<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_customer_system extends CI_Migration {

    public function up() {
        // Create customers table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'reseller_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'pin' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'plan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'product_activation_key_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'alpha_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'AlphaNumeric email without any special customer'
            ],
            'alpha_password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'AlphaNumeric password without any special cherecters'
            ],
            'username' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'activation_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'forgotten_password_selector' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'forgotten_password_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'forgotten_password_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'remember_selector' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'remember_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'last_login' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'billing_street' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'billing_zip' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE
            ],
            'billing_city' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'billing_state' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => FALSE
            ],
            'billing_country' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'comments' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'devices_allowed' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'subscription_expire' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'walletbalance' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'c_code' => [
                'type' => 'VARCHAR',
                'constraint' => 12,
                'null' => FALSE
            ],
            'v_code' => [
                'type' => 'VARCHAR',
                'constraint' => 12,
                'null' => FALSE
            ],
            'c_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'plan_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => 'master',
                'null' => FALSE
            ],
            'vcodelife' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'sebscription_trpe' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'is_upgrade' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'is_migrate' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'encoded_data' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'account_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'days_left' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '0',
                'null' => TRUE
            ],
            'package' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '0',
                'null' => TRUE
            ],
            'allow_theme' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => TRUE
            ],
            'created_on' => [
                'type' => 'DATETIME',
                'null' =>TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('customers', TRUE, ['ENGINE' => 'InnoDB']);

        // Create customer_devices table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'serial' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'model_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'date_added' => [
                'type' => 'DATE',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('customer_devices', TRUE, ['ENGINE' => 'InnoDB']);

        // Create customer_device_model table
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
        $this->dbforge->create_table('customer_device_model', TRUE, ['ENGINE' => 'InnoDB']);

        // Create customer_history table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'customet_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'logs' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('customer_history', TRUE, ['ENGINE' => 'InnoDB']);

        // Create customer_to_devices table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'appversion' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'reseller_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'model' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'null' => FALSE
            ],
            'ip' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'valid' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('customer_to_devices', TRUE, ['ENGINE' => 'InnoDB']);

        // Create mapping tables for customer relationships
        $mapping_tables = [
            'customer_to_channel_groups' => 'channel_group_id',
            'customer_to_channel_packages' => 'channel_package_id',
            'customer_to_movie_stores' => 'movie_store_id',
            'customer_to_music_categories' => 'music_category_id',
            'customer_to_series_stores' => 'series_store_id'
        ];

        foreach ($mapping_tables as $table_name => $relation_field) {
            $this->dbforge->add_field([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
                ],
                'customer_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ],
                $relation_field => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($table_name, TRUE, ['ENGINE' => 'InnoDB']);
        }
    }

    public function down() {
        // Drop all customer-related tables
        $tables = [
            'customer_to_series_stores',
            'customer_to_music_categories',
            'customer_to_movie_stores',
            'customer_to_channel_packages',
            'customer_to_channel_groups',
            'customer_to_devices',
            'customer_history',
            'customer_device_model',
            'customer_devices',
            'customers'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}