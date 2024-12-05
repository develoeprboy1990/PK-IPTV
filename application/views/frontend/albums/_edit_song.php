<div class="box box-primary">
  <div class="box-header with-border">
      <h3 class="box-title">Edit a Song</h3>
  </div>
    <div class="box-body">
      
      <form method="post" action="<?= BASE_URL ?>albums/editSong/<?=$details->id?>/<?=$song_details->id?>/2" class="form-horizontal">
      <input type="hidden" name="album_id" value="<?=$details->id?>">
        <div class="row"> 
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-4">
             <input type="text" id="name" name="name" class="form-control" value="<?=$song_details->name?>" required/>
             <span class="text-danger"><?= form_error('name'); ?></span>
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
                      <label for="server_url_id" class="col-sm-2 control-label">Server <?=$song_details->server_url_id?></label>
                      <div class="col-sm-3">
                        <select id="server_url_id" name="server_url_id" class="form-control">
                            <option value="">Select a Url</option>
                         <?php foreach($server_urls as $url){ ?>
                            <option value="<?=$url->id?>" <?=($song_details->server_url_id==$url->id) ? "selected" : ""?>><?=$url->name?></option>
                         <?php } ?>
                        </select>
                      </div>

                      <div class="col-sm-7">
                        <input type="text" id="url" name="url" value="<?=$song_details->url?>" class="form-control" placeholder="Stream Name" required/>
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
                            <option value="<?=$token->id?>" <?=($song_details->token_id==$token->id) ? "selected" : ""?>><?=$token->name?></option>
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
            <div class="col-sm-2">
             <input type="text" id="position" name="position" class="form-control"  value="<?=$song_details->position?>"/>
             <span class="text-danger"><?= form_error('position'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="secure_stream" class="col-sm-2 control-label">Secure Stream ?</label>
            <div class="col-sm-4">
              <div class="onoffswitch">
                <input type="checkbox" name="secure_stream" class="onoffswitch-checkbox" id="secure_stream" value="1" <?=($song_details->secure_stream==1) ? "checked" : ""?>>
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
                <input type="checkbox" name="has_drm" class="onoffswitch-checkbox" id="has_drm" value="1" <?=($song_details->has_drm==1) ? "checked" : ""?>>
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
              <button type="submit" class="btn btn-success ">Update Song</button>
            </div>
          </div>
        </div>

      </form>
    </div>
</div>
  