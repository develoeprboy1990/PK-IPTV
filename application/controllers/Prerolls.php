<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prerolls extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(51);
        $this->load->model('advertisements_m');
        $this->load->model('dynamic_dependent_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('prerolls');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "advs";
        $this->data['sub_nav'] = "prerolls";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Prerolls', 'prerolls');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'prerolls/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'prerolls/index';
        $this->data['page_title'] = "Preroll";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* prerolls */
        $this->data['prerolls']= $this->advertisements_m->get_by(array('type'=>'preroll'));
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
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('prerolls/edit/'.$insert_id).'" target="_blank">Preroll Video Added</a>');   
            $this->session->set_flashdata('success',"Preroll Added Successfully.");
            redirect(BASE_URL.'prerolls');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Preroll', 'prerolls/create');
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

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'prerolls/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'prerolls/create';
        $this->data['page_title'] = "Add new Preroll Video";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'prerolls' ) : '';
        $this->advertisements_m->delete_channels_by_ad($id);
        $this->advertisements_m->delete_series_by_ad($id);
        $this->advertisements_m->delete_movies_by_ad($id);
        $this->advertisements_m->delete_countries_by_ad($id);
        $this->advertisements_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('prerolls').'" target="_blank">Preroll Video Deleted</a>');   
        $this->session->set_flashdata('success',"App Deleted Successfully.");
        redirect( BASE_URL . 'prerolls' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'prerolls' ) : '';
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
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('prerolls/edit/'.$id).'" target="_blank">Preroll Video Updated</a>');   
            $this->session->set_flashdata('success',"Preroll Edited Successfully.");
            redirect(BASE_URL.'prerolls');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Preroll', 'prerolls/create');
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
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'prerolls/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'prerolls/edit';
        $this->data['page_title'] = "Edit Preroll";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}
