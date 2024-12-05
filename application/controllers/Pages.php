<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(31);
        $this->load->model('pages_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Pages');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "pages";

        /* Breadcrumbs :: Common */
       // $this->breadcrumbs->unshift(1, 'Email_templates', 'email_templates');
    }


	public function index(){
        $this->data['all_pages']= $this->pages_m->get();
      	/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['sub_nav'] = "pages";
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'pages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'pages/index';
        $this->data['page_title'] = "Pages";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

   public function create(){
   		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();	

		if(isset($_REQUEST['add_page'])){ 		
			$this->load->library('form_validation');		
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
			$this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
			$this->form_validation->set_rules('page_content', 'Page Content', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$this->data['page_title'] = $this->input->post('page_title');
				$this->data['page_name'] = $this->input->post('page_name');
				$this->data['page_content'] = $this->input->post('page_content');
			} else{
				$page_title = $this->input->post('page_title');
				$page_content = $this->input->post('page_content');
				$page_name = $this->input->post('page_name');
				$slug = strtolower(str_replace(' ', '_', $this->input->post('page_name')));
				$data = array(
				 				'page_title' => $page_title,
								'page_content' => $page_content,
								'slug' => $slug,
								'page_name' => $page_name
							);
				 $this->pages_m->insert('pages', $data);
				  redirect( BASE_URL . 'pages');
			}
		}		
		$this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "pages";
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'pages/create';
        $this->data['page_title'] = "Create Page";
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
        ( $id == NULL ) ? redirect( BASE_URL . 'pages' ) : '';
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();	

	   $where = array('id' => $id);
       $page_info =  $this->pages_m->selectdatarow($where, 'pages');
	   //print_r($page_info);exit;
       if(isset($_REQUEST['edit_page'])){ 			
			$this->load->library('form_validation');		
			$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required');
			$this->form_validation->set_rules('pages_title', 'Page Title', 'trim|required');
			$this->form_validation->set_rules('page_content', 'Page Content', 'trim|required');
			if ($this->form_validation->run() == FALSE){
				$this->data['pages_title'] = $this->input->post('pages_title');
				//$this->data['page_name'] = $this->input->post('page_name');
				$this->data['page_content'] = $this->input->post('page_content');
			} else{
				$pages_title = $this->input->post('pages_title');
				$page_content = $this->input->post('page_content');
				$slug = strtolower(str_replace(' ', '_', $this->input->post('page_name')));
				$data = array(
				 				'page_title' => $pages_title,
								'page_content' => $page_content
							);
				 $this->pages_m->update('pages', $data, $where);
				 redirect( BASE_URL . 'pages');
			}
		}
			$this->data['pages_title'] = $page_info[0]['page_title'];
			$this->data['page_name'] = $page_info[0]['page_name'];
			$this->data['page_content'] = $page_info[0]['page_content'];
		$this->data['page_id'] = $id;		
		$this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "pages";
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'customers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'pages/edit';
        $this->data['page_title'] = "Edit Page";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data); 
    }
}
