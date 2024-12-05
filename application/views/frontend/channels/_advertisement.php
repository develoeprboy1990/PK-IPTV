<div class="box box-primary">
          <div class="box-body">
            <?php if($responce = $this->session->flashdata('success')){ ?>
              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
            <?php } ?>
            <form method="post" action="<?= BASE_URL ?>channels/updateAds/<?php echo $channel_detail->id?>/3" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="preroll_enabled" class="col-sm-2 control-label">Preroll Enabled ?</label>
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
                     <option value="always on" <?php if($channel_detail->preroll_type=='always on') { echo "selected";}?>>Always On</option>
                     <option value="maximum 1x" <?php if($channel_detail->preroll_type=='maximum 1x') { echo "selected";}?>>Maximum 1x</option>
                     <option value="maximum 2x" <?php if($channel_detail->preroll_type=='maximum 2x') { echo "selected";}?>>Maximum 2x</option>
                     <option value="maximum 3x" <?php if($channel_detail->preroll_type=='maximum 3x') { echo "selected";}?>>Maximum 3x</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="overlay_enabled" class="col-sm-2 control-label">Overlay Enabled ?</label>
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
                  <label for="ticker_enabled" class="col-sm-2 control-label">Ticker Enabled ?</label>
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
                  <label for="" class="col-sm-2 control-label"></label>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-success ">Update Ads</button>
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>