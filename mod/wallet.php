<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$mycon = databaseConnect();
$dataRead = New DataRead();

$currentuserid = getCookie("userid");

$donationdetails = $dataRead->donation_getbyid($mycon,$currentuserid);

$donationdetail = $dataRead->donations_getbyid($mycon,$currentuserid);

$memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);

//get the last Ph request fulfilled

//get the referral donations bonus
$referraldonationdetails = $dataRead->referraldonations_getbyid($mycon,$currentuserid);


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wealth Fund Global Community - Earn 50% in 15 days on every fund you transfer to help another participants in ypur community.">
        <meta name="author" content="Wealth Fund Global">

        <link rel="shortcut icon" href="img/logo/logowfg.ico">

        <title>Fund Wallet - <?php echo pageTitle(); ?></title>


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
                                <h4 class="page-title">Fund Wallet Information</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>
                        <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b>Fund Wallet Growth</b></h4>
                            <p class="text-muted font-13 m-b-30">
                                Account wallet details and growth
                            </p>
                            <div class="col-lg-12">
                                <button class='btn btn-success waves-effect waves-light' data-toggle='modal' id='availablebalancebutton' data-target=".available">Available to withdraw</button>
                                <div class="portlet">
                                    <div class="portlet-heading bg-custom">
                                        <h3 class="portlet-title">
                                           Wallet
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="javascript:;" data-toggle="reload" onclick="walletRefresh(this)"><i class="ion-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="bg-primary" class="panel-collapse collapse in">
                                        <div class="portlet-body" id="wallet_refresh">
                                             <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Fullname</th>
                                    <th>Initial Amount</th>
                                    <th>Growth</th>
                                    <th>Current Amount</th>
                                    <th>Expected Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $count = 0;
                                    $totalamount = 0;
                                    foreach($referraldonationdetails as $row)
                                    {
                                        $totalamount += ($row['donation_ph'] * 0.1);
                                    ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo formatDate($row['donationcreatedon'], "yes") ?></td>
                                    <td><?php echo 'Referral bonus' ?></td>
                                    <td><?php echo $row['firstname']." ".$row['lastname'] ?></td>
                                    <td><?php echo $row['donation_ph'] ?></td>
                                    <td><?php echo '10%' ?></td>
                                    <td><?php echo ($row['donation_ph'] * 0.1) ?></td>
                                    <td><?php echo ($row['donation_ph'] * 0.1) ?></td>
                                    <td><?php if($row['status'] == '5') echo 'Pending'; else if ($row['status'] == '3') echo 'Matched'; elseif ($row['status'] == '0') echo 'Confirmed'; ?></td>  
                                </tr>
                                <?php
                                }
                                ?>

                                <?php
                                foreach($donationdetails as $row)
                                    { 
                                        if ($row['donation_ph'] != '')
                                        {
                                        $totalamount += ($row['donation_ph'] * 0.1);
                                    ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo formatDate($row['donationcreatedon'], "yes") ?></td>
                                    <td><?php echo 'Transfer Fund Request' ?></td>
                                    <td><?php echo $row['firstname']." ".$row['lastname'] ?></td>
                                    <td><?php echo $row['donation_ph'] ?></td>
                                    <td><?php echo '50%' ?></td>
                                    <td><?php echo $row['growth'] ?></td>
                                    <td><?php echo ($row['donation_ph'] + ($row['donation_ph'] * 0.5)) ?></td>
                                    <td><?php if($row['status'] == '5') echo 'Pending'; else if ($row['status'] == '3') echo 'Matched'; elseif ($row['status'] == '0') echo 'Confirmed'; ?></td>  
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            </div>
                            </div>
         
            </div>
                </div> 

                </div>
                 <div class='modal fade available' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                    <div class='modal-dialog modal-sm'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                <h4 class='modal-title' id='mySmallModalLabel'>Available to withdrawn</h4>
                        </div>
                            <div class='modal-body'>
                              <p>Available to withdrawn: <span id='availablebalance'></span></p>
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