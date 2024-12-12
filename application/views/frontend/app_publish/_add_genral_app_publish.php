<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box box-primary">
    <div class="box-header"><h4><i class="fa fa-plus"></i> Create General App Publish</h4></div>
    <?php if($response = $this->session->flashdata('success')){ ?>
        <div class="alert alert-success" role="alert" style="text-align:center"><?php echo $response;?></div>
    <?php } ?>
    <div class="box-body"> 
      <form method="post" action="<?= BASE_URL ?>app_publish/createAppPublish" class="form-horizontal">
        <input type="hidden" name="type" value="General">
        <div class="row"> 
          <div class="form-group">
            <label for="title" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-4">
             <input type="text" id="title" name="title" class="form-control" placeholder="Enter title..." required/>
             <span class="text-danger"><?= form_error('title'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="action" class="col-sm-2 control-label">Action</label>
            <div class="col-sm-4">
             <input type="text" id="action" name="action" class="form-control" placeholder="Enter action..." required/>
             <span class="text-danger"><?= form_error('action'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-4">
             <textarea id="description" name="description" class="form-control" placeholder="Enter description..." required></textarea>
             <span class="text-danger"><?= form_error('description'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="date" class="col-sm-2 control-label">Date</label>
            <div class="col-sm-4">
             <input type="date" id="date" name="date" class="form-control" required/>
             <span class="text-danger"><?= form_error('date'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="version_number" class="col-sm-2 control-label">Version Number</label>
            <div class="col-sm-4">
             <input type="text" id="version_number" name="version_number" class="form-control" placeholder="Enter version number..." required/>
             <span class="text-danger"><?= form_error('version_number'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="package_name" class="col-sm-2 control-label">Package Name</label>
            <div class="col-sm-4">
             <input type="text" id="package_name" name="package_name" class="form-control" placeholder="Enter package name..." required/>
             <span class="text-danger"><?= form_error('package_name'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="url" class="col-sm-2 control-label">URL</label>
            <div class="col-sm-4">
             <input type="url" id="url" name="url" class="form-control" placeholder="Enter URL..." required/>
             <span class="text-danger"><?= form_error('url'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="forceupdate" class="col-sm-2 control-label">Force Update</label>
            <div class="col-sm-4">
              <select id="forceupdate" name="forceupdate" class="form-control" required>
                <option value="1">True</option>
                <option value="0">False</option>
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
                <option value="1">True</option>
                <option value="0">False</option>
              </select>
             <span class="text-danger"><?= form_error('update_without_login'); ?></span>
            </div>
          </div>
        </div> 


        <div class="row"> 
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-success">Create General App</button>
            </div>
          </div>
        </div>
      </form>
     </div>
</div>