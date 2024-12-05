<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "settings";
	}

	public function index()
	{
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'setting/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'setting/index';
		$this->data['page_title'] = "Settings";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function permission($id = NULL)
	{
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'setting/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'setting/permission';
		$this->data['page_title'] = "Permission Settings";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

}

/* End of file Setting.php */
/* Location: ./application/controllers/Setting.php */