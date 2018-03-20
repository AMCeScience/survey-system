<?php

class Migration_Add_answer_table extends CI_Migration {

  public function up() {
    $this->dbforge->add_field([
      'answer_id' => [
        'type' => 'INT',
        'constraint' => 6,
        'unsigned' => true,
        'auto_increment' => true
      ],
      'user_id' => [
        'type' => 'INT',
        'constraint' => 3,
        'unsigned' => true
      ],
      'question_list' => [
        'type' => 'VARCHAR',
        'constraint' => 10
      ],
      'question_id' => [
        'type' => 'INT',
        'constraint' => 3,
        'unsigned' => true
      ],
      'answer' => [
        'type' => 'VARCHAR',
        'constraint' => 100
      ],
      'other' => [
        'type' => 'VARCHAR',
        'constraint' => 2500
      ]
    ]);

    $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (user_id)');
    $this->dbforge->add_key('answer_id', true);

    $this->dbforge->create_table('answers');
  }

  public function down() {
    $this->dbforge->drop_table('answers');
  }
}