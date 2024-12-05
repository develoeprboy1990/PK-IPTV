<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_channel_m extends MY_Model {

	protected $_table_name = 'channel_group';
	public $add_rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'position' => array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => 'required|numeric|trim'
		),
	);
	public $edit_rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'position' => array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => 'required|numeric|trim'
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