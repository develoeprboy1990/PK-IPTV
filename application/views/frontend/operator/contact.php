 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <?php echo $page_title; ?>
      <?php echo $breadcrumb; ?>
    </section>

        <!-- Main content -->
    <section class="content">
      <div class="box box-primary">
          <div class="box-body">
            <?php if($responce = $this->session->flashdata('success')){ ?>
                <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
            <?php } ?>
            <form method="post" action="<?=BASE_URL ?>operator/contact/<?=$type?>" enctype="multipart/form-data">
         
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="name" class="col-sm-12 control-label">Name</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value="<?=ucwords($details->name)?>" id="name" name="name" class="form-control" disabled/>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="logo" class="col-sm-12 control-label">GUI Logo</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="file" id="logo" name="logo" />

                  <?php if($details->logo!="") { ?>
                    <img class="" src="<?=base_url()."uploads/contact/".$details->logo?>" width="180">
                  <?php }?>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="background" class="col-sm-12 control-label">GUI Background</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="file" id="background" name="background" />

                  <?php if($details->background!="") { ?>
                    <img class="" src="<?=base_url()."uploads/contact/".$details->background?>" width="250">
                  <?php }?>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="qrcode" class="col-sm-12 control-label">QR Code</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="qrcode" value="<?=$details->qrcode?>" name="qrcode" class="form-control"/>
                  <span class="text-danger"><?= form_error('qrcode'); ?></span>
                </div>
              </div>
              
              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="text" class="col-sm-12 control-label">Text</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="text" value="<?=$details->text?>" name="text" class="form-control"/>
                  <span class="text-danger"><?= form_error('text'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="gui-text" class="col-sm-12 control-label">GUI Text</label>
                </div>
                <div class="form-group col-md-8">
                  <textarea id="gui-text" name="gui_text"><?=$details->gui_text?></textarea>
                  <span class="text-danger"><?= form_error('gui_text'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="selection_color" class="col-sm-12 control-label">Selection Color</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" id="selection_color" value="<?=$details->selection_color;?>" name="selection_color" class="form-control" />
                  <span class="text-danger"><?= form_error('selection_color'); ?></span>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-3">
                  <label for="operator_storage" class="col-sm-12 control-label"></label>
                </div>
                <div class="form-group col-md-6">
                   <button type="submit" class="btn btn-success ">Update</button>
                </div>
              </div> 
            </form>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->   