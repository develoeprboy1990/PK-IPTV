<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_server_system extends CI_Migration {

    public function up() {
        // Create server_locations table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('server_locations', TRUE, ['ENGINE' => 'InnoDB']);

        // Create server_items table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('server_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create server_items_urls table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'server_item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('server_items_urls', TRUE, ['ENGINE' => 'InnoDB']);

        // Create server_location_items table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'server_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('server_location_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create token table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'token_short_code' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('token', TRUE, ['ENGINE' => 'InnoDB']);

        // Create api_logs table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'uri' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'method' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => FALSE
            ],
            'params' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'api_key' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => FALSE
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => FALSE
            ],
            'time' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'rtime' => [
                'type' => 'FLOAT',
                'null' => TRUE
            ],
            'authorized' => [
                'type' => 'VARCHAR',
                'constraint' => 1,
                'null' => FALSE
            ],
            'response_code' => [
                'type' => 'SMALLINT',
                'constraint' => 6,
                'default' => 0,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->create_table('api_logs', TRUE, ['ENGINE' => 'InnoDB']);

        // Create keys table for API authentication
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => FALSE
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'ignore_limits' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'is_private_key' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'ip_addresses' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'date_created' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('keys', TRUE, ['ENGINE' => 'InnoDB']);

        // Create debug_logs table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'date' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'date_str' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'client' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'cms' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'crm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'user_password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'device_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('debug_logs', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all server-related tables
        $tables = [
            'debug_logs',
            'keys',
            'api_logs',
            'token',
            'server_location_items',
            'server_items_urls',
            'server_items',
            'server_locations'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}