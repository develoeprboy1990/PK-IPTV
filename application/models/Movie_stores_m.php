<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_stores_m extends MY_Model {

	protected $_table_name = 'movie_store';
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
		'language_id' => array(
			'field' => 'language_id',
			'label' => 'Language',
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
		$query = $this->db->get('movie_store');
		return $query->result();
	}

	public function get_store_info($id){
		$this->db->select('*');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('movie_store');
		return $query->row();
	}

	public function count_sub_stores($parent_store_id){
		//$sql="Select count(id) as sub_store from movie_store where parent_id='parent_store_id'";
		$sql="Select id from movie_store where parent_id='$parent_store_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function check_if_parent($id){
		$sql="Select parent_id from movie_store where id='$id'";
		$query=$this->db->query($sql);
		
		if($query->num_rows()>0)
			return $query->row()->parent_id;
		else
			return 0;
	}
public function check_if_parent_mul($id){
		$where = explode(',',$id);
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.="id='". $value."' OR ";
			 // $set_statement.=$key ."='". $value."',";
		}
		$sql="Select parent_id from movie_store WHERE ".rtrim($where_statement,' OR ');
		//echo $sql;exit;
		$query=$this->db->query($sql);
		/*return $query->result_array();*/
		if($query->num_rows()>0)
			return $query->row()->parent_id;
		else
			return 0;
	}
	
	function fetch_all_sub_stores(){	
			$this->db->where('active', '1');
			$this->db->order_by('name', 'ASC');
			$query = $this->db->get('movie_store');
			return $query->result_array();
	}
	
	function fetch_sub_stores($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('movie_store');
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

	function fetch_sub_stores_checkbox($parent_id){
		$this->db->where('parent_id', $parent_id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('movie_store');
    	//$output = '<option value="">No Sub Store Avaible</option>';
		 //$output = 'No Sub Store Avaible'; 
		  $output = 'blank'; 
	  	if($query->num_rows()>0){
	  	 // $output = '<option value="">Select Sub Stores</option>';
		 $output = '';
		  foreach($query->result() as $row)
		  {
		   //	$output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
			$output .= '<input type="checkbox" onclick="checksubstorebm('.$row->id.')" name="sub_store[]" value="'.$row->id.'" style="margin-right: 5px !important;">'.$row->name.'<br />';
		  }
		}
		return $output;
	}
	
	function fetch_genres($store_id)
	{
		//$this->db->where('store_id', $store_id);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('movie_genre');
    	$output = '';
	  	if($query->num_rows()>0){
		  foreach($query->result() as $row)
		  {
		   	$output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
		  }
		}
		return $output;
	}
	
	
	public function get_genres_all($store_id){
		//$this->db->where(array('store_id'=>$store_id));
		$query = $this->db->get('movie_genre');
		return $query->result();
	}
	
	public function get_genres_select($store_id){
		$this->db->select('id');
		$this->db->where(array('store_id'=>$store_id));
		$query = $this->db->get('movie_genre');
		$ids=array();
		foreach($query->result_array() as $row){
			array_push($ids,$row['id']);
			//$ids[]=$row['id'];
		}
		return $ids;
	}

	public function getMoviesStore($id){
		$sql="SELECT ms.* ,l.name language_name 
			 FROM movie_store ms 
		     LEFT JOIN languages l on l.id=ms.language_id where ms.parent_id = '".$id."'";	 
		$query = $this->db->query($sql);

		return $query->result_array();
	}
}

/* End of file Movie_stores_m.php */
/* Location: ./application/models/Movie_stores_m.php */