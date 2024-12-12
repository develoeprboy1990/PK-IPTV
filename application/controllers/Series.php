<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['is_allow']= check_permission(45);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('languages_m');
        $this->load->model('series_m');
        $this->load->model('series_ott_platforms_m');
        $this->load->model('tv_show_platforms_m');
        /* Title Page :: Common */
        $this->page_title->push('Series');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['main_nav'] = "sod";
        $this->data['sub_nav'] = "series";
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Series', 'series');
    }

	public function index(){  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'series/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'series/index';
        $this->data['page_title'] = "Series";
        $this->data['add_text'] = "Add a Series";
        $this->data['series'] = $this->series_m->getSeries();
        //echo '<pre>';
        //print_r($this->data['series']);exit();

        // Load OTT platforms
        $this->load->model('series_ott_platforms_m');
        $all_ott_platforms = $this->series_ott_platforms_m->get();
        $ott_platforms_array = array();
        foreach($all_ott_platforms as $platform){
            $ott_platforms_array['platform_'.$platform['id']] = $platform['name'];
        }
        $this->data['ott_platforms'] = $ott_platforms_array;

        // Load TV show platforms
        $this->load->model('tv_show_platforms_m');
        $all_tv_platforms = $this->tv_show_platforms_m->get();
        $tv_platforms_array = array();
        foreach($all_tv_platforms as $platform){
            $tv_platforms_array['platform_'.$platform['id']] = $platform['name'];
            $tv_platforms_array['language_'.$platform['id']] = $platform['language_name'];
        }
        $this->data['tv_platforms'] = $tv_platforms_array;
		
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){  // type 1 default: movie, 2: series 
        check_allow('create',$this->data['is_allow']);
        $this->load->model('series_stores_m');
        $this->load->model('series_ott_platforms_m');
        $this->load->model('tv_show_platforms_m');



        $rules = $this->series_m->rules;

        $this->form_validation->set_rules($rules);
        //$this->form_validation->set_rules('ott_platforms[]', 'OTT Platforms', 'required');
        $title="Series";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }


        if($this->form_validation->run()==TRUE){
            
            $data = $this->array_from_post($post);
            
            // Set default status for TV Show Platform
            $data['tv_show_platform_status'] = $this->input->post('tv_show_platform_status') ? 1 : 0;

            // Remove platform arrays from main data
            if(isset($data['ott_platforms'])) {
                unset($data['ott_platforms']);
            }
            if(isset($data['tv_show_platforms'])) {
                unset($data['tv_show_platforms']);
            }
        
            //$this->db->db_debug = TRUE;
            $insert_id=$this->series_m->save(NULL,$data);

            // insert store id 
            $store_id=$this->input->post('parent_store');
            
            /*if($this->input->post('sub_store')!=""){
                $store_id=$this->input->post('sub_store');
            } */  

            $data = array('store_id'=>$store_id);
            $data = array('user_id'=>$this->session->user_id);
            
            $this->series_m->save($insert_id,$data);


             // Save OTT platforms relationships
            $ott_platforms = $this->input->post('ott_platforms');
            if (is_array($ott_platforms) && count($ott_platforms) > 0) {
                foreach ($ott_platforms as $platform_id) {
                    $this->db->insert('series_to_platforms', array(
                        'ott_platform_id' => $platform_id,
                        'series_id' => $insert_id
                    ));
                }
                $data_ott_platforms = array('ott_platforms' => implode(',', $ott_platforms));
                $this->series_m->save($insert_id, $data_ott_platforms);
            }
            // Save TV Show platforms relationships only if status is enabled
            if($this->input->post('tv_show_platform_status') == 1) {
                $tv_show_platforms = $this->input->post('tv_show_platforms');

                if (is_array($tv_show_platforms) && count($tv_show_platforms) > 0) {
                    foreach ($tv_show_platforms as $platform_id) {
                        $this->db->insert('series_to_tv_platforms', array(
                            'platform_id' => $platform_id,
                            'series_id' => $insert_id
                        ));
                    }
                    $data_tv_platforms = array('tv_show_platforms' => implode(',', $tv_show_platforms));
                    $this->series_m->save($insert_id, $data_tv_platforms);
                }
            }

            //upload files if there is an image 
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', '', LOCAL_PATH_IMAGES_CMS, 'series_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

			if($this->input->post('thumb_link')!=""){
                if($this->download_and_save_image($this->input->post('thumb_link'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('thumb_link'));
                    $data = array('logo'=>$file_name);
                    $this->series_m->save($insert_id,$data);

                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');
                }
            }

           /* if(isset($_FILES['poster']['name']) && $_FILES['poster']['name']!='')
            {
                $filename= $this->upload_image('poster', '', SERIES_POSTER_UPLOAD_PATH, 'series_m',$insert_id);
                $localFilePath = SERIES_POSTER_UPLOAD_PATH.$filename;
                $this->uploadToServer($filename,$localFilePath,"images/series/poster");
            }

            if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='')
            {
                $filename= $this->upload_image('backdrop','', SERIES_BACKDROP_UPLOAD_PATH, 'series_m',$insert_id);
                $localFilePath = SERIES_BACKDROP_UPLOAD_PATH.$filename;
                $this->uploadToServer($filename,$localFilePath,"images/series/backdrop");
            }*/
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series/edit/'.$insert_id).'" target="_blank">Series Added</a>');          
            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'series');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'series/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        //channels_groups
        //$this->data['groups_channel']=$this->groups_channel_m->get();
        
        //get all parent series_stores
        $this->data['parent_stores']=$this->series_stores_m->get_by(array('parent_id'=>0));

        //get ott_platforms
        $this->data['ott_platforms'] = $this->series_ott_platforms_m->get();

        //get tv_show_platforms
        $this->data['tv_show_platforms'] = $this->tv_show_platforms_m->get(); 

        //get languages
        $this->data['languages']=$this->languages_m->get();
        //get tokens 
        $this->data['tokens']=$this->series_m->get_tokens();
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'series/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'series/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){   
        check_allow('delete',$this->data['is_allow']);
        $this->load->model('series_seasons_m');
        $this->load->model('episodes_m');
       ( $id == NULL ) ? redirect( BASE_URL . 'series' ) : '';
   
        $series_info=$this->series_m->get($id, TRUE);
        // if($channel_info->channel_image)
        // {
        //     if(file_exists("./uploads/series/".$channel_info->channel_image))
        //         @unlink("./uploads/series/".$channel_info->channel_image);
        // }

        // if($channel_info->channel_image_icon)
        // {
        //     if(file_exists("./uploads/series/icons/".$channel_info->channel_image_icon))
        //         @unlink("./uploads/series/icons/".$channel_info->channel_image_icon);
        // }

        $this->episodes_m->delete_episodes_by_series_id($id);
        $this->series_seasons_m->delete_seasons_series_id($id);
        $this->series_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series').'" target="_blank">Series Deleted</a>');          
        $this->session->set_flashdata('success',"Series and all related seasons and episodes deleted successfully.");
        redirect( BASE_URL . 'series' );
    }

    public function edit($id = NULL){   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('series_stores_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'series' ) : '';
        $title='Series';
        $rules = $this->series_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->series_m->get($id,TRUE);
		/*echo '<pre>';
		print_r($info);exit;*/
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
       
        
        if($this->form_validation->run()==TRUE){

            $data = $this->array_from_post($post);


            // Set TV Show Platform Status
            $data['tv_show_platform_status'] = $this->input->post('tv_show_platform_status') ? 1 : 0;


            // Remove platform arrays from main data
            if(isset($data['ott_platforms'])) {
                unset($data['ott_platforms']);
            }
            if(isset($data['tv_show_platforms'])) {
                unset($data['tv_show_platforms']);
            }
            $this->series_m->save($id,$data);

            // Handle store_id
            $store_id=$this->input->post('parent_store');
            if($this->input->post('sub_store')!=""){
                $store_id=$this->input->post('sub_store');
            }   

            $data = array('store_id'=>$store_id);
            $this->series_m->save($id,$data);

           

            // Handle OTT Platforms
            $ott_platforms = $this->input->post('ott_platforms');
            $this->series_ott_platforms_m->delete_platforms_by_series($id);
            if (is_array($ott_platforms) && count($ott_platforms) > 0 && !in_array('', $ott_platforms)) {
                foreach ($ott_platforms as $platform_id) {
                    $this->db->insert('series_to_platforms', array(
                        'ott_platform_id' => $platform_id,
                        'series_id' => $id
                    ));
                }
                $data_ott_platforms = array('ott_platforms' => implode(',', $ott_platforms));
                $this->series_m->save($id, $data_ott_platforms);
            } else {
                // If no platforms selected or only "No Selection" selected
                $this->series_m->save($id, array('ott_platforms' => ''));
            }



            // Handle TV Show Platforms
            if($this->input->post('tv_show_platform_status') == 1) {
                $tv_show_platforms = $this->input->post('tv_show_platforms');
                $this->tv_show_platforms_m->delete_platforms_by_tv_show($id);
                if (is_array($tv_show_platforms) && count($tv_show_platforms) > 0 && !in_array('', $tv_show_platforms)) {
                    foreach ($tv_show_platforms as $platform_id) {
                        $this->db->insert('series_to_tv_platforms', array(
                            'platform_id' => $platform_id,
                            'series_id' => $id
                        ));
                    }
                    $data_tv_platforms = array('tv_show_platforms' => implode(',', $tv_show_platforms));
                    $this->series_m->save($id, $data_tv_platforms);
                }
            } else {
                // Clear TV show platforms when status is disabled
                $this->tv_show_platforms_m->delete_platforms_by_tv_show($id);
                $this->series_m->save($id, array('tv_show_platforms' => ''));
            }

            //upload files if there is an image 
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
            {
                $filename = $this->upload_image('logo', $info->logo, LOCAL_PATH_IMAGES_CMS, 'series_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
				 $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }


           /* if(isset($_FILES['poster']['name']) && $_FILES['poster']['name']!='')
            {
                $filename= $this->upload_image('poster', $info->poster, SERIES_POSTER_UPLOAD_PATH, 'series_m',$id);
                $localFilePath = SERIES_POSTER_UPLOAD_PATH.$filename;
                $this->uploadToServer($filename,$localFilePath,"images/series/poster");
            }

            if(isset($_FILES['backdrop']['name']) && $_FILES['backdrop']['name']!='')
            {
                $filename= $this->upload_image('backdrop',$info->backdrop, SERIES_BACKDROP_UPLOAD_PATH, 'series_m',$id);
                $localFilePath = SERIES_BACKDROP_UPLOAD_PATH.$filename;
                $this->uploadToServer($filename,$localFilePath,"images/series/backdrop");
            }*/
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series/edit/'.$id).'" target="_blank">Series Updated</a>');          
            $this->session->set_flashdata('success',$title." Edited Successfully.");
            redirect(BASE_URL.'series');
        }
       
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit '.$title, 'series/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get tokens 
        $this->data['tokens']=$this->series_m->get_tokens();
        
        //get languages
        $this->data['languages']=$this->languages_m->get();

        // get all parent stores
        $this->data['stores'] =$this->series_stores_m->get_by(array('parent_id'=>0));

        $this->data['ott_platforms'] = $this->series_ott_platforms_m->get();        
        $this->data['selected_ott_platforms'] = $this->series_ott_platforms_m->get_platforms_by_series($id);

        $this->data['tv_show_platforms'] = $this->tv_show_platforms_m->get();  
        $this->data['selected_tv_platforms'] = $this->tv_show_platforms_m->get_platforms_by_tv_show($id);

        // check parent store 
        $parent_id=$this->series_stores_m->check_if_parent($info->store_id);
        
        $this->data['sub_stores'] = array();

        if($parent_id==0){
            $this->data['parent_store_id']= $info->store_id;
            $this->data['sub_store_id']= 0;
        }else{
            $this->data['parent_store_id']= $parent_id;
            $this->data['sub_store_id']= $info->store_id;
            // get sub stores 
            $this->data['sub_stores'] =$this->series_stores_m->get_by(array('parent_id'=>$parent_id));
        }

        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'series/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'series/edit';
        $this->data['title'] =$title;
        $this->data['page_title'] = "Edit ". $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function seasons($series_id){
        $this->load->model('series_seasons_m');
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'series_seasons/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'series_seasons/index';
        $this->data['page_title'] = "Series Seasons";
        $this->data['add_text'] = "Add a season";
        $this->data['series_id'] = $series_id;
        $this->data['series_info'] = $this->series_m->get_by(array('id'=>$series_id), True);
        $this->data['seasons'] =  $this->series_seasons_m->get_by(array('series_id'=>$series_id));
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function get_all_series($type=""){
        $totaldata = 10;
        $totalfiltered = 10;

        if($type==""){
            $series = $this->series_m->get();
        }else{
            $series = $this->series_m->get_by(array('type'=>'2'));  // movie type= series =2
        }
        $data = array();
        foreach ($series as $serie) {
            $data[] = array(
                    'id'=>"<a href='".site_url('series/edit/'.$serie['id'])."'>".$serie['id']."</a>",
                    'name'=>"<a href='".site_url('episodes/series/'.$serie['id'])."'>".ucwords($serie['name'])."</a>  <a href='".site_url('episodes/create/'.$serie['id'])."'><i class='fa fa-plus'></i> Add Episode</a>",
                    'actor'=>$serie['actor'],
                    'year'=>$serie['year'],
                    'director'=>ucwords($serie['director']),
                    'edit'=>btn_edit(BASE_URL.'series/edit/'.$serie['id']),
                    'delete'=>btn_delete(BASE_URL.'series/delete/'.$serie['id']),
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
	
	 public function import_series(){
		$id = urlencode(trim($this->input->post("id"))); // $id = 31910;
		$dbselect = urlencode(trim($this->input->post("dbselect")));
		$sall = urlencode(trim($this->input->post("sall")));
		
		if($sall == 'one'){
			$sessionid = $this->series_m->get_store_info_all_tmbd($id);
			
			$this->load->model('series_stores_m');
			$parent_stores = $this->series_stores_m->get_by(array('parent_id'=>0));
			//echo '<pre>';
			//print_r($id);
			if(count($sessionid) == count($parent_stores)){
				$response['imdb_status']  = "fail";
				$response['error_message']  = "Already Imported";
				//echo json_encode($response);
				echo json_encode(array("resultist" => "one", "resdata" => $response));
				
				//$response['selected_store'] = $sessionid;
			} 
            else {
					$this->load->model('tmdb_model');	
					if($dbselect == 'tmdb'){				
						$data = $this->tmdb_model->get_tvseriesinfo($id);
					} elseif($dbselect == 'imdb'){
						$data = $this->tmdb_model->get_tvseriesinfoIMDB($id);
					}
					
					//print_r($this->tmdb_model->getMovieImageResizeIbdm($data['backdrop_path'], '1280' ,'720'));
					if(isset($data['status']) && $data['status']=='success'){
						$response['imdb_status']    = 'success';
						$response['name']           = $data['name'];
						$response['tmdb_id']        = $data['tmdb_id'];          
						$response['genres']         = $data['genres'];
						if($dbselect == 'tmdb'){
							$response['backdrop_path']  = $data['backdrop_path'];
						} elseif($dbselect == 'imdb'){
							$response['backdrop_path']         = $this->tmdb_model->getMovieImageResizeIbdm($data['backdrop_path'], '640' ,'360');
						}
						$response['response']       = 'yes';
						$response['selected_store'] = json_encode($sessionid);
					} else{
						$response['imdb_status']    = 'fail';
						$response['name']           = '';
						$response['tmdb_id']        = '';
						$response['genres']         = '';
						$response['backdrop_path']  = '';						
						$response['response']       = 'no';
					}
					echo json_encode(array("resultist" => "one", "resdata" => $response));
			}
		} else{
				$this->load->model('tmdb_model');
				
				if($dbselect == 'tmdb'){					
					$data = $this->tmdb_model->getSeriesInfoAll($id); 
				} elseif($dbselect == 'imdb'){
					$data = $this->tmdb_model->getSeriesInfoAllIMDB($id); 
				}
				echo json_encode(array("resultist" => "all", "resdata" => $data, "dbselect" => $dbselect));
		}
		
	}
}/* End of file Series.php */
/* Location: ./application/controllers/series.php */