<?php

class Migration_Add_software_id_column_table_answers extends CI_Migration {

  public function up() {
    $this->dbforge->add_column('answers', [
      'software_id' => [
              'type' => 'INT',
              'constraint' => 3,
              'unsigned' => true,
              'default' => null
            ]
    ]);
  }

  public function down() {
    $this->dbforge->drop_column('answers', 'software_id');
  }
}