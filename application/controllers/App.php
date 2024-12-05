<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(60);
        $this->load->model('apps_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Apps');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "aaps";
        $this->data['sub_nav'] = "apps";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Apps', 'apps');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'apps/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'apps/index';
        $this->data['page_title'] = "App";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* APPS */
        $this->data['apps']= $this->apps_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('app_categories_m');
        $rules = $this->apps_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }

        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);

            $insert_id=$this->apps_m->save(NULL,$data);
           
            //upload files if there is an image 
            if($_FILES['icon']['name']!='')
            {
               
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('icon', '', $upload_path, 'apps_m',$insert_id);
                $localFilePath = $upload_path.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('apps/edit/'.$insert_id).'" target="_blank">App Added</a>');   
            $this->session->set_flashdata('success',"App Added Successfully.");
            redirect(BASE_URL.'apps');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create App', 'apps/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Category */
        $this->data['categories']=$this->app_categories_m->get();

        /* get all the tokens */
        $this->data['tokens'] = $this->apps_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(1); //app 1

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'apps/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'apps/create';
        $this->data['page_title'] = "Add new App";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'apps' ) : '';
        
        $app_info=$this->apps_m->get($id);
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/apps/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/apps/icons/".$app_info->channel_image_icon);
        }*/
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('apps').'" target="_blank">App Deleted</a>');   
        $this->apps_m->delete($id);
        $this->session->set_flashdata('success',"App Deleted Successfully.");
        redirect( BASE_URL . 'apps' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('app_categories_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'apps' ) : '';
        $rules = $this->apps_m->rules;
        $this->form_validation->set_rules($rules);
        $app_info=$this->apps_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->apps_m->save($id,$data);

            if($_FILES['icon']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('icon', $app_info->icon, $upload_path, 'apps_m',$id);
                $localFilePath = $upload_path.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('apps/edit/'.$id).'" target="_blank">App Updated</a>');   
            $this->session->set_flashdata('success',"App Edited Successfully.");
            redirect(BASE_URL.'apps');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit App', 'apps/create');

        /* Category */
        $this->data['categories']=$this->app_categories_m->get();

        /* get all the tokens */
        $this->data['tokens'] = $this->apps_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(1); //app 1

        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $app_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'apps/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'apps/edit';
        $this->data['page_title'] = "Edit App";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

     public function get_all_apps(){
        $totaldata = 10;
        $totalfiltered = 10;
        $apps = $this->apps_m->get();
        $data = array();
        foreach ($apps as $app) {
            $data[] = array(
                    'id'=>$app['id'],
                    'name'=>$app['name'],
                    'url'=>$app['url'],
                    'edit'=>btn_edit(BASE_URL.'apps/edit/'.$app['id']),
                    'delete'=>btn_delete(BASE_URL.'apps/delete/'.$app['id']),
                );
        }
        $json_data = array(
                        "draw"            => intval( $_REQUEST['draw'] ),
                        "recordsTotal"    => intval( $totaldata ),
                        "recordsFiltered" => intval( $totalfiltered ),
                        "data"            => $data
                    );
        echo json_encode($json_data);
    }
}