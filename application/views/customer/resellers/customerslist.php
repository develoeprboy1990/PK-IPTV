<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-straight/css/uicons-bold-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css'>
<style>
.table-head{
text-transform:uppercase !important;
}
.btn-head{
 background:#299c05 !important;
  color:#fff;
  font-size:17px;
  font-weight:800;
}
</style>
<div class="card mb-5 mb-xl-8">
	<!--begin::Header-->
	<div class="card-header border-0 pt-5 pb-5">
		<h3 class="card-title align-items-start flex-column">My Customers</h3>
		<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a Customer">
			<a href="<?php echo BASE_URL;?>resellers/createcustomer" class="btn  btn-md btn-head">Add New Customer</a>
		</div>
	</div>
	<!--end::Header-->
	
	<!--begin::Body-->
	<div class="card-body py-3">

		<!--begin::Input group-->
		<div class="row mb-6">
				
				<div class="col-lg-8">
						<!--begin::Row-->
						<div class="row">
							<?php if($this->session->flashdata('success')){ ?>
								<div class="alert alert-success" role="alert" style="text-align:left;">
									<?php echo $this->session->flashdata('success'); ?>									
								</div>
							<?php } ?>
						</div>
				</div>
			</div>
		<!--end::Input group-->

		<!--begin::Table container-->
		<div class="table-responsive">
			<!--begin::Table-->
			<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="customer_list">
				<!--begin::Table head-->
				<thead>
					<tr class="fw-bold text-muted">															
						<th class="min-w-20px">SL.NO</th>
						<th class="min-w-150px">Name</th>
						<th class="min-w-100px">Mobile</th>
						<th class="min-w-100px">Email</th>
						<?php if($resellerInfodash['see_customer_password'] == '1'){ ?>
						<th class="min-w-100px">Password</th>
						<?php } ?>
						<th class="min-w-100px">Resend Email</th>
						<th class="min-w-150px">Plan</th>	
						<th class="min-w-100px">Price  </th>	
						<th class="min-w-10px">Plan Status</th>	
						<th class="min-w-100px">Expire Date</th>															
						<th class="min-w-100px text-center">Actions</th>
					</tr>
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody>
				<?php													
				$c = 1;
				foreach($customers as $key=>$val){
				?>
					<tr>
						<td><?php echo $c;?></td>
						<td>
							<div class="d-flex align-items-center">																	
								<div class="d-flex justify-content-start flex-column">
									<a href="#" class="text-dark fw-bold text-hover-primary fs-6"><?php echo $val['title'].' '.$val['first_name'].' '.$val['last_name'];?></a>
									<!--<span class="text-muted fw-semibold text-muted d-block fs-7">HTML, JS, ReactJS</span>-->
								</div>
							</div>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['mobile'];?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['email'];?></span>
						</td>
						<?php if($resellerInfodash['see_customer_password'] == '1'){ ?>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo base64_decode($val['password']);?></span>
						</td>
						<?php } ?>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7">
								<a href="<?php echo BASE_URL;?>resellers/resendRegistration/<?php echo $val['id'];?>">Resend Email</a>
							</span>
						</td>
						<td><?php echo $val['proname'];?>
							<span class="text-muted fw-semibold text-muted d-block fs-7">Device Allowed: <?php echo $val['devices_allowed'];?></span>
						</td>
						<td><?php echo $val['price'];?>  <?php echo $val['currency'];?></td>
						<td>
						<?php
							if($val['status'] == '0'){																
								//echo '<i class="fi fi-ss-cross-circle" style="color: #cc0000;font-size: 30px;"></i>';
								echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
							}elseif(($val['sebscription_trpe'] == '') && ($val['status'] == '1')){																	
								//echo '<i class="fi fi-bs-list-check" style="color: #00cccc;font-size: 30px;"></i>';
								echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
							}elseif(($val['subscription_expire'] != '0000-00-00 00:00:00') && ($val['status'] == '1')){
								$today = date("Y-m-d H:i:s");
								$diff_time=((strtotime($val['subscription_expire']) - strtotime($today)));
								if($diff_time>0){																		
									//echo '<i class="fi fi-bs-check-double" style="color: #14b50e;font-size: 30px;"></i>';
									echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
								}else{
									echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
									//echo '<i class="fi fi-bs-badge-check" style="color: #ffcc00;font-size: 30px;"></i>';
								}
							}
						?>
						</td>
						<!--<td>
							<div class="d-flex flex-column w-30 me-2">
								<div class="d-flex flex-stack mb-2">
									<span class="text-muted me-2 fs-7 fw-bold"><?php /* echo ($val['status'] == '1') ? '<span style="color:#00cc00">ON</span>' : '<span style="color:RED">OFF</span>';*/?></span>
									
									<div class="col-lg-6 d-flex align-items-center">
										<div class="form-check form-check-solid form-switch form-check-custom fv-row">
											<input class="form-check-input w-45px h-30px" type="checkbox" id="status" name="status" value="1" <?php echo ($val['status'] == '1') ? 'checked' : '' ?> />
											<label class="form-check-label" for="allowmarketing"></label>
										</div>
									</div>
					
								</div>
								
							</div>
						</td>-->
						<td><?php echo $val['subscription_expire'];?></td>
						<td>
							<div class="d-flex justify-content-end flex-shrink-0">	

								<a href="<?php echo BASE_URL;?>resellers/rechargeonecustomer/<?php echo $val['id'];?>" class="btn btn-light btn-sm me-1 p-2" style="color:red">Recharge</a>

								<!-- <a href="<?php //echo BASE_URL;?>resellers/editcustomer/<?php echo $val['id'];?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 m-1">
									<i class="ki-duotone ki-pencil fs-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</a> -->
								<a href="<?php echo BASE_URL;?>resellers/editcustomer/<?php echo $val['id'];?>" class="btn btn-light btn-sm me-1 p-2" style="color:#009ef7;">Edit</a>

								<a href="<?php echo BASE_URL;?>resellers/upgradeonecustomer/<?php echo $val['id'];?>" class="btn btn-light btn-sm p-2" style="color:#00cc00;">Upgrade</a>

								<!--	
								<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteRowoption('<?php echo $val['title'].' '.$val['first_name'].' '.$val['last_name'];?>','<?php echo $val['id'];?>'); return false;">
									<i class="ki-duotone ki-trash fs-2">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
										<span class="path5"></span>
									</i>
								</a>-->
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
