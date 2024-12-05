<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator_m extends MY_Model {

	protected $_table_name = 'operators';
	public $rules = array(
		'operator_name' => array(
			'field' => 'operator_name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'operator_crm' => array(
			'field' => 'operator_crm',
			'label' => 'CRM',
			'rules' => 'required|trim'
		),
		'operator_brand' => array(
			'field' => 'operator_brand',
			'label' => 'Brand',
			'rules' => 'required|trim'
		),
		'operator_street' => array(
			'field' => 'operator_street',
			'label' => 'Street',
			'rules' => 'required|trim'
		),
		'operator_postal' => array(
			'field' => 'operator_postal',
			'label' => 'Postal',
			'rules' => 'required|trim'
		),
		'operator_city' => array(
			'field' => 'operator_city',
			'label' => 'City',
			'rules' => 'required|trim'
		),
		'operator_state' => array(
			'field' => 'operator_state',
			'label' => 'State',
			'rules' => 'required|trim'
		),
		'operator_country' => array(
			'field' => 'operator_country',
			'label' => 'Country',
			'rules' => 'required|trim'
		),
		'operator_telephone' => array(
			'field' => 'operator_telephone',
			'label' => 'Telephone',
			'rules' => 'required|trim'
		),
		'operator_mobile' => array(
			'field' => 'operator_mobile',
			'label' => 'Mobile',
			'rules' => 'required|trim'
		),
		'operator_email' => array(
			'field' => 'operator_email',
			'label' => 'Email',
			'rules' => 'required|trim'
		),
		'operator_bank_details' => array(
			'field' => 'operator_bank_details',
			'label' => 'Bank Details',
			'rules' => 'required|trim'
		),
		'operator_invoice_header' => array(
			'field' => 'operator_invoice_header',
			'label' => 'Invoice Header',
			'rules' => 'required|trim'
		),
		'operator_mailing_header' => array(
			'field' => 'operator_mailing_header',
			'label' => 'Mailing Header',
			'rules' => 'required|trim'
		),
		'operator_invoice_header' => array(
			'field' => 'operator_invoice_header',
			'label' => 'Invoice Header',
			'rules' => 'required|trim'
		),
		'operator_invoice_day_of_the_month' => array(
			'field' => 'operator_invoice_day_of_the_month',
			'label' => 'Invoice Day of the Month',
			'rules' => 'required|trim'
		),
		'operator_terms_link' => array(
			'field' => 'operator_terms_link',
			'label' => 'Terms Link',
			'rules' => 'required|trim'
		),
		'operator_contact_link' => array(
			'field' => 'operator_contact_link',
			'label' => 'Contact Link',
			'rules' => 'required|trim'
		),
		'operator_operator_link' => array(
			'field' => 'operator_operator_link',
			'label' => 'Operator Link',
			'rules' => 'required|trim'
		),
		'operator_client_login_link' => array(
			'field' => 'operator_client_login_link',
			'label' => 'Client Login Link',
			'rules' => 'required|trim'
		),
		'operator_registration_emails' => array(
			'field' => 'operator_registration_emails',
			'label' => 'Register Emails',
			'rules' => ''
		),
		'operator_auto_invoicing_enabled' => array(
			'field' => 'operator_auto_invoicing_enabled',
			'label' => 'Auto Invoicing Enabled',
			'rules' => ''
		),
		'operator_registration_emails' => array(
			'field' => 'operator_registration_emails',
			'label' => 'Registration Email',
			'rules' => ''
		),
		'operator_auto_invoicing_enabled' => array(
			'field' => 'operator_auto_invoicing_enabled',
			'label' => 'Auto Invoicing Enabled',
			'rules' => ''
		),
		'operator_support_email' => array(
			'field' => 'operator_support_email',
			'label' => 'Support Email',
			'rules' => 'required|trim'
		),
		'operator_default_language' => array(
			'field' => 'operator_default_language',
			'label' => 'Defatult Language',
			'rules' => 'required|trim'
		),
		'operator_image_location' => array(
			'field' => 'operator_image_location',
			'label' => 'Image Location',
			'rules' => 'required|trim'
		),
		'operator_content_api_location' => array(
			'field' => 'operator_content_api_location',
			'label' => 'Content API Location',
			'rules' => 'required|trim'
		),
		'operator_product_api_location' => array(
			'field' => 'operator_product_api_location',
			'label' => 'Product API Location',
			'rules' => 'required|trim'
		),
		'operator_web_api_location' => array(
			'field' => 'operator_web_api_location',
			'label' => 'Web API Location',
			'rules' => 'required|trim'
		),
		'operator_news_image_location' => array(
			'field' => 'operator_news_image_location',
			'label' => 'News Image Location',
			'rules' => 'required|trim'
		),
		'operator_font' => array(
			'field' => 'operator_font',
			'label' => 'Font',
			'rules' => ''
		),
		'operator_primary_color' => array(
			'field' => 'operator_primary_color',
			'label' => 'Primary Color',
			'rules' => ''
		),
		'operator_secondary_color' => array(
			'field' => 'operator_secondary_color',
			'label' => 'Secondary Color',
			'rules' => ''
		),
		'operator_use_register' => array(
			'field' => 'operator_use_register',
			'label' => 'Use Register',
			'rules' => ''
		),
		'operator_use_trial' => array(
			'field' => 'operator_use_trial',
			'label' => 'Use Trial',
			'rules' => ''
		),
		'operator_use_renew_by_key' => array(
			'field' => 'operator_use_renew_by_key',
			'label' => 'Use renew by key',
			'rules' => ''
		),
		'operator_product_trial_id' => array(
			'field' => 'operator_product_trial_id',
			'label' => 'Project Trail Id',
			'rules' => 'required|trim'
		),
		'operator_disclaimer' => array(
			'field' => 'operator_disclaimer',
			'label' => 'Disclaimer',
			'rules' => 'required|trim'
		),
		'operator_is_show_disclaimer' => array(
			'field' => 'operator_is_show_disclaimer',
			'label' => 'Is show disclaimer',
			'rules' => ''
		),
		'operator_sleepmode' => array(
			'field' => 'operator_sleepmode',
			'label' => 'Sleepmode',
			'rules' => 'required|trim'
		), 
		'operator_storage' => array(
			'field' => 'operator_storage',
			'label' => 'Storage',
			'rules' => 'required|trim'
		), 
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

}

/* End of file Operator_m.php */
/* Location: ./application/models/Operator_m.php */