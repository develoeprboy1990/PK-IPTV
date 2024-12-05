 <div class="card mb-5 mb-xl-10">
	<!--begin::Card header-->
	<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
		<!--begin::Card title-->
		<div class="card-title m-0">
			<h3 class="fw-bold m-0">Change Password</h3>
		</div>
		<!--end::Card title-->
	</div>
	<!--begin::Card header-->
	<!--begin::Content-->
	<div id="kt_account_settings_profile_details" class="collapse show">	
		<form class="form" method="post" action="<?php echo site_url('customer/changepassword'); ?>">
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
					<label class="col-lg-4 col-form-label required fw-semibold fs-6">Old Password</label>
					<!--end::Label-->
					<!--begin::Col-->
					<div class="col-lg-8 fv-row">
						
						 <input type="password" id="password" name="password" class="form-control form-control-lg form-control-solid" value="<?php echo $password;?>" placeholder="Old Password"/>
					</div>
					<!--end::Col-->
				</div>
				<div class="row mb-6">
					<!--begin::Label-->
					<label class="col-lg-4 col-form-label required fw-semibold fs-6">New Password</label>
					<!--end::Label-->
					<!--begin::Col-->
					<div class="col-lg-8 fv-row">
						<input type="password" id="newpassword" name="newpassword" class="form-control form-control-lg form-control-solid" value="<?php echo $newpassword;?>" placeholder="New Password"/>
						
					</div>
					<!--end::Col-->
				</div>
				<div class="row mb-6">
					<!--begin::Label-->
					<label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm New Password</label>
					<!--end::Label-->
					<!--begin::Col-->
					<div class="col-lg-8 fv-row">
					<input type="password" id="cnewpassword" name="cnewpassword" class="form-control form-control-lg form-control-solid" value="<?php echo $cnewpassword;?>" placeholder="Confirm New Password"/>
					</div>
					<!--end::Col-->
				</div>
				<div class="card-footer d-flex justify-content-end py-6 px-9">
					<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
					<!--<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>-->
					<input type="submit" name="save_change" id="save_change" value="Save Changes" class="btn btn-primary"  />
				</div>
			</div>
		</form>
	</div>
	<!--end::Content-->
</div>