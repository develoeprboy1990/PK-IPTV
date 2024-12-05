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
            <form method="post" action="<?= BASE_URL ?>devices/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
       
              <div class="row"> 
                <div class="form-group">
                  <label for="model_name" class="col-sm-2 control-label">Model Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="model_name" name="model_name" class="form-control" value="<?=$details->model_name?>" placeholder="Model Name"/>
                   <span class="text-danger"><?= form_error('model_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="model_type" class="col-sm-2 control-label">Model Type</label>
                  <div class="col-sm-4">
                   <input type="text" id="model_type" name="model_type" class="form-control" value="<?=$details->model_type?>" placeholder="Model Type"/>
                   <span class="text-danger"><?= form_error('model_type'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <textarea id="description" name="description" class="form-control" /><?=$details->description?></textarea>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-4">
                   <input type="file" id="image" name="image" class="form-control"/>
                    <?php if($details->image!="") { ?>
                      <img class="" src="<?=base_url()."uploads/devices/".$details->image?>" width="200">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Price</label>
                  <div class="col-sm-4">
                   <input type="text" id="price" name="price" class="form-control" value="<?=$details->price?>" placeholder="Price"/>
                   <span class="text-danger"><?= form_error('price'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="vat" class="col-sm-2 control-label">VAT</label>
                  <div class="col-sm-4">
                   <input type="text" id="vat" name="vat" class="form-control" value="<?=$details->vat?>" placeholder="VAT"/>
                   <span class="text-danger"><?= form_error('vat'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="available" class="col-sm-2 control-label">Available</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="available" class="onoffswitch-checkbox" id="available" value="true" <?=($details->available=="true") ? "checked": ""?>>
                      <label class="onoffswitch-label" for="available">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Device</button>
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