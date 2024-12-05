<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Systems extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(4);
		$this->data['operator_details'] = $this->operator_m->get(1, TRUE);
		//Do your magic here
	}

	public function index()
	{
		$this->data['_view'] = DEFAULT_THEME . 'system/index';
		$this->data['page_title'] = "System";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}
}

/* End of file Systems.php */
/* Location: ./application/controllers/Systems.php */