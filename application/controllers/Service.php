<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['all_service_menu'] = $this->service_menu_item_m->get();
		//Do your magic here
	}

	public function index()
	{
		$this->data['_view'] = DEFAULT_THEME . 'service/index';
		$this->data['page_title'] = "All services";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function add()
	{
		$this->data['_view'] = DEFAULT_THEME . 'service/add';
		$this->data['page_title'] = "Add new service";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

}

/* End of file Service.php */
/* Location: ./application/controllers/Service.php */