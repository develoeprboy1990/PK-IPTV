  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><?=$pagetitle ?></h1>
     <?php echo $breadcrumb; ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box box-primary">
      <div class="box-header with-border" style="text-align:center;">
        <input type="hidden" id="from" name="from" value="movie">			  
        <div class="import-box col-sm-4" style="border: 1px solid #367fa9;padding: 0 0 20px 0px;text-align: center;margin-left:350px;">
          <h4 style="margin-top: 0;color: white;background-color: #3c8dbc;width: 100%;padding: 10px;">IMPORT MOVIES/VIDEOS FROM TMDB / IMDB</h4>
          <div class="input-group input-group-sm" style="float:left;">
            <div>
              <input type="checkbox" id="imdb" name="imdb" value="imdb">
              <label for="FROM IMDB" style="margin-left: 5px;"> FROM IMDB</label>
            </div>
            <div>
              <input type="checkbox" id="tmdb" name="tmdb" value="tmdb">
              <label for="FROM TMDB" style="margin-left: 5px;"> FROM TMDB</label>
            </div>
            <div style="margin-left: 28px;">
              <input type="checkbox" id="manual" name="manual" value="manual">
              <label for="Manual Import Data" style="margin-left: 5px;">MANUAL IMPORT</label>
            </div>
          </div>
          <div id="search_boxbm"></div>
          <!--<div class="input-group input-group-sm" style="padding-left: 5px;padding-right: 5px;">
            <input type="text" id="tmdbid" name="tmdbid" placeholder="Enter TMBD ID or Name. Ex: 141052 or Jack" required="" class="form-control">
            <span class="input-group-btn">
              <button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>
            </span>
          </div>-->
          <div id="result" style="margin:20px;">
            <div class="alert" id="resbmbm"></div>
          </div>
          <!--  <div>Please find movie id from <a href="https://www.themoviedb.org" target="_blank">https://www.themoviedb.org</a></div>-->
        </div>
        <div style="float: right;"><a href="" class="btn btn-success" style="background-color:#3c8dbc;">Refresh</a></div>
      </div>
    </div>
    <!--<div class="box box-primary" id="loading_movie" style="display:none;">
		  <div class="box-body">
			 <div id="tmbm_searchresult"></div>
		  </div>
	   </div>-->
    <div class="box box-primary" id="movie_boxbm" style="display:none;">
    		<div class="box-body">
    			<div id="tmbm_searchresult"></div>
    		</div>
    	</div>
    <div class="box box-primary" id="movie_boxbm_select" style="display:none;">
      <div class="box-body">
	        <div id="message_dataselect" style="text-align: center;padding-bottom: 20px;font-size: 20px;"></div>
            <form method="post" action="<?= BASE_URL ?>movies/create/<?=(isset($type)) ? $type : "";?>" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="type" value="1">
              <input type="hidden" name="tmdb_id" id="tmdb_id" value="">
              <input type="hidden" name="imported" id="imported" value="0">
              <input type="hidden" name="dbselect" id="dbselect" value="" />
              <input type="hidden" id="tag_bm" name="tag_bm" value="" />
              <input type="hidden" id="genres_bm" name="genres_bm" value="" />
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                    <input type="text" id="name" name="name" class="form-control" value="" placeholder="<?=$title?> Name" required/>
                    <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
          			  <div class="col-sm-4">
          			   <label for="name" class="col-sm-8 control-label" id="settim_id_label"></label>
          			   <label for="name" class="col-sm-2 control-label" id="settim_id"></label>
          			  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                <label for="parent-store" class="col-sm-2 control-label">Store</label>
                  <div class="col-sm-2">
                    <select id="parent-store" name="parent_store" class="form-control" required>
                      <option value="">Select a Store</option>
                      <?php foreach ($stores as $store) {?>
                      <option value="<?php echo $store->id; ?>"><?php echo $store->name;?></option>
                    <?php }?>
                    </select>
                    <?php //foreach ($stores as $store) {?>
                      <!--<input type="checkbox" name="parent_store[]" value="<?php //echo $store->id; ?>" style="margin-right: 5px;"><?php //echo $store->name;?><br />-->
                    <?php //}?>
                  </div> 
                </div>
              </div>		  
              <div class="row"> 
                <div class="form-group">
                  <label for="sub-store" class="col-sm-2 control-label">Sub Stores</label>
                  <div class="col-md-2">
                    <!--<select id="sub-store" name="sub_store" class="form-control" required></select>-->
                    <div id="sub-store"></div>
                  </div>
                </div>
              </div>
              <!-- Replace the existing Tags and OTT Platforms sections with this -->
              <div class="row">
                <div class="form-group">
                  <label for="tags" class="col-sm-2 control-label">Tags & Platforms</label>
                  <div class="col-sm-8">
                    <div class="row">
                      <!-- Tags Select -->
                      <div class="col-sm-6">
                        <label>Tags</label>
                        <select id="tags" name="tags[]" class="form-control" multiple="" style="height: 200px !important; overflow-y: auto;">
                          <?php foreach ($tags as $tag) { ?>
                            <option value="<?=$tag['id']?>" <?=(in_array($tag['id'],$selected_tags)) ? "selected" : ""?>><?=$tag['name']?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <!-- OTT Platforms Select -->
                      <div class="col-sm-6">
                        <label>OTT Platforms</label>
                        <select id="ott_platforms" name="ott_platforms[]" class="form-control" multiple="" required style="height: 200px !important; overflow-y: auto;">
                          <option value="">--No Selection--</option>
                          <?php foreach ($ott_platforms as $platform) { ?>
                            <option value="<?=$platform['id']?>" <?=(in_array($platform['id'], $selected_ott_platforms)) ? "selected" : ""?>><?=$platform['name']?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="genre_group" class="col-sm-2 control-label">Genres</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="genre_group" id="multiselect_left" class="form-control" size="15" multiple="multiple">
                              <!--  <option>Nepa</option>
                                 <option>Weba</option> -->
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right" class="form-control" name="genres[]" size="15" multiple="multiple">
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
              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="year" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4" style="font-size:16px; font-weight:bold;">
                  <input type="checkbox" name="poster_backdrop" value="1" style="margin-right: 10px;" />Poster image will be same as Backdrop
                  </div>
                </div>
              </div>-->
              <div class="row"> 
                <div class="form-group">
                  <label for="poster" class="col-sm-2 control-label">Poster</label>
                  <div class="col-sm-9">
                   
                    <div id="thumbnail_content">
                    <!-- 
                      <input type="file" id="poster" onchange="showImg(this);" name="poster" class="filestyle" data-input="false" accept="image/*">
                      <input type="hidden" id="poster_remote" name="poster_remote" value="" />
                     -->
                      <input type="file" id="poster" onchange="showImg(this);" name="poster" class="filestyle" data-input="false" accept="image/*" required>
                      <input type="hidden" id="poster_remote" name="poster_remote" value="" />
                      <p class="help-block">Please upload a portrait image with width/height ratio between 0.5 and 0.7</p>
                      <?php if($this->session->flashdata('error')): ?>
                          <div class="alert alert-danger">
                              <?php echo $this->session->flashdata('error'); ?>
                          </div>
                      <?php endif; ?>
                     </div>
                    <br>
                    <img id="thumb_image" src="<?php echo base_url().'uploads/default_image/thumbnail.jpg'; ?>" width="150" class="img-thumbnail" alt="">
                  </div>
                </div>
              </div>
              <div class="row"> 
              <div class="form-group">
                <label for="backdrop" class="col-sm-2 control-label">Backdrop</label>
                <div class="col-sm-8">
                 <div id="poster_content">
                    <input type="file" id="backdrop" onchange="showImg2(this);" name="backdrop" class="filestyle" data-input="false" accept="image/*" required>
                    <input type="hidden" id="backdrop_remote" name="backdrop_remote" value="" />
		            </div>
                 <img id="poster_image" src="<?php echo base_url().'uploads/default_image/poster.jpg'; ?>" width="350" class="img-thumbnail" alt="">
			           <div id="list_images"></div>
                </div> 
              </div>
            </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="year" class="col-sm-2 control-label">Year</label>
                  <div class="col-sm-2">
                   <input type="text" id="year" name="year" class="form-control" placeholder="Year"/>
                   <span class="text-danger"><?= form_error('channel_epg_name'); ?></span>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="actor" class="col-sm-2 control-label">Movie Cast</label>

                  <div class="col-sm-4">
                   <input type="text" id="actor" name="actor" class="form-control" placeholder="Actor"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <textarea id="description" name="description" cols="100" rows="5"></textarea>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="duration" class="col-sm-2 control-label">Length (Min)</label>
                  <div class="col-sm-2">
                   <input type="text" id="duration" name="duration" class="form-control" placeholder="156"/>
                   <span class="text-danger"><?= form_error('duration'); ?></span>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="server_url_trailer" class="col-sm-2 control-label">Trailer Url</label>
                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_url_trailer" class="col-sm-2 control-label">Url</label>
                            <div class="col-sm-3">
                              <select id="server_url_trailer" name="server_url_trailer" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" selected><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="text" id="trailer" name="trailer" value="<?=set_value('trailer')?>" class="form-control" placeholder="Trailer Stream Name" required />
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-info verify-url" data-url-type="trailer" data-url-id="trailer">Verify</button>
                                  <button type="button" class="btn btn-primary play-url" data-url-id="trailer">Play</button>
                                </span>
                              </div>
                              <div class="url-message"></div>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('trailer'); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!--<div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_trailer" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_trailer" name="token_trailer" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>-->
  				  
                    </div>
                  </div>
                </div>
              </div>              
              <div class="row" id="main"> 
                <input type="hidden" name="movie_url_count" id="movie_url_count" value="1" >
                <div class="form-group" id="box-1">
                  <label for="" class="col-sm-2 control-label">Movie Url <span id="count_1">1</span></label>
                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="" class="col-sm-2 control-label">Url</label>
                            <div class="col-sm-3">
                              <select id="server_url_1" name="server_url_1" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" selected><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                            
                            <div class="col-sm-7">
                              <div class="input-group">
                                <input type="text" id="stream_name_1" name="stream_name_1" value="<?=set_value('stream_name_1')?>" class="form-control" placeholder="Movie Stream Name" required/>
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-info verify-url" data-url-type="movie" data-url-id="stream_name_1">Verify</button>
                                  <button type="button" class="btn btn-primary play-url" data-url-id="stream_name_1">Play</button>
                                </span>
                              </div>
                              <div class="url-message"></div>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('stream_name_1'); ?></span>
                            </div>

                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="" class="col-sm-2 control-label">Languageasdfads</label>
                            <div class="col-sm-4">
                              <select id="movie_language_1" name="movie_language_1" class="form-control">							  	
                                <?php foreach ($languages as $language) { ?>
                                  <option value="<?=$language['id']?>"><?=$language['name']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <label for="" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-4">
                              <select id="movie_token_1" name="movie_token_1" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>"><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
  						
  						
  						<!-- <label for="rating" class="col-sm-2 control-label">Subtitle Url</label>
  								<div class="col-sm-4">
  									<input type="text" id="movie_subtitleurl_1" name="movie_subtitleurl_1" class="form-control" />                    
  								</div>-->

                          </div>
                        </div>
                      </div>
  				  
  				  
  				  
  				  
  				 
                          
  							  <div class="row"> 
  								<div class="form-group">
  									<div class="col-sm-12">
  										<label for="rating" class="col-sm-2 control-label">Subtitle Url</label>
  										<div class="col-sm-4">
  											<input type="text" id="movie_subtitleurl_1" name="movie_subtitleurl_1" class="form-control" />                    
  										</div>
  									</div>
  								</div>
  							  </div>
  							  
  		  
                    </div>
                  </div>
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
              </div>
              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <a href="javascript:void(0);" class="btn btn-warning add-more">Add Movie Url</a>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="language" class="col-sm-2 control-label">Language</label>
                  <div class="col-sm-2">
                    <select id="language" name="language" class="form-control" required>
  				<option value="">Select Language</option>
                     <?php foreach ($languages as $language) { ?>
                        <option value="<?=$language['id']?>"><?=$language['name']?></option>
                     <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <!--  <div class="row"> 
              <div class="form-group">
                <label for="tags" class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-4">
                 <input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput"  placeholder="Tags"/>
                </div>
              </div>
            </div> -->
              <div class="row"> 
                <div class="form-group">
                  <label for="rating" class="col-sm-2 control-label">Rating</label>
                  <div class="col-sm-2">
  			            <input type="text" id="rating" name="rating" class="form-control" />
                    <!--<select id="rating" name="rating" class="form-control" >
                      <?php //for($i=1;$i<=10; $i++){?>
                           <option value="<?php //echo $i; ?>"><?php //echo $i; ?></option>
                      <?php // } ?>
                    </select>-->
                  </div>
                </div>
              </div>
  		        <div class="row"> 
                <div class="form-group">
                  <label for="rating" class="col-sm-2 control-label">Content Rating</label>
                  <div class="col-sm-2">
  			             <input type="text" id="age_rating" name="age_rating" class="form-control" required />                    
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
              <div class="row"> 
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
              </div>
              <div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="subtitles" class="col-sm-2 control-label">Subtitles</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="subtitles" class="onoffswitch-checkbox" id="subtitles" value="1" >
                      <label class="onoffswitch-label" for="subtitles">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
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
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" >
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
                      <label for="rating" class="col-sm-2 control-label">Vast Url</label>
                      <div class="col-sm-4">
      			  <input type="text" id="vast_url" name="vast_url" class="form-control" />                    
                      </div>
                    </div>
                  </div>
              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
  <!--                    <button type="submit" class="btn btn-success ">Add <?=$title?></button>
  -->    
  				<input type="submit" class="btn btn-success " value="Add <?=$title?>" name="submitbtn">
  	           </div>
                </div>
              </div>
          </form>
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper     -->
<!-- Modal for video player -->
<div class="modal fade" id="videoPlayerModal" tabindex="-1" role="dialog" aria-labelledby="videoPlayerModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="videoPlayerModalLabel">Video Player</h4>
      </div>
      <div class="modal-body">
        <div id="videoContainer" style="position: relative;">
          <video id="videoPlayer" controls style="width: 100%;">
            Your browser does not support the video tag.
          </video>
          <div id="videoStats" style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 10px; font-size: 12px; display: none;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <?php if($movie_url_permission && $movie_url_permission->allow_view == 1): ?>
          <button id="copyUrlBtn" class="btn btn-sm btn-primary">
            <i class="fa fa-copy"></i> Copy URL
          </button>
        <?php endif; ?>
       <!--  <button onclick="toggleVideoStats()" class="btn btn-sm btn-info">
          <i class="fa fa-info-circle"></i> Toggle Stats
        </button> -->
      </div>
    </div>
  </div>
</div>