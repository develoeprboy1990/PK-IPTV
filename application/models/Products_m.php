<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_m extends MY_Model {
	protected $_table_name = 'products';
	public $rules = array(
		'name' => array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|trim'
		),
		'image' => array(
			'field' => 'image',
			'label' => 'Image',
			'rules' => ''
		),
		'enable_geo_location' => array(
			'field' => 'enable_geo_location',
			'label' => 'Enable Geo Location',
			'rules' => ''
		),
		'publish_start' => array(
			'field' => 'publish_start',
			'label' => 'Publish Start',
			'rules' => 'required|trim'
		),
		'publish_end' => array(
			'field' => 'publish_end',
			'label' => 'Publish End',
			'rules' => 'required|trim'
		),
		'service_id' => array(
			'field' => 'service_id',
			'label' => 'Service ID',
			'rules' => ''
		),
		'news_group_id' => array(
			'field' => 'news_group_id',
			'label' => 'News Group ID',
			'rules' => ''
		),
		'app_package_id' => array(
			'field' => 'app_package_id',
			'label' => 'App Package ID',
			'rules' => 'required|trim'
		),
		'server_id' => array(
			'field' => 'server_id',
			'label' => 'Server ID',
			'rules' => 'required|trim'
		),
		'gui_setting_id' => array(
			'field' => 'gui_setting_id',
			'label' => 'GUI Setting ID',
			'rules' => ''
		),
		'plan_name' => array(
			'field' => 'plan_name',
			'label' => 'Plan Name',
			'rules' => 'required|trim'
		),
		'subscription_length' => array(
			'field' => 'subscription_length',
			'label' => 'Subscription Length',
			'rules' => 'required|trim'
		),
		'subscription_days_or_month' => array(
			'field' => 'subscription_days_or_month',
			'label' => 'Subscription Days or Months',
			'rules' => 'required|trim'
		),
		'customer_can_change_plan' => array(
			'field' => 'customer_can_change_plan',
			'label' => 'Customer Can Change Plan',
			'rules' => 'required|trim'
		),
		/*'product_group' => array(
			'field' => 'product_group',
			'label' => 'Product Group',
			'rules' => 'required|trim'
		),*/
		
		'price' => array(
			'field' => 'price',
			'label' => 'Price',
			'rules' => 'required|trim'
		),
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_packages_by_product($id){
		$this->db->select('package_id');
		$this->db->where(array('product_id'=>$id));
		$query = $this->db->get('product_to_packages');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['package_id'];
		}
		return $ids;
	}

	public function delete_packages_by_product($id){
		$this->db->delete('product_to_packages', array('product_id' =>$id));
	}

	public function get_app_packages_by_product($id){
		$this->db->select('app_package_id');
		$this->db->where(array('product_id'=>$id));
		$query = $this->db->get('product_to_app_packages');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['app_package_id'];
		}
		return $ids;
	}

	public function delete_app_packages_by_product($id){
		$this->db->delete('product_to_app_packages', array('product_id' =>$id));
	}

	public function get_stores_by_product($id){
		$this->db->select('vod_store_id');
		$this->db->where(array('product_id'=>$id));
		$query = $this->db->get('product_to_vod_stores');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['vod_store_id'];
		}
		return $ids;
	}

	public function get_series_stores_by_product($id){
		$this->db->select('series_store_id');
		$this->db->where(array('product_id'=>$id));
		$query = $this->db->get('product_to_series_stores');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['series_store_id'];
		}
		return $ids;
	}

	public function delete_stores_by_product($id){
		$this->db->delete('product_to_vod_stores', array('product_id' =>$id));
	}

	public function delete_series_stores_by_product($id){
		$this->db->delete('product_to_series_stores', array('product_id' =>$id));
	}

	public function get_devices_by_product($id){
		$this->db->select('device_id');
		$this->db->where(array('product_id'=>$id));
		$query = $this->db->get('product_to_devices');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['device_id'];
		}
		return $ids;
	}

	public function delete_devices_by_product($id){
		$this->db->delete('product_to_devices', array('product_id' =>$id));
	}

	public function get_countries_by_product($id){
		$this->db->select('country_id');
		$this->db->where(array('product_id'=>$id));
		$query = $this->db->get('product_to_countries');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['country_id'];
		}
		return $ids;
	}

	public function delete_countries_by_product($id){
		$this->db->delete('product_to_countries', array('product_id' =>$id));
	} 

	public function get_product_by_user($user_id){
		$sql="SELECT * FROM products p
		      JOIN customers c on p.id=c.product_id
		      WHERE c.id=".$user_id;
			 // echo $sql;
		$query=$this->db->query($sql);
		return $query->row();
	}
	
	
	public function get_all_products(){
		$sql="SELECT * FROM products";
			 // echo $sql;
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_products_byid($id){
		$sql="SELECT * FROM products where id='".$id."'";
			 // echo $sql;
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_products_bygui($gui_setting_id){
		$sql="SELECT * FROM products where gui_setting_id='".$gui_setting_id."'";
			 // echo $sql;
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
}

/* End of file Products_m.php */
/* Location: ./application/models/Products_m.php */