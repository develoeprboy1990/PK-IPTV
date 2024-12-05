<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_renewal_keys_m extends MY_Model {

	protected $_table_name = 'subscription_renewal_keys';
	public $rules = array(
		'prefix_code' => array(
			'field' => 'prefix_code',
			'label' => 'Prefix Code',
			'rules' => 'required|trim'
		),
		'product_id' => array(
			'field' => 'product_id',
			'label' => 'Product ID',
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
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getKeys(){
		/*$sql="Select s.*, p.name product_name FROM subscription_renewal_keys s
			  JOIN products p on 
			  s.product_id= p.id";*/
		$sql="Select s.*, p.name product_name FROM subscription_renewal_keys s
			  JOIN products p on 
			  s.product_id= p.id where s.reseller_id='0' AND key_type='subscribe'";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getKeysResellers(){
		/*$sql="Select s.*, p.name product_name FROM subscription_renewal_keys s
			  JOIN products p on 
			  s.product_id= p.id";*/
		$sql="Select s.*, r.name, r.email , p.name product_name FROM subscription_renewal_keys s
			  join reseller r on r.id=s.reseller_id
			  JOIN products p on 
			  s.product_id= p.id where s.reseller_id > '0'";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getKeysActivation(){
		$sql="Select s.*, p.name product_name FROM subscription_renewal_keys s
			  JOIN products p on 
			   s.product_id= p.id where s.reseller_id = '0' AND key_type='activation'";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getKeysMaster(){
		$sql="Select s.*, p.name product_name FROM subscription_renewal_keys s
			  JOIN products p on 
			   s.product_id= p.id where s.reseller_id = '0' AND key_type='master'";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	//
}

/* End of file Subscription_renewal_keys_m.php */
/* Location: ./application/models/Subscription_renewal_keys_m.php */