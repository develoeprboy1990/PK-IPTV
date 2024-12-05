<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messagedevice_m extends MY_Model {

	protected $_table_name = 'messagedevice';
	public $rules = array(
		'title' => array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|trim'
		),
		/*'image_msg' => array(
			'field' => 'image_msg',
			'label' => 'Image',
			'rules' => ''
		),*/
		'description' => array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => ''
		),
		'start_date' => array(
			'field' => 'start_date',
			'label' => 'Start Date',
			'rules' => ''
		),
		'end_date' => array(
			'field' => 'end_date',
			'label' => 'End Date',
			'rules' => ''
		)
	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getAllRowsByDate($json_date){
		$where_statement=" WHERE end_date >= '".$json_date."' AND start_date <='".$json_date."'" ;
		
		$sql="Select * FROM ".$this->_table_name.$where_statement;
		//echo $sql;
		$query = $this->db->query($sql);
		$row_array = array();
		foreach($query->result_array() as $row){
			$row_array[] = $row;
		}		
		return $row_array;
	}
	
	public function getMaxMinDate($max_min){
		if($max_min == 'maxd'){	
			$sql="SELECT MAX(end_date) AS max_date FROM ".$this->_table_name;
		}elseif($max_min == 'mind'){	
			$today = date("Y-m-d");
			//$sql="SELECT MIN(start_date) AS min_date FROM ".$this->_table_name." WHERE start_date >= '".$today."'";
			$sql="SELECT MIN(start_date) AS min_date FROM ".$this->_table_name;
		}
		//echo $sql;
		$query = $this->db->query($sql);	
		return $query->result_array();
	}

}

/* End of file Music_categories.php */
/* Location: ./application/models/Music_categories.php */