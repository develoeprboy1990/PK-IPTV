<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_templates_m extends MY_Model {
	protected $_table_name = 'email_templates';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Template Name',
			'rules' => 'required|trim'
		),
		'subject' => array(
			'field' => 'subject',
			'label' => 'Subject',
			'rules' => 'required|trim'
		),
		'sender_name' => array(
			'field' => 'sender_name',
			'label' => 'Sender Name',
			'rules' => 'required|trim'
		),
		'sender_email' => array(
			'field' => 'sender_email',
			'label' => 'Sender Email',
			'rules' => 'required|trim'
		),
		'bcc' => array(
			'field' => 'bcc',
			'label' => 'BCC',
			'rules' => ''
		),
		'body' => array(
			'field' => 'body',
			'label' => 'Message Body',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_email_template($template_name){
		$this->db->where(array('slug'=>$template_name));
		$query = $this->db->get('email_templates');
		return $query->row();
	}
}

/* End of file Email_templates_m.php */
/* Location: ./application/models/Email_templates_m.php */