<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gui_versions extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(37);
        $this->load->model('gui_versions_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('GUI Versions');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "gui_versions";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'GUI Versions', 'gui_versions');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'gui_versions/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'gui_versions/index';
        $this->data['page_title'] = "GUI Versions";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['versions']= $this->gui_versions_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->gui_versions_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->gui_versions_m->save(NULL,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('gui_versions/edit/'.$insert_id).'" target="_blank">GUI Version Added</a>');   
            $this->session->set_flashdata('success',"GUI Version Added Successfully.");
            redirect(BASE_URL.'gui_versions');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create GUI Version', 'gui_versions/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'gui_versions/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'gui_versions/create';
        $this->data['page_title'] = "Add a GUI Version";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'gui_versions' ) : '';
        $this->gui_versions_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('gui_versions').'" target="_blank">GUI Version Deleted</a>');   
        $this->session->set_flashdata('success',"GUI Version Deleted Successfully.");
        redirect( BASE_URL . 'gui_versions' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'gui_versions' ) : '';
        $rules = $this->gui_versions_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->gui_versions_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->gui_versions_m->save($id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('gui_versions/edit/'.$id).'" target="_blank">GUI Version Updated</a>');   
            $this->session->set_flashdata('success',"GUI Version Edited Successfully.");
            redirect(BASE_URL.'gui_versions');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit GUI Version', 'gui_versions/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'gui_versions/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'gui_versions/edit';
        $this->data['page_title'] = "Edit a GUI Version";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}