<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gui_versions_m extends MY_Model {
	protected $_table_name = 'gui_versions';
	public $rules = array(
		'version' => array(
			'field' => 'version',
			'label' => 'Version',
			'rules' => 'required|trim'
		),
		'changelog' => array(
			'field' => 'changelog',
			'label' => 'Change Log',
			'rules' => 'required|trim'
		),
		'location' => array(
			'field' => 'location',
			'label' => 'Location',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
}

/* End of file Gui_versions_m.php */
/* Location: ./application/models/Gui_versions_m.php */