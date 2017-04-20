<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Obaju e-commerce template">
    <meta name="author" content="Ondrej Svestka | ondrejsvestka.cz">
    <meta name="keywords" content="">

    <title>
        <?php 
            if(isset($title)) echo $title; 
            else echo 'DIRÊ-CLASSIC'; 
        ?>
    </title>

    <meta name="keywords" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>

    <!-- styles -->
    <link href="<?php echo obaju_url();?>css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo obaju_url();?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo obaju_url();?>css/animate.min.css" rel="stylesheet">
    <link href="<?php echo obaju_url();?>css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo obaju_url();?>css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="<?php echo obaju_url();?>css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="<?php echo obaju_url();?>css/custom.css" rel="stylesheet">

    <script src="<?php echo obaju_url();?>js/respond.min.js"></script>

    <link rel="shortcut icon" href="favicon.png">



</head>

<body>

    <!-- *** TOPBAR ***
 _________________________________________________________ -->
    
    <?php include_once "01_topbar.php"; ?>

    <!-- *** TOP BAR END *** -->

    <!-- *** NAVBAR ***
 _________________________________________________________ -->

    <?php include_once "02_navbar.php"; ?>

    <!-- *** NAVBAR END *** -->



    <div id="all">

        <?php 
            if(isset($sub_view))
                $this->load->view($sub_view);
            else
                echo '<div id="content"><div class="container">Nothing to show</div></div>';
        ?>

        <!-- *** FOOTER ***
 _________________________________________________________ -->
        <?php include_once "09_footer.php"; ?>

        <!-- *** FOOTER END *** -->




        <!-- *** COPYRIGHT ***
 _________________________________________________________ -->
        <?php include_once "10_copyright.php"; ?>

        <!-- *** COPYRIGHT END *** -->



    </div>
    <!-- /#all -->


    

    <!-- *** SCRIPTS TO INCLUDE ***
 _________________________________________________________ -->
    <script src="<?php echo obaju_url();?>js/jquery-1.11.0.min.js"></script>
    <script src="<?php echo obaju_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo obaju_url();?>js/jquery.cookie.js"></script>
    <script src="<?php echo obaju_url();?>js/waypoints.min.js"></script>
    <script src="<?php echo obaju_url();?>js/modernizr.js"></script>
    <script src="<?php echo obaju_url();?>js/bootstrap-hover-dropdown.js"></script>
    <script src="<?php echo obaju_url();?>js/owl.carousel.min.js"></script>
    <script src="<?php echo obaju_url();?>js/front.js"></script>


</body>

</html>