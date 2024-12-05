<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channels extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(11);
        $this->lang->load('groups');
        $this->lang->load('actions');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('Channel Groups');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "tar";
        $this->data['sub_nav'] = "channels";
        $this->data['activeTab'] = 1;
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'Channels', 'channels');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/index';
        $this->data['page_title'] = "Television and Radio";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->data['channels'] = $this->channels_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }
	
	public function channelsoverview(){
		check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/channelsoverview';
        $this->data['page_title'] = "Television and Radio";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		$chanel_info = $this->channels_m->get();
		
		$this->load->model('epgs_m');
		$epg_info = $this->epgs_m->get();
		
		$this->data['sub_nav'] = "channelsoverview";
		
		foreach($epg_info as $key=>$val){
			$epg_array['epg_'.$val['id']] = $val['name'];
		}
		
		$this->load->model('server_items_urls_m');
		$server_urls_array = $this->server_items_urls_m->getUrls(3);
		
		foreach($server_urls_array as $key=>$val){
		//print_r($val);
			$server_urls_array_bm['high_server_'.$val->id] = $val->name.' / ';
		}
		//echo '<pre>';
		//print_r($epg_info);
		//print_r($server_urls_array_bm);exit;
		$this->data['server_urls'] = $server_urls_array_bm;
		
		$catchup_server_urls_array = $this->server_items_urls_m->getUrls(2);
		
		foreach($catchup_server_urls_array as $key=>$val){
		//print_r($val);
			$catchup_server_urls_bm['catchup_server_'.$val->id] = $val->name.' / ';
		}
		
		$this->data['catchup_server_urls']=$catchup_server_urls_bm;
        $this->data['channels'] =$chanel_info;
		$this->data['epg_arr'] =$epg_array;
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
	}
	
	public function check_available(){
		$id = $_REQUEST['channel_number'];
		$channel_info=$this->channels_m->get_channel_by_id($id);
		if(count($channel_info) >0){
			echo 'duplicate';
		}else{
			echo 'available';
		}
	}
    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('languages_m');

        $rules = $this->channels_m->add_rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post(
                array( 
                    'language_id',
                    'channel_number', 
                    'channel_epg_name',
					'channel_epg_id',
					'epg_name',
                    'channel_name',
                    'server_url_high', 
                    'url_high', 
                    'token_high', 
                    'server_url_low',
                    'url_low',
                    'token_low',
                    'server_standard', 
                    'url_standard',
                    'token_standard',
                    'server_ios_tvos', 
                    'url_ios_tvos',
                    'token_ios_tvos',  
                    'server_tizen_webos', 
                    'url_tizen_webos',
                    'token_tizen_webos',  
                    'channel_type',
                    'channel_catchup_tv', 
                    'epg_url',
                    'epg_offset',
                    'dvr_offset',
                    'preroll_enabled',
                    'overlay_enabled',
                    'preroll_type',
                    'overlay_enabled',
                    'ticker_enabled',
                    'show_on_home',
                    'fingerprint',
                    'server_url_interactivetv',
                    'url_interactivetv',
                    'token_interactivetv',
                    'childlock',
                    'is_kids_friendly',
                    'is_flussonic'
                    )
                );
/*echo '<pre>';
print_r($data);exit;*/
            $insert_id=$this->channels_m->save(NULL,$data);
           
		   
		   if($this->input->post('channel_image_icon')!=""){
                if($this->download_and_save_image($this->input->post('channel_image_icon'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('channel_image_icon'));
                   // $data = array('channel_image_icon'=>$file_name);
                  	//  $this->channels_m->save($insert_id,$data);
					
					if($_FILES['channel_image']['name']!=''){
                    	$data = array('channel_image_icon'=>$file_name);
                   		$this->channels_m->save($insert_id,$data);
					}elseif($_FILES['channel_image']['name']==''){
						$data = array('channel_image_icon'=>$file_name, 'channel_image' => $file_name);
                   		$this->channels_m->save($insert_id,$data);
					}
                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
					$this->resize_image($localFilePath,$localFilePath,'180','180');
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');					
                }
            }
			
			
            //upload files if there is an image 
            if($_FILES['channel_image']['name']!='')
            {
                $filename= $this->upload_image('channel_image', '', LOCAL_PATH_IMAGES_CMS, 'channels_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                //resize image 
                $this->resize_image($_FILES["channel_image"]["tmp_name"],$localFilePath,'180','180');
				
				
		
				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
				
                
            }

            // insert into channel group tables
            if(is_array($this->input->post('channel_group')) && count($this->input->post('channel_group'))>0){
                foreach ($this->input->post('channel_group') as $group) {
                   $data=array(
                        'group_id'=>$group,
                        'channel_id'=>$insert_id
                    );
                   $this->db->insert('channel_to_group',$data);
                }
            }

            // insert into packages group tables
            if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                foreach ($this->input->post('packages') as $pkt) {
                   $data=array(
                        'package_id'=>$pkt,
                        'channel_id'=>$insert_id
                    );
                   $this->db->insert('package_to_channel',$data);
                }
            }
            
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$insert_id).'" target="_blank">Channel Added</a>');   
            $this->session->set_flashdata('success',"Channel Added Successfully.");
            redirect(BASE_URL.'channels');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create Channel', 'channels/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
         
       //channels_groups
        $this->data['groups_channel']=$this->groups_channel_m->get();
        
        //get all packages
        $this->data['packages']=$this->packages_m->get();

        //get tokens 
        $this->data['tokens']=$this->channels_m->get_tokens();
        
		$this->load->model('epgs_chanels_m');
		$this->load->model('epgs_m');
		/*echo '<pre>';*/
		$epg_status_active = $this->epgs_m->getValueWhere(array('epg_status'=>'1'));
		//print_r($epg_status_active);exit;
		//$this->data['epg_info'] = $this->epgs_m->get();
		$this->data['epg_info'] = $epg_status_active;
		$epgs_chanels_info_array = $this->epgs_chanels_m->get();
		$this->data['epg_chanel_info'] = json_encode($epgs_chanels_info_array);
		$this->data['epg_chanel_infoselect'] = serialize($epgs_chanels_info_array);
		//echo '<pre>';
		//print_r($this->epgs_chanels_m->chanel_logo('24')); exit;
		
		$this->data['chanel_logo'] = $this->epgs_chanels_m->chanel_logo('24');
		
        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(3);


        //get languages
        $this->data['languages']=$this->languages_m->get();
        
        $this->data['catchup_server_urls']=$this->server_items_urls_m->getUrls(2);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/create';
        $this->data['page_title'] = "Add New Channel";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL)
    {
        check_allow('delete',$this->data['is_allow']);
       ( $id == NULL ) ? redirect( BASE_URL . 'channels' ) : '';
        
        $channel_info=$this->channels_m->get($id);
        
        if($channel_info->channel_image)
        {
            if(file_exists("./uploads/channels/".$channel_info->channel_image))
                @unlink("./uploads/channels/".$channel_info->channel_image);
        }

        if($channel_info->channel_image_icon)
        {
            if(file_exists("./uploads/channels/icons/".$channel_info->channel_image_icon))
                @unlink("./uploads/channels/icons/".$channel_info->channel_image_icon);
        }

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels').'" target="_blank">Channel Deleted</a>');   
        $this->channels_m->delete($id);
        $this->channels_m->delete_channels_groups($id);
        $this->session->set_flashdata('success',"Channel Deleted Successfully.");
        redirect( BASE_URL . 'channels' );
    }

	public function edit($id = NULL)
    {
        check_allow('edit',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'channels' ) : '';
        $rules = $this->channels_m->edit_rules;
        $this->form_validation->set_rules($rules);
        $channel_info=$this->channels_m->get($id,TRUE);
        
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post(
                array(
                    'channel_number', 
                    'channel_epg_name',
					'channel_epg_id',
                    'channel_name', 
                    'url_high', 
                    'url_low', 
                    'channel_type',
                    'channel_catchup_tv', 
                    'token',
                    'epg_url',
                    'epg_offset',
                    'preroll_enabled',
                    'overlay_enabled',
                    'preroll_type',
                    'overlay_enabled',
                    'ticker_enabled',
                    'show_on_home',
                    'fingerprint',
                    'is_flussonic',
                    'flussonoc',
                    'url_interactivetv',
                    'childlock',
                    'secure_stream',
                    'drm_stream',
                    'drm_rewrite_rule',
                    'is_payperview',
                    'rule_payperview',
                    'is_kids_friendly',
                    'use_events',
                    'use_playlist',
                    'dvr_channel_name',
                    'is_dveo',
                    'have_archive',
                    'encoder_id',
                    'status'
                    )
                );
            $this->channels_m->save($id,$data);
                       
            //upload files if there is an image 
            if($_FILES['channel_image']['name']!='')
            {
                $filename= $this->upload_image('channel_image', $channel_info->channel_image, LOCAL_PATH_IMAGES_CMS, 'channels_m',$id);
                
               /* $this->load->library('imageeditor');
                $this->imageeditor->Initialize($filename, LOCAL_PATH_IMAGES_CMS);
                $this->imageeditor->crop(0,0,180, 180); //resize(width,height)
                $this->imageeditor->outputFile($filename, LOCAL_PATH_IMAGES_CMS);
                */
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                //resize image 
                $this->resize_image($_FILES["channel_image"]["tmp_name"],$localFilePath,'180','180');
             
				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
                
            }

            // insert into channel group tables
            if(is_array($this->input->post('channel_group')) && count($this->input->post('channel_group'))>0){
                // first delete all 
                $this->channels_m->delete_channels_groups($id);

                // then insert 
                foreach ($this->input->post('channel_group') as $group) {
                   $data=array(
                        'group_id'=>$group,
                        'channel_id'=>$id
                    );
                   $this->db->insert('channel_to_group',$data);
                }
            }

             // insert into packages group tables
            if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                
                // first delete all 
                $this->channels_m->delete_channels_package($id);

                foreach ($this->input->post('packages') as $pkt) {
                   $data=array(
                        'package_id'=>$pkt,
                        'channel_id'=>$id
                    );
                   $this->db->insert('package_to_channel',$data);
                }
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$id).'" target="_blank">Channel Updated</a>');   
            $this->session->set_flashdata('success',"Channel Edited Successfully.");
            redirect(BASE_URL.'channels');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit Channel', 'channels/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        //channels_groups
        $this->data['groups_channel']=$this->groups_channel_m->get();
        $this->data['channel_groups_ids']=$this->channels_m->get_channels_groups($id);

        //get all packages
        $this->data['packages']=$this->packages_m->get();
        
        //get packages id by channel 
        $this->data['channel_packages']=$this->channels_m->get_packages_by_channel($id);

        //get tokens 
        $this->data['tokens']=$this->channels_m->get_tokens();
        $this->data['channel_detail'] = $channel_info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/edit';
        $this->data['page_title'] = "Edit Channel";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }

    public function details($id,$tab=1){
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('logs_m');
        $this->load->model('epg_m');

		$this->load->model('epgs_chanels_m');
		$this->load->model('epgs_m');

        $this->load->model('languages_m');
		/*echo '<pre>';
		print_r();exit;*/
		$this->data['epg_info'] = $this->epgs_m->get();
		$epgs_chanels_info_array = $this->epgs_chanels_m->get();
		$this->data['epg_chanel_info'] = json_encode($epgs_chanels_info_array);
		$this->data['epg_chanel_infoselect'] = serialize($epgs_chanels_info_array);
		//echo '<pre>';
		//print_r($this->epgs_chanels_m->chanel_logo('24')); exit;
		
		$this->data['chanel_logo'] = $this->epgs_chanels_m->chanel_logo('24');
		
		
		
        ( $id == NULL ) ? redirect( BASE_URL . 'channels' ) : '';
             
        $channel_info=$this->channels_m->get($id,TRUE);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/details';
        $this->data['page_title'] = "Channel Details";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		/*echo '<pre>';
print_r($this->channels_m->get_by(array('id'=>$id),true));
exit;*/
        $this->data['channel_detail'] =$this->channels_m->get_by(array('id'=>$id),true);
        $this->data['epgs'] =$this->epg_m->get_by(array('channel_id'=>$id)); 
        $this->data['logs']=$this->logs_m->getLogs(2);
        $this->data['activeTab'] = $tab;
        //channels_groups
        $this->data['groups_channel']=$this->groups_channel_m->get();
        $this->data['channel_groups_ids']=$this->channels_m->get_channels_groups($id);

        //get all packages
        $this->data['packages']=$this->packages_m->get();
        
        //get packages id by channel 
        $this->data['channel_packages']=$this->channels_m->get_packages_by_channel($id);

        //get tokens 
        $this->data['tokens']=$this->channels_m->get_tokens();
		
		//$this->data['epg_info'] = $this->epgs_m->get();
		$this->data['epg_info'] = $this->epgs_m->get_epgs();
		//$epgs_chanels_info_array = $this->epgs_chanels_m->get();

         //get languages
        $this->data['languages']=$this->languages_m->get();
		
		
        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(3);
        $this->data['catchup_server_urls']=$this->server_items_urls_m->getUrls(2);

        $this->data['channel_info_view'] = $this->load->view( DEFAULT_THEME . 'channels/_channel_info',$this->data, TRUE);
        $this->data['package_group_view'] = $this->load->view( DEFAULT_THEME . 'channels/_package_group',$this->data, TRUE);
        $this->data['advertisement_view'] = $this->load->view( DEFAULT_THEME . 'channels/_advertisement',$this->data, TRUE);
        $this->data['epg_view'] = $this->load->view( DEFAULT_THEME . 'channels/_epg',$this->data, TRUE);
        $this->data['logs_view'] = $this->load->view( DEFAULT_THEME . 'channels/_logs',$this->data, TRUE);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function updateChannel($id,$tab){
        $this->load->model('logs_m');
        $this->load->model('epg_m');
        $this->load->model('languages_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'channels' ) : '';
        $rules = $this->channels_m->channel_edit_rules;
        $this->form_validation->set_rules($rules);
        $channel_info=$this->channels_m->get($id,TRUE);
        
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post(
            array(
                'language_id', 
                'channel_number', 
                'channel_epg_name',
				'channel_epg_id',
                'channel_name',
                'server_url_high', 
				'epg_name',
                'url_high', 
                'token_high',
                'server_url_low',
                'url_low', 
                'token_low',
                'server_standard', 
                'url_standard',
                'token_standard',
                'server_ios_tvos', 
                'url_ios_tvos',
                'token_ios_tvos',  
                'server_tizen_webos', 
                'url_tizen_webos',
                'token_tizen_webos',  
                'channel_type',
                'epg_url',
                'epg_offset',
                'dvr_offset',
                'show_on_home',
                'fingerprint',
                'server_url_interactivetv',
                'url_interactivetv',
                'token_interactivetv',
                'childlock',
                'is_kids_friendly',
                'is_flussonic'
                )
            );
        
            $this->channels_m->save($id,$data);
			
			if($this->input->post('channel_image_icon')!=""){ //echo 'test';exit;
                if($this->download_and_save_image($this->input->post('channel_image_icon'),LOCAL_PATH_IMAGES_CMS)){
                    $file_name= $this->get_file_name_from_url($this->input->post('channel_image_icon'));
					
					$data = array('channel_image_icon'=>$file_name);
                   	$this->channels_m->save($id,$data);
					/*if(($channel_info->channel_image == '') && ($_FILES['channel_image']['name']=='')){
						$data = array('channel_image' => $file_name);
                   		$this->channels_m->save($id,$data);
					}*/
					
					if($_FILES['channel_image']['name']==''){
						$data = array('channel_image' => $file_name);
                   		$this->channels_m->save($id,$data);
					}

                    $localFilePath = LOCAL_PATH_IMAGES_CMS.$file_name;
					$this->resize_image($localFilePath,$localFilePath,'180','180');
                    $this->uploadToCdnServer($file_name,$localFilePath,'images','cms');					
                }
            }
			
            //upload files if there is an image 
            if($_FILES['channel_image']['name']!='')
            {
                $filename= $this->upload_image('channel_image', $channel_info->channel_image, LOCAL_PATH_IMAGES_CMS, 'channels_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                 //resize image 
                $this->resize_image($_FILES["channel_image"]["tmp_name"],$localFilePath,'180','180');
				
				$this->uploadToCdnServer($filename,$localFilePath,'images','cms');
                

            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$id).'" target="_blank">Channel Updated</a>');   
            $this->session->set_flashdata('success',"Updated Successfully.");
            redirect(BASE_URL.'channels/details/'.$id);
        }
        
       
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/details';
        $this->data['page_title'] = "Channel Details";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['channel_detail'] =$this->channels_m->get_by(array('id'=>$id),true);
        $this->data['epgs'] =$this->epg_m->get_by(array('channel_id'=>$id)); 
        $this->data['logs']=$this->logs_m->getLogs(2);
        $this->data['activeTab'] = $tab;
        //channels_groups
        $this->data['groups_channel']=$this->groups_channel_m->get();
        $this->data['channel_groups_ids']=$this->channels_m->get_channels_groups($id);

        //get all packages
        $this->data['packages']=$this->packages_m->get();
        
        //get packages id by channel 
        $this->data['channel_packages']=$this->channels_m->get_packages_by_channel($id);

        //get tokens 
        $this->data['tokens']=$this->channels_m->get_tokens();

        //get server urls of channels 
        $this->load->model('server_items_urls_m');
        $this->data['server_urls']=$this->server_items_urls_m->getUrls(3);
        $this->data['catchup_server_urls']=$this->server_items_urls_m->getUrls(2);

        $this->data['channel_info_view'] = $this->load->view( DEFAULT_THEME . 'channels/_channel_info',$this->data, TRUE);
        $this->data['package_group_view'] = $this->load->view( DEFAULT_THEME . 'channels/_package_group',$this->data, TRUE);
        $this->data['advertisement_view'] = $this->load->view( DEFAULT_THEME . 'channels/_advertisement',$this->data, TRUE);
        $this->data['epg_view'] = $this->load->view( DEFAULT_THEME . 'channels/_epg',$this->data, TRUE);
        $this->data['logs_view'] = $this->load->view( DEFAULT_THEME . 'channels/_logs',$this->data, TRUE);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function updatePackageGroup($id,$tab){
       /* $this->load->model('logs_m');
        $this->load->model('epg_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'channels' ) : '';
        $rules = $this->channels_m->package_group_edit_rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()==TRUE){*/
          
            // insert into channel group tables
            if($this->input->post('total_channel_group')!=""){
                // first delete all 
                $this->channels_m->delete_channels_groups($id);
                if(is_array($this->input->post('channel_group')) && count($this->input->post('channel_group'))>0){
                    // then insert 
                    foreach ($this->input->post('channel_group') as $group) {
                       $data=array(
                            'group_id'=>$group,
                            'channel_id'=>$id
                        );
                       $this->db->insert('channel_to_group',$data);
                    }
                }
            }

             // insert into packages group tables
            if($this->input->post('total_package')!=""){
                // first delete all 
                $this->channels_m->delete_channels_package($id);
                if(is_array($this->input->post('packages')) && count($this->input->post('packages'))>0){
                    foreach ($this->input->post('packages') as $pkt) {
                       $data=array(
                            'package_id'=>$pkt,
                            'channel_id'=>$id
                        );
                       $this->db->insert('package_to_channel',$data);
                    }
                }
            }
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$id.'/2').'" target="_blank">Package & Group Updated</a>');   
            $this->session->set_flashdata('success',"Package & Group Updated Successfully.");
            redirect(BASE_URL.'channels/details/'.$id.'/2');
        //}

        /*$channel_info=$this->channels_m->get($id,TRUE);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/details';
        $this->data['page_title'] = "Channel Details";*/
        /* Breadcrumbs */
        /*$this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['channel_detail'] =$this->channels_m->get_by(array('id'=>$id),true);
        $this->data['epgs'] =$this->epg_m->get_by(array('channel_id'=>$id)); 
        $this->data['logs']=$this->logs_m->getLogs(2);
        $this->data['activeTab'] = $tab;
        //channels_groups
        $this->data['groups_channel']=$this->groups_channel_m->get();
        $this->data['channel_groups_ids']=$this->channels_m->get_channels_groups($id);

        //get all packages
        $this->data['packages']=$this->packages_m->get();
        
        //get packages id by channel 
        $this->data['channel_packages']=$this->channels_m->get_packages_by_channel($id);

        //get tokens 
        $this->data['tokens']=$this->channels_m->get_tokens();

        $this->data['channel_info_view'] = $this->load->view( DEFAULT_THEME . 'channels/_channel_info',$this->data, TRUE);
        $this->data['package_group_view'] = $this->load->view( DEFAULT_THEME . 'channels/_package_group',$this->data, TRUE);
        $this->data['advertisement_view'] = $this->load->view( DEFAULT_THEME . 'channels/_advertisement',$this->data, TRUE);
        $this->data['epg_view'] = $this->load->view( DEFAULT_THEME . 'channels/_epg',$this->data, TRUE);
        $this->data['logs_view'] = $this->load->view( DEFAULT_THEME . 'channels/_logs',$this->data, TRUE);
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);*/
    }

    public function updateAds($id,$tab){
        $data = $data = $this->array_from_post(
        array(
            'preroll_enabled',
            'overlay_enabled',
            'preroll_type',
            'ticker_enabled',
            )
        );
    
        $this->channels_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$id.'/3').'" target="_blank">Advertisement Updated</a>');   
        $this->session->set_flashdata('success',"Advertisement Updated Successfully.");
        redirect(BASE_URL.'channels/details/'.$id.'/3');
    }

    public function epgs($channel_id){
        $this->load->model('epg_m');
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'channels/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'channels/epg';
        $this->data['page_title'] = "Channel EPG";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['channel_info'] =$this->channels_m->get_by(array('id'=>$channel_id),true);
        $this->data['epgs'] =$this->epg_m->get_by(array('channel_id'=>$channel_id)); 
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function disable($id){
        check_allow('edit',$this->data['is_allow']);
        $data=array('status'=>0);
        $this->channels_m->save($id,$data);

        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$id.'/1').'" target="_blank">Channel Disabled</a>');   
        $this->session->set_flashdata('success',"Channel Disabled Successfully.");
        redirect(BASE_URL.'channels/details/'.$id.'/1');
    }

    public function enable($id){
        check_allow('edit',$this->data['is_allow']);
        $data=array('status'=>1);
        $this->channels_m->save($id,$data);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('channels/details/'.$id.'/1').'" target="_blank">Channel Enabled</a>');   
        $this->session->set_flashdata('success',"Channel Enabled Updated Successfully.");
        redirect(BASE_URL.'channels/details/'.$id.'/1');
    }

    public function channel_check($channel_number)
    {
        $channel=$this->channels_m->get_by(array('channel_number'=>$channel_number), TRUE);
            
        if($channel){
            $this->form_validation->set_message('channel_check', 'The {field} is already taken.');
            return FALSE;
        }else
            return TRUE;
    }

    public function channel_check_other($channel_number){
        $result=$this->channels_m->check_other_channel_number($channel_number,$this->input->post('id'));
        foreach ($result as $ch) {
            if($ch->channel_number==$channel_number){
                $this->form_validation->set_message('channel_check_other', 'The {field} is already exist.');
                return FALSE;
            } 
        }
        return TRUE;
    }
}
