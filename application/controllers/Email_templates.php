<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_templates extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(31);
        $this->load->model('email_templates_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Email_templates');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "email_templates";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Email_templates', 'email_templates');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'email_templates/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'email_templates/index';
        $this->data['page_title'] = "email_templates";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['email_templates']= $this->email_templates_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->email_templates_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->email_templates_m->save(NULL,$data);
            
            $slug=strtolower(str_replace(' ', '_', $this->input->post('name')));
            $data=array('slug'=> $slug);

            $this->email_templates_m->save($insert_id,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('email_templates/edit/'.$insert_id).'" target="_blank">Email Template Added</a>');   
            $this->session->set_flashdata('success',"Email Template Added Successfully.");
            redirect(BASE_URL.'email_templates');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Email Template', 'email_templates/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
      
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'email_templates/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'email_templates/create';
        $this->data['page_title'] = "Add a new Email Template";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'email_templates' ) : '';
        $this->email_templates_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('email_templates').'" target="_blank">Email Template Deleted</a>');   
        $this->session->set_flashdata('success',"Email Template Deleted Successfully.");
        redirect( BASE_URL . 'email_templates' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'email_templates' ) : '';
        $rules = $this->email_templates_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->email_templates_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->email_templates_m->save($id,$data);
            
            $slug=strtolower(str_replace(' ', '_', $this->input->post('name')));
            $data=array('slug'=> $slug);
            
            $this->email_templates_m->save($id,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('email_templates/edit/'.$id).'" target="_blank">Email Template Deleted</a>');   
            $this->session->set_flashdata('success',"Email Template Edited Successfully.");
            redirect(BASE_URL.'email_templates');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Email Template', 'email_templates/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'email_templates/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'email_templates/edit';
        $this->data['page_title'] = "Edit a Email Template";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}
