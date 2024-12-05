<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisements_m extends MY_Model {
	protected $_table_name = 'advertisement';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		
		'gui_position' => array(
			'field' => 'gui_position',
			'label' => 'GUI Position',
			'rules' => ''
		),
		'date_start' => array(
			'field' => 'date_start',
			'label' => 'Date Start',
			'rules' => ''
		),
		'date_end' => array(
			'field' => 'date_end',
			'label' => 'Date End',
			'rules' => ''
		),
		'max_views'=> array(
			'field' => 'max_views',
			'label' => 'Max Views',
			'rules' => ''
		),
		'price_per_view'=> array(
			'field' => 'price_per_view',
			'label' => 'Price per View',
			'rules' => ''
		),
		'show_time'=> array(
			'field' => 'show_time',
			'label' => 'Show Time',
			'rules' => ''
		),
		'url'=> array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => ''
		),
		'type'=> array(
			'field' => 'type',
			'label' => 'Type',
			'rules' => ''
		),
		'length'=> array(
			'field' => 'length',
			'label' => 'Length',
			'rules' => ''
		),
		'text'=> array(
			'field' => 'text',
			'label' => 'Text',
			'rules' => ''
		),
		'external_url'=> array(
			'field' => 'external_url',
			'label' => 'External Url',
			'rules' => ''
		),
		'campaign_email'=> array(
			'field' => 'campaign_email',
			'label' => 'Campaign Email',
			'rules' => ''
		),
		'stream_url'=> array(
			'field' => 'stream_url',
			'label' => 'Stream Url',
			'rules' => ''
		),
		
		'description'=> array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'make_clickable'=> array(
			'field' => 'make_clickable',
			'label' => 'Make Clickable',
			'rules' => ''
		),
		'campaign_email_text'=> array(
			'field' => 'campaign_email_text',
			'label' => 'Campaign Email Text',
			'rules' => ''
		),
		'exclude_country'=> array(
			'field' => 'exclude_country',
			'label' => 'Exclude Country',
			'rules' => ''
		),
		'country_id'=> array(
			'field' => 'country_id',
			'label' => 'Country',
			'rules' => ''
		),
		'state_id'=> array(
			'field' => 'state_id',
			'label' => 'State',
			'rules' => ''
		),
		'city_id'=> array(
			'field' => 'city_id',
			'label' => 'City',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_channels_by_ad($id){
		$this->db->select('channel_id');
		$this->db->where(array('advertisement_id'=>$id));
		$query = $this->db->get('advertisement_video_to_channels');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['channel_id'];
		}
		return $ids;
	}

	public function delete_channels_by_ad($id){
		$this->db->delete('advertisement_video_to_channels', array('advertisement_id' =>$id));
	}

	public function get_series_by_ad($id){
		$this->db->select('series_id');
		$this->db->where(array('advertisement_id'=>$id));
		$query = $this->db->get('advertisement_video_to_series');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['series_id'];
		}
		return $ids;
	}

	public function delete_series_by_ad($id){
		$this->db->delete('advertisement_video_to_series', array('advertisement_id' =>$id));
	}

	public function get_movies_by_ad($id){
		$this->db->select('movie_id');
		$this->db->where(array('advertisement_id'=>$id));
		$query = $this->db->get('advertisement_video_to_movies');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['movie_id'];
		}
		return $ids;
	}

	public function delete_movies_by_ad($id){
		$this->db->delete('advertisement_video_to_movies', array('advertisement_id' =>$id));
	}

	public function get_countries_by_ad($id){
		$this->db->select('country_id');
		$this->db->where(array('advertisement_id'=>$id));
		$query = $this->db->get('advertisements_exclude_include_countries');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['country_id'];
		}
		return $ids;
	}

	public function delete_countries_by_ad($id){
		$this->db->delete('advertisements_exclude_include_countries', array('advertisement_id' =>$id));
	}
	
}

/* End of file Advertisements_m.php */
/* Location: ./application/models/Advertisements_m.php */