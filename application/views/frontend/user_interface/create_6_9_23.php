 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>user_interface/create" class="form-horizontal">
              
              <div class="row"> 
                <div class="form-group">
                  <label for="setting_name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="interface_name" name="interface_name" class="form-control" placeholder="Name" value="<?php echo $interface_name;?>"/>
                   <span class="text-danger"><?= form_error('interface_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="youtube_api_key" class="col-sm-2 control-label">Youtube API key</label>
                  <div class="col-sm-4">
                   <input type="text" id="youtube_api_key" name="youtube_api_key" class="form-control" placeholder="Youtube API key" value="<?php echo $youtube_api_key;?>" />
                   <span class="text-danger"><?= form_error('youtube_api_key'); ?></span>
                  </div>
                </div>
              </div>

             

              <div class="row"> 
                <div class="form-group">
                  <label for="brandname" class="col-sm-2 control-label">Brand Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="brandname" name="brandname" class="form-control" placeholder="Brand Name" value="<?php echo $brandname;?>" />
                   <span class="text-danger"><?= form_error('brandname'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="contactinformation" class="col-sm-2 control-label">Contact Information</label>
                  <div class="col-sm-4">
                   <input type="text" id="contactinformation" name="contactinformation" class="form-control" placeholder="Contact Information" value="<?php echo $contactinformation;?>" />
                   <span class="text-danger"><?= form_error('contactinformation'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="dir" class="col-sm-2 control-label">DIR</label>
                  <div class="col-sm-4">
                   <input type="text" id="dir" name="dir" class="form-control" placeholder="DIR" value="<?php echo $dir;?>" />
                   <span class="text-danger"><?= form_error('dir'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="qrcode" class="col-sm-2 control-label">QR Code</label>
                  <div class="col-sm-4">
                   <input type="text" id="qrcode" name="qrcode" class="form-control" placeholder="QR Code" value="<?php echo $qrcode;?>" />
                   <span class="text-danger"><?= form_error('qrcode'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="text" class="col-sm-2 control-label">Text</label>
                  <div class="col-sm-6">
                  <!-- <input type="text" id="name_text" name="name_text" class="form-control" placeholder="Text" value="<?php echo $name_text;?>" />-->
				   <textarea name="name_text" id="name_text" class="form-control form-control-lg form-control-solid" placeholder="Write Text Here....." rows="6"><?php echo $name_text;?></textarea>
				   
                   <span class="text-danger"><?= form_error('name_text'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row" style="display:none"> 
                <div class="form-group">
                  <label for="logo" class="col-sm-2 control-label">Logo </label>
                  <div class="col-sm-4">
                   <input type="file" id="logo" name="logo"/>
                  </div>
                </div>
              </div>

              <div class="row" style="display:none"> 
                <div class="form-group">
                  <label for="background" class="col-sm-2 control-label">Background </label>
                  <div class="col-sm-4">
                   <input type="file" id="background" name="background"/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="selection_color" class="col-sm-2 control-label">Selection Color</label>
                  <div class="col-sm-2">
                   <input type="text" id="selection_color" name="selection_color" class="form-control" value="<?php echo $selection_color;?>" />
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-2 control-label">Product Has EPG</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="product_has_epg" class="onoffswitch-checkbox" id="product_has_epg" value="1" <?php if($product_has_epg==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="product_has_epg">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_catchuptv" class="col-sm-2 control-label">Show Catchuptv</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_catchuptv" class="onoffswitch-checkbox" id="show_catchuptv" value="1" <?php if($show_catchuptv==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_catchuptv">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_clock" class="col-sm-2 control-label">Show Clock</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_clock" class="onoffswitch-checkbox" id="show_clock" value="1" <?php if($show_clock==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_clock">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_fontsize" class="col-sm-2 control-label">Show Fontsize</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_fontsize" class="onoffswitch-checkbox" id="show_fontsize" value="1" <?php if($show_fontsize==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_fontsize">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_hint" class="col-sm-2 control-label">Show Hint</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_hint" class="onoffswitch-checkbox" id="show_hint" value="1" <?php if($show_hint==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_hint">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_languages" class="col-sm-2 control-label">Show Languages</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_languages" class="onoffswitch-checkbox" id="show_languages" value="1" <?php if($show_languages==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_languages">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_quickmenu" class="col-sm-2 control-label">Show Quick Menu</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_quickmenu" class="onoffswitch-checkbox" id="show_quickmenu" value="1" <?php if($show_quickmenu==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_quickmenu">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_screensaver" class="col-sm-2 control-label">Show Screen Saver</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_screensaver" class="onoffswitch-checkbox" id="show_screensaver" value="1" <?php if($show_screensaver==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_screensaver">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_search" class="col-sm-2 control-label">Show Search</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_search" class="onoffswitch-checkbox" id="show_search" value="1" <?php if($show_search==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_search">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_speedtest" class="col-sm-2 control-label">Show Speed Test</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_speedtest" class="onoffswitch-checkbox" id="show_speedtest" value="1" <?php if($show_speedtest==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_speedtest">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="enable_hint" class="col-sm-2 control-label">Enable Hint</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="enable_hint" class="onoffswitch-checkbox" id="enable_hint" value="1" <?php if($enable_hint==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="enable_hint">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="enable_kids_mode" class="col-sm-2 control-label">Enable Kids Mode</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="enable_kids_mode" class="onoffswitch-checkbox" id="enable_kids_mode" value="1" <?php if($enable_kids_mode==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="enable_kids_mode">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="direct_tv_mode" class="col-sm-2 control-label">Direct TV Mode</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="direct_tv_mode" class="onoffswitch-checkbox" id="direct_tv_mode" value="1" <?php if($direct_tv_mode==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="direct_tv_mode">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_preview" class="col-sm-2 control-label">Channel Preview</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="channel_preview" class="onoffswitch-checkbox" id="channel_preview" value="1" <?php if($channel_preview==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="channel_preview">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="epg_preview" class="col-sm-2 control-label">EPG Preview</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="epg_preview" class="onoffswitch-checkbox" id="epg_preview" value="1" <?php if($epg_preview==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="epg_preview">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_weather" class="col-sm-2 control-label">Show Weather</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="show_weather" class="onoffswitch-checkbox" id="show_weather" value="1" <?php if($show_weather==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="show_weather">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="max_concurrent_devices" class="col-sm-2 control-label">Max Concurrent Devices</label>
                  <div class="col-sm-1">
                   <input type="number" id="max_concurrent_devices" name="max_concurrent_devices" class="form-control" placeholder="3" value="<?php echo $max_concurrent_devices;?>" >
                   <span class="text-danger"><?= form_error('max_concurrent_devices'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="max_days_interactivetv" class="col-sm-2 control-label">Max Days interactive TV</label>
                  <div class="col-sm-1">
                   <input type="number" id="max_days_interactivetv" name="max_days_interactivetv" class="form-control" placeholder="3" value="<?php echo $max_days_interactivetv;?>" >
                   <span class="text-danger"><?= form_error('max_days_interactivetv'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sleep_mode" class="col-sm-2 control-label">Sleep Mode</label>
                  <div class="col-sm-1">
                   <input type="number" id="sleep_mode" name="sleep_mode" class="form-control" placeholder="3400" value="<?php echo $sleep_mode;?>">
                   <span class="text-danger"><?= form_error('sleep_mode'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="payment_type" class="col-sm-2 control-label">Payment Type</label>
                  <div class="col-sm-2">
                   <select name="payment_type" id="payment_type" class="form-control">
                     <option value="Subscription" >Subscription</option>
					    <option value="Wallet" >Wallet</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="storage_package" class="col-sm-2 control-label">Storage Package</label>
                  <div class="col-sm-1">
                   <input type="number" id="storage_package" name="storage_package" class="form-control" placeholder="1" value="<?php echo $storage_package;?>">
                   <span class="text-danger"><?= form_error('storage_package'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success" name="add_user_interface">Add User Interface</button>
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
  
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create( document.querySelector('#name_text') )
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );
</script>