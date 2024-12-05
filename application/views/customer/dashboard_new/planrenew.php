  <div class="card mb-5 mb-xl-10" id="renewal_change">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Change Or Renewal Plan</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										
										
										
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
										
										
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													
													<div style="text-align: center;">
													<!--<a type="reset" class="btn btn-light btn-active-light-primary me-2" onclick="planchange();return false;">Change Plan</a>-->
													<a type="submit" class="btn btn-primary" id="kt_account_profile_details_submit" onclick="renuewplan();return fal;se;">Renew Plan</a>
													<!--<input type="submit" name="activation_code" id="activation_code" value="Renuew Plan" class="btn btn-primary"  />-->
												</div>
												
												</div>
												
										
										
										
											</div>
										<!--end::Content-->
									</div>
									
<div class="card mb-5 mb-xl-10" style="display:none;" id="select_plans">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details" style=" border-bottom: 1px solid #ccc!important;">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Renew Plan</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										
								<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									<!--begin::Pricing card-->
									<div class="card" id="kt_pricing">
										<!--begin::Card body-->
										<div class="card-body">
											<!--begin::Plans-->
											<div class="d-flex flex-column">
												<!--begin::Heading-->
												<div class="text-center">
													<h1 class="fs-2hx fw-bold mb-5">Renew Plan</h1>
													<!--<div class="text-gray-400 fw-semibold fs-5">Please select your fevotite.</div>-->
													<div class="row">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6"></label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<div id="renuew_msg" style="float: left;"></div>
														</div>
													</div>
												
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Subscription Code</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															
															 <input type="text" id="plan_keycode" name="plan_keycode" class="form-control form-control-lg form-control-solid" value="" placeholder="Subscription Code"/>
														</div>
														<!--end::Col-->
													</div>
													
													<div class="text-center" style="text-align:right !important;">											
														<button type="submit" onclick="renuew_plan_subscribe();return false;" class="btn btn-primary">
															<span class="indicator-label">Renew Plan</span>												
														</button>
													</div>	
												</div>
												<!--end::Heading-->
												
												<!--begin::Row-->
												
												
												
												
												
												
												
												<div class="card-body pt-0" style="display:none;">											
											<div class="table-responsive">												
												<table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
													<thead class="fs-7 text-gray-400 text-uppercase">
														<tr>
															<th>Plan Name</th>
															<th>Price</th>															
															<th>Validity</th>
															<?php if($select_planstype != 'aproduct'){ ?>
															<th>Device Allow</th>
															<?php } ?>															
														</tr>
													</thead>
													<tbody class="fs-6"><tr>
																	<td>																
																		<div class="d-flex align-items-center">
																			<div class="d-flex flex-column justify-content-center">
																			<a href="" class="fs-6 text-gray-800 text-hover-primary">
																				<?php 
																					if($select_planstype == 'aplan'){
																						echo $select_products['plan_name'];
																					}elseif($select_planstype == 'splan'){
																						echo $select_plans['name'];
																					}elseif($select_planstype == 'rcode'){
																						echo $select_plans['group_name'];
																					}elseif($select_planstype == 'aproduct'){
																						echo $select_products['name'].'('.$select_products['plan_name'].')';
																					}
																				?>
																			</a>
																				<span></span>
																			</div>
																		</div>
																	</td>
																	<?php if($select_planstype == 'aproduct'){ ?>
																	<td>$<?php echo $select_products['price']?></td>
																	<?php }else{ ?>
																	<td>$<?php echo $select_plans['monthly_price']*$select_plans['length_months'];?></td>
																	<?php } ?>
																	<?php if($select_planstype == 'aproduct'){ ?>
																<td><?php echo $select_products['subscription_length'].' '.$select_products['subscription_days_or_month'];?></td>																	
																	<?php }else{ ?>
																	<td><?php echo $select_plans['length_months'].' '.$select_plans['month_day'];?></td>
																	<?php } ?>
																	
																	<?php if($select_planstype != 'aproduct'){ ?>
																	<td><?php echo $select_plans['devices_allowed'];?></td>	
																	<?php } ?>														
																</tr>				
														
													</tbody>
												</table>
												
												<div class="text-center" style="text-align:right !important;">											
													<button type="submit" onclick="renuew_plan('<?php echo $select_plans['id'];?>','<?php echo $select_planstype;?>');return false;" class="btn btn-primary">
														<span class="indicator-label">Renuew Plan</span>												
													</button>
												</div>	
										
											</div>
										</div>
												
										
												
												
												
												
												
												
												
												
												
												
												
												
												
												<!--end::Row-->
											</div>
											<!--end::Plans-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Pricing card-->
								</div>
								<!--end::Content container-->
							</div>
					</div>
					
<div id="planchange" style="display:none;">								
									
<div class="card mb-5 mb-xl-10">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details" style=" border-bottom: 1px solid #ccc!important;">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Change Plan</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										
								<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									<!--begin::Pricing card-->
									<div class="card" id="kt_pricing">
										<!--begin::Card body-->
										<div class="card-body">
											<!--begin::Plans-->
											<div class="d-flex flex-column">
												<!--begin::Heading-->
												<div class="text-center">
													<h1 class="fs-2hx fw-bold mb-5">Choose Your Plan</h1>
													<!--<div class="text-gray-400 fw-semibold fs-5">Please select your fevotite.</div>-->
													
												</div>
												<!--end::Heading-->
												
												<!--begin::Row-->
												<div class="row g-10">
												<?php
													foreach($plans as $key=>$val){
													if (in_array($val['id'], $product_select_group)){
												?>
													<!--begin::Col-->
													<div class="col-xl-4">
														<div class="d-flex h-100 align-items-center" 
														<?php if($user_info->sebscription_trpe == 'splan'){ ?>
																		<?php if($user_info->product_activation_key_id == $val['id']){ ?>
																			style="background:#80bfff;"
																		<?php } ?>
														<?php } ?>
														>
															<!--begin::Option-->
															<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
																<!--begin::Heading-->
																<div class="mb-7 text-center">
																	<!--begin::Title-->
																	<h1 class="text-dark mb-5 fw-bolder"><?php echo $val['name'];?></h1>
																	<?php if($user_info->sebscription_trpe == 'splan'){ ?>
																		<?php if($user_info->product_activation_key_id == $val['id']){ ?>
																			<div style="color:#00CC00">Current Plan</div>
																		<?php } ?>
																	<?php } ?>
																	<!--end::Title-->
																	<!--begin::Description-->
																	<div class="text-gray-400 fw-semibold mb-5"><?php echo $val['tag_title'];?></div>
																	<!--end::Description-->
																	<!--begin::Price-->
																	<div class="text-center">
																		<span class="mb-2 text-primary">$</span>
																		<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399"><?php echo $val['monthly_price']*$val['length_months']; ?></span>
																		<!--<span class="fs-7 fw-semibold opacity-50">/
																		<span data-kt-element="period">Mon</span></span>-->
																	</div>
																	<!--end::Price-->
																	
																	<div class="text-center">
																		<span class="mb-2 text-primary">Validity : </span>
																		<span class="mb-2 text-primary"><?php  echo $val['length_months'].' '.$val['month_day'];?></span>
																	</div>
																
																</div>
																
																<!--end::Heading-->
																<!--begin::Features-->
																<div class="w-100 mb-10">
																	
																	<?php
																		$arr = explode("\n", $val['facility_content']);																	
																		foreach($arr as $vals){
																	?>
																	
																	<div class="d-flex align-items-center mb-5">
																		<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3"><?php echo $vals;?></span>
																		<i class="ki-duotone ki-check-circle fs-1 text-success">
																			<span class="path1"></span>
																			<span class="path2"></span>
																		</i>
																	</div>
																	
																	<?php
																		}
																	?>
																
																</div>
																<!--end::Features-->
																<!--begin::Select-->
																<!--<a href="#" onclick="change_plan(<?php echo $val['id']; ?>);return false;" class="btn btn-sm btn-primary">Select</a>
-->														<a href="#" onclick="call_plan(<?php echo $val['id']; ?>);return false;" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_change_plan"<?php if($user_info->sebscription_trpe == 'splan'){ ?>
																		<?php if($user_info->product_activation_key_id == $val['id']){ ?>
																				style="display:none"
																		<?php } ?>
														<?php } ?>
														>Change Plan</a>
														<!--end::Select-->
															</div>
															<!--end::Option-->
														</div>
													</div>
													<!--end::Col-->
												<?php
														}
													} 
												?>
												</div>
												<!--end::Row-->
											</div>
											<!--end::Plans-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Pricing card-->
								</div>
								<!--end::Content container-->
							</div>
					</div>
</div>
					
<!--begin::Modal - New Target-->
		<div class="modal fade" id="kt_modal_change_plan" tabindex="-1" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content rounded">
					<!--begin::Modal header-->
					<div class="modal-header pb-0 border-0 justify-content-end">
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
						<!--end::Close-->
					</div>
					<!--begin::Modal header-->
					<!--begin::Modal body-->
					<div id="plan_id"></div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - New Target-->