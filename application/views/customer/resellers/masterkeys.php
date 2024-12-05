<style>
.custom-list {
    list-style-type: none; /* Removes bullet points */
    padding: 0;           /* Removes default padding */
    margin: 0;            /* Removes default margin */
}

.custom-list li {
    float: left;          /* Floats the list items to the left */
    margin-right: 10px;   /* Adds some space between the items */
}

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
</style>
<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />	
<div class="card mb-5 mb-xl-8">
	<!--begin::Header-->
	<div class="card-header border-0 pt-5 pb-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Master Keys</span>
			<!--<span class="text-muted mt-1 fw-semibold fs-7">Over 500 Customers</span>-->
		</h3>
		<!--<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
			<a href="<?php echo BASE_URL;?>resellers/createcustomer" class="btn btn-sm btn-light btn-active-primary">
			<i class="ki-duotone ki-plus fs-2"></i>New Member</a>
		</div>-->
		<p>Master Keys can be used in both scenarios: either to activate an account or to recharge an account. Please contact the admin if the keys are not working.</p>
	</div>

	<!--end::Header-->
	<div id="kt_app_content" class="collapse show" >
		<!--begin::Form-->
		<form class="form" method="post" action="<?php echo site_url('resellers/masterkeys');?>">
			<!--begin::Card body-->
			<div class="card-body  pt-5 pb-5"  >
				<!--begin::Input group-->
				
				<!--end::Input group-->
				<div class="row mb-6" >
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
				<div class="row mb-6  ">
					<!--begin::Label-->
					<div class="col-lg-5 fv-row">
					<label class="  col-form-label required fw-semibold fs-6">Select your plans from here<a title="Plan name assigned by the admin" style="cursor:pointer;"> (?)</a></label>
					<!--end::Label-->
					<!--begin::Col-->
					
						<select id="plan_id" name="plan_id" data-control="select2" data-placeholder="Select a Plans.." class="form-select form-select-solid form-select-lg">
						<option value="">Select your plans from here...</option>
						<?php
				$c = 1;
				//$discount_arr = array('','Fixed Price','Percentage');
				foreach($selected_plans_list as $key=>$val){ 
				?>
						 <option value="<?php echo $val['id'];?>" <?php if($plan_id == $val['id']){ echo 'selected="selected"';} ?>>
						 <?php echo $reseller_plansArray['id_'.$val['product_plans']]['name'].' ( '; ?>
						 <?php //echo ' ( '.$products_list['products_'.$reseller_plansArray['id_'.$val['product_plans']]['product_id']].' | '; ?>
						 <?php echo ' Device Allowed : '.$reseller_plansArray['id_'.$val['product_plans']]['devices_allowed'].' | '; ?>
						 <?php //echo ' Retail Price : '.$reseller_plansArray['id_'.$val['product_plans']]['monthly_price'].' '.$val['currency_type']. ' | '; ?>
						 <?php echo ' Dealer Price : '.$val['dealer_price'].' '.$val['currency_type']; ?>
						 <?php echo ' ) '; ?>
						 </option>
				<?php } ?>
						
					  </select>
						
					</div>
					<!--end::Col-->
				 
				
				<!--end::Input group-->
				
				<!--begin::Input group-->
				<div class="col-lg-5 fv-row">
					<!--begin::Label-->
					<label class="  col-form-label required fw-semibold fs-6">Number of Master Keys you want to generate for selected plan <a title="How man codes user can generate for this plan" style="cursor:pointer;">(?)</a></label>
					<!--end::Label-->
					<!--begin::Col-->
					 
						<input type="text" name="number_codes" class="form-control form-control-lg form-control-solid" placeholder="Enter number of codes you want to generate" value="<?php echo @$number_codes;?>" />
					</div>
					<!--end::Col-->
				 
				<!--end::Input group-->
				
				
				<div class="col-lg-2 fv-row">
					 <div></div>
					<div style="margin-top: 45px;"><input type="submit" name="create_code"  id="create_code" value="Create Code" class="btn btn-primary" onclick="return confirm('Are you sure you want to generate this code ?');"  />
					 
					</div> <!--<button type="reset"   class="btn btn-light btn-active-light-primary me-2">Discard</button> -->
				</div>
			</div>
			</div>
			<!--end::Card body-->
		</form>
		<!--end::Form-->
	

		<div id="myPopup" class="popup" style="display:none;">
			<div class="popup-content">
				<h2 style="color:green; margin-top:0;" id="enable_disable_title"></h2>
				<p>Write reason:</p>
				<span><input type="hidden" id="code_id" value="" /></span>
				<span><input type="hidden" id="change_type" value="" /></span>
				<div><textarea id="user_message" style="width:100%;min-height: 100px;"></textarea></div>
				<div style="width:40%; min-width:90px; float:left;">
				<button class="btn btn-block btn-primary btn-flat" onclick="makedisablecode()">Submit</button>
				</div>
				<div style="width:30%; min-width:50px; float:right;">
				<button id="closePopup" class="btn btn-block btn-primary btn-flat">Close</button>
				</div>
			</div>
		</div>

		<div id="messagHistory" class="popup" >
			<div class="popup-content" style="width:70%;margin-left: 25%;">
				<span id="closePopupMessageHistory" style="float: right;color: red;font-size: 25px;font-weight: bold;cursor: pointer;margin-top: -25px;
			margin-right: -15px;">X</span>	
				<h2 style="color:green; margin-top:0;">Message History</h2>
				<div id="msg_list"></div>																		
			</div>
		</div>

	 	<!-- NEW CODE--> 
		<div class="card-header pt-5 pb-5 bg-white">
			<!--begin::Title-->
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold text-dark">List of Master Keys</span>
				<span class="text-gray-400 mt-1 fw-semibold fs-6"> </span>
			</h3>
			<!--end::Title-->
			<!--begin::Actions-->
			<div class="card-toolbar">
				<!--begin::Filters-->
				<div class="d-flex flex-stack flex-wrap gap-4">
					<!--begin::Destination-->
					 
					<div class="d-flex align-items-center fw-bold">
						<!--begin::Label-->
						 
						 
						<select class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-5="filter_status">
							<option></option>
							<option value="Show All" selected="selected">Show All Key</option>
							<option value="allocated">Used </option>
							<option value="available">Unused </option> Recently
							<option value="Recently">Recently Generated </option>
						</select>
						<!--end::Select-->
					</div>
					<div class="d-flex align-items-center fw-bold">
						<!--begin::Label-->
						 
						<!--end::Label-->
						<!--begin::Select-->
						<select class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-5="disable_status">
							<option></option>
							<option value="Show All" selected="selected">All Data</option>
							<option value="ON">ON</option>
							<option value="OFF">OFF </option> 
						</select>
						<!--end::Select-->
					</div>
					 
				</div>
				<!--begin::Filters-->
			</div>
			<!--end::Actions-->
		</div>
		<!--begin::Body-->
		<div class="card-body py-3 table-responsive">
		<!--begin::Table container-->  
		<table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_5_table" >
			<!--begin::Table head-->
			<thead>
				<!--begin::Table row--> 
				<tr class="fw-bold text-muted">															
					<th class="min-w-20px">S.No</th>
					<th class="min-w-20px">Id</th>
					<th class="min-w-50px">Plan <br> Name</th>
					<th class="min-w-150px">Key <br> Code</th>
					<th class="min-w-50px">Retail <br> Price</th>
					<th class="min-w-50px">Dealer <br> Price </th>
					<th class="min-w-50px">Subscription</th> 
					<th class="min-w-100px">Used</th> 
					<th class="min-w-40px">Creation</th> 
					<th class="min-w-40px">Message</th>
					<th class="min-w-40px">Status</th>
					<th class="min-w-70px  ">Actions</th>
				</tr>
			</thead>
			<!--end::Table head-->
			<!--begin::Table body-->
			<tbody class="fw-bold text-gray-600">
			 
				<?php
				$c = 1;
				foreach($resellerKeycode as $key=>$val){

				  
				$today = date('yymmdd',);
				$dbdate= date("yymmdd", strtotime($val['date_created'])) ;


				?>
				<tr  style="background-color:<?=($today  ==  $dbdate)?'#ecf4e9;':''?> ">
					<td><?php echo $c;?></td>
					<td><?php echo $val['id'];?></td>
					<td>
						<div class="d-flex align-items-center">
							
							<div class="d-flex justify-content-start flex-column">
								<a href="#" class="text-dark fw-bold text-hover-primary fs-6"><?php echo $val['group_name'];?></a>
								<span class="text-muted fw-semibold text-muted d-block fs-7">Device Allowed: <?php echo $val['devices_allowed'];?></span>
							</div>
						</div>
					</td>
					<td >
					<span class="text-muted fw-semibold text-muted d-block fs-7 card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"  title="Copy Code " > 
						<span onclick="copyInvoiceNumber('<?php echo $val['keycode'];?>' )" style=" border: 1px solid gray; font-size:15px; border-radius:8px; padding:3px"> &nbsp;&nbsp;  <?php echo $val['keycode'];?><i class="fa fa-copy" ></i></span>
					</span>
					</td>
					<td>
						<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo ($val['monthly_price']*$val['length_months']+$val['activation_price']).' '.$resellerInfo['currency_type'];?></span>
					</td>
					<td>
						<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo round($val['dealer_price'], 2);?> <?=$resellerInfo['currency_type'];?></span>
					</td>
					<td>
						<span class="text-muted fw-semibold text-muted d-block fs-7"><?php echo $val['length_months'].$val['month_day'];?></span>
					</td>															
					<td class="text-end">
						<div class="d-flex flex-column w-100 me-2">
							<div class="d-flex flex-stack mb-2">
								<span class="text-muted me-2 fs-7 fw-bold">
								<?php 
								if($val['used'] == '0')
								{?>
			                   <span class="badge py-3 px-4 fs-7 badge-light-primary" class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Available">Unused <br>(<?=($today  ==  $dbdate)?'Recently':'Available'?>)</span>
							   <?php	}else{?>
								<span style=" cursor:pointer;   "  class="badge py-3 px-4 fs-7 badge-light-danger card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"    title="<?=$val['title'].' '.$val['first_name'].' '.@$val['la_name'] ;?>" >Used <br>(<?=($today  ==  $dbdate)?'Recently':'Allocated'?> )</span> 
								<?php }

								?>
							</div>							
						</div> 
					</td>
					<td class="text-end">
						<div class="d-flex flex-column w-100 me-2">
							<div class="d-flex flex-stack mb-2">
								<span class="text-muted me-2 fs-7 fw-bold">  <?php echo date("j F, Y", strtotime($val['date_created']));?> <br> <?php echo date("g:i a", strtotime($val['date_created']));?></span>
							</div>
							
						</div>
					</td>
					<td class="text-end">
						<div class="d-flex flex-column w-100 me-2">
							<div class="d-flex flex-stack mb-2">
								<span class="text-muted me-2 fs-7 fw-bold"><a href="#" style="color:#009ef7;" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"  title="Show Message" onclick="message_history(<?php echo $val['id']; ?>);return false;">Show</a></span>
							</div>
							
						</div>
					</td>
					<td class="text-end">
						<div class="d-flex flex-column w-100 me-2">
							<div class="d-flex flex-stack mb-2">
						 <span><?php echo ($val['disabled'] == '1') ? 'OFF' : 'ON';?></span>
							</div>
						</div>
					</td>
					<td class="text-end">
						<div class="d-flex justify-content-end flex-shrink-0">		
							<ul  class="custom-list">						
								<li>
										<?php
											if(($val['disabled'] == '0') && ($val['used'] == '0')){
										?>
										<a href="#" style="color:#00cc00" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"  onclick="disable_key(<?php echo $val['id']; ?>);return false;" title="make Disable"><i class="fa-solid fa-toggle-on" style="color: #00cc00;"></i></a>
										<?php }elseif(($val['disabled'] == '1') && ($val['used'] == '0')){ ?>
										<a href="#" style="color:red;" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"  onclick="enaable_key(<?php echo $val['id']; ?>);return false;" title="Make Enable"><i class="fa-solid fa-toggle-on" style="color: red;"></i>  </a>
										<?php } else{ ?>
										<!--<a href="<?php echo site_url('resellers/editcustomer/').$val['user_id']; ?>" class="btn btn-light btn-sm">Already Used</a> -->
										<?php } ?>
	</li>
								<li><a title="View Detail" href="<?php echo site_url('resellers/viewcustomer/').$val['id']; ?>" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" ><i class="fa fa-eye"></i></a>
	</li>
								<?php if($val['used'] == '0' && $val['dealer_price']!=0) {?>
								<li><a onclick="return confirm('Are you sure you want to Delete this code ?');"  title="Delete Key" href="<?php echo site_url('resellers/deleteunusedkey/').$val['id']; ?>" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" ><i class="fa fa-trash"></i>
								</a>
	</li>
								<?php } ?>
							</ul>
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
		<!--end::Table container-->
	<!--begin::Body-->
	</div>
</div>
<script>
  function copyInvoiceNumber(invoiceNumber) {
      navigator.clipboard.writeText(invoiceNumber).then(() => {
          alert(`Key Code ${invoiceNumber} copied  !`);
      }).catch(err => {
          alert('Failed to copy Key Code: ', err);
      });
  }
</script>
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
const searchText = this.value.toLowerCase();
const rows = document.querySelectorAll('#reseller_keycode tbody tr');

rows.forEach(row => {
const cells = row.querySelectorAll('td');
let match = false;

cells.forEach(cell => {
    if (cell.textContent.toLowerCase().includes(searchText)) {
        match = true;
    }
});

if (match) {
    row.classList.remove('hidden');
} else {
    row.classList.add('hidden');
}
});
});
</script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>assets/js/scripts.bundle.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>assets/js/widgets.bundle.js"></script>
<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>assets/js/custom/widgets.js"></script>