<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_categories_m extends MY_Model {

	protected $_table_name = 'app_categories';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Category Name',
			'rules' => 'required|trim'
		),
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	

}

/* End of file Music_categories.php */
/* Location: ./application/models/Music_categories.php */