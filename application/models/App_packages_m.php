<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_packages_m extends MY_Model {

	protected $_table_name = 'app_packages';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Package Name',
			'rules' => 'required|trim'
		),
		'price' => array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => 'required|numeric|trim'
		)	
	); 
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_packages(){
		$this->db->select('c.*,d.name as device_name');
        $this->db->from('channel_package as c');
        $this->db->join('sys_channel_packet_devices as d', 'c.device_type = d.id');
        $query = $this->db->get();
        return  $query->result_array();
	}

	public function get_devices(){
		$query = $this->db->get('sys_channel_packet_devices');
		return $query->result();
	}

	
	public function delete_package_categories($package_id){
		$this->db->delete('app_package_to_categories', array('app_package_id' =>$package_id));
	}

	public function get_categories_by_package($id){
		$this->db->select('app_category_id');
		$this->db->where(array('app_package_id'=>$id));
		$query = $this->db->get('app_package_to_categories');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['app_category_id'];
		}
		return $ids;
	}
}

/* End of file Channel_package_m.php */
/* Location: ./application/models/Channel_package_m.php */