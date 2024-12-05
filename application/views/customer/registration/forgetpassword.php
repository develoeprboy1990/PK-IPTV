<!doctype html>
<html lang="en">
<head>
    <title>IPTV - Forgot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://imserver.threeiptv.com/assets/customer/css/login.css" rel="stylesheet" type="text/css" />
    <style>
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: 21px;
            position: relative;
            z-index: 2;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }
    </style>
</head>
<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h2 class="heading-section"><img src="https://imserver.threeiptv.com/assets/ums/logo-general.png" style="height:160px;" alt="logo" /></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="login-wrap p-4 p-md-5">
                        <form class="form w-100" novalidate="novalidate" onSubmit="return false;">

                            <!--begin::Input group=-->
                            <div class="fv-row mb-4">
                                <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Send Reset Instructions via</span></label>
                                <div class="radio-inline">
                                    <label class="form-check radio form-check-inline" style="color: #fff;">
                                        <input class="form-check-input" type="radio" name="reset_method" value="email" checked>
                                        <span class="required">Send in Email</span>
                                    </label>
                                    <label class="form-check radio form-check-inline" style="color: #fff;">
                                        <input class="form-check-input" type="radio" name="reset_method" value="sms">
                                        <span class="required">Send In SMS</span>
                                    </label>
                                </div>
                            </div>  
                            <!--end::Input group=-->

                            <div id="email-input" class="form-group">
                                <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Email</span></label>
                                <input type="text" class="form-control rounded-left" name="email" autocomplete="off" placeholder="Enter your email address" required id="email" value="<?php echo $email; ?>">
                            </div>

                            <div id="mobile-input" style="display: none;">
                                <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2 form-group">
                                    <div class="col">
                                        <div class="fv-row mb-1">
                                            <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;">
                                                <span class="required">Country Code</span>
                                            </label>
                                            <div class="w-100">
                                                <select id="kt_ecommerce_select2_country" class="form-select form-select-solid" name="c_code" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select" data-control="select2">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach(COUNTRY_MOBILE_CODE as $key=>$val){
                                                        $selected = ($key == '61') ? 'selected' : ''; // 61 is the country code for Australia
                                                        echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="fv-row mb-1">
                                            <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;">
                                                <span>Mobile</span>                                                                     
                                            </label>
                                            <input type="text" class="form-control form-control-solid" name="mobile" value=""  placeholder="Enter your mobile number" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="msgalert" style="text-align:center;"></div>

                            <div id="msgalert_success" style="text-align:center;"></div>
                            
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="forget_password" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Send Reset Instructions</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress" id="waittext" style="display: none;">
                                        Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                        </form>
                        <!--begin::Sign up-->
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            <a href="<?php echo BASE_URL;?>customer/login" class="link-primary">Sign in</a>
                             Not a Member yet?
                            <a href="<?php echo BASE_URL;?>customer/register" class="link-primary">Sign up</a>
                        </div>
                        <!--end::Sign up-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <ul class="foote_bottom_ul_amrc">
            <li><a href="https://www.realtv.co" class="text-white">www.realtv.co</a></li>
        </ul>
    </div>
    <footer style="margin-bottom: 10px;">  
        <p style="margin-bottom: 10px;" class="text-center text-white">Copyright(c) <?php echo date('Y'); ?>, All rights reserved by <b>XTV Player</b>. <br></p>
    </footer>

</body>
</html>