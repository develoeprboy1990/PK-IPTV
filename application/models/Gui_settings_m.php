<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gui_settings_m extends MY_Model {
	protected $_table_name = 'gui_settings';
	public $rules = array(
		'setting_name' => array(
			'field' => 'setting_name',
			'label' => 'Setting Name',
			'rules' => 'required|trim'
		),
		/*'version_id' => array(
			'field' => 'version_id',
			'label' => 'Version',
			'rules' => 'required|trim'
		),*/
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
		
		'base_start_url' => array(
			'field' => 'base_start_url',
			'label' => 'Base Start Url',
			'rules' => ''
		),
		'tembm_name' => array(
			'field' => 'tembm_name',
			'label' => 'Template Name',
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
		'enable_advertisments' => array(
			'field' => 'enable_advertisments',
			'label' => 'Enable Advertisments',
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
		'text_ui' => array(
			'field' => 'text_ui',
			'label' => 'Text',
			'rules' => ''
		),		
		'primary_color' => array(
			'field' => 'primary_color',
			'label' => 'Primary Color',
			'rules' => ''
		),
      'secondary_color' => array(
			'field' => 'secondary_color',
			'label' => 'Secondary Color',
			'rules' => ''
		),
		'ui_template' => array(
			'field' => 'ui_template',
			'label' => 'ui_template',
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