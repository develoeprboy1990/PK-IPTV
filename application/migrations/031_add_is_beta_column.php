<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_is_beta_column extends CI_Migration {

    public function up() {
        // Add is_beta column to customers table
        if (!$this->db->field_exists('is_beta', 'customers')) {
            $fields = array(
                'is_beta' => array(
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => TRUE,
                    'after' => 'allow_theme'
                )
            );


            $this->dbforge->add_column('customers', $fields);
        }
    }

    public function down() {
        // Remove is_beta column from customers table
        if ($this->db->field_exists('is_beta', 'customers')) {
            $this->dbforge->drop_column('customers', 'is_beta');
        }
    }
}