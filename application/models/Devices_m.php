<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices_m extends MY_Model {
	protected $_table_name = 'devices';
	public $rules = array(
		'model_name' => array(
			'field' => 'model_name',
			'label' => 'Model Name',
			'rules' => 'required|trim'
		),
		'model_type' => array(
			'field' => 'model_type',
			'label' => 'model_type',
			'rules' => ''
		),
		'image' => array(
			'field' => 'image',
			'label' => 'Image',
			'rules' => ''
		),
		'price' => array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => ''
		),
		'vat' => array(
			'field' => 'vat',
			'label' => 'VAT',
			'rules' => ''
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'available' => array(
			'field' => 'available',
			'label' => 'Available',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_devices_by_product($product_id){
		$sql="SELECT * FROM devices d
		      JOIN product_to_devices pd on d.id=pd.device_id
		      WHERE pd.product_id=".$product_id;
		$query=$this->db->query($sql);

		/*echo $this->db->last_query();
		exit;*/
		return $query->result();
	}

	public function get_devices_by_customer($id){
		$sql="SELECT * FROM customer_to_devices 
		      WHERE customer_id=".$id;
		$query=$this->db->query($sql);
		return $query->result();
	}

}

/* End of file Devices_m.php */
/* Location: ./application/models/Devices_m.php */