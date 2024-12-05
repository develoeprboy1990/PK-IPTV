<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Episodes extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['is_allow']= check_permission(23);
        $this->load->model('episodes_m');
        $this->load->model('series_m');
		$this->load->model('tmdb_model');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Episodes');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "sod";
        $this->data['sub_nav'] = "series";
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Episodes', 'Episodes');


        $this->form_validation->set_message('check_sequence_unique', 'This sequence number is already in use for this season.');

    }

	public function series($id){
        $this->data['episodes'] = $this->episodes_m->get_by(array('series_id'=>$id));
       // $this->data['_extra_scripts'] = DEFAULT_THEME . 'episodes/_extra_scripts';
      
        $this->data['page_title'] = "episodes";
        $this->data['add_text'] = "Add an Episode";
        $this->data['series_id'] = $id;
        $this->load->model('movies_m');
        $this->data['series_info']=$this->series_m->get_by(array('id'=>$id),TRUE);
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['_view'] = DEFAULT_THEME . 'episodes/index';
        $this->data['episode_url_permission'] = $this->ion_auth->checkPermission(82);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

	public function add_episodes_manully(){
				
		$tmbd_idbm = $_REQUEST['tmbd_idbm'];
		$title = $_REQUEST['title'];
		$description = $_REQUEST['description'];
		$episode_url = $_REQUEST['episode_url'];
		$series_id = $_REQUEST['series_id'];
		$season_number = $_REQUEST['season_number'];
		$server_url = $_REQUEST['server_url'];
		$episode_number = $_REQUEST['episode_number'];
		$season_id = $_REQUEST['season_id'];
		
		$series_seasons_all = $this->series_m->get_series_seasons_info_id($season_id);
		/*echo '<pre>';
		print_r($series_seasons_all);exit;*/


		// Get the next available sequence number if not provided or is zero
	    $sequence_id = $_REQUEST['episode_number']; // Using episode number as default sequence
	    if (empty($sequence_id) || $sequence_id == '0') {
	        $sequence_id = $this->episodes_m->get_next_sequence($season_id);
	    } else {
	        // Check if sequence is unique
	        if (!$this->episodes_m->is_sequence_unique($sequence_id, $season_id)) {
	            // If sequence exists, get next available number
	            $sequence_id = $this->episodes_m->get_next_sequence($season_id);
	        }
	    }
		
		$data = array('series_id' => $series_id, 'season_id' => $season_id,
						  'title' => $title,
						  'description' => $description,
						  'actor' => '',
						  'url' => $episode_url,
						  'series_id' => $series_id,
						  'tmdb_id' => $tmbd_idbm,
						  'language_id' => '' ,						   
						  'server_url_id' => $server_url,						  
						  'season_number' => $season_number,
						  'episode_number' => $episode_number,
						  'sequence_id' => $sequence_id					 
						  
						  
					);
					
		$insert_id=$this->episodes_m->save(NULL,$data);
		 //upload files if there is an image 
         
			$this->load->model('series_seasons_m');
		if(isset($_FILES['poster']['name']) && $_FILES['poster']['name']!=''){
                $file_name = $this->upload_image('poster', '', LOCAL_PATH_IMAGES_CMS, 'series_seasons_m',$insert_id);               
							$data = array('image'=>$file_name);
							$this->episodes_m->save($insert_id,$data);
		
							$localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
							//echo $localFilePath;exit;
							$this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
        }else {
					$data = array('image'=>$series_seasons_all->poster);
			//		print_r($data);exit;
                    $this->episodes_m->save($insert_id,$data);
			}
		
		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('episodes/create/'.$insert_id).'" target="_blank">Episodes Manully Added</a>');                    
            $this->session->set_flashdata('success',$title. " Added Successfully.");
            redirect(BASE_URL.'series_seasons/episodes/'.$season_id);
		
	}

	public function add_episodes(){
		$tmbd_idbm = $_REQUEST['tmbd_idbm'];
		$sesice_id = $_REQUEST['sesice_id'];
		$episode_number = $_REQUEST['episode_number'];
		$season_number = $_REQUEST['season_number'];
		$urlvalue = $_REQUEST['urlvalue'];
		$server_url = $_REQUEST['server_url'];
		$series_id = $_REQUEST['series_id'];
		$dbselect = $_REQUEST['dbselect'];
		//$token_id = $_REQUEST['token_id'];
		//echo '<pre>';
		//$getepisodeByID = $this->tmdb_model->getepisodeByID($tmbd_idbm, $season_number,$episode_number);
		$getepisodeByID = $this->tmdb_model->getepisodeByIDimdbTMDB($tmbd_idbm, $season_number,$episode_number,$dbselect);
		
		//print_r($dbselect);exit;
		if($dbselect == 'tmdb'){
			$data = array('season_id' => $sesice_id, 
						  'title' => $getepisodeByID->name,
						  'description' => $getepisodeByID->overview,
						  'actor' => '',
						  'url' => $urlvalue,
						  'server_url_id' => $server_url,
						  'language_id' => '' ,
						  'sequence_id' => $episode_number,
						 // 'token_id' => $token_id,
						  'tmdb_id' => $tmbd_idbm,
						  'season_number' => $season_number,
						  'episode_number' => $episode_number,
						  'series_id' => $series_id
						  
					);
		} 
		elseif($dbselect == 'imdb'){
			$data = array('season_id' => $sesice_id, 
						  'title' => $getepisodeByID->title,
						  'description' => $getepisodeByID->plot,
						  'actor' => '',
						  'url' => $urlvalue,
						  'server_url_id' => $server_url,
						  'language_id' => '' ,
						  'sequence_id' => $episode_number,
						 // 'token_id' => $token_id,
						  'tmdb_id' => $tmbd_idbm,
						  'season_number' => $season_number,
						  'episode_number' => $episode_number,
						  'series_id' => $series_id
						  
					);
		}
				
		
		
		/*echo '<pre>';*/
		//print_r($data);exit;
		//$data = $this->array_from_post($post);
		
		$get_series_seasons_episode_id = $this->episodes_m->get_series_seasons_episode_id($tmbd_idbm,$season_number,$episode_number, $sesice_id, $series_id);
		/*print_r($get_series_seasons_episode_id);exit;*/
		if($get_series_seasons_episode_id->tmdb_id > 0){
			echo json_encode(array('id'=>$sesice_id, 'status' =>'Already Added'));
			//echo '';
		}else{
			$insert_id=$this->episodes_m->save(NULL,$data);
			if($insert_id > 0){
					if($dbselect == 'tmdb'){
				   		$poster_path 	= 	'http://image.tmdb.org/t/p/w500'.$getepisodeByID->still_path;
					} elseif($dbselect == 'imdb'){
						//$this->tmdb_model->getMovieImageResizeIbdm($data['backdrop_path'], '640' ,'360')
						$poster_path 	= 	$this->tmdb_model->getMovieImageResizeIbdm($getepisodeByID->image, '640' ,'360');
					}
					if($poster_path != ""){
						if($this->download_and_save_image($poster_path,LOCAL_PATH_IMAGES_CMS)){
							$file_name= $this->get_file_name_from_url($poster_path);
							$data = array('image'=>$file_name);
							$this->episodes_m->save($insert_id,$data);
		
							$localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
							//echo $localFilePath;exit;
							$this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
						}
					}
					
					echo json_encode(array('id'=>$sesice_id, 'status' =>'success'));
			}else{
				 echo json_encode(array('id'=>$sesice_id, 'status' =>'fail'));		
			}
		}
	}
	
	public function add_episodes_all(){
		$tmbd_idbm = $_REQUEST['tmbd_idbm'];
		$sesice_id = $_REQUEST['sesice_id'];
		$episode_number = $_REQUEST['episode_number'];
		$season_number = $_REQUEST['season_number'];
		$urlvalue = $_REQUEST['urlvalue'];
		$server_url = $_REQUEST['server_url'];
		$series_id = $_REQUEST['series_id'];
		$dbselect = $_REQUEST['dbselect'];
		//$token_id = $_REQUEST['token_id'];
		
		//$getepisodeByID = $this->tmdb_model->getepisodeByID($tmbd_idbm, $season_number,$episode_number);
		$getepisodeByID = $this->tmdb_model->getepisodeByIDimdbTMDB($tmbd_idbm, $season_number,$episode_number,$dbselect);
		/*echo '<pre>';
		print_r($getepisodeByID);exit;*/
		if($dbselect == 'tmdb'){
			$data = array('season_id' => $sesice_id, 
						  'title' => $getepisodeByID->name,
						  'description' => $getepisodeByID->overview,
						  'actor' => '',
						  'url' => $urlvalue,
						  'server_url_id' => $server_url,
						  'language_id' => '' ,
						  'sequence_id' => $episode_number,
						 // 'token_id' => $token_id,
						  'tmdb_id' => $tmbd_idbm,
						  'season_number' => $season_number,
						  'episode_number' => $episode_number,
						  'series_id' => $series_id
						  
					);
		} elseif($dbselect == 'imdb'){
			$data = array('season_id' => $sesice_id, 
						  'title' => $getepisodeByID->title,
						  'description' => $getepisodeByID->plot,
						  'actor' => '',
						  'url' => $urlvalue,
						  'server_url_id' => $server_url,
						  'language_id' => '' ,
						  'sequence_id' => $episode_number,
						 // 'token_id' => $token_id,
						  'tmdb_id' => $tmbd_idbm,
						  'season_number' => $season_number,
						  'episode_number' => $episode_number,
						  'series_id' => $series_id
						  
					);
		}		
		
		
		/*echo '<pre>';*/
		//print_r($data);exit;
		//$data = $this->array_from_post($post);
		
		$get_series_seasons_episode_id = $this->episodes_m->get_series_seasons_episode_id($tmbd_idbm,$season_number,$episode_number, $sesice_id, $series_id);
		/*print_r($get_series_seasons_episode_id);exit;*/
		if($get_series_seasons_episode_id->tmdb_id > 0){
			echo json_encode(array('id'=>$sesice_id, 'status' =>'Already Added'));
			//echo '';
		}else{
			$insert_id=$this->episodes_m->save(NULL,$data);
			if($insert_id > 0){
				   //$poster_path 	= 	'http://image.tmdb.org/t/p/w500'.$getepisodeByID->still_path;
				   if($dbselect == 'tmdb'){
				   		$poster_path 	= 	'http://image.tmdb.org/t/p/w500'.$getepisodeByID->still_path;
					} elseif($dbselect == 'imdb'){
						$poster_path 	= 	$this->tmdb_model->getMovieImageResizeIbdm($getepisodeByID->image, '640' ,'360'); 
					}
					if($poster_path != ""){
						if($this->download_and_save_image($poster_path,LOCAL_PATH_IMAGES_CMS)){
							$file_name= $this->get_file_name_from_url($poster_path);
							$data = array('image'=>$file_name);
							$this->episodes_m->save($insert_id,$data);
		
							$localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
							//echo $localFilePath;exit;
							$this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
						}
					}
					
					echo json_encode(array('id'=>$sesice_id, 'status' =>'success', 'tmbd_idbm' => $tmbd_idbm, 'episode_number' =>$episode_number));
			}else{
				 echo json_encode(array('id'=>$sesice_id, 'status' =>'fail'));		
			}
		}
	}
    
    public function create($season_id){  // season_id
        $rules = $this->episodes_m->rules;
        $this->form_validation->set_rules($rules);

        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
		
		
		/*echo '<pre>';
		print_r($episode_by_seasonid);*/
		$series_seasons_all = $this->series_m->get_series_seasons_info_id($season_id);
		/*echo '<pre>';
		print_r($series_seasons_all);exit;*/
		//$getseasonsAll = $this->tmdb_model->getseasonsAll($tmbd_idbm);
		$getepisodeAll = $this->tmdb_model->getepisodeAll($series_seasons_all->tmdb_id, $series_seasons_all->season_number, $series_seasons_all->dbselect);
		/*echo '<pre>';
		print_r($getepisodeAll);exit;*/
		$episode_added = $this->episodes_m->get_series_seasons_episode_by_seasonid($season_id, $series_seasons_all->season_number, $series_seasons_all->tmdb_id);
		/*echo '<pre>';
		print_r($episode_added);exit;*/
		
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);/*print_r($data);EXIT;*/

            // If sequence_id is empty, get next available sequence
            if (empty($data['sequence_id'])) {
                $data['sequence_id'] = $this->episodes_m->get_next_sequence($season_id);
            }

            // Validate sequence uniqueness
            if (!$this->episodes_m->is_sequence_unique($data['sequence_id'], $season_id)) {
                $this->session->set_flashdata('error', 'This sequence number is already in use.');
                redirect(BASE_URL.'episodes/create/'.$season_id);
                return;
            }


            $insert_id=$this->episodes_m->save(NULL,$data);

             //upload files if there is an image 
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $filename= $this->upload_image('image', '', LOCAL_PATH_IMAGES_CMS, 'episodes_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');  
            } 
            else {
					$data = array('image'=>$series_seasons_all->poster);
				//	print_r($data);exit;
                    $this->episodes_m->save($insert_id,$data);
			}



            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('episodes/edit/'.$insert_id).'" target="_blank">Episode Added</a>');          
            $this->session->set_flashdata('success',"Added Successfully.");
            redirect(BASE_URL.'series_seasons/episodes/'.$season_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Episode', 'episodes/create/'.$season_id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $title="Episode";
       
        //get languages
        $this->load->model('languages_m');
        $this->data['languages']=$this->languages_m->get();

        //get tokens 
        $this->data['tokens']=$this->series_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(6); //serie 6
		
		$this->data['getepisodeAll'] = $getepisodeAll;
		$this->data['episode_added'] = $episode_added;
		$this->data['dbselect'] = $series_seasons_all->dbselect;
		$this->data['tmbd_idbm'] = $series_seasons_all->tmdb_id;
        $this->data['season_id']=$season_id;
		$this->data['season_number'] = $series_seasons_all->season_number;
		$this->data['series_id'] = $series_seasons_all->series_id;
		
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'episodes/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'episodes/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
       ( $id == NULL ) ? redirect( BASE_URL . 'episodes' ) : '';
        
        $episode_info=$this->episodes_m->get($id,TRUE);
        $this->episodes_m->delete($id);
        // $this->episodes_m->delete_channels_groups($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series_seasons/episodes/'.$episode_info->season_id).'" target="_blank">Episode Deleted</a>');          
        $this->session->set_flashdata('success',"Episode Deleted Successfully.");
        redirect( BASE_URL . 'series_seasons/episodes/'.$episode_info->season_id );
    }

    public function edit($id = NULL){
        ( $id == NULL ) ? redirect( BASE_URL . 'episodes' ) : '';
        $rules = $this->episodes_m->rules;
        $this->form_validation->set_rules($rules);
        $episode_info=$this->episodes_m->get($id,TRUE);
        $title="Episode";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);

            // Validate sequence uniqueness
            if (!$this->episodes_m->is_sequence_unique($data['sequence_id'], $episode_info->season_id, $id)) {
                $this->session->set_flashdata('error', 'This sequence number is already in use.');
                redirect(BASE_URL.'episodes/edit/'.$id);
                return;
            }

            $this->episodes_m->save($id,$data);

             //upload files if there is an image 
            if($_FILES['image']['name']!='')
            {
                $filename= $this->upload_image('image', $episode_info->image, LOCAL_PATH_IMAGES_CMS, 'episodes_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

        
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('episodes/edit/'.$id).'" target="_blank">Episode Updated</a>');          
            $this->session->set_flashdata('success',"Edited Successfully.");
            redirect(BASE_URL.'series_seasons/episodes/'.$episode_info->season_id);
        }
   
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit '.$title, 'episodes/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get languages
        $this->load->model('languages_m');
        $this->data['languages']=$this->languages_m->get();
        
        //get tokens 
        $this->data['tokens']=$this->series_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(6); //serie 6
 		$this->data['description']=$episode_info->description;
 		$this->data['actor']=$episode_info->actor;
        $this->data['details'] = $episode_info;
        $this->data['details'] = $episode_info;
        $this->data['season_id']=$episode_info->season_id;
        $this->data['details'] = $episode_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'episodes/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'episodes/edit';
        $this->data['title'] =$title;
        $this->data['page_title'] = "Edit ". $title;
        $this->data['episode_url_permission'] = $this->ion_auth->checkPermission(82);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function get_episodes_by_series($season_id){
        $totaldata = 10;
        $totalfiltered = 10;
        $episodes = $this->episodes_m->get_by(array('season_id'=>$season_id));  // movie type= series =2
        $data = array();
        foreach ($episodes as $episode) {
            $data[] = array(
                    'id'=>$episode['id'],
                    'title'=>$episode['title'],
                    'url'=>$episode['url'],
				 'description'=>$episode['description'],
				 'actor'=>$episode['actor'],
                    'sequence'=>$episode['sequence'],
                    'edit'=>btn_edit(BASE_URL.'episodes/edit/'.$episode['id']),
                    'delete'=>btn_delete(BASE_URL.'episodes/delete/'.$episode['id']),
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

    public function verify_url() {

        $url_type = $this->input->post('url_type');
        
        $server_url_id = $this->input->post('server_url_id');

        $stream_name  = trim($this->input->post('url'));

        // Check if URL is empty
        if (empty($stream_name)) {
            echo json_encode(array('status' => 'error', 'message' => 'URL cannot be empty'));
            return;
        }


        if (!empty($server_url_id)) {
        	// Get the CNAME initial from the database
        	$cname_initial = $this->channels_m->get_server_url_by_id($server_url_id);
        	$url = rtrim($cname_initial, '/') . '/' . ltrim($stream_name, '/');        	
        }else{
        	$url = $stream_name;
        }
        
        // Load the AkamaiTokenVerifier library
        $this->load->library('AkamaiTokenVerifier');
        
        // Verify the URL and get the URL with token
        $result = $this->akamaitokenverifier->verifyUrl($url);
        
        echo json_encode($result);
    }

    public function get_server_url() {
        $server_url_id = $this->input->post('server_url_id');
        
        $this->load->model('server_items_urls_m');
        $server_url = $this->server_items_urls_m->get($server_url_id);

        if ($server_url) {
            echo json_encode(array('status' => 'success', 'server_url' => $server_url->url));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Server URL not found'));
        }
    }

    public function check_sequence_unique($sequence_id) {
        $season_id = $this->input->post('season_id');
        $episode_id = $this->uri->segment(3); // For edit mode
        
        return $this->episodes_m->is_sequence_unique($sequence_id, $season_id, $episode_id);
    }
}
