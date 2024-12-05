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

    <div class="box-header"><h4><i class="fa fa-edit"></i> Edit <?php echo $app_publish->type ?> App Publish</h4></div>
    <?php if($response = $this->session->flashdata('success')){ ?>
        <div class="alert alert-success" role="alert" style="text-align:center"><?php echo $response;?></div>
    <?php } ?>
    <div class="box-body"> 
      <form method="post" action="<?= BASE_URL ?>app_publish/updateAppPublish" class="form-horizontal">
        <input type="hidden" name="id" value="<?php echo $app_publish->id; ?>">
        <input type="hidden" name="type" value="<?php echo $app_publish->type; ?>">
        
        <div class="row"> 
          <div class="form-group">
            <label for="title" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-4">
             <input type="text" id="title" name="title" class="form-control" value="<?php echo $app_publish->title; ?>" required/>
             <span class="text-danger"><?= form_error('title'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="action" class="col-sm-2 control-label">Action</label>
            <div class="col-sm-4">
             <input type="text" id="action" name="action" class="form-control" value="<?php echo $app_publish->action; ?>" required/>
             <span class="text-danger"><?= form_error('action'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-4">
             <textarea id="description" name="description" class="form-control" required><?php echo $app_publish->description; ?></textarea>
             <span class="text-danger"><?= form_error('description'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="date" class="col-sm-2 control-label">Date</label>
            <div class="col-sm-4">
             <input type="date" id="date" name="date" class="form-control" value="<?php echo $app_publish->date; ?>" required/>
             <span class="text-danger"><?= form_error('date'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="version_number" class="col-sm-2 control-label">Version Number</label>
            <div class="col-sm-4">
             <input type="text" id="version_number" name="version_number" class="form-control" value="<?php echo $app_publish->version_number; ?>" required/>
             <span class="text-danger"><?= form_error('version_number'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="package_name" class="col-sm-2 control-label">Package Name</label>
            <div class="col-sm-4">
             <input type="text" id="package_name" name="package_name" class="form-control" value="<?php echo $app_publish->package_name; ?>" required/>
             <span class="text-danger"><?= form_error('package_name'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="url" class="col-sm-2 control-label">URL</label>
            <div class="col-sm-4">
             <input type="url" id="url" name="url" class="form-control" value="<?php echo $app_publish->url; ?>" required/>
             <span class="text-danger"><?= form_error('url'); ?></span>
            </div>
          </div>
        </div>
        <div class="row"> 
          <div class="form-group">
            <label for="forceupdate" class="col-sm-2 control-label">Force Update</label>
            <div class="col-sm-4">
              <select id="forceupdate" name="forceupdate" class="form-control" required>
                <option value="1" <?php echo ($app_publish->forceupdate == '1') ? 'selected' : ''; ?>>True</option>
                <option value="0" <?php echo ($app_publish->forceupdate == '0') ? 'selected' : ''; ?>>False</option>
              </select>
             <span class="text-danger"><?= form_error('forceupdate'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="update_without_login" class="col-sm-2 control-label">Update Without Login</label>
            <div class="col-sm-4">
              <select id="update_without_login" name="update_without_login" class="form-control" required>
                <option value="1" <?php echo ($app_publish->update_without_login == '1') ? 'selected' : ''; ?>>True</option>
                <option value="0" <?php echo ($app_publish->update_without_login == '0') ? 'selected' : ''; ?>>False</option>
              </select>
             <span class="text-danger"><?= form_error('update_without_login'); ?></span>
            </div>
          </div>
        </div>

        <?php if($app_publish->type == 'Beta'): ?>
<div class="row"> 
    <div class="form-group">
        <label for="beta_type" class="col-sm-2 control-label">Beta Type</label>
        <div class="col-sm-4">
            <select id="beta_type" name="beta_type" class="form-control">
                <option value="">Select Beta Type</option>
                <option value="Beta-Setup Box" <?php echo ($app_publish->beta_type == 'Beta-Setup Box') ? 'selected' : ''; ?>>Beta-Setup Box</option>
                <option value="Beta-General" <?php echo ($app_publish->beta_type == 'Beta-General') ? 'selected' : ''; ?>>Beta-General</option>
            </select>
            <span class="text-danger"><?= form_error('beta_type'); ?></span>
        </div>
    </div>
</div>
<?php endif; ?>

        <div class="row"> 
          <div class="form-group">
              <label for="remarks" class="col-sm-2 control-label">Remarks</label>
              <div class="col-sm-4">
                  <textarea id="remarks" name="remarks" class="form-control"><?php echo $app_publish->remarks; ?></textarea>
                  <span class="text-danger"><?= form_error('remarks'); ?></span>
              </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-success">Update <?php echo $app_publish->type ?> App Publish</button>
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