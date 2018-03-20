<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questionnaire extends MY_Auth {

  private $progress;
  private $user_id;

  function __construct()
  {
    parent::__construct();

    $this->load->model('users');

    $this->progress = $this->users->getProgress($this->auth->getUserId());
    $this->user_id = $this->auth->getUserId();
  }

  public function index()
  { 
    $this->load->model('prefills');
    $this->load->model('softwares');
    $this->load->model('answers');

    $data['tab_active'] = 'landing';
    $data['progress'] = $this->progress;
    $data['software_done'] = [];
    $data['interesting_software'] = [];
    $data['last_is_complete'] = $this->answers->totalCompletion($this->user_id) >= 1;
    $data['done_precheck_stage'] = ($this->progress * 1 !== 0);
    $data['user_type'] = $this->prefills->userType($this->user_id);

    $software_done_ids = $this->prefills->doneSoftwares($this->user_id);

    if (count($software_done_ids) > 0) {
      $data['software_done'] = $this->softwares->getDataByArr($software_done_ids);
      $data['interesting_software'] = $this->prefills->getUndoneUserSoftware($this->user_id);
    }

    $this->layout->questionnaireView('questionnaire/landing', $data);
  }

  public function software()
  {
    $this->load->model('prefills');

    $prefill_data = $this->prefills->getPrefills($this->user_id);

    $data['tab_active'] = 'software_check';
    $data['software'] = $prefill_data['software'];
    $data['reviews'] = $prefill_data['reviews'];
    $data['progress'] = $this->progress;
    
    $this->layout->questionnaireView('questionnaire/software_check', $data);
  }

  public function form()
  {
    $this->load->model('prefills');
    $this->load->model('softwares');
    $this->load->model('answers');

    $form_page = $this->uri->segment(3);
    
    $data['form_page'] = null;
    
    if (!is_null($form_page) && is_numeric($form_page) && $form_page < 3) {
      $data['form_page'] = $form_page;
    }

    $data['tab_active'] = 'questionnaire';
    $data['progress'] = $this->progress;

    $data['user_type'] = $this->prefills->userType($this->user_id);

    $data['generic_questions'] = $this->config->item('generic_questions');
    $data['tool_questions'] = $this->config->item('specific_questions');
    $data['sus_questions'] = $this->config->item('usability_questions');

    $data['user_answers'] = $this->answers->getAnswers($this->user_id);
    $data['comments'] = $this->answers->getComments($this->user_id);

    $picked_software = null;

    if ($data['user_type'] === 'using' || $data['user_type'] === 'considering') {
      $picked_software = $this->softwares->getUserSoftware($this->user_id);
    }

    if (!is_null($picked_software)) {
      $data['picked_software'] = $picked_software;
    }

    $this->layout->questionnaireView('questionnaire/questionnaire_form', $data);
  }

  public function redo()
  {
    $this->load->model('prefills');
    $this->load->helper('url');

    $software_arr = $this->prefills->getUndoneUserSoftware($this->user_id);

    if (count($software_arr) < 1) {
      redirect('questionnaire', 'refresh');
    }

    $data['tab_active'] = 'questionnaire';
    $data['progress'] = $this->progress;
    $data['interesting_software'] = $software_arr;

    $this->layout->questionnaireView('questionnaire/redo', $data);
  }

  public function nextCheck()
  {
    $question_lists = ['generic', 'specific', 'usability'];

    $question_list = $this->input->post('question_list');

    if (!in_array($question_list, $question_lists)) {
      return false;
    }

    $this->load->model('answers');

    $software_id = null;

    if ($question_list === 'specific' || $question_list === 'usability') {
      $software_id = $this->answers->getLatestSoftware($this->user_id);
    }

    list($completion, $to_do) = $this->answers->listCompletion($this->user_id, $question_list, $software_id);
    
    echo json_encode(['completed' => $completion >= 1, 'todo' => $to_do]);
  }

  public function finishedPrecheck()
  {
    $this->load->model('prefills');

    $this->prefills->precheckFinishedUpdateProgress($this->user_id);

    echo json_encode(['success' => true]);
  }

}
