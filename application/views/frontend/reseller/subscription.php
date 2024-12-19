<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($is_allow)){    
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
                            <ul class="nav nav-tabs">
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Add Subscription Code</a></li>
                              
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
															<div class="box box-primary">
																
																<?php if($responce = $this->session->flashdata('success')){ ?>
																	<div class="alert alert-warning" role="alert" style="text-align:center"><?php echo @$responce;?></div>
																<?php } ?>
																<div class="box-body">
																  <form method="post" action="<?= BASE_URL ?>reseller/subscription/" class="form-horizontal">
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="product_id" class="col-sm-2 control-label"><a title=" Product Name" style="cursor:pointer;"> Product Name</a></label>
																		<div class="col-sm-4">
																		   <select id="product_id" name="product_id" class="form-control">
																				<option value="">Select a Product</option>
																			  <?php foreach($products as $product){?>
																				<option value="<?php echo @$product['id']; ?>" <?php if(@$product_id == @$product['id']){ echo 'selected="selected"'; } ?>><?php echo @$product['name']; ?></option>
																			  <?php }?>
																		   </select>
																		   <span class="text-danger"><?= form_error('product_id'); ?></span>
																		</div>
																	  </div>
																	</div>
																	
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="devices_allow" class="col-sm-2 control-label"><a title="Keycode Length" style="cursor:pointer;">Keycode Length</a></label>
																		<div class="col-sm-4">
																		 <input type="number" id="keycode_length" name="keycode_length" class="form-control" placeholder="Max 10" value="<?php echo @$keycode_length;?>"/>
																		 <span class="text-danger"><?= form_error('keycode_length'); ?></span>
																		</div>
																	  </div>
																	</div>
																	
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="devices_allow" class="col-sm-2 control-label"><a title="Total Devices Allowed" style="cursor:pointer;">Total Devices Allowed</a></label>
																		<div class="col-sm-4">
																		 <input type="number" id="devices_allowed" name="devices_allowed" class="form-control" placeholder="500" value="<?php echo @$devices_allowed;?>"/>
																		 <span class="text-danger"><?= form_error('devices_allowed'); ?></span>
																		</div>
																	  </div>
																	</div>
															
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="quantity" class="col-sm-2 control-label">Price</label>
																		<div class="col-sm-2">
																		 <input type="text"  pattern="[0-9]*[.,]?[0-9]*" id="price" name="price" class="form-control" placeholder="5000" value="<?php echo @$price;?>"/>
																		 <span class="text-danger"><?= form_error('price'); ?></span>
																		</div>
																		<div class="col-sm-2">
																				<select id="currency_type" name="currency_type" class="form-control"> 
																					  <option value="" >Select Currency</option>						
																					<?php foreach(COUNTRY_CURRENCY as $key=>$val){?>														
																					  <option value="<?php echo @$val;?>" <?php if(@$currency_type == @$val ){ echo 'selected';} ?>><?php echo @$key;?></option>														
																					<?php }?> 
																				</select>
																		   
																		 <span class="text-danger"><?= form_error('currency_type'); ?></span>
																		</div>
																	  </div>
																	</div>
															
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="length_months" class="col-sm-2 control-label"><a title="Subscription Time" style="cursor:pointer;">Subscription Time</a></label>
																		<div class="col-sm-2">
																		 <input type="number" id="length_months" name="length_months" class="form-control" placeholder="12" value="<?php echo @$length_months;?>"/>
																		  <span class="text-danger"><?= form_error('length_months'); ?></span>
																		 </div>
																		 <div class="col-sm-2">
																		  <select id="month_day" name="month_day" class="form-control">
																				<option value="">Select a Option</option>
																				<option value="months" <?php if(@$month_day == 'months' ){ echo 'selected';}?>>Months</option>
																				<option value="days" <?php if(@$month_day == 'days' ){ echo 'selected';}?>>days</option>                 
																		   </select>
																		   
																		 <span class="text-danger"><?= form_error('month_day'); ?></span>
																		</div>
																	  </div>
																	</div>
																	
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="devices_allow" class="col-sm-2 control-label"><a title="Commission" style="cursor:pointer;">Commission</a>Commission (%)</label>
																		<div class="col-sm-4">
																		 <input type="number" id="commission" name="commission" class="form-control" value="<?php echo @$commission;?>"/> 
																		 <span class="text-danger"><?= form_error('commission'); ?></span>
																		</div>
																	  </div>
																	</div>
																										
																	<div class="row"> 
																	  <div class="form-group">
																		<label for="length_months" class="col-sm-2 control-label"><a title="Status" style="cursor:pointer;">Status</a>Status</label>
																		
																		 <div class="col-sm-4">
																		  <select id="status" name="status" class="form-control">
																				<option value="">Select a Option</option>
																				<option value="1" <?php if(@$month_day == '1' ){ echo 'selected';}?>>ON</option>
																				<option value="0" <?php if(@$month_day == '0' ){ echo 'selected';}?>>OFF</option>                 
																		   </select>
																		   
																		 <span class="text-danger"><?= form_error('status'); ?></span>
																		</div>
																	  </div>
																	</div>
																	<div class="row"> 
																	  <div class="form-group">
																		<label class="col-sm-2 control-label"></label>
																		<div class="col-sm-4">
																		  <input type="submit" class="btn btn-success " name="add_subscription" value="Ganerate Subscription Code">
																		</div>
																	  </div>
																	</div>
																  </form>
																</div>
															</div>
                               
							   
							   
							   <div class="box box-primary">
						<div class="box-header"><h4>Reseller Subscription Keys</h4></div>
						<div class="box-header">
						  <!--<span class="pull-right"><span class="export-icon">Export to: </span>
							<a href="<?=site_url('keys/subscriptionExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
							<a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
						  </span> -->
						</div>
						<div class="box-body">
						  <div id="ajax_search_responce" class="table-responsive">
							<table id="apps" class="table table-bordered table-striped">
							  <thead>
								<tr>
								  <th>S.No#</th>
								  <th>ID#</th>
								  <th><a title="Code" style="cursor:pointer;">Code</a> </th>
								  <th><a title="Product" style="cursor:pointer;">Product</a> </th>
								  <th><a title="Price" style="cursor:pointer;">Price</a></th>
								  <th><a title="Commission" style="cursor:pointer;">Commission</a></th>
								  <th><a title="Net Price" style="cursor:pointer;">Net Price</a></th>									  
								  <th><a title="Status" style="cursor:pointer;">Status</a></th>
								  <th><a title="Used" style="cursor:pointer;">Used</a></th>
								  <th><a title="Device allow" style="cursor:pointer;">Device allow</a></th>
								  <th>Subscription Time</th>
								  <?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
								  <th>Action</th>
								  <?php } ?>
								</tr> 
							  </thead>
							  
							  <tbody>
								<?php 
								$c = 1;
								foreach($all_reseller_code as $key){?>
								 <tr>
								 	<td><?php echo @$c; ?></td>
									 <td><?php echo @$key['id']; ?></td>
									<td><?php echo @$key['code']; ?></td>
									<td><?php echo @$products_list['products_'.$key['product_id']]; ?></td>
									<td><?php echo @$key['price'].' '.$key['currency_type']; ?></td>
									<td><?php echo @$key['commission'].' '.$key['currency_type']; ?></td>
									<td><?php echo @($key['price']-$key['commission']).' '.@$key['currency_type']; ?></td>
									<td><?php echo (@$key['active']==1) ? "Active" : "Inactive"; ?></td>
									<td><?php echo (@$key['used_by']==1) ? "Used" : "Not-Used"; ?></td>
									<td><?php echo @$key['devices_allowed']; ?></td>
									<td><?php echo @$key['life_length'].' '.$key['day_month']; ?></td>
									
									<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
									<td>
										<?php if($is_allow->allow_delete) {?> 
											<?php echo btn_delete(BASE_URL.'reseller/deletesubscription/'.$key['id'])?> &nbsp; 
										<?php 
											  } 											
										?> 
											
									</td>
									<?php } ?>
								</tr>
								<?php $c++; }?>
							  </tbody>
							</table>
						  </div>
						</div>
					</div>
								
                              </div>

                             
                            </div>
                            <!-- /.tab-content -->
                          </div>
                          <!-- nav-tabs-custom -->
                        </div>
                    </div>
					
					
					
					
					
					
                </section>
            </div>
