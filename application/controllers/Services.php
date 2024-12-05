<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(35);
        $this->load->model('services_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Services');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "services";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Services', 'services');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'services/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'services/index';
        $this->data['page_title'] = "Services";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['services']= $this->services_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('menus_m');
        $rules = $this->services_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);

            $insert_id=$this->services_m->save(NULL,$data);
           
            //upload files if there is an image 
           /* if($_FILES['icon']['name']!='')
            {
                $upload_path='./uploads/advertisements/';
                $filename ='channel_image';
               
                $img_data=$this->do_upload($upload_path,$filename);

                $data=array('channel_image'=> $img_data);
                $this->services_m->save($insert_id,$data);
            }*/
            
            // insert into services_menu_items table
            if(is_array($this->input->post('menu_items')) && count($this->input->post('menu_items'))>0){
                foreach ($this->input->post('menu_items') as $menu) {
                   $data=array(
                        'menu_id'=>$menu,
                        'service_id'=>$insert_id
                    );
                   $this->db->insert('services_menu_items',$data);
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('services/edit/'.$insert_id).'" target="_blank">Product Service Added</a>');   
            $this->session->set_flashdata('success',"Service Added Successfully.");
            redirect(BASE_URL.'services');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Service', 'services/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        // get all menu items
        $this->data['menu_items'] = $this->menus_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'services/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'services/create';
        $this->data['page_title'] = "Add a new Service";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
       check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'Services' ) : '';
        
        //$app_info=$this->services_m->get($id);
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/services/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/services/icons/".$app_info->channel_image_icon);
        }*/
        $this->services_m->delete_menus_by_service($id);
        $this->services_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('services').'" target="_blank">Product Service Deleted</a>');   
        $this->session->set_flashdata('success',"Service Deleted Successfully.");
        redirect( BASE_URL . 'Services' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('menus_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'Services' ) : '';
        $rules = $this->services_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->services_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->services_m->save($id,$data);

            /*if($_FILES['icon']['name']!='')
            {
                if(file_exists("./uploads/services/icons/".$channel_info->channel_image_icon))
                    @unlink("./uploads/services/icons/".$channel_info->channel_image_icon);

                $upload_path='./uploads/services/icons/';
                $icon_filename ='channel_image_icon';
               
                $img_icon_data=$this->do_upload($upload_path,$icon_filename);

                $icon_data=array('channel_image_icon'=> $img_icon_data);
                $this->services_m->save($id,$icon_data);
            }*/

            // insert into advertisements_exclude_include_countries table
            if(is_array($this->input->post('menu_items')) && count($this->input->post('menu_items'))>0){
                
                // delete first
                $this->services_m->delete_menus_by_service($id);
                foreach ($this->input->post('menu_items') as $menu) {
                   $data=array(
                        'menu_id'=>$menu,
                        'service_id'=>$id
                    );
                   $this->db->insert('services_menu_items',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('services/edit/'.$id).'" target="_blank">Product Service Updated</a>');   
            $this->session->set_flashdata('success',"Service Edited Successfully.");
            redirect(BASE_URL.'Services');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Service', 'services/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        // get all menu items
        $this->data['menu_items'] = $this->menus_m->get();
        // get selected menus
        $this->data['selected_menu_items'] = $this->services_m->get_menus_by_service($id);
        
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'services/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'services/edit';
        $this->data['page_title'] = "Edit a Service";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}