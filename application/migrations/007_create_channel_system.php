<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_channel_system extends CI_Migration {

    public function up() {
        // Create channel table
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
            'channel_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'channel_name' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => TRUE
            ],
            'channel_image' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => TRUE
            ],
            'channel_image_icon' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => TRUE
            ],
            'channel_epg_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'channel_epg_id' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'channel_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '1',
                'comment' => '1=video, 2=radio'
            ],
            'channel_catchup_tv' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Has CatchupTV'
            ],
            'encoder_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'have_archive' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'server_url_high' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_high' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'token_high' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_url_low' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_low' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => FALSE
            ],
            'token_low' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_standard' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_standard' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'token_standard' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_ios_tvos' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_ios_tvos' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'token_ios_tvos' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'server_tizen_webos' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_tizen_webos' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'token_tizen_webos' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'token' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'epg_url' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'epg_offset' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => '0',
                'comment' => 'its + or - time to add or remove from epg time'
            ],
            'dvr_offset' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'preroll_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Preroll Type in advertisment'
            ],
            'overlay_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Enable Overlay Ads?'
            ],
            'preroll_type' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'ticker_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Enable Ticker Ads?'
            ],
            'show_on_home' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'fingerprint' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'is_flussonic' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'flussonoc' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'is_dveo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'use_playlist' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'use_events' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'server_url_interactivetv' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'url_interactivetv' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => FALSE
            ],
            'token_interactivetv' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'childlock' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'secure_stream' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'drm_stream' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'drm_rewrite_rule' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
            'is_kids_friendly' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'dvr_channel_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ],
            'epg_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('channel', TRUE, ['ENGINE' => 'InnoDB']);

        // Create channel_group table
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
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('channel_group', TRUE, ['ENGINE' => 'InnoDB']);

        // Create channel_package table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ],
            'price' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
                'null' => FALSE
            ],
            'vat' => [
                'type' => 'FLOAT',
                'constraint' => '10,2',
                'null' => FALSE
            ],
            'device_type' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('channel_package', TRUE, ['ENGINE' => 'InnoDB']);

        // Create channel_to_group table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'channel_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['id'], FALSE, TRUE); // Unique key
        $this->dbforge->create_table('channel_to_group', TRUE, ['ENGINE' => 'InnoDB']);

        // Create package_to_channel table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'package_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'channel_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('package_to_channel', TRUE, ['ENGINE' => 'InnoDB']);

        // Create sys_channel_packet_devices table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->create_table('sys_channel_packet_devices', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('sys_channel_packet_devices', TRUE);
        $this->dbforge->drop_table('package_to_channel', TRUE);
        $this->dbforge->drop_table('channel_to_group', TRUE);
        $this->dbforge->drop_table('channel_package', TRUE);
        $this->dbforge->drop_table('channel_group', TRUE);
        $this->dbforge->drop_table('channel', TRUE);
    }
}