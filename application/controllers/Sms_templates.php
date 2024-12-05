<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_templates extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(31);
        $this->load->model('sms_templates_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Sms_templates');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "sms_templates";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'sms_templates', 'sms_templates');
    }


	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'sms_templates/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'sms_templates/index';
        $this->data['page_title'] = "Sms Templates";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['sms_templates']= $this->sms_templates_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->sms_templates_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->sms_templates_m->save(NULL,$data);
            
            $slug=strtolower(str_replace(' ', '_', $this->input->post('name')));
            $data=array('slug'=> $slug);

            $this->sms_templates_m->save($insert_id,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('sms_templates/edit/'.$insert_id).'" target="_blank">Sms Template Added</a>');   
            $this->session->set_flashdata('success',"Sms Template Added Successfully.");
            redirect(BASE_URL.'sms_templates');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Sms Template', 'sms_templates/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
      
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'sms_templates/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'sms_templates/create';
        $this->data['page_title'] = "Add a new Sms Template";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'sms_templates' ) : '';
        $this->sms_templates_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('sms_templates').'" target="_blank">Sms Template Deleted</a>');   
        $this->session->set_flashdata('success',"Sms Template Deleted Successfully.");
        redirect( BASE_URL . 'sms_templates' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'sms_templates' ) : '';
        $rules = $this->sms_templates_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->sms_templates_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->sms_templates_m->save($id,$data);
            
            $slug=strtolower(str_replace(' ', '_', $this->input->post('name')));
            $data=array('slug'=> $slug);
            
            $this->sms_templates_m->save($id,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('sms_templates/edit/'.$id).'" target="_blank">Sms Template Deleted</a>');   
            $this->session->set_flashdata('success',"Sms Template Edited Successfully.");
            redirect(BASE_URL.'sms_templates');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Sms Template', 'sms_templates/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'sms_templates/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'sms_templates/edit';
        $this->data['page_title'] = "Edit a Sms Template";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}
