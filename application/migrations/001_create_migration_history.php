<?php
// 001_create_migration_history.php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_migration_history extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'version' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'applied_at' => [
                'type' => 'DATETIME',
                'null' => FALSE
            ],
            'action' => [
                'type' => 'ENUM',
                'constraint' => ['migrate', 'revert'],
                'default' => 'migrate',
                'null' => FALSE
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('migration_history', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->dbforge->drop_table('migration_history', TRUE);
    }
}
