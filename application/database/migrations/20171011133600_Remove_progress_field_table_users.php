<?php

class Migration_Remove_progress_field_table_users extends CI_Migration {

  public function up() {
    $this->dbforge->drop_column('users', 'progress');   
  }

  public function down() {
    $this->dbforge->add_column('users', [
      'progress' => [
              'type' => 'INT',
              'constraint' => 3,
              'unsigned' => true,
              'default' => 0
            ]
    ]);
  }
}