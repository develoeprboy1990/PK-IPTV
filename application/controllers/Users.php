<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(1);
		/* Load :: Common */
		$this->lang->load('users');
		$this->lang->load('actions');
		$this->load->library('breadcrumbs');
		$this->load->library('page_title');
		
		/* Title Page :: Common */
		$this->page_title->push(lang('menu_users'));
		$this->data['page_title'] = $this->page_title->show();
		$this->data['pagetitle'] = $this->page_title->show();
		$this->data['main_nav'] = "users";
        $this->data['sub_nav'] = "users";
		/* Breadcrumbs :: Common */
		$this->breadcrumbs->unshift(1, lang('menu_users'), 'users');
	}

	public function index()
	{
		check_allow('view',$this->data['is_allow']);	
		$this->data['page_title'] = "List users";
		$this->data['pagetitle'] = "List users";
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['users'] = $this->ion_auth->users()->result();
		
		foreach ($this->data['users'] as $k => $user)
		{
			$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}

		$this->data['_view'] = DEFAULT_THEME . 'users/index';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function create()
	{	
		check_allow('create',$this->data['is_allow']);
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_create'), 'admin/users/create');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Variables */
		$tables = $this->config->item('tables', 'ion_auth');

		/* Validate form input */
		$this->form_validation->set_rules('first_name', 'lang:users_firstname', 'required');
		$this->form_validation->set_rules('last_name', 'lang:users_lastname', 'required');
		$this->form_validation->set_rules('email', 'lang:users_email', 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('phone', 'lang:users_phone', 'required');
		$this->form_validation->set_rules('company', 'lang:users_company', 'required');
		$this->form_validation->set_rules('password', 'lang:users_password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'lang:users_password_confirm', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
				'role'      => $this->input->post('user_role')
			);
		}

		if ($this->form_validation->run() == TRUE && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			// Send Email Notification
			$this->load->model('email_templates_m','EM');
			$template=$this->EM->get_email_template("user_added_notification");
			
			$login_link="<a href='".site_url('login/')."'>".site_url('login/')."</a>";
        	$parse_data=array('FIRST_NAME'=>$this->input->post('first_name'),
        					  'USERNAME'=>$email,
                          	  'PASSWORD'=>$password,
                          	  'LOGIN_LINK'=>$login_link,
                              'EMAIL' => $email                             
                        	);
            
            // send email to customer
            $this->load->model('Email_model');
            $email_status=$this->Email_model->send_email($template,$parse_data);

            $this->userlogs->track_this($this->session->user_id, 'New user created with username '.$email); 
			
			if($email_status){
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('users', 'refresh');
			}
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'class' => 'form-control',
                'required' => 'required',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'email',
				'class' => 'form-control',
                                 'required' => 'required',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'tel',
				'pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'class' => 'form-control',
                'required' => 'required',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'class' => 'form-control',
                'required' => 'required',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->data['main_nav'] = "users";
        	$this->data['sub_nav'] = "users";
        	$this->data['page_title'] = "Add an User";
        	$this->data['pagetitle'] = "Add an User";
        	$this->data['groups'] = $this->ion_auth->groups()->result_array();
			/* Load Template */
			$this->data['_view'] = DEFAULT_THEME . 'users/create';
			$this->load->view( DEFAULT_THEME . '_layout',$this->data);
			//$this->template->admin_render('admin/users/create', $this->data);
		}
	}

	public function delete($id = 0)
	{
		check_allow('delete',$this->data['is_allow']);
		if ( ! $this->ion_auth->logged_in())
            {
                redirect('login', 'refresh');
            }
            elseif ( ! $this->ion_auth->is_admin())
                    {
                return show_error('You must be an administrator to view this page.');
            }
            else
            {
                $delete = $this->db->delete('users', array('id' => $id));
                if($delete){
                   $this->userlogs->track_this($this->session->user_id, 'User Deleted'); 
                   $this->session->set_flashdata('message','The user deleted successfully');
                }
                else
                    $this->session->set_flashdata('message','The user has not been deleted');
                
               redirect('users','refresh');
                
            }
	}

	public function edit($id)
	{
		check_allow('edit',$this->data['is_allow']);
		$id = (int) $id;

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_edit'), 'admin/users/edit');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$user          = $this->ion_auth->user($id)->row();
		$groups        = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		/* Validate form input */
		$this->form_validation->set_rules('first_name', 'lang:edit_user_validation_fname_label', 'required');
		$this->form_validation->set_rules('last_name', 'lang:edit_user_validation_lname_label', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check_other_than');
		$this->form_validation->set_rules('phone', 'lang:edit_user_validation_phone_label', 'required');
		$this->form_validation->set_rules('company', 'lang:edit_user_validation_company_label', 'required');

		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() == TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
                    'role'       => $this->input->post('user_role')
				);

				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

//				if ($this->ion_auth->is_admin())
//				{
//					$groupData = $this->input->post('groups');
//
//					if (isset($groupData) && !empty($groupData))
//					{
//						$this->ion_auth->remove_from_group('', $id);
//
//						foreach ($groupData as $grp)
//						{
//							$this->ion_auth->add_to_group($grp, $id);
//						}
//					}
//				}

				if($this->ion_auth->update($user->id, $data))
				{
					$this->userlogs->track_this($this->session->user_id, 'User "'.$this->input->post('first_name').' '.$this->input->post('last_name').'" Updated'); 
					$this->session->set_flashdata('message', 'The user has been updated successfully');

					if ($this->ion_auth->is_admin())
					{
						redirect('users', 'refresh');
					}
					else
					{
						redirect('login', 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());

					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}
				}
			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'form-control',
                    'required' => 'required',
			'value' => $this->form_validation->set_value('first_name', $user->first_name)
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'form-control',
                        'required' => 'required',
			'value' => $this->form_validation->set_value('last_name', $user->last_name)
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('company', $user->company)
		);
		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'email',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('email', $user->email)
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'tel',
			'pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('phone', $user->phone)
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'form-control',
                   
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'form-control',
                   
			'type' => 'password'
		);

		/* Load Template */
		//$this->template->admin_render('admin/users/edit', $this->data);
		$this->data['page_title'] = "Edit an User";
        $this->data['pagetitle'] = "Edit an User";
		$this->data['_view'] = DEFAULT_THEME . 'users/edit';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

	function activate($id, $code = FALSE)
	{
		check_allow('delete',$this->data['is_allow']);
		$id = (int) $id;

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('users', 'refresh');
		}
		else
		{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/forgot_password', 'refresh');
		}
	}

	public function deactivate($id = NULL)
	{
		check_allow('delete',$this->data['is_allow']);
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_deactivate'), 'admin/users/deactivate');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
		$this->form_validation->set_rules('confirm', 'lang:deactivate_validation_confirm_label', 'required');
		$this->form_validation->set_rules('id', 'lang:deactivate_validation_user_id_label', 'required|alpha_numeric');

		$id = (int) $id;

		if ($this->form_validation->run() === FALSE)
		{
			$user = $this->ion_auth->user($id)->row();

			$this->data['csrf']       = $this->_get_csrf_nonce();
			$this->data['id']         = (int) $user->id;
			$this->data['firstname']  = ! empty($user->first_name) ? htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8') : NULL;
			$this->data['lastname']   = ! empty($user->last_name) ? ' '.htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8') : NULL;

			/* Load Template */
			//$this->template->admin_render('users/deactivate', $this->data);
			$this->data['_view'] = DEFAULT_THEME . 'users/deactivate';
			$this->load->view( DEFAULT_THEME . '_layout',$this->data);
		}
		else
		{
			if ($this->input->post('confirm') == 'yes')
			{
				if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			redirect('users', 'refresh');
		}
	}

	public function profile($id)
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_profile'), 'admin/groups/profile');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Data */
		$id = (int) $id;

		$this->data['user_info'] = $this->ion_auth->user($id)->result();
               
        $role = $this->db->get_where('groups', array('id' => $this->data['user_info'][0]->role))->row();
        $this->data['user_info'][0]->role = $role->name; 
//		foreach ($this->data['user_info'] as $k => $user)
//		{
//			$this->data['user_info'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
//		}

		/* Load Template */
		//$this->template->admin_render('admin/users/profile', $this->data);

		$this->data['_view'] = DEFAULT_THEME . 'users/profile';
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}


	public function email_check_other_than($email)
	{
	 	$this->load->model('user_m');
        $result=$this->user_m->check_other_emails($email,$this->input->post('id'));
        foreach ($result as $eml) {
            if($eml->email==$email){
                $this->form_validation->set_message('email_check_other_than', 'The {field} is already exist.');
                return FALSE;
            } 
        }
        return TRUE;
    }
    
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}