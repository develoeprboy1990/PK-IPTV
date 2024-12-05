<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlists_m extends MY_Model {
	protected $_table_name = 'playlists';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'start_time' => array(
			'field' => 'start_time',
			'label' => 'Start Time',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getPlaylistItems(){

	}

	public function getPlaylistContentItems(){
		$sql="SELECT * FROM playlist_content_items";
		$query=$this->db->query($sql);
		return $query->result();
	}
}

/* End of file Playlists_m.php */
/* Location: ./application/models/Playlists_m.php */