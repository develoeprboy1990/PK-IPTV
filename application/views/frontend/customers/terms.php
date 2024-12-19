<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(13);  // channel module id

if(!isset($is_allow))
{
    
   redirect('unauthorize', 'refresh');
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
                            
                            <div class="box">
                              <div class="box-header">
                                <h3 class="box-title">Search Result With Filters</h3>
                              </div>

                              <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('customers/termscreate', '<i class="fa fa-plus"></i> Create Page', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce" class="table-responsive">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
								  <div style="position: absolute;left: 60%; z-index:5000;">
								  <div style="float:left;    margin-top: 5px;">Sort By Reseller: </div>
								  <div style="float:left; margin-left:7px;">
								  <select class="form-control input-sm" data-control="select2" data-hide-search="true" data-placeholder="Sesellers" 
								  data-kt-ecommerce-product-filter="resellers">														
														<option value="all">All</option>
														<option value="Admin">Admin</option>
														<?php foreach($resellers as $key=>$val){?>														
														<option value="<?php echo $val['name'];?>"><?php echo $val['name'];?></option>
														<?php } ?>														
													</select>
								</div>
								</div>
                                  <table id="customers" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>User ID</th>
                                      <th>Pin/Password</th>
									  <th>Alpha Password</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>City</th>
									  <td>Plan Status</td>
                                      <th>Status</th>
									   <th>Reseller Name</th>									  
                                      <th>Edit</th>
                                      <th>Delete</th>
                                    </tr> 
                                  </thead>
                                  
                                  <tbody>
                                    <?php foreach($customers as $customer){?>
                                      <tr>
                                        <td><?=$customer['username']?></td>
                                        <td><?=base64_decode($customer['password'])?></td>
										 <td><?=base64_decode($customer['alpha_password'])?></td>
                                        <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                                        <td><?=$customer['email']?></td>
                                        <td><?=$customer['billing_city']?></td>
										<td>
															<?php
																if($customer['status'] == '0'){
																	//echo '<i class="fi fi-tr-circle-xmark" style="color: #cc0000;font-size: 30px;"></i>';
																	echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
																}elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
																	//echo '<i class="fi fi-tr-clipboard-list-check" style="color: #4287f5;font-size: 30px;"></i>';																	
																	echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
																}elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
																	$today = date("Y-m-d H:i:s");
																	$diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
																	if($diff_time>0){
																		//echo '<i class="fi fi-tr-check-double" style="color: #14b50e;font-size: 30px;"></i>';																	
																		echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
																	}else{
																		echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
																		//echo '<i class="fi fi-bs-badge-check" style="color: #ffcc00;font-size: 30px;"></i>';
																		
																	}
																}
															?>
										</td>
                                        <td><?php //echo ($customer['status']==1) ? "Active" : "Disabled" ?>
										<label class="switch">
										  <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
										  <span class="slider round"></span>
										</label>
										</td>
										<td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                                        <td><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></td>
                                        <td><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></td>
                                      </tr>
                                    <?php }?>
                                  </tbody>
                                </table>
                                </div>
                              </div>
                              <!-- /.box-body -->
                            </div>
                         </div>
                    </div>
                </section>
            </div>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 17px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 10px;
  width: 11px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-straight/css/uicons-bold-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css'>