<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function index()
  {
    if ($this->auth->checkLogin()) {
      $this->load->helper('url');

      redirect('/questionnaire');
    }

    $this->layout->view('login/login');
  }

  public function error()
  {
    $this->layout->view('login/not_logged');
  }

  public function hash()
  {
    $this->load->helper('url');

    $email = $this->uri->segment(3);
    $hash = $this->uri->segment(4);

    if (!$this->auth->login($email, $hash)) {
      redirect('/login/error');
    }

    redirect('/questionnaire');
  }

  public function ajax()
  {
    $this->load->model('users');

    $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $hash = filter_input(INPUT_POST, 'hash', FILTER_DEFAULT);

    if (!$this->auth->login($email, $hash)) {
      echo json_encode(['success' => false, 'error' => 'invalid login']);

      return;
    }

    echo json_encode(['success' => true, 'redirect' => '/questionnaire']);
  }
}
