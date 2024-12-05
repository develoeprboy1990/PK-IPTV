<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_analytics_system extends CI_Migration {

    public function up() {
        // Create analytics_report table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'date' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'user_uuid' => [
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
            'ui_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'ui_version' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'null' => FALSE
            ],
            'client_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'client_cms' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'client_crm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'client_product' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'location_city' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'location_state' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'location_country' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'location_latitude' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ],
            'location_longitude' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ],
            'device_category' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'device_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'device_model' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'network_speed' => [
                'type' => 'FLOAT',
                'null' => FALSE
            ],
            'network_latency' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'action_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'action_from' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'action_to' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('analytics_report', TRUE, ['ENGINE' => 'InnoDB']);

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

        // Create logs table
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
            'session_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
            'user_identifier' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'request_uri' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'timestamp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ],
            'client_ip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'client_user_agent' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'referer_page' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'last_login' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'last_logout' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('logs', TRUE, ['ENGINE' => 'MyISAM']);

        // Create plan_history table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'used_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'log_json' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ],
            'waller_log' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('plan_history', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all analytics-related tables
        $tables = [
            'plan_history',
            'logs',
            'debug_logs',
            'analytics_report'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}