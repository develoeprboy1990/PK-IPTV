<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servers extends User_Controller {

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

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "servers";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Servers', 'servers');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'servers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'servers/index';
        $this->data['page_title'] = "Servers";
        $this->data['add_text'] = "Add a location Item";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['locations'] = $this->server_locations_m->getLocations();
        
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function items($server_id)
    {   
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'servers/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'servers/items';
        $this->data['page_title'] = "Server Location Items";
        $this->data['add_text'] = "Add a location Item";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['server_info'] = $this->server_locations_m->getLocationInfo($server_id);
        $this->data['location_items'] = $this->server_locations_m->getItems($server_id,'location');
        $this->data['domain_items'] = $this->server_locations_m->getItems($server_id,'domain');
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){  
        check_allow('create',$this->data['is_allow']);
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

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('servers/items/'.$insert_id).'" target="_blank">Product Server Url Added</a>');   
            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'servers/items/'.$insert_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'servers/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* get all the locations */
        $this->data['locations'] = $this->server_locations_m->get();
        $this->data['_view'] = DEFAULT_THEME . 'servers/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    //ajax function 
    public function update(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('name'=>$this->input->post('name'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('server_locations');
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('servers').'" target="_blank">Product Server Url Updated</a>');   
        echo "Updated Successfully";
    }

    //ajax function 
    public function updateItem(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('url'=>$this->input->post('url'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('server_location_items');
        echo "Updated Successfully";
    }
   
    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'server_locations' ) : '';
        $this->server_locations_m->deleteItems($id);
        $this->server_locations_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('servers').'" target="_blank">Product Server Url Deleted</a>');   
        $this->session->set_flashdata('success',"Server Deleted Successfully.");
        redirect( BASE_URL . 'servers' );
    }
}
