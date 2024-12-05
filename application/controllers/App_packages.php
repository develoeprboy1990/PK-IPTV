<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_packages extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(49);
        $this->load->model('app_packages_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('app_packages');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "aaps";
        $this->data['sub_nav'] = "app_packages";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Packages', 'Packages');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'app_packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'app_packages/index';
        $this->data['page_title'] = "App Packages";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('app_categories_m');
        
        $rules = $this->app_packages_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post(
                array(
                    'name', 
                    'price'
                    )
                );

            $insert_id=$this->app_packages_m->save(NULL,$data);

            // insert into channels tables
            if(count($this->input->post('categories'))>0){
                foreach ($this->input->post('categories') as $category) {
                   $data=array(
                        'app_package_id'=>$insert_id,
                        'app_category_id'=>$category
                    );
                   $this->db->insert('app_package_to_categories',$data);
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('app_packages/edit/'.$insert_id).'" target="_blank">App Package Added</a>');   
            $this->session->set_flashdata('success',"Package Added Successfully.");
            redirect(BASE_URL.'app_packages');
        }

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create package', 'app_packages/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* App categories */
        $this->data['categories'] = $this->app_categories_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'app_packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'app_packages/create';
        $this->data['page_title'] = "Add New Package";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'app_packages' ) : '';
                      
        $this->app_packages_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('app_packages').'" target="_blank">App Package Deleted</a>');   
        $this->session->set_flashdata('success',"Package Deleted Successfully.");
        redirect( BASE_URL . 'app_packages' );
    }

    public function edit($id = NULL)
    {
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('app_categories_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'app_packages' ) : '';
        $rules = $this->app_packages_m->rules;
        $this->form_validation->set_rules($rules);
        
        $package_info=$this->app_packages_m->get($id,TRUE);
        
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post(
               array(
                    'name', 
                    'price'                 
                    )
                );
            $this->app_packages_m->save($id,$data);

             // insert into app_package_to_categories table
             if($this->input->post('total_categories')!=""){
                // first delete all  
                $this->app_packages_m->delete_package_categories($id);
                if(is_array($this->input->post('categories')) && count($this->input->post('categories'))>0){
                    // then insert 
                    foreach ($this->input->post('categories') as $category) {
                       $data=array(
                            'app_package_id'=>$id,
                            'app_category_id'=>$category
                        );
                       $this->db->insert('app_package_to_categories',$data);
                    }
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('app_packages/edit/'.$id).'" target="_blank">App Package Updated</a>');   
            $this->session->set_flashdata('success',"Package Edited Successfully.");
            redirect(BASE_URL.'app_packages');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Package', 'app_packages/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* App categories */
        $this->data['categories'] = $this->app_categories_m->get();

         /* Selected App categories */
        $this->data['selected_categories'] = $this->app_packages_m->get_categories_by_package($id);

        $this->data['package_detail'] = $package_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'app_packages/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'app_packages/edit';
        $this->data['page_title'] = "Edit Package";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function get_all_packages(){
        $totaldata = 10;
        $totalfiltered = 10;
        $app_packages = $this->app_packages_m->get();
        $data = array();
        foreach ($app_packages as $package) {
            $data[] = array(
                    'name'=>$package['name'],
                    'price'=>ucwords($package['price']),
                    'edit'=>btn_edit(BASE_URL.'app_packages/edit/'.$package['id']),
                    'delete'=>btn_delete(BASE_URL.'app_packages/delete/'.$package['id'])
                );
        }
        $json_data = array(
                        "draw"            => intval( $_REQUEST['draw'] ),
                        "recordsTotal"    => intval( $totaldata ),
                        "recordsFiltered" => intval( $totalfiltered ),
                        "data"            => $data
                    );
        echo json_encode($json_data);
    }
}