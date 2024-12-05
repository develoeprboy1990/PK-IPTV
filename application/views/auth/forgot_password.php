<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <title>XPlayer IPTV Management Sytem</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <link rel="canonical" href="" />
    <link rel="shortcut icon" href="https://imserver.threeiptv.com/theme/assets/media/logos/xplayer-fav.png" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
  </head>
<style>
 
  </style>
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
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" action="<?=site_url('forgot_password')?>" method="POST">
                            <?php if($this->session->flashdata('success')) { ?>
                                <div class="fv-row mb-12">
                                    <div class="alert alert-danger" role="alert" style="text-align:left;">
                                        <?php echo $this->session->flashdata('success'); ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($this->session->flashdata('error')){ ?>
                                <div class="alert alert-danger" role="alert" style="text-align:left;">
                                    <?php echo $this->session->flashdata('error');?>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Email</span></label>
                                 <?php echo form_input($identity);?>
                            </div>
                            <div id="msgalert" style="text-align:center;"></div>


                            <div id="msgalert_success" style="text-align:center;"></div>
                            
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                              <button type="submit" class="form-control btn btn-primary rounded px-3" >
                                <!--begin::Indicator label-->
                                <span class="indicator-label" id="forget_password">Send</span>

                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress" id="waittext">
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
                          <a href="<?=site_url('login')?>" class="link-primary">Sign in ?</a>
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
<p style="margin-bottom: 10px;" class="text-center text-white">Copyright(c) <?php echo date('Y'); ?>, All rights reserved by <b>XTV Player</b>. <br>
   </p></footer>
</body>
</html>
<!--end::Root-->
    <!--begin::Javascript-->
    <script>var hostUrl = "assets/";</script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/global/plugins.bundle.js"></script>
    <script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/authentication/sign-up/general.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    <?php isset($_extra_scripts) ? $this->load->view($_extra_scripts) : ''; ?>
  </body>
  <!--end::Body-->
</html>

    