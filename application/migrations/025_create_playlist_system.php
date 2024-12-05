<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_playlist_system extends CI_Migration {

    public function up() {
        // Create playlists table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('playlists', TRUE, ['ENGINE' => 'InnoDB']);

        // Create playlist_content_items table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'length_seconds' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('playlist_content_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create playlist_items table (linking table)
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'playlist_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'playlist_content_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => FALSE
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => FALSE
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('playlist_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create indices for better performance
//        $this->db->query('CREATE INDEX idx_playlist_id ON playlist_items (playlist_id)');
  //      $this->db->query('CREATE INDEX idx_content_id ON playlist_items (playlist_content_id)');
    //    $this->db->query('CREATE INDEX idx_position ON playlist_items (position)');
    }

    public function down() {
        // Drop indices first
       /// $this->db->query('DROP INDEX idx_playlist_id ON playlist_items');
        ///$this->db->query('DROP INDEX idx_content_id ON playlist_items');
        //$this->db->query('DROP INDEX idx_position ON playlist_items');

        // Drop all playlist-related tables
        $tables = [
            'playlist_items',
            'playlist_content_items',
            'playlists'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}