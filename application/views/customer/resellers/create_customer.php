<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Add a new Customer</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_profile_details" class="collapse show">
        <!--begin::Form-->
        <form class="form" method="post" action="<?php echo site_url('resellers/createcustomer');?>">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <div class="col-lg-8">
                        <!--begin::Row-->
                        <div class="row">
                            <?php if($message == 'error'){ ?>
                                <div class="alert alert-danger" role="alert" style="text-align:left;">
                                    <?php echo validation_errors(); ?>									
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">Title</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <select id="title" name="title" data-control="select2" data-placeholder="Select a City.." class="form-select form-select-solid form-select-lg">
                            <option value="Mr."> Mr.</option>
                            <option value="Mrs."> Mrs.</option>
                            <option value="Ms."> Ms.</option>
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
                                <input type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="<?php echo $first_name;?>" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="<?php echo $last_name;?>" />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">Mobile</label>
                    <!--end::Label-->
                    <div class="col-lg-6">
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6 fv-row">
                                <select id="kt_ecommerce_select2_country" class="form-select form-select-solid" name="c_code" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select a country" data-control="select2">
                                    <option value="">Select</option>
                                    <?php
                                        foreach(COUNTRY_MOBILE_CODE as $key=>$val){
                                            if($key == $c_code){
                                                echo '<option value="'.$key.'" selected>'.$val.'</option>';
                                            } else {
                                                echo '<option value="'.$key.'">'.$val.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <input type="text" name="mobile" class="form-control form-control-lg form-control-solid" placeholder="Mobile" value="<?php echo $mobile;?>" />
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">Email</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <input type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email" value="<?php echo $email;?>" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
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
                            <?php foreach($countries as $country){?>
                                <option data-kt-flag="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/flags/<?=$country->name?>.svg" value="<?php echo $country->id; ?>" <?=($country->id==$billing_country) ? "selected":""?>><?php echo $country->name;?></option>
                            <?php }?>
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
                        <select id="currency" name="currency" data-control="select2" data-placeholder="Select a country..." class="form-select form-select-solid form-select-lg fw-semibold">
                            <option value="">Select a Currency...</option>
                            <?php foreach(COUNTRY_CURRENCY as $key=>$val){?>
                                <option value="<?php echo $val;?>"><?php echo $key;?></option>
                            <?php }?>
                        </select>
                        <span class="text-danger"><?= form_error('currency_type'); ?></span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

 
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">State</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <!--begin::Input-->
                        <input type="text" id="billing_state" name="billing_state" class="form-control form-control-lg form-control-solid" placeholder="State" value="<?php echo $billing_state;?>" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">City</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <!--begin::Input-->
                        <input type="text" id="billing_city" name="billing_city" class="form-control form-control-lg form-control-solid" placeholder="City" value="<?php echo $billing_city;?>" />
                        <!--end::Input-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label fw-semibold fs-6 required">Street</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <input type="text" name="billing_street" class="form-control form-control-lg form-control-solid" placeholder="Street name" value="<?php echo $billing_street;?>" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label fw-semibold fs-6 required">Zip</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <input type="text" name="billing_zip" class="form-control form-control-lg form-control-solid" placeholder="Zip..." value="<?php echo $billing_zip;?>" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">Activation Key</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-6 fv-row">
                        <input type="text" name="plan_keycode" class="form-control form-control-lg form-control-solid" placeholder="Activation Key..." value="<?php echo $plan_keycode;?>" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-2 col-form-label fw-semibold fs-6">Active</label>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="status" name="status" value="1" checked="checked" />
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
                        <input type="submit" name="create_customer" id="create_customer" value="Create Customer" class="btn btn-primary" />
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
