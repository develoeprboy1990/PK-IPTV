<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{

		$dashbaord = 'admin/dashboard/';
		$this->user_m->loggedin() ==  FALSE || redirect($dashbaord);
		$rules = $this->user_m->login_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			if($this->user_m->login() == TRUE){
				redirect($dashbaord);
			}else{
				$this->session->set_flashdata('login_error', 'The Email Password Combination does not exist!');
				redirect( BASE_URL .'index');
			}
		}
		$this->data['page_title'] = 'Login';
		$this->load->view( DEFAULT_THEME . 'index',$this->data);
	}

	public function logout(){
		$this->user_m->logout();
		redirect( BASE_URL );
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */