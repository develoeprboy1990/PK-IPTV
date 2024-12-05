<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_location_tables extends CI_Migration {

    public function up() {
        // Create countries table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'iso3' => [
                'type' => 'CHAR',
                'constraint' => '3',
                'null' => TRUE
            ],
            'iso2' => [
                'type' => 'CHAR',
                'constraint' => '2',
                'null' => TRUE
            ],
            'phonecode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'capital' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'flag' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('countries', TRUE, ['ENGINE' => 'InnoDB']);

        // Create states table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'country_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' =>TRUE
            ],
            'flag' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('country_id');
        $this->dbforge->create_table('states', TRUE, ['ENGINE' => 'InnoDB']);

        // Create cities table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'state_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'country_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
                'default' => '2013-12-31 19:31:01'
            ],
            'updated_on' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'flag' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('state_id');
        $this->dbforge->add_key('country_id');
        $this->dbforge->create_table('cities', TRUE, ['ENGINE' => 'InnoDB']);

        // Add foreign key constraints
      //  $this->db->query('ALTER TABLE states ADD CONSTRAINT country_state FOREIGN KEY (country_id) REFERENCES countries(id)');
        //$this->db->query('ALTER TABLE cities ADD CONSTRAINT cities_ibfk_1 FOREIGN KEY (state_id) REFERENCES states(id)');
        //$this->db->query('ALTER TABLE cities ADD CONSTRAINT cities_ibfk_2 FOREIGN KEY (country_id) REFERENCES countries(id)');
    }

    public function down() {
        // Drop foreign key constraints first
       // $this->db->query('ALTER TABLE cities DROP FOREIGN KEY cities_ibfk_2');
        //$this->db->query('ALTER TABLE cities DROP FOREIGN KEY cities_ibfk_1');
        //$this->db->query('ALTER TABLE states DROP FOREIGN KEY country_state');

        // Drop tables
        $this->dbforge->drop_table('cities', TRUE);
        $this->dbforge->drop_table('states', TRUE);
        $this->dbforge->drop_table('countries', TRUE);
    }
}