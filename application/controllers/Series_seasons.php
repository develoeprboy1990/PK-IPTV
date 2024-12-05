<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Series_seasons extends User_Controller {

    public function __construct()
    {
        parent::__construct(); 
        $this->data['is_allow']= check_permission(23);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('series_seasons_m');
        /* Title Page :: Common */
        $this->page_title->push('Series Seasons');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['main_nav'] = "sod";
        $this->data['sub_nav'] = "series";
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Series Seasons', 'series_seasons');
    }
	public function add_seasion(){
		$tmbd = $_REQUEST['tmbd_idbm'];
		$id = $_REQUEST['id'];
		$sesice_id = $_REQUEST['sesice_id'];
		$dbselect = $_REQUEST['dbselect'];
		
		$this->load->model('tmdb_model');
		$this->load->model('series_stores_m');
		
		$getseasonsDetails = $this->tmdb_model->getseasonsmyid($tmbd);
		
		$getseasonsbycredits = $this->tmdb_model->getseasonsbycredits($tmbd);
		/*echo '<pre>';
		print_r($getseasonsbycredits);exit;*/
		$creditsArray = array();
		$c = 1;
		foreach($getseasonsbycredits as $key=>$val){
			if($val->known_for_department == 'Acting' && $c <= 5){
				array_push($creditsArray,$val->name);
				$c++;
			}
			
		}
		/*echo '<pre>';
		print_r($creditsArray);exit;*/
		
		$session_details_arr = $getseasonsDetails->seasons;		
		$season_number = 0;
		$poster_pathbb = '';
		foreach($session_details_arr as $key=>$val){
			if($id == $val->id){
				$data = array('name' => $val->name, 
						'series_id' => $sesice_id, 
						'season_number' => $val->season_number,
						'is_kids_friendly' => '',
    					'childlock' => '',
    					'year' => $val->air_date,
    					'actor' => implode(',',$creditsArray),
    					'language' => $getseasonsDetails->original_language,
    					'tags' => '',    					
    					'rating' => round($getseasonsDetails->vote_average),
    					'overlay_enabled' => '',
    					'preroll_enabled' => '',
    					'ticker_enabled' => '',
    					'show_on_home' => '',
    					'tmdb_id' => $tmbd,
    					'imported' => 0,						
						'description' => $getseasonsDetails->overview,
						'poster' =>  'http://image.tmdb.org/t/p/w500'.$val->poster_path,
						'backdrop' =>  'http://image.tmdb.org/t/p/w1280'.$getseasonsDetails->backdrop_path
						);
				$season_number = $val->season_number;
				$poster_pathbb = $val->poster_path;
			}
		}
		
		$get_seasons_series = $this->series_seasons_m->get_seasons_series_id($getseasonsDetails->id,$season_number);
		
		if($get_seasons_series->tmdb_id > 0){			
			echo json_encode(array('id'=>$sesice_id, 'data'=>$data, 'status' =>'success'));
		}else{
			echo json_encode(array('id'=>$sesice_id, 'data'=>$data, 'status' =>'success'));
		}
		
	}
	
    public function create($series_id){  
        $this->load->model('languages_m');
        $this->load->model('series_m');
		$this->load->model('series_stores_m');
        $this->load->model('movie_tags_m');
		$this->load->model('tmdb_model');
		
		$this->load->model('series_seasons_m');
        $rules = $this->series_seasons_m->rules;
        $this->form_validation->set_rules($rules);
		
		
		
		$series_info = $this->series_m->get_store_info_id($series_id);
		$tmbd_idbm = $series_info->tmbd_id;
		$dbselect = $series_info->dbselect;
		//$getseasonsAll = $this->tmdb_model->getseasonsAll($tmbd_idbm);
		$getseasonsAll = $this->tmdb_model->getseasonsAllIMDBtmdb($tmbd_idbm,$dbselect);
		
		/*echo '<pre>';
		print_r($series_info);*/
		
		$seriesseasons =  $this->series_seasons_m->get_by(array('series_id'=>$series_id));
		
		$sersess = array();
		foreach($seriesseasons as $key=>$val){
			//$sersess[] = $val['tmdb_id'];
			array_push($sersess,$val['season_number']);
		}
		/*echo '<pre>';
		print_r($getseasonsAll);exit;*/
		$getseasonsAllFinal = array();
		if($dbselect == 'tmdb'){
			foreach($getseasonsAll as $key=>$val){
				//print_r($val);
				if (!in_array($val->season_number, $sersess)){			
					$getseasonsAllFinal[] = $val;
				}
			}
		}elseif($dbselect == 'imdb'){
			foreach($getseasonsAll as $val){
				//print_r($val);
				if (!in_array($val->season_number, $sersess)){			
					$getseasonsAllFinal[] = $val;
				}
			}
		}
		
        $title='Season';
        $post=array(); 
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post); 
			/*echo '<pre>';
			print_r($data);exit;*/
            $insert_id=$this->series_seasons_m->save(NULL,$data);
            
            //upload files if there is an image 
            if(isset($_FILES['poster']['name']) && $_FILES['poster']['name']!=''){
                $filename= $this->upload_image('poster', '', LOCAL_PATH_IMAGES_CMS, 'series_seasons_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
    			$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }else {
					$data = array('poster'=>$series_info->logo);
                    $this->series_seasons_m->save($insert_id,$data);
				}

            if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='')
            {
                $filename= $this->upload_image('backdrop','', LOCAL_PATH_IMAGES_CMS, 'series_seasons_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
    			$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }else {
					$data = array('backdrop'=>$series_info->logo);
                    $this->series_seasons_m->save($insert_id,$data);
				}

            if($this->input->post('thumb_link')!=""){ 
				if($dbselect == 'imdb'){
					$thumb_link = $this->tmdb_model->getMovieImageResizeIbdm($this->input->post('thumb_link'), '342' ,'513'); 					
				} else{
					$thumb_link = $this->input->post('thumb_link');
				}
				
				
                if($this->download_and_save_image($thumb_link,LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($thumb_link);
					//echo $file_name;exit;
                    $data = array('poster'=>$file_name);
                    $this->series_seasons_m->save($insert_id,$data);										
                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;					
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                } else {
					$data = array('poster'=>$series_info->logo);
                    $this->series_seasons_m->save($insert_id,$data);
				}
            }

            if($this->input->post('poster_link')!=""){
				if($dbselect == 'imdb'){
					$poster_link = $this->tmdb_model->getMovieImageResizeIbdm($this->input->post('poster_link'), '1280' ,'720'); 					
				} else{
					$poster_link = $this->input->post('poster_link');
				}
                if($this->download_and_save_image($poster_link,LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($poster_link);
					
                    $data = array('backdrop'=>$file_name);
                    $this->series_seasons_m->save($insert_id,$data);

                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                }else {
					$data = array('backdrop'=>$series_info->logo);
                    $this->series_seasons_m->save($insert_id,$data);
				}
            }

             // insert tags
            if(is_array($this->input->post('tags')) && count($this->input->post('tags'))>0){
                foreach ($this->input->post('tags') as $tag_id) {
                   $data=array(
                        'tag_id'=>$tag_id,
                        'series_id'=>$insert_id
                    );
                   $this->db->insert('series_to_tags',$data);
                }
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series_seasons/edit/'.$insert_id).'" target="_blank">Season Added</a>');                    
            $this->session->set_flashdata('success',$title. " Added Successfully.");
            redirect(BASE_URL.'series/seasons/'.$series_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'series_seasons/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
       
        //get languages
        $this->data['languages']=$this->languages_m->get();
        
         //get tags
        $this->data['tags']=$this->movie_tags_m->get();

        //get tokens 
        $this->data['tokens']=$this->series_seasons_m->get_tokens();
		//echo $tmbd_idbm;exit;
		$this->data['tmbd_idbm'] = $tmbd_idbm;
		
		$this->data['dbselect'] = $dbselect;
		/*echo '<pre>';
		print_r( $getseasonsAll);
		exit;*/
		//$this->data['getseasonsAll'] = $getseasonsAll;
		
		$this->load->model('series_m');
		$series_info=$this->series_m->get($series_id,TRUE);
		// Make sure language name is included
		$series_info->language_name = $this->languages_m->get($series_info->language_id)->name;

		$this->data['series_info'] = $series_info;
		
		$this->data['getseasonsAll'] = $getseasonsAllFinal;
        $this->data['series_id']=$series_id;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'series_seasons/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'series_seasons/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
 

    public function delete($id = NULL)
    {
        //$this->load->model('episodes_m');
       ( $id == NULL ) ? redirect( BASE_URL . 'series' ) : '';
        
        $info=$this->series_seasons_m->get($id, TRUE);
        
        // if($channel_info->channel_image)
        // {
        //     if(file_exists("./uploads/series/".$channel_info->channel_image))
        //         @unlink("./uploads/series/".$channel_info->channel_image);
        // }

        // if($channel_info->channel_image_icon)
        // {
        //     if(file_exists("./uploads/series_seasons/icons/".$channel_info->channel_image_icon))
        //         @unlink("./uploads/series_seasons/icons/".$channel_info->channel_image_icon);
        // }
        // delete episodes too
        $this->series_seasons_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series/seasons/'.$info->series_id).'" target="_blank">Season Deleted</a>');                    
        $this->session->set_flashdata('success',"Season Deleted Successfully.");
        redirect( BASE_URL . 'series/seasons/'.$info->series_id);
    }

    public function edit($id = NULL)
    {   
        $this->load->model('languages_m');
        $this->load->model('movie_tags_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'series' ) : '';
        $title='Season';
        $rules = $this->series_seasons_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->series_seasons_m->get($id,TRUE);
		
		/*$this->load->model('series_m');
		$series_info=$this->series_m->get($info->series_id,TRUE);
		echo '<pre>';
		print_r($series_info);*/
		
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $this->series_seasons_m->save($id,$data);

             //upload files if there is an image 
           // if($_FILES['poster']['name']!=''){ 
			if(isset($_FILES['poster']['name']) && $_FILES['poster']['name']!='') {
                $filename= $this->upload_image('poster', $info->poster, LOCAL_PATH_IMAGES_CMS, 'series_seasons_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
    			$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            //if($_FILES['backdrop']['name']!='') {
			 if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='') {
                $filename= $this->upload_image('backdrop',$info->backdrop, LOCAL_PATH_IMAGES_CMS, 'series_seasons_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
    			$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            if(is_array($this->input->post('tags')) && count($this->input->post('tags'))>0){
                
                // first delete all 
                $this->movie_tags_m->delete_tags_by_series($id);

                foreach ($this->input->post('tags') as $tag_id) {
                   $data=array(
                        'tag_id'=>$tag_id,
                        'series_id'=>$id
                    );
                   $this->db->insert('series_to_tags',$data);
                }
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series_seasons/edit/'.$id).'" target="_blank">Season Updated</a>');                    
            $this->session->set_flashdata('success',$title." Edited Successfully.");
            redirect(BASE_URL.'series/seasons/'.$this->input->post('series_id'));
        }
       
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit '.$title, 'series_seasons/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get tokens 
        $this->data['tokens']=$this->series_seasons_m->get_tokens();
        
        //get languages
        $this->data['languages']=$this->languages_m->get();
        $this->data['series_id']= $info->series_id;

         // get all genres by store_id 
        $this->data['tags'] =$this->movie_tags_m->get();
        
        // get all selected genres 
        $this->data['selected_tags'] =$this->movie_tags_m->get_tags_by_series($id);

        $this->data['details'] = $info;
		
		$this->load->model('series_m');
		$series_info=$this->series_m->get($info->series_id,TRUE);
		$series_info->language_name = $this->languages_m->get($series_info->language_id)->name;
		$this->data['series_info'] = $series_info;
		
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'series_seasons/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'series_seasons/edit';
        $this->data['title'] =$title;
        $this->data['page_title'] = "Edit ". $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function episodes($season_id){
        $this->load->model('series_seasons_m');
        $this->load->model('episodes_m');
		 $this->load->library('SimpleXLSX');
		$season_info = $this->series_seasons_m->get_by(array('id'=>$season_id), True);		
		/*echo '<pre>';
		print_r($season_info);
		exit;*/
		if(isset($_REQUEST['import_csv'])){
				$tmpName = $_FILES['csv']['tmp_name'];
				$tmpNameData = file($tmpName);
	
			if ($xlsx = SimpleXLSX::parse($tmpName)) {
				$excelArray = $xlsx->rows();
				$firstCol = $excelArray[0];	
	
				for($i=1 ; $i < count($excelArray) ; $i++){	
						$csvArray[] = array(
												$firstCol[0] => $excelArray[$i][0],
												$firstCol[1] => $excelArray[$i][1],
												$firstCol[2] => $excelArray[$i][2],
												$firstCol[3] => $excelArray[$i][3],
												$firstCol[4] => $excelArray[$i][4],
												$firstCol[5] => $excelArray[$i][5],	
											);
				}
	
				$this->load->model('episodes_m');
				foreach($csvArray as $key=>$val){
					$data = array('title' => $val['title'],
									'description' => $val['description'],
									'actor' => $val['actor'],
									'url' => $val['url'],
									'image' => $val['image'],
									'episode_number' => $val['episode_number'],
									'sequence_id' => $val['episode_number'],
									'series_id' => $season_info->series_id,
									'season_number' => $season_info->season_number,
									'season_id' => $season_id,
									'server_url_id' => '12'
								);								
					$insert_id=$this->episodes_m->save(NULL,$data);
					//print_r($data);
					if($val['image'] != ""){ 						
						if($this->download_and_save_image($val['image'],LOCAL_PATH_IMAGES_CMS)){
							$file_name= $this->get_file_name_from_url($val['image']);
							$data = array('image'=>$file_name);
							$this->episodes_m->save($insert_id,$data);		
							$localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;							
							$this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
						}
					}
				}
				} else {
					echo SimpleXLSX::parseError();
				}




				/*echo '<pre>';
				print_r($tmpNameData);exit;*/
				/*$firstCol = explode(',',$tmpNameData[0]);				
				$csvArray = array();
				for($i=1 ; $i < count($tmpNameData) ; $i++){
					$ppp = explode("','",substr($tmpNameData[$i],1,-1));
					foreach($ppp as $key=>$val){					
						$fff[trim($firstCol[$key])] = $val;
					}
					$csvArray[] = $fff;
				}
				$this->load->model('episodes_m');
				foreach($csvArray as $key=>$val){
					$data = array('title' => $val['title'],
									'description' => $val['description'],
									'actor' => $val['actor'],
									'url' => $val['url'],
									'image' => $val['image'],
									'episode_number' => $val['episode_number'],
									'sequence_id' => $val['episode_number'],
									'series_id' => $season_info->series_id,
									'season_number' => $season_info->season_number,
									'season_id' => $season_id
								);								
					$insert_id=$this->episodes_m->save(NULL,$data);
					if($val['image'] != ""){ 						
						if($this->download_and_save_image($val['image'],LOCAL_PATH_IMAGES_CMS)){
							$file_name= $this->get_file_name_from_url($val['image']);
							$data = array('image'=>$file_name);
							$this->episodes_m->save($insert_id,$data);		
							$localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;							
							$this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
						}
					}
				}*/
				
		}
		
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'episodes/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'episodes/index';
        $this->data['page_title'] = "Seasons Episodes";
        $this->data['add_text'] = "Add an Episode";
		$this->data['import_text'] = "Bulk Import";
        $this->data['season_id'] = $season_id;
        $this->data['season_info'] =  $season_info;
        $this->data['episodes'] =  $this->episodes_m->get_by(array('season_id'=>$season_id));
        
        /* Breadcrumbs */
       // $this->breadcrumbs->unshift(2,'Edit '.$title, 'series_seasons/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['episode_url_permission'] = $this->ion_auth->checkPermission(82);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

	public function downloadcsv(){
			$url = 'http://imserver.threeiptv.com/xtv_client/Sample_Episode.xlsx';
			header("Content-Description: File Transfer"); 
			header("Content-Type: application/octet-stream"); 
			header(
			"Content-Disposition: attachment; filename=\""
			. 'Sample Episodes.xlsx' . "\""); 
			
			 
    		readfile ($url);
	}
    public function import_season(){  
        $response= array();        
        $id = trim($this->input->post("id")); // $id = 911-kaun-banega-crorepati;
      
        // check if already imported 
        if($this->series_seasons_m->get_by(array('tmdb_id'=>$id))){
           $response['imdb_status']  = "fail";
           $response['error_message']  = "Already Imported";
           echo json_encode($response);
        }else{
            $response['submitted_data'] = $this->input->post();
            $this->load->model('tmdb_model');
           
            $data = $this->tmdb_model->get_tvseries_info($id);            
            
            //var_dump($data);       
            if(isset($data['status']) && $data['status']=='success'){
                $response['imdb_status']    = 'success';
                $response['tmdb_id']         = $data['tmdb_id'];
                $response['title']          = $data['title'];
                $response['plot']           = $data['plot'];
                $response['runtime']        = $data['runtime'];
                $response['studio']         = $data['studio'];
                $response['actor']          = $data['actor'];
                $response['director']       = $data['director'];
                $response['producer']       = $data['producer'];
                $response['genre']          = $data['genre'];
                $response['rating']         = ceil($data['rating']);
                $response['release']        = $data['release'];
                $response['thumbnail']      = $data['thumbnail'];
                $response['poster']         = $data['poster'];
                $response['response']       = 'yes';
            }
            else{
                $response['imdb_status']    = 'fail';
                $response['title']          = '';
                $response['plot']           = '';
                $response['runtime']        = '';
                $response['actor']          = '';
                $response['rating']         = '';
                $response['release']        = '';
                $response['thumbnail']      = '';
                $response['poster']         = '';
                $response['response']       = 'no';
            }
            echo json_encode($response);
        }
    }

}
