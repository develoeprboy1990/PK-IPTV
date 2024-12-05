<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_reseller_system extends CI_Migration {

    public function up() {
        // Create reseller table
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
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'postcode' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'comment' => '0-inactive ,1-Active , 3-Delete'
            ],
            'plan_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'comment' => '1-Master,2-Activation,renewal'
            ],
            'wallet_money' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'currency_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'reseller_msgedit' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'customer_msgcontent' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ],
            'messageto_customer_reseller' => [
                'type' => 'LONGBLOB',
                'null' => FALSE
            ],
            'reseller_masterkey' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'see_customer_password' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'can_create_walletcode' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'wallet_code_discount' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'can_view_devices' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('reseller', TRUE, ['ENGINE' => 'InnoDB']);

        // Create reseller_details table
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
            'product_plans' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'currency_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'discount_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'discount_value' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'dealer_price' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'activation_price' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'plan_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('reseller_details', TRUE, ['ENGINE' => 'InnoDB']);

        // Create reseller_history table
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
            'log_json' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ],
            'key_status_log' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('reseller_history', TRUE, ['ENGINE' => 'InnoDB']);

        // Create reseller_moneycode table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'code_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'currency' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'null' => FALSE
            ],
            'used' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'discount_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'discount_amount' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('reseller_moneycode', TRUE, ['ENGINE' => 'InnoDB']);

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

        // Create reseller_wallet table
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
            'reseller_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'price' => [
                'type' => 'FLOAT',
                'null' => FALSE
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'payment_status' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'comment' => '1:active,0:delete',
                'null' => FALSE
            ],
            'create_time' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'message' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('reseller_wallet', TRUE, ['ENGINE' => 'InnoDB']);

        // Create reseller_wallet_moneycode table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'price' => [
                'type' => 'FLOAT',
                'null' => FALSE
            ],
            'used' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'comment' => '1: ACTIVE,0,DELETE',
                'null' => FALSE
            ],
            'key_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'reseller_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'used_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'disabled' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => FALSE
            ],
            'reseller_msg' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ],
            'currency_type' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('key_code', TRUE); // Unique key
        $this->dbforge->create_table('reseller_wallet_moneycode', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all reseller-related tables
        $tables = [
            'reseller_wallet_moneycode',
            'reseller_wallet',
            'reseller_panel_subscription',
            'reseller_moneycode',
            'reseller_history',
            'reseller_details',
            'reseller'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}