<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the users table
        $this->CI->db->truncate('users');

        // Insert initial data
        $data = [
            [
                'id' => 1,
                'ip_address' => '127.0.0.1',
                'username' => 'administrator',
                'password' => '$2y$12$9rVM7ACxDm1geNr81uCuDu8UwI3.QMe5ubP60brrgvffsmAnYM7qC',
                'email' => 'admin@admin.com',
                'activation_selector' => NULL,
                'activation_code' => '',
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1268889823,
                'last_login' => 1728022985,
                'active' => 1,
                'first_name' => 'XXTVXX',
                'last_name' => 'Administrator',
                'company' => 'ADMIN12',
                'phone' => '9841486601',
                'role' => 1
            ],
            [
                'id' => 3,
                'ip_address' => '27.34.104.166',
                'username' => 'test user',
                'password' => '$2y$10$keEIWyrQRgD4QabiwW1bBOKLwILngubqpIEkj1YRGCZ2bnEwP/dNS',
                'email' => 'member@gmail.com',
                'activation_selector' => NULL,
                'activation_code' => NULL,
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1570006897,
                'last_login' => 1570781998,
                'active' => 1,
                'first_name' => 'Test',
                'last_name' => 'User',
                'company' => 'Personal',
                'phone' => '9841486601',
                'role' => 2
            ],
            [
                'id' => 5,
                'ip_address' => '27.34.104.105',
                'username' => 'sunil dongol',
                'password' => '$2y$10$JnVpugBZm8Q9mBsGjbiseOf0DERiwERKkeoywrIHb43SmQFv4LRse',
                'email' => 'sdongol_2000@yahoo.com',
                'activation_selector' => NULL,
                'activation_code' => NULL,
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1573442139,
                'last_login' => 1672028277,
                'active' => 1,
                'first_name' => 'Sunil',
                'last_name' => 'Dongol',
                'company' => 'Samyak Media',
                'phone' => '9841486601',
                'role' => 1
            ],
            [
                'id' => 12,
                'ip_address' => '110.224.110.212',
                'username' => 'movie user',
                'password' => '$2y$10$2R1ehhKfuj4E9nE4LFvZf.6ganMYcb.CqbXMTew5gC7As2T6Ut9Re',
                'email' => 'movie@user.com',
                'activation_selector' => NULL,
                'activation_code' => NULL,
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1690516237,
                'last_login' => 1690542765,
                'active' => 1,
                'first_name' => 'Movie',
                'last_name' => 'user',
                'company' => 'test',
                'phone' => '8767654554',
                'role' => 13
            ],
            [
                'id' => 13,
                'ip_address' => '104.28.90.38',
                'username' => 'komal komal',
                'password' => '$2y$10$nzsh3bvgBx7JrKjwBNQfHODbDn4EIIruOmS5EpgwkQS6/8gSI5GHm',
                'email' => 'komal@threeiptv.com',
                'activation_selector' => NULL,
                'activation_code' => NULL,
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1718333920,
                'last_login' => 1730953721,
                'active' => 1,
                'first_name' => 'komal',
                'last_name' => 'komal',
                'company' => 'komal',
                'phone' => '111293847293',
                'role' => 12
            ],
            [
                'id' => 14,
                'ip_address' => '104.28.90.38',
                'username' => 'shakher tyagi',
                'password' => '$2y$10$gltD1hMG/IOMIklBgbFVY.RGMVdUFByih2KMwBwmGAF87MEcxbPTC',
                'email' => 'shakhertyagi1@gmail.com',
                'activation_selector' => NULL,
                'activation_code' => NULL,
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1718334050,
                'last_login' => 1720426007,
                'active' => 1,
                'first_name' => 'shakher',
                'last_name' => 'tyagi',
                'company' => 'shekhar',
                'phone' => '4645645645',
                'role' => 12
            ],
            [
                'id' => 15,
                'ip_address' => '104.28.90.35',
                'username' => 'admin aa',
                'password' => '$2y$10$Dx3cRcsSX40.TAuR./d9V.BwyuAkjLkcEFbYxkAr52qam9fEC74nS',
                'email' => 'admin@threeiptv.com',
                'activation_selector' => NULL,
                'activation_code' => NULL,
                'forgotten_password_selector' => NULL,
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL,
                'remember_selector' => NULL,
                'remember_code' => NULL,
                'created_at' => 1718588948,
                'last_login' => 1721893072,
                'active' => 1,
                'first_name' => 'admin',
                'last_name' => 'aa',
                'company' => '234234',
                'phone' => '112342343242',
                'role' => 12
            ],
        ];

        $this->CI->db->insert_batch('users', $data);
        echo "Users table seeded successfully.\n";
    }
}
