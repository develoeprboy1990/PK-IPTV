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
            <form method="post" action="<?= BASE_URL ?>sms_templates/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
       
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-8">
                   <input type="text" id="name" name="name" class="form-control" value="<?php echo $details->name?>" placeholder="Template Name" readonly />
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="subject" class="col-sm-2 control-label">Subject</label>
                  <div class="col-sm-8">
                   <input type="text" id="subject" name="subject" class="form-control" value="<?php echo $details->subject?>" placeholder="Subject"/>
                   <span class="text-danger"><?= form_error('subject'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sender_name" class="col-sm-2 control-label">Sender Name</label>
                  <div class="col-sm-8">
                   <input type="text" id="sender_name" name="sender_name" class="form-control" value="<?php echo $details->sender_name?>" placeholder="Sender Name"/>
                   <span class="text-danger"><?= form_error('sender_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sender_mobile" class="col-sm-2 control-label">Sender Mobile</label>
                  <div class="col-sm-8">
                   <input type="text" id="sender_mobile" name="sender_mobile" class="form-control" value="<?php echo $details->sender_mobile?>" placeholder="Sender Mobile"/>
                   <span class="text-danger"><?= form_error('sender_mobile'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sms-message-body" class="col-sm-2 control-label">SMS Body</label>
                  <div class="col-sm-8">
                    <textarea id="sms-message-body" name="body" rows="10" cols="80">
                      <?php echo $details->body?>
                    </textarea>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Sms Template</button>
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