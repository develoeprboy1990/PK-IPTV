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
							//if($val['product_group'] == $product_select_group){
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
	-->														<a href="#" onclick="call_plan(<?php echo $val['id']; ?>, <?php echo $free_change; ?>);return false;" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_change_plan"<?php if($user_info->sebscription_trpe == 'splan'){ ?>
												<?php if($user_info->product_activation_key_id == $val['id']){ ?>
														style="display:none"
												<?php } ?>
								<?php }  ?>
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