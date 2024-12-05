<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_id_column extends CI_Migration {

    public function up() {
        // Add user_id column to relevant tables
        $tables = array(
            'advertisement',            // Track which user created ads
            'albums',                   // Track which user added music albums
            'channel',                  // Track which user created channels
            'customers',                // Track which user created customer accounts
            'customer_devices',         // Track which user added devices
            'messages',                 // Track which user sent messages
            'movie',                    // Track which user added movies
            'news',                     // Track which user created news items
            'playlists',               // Track which user created playlists
            'products',                // Track which user created products
            'reseller',                // Track which user created reseller accounts
            'series',                  // Track which user added series
            'series_episode',          // Track which user added episodes
            'series_seasons',          // Track which user added seasons
            'server_items'             // Track which user added server items
        );

        foreach ($tables as $table) {
            // Check if the table exists first
            if ($this->db->table_exists($table)) {
                // Check if user_id column already exists
                if (!$this->db->field_exists('user_id', $table)) {
                    $this->dbforge->add_column($table, array(
                        'user_id' => array(
                            'type' => 'INT',
                            'constraint' => 11,
                            'null' => TRUE,
                            'after' => 'id'
                        )
                    ));
                }
            }
        }
    }

    public function down() {
        // Remove user_id column from tables
        $tables = array(
            'advertisement',
            'albums',
            'channel',
            'customers',
            'customer_devices',
            'messages',
            'movie',
            'news',
            'playlists',
            'products',
            'reseller',
            'series',
            'series_episode',
            'series_seasons',
            'server_items'
        );

        foreach ($tables as $table) {
            // Check if the table exists first
            if ($this->db->table_exists($table)) {
                // Check if the column exists before trying to drop it
                if ($this->db->field_exists('user_id', $table)) {
                    $this->dbforge->drop_column($table, 'user_id');
                }
            }
        }
    }
}