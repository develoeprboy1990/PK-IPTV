<div class="card mb-5 mb-xl-10">
	<!--begin::Card header-->
	<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
		<!--begin::Card title-->
		<div class="card-title m-0">
			<h3 class="fw-bold m-0">Upgrade Customer (<?php echo $customer_active_plan['CustomerEmail']; ?>)</h3>
		</div>
		<div class="card-title m-0 float-end">
			<!-- <h3 class="fw-bold m-0">
				Total Price: <?php echo $customer_active_plan['ActiveTotalPrice']; ?>
				<br>
				Total Days: <?php echo $customer_active_plan['ActiveTotalDays']; ?>
				<br>
				Used Days: <?php echo $customer_active_plan['ActiveUsedDays']; ?>
				<br>
				Reamining Days: <?php echo $customer_active_plan['ActiveRemainingDays']; ?>
				<br>			
				Refunded Balance: <?php echo $customer_active_plan['RemainingBalance']; ?>
			</h3> -->
		</div>
		<!--end::Card title-->
	</div>
	<!-- <div class="m-2" style="text-align:right;">Refunded Balance = (Total Price/Total Days)*Reamining Days</div> -->
	<!--begin::Card header-->

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
		<!--begin::Content-->
		<!-- <div class="row">
			<div class="col-lg-3" style="margin-top: 10px; ">
				<label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
					<input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
					<span class="d-flex">
						<i class="ki-duotone ki-verify fs-1 text-primary">
						<span class="path1"></span>
						<span class="path2"></span>
						</i>
						<span class="ms-4">
							<span class="fs-3 fw-bold text-gray-900 mb-2 d-block">  Active Product</span>
							<span class="fw-semibold fs-4 text-muted"><?php echo $customer_active_plan['ActiveProductName']?></span> 
						</span>
					</span>
				</label>
			</div>
        	<div class="col-lg-3" style="margin-top: 10px; ">
	            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
		            <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
		            <span class="d-flex">
			            <i class="ki-duotone ki-verify fs-1 text-primary">
			            	<span class="path1"></span>
			            	<span class="path2"></span>
			            </i>
			            <span class="ms-4">
			            	<span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Active Plan</span>
			            	<span class="fw-semibold fs-4 text-muted"><?php echo $customer_active_plan['ActivePlanName']?></span> 
			            </span>
		            </span>
	            </label> 
        	</div>
            <div class="col-lg-3" style="margin-top: 10px; ">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
	                <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
	                <span class="d-flex">
	                	<i class="fa fa-calendar  fa-5x" aria-hidden="true"> </i>
	                	<span class="ms-4">
	                		<span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Plan Activate</span>
	                		<span class="fw-semibold fs-4 text-muted"> <?php echo date("j F, Y, g:i a", strtotime($customer_active_plan['PlanActivate']));?></span>
	                	</span>
	                </span>
                </label> 
            </div>
            <div class="col-lg-3" style="margin-top: 10px; ">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
	                <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
	                <span class="d-flex">
		                <i class="fa fa-calendar  fa-5x" aria-hidden="true"></i>
		                <span class="ms-4">
		                	<span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Plan Expire</span>
		                	<span class="fw-semibold fs-4 text-muted"> <?php echo date("j F, Y, g:i a", strtotime($customer_active_plan['PlanExpire']));?></span>
		                </span>
                	</span>
                </label> 
            </div>
        </div> -->
		<!--begin::Table container-->
		<div class="table-responsive">
			<!--begin::Table-->
			<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="customer_list">
				<!--begin::Table head-->
				<thead>
					<tr class="fw-bold text-muted">															
						<th class="min-w-20px">SL.NO</th>
						<th class="min-w-100px">ID</th>
						<th class="min-w-150px">Product Name</th>
						<th class="min-w-150px">Plan Name</th>
						<th class="min-w-150px">Device Allowed</th>
						<th class="min-w-100px">Plan Time</th>
						<th class="min-w-100px">Expriy Date</th>
						<th class="min-w-100px">Actions</th>
					</tr>
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody>
				<?php													
				$c = 1;
				//$customers_id = $customer_active_plan['CustomerID'];
				foreach($reseller_plans as $key=>$val){
				?>
				<?php if($val['Status']=='1'){ ?>
					<tr style="background-color:#f1faff;">
						<td><?php echo $c;?></td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['ResellerPlanID'];?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['ProductName'];?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['PlanName'];?></span>
						</td>
						<td><span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['DeviceAllowed'];?></span></td>
						<td><span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['PlanTime'];?></span></td>

						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7">
								<?php echo date("j F, Y, g:i a", strtotime($customer_active_plan['PlanExpire']));?>
							</span>
						</td>
						
						<td>
							<a class="btn btn-warning btn-sm card-toolbar" title="Actvation Key" >Active Plan</a>
							<!-- <br><b>Reaming Days: <?php echo $customer_active_plan['ActiveRemainingDays']; ?></b> -->
						</td>
					</tr>
					<?php }else{ ?>	
					<tr >
						<td><?php echo $c;?></td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['ResellerPlanID'];?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['ProductName'];?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['PlanName'];?></span>
							<!-- <b><?php echo 'DealerPrice: '.$val['DealerPrice']; ?></b> -->
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['DeviceAllowed'];?></span>
						</td>
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['PlanTime'];?></span>
							<!-- <b><?php echo 'TotalDays: '.$val['TotalDays']; ?></b> -->
						</td>

						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo date("j F, Y, g:i a", strtotime($val['ExpiryDate']));?></span>
								<b><?php //echo 'Future Balance : '.$val['FutureBalance']; ?></b>	<br>
								<!-- Future Balance = (DealerPrice / TotalDays) * Reaming Days -->
						</td>
						
						<td>
							<span class="text-muted fw-semibold text-muted d-block fs-7">
								Pay: <?php echo $val['DealerPrice'];?>
							</span>
							<button class="btn btn-primary btn-sm upgradeBtn" 
							data-reseller-plan-id="<?php echo $val['ResellerPlanID'];?>"
							data-customer-id="<?php echo $customers_id;?>"
							data-plan-name="<?php echo $val['PlanName'];?>"
							data-device-allowed="<?php echo $val['DeviceAllowed'];?>"
							data-total-balance="<?php echo $val['DealerPrice'];?>">
							Upgrade Plan
							</button>
							<!-- <form class="form" method="post" action="<?php //echo site_url('resellers/upgradeonecustomer').'/'.$customers_id;?>">
								<input type="hidden" name="reseller_plan_id" value="<?php //echo $val['ResellerPlanID'];?>">
								<input type="hidden" name="customet_id" value="<?php //echo $customers_id;?>">
								<input type="submit" name="upgrade_customer" id="upgrade_customer" value="Upgrade Customer" class="btn btn-primary"  />
							</form> -->						
						</td>
					</tr>
				<?php } ?>
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
		<!--end::Content-->
		<div id="UpgradePopup" class="popup" style="display:none;">
			<div class="popup-content">
				<h2 style="color:green; margin-top:0;">Upgrade Plan</h2>
				<p>Plan Name: <span id="popupPlanName"></span></p>
				<p>Device Allowed: <span id="popupDeviceAllowed"></span></p>
				<p>Total Balance: <span id="popupTotalBalance"></span></p>
				<p>Activation Key:</p>
				<input type="hidden" id="popupResellerPlanId" value="" />
				<input type="hidden" id="popupCustomerId" value="" />

				<input type="text" id="activationKey" class="form-control form-control-lg form-control-solid" placeholder="Enter Activation Key" />
				<div style="margin-top: 20px; display: flex; justify-content: space-between;">
					<button class="btn btn-primary btn-sm" onclick="submitUpgrade()">Submit</button>
					<button id="closeUpgradePopup" class="btn btn-secondary btn-sm">Close</button>
				</div>
			</div>
		</div>
		
		<!-- New upgrade status popup -->
		<div id="upgradeStatusPopup" class="popup" style="display:none;">
		    <div class="popup-content">
		        <h2 style="color:green; margin-top:0;">Upgrade Status</h2>
		        <div id="upgradeStatusMessage"></div>
		        <div style="margin-top: 20px; text-align: center;">
		            <button id="closeUpgradeStatusPopup" class="btn btn-primary btn-sm">Close</button>
		        </div>
		    </div>
		</div>

	</div>
</div>
<style>
.popup {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    display: none;
}
.popup-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888888;
    width: 30%;
    font-weight: bolder;
	border: 10px solid #ccc;
	border-radius: 10px;
	padding-bottom: 50px;
}
.popup-content button {
    display: block;
    margin: 0 auto;
}
.show {
    display: block !important;
}
h1 {
    color: green;
}
.text-success {
    color: green;
}
.text-danger {
    color: red;
}
#upgradeMessage {
    font-weight: bold;
}
#upgradeStatusMessage ul {
    text-align: left;
    padding-left: 20px;
}

#upgradeStatusMessage li {
    margin-bottom: 10px;
}
</style>