<div class="card mb-5 mb-xl-8" id="kt_timeline_widget_2_card">
	<!--begin::Header-->
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
    <div class="card-header position-relative py-0 border-bottom-2">
	   <!--begin::Nav-->
    	<ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3" role="tablist">
    		<!--begin::Item-->
    		<li class="nav-item p-0 ms-0 me-8" role="presentation">
    			<!--begin::Link-->
    			<a class="nav-link btn btn-color-muted px-0 active" data-bs-toggle="pill" href="#kt_timeline_widget_2_tab_1" aria-selected="true" role="tab">
    				<!--begin::Subtitle-->
    				<span class="nav-text fw-semibold fs-4 mb-3">Edit Device</span>
    				<!--end::Subtitle-->
    				<!--begin::Bullet-->
    				<span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
    				<!--end::Bullet-->
    			</a>
    			<!--end::Link-->
    		</li>
    		<!--end::Item-->
    		 
    	</ul>
		<!--end::Nav-->
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body">
		<!--begin::Tab Content-->
		<div class="tab-content">
			<!--begin::Tap pane-->
			<div class="tab-pane fade active show" id="kt_timeline_widget_2_tab_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Edit Device</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form action="<?= site_url('resellers/updateDevice/'.$customer_id) ?>" method="post">
                        <input type="hidden" name="uuid" value="<?= $device['uuid'] ?>">
                        
                        <?php foreach($device as $key => $value): ?>
                            <div class="form-group">
                                <label for="<?=$key?>"><?=ucfirst($key)?></label>
                                <input type="text" class="form-control" id="<?=$key?>" name="<?=$key?>" value="<?=$value?>" <?=$key=='uuid'?'readonly':''?>>
                            </div>
                        <?php endforeach; ?>

                        <button type="submit" class="btn btn-primary">Update Device</button>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>

			</div>
			<!--end::Tap pane-->
		</div>
		<!--end::Tab Content-->
	</div>
	<!--end::Body-->
</div>