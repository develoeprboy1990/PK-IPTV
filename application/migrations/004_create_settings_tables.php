<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_settings_tables extends CI_Migration {

    public function up() {
        // Create settings table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('settings', TRUE, ['ENGINE' => 'InnoDB']);

        // Create languages table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => FALSE
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'default_language' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'create_date' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('languages', TRUE, ['ENGINE' => 'InnoDB']);

        // Create token table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => TRUE
            ],
            'token_short_code' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => TRUE
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('token', TRUE, ['ENGINE' => 'InnoDB']);

        // Create modules table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => TRUE
            ],
            'parent_id' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'null' => FALSE
            ],
            'sort_order' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('modules', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('modules', TRUE);
        $this->dbforge->drop_table('token', TRUE);
        $this->dbforge->drop_table('languages', TRUE);
        $this->dbforge->drop_table('settings', TRUE);
    }
}