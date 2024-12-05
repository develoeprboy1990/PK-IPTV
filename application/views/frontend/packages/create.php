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
            <form method="post" action="<?=BASE_URL ?>packages/create" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Package Name</label>

                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" placeholder="Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Price</label>

                  <div class="col-sm-4">
                   <input type="text" id="price" name="price" class="form-control" placeholder="Price"/>
                   <span class="text-danger"><?= form_error('price'); ?></span>
                  </div>
                </div>
              </div>

               <div class="row"> 
                <div class="form-group">
                  <label for="vat" class="col-sm-2 control-label">VAT</label>

                  <div class="col-sm-4">
                   <input type="text" id="vat" name="vat" class="form-control" placeholder="VAT"/>
                   <span class="text-danger"><?= form_error('vat'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="channel_group" class="col-sm-2 control-label">Channels</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="from" id="multiselect_left" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($channels as $channel) { ?>
                                    <option value="<?=$channel['id']?>"><?=$channel['channel_name']?></option>
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
                            <select id="multiselect_right" class="form-control" name="channels[]" size="15" multiple="multiple">
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
              </div>
             
              <div class="row"> 
                <div class="form-group">
                  <label for="device_type" class="col-sm-2 control-label">Device Type</label>

                  <div class="col-sm-4">
                   <select id="device_type" name="device_type">
                     <?php foreach ($devices as $device) { ?>
                     <option value="<?=$device->id?>"><?=$device->name?></option>
                     <?php }?>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6 text-center">
                  <button type="submit" class="btn btn-success ">Add Package</button>
                </div>
              </div>

            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->