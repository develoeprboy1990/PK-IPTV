<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(50);
        $this->load->model('advertisements_m');
        $this->load->model('dynamic_dependent_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Banners');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "advs";
        $this->data['sub_nav'] = "banners";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Banners', 'banners');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'banners/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'banners/index';
        $this->data['page_title'] = "Banners";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['banners']= $this->advertisements_m->get_by(array('type'=>'banner'));
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){ 
        check_allow('create',$this->data['is_allow']);
        $rules = $this->advertisements_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);

            $insert_id=$this->advertisements_m->save(NULL,$data);
           
            //upload files if there is an image 
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('image', '', $upload_path, 'advertisements_m',$insert_id);
                $localFilePath = $upload_path.$filename;

                 //resize image according to the position
                if($this->input->post('gui_position')=='vertical') 
                    $this->resize_image($_FILES["image"]["tmp_name"],$localFilePath,'160','580');
                
                if($this->input->post('gui_position')=='horizontal')
                    $this->resize_image($_FILES["image"]["tmp_name"],$localFilePath,'620','160');

                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            
            //upload files if there is an image 
            if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('backdrop', '', $upload_path, 'advertisements_m',$insert_id);
                $localFilePath = $upload_path.$filename;

                  //resize image according to the position
                $this->resize_image($_FILES["backdrop"]["tmp_name"],$localFilePath,'1280','720');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            // insert into advertisements_exclude_include_countries table
            if(is_array($this->input->post('countries')) && count($this->input->post('countries'))>0){
                foreach ($this->input->post('countries') as $country) {
                    if($this->input->post('exclude_country')=='yes'){
                        $data=array(
                            'country_id'=>$country,
                            'advertisement_id'=>$insert_id,
                            'exclude'=>1
                        );
                    }else{
                        $data=array(
                            'country_id'=>$country,
                            'advertisement_id'=>$insert_id,
                            'include'=>1
                        );
                    }

                    $this->db->insert('advertisements_exclude_include_countries',$data);
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('banners/edit/'.$insert_id).'" target="_blank">Banner Added</a>');   
            $this->session->set_flashdata('success',"Banner Added Successfully.");
            redirect(BASE_URL.'banners');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Banner', 'banners/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'banners/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'banners/create';
        $this->data['page_title'] = "Add a new Banner";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'banners' ) : '';
        
        //$app_info=$this->advertisements_m->get($id);
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/banners/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/banners/icons/".$app_info->channel_image_icon);
        }*/

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('banners').'" target="_blank">Banner Deleted</a>');   
        $this->advertisements_m->delete_countries_by_ad($id);
        $this->advertisements_m->delete($id);

        $this->session->set_flashdata('success',"Banner Deleted Successfully.");
        redirect( BASE_URL . 'banners' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'banners' ) : '';
        $rules = $this->advertisements_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->advertisements_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->advertisements_m->save($id,$data);

            //upload files if there is an image 
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('image', $info->image, $upload_path, 'advertisements_m',$id);
                $localFilePath = $upload_path.$filename;
                
                 //resize image according to the position
                if($this->input->post('gui_position')=='vertical') 
                    $this->resize_image($_FILES["image"]["tmp_name"],$localFilePath,'160','580');
                
                if($this->input->post('gui_position')=='horizontal')
                    $this->resize_image($_FILES["image"]["tmp_name"],$localFilePath,'620','160');

                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            //upload files if there is an image 
            if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('backdrop', $info->backdrop, $upload_path, 'advertisements_m',$id);
                $localFilePath = $upload_path.$filename;
                $this->resize_image($_FILES["backdrop"]["tmp_name"],$localFilePath,'1280','720');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
      
            // only insert when you select exclude yes into advertisements_exclude_include_countries table
            if(is_array($this->input->post('countries')) && count($this->input->post('countries'))>0){
                
                // first delete all 
                $this->advertisements_m->delete_countries_by_ad($id); //include them all
                        
                foreach ($this->input->post('countries') as $country) {
                    
                    if($this->input->post('exclude_country')=='yes'){
                        
                        $data=array(
                            'country_id'=>$country,
                            'advertisement_id'=>$id,
                            'exclude'=>1
                        );
                    }else{
                        $data=array(
                            'country_id'=>$country,
                            'advertisement_id'=>$id,
                            'include'=>1
                        );
                    }
                    $this->db->insert('advertisements_exclude_include_countries',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('banners/edit/'.$id).'" target="_blank">Banner Updated</a>');   
            $this->session->set_flashdata('success',"Banner Edited Successfully.");
            redirect(BASE_URL.'banners');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit App', 'banners/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        $this->data['selected_countries']=$this->advertisements_m->get_countries_by_ad($id);
        /* States */
        //$this->data['states']=$this->dynamic_dependent_m->get_states($info->country_id);
        /* Cities */
        //$this->data['cities']=$this->dynamic_dependent_m->get_cities($info->state_id);

        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'banners/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'banners/edit';
        $this->data['page_title'] = "Edit a Banner";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}