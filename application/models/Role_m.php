<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_m extends MY_Model {

	protected $_table_name = 'roles';
	public $add_rules = array(
		'role_name' => array(
			'field' => 'role_name',
			'label' => 'Employee Name',
			'rules' => 'required|trim'
		),
	);

	public $edit_rules = array(
		'role_name' => array(
			'field' => 'role_name',
			'label' => 'Employee Name',
			'rules' => 'required|trim'
		),
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}	

}

/* End of file Role_m.php */
/* Location: ./application/models/Role_m.php */