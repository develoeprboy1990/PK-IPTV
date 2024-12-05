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
            <form method="post" action="<?= BASE_URL ?>customer/changePassword" class="form-horizontal">
              <input type="hidden" name="user_id" value="<?=$user_id?>">
              <div class="row"> 
                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Old Password *</label>
                  <div class="col-sm-4">
                   <input type="password" id="password" name="password" class="form-control" value="" placeholder="Old Password" required/>
                   <span class="text-danger"><?= form_error('password'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="new_password" class="col-sm-2 control-label">New Password *</label>
                  <div class="col-sm-4">
                   <input type="password" id="new_password" name="new_password" class="form-control" value="" placeholder="New Password" required/>
                   <span class="text-danger"><?= form_error('new_password'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="confirm_password" class="col-sm-2 control-label">Confirm New Password</label>
                  <div class="col-sm-4">
                   <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="" placeholder="Confirm New Password" required/>
                   <span class="text-danger"><?= form_error('confirm_password'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
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