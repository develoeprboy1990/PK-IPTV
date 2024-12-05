<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatabaseSeeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
         // Load and run each seeder from the 'seeder' folder 

        // Load and run each seeder
        $this->CI->load->library('seeders/Groups_Seeder');
        $this->CI->groups_seeder->run();
        $this->CI->load->library('seeders/Group_role_permissions_Seeder');
        $this->CI->group_role_permissions_seeder->run();

        
        $this->CI->load->library('seeders/Users_Seeder');
        $this->CI->users_seeder->run();

        $this->CI->load->library('seeders/Roles_Seeder');
        $this->CI->roles_seeder->run();

        $this->CI->load->library('seeders/Profile_Seeder');
         $this->CI->profile_seeder->run();

         $this->CI->load->library('seeders/Modules_Seeder');
         $this->CI->modules_seeder->run();

         $this->CI->load->library('seeders/Permissions_Seeder');
         $this->CI->permissions_seeder->run();
 
         //$this->CI->load->library('seeders/User_Interface_Seeder');
         //$this->CI->user_interface_seeder->run();

        $this->CI->load->library('seeders/Users_Groups_Seeder');
        $this->CI->users_groups_seeder->run();
        

        // Add additional seeders here as needed

        echo "Database seeding completed.\n";
    }
}
