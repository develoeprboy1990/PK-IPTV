<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_music_system extends CI_Migration {

    public function up() {
        // Create music_categories table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('music_categories', TRUE, ['ENGINE' => 'InnoDB']);

        // Create albums table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'price' => [
                'type' => 'DOUBLE',
                'null' => TRUE
            ],
            'date_start' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'date_end' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'cover' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'show_on_home' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'tokenize' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'artist' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'is_payperview' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ],
            'rule_payperview' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'is_kids_friendly' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('albums', TRUE, ['ENGINE' => 'InnoDB']);

        // Create songs table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'album_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'server_url_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'secure_stream' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ],
            'has_drm' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('songs', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop tables in reverse order to handle dependencies
        $this->dbforge->drop_table('songs', TRUE);
        $this->dbforge->drop_table('albums', TRUE);
        $this->dbforge->drop_table('music_categories', TRUE);
    }
}