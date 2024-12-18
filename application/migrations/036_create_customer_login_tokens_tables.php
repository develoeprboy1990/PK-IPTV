<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_customer_login_tokens_tables extends CI_Migration {

    public function up() {
        // Create customer_login_tokens table
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
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'expires_at' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->dbforge->add_key('id', TRUE); // Primary key
        $this->dbforge->create_table('customer_login_tokens', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('customer_login_tokens', TRUE);
    }
}
