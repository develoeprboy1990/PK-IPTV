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
            <form method="post" action="<?= BASE_URL ?>products/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
              
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
                  <label for="image" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-4">
                   <input type="file" id="image" name="image"/>
                    <?php if($details->image!="") { ?>
                      <img class="" src="<?=base_url()."uploads/products/".$details->image?>" width="200">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="publish_start" class="col-sm-2 control-label">Publish Start</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="publish_start" name="publish_start" value="<?=$details->publish_start?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="publish_end" class="col-sm-2 control-label">Publish End</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="publish_end" name="publish_end" value="<?=$details->publish_end?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="service_id" class="col-sm-2 control-label">Services</label>
                  <div class="col-sm-2">
                     <select id="service_id" name="service_id" class="form-control" required>
                        <option value="" <?=($details->service_id==0) ? "selected" : ""?>>Select a Service</option>
                        <?php foreach($services as $service){?>
                        <option value="<?=$service['id']?>" <?=($service['id']==$details->service_id) ? "selected" : ""?>><?=$service['name']?></option>
                        <?php }?>
                     </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="news_group_id" class="col-sm-2 control-label">News Group</label>
                  <div class="col-sm-3">
                     <select id="news_group_id" name="news_group_id" class="form-control" required>
                        <option value="">Select a News Group</option>
                        <?php foreach($news_groups as $group){?>
                        <option value="<?=$group['id']?>" <?=($group['id']==$details->news_group_id) ? "selected" : ""?>><?=$group['name']?></option>
                        <?php }?>
                     </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="server_id" class="col-sm-2 control-label">Server Location</label>
                  <div class="col-sm-3">
                     <select id="server_id" name="server_id" class="form-control" required>
                        <option value="">Please select the Server Location</option>
                        <?php foreach($locations as $location){?>
                        <option value="<?=$location->id?>" <?=($location->id==$details->server_id) ? "selected" : ""?>><?=$location->name?></option>
                        <?php }?>
                     </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="gui_setting_id" class="col-sm-2 control-label">Gui Settings</label>
                  <div class="col-sm-3">
                     <select id="gui_setting_id" name="gui_setting_id" class="form-control" required>
                        <option value="">Select a GUI Settings</option>
                        <?php foreach($settings as $setting){?>
                        <option value="<?=$setting['id']?>" <?=($setting['id']==$details->gui_setting_id) ? "selected" : ""?>><?=$setting['setting_name']?></option>
                        <?php }?>
                     </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <input type="hidden" name="total_devices" id="multiselect_right_devices_number"> 
                <div class="form-group">
                  <label for="available_devices" class="col-sm-2 control-label">Devices</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_devices" id="multiselect_left_devices" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($devices as $device) { ?>
                                    <option value="<?=$device['id']?>"><?=$device['model_name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_devices" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_devices" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_devices" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_devices" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_devices" class="form-control" name="devices[]" size="15" multiple="multiple">
                                <?php foreach ($devices as $device) { ?>
                                    <?php if(in_array($device['id'],$selected_devices)) {?>
                                    <option value="<?=$device['id']?>"><?=$device['model_name']?></option>
                                    <?php }?>
                                <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_devices" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_devices" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
                  <label for="plan_name" class="col-sm-2 control-label">Plan Name</label>
                  <div class="col-sm-2">
                   <input type="text" id="plan_name" name="plan_name" value="<?=$details->plan_name?>" class="form-control" placeholder="Plan Name" required/>
                   <span class="text-danger"><?= form_error('plan_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="subscription_length" class="col-sm-2 control-label">Subscription Length Days</label>
                  <div class="col-sm-1">
                   <input type="text" id="subscription_length" name="subscription_length" value="<?=$details->subscription_length?>" class="form-control" placeholder="30" required/>
                   <span class="text-danger"><?= form_error('subscription_length'); ?></span>
                  </div>
                  <div class="col-sm-2">
                    <select name="subscription_days_or_month" id="subscription_days_or_month" class="form-control">
                      <option value="month" <?=($details->subscription_days_or_month=="month") ? "selected": ""?>>Months</option>
                      <option value="days" <?=($details->subscription_days_or_month=="days") ? "selected": ""?>>Days</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Subscription Price</label>
                  <div class="col-sm-1">
                   <input type="text" id="price" name="price"  value="<?=$details->price?>" class="form-control" placeholder="15.00" required/>
                   <span class="text-danger"><?= form_error('price'); ?></span>
                  </div>
                </div>
              </div>
         
              <div class="row"> 
                <div class="form-group">
                  <input type="hidden" name="total_package" id="multiselect_right_package_number">
                  <label for="available_packages" class="col-sm-2 control-label">Packages</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_packages" id="multiselect_left_package" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($packages as $package) { ?>
                                    <option value="<?=$package['id']?>"><?=$package['name']?></option>
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
                            <select id="multiselect_right_package" class="form-control" name="packages[]" size="15" multiple="multiple">
                                  <?php foreach ($packages as $package) { ?>
                                    <?php if(in_array($package['id'],$selected_packages)) {?>
                                    <option value="<?=$package['id']?>"><?=$package['name']?></option>
                                    <?php }?>
                                  <?php }?>
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

              <div class="row"> 
                <div class="form-group">
                  <label for="app_package_id" class="col-sm-2 control-label">App Package</label>
                  <div class="col-sm-3">
                     <select id="app_package_id" name="app_package_id" class="form-control" required>
                        <?php foreach($app_packages as $package){?>
                        <option value="<?=$package['id']?>" <?=($package['id']==$details->app_package_id) ? "selected": ""?>><?=$package['name']?></option>
                        <?php }?>
                     </select>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <input type="hidden" name="total_app_package" id="multiselect_right_number">
                <div class="form-group">
                  <label for="available_app_packages" class="col-sm-2 control-label">App Packages</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_app_packages" id="multiselect_left" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($app_packages as $package) { ?>
                                    <option value="<?=$package['id']?>"><?=$package['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right" class="form-control" name="app_packages[]" size="15" multiple="multiple">
                                  <?php foreach ($app_packages as $package) { ?>
                                    <?php if(in_array($package['id'],$selected_app_packages)) {?>
                                    <option value="<?=$package['id']?>"><?=$package['name']?></option>
                                    <?php }?>
                                  <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <input type="hidden" name="total_vod_stores" id="multiselect_right_stores_number">
                <div class="form-group">
                  <label for="available_stores" class="col-sm-2 control-label">VOD Stores</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_stores" id="multiselect_left_stores" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($stores as $store) { ?>
                                    <option value="<?=$store['id']?>"><?=$store['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_stores" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_stores" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_stores" class="form-control" name="stores[]" size="15" multiple="multiple">
                                  <?php foreach ($stores as $store) { ?>
                                    <?php if(in_array($store['id'],$selected_stores)) {?>
                                    <option value="<?=$store['id']?>"><?=$store['name']?></option>
                                    <?php }?>
                                  <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_stores" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_stores" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
                <input type="hidden" name="total_series_stores" id="multiselect_right_series_stores_number">
                <div class="form-group">
                  <label for="available_series_stores" class="col-sm-2 control-label">Series Stores</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_series_stores" id="multiselect_left_series_stores" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($series_stores as $store) { ?>
                                    <option value="<?=$store['id']?>"><?=$store['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_series_stores" class="form-control" name="series_stores[]" size="15" multiple="multiple">
                                  <?php foreach ($series_stores as $store) { ?>
                                    <?php if(in_array($store['id'],$selected_series_stores)) {?>
                                    <option value="<?=$store['id']?>"><?=$store['name']?></option>
                                    <?php }?>
                                  <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_series_stores" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
                <input type="hidden" name="total_countries" id="multiselect_right_countries_number"> 
                <div class="form-group">
                  <label for="enable_geo_location" class="col-sm-2 control-label">Enable Geo Trageting</label>
                  <div class="col-sm-10">
                    <div class="onoffswitch">
                      <input type="checkbox" name="enable_geo_location" class="onoffswitch-checkbox" id="enable_geo_location" value="1" <?=($details->enable_geo_location==1) ? "checked" : ""?> >
                      <label class="onoffswitch-label" for="enable_geo_location">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                     <span class="help-block">Note: Check this box to enable Geo Targeting on this product only customers from the selected countries can subscribe to this product.</span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="countries" class="col-sm-2 control-label">Geo Locations</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="countries" id="multiselect_left_countries" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($countries as $country) { ?>
                                    <option value="<?=$country->id?>"><?=$country->name?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_countries" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_countries" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_countries" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_countries" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_countries" class="form-control" name="countries[]" size="15" multiple="multiple">
                                <?php foreach ($countries as $country) { ?>
                                    <?php if(in_array($country->id,$selected_countries)) {?>
                                      <option value="<?=$country->id?>"><?=$country->name?></option>
                                    <?php }?>
                                <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_countries" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_countries" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
                  <label for="subscription_length" class="col-sm-2 control-label">Customer can change Plan</label>
                  <div class="col-sm-2">
                    <select name="customer_can_change_plan" id="customer_can_change_plan" class="form-control">
                      <option value="1" <?=($details->customer_can_change_plan=="1") ? "selected": ""?>>Yes</option>
                      <option value="0" <?=($details->customer_can_change_plan=="0") ? "selected": ""?>>NO</option>
                    </select>
                  </div>
                </div>
              </div>
			  <!--<div class="row"> 
				  <div class="form-group">
					<label for="product_id" class="col-sm-2 control-label">Product Group</label>
					<div class="col-sm-4">
					   <select id="product_group" name="product_group" class="form-control" required>
								<option value="">Select Product Group</option>
								<?php //foreach(PRODUCTGROUP as $key=>$val){?>
								<option value="<?php //echo $key; ?>"  <?php //($details->product_group==$key) ? "selected": "" ?>><?php //echo $val; ?></option>
								<?php //}?>
					  </select>
					</div>
				  </div>
				</div>-->
              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Product</button>
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