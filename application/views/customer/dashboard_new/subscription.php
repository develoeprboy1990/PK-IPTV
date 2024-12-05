  <div class="card mb-5 mb-xl-10">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Subscription Code</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
										
										<form class="form" method="post" action="<?php echo site_url('customer/activatsubscriptionecode'); ?>">
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													<div class="row mb-6">
														<label class="col-lg-4 col-form-label fw-semibold"></label>
														<div class="col-lg-8">
																<!--begin::Row-->
																<div class="row">
																	<?php if($message == 'error'){ ?>
																		<div class="alert alert-danger" role="alert" style="text-align:left;">
																			<?php echo validation_errors(); ?>									
																		</div>
																	<?php } ?>
																	<?php if($this->session->flashdata('message_set')){ ?>
																	<div class="alert alert-danger" role="alert" style="text-align:left;">
																		<?php echo $this->session->flashdata('message_set'); ?>
																	</div>
																	<?php } ?>
																</div>
														</div>
													</div>
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Subscription Keys</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															
															 <input type="text" id="a_key" name="a_key" class="form-control form-control-lg form-control-solid" value="<?php echo $password;?>" placeholder=" Subscription Keys"/>
														</div>
														<!--end::Col-->
													</div>
													
													
													
													
													
												
												
													<div class="card-footer d-flex justify-content-end py-6 px-9">
													<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
													<!--<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>-->
													<input type="submit" name="activation_code" id="activation_code" value="Make Subscription" class="btn btn-primary"  />
												</div>
												
												</div>
												</form>
										
										
										
											</div>
										<!--end::Content-->
									</div>