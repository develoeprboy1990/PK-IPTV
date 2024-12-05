<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_interface_m extends MY_Model {
	protected $_table_name = 'reseller';
	/*public $rules = array(
		'setting_name' => array(
			'field' => 'setting_name',
			'label' => 'Setting Name',
			'rules' => 'required|trim'
		),
		'version_id' => array(
			'field' => 'version_id',
			'label' => 'Version',
			'rules' => 'required|trim'
		),
		'youtube_api_key' => array(
			'field' => 'youtube_api_key',
			'label' => 'Youtube Api Key',
			'rules' => 'required|trim'
		),
		'flusonic_base_url' => array(
			'field' => 'flusonic_base_url',
			'label' => 'Flusonic Base Url',
			'rules' => ''
		),
		'product_has_epg' => array(
			'field' => 'product_has_epg',
			'label' => 'Product Has EPG',
			'rules' => ''
		),
		'gui_start_url' => array(
			'field' => 'gui_start_url',
			'label' => 'GUI Start Url',
			'rules' => ''
		),
		'base_start_url' => array(
			'field' => 'base_start_url',
			'label' => 'Base Start Url',
			'rules' => ''
		),
		'ui' => array(
			'field' => 'ui',
			'label' => 'UI',
			'rules' => ''
		),
		'brandname' => array(
			'field' => 'brandname',
			'label' => 'Brand Name',
			'rules' => ''
		),
		'contactinformation' => array(
			'field' => 'contactinformation',
			'label' => 'Contact Information',
			'rules' => ''
		),
		'dir' => array(
			'field' => 'dir',
			'label' => 'DIR',
			'rules' => ''
		),
		'show_catchuptv' => array(
			'field' => 'show_catchuptv',
			'label' => 'Show Catchuptv',
			'rules' => ''
		),
		'show_clock' => array(
			'field' => 'show_clock',
			'label' => 'Show Clock',
			'rules' => ''
		),
		'show_fontsize' => array(
			'field' => 'show_fontsize',
			'label' => 'Show Fontsize',
			'rules' => ''
		),
		'show_hint' => array(
			'field' => 'show_hint',
			'label' => 'Show Hint',
			'rules' => ''
		),
		'show_languages' => array(
			'field' => 'show_languages',
			'label' => 'Show Languages',
			'rules' => ''
		),
		'show_quickmenu' => array(
			'field' => 'show_quickmenu',
			'label' => 'Show Quickmenu',
			'rules' => ''
		),
		'show_screensaver' => array(
			'field' => 'show_screensaver',
			'label' => 'Show Screensaver',
			'rules' => ''
		),
		'show_search' => array(
			'field' => 'show_search',
			'label' => 'Show Search',
			'rules' => ''
		),
		'show_speedtest' => array(
			'field' => 'show_speedtest',
			'label' => 'Show Speedtest',
			'rules' => ''
		),
		'enable_hint' => array(
			'field' => 'enable_hint',
			'label' => 'Enable Hint',
			'rules' => ''
		),
		'enable_kids_mode' => array(
			'field' => 'enable_kids_mode',
			'label' => 'Enable Kids Mode',
			'rules' => ''
		),
		'direct_tv_mode' => array(
			'field' => 'direct_tv_mode',
			'label' => 'Direct TV Mode',
			'rules' => ''
		),
		'max_concurrent_devices' => array(
			'field' => 'max_concurrent_devices',
			'label' => 'Max Concurrent Devices',
			'rules' => ''
		),
		'channel_preview' => array(
			'field' => 'channel_preview',
			'label' => 'Channel Preview',
			'rules' => ''
		),
		'epg_preview' => array(
			'field' => 'epg_preview',
			'label' => 'Epg Preview',
			'rules' => ''
		),
		'show_weather' => array(
			'field' => 'show_weather',
			'label' => 'Show Weather',
			'rules' => ''
		),
		'max_days_interactivetv' => array(
			'field' => 'max_days_interactivetv',
			'label' => 'Max Days Interactivetv',
			'rules' => ''
		),
		'sleep_mode' => array(
			'field' => 'sleep_mode',
			'label' => 'Sleep Mode',
			'rules' => ''
		),
		'payment_type' => array(
			'field' => 'payment_type',
			'label' => 'Payment Type',
			'rules' => ''
		),
		'storage_package' => array(
			'field' => 'storage_package',
			'label' => 'Storage Package',
			'rules' => ''
		),
		'qrcode' => array(
			'field' => 'qrcode',
			'label' => 'QR Code',
			'rules' => ''
		),
		'text' => array(
			'field' => 'text',
			'label' => 'Text',
			'rules' => ''
		),
		'selection_color' => array(
			'field' => 'selection_color',
			'label' => 'Selection Color',
			'rules' => ''
		)
	);*/
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getAllRows($table,$order_by){
		$sql="Select * FROM ".$table.' ORDER BY '.$order_by.' DESC';;
		$query = $this->db->query($sql);
		$row_array = array();
		foreach($query->result_array() as $row){
			$row_array[] = $row;
		}		
		return $row_array;
	}
	public function insertRow($data, $table){
		$fields  = implode(',', array_keys($data));
		$values  = implode("','", array_values($data));
		$values = "'".$values."'";
		$sql = "INSERT INTO ".$table."(".$fields.") Values "."(".$values.")";
		$result = $this->db->query($sql);
		if($result){
			//return true;
			 return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function selectdatarow($where, $table){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		$sql="SELECT * FROM ".$table." WHERE ".rtrim($where_statement,' AND ') .' ORDER BY id DESC';
		//echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	 public function update_keycode($data,$where,$table){
		$set_statement="";
		foreach ($data as $key => $value) {
			 $set_statement.=$key ."='". $value."',";
		}
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
	
		$sql = "UPDATE ".$table." SET ".rtrim($set_statement,',')." WHERE ".rtrim($where_statement,' AND ');
		$result = $this->db->query($sql);
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	public function deletedatarow($where, $table){
		$where_statement="";
		foreach ($where as $key => $value) {
			 $where_statement.=$key ."='". $value."' AND ";
		}
		
		$sql= "DELETE FROM ".$table." WHERE ".rtrim($where_statement,' AND ');
		
		$query = $this->db->query($sql);
		return $query;
	}
	
}

/* End of file Services_m.php */
/* Location: ./application/models/Services_m.php */