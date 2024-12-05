<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activation_keys_m extends MY_Model {

	protected $_table_name = 'activation_keys';
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
		/*'device_id' => array(
			'field' => 'device_id',
			'label' => 'Device ID',
			'rules' => 'required|trim'
		),*/
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
		$sql="Select a.*, p.name product_name FROM activation_keys a
			  JOIN products p on 
			  a.product_id= p.id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}

	public function getKeyInfo($key){
		$sql="Select a.*,p.id product_id, p.name product_name,p.enable_geo_location 
		      FROM activation_keys a
			  JOIN products p on 
			  a.product_id= p.id 
			  WHERE keycode='".$key."'";
			 // echo $sql;exit;
		$query= $this->db->query($sql);
		return $query->row();
		//return $query->result_array();
	}
	
	public function getActivationKeyInfo($key){
		$sql="Select a.*,p.id product_id, p.name product_name,p.enable_geo_location 
		      FROM activation_keys a
			  JOIN products p on 
			  a.product_id= p.id 
			  WHERE keycode='".$key."'";
			 // echo $sql;exit;
		$query= $this->db->query($sql);
		//return $query->row();
		return $query->result_array();
	}
	
	public function getKeyInfoDetails($where, $table){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="Select * FROM ".$table." WHERE  ".rtrim($where_statement,' AND ');
		$query= $this->db->query($sql);
		return $query->row();
	}
	
	public function getKeyInfoID($id){
		$sql="Select * FROM activation_keys WHERE id='".$id."'";
		$query= $this->db->query($sql);
		return $query->row();
	}
	
	public function update_key($data,$where, $table){
	//global $db;
    $set_statement="";
    foreach ($data as $key => $value) {
    	 $set_statement.=$key ."='". $value."',";
    }
	$where_statement="";
	foreach ($where as $key => $value) {
    	 $where_statement.=$key ."='". $value."' AND ";
    }

    $sql = "UPDATE ".$table." SET ".rtrim($set_statement,',')." WHERE ".rtrim($where_statement,' AND ');
	//echo $sql;
	$result = $this->db->query($sql);
	//echo $result;exit;
	if($result){
    	return true;
	} else {
    	return false;
	}
}

}

/* End of file Activation_keys_m.php */
/* Location: ./application/models/Activation_keys_m.php */