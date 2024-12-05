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
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!-- <img src="<?= DEFAULT_ASSETS ?>sunglife_logo.png" alt="IMS IPTV Management System" title="UMS" style="height: 8rem;"><br/> -->
    <p>IPTV System</p>
  </div> 
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo lang('login_sign_session'); ?></p>
    <?php if($message){ ?>
          <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $message;?></div>
    <?php } ?>
    <!-- <div id="infoMessage"><?php echo $message;?></div> -->
    <?php echo form_open('customer/login');?>
      <div class="form-group has-feedback">
        <?php echo form_input($identity);?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="text-danger"><?= form_error('identity'); ?></span>
      </div>
      <div class="form-group has-feedback">
        <?php echo form_input($password);?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="text-danger"><?= form_error('password'); ?></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?><?php echo lang('login_remember_me'); ?>
                </label>
            </div>
        </div>

        <div class="col-xs-4">
        <?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-primary btn-block btn-flat'));?>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close();?>
    <br/>
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
</body>
</html>
