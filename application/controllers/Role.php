<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'role/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'role/index';
		$this->data['page_title'] = "List Role";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}


	public function add()
	{
		$rules = $this->role_m->add_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('role_name'));
			$insert_id=$this->role_m->save(NULL,$data);
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('role/edit/'.$insert_id).'" target="_blank">Role Created</a>');   
			$this->session->set_flashdata('role_msg',"Role Added Successfully.");
			redirect(BASE_URL.'role');
		}
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'role/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'role/add';
		$this->data['page_title'] = "Add role";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}


	public function edit($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'role' ) : '';
		$rules = $this->role_m->edit_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('role_name'));
			$this->role_m->save($id,$data);
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('role/edit/'.$id).'" target="_blank">Role Updated</a>');   
			$this->session->set_flashdata('role_msg',"Role Edited Successfully.");
			redirect(BASE_URL.'role');
		}
		$this->data['role_details'] = $this->role_m->get($id,TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'role/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'role/edit';
		$this->data['page_title'] = "Edit role";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'role' ) : '';
		$this->role_m->delete($id);
		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('role').'" target="_blank">Role Deleted</a>');   
		redirect( BASE_URL . 'role' );
	}
}

/* End of file Role.php */
/* Location: ./application/controllers/Role.php */