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

        <title>Bank Account - <?php echo pageTitle(); ?></title>


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
                                <h4 class="page-title">Bank Account Information</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <?php
                                        if ((isset($_GET['deleteall']) && $_GET['deleteall'] != '') || (isset($_GET['delete']) && $_GET['delete'] != '') )
                                        {
                                    ?>
                                    <div class='alert alert-info alert-dismissable'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                            <div id='result'></div>
                                        </div>
                                    <?php
                                    }

                                    ?>
                                    <h4 class="m-t-0 header-title"><b>Bank account details</b></h4>
                                    
                                    <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add new</button>
                                    <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" 
                                                        data-overlaySpeed="200" data-overlayColor="#36404a">Delete all</a>
                                    <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date added</th>
                                    <th>Account Name</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $count = 0;
                                    $bankaccountdetails = $dataRead->bankaccountdetails($mycon,$currentuserid);
                                    foreach ($bankaccountdetails as $row)
                                    {
                                    ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo formatDate($row['createdon'], "yes"); ?></td>
                                    <td><?php echo $row['bankaccountname']; ?></td>
                                    <td><?php echo $row['bankname']; ?></td>
                                    <td><?php echo $row['bankaccountnumber']; ?></td>
                                    <td>
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#edit-model<?php echo $row['accountdetail_id'] ?>">Edit</button>
                                          <a href="#delete-modal<?php echo $row['accountdetail_id'] ?>" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" 
                                                        data-overlaySpeed="200" data-overlayColor="#36404a">Delete</a>
                                    </td>

                                </tr>
                                <div id="delete-modal<?php echo $row['accountdetail_id']; ?>" class="modal-demo">
                                <button type="button" class="close" onclick="Custombox.close();">
                                    <span>&times;</span><span class="sr-only">Close</span>
                                </button>
                                <h4 class="custom-modal-title">Delete</h4>
                                <div class="custom-modal-text">
                                   Are you sure you want to delete <?php echo $row['bankaccountname']; ?>'s record?
                                </div>
                                <div class="modal-footer"> 
                                    <button type="button" class="btn btn-success waves-effect waves-light" type="button"  onclick="document.location.href='?delete=<?php echo $row['accountdetail_id']; ?>'">Yes</button>
                                    <button type="button" class="btn btn-primary waves-effect" onclick="Custombox.close();">No</button>
                                </div> 
                             </div>
                             <div id="edit-model<?php echo $row['accountdetail_id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title">Update bank account details</h4> 
                                                </div>
                                                <form action="admin/actionmanager.php" method="post" id="updateBankAccounts" >
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="updatebankresult"></div>
                                                    <span id="account_id" class="<?php echo $row['accountdetail_id'] ?>"></span>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group update error" id="updatenamediv"> 
                                                                <label for="name" class="control-label">Account Name*</label> 
                                                                <input type="text" class="form-control" name="name" id="updatename" placeholder="Name" value="<?php echo $row['bankaccountname'] ?>"> 
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group update error" id="updatebanknamediv"> 
                                                                <label for="bankname" class="control-label">Bank Name*</label> 
                                                                <input type="text" class="form-control" name="bankname" id="updatebankname" placeholder="Bank Name" value="<?php echo $row['bankname'] ?>"> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group update error" id="updatebankaccountnumberdiv"> 
                                                                <label for="bankaccountnumber" class="control-label">Bank Account Number*</label> 
                                                                <input type="text" class="form-control" name="bankaccountnumber" id="updatebankaccountnumber" placeholder="Bank Account Number" value="<?php echo $row['bankaccountnumber'] ?>">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group update error" id="updatepassworddiv"> 
                                                                <label for="password" class="control-label">Enter your password*</label> 
                                                                <input type="password" class="form-control" name="password" id="updatepassword" placeholder="Enter password to save changes"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="modal-footer"> 
                                                    <button class="btn btn-success waves-effect waves-light" type="submit" id="bankaccountupdatebutton">Update changes</button>
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div> 
                                            </form>
                                            </div> 
                                        </div>
                                    </div><!-- /.modal -->
                                <?php
                                } 
                                ?>
                            </tbody>
                        </table>
                            </div>
                              <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title">Add new bank account details</h4> 
                                                </div> 
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="result"></div>
                                                    <div class="row"> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="namediv"> 
                                                                <label for="name" class="control-label">Account Name*</label> 
                                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name"> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="surnamediv"> 
                                                                <label for="surname" class="control-label">Account Surname*</label> 
                                                                <input type="text" class="form-control" name="surname" id="surname" placeholder="Surname"> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="banknamediv"> 
                                                                <label for="bankname" class="control-label">Bank Name*</label> 
                                                                <input type="text" class="form-control" name="bankname" id="bankname" placeholder="Bank Name"> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="bankaccountnumberdiv"> 
                                                                <label for="bankaccountnumber" class="control-label">Bank Account Number*</label> 
                                                                <input type="text" class="form-control" name="bankaccountnumber" id="bankaccountnumber" placeholder="Bank Account Number"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="passworddiv"> 
                                                                <label for="password" class="control-label">Enter your password*</label> 
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password to save changes"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="modal-footer"> 
                                                    <button type="button" class="btn btn-success waves-effect waves-light" type="button" id="bankaccountsave">Save changes</button> 
                                                    <button type="button" class="btn btn-danger waves-effect" id="bankaccountreset">Reset</button> 
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div> 
                                            </div> 
                                        </div>
                                    </div><!-- /.modal -->

                                    <!-- Modal -->
         
            </div>
                </div> 

                </div>

                 <?php 
               include_once('inc_footer.php'); 
               ?>

               </div>
            </div>                   
               <div id="custom-modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.close();">
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title">Delete all</h4>
                <div class="custom-modal-text">
                   Are you sure you want to delete all bank accounts?
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-success waves-effect waves-light" type="button"  onclick="document.location.href='?deleteall=yes'">Yes</button>
                    <button type="button" class="btn btn-primary waves-effect" onclick="Custombox.close();">No</button>
                </div> 
            </div>
            <?php
            foreach ($bankaccountdetails as $row)
            {
        ?>

           
         <?php
         }
         ?> 

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
        <?php


            if (isset($_GET['deleteall']) && $_GET['deleteall'] != "") deleteAllAccounts(getCookie('userid'));

            if (isset($_GET['delete']) && $_GET['delete'] != "") deleteAccounts($_GET['delete']);
            //delete all bank accounts
            function deleteAllAccounts($member_id)
            {
                $dataRead = New DataRead();
                $dataWrite = New DataWrite();
                $mycon = databaseConnect();

                //delete all bank accounts
                $bankaccounts = $dataWrite->bankaccounts_deleteall($mycon, $member_id);
                if (!$bankaccounts)
                {
                    echo "<script type='text/javascript'>
                            $('#result').html('There are no records of bank accounts in your database, please add new account details');
                             window.setTimeout(function(){
                            document.location.href='profile-account.php';
                        },4000);
                          </script>";
                    return;
                }

                echo "<script type='text/javascript'>
                            $('#result').html('All bank accounts records has been deleted successfully!');
                             window.setTimeout(function(){
                            document.location.href='profile-account.php';
                        },4000);
                          </script>";
                    return;

            }

            function deleteAccounts($delete_id)
            {
                $dataRead = New DataRead();
                $dataWrite = New DataWrite();
                $mycon = databaseConnect();
                $member_id = getCookie('userid');

                //delete all bank accounts
                $bankaccounts = $dataWrite->bankaccounts_delete($mycon, $member_id, $delete_id);
                if (!$bankaccounts)
                {
                    echo "<script type='text/javascript'>
                            $('#result').html('Unable to delete, please try again.');
                             window.setTimeout(function(){
                            document.location.href='profile-account.php';
                        },4000);
                          </script>";
                    return;
                }

                echo "<script type='text/javascript'>
                            $('#result').html('Bank accounts records has been deleted successfully!');
                             window.setTimeout(function(){
                            document.location.href='profile-account.php';
                        },4000);
                          </script>";
                    return;

            }
        ?>
    </body>
</html>