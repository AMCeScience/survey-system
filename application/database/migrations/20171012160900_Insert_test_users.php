<?php

class Migration_Insert_test_users extends CI_Migration {

  var $users_arr = ['s.d.olabarriaga@amc.uva.nl', 't.bakker@amc.uva.nl', 'a.j.vanaltena@amc.uva.nl', 'm.m.leeflang@amc.uva.nl'];

  public function up() {
    foreach ($this->users_arr as $emailaddress) {
      $data = [
        'emailaddress' => $emailaddress,
        'login_hash' => hash('sha256', $this->generateRandomString(100))
      ];
      
      $this->db->insert('users', $data);

      $user_id = $this->db->insert_id();

      $this->db->query("INSERT INTO prefills (user_id, number_of_reviews, number_of_papers) VALUES ({$user_id}, 1, 1)");

      $prefill_id = $this->db->insert_id();

      $software_possibilities = $this->db->from('softwares')->get()->result();

      foreach ($software_possibilities as $item) {
        $software_id = $item->software_id;
        $value = array_rand([1, 2, 3, 4]);

        $this->db->query("INSERT INTO softwares_to_prefills (prefill_id, software_id, value) VALUES ({$prefill_id}, {$software_id}, {$value})");
      }
    }

    // Considering user

    $data = [
      'emailaddress' => 'test_no_use@test.com',
      'login_hash' => hash('sha256', $this->generateRandomString(100))
    ];
    
    $this->db->insert('users', $data);

    $user_id = $this->db->insert_id();

    $this->db->query("INSERT INTO prefills (user_id, number_of_reviews, number_of_papers) VALUES ({$user_id}, 1, 1)");

    $prefill_id = $this->db->insert_id();

    $software_possibilities = $this->db->from('softwares')->get()->result();

    foreach ($software_possibilities as $item) {
      $software_id = $item->software_id;
      $value = 0;

      $this->db->query("INSERT INTO softwares_to_prefills (prefill_id, software_id, value) VALUES ({$prefill_id}, {$software_id}, {$value})");
    }

    // No use user

    $data = [
      'emailaddress' => 'test_considering@test.com',
      'login_hash' => hash('sha256', $this->generateRandomString(100))
    ];
    
    $this->db->insert('users', $data);

    $user_id = $this->db->insert_id();

    $this->db->query("INSERT INTO prefills (user_id, number_of_reviews, number_of_papers) VALUES ({$user_id}, 1, 1)");

    $prefill_id = $this->db->insert_id();

    $software_possibilities = $this->db->from('softwares')->get()->result();

    foreach ($software_possibilities as $item) {
      $software_id = $item->software_id;
      $value = array_rand([1, 2]);

      $this->db->query("INSERT INTO softwares_to_prefills (prefill_id, software_id, value) VALUES ({$prefill_id}, {$software_id}, {$value})");
    }
  }

  public function down() {
    
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