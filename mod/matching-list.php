<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$dataRead = New DataRead();

$currentuserid = getCookie("userid");

//get the list of the those merged to pay
$mergeddonations = $dataRead->matching_transfer_getbyidmemeber_admin($mycon);

if ($mergeddonations == null)
{
    $mergeddonations = $dataRead->matching_receive_getbyidmemeber_admin($mycon);
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wealth Fund Global Community - Earn 50% in 15 days on every fund you transfer to help another participants in ypur community.">
        <meta name="author" content="Wealth Fund Global">

        <link rel="shortcut icon" href="img/logo/logowfg.ico">

        <title>Maching Lists - <?php echo pageTitle(); ?></title>


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
                                <h4 class="page-title">All Members Information</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>
                        <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b>Matching Lists</b></h4>
                            <p class="text-muted font-13 m-b-30">
                                Lists of all registered members</code>.
                            </p>

                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Transfer Name</th>
                                    <th>Receiver Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Expry Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $count = 0;
                                    $totalamount = 0;
                                    foreach($mergeddonations as $row)
                                    {

                                        $transferdetails = $dataRead->member_getbyid($mycon, $row['transfer_id']);
                                        $receiverdetails = $dataRead->member_getbyid($mycon, $row['receive_id']);
                                        
                                    ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo $transferdetails['firstname']." ".$transferdetails['lastname'] ?></td>
                                    <td><?php echo $receiverdetails['firstname']." ".$receiverdetails['lastname'] ?></td>
                                    <td><?php echo $row['amount'] ?></td>
                                    <td><?php echo formatDate($row['thedate'], "yes"); ?></td>
                                    <td><?php echo formatDate($row['expirydate'], "yes") ?></td>
                                    <td><?php if ($row['matchingstatus'] == '5') echo 'Matched'; else if ($row['matchingstatus'] == '4') echo 'Rematched'; else if ($row['matchingstatus'] == '3') echo 'Pending'; else echo 'Confirmed' ?></td>
                                    
                                </tr>
                                <?php
                                if ($row['matchingstatus'] != '4')
                                {
                                    $totalamount += $row['amount'];
                                }
                                }
                                ?>
                                 <tr>
                                    <td>Total Times </td>
                                    <td><?php echo $count ?></td>
                                    <td>Total amount out</td>
                                    <td><?php echo $totalamount ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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