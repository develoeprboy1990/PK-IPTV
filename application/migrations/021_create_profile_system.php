<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_profile_system extends CI_Migration {

    public function up() {
        // Create profile table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'collection_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'document_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'audio' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'video_quality' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'childlock' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'clock_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'clock_setting' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'toggle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'screen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'movies_progress' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'movies_favorites' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'television_progress' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'television_locked' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'television_favorites' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'television_grouplock' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'education_favorites' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'education_finished' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'education_progress' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'series_favorites' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'series_progress' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'recommendations' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'age_rating' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'profile_lock' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'mode' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('profile', TRUE, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_general_ci']);

        // Create ui_themes table for profile customization
        $this->dbforge->add_field([
            'id' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'img_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ui_themes', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all profile-related tables
        $tables = [
            'ui_themes',
            'profile'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}