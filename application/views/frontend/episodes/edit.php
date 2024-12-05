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
      <div class="box-body">
        <form method="post" action="<?= BASE_URL ?>episodes/edit/<?php echo $details->id?>" class="form-horizontal" enctype="multipart/form-data" >
          <input type="hidden" name="season_id" value="<?=$details->season_id?>">
          <div class="row"> 
            <div class="form-group">
              <label for="title" class="col-sm-2 control-label">Title</label>
              <div class="col-sm-4">
               <input type="text" id="title" name="title" class="form-control" value="<?=$details->title?>" placeholder="Title"/>
               <span class="text-danger"><?= form_error('title'); ?></span>
              </div>
            </div>
          </div>
          <div class="row"> 
              <div class="form-group">
                <label for="image" class="col-sm-2 control-label">Poster 16:9 (608x342)</label>

                <div class="col-sm-4">
                 <input type="file" id="image" name="image"/>
                
                  <?php if($details->image!="") {?>
                      <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->image?>" width="200">
                  <?php }?>
                </div>
              </div>
            </div>
          <div class="row"> 
            <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Description</label>
              <div class="col-sm-4">
               <textarea id="description" name="description" cols="100" rows="5"><?php echo $details->description?></textarea>
              </div>
            </div>
          </div>
      		<div class="row"> 
            <div class="form-group">
              <label for="actor" class="col-sm-2 control-label">Actor</label>
              <div class="col-sm-4">
               <input type="text" id="actor" name="actor" class="form-control"  value="<?php echo $details->actor?>" placeholder="Actor"/>
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
                              <option value="<?=$url->id?>" <?=($details->server_url_id==$url->id) ? "selected" : ""?>><?=$url->name?></option>
                           <?php } ?>
                          </select>
                        </div>

                        <div class="col-sm-7">
                          <input type="text" id="url" name="url" value="<?=$details->url?>" class="form-control" required/>
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
                              <option value="<?=$token->id?>" <?=($details->token_id==$token->id) ? "selected" : ""?>><?=$token->name?></option>
                           <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

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
                              <option value="<?=$url->id?>" <?=($details->server_url_id==$url->id) ? "selected" : ""?>><?=$url->name?></option>
                           <?php } ?>
                          </select>
                        </div>

                        <div class="col-sm-7">
                          <div class="input-group">
                            <input type="text" id="url" name="url" value="<?=$details->url?>" class="form-control" required/>
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
                              <option value="<?=$token->id?>" <?=($details->token_id==$token->id) ? "selected" : ""?>><?=$token->name?></option>
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
          <!-- <div class="row"> 
            <div class="form-group">
              <label for="url" class="col-sm-2 control-label">Stream Url</label>
              <div class="col-sm-4">
               <input type="text" id="url" name="url" class="form-control" value="<?=$details->url?>" placeholder="Url"/>
               <span class="text-danger"><?= form_error('url'); ?></span>
              </div>
            </div>
          </div> -->
          <!-- <div class="row"> 
            <div class="form-group">
              <label for="token_id" class="col-sm-2 control-label">Tokenize</label>
              <div class="col-sm-2">
                <select id="token_id" name="token_id" class="form-control">
                    <?php foreach($tokens as $token){ ?>
                      <option value="<?=$token->id?>" <?=($details->token_id==$token->id) ? "selected" : ""?>><?=$token->name?></option>
                    <?php } ?>
                </select>
              </div>
            </div>
          </div> -->
          <!--<div class="row"> 
            <div class="form-group">
              <label for="language_id" class="col-sm-2 control-label">Language</label>
              <div class="col-sm-2">
                <select id="language_id" name="language_id" class="form-control">
                 <?php //foreach ($languages as $language) { ?>
                    <option value="<?php //echo $language['id']?>" <?php //echo ($details->language_id==$language['id']) ? "selected" : "";?>><?php //echo $language['name']; ?></option>
                 <?php //} ?>
                </select>
              </div>
            </div>
          </div>-->
          <div class="row"> 
            <div class="form-group">
              <label for="sequence_id" class="col-sm-2 control-label">Sequence</label>
              <div class="col-sm-2">
               <input type="text" id="sequence_id" name="sequence_id" class="form-control" value="<?=$details->sequence_id?>" placeholder="1"/>
               <span class="text-danger"><?= form_error('sequence_id'); ?></span>
              </div>
            </div>
          </div>
           <!--  <div class="row"> 
            <div class="form-group">
              <label for="secure_stream" class="col-sm-2 control-label">Secure Stream ?</label>
              <div class="col-sm-4">
                <div class="onoffswitch">
                  <input type="checkbox" name="secure_stream" class="onoffswitch-checkbox" id="secure_stream" value="1" <?=($details->secure_stream==1) ? "checked" : ""?>>
                  <label class="onoffswitch-label" for="secure_stream">
                      <span class="onoffswitch-inner"></span>
                      <span class="onoffswitch-switch"></span>
                  </label>
                </div>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="form-group">
              <label class="col-sm-2 control-label"></label>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-success ">Update <?=$title?></button>
			          <a href="<?= BASE_URL ?>series_seasons/episodes/<?=$details->season_id?>" class="btn btn-success ">Cancel</a>
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
        <?php if($episode_url_permission && $episode_url_permission->allow_view == 1): ?>
          <button id="copyUrlBtn" class="btn btn-sm btn-primary">
            <i class="fa fa-copy"></i> Copy URL
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>