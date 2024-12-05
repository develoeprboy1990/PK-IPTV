<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_m extends MY_Model {
	protected $_table_name = 'logs';
	public $rules = array(
		'user_id' => array(
			'field' => 'user_id',
			'label' => 'User ID',
			'rules' => 'required'
		),
		'session_id' => array(
			'field' => 'session_id',
			'label' => 'Session ID',
			'rules' => ''
		),
		'user_identifier' => array(
			'field' => 'user_identifier',
			'label' => 'User Identifier',
			'rules' => ''
		),
		'request_uri' => array(
			'field' => 'request_uri',
			'label' => 'Request Uri',
			'rules' => ''
		),
		'client_ip' => array(
			'field' => 'client_ip',
			'label' => 'Client IP',
			'rules' => ''
		),
		'action' => array(
			'field' => 'action',
			'label' => 'Action',
			'rules' => ''
		),
		'client_user_agent' => array(
			'field' => 'client_user_agent',
			'label' => 'Client User Agent',
			'rules' => ''
		),
		'referer_page' => array(
			'field' => 'referer_page',
			'label' => 'Referer Page',
			'rules' => ''
		),
		'last_login' => array(
			'field' => 'last_login',
			'label' => 'Last Login',
			'rules' => ''
		),
		'last_logout' => array(
			'field' => 'last_logout',
			'label' => 'Last Logout',
			'rules' => ''
		),
		'timestamp'=> array(
			'field' => 'timestamp',
			'label' => 'Date',
			'rules' => ''
		)
	);
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	
	public function getLogs($user_id=""){
		$param="";
		if($user_id!="")
			$param =" WHERE l.user_id= '$user_id'";
		$sql="SELECT l.*, c.username,c.first_name, c.last_name FROM logs l
			  JOIN customers c on l.user_id=c.id";
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

	// Add to Logs_m.php
	public function getMovieLogs($movie_id) {
	    $sql = "SELECT l.*, l.action, l.timestamp, u.username, u.first_name, u.last_name, u.last_login 
	            FROM logs l
	            JOIN users u ON l.user_id = u.id 
	            WHERE l.action LIKE '%movie%' 
	            AND l.action LIKE '%".$movie_id."%'
	            ORDER BY l.timestamp DESC";
	    
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
}

/* End of file Logs_m.php */
/* Location: ./application/models/Logs_m.php */