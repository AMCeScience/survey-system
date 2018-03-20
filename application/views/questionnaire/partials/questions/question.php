<?php
  $question_answer = null;
  $question_answer_other = null;

  if (array_key_exists($question_number, $user_answers)) {
    $question_answer = $user_answers[$question_number]->answer;
    $question_answer_other = $user_answers[$question_number]->other;
  }

  $name = $question_obj['name'];
  $type = $question_obj['type'];
  $question = $question_obj['question'];
  $answers = $question_obj['answers'];
  $other = $question_obj['other'];
  $labels = isset($question_obj['labels']) ? $question_obj['labels'] : null;
  $is_followup = isset($question_obj['is_follow_up']) ? $question_obj['is_follow_up'] : '';
  $followup = isset($question_obj['follow_up']) ? $question_obj['follow_up'] : '';

  $question_number_display = $question_begin + $question_number;

  switch ($type) { 
    case 'checkbox':
      require('checkboxes.php');
      
      break;
    case 'scale':
      require('scales.php');

      break;
    case 'radio':
      require('radios.php');

      break;
  }
?>