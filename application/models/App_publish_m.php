<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_publish_m extends MY_Model {

	protected $_table_name = 'app_publish';
	public $rules = array(
		'type' => array(
			'field' => 'type',
			'label' => 'Type',
			'rules' => 'required|trim'
		),
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		'action' => array(
			'field' => 'action',
			'label' => 'Action',
			'rules' => 'required|trim'
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'required|trim'
		),
		'date' => array(
			'field' => 'date',
			'label' => 'Date',
			'rules' => 'required|trim'
		),
		'version_number' => array(
			'field' => 'version_number',
			'label' => 'Version Number',
			'rules' => 'required|trim'
		),
		'package_name' => array(
			'field' => 'package_name',
			'label' => 'Package Name',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'URL',
			'rules' => 'required|trim'
		),
		 'remarks' => array(
        'field' => 'remarks',
        'label' => 'Remarks',
        'rules' => 'trim'  // Making it optional
    	),
		'beta_type' => array(
        'field' => 'beta_type',
        'label' => 'Beta Type',
        'rules' => 'trim'
    	)
	);
	
	public $edit_rules = array(
		'type' => array(
			'field' => 'type',
			'label' => 'Type',
			'rules' => 'required|trim'
		),
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		'action' => array(
			'field' => 'action',
			'label' => 'Action',
			'rules' => 'required|trim'
		),
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'required|trim'
		),
		'date' => array(
			'field' => 'date',
			'label' => 'Date',
			'rules' => 'required|trim'
		),
		'version_number' => array(
			'field' => 'version_number',
			'label' => 'Version Number',
			'rules' => 'required|trim'
		),
		'package_name' => array(
			'field' => 'package_name',
			'label' => 'Package Name',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'URL',
			'rules' => 'required|trim'
		),
		'remarks' => array(
        'field' => 'remarks',
        'label' => 'Remarks',
        'rules' => 'trim'  // Making it optional
    	),
    	'beta_type' => array(
        'field' => 'beta_type',
        'label' => 'Beta Type',
        'rules' => 'trim'
    	)
	);
	

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_AppPublish($id='',$type){
		$sql = "Select * FROM app_publish where type = '".$type."' ";
		
		if($id!='')
		$sql .="AND  id = '".$id."' ";

		$sql .=" Order by id DESC";
		//echo $sql.'<br>';

		$query= $this->db->query($sql);
		return $query->result_array();
	}

	public function update_app_publish($data,$where,$table){
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

	public function getActiveRecord($type) {
	    $this->db->where('type', $type);
	    $this->db->where('status', 1);
	    $query = $this->db->get('app_publish', 1);
	    return $query->row();
	}
}

/* End of file App_publish_m.php */
/* Location: ./application/models/App_publish_m.php */