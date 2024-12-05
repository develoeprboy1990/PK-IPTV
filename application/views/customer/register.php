<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IPTV Management System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font --> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="login-box">
  <div class="login-logo">
    <!-- <img src="<?= DEFAULT_ASSETS ?>sunglife_logo.png" alt="IMS IPTV Management System" title="UMS" style="height: 8rem;"><br/> -->
    <p>IPTV System</p>
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Register</p>
    <?php if($message){ ?>
          <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $message;?></div>
    <?php } ?>

    <?php echo form_open("customer/register");?>
      <p>
        <?php echo lang('create_user_fname_label', 'first_name');?> <br />
        <?php echo form_input($first_name);?>
      </p>

      <p>
        <?php echo lang('create_user_lname_label', 'last_name');?> <br />
        <?php echo form_input($last_name);?>
      </p>
      
      <?php
      if($identity_column!=='email') {
          echo '<p>';
          echo lang('create_user_identity_label', 'identity');
          echo '<br />';
          echo form_error('identity');
          echo form_input($identity);
          echo '</p>';
      }
      ?>

      <p>
          <label for="activation_key">Activation Key:</label> <br />
          <?php echo form_input($activation_key);?>
      </p> 

      <p>
          <?php echo lang('create_user_email_label', 'email');?> <br />
          <?php echo form_input($email);?>
      </p>

      <p>
          <label for="confirm_email">Confirm Email:</label> <br />
          <?php echo form_input($re_email);?>
      </p>

      <p>
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
          <label for="billing_country">Country:</label> <br />
          <select name="billing_country" id="billing_country" class="form-control" required>
              <option value="">Please Select Country</option>
            <?php foreach($countries as $country){?>
              <option value="<?=$country->id?>" <?php //echo set_select('billing_country', $country->id, False); ?> ><?=$country->name?></option>
            <?php }?>
          </select>
      </p> 

      <p>
          <label for="billing_state">State:</label> <br />
          <select name="billing_state" id="billing_state" class="form-control" required>
          </select>
      </p>

      <!-- <p>
          <label for="billing_city">City:</label> <br />
          <select name="billing_city" id="billing_city" class="form-control"  required>
          </select>
      </p> -->
      
      <p>
            <label for="street">City:</label> <br />
            <?php echo form_input($city);?>
      </p>

      <p>
            <label for="street">Address:</label> <br />
            <?php echo form_input($address);?>
      </p>

    <!--   <p>
          <label for="zip">Zip:</label> <br />
          <input type="text" name="zip" id="zip" value="<?=set_value('zip')?>" class="form-control" >
      </p> -->
     
      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>
    <?php echo form_close();?>

    <div>
        <a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= DEFAULT_ASSETS ?>plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<?php isset($_extra_scripts) ? $this->load->view($_extra_scripts) : ''; ?>

</body>
</html>

