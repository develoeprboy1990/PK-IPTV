<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channels_m extends MY_Model {

	protected $_table_name = 'channel';
	protected $_order_by = 'channel_number';	
	protected $_order = 'ASC';	
	public $add_rules = array(
		'channel_number' => array(
			'field' => 'channel_number',
			'label' => 'Channel Number',
			'rules' => 'required|trim|callback_channel_check|numeric'
		),
			
		'channel_image_icon' => array(
			'field' => 'channel_image_icon',
			'label' => 'Channel image icon',
			'rules' => '' 
		),
		'channel_epg_name' => array(
			'field' => 'channel_epg_name',
			'label' => 'Channel EPG Name',
			'rules' => ''
		),
		'channel_epg_id' => array(
			'field' => 'channel_epg_id',
			'label' => 'Channel EPG Id',
			'rules' => ''
		),
		'epg_name' => array(
			'field' => 'epg_name',
			'label' => 'EPG Name',
			'rules' => ''
		),
		'language_id' => array(
			'field' => 'language_id',
			'label' => 'Languages',
			'rules' => ''
		),
		'channel_name' => array(
			'field' => 'channel_name',
			'label' => 'Channel Name',
			'rules' => 'required|trim'
		),
		'server_url_high' => array(
			'field' => 'server_url_high',
			'label' => 'Server Url',
			'rules' => ''
		),
		'url_high' => array(
			'field' => 'url_high',
			'label' => 'Standard Url',
			'rules' => 'required|trim'
		),
		'token_high' => array(
			'field' => 'token_high',
			'label' => 'Tokenize',
			'rules' => 'required|trim'
		),
		'server_url_low' => array(
			'field' => 'server_url_low',
			'label' => 'Server Url',
			'rules' => ''
		),
		'url_low' => array(
			'field' => 'url_low',
			'label' => 'Fallback Url',
			'rules' => 'trim'
		),
		'token_low' => array(
			'field' => 'token_low',
			'label' => 'Tokenize',
			'rules' => 'required|trim'
		),
		'channel_type' => array(
			'field' => 'channel_type',
			'label' => 'Channel Type',
			'rules' => ''
		),
		'epg_url' => array(
			'field' => 'epg_url',
			'label' => 'EPG Url',
			'rules' => ''
		),
		'epg_offset'=> array(
			'field' => 'epg_offset',
			'label' => 'EPG Offset',
			'rules' => ''
		),
		'preroll_enabled'=> array(
			'field' => 'preroll_enabled',
			'label' => 'Encoder ID',
			'rules' => ''
		),
		'overlay_enabled'=> array(
			'field' => 'overlay_enabled',
			'label' => 'Overlay enabled',
			'rules' => ''
		),
		'preroll_type'=> array(
			'field' => 'preroll_type',
			'label' => 'Preroll Type',
			'rules' => ''
		),
		'overlay_enabled'=> array(
			'field' => 'overlay_enabled',
			'label' => 'Overlay Enabled',
			'rules' => ''
		),
		'ticker_enabled'=> array(
			'field' => 'ticker_enabled',
			'label' => 'Ticker Enabled',
			'rules' => ''
		),
		'show_on_home'=> array(
			'field' => 'show_on_home',
			'label' => 'Show On Home',
			'rules' => ''
		),
		'fingerprint'=> array(
			'field' => 'fingerprint',
			'label' => 'Finger Print',
			'rules' => ''
		),
		'server_url_interactivetv' => array(
			'field' => 'server_url_interactivetv',
			'label' => 'Server Url',
			'rules' => ''
		),
		'url_interactivetv'=> array(
			'field' => 'url_interactivetv',
			'label' => 'Interactive TV Url',
			'rules' => 'trim'
		),
		'token_interactivetv' => array(
			'field' => 'token_interactivetv',
			'label' => 'Tokenize',
			'rules' => 'required|trim'
		),
		'childlock'=> array(
			'field' => 'childlock',
			'label' => 'Child Lock',
			'rules' => ''
		)
	);
	public $channel_edit_rules = array(
		'channel_number' => array(
			'field' => 'channel_number',
			'label' => 'Channel Number',
			'rules' => 'required|trim|numeric|callback_channel_check_other'
		),
		/*'channel_epg_id' => array(
			'field' => 'channel_epg_id',
			'label' => 'Channel Epg ID',
			'rules' => '' 
		),*/
		'channel_epg_name' => array(
			'field' => 'channel_epg_name',
			'label' => 'Channel EPG Name',
			'rules' => ''
		),
		'channel_epg_id' => array(
			'field' => 'channel_epg_id',
			'label' => 'Channel EPG Id',
			'rules' => ''
		),
		'epg_name' => array(
			'field' => 'epg_name',
			'label' => 'EPG Name',
			'rules' => ''
		),
		'channel_name' => array(
			'field' => 'channel_name',
			'label' => 'Channel Name',
			'rules' => 'required|trim'
		),
		'server_url_high' => array(
			'field' => 'server_url_high',
			'label' => 'Server Url',
			'rules' => ''
		),
		'url_high' => array(
			'field' => 'url_high',
			'label' => 'Standard Url',
			'rules' => 'required|trim'
		),
		'token_high' => array(
			'field' => 'token_high',
			'label' => 'Tokenize',
			'rules' => 'required|trim'
		),
		'server_url_low' => array(
			'field' => 'server_url_low',
			'label' => 'Server Url',
			'rules' => ''
		),
		'url_low' => array(
			'field' => 'url_low',
			'label' => 'Fallback Url',
			'rules' => 'trim'
		),
		'token_low' => array(
			'field' => 'token_low',
			'label' => 'Tokenize',
			'rules' => 'trim'
		),
		'channel_type' => array(
			'field' => 'channel_type',
			'label' => 'Channel Type',
			'rules' => ''
		),
		'epg_url' => array(
			'field' => 'epg_url',
			'label' => 'EPG Url',
			'rules' => ''
		),
		'epg_offset'=> array(
			'field' => 'epg_offset',
			'label' => 'EPG Offset',
			'rules' => ''
		),
		'show_on_home'=> array(
			'field' => 'show_on_home',
			'label' => 'Show On Home',
			'rules' => ''
		),
		'fingerprint'=> array(
			'field' => 'fingerprint',
			'label' => 'Finger Print',
			'rules' => ''
		),
		'server_url_interactivetv'=> array(
			'field' => 'server_url_interactivetv',
			'label' => 'Server Url',
			'rules' => ''
		),
		'url_interactivetv'=> array(
			'field' => 'url_interactivetv',
			'label' => 'Interactive TV Url',
			'rules' => ''
		),
		'token_interactivetv' => array(
			'field' => 'token_interactivetv',
			'label' => 'Tokenize',
			'rules' => 'trim'
		),
		'childlock'=> array(
			'field' => 'childlock',
			'label' => 'Child Lock',
			'rules' => ''
		)
	);

	public $package_group_edit_rules = array(
		'channel_group'=> array(
			'field' => 'channel_group',
			'label' => 'Channel Group',
			'rules' => ''
		),
		'packages'=> array(
			'field' => 'packages',
			'label' => 'Packages',
			'rules' => ''
		)
	);
	
	public $ads_edit_rules = array(
		'preroll_enabled'=> array(
			'field' => 'preroll_enabled',
			'label' => 'Encoder ID',
			'rules' => ''
		),
		'overlay_enabled'=> array(
			'field' => 'overlay_enabled',
			'label' => 'Overlay enabled',
			'rules' => ''
		),
		'preroll_type'=> array(
			'field' => 'preroll_type',
			'label' => 'Preroll Type',
			'rules' => ''
		),
		'ticker_enabled'=> array(
			'field' => 'ticker_enabled',
			'label' => 'Ticker Enabled',
			'rules' => ''
		)
	);
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get_channels_groups($channel_id){
		$this->db->select('group_id');
		$this->db->where(array('channel_id'=>$channel_id));
		$query = $this->db->get('channel_to_group');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['group_id'];
		}
		return $ids;
	}

	public function get_tokens(){
		$query = $this->db->get('token');
		return $query->result();
	}

	public function get_token_code_by_id($id){
		$this->db->select('token_short_code');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('token');
		if($query->num_rows()>0)
			return $query->row()->token_short_code;
		else
			return NULL;
	}

	public function get_server_url_by_id($id){
		$this->db->select('url');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get('server_items_urls');
		if($query->num_rows()>0)
			return $query->row()->url;
		else
			return NULL;
	}

	public function delete_channels_groups($channel_id){
			$this->db->delete('channel_to_group', array('channel_id' =>$channel_id));
	}

	public function get_packages_by_channel($channel_id){
		$this->db->select('package_id');
		$this->db->where(array('channel_id'=>$channel_id));
		$query = $this->db->get('package_to_channel');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['package_id'];
		}
		return $ids;
	}

    public function get_channel_by_id($channel_number){
		$this->db->select('id');
		$this->db->where(array('channel_number'=>$channel_number));
		$query = $this->db->get('channel');
		$ids=array();
		foreach($query->result_array() as $row){
			$ids[]=$row['id'];
		}
		return $ids;
	}
	
	public function delete_channels_package($channel_id){
			$this->db->delete('package_to_channel', array('channel_id' =>$channel_id));
	}

	public function check_other_channel_number($channel_number,$channel_id){
		$sql="select channel_number from channel where id<>$channel_id";
		$query = $this->db->query($sql);
		return $query->result();
	}

}

/* End of file Channel_m.php */
/* Location: ./application/models/Channel_m.php */