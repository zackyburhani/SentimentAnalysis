<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sentiment Analysis | <?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bower_components/Ionicons/css/ionicons.min.css')?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css')?>">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/dist/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/dist/css/skins/_all-skins.min.css')?>">
  <!-- SweetAlert -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/AdminLTE/dist/css/sweetalert.css')?>">
  <!-- Datatables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')?>">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/files/assets/css/upload.css')?>">
   <!-- pnotify -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/files/assets/css/pnotify.custom.min.css')?>">

  <!-- ajax -->
  <!-- jQuery 3 -->
  <script src="<?php echo base_url('assets/AdminLTE/bower_components/jquery/dist/jquery.min.js')?>"></script>

  <!-- Datatables -->
  <script src="<?php echo base_url('assets/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>
  <!-- SweetAlert -->
  <script src="<?php echo base_url('assets/sweetalert/docs/assets/sweetalert/sweetalert.min.js')?>"></script>

  <script type="text/javascript" src="<?php echo base_url('assets/files/assets/js/pnotify.custom.min.js')?>"></script>

  <script type="text/javascript" src="<?php echo base_url('assets/files/assets/js/upload.js')?>"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="<?php echo base_url('assets/Highcharts/code/highcharts.js')?>"></script>
  <script src="<?php echo base_url('assets/Highcharts/code/modules/exporting.js')?>"></script>
  <script src="<?php echo base_url('assets/Highcharts/code/modules/export-data.js')?>"></script>

  <script src="<?php echo base_url('assets/Highcharts/code/modules/wordcloud.js')?>"></script>

  <script src="<?php echo base_url('assets/Highcharts/code/highcharts-3d.js')?>"></script>

  <script src="<?php echo base_url('assets/Highcharts/code/modules/data.js')?>"></script>
  <script src="<?php echo base_url('assets/Highcharts/code/modules/drilldown.js')?>"></script>

  <!-- Google Font -->
  <!-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('') ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>-</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Administrator</b></span>
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
        
      </div>
    </nav>
  </header>