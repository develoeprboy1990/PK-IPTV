<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist_content_items_m extends MY_Model {
	protected $_table_name = 'playlist_content_items';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => 'required|trim'
		),
		'length_seconds' => array(
			'field' => 'length_seconds',
			'label' => 'Length in Seconds',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}


}

/* End of file playlist_content_items.php */
/* Location: ./application/models/playlist_content_items.php */