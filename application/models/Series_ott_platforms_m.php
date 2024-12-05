<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_ott_platforms_m extends MY_Model {
	protected $_table_name = 'series_ott_platforms';
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

	public function get_platforms_by_series($series_id){
		$this->db->select('ott_platform_id');
		$this->db->where(array('series_id'=>$series_id));
		$query = $this->db->get('series_to_platforms');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['ott_platform_id'];
		}
		return $ids;
	}

	public function delete_platforms_by_series($series_id){
		$this->db->delete('series_to_platforms', array('series_id' =>$series_id));
	}
}