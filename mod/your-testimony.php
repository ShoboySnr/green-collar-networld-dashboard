<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$mycon = databaseConnect();
$dataRead = New DataRead();

$currentuserid = getCookie("userid");

$referraldetails = $dataRead->memberreferral_getbyid($mycon, $currentuserid);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="img/logo/logowfg.ico">

        <title>Your Testimony  - <?php echo pageTitle(); ?></title>

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />


        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
        
    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

               <?php include_once('inc_header.php') ?>

               <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Your Testimonial Information</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>
                        <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Testimonies</b></h4>
                            <p class="text-muted font-13 m-b-30">
                                Lists of all your testimonies</code>.
                            </p>
                            </div>

                            <!--<div class="card-box">
                                    <div class="comment">
                                        <img src="assets/images/users/avatar-1.jpg" alt="" class="comment-avatar">
                                        <div class="comment-body">
                                            <div class="comment-text">
                                                <div class="comment-header">
                                                    <a href="#" title="">Ade Shobowale</a><span>about 2 minutes ago</span>
                                                </div>
                                                I transfer funds on the 20th of July and i receive fund on the 5th of August 2017. This platform really pays. Thank you!
                                                <div class="m-t-15">
                                                    <p>Fund Received: 50,000 </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-t-30 text-center">
                                        <a href="" class="btn btn-default waves-effect waves-light btn-sm">Load More...</a>
                                    </div>
                                </div> -->
                            </div>
         
            </div>
                </div> 

                </div>

                 <?php 
               include_once('inc_footer.php'); 
               ?>

               </div>
            </div>

                <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>

        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/plugins/peity/jquery.peity.min.js"></script>

        <script src="assets/plugins/jquery-knob/jquery.knob.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>