<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegistrationOtp extends User_Controller {

   public function __construct(){
        parent::__construct();
        $this->data['is_allow']= check_permission(78);
        $this->load->model('RegistrationOTP_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Pages');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "registrationOtp";
   }	
   public function index(){
   
   }
   public function otp($id){
   	   check_allow('edit',$this->data['is_allow']);
   	   $where = array('id' => $id);
       $registration_otp_info =  $this->RegistrationOTP_m->selectdatarow($where, 'registration_otp');
		if(isset($_REQUEST['change_status'])){ 			
			$this->load->library('form_validation');		
			$this->form_validation->set_rules('status', 'Status', 'trim|required');			
			if ($this->form_validation->run() == FALSE){
				$this->data['status'] = $this->input->post('status');
			} else{
				$status = $this->input->post('status');				
				$data = array(
				 				'status' => $status
							);
				 $this->RegistrationOTP_m->update('registration_otp',$data,$where);
				  redirect( BASE_URL . 'registrationOtp/otp/1');
			}
		}
		$this->data['status'] = $registration_otp_info[0]['status'];
				
		$this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "registrationOtp";
        //$this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'registrationOTP/index';
        $this->data['page_title'] = "Registration OTP Status";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

}
