<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$mycon = databaseConnect();
$dataRead = New DataRead();


//get the country lists
$countrydetails = $dataRead->country_getall($mycon);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wealth Fund Global Community - Earn 50% in 15 days on every fund you transfer to help another participants in ypur community.">
        <meta name="author" content="Wealth Fund Global">

        <link rel="shortcut icon" href="img/logo/logowfg.ico">

        <title>Profile - <?php echo pageTitle(); ?></title>

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
                                <h4 class="page-title">Profile Information</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>

                        <div class="row">
                                <div class="profile-detail card-box">
                                    <div class="col-md-4 col-lg-3">
                                    <div style="padding-top: 30px">
                                        <img src="member_image/<?php if ($memberdetails['picturestatus'] == '0') echo 'avatar.png'; else echo $memberdetails['username'].'.jpg'; ?>"  class="img-circle" alt="<?php echo $memberdetails['username'] ?>_photo">
                                        <iframe name="actionframe" id="actionframe" width="1px" height="1px" frameborder="0"></iframe> 
                                            <form action='admin/actionmanager.php' method='post' id='evidenceform' target="actionframe" enctype="multipart/form-data">
                                              
                                                <div class="row">
                                                <div class="form-group text-center m-t-40">
                                                <div class="col-md-12"> 
                                                    <div class="form-group paid error" id="imageuploaddiv"> 
                                                        <input type="file" class="form-control" name="imageupload" id="imageupload">
                                                    </div> 
                                                </div>
                                                    <div class="col-md-12 text-center">
                                                    <button class="btn btn-success waves-effect waves-light" type="submit">
                                                        <input type="hidden" class="form-control" name="command" id="command" value="uploadfile">
                                                    Upload
                                                    </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-9">
                                    <div  style="padding-top: 30px">
                                        <div class="text-left">
                                            <p class="text-muted font-13"><strong>Full Name :</strong> <span class="m-l-15"><?php echo $memberdetails['firstname']. " ". $memberdetails['lastname'] ?></span></p>

                                            <p class="text-muted font-13"><strong>Mobile :</strong><span class="m-l-15"><?php echo $memberdetails['phonenumber']; ?></span></p>

                                            <p class="text-muted font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $memberdetails['email']; ?></span></p>

                                            <p class="text-muted font-13"><strong>Gender :</strong> <span class="m-l-15"><?php echo $memberdetails['gender']; ?></span></p>

                                            <p class="text-muted font-13"><strong>Country :</strong> <span class="m-l-15"><?php echo $memberdetails['country'] ?></span></p>

                                            <p class="text-muted font-13"><strong>Location :</strong> <span class="m-l-15"><?php echo $memberdetails['address'] ?></span></p>

                                             <p class="text-muted font-13"><strong>Join since :</strong> <span class="m-l-15"><?php echo formatDate($memberdetails['createdon'], "yes"); ?></span></p>

                                        </div>
                                    </div>

                                </div>

                                <div class="card-box">
                                    <h4 class="m-t-0 m-b-20 header-title"><button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Edit Profile</button></h4>


                                </div>
                            </div>
                        </div>
                                              <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title">Update profile</h4> 
                                                </div> 
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="result"></div>
                                                    <form action="admin/actionmanager.php" method="post" id="profileform">
                                                    <div class="row"> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="firstnamediv"> 
                                                                <label for="firstname" class="control-label">Firstname*</label> 
                                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Firstname" value="<?php echo $memberdetails['firstname']; ?>"> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="lastnamediv"> 
                                                                <label for="lastname" class="control-label">lastname*</label> 
                                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Lastname" value="<?php echo $memberdetails['lastname']; ?>"> 
                                                            </div> 
                                                        </div> 
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="usernamediv"> 
                                                                <label for="username" class="control-label">Username*</label> 
                                                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" readonly value="<?php echo $memberdetails['username']; ?>"> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="phonenumberdiv"> 
                                                                <label for="phonenumber" class="control-label">Phonenumber*</label> 
                                                                <input type="text" class="form-control" name="phonenumber" id="phonenumber" placeholder="Phonenumber" value="<?php echo $memberdetails['phonenumber']; ?>"> 
                                                            </div> 
                                                        </div>
                                                    </div> 

                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="emaildiv"> 
                                                                <label for="email" class="control-label">Email*</label> 
                                                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" readonly value="<?php echo $memberdetails['email']; ?>"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="sexdiv"> 
                                                                <label for="sex" class="control-label">Gender*</label> 
                                                                <select name="sex" id="sex" class="form-control">
                                                                   <option value="">Choose gender*</option>
                                                                   <option value="Female" <?php if ($memberdetails['gender'] == 'Female') echo "selected" ?>>Female</option>
                                                                   <option value="Male" <?php if ($memberdetails['gender'] == 'Male') echo "selected" ?>>Male</option>
                                                            </select> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="countrydiv"> 
                                                                <label for="country" class="control-label">Country*</label> 
                                                                <select name="country" id="country" class="form-control">
                                                                    <option value="">Choose country*</option>
                                                                    <?php
                                                                    foreach ($countrydetails as $row)
                                                                    {
                                                                    ?>
                                                                    <option value="<?php echo $row['nicename'] ?>" <?php if ($memberdetails['country'] == $row['nicename']) echo "selected" ?> ><?php echo $row['nicename'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select> 
                                                            </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group error" id="addressdiv"> 
                                                                <label for="address" class="control-label">Address</label> 
                                                                <textarea class="form-control" rows="5" name="address" id="address" placeholder="Address">
                                                                    <?php echo $memberdetails['address'] ?></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="row"> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="passworddiv"> 
                                                                <label for="password" class="control-label">Password</label> 
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="Leave empty if no changes"> 
                                                            </div> 
                                                        </div> 
                                                        <div class="col-md-6"> 
                                                            <div class="form-group error" id="confirmpassworddiv"> 
                                                                <label for="confirmpassword" class="control-label">Confirm password</label> 
                                                                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Leave empty if no changes"> 
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                </div> 
                                                <div class="modal-footer"> 
                                                    <button type="submit" class="btn btn-success waves-effect waves-light" id="profilesavebutton">Save changes</button> 
                                                    <button type="button" class="btn btn-danger waves-effect" id="profilereset">Reset</button> 
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div> 
                                            </form>
                                            </div> 
                                        </div>
                                    </div><!-- /.modal -->


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

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/custom.js"></script>




    </body>
</html>