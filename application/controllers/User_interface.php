<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_interface extends User_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['is_allow']= check_permission(37);
        $this->load->model('user_interface_m');
        $this->load->library('breadcrumbs');
        $this->load->library('page_title');
        /* Title Page :: Common */
        $this->page_title->push('User Interface');
        $this->data['page_title'] = $this->page_title->show();

        $this->data['main_nav'] = "products";
        $this->data['sub_nav'] = "user_interface";

        /* Breadcrumbs :: Common */
       // $this->breadcrumbs->unshift(1, 'GUI Versions', 'gui_versions');
    }

	public function index()
	{
        check_allow('view',$this->data['is_allow']);
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'user_interface/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'user_interface/index';
        $this->data['page_title'] = "User Interface";
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        /* advertisements */
		
		$template_list = $this->user_interface_m->getAllRows('ui_themes','id');		
		foreach($template_list as $key=>$val){
			$template['temp_'.$val['id']] = array(
									'id' => $val['id'],
									'name' => $val['name'],
									'img_url' => $val['img_url']
								);
		}
				
        $this->data['template']= $template;
		
        $this->data['versions']= $this->user_interface_m->getAllRows('user_interface','id');
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);
    }

    public function create(){
        check_allow('create',$this->data['is_allow']);
		
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('ui_name', 'UI Name', 'trim|required|callback_name_unique');	
		$this->form_validation->set_rules('template_name', 'Template name', 'required');
		/*$this->form_validation->set_rules('youtube_api_key', 'Youtube Key', 'trim|required');
		$this->form_validation->set_rules('brandname', 'Brandname', 'trim|required');
		$this->form_validation->set_rules('contactinformation', 'Contact Information', 'trim|required');
		$this->form_validation->set_rules('dir', 'Dir', 'trim|required');
		$this->form_validation->set_rules('qrcode', 'QR Code', 'trim|required');
		$this->form_validation->set_rules('name_text', 'Text', 'trim|required');*/
		
		$this->data['message'] = '';
		if(isset($_REQUEST['add_user_interface'])){
			$ui_name = $this->toAlphaNumeric($this->input->post('ui_name'));
			$template_name = $this->input->post('template_name');
			$restart_app = $this->input->post('restart_app');
			$restart_stream = $this->input->post('restart_stream');			
			$lock_device_to_ip_address = $this->input->post('lock_device_to_ip_address');			
			$enable_sorting_channels = $this->input->post('enable_sorting_channels');			
			$enable_toggle_channels = $this->input->post('enable_toggle_channels');			
			$show_channel_preview = $this->input->post('show_channel_preview');					
			$toggle_default_settings = $this->input->post('toggle_default_settings');			
			$catchup_days = $this->input->post('catchup_days');			
			$clock_format = $this->input->post('clock_format');			
			$enable_catchuptv = $this->input->post('enable_catchuptv');			
			$enable_clock = $this->input->post('enable_clock');			
			$enable_favourites_menu = $this->input->post('enable_favourites_menu');			
			$enable_kids_mode_profile = $this->input->post('enable_kids_mode_profile');			
			$enable_large_fonts = $this->input->post('enable_large_fonts');			
			$enable_messages_menu = $this->input->post('enable_messages_menu');			
			$enable_profiles = $this->input->post('enable_profiles');			
			$enable_recordings = $this->input->post('enable_recordings');			
			$enable_search_menu = $this->input->post('enable_search_menu');			
			$enable_settings_menu = $this->input->post('enable_settings_menu');			
			$enable_watchlist_menu = $this->input->post('enable_watchlist_menu');			
			$enable_weather = $this->input->post('enable_weather');			
			$enable_ads = $this->input->post('enable_ads');						
			$enable_hero_images = $this->input->post('enable_hero_images');						
			$enable_news_section = $this->input->post('enable_news_section');						
			$enable_tv_preview = $this->input->post('enable_tv_preview');					
			$default_audio_language = $this->input->post('default_audio_language');						
			$default_screen_mode = $this->input->post('default_screen_mode');			
			$default_subtitle_language = $this->input->post('default_subtitle_language');			
			$enable_casting = $this->input->post('enable_casting');					
			$enable_catchup_buttons = $this->input->post('enable_catchup_buttons');									
			$enable_channel_menu = $this->input->post('enable_channel_menu');					
			$enable_mini_epg = $this->input->post('enable_mini_epg');			
			$enable_problem_report = $this->input->post('enable_problem_report');								
			$player_type = $this->input->post('player_type');									
			$enable_episodes_full_metadata = $this->input->post('enable_episodes_full_metadata');						
			$enable_epg_search = $this->input->post('enable_epg_search');			
			$enable_tv_preview_screen = $this->input->post('enable_tv_preview_screen');								
			$show_epg_preview = $this->input->post('show_epg_preview');						
			$enable_mini_epg = $this->input->post('enable_mini_epg');	
			$enable_quadview = $this->input->post('enable_quadview');
			$enable_watermarking = $this->input->post('enable_watermarking');
			
			$epg_days = $this->input->post('epg_days');	
			$sleep_mode_setting = $this->input->post('sleep_mode_setting');
			$start_screen = $this->input->post('start_screen');
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['template_name'] = $template_name;
				$this->data['restart_app'] = $restart_app;				
				$this->data['restart_stream'] = $restart_stream;				
				$this->data['lock_device_to_ip_address'] = $lock_device_to_ip_address;				
				$this->data['enable_sorting_channels'] = $enable_sorting_channels;				
				$this->data['enable_toggle_channels'] = $enable_toggle_channels;				
				$this->data['show_channel_preview'] = $show_channel_preview;								
				$this->data['toggle_default_settings'] = $toggle_default_settings;				
				$this->data['catchup_days'] = $catchup_days;				
				$this->data['clock_format'] = $clock_format;				
				$this->data['enable_catchuptv'] = $enable_catchuptv;				
				$this->data['enable_clock'] = $enable_clock;				
				$this->data['enable_favourites_menu'] = $enable_favourites_menu;				
				$this->data['enable_kids_mode_profile'] = $enable_kids_mode_profile;				
				$this->data['enable_large_fonts'] = $enable_large_fonts;							
				$this->data['enable_messages_menu'] = $enable_messages_menu;							
				$this->data['enable_profiles'] = $enable_profiles;								
				$this->data['enable_recordings'] = $enable_recordings;							
				$this->data['enable_search_menu'] = $enable_search_menu;								
				$this->data['enable_settings_menu'] = $enable_settings_menu;							
				$this->data['enable_watchlist_menu'] = $enable_watchlist_menu;								
				$this->data['enable_weather'] = $enable_weather;							
				$this->data['enable_ads'] = $enable_ads;							
				$this->data['enable_hero_images'] = $enable_hero_images;								
				$this->data['enable_news_section'] = $enable_news_section;								
				$this->data['enable_tv_preview'] = $enable_tv_preview;							
				$this->data['default_audio_language'] = $default_audio_language;								
				$this->data['default_screen_mode'] = $default_screen_mode;				
				$this->data['default_subtitle_language'] = $default_subtitle_language;				
				$this->data['enable_casting'] = $enable_casting;								
				$this->data['enable_catchup_buttons'] = $enable_catchup_buttons;							
				$this->data['enable_channel_menu'] = $enable_channel_menu;				
				$this->data['enable_mini_epg'] = $enable_mini_epg;												
				$this->data['enable_problem_report'] = $enable_problem_report;							
				$this->data['player_type'] = $player_type;				
				$this->data['enable_episodes_full_metadata'] = $enable_episodes_full_metadata;												
				$this->data['enable_epg_search'] = $enable_epg_search;								
				$this->data['enable_tv_preview_screen'] = $enable_tv_preview_screen;				
				$this->data['show_epg_preview'] = $show_epg_preview;
				$this->data['enable_mini_epg'] = $enable_mini_epg;									
				$this->data['enable_quadview'] = $enable_quadview;
				$this->data['enable_watermarking'] = $enable_watermarking;	
				
				$this->data['epg_days'] = $epg_days;									
				$this->data['sleep_mode_setting'] = $sleep_mode_setting;
				$this->data['start_screen'] = $start_screen;	
				$this->data['ui_name'] = $ui_name;				
				
			}else{
				$data = array('template_name'=>$template_name,
								'restart_app' => $restart_app,
								'restart_stream' => $restart_stream,								
								'lock_device_to_ip_address' => $lock_device_to_ip_address,								
								'enable_sorting_channels' => $enable_sorting_channels,								
								'enable_toggle_channels' => $enable_toggle_channels,								
								'show_channel_preview' => $show_channel_preview,								
								'toggle_default_settings' => $toggle_default_settings,								
								'catchup_days' => $catchup_days,								
								'clock_format' => $clock_format,								
								'enable_catchuptv' => $enable_catchuptv,								
								'enable_clock' => $enable_clock,								
								'enable_favourites_menu' => $enable_favourites_menu,								
								'enable_kids_mode_profile' => $enable_kids_mode_profile,								
								'enable_large_fonts' => $enable_large_fonts,								
								'enable_messages_menu' => $enable_messages_menu,								
								'enable_profiles' => $enable_profiles,								
								'enable_recordings' => $enable_recordings,								
								'enable_search_menu' => $enable_search_menu,								
								'enable_settings_menu' => $enable_settings_menu,								
								'enable_watchlist_menu' => $enable_watchlist_menu,								
								'enable_weather' => $enable_weather,								
								'enable_ads' => $enable_ads,								
								'enable_hero_images' => $enable_hero_images,								
								'enable_news_section' => $enable_news_section,								
								'enable_tv_preview' => $enable_tv_preview,								
								'default_audio_language' => $default_audio_language,								
								'default_screen_mode' => $default_screen_mode,								
								'default_subtitle_language' => $default_subtitle_language,								
								'enable_casting' => $enable_casting,								
								'enable_catchup_buttons' => $enable_catchup_buttons,																
								'enable_channel_menu' => $enable_channel_menu,								
								'enable_mini_epg' => $enable_mini_epg,																
								'enable_problem_report' => $enable_problem_report,																
								'player_type' => $player_type,								
								'enable_episodes_full_metadata' => $enable_episodes_full_metadata,																
								'enable_epg_search' => $enable_epg_search,															
								'enable_tv_preview_screen' => $enable_tv_preview_screen,								
								'show_epg_preview' => $show_epg_preview,
								'enable_mini_epg' => $enable_mini_epg,
								'enable_quadview' => $enable_quadview,
								'enable_watermarking' => $enable_watermarking,								
								'epg_days' => $epg_days,
								'sleep_mode_setting' => $sleep_mode_setting,
								'start_screen' => $start_screen,
								'ui_name' => $ui_name							
								);
								/*echo '<pre>';
								print_r($data);EXIT;*/
								$insert_id = $this->user_interface_m->insertRow($data, 'user_interface');							
								
			
								redirect(BASE_URL.'user_interface');
			}
			
			
		} else{
		
			$this->data['template_name'] ='';
			$this->data['restart_app'] = '';
			$this->data['restart_stream'] = '';				
			$this->data['lock_device_to_ip_address'] = '';
			$this->data['enable_sorting_channels'] = '';
			$this->data['enable_toggle_channels'] = '';
			$this->data['show_channel_preview'] = '';
			$this->data['toggle_default_settings'] = '';
			$this->data['catchup_days'] = '';
			$this->data['clock_format'] = '';
			$this->data['enable_catchuptv'] = '';
			$this->data['enable_clock'] = '';
			$this->data['enable_favourites_menu'] = '';
			$this->data['enable_kids_mode_profile'] = '';
			$this->data['enable_large_fonts'] = '';	
			$this->data['enable_messages_menu'] = '';
			$this->data['enable_profiles'] = '';
			$this->data['enable_recordings'] = '';
			$this->data['enable_search_menu'] = '';
			$this->data['enable_settings_menu'] = '';
			$this->data['enable_watchlist_menu'] = '';
			$this->data['enable_ads'] = '';
			$this->data['enable_hero_images'] = '';
			$this->data['enable_news_section'] = '';
			$this->data['enable_tv_preview'] = '';
			$this->data['default_audio_language'] = '';	
			$this->data['default_screen_mode'] = '';
			$this->data['default_subtitle_language'] = '';			
			$this->data['enable_casting'] = '';	
			$this->data['enable_catchup_buttons'] = '';			
			$this->data['enable_channel_menu'] = '';			
			$this->data['enable_mini_epg'] = '';				
			$this->data['enable_problem_report'] = '';			
			$this->data['player_type'] = '';			
			$this->data['enable_episodes_full_metadata'] = '';				
			$this->data['enable_epg_search'] = '';			
			$this->data['enable_tv_preview_screen'] = '';			
			$this->data['show_epg_preview'] = '';
			$this->data['enable_mini_epg'] = '';
			$this->data['enable_quadview'] = '';
			$this->data['enable_watermarking'] = '';		
			$this->data['enable_weather'] = '';	
			
			$this->data['epg_days'] = '';	
			$this->data['sleep_mode_setting'] = '';	
			$this->data['start_screen'] = '';	
			$this->data['ui_name'] = '';			
		}
      
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create GUI Version', 'user_interface/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
		$this->data['themes'] =$this->user_interface_m->getAllRows('ui_themes','id');
		 
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'user_interface/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'user_interface/create';
        $this->data['page_title'] = "Add a User Interface";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);		
    }

	public function edit($id){
        check_allow('create',$this->data['is_allow']);
		$where = array('id'=>$id);
		$interface_data = $this->user_interface_m->selectdatarow($where, 'user_interface');
		$this->data['id'] = $id;
		
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('ui_name', 'UI Name', 'trim|required|callback_name_unique');		
		$this->form_validation->set_rules('template_name', 'Template name', 'required');
		/*$this->form_validation->set_rules('youtube_api_key', 'Youtube Key', 'trim|required');
		$this->form_validation->set_rules('brandname', 'Brandname', 'trim|required');
		$this->form_validation->set_rules('contactinformation', 'Contact Information', 'trim|required');
		$this->form_validation->set_rules('dir', 'Dir', 'trim|required');
		$this->form_validation->set_rules('qrcode', 'QR Code', 'trim|required');
		$this->form_validation->set_rules('name_text', 'Text', 'trim|required');*/
		
		$this->data['message'] = '';
		if(isset($_REQUEST['add_user_interface'])){
			$template_name = $this->input->post('template_name');
			$restart_app = $this->input->post('restart_app');
			$restart_stream = $this->input->post('restart_stream');			
			$lock_device_to_ip_address = $this->input->post('lock_device_to_ip_address');			
			$enable_sorting_channels = $this->input->post('enable_sorting_channels');			
			$enable_toggle_channels = $this->input->post('enable_toggle_channels');			
			$show_channel_preview = $this->input->post('show_channel_preview');					
			$toggle_default_settings = $this->input->post('toggle_default_settings');			
			$catchup_days = $this->input->post('catchup_days');			
			$clock_format = $this->input->post('clock_format');			
			$enable_catchuptv = $this->input->post('enable_catchuptv');			
			$enable_clock = $this->input->post('enable_clock');			
			$enable_favourites_menu = $this->input->post('enable_favourites_menu');			
			$enable_kids_mode_profile = $this->input->post('enable_kids_mode_profile');			
			$enable_large_fonts = $this->input->post('enable_large_fonts');			
			$enable_messages_menu = $this->input->post('enable_messages_menu');			
			$enable_profiles = $this->input->post('enable_profiles');			
			$enable_recordings = $this->input->post('enable_recordings');			
			$enable_search_menu = $this->input->post('enable_search_menu');			
			$enable_settings_menu = $this->input->post('enable_settings_menu');			
			$enable_watchlist_menu = $this->input->post('enable_watchlist_menu');			
			$enable_weather = $this->input->post('enable_weather');			
			$enable_ads = $this->input->post('enable_ads');						
			$enable_hero_images = $this->input->post('enable_hero_images');						
			$enable_news_section = $this->input->post('enable_news_section');						
			$enable_tv_preview = $this->input->post('enable_tv_preview');					
			$default_audio_language = $this->input->post('default_audio_language');						
			$default_screen_mode = $this->input->post('default_screen_mode');			
			$default_subtitle_language = $this->input->post('default_subtitle_language');			
			$enable_casting = $this->input->post('enable_casting');					
			$enable_catchup_buttons = $this->input->post('enable_catchup_buttons');									
			$enable_channel_menu = $this->input->post('enable_channel_menu');					
			$enable_mini_epg = $this->input->post('enable_mini_epg');			
			$enable_problem_report = $this->input->post('enable_problem_report');								
			$player_type = $this->input->post('player_type');									
			$enable_episodes_full_metadata = $this->input->post('enable_episodes_full_metadata');						
			$enable_epg_search = $this->input->post('enable_epg_search');			
			$enable_tv_preview_screen = $this->input->post('enable_tv_preview_screen');								
			$show_epg_preview = $this->input->post('show_epg_preview');						
			$enable_mini_epg = $this->input->post('enable_mini_epg');	
			$enable_quadview = $this->input->post('enable_quadview');
			$enable_watermarking = $this->input->post('enable_watermarking');
			
			$epg_days = $this->input->post('epg_days');	
			$sleep_mode_setting = $this->input->post('sleep_mode_setting');
			$start_screen = $this->input->post('start_screen');
			$ui_name = $this->toAlphaNumeric($this->input->post('ui_name'));
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['template_name'] = $template_name;
				$this->data['restart_app'] = $restart_app;				
				$this->data['restart_stream'] = $restart_stream;				
				$this->data['lock_device_to_ip_address'] = $lock_device_to_ip_address;				
				$this->data['enable_sorting_channels'] = $enable_sorting_channels;				
				$this->data['enable_toggle_channels'] = $enable_toggle_channels;				
				$this->data['show_channel_preview'] = $show_channel_preview;								
				$this->data['toggle_default_settings'] = $toggle_default_settings;				
				$this->data['catchup_days'] = $catchup_days;				
				$this->data['clock_format'] = $clock_format;				
				$this->data['enable_catchuptv'] = $enable_catchuptv;				
				$this->data['enable_clock'] = $enable_clock;				
				$this->data['enable_favourites_menu'] = $enable_favourites_menu;				
				$this->data['enable_kids_mode_profile'] = $enable_kids_mode_profile;				
				$this->data['enable_large_fonts'] = $enable_large_fonts;							
				$this->data['enable_messages_menu'] = $enable_messages_menu;							
				$this->data['enable_profiles'] = $enable_profiles;								
				$this->data['enable_recordings'] = $enable_recordings;							
				$this->data['enable_search_menu'] = $enable_search_menu;								
				$this->data['enable_settings_menu'] = $enable_settings_menu;							
				$this->data['enable_watchlist_menu'] = $enable_watchlist_menu;								
				$this->data['enable_weather'] = $enable_weather;							
				$this->data['enable_ads'] = $enable_ads;							
				$this->data['enable_hero_images'] = $enable_hero_images;								
				$this->data['enable_news_section'] = $enable_news_section;								
				$this->data['enable_tv_preview'] = $enable_tv_preview;							
				$this->data['default_audio_language'] = $default_audio_language;								
				$this->data['default_screen_mode'] = $default_screen_mode;				
				$this->data['default_subtitle_language'] = $default_subtitle_language;				
				$this->data['enable_casting'] = $enable_casting;								
				$this->data['enable_catchup_buttons'] = $enable_catchup_buttons;							
				$this->data['enable_channel_menu'] = $enable_channel_menu;				
				$this->data['enable_mini_epg'] = $enable_mini_epg;												
				$this->data['enable_problem_report'] = $enable_problem_report;							
				$this->data['player_type'] = $player_type;				
				$this->data['enable_episodes_full_metadata'] = $enable_episodes_full_metadata;												
				$this->data['enable_epg_search'] = $enable_epg_search;								
				$this->data['enable_tv_preview_screen'] = $enable_tv_preview_screen;				
				$this->data['show_epg_preview'] = $show_epg_preview;
				$this->data['enable_mini_epg'] = $enable_mini_epg;									
				$this->data['enable_quadview'] = $enable_quadview;
				$this->data['enable_watermarking'] = $enable_watermarking;	
				
				$this->data['epg_days'] = $epg_days;									
				$this->data['sleep_mode_setting'] = $sleep_mode_setting;
				$this->data['start_screen'] = $start_screen;
				$this->data['ui_name'] = $ui_name;					
				
			}else{
				$data = array('template_name'=>$template_name,
								'restart_app' => $restart_app,
								'restart_stream' => $restart_stream,								
								'lock_device_to_ip_address' => $lock_device_to_ip_address,								
								'enable_sorting_channels' => $enable_sorting_channels,								
								'enable_toggle_channels' => $enable_toggle_channels,								
								'show_channel_preview' => $show_channel_preview,								
								'toggle_default_settings' => $toggle_default_settings,								
								'catchup_days' => $catchup_days,								
								'clock_format' => $clock_format,								
								'enable_catchuptv' => $enable_catchuptv,								
								'enable_clock' => $enable_clock,								
								'enable_favourites_menu' => $enable_favourites_menu,								
								'enable_kids_mode_profile' => $enable_kids_mode_profile,								
								'enable_large_fonts' => $enable_large_fonts,								
								'enable_messages_menu' => $enable_messages_menu,								
								'enable_profiles' => $enable_profiles,								
								'enable_recordings' => $enable_recordings,								
								'enable_search_menu' => $enable_search_menu,								
								'enable_settings_menu' => $enable_settings_menu,								
								'enable_watchlist_menu' => $enable_watchlist_menu,								
								'enable_weather' => $enable_weather,								
								'enable_ads' => $enable_ads,								
								'enable_hero_images' => $enable_hero_images,								
								'enable_news_section' => $enable_news_section,								
								'enable_tv_preview' => $enable_tv_preview,								
								'default_audio_language' => $default_audio_language,								
								'default_screen_mode' => $default_screen_mode,								
								'default_subtitle_language' => $default_subtitle_language,								
								'enable_casting' => $enable_casting,								
								'enable_catchup_buttons' => $enable_catchup_buttons,																
								'enable_channel_menu' => $enable_channel_menu,								
								'enable_mini_epg' => $enable_mini_epg,																
								'enable_problem_report' => $enable_problem_report,																
								'player_type' => $player_type,								
								'enable_episodes_full_metadata' => $enable_episodes_full_metadata,																
								'enable_epg_search' => $enable_epg_search,															
								'enable_tv_preview_screen' => $enable_tv_preview_screen,								
								'show_epg_preview' => $show_epg_preview,
								'enable_mini_epg' => $enable_mini_epg,
								'enable_quadview' => $enable_quadview,
								'enable_watermarking' => $enable_watermarking,
								'epg_days' => $epg_days,
								'sleep_mode_setting' => $sleep_mode_setting,
								'start_screen' => $start_screen,
								'ui_name' => $ui_name								
								);
																						
								$this->user_interface_m->update_keycode($data,$where,'user_interface');
								redirect(BASE_URL.'user_interface');
			}
			
			
		} else{
		
			$this->data['template_name'] = $interface_data[0]['template_name'];
			$this->data['restart_app'] = $interface_data[0]['restart_app'];
			$this->data['restart_stream'] = $interface_data[0]['restart_stream'];			
			$this->data['lock_device_to_ip_address'] = $interface_data[0]['lock_device_to_ip_address'];
			$this->data['enable_sorting_channels'] = $interface_data[0]['enable_sorting_channels'];
			$this->data['enable_toggle_channels'] = $interface_data[0]['enable_toggle_channels'];
			$this->data['show_channel_preview'] = $interface_data[0]['show_channel_preview'];
			$this->data['toggle_default_settings'] = $interface_data[0]['toggle_default_settings'];
			$this->data['catchup_days'] = $interface_data[0]['catchup_days'];
			$this->data['clock_format'] = $interface_data[0]['clock_format'];
			$this->data['enable_catchuptv'] = $interface_data[0]['enable_catchuptv'];
			$this->data['enable_clock'] = $interface_data[0]['enable_clock'];
			$this->data['enable_favourites_menu'] = $interface_data[0]['enable_favourites_menu'];
			$this->data['enable_kids_mode_profile'] = $interface_data[0]['enable_kids_mode_profile'];
			$this->data['enable_large_fonts'] = $interface_data[0]['enable_large_fonts'];	
			$this->data['enable_messages_menu'] = $interface_data[0]['enable_messages_menu'];
			$this->data['enable_profiles'] = $interface_data[0]['enable_profiles'];
			$this->data['enable_recordings'] = $interface_data[0]['enable_recordings'];			
			$this->data['enable_search_menu'] = $interface_data[0]['enable_search_menu'];
			$this->data['enable_settings_menu'] = $interface_data[0]['enable_settings_menu'];
			$this->data['enable_watchlist_menu'] = $interface_data[0]['enable_watchlist_menu'];
			$this->data['enable_ads'] = $interface_data[0]['enable_ads'];
			$this->data['enable_hero_images'] = $interface_data[0]['enable_hero_images'];
			$this->data['enable_news_section'] = $interface_data[0]['enable_news_section'];			
			$this->data['enable_tv_preview'] = $interface_data[0]['enable_tv_preview'];
			$this->data['default_audio_language'] = $interface_data[0]['default_audio_language'];
			$this->data['default_screen_mode'] = $interface_data[0]['default_screen_mode'];
			$this->data['default_subtitle_language'] = $interface_data[0]['default_subtitle_language'];		
			$this->data['enable_casting'] = $interface_data[0]['enable_casting'];			
			$this->data['enable_catchup_buttons'] = $interface_data[0]['enable_catchup_buttons'];		
			$this->data['enable_channel_menu'] = $interface_data[0]['enable_channel_menu'];			
			$this->data['enable_mini_epg'] = $interface_data[0]['enable_mini_epg'];							
			$this->data['enable_problem_report'] = $interface_data[0]['enable_problem_report'];			
			$this->data['player_type'] = $interface_data[0]['player_type'];			
			$this->data['enable_episodes_full_metadata'] = $interface_data[0]['enable_episodes_full_metadata'];				
			$this->data['enable_epg_search'] = $interface_data[0]['enable_epg_search'];			
			$this->data['enable_tv_preview_screen'] = $interface_data[0]['enable_tv_preview_screen'];			
			$this->data['show_epg_preview'] = $interface_data[0]['show_epg_preview'];
			$this->data['enable_mini_epg'] = $interface_data[0]['enable_mini_epg'];
			$this->data['enable_quadview'] = $interface_data[0]['enable_quadview'];
			$this->data['enable_watermarking'] = $interface_data[0]['enable_watermarking'];	
			$this->data['enable_weather'] = $interface_data[0]['enable_weather'];
			
			$this->data['epg_days'] = $interface_data[0]['epg_days'];
			$this->data['sleep_mode_setting'] = $interface_data[0]['sleep_mode_setting'];
			$this->data['start_screen'] = $interface_data[0]['start_screen'];			
			$this->data['ui_name'] = $interface_data[0]['ui_name'];			
		}
      
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create GUI Version', 'user_interface/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
		
        $this->data['themes'] =$this->user_interface_m->getAllRows('ui_themes','id');
		
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'user_interface/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'user_interface/edit';
        $this->data['page_title'] = "Add a User Interface";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);		
    }
	
	 public function editXXX($id){
        check_allow('create',$this->data['is_allow']);
		
		$where = array('id'=>$id);
		$interface_data = $this->user_interface_m->selectdatarow($where, 'user_interface');
		$this->data['id'] = $id;
		/*echo '<pre>';
		print_r($interface_data);exit;*/
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('interface_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('youtube_api_key', 'Youtube Key', 'trim|required');
		$this->form_validation->set_rules('brandname', 'Brandname', 'trim|required');
		$this->form_validation->set_rules('contactinformation', 'Contact Information', 'trim|required');
		$this->form_validation->set_rules('dir', 'Dir', 'trim|required');
		$this->form_validation->set_rules('qrcode', 'QR Code', 'trim|required');
		$this->form_validation->set_rules('name_text', 'Text', 'trim|required');
		
		$this->data['message'] = '';
		if(isset($_REQUEST['add_user_interface'])){
			$interface_name = $this->input->post('interface_name');
			$youtube_api_key = $this->input->post('youtube_api_key');
			$brandname = $this->input->post('brandname');
			$contactinformation = $this->input->post('contactinformation');
			$dir = $this->input->post('dir');
			$qrcode = $this->input->post('qrcode');
			$name_text = $this->input->post('name_text');
			
			$selection_color = $this->input->post('selection_color');
			$product_has_epg = $this->input->post('product_has_epg');
			$show_catchuptv = $this->input->post('show_catchuptv');
			$show_clock = $this->input->post('show_clock');
			$show_fontsize = $this->input->post('show_fontsize');
			$show_hint = $this->input->post('show_hint');
			$show_languages = $this->input->post('show_languages');
			$show_quickmenu = $this->input->post('show_quickmenu');
			$show_screensaver = $this->input->post('show_screensaver');
			$show_search = $this->input->post('show_search');
			$show_speedtest = $this->input->post('show_speedtest');
			$enable_hint = $this->input->post('enable_hint');
			$enable_kids_mode = $this->input->post('enable_kids_mode');
			$direct_tv_mode = $this->input->post('direct_tv_mode');
			$channel_preview = $this->input->post('channel_preview');
			$epg_preview = $this->input->post('epg_preview');			
			$show_weather = $this->input->post('show_weather');			
			$max_concurrent_devices = $this->input->post('max_concurrent_devices');			
			$max_days_interactivetv = $this->input->post('max_days_interactivetv');			
			$sleep_mode = $this->input->post('sleep_mode');			
			$payment_type = $this->input->post('payment_type');
			$storage_package = $this->input->post('storage_package');
			
			
			if ($this->form_validation->run() == FALSE){
				$this->data['message'] = 'error';
				$this->data['interface_name'] = $interface_name;
				$this->data['youtube_api_key'] = $youtube_api_key;
				$this->data['brandname'] = $brandname;
				$this->data['contactinformation'] = $contactinformation;
				$this->data['dir'] = $dir;
				$this->data['qrcode'] = $qrcode;
				$this->data['name_text'] = $name_text;
				
				$this->data['selection_color'] = $selection_color;
				$this->data['product_has_epg'] = $product_has_epg;
				$this->data['show_catchuptv'] = $show_catchuptv;
				$this->data['show_clock'] = $show_clock;
				$this->data['show_fontsize'] = $show_fontsize;
				$this->data['show_hint'] = $show_hint;
				$this->data['show_languages'] = $show_languages;
				$this->data['show_quickmenu'] = $show_quickmenu;				
				$this->data['show_screensaver'] = $show_screensaver;				
				$this->data['show_search'] = $show_search;				
				$this->data['show_speedtest'] = $show_speedtest;				
				$this->data['enable_hint'] = $enable_hint;				
				$this->data['enable_kids_mode'] = $enable_kids_mode;				
				$this->data['direct_tv_mode'] = $direct_tv_mode;				
				$this->data['channel_preview'] = $channel_preview;				
				$this->data['epg_preview'] = $epg_preview;				
				$this->data['show_weather'] = $show_weather;				
				$this->data['max_concurrent_devices'] = $max_concurrent_devices;				
				$this->data['max_days_interactivetv'] = $max_days_interactivetv;				
				$this->data['sleep_mode'] = $sleep_mode;				
				$this->data['payment_type'] = $payment_type;
				$this->data['storage_package'] = $storage_package;
				
			}else{
				$data = array('name'=>$interface_name,
								'youtube_api_key' => $youtube_api_key,
								'brandname' => $brandname,
								'contactinformation' => $contactinformation,
								'dir' => $dir,
								'qrcode' => $qrcode,
								'name_text' => $name_text,
								'selection_color' => $selection_color,
								'product_has_epg' => $product_has_epg,
								'show_catchuptv' => $show_catchuptv,
								'show_clock' => $show_clock,
								'show_fontsize' => $show_fontsize,
								'show_hint' => $show_hint,
								'show_languages' => $show_languages,
								'show_quickmenu' => $show_quickmenu,
								'show_screensaver' => $show_screensaver,
								'show_search' => $show_search,
								'show_speedtest' => $show_speedtest,
								'enable_hint' => $enable_hint,
								'enable_kids_mode' => $enable_kids_mode,
								'direct_tv_mode' => $direct_tv_mode,
								'channel_preview' => $channel_preview,
								'epg_preview' => $epg_preview,
								'show_weather' => $show_weather,
								'max_concurrent_devices' => $max_concurrent_devices,
								'max_days_interactivetv' => $max_days_interactivetv,
								'sleep_mode' => $sleep_mode,
								'payment_type' => $payment_type	,
								'storage_package' => $storage_package							
								);
								/*echo '<pre>';
								print_r($data);EXIT;*/
								$insert_id = $this->user_interface_m->update_keycode($data,$where,'user_interface');
								redirect(BASE_URL.'user_interface');
			}
			
			
		} else{
		
			$this->data['interface_name'] = $interface_data[0]['name'];
			$this->data['youtube_api_key'] = $interface_data[0]['youtube_api_key'];
			$this->data['brandname'] = $interface_data[0]['brandname'];
			$this->data['contactinformation'] = $interface_data[0]['contactinformation'];
			$this->data['dir'] = $interface_data[0]['dir'];
			$this->data['qrcode'] = $interface_data[0]['qrcode'];
			$this->data['name_text'] = $interface_data[0]['name_text'];			
			$this->data['selection_color'] = $interface_data[0]['selection_color'];
			$this->data['product_has_epg'] = $interface_data[0]['product_has_epg'];
			$this->data['show_catchuptv'] = $interface_data[0]['show_catchuptv'];
			$this->data['show_clock'] = $interface_data[0]['show_clock'];
			$this->data['show_fontsize'] = $interface_data[0]['show_fontsize'];
			$this->data['show_hint'] = $interface_data[0]['show_hint'];
			$this->data['show_languages'] = $interface_data[0]['show_languages'];
			$this->data['show_quickmenu'] = $interface_data[0]['show_quickmenu'];			
			$this->data['show_screensaver'] = $interface_data[0]['show_screensaver'];				
			$this->data['show_search'] = $interface_data[0]['show_search'];				
			$this->data['show_speedtest'] = $interface_data[0]['show_speedtest'];			
			$this->data['enable_hint'] = $interface_data[0]['enable_hint'];			
			$this->data['enable_kids_mode'] = $interface_data[0]['enable_kids_mode'];				
			$this->data['direct_tv_mode'] = $interface_data[0]['direct_tv_mode'];				
			$this->data['channel_preview'] = $interface_data[0]['channel_preview'];				
			$this->data['epg_preview'] = $interface_data[0]['epg_preview'];				
			$this->data['show_weather'] = $interface_data[0]['show_weather'];				
			$this->data['max_concurrent_devices'] = $interface_data[0]['max_concurrent_devices'];			
			$this->data['max_days_interactivetv'] = $interface_data[0]['max_days_interactivetv'];				
			$this->data['sleep_mode'] = $interface_data[0]['sleep_mode'];			
			$this->data['storage_package'] = $interface_data[0]['storage_package'];
			$this->data['ui_name'] = $interface_data[0]['ui_name'];
		}
      
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, 'Create GUI Version', 'user_interface/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        $this->data['_extra_scripts'] = DEFAULT_THEME . 'user_interface/_extra_scripts';
        $this->data['_view'] = DEFAULT_THEME . 'user_interface/edit';
        $this->data['page_title'] = "Add a User Interface";
        $this->load->view( DEFAULT_THEME . '_layout',$this->data);		
    }
	
    public function delete($id = NULL){
        check_allow('delete',$this->data['is_allow']);
        ( $id == NULL ) ? redirect( BASE_URL . 'user_interface' ) : '';
		
		$where = array('id'=>$id);
		//$interface_data = $this->user_interface_m->selectdatarow($where, 'user_interface');		
        $this->user_interface_m->deletedatarow($where,'user_interface');
       
        $this->session->set_flashdata('success',"User Interface Deleted Successfully.");
        redirect( BASE_URL . 'user_interface' );
    }

   public function name_unique(){
		$ui_name = $this->toAlphaNumeric($this->input->post('ui_name'));
		$this->form_validation->set_message('name_unique', 'This name already used. Use another Name.');
		$where = array('ui_name'=>$ui_name);
		if(count($this->user_interface_m->selectdatarow($where,'user_interface')) > 0 ){
			return false;
		}else{
			return true;
		}		
	}
	
	public function toAlphaNumeric($input) {
		if (is_null($input)) {
			return "";
		} else {
			$input = preg_replace('/\s/', '' , $input);
			
           $input = preg_replace("/[^a-zA-Z0-9_]/", "", $input);
			return $input;
		}
	}
}