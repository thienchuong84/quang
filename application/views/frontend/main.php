<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/ionicons/2.0.1/css/ionicons.min.css"> -->

  <!-- jquery ui -->
   <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/jquery-ui-1.12.1.base/jquery-ui.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo base_url();?>public/css/skins/skin-blue-custom-01.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url();?>public/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>public/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery ui -->
<script src="<?php echo base_url();?>public/plugins/jquery-ui-1.12.1.base/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>public/js/app.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->  
</head>

<body class="hold-transition skin-blue sidebar-mini layout-top-nav">
<div class="wrapper">

<?php 
      include_once 'inc_mainHeader.php'; 

      //include_once 'inc_leftSideColumn.php';
      //include_once 'inc_contentWrapper.php';
?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!--
    <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>
    -->

    <!-- Main content -->
    <section class="content">

    <?php
      $this->load->view($subView);
      // if(isset($extensions)) cpre($extensions);

    ?>      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?php 
    include_once 'inc_footer.php';
    include_once 'inc_controlSidebar.php'; 
?>
</div>
<!-- ./wrapper -->


</body>
</html>
