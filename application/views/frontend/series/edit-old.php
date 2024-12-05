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
            <form method="post" action="<?= BASE_URL ?>series/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="type" value="2">
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="<?php echo $details->name?>" placeholder="<?=$title?> Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group">
                  <label for="parent-store" class="col-sm-2 control-label">Stores</label>
                  <div class="col-sm-2">
                    <select id="parent-store" name="parent_store" class="form-control">
                        <option value="">Select a Store</option>
                        <?php foreach($stores as $store){?>
                              <option value="<?=$store['id']?>" <?=($store['id']==$parent_store_id) ? "selected": ""?> ><?=$store['name']?></option>
                        <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sub-store" class="col-sm-2 control-label">Sub Stores </label>
                  <div class="col-sm-2">
                    <select id="sub-store" name="sub_store" class="form-control">
                        <?php if(count($sub_stores)>0) {?>
                            <option value="">Select a Store</option>
                              <?php  foreach($sub_stores as $store){?>
                                <option value="<?=$store['id']?>" <?=($store['id']==$sub_store_id) ? "selected": ""?> ><?=$store['name']?></option>
                              <?php }?>
                        <?php }else{?>
                            <option value="">No Sub Store Available</option>
                        <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="logo" class="col-sm-2 control-label">Logo (480x160)</label>
                  <div class="col-sm-4">
                   <input type="file" id="logo" name="logo"/>
                    <?php if($details->logo!="") { ?>
                      <img class="" src="<?=base_url()."uploads/series/logo/resized/".$details->logo?>" width="180">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="poster" class="col-sm-2 control-label">Poster</label>
                  <div class="col-sm-4">
                   <input type="file" id="poster" name="poster"/>
                    <?php if($details->poster!="") { ?>
                      <img class="" src="<?=base_url()."uploads/series/poster/".$details->poster?>" width="250">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="backdrop" class="col-sm-2 control-label">Backdrop</label>
                  <div class="col-sm-4">
                   <input type="file" id="backdrop" name="backdrop"/>
                    <?php if($details->backdrop!="") { ?>
                      <img class="" src="<?=base_url()."uploads/series/backdrop/".$details->backdrop?>" width="400">
                    <?php }?>
                  </div>
                </div>
              </div>
         
              <div class="row"> 
                <div class="form-group">
                  <label for="year" class="col-sm-2 control-label">Year</label>
                  <div class="col-sm-1">
                   <input type="text" id="year" name="year" class="form-control"  value="<?php echo $details->year?>" placeholder="Year"/>
                   <span class="text-danger"><?= form_error('channel_epg_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="actor" class="col-sm-2 control-label">Casts</label>
                  <div class="col-sm-4">
                   <input type="text" id="actor" name="actor" class="form-control"  value="<?php echo $details->actor?>" placeholder="Actor"/>
                   <span class="text-danger"><?= form_error('actor'); ?></span>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="producer" class="col-sm-2 control-label">Producer</label>
                  <div class="col-sm-4">
                   <input type="text" id="producer" name="producer" class="form-control"  value="<?php echo $details->producer?>" placeholder="Producer"/>
                   <span class="text-danger"><?= form_error('producer'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="director" class="col-sm-2 control-label">Director</label>
                  <div class="col-sm-4">
                   <input type="text" id="director" name="director" class="form-control"  value="<?php echo $details->director?>" placeholder="Director"/>
                   <span class="text-danger"><?= form_error('director'); ?></span>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="studio" class="col-sm-2 control-label">Studio</label>
                  <div class="col-sm-4">
                   <input type="text" id="studio" name="studio" class="form-control"  value="<?php echo $details->studio?>" placeholder="Studio"/>
                   <span class="text-danger"><?= form_error('studio'); ?></span>
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
                  <label for="trailer" class="col-sm-2 control-label">Trailer Url</label>
                  <div class="col-sm-4">
                    <input type="text" id="trailer" name="trailer" class="form-control"  value="<?php echo $details->trailer?>" placeholder="Trailer"/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="language" class="col-sm-2 control-label">Language</label>
                  <div class="col-sm-2">
                    <select id="language" name="language" class="form-control">
                     <?php foreach ($languages as $language) { ?>
                        <option value="<?=$language['id']?>" <?=($language['id']==$details->language) ? "selected" : ""?>><?=$language['name']?></option>
                     <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="tags" class="col-sm-2 control-label">Tags</label>
                  <div class="col-sm-4">
                   <input type="text" id="tags" name="tags" class="form-control"  value="<?php echo $details->tags?>"  placeholder="Tags"/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="rating" class="col-sm-2 control-label">Rating</label>
                  <div class="col-sm-1">
                    <select id="rating" name="rating" class="form-control">
                       <?php for($i=1;$i<=10; $i++){?>
                           <option value="<?=$i?>" <?=($i==$details->rating) ? "selected" : ""?>><?=$i?></option>
                      <?php  }?>
                    </select>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="age_category" class="col-sm-2 control-label">Age Category</label>
                  <div class="col-sm-2">
                   <input type="text" id="age_category" name="age_category" class="form-control"  value="<?php echo $details->age_category?>" placeholder="Age Category"/>
                   <span class="text-danger"><?= form_error('age_category'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="token_id" class="col-sm-2 control-label">Token</label>
                  <div class="col-sm-4">
                   <select id="token_id" name="token_id">
                      <?php foreach($tokens as $token){ ?>
                        <option value="<?=$token->id?>" <?php if($token->id==$details->token_id) echo "selected";?>><?=$token->name?></option>
                     <?php } ?>
                   </select>
                  </div>
                </div>
              </div>

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

             <!--  <div class="row"> 
                <div class="form-group">
                  <label for="subtitles" class="col-sm-2 control-label">Subtitles</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="subtitles" class="onoffswitch-checkbox" id="subtitles" value="1" <?php if($details->subtitles==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="subtitles">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row"> 
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
                  <label for="position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-1">
                   <input type="text" id="position" name="position" value="<?=$details->position?>" class="form-control" placeholder="1"/>
                   <span class="text-danger"><?= form_error('position'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="active" class="col-sm-2 control-label">Active</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="active" class="onoffswitch-checkbox" id="active" value="1" <?php if($details->active==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="active">
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