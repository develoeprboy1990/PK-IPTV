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
            <form method="post" action="<?=BASE_URL ?>menus/create" class="form-horizontal">
              
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Menu Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" placeholder="Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="type" class="col-sm-2 control-label">Type</label>
                  <div class="col-sm-4">
                   <select name="type" class="form-control" id="type">
                      <option value="">Select Type</option>
                      <option value="full">Full</option>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_default" class="col-sm-2 control-label">Is Default?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <label>
                        <input type="radio" name="is_default" id="is-default-1" value="yes" class="flat-red">  
                      </label>
                      <label for="is-default-1" class="" style="font-size:14px;">Yes</label>
                      <label>
                        <input type="radio" name="is_default" id="is-default-2" value="no" class="flat-red" checked> 
                      </label>
                      <label for="is-default-2" class="">No</label>
                    </div>
                  </div>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group">
                  <label for="is_module" class="col-sm-2 control-label">Is Module?</label>
                  <div class="col-sm-4">
                    <label>
                      <input type="radio" name="is_module" id="is-module-1" value="no" class="flat-red" checked>  
                    </label>
                    <label for="is-module-1" class="" style="font-size:14px;">No</label>
                    <label>
                      <input type="radio" name="is_module" id="is-module-2" value="yes" class="flat-red"> 
                    </label>
                    <label for="is-module-2" class="">Yes</label>
                  </div>
                </div>
              </div> 

              <div class="row" id="module-name-box"> 
                <div class="form-group">
                  <label for="module_name" class="col-sm-2 control-label">Module Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="module_name" name="module_name" class="form-control" placeholder="Module Name"/>
                   <span class="text-danger"><?= form_error('module_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_app" class="col-sm-2 control-label">Is App?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <label>
                        <input type="radio" name="is_app" id="is-app-1" value="no" class="flat-red" checked>  
                      </label>
                      <label for="is-app-1" class="" style="font-size:14px;">No</label>
                      <label>
                        <input type="radio" name="is_app" id="is-app-2" value="yes" class="flat-red"> 
                      </label>
                      <label for="is-app-2" class="">Yes</label>
                    </div>
                  </div>
                </div>
              </div> 

              <div class="row"> 
                <div class="form-group">
                  <label for="position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-4">
                   <input type="text" id="position" name="position" class="form-control" placeholder="Position"/>
                   <span class="text-danger"><?= form_error('position'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="available_packages" class="col-sm-2 control-label">Packages</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_packages" id="multiselect_left_package" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($menu_packages as $package) { ?>
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
                            <select id="multiselect_right_package" class="form-control" name="menus[]" size="15" multiple="multiple">
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
                  <label for="active" class="col-sm-2 control-label">Active</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="active" class="onoffswitch-checkbox" id="active" value="1"/>
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
                    <button type="submit" class="btn btn-success ">Add Menu</button>
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