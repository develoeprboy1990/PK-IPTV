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
            <form method="post" action="<?= BASE_URL ?>channels/edit/<?php echo $channel_detail->id?>" enctype="multipart/form-data" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_number" class="col-sm-2 control-label">Number</label>

                  <div class="col-sm-4">
                   <input type="text" id="channel_number" name="channel_number" class="form-control" value="<?php echo $channel_detail->channel_number?>" placeholder="Channel Number"/>
                   <span class="text-danger"><?= form_error('channel_number'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_name" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-4">
                   <input type="text" id="channel_name" name="channel_name" class="form-control"  value="<?php echo $channel_detail->channel_name?>" placeholder="Channel Name"/>
                   <span class="text-danger"><?= form_error('channel_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_image" class="col-sm-2 control-label">Channel Logo (180X180)</label>

                  <div class="col-sm-4">
                   <input type="file" id="channel_image" name="channel_image"/>
                  
                    <?php if($channel_detail->channel_image!="") { ?>
                      <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$channel_detail->channel_image?>" width="180">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_image_icon" class="col-sm-2 control-label">Channel Icon (180X180)</label>

                  <div class="col-sm-4">
                   <input type="file" id="channel_image_icon" name="channel_image_icon"/>
                    
                    <?php if($channel_detail->channel_image_icon!="") { ?>
                      <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$channel_detail->channel_image_icon?>" width="180">
                    <?php }?>
                  </div>
                </div>
              </div>
             
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
                                  <?php foreach ($groups_channel as $group) { ?>
                                       <?php if(in_array($group['id'], $channel_groups_ids)) { ?>
                                          <option value="<?=$group['id']?>"><?=$group['name']?></option>
                                        <?php } ?>
                                    <?php }?>
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
                                  <?php foreach ($packages as $pkt) { 
                                      if(in_array($pkt['id'],$channel_packages)){
                                    ?>
                                    <option value="<?=$pkt['id']?>"><?=$pkt['name']?></option>
                                  <?php }
                                  }?>
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

              <div class="row"> 
                <div class="form-group">
                  <label for="encoder_id" class="col-sm-2 control-label">Encoder ID</label>
                  <div class="col-sm-4">
                   <input type="text" id="encoder_id" name="encoder_id" value="<?=$channel_detail->encoder_id?>" class="form-control" placeholder="Encode ID"/>
                   <span class="text-danger"><?= form_error('encoder_id'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_epg_name" class="col-sm-2 control-label">Channel EPG Name</label>

                  <div class="col-sm-4">
                   <input type="text" id="channel_epg_name" name="channel_epg_name" class="form-control"  value="<?php echo $channel_detail->channel_epg_name?>" placeholder="Channel EPG Name"/>
                   <span class="text-danger"><?= form_error('channel_epg_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_type" class="col-sm-2 control-label">Channel Type</label>

                  <div class="col-sm-4">
                   <select id="channel_type" name="channel_type">
                     <option value="Live TV" <?php if($channel_detail->channel_type=='live tv') { echo "selected";}?>>Live TV</option>
                     <option value="Web TV" <?php if($channel_detail->channel_type=='web tv') { echo "selected";}?>>Web TV</option>
                     <option value="Web Portals" <?php if($channel_detail->channel_type=='web portals') { echo "selected";}?>>Web Portals</option>
                     <option value="Radio" <?php if($channel_detail->channel_type=='radio') { echo "selected";}?>>Radio</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_catchup_tv" class="col-sm-2 control-label">Channel CatchUp TV</label>

                  <div class="col-sm-4">
                   <input type="text" id="channel_catchup_tv" name="channel_catchup_tv" class="form-control"  value="<?php echo $channel_detail->channel_catchup_tv?>" placeholder="Channel CatchUp TV"/>
                   <span class="text-danger"><?= form_error('channel_catchup_tv'); ?></span>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="url_high" class="col-sm-2 control-label">Standard Url</label>

                  <div class="col-sm-4">
                   <input type="text" id="url_high" name="url_high" class="form-control"  value="<?php echo $channel_detail->url_high?>"  placeholder="Standard Url"/>
                   <span class="text-danger"><?= form_error('url_high'); ?></span>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="url_low" class="col-sm-2 control-label">Fallback Url</label>

                  <div class="col-sm-4">
                   <input type="text" id="url_low" name="url_low" class="form-control"  value="<?php echo $channel_detail->url_low?>" placeholder="Fallback Url"/>
                   <span class="text-danger"><?= form_error('url_low'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="token" class="col-sm-2 control-label">Token</label>

                  <div class="col-sm-4">
                   <select id="token" name="token">
                      <?php foreach($tokens as $token){ ?>
                        <option value="<?=$token->id?>" <?php if($token->id==$channel_detail->token) echo "selected";?>><?=$token->name?></option>
                     <?php } ?>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="epg_url" class="col-sm-2 control-label">EPG URL</label>

                  <div class="col-sm-4">
                   <input type="text" id="epg_url" name="epg_url" class="form-control"  value="<?php echo $channel_detail->epg_url?>" placeholder="EPG URL"/>
                   <span class="text-danger"><?= form_error('epg_url'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="epg_offset" class="col-sm-2 control-label">EPG Offset</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="epg_offset" class="onoffswitch-checkbox" id="epg_offset" value="1" <?php if($channel_detail->epg_offset==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="epg_offset">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="preroll_enabled" class="col-sm-2 control-label">Preroll Enabled</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="preroll_enabled" class="onoffswitch-checkbox" id="preroll_enabled" value="1" <?php if($channel_detail->preroll_enabled==1) echo "checked";?>>
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

                  <div class="col-sm-4">
                   <select id="preroll_type" name="preroll_type">
                     <option value="">Select a Type</option>
                     <option value="Always On" <?php if($channel_detail->preroll_type=='always on') { echo "selected";}?>>Always On</option>
                     <option value="Maximum 1x" <?php if($channel_detail->preroll_type=='maximum 1x') { echo "selected";}?>>Maximum 1x</option>
                     <option value="Maximum 2x" <?php if($channel_detail->preroll_type=='maximum 2x') { echo "selected";}?>>Maximum 2x</option>
                     <option value="Maximum 3x" <?php if($channel_detail->preroll_type=='maximum 3x') { echo "selected";}?>>Maximum 3x</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="overlay_enabled" class="col-sm-2 control-label">Overlay Enabled</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="overlay_enabled" class="onoffswitch-checkbox" id="overlay_enabled" value="1" <?php if($channel_detail->overlay_enabled==1) echo "checked";?>>
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
                      <input type="checkbox" name="ticker_enabled" class="onoffswitch-checkbox" id="ticker_enabled" value="1" <?php if($channel_detail->ticker_enabled==1) echo "checked";?>>
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
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" <?php if($channel_detail->show_on_home==1) echo "checked";?>>
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
                      <input type="checkbox" name="fingerprint" class="onoffswitch-checkbox" id="fingerprint" value="1" <?php if($channel_detail->fingerprint==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="fingerprint">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_flussonic" class="col-sm-2 control-label">Is Flussonic? </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_flussonic" class="onoffswitch-checkbox" id="is_flussonic" value="1" <?php if($channel_detail->is_flussonic==1) echo "checked";?>>
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
                  <label for="flussonoc" class="col-sm-2 control-label">Flussonoc DVR</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="flussonoc" class="onoffswitch-checkbox" id="flussonoc" value="1" <?php if($channel_detail->flussonoc==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="flussonoc">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_dveo" class="col-sm-2 control-label">Is Dveo? </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_dveo" class="onoffswitch-checkbox" id="is_dveo" value="1" <?php if($channel_detail->is_dveo==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="is_dveo">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="have_archive" class="col-sm-2 control-label">Have Archive </label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="have_archive" class="onoffswitch-checkbox" id="have_archive" value="1" <?php if($channel_detail->have_archive==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="have_archive">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="url_interactivetv" class="col-sm-2 control-label">Interactive TV Url</label>

                  <div class="col-sm-4">
                   <input type="text" id="url_interactivetv" name="url_interactivetv" class="form-control"  value="<?php echo $channel_detail->url_interactivetv?>" placeholder="Interactive TV Url"/>
                   <span class="text-danger"><?= form_error('url_interactivetv'); ?></span>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="childlock" class="col-sm-2 control-label">Child lock</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="childlock" class="onoffswitch-checkbox" id="childlock" value="1" <?php if($channel_detail->childlock==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="childlock">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group">
                  <label for="secure_stream" class="col-sm-2 control-label">Secure Stream</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="secure_stream" class="onoffswitch-checkbox" id="secure_stream" value="1" <?php if($channel_detail->secure_stream==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="secure_stream">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="is_payperview" class="col-sm-2 control-label">Is Payperview ?</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_payperview" class="onoffswitch-checkbox" id="is_payperview" value="1" <?php if($channel_detail->is_payperview==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="is_payperview">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="rule_payperview" class="col-sm-2 control-label">Rule Payperview</label>
                  <div class="col-sm-4">
                   <input type="text" id="rule_payperview" name="rule_payperview" value="<?=$channel_detail->rule_payperview?>" class="form-control" placeholder="Rule Payperview"/>
                   <span class="text-danger"><?= form_error('rule_payperview'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_kids_friendly" class="col-sm-2 control-label">Is Kids Friendly ?</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="is_kids_friendly" class="onoffswitch-checkbox" id="is_kids_friendly" value="1" <?php if($channel_detail->is_kids_friendly==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="is_kids_friendly">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="use_playlist" class="col-sm-2 control-label">Use Playlist</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="use_playlist" class="onoffswitch-checkbox" id="use_playlist" value="1" <?php if($channel_detail->use_playlist==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="use_playlist">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="use_events" class="col-sm-2 control-label">Use Events</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="use_events" class="onoffswitch-checkbox" id="use_events" value="1" <?php if($channel_detail->use_events==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="use_events">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group">
                  <label for="dvr_channel_name" class="col-sm-2 control-label">DVR Channel Name</label>

                  <div class="col-sm-4">
                   <input type="text" id="dvr_channel_name" name="dvr_channel_name" class="form-control"  value="<?php echo $channel_detail->dvr_channel_name?>" placeholder="DVR Channel Name"/>
                   <span class="text-danger"><?= form_error('dvr_channel_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="drm_stream" class="col-sm-2 control-label">DRM Stream</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="drm_stream" class="onoffswitch-checkbox" id="drm_stream" value="1" <?php if($channel_detail->drm_stream==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="drm_stream">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="drm_rewrite_rule" class="col-sm-2 control-label">DRM Rewrite Rule</label>
                  <div class="col-sm-4">
                   <input type="text" id="drm_rewrite_rule" name="drm_rewrite_rule" value="<?=$channel_detail->drm_rewrite_rule?>" class="form-control" placeholder="DRM Rewrite Rule"/>
                   <span class="text-danger"><?= form_error('drm_rewrite_rule'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="status" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" value="1" <?php if($channel_detail->status==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="status">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6 text-center">
                  <button type="submit" class="btn btn-success ">Update Channel</button>
                </div>
              </div>

            </form>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->