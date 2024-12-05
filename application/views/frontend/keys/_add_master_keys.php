<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box box-primary">
    <div class="box-header"><h4><i class="fa fa-plus"></i> Create Master Keys</h4></div>
    <?php if($responce = $this->session->flashdata('success')){ ?>
        <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
    <?php } ?>
    <div class="box-body">
      <form method="post" action="<?= BASE_URL ?>keys/createMasterKeys" class="form-horizontal">
        <div class="row"> 
          <div class="form-group">
            <label for="group_name" class="col-sm-2 control-label">Group Name</label>
            <div class="col-sm-4">
             <input type="text" id="group_name" name="group_name" class="form-control" placeholder="50" required/>
             <span class="text-danger"><?php echo form_error('group_name'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="product_id" class="col-sm-2 control-label">Product</label>
            <div class="col-sm-4">
               <select id="product_id" name="product_id" class="form-control" required>
                    <option value="">Select a Product</option>
                  <?php foreach($products as $product){?>
                    <option value="<?=$product['id']?>"><?=$product['name']?></option>
                  <?php }?>
               </select>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="length" class="col-sm-2 control-label">Keycode Length</label>
            <div class="col-sm-4">
             <input type="number" id="length" name="length" class="form-control" placeholder="10" required/>
             <span class="text-danger"><?php echo form_error('length'); ?></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="prefix-code" class="col-sm-2 control-label">Keycode Prefix</label>
            <div class="col-sm-4">
             <input type="text" id="prefix-code" name="prefix_code" class="form-control" placeholder="333" required/>
             <span class="text-danger"><?php echo form_error('prefix_code'); ?></span>
            </div>
          </div>
        </div>
        
        <!--<div class="row"> 
          <div class="form-group">
            <label for="devices_allow" class="col-sm-2 control-label">Number of Devices Allowed</label>
            <div class="col-sm-4">
             <input type="number" id="devices_allow" name="devices_allowed" class="form-control" placeholder="5" required/>
             <span class="text-danger"><?php //echo form_error('devices_allowed'); ?></span>
            </div>
          </div>
        </div>-->

        <div class="row"> 
          <div class="form-group">
            <label for="quantity" class="col-sm-2 control-label">Quantity</label>
            <div class="col-sm-4">
             <input type="number" id="quantity" name="quantity" class="form-control" placeholder="50" required/>
             <span class="text-danger"><?php echo form_error('quantity'); ?></span>
            </div>
          </div>
        </div>
		<div class="row"> 
          <div class="form-group">
            <label for="quantity" class="col-sm-2 control-label">Monthly Price</label>
            <div class="col-sm-4">
             <input type="number" id="monthly_price_mas" name="monthly_price" class="form-control" placeholder="50" required/>
             <span class="text-danger"><?php echo form_error('quantity'); ?></span>
            </div>
          </div>
        </div>
        <div class="row"> 
          <div class="form-group">
            <label for="length_months" class="col-sm-2 control-label">Subscription Time</label>
            <div class="col-sm-2">
             <input type="number" id="length_months_mas" name="length_months" class="form-control" placeholder="12" required/>
             <span class="text-danger"><?php echo form_error('length_months'); ?></span>
            </div>
			
			<div class="col-sm-2">
			  <select id="month_day" name="month_day" class="form-control" required>
                    <option value="">Select a Option</option>
                	<option value="months">Months</option>
                    <option value="days">days</option>                 
               </select>
			   
             <span class="text-danger"><?php echo form_error('length_months'); ?></span>
            </div>
          </div>
        </div>
		
        <div class="row"> 
          <div class="form-group">
            <label for="quantity" class="col-sm-2 control-label">Activation Price</label>
            <div class="col-sm-4">
             <input type="number" id="activation_price_mas" name="activation_price" class="form-control" placeholder="50" required/>
             <span class="text-danger"><?php echo form_error('activation_price'); ?></span>
            </div>
          </div>
        </div>
		
		<div class="row" id="total_price_mas" style="display:none;"> 
          <div class="form-group">
            <label for="length_months" class="col-sm-2 control-label">Total price</label>
            <div class="col-sm-4">
             	<span id="price_amount_mas"></span>
            </div>
          </div>
        </div>
		
        <div class="row"> 
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-success ">Create Master Keys</button>
            </div>
          </div>
        </div>
      </form>
    </div>
</div>
