<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_genres extends User_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['is_allow']= check_permission(23);
		$this->load->model('series_genres_m');
	}

	public function index()
	{
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'series_genres/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'series_genres/index';
		$this->data['page_title'] = "List Genres";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function get_all_genre(){
		$totaldata = 10;
		$totalfiltered = 10;
		$genres = $this->series_genres_m->get();
		$data = array();
		foreach ($genres as $genre) {
			$data[] = array(
					'id'=>$genre['id'],
					'name'=>ucwords($genre['name']),
					'edit'=>btn_edit(BASE_URL.'series_genres/edit/'.$genre['id']),
					'delete'=>btn_delete(BASE_URL.'series_genres/delete/'.$genre['id']),
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

	public function add()
	{
		$rules = $this->series_genres_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('name'));
			$this->series_genres_m->save(NULL,$data);
			$this->session->set_flashdata('success',"Genre Added Successfully.");
			redirect(BASE_URL.'series_genres');
		}
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'series_genres/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'series_genres/add';
		$this->data['page_title'] = "Add New Genre";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function edit($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'series_genres' ) : '';
		$rules = $this->series_genres_m->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()==TRUE){
			$data = $this->array_from_post(array('name'));
			$this->series_genres_m->save($id,$data);
			$this->session->set_flashdata('success',"Genre Edited Successfully.");
			redirect(BASE_URL.'series_genres');
		}
		$this->data['details'] = $this->series_genres_m->get($id,TRUE);
		$this->data['_extra_scripts'] = DEFAULT_THEME . 'series_genres/_extra_scripts';
		$this->data['_view'] = DEFAULT_THEME . 'series_genres/edit';
		$this->data['page_title'] = "Edit Genre";
		$this->load->view( DEFAULT_THEME . '_layout',$this->data);	
	}

	public function delete($id = NULL)
	{
		( $id == NULL ) ? redirect( BASE_URL . 'series_genres' ) : '';
		$this->series_genres_m->delete($id);
		redirect( BASE_URL . 'series_genres' );
	}

}/* End of file Movie Genres.php */
/* Location: ./application/controllers/series_genres.php */