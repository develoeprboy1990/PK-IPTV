<div class="card mb-5 mb-xl-8">
	<!--begin::Header-->
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Wallet Payment</span>
			<!--<span class="text-muted mt-1 fw-semibold fs-7">Over 500 Customers</span>-->
		</h3>
		<!--<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
			<a href="<?php echo BASE_URL;?>resellers/createcustomer" class="btn btn-sm btn-light btn-active-primary">
			<i class="ki-duotone ki-plus fs-2"></i>New Member</a>
		</div>-->
	</div>
	<!--end::Header-->
	<div id="kt_app_content" class="collapse show">
	<!--begin::Body-->
	<div class="card-body py-3">
		<!--begin::Table container-->
		<div class="table-responsive">
			<!--begin::Table-->
			<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="reseller_keycode">
				<!--begin::Table head-->
				<thead>
					<tr class="fw-bold text-muted">															
						<th class="min-w-20px">SL.NO</th>
						<th class="min-w-50px">Amount Recharge</th>
						<th class="min-w-50px">Created</th>
						<th class="min-w-50px">Payment Status</th>															
					</tr>
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody>
				<?php
				$c = 1;
				foreach($payment_rows as $key=>$val){
				?>
					<tr>
						<td><?php echo $c;?></td>
						<td>
							<div class="d-flex align-items-center">
								
								<div class="d-flex justify-content-start flex-column">
									<a href="#" class="text-dark fw-bold text-hover-primary fs-6"><?php echo $val['price'].' '.$val['currency']; ?></a>
									<!--<span class="text-muted fw-semibold text-muted d-block fs-7">HTML, JS, ReactJS</span>-->
								</div>
							</div>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo date("j F , Y, g:i a", strtotime($val['create_time']));?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7">
								<?php if($val['payment_status']=='paid'){?>
								<span class="badge badge-light-success fs-base">Paid</span>
								<?php }  else{?> 
									<span class="badge badge-light-danger fs-base">Not Paid</span>
								
								<?php } ?>

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
</div>