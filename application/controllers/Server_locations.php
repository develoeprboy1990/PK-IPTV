<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_locations extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $is_allow = $this->ion_auth->checkPermission(15); 
        $this->data['is_allow']= $is_allow;
        
        if(!isset($is_allow))
        {
           redirect('unauthorize', 'refresh');
        }

        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('server_locations_m');
        /* Title Page :: Common */
        $this->page_title->push('Server Location');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "server_locations";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Server Locations', 'server_locations');
    }

	public function index()
	{
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'server_locations/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'server_locations/index';
        $this->data['page_title'] = "Server Locations";
        $this->data['add_text'] = "Add a location Item";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['locations'] = $this->server_locations_m->getLocations();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function items($location_id)
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'server_locations/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'server_locations/items';
        $this->data['page_title'] = "Server Location Items";
        $this->data['add_text'] = "Add a location Item";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['server_info'] = $this->server_locations_m->getLocationInfo($location_id);
        $this->data['items'] = $this->server_locations_m->getLocationsItems($location_id);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){  
        $this->load->model('server_locations_m');
        $rules = $this->server_locations_m->rules;
        $this->form_validation->set_rules($rules);
        $title="Server ";
 
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->server_locations_m->save(NULL,$data);
            
            //insert server location items
            $this->server_locations_m->insertItems($insert_id);

            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'server_locations/items/'.$insert_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'server_locations/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* get all the locations */
        $this->data['locations'] = $this->server_locations_m->get();
        $this->data['_view'] = DEFAULT_THEME . 'server_locations/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    //ajax function 
    public function update(){
        $id=$this->input->post('id');
        $data=array('name'=>$this->input->post('name'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('server_locations');
        echo "Updated Successfully";
    }

    //ajax function 
    public function updateItem(){
        $id=$this->input->post('id');
        $data=array('url'=>$this->input->post('url'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('server_location_items');
        echo "Updated Successfully";
    }
   
    public function delete($id = NULL)
    {
       ( $id == NULL ) ? redirect( BASE_URL . 'server_locations' ) : '';
        $this->server_locations_m->deleteItems($id);
        $this->server_locations_m->delete($id);
        $this->session->set_flashdata('success',"Server Deleted Successfully.");
        redirect( BASE_URL . 'server_locations' );
    }

}
