<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_packages_m extends MY_Model {

	protected $_table_name = 'iptv_menu_packages';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Menu Name',
			'rules' => 'required|trim'
		),
		'url' => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => ''
		)
	);
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function delete_menus_by_package($package_id){
		$this->db->delete('iptv_menu_package_item', array('menu_package_id' =>$package_id));
	}

	public function get_menus_by_package($package_id){
		$this->db->select('menu_id');
		$this->db->where(array('menu_package_id'=>$package_id));
		$query = $this->db->get('iptv_menu_package_item');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['menu_id'];
		}
		return $ids;
	}
}

/* End of file Menu_packages_m.php */
/* Location: ./application/models/Menu_packages_m.php */