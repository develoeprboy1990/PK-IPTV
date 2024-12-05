<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_beta_type_column extends CI_Migration {

    public function up() {
        if (!$this->db->field_exists('beta_type', 'app_publish')) {
            $fields = array(
                'beta_type' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE,
                    'after' => 'update_without_login'
                )
            );
            $this->dbforge->add_column('app_publish', $fields);
        }
    }

    public function down() {
        if ($this->db->field_exists('beta_type', 'app_publish')) {
            $this->dbforge->drop_column('app_publish', 'beta_type');
        }
    }
}