<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_devices_m extends MY_Model {
	protected $_table_name = 'customer_devices';
	public $rules = array(
		'serial' => array(
			'field' => 'serial',
			'label' => 'Serial',
			'rules' => 'required|trim'
		),
		'model_id' => array(
			'field' => 'model_id',
			'label' => 'Model ID',
			'rules' => ''
		),
		'location' => array(
			'field' => 'location',
			'label' => 'Location',
			'rules' => ''
		),
		'status' => array(
			'field' => 'last_name',
			'label' => 'Last Name',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getDevices(){
		$this->db->select('a.*,j.name model');
		$this->db->from($this->_table_name.' as a');
		$table_join = "a.model_id = j.id"; 
		$this->db->join('customer_device_model as j', $table_join);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getModels(){
		$query = $this->db->get('customer_device_model');
		return $query->result();
	}
}

/* End of file Customers_m.php */
/* Location: ./application/models/Customers_m.php */