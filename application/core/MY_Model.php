<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_order_by = 'id';	
	protected $_order = '';	
	protected $_timestamps = FALSE;
	public $rules = array();

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	
	public function get( $id = NULL, $single = FALSE ){
		if($id!=NULL){
			$this->db->where(array('id' => $id));
			$method = 'row';
		}
		else if($single == TRUE){
			$method = 'row';
		}
		else{
			$method = 'result_array';
		}		
		$this->db->order_by($this->_order_by,$this->_order);
		return $this->db->get($this->_table_name)->$method();
		// echo $this->db->last_query();
	}

	public function get_by($where, $single = FALSE){
		$this->db->where($where);
		return $this->get(NULL, $single);
	}

	public function save($id = NULL,$data){
		if($id !== NULL){
			$this->db->set($data);
			$this->db->where('id', $id);
			return $this->db->update($this->_table_name);
		}else{
			if(!($this->db->insert($this->_table_name,$data))){
				$error = $this->db->error();
				if($error['code'] == 1062){
					return "Already Exist!";
				}
			}else{
				return $this->db->insert_id();
			}
		}
	}

	public function delete($id){
		try {
	       	$this->db->delete($this->_table_name, array('id' => $id));
	        $db_error = $this->db->error();
	        if (!empty($db_error['message'])) {
	            throw new Exception('Already in use.');
	        }
	        $this->session->set_flashdata('delete_success','Deleted Successfully.');
	        return TRUE;
	    } catch (Exception $e) {
	    	$this->session->set_flashdata('delete_error',$e->getMessage());
	        return FALSE;
	    }
	}


	public function get_join( $id = NULL,$where = array(), $single = FALSE ){


		if($id!=NULL){
			$where = array( $this->_table_name.'.'.'id' => $id);
		}
		$this->load->helper('string');
		$joinsArray = array();
		$fields = '';

		//get main table all fields
			$main_table_fields = $this->db->list_fields($this->_table_name);
			foreach($main_table_fields as $f)
				$fields .= $this->_table_name .'.'. $f . ', ';
		//

		//get data from information schema
			$this->db->select();
			$this->db->from('information_schema.key_column_usage');
			$this->db->where(array('TABLE_NAME' => $this->_table_name));
			$this->db->like('CONSTRAINT_NAME', 'fk', 'after'); 
			$infomation_schema_result = $this->db->get()->result_array();
		//
					
		foreach ($infomation_schema_result as $j) {
			$column_name = $j['COLUMN_NAME'];
			$table_name = $j['TABLE_NAME'];
			$r_table_name = $j['REFERENCED_TABLE_NAME'];
			$table_fields = $this->db->list_fields($r_table_name);
			$r_table_name_alias = random_string('alpha', 8);
			$r_table_name = $j['REFERENCED_TABLE_NAME'] . ' as ' .$r_table_name_alias;
			$r_column_name = $j['REFERENCED_COLUMN_NAME'];

			foreach ($table_fields as $tf) {
				$fields .= $r_table_name_alias . '.' .$tf . ' as ' . $column_name . '_' . $tf . ', ';
			}

			$table_join = "$table_name.$column_name = $r_table_name_alias.$r_column_name";
			$data = array(
				'table'=> $r_table_name,
				'tableJoin'=> $table_join
			);
			array_push($joinsArray,$data);
		}
		if( $id == NULL ){
			$result_set = joins($fields,$this->_table_name,'result',$joinsArray,$where);			
		}else{
			$result_set = joins($fields,$this->_table_name,'row',$joinsArray,$where);
		}
        return $result_set;
	}
}
/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */