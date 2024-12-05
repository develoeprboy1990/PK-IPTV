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
          <form  novalidate="novalidate" id="kt_sign_in_form" action="<?php echo BASE_URL;?>resellers/login" method="post" class="login-form">
           
            <?php if($this->session->flashdata('message_set')){ ?>
              <div class="fv-row mb-12">
            	<div class="alert alert-danger" role="alert" style="text-align:left;">
            		<?php echo $this->session->flashdata('message_set'); ?>
            	</div>
</div>
            <?php } ?>
            					
            <?php if($message == 'error'){ ?>
              <div class="alert alert-danger" role="alert" style="text-align:left;">
            	<?php echo validation_errors(); ?>									
</div>
            <?php } ?>

		        <div class="form-group"> 
			        <label class="fs-6 fw-semibold form-label mt-0" style="color: #fff;"><span class="required">Email address</span></label>
              <input type="text" class="form-control rounded-left" name="identity" autocomplete="off" placeholder="Enter your email address " value="<?php echo $identity; ?>" required>
            </div>

            <div>
              <label for="username" style="color: aliceblue;"><span class="required">Password</span></label>
            </div>
            <div class="form-group d-flex">
                <input type="password"  id="password-field" class="form-control rounded-left" autocomplete="off" name="password" placeholder="Enter your password"  value="<?php echo $password; ?>"  required>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            
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
