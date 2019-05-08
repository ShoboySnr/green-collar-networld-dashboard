<?php
require_once('admin/config.php');
require_once('admin/inc_dbfunctions.php');

$dataRead = New DataRead();
$dataWrite = New DataWrite();
$mycon = databaseConnect();
$currentuserid = getCookie("userid");


$memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);

$donationdetails = $dataRead->donations_getbyid($mycon,$currentuserid);

$donationdetailsall = $dataRead->donation_getallrandom($mycon, '10');

$donationdetailsallconfirmed = $dataRead->donation_getallrandomconfirmed($mycon, '10');

//get the list of the those merged to pay
$mergeddonations = $dataRead->matching_transfer_getbyidmemeber($mycon, '5', $memberdetails['member_id']);

if ($mergeddonations == null)
{
    $mergeddonations = $dataRead->matching_receive_getbyidmemeber($mycon, '5', $memberdetails['member_id']);
}

//get all the received funds from the database
$receivedfundsall = $dataRead->receivefundsallrandom($mycon, '1');

//get the news details from the admin
$newsdetails = $dataRead->news_getall($mycon);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Wealth Fund Global Community - Earn 50% in 15 days on every fund you transfer to help another participants in ypur community.">
        <meta name="author" content="Wealth Fund Global">

        <link rel="shortcut icon" href="img/logo/logowfg.ico">

        <title>Dashboard - <?php echo pageTitle(); ?></title>


        <link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
        
        <link href="assets/plugins/custombox/css/custombox.css" rel="stylesheet">
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
                                <h4 class="page-title">Dashboard</h4>
                                <p class="text-muted page-title-alt">Welcome <?php echo getCookie("fullname") ?>!</p>
                            </div>
                        </div>

                        <?php

                        if ($newsdetails != null)
                        {
                        ?>
                        <div class="alert alert-warning" id="accountdetails_new">
                              You have a new message from the Admin, Wealth Fund Global
                              <div class="button-list">

                        <!-- Full width modal -->
                        <button class="btn btn-primary waves-effect waves-light" onclick="document.location.href='#news_section'">Click here to go news from admin section</button>
                    </div>
                          </div>
                      <?php
                      }
                      ?>
                        <?php

                        if ($memberdetails['picturestatus'] == '0')
                        {
                        ?>
                        <div class="alert alert-info" id="accountdetails_new">
                              You need to set up your profile picture.
                              <div class="button-list">

                        <!-- Full width modal -->
                        <button class="btn btn-primary waves-effect waves-light" onclick="document.location.href='profile.php'">Go to my personal account</button>
                    </div>
                          </div>
                      <?php
                      }
                      ?>
                         <?php

                      if ($memberdetails['accountdetail_id'] == '')
                      {
                      ?>
                       <div class="alert alert-info" id="accountdetails_new">
                                              You cannot transfer or receive any funds yet until you add your account details. 
                                              <div class="button-list">

                                        <!-- Full width modal -->
                                        <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add account details</button>
                                    </div>
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

                        <?php
                      }
                      else
                      {
                      ?>
                      <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0"><b>Funds Transfer/Receive </b></h4>
                                    <p class="text-muted m-b-30 font-13">
                                        Get started: To transfer fund, please click on 'Transfer Funds' Button and to receive funds please click on 'Receive Fund' Button.
                                    </p>
                                    
                                    <!-- sample modal content -->

                                    
                              <div id="transfer_funds" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title">Create a new transfer funds requests</h4> 
                                                </div> 
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="transferresult"></div>

                                                    <div class="row">
                                                         <div class="col-sm-12 col-lg-12 col-md-12">
                                                                <div class="panel panel-border panel-warning">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title">Transfer Fund Info</h3>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <p class="header-title text-left" style='font-family: Poppins;'>
                                                                           To transfer fund, select the amount to transfer in your local currency and the bank account to use. Then click save. You will be merged within 10 days with 
                                                                           another participants on this global network in your country. As soon as you are being merged, you will receive an email notification. Transfer funds to the participants and wait
                                                                           till the 15th day to be able to receive 50% increment of your funds transfered plus referral bonus if any. During this waiting period, your fund wallet will continue to grow till it reaches its maximum 50%.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group transfer error" id="amountdiv"> 
                                                                <label for="amount" class="control-label">Amount (in your local currency)*</label> 
                                                                <select name='amount' class='form-control' id='amount' onclick='customAmount(this);'  onchange='customAmount(this);'>
                                                                    <option value=''>choose amount</option>
                                                                    <option value='5000'>5000</option>
                                                                    <option value='10000'>10000</option>
                                                                    <option value='20000'>20000</option>
                                                                    <option value='50000'>50000</option>
                                                                    <option value='100000'>100000</option>
                                                                    <option value='200000'>200000</option>
                                                                    <option value='250000'>250000</option>
                                                                    <option value='500000'>500000</option>
                                                                    <option value='1000000'>1000000</option>
                                                                </select>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="row" id='custom_amount' style='display: none'> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group transfer error" id="amountcustomdiv"> 
                                                                <label for="amountcustom" class="control-label">Enter custom Amount (in your local currency)*</label> 
                                                                <input type="number" class="form-control" name="amountcustom" id="amountcustom" placeholder="Enter amount you want to recieve"> 
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12"> 
                                                            <div class="form-group transfer error" id="bankaccountsdiv"> 
                                                                <label for="bankaccounts" class="control-label">Bank Account to use*</label>
                                                                <select name='bankaccounts' id='bankaccounts' class='form-control'>
                                                                    <option value=''>choose bank accounts</option>
                                                                <?php
                                                                 $bankaccountdetails = $dataRead->bankaccountdetails($mycon,$currentuserid);
                                                                foreach ($bankaccountdetails as $row)
                                                                {
                                                                ?>
                                                                <option value="<?php echo $row['accountdetail_id'] ?>"><?php echo $row['bankaccountname']." - ".$row['bankaccountnumber'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                                </select>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group transfer error" id="passworddiv"> 
                                                                <label for="password" class="control-label">Enter your password*</label> 
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password to save changes"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="row"> 
                                                        <div class="col-md-12">
                                                            <div class="col-md-4">
                                                                <img src="captcha.php" height="35px" /><br>
                                                            </div><span class="visible-xs"><br></span>
                                                            <div class="col-md-8 form-group transfer error" id="captchadiv">
                                                                <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Enter Captcha code*"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="modal-footer"> 
                                                    <button type="button" class="btn btn-success waves-effect waves-light" id="transfersave">Save</button> 
                                                    <button type="button" class="btn btn-danger waves-effect" id="transfersavereset">Reset</button> 
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div> 
                                            </div> 
                                        </div>
                                    </div><!-- /.modal -->

                                    <div id="receive_funds" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title">Create a new receive funds requests</h4> 
                                                </div> 
                                                <div class="modal-body">
                                                    <p class="text-left text-primary is-required">* is required </p>
                                                    <div id="receiveresult"></div>

                                                    <div class="row">
                                                         <div class="col-sm-12 col-lg-12 col-md-12">
                                                                <div class="panel panel-border panel-warning">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title">Receive Fund Info</h3>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <p class="header-title text-left" style='font-family: Poppins;'>
                                                                           To Receive fund, type the amount to receive in your local currency and the bank account to use. Then click save. You will be merged within 24 hours with 
                                                                           another participants on this global network in your country. As soon as you are merged, you will receive an email notification. You don't have to force the person to pay you. The Payer will also be notified of his/her transfer order.
                                                                           Confirm the person immediately you receive funds in your bank accounts. Then don't forget to write your testimony. Your Testimony helps us to grow this community 
                                                                           and you also benefits as this global community grows. Thanks
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group receive error" id="amountreceivediv"> 
                                                                <label for="amountreceive" class="control-label">Amount (in your local currency)*</label> 
                                                                <input type="text" class="form-control" name="amountreceive" id="amountreceive" placeholder="Enter amount you want to recieve"> 
                                                                <br> <button type="button" class="btn btn-success waves-effect" id="withdrawall">Withdraw all</button></br> 
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-12"> 
                                                            <div class="form-group receive error" id="bankaccountsreceivediv"> 
                                                                <label for="bankaccountsreceive" class="control-label">Bank Account to use*</label>
                                                                <select name='bankaccountsreceive' id='bankaccountsreceive' class='form-control'>
                                                                    <option value=''>choose bank accounts</option>
                                                                <?php
                                                                 $bankaccountdetails = $dataRead->bankaccountdetails($mycon,$currentuserid);
                                                                foreach ($bankaccountdetails as $row)
                                                                {
                                                                ?>
                                                                <option value="<?php echo $row['accountdetail_id'] ?>"><?php echo $row['bankaccountname']." - ".$row['bankaccountnumber'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                                </select>
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group receive error" id="passwordreceivediv"> 
                                                                <label for="passwordreceive" class="control-label">Enter your password*</label> 
                                                                <input type="password" class="form-control" name="passwordreceive" id="passwordreceive" placeholder="Enter password to save changes"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <hr>


                                                    <div class="row"> 
                                                        <div class="col-md-12">
                                                            <div class="col-md-4">
                                                                <img src="captcha.php" height="35px" /><br>
                                                            </div><span class="visible-xs"><br></span>
                                                            <div class="col-md-8 form-group receive error" id="captchareceivediv">
                                                                <input type="text" class="form-control" name="captchareceive" id="captchareceive" placeholder="Enter Captcha code*"> 
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="modal-footer"> 
                                                    <button type="button" class="btn btn-success waves-effect waves-light" id="receivesave">Save</button> 
                                                    <button type="button" class="btn btn-danger waves-effect" id="receivesavereset">Reset</button> 
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div> 
                                            </div> 
                                        </div>
                                    </div><!-- /.modal -->

                                    <div class="button-list text-center">
                                        <!-- Custom width modal -->
                                        
                                            <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#transfer_funds" style='width: 40%; height: 90px; font-size: 35px'>Transfer Funds</button>
                                            <span class='visible-xs'><br><br></span>
                                            <button class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#receive_funds" style='width: 40%; height: 90px; font-size: 35px'>Receive Funds</button>
                                    </div>
                                    <div class='row' style='padding-top: 40px'>
                                       <div id="fundresult"></div>
                                    <div class="col-sm-8 col-lg-8 col-md-8">
                                    <div class="panel panel-success panel-border">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Funds Requests Matching</h3>
                                        </div>
                                         <div class="form-group ">
                                        <div class='row'>
                                            <div class="col-xs-9 col-md-9 matching error" id="sortmatchingdiv">
                                            <select name="sortmatching" id="sortmatching" class="form-control">
                                                   <option value="All">All </option>
                                                   <option value="5">Matched</option>
                                                   <option value="3">Pending</option>
                                                   <option value="0">Confirmed</option>
                                            </select>
                                            </div>
                                            <div class="col-md-3 col-xs-3 error">
                                                <button class="btn btn-primary btn-md waves-effect waves-light"  id="sortmatchingbutton" type="button">
                                                Sort!
                                                </button>
                                            </div>
                                        </div> 
                                    </div>
                                        <div class="panel-body" id='matching_id'>
                                            <?php
                                            $count = 0;
                                            foreach($mergeddonations as $row)
                                            {
                                                $transferdetails = $dataRead->member_getbyid($mycon, $row['transfer_id']);
                                                $receiverdetails = $dataRead->member_getbyid($mycon, $row['receive_id']);
                                                $receiverbankaccoutdetails = $dataRead->bankaccountdetails_getbyid($mycon,$row['accountdetail_id']);
                                            
                                            ?>

                                            <div class='portlet' id='matchingfund'>
                                    <div class="portlet-heading <?php if ($row['matchingstatus'] == '5' || $row['matchingstatus'] == '3') echo 'bg-primary'; else if($row['matchingstatus'] == '4') echo "bg-danger"; else echo 'bg-success'; ?>">
                                        <h3 class='portlet-title'>
                                           <?php if ($row['matchingstatus'] == '5') echo "New"; else if($row['matchingstatus'] == '3') echo "Pending"; else if($row['matchingstatus'] == '4') echo "Flagged"; else echo "Completed"; ?> Match
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="javascript:void(0);" onclick="refreshMatchingFund(<?php echo $row['matching_id'] ?>)" data-toggle="reload"><i class="ion-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary<?php echo $row['matching_id'] ?>"><i class="ion-minus-round"></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div id='bg-primary<?php echo $row['matching_id'] ?>' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <?php 
                                            if ($row['matchingstatus'] == '5') 
                                            {
                                                ?>
                                            <p>Status: No Evidence Uploaded</p>
                                            <div class="text-center">
                                                 <div class="progress">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                                    <span class="sr-only">25% Complete</span>
                                                </div>
                                            </div>
                                            </div>
                                            <?php
                                            }
                                            else if ($row['matchingstatus'] == '3') 
                                            {
                                                ?>
                                            <p>Status: <a href='evidence/<?php echo $row['matching_id'] ?>.jpg' target='_blank' style='color: #FF0000; text-decoration: underline'> View Evidence </a> </p>
                                            <div class="text-center">
                                                 <div class="progress">
                                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                    <span class="sr-only">50% Complete</span>
                                                </div>
                                            </div>
                                            </div>
                                            <?php
                                                }
                                            else if ($row['matchingstatus'] == '0')
                                            {
                                                ?>
                                            <p>Status: Confirmed</p>
                                            <div class="text-center">
                                                 <div class="progress">
                                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                                    <span class="sr-only">100% Complete</span>
                                                </div>
                                            </div>
                                            </div>
                                            <?php
                                            }
                                            else if ($row['matchingstatus'] == '4')
                                            {
                                                ?>
                                            <p>Status: Flagged</p>
                                            <div class="text-center">
                                                 <div class="progress">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                                                    <span class="sr-only">10% Complete</span>
                                                </div>
                                            </div>
                                            </div>
                                            <?php
                                            } 
                                            ?>
                                            <div class="chat-conversation" style="height: 300px">
                                            <ul class="conversation-list nicescroll">
                                                <li class="clearfix">
                                                <div class="chat-avatar">
                                                    <img src="member_image/<?php if ($transferdetails['picturestatus'] != '1') echo 'avatar.png'; else echo $transferdetails['username'].'.jpg' ?>" alt="<?php echo $transferdetails['username'] ?>">
                                                    <i><?php echo formatDate($row['thedate']) ?></i>
                                                </div>
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <i><?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?></i>
                                                        <p>
                                                           You are to receive <?php echo $row['amount'] ?> fund from me.
                                                        </p>
                                                        <p> 
                                                            Phone number: <?php echo $transferdetails['phonenumber'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                             <li class="clearfix odd">
                                                <div class="chat-avatar">
                                                    <img src="member_image/<?php if ($receiverdetails['picturestatus'] != '1') echo 'avatar.png'; else echo $receiverdetails['username'].'.jpg' ?>" alt="<?php echo $receiverdetails['username'] ?>">
                                                    <i><?php echo formatDate($row['thedate']) ?></i>
                                                </div>
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <i><?php echo $receiverdetails['lastname']." ".$receiverdetails['firstname'] ?></i>
                                                        <p>
                                                          Here are my account details<br>
                                                          Account Name: <?php echo $receiverdetails['bankaccountname'] ?><br>
                                                          Bank Name: <?php echo $receiverdetails['bankname'] ?><br>
                                                          Bank Account Number: <?php echo $receiverdetails['bankaccountnumber'] ?>
                                                        </p>
                                                        <p> Phonenumber: <?php echo $receiverdetails['phonenumber'] ?> </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <?php
                                        if ($row['matchingstatus'] == '5')
                                        {
                                        ?>
                                        <div class="text-left">
                                             <h5 style="color: #FF0000; font-weight: bolder">Expire: <?php $expirydate = formatDate(date("Y-m-d H:i:s", strtotime($row['expirydate']) - strtotime("Y-m-d H:i:s")), "yes");
                                                //Calculate difference
                                            $diff= strtotime($expirydate)-time();//time returns current time in seconds
                                            $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
                                            $hours=round(($diff-$days*60*60*24)/(60*60)); 
                                            echo $days." days. " .$hours. " hours";
                                            ?></h5>
                                        
                                        </div>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                            <hr>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-md waves-effect waves-light' data-toggle='modal' data-target=".r<?php echo ++$count ?>">Details</button>
                                            </div>
                                        </div>
                                        <div class="modal fade r<?php echo $count ?>" tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-lg'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>New matched details</h4>
                                            </div>
                                                <div class='modal-body'>
                                                    <p>You have been martched! <?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?> is to transfer the sum total of 
                                                        <?php echo $row['amount'] ?> to <?php echo $receiverdetails['lastname']." ".$receiverdetails['firstname'] ?>. </p>
                                                    <p><span style='color: #FF0000; font-weight: bold'><i class='md md-file-upload'></i> <?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?>'s details:</span> <br />
                                                        Fullname: <?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?><br />
                                                        Phonenumber: <?php echo $transferdetails['phonenumber'] ?><br />
                                                        Email: <?php echo $transferdetails['email'] ?><br />
                                                        Gender: <?php echo $transferdetails['gender'] ?><br />
                                                        Country: <?php echo $transferdetails['country'] ?>
                                                    </p>
                                                    <p><span style='color: #FF0000; font-weight: bold'><i class='md md-file-download'></i> <?php echo $receiverdetails['lastname']." ".$receiverdetails['firstname'] ?>'s details:</span> <br />
                                                        Fullname: <?php echo $receiverdetails['lastname']." ".$receiverdetails['firstname'] ?><br />
                                                        Account Name: <?php echo $receiverdetails['bankaccountname'] ?><br/>
                                                        Bank Name: <?php echo $receiverdetails['bankname'] ?><br />
                                                        Bank Account Number: <?php echo $receiverdetails['bankaccountnumber'] ?><br />
                                                        Phonenumber: <?php echo $receiverdetails['phonenumber'] ?><br />
                                                        Gender: <?php echo $receiverdetails['gender'] ?><br />
                                                        Country: <?php echo $receiverdetails['country'] ?><br />
                                                    </p>
                                                    </p>
                                                    <p>It can happen that either of the two party can forget that they have been matched. So <?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?> can 
                                                        call <?php echo $receiverdetails['lastname']." ".$receiverdetails['firstname'] ?> through <?php if ($receiverdetails['gender'] == 'Male') echo "his"; else echo "her" ?>
                                                        contact number <?php echo $receiverdetails['phonenumber'] ?>, also <?php echo $receiverdetails['lastname']." ".$receiverdetails['firstname'] ?> can call
                                                        <?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?>  through <?php if ($receiverdetails['gender'] == 'Male') echo "his"; else echo "her" ?>
                                                        contact number <?php echo $transferdetails['phonenumber'] ?>. </p>
                                                    <P><strong>Pleae Note: These calls is not to force your matched participants but only to remind them of their request order. Hence do not disturb them with your calls. Any participants
                                                        that fails to responds to their order before the expiry date and time will be blocked automatically. Therefore, if you are to matched to transfer, please do so as quick as possible. If you are to
                                                        receive funds, as soon as the funds gets into your bank accounts confirm the sender. There's no need to delay anyone. </strong></p>
                                                    <p style='color: #FF0000'>
                                                        <?php if (isset($expirydate) && $row['matchingstatus'] != '5' && $row['matchingstatus'] != '4') echo "Expiry: ".$expirydate; ?></p>
                                                  <p>Status: <?php if ($row['matchingstatus'] == '5') echo "No Evidence Uploaded"; else if ($row['matchingstatus'] == '3') echo "<a href='evidence/".$row['matching_id'].".jpg' target='_blank' style='color: #FF0000; font-decoration: underline'> view Evidence </a>";
                                                  else if ($row['matchingstatus'] =='0') echo 'Confirmed'; else echo 'Flagged' ?></p><br><br>
                                                    <?php if ($row['transfer_id'] == $currentuserid && $row['matchingstatus'] == '5')
                                                    {
                                                    ?>
                                                    <iframe name="actionframe" id="actionframe" width="1px" height="1px" frameborder="0"></iframe> 
                                                    <form action='admin/actionmanager.php' method='post' id='evidenceform' target="actionframe" enctype="multipart/form-data">
                                                        <div class="matchingpaid" id="<?php echo $row['matching_id'] ?>"></div>
                                                        <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group paid error" id="amountpaiddiv"> 
                                                                <label for="amountpaid" class="control-label">Amount Paid*</label> 
                                                                <input type="text" class="form-control" name="amountpaid" id="amountpaid" placeholder="Enter amount you paid">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group paid error" id="uploadevidencediv"> 
                                                                <label for="uploadevidence" class="control-label">Upload Evidence*</label> 
                                                                <input type="file" class="form-control" name="uploadevidence" id="uploadevidence">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer"> 
                                                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                                        <input type='hidden' name='command' id='command' value='evidence_add'>
                                                        <input type='hidden' name='matching_id' id='matching_id' value="<?php echo $row['matching_id'] ?>">
                                                        <button type="button" class="btn btn-danger waves-effect" id="paidresetbutton">Reset</button> 
                                                        <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                    </div> 
                                                    </form>
                                                    <?php
                                                    }
                                                    else if ($row['receive_id'] == $currentuserid && $row['matchingstatus'] != '0' && $row['matchingstatus'] != '4')
                                                    {
                                                    ?>
                                                    <p>Are you sure you want to perform operation on <span class='extendmatching' id="<?php echo $row['matching_id'] ?>"><?php echo $transferdetails['lastname']." ".$transferdetails['firstname'] ?>? </span></p>
                                                    <div id="matchingextend<?php echo $row['matching_id'] ?>" ></div>
                                                    <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group extend error" id="extendpassworddiv<?php echo $row['matching_id'] ?>"> 
                                                                <label for="extendpassword" class="control-label">Enter your password*</label> 
                                                                <input type="password" class="form-control" name="extendpassword" id="extendpassword<?php echo $row['matching_id'] ?>" placeholder="Enter password to save changes">
                                                                <input type="hidden" class="form-control" name="command" id="command<?php echo $row['matching_id'] ?>" value="<?php echo $row['matching_id'] ?>">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class='text-center'>
                                                        <div class="button-list">
                                                            <button type="button" class="btn btn-success btn-custom btn-rounded waves-effect waves-light" id="confirmbutton<?php echo $row['matching_id'] ?>" onclick="confirm(<?php echo $row['matching_id'] ?>);"><i class='fa fa-check'></i> Confirm Payment</button>    
                                                            <button type="button" class="btn btn-primary btn-custom btn-rounded waves-effect" id="extendbutton<?php echo $row['matching_id'] ?>" onclick="extend(<?php echo $row['matching_id'] ?>);"><i class='fa fa-sign-out'></i> Extend by 24 hours</button>
                                                            <button type="button" class="btn btn-danger btn-custom btn-rounded waves-effect waves-light" id="falsepaymentbutton<?php echo $row['matching_id'] ?>" onclick="falsePayment(<?php echo $row['matching_id'] ?>);">
                                                                <i class='fa fa-times'></i> False Payment</button>
                                                            <button type="button" class="btn btn-info btn-custom btn-rounded waves-effect waves-light" data-dismiss="modal">Dismiss</button>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                     ?>
                                                     <button type="button" class="btn btn-info btn-custom btn-rounded waves-effect waves-light" data-dismiss="modal">Dismiss</button>
                                                     <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                    ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-lg-4 col-md-4">
                                    <div class="panel panel-success panel-border">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Funds Requests Order</h3>
                                        </div>          
                                    <div class="form-group ">
                                        <div class='row'>
                                            <div class="col-xs-8 col-md-8 sort error" id="sortfunddiv">
                                            <select name="sortfund" id="sortfund" class="form-control">
                                                   <option value="5">Pending</option>
                                                   <option value="3">Matched </option>
                                                   <option value="0">Confirmed </option>
                                            </select>
                                            </div>
                                            <div class="col-md-4 col-xs-4 error">
                                                <button class="btn btn-primary btn-md waves-effect waves-light"  id="sortfundbutton" type="button">
                                                Sort!
                                                </button>
                                            </div>
                                        </div> 
                                    </div>
                                        <div class="panel-body"  id='order_id'>
                                            <?php
                                            foreach($donationdetails as $row)
                                            {
                                            ?>
                                                <div class='portlet' id='transferfund<?php echo $row['donation_id'] ?>'>
                                                    <?php 
                                                        if ($row['status'] == '5')
                                                    {
                                                    ?>
                                    <div class='portlet-heading bg-primary'>
                                        <h3 class='portlet-title'>
                                           New Requests
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="javascript:void(0);" onclick="refreshTransferFund(<?php echo $row['donation_id'] ?>);" data-toggle="reload"><i class="ion-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary<?php echo $row['donation_id'] ?>"><i class="ion-minus-round"></i></a>
                                            <span class="divider"></span>
                                            <a href="javascript:void(0);" onclick="deleteTransferFund(<?php echo $row['donation_id'] ?>);"><i class="ion-close-round"></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div id='bg-primary<?php echo $row['donation_id'] ?>' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> You created a new <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?> fund request order.</p>
                                            <p> Amount: <?php if ($row['donation_ph'] != '') echo $row['donation_ph']; else echo $row['donation_gh']; ?></p>
                                            <hr>
                                            <p> Status: Pending</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target=".<?php echo $row['donation_id'] ?>">Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade <?php echo $row['donation_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>
                                            </div>
                                                <div class='modal-body'>
                                                  <p>You have created a new <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?> fund request order</p>
                                                  <p>Amount to <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?>: <?php if ($row['donation_ph'] != '') echo $row['donation_ph']; else echo $row['donation_gh']; ?></p>
                                                  <p>Please wait patiently as we find another participants for you. Thanks</p>
                                                  <p>Status: Pending</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    else if ($row['status'] == '3')
                                    {
                                    ?>
                                    <div class='portlet-heading bg-danger'>
                                        <h3 class='portlet-title'>
                                           Matched Request
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="javascript:void(0);" onclick="refreshTransferFund(<?php echo $row['donation_id'] ?>);" data-toggle="reload"><i class="ion-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary<?php echo $row['donation_id'] ?>"><i class="ion-minus-round"></i></a>
                                            <span class="divider"></span>
                                            <a href="javascript:void(0);" onclick="deleteTransferFund(<?php echo $row['donation_id'] ?>);"><i class="ion-close-round"></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div id='bg-primary<?php echo $row['donation_id'] ?>' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been matched.</p>
                                            <p> Amount: <?php if ($row['donation_ph'] != '') echo $row['donation_ph']; else echo $row['donation_gh']; ?></p>
                                            <hr>
                                            <p> Status: Matched</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target=".<?php echo $row['donation_id'] ?>">Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade <?php echo $row['donation_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Matched request details</h4>
                                            </div>
                                                <div class='modal-body'>
                                                  <p>Your <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?> order has been processed. You have been matched to <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?>.</p>
                                                  <p>Amount to <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?>: <?php if ($row['donation_ph'] != '') echo $row['donation_ph']; else echo $row['donation_gh']; ?></p>
                                                  <p>You have been matched with another participants. Please attend to your <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?> order request.</p>
                                                  <p>Status: Matched</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    else if ($row['status'] == '0')
                                    {
                                    ?>
                                    <div class='portlet-heading bg-success'>
                                        <h3 class='portlet-title'>
                                           Confirm Requests
                                        </h3>
                                        <div class="portlet-widgets">
                                            <a href="javascript:void(0);" onclick="refreshTransferFund(<?php echo $row['donation_id'] ?>);" data-toggle="reload"><i class="ion-refresh"></i></a>
                                            <span class="divider"></span>
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary<?php echo $row['donation_id'] ?>"><i class="ion-minus-round"></i></a>
                                            <span class="divider"></span>
                                            <a href="javascript:void(0);" onclick="deleteTransferFund(<?php echo $row['donation_id'] ?>);"><i class="ion-close-round"></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div id='bg-primary<?php echo $row['donation_id'] ?>' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been confirmed.</p>
                                            <p> Amount: <?php if ($row['donation_ph'] != '') echo $row['donation_ph']; else echo $row['donation_gh']; ?></p>
                                            <hr>
                                            <p> Status: Confirmed</p>
                                            <div class='text-right'>
                                                <?php if ($row['testimonialstatus'] == '1' && $row['donation_gh'] != '') 
                                                {
                                                ?>
                                                <button class='btn btn-success btn-xs waves-effect waves-light' data-toggle='modal' data-target=".t<?php echo $row['donation_id'] ?>"><i class='fa fa-warning'></i> Upload testimony</button>
                                                <?php
                                                }
                                                elseif ($row['testimonialstatus'] == '5' && $row['donation_gh'] != '')
                                                {
                                                ?>
                                                
                                                <button class='btn btn-success btn-xs waves-effect waves-light'><i class='fa fa-check'></i> Testimony saved</button>
                                                <?php
                                                }
                                                ?>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target=".<?php echo $row['donation_id'] ?>">Details</button>
                                            </div>
                                        </div>
                                    </div>
                                        <div class='modal fade <?php echo $row['donation_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Confirmed request details</h4>
                                            </div>
                                                <div class='modal-body'>
                                                  <p>Your <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?> order has been confirmed. </p>
                                                  <p>Amount to <?php if ($row['donation_ph'] != '') echo 'transfer'; else echo 'receive'; ?>: <?php if ($row['donation_ph'] != '') echo $row['donation_ph']; else echo $row['donation_gh']; ?></p>
                                                  <p>Your order has been sucessfully confirmed by your matched participants. Thank you!</p>
                                                  <p>Status: Confirmed</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal fade t<?php echo $row['donation_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-lg'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Upload Testimony</h4>
                                            </div>
                                                <div class='modal-body'>
                                                  <h3> You received a sum of <?php echo $row['donation_gh'] ?> in your last receive request order. Please write a testimony letter to help us grow this community.
                                                    A testimony letter should contain the following: </h3>
                                                    <p><ol>
                                                            <li>Your Name e.g Linda Flemmings</li>
                                                            <li>Your location e.g Texas, United States</li>
                                                            <li>The last date you made a transfer request order and the amount </li>
                                                            <li>The date you received payment. </li>
                                                            <li>And the amount received. </li>
                                                        </ol></p>
                                                    <p> For example, <br>
                                                        <span style='color: #FF0000; font-weight: bold'>My Name is Linda Flemmings and i live in Texas, United State. I made a transfer request order on the 20th April, 2016 with the sum of 5000 and I received
                                                        the sum of 8000 on the 5th of May, 2016. Thanks to Wealth Fund Global! </span></p>
                                                        <div id="testimonyresult<?php echo $row['donation_id'] ?>" ></div>
                                                        <div class="row"> 
                                                        <div class="col-md-12"> 
                                                            <div class="form-group testimony error" id="testimonydiv<?php echo $row['donation_id'] ?>"> 
                                                                <label for="testimony" class="control-label">Testimony letter</label> 
                                                                <textarea class="form-control" name="testimnony" id="testimony<?php echo $row['donation_id'] ?>" rows="5" placeholder="Write testimony letter here..."></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class='text-center'>
                                                        <div class="button-list">
                                                            <button type="button" class="btn btn-success btn-custom waves-effect waves-light" id="testimonybutton<?php echo $row['donation_id'] ?>" onclick="testimony(<?php echo $row['donation_id'] ?>);"><i class='fa fa-check'></i> Save</button> 
                                                            <button type="button" class="btn btn-info btn-custom waves-effect waves-light" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                   </div>
                                            <?php
                                            }
                                            ?>

                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                      <?php
                        }
                        ?>
                      <div class="row">

                            <div class="col-lg-4">
                            <div class="card-box">
                              <h4 class="text-dark header-title m-t-0">Transfer Funds</h4>

                              <div class="text-center custom_height">
                                    <?php
                                            foreach($donationdetailsall as $row)
                                            {
                                            ?> 
                                    <div class="comment">
                                        <img src="member_image/<?php if ($row['picturestatus'] == '0') echo 'avatar.png'; else echo $row['username'].'.jpg'; ?>" alt="<?php echo $row['username'] ?>_photo" class="comment-avatar">
                                        <div class="comment-body">
                                            <div class="comment-text">
                                                <div class="comment-header">
                                                    <a href="#" title=""><?php echo $row['username']; ?></a><span>on <?php echo formatDate($row['donationcreated'], "yes") ?></span>
                                                </div>
                                                <div class="m-t-15">
                                                    <p>Amount: <?php if ($row['username'] == 'omowunmi' || $row['username'] == 'Alios') echo ($row['donation_ph'] + 40000); else echo $row['donation_ph'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    </div>

                            </div>

                            </div>
                            <div class="col-lg-4">
                            <div class="card-box">
                              <h4 class="text-dark header-title m-t-0">Confirmed Funds</h4>

                              <div class="text-center custom_height">
                                <?php 
                                    foreach($donationdetailsallconfirmed as $row)
                                    {
                                        if ($row['random_match'] != '1')
                                        {
                                ?>
                                    <div class="comment">
                                        <img src="member_image/<?php if ($row['picturestatus'] == '0') echo 'avatar.png'; else echo $row['username'].'.jpg'; ?>" alt="<?php echo $row['username'] ?>_photo" class="comment-avatar">
                                        <div class="comment-body">
                                            <div class="comment-text">
                                                <div class="comment-header">
                                                    <a href="#" title=""><?php echo $row['username'] ?></a><span>on <?php echo formatDate($row['donationcreated'], "yes") ?></span>
                                                </div>
                                                <div class="m-t-15">
                                                    <p>Amount: <?php echo $row['donation_ph'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                }
                                ?>
                                    </div>  

                            </div>

                            </div>
                             <div class="col-lg-4">
                            <div class="card-box">
                              <h4 class="text-dark header-title m-t-0">Recieved Funds</h4>

                              <div class="text-center custom_height">
                                         <?php
                                            foreach($receivedfundsall as $row)
                                            {
                                                if ($row['random_match'] != '1')
                                                {
                                            ?> 
                                    <div class="comment">
                                        <img src="member_image/<?php if ($row['picturestatus'] == '0') echo 'avatar.png'; else echo $row['username'].'.jpg'; ?>" alt="<?php echo $row['username'] ?>_photo" class="comment-avatar">
                                        <div class="comment-body">
                                            <div class="comment-text">
                                                <div class="comment-header">
                                                    <a href="#" title=""><?php echo $row['username'] ?></a><span>on <?php echo formatDate($row['matchingcreatedon'], "yes") ?></span>
                                                </div>
                                                <div class="m-t-15">
                                                    <p>Amount: <?php echo $row['amount'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </div>
                                    

                            </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                            <div class="card-box">
                              <h4 class="text-dark header-title m-t-0">Testimonies</h4>

                              <div class="text-center">
                                        
                                    </div>

                                    

                            </div>

                            </div>
                            <div class="col-lg-6" id="news_section">
                            <div class="card-box">
                              <h4 class="text-dark header-title m-t-0">News from Admin</h4>
                                <?php
                                            foreach($newsdetails as $row)
                                            {
                                            ?> 
                                    <div class="comment">
                                        <img src="assets/images/users/avatar-4.jpg" alt="Admin_photo" class="comment-avatar">
                                        <div class="comment-body">
                                            <div class="comment-text">
                                                <div class="comment-header">
                                                    <a href="#" title="">Administrator</a><span>on <?php echo formatDate($row['thedate'], "yes") ?></span>
                                                </div>
                                                <div class="m-t-15">
                                                    <p style="font-weight: bolder"><?php echo $row['title'] ?></p>
                                                    <p  style='font-weight: normal'><?php echo substr($row['content'], 0, 100) ?></p>
                                                    <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#news<?php echo $row['new_id'] ?>">View</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="news<?php echo $row['new_id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog"> 
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                    <h4 class="modal-title" style="text-transform: uppercase"><?php echo $row['title'] ?></h4> 
                                                </div> 
                                                <div class="modal-body">
                                                    <p><?php echo $row['content'] ?>...</p>
                                                </div> 
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                                                </div> 
                                            </div> 
                                        </div>
                                    </div><!-- /.modal -->
                                    <?php
                                    }
                                    ?>
                                    </div>

                                    

                            </div>

                            </div>
                        </div>


                    </div> <!-- container -->

                </div> <!-- content -->

               <?php 
               include_once('inc_footer.php'); 
               ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


  

        </div>
        <!-- END wrapper -->



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

         <!-- Modal-Effect -->
        <script src="assets/plugins/custombox/js/custombox.min.js"></script>
        <script src="assets/plugins/custombox/js/legacy.min.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/custom.js"></script>




    </body>
</html>