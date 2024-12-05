<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_subscription_system extends CI_Migration {

    public function up() {
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

        // Create subscription_renewal_keys table
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
            'group_unic_code' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'devices_allowed' => [
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
            'plan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'monthly_price' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'dealer_price' => [
                'type' => 'FLOAT',
                'null' => FALSE
            ],
            'length_months' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'month_day' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
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
                'null' =>TRUE
            ],
            'date_used' => [
                'type' => 'DATETIME', 
                'null' => TRUE
            ],
            'date_created' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'reseller_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'reseller_plan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'reseller_msg' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ],
            'key_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
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
        $this->dbforge->create_table('subscription_renewal_keys', TRUE, ['ENGINE' => 'InnoDB']);

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

        // Create reseller_panel_subscription table
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
                'type' => 'FLOAT',
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
                'comment' => '1-on,0-off,3-delete',
                'null' => FALSE
            ],
            'month_day' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'facility_content' => [
                'type' => 'MEDIUMTEXT',
                'null' => FALSE
            ],
            'currency_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'plan_type' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'activation_price' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('reseller_panel_subscription', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all subscription-related tables
        $tables = [
            'reseller_panel_subscription',
            'customers_panel_subscription',
            'subscription_renewal_keys',
            'subscriptiongroup'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}