<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homescreen extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(17);
        $this->load->model('channels_m');
        $this->load->model('series_m');
         $this->load->model('series_seasons_m');
        $this->load->model('movies_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Homescreen Items');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "homescreen";
        $this->data['sub_nav'] = "homescreen";
        
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'HomeScreen', 'homescreen');
    }

	public function index($tab=1)
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'homescreen/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'homescreen/index';
        $this->data['page_title'] = "Homescreen Items";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* channels */
        $this->data['channels']= $this->channels_m->get();
        $this->data['selected_channels']= $this->channels_m->get_by(array('show_on_home'=>1));
        
        /* Movies */
        $this->data['movies']= $this->movies_m->get();
        $this->data['selected_movies']= $this->movies_m->get_by(array('show_on_home'=>1));

        /* series */
		$series_list = $this->series_m->get();
		foreach($series_list as $key=>$val){
			$series_list_arr['series_'.$val['id']] = $val['name'];
		}
		
        $this->data['series_list']= $series_list_arr;
        //$this->data['selected_series']= $this->series_m->get_by(array('show_on_home'=>1));

        /* series seasons*/
        $this->data['series_seasons']= $this->series_seasons_m->get();
        $this->data['selected_series_seasons']= $this->series_seasons_m->get_by(array('show_on_home'=>1));

        $this->data['activeTab'] = $tab;

        $this->data['channels_view']= $this->load->view( DEFAULT_THEME . 'homescreen/_channels',$this->data, TRUE);;
        $this->data['movies_view']= $this->load->view( DEFAULT_THEME . 'homescreen/_movies',$this->data, TRUE);;
        $this->data['series_seasons_view']= $this->load->view( DEFAULT_THEME . 'homescreen/_series_seasons',$this->data, TRUE);;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function updateChannels(){
        check_allow('edit',$this->data['is_allow']);
        // update channels
        if(is_array($this->input->post('channels')) && count($this->input->post('channels'))>0){
            foreach ($this->input->post('channels') as $channel_id) {
               $data=array('show_on_home'=>1);
               $this->channels_m->save($channel_id,$data);
               $select_id[]=$channel_id;
            }

            // update channels to show_on_home =0 not listed 
            $channels= $this->channels_m->get();

            foreach($channels as $channel){
                if(!in_array($channel['id'],$this->input->post('channels'))){
                    $data=array('show_on_home'=>0);
                    $this->channels_m->save($channel['id'],$data);
                }
            }
        }
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('homescreen').'" target="_blank">Channels Updated on Homescreen</a>');   
        $this->session->set_flashdata('success',"Channels Updated on Homescreen Successfully.");
        redirect(BASE_URL.'homescreen');
    }

    public function updateMovies(){
         check_allow('edit',$this->data['is_allow']);
        // insert into product_to_vod_stores table
        if(is_array($this->input->post('movies')) && count($this->input->post('movies'))>0){
            foreach ($this->input->post('movies') as $movie_id) {
               $data=array('show_on_home'=>1);
               $this->movies_m->save($movie_id,$data);
            }

            // update movies to show_on_home =0 not listed 
            $movies= $this->movies_m->get();

            foreach($movies as $movie){
                if(!in_array($movie['id'],$this->input->post('movies'))){
                    $data=array('show_on_home'=>0);
                    $this->movies_m->save($movie['id'],$data);
                }
            }
        }

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('homescreen/index/2').'" target="_blank">Movies Updated on HomeScreen</a>');   
        $this->session->set_flashdata('success',"Movies Updated on HomeScreen Successfully.");
        redirect(BASE_URL.'homescreen/index/2');
    }

    public function updateSeries(){
         check_allow('edit',$this->data['is_allow']);
        // update series table 
        if(is_array($this->input->post('series')) && count($this->input->post('series'))>0){
            foreach ($this->input->post('series') as $serie_id) {
               $data=array('show_on_home'=>1);
               $this->series_m->save($serie_id,$data);
            }

            // update series to show_on_home =0 not listed 
            $series= $this->series_m->get();
            foreach($series as $serie){
                if(!in_array($serie['id'],$this->input->post('series'))){
                    $data=array('show_on_home'=>0);
                    $this->series_m->save($serie['id'],$data);
                }
            }
        }
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('homescreen/index/3').'" target="_blank">Series Updated on HomeScreen</a>');   
        $this->session->set_flashdata('success',"Series Updated on HomeScreen Successfully.");
        redirect(BASE_URL.'homescreen/index/3');
    }

    public function updateSeriesSeasons(){
         check_allow('edit',$this->data['is_allow']);
       
        // update series seasons table 
        if(is_array($this->input->post('series_seasons')) && count($this->input->post('series_seasons'))>0){
            foreach ($this->input->post('series_seasons') as $serie_season_id) {
               $data=array('show_on_home'=>1);
               $this->series_seasons_m->save($serie_season_id,$data);
            }

            // update series_seasons to show_on_home =0 not listed 
            $series_seasons= $this->series_seasons_m->get();
            foreach($series_seasons as $season){
                if(!in_array($season['id'],$this->input->post('series_seasons'))){
                    $data=array('show_on_home'=>0);
                    $this->series_seasons_m->save($season['id'],$data);
                }
            }
        }
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('homescreen/index/3').'" target="_blank">Series Seasons Updated on HomeScreen</a>');   
        $this->session->set_flashdata('success',"Series Seasons Updated on HomeScreen Successfully.");
        redirect(BASE_URL.'homescreen/index/3');
    }
}
