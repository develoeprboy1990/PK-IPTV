<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_m extends MY_Model {

	protected $_table_name = 'employees';
	public $add_rules = array(
		'emp_name' => array(
			'field' => 'emp_name',
			'label' => 'Employee Name',
			'rules' => 'required|trim'
		),
	);
	public $edit_rules = array(
		'emp_name' => array(
			'field' => 'emp_name',
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

/* End of file Employee_m.php */
/* Location: ./application/models/Employee_m.php */