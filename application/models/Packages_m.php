<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages_m extends MY_Model {

	protected $_table_name = 'channel_package';
	public $add_rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Package Name',
			'rules' => 'required|trim'
		),
		'price' => array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => 'required|numeric|trim'
		),
		'vat' => array(
			'field' => 'vat',
			'label' => 'VAT',
			'rules' => 'required|numeric|trim'
		),
		'device_type' => array(
			'field' => 'device_type',
			'label' => 'Device Type',
			'rules' => 'required|trim'
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

	public function get_packages(){
		$this->db->select('c.*,d.name as device_name');
        $this->db->from('channel_package as c');
        $this->db->join('sys_channel_packet_devices as d', 'c.device_type = d.id');
        $query = $this->db->get();
       // echo $this->db->last_query();

        return  $query->result_array();
	}

	public function get_devices(){
		$query = $this->db->get('sys_channel_packet_devices');
		return $query->result();
	}

	public function delete_package_channel($package_id){
		$this->db->delete('package_to_channel', array('package_id' =>$package_id));
	}

	public function get_channels_by_package($id){
		$this->db->select('channel_id');
		$this->db->where(array('package_id'=>$id));
		$query = $this->db->get('package_to_channel');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['channel_id'];
		}
		return $ids;
	}

	public function get_packages_by_product($product_id){
		$sql="SELECT * FROM channel_package c
		      JOIN product_to_packages pp on c.id=pp.package_id
		      WHERE pp.product_id=".$product_id;
		$query=$this->db->query($sql);
		return $query->result();
	}

}

/* End of file Channel_package_m.php */
/* Location: ./application/models/Channel_package_m.php */