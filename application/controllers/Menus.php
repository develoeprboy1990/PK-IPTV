<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(21);
        $this->load->model('menus_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('menus');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "mi";
        $this->data['sub_nav'] = "menus";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Menus', 'menus');
    }

	public function index()
	{  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'menus/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'menus/index';
        $this->data['page_title'] = "Menu";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['menus'] = $this->menus_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('menu_packages_m');
        $rules = $this->menus_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->menus_m->save(NULL,$data);

            // insert into menus_packages_items  tables
            if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
               
                foreach ($this->input->post('packages') as $package) {
                   $data=array(
                        'menu_package_id'=>$package,
                        'menu_id'=>$insert_id
                    );
                   $this->db->insert(' iptv_menu_package_item',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('menus/edit/'.$insert_id).'" target="_blank">Menu Created</a>');   
            $this->session->set_flashdata('success',"Menu Added Successfully.");
            redirect(BASE_URL.'menus');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Menu', 'menus/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Menu Packages */
        $this->data['menu_packages'] = $this->menu_packages_m->get();
        
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'menus/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'menus/create';
        $this->data['page_title'] = "Add New Menu";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {   
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'menus' ) : '';
        $this->menus_m->delete_packages_by_menu($id);              
        $this->menus_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('menus').'" target="_blank">Menu Deleted</a>');   
        $this->session->set_flashdata('success',"Deleted Successfully.");
        redirect( BASE_URL . 'menus' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('menu_packages_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'menus' ) : '';
        $rules = $this->menus_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->menus_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->menus_m->save($id,$data);

            // insert into menus_packages_items  tables
            if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                // first delete all 
                $this->menus_m->delete_packages_by_menu($id);

                foreach ($this->input->post('packages') as $package) {
                   $data=array(
                        'menu_package_id'=>$package,
                        'menu_id'=>$id
                    );
                   $this->db->insert(' iptv_menu_package_item',$data);
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('menus/edit/'.$id).'" target="_blank">Menu Updated</a>');   
            $this->session->set_flashdata('success',"Menu Edited Successfully.");
            redirect(BASE_URL.'menus');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Menu', 'menus/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* Menu Packages */
        $this->data['menu_packages'] = $this->menu_packages_m->get();

        /* Get Packages Selected */
        $this->data['selected_packages'] = $this->menus_m->get_packages_by_menu($id);

        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'menus/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'menus/edit';
        $this->data['page_title'] = "Edit Menu";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
}