<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(19);
		$this->data['main_nav'] = "employee";
        $this->data['sub_nav'] = "employee";
	}

	public function index()
	{
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'employee/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'employee/index';
		$this->data['page_title'] = "List employees";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}


	public function add()
	{
		$rules = $this->employee_m->add_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('emp_name'));
			$this->employee_m->save(NULL,$data);
			$this->session->set_flashdata('emp_msg',"Employee Added Successfully.");
			redirect(BASE_URL.'employee');
		}
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'employee/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'employee/add';
		$this->data['page_title'] = "Add new employee";
		
		$this->data['main_nav'] = "employee";
        $this->data['sub_nav'] = "employee_add";

		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'employee' ) : '';
		$rules = $this->employee_m->edit_rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('emp_name'));
			$this->employee_m->save($id,$data);
			$this->session->set_flashdata('emp_msg',"Employee Edited Successfully.");
			redirect(BASE_URL.'employee');
		}
		$this->data['emp_details'] = $this->employee_m->get($id,TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'employee/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'employee/edit';
		$this->data['page_title'] = "Edit employee";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'employee' ) : '';
		$this->employee_m->delete($id);
		redirect( BASE_URL . 'employee' );
	}

}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */