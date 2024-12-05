<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Songs_m extends MY_Model {

	protected $_table_name = 'songs';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'album_id' => array(
			'field' => 'album_id',
			'label' => 'Album ID',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => 'required|trim'
		),
		'server_url_id' => array(
			'field' => 'server_url_id',
			'label' => 'Server Url',
			'rules' => ''
		),
		'token_id' => array(
			'field' => 'token_id',
			'label' => 'Tokenize',
			'rules' => ''
		),
		'position' => array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => ''
		),
		'has_drm' => array(
			'field' => 'has_drm',
			'label' => 'Has DRM',
			'rules' => ''
		),
		'secure_stream' => array(
			'field' => 'secure_stream',
			'label' => 'Secure Stream',
			'rules' => ''
		)	
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function join($join_table_name,$foreign_key){
			$this->db->select('a.*,j.name album_name');
			$this->db->from($this->_table_name.' as a');
			$table_join = "a.$foreign_key = j.id"; 
			$this->db->join($join_table_name.' as j', $table_join);
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result_array(); 

/*
			$sql="SELECT s.*, b.name album_name 
				  FROM songs s 
				  JOIN albums b ON
			      s.album_id = b.id";
			$query = $this->db->query($sql);
			//echo $this->db->last_query();
			return $query->result_array();*/
	}

	public function get_tokens(){
		$query = $this->db->get('token');
		return $query->result();
	}
}

/* End of file Songs_m.php */
/* Location: ./application/models/Songs_m.php */