<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box box-primary">
    <div class="box-header"><h4><i class="fa fa-plus"></i> Create Channel Package Keys</h4></div>
    <?php if($responce = $this->session->flashdata('success')){ ?>
        <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
    <?php } ?>
    <div class="box-body">
      <form method="post" action="<?= BASE_URL ?>keys/createPackageKeys" class="form-horizontal">
        <div class="row"> 
          <div class="form-group">
            <label for="group_name" class="col-sm-2 control-label">Group Name</label>
            <div class="col-sm-4">
             <input type="text" id="group_name" name="group_name" class="form-control" placeholder="50" required/>
             <span class="text-danger"><?= form_error('group_name'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="package_id" class="col-sm-2 control-label">Package</label>
            <div class="col-sm-4">
               <select id="package_id" name="package_id" class="form-control" required>
                    <option value="">Select a package</option>
                  <?php foreach($packages as $package){?>
                    <option value="<?=$package['id']?>"><?=$package['name']?></option>
                  <?php }?>
               </select>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="length" class="col-sm-2 control-label">Keycode Length</label>
            <div class="col-sm-4">
             <input type="text" id="length" name="length" class="form-control" placeholder="10" required/>
             <span class="text-danger"><?= form_error('length'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="prefix-code" class="col-sm-2 control-label">Keycode Prefix</label>
            <div class="col-sm-4">
             <input type="text" id="prefix-code" name="prefix_code" class="form-control" placeholder="666" required/>
             <span class="text-danger"><?= form_error('prefix_code'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="quantity" class="col-sm-2 control-label">Quantity</label>
            <div class="col-sm-4">
             <input type="text" id="quantity" name="quantity" class="form-control" placeholder="50" required/>
             <span class="text-danger"><?= form_error('quantity'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="monthly_price" class="col-sm-2 control-label">Monthly Price</label>
            <div class="col-sm-4">
             <input type="text" id="monthly_price" name="monthly_price" class="form-control" placeholder="25.00" required/>
             <span class="text-danger"><?= form_error('monthly_price'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="length_months" class="col-sm-2 control-label">Length Months</label>
            <div class="col-sm-4">
             <input type="text" id="length_months" name="length_months" class="form-control" placeholder="12" required/>
             <span class="text-danger"><?= form_error('length_months'); ?></span>
            </div>
          </div>
        </div>
        
        <div class="row"> 
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-success ">Create Package Keys</button>
            </div>
          </div>
        </div>
      </form>
    </div>
</div>
