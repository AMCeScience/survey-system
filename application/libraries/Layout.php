<?php

class Layout extends MY_Library {
  
  function view($view, $data = [])
  {
    $this->load->view('layout/header');
    $this->load->view($view, $data);
    $this->load->view('layout/footer');
  }

  function questionnaireView($view, $data = [])
  {
    $this->load->view('layout/header');
    $this->load->view('layout/questionnaire_header', $data);
    $this->load->view($view, $data);
    $this->load->view('layout/footer');
  }
}