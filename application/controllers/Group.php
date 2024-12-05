<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'group/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'group/index';
		$this->data['page_title'] = "List group";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}


	public function add()
	{

		$rules = $this->group_m->add_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('group_name'));
			$this->group_m->save(NULL,$data);
			$this->session->set_flashdata('group_msg',"Group Added Successfully.");
			redirect(BASE_URL.'group');
		}
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'group/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'group/add';
		$this->data['page_title'] = "Add Group";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'group' ) : '';
		$rules = $this->group_m->edit_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('group_name'));
			$this->group_m->save($id,$data);
			$this->session->set_flashdata('group_msg',"Group Edited Successfully.");
			redirect(BASE_URL.'group');
		}
		$this->data['group_details'] = $this->group_m->get($id,TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'group/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'group/edit';
		$this->data['page_title'] = "Edit group";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'group' ) : '';
		$this->group_m->delete($id);
		redirect( BASE_URL . 'group' );
	}

}

/* End of file Group.php */
/* Location: ./application/controllers/Group.php */