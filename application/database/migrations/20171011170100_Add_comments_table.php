<?php

class Migration_Add_comments_table extends CI_Migration {

  public function up() {
    $this->dbforge->add_field([
      'user_id' => [
        'type' => 'INT',
        'constraint' => 3,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'question_list' => [
        'type' => 'VARCHAR',
        'constraint' => 128
      ],
      'comment' => [
        'type' => 'VARCHAR',
        'constraint' => 2500
      ]
    ]);

    $this->dbforge->add_key(['user_id', 'question_list'], true);

    $this->dbforge->create_table('comments');
  }

  public function down() {
    $this->dbforge->drop_table('comments');
  }
}