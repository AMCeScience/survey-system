<?php

class Answers extends CI_Model {

  // Array of available question lists.
  private $question_lists = ['generic', 'specific', 'usability'];

  /**
  * Store an answer.
  * Called by the answer ajax function, check whether the request was valid
  * and creates or updates the answer in the database.
  */
  public function store($user_id, $question_list, $question_id, $answer, $other = '', $software_id = null, $disable_software_check = false)
  {
    $this->load->model('softwares');
    $this->load->model('prefills');

    // If provided, check software id is valid
    if (!is_null($software_id) && !$this->softwares->isValidId($software_id)) {
      return false;
    }

    // Check question_list is valid
    if (!in_array($question_list, $this->question_lists)) {
      return false;
    }

    // Check question_id is valid
    $questions = $this->config->item($question_list . '_questions');

    if (!in_array($question_id, array_keys($questions))) {
      return false;
    }

    // Implode answers from checkboxes
    if (is_array($answer)) {
      $answer = implode(', ', $answer);
    }

    // Set other to empty string if null
    if (is_null($other)) {
      $other = '';
    }

    // Check if this request needs a software id and it is a valid software id for this user
    if (($question_list === 'specific' || $question_list === 'usability') 
      && (is_null($software_id) || ($disable_software_check === false && !$this->prefills->validateSoftwareId($user_id, $software_id)))) {
      return false;
    }

    // Set software id to null if not required for this request
    if ($question_list !== 'specific' && $question_list !== 'usability') {
      $software_id = null;
    }

    $data = [
      'user_id' => $user_id,
      'question_list' => $question_list,
      'question_id' => $question_id,
      'answer' => $answer,
      'other' => $other,
      'software_id' => $software_id
    ];

    // Check if question already has an answer
    $existing_id = $this->existingId($user_id, $question_list, $question_id, $software_id);

    // Update answer or insert new row
    if (!is_null($existing_id)) {
      $this->db->where('answer_id', $existing_id->answer_id)->update('answers', $data);
    } else {
      $this->db->insert('answers', $data);
    }

    $progress = $this->updateProgress($user_id);

    return [true, $progress];
  }

  public function storeComment($user_id, $question_list, $comment)
  {
    // Check question_list is valid
    if (!in_array($question_list, $this->question_lists)) {
      return false;
    }

    $data = [
      'user_id' => $user_id,
      'question_list' => $question_list,
      'comment' => $comment
    ];

    $existing_id = $this->existingCommentId($user_id, $question_list);

    // Update answer or insert new row
    if (!is_null($existing_id)) {
      $this->db->where(['user_id' => $user_id, 'question_list' => $question_list])->update('comments', $data);
    } else {
      $this->db->insert('comments', $data);
    }

    return true;
  }

  /**
  * Format all the answers for a specific user.
  * Loops the question lists and builds an array of the user's answers.
  */
  public function getAnswers($user_id)
  {
    $answers = [];

    // Loop the questions lists
    foreach ($this->question_lists as $list) {
      // Get the questions data
      $list_questions = $this->config->item($list . '_questions');

      $software_id = null;

      if ($list === 'specific' || $list === 'usability') {
        $software_id = $this->getLatestSoftware($user_id);
      }

      // Get the user's answers to the question list
      $list_answers = $this->getList($user_id, $list, $software_id);

      $answer_arr = [];

      // Build the answer array
      foreach ($list_answers as $list_answer) {
        // Explode checkbox answers back into an array of answer keys
        if ($list_questions[$list_answer->question_id]['type'] === 'checkbox') {
          $list_answer->answer = explode(', ', $list_answer->answer);
        }

        // Add the answer to the answer array under the specific question id (for mapping)
        $answer_arr[$list_answer->question_id] = $list_answer;
      }

      // Add the answer array to the array of question lists
      $answers[$list] = $answer_arr;
    }

    return $answers;
  }

  public function getComments($user_id)
  {
    $comments = $this->db->from('comments')->where(['user_id' => $user_id])->get()->result();

    $comments_arr = [];

    foreach ($comments as $comment) {
      $comments_arr[$comment->question_list] = $comment->comment;
    }

    return $comments_arr;
  }

  /**
  * Return all the answers for the specified question list.
  */
  public function getList($user_id, $question_list, $software_id = null)
  {
    if (!is_null($software_id)) {
      $this->db->where('software_id', $software_id);
    }

    return $this->db->from('answers')->where(['user_id' => $user_id, 'question_list' => $question_list])->get()->result();
  }

  public function getLatestSoftware($user_id)
  {
    $id = $this->db->select('software_id')->from('answers')->where('user_id', $user_id)->order_by('answer_id', 'desc')->limit(1)->get()->row(0);

    if (!is_null($id)) {
      return $id->software_id;
    }

    return null;
  }

  /**
  * Check whether the question has already been answered, if so, return existing answer row.
  */
  public function existingId($user_id, $question_list, $question_id, $software_id = null)
  {
    if (!is_null($software_id)) {
      $this->db->where('software_id', $software_id);
    }

    return $this->db->from('answers')->where(['user_id' => $user_id, 'question_list' => $question_list, 'question_id' => $question_id])->get()->row(0);
  }

  public function existingCommentId($user_id, $question_list)
  {
    return $this->db->from('comments')->where(['user_id' => $user_id, 'question_list' => $question_list])->get()->row(0);
  }

  /**
  * Update the user's progress after answering a question.
  */
  public function updateProgress($user_id)
  {
    $progress_increments = $this->config->item('progress');

    $list_completion = $this->totalCompletion($user_id);

    $new_percentage = $progress_increments['prefill_check'] + round($list_completion * $progress_increments['question_lists'], 0);
    
    $this->db
        ->set('percentage', $new_percentage)
        ->set('progress', 'question_lists')
        ->where('user_id', $user_id)
        ->update('user_progress');

    return $new_percentage;
  }

  /**
  * Calculate the percentage of completed questions for a user.
  * Loops over all the lists that the user has to complete and calls listCompletion.
  */
  public function totalCompletion($user_id)
  {
    $this->load->model('prefills');

    $user_type = $this->prefills->userType($user_id);

    switch ($user_type) {
      case 'using':
        $total_percentage = 0;

        foreach($this->question_lists as $list_name) {
          $software_id = null;

          if ($list_name === 'specific' || $list_name === 'usability') {
            $software_id = $this->getLatestSoftware($user_id);
          }

          list($percentage, $question_ids) = $this->listCompletion($user_id, $list_name, $software_id);
          
          $total_percentage += $percentage;
        }

        $percentage = $total_percentage / 3;

        break;
      case 'considering':
        list($percentage, $question_ids) = $this->listCompletion($user_id, 'generic');

        break;
      case 'no_use':
        list($percentage, $question_ids) = $this->listCompletion($user_id, 'generic');

        break;
    }

    $progress_increments = $this->config->item('progress');

    return $percentage;
  }

  /**
  * For a single list of questions check how many of the required questions the user has answered.
  * Takes into account follow-up questions, when the question that requires follow-up has been answered positively
  * the follow-up question itself is added to the list of required questions.
  */
  public function listCompletion($user_id, $question_list, $software_id = null)
  {
    $to_do = $this->config->item($question_list . '_questions');

    $answered = $this->getList($user_id, $question_list, $software_id);

    $answered_arr = [];

    foreach ($answered as $item) {
      $answered_arr[$item->question_id] = $item;
    }

    $total_to_do = 0;
    $option_questions = [];
    $question_ids_done = [];
    $question_ids_to_do = [];

    // Loop al questions in the list
    foreach ($to_do as $question_id => $answer) {
      // Check if the question has been answered
      if (array_key_exists($question_id, $answered_arr) && $answered_arr[$question_id]->answer !== '') {
        $question_ids_done[] = $question_id;

        // If this is a question that has a follow up, add the follow up question to the list of required items
        if (array_key_exists('follow_up', $answer) && $answer['follow_up'] !== '' && $answered_arr[$question_id]->answer === 'yes') {
          $option_questions[] = $question_id + 1;
        }
      } else if (!array_key_exists('is_follow_up', $answer)) {
        // Question has not been answered, add it to the to do list
        // Skip all items that are a follow up question
        $question_ids_to_do[] = $question_id;
      }

      // Check if this is a follow up question
      if (array_key_exists('is_follow_up', $answer) && $answer['is_follow_up'] === true) {
        // Check if this question is in the list of required follow up questions
        if (in_array($question_id, $option_questions)) {
          $total_to_do++;

          // Check if this questions has been answered yet, if not add it to the to do list
          if (!array_key_exists($question_id, $answered_arr) || strlen($answered_arr[$question_id]->answer) < 1) {
            $question_ids_to_do[] = $question_id;
          }
        } else {
          if (array_key_exists($question_id, $answered_arr) && $answered_arr[$question_id]->answer !== '') {
            array_pop($question_ids_done);
          }
        }

        continue;
      }

      $total_to_do++;
    }

    return array(count($question_ids_done) / $total_to_do, $question_ids_to_do);
  }

  public function getUniqueUsersWithAnswers()
  {
    return $this->db->select(['COUNT(*) AS number_of_answers', 'user_id'], false)->from('answers')->group_by('user_id')->get()->result();
  }

}