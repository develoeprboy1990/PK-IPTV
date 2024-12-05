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
            <form method="post" action="<?= BASE_URL ?>songs/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
 
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="<?=$details->name?>" placeholder="Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="album_id" class="col-sm-2 control-label">Album</label>
                  <div class="col-sm-3">
                   <select name="album_id" id="album_id" class="form-control">
                     <option>Select a Album</option>
                     <?php foreach($albums as $album){?>
                     <option value="<?=$album['id']?>" <?=($album['id']==$details->album_id) ? "selected": ""?>><?=$album['name']?></option>
                     <?php }?>
                   </select>
                  </div>
                </div>
              </div>
             
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
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-4">
                   <input type="text" id="position" name="position" class="form-control" value="<?=$details->position?>" placeholder="Position"/>
                   <span class="text-danger"><?= form_error('position'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
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
              </div>

              <div class="row"> 
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
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update <?=$title?></button>
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