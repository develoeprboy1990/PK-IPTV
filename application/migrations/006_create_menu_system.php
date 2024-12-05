<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_menu_system extends CI_Migration {

    public function up() {
        // Create iptv_menus table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'is_default' => [
                'type' => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default' => 'yes',
                'null' => FALSE
            ],
            'is_module' => [
                'type' => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default' => 'no',
                'null' => FALSE
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'is_app' => [
                'type' => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default' => 'no',
                'null' => FALSE
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('iptv_menus', TRUE, ['ENGINE' => 'InnoDB']);

        // Create iptv_menu_packages table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('iptv_menu_packages', TRUE, ['ENGINE' => 'InnoDB']);

        // Create iptv_menu_package_item table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'menu_package_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('iptv_menu_package_item', TRUE, ['ENGINE' => 'InnoDB']);

        // Create service_menu_items table
        $this->dbforge->add_field([
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ],
            'is_default' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'is_module' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'module_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'is_app' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'package_url' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('menu_id', TRUE);
        $this->dbforge->create_table('service_menu_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create service_menu_package table
        $this->dbforge->add_field([
            'service_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'service_name' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->create_table('service_menu_package', TRUE, ['ENGINE' => 'InnoDB']);

        // Create service_menu_package_item table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'service_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'Active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id');
        $this->dbforge->create_table('service_menu_package_item', TRUE, ['ENGINE' => 'InnoDB']);

        // Create ser_menu_items table
        $this->dbforge->add_field([
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'ser_menu_item_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ],
            'ser_menu_item_is_default' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'ser_menu_item_is_module' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'ser_menu_item_module_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'ser_menu_item_type' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'ser_menu_item_is_app' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ],
            'ser_menu_item_package_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'ser_menu_item_package_url' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('menu_id', TRUE);
        $this->dbforge->create_table('ser_menu_items', TRUE, ['ENGINE' => 'InnoDB']);

        // Create ser_menu_packages table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'ser_menu_package_name' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->create_table('ser_menu_packages', TRUE, ['ENGINE' => 'InnoDB']);

        // Create ser_menu_package_items table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'ser_menu_package_items_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'ser_menu_package_items_menu_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'ser_menu_package_items_position' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'ser_menu_package_items_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id');
        $this->dbforge->create_table('ser_menu_package_items', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('ser_menu_package_items', TRUE);
        $this->dbforge->drop_table('ser_menu_packages', TRUE);
        $this->dbforge->drop_table('ser_menu_items', TRUE);
        $this->dbforge->drop_table('service_menu_package_item', TRUE);
        $this->dbforge->drop_table('service_menu_package', TRUE);
        $this->dbforge->drop_table('service_menu_items', TRUE);
        $this->dbforge->drop_table('iptv_menu_package_item', TRUE);
        $this->dbforge->drop_table('iptv_menu_packages', TRUE);
        $this->dbforge->drop_table('iptv_menus', TRUE);
    }
}