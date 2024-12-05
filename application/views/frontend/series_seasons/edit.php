 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$pagetitle ?></h1>
       <?php echo $breadcrumb; ?>
    </section>
<?php
/*echo '<pre>';
print_r($details);*/
?>
    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
		
          <div class="box-body">
		  
            <form method="post" action="<?=BASE_URL?>series_seasons/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="series_id" value="<?=$series_id?>">
              <input type="hidden" name="tmdb_id" id="tmdb_id" value="<?php echo $details->tmdb_id?>">
              <input type="hidden" name="imported" id="imported" value="<?php echo $details->imported?>">
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="<?php echo $details->name?>" placeholder="<?=$title?> Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group">
                  <label for="season_number" class="col-sm-2 control-label">Season Number</label>
                  <div class="col-sm-4">
                   <input type="text" id="season_number" name="season_number" class="form-control" value="<?php echo $details->season_number?>" placeholder="Season Number"/>
                   <span class="text-danger"><?= form_error('season_number'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="poster" class="col-sm-2 control-label">Poster (342 X 513)</label>

                  <div class="col-sm-4">
                   <input type="file" id="poster" name="poster" onchange="showImg(this);" />
                  
                    <?php if($details->poster!="") {?>
                        <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->poster?>" width="200" id="thumb_image">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="backdrop" class="col-sm-2 control-label">Backdrop (1280 X 720)</label>

                  <div class="col-sm-4">
                   <input type="file" id="backdrop" name="backdrop" onchange="showImg2(this);"/>
                    <?php if($details->backdrop!="") { ?>
                      <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->backdrop?>" width="400" id="poster_image">
                    <?php }?>
                  </div>
                </div>
              </div>
         
              <div class="row"> 
                <div class="form-group">
                  <label for="year" class="col-sm-2 control-label">Year</label>

                  <div class="col-sm-2">
                   <input type="text" id="year" name="year" class="form-control"  value="<?php echo $details->year?>" placeholder="Year"/>
                   <span class="text-danger"><?= form_error('channel_epg_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="actor" class="col-sm-2 control-label">Seasons Cast</label>

                  <div class="col-sm-4">
                   <input type="text" id="actor" name="actor" class="form-control"  value="<?php echo $details->actor?>" placeholder="Actor"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
                </div>
              </div>

               <!-- <div class="row"> 
                <div class="form-group">
                  <label for="producer" class="col-sm-2 control-label">Producer</label>
                  <div class="col-sm-4">
                   <input type="text" id="producer" name="producer" class="form-control"  value="<?php echo $details->producer?>" placeholder="Producer"/>
                   <span class="text-danger"><?= form_error('producer'); ?></span>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="director" class="col-sm-2 control-label">Director</label>
                  <div class="col-sm-4">
                   <input type="text" id="director" name="director" class="form-control"  value="<?php echo $details->director?>" placeholder="Director"/>
                   <span class="text-danger"><?= form_error('director'); ?></span>
                  </div>
                </div>
              </div> -->

               <!-- <div class="row"> 
                <div class="form-group">
                  <label for="studio" class="col-sm-2 control-label">Studio</label>
                  <div class="col-sm-4">
                   <input type="text" id="studio" name="studio" class="form-control"  value="<?php echo $details->studio?>" placeholder="Studio"/>
                   <span class="text-danger"><?= form_error('studio'); ?></span>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <textarea id="description" name="description" cols="100" rows="5"><?php echo $details->description?></textarea>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="duration" class="col-sm-2 control-label">Length</label>
                  <div class="col-sm-2">
                   <input type="text" id="duration" name="duration" class="form-control" value="<?php echo $details->duration?>" placeholder="156"/>
                   <span class="text-danger"><?= form_error('duration'); ?></span>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="trailer" class="col-sm-2 control-label">Trailer Url</label>
                  <div class="col-sm-4">
                    <input type="text" id="trailer" name="trailer" class="form-control"  value="<?php echo $details->trailer?>" placeholder="Trailer"/>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="url" class="col-sm-2 control-label">Movie Url</label>
                  <div class="col-sm-4">
                    <input type="text" id="url" name="url" class="form-control"  value="<?php echo $details->url?>" placeholder="Url"/>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="language" class="col-sm-2 control-label">Language</label>
                  <div class="col-sm-2">
                    <select id="language" name="language" class="form-control">
                     <?php //foreach ($languages as $language) { ?>
                        <option value="<?=$language['id']?>" <?=($details->language==$language['id']) ? "selected" : ""?>><?=$language['name']?></option>
                     <?php //} ?>
                    </select>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="language" class="col-sm-2 control-label">Language</label>
                  <div class="col-sm-4">
                    <!-- Read-only display of inherited langua  ge -->
                    <select id="language" class="form-control" disabled>
                      <option value="<?=$series_info->language_id?>"><?=$series_info->language_name?></option>
                    </select>
                    <div class="help-block text-info" style="margin-top: 5px;">
                      <i class="fa fa-info-circle"></i>
                      Language is inherited from the series settings. To change, please update the main series configuration.
                    </div>
                  </div>
                </div>
              </div>


				<div class="row"> 
                <div class="form-group">
                  <label for="language" class="col-sm-2 control-label">Token</label>
                  <div class="col-sm-2">
                    <select id="token_id" name="token_id" class="form-control">
                      <option value="1" <?=($details->token_id== '1') ? "selected" : ""?>>Secure Stream</option>
                      <option value="2" <?=($details->token_id== '2') ? "selected" : ""?>>No Token</option>
                      <option value="3" <?=($details->token_id== '3') ? "selected" : ""?>>Akamai</option>
                      <option value="4" <?=($details->token_id== '4') ? "selected" : ""?>>Flussonic</option>
                    </select>
                  </div>
                </div>
              </div>
             <!-- <div class="row"> 
                <div class="form-group">
                  <label for="tags" class="col-sm-2 control-label">Tags</label>
                  <div class="col-sm-2">
                    <select id="tags" name="tags[]" class="form-control" multiple="">
                     <?php //foreach ($tags as $tag) { ?>
                              <option value="<?php echo $tag['id'];?>" <?php //echo (in_array($tag['id'],$selected_tags)) ? "selected" : ""; ?>><?php //echo $tag['name']; ?></option>
                     <?php //} ?>
                    </select>
                  </div>
                </div>
              </div>-->

              <div class="row"> 
                <div class="form-group">
                  <label for="rating" class="col-sm-2 control-label">Rating</label>
                  <div class="col-sm-1">
                    <select id="rating" name="rating" class="form-control">
                       <?php for($i=1;$i<=10; $i++){?>
                           <option value="<?=$i?>" <?=($i==$details->rating) ? "selected" : ""?>><?=$i?></option>
                      <?php  }?>
                    </select>
                  </div>
                </div>
              </div>

               <!-- <div class="row"> 
                <div class="form-group">
                  <label for="age_category" class="col-sm-2 control-label">Age Category</label>
                  <div class="col-sm-2">
                   <input type="text" id="age_category" name="age_category" class="form-control"  value="<?php echo $details->age_category?>" placeholder="Age Category"/>
                   <span class="text-danger"><?= form_error('age_category'); ?></span>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="tokenize" class="col-sm-2 control-label">Should Tokenize ?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="tokenize" class="onoffswitch-checkbox" id="tokenize" value="1" <?php if($details->tokenize==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="tokenize">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="token_id" class="col-sm-2 control-label">Token</label>
                  <div class="col-sm-2">
                   <select id="token_id" name="token_id" class="form-control">
                      <?php foreach($tokens as $token){ ?>
                        <option value="<?=$token->id?>" <?php if($token->id==$details->token_id) echo "selected";?>><?=$token->name?></option>
                     <?php } ?>
                   </select>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="is_payperview" class="col-sm-2 control-label">Is Pay Per View ?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="is_payperview" class="onoffswitch-checkbox" id="is_payperview" value="1" <?php if($details->is_payperview==1) echo "checked";?>>
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
                  <label for="rule_payperview" class="col-sm-2 control-label">Rule Pay Per View</label>
                  <div class="col-sm-4">
                   <input type="text" id="rule_payperview" name="rule_payperview" class="form-control" value="<?=$details->rule_payperview?>" placeholder="Rule Pay Per View"/>
                   <span class="text-danger"><?= form_error('rule_payperview'); ?></span>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="secure_stream" class="col-sm-2 control-label">Secure Stream ?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="secure_stream" class="onoffswitch-checkbox" id="secure_stream" value="1" <?php if($details->secure_stream==1) echo "checked";?>>
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
                  <label for="has_drm" class="col-sm-2 control-label">Has DRM ?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="has_drm" class="onoffswitch-checkbox" id="has_drm" value="1" <?php if($details->has_drm==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="has_drm">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="is_kids_friendly" class="col-sm-2 control-label">Is Kids Friendly</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="is_kids_friendly" class="onoffswitch-checkbox" id="is_kids_friendly" value="1" <?php if($details->is_kids_friendly==1) echo "checked";?>>
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
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="childlock" class="col-sm-2 control-label">Childlock</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" 
                             class="onoffswitch-checkbox" 
                             id="childlock"
                             <?= $series_info->childlock == '1' ? 'checked' : '' ?>
                             disabled>
                      <label class="onoffswitch-label" for="childlock" style="cursor: not-allowed; opacity: 0.7;">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                    <div class="help-block text-info" style="margin-top: 5px;">
                      <i class="fa fa-info-circle"></i>
                      Childlock setting is inherited from the series. To modify, please update the main series configuration.
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="subtitles" class="col-sm-2 control-label">Subtitles</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="subtitles" class="onoffswitch-checkbox" id="subtitles" value="1" <?php if($details->subtitles==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="subtitles">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="accessrule" class="col-sm-2 control-label">Access Rule</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="accessrule" class="onoffswitch-checkbox" id="accessrule" value="1" <?php if($details->accessrule==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="accessrule">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="overlay_enabled" class="col-sm-2 control-label">Overlay Enabled</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="overlay_enabled" class="onoffswitch-checkbox" id="overlay_enabled" value="1" <?php if($details->overlay_enabled==1) echo "checked";?>>
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
                  <label for="preroll_enabled" class="col-sm-2 control-label">Preroll Enabled</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="preroll_enabled" class="onoffswitch-checkbox" id="preroll_enabled" value="1" <?php if($details->preroll_enabled==1) echo "checked";?>>
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
                  <label for="ticker_enabled" class="col-sm-2 control-label">Ticker Enabled</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="ticker_enabled" class="onoffswitch-checkbox" id="ticker_enabled" value="1" <?php if($details->ticker_enabled==1) echo "checked";?>>
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
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" <?php if($details->show_on_home==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_on_home">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

			<?php if($series_info->episode_update == '1'){?>
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
			  
			  <div class="row" id="days_select" style=" display:<?php if($details->episode_update==1){ echo "block"; }else { echo "none"; } ?> "> 
                <div class="form-group">
                  <label for="episode_update" class="col-sm-2 control-label"></label>
                  <div class="col-sm-8" style="    border: 1px solid #ccc; padding: 10px 0;">
				  <div class="col-sm-12" style="margin-bottom:15px;margin-top: 15px;">				  	  
					  
					  <label for="mon_day" class="col-sm-2 control-label">MONDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="mon_day" class="onoffswitch-checkbox" id="mon_day" value="1" <?php if($details->mon_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="mon_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="tues_day" class="col-sm-2 control-label">TUESDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="tues_day" class="onoffswitch-checkbox" id="tues_day" value="1" <?php if($details->tues_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="tues_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="wednes_day" class="col-sm-2 control-label">WEDNESDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="wednes_day" class="onoffswitch-checkbox" id="wednes_day" value="1" <?php if($details->wednes_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="wednes_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
				  </div>
				  
				  <div class="col-sm-12" style="margin-bottom:15px;">					  
					  
					   <label for="thirs_day" class="col-sm-2 control-label">THIRSDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="thirs_day" class="onoffswitch-checkbox" id="thirs_day" value="1" <?php if($details->thirs_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="thirs_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					   <label for="fri_day" class="col-sm-2 control-label">FRIDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="fri_day" class="onoffswitch-checkbox" id="fri_day" value="1" <?php if($details->fri_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="fri_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="satur_day" class="col-sm-2 control-label">SATURDAY</label>
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
					
				  <div class="col-sm-12" style="margin-bottom:15px;"> 				   
					  
					  <label for="sun_day" class="col-sm-2 control-label">SUNDAY</label>
					  <div class="col-sm-2">					 
						<div class="onoffswitch">
						  <input type="checkbox" name="sun_day" class="onoffswitch-checkbox" id="sun_day" value="1" <?php if($details->sun_day==1) echo "checked";?> >
						  <label class="onoffswitch-label" for="sun_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					</div>
					
				  <div class="col-sm-12" style="margin-bottom: 15px;border-bottom: 1px solid #ccc;padding-bottom: 10px;border-top: 1px solid #ccc;">   
					<label for="actor" class="col-sm-2 control-label">Note</label>
                  	<div class="col-sm-4" style="margin-top: 8px;">
                   		<apan> &lt;Date&gt; &lt;Day&gt; &lt;Sequence&gt;</span>
                    </div>
				  </div>  
				  
				  <div class="col-sm-12" style="margin-bottom:15px;">   
					<label for="actor" class="col-sm-2 control-label">Title</label>
                  	<div class="col-sm-4">
                   <input type="text" id="title" name="title" class="form-control"  value="<?php echo $details->title?>" placeholder="Title"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
				  </div>  
					
					<div class="col-sm-12" style="margin-bottom:15px;">  
					 	<label for="actor" class="col-sm-2 control-label">URL</label>
                  		<div class="col-sm-4">
                   <input type="text" id="session_url" name="session_url" class="form-control"  value="<?php echo $details->session_url?>" placeholder="URL" />
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
					</div>
					<div class="col-sm-12" style="margin-bottom:15px;">  
					 	 <label for="actor" class="col-sm-2 control-label">Description</label>

                 		 <div class="col-sm-4">
                  
				   <textarea id="url_description" name="url_description" cols="80" rows="5" placeholder="Description..." ><?php echo $details->url_description ;?></textarea>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
					</div>
					
					 
				  </div>
				  
                </div>
              </div>
			  
		<?php } ?>
			 
              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update <?=$title?></button>
					<a href="<?= BASE_URL ?>series/seasons/<?=$series_id?>" class="btn btn-success ">Cancel</a>
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