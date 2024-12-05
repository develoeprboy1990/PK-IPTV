<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_operator_system extends CI_Migration {

    public function up() {
        // Create operator table
        $this->dbforge->add_field([
            'operator_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => FALSE
            ],
            'street' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'postal' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => TRUE
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => TRUE
            ],
            'telephone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'bankdetails' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE
            ],
            'invoice_header' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'mailing_header' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'invoice_day_of_the_month' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'terms_link' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'contact_link' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'operator_link' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'client_login_link' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'registration_emails' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => FALSE
            ],
            'autoinvoicingenabled' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => TRUE
            ],
            'support_email' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'default_language' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'gui_logo' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'gui_background' => [
                'type' => 'VARCHAR',
                'constraint' => 450,
                'null' => TRUE
            ],
            'selection_color' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ],
            'gui_text' => [
                'type' => 'VARCHAR',
                'constraint' => 2000,
                'null' => TRUE,
                'comment' => 'html and css show in start page'
            ],
            'qrcode' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => FALSE
            ],
            'product_api_location' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'comment' => 'this is json file location'
            ],
            'web_api_location' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
                'comment' => 'api location'
            ],
            'use_register' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'use_trial' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'use_renew_by_key' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'product_trial_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'disclaimer' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE
            ],
            'is_show_disclaimer' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE
            ],
            'storage' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('operator_id', TRUE);
        $this->dbforge->create_table('operator', TRUE, ['ENGINE' => 'InnoDB']);

        // Create operators table (extended version)
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'operator_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_crm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_brand' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_street' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'operator_postal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_city' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'operator_country' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'operator_state' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'operator_telephone' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_bank_details' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_invoice_header' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_mailing_header' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_invoice_day_of_the_month' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'operator_terms_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_contact_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_operator_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_client_login_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_registration_emails' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => TRUE
            ],
            'operator_auto_invoicing_enabled' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => TRUE
            ],
            'operator_support_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_default_language' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_image_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_content_api_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_product_api_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'this is json file location'
            ],
            'operator_web_api_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE,
                'comment' => 'api location'
            ],
            'operator_news_image_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_font' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_primary_color' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_secondary_color' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_use_register' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => TRUE
            ],
            'operator_use_trial' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => TRUE
            ],
            'operator_use_renew_by_key' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => TRUE
            ],
            'operator_product_trial_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'operator_disclaimer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'operator_is_show_disclaimer' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => TRUE
            ],
            'operator_sleepmode' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'operator_storage' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'operator_status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '1',
                'null' => TRUE
            ],
            'operator_create_date' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('operators', TRUE, ['ENGINE' => 'InnoDB']);
    }

    public function down() {
        // Drop operator-related tables
        $this->dbforge->drop_table('operators', TRUE);
        $this->dbforge->drop_table('operator', TRUE);
    }
}