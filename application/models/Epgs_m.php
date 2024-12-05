<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epgs_m extends MY_Model {
	protected $_table_name = 'epgs';
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
		'epg_offset' => array(
			'field' => 'epg_offset',
			'label' => 'Epg Offset',
			'rules' => 'required|trim'
		)
		
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getValue($slug){
		$this->db->select('value');
		$this->db->where(array('slug'=>$slug));
		$query = $this->db->get('settings');
		$data=$query->row();
		return $data->value;
	}
	
	public function getValueWhere($data_where){
		$this->db->select('*');
		$this->db->where($data_where);
		$query = $this->db->get('epgs');
		//$data=$query->row();
		$data = $query->result();
		//print_r($data);
		return $data;
	}

	public function get_settings_by_type($id){
		$this->db->select('*');
		$this->db->where(array('type'=>$id));
		$query = $this->db->get('settings');
		return $query->result();
	}
	
	public function get_epgs(){
		$this->db->select('*');
		$this->db->where(array('url_type'=>'2', 'epg_status' => '1'));
		$query = $this->db->get('epgs');
		return $query->result_array();
	}


}

/* End of file Settings_m.php */
/* Location: ./application/models/Settings_m.php */