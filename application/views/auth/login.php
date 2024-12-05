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

.container{
  padding-top:50px;
  margin: auto;
}
</style>
</head>
<body>
<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <h2 class="heading-section"><img src="https://imserver.threeiptv.com/assets/ums/logo-general.png" style="height:160px;" alt="logo"/></h2>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5">
        <div class="login-wrap p-4 p-md-5">

            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="<?=site_url('login')?>">

            <?php if($this->session->flashdata('success')){?>
              <div class="fv-row mb-12">
                <div class="alert alert-danger" role="alert" style="text-align:left;">
                  <?php echo $this->session->flashdata('success');?>
                </div>
              </div>
            <?php }?>

            <?php if($this->session->flashdata('error')){?>
              <div class="alert alert-danger" role="alert" style="text-align:left;">
                <?php echo $this->session->flashdata('error');?>
              </div>
            <?php }?>




            <div class="form-group"> 
              <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Email address</span></label>
               <?php echo form_input($identity);?>
            </div>

            <div>
              <label for="username" style="color: aliceblue;"><span class="required">Password</span></label>
            </div>
            <div class="form-group d-flex">
                <?php echo form_input($password);?>
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>

            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div><!--<input type="checkbox" name="remember">Remember--></div>
                <!--begin::Link-->
                <a href="<?=site_url('forgot_password')?>" class="link-primary">Forgot Password ?</a>
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->
            
            <div class="form-group">
              <button type="submit"  name="sign_in_submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
            </div>
          
          </form>
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

<script>
  $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
</script>
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
