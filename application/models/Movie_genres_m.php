<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_genres_m extends MY_Model {

	protected $_table_name = 'movie_genre';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Genre Name',
			'rules' => 'required|trim'
		),
        'order_no' => array(
            'field' => 'order_no',
            'label' => 'Display Order',
            'rules' => 'trim|integer'
        )/*,
		'parent_store' => array(
			'field' => 'parent_store',
			'label' => 'Store Name',
			'rules' => 'required|trim'
		),*/
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getGenres(){
		/*$sql= "SELECT mg.*, ms.name store_name FROM movie_genre mg
		       JOIN movie_store ms on 
		       ms.id=mg.store_id";*/
		$sql= "SELECT * from movie_genre";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

}

/* End of file Movie_genres_m.php */
/* Location: ./application/models/Movie_genres_m.php */