<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_tags_m extends MY_Model {
	protected $_table_name = 'movie_tags';
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

	public function get_tags_by_movie($movie_id){
		$this->db->select('tag_id');
		$this->db->where(array('movie_id'=>$movie_id));
		$query = $this->db->get('movie_to_tags');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['tag_id'];
		}
		return $ids;
	}

	public function delete_tags_by_movie($movie_id){
		$this->db->delete('movie_to_tags', array('movie_id' =>$movie_id));
	}

	public function get_tags_by_series($series_id){
		$this->db->select('tag_id');
		$this->db->where(array('series_id'=>$series_id));
		$query = $this->db->get('series_to_tags');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['tag_id'];
		}
		return $ids;
	}

	public function delete_tags_by_series($series_id){
		$this->db->delete('series_to_tags', array('series_id' =>$series_id));
	}
}

/* End of file Movie_tags_m.php */
/* Location: ./application/models/Movie_tags_m.php */