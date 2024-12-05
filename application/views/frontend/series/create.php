<!-- Content Wrapper. Contains page content -->
<style>
  select[multiple] {
    height: 200px !important;
  }
  
  .form-group label {
    font-weight: 600;
    margin-bottom: 8px;
  }
  
  .platforms-container {
    background: #f9f9f9;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  .platforms-container .form-group {
    margin-bottom: 0;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><?=$pagetitle ?></h1>
     <?php echo $breadcrumb; ?>
  </section>

  <!-- Main content -->
  <section class="content">
	 	<div class="box box-primary">
      <div class="box-header with-border" style="text-align:center;" >
        <input type="hidden" id="from" name="from" value="tv">
        <div class="import-box col-sm-4" style="border: 1px solid #367fa9;padding: 0 0 20px 0px;text-align: center;margin-left:350px;">
          <h4 style="margin-top: 0;color: white;background-color: #3c8dbc;width: 100%;padding: 10px;">IMPORT SERIES FROM TMDB / IMDB</h4>
          <!--<div class="input-group input-group-sm" style="padding-left: 20px;padding-right: 20px;">
            <input type="text" id="tmdbid" name="tmdbid" placeholder="Enter TMDB ID. Ex: 911 or Name Ex: atypical" required="" class="form-control">
            <span class="input-group-btn">
              <button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>
            </span>
          </div>-->
      		<div class="input-group input-group-sm" style="float:left;">
      			<div>
      			  <input type="checkbox" id="tmdb" name="tmdb" value="tmdb" checked="checked">
      		    <label for="FROM TMDB" style="margin-left: 5px;"> FROM TMDB</label>
      			</div>
      			
      			<div>
      		 	  <input type="checkbox" id="imdb" name="imdb" value="imdb" >
      		    <label for="FROM IMDB" style="margin-left: 5px;"> FROM IMDB</label>
      			</div>
      			
      			<div style="margin-left: 28px;">
      			  <input type="checkbox" id="manually_insert" name="manually_insert" value="manually_insert">
      		    <label for="Manual Import Data" style="margin-left: 5px;">MANUAL IMPORT</label>
      			</div>
      		</div>
      	  <div id="search_boxbm">
      	  		<div class="input-group input-group-sm" style="padding-left: 5px;padding-right: 5px;">
      			  	<input type="text" id="tmdbid" name="tmdbid" placeholder="Enter TMDB ID or Name. Ex: 141052 or Jack" required="" class="form-control">
      			  	<span class="input-group-btn">
      					<button type="button" class="btn large btn-info btn-flat w-sm waves-effect waves-light" id="import_btn">Fetch</button>
      			  	</span>
      			</div>
      	  </div>
          <div id="result" style="margin:20px;">
            <div class="alert"></div>
          </div>
         <!-- <div>Please find season id from <a href="https://www.themoviedb.org" target="_blank">https://www.themoviedb.org</a></div>-->
        </div>
      </div>
    </div>
	  <div class="box box-primary" id="serese_boxbm" style="display:none;">
		  <div id="ssss_ggg" style="text-align: center;"></div>
      <div class="box-body" id="tmbm_searchresult"></div>
	  </div>
		<!--<div style="font-size:14px; font-weight:bold;">
			<input type="checkbox" name="manually_insert" id="manually_insert" onclick="$('#serese_boxbm_select').toggle();"  /> Manually Insert
		</div>-->
    <div class="box box-primary" id="serese_boxbm_select" style="display:none;">
		  <div id="ssss_gggdd" style="text-align: center;"></div>
      <div class="box-body">		  
		    <div id="message_dataselect" style="text-align: center;font-size: 15px;font-weight: bold;margin-bottom: 10px;"></div>
        <form method="post" action="<?= BASE_URL ?>series/create" enctype="multipart/form-data" class="form-horizontal">
          <input type="hidden" name="type" value="2">
	        <input type="hidden" name="tmbd_id" id="tmbd_id" value="" />
	        <input type="hidden" name="dbselect" id="dbselect" value="" />

          <div class="row"> 
            <div class="form-group">
              <label for="name" class="col-sm-2 control-label">Name</label>

              <div class="col-sm-4">
               <input type="text" id="name" name="name" class="form-control" value="" placeholder="<?=$title?> Name" required/>
               <span class="text-danger"><?= form_error('name'); ?></span>  
              </div>
		  
		          <div class="col-sm-4">                   
               <div id="dbidshow" style="float: right;"></div>  
              </div>
            </div>
          </div>
          <div class="row"> 
            <div class="form-group">
              <label for="parent-store" class="col-sm-2 control-label">Series Store</label>
              <div class="col-sm-4">
                <select id="parent-store" name="parent_store" class="form-control" required>
                    <option value="">Select a Store</option>
                  <?php foreach ($parent_stores as $store){?>
                    <option value="<?=$store['id']?>"><?=$store['name']?></option>
                  <?php }?>
                </select>
              </div>
            </div>
          </div>

          <!-- For create.php and edit.php, replace the OTT Platforms and TV Show Platforms sections with: -->

         <!--  <div class="row">
            <div class="form-group">
              <label for="platforms" class="col-sm-2 control-label">Platforms</label>
              <div class="col-sm-8">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="ott_platforms">OTT Platforms</label>
                      <select id="ott_platforms" name="ott_platforms[]" class="form-control" multiple="" required style="height: 200px !important;">
                        <option value="">--No Selection--</option>
                        <?php foreach ($ott_platforms as $platform) { ?>
                          <option value="<?=$platform['id']?>" 
                            <?php if(isset($selected_ott_platforms) && in_array($platform['id'], $selected_ott_platforms)) echo "selected"; ?>>
                            <?=$platform['name']?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <div class="row"> 
            <div class="form-group">
              <label for="ott_platforms" class="col-sm-2 control-label">OTT Platforms</label>
              <div class="col-sm-4">
                <select id="ott_platforms" name="ott_platforms[]" class="form-control" multiple="" required style="height: 200px !important;">
                  <option value="">--No Selection--</option>
                  <?php foreach ($ott_platforms as $platform) { ?>
                    <option value="<?=$platform['id']?>" 
                      <?php if(isset($selected_ott_platforms) && in_array($platform['id'], $selected_ott_platforms)) echo "selected"; ?>>
                      <?=$platform['name']?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>          
          <div class="row"> 
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">Language</label>
                <div class="col-sm-4">
                  <select id="language_id" name="language_id" class="form-control">                 
                    <?php foreach ($languages as $language) { ?>
                      <option value="<?=$language['id']?>"><?=$language['name']?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
          </div>
          <!--<div class="row"> 
            <div class="form-group">
              <label for="sub-store" class="col-sm-2 control-label">Sub Stores</label>
              <div class="col-sm-4">
                <select id="sub-store" name="sub_store" class="form-control">
                </select>
              </div>
            </div>
          </div>-->
          <div class="row"> 
            <div class="form-group">
              <label for="logo" class="col-sm-2 control-label">Cover 16:9 (1280X720)</label>
              <div class="col-sm-4" id="thumbnail_content">
               <input type="file" id="logo" name="logo" required />
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
          <div class="row"> 
            <div class="form-group">
              <label for="position" class="col-sm-2 control-label">Position</label>
              <div class="col-sm-1">
               <input type="text" id="position" name="position" class="form-control" placeholder="1"/>
               <span class="text-danger"><?= form_error('position'); ?></span>
              </div>
            </div>
          </div>
          <!-- <div class="row"> 
            <div class="form-group">
              <label for="show_on_home" class="col-sm-2 control-label">Show on Home</label>
              <div class="col-sm-4">
                <div class="onoffswitch">
                  <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" checked>
                  <label class="onoffswitch-label" for="show_on_home">
                      <span class="onoffswitch-inner"></span>
                      <span class="onoffswitch-switch"></span>
                  </label>
                </div>
              </div>
            </div>
          </div> -->
          <div class="row"> 
            <div class="form-group">
              <label for="active" class="col-sm-2 control-label">Status</label>
              <div class="col-sm-4">
                <div class="onoffswitch">
                  <input type="checkbox" name="active" class="onoffswitch-checkbox" id="active" value="1" checked>
                  <label class="onoffswitch-label" for="active">
                      <span class="onoffswitch-inner"></span>
                      <span class="onoffswitch-switch"></span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Replace the TV Show Platform section with this updated version -->
          <div class="row"> 
            <div class="form-group">
              <label for="tv_show_platform_status" class="col-sm-2 control-label">TV Show Platform Status</label>
              <div class="col-sm-4">
                <div class="onoffswitch">
                  <input type="checkbox" name="tv_show_platform_status" class="onoffswitch-checkbox" id="tv_show_platform_status" value="1">
                  <label class="onoffswitch-label" for="tv_show_platform_status">
                      <span class="onoffswitch-inner"></span>
                      <span class="onoffswitch-switch"></span>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- <div class="row tv-show-platforms-section" style="display:none;"> 
            <div class="form-group">
              <label for="tv_show_platforms" class="col-sm-2 control-label">TV Show Platforms</label>
              <div class="col-sm-4">
                <select id="tv_show_platforms" name="tv_show_platforms[]" class="form-control" multiple="" style="height: 200px !important;">
                  <option value="">--No Selection--</option>
                  <?php foreach ($tv_show_platforms as $platform) { ?>
                    <option value="<?=$platform['id']?>"><?=$platform['name']?></option>
                  <?php } ?>
                </select>
                <span class="text-danger tv-show-platforms-error" style="display:none;">Please select at least one TV Show Platform when status is enabled</span>
              </div>
            </div>
          </div> -->

          <div class="row tv-show-platforms-section" style="display:none;"> 
            <div class="form-group">
                <label for="tv_show_platforms" class="col-sm-2 control-label">TV Show Platforms</label>
                <div class="col-sm-4">
                    <select id="tv_show_platforms" name="tv_show_platforms[]" class="form-control" multiple="" style="height: 200px !important;">
                        <option value="">--No Selection--</option>
                        <?php foreach ($tv_show_platforms as $platform) { ?>
                            <option value="<?=$platform['id']?>" 
                                    data-language="<?=$platform['language_id']?>"
                                    <?php if(isset($selected_tv_platforms) && in_array($platform['id'], $selected_tv_platforms)) echo "selected"; ?>>
                                <?=$platform['name']?> (<?=$platform['language_name']?>)
                            </option>
                        <?php } ?>
                    </select>
                    <span class="text-danger tv-show-platforms-error" style="display:none;">Please select at least one TV Show Platform when status is enabled</span>
                </div>
            </div>
          </div>



          <div class="row">
            <div class="form-group">
              <label class="col-sm-2 control-label"></label>
              <div class="col-sm-4">
                <button type="submit" class="btn btn-success ">Add <?=$title?></button>
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