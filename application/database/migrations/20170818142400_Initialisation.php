<?php

class Migration_Initialisation extends CI_Migration {

    public function up() {
        // CREATE THE USERS TABLE
        $this->dbforge->add_field([
          'user_id' => [
            'type' => 'INT',
            'constraint' => 3,
            'unsigned' => true,
            'auto_increment' => true
          ],
          'login_hash' => [
            'type' => 'VARCHAR',
            'constraint' => 128
          ],
          'emailaddress' => [
            'type' => 'VARCHAR',
            'constraint' => 250
          ],
          'progress' => [
            'type' => 'INT',
            'constraint' => 3,
            'unsigned' => true,
            'default' => 0
          ]
        ]);

        $this->dbforge->add_key('user_id', true);

        $this->dbforge->create_table('users');
        // END USERS TABLE

        // CREATE THE SOFTWARE TABLE
        $this->dbforge->add_field([
          'software_id' => [
            'type' => 'INT',
            'constraint' => 3,
            'unsigned' => true,
            'auto_increment' => true
          ],
          'name' => [
            'type' => 'VARCHAR',
            'constraint' => 120
          ]
        ]);

        $this->dbforge->add_key('software_id', true);
        $this->dbforge->create_table('softwares');
        // END SOFTWARE TABLE

        // CREATE THE PREFILLS TABLE
        $this->dbforge->add_field([
          'prefill_id' => [
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
          'number_of_reviews' => [
            'type' => 'INT',
            'constraint' => 1,
            'unsigned' => true
          ],
          'number_of_papers' => [
            'type' => 'INT',
            'constraint' => 1,
            'unsigned' => true
          ],
          'has_changed' => [
            'type' => 'TINYINT',
            'default' => 0
          ]
        ]);

        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users (user_id)');
        $this->dbforge->add_key('prefill_id', TRUE);

        $this->dbforge->create_table('prefills');
        // END PREFILLS TABLE

        // CREATE COUPLE TABLE BETWEEN SOFTWARE AND PREFILLS
        $this->dbforge->add_field([
          'prefill_id' => [
            'type' => 'INT',
            'constraint' => 3,
            'unsigned' => true
          ],
          'software_id' => [
            'type' => 'INT',
            'constraint' => 3,
            'unsigned' => true
          ],
          'value' => [
            'type' => 'VARCHAR',
            'constraint' => 250
          ],
          'has_changed' => [
            'type' => 'TINYINT',
            'default' => 0
          ]
        ]);

        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (prefill_id) REFERENCES prefills (prefill_id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (software_id) REFERENCES softwares (software_id)');

        $this->dbforge->add_key(['prefill_id', 'software_id']);
        $this->dbforge->create_table('softwares_to_prefills');
        // END COUPLE TABLE
    }

    public function down() {
        $this->dbforge->drop_table('users', true);
        $this->dbforge->drop_table('prefills', true);
        $this->dbforge->drop_table('software', true);
        $this->dbforge->drop_table('softwares_to_prefills', true);
    }

}
