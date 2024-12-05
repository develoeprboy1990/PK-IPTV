<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_channel extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(46);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Channel Groups');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "tar";
        $this->data['sub_nav'] = "groups";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Groups', 'groups_channel');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'groups_channel/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'groups_channel/index';
        $this->data['page_title'] = "Television and Radio";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->groups_channel_m->add_rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post(array('name','position'));

            $insert_id=$this->groups_channel_m->save(NULL,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('groups_channel/edit/'.$insert_id).'" target="_blank">Channel Groups Added</a>');          
            $this->session->set_flashdata('success',"Channel Group Added Successfully.");
            redirect(BASE_URL.'groups_channel');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Group', 'groups_channel/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'groups_channel/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'groups_channel/create';
        $this->data['page_title'] = "Add new Group";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }


	public function create_old()
	{
		// if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		// {
		// 	redirect('auth', 'refresh');
		// }

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
            $this->data['_view'] = DEFAULT_THEME . 'groups_channel/create';
            $this->load->view( DEFAULT_THEME . '_layout',$this->data);
		}
	}

    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'employee' ) : '';
        $this->groups_channel_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('groups_channel').'" target="_blank">Channel Groups Deleted</a>');          
        $this->session->set_flashdata('success',"Channel Group Deleted Successfully.");
        redirect( BASE_URL . 'groups_channel' );
    }

	/*public function delete($id)
	{
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
                $delete = $this->db->delete('channel_group', array('id' => $id));
                if($delete)
                   $this->session->set_flashdata('success','The Group deleted successfully');
                else
                    $this->session->set_flashdata('success','The Group has not been deleted');
                
               redirect('groups','refresh');
                
            }
	}*/

    public function edit($id = NULL)
    {
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'groups_channel' ) : '';
        $rules = $this->groups_channel_m->edit_rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post(array('name','position'));
            $this->groups_channel_m->save($id,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('groups_channel/edit/'.$id).'" target="_blank">Channel Groups Deleted</a>');          
            $this->session->set_flashdata('success',"Group Edited Successfully.");
            redirect(BASE_URL.'groups_channel');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_groups_create'), 'admin/groups/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['groups_detail'] = $this->groups_channel_m->get($id,TRUE);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'groups_channel/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'groups_channel/edit';
        $this->data['page_title'] = "Edit Group";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}
