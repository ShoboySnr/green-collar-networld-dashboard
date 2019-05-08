<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$mycon = databaseConnect();
$dataRead = New DataRead();


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wealth Fund Global Community - Earn 50% in 15 days on every fund you transfer to help another participants in ypur community.">
        <meta name="author" content="Wealth Fund Global">

        <link rel="shortcut icon" href="img/logo/logowfg.ico">

        <title>System Rules - <?php echo pageTitle(); ?></title>


        <link href="assets/plugins/custombox/css/custombox.css" rel="stylesheet">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />


        <link href="assets/plugins/bootstrap-table/css/bootstrap-table.min.css" rel="stylesheet" type="text/css" />


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
                                <h4 class="page-title">System Rules</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>
                        <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b>Wealth Fund Global System Rules</b></h4>
                            <p class="text-muted font-13 m-b-30">
                                Read our system rules for all participants on this global community</code>.
                            </p>
                            <div class="col-sm-12">
                                <div class="panel panel-border panel-custom">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Read the following carefully before participating...</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>
                                            Wealth Fund Global is only a mutual community that brings individuals together to help one another by transfering and receiving funds. Hence, WFG is not a bank. 
                                            It has no specific place where participants' money are kept. It simply involves the transfer of funds from one participants to another and receipients of funds to another participants.
                                             Only the participants determines the growth of this community. 
                                            <br><span style='color: #FF0000'>Participants are to participates mutually with their spare cash only.</span>
                                        </p>
                                        <p> The following rules applies to all individuals on this global network. Make sure you read these rules and understand it before participating mutually.</p>
                                        <p><span class='text-primary'>1. </span> Only participate with your spare cash. If you don't have money, please do not bother to register on this platform as your accounts would be disabled
                                            after 3 days if you did not make any transfer funds requests.</p>
                                        <p><span class='text-primary'>2. </span> Request to transfer funds or receive funds will be shown in your dashboard. Make sure if you are to transfer funds to fulfil this request on or before the expiry date shown. 
                                            Failure to do that will lead to your accounts being blocked temporarily. And if you are to receive funds, ensure you confirm the participants that transfer the funds to you immediately you receive bank alert. Do not confirm blindly.</p>
                                         <p><span class='text-primary'>3. </span> We give zero tolerance to fake or invalid proof of payment, any one suspected to have uploaded fake POP will be automatically blocked.</p>
                                         <p><span class='text-primary'>4. </span> We only give room to one request at a time. Therefore, it is not possible to make multiple requests on this platform. And any one suspected will be automatically be blocked permanently from this platform. 
                                            This is not a money doubler platform. We only help one another.</p>
                                        <p><span class='text-primary'>5. </span> You cannot make any transfer fund request less than the previous requests. You can only increase or maintain the level of your previous requests.</p>
                                        <p><span class='text-primary'>6. </span> Every participants should get a mobile banking for the smooth operations and running of their individual accounts. 
                                            We give zero tolerance to weekend excuses, as soon as your time to transfer funds expires the system will automatically block you.</p>
                                        <p><span class='text-primary'>7. </span> For those who loves to delay confirmation of payment, the system gives you only 48 hours only to ensure that you confirm the participants that transfer funds to you. Failure to do so will lead 
                                            to automatic suspension of your accounts and deductions from your fund wallet.</p>
                                        <p><span class='text-primary'>8. </span> Transfer funds request will be matched between 9th and 13th day. And shall not exceed the stipulated time, so don't be scared if your request is late to be matched, it will definately be merged.</p>
                                        <p><span class='text-primary'>10. </span>You don't make receive funds request anyhow, there is room for recommitment. Failure to recommit that is make another transfer funds request after 30 days will lead to automatic block of your accounts all bonus and downlines will be deleted from your fund wallet. All our participants should ensure to recommit, that is the only way this
                                            system is going to survive and last longer. </p>
                                        <div class="panel-heading">
                                        <h3 class="panel-title">WE RESERVE THE RIGHT TO REVISE OUR SYSTEM RULES FROM TIME TO TIME TO ENSURE THAT THIS PLATFORM GOES SMOOTHLY AND EVERYBODY BENEFITS. WE URGE ALL OUR PARTICIPANTS TO COMPLY AND OBEY THE SYSTEM RULES. I LOVE WEALTH FUND GLOBAL. WEALTH FUND GLOBAL IS HERE TO STAY FOREVER!</h3>
                                    </div>
                                    </div>
                                </div>
                            </div>
                           
                            </div>
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


        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


        <!-- Modal-Effect -->
        <script src="assets/plugins/custombox/js/custombox.min.js"></script>
        <script src="assets/plugins/custombox/js/legacy.min.js"></script>

        <script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
    });

</script>
    </body>
</html>