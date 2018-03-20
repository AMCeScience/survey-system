<?php

class Migration_Fill_software_prefills extends CI_Migration {

  public function up() {
    $file_location = 'data/prefill.csv';

    $file_handle = fopen($file_location, 'r');

    $users_arr = [];

    while (($data = fgetcsv($file_handle)) !== false) {
      $data = array_map('utf8_encode', $data);

      if (preg_grep('/per year/i', $data)) {
        $users_arr[] = $data;
      }
    }

    $software_ids = $this->db->select('software_id')->from('softwares')->get()->result_array();

    $flat_ids = array_map(function($item) {
      return $item['software_id'];
    }, $software_ids);
    
    foreach ($users_arr as $user_data) {
      $number_of_reviews = $user_data[1];
      $number_of_papers = $user_data[3];

      $emailaddress = $user_data[count($user_data) - 1];

      $software = [];

      foreach ($flat_ids as $arr_key => $software_id) {
        $software[$software_id] = $user_data[$arr_key + 4];
      }

      $user = $this->db->select('user_id')->from('users')->where('emailaddress', $emailaddress)->get()->row(0);
      
      $this->db->query("INSERT INTO prefills (user_id, number_of_reviews, number_of_papers) VALUES ({$user->user_id}, {$number_of_reviews}, {$number_of_papers})");

      $prefill_id = $this->db->insert_id();

      foreach ($software as $software_id => $value) {
        if ($value === '') {
          $value = 0;
        }

        $value = $this->db->escape($value);

        $this->db->query("INSERT INTO softwares_to_prefills (prefill_id, software_id, value) VALUES ({$prefill_id}, {$software_id}, {$value})");
      }
    }
  }

  public function down() {
    $this->db->empty_table('softwares_to_prefills');
    $this->db->empty_table('prefills');
  }

}