<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Rename_created_on_to_created_at extends CI_Migration {

    public function up() {
        // Rename created_on to created_at in relevant tables
        $tables = array(
            'activation_keys',          // Track when activation keys were created
            'advertisement',            // Track when ads were created
            'albums',                   // Track when albums were created
            'channel',                  // Track when channels were created
            'customers',                // Track when customers were updated
            'customer_devices',         // Track when devices were created
            'messages',                 // Track when messages were created
            'movie',                    // Track when movies were created
            'news',                     // Track when news were created
            'playlists',               // Track when playlists were created
            'products',                // Track when products were created
            'reseller',                // Track when reseller accounts were created
            'series',                  // Track when series were created
            'series_episode',          // Track when episodes were created
            'series_seasons',          // Track when seasons were created
            'server_items',            // Track when server items were created
            'subscription_renewal_keys' // Track when renewal keys were created
        );

        foreach ($tables as $table) {
            // Skip if the table doesn't have created_on column
            if ($this->db->field_exists('created_on', $table)) {
                // Using direct SQL query to rename created_on to created_at while maintaining the default value
                $this->db->query("ALTER TABLE `{$table}` 
                                CHANGE COLUMN `created_on` `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP");
            }
        }
    }

    public function down() {
        // Revert created_at back to created_on
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
            // Skip if the table doesn't have created_at column
            if ($this->db->field_exists('created_at', $table)) {
                $this->db->query("ALTER TABLE `{$table}` 
                                CHANGE COLUMN `created_at` `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP");
            }
        }
    }
}