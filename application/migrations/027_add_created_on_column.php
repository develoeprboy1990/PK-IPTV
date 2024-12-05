<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_created_on_column extends CI_Migration {

    public function up() {
        // Add created_on column to relevant tables
        $tables = array(
            'activation_keys',          // Track when activation keys were generated
            'advertisement',            // Track when ads were created
            'albums',                   // Track when albums were added
            'channel',                  // Track when channels were created
            'customer_devices',         // Track when devices were added
            'messages',                 // Track when messages were sent
            'movie',                    // Some tables already have it, adding to others
            'news',                     // Track when news items were created
            'playlists',               // Track when playlists were created
            'products',                // Track when products were created
            'reseller',                // Track when reseller accounts were created
            'series',                  // Track when series were added
            'series_episode',          // Track when episodes were added
            'series_seasons',          // Track when seasons were added
            'server_items',            // Track when server items were added
            'subscription_renewal_keys' // Track when renewal keys were generated
        );

        foreach ($tables as $table) {
            // Skip if the table already has created_on column
            if (!$this->db->field_exists('created_on', $table)) {
                // Using direct SQL query for proper CURRENT_TIMESTAMP default
                $this->db->query("ALTER TABLE `{$table}` 
                                ADD COLUMN `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP");
            }
        }
    }

    public function down() {
        // Remove created_on column from tables
        $tables = array(
            'activation_keys',
            'advertisement',
            'albums',
            'channel',
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
            'server_items',
            'subscription_renewal_keys'
        );

        foreach ($tables as $table) {
            if ($this->db->field_exists('created_on', $table)) {
                $this->dbforge->drop_column($table, 'created_on');
            }
        }
    }
}