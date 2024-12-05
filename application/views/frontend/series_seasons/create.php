 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$pagetitle ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content"> 
        <div class="box box-primary" style="display:none;">
         <div class="box-header with-border" style="text-align:center;" >
              <input type="hidden" id="from" name="from" value="tv">
              <div class="import-box col-sm-4" style="border: 1px solid #367fa9;padding: 0 0 20px 0px;text-align: center;margin-left:350px;">
                <h4 style="margin-top: 0;color: white;background-color: #3c8dbc;width: 100%;padding: 10px;">IMPORT SEASON FROM TMDB</h4>
                <div class="input-group input-group-sm" style="padding-left: 20px;padding-right: 20px;">
                  <input type="text" id="tmdbid" name="tmdbid" placeholder="Enter TMDB ID. Ex: 911" required="" class="form-control">
				  
                  <span class="input-group-btn">
                    <button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>
                  </span>
                </div>
                <div id="result" style="margin:20px;">
                  <div class="alert"></div>
                </div>

                <div>Please find season id from <a href="https://www.themoviedb.org" target="_blank">https://www.themoviedb.org</a></div>
              </div>
          </div>
        </div>
<?php 
	if($tmbd_idbm != ''){
?>
		<div class="box box-primary" id="series_show_list">
          <div class="box-body">
		 	<h3 class="box-title pull-right">
					<a href="<?php echo BASE_URL.'series/seasons/'.$series_id; ?>" class="btn btn-block btn-primary btn-flat">
						<i class="fa fa-arrow-left"></i> 
						Back to Seasons
					</a>
			</h3>
		
		  <?php 
		  		if($dbselect == 'tmdb'){
					$serise_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">
						<div style="width:20%;float:left;">.</div>
						<div style="width:20%;float:left;">Title</div>
						<div style="width:30%;float:left;">Release Year</div>
						<div style="width:20%;float:left;">Total Episode</div>
						<div tyle="width:10%;float:left;font-size:18px;font-waight:bold;">Action</div>
					</div>';
				}elseif($dbselect == 'imdb'){
					$serise_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">
						<div style="width:40%;float:left;">.</div>
						<div style="width:40%;float:left;">Title</div>						
						<div tyle="width:20%;float:left;font-size:18px;font-waight:bold;">Action</div>
					</div>';
				}
				$manually_add = '';
				if(count($getseasonsAll)>0){
					foreach ($getseasonsAll as $key=>$val) {
					
								 // http://image.tmdb.org/t/p/w500//zvZBNNDWd5LcsIBpDhJyCB2MDT7.jpg
								 if($dbselect == 'tmdb'){
									  $serise_list_html.='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">
															<div style="width:20%;float:left;"><img src="http://image.tmdb.org/t/p/w500'.$val->poster_path.'" height="100" width="100"/></div>
															<div style="width:20%;float:left;">'.$val->name.'</div>
															<div style="width:30%;float:left;">'.$val->air_date.'</div>
															<div style="width:20%;float:left;">'.$val->episode_count.'</div>
															<div><a href="#" onclick="select_serese(\''.$tmbd_idbm.'\',\''.$val->id.'\',\''.$series_id.'\',\''.$dbselect.'\'); return false;" style="width:10%;float:left;font-size:18px;font-waight:bold;color:#45b010;">Add</a></div>
														</div>';
								
								}elseif($dbselect == 'imdb'){
										 $serise_list_html.='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">
														<div style="width:40%;float:left;"><img id="serise_'.$val->id.'" src="'.$val->poster_path.'" height="100" width="100"/></div>
														<div style="width:40%;float:left;">'.$val->name.'</div>														
														<div style="width:20%;float:left;"><a href="#" onclick="select_serese(\''.$tmbd_idbm.'\',\''.$val->id.'\',\''.$series_id.'\',\''.$dbselect.'\'); return false;" class="btn btn-block btn-primary btn-flat">Add</a></div>
													</div>';
								}			
					}
					//$manually_add = 'none';
				}else{
							 $serise_list_html.='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;">														
														<div style="width:100%;text-align: center;font-weight: bold;">No More Seasons</div>		
														<a href="#" onclick="open_edit_form(); return false;" class="btn btn-block btn-primary btn-flat">
															Add Manually
														</a>												
													</div>';
					//$manually_add = 'block';
				}
						
						echo $serise_list_html;
			?>
		  </div>
</div>

<?php 
}/*else{*/
?>
        <div class="box box-primary" style=" <?php if($tmbd_idbm != ''){ ?> display:none; <?php } ?>" id="edit_form">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>series_seasons/create/<?=$series_id?>" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="series_id" value="<?=$series_id?>">
              <input type="hidden" name="tmdb_id" id="tmdb_id" value="<?php echo $tmbd_idbm;?>">
			  <input type="hidden" name="dbselect" id="dbselect" value="">
              <input type="hidden" name="imported" id="imported" value="0">
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="" placeholder="<?=$title?> Name" required/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="season_number" class="col-sm-2 control-label">Season Number</label>
                  <div class="col-sm-4">
                   <input type="text" id="season_number" name="season_number" class="form-control" value="" placeholder="Season Number" required/>
                   <span class="text-danger"><?= form_error('season_number'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row" id="poster_row"> 
                <div class="form-group">
                  <label for="poster" class="col-sm-2 control-label">Poster (342 X 513)</label>
                  <div class="col-sm-4">
                    <div id="thumbnail_content">
                      <input type="file" id="poster" onchange="showImg(this);" name="poster" class="filestyle" data-input="false" accept="image/*">
                    </div>
                    <br>
                    <img id="thumb_image" src="<?php echo base_url().'uploads/default_image/thumbnail.jpg'; ?>" width="150" class="img-thumbnail" alt="">
                  </div>
                </div>
              </div>

              <div class="row" id="backdrop_row"> 
                <div class="form-group">
                  <label for="backdrop" class="col-sm-2 control-label">Backdrop (1280 X 720)</label>
                  <div class="col-sm-4">
                   <div id="poster_content">
                    <input type="file" id="backdrop" onchange="showImg2(this);" name="backdrop" class="filestyle" data-input="false" accept="image/*">
                   </div>
                   <img id="poster_image" src="<?php echo base_url().'uploads/default_image/poster.jpg'; ?>" width="350" class="img-thumbnail" alt="">
                  </div>
                </div>
              </div>
         
              <div class="row" id="year_row"> 
                <div class="form-group">
                  <label for="year" class="col-sm-2 control-label">Year</label>
                  <div class="col-sm-2">
                   <input type="text" id="year" name="year" class="form-control" placeholder="Year"/>
                   <span class="text-danger"><?= form_error('channel_epg_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row" id="moviecost_row"> 
                <div class="form-group">
                  <label for="actor" class="col-sm-2 control-label">Movie Cast</label>
                  <div class="col-sm-4">
                   <input type="text" id="actor" name="actor" class="form-control" placeholder="Actor"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row" id="description_row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <textarea id="description" name="description" cols="100" rows="5"></textarea>
                  </div>
                </div>
              </div>
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="language" class="col-sm-2 control-label">Language</label>
                  <!-- <div class="col-sm-2">
                    <select id="language" name="language" class="form-control">
                     <?php //foreach ($languages as $language) { ?>
                        <option value="<?=@$language['id']?>"><?= @$language['name']?></option>
                     <?php //} ?>
                    </select>
                  </div> -->
                   <div class="col-sm-4">
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
                      <option value="1">Secure Stream</option>
                      <option value="2">No Token</option>
                      <option value="3" selected="">Akamai</option>
                      <option value="4">Flussonic</option>
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
                        <option value="<?php //echo $tag['id']; ?>"><?php //echo $tag['name'];?></option>
                     <?php //} ?>
                    </select>
                  </div>
                </div>
              </div>-->

              <div class="row"> 
                <div class="form-group">
                  <label for="rating" class="col-sm-2 control-label">Rating</label>
                  <div class="col-sm-1">
                    <select id="rating" name="rating" class="form-control" >
                      <?php for($i=1;$i<=10; $i++){?>
                           <option value="<?=$i?>"><?=$i?></option>
                      <?php  }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_kids_friendly" class="col-sm-2 control-label">Is Kids Friendly</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="is_kids_friendly" class="onoffswitch-checkbox" id="is_kids_friendly" value="1" >
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
                      <input type="checkbox" name="childlock" class="onoffswitch-checkbox" id="childlock" value="1" >
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
                             value="1" 
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
                  <label for="ticker_enabled" class="col-sm-2 control-label">Ticker Enabled</label>
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
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" >
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
                      <input type="checkbox" name="episode_update" class="onoffswitch-checkbox" id="episode_update" value="1">
                      <label class="onoffswitch-label" for="episode_update">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

			<div class="row" id="days_select" style="display:none;"> 
                <div class="form-group">
                  <label for="episode_update" class="col-sm-2 control-label"></label>
                  <div class="col-sm-8" style="    border: 1px solid #ccc; padding: 10px 0;">
				  <div class="col-sm-12" style="margin-bottom:15px;margin-top: 15px;">
				  	 					  
					  <label for="mon_day" class="col-sm-2 control-label">MONDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="mon_day" class="onoffswitch-checkbox" id="mon_day" value="1">
						  <label class="onoffswitch-label" for="mon_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="tues_day" class="col-sm-2 control-label">TUESDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="tues_day" class="onoffswitch-checkbox" id="tues_day" value="1">
						  <label class="onoffswitch-label" for="tues_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					  <label for="wednes_day" class="col-sm-2 control-label">WEDNESDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="wednes_day" class="onoffswitch-checkbox" id="wednes_day" value="1">
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
						  <input type="checkbox" name="thirs_day" class="onoffswitch-checkbox" id="thirs_day" value="1">
						  <label class="onoffswitch-label" for="thirs_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					   <label for="fri_day" class="col-sm-2 control-label">FRIDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="fri_day" class="onoffswitch-checkbox" id="fri_day" value="1">
						  <label class="onoffswitch-label" for="fri_day">
							  <span class="onoffswitch-inner"></span>
							  <span class="onoffswitch-switch"></span>
						  </label>
						</div>
					  </div>
					  
					   <label for="satur_day" class="col-sm-2 control-label">SATURDAY</label>
					  <div class="col-sm-2">
					  
						<div class="onoffswitch">
						  <input type="checkbox" name="satur_day" class="onoffswitch-checkbox" id="satur_day" value="1" >
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
						  <input type="checkbox" name="sun_day" class="onoffswitch-checkbox" id="sun_day" value="1">
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
                   <input type="text" id="title" name="title" class="form-control"  value="" placeholder="Title"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
				  </div>
				  <div class="col-sm-12" style="margin-bottom:15px;">   
					<label for="actor" class="col-sm-2 control-label">URL</label>
                  	<div class="col-sm-4">
                   <input type="text" id="session_url" name="session_url" class="form-control"  value="" placeholder="URL"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
				  </div>
				    
				  <div class="col-sm-12" style="margin-bottom:15px;"> 
				  	<label for="actor" class="col-sm-2 control-label">Description</label>
                  	<div class="col-sm-4">
                   <!--<input type="text" id="description" name="description" class="form-control"  value="<?php echo $details->description ;?>" placeholder="URL"/>-->
				   <textarea id="url_description" name="url_description" cols="80" rows="5" placeholder="Description..."></textarea>
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
                    <button type="submit" class="btn btn-success ">Add <?=$title?></button>
					<a href="<?php echo BASE_URL.'series/seasons/'.$series_id; ?>" class="btn btn-success ">Cancel</a>
                  </div>
                </div>
              </div>

            </form>
          </div>
      </div>
<?php
/*}*/
?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 