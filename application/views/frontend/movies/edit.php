<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><?=$pagetitle ?></h1>
     <?php echo $breadcrumb; ?>
  </section>

  <!-- Main content -->
   <section class="content">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Edit Movie</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-1">View Detials</a></li>
        <li class=""><a href="#tab_3" data-toggle="tab" id="tab-menu-3">Activity Log</a></li>
        
	      <li class="dropdown pull-right">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            Settings <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li role="presentation"><?php if($details->status==1){?><a role="menuitem" tabindex="-1" href="<?=site_url('movies/disable/'.$details->id)?>">Disable Movie</a><?php }else{?><a role="menuitem" tabindex="-1" href="<?=site_url('movies/enable/'.$details->id)?>">Enable Movie</a> <?php }?></li>
          </ul>
        </li>
	      <li class="dropdown pull-right">
          <a href="#" onclick="update_select_movie('<?php echo $details->tmdb_id;?>','<?php echo $details->dbselect;?>'); return false;" style=" color:#008d4c;">Fetch Update Data</a></li>
	      <li class="dropdown pull-right"><a href="" style=" color:#008d4c;">Refresh</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="box box-primary">
            <div class="box-body">
              <form method="post" action="<?=BASE_URL?>movies/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="type" value="1">
                <input type="hidden" name="tmdb_id" id="tmdb_id" value="<?php echo $details->tmdb_id; ?>">
                <input type="hidden" name="imported" id="imported" value="<?php echo $details->imported; ?>">
                <input type="hidden" name="dbselect" id="dbselect" value="<?php echo $details->dbselect; ?>" />
                <input type="hidden" id="tag_bm" name="tag_bm" value="<?php echo implode(',',$selected_tags);?>" />
                <input type="hidden" id="genres_bm" name="genres_bm" value="<?php echo implode(',',$selected_genres);?>" />
                <div class="row"> 
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-4">
                      <input type="text" id="name" name="name" class="form-control" value="<?php echo stripslashes($details->name);?>" placeholder="<?=$title?> Name"/>
                      <span class="text-danger"><?= form_error('name'); ?></span>
                    </div>
              			<div class="col-sm-4">
              			  <!--<label for="name" class="col-sm-8 control-label">TMBD Id : </label>
              			  <label for="name" class="col-sm-2 control-label" id="settim_id"><?php echo $details->tmdb_id?></label>-->
              			  <label for="name" class="col-sm-8 control-label" id="settim_id_label"><?php echo strtoupper($details->dbselect); ?></label>
              			  <label for="name" class="col-sm-2 control-label" id="settim_id"><?php echo $details->tmdb_id; ?></label>
              			</div>
                  </div>
                </div>
               
                <div class="row"> 
                  <div class="form-group">
                    <label for="parent-store" class="col-sm-2 control-label">Stores</label>
                    <div class="col-sm-4">
                      <select id="parent-store" name="parent_store" class="form-control">
                     <option value="">Select a Store</option>
                          <?php foreach($stores as $store){?>
                               <option value="<?php echo $store['id']; ?>" <?php echo($store['id']==$parent_store_id) ? "selected": ""; ?> ><?php echo $store['name']; ?></option>
							 <?php   //if($store['id']==$parent_store_id){ ?>
							  <!-- <option value="<?php //echo $store['id']; ?>" selected><?php //echo $store['name']; ?></option> -->
							  <?php //}?>
                          <?php }?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row"> 
                  <div class="form-group">
                    <label for="sub-store" class="col-sm-2 control-label">Sub Stores </label>
                    <div class="col-sm-4">
                      <!--<select id="sub-store" name="sub_store" class="form-control">
                          <?php //if(count($sub_stores)>0) {?>
                              <option value="">Select a Store</option>
                                <?php  //foreach($sub_stores as $store){?>
                                  <option value="<?php echo $store['id'];?>" <?php echo ($store['id']==$sub_store_id) ? "selected": ""; ?> ><?php echo $store['name'];?></option>
                                <?php //}?>
                          <?php //}else{?>
                              <option value="">No Sub Store Available</option>
                          <?php //}?>
                      </select>-->
					
					<div id="sub-store">
						<?php if(count($sub_stores)>0) {?>                               
                                <?php  foreach($sub_stores as $store){?>
							  	<input type="checkbox" onclick="checksubstorebm('<?php echo $store['id'];?>')" name="sub_store[]" value="<?php echo $store['id'];?>" style="margin-right: 5px !important;" <?php if (in_array($store['id'], $sub_store_id)) { echo "checked"; } ?> ><?php echo $store['name'];?><br />
							  <?php } ?>
						<?php } ?>
					</div>
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
                                  <?php foreach($genres as $genre){?>
                                    <option value="<?=$genre->id?>"><?=$genre->name?></option>
                                  <?php } ?>
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
                                  <?php foreach($genres as $genre){?>
                                    <?php if(in_array($genre->id,$selected_genres)){?>
                                    <option value="<?=$genre->id?>"><?=$genre->name?></option>
                                    <?php }?>
                                  <?php } ?>
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
				  <input type="file" id="poster" onchange="showImg(this);" name="poster" class="filestyle" data-input="false" accept="image/*">
          <p class="help-block">Please upload a portrait image with width/height ratio between 0.5 and 0.7</p>
          <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                    <!-- <input type="file" id="poster" name="poster"/>
				   <input type="hidden" id="poster_remote" name="poster_remote" value="" />-->
				   </div>
                      <?php //if($details->poster!="") {?>
                          <img id="thumb_image" class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->poster?>" width="200">
                      <?php //}?>
					
                    </div>
                  </div>
                </div>

                <div class="row"> 
                  <div class="form-group">
                    <label for="backdrop" class="col-sm-2 control-label">Backdrop</label>
                    <div class="col-sm-8">
                     <!--<input type="file" id="backdrop" name="backdrop"/>-->
				   <div id="poster_content">
				    <input type="file" id="backdrop" onchange="showImg2(this);" name="backdrop" class="filestyle" data-input="false" accept="image/*">

				  <!-- <input type="hidden" id="backdrop_remote" name="backdrop_remote" value="" />-->
				   </div>
                      <?php //if($details->backdrop!="") { ?>
                        <img id="poster_image" class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->backdrop?>" width="400">
                      <?php //}?>
					
					<div id="list_images">
						<?php
							$lc = 0;
              if(isset($list_image)){
							foreach($list_image as $key=>$val){
						?>
						<div style="float:left;cursor: pointer;margin-top: 5px;" onclick="list_image_select_edit('<?php echo $lc; ?>');">
							<img id="list_img_<?php echo $lc; ?>" src="<?php echo $val; ?>" alt="<?php echo $val; ?>" width="200" class="img-thumbnail" />
						</div>
						<?php 
							$lc++;
							}
              }
						 
             ?>
					</div>
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
                    <label for="actor" class="col-sm-2 control-label">Movie Cast</label>

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
                     <textarea id="description" name="description" cols="100" rows="5"><?php echo str_replace('\\', '', $details->description);?></textarea>
                    </div>
                  </div>
                </div>

                <div class="row"> 
                  <div class="form-group">
                    <label for="duration" class="col-sm-2 control-label">Length (Min)</label>
                    <div class="col-sm-2">
                     <input type="text" id="duration" name="duration" class="form-control" value="<?php echo $details->duration?>" placeholder="156"/>
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
                                    <option value="<?=$url->id?>" <?=($details->server_url_trailer==$url->id) ? "selected" : ""?>><?=$url->name?></option>
                                 <?php } ?>
                                </select>
                              </div>

                              
                                <div class="col-sm-7">
                                  <div class="input-group">
                                    <input type="text" id="trailer" name="trailer" value="<?=$details->trailer?>" class="form-control" placeholder="Trailer Stream Name" required />
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info verify-url" data-url-type="trailer" data-url-id="trailer">Verify</button>
                                      <button type="button" class="btn btn-primary play-url" data-url-id="trailer">Play</button>
                                    </span>
                                  </div>
                                  <div class="url-message"></div>
                                  <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                                  <span class="text-danger"><?= form_error('trailer'); ?></span>
                                </div>

                                <!-- <div class="col-sm-7">
                                <input type="text" id="trailer" name="trailer" value="<?=$details->trailer?>" class="form-control" placeholder="Trailer Stream Name" required />
                                <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                                <span class="text-danger"><?= form_error('trailer'); ?></span>
                                </div> -->
                            </div>
                          </div>
                        </div>

                        <!--<div class="row"> 
                          <div class="form-group">
                            <div class="col-sm-12">
                              <label for="token_trailer" class="col-sm-2 control-label">Tokenize</label>
                              <div class="col-sm-6">
                                <select id="token_trailer" name="token_trailer" class="form-control">
                                 <?php //foreach($tokens as $token){ ?>
                                    <option value="<?php //echo $token->id; ?>" <?php //echo ($details->token_trailer==$token->id) ? "selected" : ""; ?>><?php //echo $token->name; ?></option>
                                 <?php //} ?>
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
                  
                <?php $i=1;
                if(count($movie_urls)>0){?>
                  <input type="hidden" name="movie_url_count" id="movie_url_count" value="<?=count($movie_urls)?>">
                <?php  foreach($movie_urls as $stream){?>
                    <div class="form-group" id="box-<?=$i?>">
                      <label for="server_url_<?=$i?>" class="col-sm-2 control-label">Movie Url <span id="count_<?=$i?>"><?=$i?></span></label>
                      <div class="col-sm-8" >
                        <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                          <div class="row"> 
                            <div class="form-group">
                              <div class="col-sm-12">
                                <label for="server_url_<?=$i?>" class="col-sm-2 control-label">Url</label>
                                <div class="col-sm-3">
                                  <select id="server_url_<?=$i?>" name="server_url_<?=$i?>" class="form-control">
                                      <option value="">Select a Url</option>
                                   <?php foreach($server_urls as $url){ ?>
                                      <option value="<?=$url->id?>" <?=($stream->server_url_id==$url->id) ? "selected" : ""?>><?=$url->name?></option>
                                   <?php } ?>
                                  </select>
                                </div>


                                <div class="col-sm-7">
                                  <div class="input-group">
                                    <input type="text" id="stream_name_<?=$i?>" name="stream_name_<?=$i?>" value="<?=$stream->stream_name?>" class="form-control" required/>
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-info verify-url" data-url-type="movie" data-url-id="stream_name_<?=$i?>">Verify</button>
                                      <button type="button" class="btn btn-primary play-url" data-url-id="stream_name_1">Play</button>

                                    </span>
                                  </div>
                                  <div class="url-message"></div>
                                  <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                                  <span class="text-danger"><?= form_error('url'); ?></span>
                                </div>
                                
                                <!-- <div class="col-sm-7">
                                  <input type="text" id="stream_name_<?=$i?>" name="stream_name_<?=$i?>" value="<?=$stream->stream_name?>" class="form-control" required/>
                                  <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                                  <span class="text-danger"><?= form_error('url'); ?></span>
                                </div> -->
                              </div>
                            </div>
                          </div>

                          <div class="row"> 
                            <div class="form-group">
                              <div class="col-sm-12">
                                <label for="movie_language_<?=$i?>" class="col-sm-2 control-label">Language</label>
                                <div class="col-sm-3">
                                  <select id="movie_language_<?=$i?>" name="movie_language_<?=$i?>" class="form-control">
                                    <?php foreach ($languages as $language) { ?>
                                      <option value="<?=$language['id']?>" <?=($stream->language_id==$language['id']) ? "selected" : ""?>><?=$language['name']?></option>
                                    <?php } ?>
                                  </select>
                                </div>

                                <label for="movie_token_<?=$i?>" class="col-sm-2 control-label">Tokenize</label>
                                <div class="col-sm-4">
                                  <select id="movie_token_<?=$i?>" name="movie_token_<?=$i?>" class="form-control">
                                   <?php foreach($tokens as $token){ ?>
                                      <option value="<?php echo $token->id; ?>" <?php echo ($stream->token_id==$token->id) ? "selected" : ""; ?>><?php echo $token->name; ?></option>
                                   <?php } ?>
                                  </select>
                                </div>
							  
							 
										  
                              </div>
                            </div>
                          </div>
						
						
						<div class="row"> 
								<div class="form-group">
									<div class="col-sm-12">
										<label for="rating" class="col-sm-2 control-label">Subtitle Url</label>
										<div class="col-sm-4">
											 <input type="text" id="movie_subtitleurl_<?=$i?>" name="movie_subtitleurl_<?=$i?>" value="<?=$stream->movie_subtitleurl?>" class="form-control" />                                    
										</div>
									</div>
								</div>
							  </div>
                        </div>
                      </div>
                      <span class="glyphicon glyphicon-remove"></span>
                    </div>
                  <?php $i++;
                  }
                } else{?>
                  <input type="hidden" name="movie_url_count" id="movie_url_count"  value="1">
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
                                    <option value="<?=$url->id?>" ><?=$url->name?></option>
                                 <?php } ?>
                                </select>
                              </div>

                              <div class="col-sm-7">
                                <input type="text" id="stream_name_1" name="stream_name_1" value="<?=set_value('stream_name_1')?>" class="form-control" placeholder="Movie Stream Name" required/>
                                <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                                <span class="text-danger"><?= form_error('stream_name_1'); ?></span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row"> 
                          <div class="form-group">
                            <div class="col-sm-12">
                              <label for="" class="col-sm-2 control-label">Language</label>
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
                                    <option value="<?php echo $token->id; ?>"><?php $token->name; ?></option>
                                 <?php } ?>
                                </select>
                              </div>
							
							


                            </div>
                          </div>
                        </div>
					  
					  
					   <div class="row"> 
								<div class="form-group">
									<div class="col-sm-12">
										<label for="rating" class="col-sm-2 control-label">Subtitle Url</label>
										<div class="col-sm-4">
											 <input type="text" id="movie_subtitleurl_<?=$i?>" name="movie_subtitleurl_<?=$i?>" value="<?=$stream->movie_subtitleurl?>" class="form-control" />                                    
										</div>
									</div>
								</div>
							  </div>
                      </div>
                    </div>
                    <span class="glyphicon glyphicon-remove"></span>
                  </div>
                <?php }?>
                </div>
            
                <div class="row" id="add-more-btn-row">
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
                      <select id="language" name="language" class="form-control">
                       <?php foreach ($languages as $language) { ?>
                          <option value="<?=$language['id']?>" <?=($details->language==$language['id']) ? "selected" : ""?>><?=$language['name']?></option>
                       <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                

                <!--  <div class="row"> 
                  <div class="form-group">
                    <label for="tags" class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-4">
                     <input type="text" id="tags" name="tags" class="form-control"  value="<?php echo $details->tags?>"  placeholder="Tags"/>
                    </div>
                  </div>
                </div> -->

                <div class="row"> 
                  <div class="form-group">
                    <label for="rating" class="col-sm-2 control-label">Rating</label>
                    <div class="col-sm-1">
                     <!-- <select id="rating" name="rating" class="form-control">
                         <?php //for($i=1;$i<=10; $i++){?>
                             <option value="<?php //echo $i; ?>" <?php //echo ($i==$details->rating) ? "selected" : ""; ?>><?php //echo $i; ?></option>
                        <?php  //}?>
                      </select>-->
					
					<input type="text" id="rating" name="rating" value="<?php echo $details->rating;?>" />
                    </div>
                  </div>
                </div>
			 
		  <div class="row"> 
              <div class="form-group">
                <label for="rating" class="col-sm-2 control-label">Content Rating</label>
                <div class="col-sm-1">
			  <input type="text" id="age_rating" name="age_rating" value="<?php echo $details->age_rating;?>" required />                    
                </div>
              </div>
            </div>
		  
		  <!--<div class="row"> 
              <div class="form-group">
                <label for="rating" class="col-sm-2 control-label">Subtitle Url</label>
                <div class="col-sm-1">
			  <input type="text" id="subtitle_url" name="subtitle_url" value="<?php //echo $details->subtitle_url;?>" />                    
                </div>
              </div>
            </div>-->
		  
		  
		  
		  
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

               <!--  <div class="row"> 
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
<!--
                <div class="row"> 
                  <div class="form-group">
                    <label for="subtitles" class="col-sm-2 control-label">Subtitles</label>
                    <div class="col-sm-4">
                      <div class="onoffswitch">
                        <input type="checkbox" name="subtitles" class="onoffswitch-checkbox" id="subtitles" value="1" <?php //if($details->subtitles==1) echo "checked";?>>
                        <label class="onoffswitch-label" for="subtitles">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
-->

               <!--  <div class="row"> 
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
                    <label for="ticker_enabled" class="col-sm-2 control-label">Ticker</label>
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
			     <div class="row"> 
              <div class="form-group">
                <label for="rating" class="col-sm-2 control-label">Vast Url</label>
                <div class="col-sm-4">
			          <input type="text" id="vast_url" name="vast_url" value="<?php echo $details->vast_url; ?>" class="form-control" />                    
                </div>
              </div>
            </div>
		  
                <div class="row">
                  <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4">
                      <!--<button type="submit" class="btn btn-success ">Update <?=$title?></button>-->
					            <input type="submit" class="btn btn-success " value="Update <?=$title?>" name="submitbtn">
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>

          <div class="tab-pane" id="tab_2">
            <div class="box box-primary">
              <div class="box-body">
                <!-- Movie Details View -->
                <div class="row">
                  <div class="col-md-3">
                    <!-- Poster -->
                    <div class="movie-poster">
                      <?php if($details->poster != ""): ?>
                        <img src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->poster?>" width="50" class="img-responsive">
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="col-md-9">
                    <!-- Basic Info -->
                    <div class="movie-info">
                      <h3><?=stripslashes($details->name)?></h3>
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table table-striped">
                            <tr>
                              <th width="150">Created By</th>
                              <td><?=$details->created_by;?></td>
                              <!-- <td><?=$this->movies_m->get_user_details($details->user_id)?></td> --> 
                            </tr>
                            <tr>
                              <th>Created Date</th>
                              <td><?=date('d M Y H:i:s', strtotime($details->created_at))?></td>
                            </tr>
                            <tr>
                              <th>Last Updated</th>
                              <td><?=date('d M Y H:i:s', strtotime($details->updated_at))?></td>
                            </tr>
                            <tr>
                              <th>Status</th>
                              <td>
                                <?php if($details->status == 1): ?>
                                  <span class="label label-success">Active</span>
                                <?php else: ?>
                                  <span class="label label-danger">Inactive</span>
                                <?php endif; ?>
                              </td>
                            </tr>
                          </table>
                        </div>

                        <div class="col-md-6">
                          <table class="table table-striped">
                            <tr>
                              <th width="150">Year</th>
                              <td><?=$details->year?></td>
                            </tr>
                            <tr>
                              <th>Duration</th>
                              <td><?=$details->duration?> mins</td>
                            </tr>
                            <tr>
                              <th>Rating</th>
                              <td><?=$details->rating?>/10</td>
                            </tr>
                            <tr>
                              <th>Age Rating</th>
                              <td><?=$details->age_rating?></td>
                            </tr>
                          </table>
                        </div>
                      </div>

                      <!-- Description -->
                      <div class="row">
                        <div class="col-md-12">
                          <h4>Description</h4>
                          <p><?=nl2br(stripslashes($details->description))?></p>
                        </div>
                      </div>

                      <!-- Cast & Genres -->
                      <div class="row">
                        <div class="col-md-12">
                          <h4>Cast & Categories</h4>
                          <table class="table table-striped">
                            <tr>
                              <th width="150">Cast</th>
                              <td><?=$details->actor?></td>
                            </tr>
                            <tr>
                              <th>Genres</th>
                              <td>
                                <?php 
                                $genres = explode(',', $details->select_genres);
                                foreach($genres as $genre) {
                                  if(isset($all_genres_array['id_'.$genre])) {
                                    echo '<span class="label label-info">'.$all_genres_array['id_'.$genre].'</span> ';
                                  }
                                }
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <th>Tags</th>
                              <td>
                                <?php
                                $tags = explode(',', $details->tags); 
                                foreach($tags as $tag) {
                                  if(isset($tags_array['tags_'.$tag])) {
                                    echo '<span class="label label-primary">'.$tags_array['tags_'.$tag].'</span> ';
                                  }
                                }
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <th>OTT Platforms</th>
                              <td>
                                <?php
                                $platforms = explode(',', $details->ott_platforms);
                                foreach($platforms as $platform) {
                                  if(isset($ott_platforms_array['platform_'.$platform])) {
                                    echo '<span class="label label-success">'.$ott_platforms_array['platform_'.$platform].'</span> ';
                                  }
                                }
                                ?>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>

                      <!-- Settings -->
                      <div class="row">
                        <div class="col-md-12">
                          <h4>Settings</h4>
                          <table class="table table-striped">
                            <tr>
                              <th width="150">Show on Home</th>
                              <td><?=$details->show_on_home ? 'Yes' : 'No'?></td>
                            </tr>
                            <tr>
                              <th>Kids Friendly</th>
                              <td><?=$details->is_kids_friendly ? 'Yes' : 'No'?></td>
                            </tr>
                            <tr>
                              <th>Child Lock</th>
                              <td><?=$details->childlock ? 'Yes' : 'No'?></td>
                            </tr>
                            <tr>
                              <th>Features</th>
                              <td>
                                <?php if($details->overlay_enabled): ?>
                                  <span class="label label-info">Overlay</span>
                                <?php endif; ?>
                                <?php if($details->preroll_enabled): ?>
                                  <span class="label label-info">Preroll</span>
                                <?php endif; ?>
                                <?php if($details->ticker_enabled): ?>
                                  <span class="label label-info">Ticker</span>
                                <?php endif; ?>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_3">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Movie Activity Log</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive" class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="150">Date & Time</th>
                        <th width="150">User</th>
                        <th>Action</th>
                        <th width="100">IP Address</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(!empty($movie_logs)): ?>
                        <?php foreach($movie_logs as $log): ?>
                          <tr>
                            <td><?=date('d M Y H:i:s', $log['timestamp'])?></td>
                            <td>
                              <?php 
                              $user_name = $log['first_name'] . ' ' . $log['last_name'];
                              echo !empty(trim($user_name)) ? $user_name : $log['username'];
                              ?>
                            </td>
                            <td><?=$log['action']?></td>
                            <td><?=$log['ip_address']?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No activity logs found</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
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