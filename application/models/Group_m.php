<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group_m extends MY_Model {

	protected $_table_name = 'groups';
	public $add_rules = array(
		'group_name' => array(
			'field' => 'group_name',
			'label' => 'Group Name',
			'rules' => 'required|trim'
		),
	);
	public $edit_rules = array(
		'group_name' => array(
			'field' => 'group_name',
			'label' => 'Group Name',
			'rules' => 'required|trim'
		),
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

}

/* End of file Group_m.php */
/* Location: ./application/models/Group_m.php */