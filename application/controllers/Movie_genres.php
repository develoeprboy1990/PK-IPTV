<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_genres extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(41);
		$this->load->model('movie_genres_m');
		$this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "movie_genres";
	}

	public function index()
	{ 
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_genres/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_genres/index';
		$this->data['page_title'] = "List Genres";
		$this->data['genres'] =$this->movie_genres_m->getGenres();
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function get_all_genre(){
		$totaldata = 10;
		$totalfiltered = 10;
		$genres = $this->movie_genres_m->get();
		$data = array();
		foreach ($genres as $genre) {
			$data[] = array(
					'id'=>"<a href='".site_url('movie_genres/edit/'.$genre['id'])."'>".$genre['id']."</a>",
					'name'=>ucwords($genre['name']),
					'edit'=>btn_edit(BASE_URL.'movie_genres/edit/'.$genre['id']),
					'delete'=>btn_delete(BASE_URL.'movie_genres/delete/'.$genre['id']),
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

	public function add()
	{
		check_allow('create',$this->data['is_allow']);
		$this->load->model('movie_stores_m');
		$rules = $this->movie_genres_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			
			//$data = $this->array_from_post(array('name'));
			/*$store_id=$this->input->post('parent_store');
			
			if($this->input->post('sub_store')!=""){
				$store_id=$this->input->post('sub_store');
			}	

			$data = array('name'=>$this->input->post('name'),
						  'store_id'=>$store_id
						);
			*/
			$data = array(
				'name'=>$this->input->post('name'),
				'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0
			);
			$insert_id=$this->movie_genres_m->save(NULL,$data);
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_genres/edit/'.$insert_id).'" target="_blank">Movie Genre Created</a>');   
			$this->session->set_flashdata('success',"Movie Genre Added Successfully.");
			redirect(BASE_URL.'movie_genres');
		}

		// get all parent stores 
		$this->data['stores'] =$this->movie_stores_m->get_by(array('parent_id'=>0));
		
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_genres/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_genres/add';
		$this->data['page_title'] = "Add New Genre";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{	
		check_allow('edit',$this->data['is_allow']);
		$this->load->model('movie_stores_m');
		( $id == NULL ) ? redirect( BASE_URL . 'movie_genres' ) : '';
		$info=$this->movie_genres_m->get($id,TRUE);
		$rules = $this->movie_genres_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){			
			$store_id=$this->input->post('parent_store');
			
			if($this->input->post('sub_store')!=""){
				$store_id=$this->input->post('sub_store');
			}	

			$data = array('name'=>$this->input->post('name'),
				 		  'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0,
						  'store_id'=>$store_id
						);
			$this->movie_genres_m->save($id,$data);

			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_genres/edit/'.$id).'" target="_blank">Movie Genre Updated</a>');   
			$this->session->set_flashdata('success',"Genre Edited Successfully.");
			redirect(BASE_URL.'movie_genres');
		}

		// get all parent stores
		$this->data['stores'] =$this->movie_stores_m->get_by(array('parent_id'=>0));

		// check parent store 
		$parent_id=$this->movie_stores_m->check_if_parent($info->store_id);
		
		$this->data['sub_stores'] = array();

		if($parent_id==0){
			$this->data['parent_store_id']= $info->store_id;
			$this->data['sub_store_id']= 0;
		}else{
			$this->data['parent_store_id']= $parent_id;
			$this->data['sub_store_id']= $info->store_id;
			// get sub stores 
			$this->data['sub_stores'] =$this->movie_stores_m->get_by(array('parent_id'=>$parent_id));
		}

		//$this->load->model('movies_m');
		$genres_select = $this->movie_stores_m->get_genres_select($info->store_id);
		$this->data['genres_select'] = $genres_select;
			
		//echo '<pre>';
		$genres_all = $this->movie_stores_m->get_genres_all($info->store_id);
		$this->data['genres_all'] = $genres_all;
			/*print_r($genres_select);
			print_r($genres_all);
			exit;*/
		$this->data['details'] = $info;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_genres/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_genres/edit';
		$this->data['page_title'] = "Edit Genre";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{	
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_genres' ) : '';
		$this->movie_genres_m->delete($id);
		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_genres').'" target="_blank">Movie Genre Deleted</a>');   
		$this->session->set_flashdata('success',"Movie Genre Deleted Successfully.");
		redirect( BASE_URL . 'movie_genres' );
	}

}/* End of file Movie Genres.php */
/* Location: ./application/controllers/Movie_genres.php */