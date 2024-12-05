<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_items_urls extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(54);
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('server_items_urls_m');
        /* Title Page :: Common */
        $this->page_title->push('Server Items Urls');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "system";
        $this->data['sub_nav'] = "server_items_urls";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Server Item Urls', 'server_items_urls');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'server_items_urls/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'server_items_urls/index';
        $this->data['page_title'] = "Server Items Urls";
        $this->data['add_text'] = "Add a location Item";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['server_items'] = $this->server_items_urls_m->getServerItems();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    //ajax function 
    public function updateItem(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('name'=>$this->input->post('name'),
                    'url'=>$this->input->post('url'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('server_items_urls');
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('server_items_urls').'" target="_blank">CNAME Intials Updated</a>');   
        echo "Updated Successfully";
    }
    
    //ajax function 
    public function addItem(){
        check_allow('create',$this->data['is_allow']);
        $data=array('server_item_id'=>$this->input->post('id'),
                    'name'=>$this->input->post('name'),
                    'url'=>$this->input->post('url')
                    );
        $this->db->insert('server_items_urls',$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('server_items_urls').'" target="_blank">CNAME Intials Added</a>');   
        echo "Added Successfully";
    }
   
    public function deleteItem($id = NULL)
    {   
        check_allow('delete',$this->data['is_allow']);
        $id=$this->input->post('id');
        $this->server_items_urls_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('server_items_urls').'" target="_blank">CNAME Intials Deleted</a>');   
        echo "Deleted Successfully";
    }
}
