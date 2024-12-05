<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($is_allow))
{
   redirect('login', 'refresh');
}
?>  
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-md-12">
              <div class="nav-tabs-custom">
                <div class="tab-content">
                  <?php defined('BASEPATH') OR exit('No direct script access allowed');?>
                    <div class="box box-primary">
                        <div class="box-header"><h4><i class="fa fa-edit"></i>Edit Trial Plan</h4></div>
                        <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                        <?php } ?>
                        <div class="box-body">
                          <form method="post" action="<?= BASE_URL ?>reseller/editplanTrial/<?php echo $id;?>" class="form-horizontal">
                            <div class="row"> 
                              <div class="form-group">
                                <label for="group_name" class="col-sm-2 control-label">Plan Name</label>
                                <div class="col-sm-4">
                                 <input type="text" id="sname" name="sname" class="form-control" value="<?php echo $sname;?>" required/>
                                 <span class="text-danger"><?= form_error('group_name'); ?></span>
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
                                        <option value="<?php echo $product['id']; ?>" <?php if($product_id == $product['id']){ echo 'selected="selected"'; } ?>><?php echo $product['name']; ?></option>
                                      <?php }?>
                                   </select>
                                </div>
                              </div>
                            </div>
                    
                            <div class="row"> 
                              <div class="form-group">
                                <label for="devices_allow" class="col-sm-2 control-label">Devices Allowed</label>
                                <div class="col-sm-4">
                                 <input type="number" id="devices_allowed" name="devices_allowed" class="form-control" placeholder="5" required value="<?php echo $devices_allowed;?>"/>
                                 <span class="text-danger"><?php echo form_error('devices_allowed'); ?></span>
                                </div>
                              </div>
                            </div>
                    
                            <div class="row"> 
                              <div class="form-group">
                                <label for="quantity" class="col-sm-2 control-label">Monthly Retail Price</label>
                                <div class="col-sm-2">
                                 <input type="text" pattern="[0-9]*[.,]?[0-9]*" id="price_trial" name="price" class="form-control" placeholder="0" required value="<?php echo $price;?>"/>
                                 <span class="text-danger"><?= form_error('quantity'); ?></span>
                                </div>
                                
                                <div class="col-sm-2">
                                    <select id="currency_type" name="currency_type" class="form-control" required> 
                                          <option value="" >Select Currency</option>						
                                        <?php foreach(COUNTRY_CURRENCY as $key=>$val){?>														
                                          <option value="<?php echo $val;?>" <?php if($currency_type == $val ){ echo 'selected';} ?>><?php echo $key;?></option>														
                                        <?php }?> 
                                    </select>
                                 <span class="text-danger"><?= form_error('currency_type'); ?></span>
                                </div>
                              </div>
                            </div>
                            
                            <div class="row"> 
                              <div class="form-group">
                                <label for="length_months" class="col-sm-2 control-label">Trial Length</label>
                                <div class="col-sm-2">
                                 <input type="number" id="length_months_trial" name="length_months" class="form-control" placeholder="30" required value="<?php echo $length_months;?>"/>
                                 </div>
                                 <div class="col-sm-2">
                                  <select id="month_day" name="month_day" class="form-control" required>
                                        <option value="days" selected>days</option>
                                   </select>
                                 <span class="text-danger"><?= form_error('length_months'); ?></span>
                                </div>
                              </div>
                            </div>
                            
                            <div class="row"> 
                              <div class="form-group">
                                <label for="quantity" class="col-sm-2 control-label">Plan Description</label>
                                <div class="col-sm-4">
                                 <textarea id="facility_content" name="facility_content" class="form-control" placeholder="Plan Description write here..." required ><?php echo $facility_content;?></textarea>
                                 <span class="text-danger"><?= form_error('quantity'); ?></span>
                                </div>
                              </div>
                            </div>
                            
                            <div class="row"> 
                              <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                
                                 <div class="col-sm-2">
                                  <select id="status" name="status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="1" <?php if($status == '1' ){ echo 'selected';} ?>>ON</option>
                                        <option value="0" <?php if($status == '0' ){ echo 'selected';} ?>>OFF</option> 
                                   </select>
                                   
                                 <span class="text-danger"><?= form_error('status'); ?></span>
                                </div>
                              </div>
                            </div>
                            
                            <div class="row"> 
                              <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-4">
                                  <input type="submit" class="btn btn-success " name="resellers_plans" value="Update Trial Plan">
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>