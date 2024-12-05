<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_movie_system extends CI_Migration {

    public function up() {
        // Create movie table
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
            'year' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE
            ],
            'actor' => [
                'type' => 'TEXT',
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
            'description' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'duration' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
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
            'server_url_trailer' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'trailer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'token_trailer' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_url_movie' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => '*'
            ],
            'token_movie' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'rating' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
                'comment' => 'used for age rating'
            ],
            'age_category' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'age_rating' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'imdb_rating' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
                'comment' => 'rating how many star'
            ],
            'store_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'subtitles' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'null' => TRUE,
                'default' => 0
            ],
            'accessrule' => [
                'type' => 'INT',
                'constraint' => 11,
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
                'constraint' => 255,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1
            ],
            'dbselect' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'vast_url' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'subtitle_url' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'select_genres' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'created_on' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('id', FALSE, FALSE, 'bhaskar');
        $this->dbforge->create_table('movie', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_genre table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
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
        $this->dbforge->create_table('movie_genre', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_store table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'language_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0
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
                'comment' => 'if 1 then this is main store and  has sub store.'
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('movie_store', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_stream_urls table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'movie_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'language_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_url_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'stream_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'token_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'movie_subtitleurl' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('movie_stream_urls', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_tags table
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
        $this->dbforge->create_table('movie_tags', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_to_genres table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'movie_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'genre_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE,
                'default' => 0
            ],
            'store_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'substore_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('movie_to_genres', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_to_tags table
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
            'movie_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('movie_to_tags', TRUE, ['ENGINE' => 'InnoDB']);

        // Create movie_ott_platforms table
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
        $this->dbforge->create_table('movie_ott_platforms', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('movie_ott_platforms', TRUE);
        $this->dbforge->drop_table('movie_to_tags', TRUE);
        $this->dbforge->drop_table('movie_to_genres', TRUE);
        $this->dbforge->drop_table('movie_tags', TRUE);
        $this->dbforge->drop_table('movie_stream_urls', TRUE);
        $this->dbforge->drop_table('movie_store', TRUE);
        $this->dbforge->drop_table('movie_genre', TRUE);
        $this->dbforge->drop_table('movie', TRUE);
    }
}