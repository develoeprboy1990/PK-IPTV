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
            <form method="post" action="<?= BASE_URL ?>gui_versions/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
              <div class="row"> 
                <div class="form-group">
                  <label for="version" class="col-sm-2 control-label">Version</label>
                  <div class="col-sm-4">
                   <input type="text" id="version" name="version" value="<?=$details->version?>" class="form-control" placeholder="1.1" required/>
                   <span class="text-danger"><?= form_error('version'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="changelog" class="col-sm-2 control-label">Changelog</label>
                  <div class="col-sm-4">
                   <textarea id="changelog" name="changelog" class="form-control" required/><?=$details->changelog?></textarea>
                   <span class="text-danger"><?= form_error('changelog'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="location" class="col-sm-2 control-label">Location</label>
                  <div class="col-sm-4">
                   <input type="text" id="location" name="location" value="<?=$details->location?>" class="form-control" placeholder="http://" required/>
                   <span class="text-danger"><?= form_error('location'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update GUI Version</button>
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