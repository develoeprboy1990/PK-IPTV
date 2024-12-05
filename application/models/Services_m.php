<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_m extends MY_Model {
	protected $_table_name = 'services';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'price' => array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => ''
		),
		'vat' => array(
			'field' => 'vat',
			'label' => 'VAT',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_menus_by_service($id){
		$this->db->select('menu_id');
		$this->db->where(array('service_id'=>$id));
		$query = $this->db->get('services_menu_items');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['menu_id'];
		}
		return $ids;
	}

	public function delete_menus_by_service($id){
		$this->db->delete('services_menu_items', array('service_id' =>$id));
	}
}

/* End of file Services_m.php */
/* Location: ./application/models/Services_m.php */