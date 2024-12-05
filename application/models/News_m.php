<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_m extends MY_Model {
	protected $_table_name = 'news';
	public $rules = array(
		'news_group_id' => array(
			'field' => 'news_group_id',
			'label' => 'Group ID',
			'rules' => 'required|trim'
		),
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
}

/* End of file News_m.php */
/* Location: ./application/models/News_m.php */