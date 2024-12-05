<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messagedevice extends User_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(75);
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        $this->load->model('messagedevice_m');
        /* Title Page :: Common */
        $this->page_title->push('Message Device');
        $this->data['pagetitle'] = $this->page_title->show();

        $this->data['main_nav'] = "customers";
        $this->data['sub_nav'] = "messagedevice";
       
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Message Device', 'messagedevice');
    }

	public function index()
	{  
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'messagedevice/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'messagedevice/index';
        $this->data['page_title'] = "Message Device";
        $this->data['add_text'] = "Add a Message Device";
        $this->data['type'] = 1;
        $this->data['albums'] =$this->messagedevice_m->get();
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){ 
        check_allow('create',$this->data['is_allow']);
        $this->load->model('messagedevice_m'); 
        $rules = $this->messagedevice_m->rules;
        $this->form_validation->set_rules($rules);
        $title="Message Device";
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);			
            $insert_id=$this->messagedevice_m->save(NULL,$data);
           
            //upload files if there is an image 
			 if($_FILES['image_msg']['name']!=''){
                $upload_path= LOCAL_PATH_IMAGES_CRMD_UPL0AD ;
				if (!is_dir($upload_path)) {
					/* Directory does not exist, so lets create it. */
					mkdir($upload_path, 0777, true);
				}			
               
                $filename= $this->upload_image('image_msg','', $upload_path, 'messagedevice_m',$insert_id);
                $localFilePath = $upload_path.$filename;
				
				$current_time = strtotime(date("Y-m-d h:i:s"));
							
				$img_type = str_replace("image/","",$_FILES['image_msg']['type']);
				$newimagename = $current_time.'.'.$img_type;	
				$newimagepath = LOCAL_PATH_IMAGES_CRMD_UPL0AD.$current_time.'.'.$img_type;	
				rename($localFilePath,$newimagepath);				
                 //resize image 
               // $this->resize_image($_FILES["image_msg"]["tmp_name"],$localFilePath,'215','215');
			    $this->resize_image($_FILES["image_msg"]["tmp_name"],$newimagepath,'215','215');
                //$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
				$this->uploadToCdnServer($newimagename,$newimagepath,'images','cms');				
				$this->messagedevice_m->save($insert_id,array('image_msg' => $newimagename));
            }
			
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('messagedevice/details/'.$insert_id).'" target="_blank">Messagedevice Created</a>');         
            $this->session->set_flashdata('success',$title. "Added Successfully.");
			
			$this->makeJson();
			
            redirect(BASE_URL.'messagedevice'); 
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create '.$title, 'messagedevice/create/');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();     
             
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'messagedevice/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'messagedevice/create';
        $this->data['page_title'] = "Add New " .$title;
        $this->data['title'] = $title;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {   
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'messagedevice' ) : '';
        $messagedevice_info=$this->messagedevice_m->get($id,TRUE);
        if($messagedevice_info->image_msg){
			 $upload_path= LOCAL_PATH_IMAGES_CMS.'messagedevice/' ;
            if(file_exists($upload_path.$messagedevice_info->image_msg)){
                @unlink($upload_path.$messagedevice_info->image_msg);
			}
        }
		
		 	$this->userlogs->track_this($this->session->user_id,'Message Device Deleted');         
        	$this->messagedevice_m->delete($id);
			
			$start_date = $messagedevice_info->start_date;
			$end_date = $messagedevice_info->end_date;
			
			$today_date = date("Y-m-d");
			if (date_create($end_date) >= date_create($today_date)) {
				$maxd = $messagedevice_info->end_date;
				if(date_create($today_date) >= date_create($start_date)) {
					$mind = $today_date;
				}else{
					$mind = $messagedevice_info->start_date;
				}
				$diff = date_diff(date_create($maxd), date_create($mind));
				
				$diff_day = $diff->d;
				
				for($i=0 ; $i <= $diff_day ; $i++){
					//$json_date = date("Y-m-d", strtotime("+".$i." days", strtotime($mind)));
					$json_date = date("d-m-Y", strtotime("+".$i." days", strtotime($mind)));
					$json_directory = LOCAL_PATH_CRMD;
					$filename = str_replace('-','_',$json_date) . '_push.json';
					$localFilePath = $json_directory.'/'.$filename;
					if(file_exists($localFilePath)){
						@unlink($localFilePath);
					}			
				}
			}
       
		
		$this->makeJson();
        $this->session->set_flashdata('success',"Message Device Deleted Successfully.");
        redirect( BASE_URL . 'messagedevice' );
    }

	
    public function details($id){		
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'messagedevice' ) : '';
        $rules = $this->messagedevice_m->rules;
        $this->form_validation->set_rules($rules);
        $msg_info=$this->messagedevice_m->get($id,TRUE);
		//print_r($msg_info);exit;
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $this->messagedevice_m->save($id,$data);
            
            //upload files if there is an image 
			 if($_FILES['image_msg']['name']!=''){
                $upload_path= LOCAL_PATH_IMAGES_CRMD_UPL0AD ;
				if (!is_dir($upload_path)) {
					/* Directory does not exist, so lets create it. */
					mkdir($upload_path, 0777, true);
				}
			
               
                $filename= $this->upload_image('image_msg',$msg_info->image_msg, $upload_path, 'messagedevice_m',$id);
                $localFilePath = $upload_path.$filename;
				
				$current_time = strtotime(date("Y-m-d h:i:s"));
							
				$img_type = str_replace("image/","",$_FILES['image_msg']['type']);
				$newimagename = $current_time.'.'.$img_type;	
				$newimagepath = LOCAL_PATH_IMAGES_CRMD_UPL0AD.$current_time.'.'.$img_type;	
				rename($localFilePath,$newimagepath);				
                 //resize image 
               // $this->resize_image($_FILES["image_msg"]["tmp_name"],$localFilePath,'215','215');
			    $this->resize_image($_FILES["image_msg"]["tmp_name"],$newimagepath,'215','215');
                //$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
				$this->uploadToCdnServer($newimagename,$newimagepath,'images','cms');
				
				 $this->messagedevice_m->save($id,array('image_msg' => $newimagename));
            }
			

			$maxd = $messagedevice_info->end_date;
			
			$mind = date("Y-m-d");
			$diff = date_diff(date_create($maxd), $mind);
			
				
			$diff_day = $diff->d;
			
			
			for($i=0 ; $i <= $diff_day ; $i++){
				//$json_date = date("Y-m-d", strtotime("+".$i." days", strtotime($mind)));
				$json_date = date("d-m-Y", strtotime("+".$i." days", strtotime($mind)));
				$json_directory = LOCAL_PATH_CRMD;
				$filename = str_replace('-','_',$json_date) . '_push.json';
				$localFilePath = $json_directory.'/'.$filename;
				if(file_exists($localFilePath)){
                	@unlink($localFilePath);
				}				
							
			}
       
		
			$this->makeJson();
		
            $this->session->set_flashdata('success',"Edited Successfully.");
            redirect(BASE_URL.'messagedevice');
        }
        $title='Message';
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,$title.' Details', 'messagedevice/edit/'.$id);
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
       
        $this->data['details'] = $msg_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'messagedevice/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'messagedevice/details';
        $this->data['title'] =$title;
        $this->data['page_title'] = $title." Details";
       
        $this->data['msg_id'] = $id;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function makeJson(){
			$maxd = $this->messagedevice_m->getMaxMinDate('maxd');
			$mind = $this->messagedevice_m->getMaxMinDate('mind');
			$today_date = date("Y-m-d");
			
			if (date_create($mind[0]['min_date']) >= date_create($today_date)) {
				$min_date = $mind[0]['min_date'];
				$diff = date_diff(date_create($maxd[0]['max_date']), date_create($mind[0]['min_date']));
			}else{
				$min_date = $today_date;
				$diff = date_diff(date_create($maxd[0]['max_date']), date_create($min_date));
			}
			
			$diff_day = $diff->d;
			
			
			if (date_create($mind[0]['max_date']) >= date_create($today_date)) {
				for($i=0 ; $i <= $diff_day ; $i++){
						//$json_date = '2023-09-25';
						$json_date = date("Y-m-d", strtotime("+".$i." days", strtotime($min_date)));
						$file_date = date("d-m-Y", strtotime("+".$i." days", strtotime($min_date)));
						$data_raw = $this->messagedevice_m->getAllRowsByDate($json_date);
						$data = array();
						if(count($data_raw) >0){						
							foreach($data_raw as $key=>$val){
								$data_array = array(
													/*'title' => $val['title'],
													'description' => $val['description'],
													'image_msg' => LOCAL_PATH_IMAGES_CRMD.$val['image_msg'],
													'start_date' => $val['start_date'],
													'end_date' => $val['end_date']*/
													'content_id' => $val['id'],
													'time' => strtotime($val['start_date']),
													'big_text' => $val['description'],
													'title' => $val['title'],
													'image_msg' => LOCAL_PATH_IMAGES_CRMD.$val['image_msg']
												);
								array_push($data,$data_array);
							}
						}				
						//JSON
						//==============================================================
								$json_directory = LOCAL_PATH_CRMD;
								if(!is_dir($json_directory)){
									/* Directory does not exist, so lets create it. */
									mkdir($json_directory, 0777, true);
								}					
								$filename = str_replace('-','_',$file_date) . '_push.json';
									
								$localFilePath = $json_directory.'/'.$filename;
								
								
								if(file_exists($localFilePath)){
									@unlink($localFilePath);
								}
				
				
								$final_json_output = json_encode($data);
								
								$fpt_r = fopen($localFilePath, 'w');
								fwrite($fpt_r, $final_json_output);
								fclose($fpt_r);		
						//=================================================================
				
				}
			}
			
			redirect(BASE_URL.'messagedevice');
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
