<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>
 
    <!-- Main content -->
    <section class="content">
      <?php if($responce = $this->session->flashdata('success')){ ?>
            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
      <?php } ?>

      <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>customers/addPackage/<?=$customer_id?>" class="form-horizontal">
              <div class="row"> 
                <input type="hidden" name="total_channel_package" id="multiselect_right_package_number">
                <div class="form-group">
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
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Packages</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>
    </section>
</div>