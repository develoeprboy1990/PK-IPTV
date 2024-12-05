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
            <form method="post" action="<?= BASE_URL ?>banners/create" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="type" value="banner">
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" placeholder="Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="gui_position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-4">
                     <select id="gui_position" name="gui_position" class="form-control">
                        <option value="">Select a Position</option>
                        <option value="vertical">Vertical (160x580)</option>
                        <option value="horizontal">Horizontal (620x160)</option>
                     </select>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Banner Image</label>
                  <div class="col-sm-4">
                   <input type="file" id="image" name="image"/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="date_start" class="col-sm-2 control-label">Start Date</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="date_start" name="date_start">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="date_end" class="col-sm-2 control-label">End Date</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="date_end" name="date_end">
                    </div>
                  </div>
                </div>
              </div>

             <!--  <div class="row"> 
                <div class="form-group">
                  <label for="max_views" class="col-sm-2 control-label">Views</label>
                  <div class="col-sm-4">
                   <input type="text" id="max_views" name="max_views" class="form-control" placeholder="Maximum Views"/>
                   <span class="text-danger"><?= form_error('max_views'); ?></span>
                  </div>
                </div>
              </div> -->

<!-- 
              <div class="row"> 
                <div class="form-group">
                  <label for="price_per_view" class="col-sm-2 control-label">Price per View</label>
                  <div class="col-sm-4">
                   <input type="text" id="price_per_view" name="price_per_view" class="form-control" placeholder="Price per View"/>
                   <span class="text-danger"><?= form_error('price_per_view'); ?></span>
                  </div>
                </div>
              </div> -->

             <!--  <div class="row"> 
                <div class="form-group">
                  <label for="url" class="col-sm-2 control-label">Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="url" name="url" class="form-control" placeholder="Url"/>
                   <span class="text-danger"><?= form_error('url'); ?></span>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="stream_url" class="col-sm-2 control-label">Stream Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="stream_url" name="stream_url" class="form-control" placeholder="Stream Url"/>
                   <span class="text-danger"><?= form_error('stream_url'); ?></span>
                  </div>
                </div>
              </div>
                     
              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <textarea  id="description" name="description" class="form-control" placeholder="Description"> </textarea>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="campaign_email_text" class="col-sm-2 control-label">Campaign Text</label>
                  <div class="col-sm-4">
                   <input type="text" id="campaign_email_text" name="campaign_email_text" class="form-control" placeholder="Campaign Email Text"/>
                   <span class="text-danger"><?= form_error('external_url'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="campaign_email" class="col-sm-2 control-label">Campaign Email</label>
                  <div class="col-sm-4">
                   <input type="text" id="campaign_email" name="campaign_email" class="form-control" placeholder="Campaign Email"/>
                   <span class="text-danger"><?= form_error('campaign_email'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="backdrop" class="col-sm-2 control-label">Campaign Backdrop (1280x720)</label>
                  <div class="col-sm-4">
                    <input type="file" id="backdrop" name="backdrop"/>
                  </div>
                </div>
              </div>

             <!--  <div class="row"> 
                <div class="form-group">
                  <label for="category_id" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-4">
                     <select id="category_id" name="category_id" class="form-control">
                          <option value="">Select a Category</option>
                        <?php foreach($categories as $category){?>
                          <option value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php }?>
                     </select>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="make_clickable" class="col-sm-2 control-label">Make Clickable</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="make_clickable" class="onoffswitch-checkbox" id="make_clickable" value="1">
                      <label class="onoffswitch-label" for="make_clickable">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="exclude_country" class="col-sm-2 control-label">Countries to</label>
                  <div class="col-sm-4">
                    <label>
                      <input type="radio" name="exclude_country" id="flat-radio-1" value="no" class="flat-red" checked>  
                    </label>
                    <label for="flat-radio-1" class="" style="font-size:14px;">Include</label>
                    <label>
                      <input type="radio" name="exclude_country" id="flat-radio-2" value="yes" class="flat-red"> 
                    </label>
                    <label for="flat-radio-2" class="">Exclude</label>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="available_countries" class="col-sm-2 control-label">Countries</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_countries" id="multiselect_left_package" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($countries as $country) { ?>
                                    <option value="<?=$country->id?>"><?=$country->name?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_package" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_package" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_package" class="form-control" name="countries[]" size="15" multiple="multiple" required>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_package" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_package" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!-- 
              <div class="row"> 
                <div class="form-group">
                  <label for="country_id" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-4">
                    <select id="country_id" name="country_id" class="form-control">
                      <option selected>Please Select Country</option>
                      <?php foreach($countries as $country){?>
                          <option value="<?=$country->id?>"><?=$country->name?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="state_id" class="col-sm-2 control-label">State</label>
                  <div class="col-sm-4">
                    <select id="state_id" name="state_id" class="form-control">
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="city_id" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-4">
                     <select id="city_id" name="city_id" class="form-control"> </select>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add Banner</button>
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