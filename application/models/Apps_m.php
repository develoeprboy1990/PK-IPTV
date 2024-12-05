<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps_m extends MY_Model {

	protected $_table_name = 'app';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'category_id' => array(
			'field' => 'category_id',
			'label' => 'Category',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => 'required|trim'
		),
		'server_url_id' => array(
			'field' => 'server_url_id',
			'label' => 'Server Url',
			'rules' => ''
		),
		'token_id' => array(
			'field' => 'token_id',
			'label' => 'Tokenize',
			'rules' => ''
		),
		'icon' => array(
			'field' => 'icon',
			'label' => 'Icon',
			'rules' => ''
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'show_on_home'=> array(
			'field' => 'show_on_home',
			'label' => 'Show On Home',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_tokens(){
		$query = $this->db->get('token');
		return $query->result();
	}
	
}

/* End of file Apps_m.php */
/* Location: ./application/models/Apps_m.php */