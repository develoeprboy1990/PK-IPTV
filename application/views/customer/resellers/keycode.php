<div class="card mb-5 mb-xl-8">
										<!--begin::Header-->
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bold fs-3 mb-1">Key Code</span>
												<!--<span class="text-muted mt-1 fw-semibold fs-7">Over 500 Customers</span>-->
											</h3>
											<!--<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
												<a href="<?php echo BASE_URL;?>resellers/createcustomer" class="btn btn-sm btn-light btn-active-primary">
												<i class="ki-duotone ki-plus fs-2"></i>New Member</a>
											</div>-->
										</div>
										<!--end::Header-->
										<div id="kt_app_content" class="collapse show">
											<!--begin::Form-->
											<form class="form" method="post" action="<?php echo site_url('resellers/keycode');?>">
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													<!--begin::Input group-->
													
													<!--end::Input group-->
													<div class="row mb-6">
														<?php if($this->session->flashdata('message_set')){ ?>
															<!--<div class="fv-row mb-8">-->
															<div class="col-lg-8 fv-row">
															<?php if($this->session->flashdata('error')){ ?>
																<div class="alert alert-danger" role="alert" style="text-align:left;">
																	<?php echo $this->session->flashdata('error'); ?>
																</div>
															<?php } ?>
															<?php if($this->session->flashdata('success')){ ?>
																<div class="alert alert-success" role="alert" style="text-align:left;">
																	<?php echo $this->session->flashdata('success'); ?>
																</div>
															<?php } ?>
															</div>
														<?php } ?>
														<?php if($message == 'error'){ ?>
														<div class="col-lg-8">
																<!--begin::Row-->
																<div class="row">
																	
																		<div class="alert alert-danger" role="alert" style="text-align:left;">
																			<?php echo validation_errors(); ?>									
																		</div>
																	
																</div>
														</div>
														<?php } ?>
													</div>
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Plans</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-6 fv-row">
															<select id="plan_id" name="plan_id" data-control="select2" data-placeholder="Select a Plans.." class="form-select form-select-solid form-select-lg">
															<option value="">Select a Plans...</option>
															<?php
													$c = 1;
													//$discount_arr = array('','Fixed Price','Percentage');
													foreach($selected_plans_list as $key=>$val){ 
													?>
															 <option value="<?php echo $val['id'];?>" <?php if($plan_id == $val['id']){ echo 'selected="selected"';} ?>>
															 <?php echo $reseller_plansArray['id_'.$val['product_plans']]['name'].' ( '; ?>
															 <?php //echo ' ( '.$products_list['products_'.$reseller_plansArray['id_'.$val['product_plans']]['product_id']].' | '; ?>
															 <?php echo ' Device Allowed : '.$reseller_plansArray['id_'.$val['product_plans']]['devices_allowed'].' | '; ?>
															 <?php //echo ' Retail Price : '.$reseller_plansArray['id_'.$val['product_plans']]['monthly_price'].' '.$val['currency_type']. ' | '; ?>
															 <?php echo ' Dealer Price : '.$val['dealer_price'].' '.$val['currency_type']; ?>
															 <?php echo ' ) '; ?>
															 </option>
													<?php } ?>
															
														  </select>
															
														</div>
														<!--end::Col-->
													</div>
													
													<!--end::Input group-->
													
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Number of Codes</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-6 fv-row">
															<input type="text" name="number_codes" class="form-control form-control-lg form-control-solid" placeholder="Number of Codes" value="<?php echo $number_codes;?>" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													
													
													<div class="row mb-6">
														<label class="col-lg-5 col-form-label fw-semibold fs-6"></label>
														<div class="col-lg-4 d-flex align-items-center">
														<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
														<!--<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>-->
														<input type="submit" name="create_code" id="create_code" value="Create Code" class="btn btn-primary"  />
														</div>
													</div>
												</div>
												<!--end::Card body-->
												<!--begin::Actions-->
												<div class="card-footer d-flex justify-content-end py-6 px-9">
													
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Form-->
										
										
								<div id="myPopup" class="popup" style="display:none;">
									<div class="popup-content">
										<h2 style="color:green; margin-top:0;" id="enable_disable_title"></h2>
										<p>Write reason:</p>
										<span><input type="hidden" id="code_id" value="" /></span>
										<span><input type="hidden" id="change_type" value="" /></span>
										<div><textarea id="user_message" style="width:100%;min-height: 100px;"></textarea></div>
										<div style="width:40%; min-width:90px; float:left;">
										<button class="btn btn-block btn-primary btn-flat" onclick="makedisablecode()">Submit</button>
										</div>
										<div style="width:30%; min-width:50px; float:right;">
										<button id="closePopup" class="btn btn-block btn-primary btn-flat">Close</button>
										</div>
									</div>
								</div>
								
								<div id="messagHistory" class="popup" >
									<div class="popup-content" style="width:70%;margin-left: 25%;">
										<span id="closePopupMessageHistory" style="float: right;color: red;font-size: 25px;font-weight: bold;cursor: pointer;margin-top: -25px;
    margin-right: -15px;">X</span>	
										<h2 style="color:green; margin-top:0;">Message History</h2>
										<div id="msg_list"></div>																		
									</div>
									
								</div>
								
										<!--begin::Body-->
										<div class="card-body py-3">
											<!--begin::Table container-->
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="reseller_keycode">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bold text-muted">															
															<th class="min-w-20px">SL.NO</th>
															<th class="min-w-50px">Plan Name</th>
															<th class="min-w-50px">Key Code</th>
															<th class="min-w-50px">Price</th>
															<th class="min-w-50px">Devices Allowed</th>
															<th class="min-w-50px">Subscription</th> 
															<th class="min-w-100px">Used</th>
															<th class="min-w-40px">Status</th>
															<th class="min-w-40px">Message</th>
															<th class="min-w-70px text-end">Actions</th>
														</tr>
													</thead>
													<!--end::Table head-->
													<!--begin::Table body-->
													<tbody>
													<?php
													$c = 1;
													foreach($resellerKeycode as $key=>$val){
													?>
														<tr>
															<td><?php echo $c;?></td>
															<td>
																<div class="d-flex align-items-center">
																	
																	<div class="d-flex justify-content-start flex-column">
																		<a href="#" class="text-dark fw-bold text-hover-primary fs-6"><?php echo $val['group_name'];?></a>
																		<!--<span class="text-muted fw-semibold text-muted d-block fs-7">HTML, JS, ReactJS</span>-->
																	</div>
																</div>
															</td>
															<td>
																<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['keycode'];?></span>
															</td>
															<td>
																<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['monthly_price'].' '.$resellerInfo['currency_type'];?></span>
															</td>
															<td>
																<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['devices_allowed'];?></span>
															</td>
															<td>
																<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['length_months'].$val['month_day'];?></span>
															</td>
															
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold"><?php echo ($val['used'] == '0') ? '<span style="color:#00cc00">NOT USED</span>' : '<span style="color:RED">USED</span>';?></span>
																	</div>
																	
																</div>
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold"><?php echo ($val['disabled'] == '1') ? '<span style="color:RED">OFF</span>' : '<span style="color:#00cc00">ON</span>';?></span>
																	</div>
																	
																</div>
															</td>
															<td class="text-end">
																<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold"><a href="#" style="color:#009ef7;" class="btn btn-light btn-sm" onclick="message_history(<?php echo $val['id']; ?>);return false;">Show</a></span>
																	</div>
																	
																</div>
															</td>
															<td class="text-end">
																<div class="d-flex justify-content-end flex-shrink-0">																
																	
																			<?php
																				if(($val['disabled'] == '0') && ($val['used'] == '0')){
																			?>
																			<a href="#" style="color:red" class="btn btn-light btn-sm" onclick="disable_key(<?php echo $val['id']; ?>);return false;">Make Disable</a>
																			<?php }elseif(($val['disabled'] == '1') && ($val['used'] == '0')){ ?>
																			<a href="#" style="color:#00cc00;" class="btn btn-light btn-sm" onclick="enaable_key(<?php echo $val['id']; ?>);return false;">Make Enable</a>
																			<?php } else{ ?>
																			<a href="<?php echo site_url('resellers/editcustomer/').$val['user_id']; ?>" class="btn btn-light btn-sm">Already Used</a>
																			<?php } ?>
																			
																</div>
															</td>
														</tr>
													<?php
														$c++;
													}
													?>	
													</tbody>
													<!--end::Table body-->
												</table>
												<!--end::Table-->
											</div>
											<!--end::Table container-->
										</div>
										<!--begin::Body-->
										
										</div>
									</div>
<style>
        .popup {
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            display: none;
        }
        .popup-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888888;
            width: 30%;
            font-weight: bolder;
			border: 10px solid #ccc;
    		border-radius: 10px;
			padding-bottom: 50px;
        }
        .popup-content button {
            display: block;
            margin: 0 auto;
        }
        .show {
            display: block !important;
        }
        h1 {
            color: green;
        }
    </style>
	