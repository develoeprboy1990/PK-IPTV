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
            <form method="post" action="<?= BASE_URL ?>email_templates/create" class="form-horizontal">
              
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-8">
                   <input type="text" id="name" name="name" class="form-control" value="<?=set_value('name')?>" placeholder="Template Name" required/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="subject" class="col-sm-2 control-label">Subject</label>
                  <div class="col-sm-8">
                   <input type="text" id="subject" name="subject" class="form-control" value="<?=set_value('subject')?>" placeholder="Subject" required/>
                   <span class="text-danger"><?= form_error('subject'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sender_name" class="col-sm-2 control-label">Sender Name</label>
                  <div class="col-sm-8">
                   <input type="text" id="sender_name" name="sender_name" class="form-control" value="<?=set_value('sender_name')?>" placeholder="Sender Name" required/>
                   <span class="text-danger"><?= form_error('sender_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="sender_email" class="col-sm-2 control-label">Sender Email</label>
                  <div class="col-sm-8">
                   <input type="email" id="sender_email" name="sender_email" class="form-control" value="<?=set_value('sender_email')?>" placeholder="Sender Email" required/>
                   <span class="text-danger"><?= form_error('sender_email'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="bcc" class="col-sm-2 control-label">BCC</label>
                  <div class="col-sm-8">
                   <input type="email" id="bcc" name="bcc" class="form-control" value="<?=set_value('bcc')?>" placeholder="BCC"/>
                   <span class="text-danger"><?= form_error('bcc'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="email-message-body" class="col-sm-2 control-label">Message Body</label>
                  <div class="col-sm-8">
                    <textarea id="email-message-body" name="body" rows="10" cols="80" required>
                            <?=set_value('body')?>
                    </textarea>
                  </div>
                </div>
              </div>
             
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add Template</button>
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