<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_categories extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(48);
		$this->load->model('app_categories_m');
		$this->data['main_nav'] = "aaps";
        $this->data['sub_nav'] = "app_categories";
	}

	public function index()
	{
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'app_categories/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'app_categories/index';
		$this->data['page_title'] = "List Categories";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}


	public function add()
	{
		check_allow('create',$this->data['is_allow']);
		$rules = $this->app_categories_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('name'));
			$insert_id=$this->app_categories_m->save(NULL,$data);
			
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('app_categories/edit/'.$insert_id).'" target="_blank">App Category Added</a>');   
			$this->session->set_flashdata('success',"Category Added Successfully.");
			redirect(BASE_URL.'app_categories');
		}
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'app_categories/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'app_categories/add';
		$this->data['page_title'] = "Add new Category";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{
		check_allow('edit',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'app_categories' ) : '';
		$rules = $this->app_categories_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('name'));
			$this->app_categories_m->save($id,$data);
			
			$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('app_categories/edit/'.$id).'" target="_blank">App Category Updated</a>');   
			$this->session->set_flashdata('success',"Category Edited Successfully.");
			redirect(BASE_URL.'app_categories');
		}
		$this->data['details'] = $this->app_categories_m->get($id,TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'app_categories/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'app_categories/edit';
		$this->data['page_title'] = "Edit Category";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'app_categories' ) : '';
		
		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('app_categories/').'" target="_blank">App Category Deleted</a>');   
		$this->app_categories_m->delete($id);
		$this->session->set_flashdata('success',"Category Deleted Successfully.");
		redirect( BASE_URL . 'app_categories' );
	}

	public function get_all_cat(){
        $totaldata = 10;
        $totalfiltered = 10;
        $categories = $this->app_categories_m->get();
        $data = array();
        foreach ($categories as $category) {
            $data[] = array(
                    'id'=>$category['id'],
                    'name'=>$category['name'],
                    'edit'=>btn_edit(BASE_URL.'app_categories/edit/'.$category['id']),
                    'delete'=>btn_delete(BASE_URL.'app_categories/delete/'.$category['id']),
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

/* End of file app_categories.php */
/* Location: ./application/controllers/app_categories.php */