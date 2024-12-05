<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_languages extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(42);
		$this->load->model('languages_m');
		$this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "movie_languages";
	}

	public function index()
	{ 
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_languages/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_languages/index';
		$this->data['page_title'] = "Movie Languages";
		$this->data['languages'] =$this->languages_m->get();
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function add()
	{
		check_allow('create',$this->data['is_allow']);
		$rules = $this->languages_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = array('name'=>$this->input->post('name'),
						  'code'=>strtolower($this->input->post('name')),
						  'active'=>1,
						  'create_date'=>time()
						);
			$insert_id=$this->languages_m->save(NULL,$data);
			
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_languages').'" target="_blank">Language Added</a>');   
			$this->session->set_flashdata('success',"Movie Language Added Successfully.");
			redirect(BASE_URL.'movie_languages');
		}

		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_languages/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_languages/add';
		$this->data['page_title'] = "Add Movie Language";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	//ajax function 
    public function getItem(){
        $id=$this->input->post('id');
        $info= $this->languages_m->get($id,true);
        echo $info->name;
    }

	//ajax function 
    public function addItem(){
    	check_allow('create',$this->data['is_allow']);
        $data = array('name'=>$this->input->post('name'),
					  'code'=>strtolower($this->input->post('name')),
					  'active'=>1,
					  'create_date'=>time()
					);

        $insert_id= $this->languages_m->save(NULL,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_languages').'" target="_blank">Language Added</a>');   
        echo $insert_id;
    }

    //ajax function 
    public function updateItem(){
    	check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('name'=>$this->input->post('name'));
        $this->languages_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_languages').'" target="_blank">Language Updated</a>');   
        echo "Updated Successfully";
    }

	public function edit($id = NULL)
	{	
		check_allow('edit',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_languages' ) : '';
		$info=$this->languages_m->get($id,TRUE);
		$rules = $this->languages_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			
			$data = array('name'=>$this->input->post('name'),
						  'code'=>strtolower($this->input->post('name'))
						);
			$this->languages_m->save($id,$data);

			$this->session->set_flashdata('success',"Language Edited Successfully.");
			redirect(BASE_URL.'movie_languages');
		}

		$this->data['details'] = $info;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_languages/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_languages/edit';
		$this->data['page_title'] = "Edit Language";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_languages' ) : '';
		$this->languages_m->delete($id);
		redirect( BASE_URL . 'movie_languages' );
	}

	public function deleteItem($id = NULL)
    {   
    	check_allow('delete',$this->data['is_allow']);
        $id=$this->input->post('id');
        $this->languages_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_languages').'" target="_blank">Language Deleted</a>');   
        echo "Deleted Successfully";
    }

}/* End of file Movie Languages.php */
/* Location: ./application/controllers/Movie_languages.php */