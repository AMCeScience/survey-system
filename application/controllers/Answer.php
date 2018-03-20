<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answer extends MY_Auth {

  public function ajax()
  {
    $user_id = $this->auth->getUserId();

    $question_list = $this->input->post('question_list');
    $question_id = $this->input->post('question_id');
    $answer = $this->input->post('answer');
    $other_text = $this->input->post('other_text');
    $software_id = $this->input->post('software_id');

    $this->load->model('answers');

    list($success, $progress) = $this->answers->store($user_id, $question_list, $question_id, $answer, $other_text, $software_id);

    if (!$success) {
      echo json_encode(['success' => false, 'error' => '']);

      return;
    }

    echo json_encode(['success' => true, 'new_progress' => $progress]);
  }

  public function ajaxRedo()
  {
    $user_id = $this->auth->getUserId();

    $software_id = $this->input->post('software_id');

    $this->load->model('answers');

    list($success, $progress) = $this->answers->store($user_id, 'specific', 1, '', '', $software_id, true);

    if (!$success) {
      echo json_encode(['success' => false, 'error' => '']);

      return;
    }

    echo json_encode(['success' => true]); 
  }

  public function storeComment()
  {
    $user_id = $this->auth->getUserId();

    $question_list = $this->input->post('question_list');
    $comment = $this->input->post('comment');

    $this->load->model('answers');

    $success = $this->answers->storeComment($user_id, $question_list, $comment);

    echo json_encode(['success' => $success]);
  }

  public function updateSoftware()
  {
    $new_value = filter_input(INPUT_POST, 'new_value', FILTER_SANITIZE_NUMBER_INT);
    $software_id = filter_input(INPUT_POST, 'software_id', FILTER_SANITIZE_NUMBER_INT);

    if (!is_null($new_value) && !is_null($software_id)) {
      $this->load->model('prefills');

      $this->prefills->updateSoftware($software_id, $this->auth->getUserId(), $new_value);

      echo json_encode(['success' => true]);

      return;
    }

    echo json_encode(['success' => false]);
  }

  public function updatePrefill()
  {
    $new_value = filter_input(INPUT_POST, 'new_value', FILTER_SANITIZE_NUMBER_INT);
    $type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);

    if ($type !== 'reviews' && $type !== 'papers') {
      return;
    }

    $this->load->model('prefills');

    $this->prefills->updatePrefill($type, $this->auth->getUserId(), $new_value);

    echo json_encode(['success' => true]);
  }
}
