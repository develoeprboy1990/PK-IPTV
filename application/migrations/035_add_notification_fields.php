<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_notification_fields extends CI_Migration {

    public function up() {
        $fields = array(
            'notification_subject' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'after' => 'wallet_money'
            ),
            'notification_body' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'after' => 'notification_subject'
            ),
            'renewal_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'after' => 'notification_body'
            ),
            'qr_code' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'Base64 encoded QR code image',
                'after' => 'renewal_url'
            )
        );

        if (!$this->db->field_exists('notification_subject', 'reseller')) {
            $this->dbforge->add_column('reseller', $fields);
        }
    }

    public function down() {
        $fields = array('notification_subject', 'notification_body', 'renewal_url', 'qr_code');
        foreach ($fields as $field) {
            if ($this->db->field_exists($field, 'reseller')) {
                $this->dbforge->drop_column('reseller', $field);
            }
        }
    }
}