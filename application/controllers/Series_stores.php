<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_stores extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(44);
		$this->load->model('series_stores_m');
		$this->data['main_nav'] = "sod";
        $this->data['sub_nav'] = "series_stores";
	}

	public function index()
	{
		check_allow('view',$this->data['is_allow']);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'series_stores/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'series_stores/index';
		$this->data['page_title'] = "List Stores";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function get_all_store(){
		$totaldata = 10;
		$totalfiltered = 10;
		$stores = $this->series_stores_m->getSeriesStore();
		$data = array();
		// Load the series model
    	$this->load->model('series_m');
		foreach ($stores as $store) {
			$series_count = $this->series_m->count_series_by_store($store['id']);
			$data[] = array(
					'id'=>"<a href='".site_url('series_stores/edit/'.$store['id'])."'>".$store['id']."</a>",
					'name'=>ucwords($store['name']),
					'position'=>ucwords($store['position']),
					'language_name'=>ucwords($store['language_name']),
					'total_series'=> $series_count, // Add this line
					'active'=>($store['active']==0) ? "Inactive" : "Active",
					'edit'=>btn_edit(BASE_URL.'series_stores/edit/'.$store['id']),
					'delete'=>btn_delete(BASE_URL.'series_stores/delete/'.$store['id']),
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

	public function add($parent_id="")
	{	
		check_allow('create',$this->data['is_allow']);
		$this->load->model('languages_m');

		$rules = $this->series_stores_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('parent_id','name','position','language_id','active','childlock'));
			$insert_id=$this->series_stores_m->save(NULL,$data);
			
			//upload files if there is an image 
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', '', LOCAL_PATH_IMAGES_CMS, 'series_stores_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                 //resize image 
               // $this->resize_image($_FILES["logo"]["tmp_name"],$localFilePath,'608','342');
				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series_stores/edit/'.$insert_id).'" target="_blank">Series Store Added</a>');   
            $this->session->set_flashdata('success',"Series Store Added Successfully.");
			if($parent_id) 
				redirect(BASE_URL.'series_stores/sub_store/'.$parent_id);
			else
				redirect(BASE_URL.'series_stores');
		}

		//get languages
        $this->data['languages']=$this->languages_m->get();

		$this->data['parent_id'] = $parent_id;
		$this->data['main_stores'] =$this->series_stores_m->get_parent_store();
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'series_stores/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'series_stores/add';
		$this->data['page_title'] = "Add New Store";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{
		check_allow('edit',$this->data['is_allow']);
		$this->load->model('languages_m');

		( $id == NULL ) ? redirect( BASE_URL . 'series_stores' ) : '';
		$rules = $this->series_stores_m->rules;
		$this->form_validation->set_rules($rules);
		$info=$this->series_stores_m->get($id,TRUE);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('parent_id','name','position','language_id','active','childlock'));
			$this->series_stores_m->save($id,$data);
			
			//upload files if there is an image 
            if($_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', $info->logo, LOCAL_PATH_IMAGES_CMS, 'series_stores_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                 //resize image 
               // $this->resize_image($_FILES["logo"]["tmp_name"],$localFilePath,'608','342');
               $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series_stores/edit/'.$id).'" target="_blank">Series Store Updated</a>');   
			$this->session->set_flashdata('success',"Store Edited Successfully.");
			$parent=$this->series_stores_m->check_if_parent($id);
			if($parent==0)
				redirect(BASE_URL.'series_stores/');
			else
				redirect(BASE_URL.'series_stores/sub_store/'.$parent);
		}
		
		//get languages
        $this->data['languages']=$this->languages_m->get();

		$this->data['main_stores'] =$this->series_stores_m->get_parent_store();
		$this->data['details'] = $info;
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'series_stores/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'series_stores/edit';
		$this->data['page_title'] = "Edit Store";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{	
		check_allow('delete',$this->data['is_allow']);
		( $id == NULL ) ? redirect( BASE_URL . 'series_stores' ) : '';
		$this->series_stores_m->delete_child($id);
		$this->series_stores_m->delete($id);

		$this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('series_stores').'" target="_blank">Series Store Deleted</a>');   
		$this->session->set_flashdata('success',"Store Deleted Successfully.");
		redirect( BASE_URL . 'series_stores' );
	}

	public function sub_store($id){
		$this->data['id'] =$id;
		$this->data['main_store_info'] =$this->series_stores_m->get_store_info($id);
		$this->data['stores'] = $this->series_stores_m->get_by(array('parent_id'=>$id));
		$this->data['_view'] = DEFAULT_THEME . 'series_stores/sub_store';
		$this->data['page_title'] = "List Sub Stores";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}

	public function get_substore($id){
		$totaldata = 10;
		$totalfiltered = 10;
		$stores = $this->series_stores_m->get_by(array('parent_id'=>$id));
		$data = array();
		foreach ($stores as $store) {
			$data[] = array(
					'id'=>$store['id'],
					'name'=>ucwords($store['name']),
					'position'=>ucwords($store['position']),
					'active'=>($store['active']==0) ? "Inactive" : "Active",
					'edit'=>btn_edit(BASE_URL.'series_stores/edit/'.$store['id']),
					'delete'=>btn_delete(BASE_URL.'series_stores/delete/'.$store['id']),
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

	 public function fetch_sub_stores(){
        if($this->input->post('parent_id'))
        {
            echo $this->series_stores_m->fetch_sub_stores($this->input->post('parent_id'));
        }
    }
}/* End of file Series Stores.php */
/* Location: ./application/controllers/series_stores.php */