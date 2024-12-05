 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>movie_stores/edit/<?=$details->id; ?>"  enctype="multipart/form-data" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Main Store</label>
                  <div class="col-sm-4">
                    <select id="main_store_list" name="parent_id">
                      <option value="0">Select Main Store/ Make this main Store</option>
                      <?php foreach($main_stores as $store){ ?>
                        <option value="<?=$store->id?>" <?php if($details->parent_id==$store->id) echo "selected";?>><?=$store->name?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Store Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" value="<?=$details->name?>" class="form-control"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="logo" class="col-sm-2 control-label">Logo 3:1 (300x100)</label>
                  <div class="col-sm-4">
                   <input type="file" id="logo" name="logo"/>
                    <?php if($details->logo!="") { ?>
                      <img class="" src="<?=base_url().LOCAL_PATH_IMAGES_CMS.$details->logo?>" width="150">
                    <?php }?>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-4">
                   <input type="text" id="position" name="position"  value="<?=$details->position?>" class="form-control"/>
                   <span class="text-danger"><?= form_error('position'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Language</label>
                    <div class="col-sm-4">
                      <select id="language_id" name="language_id" class="form-control">                 
                        <?php foreach ($languages as $language) { ?>
                          <option value="<?=$language['id']?>" <?php if($language['id']==$details->language_id){ ?>selected<?php } ?>><?=$language['name']?></option>
                        <?php } ?>
                      </select>
                    </div>
                    
                  
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="childlock" class="col-sm-2 control-label">Child lock</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="childlock" class="onoffswitch-checkbox" id="childlock" value="1" <?php if($details->childlock==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="childlock">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="childlock" class="col-sm-2 control-label">Active</label>
                  <div class="col-sm-4">
                   <div class="onoffswitch">
                      <input type="checkbox" name="active" class="onoffswitch-checkbox" id="active" value="1"  <?php if($details->active==1) echo "checked";?>>
                      <label class="onoffswitch-label" for="active">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group">
                   <label class="col-sm-2 control-label"></label>
                   <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Edit Store</button>
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