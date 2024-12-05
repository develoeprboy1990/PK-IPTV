<div class="card mb-5 mb-xl-10">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Recharge Customer</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form class="form" method="post" action="<?php echo site_url('resellers/rechargecustomer');?>">
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													<!--begin::Input group-->
													
													<!--end::Input group-->
													<div class="row mb-6">
														
														<div class="col-lg-8">
																<!--begin::Row-->
																<div class="row">
																	<?php if($message == 'error'){ ?>
																		<div class="alert alert-danger" role="alert" style="text-align:left;">
																			<?php echo validation_errors(); ?>									
																		</div>
																	<?php } ?>
																</div>
														</div>
													</div>
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Customer Name</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-6 fv-row">
															<select id="customet_id" name="customet_id" data-control="select2" data-placeholder="Select Customer.." 
																class="form-select form-select-solid form-select-lg">
																<option value="">Select Customer</option>
												<?php
													foreach($customers as $key=>$val){
												?>
													 <option value="<?php echo $val['id'];?>" <?php if($customet_id == $val['id']){ echo 'selected="selected"';} ?> >
													 		<?php echo $val['title'].' '.$val['first_name'].' '.$val['last_name'].' ('.$val['email'].')';?>
													 </option>
												<?php
													}
												?>
														  </select>
															
														</div>
														<!--end::Col-->
													</div>
																							
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-2 col-form-label required fw-semibold fs-6">Plan Keycode</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-6 fv-row">
															<input type="text" name="plan_keycode" class="form-control form-control-lg form-control-solid" placeholder="Plan Keycode..." value="<?php echo $plan_keycode;?>" />
													
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->													
													
													<div class="row mb-6">
														<label class="col-lg-5 col-form-label fw-semibold fs-6"></label>
														<div class="col-lg-4 d-flex align-items-center">
														<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
														<!--<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>-->
														<input type="submit" name="create_customer" id="create_customer" value="Create Customer" class="btn btn-primary"  />
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
										</div>
										<!--end::Content-->
									</div>