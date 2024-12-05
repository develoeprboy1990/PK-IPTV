<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(18);
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('albums_m');
        /* Title Page :: Common */
        $this->page_title->push('Albums');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "mod";
        $this->data['sub_nav'] = "albums";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Albums', 'albums');
    }

	public function index()
	{  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'albums/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'albums/index';
        $this->data['page_title'] = "Albums";
        $this->data['add_text'] = "Add an Album";
        $this->data['type'] = 1;
        $this->data['albums'] =$this->albums_m->get();
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){ 
        check_allow('create',$this->data['is_allow']);
        $this->load->model('music_categories_m'); 
        $rules = $this->albums_m->rules;
        $this->form_validation->set_rules($rules);
        $title="Albums";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->albums_m->save(NULL,$data);
           
            //upload files if there is an image 
            if($_FILES['cover']['name']!='')
            {
                $upload_path= LOCAL_PATH_IMAGES_CMS ;
               
                $filename= $this->upload_image('cover', '', $upload_path, 'albums_m',$insert_id);
                $localFilePath = $upload_path.$filename;
                 //resize image 
                $this->resize_image($_FILES["cover"]["tmp_name"],$localFilePath,'215','215');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/details/'.$insert_id).'" target="_blank">Album Created</a>');         
            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'albums'); 
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'albums/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
     
        //get categories
        $this->data['categories']=$this->music_categories_m->get();
        //get tokens 
        $this->data['tokens']=$this->albums_m->get_tokens();
        
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'albums/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'albums/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {   
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'albums' ) : '';
        $album_info=$this->albums_m->get($id,TRUE);
        if($album_info->cover){
            if(file_exists("./uploads/musics/".$album_info->cover))
                @unlink("./uploads/musics/".$album_info->cover);
        }
        $this->userlogs->track_this($this->session->user_id,'Album Deleted');         
        $this->albums_m->delete_songs($id);
        $this->albums_m->delete($id);
        $this->session->set_flashdata('success',"Album Deleted Successfully.");
        redirect( BASE_URL . 'albums' );
    }

	public function edit($id = NULL)
    {
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('music_categories_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'albums' ) : '';
        $rules = $this->albums_m->rules;
        $this->form_validation->set_rules($rules);
        $album_info=$this->albums_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->albums_m->save($id,$data);
            
            //upload files if there is an image 
            if($_FILES['cover']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('cover', $album_info->cover, $upload_path, 'albums_m',$id);
                $localFilePath = $upload_path.$filename;
                 //resize image 
                $this->resize_image($_FILES["cover"]["tmp_name"],$localFilePath,'215','215');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/details/'.$id).'" target="_blank">Album Updated</a>');   
            $this->session->set_flashdata('success',"Edited Successfully.");
            redirect(BASE_URL.'albums');
        }
        $title='Albums';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit '.$title, 'albums/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get categories
        $this->data['categories']=$this->music_categories_m->get();
        //get tokens 
        $this->data['tokens']=$this->albums_m->get_tokens();
        $this->data['details'] = $album_info;
         $this->data['_extra_scripts'] = DEFAULT_THEME . 'albums/_common_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'albums/edit';
        $this->data['title'] =$title;
        $this->data['page_title'] = "Edit ". $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function details($id,$tab=1){
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('music_categories_m');
        $this->load->model('songs_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'albums' ) : '';
        $rules = $this->albums_m->rules;
        $this->form_validation->set_rules($rules);
        $album_info=$this->albums_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->albums_m->save($id,$data);
            
            //upload files if there is an image 
            if($_FILES['cover']['name']!='')
            {
                $upload_path=LOCAL_PATH_IMAGES_CMS;
                $filename= $this->upload_image('cover', $album_info->cover, $upload_path, 'albums_m',$id);
                $localFilePath = $upload_path.$filename;
                 //resize image 
                $this->resize_image($_FILES["cover"]["tmp_name"],$localFilePath,'215','215');
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->session->set_flashdata('success',"Edited Successfully.");
            redirect(BASE_URL.'albums');
        }
        $title='Albums';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,$title.' Details', 'albums/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get categories
        $this->data['categories']=$this->music_categories_m->get();
        //get tokens 
        $this->data['tokens']=$this->albums_m->get_tokens();
        $this->data['details'] = $album_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'albums/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'albums/details';
        $this->data['title'] =$title;
        $this->data['page_title'] = $title." Details";
        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(5); //music 5

        $this->data['songs'] =$this->songs_m->get_by(array('album_id'=>$id));
        $this->data['album_view'] = $this->load->view( DEFAULT_THEME . 'albums/_album_info',$this->data, TRUE);
        $this->data['song_form_action'] = "add";
        $this->data['add_songs_view'] = $this->load->view( DEFAULT_THEME . 'albums/_add_song',$this->data, TRUE);
        $this->data['songs_list_view'] = $this->load->view( DEFAULT_THEME . 'albums/_song_list',$this->data, TRUE);
        $this->data['activeTab'] = $tab;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function addSong($id,$tab){
        $this->load->model('music_categories_m');
        $this->load->model('songs_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'albums' ) : '';
        $album_info=$this->albums_m->get($id,TRUE);
        $rules = $this->songs_m->rules;
        $this->form_validation->set_rules($rules);
        $title="songs";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->songs_m->save(NULL,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/editSong/'.'/'.$id.'/'.$insert_id.'/2').'" target="_blank">Song Added</a>');   
            $this->session->set_flashdata('success',"Song added Successfully.");
            redirect(BASE_URL.'albums/details/'.$id.'/2');
        }
        $title='Albums';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,$title.' Details', 'albums/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get categories
        $this->data['categories']=$this->music_categories_m->get();
        //get tokens 
        $this->data['tokens']=$this->albums_m->get_tokens();
        $this->data['details'] = $album_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'albums/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'albums/details';
        $this->data['title'] =$title;
        $this->data['page_title'] = $title." Details";
        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(5); //music 5

        $this->data['songs'] =$this->songs_m->get_by(array('album_id'=>$id));
        $this->data['album_view'] = $this->load->view( DEFAULT_THEME . 'albums/_album_info',$this->data, TRUE);
        $this->data['song_form_action'] = "add";
        $this->data['add_songs_view'] = $this->load->view( DEFAULT_THEME . 'albums/_add_song',$this->data, TRUE);
        $this->data['songs_list_view'] = $this->load->view( DEFAULT_THEME . 'albums/_song_list',$this->data, TRUE);
        $this->data['activeTab'] = $tab;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function editSong($id,$song_id,$tab){
        $this->load->model('music_categories_m');
        $this->load->model('songs_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'albums' ) : '';
        $album_info=$this->albums_m->get($id,TRUE);
        $song_info=$this->songs_m->get($song_id,TRUE);
        $rules = $this->songs_m->rules;
        $this->form_validation->set_rules($rules);
        $title="songs";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $this->songs_m->save($song_id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/editSong/'.'/'.$id.'/'.$song_id.'/2').'" target="_blank">Song Updated</a>');   
            $this->session->set_flashdata('success',"Song updated Successfully.");
            redirect(BASE_URL.'albums/details/'.$id.'/2');
        }
        $title='Albums';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,$title.' Details', 'albums/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get categories
        $this->data['categories']=$this->music_categories_m->get();
        //get tokens 
        $this->data['tokens']=$this->albums_m->get_tokens();
        $this->data['details'] = $album_info;
        $this->data['song_details'] = $song_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'albums/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'albums/details';
        $this->data['title'] =$title;
        $this->data['page_title'] = $title." Details";
        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(5); //music 5

        $this->data['songs'] =$this->songs_m->get_by(array('album_id'=>$id));
        
        $this->data['album_view'] = $this->load->view( DEFAULT_THEME . 'albums/_album_info',$this->data, TRUE);
        $this->data['edit_songs_view'] = $this->load->view( DEFAULT_THEME . 'albums/_edit_song',$this->data, TRUE);
        $this->data['song_form_action'] = "edit";
        $this->data['songs_list_view'] = $this->load->view( DEFAULT_THEME . 'albums/_song_list',$this->data, TRUE);
        $this->data['activeTab'] = $tab;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function deleteSong($id,$song_id){
        $this->load->model('songs_m');
        $this->songs_m->delete($song_id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/details/'.$id.'/2').'" target="_blank">Song Deleted</a>');   
        $this->session->set_flashdata('success',"Song Deleted Successfully.");
        redirect( BASE_URL . 'albums/details/'.$id.'/2');
    }

    public function disable($id){
        $data=array('status'=>0);
        $this->albums_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/details/'.$id).'" target="_blank">Album Disabled</a>');   
        $this->session->set_flashdata('success',"Album Disabled Successfully.");
        redirect(BASE_URL.'albums');
    }

    public function enable($id){
        $data=array('status'=>1);
        $this->albums_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('albums/details/'.$id).'" target="_blank">Album enabled</a>');   
        $this->session->set_flashdata('success',"Album Enabled Successfully.");
        redirect(BASE_URL.'albums');
    }
}
