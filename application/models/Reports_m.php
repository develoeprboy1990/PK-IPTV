<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_m extends MY_Model {
	protected $_table_name = 'analytics_report';

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getAnalytics(){
		$sql="SELECT ar.*,c.first_name,c.last_name FROM analytics_report ar
		      JOIN customer c on c.id=ar.user_id";
		$query=$this->db->query($sql);
		return $query->result();
	}

	public function get_devices_by_product($product_id){
		$sql="SELECT * FROM devices d
		      JOIN product_to_devices pd on d.id=pd.device_id
		      WHERE pd.product_id=".$product_id;
		$query=$this->db->query($sql);

		/*echo $this->db->last_query();
		exit;*/
		return $query->result();
	}

	public function get_devices_by_customer($id){
		$sql="SELECT * FROM customer_to_devices 
		      WHERE customer_id=".$id;
		$query=$this->db->query($sql);
		return $query->result();
	}

}

/* End of file Reports_m.php */
/* Location: ./application/models/Reports_m.php */