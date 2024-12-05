<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: 150%;
  left: 50%;
  margin-left: -60px;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
<div class="card mb-5 mb-xl-8">
	<!--begin::Header-->
	<div class="card-header border-0 pt-5 pb-5">
	<h3 class="card-title align-items-start flex-column">
		<span class="card-label fw-bold fs-3">My Plans</span>
		<!--<span class="text-muted mt-1 fw-semibold fs-7">Over 500 Customers</span>-->
	</h3>
	<!--<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
		<a href="<?php echo BASE_URL;?>resellers/createcustomer" class="btn btn-sm btn-light btn-active-primary">
		<i class="ki-duotone ki-plus fs-2"></i>New Member</a>
	</div>-->
	</div>
	<!--end::Header-->

	<!--begin::Body-->
	<div class="card-body py-5">
		<!--begin::Table container-->
		<div class="table-responsive">
			<!--begin::Table-->
			<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="customer_plan">
				<!--begin::Table head-->
				<thead>
					<tr class="fw-bold fs-6 text-gray-800" style="font-weight: bold;">															
						<th class="min-w-20px fw-bold table-head">S.NO</th>
						<th class="min-w-20px fw-bold table-head">Id</th>
						<th class="min-w-100px fw-bold table-head">Product Name</th>
						<th class="min-w-100px fw-bold table-head">Plan Name </th>
						<th class="min-w-100px fw-bold table-head">Plan Time </th>
						<!--<th class="min-w-100px fw-bold">Retail  </th> -->
						<th class="min-w-100px fw-bold table-head"> Retail Price</th>
						<th class="min-w-100px fw-bold table-head">Commission</th>
						<th class="min-w-100px fw-bold table-head">Dealer price</th>															
						<th class="min-w-100px">Device Allowed</th>
						<!--<th class="min-w-100px table-head">Actions</th> -->
					</tr>
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody>
				<?php
				$c = 1;
				//$discount_arr = array('','Fixed Price','Percentage');
				
				foreach($selected_plans_list as $key=>$val){ 
				?>
					<tr>
						<td><?php echo $c;?></td>
						<td><?php echo $val['id'];?></td>
						<td>
							<div type="button"   data-toggle="tooltip" data-placement="top" title="Tooltip on top">
							<?php echo $products_list['products_'.$reseller_plansArray['id_'.$val['product_plans']]['product_id']]; ?>
							</div>		
						</td>
						<td>
							<div class="d-flex align-items-center">
								<div class="d-flex justify-content-start flex-column">
									<a href="#" onclick="return false;" class="text-dark fw-bold text-hover-primary fs-6"><?php echo $reseller_plansArray['id_'.$val['product_plans']]['name']; ?></a>
									<!--<span class="text-muted fw-semibold text-muted d-block fs-7">HTML, JS, ReactJS</span>-->
								</div>
							</div>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $reseller_plansArray['id_'.$val['product_plans']]['length_months'].' '.$reseller_plansArray['id_'.$val['product_plans']]['month_day']; ?></span>
						</td>

					<!--	<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $reseller_plansArray['id_'.$val['product_plans']]['monthly_price'].' '.$val['currency_type']; ?></span>
						</td>  -->
						<td>
						<span class="text-muted fw-semibold text-muted d-block fs-7">
						<?php echo $val['dealer_price'].' '.$val['currency_type']; ?>
						</span>
						</td>
						<td>
						<span class="text-muted fw-semibold text-muted d-block fs-7">
						<?php 
						if($val['discount_type']==1){
							echo $val['discount_value'];
						} else{
							$amt=($val['dealer_price'] * $val['discount_value'])/100;

							echo   $amt ;
						} echo '&nbsp;'. $val['currency_type']; ?></td>
						<td>
						<span class="text-muted fw-semibold text-muted d-block fs-7">
						<?php 
						if($val['discount_type']==1){
							echo $val['dealer_price'] - $val['discount_value'];
						} else{
							$amt=($val['dealer_price'] * $val['discount_value'])/100;

							echo $val['dealer_price'] - $amt ; 
						}    echo '&nbsp;'. $val['currency_type']; ?>
							  
						</td>
			      <td>
							<span class="text-muted fw-semibold text-muted d-block fs-7">
							<?php echo $reseller_plansArray['id_'.$val['product_plans']]['devices_allowed']; ?>
							</span>
						</td>	
						   <!--<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7">
							<button>Plan Detail</button>
							</span>
						</td> -->
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
	<!--end::Body-->
</div> 
<script>
	$(function () {
	$('[data-toggle="tooltip"]').tooltip()
	})
</script>