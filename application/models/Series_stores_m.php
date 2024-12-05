<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_stores_m extends MY_Model {

	protected $_table_name = 'series_store';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Store Name',
			'rules' => 'required|trim'
		),
		'position' => array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => 'required|numeric|trim'
		),

		'childlock' => array(
			'field' => 'childlock',
			'label' => 'Child Lock',
			'rules' => ''
		),

		'active' => array(
			'field' => 'active',
			'label' => 'Status',
			'rules' => ''
		),

	);

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_parent_store(){
		$this->db->select('name, id');
		$this->db->where(array('parent_id'=>0));
		$query = $this->db->get('series_store');
		return $query->result();
	}

	public function get_store_info($id){
		$this->db->select('*');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('series_store');
		return $query->row();
	}
   
	public function delete_child($id){
		$this->db->delete('series_store', array('parent_id' =>$id));
	}
	public function count_sub_stores($parent_store_id){
		//$sql="Select count(id) as sub_store from movie_store where parent_id='parent_store_id'";
		$sql="Select id from series_store where parent_id='$parent_store_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function check_if_parent($id){
		$sql="Select parent_id from series_store where id='$id'";
		$query=$this->db->query($sql);
		$data=$query->row();
		return $data->parent_id;
			
	}

	function fetch_sub_stores($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('series_store');
    	$output = '<option value="">No Sub Store Avaible</option>';
		  
	  	if($query->num_rows()>0){
	  	  $output = '<option value="">Select Sub Stores</option>';
		  foreach($query->result() as $row)
		  {
		   	$output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
		  }
		}
		return $output;
	}

	public function getSeriesStore(){
		$sql="SELECT ss.* ,l.name language_name 
			 FROM series_store ss 
		     LEFT JOIN languages l on l.id=ss.language_id where ss.parent_id = 0";	 
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	
}

/* End of file Series_stores_m.php */
/* Location: ./application/models/Series_stores_m.php */