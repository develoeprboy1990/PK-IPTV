<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><?=$pagetitle ?></h1>
  	<?php echo $breadcrumb; ?>
  </section>
  <!-- Main content -->
  <section class="content">
		<?php
		if($tmbd_idbm != ''){
		?>	 
		<div class="box box-primary">
	    <div class="box-body">
			  <h3 class="box-title pull-right">
					<a href="<?php echo BASE_URL.'series_seasons/episodes/'.$season_id; ?>" class="btn btn-block btn-primary btn-flat">
						<i class="fa fa-arrow-left"></i> 
						Back to Episode
					</a>
				</h3>
				<?php if($dbselect != ''){ ?>
				<h3 class="box-title pull-left">
					<a href="#" class="btn btn-block btn-primary btn-flat" onclick="showManually(); return false;">						
						<span id="manully_text" style="display:block;">Manually Add Episode <i class="fa fa-arrow-down"></i> </span>
						<span id="imdbtmdb_text" style="display:none;">IMDB/TMDB Add Episode <i class="fa fa-arrow-up"></i> </span>
					</a>
				</h3>
				<?php } ?>
			  <?php
			  		/*$serise_list_html = '<div style="width:100%;float:left;padding:20px 0; border-bottom: 2px solid #ccc;">
						<div style="width:20%;float:left;">.</div>
						<div style="width:10%;float:left;">Title</div>
						<div style="width:10%;float:left;">Release Year</div>
						<div style="width:13%;float:left;    margin: 0 1%;">Stream Url</div>
						<div style="width:13%;float:left;    margin: 0 1%;">Tokenize</div>					
						<div style="width:14%;float:left;     margin: 0 3%;">Set Episode URL</div>
						<div tyle="width:10%;float:left;font-size:18px;font-waight:bold;">Action</div>
					</div>
				
					<div style="width: 100%;float: left;text-align: center;font-size: 16px;color: red;" id="msgggg"></div>';
					foreach ($getepisodeAll as $key=>$val) {
								if(!in_array($val->episode_number, $episode_added)){
								  $serise_list_html.='<div style="width:100%;float:left;padding:20px 0; border-bottom: 1px solid #ccc;" id="episodesdiv_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'">
								  
														<div style="width:20%;float:left;"><img src="http://image.tmdb.org/t/p/w500'.$val->still_path.'" height="100" width="100"/></div>
														<div style="width:10%;float:left;">'.$val->name.'</div>
														<div style="width:10%;float:left;">'.$val->air_date.'</div>
														<div style="width:13%;float:left;    margin: 0 1%;">
																	<select id="server_url_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'" name="server_url_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'" class="form-control bminbox">
	                                  									<option value="">Select a Url</option>
	                                                                 	<option value="12">Series</option>
	                                                             	</select>
														</div>
														<div style="width:13%;float:left;       margin: 0 1%;">
																<select id="token_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'" name="token_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'" class="form-control bminbox">
	                                                                 <option value="1">Secure Stream</option>
	                                                                 <option value="2" selected="">No Token</option>
	                                                                 <option value="3">Akamai</option>
	                                                                 <option value="4">Flussonic</option>
	                                                             </select>
														</div>
														<div style="width:14%;float:left;    margin: 0 3%;"><input class="bminbox form-control" type="" name="episodes_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'" id="episodes_'.$tmbd_idbm.'_'.$season_id.'_'.$val->episode_number.'" value="" /></div>
														<div><a href="#" onclick="select_episodes('.$tmbd_idbm.','.$season_id.','.$val->episode_number.','.$season_number.'); return false;" style="width:10%;float:left;font-size:18px;font-waight:bold;color:#45b010;">Add</a></div>
													</div>';
													
									}
												
								}
							
							echo $serise_list_html;*/
				?>
				<div style="width: 100%;float: left;text-align: center;font-size: 16px;color: red;" id="msgggg"></div>
				<?php if($dbselect == 'tmdb'){ ?>
					<table id="episodeshow" class="table table-bordered table-striped">
	          <thead>
	            <tr>
	              <th>Images</th>
	              <th>Title</th>
								<th>Sequence</th>									  
	              <th>Release</th>
								<th>Stream Url</th>  
								<th>Episode URL</th>
								<th>Action</th>
	             </tr> 
	            </thead>
							<tbody>
							<?php
							if(isset($getepisodeAll)){
								foreach (@$getepisodeAll as $key=>$val) {
								if(!in_array($val->episode_number, $episode_added)){ ?>
									<tr id="episodesdiv_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number; ?>">
										<td><img src="http://image.tmdb.org/t/p/w500<?php echo $val->still_path;?>" width="100" /></td>	
										<td><?php echo $val->name;?></td>
										<td><?php echo $val->episode_number;?></td>
										<td><?php echo $val->air_date;?></td>
										<td>
											<select id="server_url_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number;?>" name="server_url_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number;?>" class="form-control bminbox">
	                        <option value="12">Series</option>
	                    </select>
										</td>
										<!--<td>
										<select id="token_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number;?>" name="token_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number;?>" class="form-control bminbox">
	                                               <option value="1">Secure Stream</option>
	                                               <option value="2" selected="">No Token</option>
	                                               <option value="3">Akamai</option>
	                                               <option value="4">Flussonic</option>
	                                         </select>
										</td>-->
										<td>
											<input class="bminbox form-control episodeurlbm" type="text" name="episodes_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number;?>" id="episodes_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episode_number;?>" value="" style="min-width:300px; width:100%;" />
										</td>
										<td>
											<a href="#" onclick="select_episodes('<?php echo $tmbd_idbm;?>','<?php echo $season_id;?>','<?php echo $val->episode_number;?>','<?php echo $season_number;?>','<?php echo $series_id;?>','<?php echo $dbselect;?>'); return false;" class="btn btn-block btn-primary btn-flat">Add</a>
										</td>
								  </tr>
								  <?php
								  				$episodesbm[] = array('tmbd_idbm' => $tmbd_idbm, 
																			'season_id' => $season_id, 
																				'episode_number' => $val->episode_number,
																					'season_number' => $season_number,
																						'series_id' => $series_id,
																						'dbselect' => $dbselect); 
								}
						}
							}
						?>
						</tbody>
	        </table>
				<?php  }
				elseif($dbselect == 'imdb'){ ?>	
					<table id="episodeshow" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Images</th>
								<th>Title</th>
								<th>Sequence</th>									  
								<th>Release</th>
								<th>Stream Url</th>                                      
								<!-- <th>Tokenize</th>-->
								<th>Episode URL</th>
								<th>Action</th>
							</tr>
						</thead>
					  <tbody>
					  <?php
					  		foreach ($getepisodeAll as $key=>$val) {
									if(!in_array($val->episodeNumber, $episode_added)){ ?>
					  	  <tr id="episodesdiv_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber; ?>">
					  	   	<td><img src="<?php echo $val->image;?>" width="100" /></td>
					  	   	<td><?php echo $val->title;?></td>
									<td><?php echo $val->episodeNumber;?></td>
									<td><?php echo $val->released;?></td>
									<td>
										<select id="server_url_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber;?>" name="server_url_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber;?>" class="form-control bminbox">
		                          						<option value="12">Series</option>
		                                         </select>
									</td>
									<!--<td>
									<select id="token_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber;?>" name="token_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber;?>" class="form-control bminbox">
		                                           <option value="1">Secure Stream</option>
		                                           <option value="2" selected="">No Token</option>
		                                           <option value="3">Akamai</option>
		                                           <option value="4">Flussonic</option>
		                                     </select>
									</td>-->
									<td>
										<input class="bminbox form-control episodeurlbm" type="text" name="episodes_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber;?>" id="episodes_<?php echo $tmbd_idbm.'_'.$season_id.'_'.$val->episodeNumber;?>" value="" style="min-width:300px; width:100%;" />
									</td>
									<td>
										<a href="#" onclick="select_episodes('<?php echo $tmbd_idbm;?>','<?php echo $season_id;?>','<?php echo $val->episodeNumber;?>','<?php echo $season_number;?>','<?php echo $series_id;?>','<?php echo $dbselect;?>'); return false;" class="btn btn-block btn-primary btn-flat">Add</a>
									</td>
						   </tr>
						  <?php
						  				$episodesbm[] = array('tmbd_idbm' => $tmbd_idbm, 
																	'season_id' => $season_id, 
																		'episode_number' => $val->episodeNumber,
																			'season_number' => $season_number,
																				'series_id' => $series_id,
																				'dbselect' => $dbselect); 
						  				}
								}
						  ?>
					  </tbody>
	        </table>				
				<?php } ?>
				
				<?php //if($dbselect == ''){ ?>
				<div class="box-body" style="margin-top: 80px;border-top: 1px solid #ccc; <?php if($dbselect == ''){ echo 'display : block'; }else{ echo 'display : none'; } ?> " id="manully_add">
	        <form method="post" action="<?= BASE_URL ?>episodes/add_episodes_manully/<?= @$series_id?>" enctype="multipart/form-data" class="form-horizontal">
	          <input type="hidden" name="series_id" id="series_id" value="<?=$series_id?>">
	          <input type="hidden" name="tmbd_idbm" id="tmbd_idbm" value="">
				  	<input type="hidden" name="dbselect" id="dbselect" value="">
	          <!--<input type="hidden" name="imported" id="imported" value="0">-->
				  	<input type="hidden" name="season_id" id="season_id" value="<?= @$season_id?>">
				  	<input type="hidden" name="season_number" id="season_number" value="<?= @$season_number?>">
	            <div class="row"> 
	              <div class="form-group">
	                <label for="name" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-4">
	                 <input type="text" id="title" name="title" class="form-control" value="" placeholder="<?=$title?> Name" required/>
	                 <span class="text-danger"><?= form_error('name'); ?></span>
	                </div>
	              </div>
	            </div>

							<div class="row"> 
						    <div class="form-group">
						        <label for="episode_number" class="col-sm-2 control-label">Episode Number</label>
						        <div class="col-sm-4">
						            <input type="number" id="episode_number" name="episode_number" class="form-control" value="" placeholder="Episode Number" required/>
						            <span class="text-danger"><?= form_error('episode_number'); ?></span>
							        </div>
								    </div>
								</div>

	            <!--<div class="row"> 
	              <div class="form-group">
	                <label for="season_number" class="col-sm-2 control-label">Season Number</label>
	                <div class="col-sm-4">
	                 <input type="text" id="season_number" name="season_number" class="form-control" value="" placeholder="Season Number" required/>
	                 <span class="text-danger"><?= form_error('season_number'); ?></span>
	                </div>
	              </div>
	            </div>-->
	            <div class="row" id="poster_row"> 
	              <div class="form-group">
	                <label for="poster" class="col-sm-2 control-label">Image (342 X 513)</label>
	                <div class="col-sm-4">
	                  <div id="thumbnail_content">
	                    <input type="file" id="poster" onchange="showImg(this);" name="poster" class="filestyle" data-input="false" accept="image/*">
	                  </div>
	                  <br>
	                  <img id="thumb_image" src="<?php echo base_url().'uploads/default_image/thumbnail.jpg'; ?>" width="150" class="img-thumbnail" alt="">
	                </div>
	              </div>
	            </div>
	            <!--<div class="row" id="backdrop_row"> 
	              <div class="form-group">
	                <label for="backdrop" class="col-sm-2 control-label">Backdrop (1280 X 720)</label>
	                <div class="col-sm-4">
	                 <div id="poster_content">
	                  <input type="file" id="backdrop" onchange="showImg2(this);" name="backdrop" class="filestyle" data-input="false" accept="image/*">
	                 </div>
	                 <img id="poster_image" src="<?php echo base_url().'uploads/default_image/poster.jpg'; ?>" width="350" class="img-thumbnail" alt="">
	                </div>
	              </div>
	            </div>-->
	            <div class="row"> 
							  <div class="form-group">
							    <label for="season_number" class="col-sm-2 control-label">Episode URL</label>
							    <div class="col-sm-6">
							      <div class="input-group">
							        <input type="text" id="episode_url" name="episode_url" class="form-control" value="" placeholder="Episode URL" required/>
							        <span class="input-group-btn">
							          <button type="button" class="btn btn-info verify-url" data-url-type="episode" data-url-id="episode_url">Verify</button>
							          <button type="button" class="btn btn-success play-url-edit" data-url-type="episode" data-url-id="episode_url">Play</button>
							        </span>
							      </div>
							      <div class="url-message"></div>
							      <span class="text-danger"><?= form_error('season_number'); ?></span>
							    </div>
							  </div>
							</div>

							<!-- <div class="row"> 
							  <div class="form-group">
							    <label for="season_number" class="col-sm-2 control-label">Episode URL</label>
							    <div class="col-sm-4">
							     <input type="text" id="episode_url" name="episode_url" class="form-control" value="" placeholder="Episode URL" required/>
							     <span class="text-danger"><?= form_error('season_number'); ?></span>
							    </div>
							  </div>
							</div> -->
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
	                <label for="language" class="col-sm-2 control-label">Stream Url</label>
	                <div class="col-sm-2">
	                  <select id="server_url" name="server_url" class="form-control">
	                   <option value="12">Series</option>
	                  </select>
	                </div>
	              </div>
	            </div>	

	            <input type="hidden" value="12" name="server_url_id" id="server_url_id">	

							<div class="row">
								<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-4">
								<button type="submit" class="btn btn-success ">Add <?= @$title ?></button>
								<a href="<?php echo BASE_URL.'series/seasons/'.@$series_id; ?>" class="btn btn-success ">Cancel</a>
								</div>
								</div>
							</div>			
	          </form>
	        </div>
				<?php //} ?>
				
				<?php if($dbselect != ''){ ?>
					<div id="set_episode_url">
						<input type="hidden" id="all_episode_json" name="all_episode_json" value='<?php echo json_encode($episodesbm);?>'  />
						<div class="row"> 
            	<div class="form-group">
								<div class="col-sm-4">
									<textarea id="user_episode_url" name="user_episode_url" style="width: 100%;height: 100px;"></textarea>
									<a href="#" class="btn btn-block btn-primary btn-flat" onclick="setepisode_url(); return false;">Set Episode URL</a>
								</div>
								<div class="col-sm-4">
									
								</div>
								<div class="col-sm-4" style="margin-top:4%;">											
									<a href="#" class="btn btn-block btn-primary btn-flat" onclick="addallepisove(); return false;">ADD All Episode(Max 10)</a>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php 
		}
		else{
		?>
	  <div class="box box-primary" >
	    <div class="box-body" >
	      <form method="post" action="<?= BASE_URL ?>episodes/create/<?=$season_id?>" class="form-horizontal" enctype="multipart/form-data" >
	        <input type="hidden" name="season_id" value="<?=$season_id?>">
	        <div class="row"> 
	          <div class="form-group">
	            <label for="title" class="col-sm-2 control-label">Title</label>
	            <div class="col-sm-4">
	             <input type="text" id="title" name="title" class="form-control" value="<?=set_value('title')?>" placeholder="Title" required/>
	             <span class="text-danger"><?= form_error('title'); ?></span>
	            </div>
	          </div>
	        </div>
	        <div class="row"> 
	          <div class="form-group">
	            <label for="image" class="col-sm-2 control-label">Poster 16:9(608x342)</label>
	            <div class="col-sm-4">
	              <div id="thumbnail_content">
	                <input type="file" id="image" onchange="showImg(this);" name="image" class="filestyle" data-input="false" accept="image/*">
	              </div>
	              <br>
	              <img id="thumb_image" src="<?php echo base_url().'uploads/default_image/thumbnail.jpg'; ?>" width="150" class="img-thumbnail" alt="">
	            </div>
	          </div>
	        </div>
					<div class="row"> 
					  <div class="form-group">
					    <label for="description" class="col-sm-2 control-label">Description</label>
					    <div class="col-sm-4">
					     <textarea id="description" name="description" cols="100" rows="5"><?=set_value('description')?></textarea>
					    </div>
					  </div>
					</div>
					<div class="row"> 
					  <div class="form-group">
					    <label for="actor" class="col-sm-2 control-label">Movie Cast</label>
					    <div class="col-sm-4">
					     <input type="text" id="actor" name="actor" class="form-control" placeholder="Actor" value="<?=set_value('actor')?>" />
					     <span class="text-danger"><?= form_error('actor'); ?></span>
					    </div>
					  </div>
					</div>
	        <!-- <div class="row"> 
	          <div class="form-group">
	            <label for="" class="col-sm-2 control-label">Stream Url</label>
	            <div class="col-sm-8" >
	              <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
	                <div class="row"> 
	                  <div class="form-group">
	                    <div class="col-sm-12">
	                      <label for="server_url_id" class="col-sm-2 control-label">Server Url</label>
	                      <div class="col-sm-3">
	                        <select id="server_url_id" name="server_url_id" class="form-control">
	                            <option value="">Select a Url</option>
	                         <?php foreach($server_urls as $url){ ?>
	                            <option value="<?=$url->id?>" ><?=$url->name?></option>
	                         <?php } ?>
	                        </select>
	                      </div>

	                      <div class="col-sm-7">
	                        <input type="text" id="url" name="url" value="<?=set_value('url')?>" class="form-control" placeholder="Stream Name" required/>
	                        <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
	                        <span class="text-danger"><?= form_error('url'); ?></span>
	                      </div>
	                    </div>
	                  </div>
	                </div>

	                <div class="row"> 
	                  <div class="form-group">
	                    <div class="col-sm-12">
	                      <label for="token_id" class="col-sm-2 control-label">Tokenize</label>
	                      <div class="col-sm-6">
	                        <select id="token_id" name="token_id" class="form-control">
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
	         -->
	         <div class="row"> 
					  <div class="form-group">
					    <label for="" class="col-sm-2 control-label">Stream Url</label>
					    <div class="col-sm-8" >
					      <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
					        <div class="row"> 
					          <div class="form-group">
					            <div class="col-sm-12">
					              <label for="server_url_id" class="col-sm-2 control-label">Server Url</label>
					              <div class="col-sm-3">
					                <select id="server_url_id" name="server_url_id" class="form-control">
					                  <option value="">Select a Url</option>
					                  <?php foreach($server_urls as $url){ ?>
					                    <option value="<?=$url->id?>"><?=$url->name?></option>
					                  <?php } ?>
					                </select>
					              </div>

					              <div class="col-sm-7">
					                <div class="input-group">
					                  <input type="text" id="url" name="url" value="<?=set_value('url')?>" class="form-control" placeholder="Stream Name" required/>
					                  <span class="input-group-btn">
					                    <button type="button" class="btn btn-info verify-url" data-url-type="episode" data-url-id="url">Verify</button>
					                    <button type="button" class="btn btn-success play-url-edit" data-url-type="episode" data-url-id="url">Play</button>
					                  </span>
					                </div>
					                <div class="url-message"></div>
					                <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
					                <span class="text-danger"><?= form_error('url'); ?></span>
					              </div>
					            </div>
					          </div>
					        </div>

					        <div class="row"> 
					          <div class="form-group">
					            <div class="col-sm-12">
					              <label for="token_id" class="col-sm-2 control-label">Tokenize</label>
					              <div class="col-sm-6">
					                <select id="token_id" name="token_id" class="form-control">
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
	        <div class="row"> 
	          <div class="form-group">
	            <label for="language_id" class="col-sm-2 control-label">Language</label>
	            <div class="col-sm-2">
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
	            <label for="sequence_id" class="col-sm-2 control-label">Sequence</label>
	            <div class="col-sm-2">
	             <input type="text" id="sequence_id" name="sequence_id" class="form-control" placeholder="1" required />
	             <span class="text-danger"><?= form_error('sequence_id'); ?></span>
	            </div>
	          </div>
	        </div>
	        <div class="row"> 
	          <div class="form-group">
	            <label for="secure_stream" class="col-sm-2 control-label">Secure Stream ?</label>
	            <div class="col-sm-4">
	              <div class="onoffswitch">
	                <input type="checkbox" name="secure_stream" class="onoffswitch-checkbox" id="secure_stream" value="1" >
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
	            <label class="col-sm-2 control-label"></label>
	            <div class="col-sm-4">
	              <button type="submit" class="btn btn-success ">Add <?= @$title?></button>
	            </div>
	          </div>
	        </div>
	      </form>
	    </div>
		</div>
		<?php
			}
		?>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Add this modal section at the bottom of create.php -->
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
        <?php if($episode_url_permission && $episode_url_permission->allow_view == 1): ?>
          <button id="copyUrlBtn" class="btn btn-sm btn-primary">
            <i class="fa fa-copy"></i> Copy URL
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div> 