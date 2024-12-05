<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends MY_Model {

	protected $_table_name = 'users';
	public $login_rules = array(
		'admin_email' => array(
			'field' => 'admin_email',
			'label' => 'Email ID',
			'rules' => 'required|trim'
		),
		'admin_password' => array(
			'field' => 'admin_password',
			'label' => 'Password',
			'rules' => 'required|trim|min_length[6]'
		),
	);

	public $add_rules = array(
		'user_employee_id' => array(
			'field' => 'user_employee_id',
			'label' => 'Employee ID',
			'rules' => 'required|trim'
		),
		'user_group_id' => array(
			'field' => 'user_group_id',
			'label' => 'Group ID',
			'rules' => 'required|trim'
		),
		'user_name' => array(
			'field' => 'user_name',
			'label' => 'Username',
			'rules' => 'required|trim'
		),
		'user_password' => array(
			'field' => 'user_password',
			'label' => 'Password',
			'rules' => 'required|trim'
		),
	);

	public $edit_rules = array(
		'user_employee_id' => array(
			'field' => 'user_employee_id',
			'label' => 'Employee ID',
			'rules' => 'required|trim'
		),
		'user_group_id' => array(
			'field' => 'user_group_id',
			'label' => 'Group ID',
			'rules' => 'required|trim'
		),
		'user_name' => array(
			'field' => 'user_name',
			'label' => 'Username',
			'rules' => 'required|trim'
		),
		'user_password' => array(
			'field' => 'user_password',
			'label' => 'Password',
			'rules' => 'required|trim'
		),
	);
	

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}


	public function check_other_emails($user_email,$user_id){
		$sql="select email from users where id<>$user_id";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function login(){
		$user = $this->get_by(array(
			'admin_email' => $this->input->post('admin_email'),
			'admin_password' => $this->input->post('admin_password'),
		 ), TRUE);
		if(!empty($user)){
			$data = array(
				'admin_id' => $user->id,
				'admin_email' => $user->admin_email,
				'admin_loggedin' => TRUE,
			);
			$this->session->set_userdata($data);
		}
	}

	public function loggedin(){
		return (bool) $this->session->userdata('admin_loggedin');
	}

	public function logout(){
		$this->session->sess_destroy();
	}


}	

/* End of file User_m.php */
/* Location: ./application/models/User_m.php */