<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(9);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Role');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['page_title'] = $this->page_title->show();
        $this->data['main_nav'] = "users";
        $this->data['sub_nav'] = "role_groups";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Roles', 'groups');
    }


	public function index() 
	{    
        check_allow('view',$this->data['is_allow']);         
        $this->data['pagetitle'] = "List Roles";
        $this->data['page_title'] = "List Roles";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['groups'] = $this->ion_auth->groups()->result();

        /* Load Template */
       
        $this->data['_view'] = DEFAULT_THEME . 'groups/index';
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

	public function create()
	{  
        check_allow('create',$this->data['is_allow']);
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}


        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_groups_create'), 'admin/groups/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
		$this->form_validation->set_rules('group_name', 'lang:create_group_validation_name_label', 'required');

		if ($this->form_validation->run() == TRUE)
		{ 
            // if(count())
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
			    if(count($this->input->post('modules')))
                {
                    foreach($this->input->post('modules') as $module_id)
                    { 
                        $modules[] = array(
                                            'group_id' => $new_group_id,
                                            'role_id' => $module_id,
                                            'allow_create' => $this->input->post('create_'.$module_id),
                                            'allow_edit' => $this->input->post('edit_'.$module_id),
                                            'allow_delete' => $this->input->post('delete_'.$module_id),
                                            'allow_view' => $this->input->post('view_'.$module_id)
                                    );
                    }
                    $data = $modules;

                    $this->db->insert_batch('group_role_permissions', $data);
                }	
                $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('groups/edit/'.$new_group_id).'" target="_blank">Role Added</a>');          
                $this->session->set_flashdata('success', 'The role created successfully');
                redirect('groups', 'refresh');
			}
		}
		else
		{
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('group_name')
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
                'class' => 'form-control',
				'value' => $this->form_validation->set_value('description')
			);

            /* Load Template */
            //$this->template->admin_render('admin/groups/create', $this->data);
            $this->data['main_nav'] = "users";
            $this->data['sub_nav'] = "role_groups";

            $this->data['pagetitle'] = "Add a group";
            $this->data['page_title'] = "Add a group";
            $this->data['_extra_scripts'] = DEFAULT_THEME . 'groups/_extra_scripts';
            $this->data['_view'] = DEFAULT_THEME . 'groups/create';
            $this->load->view( DEFAULT_THEME . '_layout',$this->data);
		}
	}


	public function delete($id)
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
                $this->db->delete('group_role_permissions', array('group_id' => $id));
                $delete = $this->db->delete('groups', array('id' => $id));
                if($delete){
                    $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('groups').'" target="_blank">Role Deleted</a>');          
                    $this->session->set_flashdata('success','The Role deleted successfully');
                }
                else
                    $this->session->set_flashdata('success','The Role has not been deleted');
                
               redirect('groups','refresh');
                
            }
	}


	public function edit($id)
	{
		check_allow('edit',$this->data['is_allow']);
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin() OR ! $id OR empty($id))
		{
			redirect('auth', 'refresh');
		}

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_groups_edit'), 'admin/groups/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Variables */
		$group = $this->ion_auth->group($id)->row();

		/* Validate form input */
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required');

		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->form_validation->run() == TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update)
				{
                                    $this->db->delete('group_role_permissions', array('group_id' => $id)); 
                                    if(count($this->input->post('modules')))
                                    {
                                        
                                        foreach($this->input->post('modules') as $module_id)
                                        { 
                                            $modules[] = array(
                                                                'group_id' => $id,
                                                                'role_id' => $module_id,
                                                                'allow_create' => $this->input->post('create_'.$module_id),
                                                                'allow_edit' => $this->input->post('edit_'.$module_id),
                                                                'allow_delete' => $this->input->post('delete_'.$module_id),
                                                                'allow_view' => $this->input->post('view_'.$module_id)
                                                        );
                                        }
                                        $data = $modules;
//echo "<pre>";
//print_r($data); exit;
                                        $this->db->insert_batch('group_role_permissions', $data);
                                    }
					               
                                    $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('groups/edit/'.$id).'" target="_blank">Role Updated</a>');          
                                    $this->session->set_flashdata('success', 'The group updated successfully');

                    /* IN TEST */
                  //  $this->db->update('groups', array('bgcolor' => $_POST['group_bgcolor']), 'id = '.$id);
				}
				else
				{
					$this->session->set_flashdata('success', 'The group has not been updated');
				}

				redirect('groups', 'refresh');
			}
		}

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['group']   = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'type'    => 'text',
			'name'    => 'group_name',
			'id'      => 'group_name',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
            'class'   => 'form-control',
			$readonly => $readonly,
                    'required' => 'required'
		);
		$this->data['group_description'] = array(
			'type'  => 'text',
			'name'  => 'group_description',
			'id'    => 'group_description',
			'value' => $this->form_validation->set_value('group_description', $group->description),
            'class' => 'form-control'
		);
		// $this->data['group_bgcolor'] = array(
		// 	'type'     => 'text',
		// 	'name'     => 'group_bgcolor',
		// 	'id'       => 'group_bgcolor',
		// 	'value'    => $this->form_validation->set_value('group_bgcolor', $group->bgcolor),
		// 	'data-src' => $group->bgcolor,
  //           'class'    => 'form-control'
		// );

        /* Load Template */
        //$this->template->admin_render('admin/groups/edit', $this->data);
        $this->data['pagetitle'] = "Edit a group";
        $this->data['page_title'] = "Edit a group";
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'groups/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'groups/edit';
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
}
