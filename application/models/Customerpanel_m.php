<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customerpanel_m extends MY_Model {
	protected $_table_name = 'customers_panel_subscription';
	public function insert($table,$data){
		//global $db;
		$fields  = implode(',', array_keys($data));
		$values  = implode("','", array_values($data));
		$values = "'".$values."'";
		$sql = "INSERT INTO ".$table."(".$fields.") Values "."(".$values.")";
		$result = $this->db->query($sql);
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	public function getKeys(){
		$sql="Select s.*, p.name product_name FROM customers_panel_subscription s
			  JOIN products p on 
			  s.product_id= p.id 
			  where s.active ='1' 
			  ORDER BY s.id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getPlans(){
		$sql="Select s.*, p.name product_name FROM customers_panel_subscription s
			  JOIN products p on 
			  s.product_id= p.id 
			  where s.active ='1' 
			  ORDER BY s.id";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getKeysById($id){
		$sql="Select s.*, p.name product_name FROM customers_panel_subscription s
			  JOIN products p on 
			  s.product_id= p.id 
			  where s.active ='1' AND s.id = '".$id."'";
		$query= $this->db->query($sql);
		$res =  $query->result_array();
		return $res[0];
	}
	
	public function getPlanProductById($id){
		$sql="Select s.*, p.name product_name FROM customers_panel_subscription s
			  JOIN products p on 
			  s.product_id= p.id 
			  where s.active ='1' AND s.product_id = '".$id."'";
		$query= $this->db->query($sql);
		$res =  $query->result_array();
		return $res[0];
	}
	
	public function getPlanById($id){
		$sql="Select * FROM customers_panel_subscription where id='".$id."'";
		$query= $this->db->query($sql);
		$res =  $query->result_array();
		return $res[0];
	}
	
	public function getallWaletKeys(){
		$sql="Select * FROM wallet_moneycode where active='1'";
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getallWaletKeysByKeycode($keycode){
		$sql="Select * FROM wallet_moneycode where active='1' AND key_code='".$keycode."'";
		$query= $this->db->query($sql);
		return $query->result_array();
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
		//echo $sql;exit;
		$result = $this->db->query($sql);
		//echo $result;exit;
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	public function getdataall($table,$where){
		$where_statement = '';
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="Select * FROM ".$table." WHERE ".rtrim($where_statement,' AND ');
		//echo $sql;exit;
		$query= $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getdataallPlans($table){		
		$sql="Select * FROM ".$table;
		$query = $this->db->query($sql);
		$plans = array();
		foreach($query->result_array() as $row){
			$plans['plans_'.$row['id']] = $row;
		}
		//echo '<pre>';
		return $plans;
	}
}