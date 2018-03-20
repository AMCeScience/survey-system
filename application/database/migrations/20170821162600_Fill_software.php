<?php

class Migration_Fill_software extends CI_Migration {

  public function up() {
    $file_location = 'data/prefill.csv';

    $file_handle = fopen($file_location, 'r');

    $software_arr = [];

    while (($data = fgetcsv($file_handle)) !== false) {
      $data = array_map("utf8_encode", $data);

      if (in_array('EndNote', $data)) {
        $software_arr = array_filter($data, 'strlen');
      }
    }

    foreach ($software_arr as $software) {
      $this->db->insert('softwares', ['name' => $software]);
    }
  }

  public function down() {
    $this->db->truncate('softwares');
  }

}