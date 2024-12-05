<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modules_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the modules table
        $this->CI->db->truncate('modules');

        // Insert initial data
        $data = [
            ['id' => 1, 'name' => 'User', 'parent_id' => 57, 'sort_order' => 0],
            ['id' => 3, 'name' => 'Dashboard', 'parent_id' => 0, 'sort_order' => 1],
            ['id' => 4, 'name' => 'System', 'parent_id' => 0, 'sort_order' => 30],
            ['id' => 5, 'name' => 'Settings', 'parent_id' => 4, 'sort_order' => 0],
            ['id' => 7, 'name' => 'Reports', 'parent_id' => 0, 'sort_order' => 26],
            ['id' => 9, 'name' => 'Role', 'parent_id' => 57, 'sort_order' => 0],
            ['id' => 11, 'name' => 'Channels', 'parent_id' => 25, 'sort_order' => 0],
            ['id' => 12, 'name' => 'Security', 'parent_id' => 4, 'sort_order' => 0],
            ['id' => 13, 'name' => 'Customers', 'parent_id' => 56, 'sort_order' => 0],
            ['id' => 14, 'name' => 'Playlists', 'parent_id' => 25, 'sort_order' => 0],
            ['id' => 15, 'name' => 'Servers', 'parent_id' => 58, 'sort_order' => 0],
            ['id' => 17, 'name' => 'Homescreen', 'parent_id' => 0, 'sort_order' => 28],
            ['id' => 18, 'name' => 'Albums', 'parent_id' => 24, 'sort_order' => 0],
            ['id' => 20, 'name' => 'Products', 'parent_id' => 58, 'sort_order' => 0],
            ['id' => 21, 'name' => 'Menu', 'parent_id' => 55, 'sort_order' => 0],
            // Additional rows omitted for brevity
            ['id' => 82, 'name' => 'Movie URL', 'parent_id' => 22, 'sort_order' => 0],
        ];

        $this->CI->db->insert_batch('modules', $data);
        echo "Modules table seeded successfully.\n";
    }
}
