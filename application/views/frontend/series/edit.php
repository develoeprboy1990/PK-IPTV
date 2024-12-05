 <!-- Content Wrapper. Contains page content -->
<style>
  select[multiple] {
    height: 200px !important;
  }
  
  .form-group label {
    font-weight: 600;
    margin-bottom: 8px;
  }
  
  .platforms-container {
    background: #f9f9f9;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  .platforms-container .form-group {
    margin-bottom: 0;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$pagetitle ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>series/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="type" value="2">
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="<?php echo $details->name?>" placeholder="<?=$title?> Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
				  
        				  <div class="col-sm-4">                   
                    <div style="float: right;">
        				      <input type="hidden" name="dbselect" id="dbselect" value="<?php echo $details->dbselect;?>" />
        				      <input type="hidden" name="tmbd_id" id="tmbd_id" value="<?php echo $details->tmbd_id;?>" />
        				   		<span style="font-weight:bold;font-size:14px;text-transform: uppercase;"> <?php echo $details->dbselect;?> : </span>
        						  <span><?php echo $details->tmbd_id;?></span>
        				   </div> 				   
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group">
                  <label for="parent-store" class="col-sm-2 control-label">Stores</label>
                  <div class="col-sm-2">
                    <select id="parent-store" name="parent_store" class="form-control">
                        <!--<option value="">Select a Store</option>-->
                        <?php foreach($stores as $store){?>
          							<?php
          								if($store['id']==$parent_store_id){
          							?>
                                        <option value="<?=$store['id']?>" selected ><?=$store['name']?></option>
          							<?php
          								}else{
          							?>
          								<option value="<?=$store['id']?>"><?=$store['name']?></option>
          							<?php }?>
                        <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="ott_platforms" class="col-sm-2 control-label">OTT Platforms</label>
                  <div class="col-sm-4">
                    <select id="ott_platforms" name="ott_platforms[]" class="form-control" multiple="" required style="height: 200px !important;">
                      <option value="" <?php echo (empty($selected_ott_platforms)) ? 'selected' : ''; ?>>--No Selection--</option>
                      <?php foreach ($ott_platforms as $platform) { ?>
                        <option value="<?=$platform['id']?>" 
                          <?php echo (!empty($selected_ott_platforms) && in_array($platform['id'], $selected_ott_platforms)) ? 'selected' : ''; ?>>
                          <?=$platform['name']?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>              

              <div class="row"> 
                <div class="form-group">
                  <label for="parent-store" class="col-sm-2 control-label">Languages</label>
                  <div class="col-sm-2">
                    <select id="language_id" name="language_id" class="form-control">
                        <!--<option value="">Select a Language</option>-->
                        <?php foreach($languages as $language){?>
          							<option value="<?=$language['id']?>" <?php if($language['id']==$details->language_id){ ?>selected<?php } ?>>
          								<?=$language['name']?>
          							</option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <!--<div class="row"> 
                <div class="form-group">
                  <label for="sub-store" class="col-sm-2 control-label">Sub Stores </label>
                  <div class="col-sm-2">
                    <select id="sub-store" name="sub_store" class="form-control">
                        <?php if(count($sub_stores)>0) {?>
                            <option value="">Select a Store</option>
                              <?php  foreach($sub_stores as $store){?>
                                <option value="<?=$store['id']?>" <?=($store['id']==$sub_store_id) ? "selected": ""?> ><?=$store['name']?></option>
                              <?php }?>
                        <?php }else{?>
                            <option value="">No Sub Store Available</option>
                        <?php }?>
                    </select>
                  </div>
                </div>
              </div>-->

              <div class="row"> 
                <div class="form-group">
                  <label for="logo" class="col-sm-2 control-label">Cover 16:9 (608x342)</label>
                  <div class="col-sm-4">
                   <input type="file" id="logo" name="logo"/>
                    <?php if($details->logo!="") { ?>
                      <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->logo?>" width="180">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="childlock" class="col-sm-2 control-label">Childlock</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="childlock" class="onoffswitch-checkbox" id="childlock" value="1" <?php if($details->childlock==1) echo "checked";?>>
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
                  <label for="position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-1">
                   <input type="text" id="position" name="position" value="<?=$details->position?>" class="form-control" placeholder="1"/>
                   <span class="text-danger"><?= form_error('position'); ?></span>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="show_on_home" class="col-sm-2 control-label">Show on Home</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" <?php if($details->show_on_home==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_on_home">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="active" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="active" class="onoffswitch-checkbox" id="active" value="1" <?php if($details->active==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="active">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

				      <div class="row"> 
                <div class="form-group">
                  <label for="episode_update" class="col-sm-2 control-label">Daily Episode Update</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="episode_update" class="onoffswitch-checkbox" id="episode_update" value="1" <?php if($details->episode_update==1) echo "checked";?> >
                      <label class="onoffswitch-label" for="episode_update">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
			  
			         <div class="row" id="days_select" style=" display:none"> 
                <div class="form-group">
                  <label for="episode_update" class="col-sm-2 control-label"></label>
                  <div class="col-sm-8" style="    border: 1px solid #ccc; padding: 10px 0;">
				  <div class="col-sm-12" style="margin-bottom:15px;margin-top: 15px;">
				  	  <label for="sun_day" class="col-sm-2 control-label">SUN DAY</label>
					  <div class="col-sm-2">					 
						<div class="onoffswitch">
						  <input type="checkbox" name="sun_day" class="onoffswitch-checkbox" id="sun_day" value="1" <?php if($details->sun_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="sun_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="mon_day" class="col-sm-2 control-label">MON DAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="mon_day" class="onoffswitch-checkbox" id="mon_day" value="1" <?php if($details->mon_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="mon_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="tues_day" class="col-sm-2 control-label">TUES DAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="tues_day" class="onoffswitch-checkbox" id="tues_day" value="1" <?php if($details->tues_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="tues_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
				  </div>
				  
				  <div class="col-sm-12" style="margin-bottom:15px;">
					  <label for="wednes_day" class="col-sm-2 control-label">WEDNES DAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="wednes_day" class="onoffswitch-checkbox" id="wednes_day" value="1" <?php if($details->wednes_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="wednes_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					   <label for="thirs_day" class="col-sm-2 control-label">THIRS DAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="thirs_day" class="onoffswitch-checkbox" id="thirs_day" value="1" <?php if($details->thirs_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="thirs_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					   <label for="fri_day" class="col-sm-2 control-label">FRI DAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="fri_day" class="onoffswitch-checkbox" id="fri_day" value="1" <?php if($details->fri_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="fri_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					</div>
					
				  <div class="col-sm-12" style="margin-bottom:15px;"> 
					   <label for="satur_day" class="col-sm-2 control-label">SATUR DAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="satur_day" class="onoffswitch-checkbox" id="satur_day" value="1" <?php if($details->satur_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="satur_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					</div>
					  
					  
				  </div>
				  
                </div>
              </div>


			         <div class="row"> 
                <div class="form-group">
                  <label for="tv_show_platform_status" class="col-sm-2 control-label">TV Show Platform Status</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="tv_show_platform_status" class="onoffswitch-checkbox" id="tv_show_platform_status" value="1" <?php if($details->tv_show_platform_status==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="tv_show_platform_status">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Similar update for TV Show Platforms section -->
              <!-- <div class="row tv-show-platforms-section" style="display:<?php echo ($details->tv_show_platform_status==1) ? 'block' : 'none';?>;"> 
                <div class="form-group">
                  <label for="tv_show_platforms" class="col-sm-2 control-label">TV Show Platforms</label>
                  <div class="col-sm-4">
                    <select id="tv_show_platforms" name="tv_show_platforms[]" class="form-control" multiple="" style="height: 200px !important;">
                      <option value="" <?php echo (empty($selected_tv_platforms)) ? 'selected' : ''; ?>>--No Selection--</option>
                      <?php foreach ($tv_show_platforms as $platform) { ?>
                        <option value="<?=$platform['id']?>" 
                          <?php echo (!empty($selected_tv_platforms) && in_array($platform['id'], $selected_tv_platforms)) ? 'selected' : ''; ?>>
                          <?=$platform['name']?>
                        </option>
                      <?php } ?>
                    </select>
                    <span class="text-danger tv-show-platforms-error" style="display:none;">Please select at least one TV Show Platform</span>
                  </div>
                </div>
              </div> -->

              <div class="row tv-show-platforms-section" style="display:none;"> 
                <div class="form-group">
                    <label for="tv_show_platforms" class="col-sm-2 control-label">TV Show Platforms</label>
                    <div class="col-sm-4">
                        <select id="tv_show_platforms" name="tv_show_platforms[]" class="form-control" multiple="" style="height: 200px !important;">
                            <option value="">--No Selection--</option>
                            <?php foreach ($tv_show_platforms as $platform) { ?>
                                <option value="<?=$platform['id']?>" 
                                        data-language="<?=$platform['language_id']?>"
                                        <?php if(isset($selected_tv_platforms) && in_array($platform['id'], $selected_tv_platforms)) echo "selected"; ?>>
                                    <?=$platform['name']?> (<?=$platform['language_name']?>)
                                </option>
                            <?php } ?>
                        </select>
                        <span class="text-danger tv-show-platforms-error" style="display:none;">Please select at least one TV Show Platform when status is enabled</span>
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update <?=$title?></button>
					           <a href="<?= BASE_URL ?>series/" class="btn btn-success ">Cancel</a>
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