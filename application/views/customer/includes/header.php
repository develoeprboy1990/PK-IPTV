<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $site_name . ' | ' . $page_title ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/AdminLTE.min.css">
  <!-- Tree view css -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/treestyle.css">
  <!-- Dropify style -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/dropify.css">
  <!-- Sweet Alert style -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/sweetalert.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/select2/dist/css/select2.min.css">

  <!-- Bootstrap toggle cdn -->
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>dist/css/onoffswitch.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/bootstrap/dist/css/less/forms.less">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>plugins/iCheck/all.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper"> 

  <header class="main-header">
    <!-- Logo -->
    <a href="<?= BASE_URL ?>dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>U</b>MS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?= $site_name; ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav"> 
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= DEFAULT_ASSETS ?>logo.png" class="user-image" alt="User Management System">
              <span class="hidden-xs">Customer</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= DEFAULT_ASSETS ?>logo.png" class="img-circle" alt="User Management System">

                <p>
                 <?php echo $this->session->first_name. ' '. $this->session->last_name; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('customer/index/3/'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= BASE_URL ?>customer/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>