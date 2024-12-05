<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_statistics_module extends CI_Migration {

    public function up() {
        // Check if the Statistics module already exists
        $exists = $this->db->get_where('modules', array('name' => 'Statistics'))->num_rows();
        
        if ($exists == 0) {
            $data = array(
                'id' => '83',
                'name' => 'Statistics',
                'parent_id' => '0',
                'sort_order' => '2'
            );
            
            $this->db->insert('modules', $data);
        }
    }

    public function down() {
        // Remove the Statistics module
        $this->db->where('id', '83');
        $this->db->or_where('name', 'Statistics'); 
        $this->db->delete('modules');
    }
}