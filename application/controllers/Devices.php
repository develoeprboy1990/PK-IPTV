<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices extends User_Controller {

    public function __construct()
    {
        parent::__construct(); 
        $this->data['is_allow']= check_permission(34);

        $this->load->model('devices_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Devices');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "devices";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Devices', 'devices');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'devices/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'devices/index';
        $this->data['page_title'] = "Devices";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['devices']= $this->devices_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->devices_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);

            $insert_id=$this->devices_m->save(NULL,$data);
            
            //upload files if there is an image 
            if($_FILES['image']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
               
                $filename= $this->upload_image('image', '', $upload_path, 'devices_m',$insert_id);
                $localFilePath = $upload_path.$filename;
$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('devices/edit/'.$insert_id).'" target="_blank">Product Device Added</a>');   
            $this->session->set_flashdata('success',"Device Added Successfully.");
            redirect(BASE_URL.'devices');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Device', 'devices/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
      
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'devices/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'devices/create';
        $this->data['page_title'] = "Add a new Device";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
       check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'devices' ) : '';
        
        //$app_info=$this->devices_m/->get($id);
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/devices/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/devices/icons/".$app_info->channel_image_icon);
        }*/
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('devices').'" target="_blank">Product Device Deleted</a>');   
        $this->devices_m->delete($id);
        $this->session->set_flashdata('success',"Device Deleted Successfully.");
        redirect( BASE_URL . 'devices' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'devices' ) : '';
        $rules = $this->devices_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->devices_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->devices_m->save($id,$data);

            if($_FILES['image']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('image', $info->image, $upload_path, 'devices_m',$id);
                $localFilePath = $upload_path.$filename;
$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('devices/edit/'.$id).'" target="_blank">Product Device Updated</a>');   
            $this->session->set_flashdata('success',"Device Edited Successfully.");
            redirect(BASE_URL.'devices');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Device', 'devices/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'devices/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'devices/edit';
        $this->data['page_title'] = "Edit a Device";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}