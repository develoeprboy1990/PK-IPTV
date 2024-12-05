<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_app_system extends CI_Migration {

    public function up() {
        // Create app_categories table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('id_UNIQUE', TRUE);
        $this->dbforge->create_table('app_categories', TRUE, ['ENGINE' => 'InnoDB']);

        // Create app_packages table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'price' => [
                'type' => 'DOUBLE',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('app_packages', TRUE, ['ENGINE' => 'InnoDB']);

        // Create app table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_url_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'show_on_home' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('id_UNIQUE', TRUE);
        $this->dbforge->create_table('app', TRUE, ['ENGINE' => 'InnoDB']);

        // Create app_package_items table
        $this->dbforge->add_field([
            'item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'package_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'app_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('item_id', TRUE);
        $this->dbforge->create_table('app_package_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create app_package_to_categories table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'app_package_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'app_category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('app_package_to_categories', TRUE, ['ENGINE' => 'InnoDB']);

        // Create app_publish table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'date' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'version_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'forceupdate' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'update_without_login' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'default' => 1,
                'null' => FALSE
            ],
            'remarks' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '0',
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' =>TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('app_publish', TRUE, ['ENGINE' => 'MyISAM']);
    }

    public function down() {
        // Drop all app-related tables in reverse order of creation
        $tables = [
            'app_publish',
            'app_package_to_categories',
            'app_package_items',
            'app',
            'app_packages',
            'app_categories'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}