<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_news_system extends CI_Migration {

    public function up() {
        // Create news_groups table
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
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('news_groups', TRUE, ['ENGINE' => 'InnoDB']);

        // Create news table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'news_group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'date_created' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('news', TRUE, ['ENGINE' => 'InnoDB']);

        // Create pages table for static content
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'page_title' => [
                'type' => 'MEDIUMTEXT',
                'null' => FALSE
            ],
            'page_content' => [
                'type' => 'LONGBLOB',
                'null' => FALSE
            ],
            'slug' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'page_name' => [
                'type' => 'TEXT',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pages', TRUE, ['ENGINE' => 'InnoDB']);

        // Create publish table for managing content updates
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'should_update' => [
                'type' => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default' => 'yes',
                'null' => FALSE
            ],
            'last_update' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('publish', TRUE, ['ENGINE' => 'InnoDB']);

        // Create publish_vod_classic_ims table for VOD publishing
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'should_update' => [
                'type' => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default' => 'yes',
                'null' => FALSE
            ],
            'last_update' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('publish_vod_classic_ims', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop all news-related tables
        $tables = [
            'publish_vod_classic_ims',
            'publish',
            'pages',
            'news',
            'news_groups'
        ];

        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}