<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_interface_tables extends CI_Migration {

    public function up() {
        // Create gui_settings table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'setting_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'version_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'youtube_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'flusonic_base_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'product_has_epg' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'gui_start_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'base_start_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'ui' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'null' => FALSE
            ],
            'brandname' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'contactinformation' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'dir' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'show_catchuptv' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_clock' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_fontsize' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_hint' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_languages' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_quickmenu' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_screensaver' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_search' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_speedtest' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'enable_hint' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'enable_kids_mode' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'direct_tv_mode' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'max_concurrent_devices' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'channel_preview' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'epg_preview' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'show_weather' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'max_days_interactivetv' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'sleep_mode' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'payment_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'storage_package' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'qrcode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'text_ui' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'background' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'selection_color' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => FALSE
            ],
            'ui_template' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'enable_advertisments' => [
                'type' => 'ENUM',
                'constraint' => ['true','false'],
                'default' => 'true',
                'null' => FALSE
            ],
            'tembm_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('gui_settings', TRUE, ['ENGINE' => 'InnoDB']);

        // Create gui_versions table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'version' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'changelog' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('gui_versions', TRUE, ['ENGINE' => 'InnoDB']);

        // Create ui_themes table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'img_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ui_themes', TRUE, ['ENGINE' => 'InnoDB']);

        // Create user_interface table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'ui_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'template_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 1
            ],
            'restart_app' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'restart_stream' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'enable_sorting_channels' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'enable_toggle_channels' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'show_channel_preview' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'toggle_default_settings' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE
            ],
            'catchup_days' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'clock_format' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE
            ],
            'enable_catchuptv' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'enable_clock' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'start_screen' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_interface', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('user_interface', TRUE);
        $this->dbforge->drop_table('ui_themes', TRUE);
        $this->dbforge->drop_table('gui_versions', TRUE);
        $this->dbforge->drop_table('gui_settings', TRUE);
    }
}