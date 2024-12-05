<div class="card mb-5 mb-xl-8">
	<!--begin::Header-->
	<div class="card-header border-0 pt-5 pb-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 ">Send a message to your customers</span>
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
		<form class="form" method="post" action="<?php echo site_url('resellers/editcustomermsg');?>">
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
					<label class="col-lg-2 col-form-label required fw-semibold fs-6">Enter your Message</label>
					<!--end::Label-->
					<!--begin::Col-->
					<div class="col-lg-8 fv-row">
						<!--<input type="text" name="number_codes" class="form-control form-control-lg form-control-solid" placeholder="Number of Codes" value="<?php //echo $number_codes;?>" />-->
						<textarea name="messageto_customer" id="messageto_customer" class="form-control form-control-lg form-control-solid" placeholder="Enter your message" rows="6"><?php echo $messageto_customer;?></textarea>
					</div>
					<!--end::Col-->
				</div>
				<!--end::Input group-->
				
				<div class="row mb-6">
					<label class="col-lg-5 col-form-label fw-semibold fs-6"></label>
					<div class="col-lg-4 d-flex align-items-center">
					<!--<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
					<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>-->
					<input type="submit" name="create_msg" id="create_msg" value="Write Message" class="btn btn-primary"  />
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
</div>							
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create( document.querySelector( '#messageto_customer' ) )
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );
</script>