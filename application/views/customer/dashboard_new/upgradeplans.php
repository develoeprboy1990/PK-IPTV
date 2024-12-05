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
							<?php /*foreach($plans as $key=>$val){ 
								?>	
							<div class="col-xl-6">
								<div class="d-flex h-100 align-items-center" 
									<?php if($info->plan_id == $val['id']){ ?>
										style="background:#80bfff;"
									<?php } ?>
 >									
									<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">										
										<div class="mb-7 text-center">											
											<h1 class="text-dark mb-5 fw-bolder"><?php echo $val['name']; ?></h1>	
											<div class="text-gray-400 fw-semibold mb-5">Product: <?php echo $val['ProductName']; ?></div>
											<div class="text-center">
												<span class="mb-2 text-primary">$</span>
												<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">0</span>
											</div>
											<div class="text-center">
												<span class="mb-2 text-primary">Validity : </span>
												<span class="mb-2 text-primary"><?php echo $val['length_months'].' '.$val['month_day']; ?></span>
											</div>
										</div>
										<div class="w-100 mb-10">
											<div class="d-flex align-items-center mb-5">
												<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Device Allowed: <?php echo $val['devices_allowed']; ?></span>
												<i class="ki-duotone ki-check-circle fs-1 text-success">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</div>
										</div>

										<?php if($info->plan_id == $val['id']){ ?>
										<a href="#" class="btn btn-sm fw-bold btn-warning" >Current Plan</a>
										<?php }else{?>
										<a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" >Contact Support</a>
										<?php } ?>
										
									</div>
								</div>
							</div>
							<?php }*/ ?>
							<?php foreach($plans as $key=>$val){ ?>	
							    <div class="col-xl-6">
							        <div class="d-flex h-100 align-items-center" 
							            <?php if($info->plan_id == $val['id']){ ?>
							                style="background:#80bfff;"
							            <?php } ?>>									
							            <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">										
							                <div class="mb-7 text-center">											
							                    <h1 class="text-dark mb-5 fw-bolder"><?php echo $val['name']; ?></h1>	
							                    <div class="text-gray-400 fw-semibold mb-5">Product: <?php echo $val['ProductName']; ?></div>
							                    <div class="text-center">
							                        <span class="mb-2 text-primary">$</span>
							                        <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
							                        	<?php echo (($val['monthly_price']*$val['length_months'])+$val['activation_price']); ?></span>
							                    </div>
							                    <div class="text-center">
							                        <span class="mb-2 text-primary">Validity : </span>
							                        <span class="mb-2 text-primary"><?php echo $val['length_months'].' '.$val['month_day']; ?></span>
							                    </div>
							                </div>
							                <div class="w-100 mb-10">
							                    <div class="d-flex align-items-center mb-5">
							                        <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">Device Allowed: <?php echo $val['devices_allowed']; ?></span>
							                        <i class="ki-duotone ki-check-circle fs-1 text-success">
							                            <span class="path1"></span>
							                            <span class="path2"></span>
							                        </i>
							                    </div>
							                </div>

							                <?php if($info->plan_id == $val['id']){ ?>
							                    <button class="btn btn-sm fw-bold btn-warning" disabled>Current Plan</button>
							                <?php } else { ?>
							                   <button class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#upgradeModal" onclick="setUpgradeInfo(<?php echo htmlspecialchars(json_encode($val), ENT_QUOTES, 'UTF-8'); ?>)">Upgrade Plan</button>
							                <?php } ?>
							            </div>
							        </div>
							    </div>
							<?php } ?>

						
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
				
<!-- Upgrade Modal -->
<div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upgradeModalLabel">Upgrade Plan Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You have selected to upgrade to the following plan:</p>
                <ul>
                    <li><strong>Plan Name:</strong> <span id="upgradePlanName"></span></li>
                    <li><strong>Product:</strong> <span id="upgradeProductName"></span></li>
                    <li><strong>Price:</strong> $<span id="upgradePlanPrice"></span></li>
                    <li><strong>Validity:</strong> <span id="upgradePlanValidity"></span></li>
                    <li><strong>Devices Allowed:</strong> <span id="upgradeDevicesAllowed"></span></li>
                </ul>
                <p>Are you sure you want to request an upgrade to this plan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmUpgrade()">Send Request</button>
            </div>
        </div>
    </div>
</div>

<script>
let selectedPlanId;

function setUpgradeInfo(planInfo) {
    selectedPlanId = planInfo.id;
    document.getElementById('upgradePlanName').textContent = planInfo.name;
    document.getElementById('upgradeProductName').textContent = planInfo.ProductName;
    document.getElementById('upgradePlanPrice').textContent = planInfo.monthly_price;
    document.getElementById('upgradePlanValidity').textContent = planInfo.length_months + ' ' + planInfo.month_day;
    document.getElementById('upgradeDevicesAllowed').textContent = planInfo.devices_allowed;
}

function confirmUpgrade() {
    // Send AJAX request to backend
    $.ajax({
        url: '<?php echo base_url("customer/requestUpgrade"); ?>',
        method: 'POST',
        data: { planId: selectedPlanId },
        success: function(response) {
            $('#upgradeModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Your upgrade request has been sent successfully!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        },
        error: function() {
             Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'There was an error sending your request. Please try again later.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>