<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tv_show_platforms extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(61); // You may want to change permission number
        $this->load->model('tv_show_platforms_m');
        $this->load->model('languages_m'); // Load languages model
        $this->data['main_nav'] = "sod";
        $this->data['sub_nav'] = "tv_show_platforms";
    }

    public function index()
    { 
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'tv_show_platforms/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'tv_show_platforms/index';
        $this->data['page_title'] = "TV Show Platforms";
        $this->data['platforms'] = $this->tv_show_platforms_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);    
    }

    public function add()
    {
        check_allow('create',$this->data['is_allow']);
        $rules = $this->tv_show_platforms_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            $data = array(
                'name' => $this->input->post('name'),
                'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0,
                'language_id' => $this->input->post('language_id')
            );
            $insert_id=$this->tv_show_platforms_m->save(NULL,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('tv_show_platforms').'" target="_blank">TV Show Platform Added</a>');   
            $this->session->set_flashdata('success',"TV Show Platform Added Successfully.");
            redirect(BASE_URL.'tv_show_platforms');
        }

        $this->data['languages'] = $this->languages_m->get(); // Get all languages
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'tv_show_platforms/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'tv_show_platforms/add';
        $this->data['page_title'] = "Add TV Show Platform";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);    
    }

    public function getItem(){
        $id = $this->input->post('id');
        $info = $this->tv_show_platforms_m->get($id, true);
        echo json_encode([
            'name' => $info->name,
            'order_no' => $info->order_no ? $info->order_no : 0,
            'language_name' => $info->language_name
        ]);
    }

    public function addItem(){
        check_allow('create',$this->data['is_allow']);
        $data=array(
            'name'=>$this->input->post('name'),
            'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0,
            'language_id'=>$this->input->post('language_id')
        );

        $insert_id= $this->tv_show_platforms_m->save(NULL,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('tv_show_platforms').'" target="_blank">TV Show Platform Added</a>');   
        echo $insert_id;
    }

    public function updateItem(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array(
            'name'=>$this->input->post('name'),
            'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0,
            'language_id'=>$this->input->post('language_id')
        );
        $this->tv_show_platforms_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('tv_show_platforms').'" target="_blank">TV Show Platform Updated</a>');   
        echo "Updated Successfully";
    }

    public function edit($id = NULL)
    {    
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'tv_show_platforms' ) : '';
        $info=$this->tv_show_platforms_m->get($id,TRUE);
        $rules = $this->tv_show_platforms_m->rules;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run()==TRUE){    
            $data = array(
                'name' => $this->input->post('name'),
                'order_no' => $this->input->post('order_no') ? $this->input->post('order_no') : 0,
                'language_id' => $this->input->post('language_id')
            );
            $this->tv_show_platforms_m->save($id,$data);

            $this->session->set_flashdata('success',"TV Show Platform Edited Successfully.");
            redirect(BASE_URL.'tv_show_platforms');
        }
        $this->data['languages'] = $this->languages_m->get(); // Get all languages
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'tv_show_platforms/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'tv_show_platforms/edit';
        $this->data['page_title'] = "Edit TV Show Platform";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);    
    }

    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'tv_show_platforms' ) : '';
        $this->tv_show_platforms_m->delete($id);
        redirect( BASE_URL . 'tv_show_platforms' );
    }

    public function deleteItem($id = NULL)
    {   
        check_allow('delete',$this->data['is_allow']);
        $id=$this->input->post('id');
        $this->tv_show_platforms_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('tv_show_platforms').'" target="_blank">TV Show Platform Deleted</a>');   
        echo "Deleted Successfully";
    }

    public function getPlatformsByLanguage() {
        $language_id = $this->input->post('language_id');
        $platforms = $this->tv_show_platforms_m->get_by(['language_id' => $language_id]);
        echo json_encode($platforms);
    }
}