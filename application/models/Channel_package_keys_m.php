<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel_package_keys_m extends MY_Model {

	protected $_table_name = 'channel_package_keys';
	public $rules = array(
		'prefix_code' => array(
			'field' => 'prefix_code',
			'label' => 'Prefix Code',
			'rules' => 'required|trim'
		),
		'package_id' => array(
			'field' => 'package_id',
			'label' => 'Package ID',
			'rules' => 'required|trim'
		),
		'group_name' => array(
			'field' => 'group_name',
			'label' => 'Group Name',
			'rules' => 'required|trim'
		),
		'length' => array(
			'field' => 'length',
			'label' => 'Length',
			'rules' => 'required|trim'
		),
		'quantity' => array(
			'field' => 'quantity',
			'label' => 'Quantity',
			'rules' => 'required|trim'
		),
		'length_months' => array(
			'field' => 'length_months',
			'label' => 'Length Months',
			'rules' => 'required|trim'
		),
		'monthly_price' => array(
			'field' => 'monthly_price',
			'label' => 'Monthly Price',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getKeys(){
		$sql="Select c.*, cp.name package_name FROM channel_package_keys c
			  JOIN channel_package cp on 
			  c.package_id= cp.id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
}

/* End of file Subscription_renewal_keys_m.php */
/* Location: ./application/models/Subscription_renewal_keys_m.php */