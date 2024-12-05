<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_core_auth_tables extends CI_Migration {

    public function up() {
        // Create groups table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'type' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('groups', TRUE, ['ENGINE' => 'InnoDB']);

        // Create users table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => FALSE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '254',
                'null' => FALSE
            ],
            'activation_selector' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'activation_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'forgotten_password_selector' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'forgotten_password_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'forgotten_password_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'remember_selector' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'remember_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'created_on' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'last_login' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ],
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'role' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['email'], FALSE, TRUE); // Unique key
        $this->dbforge->add_key(['activation_selector'], FALSE, TRUE); // Unique key
        $this->dbforge->add_key(['forgotten_password_selector'], FALSE, TRUE); // Unique key
        $this->dbforge->add_key(['remember_selector'], FALSE, TRUE); // Unique key
        $this->dbforge->create_table('users', TRUE, ['ENGINE' => 'InnoDB']);

        // Create users_groups table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ],
            'group_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => TRUE,
                'null' => FALSE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['user_id', 'group_id']); // Composite key
        $this->dbforge->create_table('users_groups', TRUE, ['ENGINE' => 'InnoDB']);

        // Create permissions table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'per_view' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'null' => TRUE
            ],
            'per_create' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'null' => TRUE
            ],
            'per_edit' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'null' => TRUE
            ],
            'per_delete' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'null' => TRUE
            ],
            'per_status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'null' => TRUE
            ],
            'per_create_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('permissions', TRUE, ['ENGINE' => 'InnoDB']);

// Create group_role_permissions table 

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'allow_create' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '1',
                'null' => FALSE
            ],
            'allow_edit' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '1',
                'null' => FALSE
            ],
            'allow_delete' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '1',
                'null' => FALSE
            ],
            'allow_view' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => '1',
                'null' => FALSE
            ]
        ]);

        // Add primary key
        $this->dbforge->add_key('id', TRUE);

       
        $this->dbforge->create_table('group_role_permissions', TRUE, ['ENGINE' => 'InnoDB']);

        // Create roles table 
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'role_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'role_status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1'
            ],
            'role_create_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roles', TRUE, ['ENGINE' => 'InnoDB']);

        // Add login_attempts table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => FALSE
            ],
            'login' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'time' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('login_attempts', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        $this->dbforge->drop_table('login_attempts', TRUE);
        $this->dbforge->drop_table('roles', TRUE);
        $this->dbforge->drop_table('permissions', TRUE);
        $this->dbforge->drop_table('users_groups', TRUE);
        $this->dbforge->drop_table('users', TRUE);
        $this->dbforge->drop_table('groups', TRUE);
        $this->dbforge->drop_table('group_role_permissions', TRUE);
        
    }
}