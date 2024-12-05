<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['all_employees'] = $this->employee_m->get();
		$this->data['all_groups'] = $this->group_m->get();
		//Do your magic here
	}

	public function index()
	{
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'user/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'user/index';
		$this->data['page_title'] = "List users";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);		
	}


	public function add()
	{
		$rules = $this->user_m->add_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('user_employee_id','user_group_id','user_name','user_password'));
			$this->user_m->save(NULL,$data);
			$this->session->set_flashdata('user_msg',"Employee Added Successfully.");
			redirect(BASE_URL.'user');
		}
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'user/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'user/add';
		$this->data['page_title'] = "Add new user";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);		
	}

	public function edit($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'user' ) : '';
		$rules = $this->user_m->edit_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('user_employee_id','user_group_id','user_name','user_password'));
			$this->user_m->save($id,$data);
			$this->session->set_flashdata('user_msg',"Employee Edit Successfully.");
			redirect(BASE_URL.'user');
		}
		$this->data['user_details'] = $this->user_m->get_join($id, NULL, TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'user/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'user/edit';
		$this->data['page_title'] = "Edit user";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);		
	}

	public function delete($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'user' ) : '';
		$this->employee_m->delete($id);
		redirect( BASE_URL . 'user' );
	}
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */