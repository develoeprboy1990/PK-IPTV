<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(24);
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('songs_m');
        /* Title Page :: Common */
        $this->page_title->push('Songs');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "mod";
        $this->data['sub_nav'] = "songs";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'songs', 'Songs');
    }

	public function index()
	{
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'songs/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'songs/index';
        $this->data['page_title'] = "Songs";
        $this->data['add_text'] = "Add a Song";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){  
        $this->load->model('albums_m');
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

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('songs/edit/'.$insert_id).'" target="_blank">Song Added</a>');   
            $this->session->set_flashdata('success',$title. "Added Successfully.");
            redirect(BASE_URL.'songs');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'songs/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* get all the Album */
        $this->data['albums'] = $this->albums_m->get();

        /* get all the tokens */
        $this->data['tokens'] = $this->songs_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(5); //music 5

        $this->data['_view'] = DEFAULT_THEME . 'songs/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {
       ( $id == NULL ) ? redirect( BASE_URL . 'songs' ) : '';
        $this->songs_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('songs').'" target="_blank">Song Deleted</a>');   
        $this->session->set_flashdata('success',"Song Deleted Successfully.");
        redirect( BASE_URL . 'songs' );
    }

	public function edit($id = NULL){
        $this->load->model('albums_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'songs' ) : '';
        $rules = $this->songs_m->rules;
        $this->form_validation->set_rules($rules);
        $song_info=$this->songs_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->songs_m->save($id,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('songs/edit/'.$id).'" target="_blank">Song Updated</a>');   
            $this->session->set_flashdata('success',"Edited Successfully.");
            redirect(BASE_URL.'songs');
        }
        $title='Song';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit '.$title, 'songs/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        /* get all the Album */
        $this->data['albums'] = $this->albums_m->get();

        /* get all the tokens */
        $this->data['tokens'] = $this->songs_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(5); //music 5

        $this->data['details'] = $song_info;
        $this->data['_view'] = DEFAULT_THEME . 'songs/edit';
        $this->data['title'] =$title;
        $this->data['page_title'] = "Edit a ". $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function get_all_songs(){
        $totaldata = 10;
        $totalfiltered = 10;
        $songs = $this->songs_m->join('albums','album_id');
        //$songs = $this->songs_m->get();
        $data = array();
        foreach ($songs as $song) {
            $data[] = array(
                    'id'=>$song['id'],
                    'name'=>$song['name'],
                    'album_name'=>$song['album_name'],
                    'url'=>$song['url'],
                    'position'=>$song['position'],
                    'edit'=>btn_edit(BASE_URL.'songs/edit/'.$song['id']),
                    'delete'=>btn_delete(BASE_URL.'songs/delete/'.$song['id']),
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
