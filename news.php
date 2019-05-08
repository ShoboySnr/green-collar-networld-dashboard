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

        <title>News from Admin - <?php echo pageTitle(); ?></title>


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
                                <h4 class="page-title">News from Admin Information</h4>
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
                                    <h4 class="m-t-0 header-title"><b>News Details</b></h4>
                                    
                                    <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add new</button>
                                    <a href="#custom-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" 
                                                        data-overlaySpeed="200" data-overlayColor="#36404a">Delete all</a>
                                    <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Date added</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Creeated by</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $count = 0;
                                    $newsdetails = $dataRead->news_getall($mycon);
                                    foreach ($newsdetails as $row)
                                    {
                                    ?>
                                <tr>
                                    <td><?php echo ++$count; ?></td>
                                    <td><?php echo formatDate($row['thedate'], "yes"); ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['content']; ?></td>
                                    <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                    <td>
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#edit-model<?php echo $row['new_id'] ?>">Edit</button>
                                          <a href="#delete-modal<?php echo $row['new_id'] ?>" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" 
                                                        data-overlaySpeed="200" data-overlayColor="#36404a">Delete</a>
                                    </td>

                                </tr>
                                <div id="edit-model<?php echo $row['new_id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title">Edit <?php echo $row['title'] ?></h4> 
                                                </div> 
                                                    <form action='admin/actionmanager.php' method='post' id='newsform' target="newsframe" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="result"></div>
                                                     <iframe name="newsframe" id="newsframe" width="100%" height="50%" frameborder="0"></iframe> 
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="titlediv"> 
                                                                <label for="name" class="control-label">News Title*</label> 
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="News Title" value="<?php echo $row['title'] ?>"> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="contentdiv"> 
                                                                <label for="surname" class="control-label">Content*</label>
                                                                <textarea class="form-control" name="content" id="content" placeholder="Type news content here" rows="5"><?php echo $row['content'] ?></textarea>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                </div> 
                                                <div class="modal-footer">
                                                    <input type="hidden" id="command" name="command" value="news_edit" />
                                                    <input type="hidden" id="news_id" name="news_id" value="<?php echo $row['new_id'] ?>" />
                                                    <button type="submit" class="btn btn-success waves-effect waves-light" id="newsupdate">Update changes</button>
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
                                                    <h4 class="modal-title">Add News Broadcast Information</h4> 
                                                </div> 
                                                    <form action='admin/actionmanager.php' method='post' id='newsform' target="newsframe" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="result"></div>
                                                     <iframe name="newsframe" id="newsframe" width="100%" height="50%" frameborder="0"></iframe> 
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="titlediv"> 
                                                                <label for="name" class="control-label">News Title*</label> 
                                                                <input type="text" class="form-control" name="title" id="title" placeholder="News Title"> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="contentdiv"> 
                                                                <label for="surname" class="control-label">Content*</label>
                                                                <textarea class="form-control" name="content" id="content" placeholder="Type news content here" rows="5"></textarea>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                </div> 
                                                <div class="modal-footer">
                                                    <input type="hidden" id="command" name="command" value="news_add" />
                                                    <button type="submit" class="btn btn-success waves-effect waves-light" id="newssave">Save changes</button> 
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
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
<!--form validation init-->
        <script src="assets/plugins/tinymce/tinymce.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function () {
                if($("#content").length > 0){
                    tinymce.init({
                        selector: "textarea#content",
                        theme: "modern",
                        height:300,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]
                    });    
                }  
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