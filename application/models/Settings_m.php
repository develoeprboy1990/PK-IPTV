<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_m extends MY_Model {
	protected $_table_name = 'settings';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'slug' => array(
			'field' => 'slug',
			'label' => 'Slug',
			'rules' => 'required|trim'
		),
		'type' => array(
			'field' => 'type',
			'label' => 'Type',
			'rules' => 'required|trim'
		),
		'value' => array(
			'field' => 'value',
			'label' => 'Value',
			'rules' => 'required|trim'
		),

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

	public function get_settings_by_type($id){
		$this->db->select('*');
		$this->db->where(array('type'=>$id));
		$query = $this->db->get('settings');
		return $query->result();
	}


}

/* End of file Settings_m.php */
/* Location: ./application/models/Settings_m.php */