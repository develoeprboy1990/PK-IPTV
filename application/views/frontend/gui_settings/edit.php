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
            <form method="post" action="<?= BASE_URL ?>gui_settings/edit/<?php echo @$details->id?>" enctype="multipart/form-data" class="form-horizontal">
       
              <div class="row"> 
                <div class="form-group">
                  <label for="setting_name" class="col-sm-2 control-label">Gui Setting Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="setting_name" name="setting_name" value="<?=@$details->setting_name?>" class="form-control" placeholder="Name" required/>
                   <span class="text-danger"><?= form_error('setting_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="youtube_api_key" class="col-sm-2 control-label">Youtube API key</label>
                  <div class="col-sm-4">
                   <input type="text" id="youtube_api_key" name="youtube_api_key"  value="<?=@$details->youtube_api_key?>" class="form-control" placeholder="Youtube API key" required/>
                   <span class="text-danger"><?= form_error('youtube_api_key'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="flusonic_base_url" class="col-sm-2 control-label">Flusonic Base Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="flusonic_base_url" name="flusonic_base_url"  value="<?=@$details->flusonic_base_url?>" class="form-control" placeholder="http://" required/>
                   <span class="text-danger"><?= form_error('flusonic_base_url'); ?></span>
                  </div>
                </div>
              </div>

              <!--<div class="row" style="display:none;"> 
                <div class="form-group">
                  <label for="gui_start_url" class="col-sm-2 control-label">GUI Start Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="gui_start_url" name="gui_start_url"  value="<?=$details->gui_start_url?>" class="form-control" placeholder="http://" required/>
                   <span class="text-danger"><?= form_error('gui_start_url'); ?></span>
                  </div>

                  <label for="version_id" class="col-sm-1 control-label">Version</label>
                  <div class="col-sm-2">
                    <select class="form-control" name="version_id" id="version_id" required>
                        <option value="">Select a GUI Version</option>
                      <?php foreach ($versions as $version) {?>
                        <option value="<?=$version['id']?>" <?=($version['id']==$details->version_id) ? "selected" : ""?>><?=$version['version']?></option>
                      <?php }?>
                    </select>
                   <span class="text-danger"><?= form_error('version_id'); ?></span>
                  </div>
                </div>
              </div>-->

              <!--<div class="row"> 
                <div class="form-group">
                  <label for="base_start_url" class="col-sm-2 control-label">Base Start Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="base_start_url" name="base_start_url"  value="<?=$details->base_start_url?>" class="form-control" placeholder="http://" required/>
                   <span class="text-danger"><?= form_error('base_start_url'); ?></span>
                  </div>
                </div>
              </div>-->

              <div class="row"> 
                <div class="form-group">
                  <label for="ui" class="col-sm-2 control-label">Template</label>
                  <div class="col-sm-4">
                    <select name="ui" id="ui" class="form-control">
						<option value="">Select Template</option>
                      <?php foreach($themes as $theme){?>
                        <option value="<?=@$theme['id']?>" <?=(@$details->ui==@$theme['id']) ? "selected": ""?>><?=@$theme['name']?></option>
                      <?php }?>
                    </select>
					<span id="template_name"><input type="hidden" name="tembm_name" id="tembm_name" value="<?php echo $details->tembm_name;?>" /></span>
                    <span class="text-danger"><?=form_error('ui')?></span>
                  </div>
                </div>
              </div>
			<div class="row"> 
                <div class="form-group">
                  <label for="ui" class="col-sm-2 control-label">UI Theme</label>
                  <div class="col-sm-4">
                    <select name="ui_template" id="ui_template" class="form-control">
                      <?php foreach($template as $key=>$val){?>
                        <option value="<?=@$val['id']?>" <?=(@$details->ui_template==@$val['id']) ? "selected": ""?>><?=@$val['ui_name']?></option>
                      <?php }?>
                    </select>
					<span id="basestart_url"><input type="hidden" name="base_start_url" id="base_start_url" value="<?php echo @$details->base_start_url;?>" /></span>
                    <span class="text-danger"><?=form_error('ui')?></span>
                  </div>
                </div>
              </div>
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="brandname" class="col-sm-2 control-label">Brand Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="brandname" name="brandname" value="<?=@$details->brandname?>" class="form-control"  placeholder="Brand Name" required/>
                   <span class="text-danger"><?= form_error('brandname'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="contactinformation" class="col-sm-2 control-label">Contact Information</label>
                  <div class="col-sm-4">
                   <input type="text" id="contactinformation" name="contactinformation" value="<?=@$details->contactinformation?>" class="form-control" placeholder="Contact Information" required/>
                   <span class="text-danger"><?= form_error('contactinformation'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="dir" class="col-sm-2 control-label">DIR</label>
                  <div class="col-sm-4">
                   <input type="text" id="dir" name="dir" value="<?=@$details->dir?>" class="form-control" placeholder="DIR" required/>
                   <span class="text-danger"><?= form_error('dir'); ?></span>
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group">
                  <label for="qrcode" class="col-sm-2 control-label">QR Code</label>
                  <div class="col-sm-4">
                   <input type="text" id="qrcode" name="qrcode" value="<?=@$details->qrcode?>" class="form-control" placeholder="QR Code" required/>
                   <span class="text-danger"><?= form_error('qrcode'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="text" class="col-sm-2 control-label">Text</label>
                  <div class="col-sm-4">
                   <!--<input type="text" id="text_ui" name="text_ui" value="<?php //echo $details->text_ui; ?>" class="form-control" placeholder="Text" required/>-->
				   <textarea name="text_ui" id="text_ui" class="form-control form-control-lg form-control-solid" placeholder="Write Text Here....." rows="6"><?php echo @$details->text_ui;?></textarea>
                   <span class="text-danger"><?= form_error('text'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="logo" class="col-sm-2 control-label">Logo </label>
                  <div class="col-sm-4">
                   <input type="file" id="logo" name="logo"/>
                    <?php if($details->logo!="") { ?>
                      <!--<img class="" src="<?=base_url()."uploads/gui_settings/logo/".$details->logo?>" width="100">-->
					  <img class="" src="<?php echo base_url(). LOCAL_PATH_IMAGES_CMS.@$details->logo; ?>" width="100">
					  
					  
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="background" class="col-sm-2 control-label">Background </label>
                  <div class="col-sm-4">
                   <input type="file" id="background" name="background"/>
                    <?php if($details->background!="") { ?>
					<img class="" src="<?=base_url(). LOCAL_PATH_IMAGES_CMS.@$details->background?>" width="250">
                    <!--  <img class="" src="<?=base_url()."uploads/gui_settings/background/".$details->background?>" width="250">-->
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="primary_color" class="col-sm-2 control-label">Primary Color</label>
                  <div class="col-sm-2">
                   <input type="text" id="primary_color" name="primary_color"  value="<?=@$details->primary_color?>" class="form-control" />
                  </div>
                </div>
              </div>
              
                <div class="row"> 
                <div class="form-group">
                  <label for="secondary_color" class="col-sm-2 control-label">Secondary Color</label>
                  <div class="col-sm-2">
                   <input type="text" id="secondary_color" name="secondary_color"  value="<?=@$details->secondary_color?>" class="form-control" />
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="product_has_epg" class="col-sm-2 control-label">Product Has EPG</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="product_has_epg" class="onoffswitch-checkbox" id="product_has_epg" value="true"  <?=($details->product_has_epg=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_catchuptv" class="onoffswitch-checkbox" id="show_catchuptv" value="true"  <?=($details->show_catchuptv=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_clock" class="onoffswitch-checkbox" id="show_clock" value="true"  <?=($details->show_clock=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_fontsize" class="onoffswitch-checkbox" id="show_fontsize" value="true"  <?=($details->show_fontsize=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_hint" class="onoffswitch-checkbox" id="show_hint" value="true"  <?=($details->show_hint=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_languages" class="onoffswitch-checkbox" id="show_languages" value="true"  <?=($details->show_languages=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_quickmenu" class="onoffswitch-checkbox" id="show_quickmenu" value="true"  <?=($details->show_quickmenu=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_screensaver" class="onoffswitch-checkbox" id="show_screensaver" value="true"  <?=($details->show_screensaver=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_search" class="onoffswitch-checkbox" id="show_search" value="true"  <?=($details->show_search=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_speedtest" class="onoffswitch-checkbox" id="show_speedtest" value="true"  <?=($details->show_speedtest=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="enable_hint" class="onoffswitch-checkbox" id="enable_hint" value="true"  <?=($details->enable_hint=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="enable_kids_mode" class="onoffswitch-checkbox" id="enable_kids_mode" value="true" <?=($details->enable_kids_mode=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="direct_tv_mode" class="onoffswitch-checkbox" id="direct_tv_mode" value="true" <?=($details->direct_tv_mode=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="channel_preview" class="onoffswitch-checkbox" id="channel_preview" value="true"  <?=($details->channel_preview=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="epg_preview" class="onoffswitch-checkbox" id="epg_preview" value="true"  <?=($details->epg_preview=="true") ? "checked" : ""?>>
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
                      <input type="checkbox" name="show_weather" class="onoffswitch-checkbox" id="show_weather" value="true" <?=($details->show_weather=="true") ? "checked" : ""?>>
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
                  <label for="show_weather" class="col-sm-2 control-label">Advertisment</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="enable_advertisments" class="onoffswitch-checkbox" id="enable_advertisments" value="true" <?=($details->enable_advertisments=="true") ? "checked" : ""?>>
                      <label class="onoffswitch-label" for="enable_advertisments">
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
                   <input type="text" id="max_concurrent_devices" name="max_concurrent_devices" value="<?=$details->max_concurrent_devices?>" class="form-control" placeholder="3"/>
                   <span class="text-danger"><?= form_error('max_concurrent_devices'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="max_days_interactivetv" class="col-sm-2 control-label">Max Days interactive TV</label>
                  <div class="col-sm-1">
                   <input type="text" id="max_days_interactivetv" name="max_days_interactivetv" value="<?=$details->max_days_interactivetv?>" class="form-control" placeholder="3"/>
                   <span class="text-danger"><?= form_error('max_days_interactivetv'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sleep_mode" class="col-sm-2 control-label">Sleep Mode</label>
                  <div class="col-sm-1">
                   <input type="text" id="sleep_mode" name="sleep_mode" value="<?=$details->sleep_mode?>" class="form-control" placeholder="3400"/>
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
                   <input type="text" id="storage_package" name="storage_package" value="<?=$details->storage_package?>" class="form-control" placeholder=""/>
                   <span class="text-danger"><?= form_error('storage_package'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Setting</button>
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
.create( document.querySelector('#text_ui') )
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );
</script>