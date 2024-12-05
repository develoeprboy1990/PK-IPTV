<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_ott_platforms_m extends MY_Model {
	protected $_table_name = 'movie_ott_platforms';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
        'order_no' => array(
            'field' => 'order_no',
            'label' => 'Display Order',
            'rules' => 'trim|integer'
        )
	);
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_platforms_by_movie($movie_id){
		$this->db->select('ott_platform_id');
		$this->db->where(array('movie_id'=>$movie_id));
		$query = $this->db->get('movie_to_platforms');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['ott_platform_id'];
		}
		return $ids;
	}

	public function delete_platforms_by_movie($movie_id){
		$this->db->delete('movie_to_platforms', array('movie_id' =>$movie_id));
	}
}