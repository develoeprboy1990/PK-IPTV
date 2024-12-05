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
            <form method="post" action="<?= BASE_URL ?>registrationOtp/otp/1" class="form-horizontal">
              
             
             <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">OTP Status Change</label>
                  <div class="col-sm-4">
                   <!--<input type="text" id="page_title" name="page_title" class="form-control" value="<?=set_value('page_title')?>" placeholder="Page Title"/>-->
				   <select id="status" name="status" class="form-control" >
				   		<option value="1" <?php if($status == '1'){ echo 'selected';} ?> >Yes</option>
						<option value="0" <?php if($status == '0'){ echo 'selected';} ?> >No</option>
				   </select>
                   <span class="text-danger"><?= form_error('status'); ?></span>
                  </div>
                </div>
              </div>

                          
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="submit" class="btn btn-success" id="change_status" name="change_status" value="Change Status" />
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