<?php

class Migration_Add_user_progress_table extends CI_Migration {

  public function up() {
    $this->dbforge->add_field([
      'progress_id' => [
        'type' => 'INT',
        'constraint' => 3,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 3,
        'unsigned' => true
      ],
      'progress' => [
        'type' => 'VARCHAR',
        'constraint' => 128
      ],
      'percentage' => [
        'type' => 'INT',
        'constraint' => 3,
        'unsigned' => true,
        'default' => 0
      ]
    ]);

    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (user_id)');
    $this->dbforge->add_key('progress_id', true);

    $this->dbforge->create_table('user_progress');
  }

  public function down() {
    $this->dbforge->drop_table('user_progress');
  }
}