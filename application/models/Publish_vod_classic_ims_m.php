<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class publish_vod_classic_ims_m extends MY_Model {
	protected $_table_name = 'publish_vod_classic_ims';
	public $rules = array(
		'module_name' => array(
			'field' => 'module_name',
			'label' => 'Module Name',
			'rules' => ''
		),
		'should_update' => array(
			'field' => 'should_update',
			'label' => 'Should Update',
			'rules' => ''
		),
		'last_update' => array(
			'field' => 'last_update',
			'label' => 'Last Update',
			'rules' => ''
		),

	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
}

