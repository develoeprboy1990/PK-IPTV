<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_ott_platforms extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(61);
		$this->load->model('movie_ott_platforms_m');
		$this->data['main_nav'] = "vod";
        $this->data['sub_nav'] = "movie_ott_platforms";
	}

	public function index()
	{ 
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_ott_platforms/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_ott_platforms/index';
		$this->data['page_title'] = "OTT Platforms";
		$this->data['platforms'] = $this->movie_ott_platforms_m->get();
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function add()
	{
		check_allow('create',$this->data['is_allow']);
		$rules = $this->movie_ott_platforms_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = array('name'=>$this->input->post('name'));
			$insert_id=$this->movie_ott_platforms_m->save(NULL,$data);
			
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_ott_platforms').'" target="_blank">OTT Platform Added</a>');   
			$this->session->set_flashdata('success',"OTT Platform Added Successfully.");
			redirect(BASE_URL.'movie_ott_platforms');
		}

		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_ott_platforms/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_ott_platforms/add';
		$this->data['page_title'] = "Add OTT Platform";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function getItem(){
        $id=$this->input->post('id');
        $info= $this->movie_ott_platforms_m->get($id,true);
        echo json_encode(array(
            'name' => $info->name,
            'order_no' => $info->order_no ? $info->order_no : 0
        ));
    }

	public function addItem(){
    	check_allow('create',$this->data['is_allow']);
        $data = array(
        	'name'=>$this->input->post('name'),
        	'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0
        );

        $insert_id= $this->movie_ott_platforms_m->save(NULL,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_ott_platforms').'" target="_blank">OTT Platform Added</a>');   
        echo $insert_id;
    }

    public function updateItem(){
    	check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array(
        	'name'=>$this->input->post('name'),
        	'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0
    	);
        $this->movie_ott_platforms_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_ott_platforms').'" target="_blank">OTT Platform Updated</a>');   
        echo "Updated Successfully";
    }

	public function edit($id = NULL)
	{	
		check_allow('edit',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_ott_platforms' ) : '';
		$info=$this->movie_ott_platforms_m->get($id,TRUE);
		$rules = $this->movie_ott_platforms_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			
			$data = array(
				'name'=>$this->input->post('name'),
				'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0
			);
			$this->movie_ott_platforms_m->save($id,$data);

			$this->session->set_flashdata('success',"OTT Platform Edited Successfully.");
			redirect(BASE_URL.'movie_ott_platforms');
		}

		$this->data['details'] = $info;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'movie_ott_platforms/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'movie_ott_platforms/edit';
		$this->data['page_title'] = "Edit OTT Platform";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'movie_ott_platforms' ) : '';
		$this->movie_ott_platforms_m->delete($id);
		redirect( BASE_URL . 'movie_ott_platforms' );
	}

	public function deleteItem($id = NULL)
    {   
    	check_allow('delete',$this->data['is_allow']);
        $id=$this->input->post('id');
        $this->movie_ott_platforms_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('movie_ott_platforms').'" target="_blank">OTT Platform Deleted</a>');   
        echo "Deleted Successfully";
    }
}