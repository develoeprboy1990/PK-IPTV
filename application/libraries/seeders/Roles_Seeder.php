<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the roles table
        $this->CI->db->truncate('roles');

        // Insert initial data
        $data = [
            [
                'id' => 1,
                'role_name' => 'manager',
                'role_status' => '1',
                'role_create_date' => '2019-08-02 07:24:03'
            ],
        ];

        $this->CI->db->insert_batch('roles', $data);
        echo "Roles table seeded successfully.\n";
    }
}
