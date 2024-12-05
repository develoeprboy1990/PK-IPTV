<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the groups table
        $this->CI->db->truncate('groups');

        // Insert initial data
        $data = [
            ['id' => 1, 'name' => 'super admin', 'description' => 'Administrator', 'type' => '1'],
            ['id' => 2, 'name' => 'Members', 'description' => 'General User', 'type' => '0'],
            ['id' => 6, 'name' => 'video-channel-operat', 'description' => 'this for video', 'type' => 'app and channel operator Create Read update delete'],
            ['id' => 7, 'name' => 'Sub-Admin', 'description' => '', 'type' => '0'],
            ['id' => 8, 'name' => 'admin', 'description' => 'General Admin', 'type' => '0'],
            ['id' => 9, 'name' => 'User-manager', 'description' => 'User', 'type' => 'channel'],
            ['id' => 10, 'name' => 'New Role Test', 'description' => 'Test role', 'type' => '0'],
            ['id' => 11, 'name' => 'devadmin', 'description' => 'dev admin', 'type' => '0'],
            ['id' => 12, 'name' => 'Admin-developer', 'description' => 'for kris developer', 'type' => '0'],
            ['id' => 13, 'name' => 'movie-user', 'description' => 'can use movie only', 'type' => '0'],
        ];

        $this->CI->db->insert_batch('groups', $data);
        echo "Groups table seeded successfully.\n";
    }
}
