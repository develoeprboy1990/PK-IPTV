<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Keys extends User_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(30);
        $this->load->model('subscription_renewal_keys_m');
        $this->load->model('channel_package_keys_m');
        $this->load->model('activation_keys_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Key Cards');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "keys";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Keys', 'keys');
    }

	public function index($tab=1)
	{
        check_allow('view',$this->data['is_allow']);
        $this->load->model('products_m');
        $this->load->model('packages_m');
        $this->load->model('devices_m');
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'keys/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'keys/index';
        $this->data['page_title'] = "Key Cards";
        $this->data['activeTab'] = $tab;
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
       
        $this->data['products']= $this->products_m->get();
        // subscription renewal Keys Form and List 
        $this->data['subscription_renewal_keys']= $this->subscription_renewal_keys_m->getKeys();
        $this->data['subscription_renewal_keys_view'] = $this->load->view( DEFAULT_THEME . 'keys/_add_subscription_keys',$this->data, TRUE);
        $this->data['subscription_renewal_keys_list_view']= $this->load->view( DEFAULT_THEME . 'keys/_list_subscription_keys',$this->data, TRUE);
		
		 // subscription renewal Keys Form and List 
        $this->data['subscription_renewal_keys_resellers']= $this->subscription_renewal_keys_m->getKeysResellers();
       // $this->data['subscription_renewal_keys_view_resellers'] = $this->load->view( DEFAULT_THEME . 'keys/_add_subscription_keys',$this->data, TRUE);
        $this->data['subscription_renewal_keys_list_view_resellers']= $this->load->view( DEFAULT_THEME . 'keys/_list_subscription_keys_resellers',$this->data, TRUE);
        
        // channel package keys form and List 
        $this->data['packages']= $this->packages_m->get();
        $this->data['package_keys']= $this->channel_package_keys_m->getKeys();
        $this->data['package_keys_view'] = $this->load->view( DEFAULT_THEME . 'keys/_add_package_keys',$this->data, TRUE);
        $this->data['package_keys_list_view']= $this->load->view( DEFAULT_THEME . 'keys/_list_package_keys',$this->data, TRUE); 
        
        // channel package keys form and List 
        $this->data['devices']= $this->devices_m->get();
        $this->data['activation_keys']= $this->activation_keys_m->getKeys();
        $this->data['activation_keys_view'] = $this->load->view( DEFAULT_THEME . 'keys/_add_activation_keys',$this->data, TRUE);
        $this->data['activation_keys_list_view']= $this->load->view( DEFAULT_THEME . 'keys/_list_activation_keys',$this->data, TRUE); 
         
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function createRenewalKeys(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->subscription_renewal_keys_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            // create subscription keys 
			$group_unic = $this->input->post('prefix_code').substr(str_shuffle("0123456789abcdefghijklmmnopqrstuvwxyz"), 0, 20);
            for($i=1;$i<=$this->input->post('quantity');$i++){
                
                $length =$this->input->post('length')-strlen($this->input->post('prefix_code')); 
                $key = substr(str_shuffle("0123456789"), 0, $length);

                $final_key=$this->input->post('prefix_code').$key;
                $data = array('keycode'=>$final_key,
							  'group_unic_code' => $group_unic,
                              'group_name'=>$this->input->post('group_name'),
                              'product_id'=>$this->input->post('product_id'),
                              'devices_allowed'=>$this->input->post('devices_allowed'),
                              'length_months'=>$this->input->post('length_months'),
							  'month_day' => $this->input->post('month_day'),
							  'monthly_price' => $this->input->post('monthly_price'),
                              'date_created'=>date('Y-m-d H:i:s')
                    );
                $this->subscription_renewal_keys_m->save(NULL,$data);
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys').'" target="_blank">Keys Created</a>');   
            $this->session->set_flashdata('success',"Keys Created Successfully.");
            redirect(BASE_URL.'keys');
        }
        redirect(BASE_URL.'keys');
    }

    public function createPackageKeys(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->channel_package_keys_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            // create subscription keys 
            for($i=1;$i<=$this->input->post('quantity');$i++){
                
                $length =$this->input->post('length')-strlen($this->input->post('prefix_code')); 
                $key = substr(str_shuffle("0123456789"), 0, $length);

                $final_key=$this->input->post('prefix_code').$key;
                $data = array('keycode'=>$final_key,
                              'group_name'=>$this->input->post('group_name'),
                              'package_id'=>$this->input->post('package_id'),
                              'length_months'=>$this->input->post('length_months'),
                              'monthly_price'=>$this->input->post('monthly_price'),
                              'date_created'=>date('Y-m-d H:i:s')
                    );
                $this->channel_package_keys_m->save(NULL,$data);
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys/index/2').'" target="_blank">Package Keys Created</a>');   
            $this->session->set_flashdata('success',"Package Keys Created Successfully.");
            redirect(BASE_URL.'keys/index/2');
        }
        redirect(BASE_URL.'keys/index/2');
    }

    public function createActivationKeys(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->activation_keys_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            // create subscription keys 
            for($i=1;$i<=$this->input->post('quantity');$i++){
                
                $length =$this->input->post('length')-strlen($this->input->post('prefix_code')); 
                $key = substr(str_shuffle("0123456789"), 0, $length);

                $final_key=$this->input->post('prefix_code').$key;
                $data = array('keycode'=>$final_key,
                              'group_name'=>$this->input->post('group_name'),
                              'product_id'=>$this->input->post('product_id'),
                              'devices_allowed'=>$this->input->post('devices_allowed'),
                              'length_months'=>$this->input->post('length_months'),
                              'monthly_price'=>$this->input->post('monthly_price'),
                              'date_created'=>date('Y-m-d H:i:s')
                    );
                $this->activation_keys_m->save(NULL,$data);
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys/index/3').'" target="_blank">Activation Keys Created</a>');   
            $this->session->set_flashdata('success',"Keys Created Successfully.");
            redirect(BASE_URL.'keys/index/3');
        }
        redirect(BASE_URL.'keys/index/3');
    }

    public function deleteRenewalKey($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'keys' ) : '';
        $this->subscription_renewal_keys_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys').'" target="_blank">Renewal Keys Deleted</a>');   
        $this->session->set_flashdata('success',"Key Deleted Successfully.");
        redirect( BASE_URL . 'keys' );
    }

    public function deletePackageKey($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'keys' ) : '';
        $this->channel_package_keys_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys/index/2').'" target="_blank">Package Keys Deleted</a>');   
        $this->session->set_flashdata('success',"Key Deleted Successfully.");
        redirect( BASE_URL . 'keys/index/2' );
    }

    public function deleteActivationKey($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'keys' ) : '';
        $this->activation_keys_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('keys/index/3').'" target="_blank">Activation Key Deleted</a>');   
        $this->session->set_flashdata('success',"Key Deleted Successfully.");
        redirect( BASE_URL . 'keys/index/3' );
    }


    public function subscriptionExportExcel() {
        check_allow('edit',$this->data['is_allow']);
        $today=date("Y_m_d");
        $fileName = $today.'_subscription_keys.xlsx';  
        $employeeData = $this->subscription_renewal_keys_m->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Keycode');
        $sheet->setCellValue('C1', 'Group Name');
        $sheet->setCellValue('D1', 'Active');
        $sheet->setCellValue('E1', 'Disabled');
        $sheet->setCellValue('F1', 'Date Created');       
        $rows = 2;
        foreach ($employeeData as $val){
            $sheet->setCellValue('A' . $rows, $val['id']);
            $sheet->setCellValue('B' . $rows, $val['keycode']);
            $sheet->setCellValue('C' . $rows, $val['group_name']);
            $sheet->setCellValue('D' . $rows, $val['active']);
            $sheet->setCellValue('E' . $rows, $val['disabled']);
            $sheet->setCellValue('F' . $rows, $val['date_created']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
        $writer->save("uploads/excels/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/uploads/excels/".$fileName);              
    }  

    public function packageExportExcel() {
        check_allow('edit',$this->data['is_allow']);
        $today=date("Y_m_d");
        $fileName = $today.'_package_keys.xlsx';  
        $employeeData = $this->channel_package_keys_m->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Keycode');
        $sheet->setCellValue('C1', 'Group Name');
        $sheet->setCellValue('D1', 'Monthly Price');
        $sheet->setCellValue('E1', 'Active');
        $sheet->setCellValue('F1', 'Disabled');   
        $sheet->setCellValue('G1', 'Date Created');       
        $rows = 2;
        foreach ($employeeData as $val){
            $sheet->setCellValue('A' . $rows, $val['id']);
            $sheet->setCellValue('B' . $rows, $val['keycode']);
            $sheet->setCellValue('C' . $rows, $val['group_name']);
            $sheet->setCellValue('D' . $rows, $val['monthly_price']);
            $sheet->setCellValue('E' . $rows, $val['active']);
            $sheet->setCellValue('F' . $rows, $val['disabled']);
            $sheet->setCellValue('G' . $rows, $val['date_created']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
        $writer->save("uploads/excels/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/uploads/excels/".$fileName);              
    }

    public function activationExportExcel() {
        check_allow('edit',$this->data['is_allow']);
        $today=date("Y_m_d");
        $fileName = $today.'_activation_keys.xlsx';  
        $employeeData = $this->activation_keys_m->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Keycode');
        $sheet->setCellValue('C1', 'Group Name');
        $sheet->setCellValue('D1', 'Monthly Price');
        $sheet->setCellValue('E1', 'Active');
        $sheet->setCellValue('F1', 'Disabled');       
        $rows = 2;
        foreach ($employeeData as $val){
            $sheet->setCellValue('A' . $rows, $val['id']);
            $sheet->setCellValue('B' . $rows, $val['keycode']);
            $sheet->setCellValue('C' . $rows, $val['group_name']);
            $sheet->setCellValue('D' . $rows, $val['monthly_price']);
            $sheet->setCellValue('E' . $rows, $val['active']);
            $sheet->setCellValue('F' . $rows, $val['disabled']);
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);
        $writer->save("uploads/excels/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/uploads/excels/".$fileName);              
    }   


    function mypdf(){
     
       // $this->load->view(DEFAULT_THEME . 'keys/pdf');
        
        // Get output html
       // $html = $this->output->get_output();
        
        // Load pdf library
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml('<h1>HELLO WORLD</h1>');
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
    }
}
