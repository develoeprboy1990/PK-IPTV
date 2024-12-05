<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_templates_m extends MY_Model {
	protected $_table_name = 'sms_templates';
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
		'sender_mobile' => array(
			'field' => 'sender_mobile',
			'label' => 'Sender Mobile',
			'rules' => 'required|trim'
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

	public function get_sms_template($template_name){
		$this->db->where(array('slug'=>$template_name));
		$query = $this->db->get('sms_templates');
		return $query->row();
	}
}

/* End of file Sms_templates_m.php */
/* Location: ./application/models/Sms_templates_m.php */