<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ui_themes_m extends MY_Model {
	protected $_table_name = 'ui_themes';
	public $rules = array(
		'version' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		)		
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
}

/* End of file Ui_themes_m.php */
/* Location: ./application/models/Ui_themes_m.php */