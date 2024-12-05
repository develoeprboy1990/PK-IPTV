<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_items_urls_m extends MY_Model {
	protected $_table_name = 'server_items_urls';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	
	public function getUrls($server_item_id){
		$this->db->where(array('server_item_id'=>$server_item_id));
		$query = $this->db->get('server_items_urls');
		return $query->result();
	}

	public function getServerItems(){
		$query = $this->db->get('server_items');
		return $query->result();
	}

	public function getLocationInfo($location_id){
		$this->db->where(array('id'=>$location_id));
		$query = $this->db->get('server_locations');
		return $query->row();
	}

	public function getLocationsItems($location_id){
		$this->db->where(array('server_id'=>$location_id));
		$query = $this->db->get('server_location_items');
		return $query->result();
	}

	public function insertItems($server_id){
		$items= array('music','catchup','movie','app','channel','serie');
		foreach ($items as $item) {
			$data=array('server_id'=>$server_id,
					    'name'=>$item);
			$this->db->insert('server_location_items',$data);
		}
	}

	public function deleteItems($server_id){
		$this->db->delete('server_location_items', array('server_id' => $server_id));
	}
}

/* End of file Server_items_urls_m.php */
/* Location: ./application/models/Server_items_urls_m.php */