<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_devices extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(36);
        $this->load->model('customer_devices_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Customers Devices');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "customers";
        $this->data['sub_nav'] = "customer_devices";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Customers Devices', 'customers_devices');
    }

	public function index()
	{  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customer_devices/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customer_devices/index';
        $this->data['page_title'] = "Device";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['devices']= $this->customer_devices_m->getDevices();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->customer_devices_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            $serial_post=$this->input->post('serial');
            $text = trim($serial_post);
            $textAr = explode("\n", $text);
            $serials = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

            foreach ($serials as $serial) {
                $data = array('serial'=>$serial,
                             'model_id'=>$this->input->post('model_id'),
                             'location'=>$this->input->post('location'),
                             'date_added'=>date('Y-m-d')
                            );
                $this->customer_devices_m->save(NULL,$data);
            } 
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customer_devices').'" target="_blank">Customer Device Added</a>');   
            $this->session->set_flashdata('success',"Customer Device Added Successfully.");
            redirect(BASE_URL.'customer_devices');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Device', 'customer_devices/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['models'] = $this->customer_devices_m->getModels();
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customer_devices/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customer_devices/create';
        $this->data['page_title'] = "Add a new Device";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'customer_devices' ) : '';
        $this->customer_devices_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customer_devices').'" target="_blank">Customer Device Deleted</a>');   
        $this->session->set_flashdata('success',"Device Deleted Successfully.");
        redirect( BASE_URL . 'customer_devices' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'customer_devices' ) : '';
        $rules = $this->customer_devices_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->customer_devices_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->customer_devices_m->save($id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('customer_devices/edit/'.$id).'" target="_blank">Customer Device Updated</a>');   
            $this->session->set_flashdata('success',"Device Edited Successfully.");
            redirect(BASE_URL.'customer_devices');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Device', 'customer_devices/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['models'] = $this->customer_devices_m->getModels();
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customer_devices/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'customer_devices/edit';
        $this->data['page_title'] = "Edit a Device";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }   
}
