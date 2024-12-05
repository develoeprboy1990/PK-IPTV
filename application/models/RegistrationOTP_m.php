<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrationOTP_m extends MY_Model {
	protected $_table_name = 'registration_otp';
	
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_page($page_name){
		$this->db->where(array('slug'=>$page_name));
		$query = $this->db->get('email_templates');
		return $query->row();
	}
	
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
	
	public function update($table,$data,$where){
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
		$result = $this->db->query($sql);
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	public function selectdatarow($where, $table){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="SELECT * FROM ".$table." WHERE ".rtrim($where_statement,' AND ');
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}

/* End of file Email_templates_m.php */
/* Location: ./application/models/Email_templates_m.php */