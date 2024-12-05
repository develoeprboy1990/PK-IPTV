<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_packages extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(39);
        $this->load->model('menu_packages_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('menu_packages');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "mi";
        $this->data['sub_nav'] = "menu_packages";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Menu Packages', 'menu_packages');
    }

	public function index()
	{  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'menu_packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'menu_packages/index';
        $this->data['page_title'] = "Menu Package";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['menu_packages'] = $this->menu_packages_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('menus_m');
        $rules = $this->menu_packages_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->menu_packages_m->save(NULL,$data);
            
            // insert into menus_packages_items  tables
            if(is_array($this->input->post('menus')) && count($this->input->post('menus'))>0){
                foreach ($this->input->post('menus') as $menu) {
                   $data=array(
                        'menu_id'=>$menu,
                        'menu_package_id'=>$insert_id
                    );
                   $this->db->insert(' iptv_menu_package_item',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('menu_packages/edit/'.$insert_id).'" target="_blank">Menu Package Created</a>');   
            $this->session->set_flashdata('success',"Menu Package Added Successfully.");
            redirect(BASE_URL.'menu_packages');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Menu Package', 'menu_packages/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Menus */
        $this->data['menus'] = $this->menus_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'menu_packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'menu_packages/create';
        $this->data['page_title'] = "Add New Menu Package";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {   
        check_allow('view',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'menu_packages' ) : '';
        $this->menu_packages_m->delete_menus_by_package($id);
        $this->menu_packages_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('menu_packages').'" target="_blank">Menu Package Deleted</a>');   
        $this->session->set_flashdata('success',"Deleted Successfully.");
        redirect( BASE_URL . 'menu_packages' );
    }

    public function edit($id = NULL)
    {
        $this->load->model('menus_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'menu_packages' ) : '';
        $rules = $this->menu_packages_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->menu_packages_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->menu_packages_m->save($id,$data);
            
            // insert into menus_packages_items  tables
            if(is_array($this->input->post('menus')) && count($this->input->post('menus'))>0){
                
                // first delete all 
                $this->menu_packages_m->delete_menus_by_package($id);

                foreach ($this->input->post('menus') as $menu) {
                   $data=array(
                        'menu_id'=>$menu,
                        'menu_package_id'=>$id
                    );
                   $this->db->insert(' iptv_menu_package_item',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('menu_packages/edit/'.$id).'" target="_blank">Menu Package Updated</a>');   
            $this->session->set_flashdata('success',"Menu Package Edited Successfully.");
            redirect(BASE_URL.'menu_packages');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Menu Package', 'menu_packages/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Menus */
        $this->data['menus'] = $this->menus_m->get();
        
        /* Get Menus Selected */
        $this->data['selected_menus'] = $this->menu_packages_m->get_menus_by_package($id);

        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'menu_packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'menu_packages/edit';
        $this->data['page_title'] = "Edit Menu Package";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}