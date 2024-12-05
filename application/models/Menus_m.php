<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_m extends MY_Model {

	protected $_table_name = 'iptv_menus';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Menu Name',
			'rules' => 'required|trim'
		),
		'type' => array(
			'field' => 'type',
			'label' => 'Type',
			'rules' => ''
		),
		'is_default' => array(
			'field' => 'is_default',
			'label' => 'Is Default',
			'rules' => ''
		),
		'is_module' => array(
			'field' => 'is_module',
			'label' => 'Is Module',
			'rules' => ''
		),
		'module_name' => array(
			'field' => 'module_name',
			'label' => 'Module Name',
			'rules' => ''
		),
		'is_app' => array(
			'field' => 'is_app',
			'label' => 'Is App',
			'rules' => ''
		),
		'position' => array(
			'field' => 'name',
			'label' => 'Menu Name',
			'rules' => ''
		),
		'active' => array(
			'field' => 'active',
			'label' => 'Status',
			'rules' => ''
		)				
	);
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function delete_packages_by_menu($menu_id){
		$this->db->delete('iptv_menu_package_item', array('menu_id' =>$menu_id));
	}

	public function get_packages_by_menu($menu_id){
		$this->db->select('menu_package_id');
		$this->db->where(array('menu_id'=>$menu_id));
		$query = $this->db->get('iptv_menu_package_item');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['menu_package_id'];
		}
		return $ids;
	}
}

/* End of file Menus_m.php */
/* Location: ./application/models/Menus_m.php */