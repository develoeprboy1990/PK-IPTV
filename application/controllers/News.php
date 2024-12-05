<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends User_Controller {

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
        $this->load->model('news_m');
        $this->load->helper('text');
        /* Title Page :: Common */
        $this->page_title->push('News');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "news";
        $this->data['sub_nav'] = "news_groups";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'News Groups', 'news_groups');
    }

	public function index()
	{
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'news/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'news/index';
        $this->data['page_title'] = "News";
        $this->data['add_text'] = "Add a News Group";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['news_groups'] = $this->news_groups_m->get();
        
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function items($group_id)
    {
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'news/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'news/items';
        $this->data['page_title'] = "News Items";
        $this->data['add_text'] = "Add a News Item";
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['group_info'] = $this->news_groups_m->get($group_id, true);
        $this->data['news_items'] = $this->news_m->get_by(array('news_group_id'=>$group_id));
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create($group_id){  
        $rules = $this->news_m->rules;
        $this->form_validation->set_rules($rules);
        $title="News ";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->news_m->save(NULL,$data);
            
            // add date_created
            $data= array('date_created'=>time());
            $this->news_m->save($insert_id,$data);
            //upload files if there is an image 
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $filename= $this->upload_image('image', '', LOCAL_PATH_IMAGES_CMS, 'news_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                 //resize image 
                $this->resize_image($_FILES["image"]["tmp_name"],$localFilePath,'200','90');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('news/edit/'.$insert_id).'" target="_blank">News Added</a>');   
            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'news/items/'.$group_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'news/create/'.$group_id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['group_id']=$group_id;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'news/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'news/create';
        $this->data['page_title'] = "Add " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function edit($group_id,$id){  
        $info=$this->news_m->get($id, true);
        $rules = $this->news_m->rules;
        $this->form_validation->set_rules($rules);
        $title="News ";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $this->news_m->save($id,$data);
           
            //upload files if there is an image 
            if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
            {
                $filename= $this->upload_image('image', $info->image, LOCAL_PATH_IMAGES_CMS, 'news_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                 //resize image 
                $this->resize_image($_FILES["image"]["tmp_name"],$localFilePath,'200','90');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('news/edit/'.$id).'" target="_blank">News Updated</a>');   
            $this->session->set_flashdata('success',$title. "Updated Successfully.");
            redirect(BASE_URL.'news/items/'.$group_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Update '.$title, 'news/edit/'.$group_id. '/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['group_id']=$group_id;
        $this->data['news_info']=$info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'news/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'news/edit';
        $this->data['page_title'] = "Edit " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
   
    public function delete($group_id,$id = NULL)
    {
       ( $id == NULL ) ? redirect( BASE_URL . 'news_groups' ) : '';
        // delete image 
        $news_info=$this->news_m->get($id,true);
        
        if($news_info->image)
        {
            if(file_exists("./uploads/news/".$news_info->image))
                @unlink("./uploads/news/".$news_info->image);
        }

        $this->news_m->delete($id);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('news').'" target="_blank">News Deleted</a>');   
        $this->session->set_flashdata('success',"News Deleted Successfully.");
        redirect( BASE_URL . 'news/items/'.$group_id);
    }
}
