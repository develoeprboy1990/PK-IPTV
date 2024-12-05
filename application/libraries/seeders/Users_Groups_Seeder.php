<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Groups_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the users_groups table
        $this->CI->db->truncate('users_groups');

        // Insert initial data
        $data = [
            ['id' => 1, 'user_id' => 1, 'group_id' => 1],
            ['id' => 2, 'user_id' => 1, 'group_id' => 2],
            ['id' => 4, 'user_id' => 3, 'group_id' => 2],
            ['id' => 6, 'user_id' => 5, 'group_id' => 2],
            ['id' => 8, 'user_id' => 7, 'group_id' => 2],
            ['id' => 9, 'user_id' => 8, 'group_id' => 2],
            ['id' => 10, 'user_id' => 9, 'group_id' => 2],
            ['id' => 11, 'user_id' => 10, 'group_id' => 2],
            ['id' => 12, 'user_id' => 11, 'group_id' => 1],
            ['id' => 13, 'user_id' => 12, 'group_id' => 2],
            ['id' => 14, 'user_id' => 13, 'group_id' => 2],
            ['id' => 15, 'user_id' => 14, 'group_id' => 2],
            ['id' => 16, 'user_id' => 15, 'group_id' => 2],
        ];

        $this->CI->db->insert_batch('users_groups', $data);
        echo "Users_Groups table seeded successfully.\n";
    }
}
