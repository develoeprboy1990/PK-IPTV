<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_advertisement_system extends CI_Migration {

    public function up() {
        // Create advertisement table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'collate' => 'latin1_general_ci'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE,
                'collate' => 'latin1_general_ci'
            ],
            'gui_position' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'collate' => 'latin1_general_ci'
            ],
            'date_start' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'date_end' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'max_views' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'price_per_view' => [
                'type' => 'DOUBLE',
                'null' => TRUE
            ],
            'show_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'reseller_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 999,
                'null' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE,
                'collate' => 'latin1_general_ci'
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'default' => 'banner',
                'null' => TRUE,
                'collate' => 'latin1_general_ci'
            ],
            'length' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => TRUE
            ],
            'text' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'external_url' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE,
                'collate' => 'latin1_general_ci'
            ],
            'campaign_email' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'stream_url' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'backdrop' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'make_clickable' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => TRUE
            ],
            'campaign_email_text' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'exclude_country' => [
                'type' => 'ENUM',
                'constraint' => ['no', 'yes'],
                'default' => 'no',
                'null' => FALSE
            ],
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'city_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('advertisement', TRUE, ['ENGINE' => 'InnoDB']);

        // Create advertisement_reports table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'ad_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'ad_name' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'view_date' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'ad_gui_position' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'ad_price_per_view' => [
                'type' => 'DOUBLE',
                'null' => TRUE
            ],
            'reseller_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'ad_type' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'default' => 'banner',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('advertisement_reports', TRUE, ['ENGINE' => 'InnoDB']);

        // Create advertisements_exclude_include_countries table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'advertisement_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'include' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'exclude' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('advertisements_exclude_include_countries', TRUE, ['ENGINE' => 'InnoDB']);

        // Create video advertisement mapping tables
        $video_ad_tables = [
            'advertisement_video_to_channels' => 'channel_id',
            'advertisement_video_to_movies' => 'movie_id',
            'advertisement_video_to_series' => 'series_id'
        ];

        foreach ($video_ad_tables as $table_name => $content_field) {
            $this->dbforge->add_field([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => TRUE
                ],
                'advertisement_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ],
                $content_field => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table($table_name, TRUE, ['ENGINE' => 'InnoDB']);
        }
    }

    public function down() {
        // Drop advertisement-related tables
        $tables = [
            'advertisement_video_to_series',
            'advertisement_video_to_movies',
            'advertisement_video_to_channels',
            'advertisements_exclude_include_countries',
            'advertisement_reports',
            'advertisement'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}