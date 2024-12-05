<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_genres_m extends MY_Model {

	protected $_table_name = 'series_genre';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Genre Name',
			'rules' => 'required|trim'
		),
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

}

/* End of file Series_genres_m.php */
/* Location: ./application/models/Series_genres_m.php */