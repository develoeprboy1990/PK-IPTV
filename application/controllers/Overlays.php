<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Overlays extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(52);
        $this->load->model('advertisements_m');
        $this->load->model('dynamic_dependent_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('overlays');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "advs";
        $this->data['sub_nav'] = "overlays";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Overlays', 'overlays');
    } 

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'overlays/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'overlays/index';
        $this->data['page_title'] = "Overlay Video";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* overlays */
        $this->data['overlays']= $this->advertisements_m->get_by(array('type'=>'overlay'));
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
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            
            // insert into advertisment video to chennels table
            if(is_array($this->input->post('channels')) && count($this->input->post('channels'))>0){
                foreach ($this->input->post('channels') as $channel) {
                   $data=array(
                        'channel_id'=>$channel,
                        'advertisement_id'=>$insert_id
                    );
                   $this->db->insert('advertisement_video_to_channels',$data);
                }
            }

             // insert into advertisment video to series table
            if(is_array($this->input->post('series')) && count($this->input->post('series'))>0){
                foreach ($this->input->post('series') as $series) {
                   $data=array(
                        'series_id'=>$series,
                        'advertisement_id'=>$insert_id
                    );
                   $this->db->insert('advertisement_video_to_series',$data);
                }
            }

             // insert into advertisment video to series table
            if(is_array($this->input->post('movies')) && count($this->input->post('movies'))>0){
                foreach ($this->input->post('movies') as $movie) {
                   $data=array(
                        'movie_id'=>$movie,
                        'advertisement_id'=>$insert_id
                    );
                   $this->db->insert('advertisement_video_to_movies',$data);
                }
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
    
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('overlays/edit/'.$insert_id).'" target="_blank">Video Overlay Created</a>');   
            $this->session->set_flashdata('success',"Overlay Added Successfully.");
            redirect(BASE_URL.'overlays');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Overlay', 'overlays/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* channels */
        $this->load->model('channels_m');
        $this->data['channels']=$this->channels_m->get();

        /* series */
        $this->load->model('series_m');
        $this->data['series']=$this->series_m->get();

        /* movies */
        $this->load->model('movies_m');
        $this->data['movies']=$this->movies_m->get();

        /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'overlays/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'overlays/create';
        $this->data['page_title'] = "Add a new Overlay Video";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'overlays' ) : '';
        
       /* if($app_info->channel_image_icon)
        {
            if(file_exists("./uploads/overlays/icons/".$app_info->channel_image_icon))
                @unlink("./uploads/overlays/icons/".$app_info->channel_image_icon);
        }*/
        $this->advertisements_m->delete_channels_by_ad($id);
        $this->advertisements_m->delete_series_by_ad($id);
        $this->advertisements_m->delete_movies_by_ad($id);
        $this->advertisements_m->delete_countries_by_ad($id);
        $this->advertisements_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('overlays').'" target="_blank">Video Overlay Deleted</a>');   
        $this->session->set_flashdata('success',"Overlay Video Deleted Successfully.");
        redirect( BASE_URL . 'overlays' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'overlays' ) : '';
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
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

             // insert into advertisement_video_to_channels table
            if($this->input->post('total_channels')!=""){
                //delete first
                $this->advertisements_m->delete_channels_by_ad($id);
                
                if(is_array($this->input->post('channels')) && count($this->input->post('channels'))>0){
                    foreach ($this->input->post('channels') as $channel) {
                       $data=array(
                            'channel_id'=>$channel,
                            'advertisement_id'=>$id
                        );
                       $this->db->insert('advertisement_video_to_channels',$data);
                    }
                }
            }

             // insert into advertisement_video_to_series table
            if($this->input->post('total_series')!=""){
                //delete first
                $this->advertisements_m->delete_series_by_ad($id);
                
                if(is_array($this->input->post('series')) && count($this->input->post('series'))>0){
                    foreach ($this->input->post('series') as $serie) {
                       $data=array(
                            'series_id'=>$serie,
                            'advertisement_id'=>$id
                        );
                       $this->db->insert('advertisement_video_to_series',$data);
                    }
                }
            }

             // insert into advertisement_video_to_movies table
            if($this->input->post('total_movies')!=""){
                //delete first
                $this->advertisements_m->delete_movies_by_ad($id);
                
                if(is_array($this->input->post('movies')) && count($this->input->post('movies'))>0){
                    foreach ($this->input->post('movies') as $movie) {
                       $data=array(
                            'movie_id'=>$movie,
                            'advertisement_id'=>$id
                        );
                       $this->db->insert('advertisement_video_to_movies',$data);
                    }
                }
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
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('overlays/edit/'.$id).'" target="_blank">Video Overlay Updated</a>');   
            $this->session->set_flashdata('success',"Overlay Video Edited Successfully.");
            redirect(BASE_URL.'overlays');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Overlay Video', 'overlays/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

         /* Countries */
        $this->data['countries']=$this->dynamic_dependent_m->fetch_country();
        $this->data['selected_countries']=$this->advertisements_m->get_countries_by_ad($id);
        
         /* channels */
        $this->load->model('channels_m');
        $this->data['channels']=$this->channels_m->get();
        $this->data['selected_channels']=$this->advertisements_m->get_channels_by_ad($id);

        /* series */
        $this->load->model('series_m');
        $this->data['series']=$this->series_m->get();
        $this->data['selected_series']=$this->advertisements_m->get_series_by_ad($id);

        /* movies */
        $this->load->model('movies_m');
        $this->data['movies']=$this->movies_m->get();
        $this->data['selected_movies']=$this->advertisements_m->get_movies_by_ad($id);

        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'overlays/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'overlays/edit';
        $this->data['page_title'] = "Edit Overlay Video";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}
