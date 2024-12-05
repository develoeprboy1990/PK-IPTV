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
            <form method="post" action="<?= BASE_URL ?>channels/create" enctype="multipart/form-data" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_number" class="col-sm-2 control-label">Number</label>

                  <div class="col-sm-4">
                   <input type="number" id="channel_number" name="channel_number" value="<?=set_value('channel_number')?>" class="form-control" placeholder="Channel Number"/>
                   <span class="text-danger" id="channel_number_msg"><?= form_error('channel_number'); ?></span>
                  </div>
				  
				  <div class="col-sm-4">
                              <a href="#" class="btn btn-success" onclick="check_available();return false;">Check Available</a>
                            </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_name" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-4">
                   <input type="text" id="channel_name" name="channel_name" value="<?=set_value('channel_name')?>" class="form-control" placeholder="Channel Name"/>
                   <span class="text-danger"><?= form_error('channel_name'); ?></span>
                  </div>
                </div>
              </div>

              

             <!--  <div class="row"> 
                <div class="form-group">
                  <label for="channel_image_icon" class="col-sm-2 control-label">Channel Icon (180X180)</label>

                  <div class="col-sm-4">
                   <input type="file" id="channel_image_icon" name="channel_image_icon"/>
                  </div>
                </div>
              </div> -->
            
              <div class="row"> 
                <div class="form-group">
                  <label for="channel_group" class="col-sm-2 control-label">Channel Group</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="from" id="multiselect_left" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($groups_channel as $group) { ?>
                                    <option value="<?=$group['id']?>"><?=$group['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right" class="form-control" name="channel_group[]" size="15" multiple="multiple">
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_group" class="col-sm-2 control-label">Packages</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="package_from" id="multiselect_left_package" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($packages as $pkt) { ?>
                                    <option value="<?=$pkt['id']?>"><?=$pkt['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_package" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_package" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_package" class="form-control" name="packages[]" size="15" multiple="multiple">
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_package" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_package" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="encoder_id" class="col-sm-2 control-label">Encoder ID</label>
                  <div class="col-sm-4">
                   <input type="text" id="encoder_id" name="encoder_id" value="<?=set_value('encoder_id')?>" class="form-control" placeholder="Encode ID"/>
                   <span class="text-danger"><?= form_error('encoder_id'); ?></span>
                  </div>
                </div>
              </div> -->
              <div class="row"> 
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Language</label>
                            <div class="col-sm-4">
                              <select id="language_id" name="language_id" class="form-control">                 
                                <?php foreach ($languages as $language) { ?>
                                  <option value="<?=$language['id']?>"><?=$language['name']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            
                          
                        </div>
                      </div>
				<div class="row"> 
                <div class="form-group">
                  <label for="channel_epg_name" class="col-sm-2 control-label">EPG Name</label>

                  <div class="col-sm-4">
				  <select id="epg_name" name="epg_name" class="form-control" required>
				  			<option value="">Select EPG</option>
				  		<?php 
							foreach($epg_info as $val){
								echo '<option value="'.$val->id.'">'.$val->name.'</option>';
							}
						?>
				  </select>
                  
                  </div>
                </div>
              </div>

              
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="channel_epg_name" class="col-sm-2 control-label">Channel EPG Name</label>

                  <div class="col-sm-4">
				  <input id="channel_epg_name" name="channel_epg_name" class="form-control">
				  <input type="hidden" id="channel_epg_id" name="channel_epg_id">
				  		<?php 
							/*foreach($epg_info as $val){
								echo '<option value="live tv">'.$val['chanel_name'].'</option>';
							}*/
						?>
				 <!-- </select>-->
                   <!--<input type="text" id="channel_epg_name" name="channel_epg_name" value="<?=php //echo et_value('channel_epg_name');?>" class="form-control" placeholder="Channel EPG Name"/>
                   <span class="text-danger"><?php //echo form_error('channel_epg_name'); ?></span>-->
                  </div>
                </div>
              </div>

			  <div class="row" > 
                <div class="form-group">
                  <label for="chanel_logo" class="col-sm-2 control-label">Search Images</label>
					<?php
							foreach($chanel_logo as $val){							
								echo '<input type="hidden" id="select_logo_'.$val->id.'" value="'.$val->icon.'" >';
							}
					?>
                  <div class="col-sm-4" id="shanel_sec">
				  	<select id="chanel_logo" name="chanel_logo" class="form-control">
				  			<option value="">Select Image</option>
				  		<?php 
						//print_r($chanel_logo);
							foreach($chanel_logo as $val){
								echo '<option value="'.$val->id.'">'.$val->chanel_name.'</option>';
								//echo '<input type="hidden" id="select_logo_'.$val->id.'" value="'.$val->icon.'" >';
							}
						?>
				  </select>	
                  </div>
				  
                </div>
              </div>
			  <div class="row" > 
                <div class="form-group">
                  <label for="chanel_logo" class="col-sm-2 control-label"></label>					
                  <div class="col-sm-4" id="shanel_sec">
				  	<input type="hidden" id="channel_image_icon" name="channel_image_icon" value="" />
				  	<div id="selected_img"></div>
				  </div>				   
                </div>
              </div>
			  <div class="row"> 
                <div class="form-group">
                  <label for="channel_image" class="col-sm-2 control-label">Channel Logo (180X180)</label>

                  <div class="col-sm-4">
                   <input type="file" id="channel_image" name="channel_image"/>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="channel_type" class="col-sm-2 control-label">Channel Type</label>

                  <div class="col-sm-2">
                   <select id="channel_type" name="channel_type" class="form-control">
                     <option value="live tv">Live TV</option>
                     <option value="web tv">Web TV</option>
                     <option value="web portals">Web Portals</option>
                     <option value="radio">Radio</option>
                   </select>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="channel_catchup_tv" class="col-sm-2 control-label">Channel CatchUp TV</label>

                  <div class="col-sm-4">
                   <input type="text" id="channel_catchup_tv" name="channel_catchup_tv" value="<?=set_value('channel_catchup_tv')?>" class="form-control" placeholder="Channel CatchUp TV"/>
                   <span class="text-danger"><?= form_error('channel_catchup_tv'); ?></span>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="url_high" class="col-sm-2 control-label">High Url <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="High Bandwidth"></i></label>
                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_url_high" class="col-sm-2 control-label">Url</label>
							
                            <div class="col-sm-3">
                              <select id="server_url_high" name="server_url_high" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>"><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <input type="text" id="url_high" name="url_high" value="<?=set_value('url_high')?>" class="form-control" placeholder="High Url"/>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('url_high'); ?></span>
                            </div>
							
							
                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_high" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_high" name="token_high" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
							
							<!--<div class="col-sm-4">
                              <a href="#" class="btn btn-success" onclick="copyhigh_urldata();return false;">Copy Data</a>
                            </div>-->
							
							
                          </div>
                        </div>
                      </div>
					  
					  
                    </div>
                  </div>
                </div>
              </div>
			  <div class="row"> 
								<div class="form-group">
								  <label for="url_interactivetv" class="col-sm-2 control-label">Catchup TV Url</label>
				
								  <div class="col-sm-8" >
									<div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
									  <div class="row"> 
										<div class="form-group">
										  <div class="col-sm-12">
											<label for="server_url_interactivetv" class="col-sm-2 control-label">Url</label>
											
											<div class="col-sm-3">
											  <select id="server_url_interactivetv" name="server_url_interactivetv" class="form-control" >
												  <option value="">Select a Url</option>
											   <?php foreach($catchup_server_urls as $url){ ?>
												  <option value="<?=$url->id?>" ><?=$url->name?></option>
											   <?php } ?>
											  </select>
											  
											</div>
				
											<div class="col-sm-7">
											  <input type="text" id="url_interactivetv" name="url_interactivetv" value="<?=set_value('url_interactivetv')?>" class="form-control" placeholder="Catchup Url"/>
											  <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
											  <span class="text-danger"><?= form_error('url_interactivetv'); ?></span>
											</div>
										  </div>
										</div>
									  </div>
				
									  <div class="row"> 
										<div class="form-group">
										  <div class="col-sm-12">
											<label for="token_interactivetv" class="col-sm-2 control-label">Tokenize</label>
											<div class="col-sm-8">
											  <select id="token_interactivetv" name="token_interactivetv" class="form-control" style="width:150px;">
											   <?php foreach($tokens as $token){ ?>
												  <option value="<?=$token->id?>"><?=$token->name?></option>
											   <?php } ?>
											  </select>
											  <p class="help-block">If DVR is ON and Catchup url is empty then above url will be used for DVR</p>
											</div>
										  </div>
										</div>
									  </div>
									</div>
								  </div>
								</div>
							  </div>
							  
              <div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="url_low" class="col-sm-2 control-label">Low Url <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Low Bandwidth for mobile devices"></i></label>

                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_url_low" class="col-sm-2 control-label">Url</label>
                            
                            <div class="col-sm-3">
                              <select id="server_url_low" name="server_url_low" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" ><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <input type="text" id="url_low" name="url_low" value="<?=set_value('url_low')?>" class="form-control" placeholder="Fallback Url"/>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('url_low'); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_low" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_low" name="token_low" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="standard_url" class="col-sm-2 control-label">Standard Url <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Standard Url"></i></label>

                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_standard" class="col-sm-2 control-label">Url</label>
                            
                            <div class="col-sm-3">
                              <select id="server_standard" name="server_standard" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" ><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <input type="text" id="url_standard" name="url_standard" value="<?=set_value('url_standard')?>" class="form-control" placeholder="Standard Url"/>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('url_standard'); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_standard" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_standard" name="token_standard" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              

              <div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="ios_tvos" class="col-sm-2 control-label">IOS TVOS Url <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="IOS TVOS Url"></i></label>

                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_ios_tvos" class="col-sm-2 control-label">Url</label>
                            
                            <div class="col-sm-3">
                              <select id="server_ios_tvos" name="server_ios_tvos" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" ><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <input type="text" id="url_ios_tvos" name="url_ios_tvos" value="<?=set_value('url_ios_tvos')?>" class="form-control" placeholder="IOS TVOS Url"/>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('url_ios_tvos'); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_ios_tvos" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_ios_tvos" name="token_ios_tvos" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="ios_tvos" class="col-sm-2 control-label">Tizen Webos Url <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Tizen Webos Url"></i></label>

                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_tizen_webos" class="col-sm-2 control-label">Url</label>
                            
                            <div class="col-sm-3">
                              <select id="server_tizen_webos" name="server_tizen_webos" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" ><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <input type="text" id="url_tizen_webos" name="url_tizen_webos" value="<?=set_value('url_tizen_webos')?>" class="form-control" placeholder="Tizen Webos Url"/>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('url_tizen_webos'); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_tizen_webos" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_tizen_webos" name="token_tizen_webos" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="epg_url" class="col-sm-2 control-label">EPG URL</label>

                  <div class="col-sm-4">
                   <input type="text" id="epg_url" name="epg_url" value="<?=set_value('epg_url')?>" class="form-control" placeholder="EPG URL"/>
                   <p class="help-block">Use only if epg data is not in bulk import.</p>
                   <span class="text-danger"><?= form_error('epg_url'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="epg_offset" class="col-sm-2 control-label">EPG Offset</label>

                  <div class="col-sm-6">
                   <input type="text" id="epg_offset" name="epg_offset" class="form-control" style="width:100px;" value="" placeholder="+1"/>
                   <p class="help-block">Time +/- minutes to add to channels</p>
                   <span class="text-danger"><?= form_error('epg_offset'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_flussonic" class="col-sm-2 control-label">DVR (ON/OFF) </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_flussonic" class="onoffswitch-checkbox" id="is_flussonic" value="1">
                      <label class="onoffswitch-label" for="is_flussonic">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="dvr_offset" class="col-sm-2 control-label">DVR Offset (seconds)</label>

                  <div class="col-sm-8">
                   <input type="text" id="dvr_offset" name="dvr_offset" class="form-control" style="width:100px;" value="" placeholder="10000"/>
                   <p class="help-block">This is the time rewind will be start. It is only required If you using timeshift stream and used dvr of live stream</p>
                   <span class="text-danger"><?= form_error('dvr_offset'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="preroll_enabled" class="col-sm-2 control-label">Preroll Enabled</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="preroll_enabled" class="onoffswitch-checkbox" id="preroll_enabled" value="1">
                      <label class="onoffswitch-label" for="preroll_enabled">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="preroll_type" class="col-sm-2 control-label">Preroll Type</label>

                  <div class="col-sm-2">
                   <select id="preroll_type" name="preroll_type" class="form-control">
                     <option value="">Select a Type</option>
                     <option value="always on">Always On</option>
                     <option value="maximum 1x">Maximum 1x</option>
                     <option value="maximum 2x">Maximum 2x</option>
                     <option value="maximum 3x">Maximum 3x</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="overlay_enabled" class="col-sm-2 control-label">Overlay Enabled</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="overlay_enabled" class="onoffswitch-checkbox" id="overlay_enabled" value="1">
                      <label class="onoffswitch-label" for="overlay_enabled">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="ticker_enabled" class="col-sm-2 control-label">Ticker</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="ticker_enabled" class="onoffswitch-checkbox" id="ticker_enabled" value="1">
                      <label class="onoffswitch-label" for="ticker_enabled">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_on_home" class="col-sm-2 control-label">Show on Home</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1">
                      <label class="onoffswitch-label" for="show_on_home">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="fingerprint" class="col-sm-2 control-label">Fingerprint</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="fingerprint" class="onoffswitch-checkbox" id="fingerprint" value="1">
                      <label class="onoffswitch-label" for="fingerprint">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="is_flussonic" class="col-sm-2 control-label">Is Flussonic? </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_flussonic" class="onoffswitch-checkbox" id="is_flussonic" value="1">
                      <label class="onoffswitch-label" for="is_flussonic">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="flussonoc" class="col-sm-2 control-label">Flussonoc DVR</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="flussonoc" class="onoffswitch-checkbox" id="flussonoc" value="1">
                      <label class="onoffswitch-label" for="flussonoc">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="is_dveo" class="col-sm-2 control-label">Is Dveo? </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_dveo" class="onoffswitch-checkbox" id="is_dveo" value="1">
                      <label class="onoffswitch-label" for="is_dveo">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="have_archive" class="col-sm-2 control-label">Have Archive </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="have_archive" class="onoffswitch-checkbox" id="have_archive" value="1">
                      <label class="onoffswitch-label" for="have_archive">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="childlock" class="col-sm-2 control-label">Child lock</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="childlock" class="onoffswitch-checkbox" id="childlock" value="1">
                      <label class="onoffswitch-label" for="childlock">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="secure_stream" class="col-sm-2 control-label">Secure Stream</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="secure_stream" class="onoffswitch-checkbox" id="secure_stream" value="1">
                      <label class="onoffswitch-label" for="secure_stream">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="is_payperview" class="col-sm-2 control-label">Is Payperview ?</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_payperview" class="onoffswitch-checkbox" id="is_payperview" value="1">
                      <label class="onoffswitch-label" for="is_payperview">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="rule_payperview" class="col-sm-2 control-label">Rule Payperview</label>
                  <div class="col-sm-4">
                   <input type="text" id="rule_payperview" name="rule_payperview" value="<?=set_value('rule_payperview')?>" class="form-control" placeholder="Rule Payperview"/>
                   <span class="text-danger"><?= form_error('rule_payperview'); ?></span>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="is_kids_friendly" class="col-sm-2 control-label">Is Kids Friendly ?</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_kids_friendly" class="onoffswitch-checkbox" id="is_kids_friendly" value="1">
                      <label class="onoffswitch-label" for="is_kids_friendly">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="use_playlist" class="col-sm-2 control-label">Use Playlist</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="use_playlist" class="onoffswitch-checkbox" id="use_playlist" value="1">
                      <label class="onoffswitch-label" for="use_playlist">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="use_events" class="col-sm-2 control-label">Use Events</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="use_events" class="onoffswitch-checkbox" id="use_events" value="1">
                      <label class="onoffswitch-label" for="use_events">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="dvr_channel_name" class="col-sm-2 control-label">DVR Channel Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="dvr_channel_name" name="dvr_channel_name" value="<?=set_value('dvr_channel_name')?>" class="form-control" placeholder="EPG Offset"/>
                   <span class="text-danger"><?= form_error('dvr_channel_name'); ?></span>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="drm_stream" class="col-sm-2 control-label">DRM Stream</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="drm_stream" class="onoffswitch-checkbox" id="drm_stream" value="1">
                      <label class="onoffswitch-label" for="drm_stream">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="drm_rewrite_rule" class="col-sm-2 control-label">DRM Rewrite Rule</label>
                  <div class="col-sm-4">
                   <input type="text" id="drm_rewrite_rule" name="drm_rewrite_rule" value="<?=set_value('drm_rewrite_rule')?>" class="form-control" placeholder="DRM Rewrite Rule"/>
                   <span class="text-danger"><?= form_error('drm_rewrite_rule'); ?></span>
                  </div>
                </div>
              </div> -->
              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-success ">Add Channel</button>
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

   <style>
     #select {
   position: relative;
   min-width: max-content;
   color: var(--select-text-color);
   user-select: none;
   min-width: 300px;
}

#select > * {
   box-sizing: border-box;
}

#select > li {
   list-style: none;
}

#select > li span.select-label {
   position: relative;
   display: block;
   font-weight: 600;
   background: var(--select-label-background);
   padding: 0.5em 2.5em 0.5em 1em;
   /*box-shadow: 0 0 1em 0 rgba(0, 0, 0, 0.05);*/
  /* border-radius: 6px;*/
   border: 1px solid #ccc;
   transition: 0.2s;
   z-index: 1;
}

#select > li.visible span.select-label,
#select > li:hover span.select-label {
   background: var(--select-item-hover);
   cursor: pointer;
}

#select > li span.select-label:after {
   content: "";
   width: 0;
   height: 0;
   border-left: 6px solid transparent;
   border-right: 6px solid transparent;
   border-top: 7px solid var(--select-arrow-color);
   position: absolute;
   right: 1.25em;
   top: 50%;
   transform: translateY(calc(-50% + 2px));
}

#select > li.hover:hover ul.select-menu,
#select > li.visible ul.select-menu {
   display: block;
}

#select > li.visible .overlay {
   content: " ";
   position: fixed;
   top: 0;
   left: 0;
   width: 100vw;
   height: 100vh;
   z-index: -1;
}

#select > li ul.select-menu {
   display: none;
   position: absolute;
   background: #fff;
   /*box-shadow: 0 0 1em 0 rgba(0, 0, 0, 0.1);
   border-radius: 6px;*/
   border: 1px solid #eee;
   width: 100%;
   overflow: hidden;
   overflow-y: auto;
   max-height: 300px;
   z-index: 2;
   padding-left:0;
}

/* flex inline */
#select > li ul.select-menu .select-inline {
   display: flex;
   flex-wrap: nowrap;
}
#select > li ul.select-menu .select-title,
#select > li ul.select-menu.fix .select-title {
   display: block;
   font-weight: 600;
   padding: 0 0 0.5em 0;
   width: 50%;
}

#select > li ul.select-menu .select-title {
   display: none;
   width: 100%;
}

#select > li ul.select-menu .select-close {
   display: none;
   text-align: text-right;
}
/* search */
#select > li ul.select-menu .select-search {
   background: var(--select-background);
   top: 0;
   position: sticky;
   padding: 0.5em;
   z-index: 1;
}

#select > li ul.select-menu .select-search input {
   background: #eee;
   color: var(--select-text-color);
   border: 0;
   outline: none;
   padding: 0.75em 1em;
   width: 100%;
   border-radius: 6px;
}

/* menu */
#select > li ul.select-menu .select-list {
   position: relative;
   padding: 0.5em 0.5em;
}

#select > li ul.select-menu .select-list li {
   position: relative;
   display: block;
   padding: 0.5em 1em;
   transition: 0.2s;
   margin-bottom: 0.25rem;
   border-bottom:1px solid #eee;
   /*font-size: 0.9em;*/
}

#select > li ul.select-menu .select-list li:not(.disabled):not(.selected):hover {
   background: var(--select-item-hover);
   border-radius: 6px;
   cursor: pointer;
}
#select > li ul.select-menu .select-list li.selected {
   background: var(--select-item-hover);
   border-radius: 6px;
}

#select > li ul.select-menu .select-list span p {
   display: inline-block;
   max-width: 90%;
}
#select > li ul.select-menu .select-list li span:after {
   content: "";
   position: absolute;
   width: 10px;
   height: 10px;
   border: 2px solid var(--select-text-color);
   border-radius: 99px;
   top: calc(50% + 1px);
   right: 15px;
   transform: translateY(-50%);
   opacity: 0.5;
}

#select
   > li
   ul.select-menu:not(.responsive)
   .select-list
   li.selected
   span:before {
   content: "";
   position: absolute;
   width: 7px;
   height: 7px;
   background: var(--select-text-color);
   border: 3.5px solid var(--select-background);
   border-radius: 99px;
   top: calc(50% + 1px);
   right: 15px;
   transform: translateY(-50%);
}

/* modes */
#select > li ul.select-menu .select-list li.selected {
   font-weight: 600;
}

#select > li ul.select-menu .select-list li.disabled {
   cursor: not-allowed;
   color: var(--select-text-muted);
}
#select > li ul.select-menu .select-list li.disabled span:after {
   opacity: 0;
}

/* position down directions */
#select > li.down.hover:hover span.select-label,
#select > li.down.visible span.select-label {
   border-bottom-right-radius: 0;
   border-bottom-left-radius: 0;
}

#select > li.down.hover:hover ul.select-menu,
#select > li.down.visible ul.select-menu {
   border-top-color: transparent;
   border-top-right-radius: 0;
   border-top-left-radius: 0;
   margin-top: -2px;
}

/* UP */
#select > li.up.hover:hover span.select-label,
#select > li.up.visible span.select-label {
   border-top-right-radius: 0;
   border-top-left-radius: 0;
}

#select > li.up span.select-label:after {
   transform: rotate(180deg);
}

#select > li.up.hover:hover ul.select-menu,
#select > li.up.visible ul.select-menu {
   border-bottom-color: transparent;
   border-bottom-right-radius: 0;
   border-bottom-left-radius: 0;
   bottom: calc(100% - 4.5px);
}

@media only screen and (max-width: 600px) {
   .select-overflow-hidden {
       overflow: hidden !important;
   }
   #select > li ul.select-menu.responsive {
       border-radius: 0;
       position: fixed;
       top: 0;
       left: 0;
       width: 100vw;
       min-height: 100vh;
       overflow: hidden;
       overflow-y: auto;
       z-index: 2;
   }
   #select > li ul.select-menu.responsive .select-search .select-title {
       display: block;
   }
   #select > li ul.select-menu.responsive .select-close {
       display: block;
   }
   #select > li span.select-label:after {
       content: "";
       width: 0;
       height: 0;
       border-left: 6px solid transparent;
       border-right: 6px solid transparent;
       border-top: 7px solid var(--select-arrow-color);
       position: absolute;
       right: 1.25em;
       top: calc(50% + 2px);
       transform: translateY(calc(-50% + 2px)) rotate(180deg);
   }
   #select > li span.select-label:before {
       content: "";
       width: 0;
       height: 0;
       border-left: 6px solid transparent;
       border-right: 6px solid transparent;
       border-top: 7px solid var(--select-arrow-color);
       position: absolute;
       top: 15px;
       right: 1.25em;
       transform: translateY(calc(-50% + 2px));
   }
}

#chanel_logo {
   display: none
}
 /*
      #shanel_sec {
         display: flex;
         flex-wrap: nowrap;
         align-items: center;
         justify-content: center;
         flex-direction: column;

      }
     section {
         display: flex;
         flex-wrap: nowrap;
         align-items: center;
         justify-content: center;
         flex-direction: column;

         width: 100vw;
         height: 100vh;
      }*/
      .lead { font-size: 1.5rem; font-weight: 300; margin-bottom: 3rem; }
   </style>

 