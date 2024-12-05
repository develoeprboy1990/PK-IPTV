<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlists extends User_Controller {

    public function __construct()
    {
        parent::__construct();

        $is_allow = $this->ion_auth->checkPermission(14); 
        $this->data['is_allow']= $is_allow;
        
        if(!isset($is_allow))
        {
           redirect('unauthorize', 'refresh');
        }

        $this->load->model('playlists_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');

        /* Title Page :: Common */
        $this->page_title->push('Playlists');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "tar";
        $this->data['sub_nav'] = "playlists";
        
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Playlists', 'playlists');
    }

    public function index()
    { 
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'playlists/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'playlists/index';
        $this->data['page_title'] = "playlists";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['playlists']= $this->playlists_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $rules = $this->playlists_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->playlists_m->save(NULL,$data);
            
            //insert generated url 
            $start_time = $this->update_time($this->input->post('start_time'));
            $url="http://ims.hificdn.com/api/get_playlist.php?id=". $insert_id."&type=playlist";
            $data=array('url'=>$url,
                        'start_time'=>$start_time);
            $this->playlists_m->save($insert_id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists/edit/'.$insert_id).'" target="_blank">Playlist Created</a>');   
            $this->session->set_flashdata('success',"Playlist Added Successfully.");
            redirect(BASE_URL.'playlists');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Playlist', 'playlists/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['active_tab'] = 1;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'playlists/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'playlists/create';
        $this->data['page_title'] = "Add a Playlist";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
        ($id == NULL ) ? redirect( BASE_URL . 'devices' ) : '';
      
        $this->playlists_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists').'" target="_blank">Playlist Deleted</a>');   
        $this->session->set_flashdata('success',"Playlist Deleted Successfully.");
        redirect( BASE_URL . 'playlists' );
    }

    public function edit($id = NULL,$tab=1)
    {   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('playlist_content_items_m');
        $this->load->model('playlist_items_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'playlists' ) : '';
        $rules = $this->playlists_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->playlists_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->playlists_m->save($id,$data);
            
            $start_time = $this->update_time($this->input->post('start_time'));
            $data=array('start_time'=>$start_time);
            $this->playlists_m->save($id,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists/edit/'.$id).'" target="_blank">Playlist Updated</a>');   
            $this->session->set_flashdata('success',"Playlist Edited Successfully.");
            redirect(BASE_URL.'playlists/edit/'.$id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Playlist', 'playlists/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['details'] = $info;
        
        $this->data['playlist_items'] = $this->playlist_items_m->getPlayListItems($id);
        $this->data['playlist_content_items'] = $this->playlist_content_items_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'playlists/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'playlists/edit';
        $this->data['page_title'] = "Edit a Playlist";
        $this->data['active_tab'] = $tab;
        
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function addContent($playlist_id){
        $this->load->model('playlist_content_items_m');
        $this->load->model('playlist_items_m');
        $rules = $this->playlist_content_items_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->playlists_m->get($playlist_id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->playlist_content_items_m->save(NULL,$data);
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists/edit/'.$playlist_id.'/2').'" target="_blank">Playlist Content Item Added</a>');     
            $this->session->set_flashdata('success_add_content',"Playlist Content Item Added Successfully.");
            redirect(BASE_URL.'playlists/edit/'.$playlist_id.'/2');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Playlist', 'playlists/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        $this->data['details'] = $info;
        
        $this->data['playlist_items'] = $this->playlist_items_m->getPlayListItems($playlist_id);
        $this->data['playlist_content_items'] = $this->playlist_content_items_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'playlists/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'playlists/edit';
        $this->data['page_title'] = "Edit a Playlist";
        $this->data['active_tab'] = 2;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
  
    public function addPlayListItem($playlist_id){
        $this->load->model('playlist_content_items_m');
        $this->load->model('playlist_items_m');
        $rules = $this->playlist_items_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->playlists_m->get($playlist_id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
           /* $data = $this->array_from_post($post);
            $insert_id=$this->playlist_items_m->save(NULL,$data);
            */
            //insert Start time and end time 
            $start_time=$info->start_time;
            $end_time=$this->getLatestEndTime($playlist_id); //get the latest end time
            if($end_time!=false){
               $start_time=$end_time;
            }

            // get length in seconds of content item 
            $content_id=$this->input->post('playlist_content_id');
            $info_content=$this->playlist_content_items_m->get($content_id,TRUE);

            //length seconds
            $length=$info_content->length_seconds;

            $end_time = date('H:i A', strtotime($start_time)+$length); // $today is today date
            $end_time= $this->update_time($end_time);
                      
            $data=array('playlist_id'=>$this->input->post('playlist_id'),
                        'playlist_content_id'=>$this->input->post('playlist_content_id'),
                        'start_time'=>$start_time,
                        'end_time'=>$end_time,
                        'position'=>$this->input->post('position'));
            $insert_id=$this->playlist_items_m->save(NULL,$data);

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists/edit/'.$playlist_id).'" target="_blank">Playlist Item Added</a>');     
            $this->session->set_flashdata('success_add_playlist_item',"Playlist Item Added Successfully.");
            redirect(BASE_URL.'playlists/edit/'.$playlist_id);
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Playlist', 'playlists/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        $this->data['details'] = $info;
        
        $this->data['playlist_items'] = $this->playlist_items_m->getPlayListItems($playlist_id);
        $this->data['playlist_content_items'] = $this->playlist_content_items_m->get();

        $this->data['_extra_scripts'] = DEFAULT_THEME . 'playlists/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'playlists/edit';
        $this->data['page_title'] = "Edit a Playlist";
        $this->data['active_tab'] = 2;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    //ajax function
    public function updateItem(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('position'=>$this->input->post('value'));
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('playlist_items');
        echo "Updated Successfully";
    }

    public function fillPlaylist($playlist_id){
        $this->load->model('playlist_content_items_m');
        $this->load->model('playlist_items_m');
        
        //get the smallest start time for the playlists 
        $sql_start_time="Select start_time from playlist_items 
              WHERE playlist_id=? order by position ASC 
              LIMIT 1";
        $query=$this->db->query($sql_start_time, array($playlist_id));      
        $start_time=$query->row()->start_time;
        
        //get the greatest endtime for the playlists
        $sql_end_time="Select end_time from playlist_items 
              WHERE playlist_id=? order by position DESC 
              LIMIT 1";
        $query=$this->db->query($sql_end_time, array($playlist_id));      
        $end_time=$query->row()->end_time;

        // get the difference 
        $time2=strtotime($end_time);
        $time1=strtotime($start_time);
        if($time2 < $time1) {
            $time2 += 24 * 60 * 60;
        }
        $diff= ($time2 - $time1) / 3600; // get the hours 6

        // loop until it is difference is 24 hour 
        if($diff != 0) {
            // get existing playlist items 
            $playlist_items = $this->playlist_items_m->get_by(array('playlist_id'=>$playlist_id));
            foreach ($playlist_items as $item) {
                // check if the difference is less than 24 
                 //get the smallest start time for the playlists 
                $sql_start_time="Select start_time from playlist_items 
                      WHERE playlist_id=? order by position ASC 
                      LIMIT 1";
                $query=$this->db->query($sql_start_time, array($playlist_id));      
                $start_time=$query->row()->start_time;
                
                //get the greatest endtime for the playlists
                $sql_end_time="Select end_time from playlist_items 
                      WHERE playlist_id=? order by position DESC 
                      LIMIT 1";
                $query=$this->db->query($sql_end_time, array($playlist_id));      
                $end_time=$query->row()->end_time;

                // get the difference 
                $time2=strtotime($end_time);
                $time1=strtotime($start_time);
              
                if($time2 < $time1) {
                    $time2 += 24 * 60 * 60;
                }

                $diff= ($time2 - $time1) / 3600;
                if($diff==0)
                    break;
                $content_info = $this->playlist_content_items_m->get_by(array('id'=>$item['playlist_content_id']), TRUE);
                //length seconds
                $length=$content_info->length_seconds;
                
                // get the latest end time 
                $sql="Select end_time from playlist_items 
                  WHERE playlist_id=? order by id desc 
                  LIMIT 1";
                $query=$this->db->query($sql, array($playlist_id));
                $start_time=$query->row()->end_time;

                $end_time = date('H:i A', strtotime($start_time)+$length); // $today is today date
                $end_time= $this->update_time($end_time);

                // get latest position
                $sql_position="Select position from playlist_items 
                  WHERE playlist_id=? order by position desc 
                  LIMIT 1";
                $query_position=$this->db->query($sql_position, array($playlist_id));
                $position=($query_position->row()->position) + 1;
                
                $data=array('playlist_id'=>$item['playlist_id'],
                            'playlist_content_id'=>$item['playlist_content_id'],
                            'start_time'=>$start_time,
                            'end_time'=>$end_time,
                            'position'=>$position
                            );
                            
               $this->playlist_items_m->save(NULL,$data);
            }
        }
        
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists/edit/'.$playlist_id).'" target="_blank">Playlist Filled</a>');     
        $this->session->set_flashdata('success',"Playlist Filled Successfully.");
        redirect( BASE_URL . 'playlists/edit/'.$playlist_id );
    }

    public function deletePlaylistItem($playlist_id,$id = NULL){
        check_allow('delete',$this->data['is_allow']);
        $this->load->model('playlist_content_items_m');
        $this->load->model('playlist_items_m');
        ($id == NULL ) ? redirect( BASE_URL . 'playlists/edit/'.$playlist_id) : '';
       
        // update all the playlist start_time and end time
        // get deleted list's upper end_time 
        $sql="Select end_time from playlist_items 
              WHERE id>? AND playlist_id=? order by id asc
              LIMIT 1";
        $query=$this->db->query($sql, array($id,$playlist_id));
   
        //delete 
        $this->playlist_items_m->delete($id);
        if($query->num_rows()>0){
            $start_time=$query->row()->end_time;

            //get all playlist items associated with playlist_id order by asc 
            $playlist_items = $this->playlist_items_m->get_by(array('playlist_id'=>$playlist_id));
            foreach ($playlist_items as $item) {
                $content_info = $this->playlist_content_items_m->get_by(array('id'=>$item['playlist_content_id']), TRUE);
                
                //length seconds
                $length=$content_info->length_seconds;

                $end_time = date('H:i A', strtotime($start_time)+$length); // $today is today date
                $end_time= $this->update_time($end_time);

                $data=array('start_time'=>$start_time,
                            'end_time'=>$end_time
                            );
                            
                $this->playlist_items_m->save($item['id'],$data);
                $start_time=$end_time;
            }
        }
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('playlists/edit/'.$playlist_id).'" target="_blank">Playlist Deleted</a>');     
        $this->session->set_flashdata('success',"Playlist Deleted Successfully.");
        redirect( BASE_URL . 'playlists/edit/'.$playlist_id );
    }

    //ajax function
    public function deleteItem(){
        check_allow('delete',$this->data['is_allow']);
        $this->load->model('playlist_items_m');
        $id=$this->input->post('id');
        $this->playlist_items_m->delete($id);
        echo "Updated Successfully";
    }

    //ajax function
    public function updateContentItem(){
        check_allow('edit',$this->data['is_allow']);
        $id=$this->input->post('id');
        $data=array('name'=>$this->input->post('name'),
                    'length_seconds'=>$this->input->post('length'),
                    'url'=>$this->input->post('url')
                    );
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('playlist_content_items');
        echo "Updated Successfully";
    }

    //ajax function
    public function deleteContentItem(){
        check_allow('delete',$this->data['is_allow']);
        $this->load->model('playlist_content_items_m');
        $id=$this->input->post('id');
        $this->db->delete('playlist_items', array('playlist_content_id' => $id));
        $this->playlist_content_items_m->delete($id);
        echo "Updated Successfully";
    }

    function getLatestEndTime($playlist_id){
        $sql="Select end_time FROM playlist_items 
              WHERE playlist_id=? order by id DESC LIMIT 1";
        $query=$this->db->query($sql,$playlist_id);
        if($query->num_rows()>0){
            return $query->row()->end_time;
        }else{
            return false;
        }
    }

    function update_time($time){
        $ap = $time[5].$time[6];
        $ttt = explode(":", $time);
        $th = $ttt['0'];
        $tm = $ttt['1'];
        if($ap=='pm' || $ap=='PM'){
            $th+=12;
            if($th==24){
                $th = 12;
            }
        }
        if($ap=='am' || $ap=='AM'){
            if($th==12){
                $th = '00';
            }
        }
        $newtime = $th.":".$tm[0].$tm[1];
        return $newtime;
    }

}
