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
            <form method="post" action="<?= BASE_URL ?>customer_devices/create" class="form-horizontal">
              
              <div class="row"> 
                <div class="form-group">
                  <label for="serial" class="col-sm-2 control-label">Serial</label>
                  <div class="col-sm-4">
                   <textarea id="serial" name="serial" class="form-control" placeholder="0011DDFFEEAA"></textarea> 
                  <!--  <input type="text" id="serial" name="serial" class="form-control" value="" placeholder="Serial"/>
                   <span class="text-danger"><?= form_error('serial'); ?></span> -->
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="model_id" class="col-sm-2 control-label">Device Model</label>
                  <div class="col-sm-4">
                   <select id="model" name="model_id" class="form-control">
                      <?php foreach ($models as $model) {?>
                         <option value="<?=$model->id?>"><?=$model->name?></option>
                      <?php } ?>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="location" class="col-sm-2 control-label">Stock Location</label>
                  <div class="col-sm-4">
                   <input type="text" id="location" name="location" class="form-control" value="" placeholder="New York"/>
                   <span class="text-danger"><?= form_error('location'); ?></span>
                  </div>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add Device</button>
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