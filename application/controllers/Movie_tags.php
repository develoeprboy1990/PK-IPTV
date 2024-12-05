<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_tags extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(61);
		$this->load->model('movie_tags_m');
		$this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "movie_tags";
	}

	public function index()
	{ 
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_tags/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_tags/index';
		$this->data['page_title'] = "Movie Tags";
		$this->data['tags'] =$this->movie_tags_m->get();
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function add()
	{
		check_allow('create',$this->data['is_allow']);
		$rules = $this->movie_tags_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = array('name'=>$this->input->post('name'));
			$insert_id=$this->movie_tags_m->save(NULL,$data);
			
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_tags').'" target="_blank">Movie Tags Added</a>');   
			$this->session->set_flashdata('success',"Movie Tags Added Successfully.");
			redirect(BASE_URL.'movie_tags');
		}

		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_tags/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_tags/add';
		$this->data['page_title'] = "Add Movie Tag";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	//ajax function 
    public function getItem(){
        $id=$this->input->post('id');
        $info= $this->movie_tags_m->get($id,true);
        echo $info->name;
    }

	//ajax function 
    public function addItem(){
    	check_allow('create',$this->data['is_allow']);
        $data = array('name'=>$this->input->post('name'));

        $insert_id= $this->movie_tags_m->save(NULL,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_tags').'" target="_blank">Language Added</a>');   
        echo $insert_id;
    }

    //ajax function 
    public function updateItem(){
    	check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('name'=>$this->input->post('name'));
        $this->movie_tags_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_tags').'" target="_blank">MOvie Tag Updated</a>');   
        echo "Updated Successfully";
    }

	public function edit($id = NULL)
	{	
		check_allow('edit',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_tags' ) : '';
		$info=$this->movie_tags_m->get($id,TRUE);
		$rules = $this->movie_tags_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			
			$data = array('name'=>$this->input->post('name'));
			$this->movie_tags_m->save($id,$data);

			$this->session->set_flashdata('success',"Movie Tag Edited Successfully.");
			redirect(BASE_URL.'movie_tags');
		}

		$this->data['details'] = $info;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_tags/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_tags/edit';
		$this->data['page_title'] = "Edit Movie Tag";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_tags' ) : '';
		$this->movie_tags_m->delete($id);
		redirect( BASE_URL . 'movie_tags' );
	}

	public function deleteItem($id = NULL)
    {   
    	check_allow('delete',$this->data['is_allow']);
        $id=$this->input->post('id');
        $this->movie_tags_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_tags').'" target="_blank">Movie Tag Deleted</a>');   
        echo "Deleted Successfully";
    }

}/* End of file Movie_Tags.php */
/* Location: ./application/controllers/movie_tags.php */