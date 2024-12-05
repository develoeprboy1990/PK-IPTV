<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epgs_m extends MY_Model {
	protected $_table_name = 'epgs';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => 'required|trim'
		)
		
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_epgs(){
		$this->db->select('*');
		$this->db->from($this->_table_name);		
		$query = $this->db->get();
		return $query->result();
	}


}

/* End of file Settings_m.php */
/* Location: ./application/models/Settings_m.php */