<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_stores extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->data['is_allow']= check_permission(40);
		$this->load->model('movie_stores_m');
		$this->load->model('languages_m');
		$this->load->model('movies_m');
		
		$this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "movie_stores";
	}

	public function index()
	{
		$this->data['is_allow']= check_permission(40);
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_stores/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_stores/index';
		$this->data['page_title'] = "List Stores";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function get_all_store(){
		$this->data['is_allow']= check_permission(40);
		$totaldata = 10;
		$totalfiltered = 10;
		$stores = $this->movie_stores_m->getMoviesStore(0);
		$data = array();
		
		// Load the movies model
    	$this->load->model('movies_m');

		foreach ($stores as $store) {
			$movie_count = $this->movies_m->count_movies_by_store($store['id']);
			$data[] = array(
					'id'=>"<a href='".site_url('movie_stores/edit/'.$store['id'])."'>".$store['id']."</a>",
					'name'=>"<a href='".site_url('movie_stores/sub_store/'.$store['id'])."'>".ucwords($store['name']) ."(".$this->movie_stores_m->count_sub_stores($store['id']) .")</a>",
					'position'=>ucwords($store['position']),
					'language_name'=>ucwords($store['language_name']),
					'total_movies'=> $movie_count, // Add this line
					'active'=>($store['active']==0) ? "Inactive" : "Active",
					'edit'=>btn_edit(BASE_URL.'movie_stores/edit/'.$store['id']),
					'delete'=>btn_delete(BASE_URL.'movie_stores/delete/'.$store['id']),
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

	public function add($parent_id="")
	{	
		$this->data['is_allow']= check_permission(40);
		check_allow('create',$this->data['is_allow']);
		$rules = $this->movie_stores_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('parent_id','name','position','language_id','active','childlock'));
			$insert_id=$this->movie_stores_m->save(NULL,$data);
			
			//upload files if there is an image 
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', '', LOCAL_PATH_IMAGES_CMS, 'movie_stores_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                //resize image 
               // $this->resize_image($_FILES["logo"]["tmp_name"],$localFilePath,'640','360');
 				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            } 

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_stores/edit/'.$insert_id).'" target="_blank">Movie Store Added</a>');   

			$this->session->set_flashdata('success',"Movie Store Added Successfully.");
			if($parent_id)
				redirect(BASE_URL.'movie_stores/sub_store/'.$parent_id);
			else
				redirect(BASE_URL.'movie_stores');
		}

		//get languages
        $this->data['languages']=$this->languages_m->get();

		$this->data['parent_id'] = $parent_id;
		$this->data['main_stores'] =$this->movie_stores_m->get_parent_store();
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_stores/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_stores/add';
		$this->data['page_title'] = "Add New Store";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{	
		$this->data['is_allow']= check_permission(40);
		check_allow('edit',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_stores' ) : '';
		$rules = $this->movie_stores_m->rules;
		$this->form_validation->set_rules($rules);
		$info=$this->movie_stores_m->get($id,TRUE);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('parent_id','name','position','language_id','active','childlock'));
			$this->movie_stores_m->save($id,$data);
			
			//upload files if there is an image 
            if($_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', $info->logo, LOCAL_PATH_IMAGES_CMS, 'movie_stores_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                //resize image 
               // $this->resize_image($_FILES["logo"]["tmp_name"],$localFilePath,'640','360');
 $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_stores/edit/'.$id).'" target="_blank">Movie Store Updated</a>');   
			$this->session->set_flashdata('success',"Store Edited Successfully.");
			$parent=$this->movie_stores_m->check_if_parent($id);
			if($parent==0)
				redirect(BASE_URL.'movie_stores/');
			else
				redirect(BASE_URL.'movie_stores/sub_store/'.$parent);
		}

		//get languages
        $this->data['languages']=$this->languages_m->get();

		$this->data['main_stores'] =$this->movie_stores_m->get_parent_store();
		$this->data['details'] = $info;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_stores/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_stores/edit';
		$this->data['page_title'] = "Edit Store";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{	
		$this->data['is_allow']= check_permission(40);
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_stores' ) : '';
		$this->movie_stores_m->delete($id);
		
		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_stores').'" target="_blank">Movie Store Deleted</a>');   
		$this->session->set_flashdata('success',"Store Deleted Successfully.");
		redirect( BASE_URL . 'movie_stores' );
	}

	public function sub_store($id){
		$this->data['id'] =$id;
		$this->data['main_store_info'] =$this->movie_stores_m->get_store_info($id);
		$this->data['stores'] = $this->movie_stores_m->getMoviesStore($id);
		$this->data['_view'] = DEFAULT_THEME . 'movie_stores/sub_store';
		$this->data['page_title'] = "List Sub Stores";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

	public function get_substore($id){
		$totaldata = 10;
		$totalfiltered = 10;
		$stores = $this->movie_stores_m->get_by(array('parent_id'=>$id));
		$data = array();
		foreach ($stores as $store) {
			$movie_count = $this->movies_m->count_movies_by_store($store['id']);
			$data[] = array(
					'id'=>"<a href='".site_url('movie_stores/edit/'.$store['id'])."'>".$store['id']."</a>",
					'name'=>ucwords($store['name']),
					'position'=>ucwords($store['position']),
					'total_movies'=> $movie_count, // Add this line
					'active'=>($store['active']==0) ? "Inactive" : "Active",
					'edit'=>btn_edit(BASE_URL.'movie_stores/edit/'.$store['id']),
					'delete'=>btn_delete(BASE_URL.'movie_stores/delete/'.$store['id']),
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


	public function fetch_sub_stores(){
      	if($this->input->post('parent_id'))
      	{
       		echo $this->movie_stores_m->fetch_sub_stores($this->input->post('parent_id'));
      	}
    }


    public function fetch_sub_stores_and_genres(){ 
		//check_permission(43);
      	if($this->input->post('parent_id'))
      	{
       		$stores= $this->movie_stores_m->fetch_sub_stores($this->input->post('parent_id'));
			$stores= $this->movie_stores_m->fetch_sub_stores_checkbox($this->input->post('parent_id'));
			
      	//print_r($stores);
       		$genres= $this->movie_stores_m->fetch_genres($this->input->post('parent_id'));
           	echo json_encode(array('stores'=>$stores,
      		 			           'genres'=>$genres)
           					);
      	}
    }

    public function fetch_genres(){
    	if($this->input->post('store_id'))
      	{
       		echo $this->movie_stores_m->fetch_genres($this->input->post('store_id'));
      	}
    }

}/* End of file Movie Stores.php */
/* Location: ./application/controllers/movie_stores.php */