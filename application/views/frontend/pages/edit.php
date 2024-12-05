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
            <form method="post" action="<?= BASE_URL ?>pages/edit/<?php echo $page_id;?>" class="form-horizontal">
              
			   <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Page Name</label>
                  <div class="col-sm-8">
                   <input type="text" id="page_name" name="page_name" class="form-control" value="<?php echo $page_name; ?>" placeholder="Page Name" readonly />
                   <span class="text-danger"><?= form_error('page_name'); ?></span>
                  </div>
                </div>
              </div>
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Page Title</label>
                  <div class="col-sm-8">
                   <input type="text" id="pages_title" name="pages_title" class="form-control" value="<?php echo $pages_title;?>" placeholder="Page Title"/>
                   <span class="text-danger"><?= form_error('pages_title'); ?></span>
                  </div>
                </div>
              </div>

             

              <div class="row"> 
                <div class="form-group">
                  <label for="email-message-body" class="col-sm-2 control-label">Page Content</label>
                  <div class="col-sm-8">
                    <textarea id="email-message-body" name="page_content" rows="10" cols="80">
                            <?php echo $page_content; ?>
                    </textarea>
					 <span class="text-danger"><?= form_error('page_content'); ?></span>
                  </div>
                </div>
              </div>
             
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="submit" class="btn btn-success" id="edit_page" name="edit_page" value="edit Page" />
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