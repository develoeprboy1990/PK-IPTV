<!--<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-thin-rounded/css/uicons-thin-rounded.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-thin-straight/css/uicons-thin-straight.css'>-->

<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-straight/css/uicons-bold-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css'>

<style>
.t-button{
	    color: #fff;
    font-size: 15px;
    font-weight: 800;
    /* text-decoration: underline; */
    background: #323248;
    padding: 10px;
    /* margin-top: -16px; */
    border-radius: 7px;
}
</style>
<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
		<!--begin::Toolbar container-->
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<!--begin::Title-->
				<!--<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Multipurpose</h1>-->
				<!--end::Title-->
				<!--begin::Breadcrumb-->
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
					<!--begin::Item-->
					<li class="breadcrumb-item text-muted">
						<a href="" class="text-muted text-hover-primary">Home</a>
					</li>
					<!--end::Item-->
					<!--begin::Item-->
					<li class="breadcrumb-item">
						<span class="bullet bg-gray-400 w-5px h-2px"></span>
					</li>
					<!--end::Item-->
					<!--begin::Item-->
					<li class="breadcrumb-item text-muted">Dashboard Panel</li>
					<!--end::Item-->
				</ul>
				<!--end::Breadcrumb-->
			</div>
			<!--end::Page title-->
			<!--begin::Actions-->
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<!--begin::Secondary button-->
				<!--<a href="#" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>-->
				<!--end::Secondary button-->
				<!--begin::Primary button-->
				<!--<a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>-->
				<!--end::Primary button-->
			</div>
			<!--end::Actions-->
		</div>
		<!--end::Toolbar container-->
	</div>
	<!--end::Toolbar-->
	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-fluid">

			<div class="row g-10 row-cols-2 row-cols-lg-4" style="margin-bottom:30px;">
				<!--<div class="col" style="padding: 5px;text-align: center;">
					<div><img src="/*?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?*/media/avatars/pending_tick_blue.png" alt="Trial" width="75" />	</div>
					<div style="font-size:10px; margin-top:-15px;">Pending Account</div>
				</div> -->
				<div class="col" style="padding: 5px;text-align: center;">
					<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/dark_orange_check.png" alt="Trial" width="75" />	
					<div style="font-size: 19px; font-weight: 700;">Trial Account</div>
				</div>
				<div class="col" style="padding: 5px;text-align: center;border-left: 1px solid #ddd;">
					<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/dark_green_check.png" alt="Trial" width="75" />	
					<div style="font-size: 19px; font-weight: 700;">Active Account</div>
				</div>
				<div class="col" style="padding: 5px;text-align: center;border-left: 1px solid #ddd;">
					<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/yellow_check.png" alt="Trial" width="75" />	
					<div style="font-size: 19px; font-weight: 700;">Expired Account</div>
				</div>
				<div class="col" style="padding: 5px;text-align: center;border-left: 1px solid #ddd;">
					<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/cross_red.png" alt="Trial" width="75" />	
					<div style="font-size: 19px; font-weight: 700;">Disabled Account</div>
				</div>
				</div>

			<div class="row g-10 row-cols-2 row-cols-lg-4">
				<!--begin::Col-->
				<div class="col" style="padding:5px">
					<!--begin::Overlay-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end  mb-5" style="background-color:#f58d05;border-radius: 0;">
					<div style="float: left;position: absolute;margin-top: 20px;    margin-left: 10px;">															
						<!--<i class="fi fi-tr-check-double" style="color: #fff;font-size: 35px;"></i>
						<i class="fi fi-bs-check-double" style="color: #fff;font-size: 55px;"></i>		-->	
						<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/white-tick.png" alt="Trial" width="75" />								
					</div>
			<!--begin::Header-->
			<div style="padding: 30px 10px 0 0;text-align: right;color: #fff;font-weight: bold;" >
						<!--begin::Title-->
						<div class="">
							<!--begin::Amount-->
							<div class="" style="font-size:14px !important;">Total <br />Trial</div>
							<!--end::Amount-->																
						</div>
						<!--end::Title-->
					</div>
			<!--end::Header-->
			<div style="margin: 59px 5px 20px;color: #fff;" >
						<!--begin::Title-->
						<div style="padding:5px;">
							<!--begin::Amount-->
						
								<a href="#" class="t-button">Know More</a>
						
							<!--end::Amount-->
							
							<!--begin::Subtitle-->
							<div style="float:right; font-size:25px;margin-top: -10px;">0</div>
							
							<!--end::Subtitle-->
						</div>
						<!--end::Title-->
					</div>
		
		</div>
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col" style="padding:5px">
					<!--begin::Overlay-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end mb-5" style="background-color:#14b50e;border-radius: 0;">
					<div style="float: left;position: absolute;margin-top: 20px;    margin-left: 10px;">															
						<!--<i class="fi fi-bs-check-double" style="color: #fff;font-size: 55px;"></i>	-->	
						<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/white-tick.png" alt="Trial" width="75" />									
					</div>
			<!--begin::Header-->
			<div style="padding: 30px 10px 0 0;text-align: right;color: #fff;font-weight: bold;" >
						<!--begin::Title-->
						<div class="">
							<!--begin::Amount-->
							<div class="" style="font-size:14px !important;">Total <br />Active</div>
							<!--end::Amount-->
						</div>
						<!--end::Title-->
					</div>
			<!--end::Header-->
			<div style="margin: 59px 5px 20px;color: #fff;" >
						<!--begin::Title-->
						<div style="padding:5px;">
							<!--begin::Amount-->
						
								<a href="#" class="t-button">Know More</a>
						
							<!--end::Amount-->
							
							<!--begin::Subtitle-->
							<div style="float:right; font-size:25px;margin-top: -10px;"><?php echo count($active_members);?></div>
							
							<!--end::Subtitle-->
						</div>
						<!--end::Title-->
					</div>
		
		</div>
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col" style="padding:5px">
					<!--begin::Overlay-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end  mb-5" style="background-color:#ffcc00;border-radius: 0;">
					<div style="float: left;position: absolute;margin-top: 20px;    margin-left: 10px;">															
						<!--<i class="fi fi-bs-check-double" style="color: #fff;font-size: 55px;"></i>	-->	
						<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/custom_round_white.png" alt="Trial" width="75" />									
					</div>
			<!--begin::Header-->
			<div style="padding: 30px 10px 0 0;text-align: right;color: #fff;font-weight: bold;" >
						<!--begin::Title-->
						
						<div class="">
							<!--begin::Amount-->
							<div class="" style="font-size:14px !important;">Total <br />Expired</div>
							<!--end::Amount-->
						</div>
						<!--end::Title-->
					</div>
			<!--end::Header-->
			<div style="margin: 59px 5px 20px;color: #fff;" >
						<!--begin::Title-->
						<div style="padding:5px;">
							<!--begin::Amount-->
						
								<a href="#" class="t-button">Know More</a>
						
							<!--end::Amount-->
							
							
							<!--begin::Subtitle-->
							<div style="float:right; font-size:25px;margin-top: -10px;"><?php echo count($expired_members);?></div>
							
							<!--end::Subtitle-->
						</div>
						<!--end::Title-->
					</div>
		
		</div>
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col" style="padding:5px">
					<!--begin::Overlay-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end  mb-5" style="background-color:#cc0000; border-radius: 0;">
					<div style="float: left;position: absolute;margin-top: 20px;    margin-left: 10px;">															
						<!--<i class="fi fi-bs-check-double" style="color: #fff;font-size: 55px;"></i>	-->	
						<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/white_cross.png" alt="Trial" width="75" />									
					</div>
			<!--begin::Header-->
			<div style="padding: 30px 10px 0 0;text-align: right;color: #fff;font-weight: bold;" >
						<!--begin::Title-->
						<div>
							<!--begin::Amount-->
							<div class="" style="font-size:14px !important;">Total <br />Disabled</div>
							<!--end::Amount-->
						</div>
						<!--end::Title-->
					</div>
			<!--end::Header-->
			<div style="margin: 59px 5px 20px;color: #fff;" >
						<!--begin::Title-->
						<div style="padding:5px;">
							<!--begin::Amount-->
						
								<a href="#" class="t-button">Know More</a>
						
							<!--end::Amount-->
							
							<!--begin::Subtitle-->
							<div style="float:right; font-size:25px;margin-top: -10px;"><?php echo count($disabled_members);?></div>
							
							<!--end::Subtitle-->
						</div>
						<!--end::Title-->
					</div>
		
		</div>
				</div>
				<!--end::Col-->
			</div>
			
			<!--begin::Row-->
			<?php if($msg_to_customer != ''){ ?>
			<div class="row gx-5 gx-xl-10">
				<!--begin::Col-->
				<div class="col-xxl-6 mb-5 mb-xl-10">
					<!--begin::Chart widget 8-->
					<div class="col-md-6 col-lg-6 col-xl-12 col-xxl-3 mb-md-5 mb-xl-10">
					<!--begin::Card widget 20-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10">
						<!--begin::Header-->
						<div class="card-header pt-5" style="padding: 2.25rem;">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<?php echo $msg_to_customer;?>
							</div>
							<!--end::Title-->
							<div>
							
							</div>
						</div>
						<!--end::Header-->
						
					
					</div>
					<!--end::Card widget 20-->
					<!--begin::Card widget 7-->
					
					<!--end::Card widget 7-->
				</div>
					<!--end::Chart widget 8-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				
				<!--end::Col-->
			</div>
			<?php } ?>
			<!--end::Row-->
			
			<!--begin::Row-->
			<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
				<!--begin::Col-->
				<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
					<!--begin::Card widget 20-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/patterns/vector-1.png')">
						<!--begin::Header-->
						<div class="card-header pt-5">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<!--begin::Amount-->
								<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Wallet</span>
								<!--end::Amount-->
								
								<!--begin::Subtitle-->
								<span class="text-white opacity-75 pt-1 fw-semibold fs-6">
									$<?php echo $user_info->walletbalance;?>
								</span>
								<span class="text-white opacity-75 pt-1 fw-semibold fs-6">
									
								</span>	
								<span class="text-white opacity-75 pt-1 fw-semibold fs-6">
									
								</span>	
								<!--end::Subtitle-->
							</div>
							<!--end::Title-->
						</div>
						<!--end::Header-->
						
					
					</div>
					<!--end::Card widget 20-->
					<!--begin::Card widget 7-->
					
					<!--end::Card widget 7-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<?php if(isset($product)){ ?>
				<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
					<!--begin::Card widget 20-->
					<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #80bfff;">
						<!--begin::Header-->
						<div class="card-header pt-5">
							<!--begin::Title-->
							<div class="card-title d-flex flex-column">
								<!--begin::Amount-->
								<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Active Plan</span>
								<!--end::Amount-->
								<!--begin::Subtitle-->
								<span class="text-white opacity-75 pt-1 fw-semibold fs-6">
								<?php if($product_details_settype == '1'){ ?>
									<?php echo $product->name.' ( '.$product->plan_name.' ) ';?>
								<?php } ?>
								
								<?php if($product_details_settype == '0'){ ?>
									<?php echo $product->name.' ( '.$plan_details->name.' ) '; ?>
								<?php } ?>
								</span>
								<span class="text-white opacity-75 pt-1 fw-semibold fs-6">
									<?php echo 'Expire ON : ' .date("F j, Y", strtotime( $product->subscription_expire));?>
								</span>	
								<span class="text-white opacity-75 pt-1 fw-semibold fs-6">
									<?php //echo 'Device Allowed : ' .$product->devices_allowed;?>
								</span>	
								<!--end::Subtitle-->
							</div>
							<!--end::Title-->
							<div>
							<?php
							if(($product->customer_can_change_plan == '1') && (count($group_product) > 0)){
							?>
							<a href="<?php BASE_URL ?>customer/changeplans/" class="btn btn-sm fw-bold btn-primary">Change Plan</a>
							<?php } ?>
							<!--<a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_change_plan">Change Plan</a>-->
							<!--<a href="#" class="btn btn-sm fw-bold btn-primary" onclick="cancel_plan();return false;">Cancel</a>-->
							</div>
						</div>
						<!--end::Header-->
						
					
					</div>
					<!--end::Card widget 20-->
					<!--begin::Card widget 7-->
					
					<!--end::Card widget 7-->
				</div>
				<?php } ?>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-xxl-6">
					<!--begin::Engage widget 10-->
					
					<!--end::Engage widget 10-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
			
			
			<!--begin::Row-->
			<div class="row gx-5 gx-xl-10">
				<!--begin::Col-->
				<div class="col-xxl-6 mb-5 mb-xl-10">
					<!--begin::Chart widget 8-->
					
					<!--end::Chart widget 8-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				
				<!--end::Col-->
			</div>
			<!--end::Row-->
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>
<!--end::Content wrapper-->
<!--begin::Footer-->
<div id="kt_app_footer" class="app-footer">
		<!--begin::Footer container-->
		<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
			<!--begin::Copyright-->
			<div class="text-dark order-2 order-md-1">
				<span class="text-muted fw-semibold me-1">2024&copy;</span>
				<a href="" target="_blank" class="text-gray-800 text-hover-primary"><a href="https:www.realtv.co">Real Tv</a> IPTV</a>
			</div>
			<!--end::Copyright-->
			<!--begin::Menu-->
			
			<!--end::Menu-->
		</div>
		<!--end::Footer container-->
	</div>
<!--end::Footer-->
</div>
<!--end:::Main-->
				
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
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
				<div style="text-align:center;"><h1>New Subscription Plans</h1></div>
				<div id="message_alert"  style="text-align:center;"></div>
				<!--begin:Form-->
				<div class="card-body pt-0">
									<!--begin::Table container-->
									<div class="table-responsive">
										<!--begin::Table-->
										<table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
											<thead class="fs-7 text-gray-400 text-uppercase">
												<tr>
													<th>Name</th>
													<th>Price</th>
													<th>Validity</th>
													<th>Device Allow</th>
													<th class="text-end">Action</th>
												</tr>
											</thead>
											<tbody class="fs-6">
												<?php
													foreach($subscription_renewal_keys as $key=>$val){
												?>
												
												<tr>
													<td>
														<!--begin::User-->
														<div class="d-flex align-items-center">																	
															<!--begin::Info-->
															<div class="d-flex flex-column justify-content-center">
																<a href="" class="fs-6 text-gray-800 text-hover-primary"><?php echo $val['name']?></a>
																<span><?php echo $val['product_name']?></span>
															</div>
															<!--end::Info-->
														</div>
														<!--end::User-->
													</td>
													
													<td><?php echo $val['monthly_price']?></td>
													<td><?php echo $val['valid_time'].' '.$val['month_day']; ?></td>
													<td><?php echo $val['devices_allowed'];?></td>
													<td class="text-end">
														<a href="#" class="btn btn-light btn-sm" onclick="change_plan(<?php echo $val['id']; ?>);return false;">Change Plan</a>
													</td>
												</tr>
												
												<?php 
													}
												?>
												
												
											</tbody>
										</table>
										<!--end::Table-->
									</div>
									<!--end::Table container-->
								</div>
				<!--end:Form-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - New Target-->