<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_groups extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $is_allow = $this->ion_auth->checkPermission(33); 
        $this->data['is_allow']= $is_allow;
        
        if(!isset($is_allow))
        {
           redirect('unauthorize', 'refresh');
        }

        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('news_groups_m');
        /* Title Page :: Common */
        $this->page_title->push('News');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "news";
        $this->data['sub_nav'] = "news_groups";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Servers', 'servers');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'news_groups/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'news_groups/index';
        $this->data['page_title'] = "News";
        $this->data['add_text'] = "Add a News Group";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['news_groups'] = $this->news_groups_m->get();
        
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){  
        check_allow('create',$this->data['is_allow']);
        $rules = $this->news_groups_m->rules;
        $this->form_validation->set_rules($rules);
        $title="News Groups ";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->news_groups_m->save(NULL,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('news_groups/edit/'.$insert_id).'" target="_blank">News Group Created</a>');   
            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'news/items/'.$insert_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'news_groups/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        $this->data['_view'] = DEFAULT_THEME . 'news_groups/create';
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
        $this->db->update('news_groups');
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('news_groups').'" target="_blank">News Group Updated</a>');   
        echo "Updated Successfully";
    }
   
    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
        $this->load->model('news_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'server_locations' ) : '';
        // delete images for the news 
        $news_items=$this->news_m->get_by(array('news_group_id'=>$id));
        foreach($news_items as $news_info){ 
          
            if($news_info['image'])
            {
                if(file_exists("./uploads/news/".$news_info['image']))
                    @unlink("./uploads/news/".$news_info['image']);
            }
            $this->news_m->delete($news_info['id']);
        }
        $this->news_groups_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('news_groups').'" target="_blank">News Group Deleted</a>');   
        $this->session->set_flashdata('success',"Server Deleted Successfully.");
        redirect( BASE_URL . 'news_groups' );
    }
}
