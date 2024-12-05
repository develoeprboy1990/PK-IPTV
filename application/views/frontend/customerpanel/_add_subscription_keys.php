<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box box-primary">
    <div class="box-header"><h4><i class="fa fa-plus"></i>Create Subscription Plans</h4></div>
    <?php if($responce = $this->session->flashdata('success')){ ?>
        <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
    <?php } ?>
    <div class="box-body">
      <form method="post" action="<?= BASE_URL ?>customerpanel" class="form-horizontal">
        <div class="row"> 
          <div class="form-group">
            <label for="group_name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-4">
             <input type="text" id="sname" name="sname" class="form-control" value="<?php echo $sname;?>" required/>
             <span class="text-danger"><?= form_error('group_name'); ?></span>
            </div>
          </div>
        </div>


		<!--<div class="row"> 
          <div class="form-group">
            <label for="product_id" class="col-sm-2 control-label">Product Group</label>
            <div class="col-sm-4">
               <select id="product_group" name="product_group" class="form-control" required>
                        <option value="">Select Product Group</option>
                        <?php //foreach(PRODUCTGROUP as $key=>$val){?>
                        <option value="<?php // echo $key?>"><?php //echo $val?></option>
                        <?php //}?>
              </select>
            </div>
          </div>
        </div>-->
		
		
		
        <div class="row"> 
          <div class="form-group">
            <label for="product_id" class="col-sm-2 control-label">Product</label>
            <div class="col-sm-4">
               <select id="product_id" name="product_id" class="form-control" required>
                    <option value="">Select a Product</option>
                  <?php foreach($products as $product){?>
                    <option value="<?php echo $product['id']; ?>" <?php if($product_id == $product['id']){ echo 'selected="selected"'; } ?>><?php echo $product['name']; ?></option>
                  <?php }?>
               </select>
            </div>
          </div>
        </div>

	 <div class="row"> 
          <div class="form-group" id="corresponding_products" style="display:none;">
            <label for="product_id" class="col-sm-2 control-label">Corresponding Products</label>
            <div class="col-sm-4" id="related_products">
			
			</div>
		</div>
	</div>
	
		<!--<div class="row"> 
          <div class="form-group">
            <label for="product_id" class="col-sm-2 control-label">GUI Settings</label>
            <div class="col-sm-4">
               <select id="gui_setting_id" name="gui_setting_id" class="form-control" required>
                        <option value="">Select a GUI Settings</option>
                        <?php //foreach($settings as $setting){?>
                        <option value="<?php //echo $setting['id'];?>"><?php //echo $setting['setting_name'];?></option>
                        <?php //}?>
              </select>
            </div>
          </div>
        </div>-->
		
        <!--<div class="row"> 
          <div class="form-group">
            <label for="length" class="col-sm-2 control-label">Keycode Length</label>
            <div class="col-sm-4">
             <input type="text" id="length" name="length" class="form-control" placeholder="10" required/>
             <span class="text-danger"></span>
            </div>
          </div>
        </div>

        <div class="row"> 
          <div class="form-group">
            <label for="prefix-code" class="col-sm-2 control-label">Keycode Prefix</label>
            <div class="col-sm-4">
             <input type="text" id="prefix-code" name="prefix_code" class="form-control" placeholder="333" required/>
             <span class="text-danger"></span>
            </div>
          </div>
        </div>-->
        
        <div class="row" style="display:none;"> 
          <div class="form-group">
            <label for="devices_allow" class="col-sm-2 control-label">Number of Devices Allowed</label>
            <div class="col-sm-4">
             <input type="number" id="devices_allowed" name="devices_allowed" class="form-control" placeholder="5" value="<?php echo $devices_allowed;?>"/>
             <span class="text-danger"><?= form_error('devices_allowed'); ?></span>
            </div>
          </div>
        </div>

        <!--<div class="row"> 
          <div class="form-group">
            <label for="quantity" class="col-sm-2 control-label">Quantity</label>
            <div class="col-sm-4">
             <input type="text" id="quantity" name="quantity" class="form-control" placeholder="50" required/>
             <span class="text-danger"></span>
            </div>
          </div>
        </div>-->

		<div class="row"> 
          <div class="form-group">
            <label for="quantity" class="col-sm-2 control-label">Price</label>
            <div class="col-sm-4">
             <input type="number" id="price" name="price" class="form-control" placeholder="50" required value="<?php echo $price;?>"/>
             <span class="text-danger"><?= form_error('quantity'); ?></span>
            </div>
          </div>
        </div>
		
        <div class="row"> 
          <div class="form-group">
            <label for="length_months" class="col-sm-2 control-label">Subscription Length</label>
            <div class="col-sm-2">
             <input type="number" id="length_months" name="length_months" class="form-control" placeholder="12" required value="<?php echo $length_months;?>"/>
			 
			 </div>
			 <div class="col-sm-2">
			  <select id="month_day" name="month_day" class="form-control" required>
                    <option value="">Select a Option</option>
                	<option value="months">Months</option>
                    <option value="days">days</option>                 
               </select>
			   
             <span class="text-danger"><?= form_error('length_months'); ?></span>
            </div>
          </div>
        </div>
		
										<div class="row"> 
										  <div class="form-group">
											<label for="quantity" class="col-sm-2 control-label">Tag Title</label>
											<div class="col-sm-4">
											 <input type="text" id="tag_title" name="tag_title" class="form-control" placeholder="Tag Title..." required value="<?php echo @$plan_details['tag_title'];?>"/>
											 <span class="text-danger"><?= form_error('quantity'); ?></span>
											</div>
										  </div>
										</div>
										
										<div class="row"> 
										  <div class="form-group">
											<label for="quantity" class="col-sm-2 control-label">Plan Description</label>
											<div class="col-sm-4">
											 <textarea id="facility_content" name="facility_content" class="form-control" placeholder="Plan Description write here..." required ><?php echo @$plan_details['facility_content'];?></textarea>
											 <span class="text-danger"><?= form_error('quantity'); ?></span>
											</div>
										  </div>
										</div>
        
        <div class="row"> 
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
              <input type="submit" class="btn btn-success " name="subscription_plans" value="Create Subscription Plans">
            </div>
          </div>
        </div>
      </form>
    </div>
</div>
