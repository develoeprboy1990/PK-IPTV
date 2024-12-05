<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Languages_m extends MY_Model {
	protected $_table_name = 'languages';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'code' => array(
			'field' => 'code',
			'label' => 'Code',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

}

/* End of file Languages_m.php */
/* Location: ./application/models/Languages_m.php */