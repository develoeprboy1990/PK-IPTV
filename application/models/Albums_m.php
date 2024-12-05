<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums_m extends MY_Model {

	protected $_table_name = 'albums';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'category_id' => array(
			'field' => 'category_id',
			'label' => 'Category',
			'rules' => 'required|trim'
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'required|trim'
		),
		'price' => array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => ''
		),
		'date_start' => array(
			'field' => 'date_start',
			'label' => 'Start Date',
			'rules' => ''
		),
		'date_end' => array(
			'field' => 'date_end',
			'label' => 'End Date',
			'rules' => ''
		),
		'show_on_home' => array(
			'field' => 'show_on_home',
			'label' => 'Show on Home',
			'rules' => ''
		),
		'tokenize'=> array(
			'field' => 'tokenize',
			'label' => 'Token',
			'rules' => ''
		),
		'artist'=> array(
			'field' => 'artist',
			'label' => 'Artist',
			'rules' => ''
		),
		'position'=> array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => ''
		),
		'is_payperview' => array(
			'field' => 'is_payperview',
			'label' => 'Is Payperview',
			'rules' => ''
		),
		'rule_payperview' => array(
			'field' => 'rule_payperview',
			'label' => 'Rule Payperview',
			'rules' => ''
		),
		'is_kids_friendly' => array(
			'field' => 'is_kids_friendly',
			'label' => 'Is Kids Friendly',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_channels_groups($channel_id){
		$this->db->select('group_id');
		$this->db->where(array('channel_id'=>$channel_id));
		$query = $this->db->get('channel_to_group');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['group_id'];
		}
		return $ids;
	}

	public function get_tokens(){
		$query = $this->db->get('token');
		return $query->result();
	}

	public function delete_songs($album_id){
		$this->db->delete('songs', array('album_id' =>$album_id));
	}

	public function get_packages_by_channel($channel_id){
		$this->db->select('package_id');
		$this->db->where(array('channel_id'=>$channel_id));
		$query = $this->db->get('package_to_channel');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['package_id'];
		}
		return $ids;
	}

	public function delete_channels_package($channel_id){
			$this->db->delete('package_to_channel', array('channel_id' =>$channel_id));
	}

}

/* End of file Movies_m.php */
/* Location: ./application/models/Movies_m.php */