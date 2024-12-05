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
            <form method="post" action="<?= BASE_URL ?>prerolls/create" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="type" value="preroll">
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" placeholder="Name" required/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="length" class="col-sm-2 control-label">Length (in seconds)</label>
                  <div class="col-sm-4">
                   <input type="text" id="length" name="length" class="form-control" placeholder="length" required/>
                   <span class="text-danger"><?= form_error('length'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="url" class="col-sm-2 control-label">Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="url" name="url" class="form-control" placeholder="Url" required/>
                   <span class="text-danger"><?= form_error('url'); ?></span>
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
                      <input type="text" class="form-control pull-right" id="date_start" name="date_start" required>
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
                      <input type="text" class="form-control pull-right" id="date_end" name="date_end" required>
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

             <!--  <div class="row"> 
                <div class="form-group">
                  <label for="price_per_view" class="col-sm-2 control-label">Price per View</label>
                  <div class="col-sm-4">
                   <input type="text" id="price_per_view" name="price_per_view" class="form-control" placeholder="Price per View"/>
                   <span class="text-danger"><?= form_error('price_per_view'); ?></span>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label for="available_channels" class="col-sm-2 control-label">Channels</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_channels" id="multiselect_left_channels" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($channels as $channel) { ?>
                                    <option value="<?=$channel['id']?>"><?=$channel['channel_name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_channels" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_channels" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_channels" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_channels" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_channels" class="form-control" name="channels[]" size="15" multiple="multiple">
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_channels" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_channels" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
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
                  <label for="available_series" class="col-sm-2 control-label">Series</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_series" id="multiselect_left_series" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($series as $serie) { ?>
                                    <option value="<?=$serie['id']?>"><?=$serie['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_series" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_series" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_series" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_series" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_series" class="form-control" name="series[]" size="15" multiple="multiple">
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_series" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_series" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
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
                  <label for="available_movies" class="col-sm-2 control-label">Movies</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_movies" id="multiselect_left_movies" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($movies as $movie) { ?>
                                    <option value="<?=$movie['id']?>"><?=$movie['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_movies" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_movies" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_movies" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_movies" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_movies" class="form-control" name="movies[]" size="15" multiple="multiple">
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_movies" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_movies" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
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
                  <label for="exclude_country" class="col-sm-2 control-label">Countries To</label>
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
                  <label for="available_countries" class="col-sm-2 control-label">Select Countries</label>
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

              <!-- <div class="row"> 
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
                    <button type="submit" class="btn btn-success ">Add Preroll Video</button>
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