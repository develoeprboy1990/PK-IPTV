<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_groups_m extends MY_Model {
	protected $_table_name = 'news_groups';
	public $rules = array(
		'name' => array(
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

/* End of file News_groups_m.php */
/* Location: ./application/models/News_groups_m.php */