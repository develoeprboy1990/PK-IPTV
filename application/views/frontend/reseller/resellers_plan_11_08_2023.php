<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(11);  // channel module id

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
                          <!-- Custom Tabs -->
                          <div class="nav-tabs-custom">
                            <!--<ul class="nav nav-tabs">
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Subscription Plans</a></li>
                              
                            </ul>-->
                            <div class="tab-content">
                              <?php defined('BASEPATH') OR exit('No direct script access allowed');?>
								<div class="box box-primary">
									<div class="box-header"><h4><i class="fa fa-plus"></i>Create Reseller Plans</h4></div>
									<?php if($responce = $this->session->flashdata('success')){ ?>
										<div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
									<?php } ?>
									<div class="box-body">
									  <form method="post" action="<?= BASE_URL ?>reseller/resellerplans" class="form-horizontal">
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
											<label for="group_name" class="col-sm-2 control-label">Number Of Keys</label>
											<div class="col-sm-4">
											 <input type="number" id="keysnumber" name="keysnumber" class="form-control" value="<?php echo $keysnumber;?>" required/>
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
											<label for="devices_allow" class="col-sm-2 control-label">Number of Devices Allowed</label>
											<div class="col-sm-4">
											 <input type="number" id="devices_allowed" name="devices_allowed" class="form-control" placeholder="5" required value="<?php echo $devices_allowed;?>"/>
											 <span class="text-danger"><?= form_error('devices_allowed'); ?></span>
											</div>
										  </div>
										</div>
								
										<div class="row"> 
										  <div class="form-group">
											<label for="quantity" class="col-sm-2 control-label">Price</label>
											<div class="col-sm-2">
											 <input type="number" id="price" name="price" class="form-control" placeholder="50" required value="<?php echo $price;?>"/>
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
																			<label for="quantity" class="col-sm-2 control-label">Plan Description</label>
																			<div class="col-sm-4">
																			 <textarea id="facility_content" name="facility_content" class="form-control" placeholder="Plan Description write here..." required ><?php echo $plan_details['facility_content'];?></textarea>
																			 <span class="text-danger"><?= form_error('quantity'); ?></span>
																			</div>
																		  </div>
																		</div>
										
										<div class="row"> 
										  <div class="form-group">
											<label class="col-sm-2 control-label"></label>
											<div class="col-sm-4">
											  <input type="submit" class="btn btn-success " name="subscription_plans" value="Create Reseller Plans">
											</div>
										  </div>
										</div>
									  </form>
									</div>
								</div>


                             
                            </div>
                            <!-- /.tab-content -->
                          </div>
                          <!-- nav-tabs-custom -->
                        </div>
                    </div>
					
					<div class="box box-primary">
    <div class="box-header"><h4>Renewal Plans</h4></div>
    <div class="box-header">
      <span class="pull-right"><span class="export-icon">Export to: </span>
        <a href="<?=site_url('keys/subscriptionExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
        <a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
      </span> 
    </div>
    <div class="box-body">
      <div id="ajax_search_responce">
        <table id="apps" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Product</th>
			  <th>Code</th>
              <th>Price</th>
			  <th>Currency</th>
			  <th>Plan Time</th> 
			  <th>Device allow</th>
              <th>Status</th>	
			  <th>Used</th>			  
			  <?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
              <th>Action</th>
			  <?php } ?>
            </tr> 
          </thead>
          
          <tbody>
            <?php foreach($reseller_m as $key){?>
             <tr>
                <td><?php echo $key['name']; ?></td>
                <td><?php echo $products_list['products_'.$key['product_id']]; ?></td>
				 <td><?php echo $key['key_code']; ?></td>
                <td><?php echo ($key['monthly_price'] * $key['length_months']); ?></td>
				<td><?php echo $key['currency_type']; ?></td>
				<td><?php echo $key['length_months'].' '.$key['month_day']; ?></td>
				<td><?php echo $key['devices_allowed']; ?></td>
                <td><?php echo ($key['active']==1) ? "Active" : "Inactive"; ?></td>
				 <td><?php echo ($key['used_by']=='') ? "Not-Used" : "Used"; ?></td>
				<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
                <td>
					<?php if($is_allow->allow_delete) {?> 
						<?php echo btn_delete(BASE_URL.'reseller/deletecode/'.$key['id'])?> &nbsp; 
					<?php }  ?>
				</td>
				<?php } ?>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
</div>
                </section>
				
				
				
				
				
            </div>