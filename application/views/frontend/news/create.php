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
            <form method="post" action="<?= BASE_URL ?>news/create/<?=$group_id?>" class="form-horizontal"  enctype="multipart/form-data">
              <input type="hidden" name="news_group_id" value="<?=$group_id?>">
              <div class="row"> 
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-4">
                   <input type="text" id="title" name="title" class="form-control" placeholder="Name" required/>
                   <span class="text-danger"><?= form_error('title'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">News Image (200 X 90)</label>
                  <div class="col-sm-4">
                   <input type="file" id="image" name="image"/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="news_description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-8">
                   <textarea id="news_description" name="description" class="form-control"/></textarea>
                   <span class="text-danger"><?= form_error('description'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add News</button>
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