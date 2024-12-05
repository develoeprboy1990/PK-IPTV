<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_locations_m extends MY_Model {
	protected $_table_name = 'server_locations';
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
	
	public function getLocations(){
		$query = $this->db->get('server_locations');
		return $query->result();
	}

	public function getLocationInfo($location_id){
		$this->db->where(array('id'=>$location_id));
		$query = $this->db->get('server_locations');
		return $query->row();
	}

	public function getItems($server_id,$type){
		$this->db->where(array('server_id'=>$server_id,'type'=>$type));
		$query = $this->db->get('server_location_items');
		return $query->result();
	}

	public function getLocationItems($location_id){
		$this->db->where(array('server_id'=>$location_id,'type'=>'location'));
		$query = $this->db->get('server_location_items');
		return $query->result();
	}

	public function getDomainItems($location_id){
		$this->db->where(array('server_id'=>$location_id,'type'=>'location'));
		$query = $this->db->get('server_location_items');
		return $query->result();
	}

	public function insertItems($server_id){
		$item_locations= array('music','catchup','movie','app','channel','serie','product','api','language','base','add');
		$item_domains= array('music','catchup','movie','app','channel','serie');
		foreach ($item_locations as $item) {
			$data=array('server_id'=>$server_id,
					    'name'=>$item.'_location',
					    'type'=>'location');
			$this->db->insert('server_location_items',$data);
		}

		foreach ($item_domains as $item) {
			$data=array('server_id'=>$server_id,
					    'name'=>$item.'_domain',
					    'type'=>'domain');
			$this->db->insert('server_location_items',$data);
		}
	}

	public function deleteItems($server_id){
		$this->db->delete('server_location_items', array('server_id' => $server_id));
	}
}

/* End of file Server_locations_m.php */
/* Location: ./application/models/Server_locations_m.php */