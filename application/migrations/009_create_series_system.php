<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_series_system extends CI_Migration {

    public function up() {
        // Create series table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => FALSE,
                'comment' => '*'
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'poster' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'backdrop' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'store_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'language_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'tmbd_id' => [
                'type' => 'VARCHAR',
                'constraint' => 56,
                'null' => TRUE
            ],
            'is_kids_friendly' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'childlock' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => TRUE,
                'default' => 0
            ],
            'year' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE
            ],
            'actor' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'language' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'tags' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'ott_platforms' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'tv_show_platform_status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'tv_show_platforms' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'duration' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'producer' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'director' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'studio' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'trailer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'rating' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'age_category' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'overlay_enabled' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'preroll_enabled' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'ticker_enabled' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'show_on_home' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 1
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1
            ],
            'dbselect' => [
                'type' => 'VARCHAR',
                'constraint' => 28,
                'null' => FALSE
            ],
            'episode_update' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'sun_day' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'mon_day' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'tues_day' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'wednes_day' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'thirs_day' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'fri_day' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'satur_day' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'created_on' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_seasons table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'series_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => FALSE,
                'comment' => '*'
            ],
            'poster' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'backdrop' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'big size like 1280x720 size poster'
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'is_kids_friendly' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'childlock' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'secure_stream' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'has_drm' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'is_payperview' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'rule_payperview' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'tokenize' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 1
            ],
            'imported' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'tmdb_id' => [
                'type' => 'VARCHAR',
                'constraint' => 28,
                'null' => FALSE
            ],
            'season_number' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_seasons', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_episode table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'season_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'actor' => [
                'type' => 'TEXT',
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
            'language_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'sequence_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'tmdb_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'season_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'episode_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'series_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_episode', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_store table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'language_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'childlock' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'comment' => 'if 1 then this is main store and has sub store.'
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_store', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_ott_platforms table
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
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_ott_platforms', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_to_platforms table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'ott_platform_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'series_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_to_platforms', TRUE, ['ENGINE' => 'InnoDB']);

        // Create tv_show_platforms table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'language_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tv_show_platforms', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_to_tv_platforms table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'series_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'platform_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_to_tv_platforms', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_genre table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'store_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_genre', TRUE, ['ENGINE' => 'InnoDB']);

        // Create series_to_tags table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'tag_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'series_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('series_to_tags', TRUE, ['ENGINE' => 'InnoDB']);

        // Add indexes and foreign key constraints for series system tables
     //   $this->db->query('ALTER TABLE series_to_tv_platforms ADD INDEX `series_id` (`series_id`)');
        //$this->db->query('ALTER TABLE series_to_tv_platforms ADD INDEX `platform_id` (`platform_id`)');
    }

    public function down() {
        // Drop all tables in reverse order to handle dependencies
        $this->dbforge->drop_table('series_to_tags', TRUE);
        $this->dbforge->drop_table('series_genre', TRUE);
        $this->dbforge->drop_table('series_to_tv_platforms', TRUE);
        $this->dbforge->drop_table('tv_show_platforms', TRUE);
        $this->dbforge->drop_table('series_to_platforms', TRUE);
        $this->dbforge->drop_table('series_ott_platforms', TRUE);
        $this->dbforge->drop_table('series_store', TRUE);
        $this->dbforge->drop_table('series_episode', TRUE);
        $this->dbforge->drop_table('series_seasons', TRUE);
        $this->dbforge->drop_table('series', TRUE);
    }
}