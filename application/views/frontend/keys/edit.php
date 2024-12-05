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
            <form method="post" action="<?= BASE_URL ?>apps/edit/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">

               <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="<?=$details->name?>" placeholder="Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="url" class="col-sm-2 control-label">Url</label>
                  <div class="col-sm-4">
                   <input type="text" id="url" name="url" class="form-control" value="<?=$details->url?>" placeholder="Url"/>
                   <span class="text-danger"><?= form_error('url'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="icon" class="col-sm-2 control-label">Icon</label>
                  <div class="col-sm-4">
                   <input type="file" id="icon" name="icon"/>
                  </div>
                </div>
              </div>
          
              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <textarea  id="description" name="description" class="form-control" placeholder="Description"><?=$details->description?></textarea>
                   <span class="text-danger"><?= form_error('description'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="category_id" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-4">
                   <select id="category_id" name="category_id" class="form-control">
                        <option value="">Select a Category</option>
                      <?php foreach($categories as $category){?>
                        <option value="<?=$category['id']?>" <?=($category['id']==$details->category_id) ? "selected": ""?>><?=$category['name']?></option>
                      <?php }?>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="show_on_home" class="col-sm-2 control-label">Show on Home</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1" <?=($details->show_on_home==1) ? "checked" : ""?>>
                      <label class="onoffswitch-label" for="show_on_home">
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
                    <button type="submit" class="btn btn-success ">Update App</button>
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