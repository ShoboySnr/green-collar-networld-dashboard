<?php
require_once('admin/config.php');
require_once('admin/inc_dbfunctions.php');

$dataRead = New DataRead();
$dataWrite = New DataWrite();
$mycon = databaseConnect();
$currentuserid = getCookie("userid");

$memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);

//get the list of the those merged to pay
$mergeddonations = $dataRead->matching_transfer_getbyidmatchingstatus($mycon, '0', $memberdetails['member_id']);

if ($mergeddonations == null)
{
    $mergeddonations = $dataRead->matching_receive_getbyidmatchingstatus($mycon, '0', $memberdetails['member_id']);
}

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
                                               <button class='btn btn-danger btn-md waves-effect waves-light' data-toggle='modal' data-target=".r<?php echo $row['matching_id'] ?>">Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade r<?php echo $row['matching_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
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