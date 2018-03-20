<?php

class Migration_Fill_users extends CI_Migration {

  public function up() {
    $file_location = 'data/prefill.csv';

    $file_handle = fopen($file_location, 'r');

    $users_arr = [];

    while (($data = fgetcsv($file_handle)) !== false) {
      $data = array_map("utf8_encode", $data);

      if (preg_grep('/per year/i', $data)) {
        $users_arr[] = $data[count($data) - 1];
      }
    }

    foreach ($users_arr as $emailaddress) {
      $data = [
        'emailaddress' => $emailaddress,
        'login_hash' => hash('sha256', $this->generateRandomString(100))
      ];
      
      $this->db->insert('users', $data);
    }
  }

  public function down() {
    $this->db->empty_table('users');
  }

  private function generateRandomString($length = 50) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()-_=+[{]};:<>,./?';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }

}