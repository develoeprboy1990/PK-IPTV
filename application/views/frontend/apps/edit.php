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
                  <label for="icon" class="col-sm-2 control-label">Icon</label>
                  <div class="col-sm-4">
                   <input type="file" id="icon" name="icon"/>
                    <?php if($details->icon!="") { ?>
                      <img class="" src="<?=base_url()."uploads/apps/".$details->icon?>" width="180">
                    <?php }?>
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
                  <label for="" class="col-sm-2 control-label">App Url</label>
                  <div class="col-sm-8" >
                    <div style="border:1px solid #d2d6de; border-radius:10px;padding:20px;">
                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="server_url_id" class="col-sm-2 control-label">Server Url</label>
                            <div class="col-sm-3">
                              <select id="server_url_id" name="server_url_id" class="form-control">
                                  <option value="">Select a Url</option>
                               <?php foreach($server_urls as $url){ ?>
                                  <option value="<?=$url->id?>" <?=($details->server_url_id==$url->id) ? "selected" : ""?>><?=$url->name?></option>
                               <?php } ?>
                              </select>
                            </div>

                            <div class="col-sm-7">
                              <input type="text" id="url" name="url" value="<?=$details->url?>" class="form-control" required/>
                              <p class="help-block">Select server and add only stream name, or select no server and add full url.</p>
                              <span class="text-danger"><?= form_error('url'); ?></span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row"> 
                        <div class="form-group">
                          <div class="col-sm-12">
                            <label for="token_id" class="col-sm-2 control-label">Tokenize</label>
                            <div class="col-sm-6">
                              <select id="token_id" name="token_id" class="form-control">
                               <?php foreach($tokens as $token){ ?>
                                  <option value="<?=$token->id?>" <?=($details->token_id==$token->id) ? "selected" : ""?>><?=$token->name?></option>
                               <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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