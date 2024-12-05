<!doctype html>
<html lang="en">
<head>
    <title>IPTV</title>
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
                        <form novalidate="novalidate" action="<?php echo BASE_URL;?>customer/migrate?data=<?php echo $encoded_data; ?>" method="post" >
                        	<input type="hidden" value="<?php echo $encoded_data; ?>"  name="encoded_data" >

                            <?php if($this->session->flashdata('message_set')) { ?>
                                <div class="fv-row mb-12">
                                    <div class="alert alert-danger" role="alert" style="text-align:left;">
                                        <?php echo $this->session->flashdata('message_set'); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($message == 'error') { ?>
                                <div class="alert alert-danger" role="alert" style="text-align:left;">
                                    <?php echo validation_errors(); ?>
                                </div>
                            <?php } ?>

							<div class="form-group">
                                <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Name</span></label>
                                <input type="text" class="form-control rounded-left" name="name" autocomplete="off" placeholder="Enter your name" value="<?php echo $name; ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Email</span></label>
                                <input type="text" class="form-control rounded-left" name="email" autocomplete="off" placeholder="Enter your email address" value="<?php echo $email; ?>" required>
                            </div>

							<div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2 form-group">
								<!--begin::Col-->
								<div class="col">
									<!--begin::Input group-->
									<div class="fv-row mb-1">
										<!--begin::Label-->
										<label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;">
											<span class="required">Country Code</span>
										</label>
										<!--end::Label-->
										<div class="w-100">
											<!--begin::Select2-->
											<select id="kt_ecommerce_select2_country" class="form-select form-sel ect-solid" name="c_code" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select a country" data-control="select2">
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
											<!--end::Select2-->
										</div>
									</div>
									<!--end::Input group-->
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col">
									<!--begin::Input group-->
									<div class="fv-row mb-1">
										<!--begin::Label-->
										<label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;">
											<span>Mobile</span>																		
										</label>
										<!--end::Label-->
										<!--begin::Input-->
										<input type="text" class="form-control form-control-solid" name="mobile" value="<?php echo $mobile;?>" placeholder="Enter your mobile number" />
										<!--end::Input-->
									</div>
									<!--end::Input group-->
								</div>
								<!--end::Col-->
							</div>
							
							<!--begin::Input group-->
							<div class="fv-row mb-2" data-kt-password-meter="true">
								<!--<label class="fs-6 fw-semibold form-label mt-3"><span class="required">Password</span></label>
								
								<div class="mb-1">
									
									<div class="position-relative mb-3">
										<input class="form-control bg-transparent" type="password" placeholder="Password" name="passwordv" autocomplete="off" value="<?php echo $passwordv;?>" />												
									</div>
								
								</div>
								
								<div class="text-muted">Use not less than 8 characters and not more than 18 characters.</div>-->
								
							</div>
							<!--end::Input group=-->

                            <div class="form-group">
                                <button type="submit" name="kt_sign_up_submit" class="form-control btn btn-primary rounded submit px-3">Submit</button>
                            </div>
                        </form>
                        <!--begin::Sign up-->
                        <!-- <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                            <a href="<?php echo BASE_URL;?>customer/login" class="link-primary">Sign in</a>
                        </div> -->
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
<p style="margin-bottom: 10px;" class="text-center text-white">Copyright(c) <?php echo date('Y'); ?>, All rights reserved by <b>XTV Player</b>. <br>
   </p></footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>