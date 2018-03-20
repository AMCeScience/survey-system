<?php

/**
 * Extend the MY_Controller to add a login protected controller
 */
class MY_Auth extends CI_Controller
{
    function __construct()
    {
        // Call CI_Controller __construct first
        parent::__construct();
        // Call user authentication function
        if (!$this->auth->checkLogin()) {
          $this->load->helper('url');
          
          if ($this->input->is_ajax_request()) {
            echo json_encode(['success' => false, 'logged_in' => false]);

            die();
          }

          redirect('/login/error');
        }
    }
}