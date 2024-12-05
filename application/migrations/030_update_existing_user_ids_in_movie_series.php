<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_existing_user_ids_in_movie_series extends CI_Migration {

    public function up() {
        // Tables that need user_id update
        $tables = array(
            'movie',
            'series'
        );

        foreach ($tables as $table) {
            // Check if the table exists
            if ($this->db->table_exists($table)) {
                // Check if user_id column exists
                if ($this->db->field_exists('user_id', $table)) {
                    // Update all records where user_id is NULL
                    $this->db->query("UPDATE {$table} SET user_id = 1 WHERE user_id IS NULL");
                }
            }
        }
    }

    public function down() {
        // Tables to revert
        $tables = array(
            'movie',
            'series'
        );

        foreach ($tables as $table) {
            // Check if the table exists
            if ($this->db->table_exists($table)) {
                // Check if user_id column exists
                if ($this->db->field_exists('user_id', $table)) {
                    // Set all user_id values back to NULL
                    $this->db->query("UPDATE {$table} SET user_id = NULL");
                }
            }
        }
    }
}