 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>user_interface/create" class="form-horizontal">
			
			


 			 <div class="row" style="    margin: 0 10px;"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-2 control-label" style="text-align: left; color:#2196F3;">UI Name</label>                  
                </div>
              </div>
			   <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Name
				  	<apan class="tooltip-bm"> 
					  <span style="font-size:13px">?</span>
					  <span class="tooltiptext-bm" style="font-size:12px;">Name Must be unique.</span>
					</span>
				  </label>
                  <div class="col-sm-4"> 
					<input type="text" value="<?php echo $ui_name;?>" name="ui_name" id="ui_name" value="1" />
					<span class="text-danger"><?= form_error('ui_name'); ?></span>
                  </div>
                </div>
              </div>
			  
			  <div class="row" style="border-top:1px solid #ccc;margin: 0 10px;"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-2 control-label" style="text-align: left; color:#2196F3;">Template</label>                  
                </div>
              </div>
			  
			   <div class="row"> 
                <div class="form-group">
                  
				  
                 <!-- <div class="col-sm-4" style="text-align: center;"> 
						<img src="<?= BASE_URL ?>assets/ums/template/Akua.jpg" width="150"  /><br />						
						<label for="product_has_epg">Akua</label>
						<input type="radio" <?=($template_name == 'Akua') ? "checked" : "" ?> name="template_name" value="Akua" style="margin-left: 10px;">						
                  </div>
				  <div class="col-sm-4" style="text-align: center;"> 
						<img src="<?= BASE_URL ?>assets/ums/template/Honua.jpg" width="150"  /><br />						
						<label for="product_has_epg">Honua</label>
						<input type="radio" <?=($template_name == 'Honua') ? "checked" : "" ?> name="template_name" value="Honua" style="margin-left: 10px;">
                  </div>
				  <div class="col-sm-4" style="text-align: center;"> 
						<img src="<?= BASE_URL ?>assets/ums/template/Iridium.jpg" width="150"  /><br />						
						<label for="product_has_epg">Iridium</label>
						<input type="radio" <?=($template_name == 'Iridium') ? "checked" : "" ?> name="template_name" value="Iridium" style="margin-left: 10px;">
                  </div> -->
				  <?php
				  	foreach($themes as $key=>$val){
				  ?>
				  	<div class="col-sm-4" style="text-align: center;"> 
						<img src="<?php echo $val['img_url'];?>" width="150"  /><br />						
						<label for="product_has_epg"><?php echo $val['name'];?></label>
						<input type="radio" <?=($template_name == $val['id']) ? "checked" : "" ?> name="template_name" value="<?php echo $val['id'];?>" style="margin-left: 10px;">
                    </div>
				  <?php
				  	}
				  ?>
								  
                </div>
              </div>
			  

             <div class="row" style="border-top:1px solid #ccc;margin: 0 10px;"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-2 control-label" style="text-align: left; color:#2196F3;">App State Change</label>                  
                </div>
              </div>
			  
			   <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Restart App</label>
                  <div class="col-sm-1">                 
					<label class="switch">
						<input type="checkbox" <?=($restart_app == 1) ? "checked" : "" ?> id="restart_app" name="restart_app" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				 
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Restart Stream</label>
                  <div class="col-sm-1">					
					<label class="switch">
						<input type="checkbox" <?=($restart_stream == 1) ? "checked" : "" ?> id="restart_stream" name="restart_stream" value="1">
						<span class="slider round"></span>
					</label>
										
                  </div>
				  
                </div>
              </div>
			  
			   		  
			  
			  <div class="row" style="border-top:1px solid #ccc;margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left; color:#2196F3;">Authentication</label>                  
                </div>
              </div>
			  
			   <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Lock Device To IP Address</label>
                  <div class="col-sm-4">                   
					<label class="switch">
						<input type="checkbox" <?=($lock_device_to_ip_address == 1) ? "checked" : "" ?> name="lock_device_to_ip_address" id="lock_device_to_ip_address" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
                </div>
              </div>
			  
			  <div class="row" style="border-top:1px solid #ccc;    margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left; color:#2196F3;">Channel</label>                  
                </div>
              </div>
			  
			   <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Sorting Channels</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_sorting_channels == 1) ? "checked" : "" ?> id="enable_sorting_channels" name="enable_sorting_channels" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Toggle Channels</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_toggle_channels == 1) ? "checked" : "" ?> name="enable_toggle_channels" id="enable_toggle_channels" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>		  
			 
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Show Channel Preview</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($show_channel_preview == 1) ? "checked" : "" ?> name="show_channel_preview" id="show_channel_preview" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="payment_type" class="col-sm-4 control-label">Toggle Default Settings
				  	<apan class="tooltip-bm"> 
					  <span style="font-size:13px">?</span>
					  <span class="tooltiptext-bm" style="font-size:12px;">Tooltip text</span>
					</span>
				  </label>
                  <div class="col-sm-2">
                   <select name="toggle_default_settings" id="toggle_default_settings" class="form-control">
                        <option value="user_defined" <?php if($toggle_default_settings == 'user_defined'){ echo 'selected'; }?> >User Defined</option>
					    <option value="channel" <?php if($toggle_default_settings == 'channel'){ echo 'selected'; }?> >Channel View</option>
						<option value="toggle" <?php if($toggle_default_settings == 'toggle'){ echo 'selected'; }?> >Toggle View</option>
                   </select>
                  </div>
                </div>
              </div>
			  
			 			  
			  
			  <div class="row" style="border-top:1px solid #ccc; margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left;color:#2196F3;">General</label>                  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Catchup Days</label>
                  <div class="col-sm-2"> 
					<input type="number" value="<?php echo $catchup_days;?>" name="catchup_days" id="catchup_days" value="1" />
					
                  </div>
				  
				 <label for="payment_type" class="col-sm-3 control-label">Clock Format</label>
                 <div class="col-sm-2"> 
					 <select name="clock_format" id="clock_format" class="form-control">
                     <option value="24_hours" <?php if($clock_format == '24_hours'){ echo 'selected'; }?> >24 Hrs</option>
					    <option value="am_pm" <?php if($clock_format == 'am_pm'){ echo 'selected'; }?>>AM/PM</option>
                   </select>
                  </div>
                </div>
              </div>
			  
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Catchuptv</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_catchuptv == 1) ? "checked" : "" ?> id="enable_catchuptv" name="enable_catchuptv" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Clock</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_clock == 1) ? "checked" : "" ?> name="enable_clock" id="enable_clock" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Favourites Menu</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_favourites_menu == 1) ? "checked" : "" ?> id="enable_favourites_menu" name="enable_favourites_menu" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Kids Mode Profile</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_kids_mode_profile == 1) ? "checked" : "" ?> name="enable_kids_mode_profile" id="enable_kids_mode_profile" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Large Fonts</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_large_fonts == 1) ? "checked" : "" ?> name="enable_large_fonts" id="enable_large_fonts" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Messages Menu</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_messages_menu == 1) ? "checked" : "" ?> id="enable_messages_menu" name="enable_messages_menu" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Profiles</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_profiles == 1) ? "checked" : "" ?> name="enable_profiles" id="enable_profiles" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Recordings</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_recordings == 1) ? "checked" : "" ?> id="enable_recordings" name="enable_recordings" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Search Menu</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_search_menu == 1) ? "checked" : "" ?> id="enable_search_menu" name="enable_search_menu" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Settings Menu</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_settings_menu == 1) ? "checked" : "" ?> name="enable_settings_menu" id="enable_settings_menu" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Watchlist Menu</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_watchlist_menu == 1) ? "checked" : "" ?> id="enable_watchlist_menu" name="enable_watchlist_menu" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Weather</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_weather == 1) ? "checked" : "" ?> id="enable_weather" name="enable_weather" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="default_audio_language" class="col-sm-3 control-label control-label-bm">Epg Days</label>
                  <div class="col-sm-2"> 
					<input type="number" id="epg_days" name="epg_days" value="<?php echo $epg_days;?>"  />
                  </div>
				  
				 <label for="payment_type" class="col-sm-3 control-label">Sleep Mode Setting</label>
                 <div class="col-sm-2"> 
					<input type="number" id="sleep_mode_setting" name="sleep_mode_setting" value="<?php echo $sleep_mode_setting;?>"  />
                  </div>
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="default_audio_language" class="col-sm-3 control-label control-label-bm">Start Screen</label>
                  <div class="col-sm-2"> 
					<select name="start_screen" id="start_screen" class="form-control">
                     	<option value="home" <?php if($start_screen == 'home'){ echo 'selected'; }?>>Home</option>
						<option value="channels" <?php if($start_screen == 'channels'){ echo 'selected'; }?>>channels</option>
						<option value="tv_guide" <?php if($start_screen == 'tv_guide'){ echo 'selected'; }?>>TV Guide</option>
						<option value="television" <?php if($start_screen == 'television'){ echo 'selected'; }?>>Television</option>
						<option value="movies" <?php if($start_screen == 'movies'){ echo 'selected'; }?>>Movies</option>
						<option value="series" <?php if($start_screen == 'series'){ echo 'selected'; }?>>Series</option>
						<option value="music" <?php if($start_screen == 'music'){ echo 'selected'; }?>>Music</option>
						<option value="apps" <?php if($start_screen == 'apps'){ echo 'selected'; }?>>Apps</option>
                   </select>
                  </div>
				 
                </div>
              </div>
			  
			  
			   <div class="row" style="border-top:1px solid #ccc;    margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left; color:#2196F3;">Home</label>                  
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Ads</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_ads == 1) ? "checked" : "" ?> id="enable_ads" name="enable_ads" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Hero Images</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_hero_images == 1) ? "checked" : "" ?> id="enable_hero_images" name="enable_hero_images" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable News Section</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_news_section == 1) ? "checked" : "" ?> id="enable_news_section" name="enable_news_section" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Weather</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_tv_preview == 1) ? "checked" : "" ?> id="enable_tv_preview" name="enable_tv_preview" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  
			  
			  <div class="row" style="border-top:1px solid #ccc;    margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left; color:#2196F3;">Player</label>                  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="default_audio_language" class="col-sm-3 control-label control-label-bm">Default Audio Language</label>
                  <div class="col-sm-2"> 
					<select name="default_audio_language" id="default_audio_language" class="form-control">
                     	<option value="user_defined" >User Defined</option>
                   </select>
                  </div>
				  
				 <label for="payment_type" class="col-sm-3 control-label">Default Screen Mode</label>
                 <div class="col-sm-2"> 
					<select name="default_screen_mode" id="default_screen_mode" class="form-control">
                     	<option value="user_defined" <?php if($default_screen_mode == 'user_defined'){ echo 'selected'; }?>>User Defined</option>
					   <option value="contain_cover" <?php if($default_screen_mode == 'contain_cover'){ echo 'selected'; }?>>Contain	cover</option>
					   <option value="stretch" <?php if($default_screen_mode == 'stretch'){ echo 'selected'; }?>>Stretch</option>
                   </select>
                  </div>
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Default Subtitle Language</label>
                  <div class="col-sm-2"> 
					<select name="default_subtitle_language" id="default_subtitle_language" class="form-control">
                     	<option value="user_defined" >User Defined</option>
					    
                    </select>
                  </div>
				  
				 <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Casting</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_casting == 1) ? "checked" : "" ?> id="enable_casting" name="enable_casting" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Catchup Buttons</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_catchup_buttons == 1) ? "checked" : "" ?> id="enable_catchup_buttons" name="enable_catchup_buttons" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Channel Menu</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_channel_menu == 1) ? "checked" : "" ?> id="enable_channel_menu" name="enable_channel_menu" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Mini Epg</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_mini_epg == 1) ? "checked" : "" ?> id="enable_mini_epg" name="enable_mini_epg" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Problem Report</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_problem_report == 1) ? "checked" : "" ?> id="enable_problem_report" name="enable_problem_report" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Quadview</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_quadview == 1) ? "checked" : "" ?> id="enable_quadview" name="enable_quadview" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable Watermarking</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_watermarking == 1) ? "checked" : "" ?> id="enable_watermarking" name="enable_watermarking" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Player Type</label>
                  <div class="col-sm-2"> 
					<select name="player_type" id="player_type" class="form-control">
                     	<option value="full_player" >Full Player</option>
					    
                    </select>
                  </div>
                </div>
              </div>
			  
			  
			  <div class="row" style="border-top:1px solid #ccc;    margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left; color:#2196F3;">Series</label>                  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Episodes Full Metadata</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_episodes_full_metadata == 1) ? "checked" : "" ?> id="enable_episodes_full_metadata" name="enable_episodes_full_metadata" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  
                </div>
              </div>
			  
			  <div class="row" style="border-top:1px solid #ccc;    margin: 0 10px;"> 
                <div class="form-group" >
                  <label for="product_has_epg" class="col-sm-2 control-label"  style="text-align: left; color:#2196F3;">TV Guide</label>                  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Enable Epg Search</label>
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($enable_epg_search == 1) ? "checked" : "" ?> id="enable_epg_search" name="enable_epg_search" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  <label for="product_has_epg" class="col-sm-4 control-label control-label-bm">Enable TV Preview Screen</label>
				  <div class="col-sm-1">                
					<label class="switch">
						<input type="checkbox" <?=($enable_tv_preview_screen == 1) ? "checked" : "" ?> id="enable_tv_preview_screen" name="enable_tv_preview_screen" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-3 control-label control-label-bm">Show Epg Preview 
				  	<apan class="tooltip-bm"> 
					  <span style="font-size:13px">?</span>
					  <span class="tooltiptext-bm" style="font-size:12px;">Tooltip text</span>
					</span>
				  </label>
				  
				 
                  <div class="col-sm-1">                  
					<label class="switch">
						<input type="checkbox" <?=($show_epg_preview == 1) ? "checked" : "" ?> id="show_epg_preview" name="show_epg_preview" value="1">
						<span class="slider round"></span>
					</label>
                  </div>
				  
				  
                </div>
              </div>
			 
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success" name="add_user_interface">Add User Interface</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script>
/*ClassicEditor
.create( document.querySelector('#name_text') )
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );*/
</script>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 23px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 4px;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}

.control-label-bm{padding-top:0 !important;}
</style>

<style>

.tooltip-bm {
  position: relative;
  display: inline-block;
 /* border-bottom: 1px dotted black;*/
   border: 1px solid #ccc;
    width: 20px;
    text-align: center;
    border-radius: 50%;
    background-color: #000;
    color: #fff;
    height: 20px;
    font-weight: bold;
}

.tooltip-bm .tooltiptext-bm {
  visibility: hidden;
  width:auto;
  /*width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;*/
  position: absolute;
  z-index: 1;
  top: -5px;
  left: 110%;
  
  min-width:100px;
  padding:5px;
  background-color: #fff;
  color: #000;
  text-align: center;
  border-radius: 3px;
  padding: 5px 0;
  border:1px solid #FFD700;
}

.tooltip-bm .tooltiptext-bm::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent #FFD700 transparent transparent;
}
.tooltip-bm:hover .tooltiptext-bm {
  visibility: visible;
}
</style>