<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the permissions table
        $this->CI->db->truncate('permissions');

        // Insert initial data
        $data = [
            [
                'id' => 1,
                'per_view' => '1',
                'per_create' => '1',
                'per_edit' => '1',
                'per_delete' => '1',
                'per_status' => '1',
                'per_create_date' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'per_view' => '0',
                'per_create' => '1',
                'per_edit' => '0',
                'per_delete' => '1',
                'per_status' => '1',
                'per_create_date' => date('Y-m-d H:i:s')
            ],
            // Add more sample data as needed
        ];

        $this->CI->db->insert_batch('permissions', $data);
        echo "Permissions table seeded successfully.\n";
    }
}
