<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_product_system extends CI_Migration {

    public function up() {
        // Create products table
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
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'plan_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'subscription_length' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'subscription_days_or_month' => [
                'type' => 'ENUM',
                'constraint' => ['month', 'days'],
                'default' => 'month',
                'null' => FALSE
            ],
            'price' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ],
            'publish_start' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'publish_end' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'app_package_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'service_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'news_group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'gui_setting_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'enable_geo_location' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'customer_can_change_plan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('products', TRUE, ['ENGINE' => 'InnoDB']);

        // Create activation_keys table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'keycode' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'prefix_code' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'group_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'devices_allowed' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'monthly_price' => [
                'type' => 'DOUBLE',
                'null' => FALSE
            ],
            'length_months' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'used' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ],
            'disabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'blocked' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'blocked_comment' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'blocked_date' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'date_used' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'date_created' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'date_expired' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'month_day' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'default' => 'months',
                'null' => FALSE
            ],
            'activation_price' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'default' => '0',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('activation_keys', TRUE, ['ENGINE' => 'InnoDB']);

        // Create various product relationship tables
        $relationship_tables = [
            'product_to_app_packages' => 'app_package_id',
            'product_to_countries' => 'country_id',
            'product_to_devices' => 'device_id',
            'product_to_packages' => 'package_id',
            'product_to_series_stores' => 'series_store_id',
            'product_to_vod_stores' => 'vod_store_id'
        ];

        foreach ($relationship_tables as $table_name => $related_field) {
            $this->dbforge->add_field([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
                ],
                'product_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ],
                $related_field => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($table_name, TRUE, ['ENGINE' => 'InnoDB']);
        }

        // Create customers_panel_subscription table
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
            ],
            'monthly_price' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'length_months' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'devices_allowed' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'null' => FALSE
            ],
            'month_day' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'tag_title' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'facility_content' => [
                'type' => 'MEDIUMTEXT',
                'null' => FALSE
            ],
            'gui_setting_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'product_group' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'rproducts' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('customers_panel_subscription', TRUE, ['ENGINE' => 'InnoDB']);

        // Create subscriptiongroup table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'group_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'subscription_pans' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'null' => FALSE
            ],
            'free_change' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('subscriptiongroup', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all product-related tables
        $tables = [
            'subscriptiongroup',
            'customers_panel_subscription',
            'product_to_vod_stores',
            'product_to_series_stores',
            'product_to_packages',
            'product_to_devices',
            'product_to_countries',
            'product_to_app_packages',
            'activation_keys',
            'products'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}