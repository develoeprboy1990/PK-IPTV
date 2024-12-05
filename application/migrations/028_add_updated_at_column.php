<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_updated_at_column extends CI_Migration {

    public function up() {
        // Add updated_at column to relevant tables
        $tables = array(
            'activation_keys',          // Track when activation keys were updated
            'advertisement',            // Track when ads were updated
            'albums',                   // Track when albums were updated
            'channel',                  // Track when channels were updated
            'customers',                // Track when customers were updated
            'customer_devices',         // Track when devices were updated
            'messages',                 // Track when messages were updated
            'movie',                    // Track when movies were updated
            'news',                     // Track when news items were updated
            'playlists',               // Track when playlists were updated
            'products',                // Track when products were updated
            'reseller',                // Track when reseller accounts were updated
            'series',                  // Track when series were updated
            'series_episode',          // Track when episodes were updated
            'series_seasons',          // Track when seasons were updated
            'server_items',            // Track when server items were updated
            'subscription_renewal_keys' // Track when renewal keys were updated
        );

        foreach ($tables as $table) {
            // Skip if the table already has updated_at column
            if (!$this->db->field_exists('updated_at', $table)) {
                // Using direct SQL query for proper timestamp update trigger
                $this->db->query("ALTER TABLE `{$table}` 
                                ADD COLUMN `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                                ON UPDATE CURRENT_TIMESTAMP");
            }
        }
    }

    public function down() {
        // Remove updated_at column from tables
        $tables = array(
            'activation_keys',
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
            'server_items',
            'subscription_renewal_keys'
        );

        foreach ($tables as $table) {
            if ($this->db->field_exists('updated_at', $table)) {
                $this->dbforge->drop_column($table, 'updated_at');
            }
        }
    }
}