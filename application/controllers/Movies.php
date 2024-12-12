<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends User_Controller {
    public function __construct(){
        parent::__construct();
        $this->data['is_allow']= check_permission(43);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('movies_m');
        $this->load->model('movie_ott_platforms_m');
        /* Title Page :: Common */
        $this->page_title->push('Movies');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "movies";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'movies', 'movies');
    }
	public function updategens(){
		 $allmovies = $this->movies_m->get();
			echo '<pre>';
		  
		  $this->load->model('movies_m');
		 foreach($allmovies as $key=>$val){
		 	$select_genres = $this->movies_m->get_genres_by_movie($val['id']);
			print_r($select_genres);
			$data_select_genres = array('select_genres'=>implode(',',$select_genres));
            $this->movies_m->save($val['id'],$data_select_genres);
		 }
	}
	public function updategens_new(){		 
		$this->load->model('movie_stores_m');
		$sql = "SELECT `id`,  `store_id` , `select_genres` FROM `movie`";
		$query = $this->db->query($sql);
		
		foreach ($query->result() as $movie) {		
			$parent_id=$this->movie_stores_m->check_if_parent_mul($movie->store_id);
			$this->movies_m->delete_genres_by_movie($movie->id);
			 
			 $select_genres = explode(',',$movie->select_genres);
			 //print_r($select_genres);
				 foreach($select_genres as $val){
				   $data=array(
								'genre_id'=>$val,
								'movie_id'=>$movie->id,
								'store_id' => $parent_id,
								'substore_id' => $movie->store_id
							);
							
						  
						   $this->db->insert('movie_to_genres',$data);
				}		   
		
		}
	}

	// Modified Movies Controller - index method
	// In Movies.php controller:

	public function index($id='') {
	    check_allow('view',$this->data['is_allow']);
	    $this->data['_extra_scripts'] = DEFAULT_THEME . 'movies/_extra_scripts';
	    $this->data['_view'] = DEFAULT_THEME . 'movies/index';
	    $this->data['page_title'] = "Movies";
	    $this->data['add_text'] = "Add a Movie";
	    $this->data['type'] = 1;
	    $this->data['breadcrumb'] = $this->breadcrumbs->show();
	    
	    // Load all required models
	    $this->load->model('movie_stores_m');
	    $this->load->model('languages_m');
	    $this->load->model('movie_tags_m');
	    
	    // Get store/language data for dropdowns
	    $store_substore = $this->movie_stores_m->fetch_all_sub_stores();
	    $languages = $this->languages_m->get();
	    
	    // Process store data
	    $store_get = array();
	    $sub_store_get = array();
	    foreach($store_substore as $val) {
	        if($val['parent_id'] == '0') {
	            $store_get['id_'.$val['id']] = $val['name'];
	        } else {
	            $sub_store_get['id_'.$val['id']] = array(
	                'name' => $val['name'], 
	                'parent_id' => $val['parent_id']
	            );
	        }
	    }
	    
	    // Process language data
	    $languages_array = array();
	    foreach($languages as $val) {
	        $languages_array['lang_'.$val['id']] = $val['name'];
	    }
	    
	    // Get and process genres
	    $all_genres = $this->movies_m->get_genres_by_store('');
	    $all_genres_array = array();
	    foreach($all_genres as $val) {
	        $all_genres_array['id_'.$val->id] = $val->name;
	    }
	    
	    // Get and process tags
	    $allmovie_tags = $this->movie_tags_m->get();
	    $allmovie_tags_array = array();
	    foreach($allmovie_tags as $val) {
	        $allmovie_tags_array['tags_'.$val['id']] = $val['name'];
	    }
	    
	    // Get OTT platforms
	    $this->load->model('movie_ott_platforms_m');
	    $all_ott_platforms = $this->movie_ott_platforms_m->get();
	    $ott_platforms_array = array();
	    foreach($all_ott_platforms as $platform) {
	        $ott_platforms_array['platform_'.$platform['id']] = $platform['name'];
	    }
	    
	    // Store all data in session for AJAX endpoint to use
	    $this->session->set_userdata('movie_reference_data', array(
	        'genres' => $all_genres_array,
	        'tags' => $allmovie_tags_array,
	        'ott_platforms' => $ott_platforms_array,
	        'languages' => $languages_array,
	        'store' => $store_get,
	        'sub_store' => $sub_store_get
	    ));
	    
	    // Pass data to view
	    $this->data['genres'] = $all_genres_array;
	    $this->data['languages'] = $languages_array;
	    $this->data['store'] = $store_get;
	    $this->data['sub_store'] = $sub_store_get;
	    $this->data['tags'] = $allmovie_tags_array;
	    $this->data['ott_platforms'] = $ott_platforms_array;
	    $this->data['movie_url_permission'] = $this->ion_auth->checkPermission(82);
	    
	    $this->load->view(DEFAULT_THEME . '_layout', $this->data);
	}
	public function get_movies_data() {
	    // Load reference data from session
	    $reference_data = $this->session->userdata('movie_reference_data');
	    //print_r($reference_data);
	    
	    $draw = $this->input->post('draw');
	    $start = $this->input->post('start');
	    $length = $this->input->post('length');
	    $search = $this->input->post('search')['value'];
	    $order = $this->input->post('order')[0];
	    //print_r($order);
	    
	    // Get filtered records
	    $movies = $this->movies_m->get_filtered_movies($start, $length, $search, $order);
	    $total_records = $this->movies_m->get_total_movies();
	    $filtered_records = $this->movies_m->get_filtered_count($search);
	    
	    $data = array();
	    foreach($movies as $movie) {
	        // Process store data
	        @$store_id = explode(',', $movie['store_id']);
	        $storeparentid = @$reference_data['sub_store']['id_'.@$store_id[0]]['parent_id'];

	        $store_name = $storeparentid == '' ? 
	            @$reference_data['store']['id_'.@$movie['store_id']] : 
	            @$reference_data['store']['id_'.@$storeparentid];
	            
	        // Process tags
	        $movie_tags = explode(',', $movie['tags']);
	        $tag_string = '';
	        foreach($movie_tags as $tag) {
	            if(isset($reference_data['tags']['tags_'.$tag])) {
	                $tag_string .= $reference_data['tags']['tags_'.$tag] . ', ';
	            }
	        }
	        $tag_string = rtrim($tag_string, ', ');
	        
	        // Process genres
	        $movie_genres = explode(',', $movie['select_genres']);
	        $genres_string = '';
	        foreach($movie_genres as $genre) {
	            if(isset($reference_data['genres']['id_'.$genre])) {
	                $genres_string .= $reference_data['genres']['id_'.$genre] . ', ';
	            }
	        }
	        $genres_string = rtrim($genres_string, ', ');
	        
	        // Process OTT platforms
	        $ott_string = "No Selection";
	        if (!empty($movie['ott_platforms'])) {
	            $platforms = explode(',', $movie['ott_platforms']);
	            $platform_string = '';
	            foreach($platforms as $platform) {
	                if(isset($reference_data['ott_platforms']['platform_'.$platform])) {
	                    $platform_string .= $reference_data['ott_platforms']['platform_'.$platform] . ', ';
	                }
	            }
	            $ott_string = rtrim($platform_string, ', ');
	        }
	        
	        $row = array();
	        $row[] = '<a href="'.site_url('movies/edit/'.$movie['id']).'">'.$movie['id'].'</a>';
	        $row[] = ucwords(stripslashes($movie['name']));
	        $row[] = '<img src="'.base_url().LOCAL_PATH_IMAGES_CMS.$movie['poster'].'" width="50">';
	        $row[] = '<img src="'.base_url().LOCAL_PATH_IMAGES_CMS.$movie['backdrop'].'" width="80" style="display:none;" class="backdrop_row">';
	        $row[] = $store_name;
	        $row[] = $tag_string;
	        $row[] = $genres_string;
	        $row[] = $ott_string;
	        $row[] = @$reference_data['languages']['lang_'.$movie['language']];
	        $row[] = $movie['year'];
	        $row[] = ucwords($movie['actor']);
	        $row[] = $movie['trailer'];
	        $row[] = $movie['rating'];
	        $row[] = $movie['age_rating'];
	        $row[] = ($movie['show_on_home']==1) ? "ON" : "OFF";
	        $row[] = ($movie['status']==1) ? "Active" : "Disabled";
	        $row[] = $movie['user'];
	        
	        // Action buttons
	        $actions = '<div class="btn-group" role="group">';
	        $actions .= '<a href="'.BASE_URL.'movies/edit/'.$movie['id'].'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
	        $actions .= '<a href="'.BASE_URL.'movies/delete/'.$movie['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure?\');"><i class="fa fa-trash"></i> Delete</a>';
	        $actions .= '<a href="javascript:void(0);" class="btn btn-xs btn-success play-movie" data-movie-id="'.$movie['id'].'"><i class="fa fa-play"></i> Play</a>';
	        $actions .= '</div>';
	        $row[] = $actions;
	        
	        $data[] = $row;
	    }
	    
	    $output = array(
	        "draw" => intval($draw),
	        "recordsTotal" => $total_records,
	        "recordsFiltered" => $filtered_records,
	        "data" => $data
	    );
	    
	    echo json_encode($output);
	}
	public function movieSearch(){
		$moviesearch_val = $_REQUEST['moviesearch_val'];
		
		
		if(trim($moviesearch_val) == ''){
			$row_peg = 20;
		} else{
			$row_peg = 500;
		}
		if($id != ''){
			$start_limit = (!isset($id)) ? '0' : ($id*$row_peg);
		}
		$get_all_movies = $this->movies_m->get_allmovies_search($start_limit, $row_peg, $moviesearch_val);
		
		
		
		
		$this->load->model('movie_stores_m');
		$store_substore = $this->movie_stores_m->fetch_all_sub_stores();
		 
		foreach($store_substore as $key=>$val){
			if($val['parent_id'] == '0'){
				$store_get['id_'.$val['id']] = $val['name'];
			} else{
				$sub_store_get['id_'.$val['id']] = array('name' => $val['name'], 'parent_id' => $val['parent_id']);
			}
		}
		
		//get languages
		$this->load->model('languages_m');
		$languages = $this->languages_m->get();
		foreach($languages as $key=>$val){
			$languages_array['lang_'.$val['id']] = $val['name'];
		}
		
		 // get all genres by store_id 
		 
		$all_genres = $this->movies_m->get_genres_by_store('');
		foreach($all_genres as $key=>$val){
			$all_genres_array['id_'.$val->id] = $val->name;
		}
		
		
		
        $genres = $all_genres_array;
		
        $languages = $languages_array;
		$store = $store_get;
		$sub_store = $sub_store_get;
		
		
		
		// get all genres by store_id 
		$this->load->model('movie_tags_m');
		$allmovie_tags = $this->movie_tags_m->get();
		
		foreach($allmovie_tags as $key=>$val){
			$allmovie_tags_array['tags_'.$val['id']] = $val['name'];
		}		
        $tags = $allmovie_tags_array;       
     
	 
	 
	 
	 
		
		foreach ($get_all_movies as $movie) { 
					$movie_list = '<tr>
                                       <td>'.$movie['id'].'</td>
                                       <td>'.ucwords(stripslashes($movie['name'])).'</td>
									   <td class="poster_row"><img src="'.base_url().LOCAL_PATH_IMAGES_CMS.$movie['poster'].'" width="50" ></td>
									   <td style="display:none;" class="backdrop_row"><img src="'.base_url().LOCAL_PATH_IMAGES_CMS.$movie['backdrop'].'" width="80" ></td>';
									   
											
										$store_id = explode(',',$movie['store_id']);
										//echo $store_id[0];
										$storeparentid = $sub_store['id_'.$store_id[0]]['parent_id'];
										//$store_name_set = $store['id_'.$storeparentid];
										if($storeparentid == ''){
											$store_name_set = $store['id_'.$movie['store_id']];
										}else{
											$store_name_set = $store['id_'.$storeparentid];
										}
										
										$sub_store_name_set = '';
										foreach($store_id as $val){												
											$sub_store_name_set.=$sub_store['id_'.$val]['name'].' , ';
										}
										
						$movie_list .=  '<td class="store_row">'.$store_name_set.'</td>
									     <td class="movie_tag_row">';
									  
										   $movie_tag = explode(',',$movie['tags']);
										   $tag_string = '';
										   foreach($movie_tag as $val){
												$tag_string.=	$tags['tags_'.$val].' , ';
										   }
									   
						$movie_list .= rtrim($tag_string,' , ').'</td>';
						$movie_list .= '<td class="movie_gen_row">';
									  
									   $movie_tag = explode(',',$movie['select_genres']);
									   $tag_string = '';
									   foreach($movie_tag as $val){
									   		$tag_string.=	$genres['id_'.$val].' , ';
									   }
									   
					$movie_list .= rtrim($tag_string,' , ').'</td>';
					$movie_list .=   '<td class="language_row">'.$languages['lang_'.$movie['language']].'</td>';
                    $movie_list .=   '<td class="myear_row" style="display:none;">'.$movie['year'].'</td>';
                    $movie_list .=	 '<td style="display:none;" class="mcast_row">'.ucwords($movie['actor']).'</td>';
					$movie_list .=   '<td style="display:none;" class="trailer_row">'.$movie['trailer'].'</td>';
					$movie_list .=	 '<td class="rating_row">'.$movie['rating'].'</td>';
					$movie_list .= 	 '<td style="display:none;" class="crating_row">'.$movie['age_rating'].'</td>';
					$show_on_home_string = ($movie["show_on_home"]==1) ? "ON" : "OFF";
                    $movie_list .= 	 '<td>'.$show_on_home_string .'</td>';
					$status_str = ($movie['status']==1) ? "Active" : "Disabled";
					$movie_list .= 	 '<td>'.$status_str.'</td>';
					$movie_list .=	 '<td class="user_id_row">'.$movie['user'].'</td>';
                    $movie_list .= 	 '<td>'.btn_edit(BASE_URL.'movies/edit/'.$movie['id']).btn_delete(BASE_URL.'movies/delete/'.$movie['id']).'</td>';
                    $movie_list .= 	 '</tr>';
					
					//$movie_list .= $this->pagination->create_links();
					echo $movie_list;
					
					 
                                    
		}
	}
	public function indexxxx(){
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'movies/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'movies/index';
        $this->data['page_title'] = "Movies";
        $this->data['add_text'] = "Add a Movie";
        $this->data['type'] = 1;
        /* Breadcrumbs */
		/*echo '<pre>';
		print_r($this->movies_m->get_allmovies());exit;*/
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['movies'] = $this->movies_m->get();
		
		$this->load->model('movie_stores_m');
		$store_substore = $this->movie_stores_m->fetch_all_sub_stores();
		 
		foreach($store_substore as $key=>$val){
			if($val['parent_id'] == '0'){
				$store_get['id_'.$val['id']] = $val['name'];
			} else{
				$sub_store_get['id_'.$val['id']] = array('name' => $val['name'], 'parent_id' => $val['parent_id']);
			}
		}
		/*echo '<pre>';
		print_r($sub_store_get);exit;*/
		//get languages
		$this->load->model('languages_m');
		$languages = $this->languages_m->get();
		foreach($languages as $key=>$val){
			$languages_array['lang_'.$val['id']] = $val['name'];
		}
		/*
		echo '<pre>';
		print_r($languages_array); exit;
		*/
		
		 // get all genres by store_id 
		 
		$all_genres = $this->movies_m->get_genres_by_store('');
		foreach($all_genres as $key=>$val){
			$all_genres_array['id_'.$val->id] = $val->name;
		}
		
		/*echo '<pre>';
		print_r($all_genres_array); exit;*/
		
        $this->data['genres'] = $all_genres_array;
		
        $this->data['languages']=$languages_array;
		$this->data['store'] = $store_get;
		$this->data['sub_store'] = $sub_store_get;
		
		
		
		// get all genres by store_id 
		$this->load->model('movie_tags_m');
		$allmovie_tags = $this->movie_tags_m->get();
		
		foreach($allmovie_tags as $key=>$val){
			$allmovie_tags_array['tags_'.$val['id']] = $val['name'];
		}		
        $this->data['tags'] = $allmovie_tags_array;       
     
		
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
	public function overviews(){
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'movies/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'movies/overviews';
        $this->data['page_title'] = "Movies";
        $this->data['add_text'] = "Overviews a Movie";
        $this->data['type'] = 1;
		
		 $this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "overviews";
		
        /* Breadcrumbs */
		if(@$type !="" ){
             $this->data['type'] = @$type;
        }

 		$this->breadcrumbs->unshift(2, 'Overviews '.@$title, 'movies/overviews/'.@$type);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		
        $this->data['movies'] = $this->movies_m->get();
		
		$this->load->model('movie_stores_m');
		$store_substore = $this->movie_stores_m->fetch_all_sub_stores();
		 
		foreach($store_substore as $key=>$val){
			if($val['parent_id'] == '0'){
				$store_get['id_'.$val['id']] = $val['name'];
			} else{
				$sub_store_get['id_'.$val['id']] = array('name' => $val['name'], 'parent_id' => $val['parent_id']);
			}
		}
		/*echo '<pre>';
		print_r($sub_store_get);exit;*/
		//get languages
		$this->load->model('languages_m');
		$languages = $this->languages_m->get();
		foreach($languages as $key=>$val){
			$languages_array['lang_'.$val['id']] = $val['name'];
		}
		/*
		echo '<pre>';
		print_r($languages_array); exit;
		*/
		
		 // get all genres by store_id 
		 
		$all_genres = $this->movies_m->get_genres_by_store('');
		foreach($all_genres as $key=>$val){
			$all_genres_array['id_'.$val->id] = $val->name;
		}
		
		/*echo '<pre>';
		print_r($all_genres_array); exit;*/
		
        $this->data['genres'] = $all_genres_array;
		
        $this->data['languages']=$languages_array;
		$this->data['store'] = $store_get;
		$this->data['sub_store'] = $sub_store_get;
		
		
		
		// get all genres by store_id 
		$this->load->model('movie_tags_m');
		$allmovie_tags = $this->movie_tags_m->get();
		
		foreach($allmovie_tags as $key=>$val){
			$allmovie_tags_array['tags_'.$val['id']] = $val['name'];
		}		
        $this->data['tags'] = $allmovie_tags_array;       
     
		
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
    public function create($type=""){  // type 1 default: movie, 2: series 
		
        check_allow('create',$this->data['is_allow']);
        $this->load->model('languages_m');
        $this->load->model('movie_tags_m');
        $this->load->model('movie_genres_m');
        $this->load->model('movie_stores_m');
        $this->load->model('movie_ott_platforms_m');
		
        $rules = $this->movies_m->rules;
        $this->form_validation->set_rules($rules);

        if($type!=""){
             $this->data['type'] = $type;
        }

        if($type!="" && $type==1){
            $title="Movie";
        }else{
            $title="Series";
        }

        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
		
		//$this->load->library('form_validation');
		/*echo '<pre>';
			print_r($this->array_from_post($post));exit;*/
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('ott_platforms[]', 'OTT Platforms', 'required');
		//$this->form_validation->set_rules('parent_store', 'parent_store', 'required');
		if($this->input->post('submitbtn')){
       	 //if($this->form_validation->run() == FALSE){}else{
            $data = $this->array_from_post($post);
			/*echo '<pre>';			
			print_r($data);exit;*/
			
			$tag_bm = $_POST['tag_bm'];
			//$ott_platform_bm = $_POST['ott_platform_bm'];
			$genres_bm = $_POST['genres_bm'];


			
			
			$formdatabm = array('name' => $data['name'],
								'is_kids_friendly' => $data['is_kids_friendly'],
								'childlock' => $data['childlock'],
								'year' => $data['year'],
								'actor' => $data['actor'],
								'language' => $data['language'],
								'tags' => $tag_bm,
								'description' => $data['description'],
								'duration' => $data['duration'],
								'dbselect' => $data['dbselect'],
								'age_rating' => $data['age_rating'],
								'server_url_trailer' => $data['server_url_trailer'],
								'trailer' => $data['trailer'],
								'token_trailer' => $data['token_trailer'],
								'rating' => $data['rating'],
								'subtitles' => $data['subtitles'],
								'overlay_enabled' => $data['overlay_enabled'],
								'preroll_enabled' => $data['preroll_enabled'],
								'ticker_enabled' => $data['ticker_enabled'],
								'show_on_home' => $data['show_on_home'],
								'tmdb_id' => $data['tmdb_id'],
								'imported' => $data['imported'],
								'vast_url' => $data['vast_url'],
								'user_id' => $this->session->user_id
								);
            $insert_id=$this->movies_m->save(NULL,$formdatabm);
           
            //upload files if there is an image 
            if(isset($_FILES['poster']['name']) && $_FILES['poster']['name']!='')
            {
            	//create
                $filename= $this->upload_image('poster', '', LOCAL_PATH_IMAGES_CMS, 'movies_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
                
            	/*$uploadResult = $this->handlePosterUpload($_FILES['poster'],'',$insert_id);
			    if (!$uploadResult['success']) {
			        $this->session->set_flashdata('error', $uploadResult['message']);
			        redirect(BASE_URL.'movies/create');
			    }
			    $filename = $uploadResult['filename'];*/
            }

            if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='')
            { 	//echo LOCAL_PATH_IMAGES_CMS;exit;
                $filename= $this->upload_image('backdrop','', LOCAL_PATH_IMAGES_CMS, 'movies_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
			
			if($this->input->post('poster_remote')!=""){ 
				$image_name = str_replace('/','',$this->input->post('poster_remote'));
				$filename = $this->upload_image_remote('poster',LOCAL_PATH_IMAGES_CMS,$image_name,'movies_m',$insert_id);
				$localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
			}
			if($this->input->post('backdrop_remote')!=""){ 
				$image_name = str_replace('/','',$this->input->post('backdrop_remote'));
				$filename = $this->upload_image_remote('backdrop',LOCAL_PATH_IMAGES_CMS,$image_name,'movies_m',$insert_id);
				$localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
				//echo LOCAL_PATH_IMAGES_CMS.'uuuuu';exit;
			}
			
			
            if($this->input->post('thumb_link')!=""){
                if($this->download_and_save_image($this->input->post('thumb_link'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('thumb_link'));
                    $data = array('poster'=>$file_name);
                    $this->movies_m->save($insert_id,$data);

                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                }
            }

            if($this->input->post('poster_link')!=""){
                if($this->download_and_save_image($this->input->post('poster_link'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('poster_link'));
                    
                    $data = array('backdrop'=>$file_name);
                    $this->movies_m->save($insert_id,$data);
					
					/*$poster_backdrop = $this->input->post('poster_backdrop');
					if($poster_backdrop){
						$data = array('poster'=>$file_name);
                    	$this->movies_m->save($id,$data);
					}*/
					
                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                }
            }
            
			
			 // insert store id 
            $store_id=$this->input->post('parent_store');
            $setstore_id = $store_id;
            if($this->input->post('sub_store')!=""){
                //$store_id=$this->input->post('sub_store');
				$sub_store = $this->input->post('sub_store');
				$store_id= implode(',',$sub_store);
				$setsubstore_id = $store_id;
            } else{
				$setsubstore_id = '0';
			}  
			
            $data = array('store_id'=>$store_id);
            $this->movies_m->save($insert_id,$data);



            if(is_array($this->input->post('genres')) && count($this->input->post('genres'))>0){
				$select_genres = array();
				//echo '<pre>';
                foreach ($this->input->post('genres') as $genre_id) {
                   $data=array(
                        'genre_id'=>$genre_id,
                        'movie_id'=>$insert_id,
						'store_id' => $setstore_id,
						'substore_id' => $setsubstore_id
                    );
					//print_r($data);
					 $select_genres[] = $genre_id;
                   $this->db->insert('movie_to_genres',$data);
                }
				
				
			
				$data_select_genres = array('select_genres'=>implode(',',$select_genres));
            	$this->movies_m->save($insert_id,$data_select_genres);
				/*echo '2 ============';
				print_r($select_genres);
				exit;*/
				
            } 
            elseif($genres_bm != ''){
				$genres_bm_array = explode(',',$genres_bm);
				$select_genres = array();
				foreach($genres_bm_array as $key=>$val){
					$data=array(
                        'genre_id'=>$val,
                        'movie_id'=>$insert_id,
						'store_id' => $setstore_id,
						'substore_id' => $setsubstore_id
                    );
				   $select_genres[] = $val;
                   $this->db->insert('movie_to_genres',$data);
				}
				
				$data_select_genres = array('select_genres'=>implode(',',$select_genres));
            	$this->movies_m->save($insert_id,$data_select_genres);
				/*echo '1 ============';
				print_r($select_genres);exit;*/
			}
            
            // insert tags
            if(is_array($this->input->post('tags')) && count($this->input->post('tags'))>0){
                foreach ($this->input->post('tags') as $tag_id) {
                   $data=array(
                        'tag_id'=>$tag_id,
                        'movie_id'=>$insert_id
                    );
                   $this->db->insert('movie_to_tags',$data);
                }
            } elseif($tag_bm != ''){
				$tag_bm_array = explode(',',$tag_bm);
				foreach($tag_bm_array as $key=>$val){
					$data=array(
                        'tag_id'=>$val,
                        'movie_id'=>$insert_id
                    );
                   $this->db->insert('movie_to_tags',$data);
				}
			}

			$ott_platforms = $this->input->post('ott_platforms');
        	if (is_array($ott_platforms) && count($ott_platforms) > 0) {
	            foreach ($ott_platforms as $platform_id) {
	                $this->db->insert('movie_to_platforms', array(
	                    'ott_platform_id' => $platform_id,
	                    'movie_id' => $insert_id
	                ));
	            }
            	$data_ott_platforms = array('ott_platforms' => implode(',', $ott_platforms));
            	$this->movies_m->save($insert_id, $data_ott_platforms);
        	}


            /* 
            // insert store id 
            $store_id=$this->input->post('parent_store');
            
            if($this->input->post('sub_store')!=""){
                //$store_id=$this->input->post('sub_store');
				$sub_store = $this->input->post('sub_store');
				$store_id= implode(',',$sub_store);
            }   
            $data = array('store_id'=>$store_id);
            $this->movies_m->save($insert_id,$data);
            */

            // insert movie urls 
            for($i=1;$i<=$this->input->post('movie_url_count');$i++){
                $language=$this->input->post('movie_language_'.$i);
                $token=$this->input->post('movie_token_'.$i);
                $server_url=$this->input->post('server_url_'.$i);
                $stream_name=$this->input->post('stream_name_'.$i);
				$movie_subtitleurl = $this->input->post('movie_subtitleurl_'.$i);
                $data=array('movie_id'=>$insert_id,
                            'language_id'=>$language,
                            'server_url_id'=>$server_url,
                            'stream_name'=>$stream_name,
                            'token_id'=>$token,
							'movie_subtitleurl' => $movie_subtitleurl
                            );
                $this->db->insert('movie_stream_urls',$data);
            }
			
			$this->createJsonMovieDetails(4,$insert_id);
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movies/edit/'.$insert_id).'" target="_blank">Movie Added</a>');   
            $this->session->set_flashdata('success',"Added Successfully.");
            redirect(BASE_URL.'movies');
			//}
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'movies/create/'.$type);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        //get languages
        $this->data['languages']=$this->languages_m->get();
        
         //get tags
        $this->data['tags']=$this->movie_tags_m->get();

        //get ott_platforms
    	$this->data['ott_platforms'] = $this->movie_ott_platforms_m->get();	

        //get all parent stores
        $this->data['stores']=$this->movie_stores_m->get_parent_store();
       
        //get tokens 
        $this->data['tokens']=$this->movies_m->get_tokens();
        
        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(4); //movie 4
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'movies/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'movies/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->data['movie_url_permission'] = $this->ion_auth->checkPermission(82); 
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'movies' ) : '';
        $channel_info=$this->movies_m->get($id);
        
        // if($channel_info->channel_image)
        // {
        //     if(file_exists("./uploads/movies/".$channel_info->channel_image))
        //         @unlink("./uploads/movies/".$channel_info->channel_image);
        // }

        // if($channel_info->channel_image_icon)
        // {
        //     if(file_exists("./uploads/movies/icons/".$channel_info->channel_image_icon))
        //         @unlink("./uploads/movies/icons/".$channel_info->channel_image_icon);
        // }

        $this->movies_m->delete($id);
        // $this->movies_m->delete_channels_groups($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movies').'" target="_blank">Movie Deleted</a>');   
        $this->session->set_flashdata('success',"Movie Deleted Successfully.");
        redirect( BASE_URL . 'movies' );
    }
    public function edit($id = NULL){
	
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('languages_m');
        $this->load->model('movie_genres_m');
        $this->load->model('movie_stores_m');
        $this->load->model('movie_tags_m');
        $this->load->model('logs_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'movies' ) : '';
        $rules = $this->movies_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->movies_m->get($id,TRUE);
		$parent_id=$this->movie_stores_m->check_if_parent_mul($info->store_id);
		
		if($parent_id==0){
            $setstore_id = $info->store_id;
            $setsubstore_id = 0;
        }else{
			$setstore_id = $parent_id;
            $setsubstore_id = $info->store_id;            
        }
		
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
       
		if($this->input->post('submitbtn')){
			$genres_bm = $_POST['genres_bm']; 
			$tag_bm = $_POST['tag_bm'];			
            $data = $data = $this->array_from_post($post);
            $this->movies_m->save($id,$data);
            
            //upload files if there is an image 
            if($_FILES['poster']['name']!='')
            {
				
				//edit
				$filename=$this->upload_image('poster', $info->poster, LOCAL_PATH_IMAGES_CMS, 'movies_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
                

				/*$uploadResult = $this->handlePosterUpload($_FILES['poster'], $info->poster,$id);
				if (!$uploadResult['success']) {
				$this->session->set_flashdata('error', $uploadResult['message']);
				redirect(BASE_URL.'movies/edit/'.$id);
				}
				$filename = $uploadResult['filename'];*/

                
            }

            if($_FILES['backdrop']['name']!='')
            {
                $filename=$this->upload_image('backdrop',$info->backdrop, LOCAL_PATH_IMAGES_CMS, 'movies_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

			
			
			if($this->input->post('thumb_link')!=""){
                if($this->download_and_save_image($this->input->post('thumb_link'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('thumb_link'));
                    $data = array('poster'=>$file_name);
                    $this->movies_m->save($id,$data);

                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                }
            }

            if($this->input->post('poster_link')!=""){
                if($this->download_and_save_image($this->input->post('poster_link'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('poster_link'));
                    
                    $data = array('backdrop'=>$file_name);
                    $this->movies_m->save($id,$data);
					
                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                }
            }
			
			
            if(is_array($this->input->post('genres')) && count($this->input->post('genres'))>0){
                
                // first delete all 
                $this->movies_m->delete_genres_by_movie($id);
				$select_genres = array();
                foreach ($this->input->post('genres') as $genre_id) {
                   $data=array(
                        'genre_id'=>$genre_id,
                        'movie_id'=>$id,
						'store_id' => $setstore_id,
						'substore_id' => $setsubstore_id
                    );
					
				   $select_genres[] = $genre_id;
                   $this->db->insert('movie_to_genres',$data);
                }
				
				$data_select_genres = array('select_genres'=>implode(',',$select_genres));
            	$this->movies_m->save($id,$data_select_genres);
				
            }elseif($genres_bm != ''){
				$this->movies_m->delete_genres_by_movie($id);
				$genres_bm_array = explode(',',$genres_bm);
				$select_genres = array();
				foreach($genres_bm_array as $key=>$val){
					$data=array(
                        'genre_id'=>$val,
                        'movie_id'=>$id,
						'store_id' => $setstore_id,
						'substore_id' => $setsubstore_id
                    );
				   $select_genres[] = $val;
                   $this->db->insert('movie_to_genres',$data);
				}
				
				$data_select_genres = array('select_genres'=>implode(',',$select_genres));
            	$this->movies_m->save($id,$data_select_genres);
			}else{
				 $this->movies_m->delete_genres_by_movie($id);
			}

            if(is_array($this->input->post('tags')) && count($this->input->post('tags'))>0){
                
                // first delete all 
                $this->movie_tags_m->delete_tags_by_movie($id);
				$tags = array();
                foreach ($this->input->post('tags') as $tag_id) {
                   $data=array(
                        'tag_id'=>$tag_id,
                        'movie_id'=>$id
                    );
                   $this->db->insert('movie_to_tags',$data);
				   $tags[] = $tag_id;
                }
				
				$datatags = array('tags'=>implode(',',$tags));
            	$this->movies_m->save($id,$datatags);
            }elseif($tag_bm != ''){
				$tags = array();
				$tag_bm_array = explode(',',$tag_bm);
				foreach($tag_bm_array as $key=>$val){
					$data=array(
                        'tag_id'=>$val,
                        'movie_id'=>$id
                    );
					$tags[] = $val;
                   $this->db->insert('movie_to_tags',$data);
				}
				
				$datatags = array('tags'=>implode(',',$tags));
            	$this->movies_m->save($id,$datatags);
			}

			$ott_platforms = $this->input->post('ott_platforms');
			$this->movie_ott_platforms_m->delete_platforms_by_movie($id);
			if (is_array($ott_platforms) && count($ott_platforms) > 0) {
			    foreach ($ott_platforms as $platform_id) {
			        $this->db->insert('movie_to_platforms', array(
			            'ott_platform_id' => $platform_id,
			            'movie_id' => $id
			        ));
			    }
			    $data_ott_platforms = array('ott_platforms' => implode(',', $ott_platforms));
			    $this->movies_m->save($id, $data_ott_platforms);
			}

            // insert store id 
            $store_id=$this->input->post('parent_store');
            
            if($this->input->post('sub_store')!=""){               
				$sub_store = $this->input->post('sub_store');
				$store_id= implode(',',$sub_store);
            }   
 			$data = array('store_id'=>$store_id);
            $this->movies_m->save($id,$data);

            $this->movies_m->deleteMovieUrls($id);
            for($i=1;$i<=$this->input->post('movie_url_count');$i++){
                $language=$this->input->post('movie_language_'.$i);
                $token=$this->input->post('movie_token_'.$i);
                $server_url=$this->input->post('server_url_'.$i);
                $stream_name=$this->input->post('stream_name_'.$i);
				$movie_subtitleurl=$this->input->post('movie_subtitleurl_'.$i);
                $data=array('movie_id'=>$id,
                            'language_id'=>$language,
                            'server_url_id'=>$server_url,
                            'stream_name'=>$stream_name,
                            'token_id'=>$token,
							'movie_subtitleurl' => $movie_subtitleurl
                            );
                $this->db->insert('movie_stream_urls',$data);
            }

           
			$this->createJsonMovieDetails(4,$id);
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movies/edit/'.$id).'" target="_blank">Movie Updated</a>');   
            $this->session->set_flashdata('success',"Edited Successfully.");
            redirect(BASE_URL.'movies');
        }
        
        $title='Movie';
        $this->load->model('tmdb_model');
		$data_image = $this->tmdb_model->get_movie_info_image_ibdm($info->tmdb_id); 		
		//$poster_array = $data_image->items;

		$var = $data_image->items ?? []; // Set to empty array if null
		
		if(count(@$var) > 0){
			$cc = 0;
			foreach($var as $key=>$val){
				if(($cc > 0) && ($cc <= BACKDROP_IMAGES_MOVIE)){
					
					$imglink = $this->tmdb_model->getMovieImageResizeIbdm($val->image, '1280' ,'720');
					if (strpos($imglink, $info->backdrop)  === false) {					
						$list_image[] = $imglink;
					}
				}
				$cc++;	
			} 
		}
				
		$this->data['list_image'] = @$list_image;				
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit '.$title, 'movies/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        //get tokens 
        $this->data['tokens']=$this->movies_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(4); //movie 4

         //get languages
        $this->data['languages']=$this->languages_m->get();

        // get all parent stores
        $this->data['stores'] =$this->movie_stores_m->get_by(array('parent_id'=>0));

      
        $this->data['sub_stores'] = array();

        if($parent_id==0){
            $this->data['parent_store_id']= $info->store_id;
            $this->data['sub_store_id']= 0;
        }
        else{
            $this->data['parent_store_id']= $parent_id;
            $this->data['sub_store_id']= explode(',',$info->store_id);
            // get sub stores 
            $this->data['sub_stores'] =$this->movie_stores_m->get_by(array('parent_id'=>$parent_id));
        }

        // get all genres by store_id 
        $this->data['genres'] =$this->movies_m->get_genres_by_store($info->store_id);
        
        $this->data['selected_genres'] =$this->movies_m->get_genres_by_movie($id);

         // get all genres by store_id 
        $this->data['tags'] =$this->movie_tags_m->get();

        $this->data['ott_platforms'] = $this->movie_ott_platforms_m->get();        
    	$this->data['selected_ott_platforms'] = $this->movie_ott_platforms_m->get_platforms_by_movie($id);
    
        
        // get all selected genres 
        $this->data['selected_tags'] =$this->movie_tags_m->get_tags_by_movie($id);
        
        $this->data['movie_urls'] =$this->movies_m->get_movie_urls($id);

        $info->created_by = $this->movies_m->get_user_details($info->user_id);
        
        $this->data['details'] = $info;
        
       
		$this->data['movie_logs'] = $this->logs_m->getMovieLogs($id);
		//print_r($this->data['movie_logs']);exit();
        
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'movies/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'movies/edit';
        $this->data['title'] =$title;
        $this->data['page_title'] = "Edit ". $title;
        $this->data['movie_url_permission'] = $this->ion_auth->checkPermission(82); 
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
	public function createJsonMovieDetails($id,$movie_id){
		//$this->createJsonUpdate("movie");
		//check_allow('create', $this->data['is_allow']);
		$this->load->model('movies_m');
		$this->load->model('channels_m');		
		$this->load->model('publish_m');
				
		/*$this->load->model('customers_m');
		$this->load->model('settings_m');*/
		
		$server_time = date('Y-m-d H:i:s');

		// get all movies
		$movies = $this->movies_m->get_movies();

		foreach ($movies as $movie) {
			if($movie_id == $movie->id){
					$url_trailer = rtrim($this->channels_m->get_server_url_by_id($movie->server_url_trailer), "/");
					if ($url_trailer != NULL)
						$url_trailer = $url_trailer . "/";
		
					//get movie stream urls 
					$sql = "Select msu.stream_name,l.name language_name,t.token_short_code,siu.url,m.vast_url
						  FROM movie_stream_urls msu
						  JOIN movie m on m.id=msu.movie_id
						  JOIN languages l on l.id=msu.language_id
						  JOIN token t on t.id=msu.token_id
						  LEFT JOIN server_items_urls siu on siu.id=msu.server_url_id
						  WHERE msu.movie_id=" . $movie->id;
					$query = $this->db->query($sql);
					$stream_urls = array();
					foreach ($query->result() as $stream) {
						if ($stream->url != NULL) {
							$stream_url = rtrim($stream->url, "/");
							$url = $stream_url . "/" . ltrim($stream->stream_name, "/");
						} else {
							$url = $stream->stream_name;
						}
		
						array_push(
							$stream_urls,
							array(
								'url' => $url,
								'language' => $stream->language_name,
								//'toktype'=>$stream->token_short_code,
								'vtt_url' => $stream->vast_url,
								'secure_stream' => false,
								'akamai_token' => true,
								'flussonic_token' => false
							)
						);
					}
		
					$url_movie = rtrim($this->channels_m->get_server_url_by_id($movie->server_url_movie), "/");
					if ($url_movie != NULL)
						$url_movie = $url_movie . "#";
		
					//get tags for this movie
					$sql_tags = "SELECT name FROM movie_tags WHERE id IN (
						SELECT tag_id from movie_to_tags WHERE movie_id='$movie->id')";
					$query_tags = $this->db->query($sql_tags);
		
					$tags = [];
		
					foreach ($query_tags->result() as $tag) {
						$tags[] = $tag->name;
					}
		
					$movie_array = array(
						'ServerTime' => $server_time,
						'id' => (int)$movie->id,
						'name' => $movie->name,
						'description' => $movie->description,
						'poster' => $movie->poster,
						'backdrop' => $movie->backdrop,
						'length' => (int)$movie->duration,
						'year' => $movie->year,
						'trailer_url' => $url_trailer . $movie->trailer,
						// 'toktype_trailer'=>$this->channels_m->get_token_code_by_id($movie->token_trailer),
						'actors' => $movie->actor,
						'imdb_rating' => (int)$movie->rating,
						'rating' => ((int)$movie->rating)/2,
						'language' => $movie->language_name,
						'childLock' => (int)$movie->childlock,
						'is_kids_friendly' => ($movie->is_kids_friendly == 0) ? false : true,
						'age_rating' => null,
						'is_payperview' => false,
						'rule_payperview' => array(
							'id' => 0,
							'name' => null,
							'type' => null,
							'quantity' => 0
						),
						'movieprices' => array(),
						'moviedescriptions' => array(array(
							'language' => $movie->language_name,
							'description' => $movie->description
						)),
						'moviestreams' => $stream_urls,
						'tags' => $tags,
						'has_preroll' => (int)$movie->preroll_enabled,
						'has_overlaybanner' => (int)$movie->overlay_enabled,
						'has_ticker' => (int)$movie->ticker_enabled,
						'vast' => null
					);
		
					$filename = $movie->id . '_movie_details_v2.json';
					$localFilePath = LOCAL_PATH_CMS . $filename;
					$main_array = $movie_array;
					/* Encryption */
					$final_json_output = json_encode($movie_array, JSON_UNESCAPED_SLASHES);
					//$final['CID'] = encrypt($final_json_output, 2);
		
					if (ENCRYPT_JSON == 1)
						$final['CID'] = encrypt($final_json_output, 2);
					else
						$final = $main_array;
		
					$return_array = json_encode($final, JSON_UNESCAPED_SLASHES);
		
					$fp = fopen($localFilePath, 'w');
					fwrite($fp, $return_array);
					fclose($fp);
		
					$this->uploadToCdnServer($filename, $localFilePath, 'jsons', 'cms');
			}
		}

		// insert into tables
		$data = array('last_update' => date('Y-m-d H:i:s'));
		$this->publish_m->save($id, $data);
	}
    public function series(){

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'movies/_extra_scripts_series';
        $this->data['_view'] = DEFAULT_THEME . 'movies/index';
        $this->data['page_title'] = "Series";
        $this->data['add_text'] = "Add a Series";
        $this->data['type'] = 2;
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
    public function importMovie(){
        $this->load->model('tmdb_model');
        $tmdb_id=$this->input->post('tmdb_id');

        // check if already imported 
        if($this->movies_m->get_by(array('tmdb_id'=>$tmdb_id))){
            $this->session->set_flashdata('failure',"Already Imported");
            redirect(BASE_URL.'movies');
        }


        $details=$this->tmdb_model->getMovieDetail($tmdb_id);
        $data_array= json_decode($details);
        
        $casts=$this->tmdb_model->getMovieCasts($tmdb_id);
        $casts_array= json_decode($casts);
        $actors="";
        foreach ($casts_array->cast as $actor) {
            $actors .=$actor->name.", ";
        }

        /*
        echo "<pre>";
        print_r($casts_array);
        echo "</pre>";
        */
        // check if error 
        if(isset($data_array->status_code) && $data_array->status_code==34){
            $this->session->set_flashdata('failure',$data_array->status_message);
            redirect(BASE_URL.'movies');
        }else{
            $name= $data_array->original_title;
            $poster= $data_array->poster_path;
            $backdrop = $data_array->backdrop_path;
            $rating = ceil($data_array->vote_average);
            $language =  $data_array->original_language;
            
            $data=array('name'=>$name,
                        'poster'=>$poster,
                        'backdrop'=>$backdrop,
                        'rating'=>$rating,
                        'actor'=>rtrim($actors,','),
                        'language'=>1,
                        'imported'=>1,
                        'tmdb_id'=>$tmdb_id
                        );
            $this->movies_m->save(NULL,$data);
            $this->session->set_flashdata('success',"Successfully Imported");
            redirect(BASE_URL.'movies');
        }
    }
	public function import_movieselect(){
		$this->load->model('movie_stores_m');
		$id = urlencode(trim($this->input->post("id"))); // $id = 31910;
		$dbselect = urlencode(trim($this->input->post("dbselect")));
		//echo $dbselect;exit;
		$response= array();        
		//$id = trim($this->input->post("id")); // $id = 31910;
		$from = $this->input->post("from");  // $from ='tv';
 
		// check if already imported 
		//echo '<pre>';
		$response['selected_store'] = '';
		$movie_info = $this->movies_m->get_by(array('tmdb_id'=>$id));
		$fetch_all_sub_stores = $this->movie_stores_m->fetch_all_sub_stores();
		
		
		$storeinfo_array = array();
		foreach($fetch_all_sub_stores as $key=>$val){
			$storeinfo_array['id_'.$val['id']] = $val['name'];
		}
		$movie_info_array = array();
		foreach($movie_info as $key=>$val){
			$movie_info_array[] = $storeinfo_array['id_'.$val['store_id']];
		}
		//echo '<pre>';
		//print_r($movie_info);
		//print_r($movie_info_array);
		//if($this->movies_m->get_by(array('tmdb_id'=>$id))){
		if($movie_info){
		   $response['imdb_status']  = "fail";
		   $response['error_message']  = "Already Imported";
		   
		   $parent_id=$this->movie_stores_m->check_if_parent($movie_info[0]['store_id']);
		  // print_r($parent_id);exit;
		   $response['selected_store'] = $parent_id;
		   
		   $response['selected_store_substore'] = implode(',',$movie_info_array);
		   //echo json_encode($response);
		  // echo json_encode(array("resultist" => "one", "resdata" => $response));
		}
		//else{
		if($dbselect == 'imdb'){
			$chooseselect = urlencode(trim($this->input->post("chooseselect")));						
			$this->load->model('tmdb_model');
			$data = $this->tmdb_model->get_movie_info_ibdm($id); 						
			$data_image = $this->tmdb_model->get_movie_info_image_ibdm($id); 
			
			/*echo '<pre>';
			//print_r($data);
			print_r($data_image);*/
			$thumbnail = $data->image;
			
			$poster_string = $data->image;
			$poster_array = $var;
			
			//echo '<pre>';
			//print_r($poster_array);
			 
			if(count($poster_array) > 0){
				$cc = 0;
				foreach($poster_array as $key=>$val){
					if(($cc > 0) && ($cc <= BACKDROP_IMAGES_MOVIE)){
						$list_image[] = $this->tmdb_model->getMovieImageResizeIbdm($val->image, '1280' ,'720');
					}
					$cc++;	
				} 
			}
			
			/*echo '<pre>';
			//print_r($data);
			print_r($list_image);*/
			
			if(count($poster_array) > 0){
				$poster_string = $poster_array[0]->image;
			}
			
			$thumbnail_final = $this->tmdb_model->getMovieImageResizeIbdm($thumbnail,'360','540');
			$poster_string_final = $this->tmdb_model->getMovieImageResizeIbdm($poster_string, '1280' ,'720');
			/*$poster_string_final = $poster_string;
			$backdrops_string_final = $backdrops_string;*/
			//echo $poster_string_final;
			
			$actorList = array();
			$c = 1;
			foreach($data->actorList as $key=>$val){
				if($c < 6){
					array_push($actorList,$val->name);
				}
				$c++;
			}
		
			//$response['submitted_data'] = $this->input->post(); 
			$response['imdb_status']    = 'success';
			$response['tmdb_id']        = $data->id;
			$response['title']          = $data->title;
			$response['plot']           = $data->plot;
			$response['runtime']        = $data->runtimeMins;
			$response['studio']         = '';
			$response['actor']          = implode(',',$actorList);
			$response['director']       = $data->directors;
			$response['producer']       = $data->companies;
			$response['genre']          = $data->genres;
			$response['rating']         = $data->imDbRating;
			$response['age_rating']     = $data->contentRating;
			$response['release']        = $data->releaseDate;
			$response['poster']      	= $thumbnail;
			$response['thumbnail']      = $thumbnail_final;
			$response['poster']         = $poster_string_final;
			$response['response']       = 'yes';
			$response['dbselect']       = $dbselect;
			$response['tags']     		= $data->genres;
			$response['list_image']      = $list_image;
			
			/*echo '<pre>';
			print_r($response);*/
			//genres
			//echo json_encode(array("resultist" => "one", "resdata" => $response));
		} 
		elseif($dbselect == 'tmdb'){
			$response['submitted_data'] = $this->input->post();
			$this->load->model('tmdb_model');
			if($from=='tv'){
				//$data = $this->tmdb_model->get_tvshow_actor_info($id);
				$data = $this->tmdb_model->get_tvseries_info($id);            
			}else{ //echo 'test';exit;
				//$data = $this->tmdb_model->get_movie_actor_info($id);
				$data = $this->tmdb_model->get_movie_info($id);            
			}
			//var_dump($data);       
			if(isset($data['status']) && $data['status']=='success'){
				$response['imdb_status']    = 'success';
				$response['tmdb_id']        = $data['tmdb_id'];
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
				$response['dbselect']       = $dbselect;
			} else{
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
			//echo json_encode($response);
		}
		echo json_encode(array("resultist" => "one", "resdata" => $response));
		//}
		
	}
	public function edit_import_movieselect(){
		        $id = urlencode(trim($this->input->post("id"))); // $id = 31910;
				$dbselect = urlencode(trim($this->input->post("dbselect"))); // $id = 31910;
				$response= array();        
				//$id = trim($this->input->post("id")); // $id = 31910;
				$from = $this->input->post("from");  // $from ='tv';
		 
				
					$response['submitted_data'] = $this->input->post();
					$this->load->model('tmdb_model');
				if($dbselect == 'tmdb'){
					if($from=='tv'){
						//$data = $this->tmdb_model->get_tvshow_actor_info($id);
						$data = $this->tmdb_model->get_tvseries_info($id);            
					}else{
						//$data = $this->tmdb_model->get_movie_actor_info($id);
						$data = $this->tmdb_model->get_movie_info($id);            
					} 
					//print_r($data);exit;
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
					} else{
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
				} elseif($dbselect == 'imdb'){
					
						//$chooseselect = urlencode(trim($this->input->post("chooseselect")));
						
						//$this->load->model('tmdb_model');
						$data = $this->tmdb_model->get_movie_info_ibdm($id); 
						/*echo '<pre>';
						print_r($data);exit;*/
						$actorList = array();
						$c = 1;
						foreach($data->actorList as $key=>$val){
							if($c < 6){
								array_push($actorList,$val->name);
							}
							$c++;
						}
						
									$response['imdb_status']    = 'success';
									$response['tmdb_id']        = $data->id;
									$response['title']          = $data->title;
									$response['plot']           = $data->plot;
									$response['runtime']        = $data->runtimeMins;
									$response['studio']         = '';
									$response['actor']          = implode(',',$actorList);
									$response['director']       = $data->directors;
									$response['producer']       = $data->companies;
									$response['genre']          = $data->genres;
									$response['rating']         = $data->imDbRating;
									$response['release']        = $data->releaseDate;
									$response['thumbnail']      = $data->image;
									$response['poster']         = $data->image;
									$response['response']       = 'yes';
									$response['dbselect']       = $dbselect;									
					
				}
					echo json_encode($response);
					
				
		
	}
    //imdb import
    public function import_movie(){
		$id = urlencode(trim($this->input->post("id"))); // $id = 31910;
		$dbselect = urlencode(trim($this->input->post("dbselect")));
		//echo $dbselect;exit;
		$this->load->model('tmdb_model');
		if($dbselect == 'tmdb'){
			if(is_numeric($id)){
				$response= array();        
				$id = trim($this->input->post("id")); // $id = 31910;
				$from = $this->input->post("from");  // $from ='tv';
		 
				// check if already imported 
				if($this->movies_m->get_by(array('tmdb_id'=>$id))){
				   $response['imdb_status']  = "fail";
				   $response['error_message']  = "Already Imported";
				   //echo json_encode($response);
				   echo json_encode(array("resultist" => "one", "resdata" => $response));
				}else{
					$response['submitted_data'] = $this->input->post();
					//$this->load->model('tmdb_model');
					
					if($from=='tv'){
							$data = $this->tmdb_model->get_tvseries_info($id);            
					}else{
							$data = $this->tmdb_model->get_movie_info($id);            
					}
					/*if($dbselect == 'tmdb'){
						
					} elseif($dbselect == 'imdb'){
						$data = $this->tmdb_model->get_movie_info_ibdm($id);  
					}*/
					//var_dump($data);       
					if(isset($data['status']) && $data['status']=='success'){
						$response['imdb_status']    = 'success';
						$response['tmdb_id']        = $data['tmdb_id'];
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
					//echo json_encode($response);
					echo json_encode(array("resultist" => "one", "resdata" => $response));
				}
			}
			else {
				
				/*if($dbselect == 'tmdb'){
					$data = $this->tmdb_model->getMovieInfoAll($id); 
				} elseif($dbselect == 'imdb'){
					$data = $this->tmdb_model->getMovieInfoAllIMDB(urldecode($id)); 
				}*/
				$data = $this->tmdb_model->getMovieInfoAll($id);
		
				echo json_encode(array("resultist" => "all", "dbselect" => $dbselect, "resdata" => $data));
			}
		} 
		elseif($dbselect == 'imdb'){
			$chooseselect = urlencode(trim($this->input->post("chooseselect")));
			/*if($chooseselect == 'one'){
				$data = $this->tmdb_model->get_movie_info_ibdm($id);  
			}else {*/
				$data = $this->tmdb_model->getMovieInfoAllIMDB(urldecode($id)); 
				echo json_encode(array("resultist" => "all", "dbselect" => $dbselect, "resdata" => $data));
			//}
		}
		
    }
    public function disable($id){
        check_allow('edit',$this->data['is_allow']);
        $data=array('status'=>0);
        $this->movies_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movies').'" target="_blank">Movie Disabled</a>');   
        $this->session->set_flashdata('success',"Movie Disabled Successfully.");
        redirect(BASE_URL.'movies');
    }
    public function enable($id){
        check_allow('edit',$this->data['is_allow']);
        $data=array('status'=>1);
        $this->movies_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movies').'" target="_blank">Movie Enabled</a>');   
        $this->session->set_flashdata('success',"Movie Enabled Updated Successfully.");
        redirect(BASE_URL.'movies');
    }
    public function saveImageTest(){
        $url="https://image.tmdb.org/t/p/w185/keym7MPn1icW1wWfzMnW3HeuzWU.jpg";
        $path=LOCAL_PATH_IMAGES_CMS;
        $this->download_and_save_image($url,$path);
    }
	public function verify_urlXXXX() {

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

	public function verify_url() {
		$url_type = $this->input->post('url_type');
		$server_url_id = $this->input->post('server_url_id');
		$stream_name = trim($this->input->post('url'));

		// Check if URL is empty
		if (empty($stream_name)) {
		    echo json_encode(array('status' => 'error', 'message' => 'URL cannot be empty'));
		    return;
		}

		if (!empty($server_url_id)) {
		    $cname_initial = $this->channels_m->get_server_url_by_id($server_url_id);
		    $url = rtrim($cname_initial, '/') . '/' . ltrim($stream_name, '/');        
		} else {
		    $url = $stream_name;
		}

		// Load the AkamaiTokenVerifier library
        $this->load->library('AkamaiTokenVerifier');
        
        // Verify the URL and get the URL with token
		$result = $this->akamaitokenverifier->verifyUrl($url);

		// Add video info to the response if available
		if ($result['status'] === 'success' && isset($result['video_info'])) {
		    $result['video_details'] = array(
		        'format' => $result['video_info']['format'],
		        'size' => $this->formatBytes($result['video_info']['file_size']),
		        'type' => $result['video_info']['content_type']
		    );
		}

		echo json_encode($result);
	}

	private function formatBytes($bytes, $precision = 2) {
	    $units = array('B', 'KB', 'MB', 'GB', 'TB');

	    $bytes = max($bytes, 0);
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
	    $pow = min($pow, count($units) - 1);

	    return round($bytes / pow(1024, $pow), $precision) . ' ' . $units[$pow];
	}

    public function get_server_url() {
	    $server_url_id = $this->input->post('server_url_id');
	    $server_url = $this->movies_m->get_server_url($server_url_id);
	    
	    if ($server_url) {
	        echo json_encode(['status' => 'success', 'server_url' => $server_url]);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Server URL not found']);
	    }
	}
	public function get_movie_urls() {
	    $movie_id = $this->input->post('movie_id');
	    $urls = $this->movies_m->get_movie_urls_with_server($movie_id);
	    
	    if ($urls) {
	        echo json_encode(['status' => 'success', 'trailer_url' => $urls['trailer_url'], 'movie_urls' => $urls['movie_urls']]);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Movie URLs not found']);
	    }
	}

	private function handlePosterUpload($file, $oldImage = '',$id) {
	    if (isset($file['name']) && $file['name'] != '') {
	        // Create temp file to validate dimensions
	        $tempPath = $file['tmp_name'];
	        
	        // Validate poster ratio
	        $validationResult = $this->movies_m->validatePosterRatio($tempPath);
	        
	        if (!$validationResult['valid']) {
	            // Delete old temp file if exists
	            if (file_exists($tempPath)) {
	                @unlink($tempPath);
	            }
	            return [
	                'success' => false,
	                'message' => $validationResult['message']
	            ];
	        }

	        // If validation passes, proceed with upload
	        $filename = $this->upload_image('poster', $oldImage, LOCAL_PATH_IMAGES_CMS, 'movies_m', $id);
	        $localFilePath = LOCAL_PATH_IMAGES_CMS . $filename;
	        $this->uploadToCdnServer($filename, $localFilePath, 'images', 'cms');
	        
	        return [
	            'success' => true,
	            'filename' => $filename
	        ];
	    }
	    return ['success' => true, 'filename' => $oldImage];
	}
}