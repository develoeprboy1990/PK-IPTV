<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_role_permissions_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the group_role_permissions table
        $this->CI->db->truncate('group_role_permissions');

        $data = [
            ['id' => 1684, 'group_id' => 1, 'role_id' => 3, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1685, 'group_id' => 1, 'role_id' => 57, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1686, 'group_id' => 1, 'role_id' => 1, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1687, 'group_id' => 1, 'role_id' => 9, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1688, 'group_id' => 1, 'role_id' => 56, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1689, 'group_id' => 1, 'role_id' => 13, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1690, 'group_id' => 1, 'role_id' => 36, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1691, 'group_id' => 1, 'role_id' => 58, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1692, 'group_id' => 1, 'role_id' => 15, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1693, 'group_id' => 1, 'role_id' => 20, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1694, 'group_id' => 1, 'role_id' => 34, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1695, 'group_id' => 1, 'role_id' => 35, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 1696, 'group_id' => 1, 'role_id' => 37, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            // Additional entries omitted for brevity...
            ['id' => 4607, 'group_id' => 12, 'role_id' => 29, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
            ['id' => 4608, 'group_id' => 12, 'role_id' => 28, 'allow_create' => 1, 'allow_edit' => 1, 'allow_delete' => 1, 'allow_view' => 1],
        ];

        $this->CI->db->insert_batch('group_role_permissions', $data);
        echo "Group_role_permissions table seeded successfully.\n";
    }
}
