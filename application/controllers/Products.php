<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends User_Controller {

    public function __construct() 
    {
        parent::__construct(); 
        $this->data['is_allow']= check_permission(20);
        $this->load->model('products_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Products');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "products";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Products', 'products');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'products/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'products/index';
        $this->data['page_title'] = "Products";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['products']= $this->products_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('services_m');
        $this->load->model('news_groups_m');
        $this->load->model('devices_m');
        $this->load->model('packages_m');
        $this->load->model('app_packages_m');
        $this->load->model('movie_stores_m');
        $this->load->model('series_stores_m');
        $this->load->model('dynamic_dependent_m');
        $this->load->model('gui_settings_m');
        $this->load->model('server_locations_m');
        $rules = $this->products_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);

            $insert_id=$this->products_m->save(NULL,$data);
            
            //upload files if there is an image 
            if($_FILES['image']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('image', '', $upload_path, 'products_m',$insert_id);
                $localFilePath = $upload_path.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            
             // insert into product_to_app_packages table
            if(is_array($this->input->post('devices')) && count($this->input->post('devices'))>0){
                foreach ($this->input->post('devices') as $device_id) {
                   $data=array(
                        'device_id'=>$device_id,
                        'product_id'=>$insert_id
                    );
                   $this->db->insert('product_to_devices',$data);
                }
            }

            // insert into product_to_app_packages table
           /* if(is_array($this->input->post('app_packages')) && count($this->input->post('app_packages'))>0){
                foreach ($this->input->post('app_packages') as $app_pkg) {
                   $data=array(
                        'app_package_id'=>$app_pkg,
                        'product_id'=>$insert_id
                    );
                   $this->db->insert('product_to_app_packages',$data);
                }
            }*/

            // insert into product_to_app_packages table
            if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                foreach ($this->input->post('packages') as $pkg) {
                   $data=array(
                        'package_id'=>$pkg,
                        'product_id'=>$insert_id
                    );
                   $this->db->insert('product_to_packages',$data);
                }
            }

            // insert into product_to_vod_stores table
            if(is_array($this->input->post('stores')) && count($this->input->post('stores'))>0){
                foreach ($this->input->post('stores') as $store) {
                   $data=array(
                        'vod_store_id'=>$store,
                        'product_id'=>$insert_id
                    );
                   $this->db->insert('product_to_vod_stores',$data);
                }
            }

            // insert into product_to_series_stores table
            if(is_array($this->input->post('series_stores')) && count($this->input->post('series_stores'))>0){
                foreach ($this->input->post('series_stores') as $store) {
                   $data=array(
                        'series_store_id'=>$store,
                        'product_id'=>$insert_id
                    );
                   $this->db->insert('product_to_series_stores',$data);
                }
            }

            // insert into product_to_countries table
            if(is_array($this->input->post('countries')) && count($this->input->post('countries'))>0){
                foreach ($this->input->post('countries') as $country) {
                   $data=array(
                        'country_id'=>$country,
                        'product_id'=>$insert_id
                    );
                   $this->db->insert('product_to_countries',$data);
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('products/edit/'.$insert_id).'" target="_blank">Product Created</a>');   
            $this->session->set_flashdata('success',"Product Added Successfully.");
            redirect(BASE_URL.'products');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Product', 'products/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Services */
        $this->data['services']= $this->services_m->get();

        /* News Groups */
        $this->data['news_groups']= $this->news_groups_m->get();

        /* Server Locations */
        $this->data['locations']= $this->server_locations_m->getLocations();

        /* GUI Settings*/
        $this->data['settings']= $this->gui_settings_m->get();

        /* Devices */
        $this->data['devices']= $this->devices_m->get_by(array('available'=>'true'));

        /* packages */
        $this->data['packages']= $this->packages_m->get();
        
        /* App packages */
        $this->data['app_packages']= $this->app_packages_m->get();
        
        /* VOD Stores */
        $this->data['stores']= $this->movie_stores_m->get_by(array('parent_id'=>0));
        
        /* Series Stores */
        $this->data['series_stores']= $this->series_stores_m->get_by(array('parent_id'=>0));
        
        /*  Countries */
        $this->data['countries']= $this->dynamic_dependent_m->fetch_country();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'products/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'products/create';
        $this->data['page_title'] = "Add a new Product";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'products' ) : '';
        
        //$app_info=$this->products_m->get($id);
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/products/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/products/icons/".$app_info->channel_image_icon);
        }*/
        $this->products_m->delete_devices_by_product($id);
        $this->products_m->delete_packages_by_product($id);
        $this->products_m->delete_app_packages_by_product($id);
        $this->products_m->delete_stores_by_product($id);
        $this->products_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('products').'" target="_blank">Product Deleted</a>');   
        $this->session->set_flashdata('success',"Product Deleted Successfully.");
        redirect( BASE_URL . 'products' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('services_m');
        $this->load->model('news_groups_m');
        $this->load->model('devices_m');
        $this->load->model('packages_m');
        $this->load->model('app_packages_m');
        $this->load->model('movie_stores_m');
        $this->load->model('series_stores_m');
        $this->load->model('dynamic_dependent_m');
        $this->load->model('gui_settings_m');
        $this->load->model('devices_m');
        $this->load->model('server_locations_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'products' ) : '';
        $rules = $this->products_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->products_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
			/*echo '<pre>';
			print_r($data); exit;*/
            $this->products_m->save($id,$data);

            //upload files if there is an image 
            if($_FILES['image']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('image', $info->image, $upload_path, 'products_m',$id);
                $localFilePath = $upload_path.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            // insert into product_to_app_packages table
            if($this->input->post('total_devices')!=""){
                //delete first
                $this->products_m->delete_devices_by_product($id);
                if(is_array($this->input->post('devices')) && count($this->input->post('devices'))>0){
                    foreach ($this->input->post('devices') as $device_id) {
                       $data=array(
                            'device_id'=>$device_id,
                            'product_id'=>$id
                        );
                       $this->db->insert('product_to_devices',$data);
                    }
                }
            }

            // insert into product_to_app_packages table
          /*  if($this->input->post('total_app_package')!=""){
                //delete first
                $this->products_m->delete_app_packages_by_product($id);
                if(is_array($this->input->post('app_packages')) && count($this->input->post('app_packages'))>0){
                    foreach ($this->input->post('app_packages') as $app_pkg) {
                       $data=array(
                            'app_package_id'=>$app_pkg,
                            'product_id'=>$id
                        );
                       $this->db->insert('product_to_app_packages',$data);
                    }
                }
            }*/

            // insert into product_to_packages table
            if($this->input->post('total_package')!=""){
                //delete first
                $this->products_m->delete_packages_by_product($id);
                if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                    foreach ($this->input->post('packages') as $pkg) {
                       $data=array(
                            'package_id'=>$pkg,
                            'product_id'=>$id
                        );
                       $this->db->insert('product_to_packages',$data);
                    }
                }
            }

            // insert into product_to_vod_stores table
            if($this->input->post('total_vod_stores')!=""){
                //delete first
                $this->products_m->delete_stores_by_product($id);
                if(is_array($this->input->post('stores')) && count($this->input->post('stores'))>0){
                    foreach ($this->input->post('stores') as $store) {
                       $data=array(
                            'vod_store_id'=>$store,
                            'product_id'=>$id
                        );
                       $this->db->insert('product_to_vod_stores',$data);
                    }
                }
            }

            // insert into product_to_series_stores table
            if($this->input->post('total_series_stores')!=""){
                //delete first
                $this->products_m->delete_series_stores_by_product($id);
                if(is_array($this->input->post('series_stores')) && count($this->input->post('series_stores'))>0){
                    foreach ($this->input->post('series_stores') as $store) {
                       $data=array(
                            'series_store_id'=>$store,
                            'product_id'=>$id
                        );
                       $this->db->insert('product_to_series_stores',$data);
                    }
                }
            }

            // insert into product_to_countries table
            if($this->input->post('total_countries')!=""){
                //delete first
                $this->products_m->delete_countries_by_product($id);
                if(is_array($this->input->post('countries')) && count($this->input->post('countries'))>0){
                    foreach ($this->input->post('countries') as $country) {
                       $data=array(
                            'country_id'=>$country,
                            'product_id'=>$id
                        );
                       $this->db->insert('product_to_countries',$data);
                    }
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('products/edit/'.$id).'" target="_blank">Product updated</a>');   
            $this->session->set_flashdata('success',"Product Edited Successfully.");
            redirect(BASE_URL.'products');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Product', 'products/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Services */
        $this->data['services']= $this->services_m->get();

         /* News Groups */
        $this->data['news_groups']= $this->news_groups_m->get();

        /* Server Locations */
        $this->data['locations']= $this->server_locations_m->getLocations();

        /* Devices */
        $this->data['devices']= $this->devices_m->get_by(array('available'=>'true'));
        $this->data['selected_devices']= $this->products_m->get_devices_by_product($id);

        /* GUI Settings*/
        $this->data['settings']= $this->gui_settings_m->get();
       
        /* Packages */
        $this->data['packages']= $this->packages_m->get();
        $this->data['selected_packages']= $this->products_m->get_packages_by_product($id);
        
        /* VOD Stores */
        $this->data['countries']= $this->dynamic_dependent_m->fetch_country();
        $this->data['selected_countries']=$this->products_m->get_countries_by_product($id);

        /* App packages */
        $this->data['app_packages']= $this->app_packages_m->get();
        //$this->data['selected_app_packages']= $this->products_m->get_app_packages_by_product($id);

        /* VOD Stores */
        $this->data['stores']= $this->movie_stores_m->get_by(array('parent_id'=>0));
        $this->data['selected_stores']= $this->products_m->get_stores_by_product($id);

        /* Series Stores */
        $this->data['series_stores']= $this->series_stores_m->get_by(array('parent_id'=>0));
        $this->data['selected_series_stores']= $this->products_m->get_series_stores_by_product($id);

        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'products/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'products/edit';
        $this->data['page_title'] = "Edit a Product";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
 
}
