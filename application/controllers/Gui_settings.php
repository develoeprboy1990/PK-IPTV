<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gui_settings extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(38);
        $this->load->model('gui_settings_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('GUI Settings');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "gui_settings";

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, 'GUI Settings', 'gui_settings');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'gui_settings/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'gui_settings/index';
        $this->data['page_title'] = "GUI Settings";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
        $this->data['settings']= $this->gui_settings_m->get();
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
        $this->load->model('gui_versions_m');
        $this->load->model('ui_themes_m');
        $rules = $this->gui_settings_m->rules;
        $this->form_validation->set_rules($rules);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $this->array_from_post($post);
            $insert_id=$this->gui_settings_m->save(NULL,$data);
           
            //upload files if there is an image 
            if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', '', LOCAL_PATH_IMAGES_CMS, 'gui_settings_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            if(isset($_FILES['background']['name']) && $_FILES['background']['name']!='')
            {
                $filename= $this->upload_image('background','', LOCAL_PATH_IMAGES_CMS, 'gui_settings_m',$insert_id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }   
			 $this->userinterfaceJson($insert_id);
            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('gui_settings/edit/'.$insert_id).'" target="_blank">GUI Settings Added</a>');   
            $this->session->set_flashdata('success',"GUI Settings Added Successfully.");
            redirect(BASE_URL.'gui_settings');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create GUI Settings', 'gui_settings/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        //get gui versions
        $this->data['versions'] =$this->gui_versions_m->get();

        //get gui themes
        $this->data['themes'] =$this->ui_themes_m->get();



		 $template_list = $this->ui_themes_m->get();		
        //get gui themes
        $this->data['themes'] = $template_list;

		
		foreach($template_list as $key=>$val){
			$template['temp_'.$val['id']] = array(
									'id' => $val['id'],
									'name' => $val['name'],
									'img_url' => $val['img_url']
								);
		}
				
        $this->data['themes_temp']= $template;
		
		$this->load->model('user_interface_m');
		/*echo '<pre>';
		print_r($info);
		exit;*/
		//$where = array('template_name'=>$info->ui);
		$this->data['template']= $this->user_interface_m->getAllRows('user_interface','id');
		
		
		
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'gui_settings/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'gui_settings/create';
        $this->data['page_title'] = "Add a GUI Settings";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'Services' ) : '';
        $this->gui_settings_m->delete_menus_by_service($id);
        $this->gui_settings_m->delete($id);
        $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('gui_settings').'" target="_blank">GUI Settings Deleted</a>');   
        $this->session->set_flashdata('success',"GUI Settings Deleted Successfully.");
        redirect( BASE_URL . 'gui_settings' );
    }

    public function edit($id = NULL)
    {   
        check_allow('edit',$this->data['is_allow']);
        $this->load->model('gui_versions_m');
        $this->load->model('ui_themes_m');
        ( $id == NULL ) ? redirect( BASE_URL . 'gui_settings' ) : '';
        $rules = $this->gui_settings_m->rules;
        $this->form_validation->set_rules($rules);
        $info=$this->gui_settings_m->get($id,TRUE);
        $post=array();
        foreach($rules as $key=>$value){
            $post[]=$key;
        }
        if($this->form_validation->run()==TRUE){
            $data = $data = $this->array_from_post($post);
            $this->gui_settings_m->save($id,$data);

             //upload files if there is an image 
            if($_FILES['logo']['name']!='')
            {
                $filename= $this->upload_image('logo', $info->logo, LOCAL_PATH_IMAGES_CMS, 'gui_settings_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            if($_FILES['background']['name']!='')
            {
                $filename= $this->upload_image('background',$info->background, LOCAL_PATH_IMAGES_CMS, 'gui_settings_m',$id);
                $localFilePath = LOCAL_PATH_IMAGES_CMS.$filename;
                $this->uploadToCdnServer($filename,$localFilePath,'images','cms');
            }

            $this->userlogs->track_this($this->session->user_id,'<a href="'.site_url('gui_settings/edit/'.$id).'" target="_blank">GUI Settings Updated</a>');   
            $this->session->set_flashdata('success',"GUI Setting Edited Successfully.");
			
			$this->userinterfaceJson($id);
            redirect(BASE_URL.'gui_settings');
        }
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2,'Edit GUI Setting', 'gui_settings/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        //get gui versions
        $this->data['versions'] =$this->gui_versions_m->get();
		
        $template_list = $this->ui_themes_m->get();		
        //get gui themes
        $this->data['themes'] = $template_list;

		
		foreach($template_list as $key=>$val){
			$template['temp_'.$val['id']] = array(
									'id' => $val['id'],
									'name' => $val['name'],
									'img_url' => $val['img_url']
								);
		}
				
        $this->data['themes_temp']= $template;
		
		$this->load->model('user_interface_m');
		/*echo '<pre>';
		print_r($info);
		exit;*/
		$where = array('template_name'=>$info->ui);
		$this->data['template']= $this->user_interface_m->selectdatarow($where,'user_interface');
		
        $this->data['details'] = $info;
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'gui_settings/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'gui_settings/edit';
        $this->data['page_title'] = "Edit a GUI Setting";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);  
    }
	
	public function templateselect(){
		$theme_id = $_REQUEST['theme_id'];
		$this->load->model('user_interface_m');
		$where = array('template_name'=>$theme_id);
		$template = $this->user_interface_m->selectdatarow($where,'user_interface');
	/*	echo '<pre>';
		print_r($selected_ui);*/
			echo '<option value="">Select UI</option>';
		foreach($template as $key=>$val){
            echo '<option value="'.$val['id'].'">'.$val['ui_name'].'</option>';
        }
	}
	
	public function userinterfaceJson($id){
		$this->load->model('user_interface_m');
		$where = array('id'=>$id);
		$gui_settings_details = $this->user_interface_m->selectdatarow($where,'gui_settings');
		/*echo '<pre>';
		print_r($gui_settings_details);exit;*/
		$template_where = array('id'=>$gui_settings_details[0]['ui_template']);
		$template = $this->user_interface_m->selectdatarow($template_where,'user_interface');
		
		
		$userinterface_array = array(
							'general' => array(
												'enable_messages_menu' => $template[0]['enable_messages_menu']== 1 ? true : false,
												'enable_settings_menu' => $template[0]['enable_settings_menu']== 1 ? true : false,										
												'enable_watchlist_menu' => $template[0]['enable_watchlist_menu']== 1 ? true : false,										
												'enable_search_menu' => $template[0]['enable_search_menu']== 1 ? true : false,											
												'enable_favourites_menu' => $template[0]['enable_favourites_menu']== 1 ? true : false,									
												'enable_sharing' => false,											
												'enable_weather' => $template[0]['enable_weather']== 1 ? true : false,										
												'enable_large_fonts' =>  $template[0]['enable_large_fonts']== 1 ? true : false,										
												'enable_kids_mode_profile' =>  $template[0]['enable_kids_mode_profile']== 1 ? true : false,										
												'enable_profiles' =>  $template[0]['enable_profiles']== 1 ? true : false,											
												'enable_clock' =>  $template[0]['enable_clock']== 1 ? true : false,											
												'enable_recordings' =>  $template[0]['enable_recordings']== 1 ? true : false,										
												'enable_catchuptv' =>  $template[0]['enable_catchuptv']== 1 ? true : false,											
												'clock_format' =>  $template[0]['clock_format'],											
												'sleep_mode_setting' =>  (int)$template[0]['sleep_mode_setting'],											
												'catchup_days' =>  (int)$template[0]['catchup_days'],											
												'epg_days' =>  (int)$template[0]['epg_days'],											
												'start_screen' =>  ucwords( $template[0]['start_screen'])
											   ),
							'home' => array(
											 'enable_hero_images' => $template[0]['enable_messages_menu']== 1 ? true : false,
											 'enable_news_section' => $template[0]['enable_news_section']== 1 ? true : false,
											 'enable_ads' => $template[0]['enable_ads']== 1 ? true : false,
											 'enable_tv_preview' => $template[0]['enable_tv_preview']== 1 ? true : false
											),
							'channel' => array(
											 'show_channel_preview' => $template[0]['show_channel_preview']== 1 ? true : false,
											 'enable_toggle_channels' => $template[0]['enable_toggle_channels']== 1 ? true : false,
											 'enable_sorting_channels' => $template[0]['enable_sorting_channels']== 1 ? true : false,
											 'toggle_default_settings' => $template[0]['toggle_default_settings']=="user_defined" ? "User Defined":"User Defined",		
											),
							'tv_guide' => array(
											 'show_epg_preview' => $template[0]['show_epg_preview']== 1 ? true : false,
											 'enable_epg_search' => $template[0]['enable_epg_search']== 1 ? true : false,
											 'enable_tv_preview_screen' => $template[0]['enable_tv_preview_screen']	== 1 ? true : false										 
											),
							'player' => array(
											 'enable_mini_epg' => $template[0]['enable_mini_epg']== 1 ? true : false,
											 'enable_channel_menu' => $template[0]['enable_channel_menu']== 1 ? true : false,
											 'enable_catchup_buttons' => $template[0]['enable_catchup_buttons']== 1 ? true : false,											 
											 'enable_casting' => $template[0]['enable_casting']== 1 ? true : false,											 
											 'enable_problem_report' => $template[0]['enable_problem_report']== 1 ? true : false,											 
											 'enable_quadview' => $template[0]['enable_quadview']== 1 ? true : false,											 
											 'enable_watermarking' => $template[0]['enable_watermarking']== 1 ? true : false,										 
											 'enable_player_menu' => false,											 
											 'default_audio_language' => $template[0]['default_audio_language']=="user_defined"? "User Defined":"User Defined",											 
											 'default_subtitle_language' => $template[0]['default_subtitle_language']=="user_defined"? "User Defined":"User Defined",													 
											 'default_screen_mode' => $template[0]['default_screen_mode']=="user_defined"? "User Defined":"User Defined",												 
											 'player_type' => $template[0]['player_type']==full_player?"Full Player (default)":"user_defined"
											),
							'app_state_change' => array(
											 'restart_app' => $template[0]['restart_app']== 1 ? true : false,
											 'restart_stream' => $template[0]['restart_stream']== 1 ? true : false										 
											),
							'authentication' => array(
											 'lock_device_to_ip_address' => $template[0]['lock_device_to_ip_address']== 1 ? true : false								 
											),
							'series' => array(
											 'enable_episodes_full_metadata' => $template[0]['enable_episodes_full_metadata']	== 1 ? true : false									 
											)
							
					);
		$contact_array = array(
									'qrcode' => $gui_settings_details[0]['qrcode'],
									'text' => htmlentities($gui_settings_details[0]['text_ui']),
									'logo' => $gui_settings_details[0]['logo'],
									'background' => $gui_settings_details[0]['background'],
									'selection_color' => $gui_settings_details[0]['primary_color']
								);
		$account_array = array(
								'use_register' => false,
								'use_trial' => false,
								'use_renew_by_key' => false,
								'product_trial_id' => 0,
								'disclaimer' => null,
								'is_show_disclaimer' => false
								);
		$languages_array = array(
									array('language' => 'English' ),
									array('language' => 'Hindi')
								);
		$style_array = array(
								'image_location' => CDN_LOCATION_FOR_IMAGE,
								'content_api_location' => rtrim( ltrim (LOCAL_PATH_CMS, "./"), "/"),
								'product_api_location' => rtrim( ltrim (LOCAL_PATH_CRM, "./"), "/"),
								'web_api_location' => "https://".SITE_IMS_HOST."/api",
								'news_image_location' => rtrim( ltrim (LOCAL_PATH_CRM, "./"), "/"),
								'font' => 'Arial',
          						'background' => $gui_settings_details[0]['background'],
								'logo' => $gui_settings_details[0]['logo'],
								'highlight' => array('primary'=>$gui_settings_details[0]['primary_color'],
                                                     'secondary'=>$gui_settings_details[0]['secondary_color'])
        );
		$purchase_array = array(
									'google' => array(
														'client_email' => '',
														'private_key' => '',
														'public_key_path' => '',
														'public_key_str_sandbox' => '',
														'public_key_str_live' => '',
														'access_token' => '',
														'ref_token' => '',
														'client_id' => '',
														'client_secret' => ''
									
													),
									'apple' => array(
														'exclude_old_transactions' => false,
														'password' => ''
									
													),
									'amazon' => array(
														'api_version' => '',
														'secret' => '',
														'validation_host' => ''
													)
								);
								
		$json_array = array(
								'client' => IMS_CLIENT,
								'brandname' => $gui_settings_details[0]['brandname'],
								'supportinfo' => null,
								'contact' => $contact_array,
								'cms' => CMS,
								'crm' => CRM,
								'account' => $account_array,
								'sleepmode' => (int)$gui_settings_details[0]['sleep_mode'],
								'default_language' => 'English',
								'languages' => $languages_array,
								'style' => $style_array,
								'userinterface' => $userinterface_array,
								'purchase' => $purchase_array
							);
					
		
			$filename = 'settings.json';
			$localdirectory = IMS_CLIENT.'/userinterfaces/'.$gui_settings_details[0]['base_start_url'].'_'.md5($id).'/settings/';
			$localFilePath =  $localdirectory. $filename;
			/* Encryption */
			$return_array = json_encode(json_encode($json_array, JSON_UNESCAPED_SLASHES),JSON_UNESCAPED_SLASHES);
			
			if(!is_dir($localdirectory)){
    			/* Directory does not exist, so lets create it. */
           			mkdir($localdirectory, 0777, true);
             }

			$fp = fopen($localFilePath, 'w');
			fwrite($fp, $return_array);
			fclose($fp);

			//$image_directory_logo = 'xtv_client/userinterfaces/images/'.md5($id).'/logo/';
			$image_directory_logo =  IMS_CLIENT.'/userinterfaces/'.$gui_settings_details[0]['base_start_url'].'_'.md5($id).'/artwork/';
			if(!is_dir($image_directory_logo)){    			
           		mkdir($image_directory_logo, 0777, true);
             }
			 
			//$image_directory_background = 'xtv_client/userinterfaces/images/'.md5($id).'/background/';
			$image_directory_background =  IMS_CLIENT.'/userinterfaces/'.$gui_settings_details[0]['base_start_url'].'_'.md5($id).'/artwork/';
			if(!is_dir($image_directory_background)){    			
           		mkdir($image_directory_background, 0777, true);
             }
			 
			//For logo Image
			$filedestination_logo = $image_directory_logo;
			$this->uploadjsonimages(LOCAL_PATH_IMAGES_CMS,$filedestination_logo,$gui_settings_details[0]['logo']);
			
			// For Background Image
			$filedestination_background = $image_directory_background;
			$this->uploadjsonimages(LOCAL_PATH_IMAGES_CMS,$filedestination_background,$gui_settings_details[0]['background']);			
			
	}
	
	public function uploadjsonimages($filesource,$filedestination,$filename){
		$file = $filesource.$filename;
		// Open the file to get existing content
		$data = file_get_contents($file);		
		// New file
		$new = $filedestination.$filename;		
		// Write the contents back to a new file
		file_put_contents($new, $data);
	}
}