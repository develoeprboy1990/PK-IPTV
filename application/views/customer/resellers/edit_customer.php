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
    				<span class="nav-text fw-semibold fs-4 mb-3">Info</span>
    				<!--end::Subtitle-->
    				<!--begin::Bullet-->
    				<span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
    				<!--end::Bullet-->
    			</a>
    			<!--end::Link-->
    		</li>
    		<!--end::Item-->

            <!--begin::Item-->
            <li class="nav-item p-0 ms-0 me-8" role="presentation">
                <!--begin::Link-->
                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="pill" href="#kt_timeline_widget_2_tab_2" aria-selected="false" role="tab" tabindex="-1">
                    <!--begin::Subtitle-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Logs</span>
                    <!--end::Subtitle-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
                <!--end::Link-->
            </li>
            <!--end::Item-->

             <?php if ($is_upgrade == '1') {?>
            <!--begin::Item-->
            <li class="nav-item p-0 ms-0 me-8" role="presentation">
                <!--begin::Link-->
                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="pill" href="#kt_timeline_widget_2_tab_3" aria-selected="false" role="tab" tabindex="-1">
                    <!--begin::Subtitle-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Upgrade Logs</span>
                    <!--end::Subtitle-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
                <!--end::Link-->
            </li>
            <!--end::Item-->
            <?php } ?>

             <?php if ($resellerInfo[0]['can_view_devices'] == '1') {?>



            <!--begin::Item-->
            <li class="nav-item p-0 ms-0 me-8" role="presentation">
                <!--begin::Link-->
                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="pill" href="#kt_timeline_widget_2_tab_4" aria-selected="false" role="tab" tabindex="-1">
                    <!--begin::Subtitle-->
                    <span class="nav-text fw-semibold fs-4 mb-3">Devices</span>
                    <!--end::Subtitle-->
                    <!--begin::Bullet-->
                    <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                    <!--end::Bullet-->
                </a>
                <!--end::Link-->
            </li>
            <!--end::Item-->

            <?php } ?>



    		 
    	</ul>
		<!--end::Nav-->
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body">
		<!--begin::Tab Content-->
		<div class="tab-content">
			<!--begin::Tap pane-->
			<div class="tab-pane  active show" id="kt_timeline_widget_2_tab_1" role="tabpanel">
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Edit Customer</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form class="form" method="post" action="<?php echo site_url('resellers/editcustomer/') . $customid; ?>">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <?php if ($message == 'error') { ?>
                                            <div class="alert alert-danger" role="alert" style="text-align:left;">
                                                <?php echo validation_errors(); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">Title</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select id="title" name="title" data-control="select2" data-placeholder="Select a City.." class="form-select form-select-solid form-select-lg">
                                        <option value="Mr." <?php if ($title == 'Mr.') { echo 'selected="selected"'; } ?>> Mr.</option>
                                        <option value="Mrs." <?php if ($title == 'Mrs.') { echo 'selected="selected"'; } ?>> Mrs.</option>
                                        <option value="Ms." <?php if ($title == 'Ms.') { echo 'selected="selected"'; } ?>> Ms.</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">Full Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="<?php echo $first_name; ?>" />
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="<?php echo $last_name; ?>" />
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">Mobile</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row">
                                            <select id="kt_ecommerce_select2_country" class="form-select form-select-solid" name="c_code" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select a country" data-control="select2">
                                                <option value="">Select</option>
                                                <?php
                                                foreach (COUNTRY_MOBILE_CODE as $key => $val) {
                                                    if ($key == $c_code) {
                                                        echo '<option value="' . $key . '" selected>' . $val . '</option>';
                                                    } else {
                                                        echo '<option value="' . $key . '">' . $val . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="mobile" class="form-control form-control-lg form-control-solid" placeholder="Mobile" value="<?php echo $mobile; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">Email</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input readonly="readonly" type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email" value="<?php echo $email; ?>" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6 required">Password</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input readonly="readonly" type="text" name="password" class="form-control form-control-lg form-control-solid" placeholder="Password" value="<?php echo $password; ?>" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">Country</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select id="billing_country" name="billing_country" data-control="select2" data-placeholder="Select a country..." class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">Select a Country...</option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option data-kt-flag="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW; ?>media/flags/<?= $country->name ?>.svg" value="<?php echo $country->id; ?>" <?= ($country->id == $billing_country) ? "selected" : "" ?>><?php echo $country->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">
                                    <span class="required">Currency Type </span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <select id="currency" name="currency" data-control="select2" data-placeholder="Select a currency..." class="form-select form-select-solid form-select-lg fw-semibold">
                                        <option value="">Select a Currency...</option>
                                        <?php foreach(COUNTRY_CURRENCY as $key=>$val){?>
                                            <option value="<?php echo $val;?>" <?= ($val == $currency) ? "selected" : "" ?>><?php echo $key;?></option>
                                        <?php }?>
                                    </select>
                                    <span class="text-danger"><?= form_error('currency_type'); ?></span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

            

                            
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">State</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="billing_state" class="form-control form-control-lg form-control-solid" placeholder="State" value="<?php echo $billing_state; ?>" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-6">City</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="billing_city" class="form-control form-control-lg form-control-solid" placeholder="City" value="<?php echo $billing_city; ?>" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6 required">Street</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="billing_street" class="form-control form-control-lg form-control-solid" placeholder="Company name" value="<?php echo $billing_street; ?>" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6 required">Zip</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="billing_zip" class="form-control form-control-lg form-control-solid" placeholder="Zip..." value="<?php echo $billing_zip; ?>" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label fw-semibold fs-6">Active</label>
                                <!--end::Label-->
                                <!--begin::Label-->
                                <div class="col-lg-6 d-flex align-items-center">
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        <input class="form-check-input w-45px h-30px" type="checkbox" id="status" name="status" value="1" <?php if ($status == '1') { echo 'checked="checked"'; } ?> />
                                        <label class="form-check-label" for="allowmarketing"></label>
                                    </div>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            <div class="row mb-6">
                                <label class="col-lg-5 col-form-label fw-semibold fs-6"></label>
                                <div class="col-lg-4 d-flex align-items-center">
                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                    <input type="submit" name="create_customer" id="create_customer" value="Edit Customer" class="btn btn-primary" />
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
                <!--end::Content-->
            </div>

			</div>
			<!--end::Tap pane-->
			<!--begin::Tap pane   customer info form start here -->
			<div class="tab-pane " id="kt_timeline_widget_2_tab_2" role="tabpanel">
				<!--begin::Table container-->
                <div class="row">
                    <div class="col-lg-3" style="margin-top: 10px; ">
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                    <!--begin::Input-->
                    <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="d-flex">
                    <!--begin::Icon-->
                    <i class="ki-duotone ki-verify fs-1 text-primary">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    </i>
                    <!--end::Icon-->
                    <!--begin::Info-->
                    <span class="ms-4">
                    <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">  Active Product</span>
                    <span class="fw-semibold fs-4 text-muted"><?=$productName?> </span> 
                    </span>
                    <!--end::Info-->
                    </span>
                    <!--end::Label-->
                    </label> 
                </div>

                    <div class="col-lg-3" style="margin-top: 10px; ">
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                        <!--begin::Input-->
                        <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="d-flex">
                        <!--begin::Icon-->
                        <i class="ki-duotone ki-verify fs-1 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        </i>
                        <!--end::Icon-->
                        <!--begin::Info-->
                        <span class="ms-4">
                        <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">  Active Plan</span>
                        <span class="fw-semibold fs-4 text-muted"><?=$ActivePlanName?> </span> 
                        </span>
                        <!--end::Info-->
                        </span>
                        <!--end::Label-->
                        </label> 
                    </div>
                


                    <div class="col-lg-3" style="margin-top: 10px; ">
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                        <!--begin::Input-->
                        <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="d-flex">
                        <!--begin::Icon-->
                        <i class="fa fa-calendar  fa-5x" aria-hidden="true"> 

                        </i>
                        <!--end::Icon-->
                        <!--begin::Info-->
                        <span class="ms-4">
                        <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Plan Activate</span>
                        <span class="fw-semibold fs-4 text-muted"> <?php echo date("j F, Y, g:i a", strtotime($vcodelife));?>

                        </span>
                        </span>
                        <!--end::Info-->
                        </span>
                        <!--end::Label-->
                        </label> 
                    </div>

                    <div class="col-lg-3" style="margin-top: 10px; ">
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                        <!--begin::Input-->
                        <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                        <!--end::Input-->
                        <!--begin::Label-->
                        <span class="d-flex">
                        <!--begin::Icon-->
                        <i class="fa fa-calendar  fa-5x" aria-hidden="true"> 

                        </i>
                        <!--end::Icon-->
                        <!--begin::Info-->
                        <span class="ms-4">
                        <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Plan Expire</span>
                        <span class="fw-semibold fs-4 text-muted"> <?php echo date("j F, Y, g:i a", strtotime($expire));?>

                        </span>
                        </span>
                        <!--end::Info-->
                        </span>
                        <!--end::Label-->
                        </label> 
                    </div>
                </div>
       
                <div class="table-responsive">
					<!--begin::Table-->
                    <h2>Recharge History</h2>
    				<table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
    						<!--begin::Table head-->
    						<thead>
    							<tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
    								<th class="ps-0 w-50px">S.No</th> 
                                    <th class=" min-w-100px">Activation Key</th>
                                    <th class=" min-w-100px">Product Name</th>
    								<th class=" min-w-100px">Plan Name</th>
    								<th class="min-w-100px">Plan Duration</th> 
    								<th class="min-w-100px">Recharge</th>
    							</tr>
    						</thead>
    						<!--end::Table head-->
    						<!--begin::Table body-->
    						<tbody>
                            <?php
                            $i=1;
                          foreach($info as $info){?>
                           
    							<tr>    								 
    								<td class="ps-0">
    									 <?=$i?>
    								</td>
    								<td>    									 
                                            <?php if($info['sebscription_trpe']=='Active'){?>
                                                <a   style="color:#009ef7;" class="btn btn-light-success btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"   data-bs-original-title="Actvation Key" title="Actvation Key" data-kt-initialized="1"><?=$info['activation_code'];?></a>

                                            <?php } else{ ?>  <a   style="color:#009ef7;" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"   data-bs-original-title="Recharge Key" title="Recharge Key" data-kt-initialized="1"><?=$info['activation_code'];?></a> <?php  }?>  
    								</td>

                                    <td>
                                        <span class="text-gray-800 fw-bold d-block fs-6 ps-0"> <?=$info['productName']?></span>
                                    </td>
                                    <td>
    									<span class="text-gray-800 fw-bold d-block fs-6 ps-0"> <?=$info['group_name']?></span>
    								</td>
                                    <td>
    									  <?=$info['subscription_renewal_keys']?>  <?=$info['subscription_days_or_month']?> 
    									  
    								</td>
    								 
    								<td class="  pe-0">
    									 
                                         <?php echo date("j F, Y, g:i a", strtotime($info['created_at']));?> 
    								</td>
                                    

                                </tr>
    							 <?php   $i++;
                                   }

                                  ?>
    						</tbody>
    						<!--end::Table body-->
    					</table>
				</div>
				<!--end::Table-->
			</div>
			<!--end::Tap pane-->

            <!--begin::Tap pane   customer history form start here -->
            <div class="tab-pane " id="kt_timeline_widget_2_tab_3" role="tabpanel">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <h2>Upgrade Logs</h2>
                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                <th class="ps-0 w-50px">S.No</th> 
                                <th class="min-w-100px">Plan Name</th>
                                <th class="min-w-100px">Type</th>
                                <th class="min-w-100px">Refunded Amount</th>
                                <th class="min-w-100px">Dates</th>
                                <th class="min-w-100px">Activation Code</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        <?php
                        $i=1;
                        foreach($reseller_customer_log as $val){?>
                            <tr>                                     
                                <td class="ps-0"><?=$i?></td>
                                <td><?php echo $val['plan_name'].'<br>'.'Devide Allowed:'.$val['devices_allowed']; ?></td>
                                <td>
                                    <span class="text-gray-800 fw-bold d-block fs-6 ps-0"><?php echo $val['sebscription_trpe']; ?></span>
                                </td>
                                <td><?php echo $val['remaining_balance']; ?></td>
                                <td>
                                    <?php echo 'Created: '.$val['date_created'].'<br>';?>
                                    <?php echo 'Expire: '.$val['subscription_expire'].'<br>';?>     
                                </td>
                                <td><?php echo $val['activation_code'];?></td>
                            </tr>
                        <?php
                        $i++;
                        }
                        ?>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Tap pane-->

            <div class="tab-pane " id="kt_timeline_widget_2_tab_4" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                        <thead>
                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                <th>UUID</th>
                                <th>Model</th>
                                <th>Type</th>
                                <th>IP Address</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Appversion</th>
                                <th>Valid</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($devices['devices'] as $device): ?>
                                <tr>
                                    <td><?= $device['uuid'] ?></td>
                                    <td><?= $device['model'] ?></td>
                                    <td><?= $device['type'] ?></td>
                                    <td><?= $device['ip'] ?></td>
                                    <td><?= $device['country'] ?></td>
                                    <td><?= $device['city'] ?></td>
                                    <td><?= $device['state'] ?></td>
                                    <td><?= $device['appversion'] ?></td>
                                    <td><?= date('Y-m-d H:i:s', $device['valid']) ?></td>
                                    <td>
                                        <!-- <a href="<?= site_url('resellers/editDevice/'.$customid.'/'.$device['uuid']) ?>" class="btn btn-primary btn-sm">Edit</a> -->
                                        <a href="<?= site_url('resellers/deleteDevice/'.$customid.'/'.$device['uuid']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this device?')">Release device</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
		 
		</div>
		<!--end::Tab Content-->
	</div>
	<!--end::Body-->
</div>