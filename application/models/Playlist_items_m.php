<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist_items_m extends MY_Model {
	protected $_table_name = 'playlist_items';
	public $rules = array(
		'playlist_id' => array(
			'field' => 'playlist_id',
			'label' => 'Playlist ID',
			'rules' => 'required|trim'
		),
		'playlist_content_id' => array(
			'field' => 'playlist_content_id',
			'label' => 'Playlist Content',
			'rules' => 'required|trim'
		),
		'position' => array(
			'field' => 'position',
			'label' => 'Position',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getPlayListItems($playlist_id){

		$sql="SELECT p.*,pi.id playlist_item_id, pi.start_time item_start_time, pi.end_time item_end_time, pi.position, pci.name content_name,pci.url content_url 
		      FROM playlists p
		      JOIN playlist_items pi on p.id=pi.playlist_id 
		      JOIN playlist_content_items pci on pci.id=pi.playlist_content_id
		      WHERE p.id=?";
		$query=$this->db->query($sql,$playlist_id);

		return $query->result();
	}
}

/* End of file Playlist_items_m.php */
/* Location: ./application/models/Playlist_items_m.php */