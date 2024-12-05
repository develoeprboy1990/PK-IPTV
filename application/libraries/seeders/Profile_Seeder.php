<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the profile table
        $this->CI->db->truncate('profile');

        // Insert initial data
        $data = [
            [
                'id' => 1,
                'collection_key' => 'collection',
                'document_key' => 'document',
                'audio' => '',
                'video_quality' => '',
                'childlock' => '',
                'clock_type' => '',
                'clock_setting' => '',
                'toggle' => '',
                'screen' => '',
                'text' => '',
                'movies_progress' => '',
                'movies_favorites' => '',
                'television_progress' => '',
                'television_locked' => '',
                'television_favorites' => '',
                'television_grouplock' => '',
                'education_favorites' => '',
                'education_finished' => '',
                'education_progress' => '',
                'series_favorites' => '',
                'series_progress' => '',
                'avatar' => '',
                'recommendations' => '',
                'age_rating' => '',
                'profile_lock' => '',
                'mode' => '',
                'name' => 'Test'
            ],
            [
                'id' => 2,
                'collection_key' => 'collection',
                'document_key' => 'document',
                'audio' => '',
                'video_quality' => '',
                'childlock' => '',
                'clock_type' => '',
                'clock_setting' => '',
                'toggle' => '',
                'screen' => '',
                'text' => '',
                'movies_progress' => '',
                'movies_favorites' => '',
                'television_progress' => '',
                'television_locked' => '',
                'television_favorites' => '',
                'television_grouplock' => '',
                'education_favorites' => '',
                'education_finished' => '',
                'education_progress' => '',
                'series_favorites' => '',
                'series_progress' => '',
                'avatar' => '',
                'recommendations' => '',
                'age_rating' => '',
                'profile_lock' => '',
                'mode' => '',
                'name' => 'Rester'
            ],
            [
                'id' => 89,
                'collection_key' => 'xtv.xtv_crm_111',
                'document_key' => 'write2sunny123gmailcom.666919.profile',
                'audio' => '',
                'video_quality' => 'HIGH',
                'childlock' => '0000',
                'clock_type' => '24h',
                'clock_setting' => 'HH:mm',
                'toggle' => '',
                'screen' => '',
                'text' => '',
                'movies_progress' => '[]',
                'movies_favorites' => '[]',
                'television_progress' => '[]',
                'television_locked' => '[]',
                'television_favorites' => '[]',
                'television_grouplock' => '[{"1":1},{"2":2}]',
                'education_favorites' => '[]',
                'education_finished' => '[]',
                'education_progress' => '[]',
                'series_favorites' => '[]',
                'series_progress' => '[]',
                'avatar' => '',
                'recommendations' => '[]',
                'age_rating' => 'TV-ALL',
                'profile_lock' => '',
                'mode' => 'regular',
                'name' => 'aaa'
            ],
        ];

        $this->CI->db->insert_batch('profile', $data);
        echo "Profile table seeded successfully.\n";
    }
}
