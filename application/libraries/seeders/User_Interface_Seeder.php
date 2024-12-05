<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Interface_Seeder {

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function run() {
        // Clear existing data from the user_interface table
        $this->CI->db->truncate('user_interface');

        // Insert initial data
        $data = [
            [
                'id' => 2,
                'ui_name' => 'test1234_bm',
                'template_name' => '3',
                'status' => 1,
                'restart_app' => 1,
                'restart_stream' => 1,
                'lock_device_to_ip_address' => 1,
                'enable_sorting_channels' => 1,
                'enable_toggle_channels' => 1,
                'show_channel_preview' => 1,
                'toggle_default_settings' => 'channel',
                'catchup_days' => 2,
                'clock_format' => 'am_pm',
                'enable_catchuptv' => 1,
                'enable_clock' => 1,
                'enable_favourites_menu' => 1,
                'enable_kids_mode_profile' => 1,
                'enable_large_fonts' => 1,
                'enable_messages_menu' => 1,
                'enable_profiles' => 1,
                'enable_recordings' => 1,
                'enable_search_menu' => 1,
                'enable_settings_menu' => 1,
                'enable_watchlist_menu' => 1,
                'enable_weather' => 1,
                'enable_ads' => 1,
                'enable_hero_images' => 1,
                'enable_news_section' => 1,
                'enable_tv_preview' => 1,
                'default_audio_language' => 'user_defined',
                'default_screen_mode' => 'stretch',
                'default_subtitle_language' => 'user_defined',
                'enable_casting' => 1,
                'enable_catchup_buttons' => 1,
                'enable_channel_menu' => 1,
                'enable_mini_epg' => 1,
                'enable_problem_report' => 1,
                'player_type' => 'full_player',
                'enable_episodes_full_metadata' => 1,
                'enable_epg_search' => 1,
                'enable_tv_preview_screen' => 1,
                'show_epg_preview' => 1,
                'enable_watermarking' => 1,
                'enable_quadview' => 1,
                'epg_days' => 2,
                'sleep_mode_setting' => 2,
                'start_screen' => 'tv_guide'
            ],
            [
                'id' => 3,
                'ui_name' => 'test12345_bm',
                'template_name' => '2',
                'status' => 1,
                'restart_app' => 1,
                'restart_stream' => 1,
                'lock_device_to_ip_address' => 0,
                'enable_sorting_channels' => 0,
                'enable_toggle_channels' => 0,
                'show_channel_preview' => 0,
                'toggle_default_settings' => 'user_defined',
                'catchup_days' => 0,
                'clock_format' => '24_hours',
                'enable_catchuptv' => 1,
                'enable_clock' => 0,
                'enable_favourites_menu' => 0,
                'enable_kids_mode_profile' => 0,
                'enable_large_fonts' => 1,
                'enable_messages_menu' => 0,
                'enable_profiles' => 0,
                'enable_recordings' => 0,
                'enable_search_menu' => 0,
                'enable_settings_menu' => 0,
                'enable_watchlist_menu' => 0,
                'enable_weather' => 0,
                'enable_ads' => 0,
                'enable_hero_images' => 0,
                'enable_news_section' => 0,
                'enable_tv_preview' => 0,
                'default_audio_language' => 'user_defined',
                'default_screen_mode' => 'user_defined',
                'default_subtitle_language' => 'user_defined',
                'enable_casting' => 0,
                'enable_catchup_buttons' => 0,
                'enable_channel_menu' => 0,
                'enable_mini_epg' => 0,
                'enable_problem_report' => 0,
                'player_type' => 'full_player',
                'enable_episodes_full_metadata' => 0,
                'enable_epg_search' => 0,
                'enable_tv_preview_screen' => 1,
                'show_epg_preview' => 1,
                'enable_watermarking' => 0,
                'enable_quadview' => 0,
                'epg_days' => 0,
                'sleep_mode_setting' => 0,
                'start_screen' => 'home'
            ],
            // Additional rows omitted for brevity...
        ];

        $this->CI->db->insert_batch('user_interface', $data);
        echo "User_Interface table seeded successfully.\n";
    }
}
