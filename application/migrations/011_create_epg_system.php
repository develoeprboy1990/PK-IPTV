<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_epg_system extends CI_Migration {

    public function up() {
        // Create epgs (EPG Sources) table
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
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'epg_offset' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'epg_offset_date' => [
                'type' => 'VARCHAR',
                'constraint' => 28,
                'null' => FALSE
            ],
            'epg_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('name', TRUE); // Unique key on name
        $this->dbforge->create_table('epgs', TRUE, ['ENGINE' => 'InnoDB']);

        // Create epgs_chanels table (mapping between EPG sources and channels)
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'epgs_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'chanel_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'clanel_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'icon' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'url_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('epgs_chanels', TRUE, ['ENGINE' => 'InnoDB']);

        // Create epg table (actual program data)
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'channel_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            't_start' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            't_end' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'ut_start' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'ut_end' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'progimg' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'is_series' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('epg', TRUE, ['ENGINE' => 'InnoDB']);

        // Create daily_episode_update table for managing series episode updates
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'episode_date' => [
                'type' => 'DATE',
                'null' => FALSE
            ],
            'season_id' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'series_name' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'season_name' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'title' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'url' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'seasons_description' => [
                'type' => 'LONGTEXT',
                'null' => FALSE
            ],
            'sequence' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'is_added' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'default' => 0,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('daily_episode_update', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop tables in reverse order to handle dependencies
        $this->dbforge->drop_table('daily_episode_update', TRUE);
        $this->dbforge->drop_table('epg', TRUE);
        $this->dbforge->drop_table('epgs_chanels', TRUE);
        $this->dbforge->drop_table('epgs', TRUE);
    }
}