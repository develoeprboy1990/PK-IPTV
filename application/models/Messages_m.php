<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_m extends MY_Model {
	protected $_table_name = 'messages';
	public $rules = array(
		'subject' => array(
			'field' => 'subject',
			'label' => 'Subject',
			'rules' => 'required|trim'
		),
		// 'body' => array(
		// 	'field' => 'body',
		// 	'label' => 'Message Body',
		// 	'rules' => 'required|trim'
		// )
	);
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	
	public function getMessages($user_id=""){
		$param="";
		if($user_id!="")
			$param =" WHERE customer_id= '$user_id'";
		$sql="SELECT *
			  FROM messages";
		$sql.=$param;

		$query=$this->db->query($sql);
		return $query->result_array();
	} 


	public function getUserLogs($user_id=""){
		$param="";
		if($user_id!="")
			$param =" WHERE l.user_id= '$user_id'";
		$sql="SELECT l.*, u.username,u.last_login FROM logs l
			  JOIN users u on l.user_id=u.id";
		$sql.=$param;

		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function getDebugLogs($user_id=""){
		$param="";
		if($user_id!="")
			$param =" WHERE l.user_id= '$user_id'";
		$sql="SELECT l.*, c.username FROM debug_logs l
			  LEFT JOIN customers c on l.user_id=c.id";
		$sql.=$param;

		$query=$this->db->query($sql);
		return $query->result_array();
	}
}

/* End of file Logs_m.php */
/* Location: ./application/models/Logs_m.php */