<?php
require_once("admin/inc_dbfunctions.php");


function databaseConnect()
{
    require("admin/connectionstrings.php");


    $mycon = new PDO("mysql:host=$MYSQL_Server;dbname=$MYSQL_Database;charset=utf8", "$MYSQL_Username", "$MYSQL_Password"); 
    $mycon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mycon->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);    
    return $mycon;
}


function sendEmail($email,$subject,$message)
{
    //$sender = "Imo State Security Service<noreply@iss.zoracom.com>";
    $sent = mail($email,$subject,$message, "From: Wealth Fund Global <noreply@wealthfundglobal.com>"."\r\n"."Content-type: text/html; charset=iso-8859-1","-fwebmaster@".$_SERVER["SERVER_NAME"]);
    if($sent) return true;
    return false;
}



$mycon = databaseConnect();

Fundgrowth();

NewReceiver();

addFundBonus();

addReceiveAmount();

//matching();

membersBlock();

matchLeftover();


sendEmailParticipants();

failedParticipants();

//amountReferralReceivable();

//GROWTH FOR FUND
function Fundgrowth()
{
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();
    $mycon = databaseConnect();



    //find all donations ph 
    $findalldonations = $dataRead->donations_getall($mycon);
    
    foreach ($findalldonations as $row)
    {
        //$timedifference = (strtotime($row['createdon']) - strtotime(date("Y-m-d, H:i:s")));
        //var_dump($timedifference);
        //strtotime(date("Y-m-d H:i:s"), strtotime("+ 30 days"));
         if ((strtotime($row['readydonation_gh']) >= strtotime(date("Y-m-d H:i:s"))))
            {
                $countdays = intval(abs(strtotime($row['readydonation_gh']) - strtotime(date("Y-m-d H:i:s")))/86400);
                $datenow = date("d") + date("d", strtotime($row['createdon']));
                $totaldonation_ph = ($row['donation_ph'] + (($row['donation_ph'] * 0.5 * (15 - $countdays))/15));
                //update the growth colum for the donation table
                $growthupdate = $dataWrite->donations_growthupdate($mycon, $row['donation_id'], ceil($totaldonation_ph));
                if (!$growthupdate)
                {
                    echo false;
                }
                else echo true;
            } else
            {
                $totaldonation_ph = ($row['donation_ph'] * 0.5) + $row['donation_ph'];
                //update the growth colum for the donation table
                $growthupdate = $dataWrite->donations_growthupdate($mycon, $row['donation_id'], $totaldonation_ph);
                
            }

    }

}


function NewReceiver()
{
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();
    $mycon = databaseConnect();

    //find all donations that has been confirmed with status of 0
    $donationsall = $dataRead->donations_getall($mycon);
    $totalbalance = 0;
    foreach($donationsall as $row)
    {
        //check if the member already exists in the donations receivable table
        $membercheck = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
        
        if ($membercheck == null)
        {
            //add new member to the donations receivable column
            $addmember = $dataWrite->donationsreceivable_add($mycon, $row['member_id'], '0', '0', '0');
            if (!$addmember) 
            {
                echo false;
            }
        }
    }
    return;
}

function addFundBonus()
{
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();
    $mycon = databaseConnect();

    $membersall = $dataRead->member_getbyall($mycon);
    $totalamount = 0;
    foreach($membersall as $row)
    {
        $zerobalance = $dataWrite->donationsreceivable_updatezero($mycon, $row['member_id'], '0', '0', '0');
        //var_dump($zerobalance);  
    }
    
    
    foreach($membersall as $row)
    {
        //get each donation requests
        $donationrequests = $dataRead->donations_getidmember($mycon,$row['member_id']);

        foreach($donationrequests as $donation)
        {
            if ($donationrequests != null &&  $donation['status'] == '0') //for those status already confirmed and already set to receive help
            {
               //find the donations receivable
                $membercheck = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                //update the fund in wallet
                if ($membercheck['amount'] >= 0)
                {
                    $balance = ($donation['donation_ph'] * 0.5) + $donation['donation_ph'] + $membercheck['amount'] - $membercheck['withdrawn'];
                    $updatefund = $dataWrite->donationsreceivable_update($mycon, $membercheck['member_id'], ($donation['donation_ph'] * 0.5) + $donation['donation_ph'] + $membercheck['amount'], $balance);


                }
                

            }    
        }
        
    }

        foreach($membersall as $row)
            {
                //get each donation requests
                $donationrequests = $dataRead->donations_getidmember($mycon,$row['referral_id']);
                foreach($donationrequests as $donation)
                {
                    if ($donationrequests != null &&  $donation['status'] == '0')
                    {
                       //find the donations receivable
                        $memberdonations = $dataRead->donations_getbyidreferral($mycon, $row['member_id']);
                        
                        //update the fund in wallet
                        if ($memberdonations['donation_ph'] >= 0 && $memberdonations['donation_ph'] != null)
                        {
                            //find the donations receivable
                            $membercheck = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']); 
                            $referralbonus = ($memberdonations['donation_ph'] * 0.1);
                            $referralbalance =  $membercheck['balance'] + $referralbonus;
                            $updatefund = $dataWrite->donationsreceivable_update($mycon, $membercheck['referral_id'], $membercheck['amount'] + $referralbonus, $referralbalance);

                        }
                        

                    }    
                }
                
            }

}



function addReceiveAmount()
{
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();
    $mycon = databaseConnect();

    //get all the receive fund request that has been merged i,e status of 3 and matched status of 5
    $fundrequestall = $dataRead->receivefundrequestall($mycon);
    var_dump($fundrequestall);
    //var_dump($fundrequestall);
    foreach($fundrequestall as $row)
    {
        //find the receive donation by member
        $memberfind = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
        //update the amount
        $updateamount = $dataWrite->donationsreceivable_updatewithdrawn($mycon, $row['member_id'], $memberfind['withdrawn'] + $row['donation_gh'], $memberfind['amount'] - $row['donation_gh']);

    }
}


function matching()
{
    $dataRead = New DataRead();
    $dataWrite = New DAtaWrite();
    $mycon = databaseConnect();

    //get the new donation request with status of 5 and matchedstatus of 0 and member status equal to 0
    $receivefundall = $dataRead->receiefundrequestall($mycon, '5', '0', '0');

    $totalamountreceivable = 0;
    $amount = 0;
    $difference = 0;
    
    
    foreach ($receivefundall as $row)
    {
        $receivefundperson_id = $row['donation_id'];
        //get the amount in the receivable donations
        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
        $totalamountreceivable = $donationsreceivable['withdrawn'];


        //get the list of all the  active donations that are at least 3 days and matched status of 0, status of 5 and memberstatus of 0
        $thedate = date("Y-m-d H:i:s", strtotime("- 5 days"));
        $activetransferdonations = $dataRead->activetransferdonations($mycon, '5', '0', '0', $row['member_id'], $row['country']);
        var_dump($activetransferdonations);

        //update the matching table
        //check if the matching falls on  weekend
        if (date('D') == 'Fri' || date('D') == 'Sat')
        $expirydate = date("Y-m-d H:i:s", strtotime("+ 48 hours"));
        else $expirydate = date("Y-m-d H:i:s", strtotime("+ 36 hours"));
        //$mycon->beginTransaction();
        foreach ($activetransferdonations as $transfer)
        {
            //get the amount in the receivable donations
            $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
            $totalamountreceivable = $donationsreceivable['withdrawn'];
            var_dump($totalamountreceivable);
            var_dump($amount);
            if ($amount != 0 || $totalamountreceivable > 0)
        {
           if (strtotime($transfer['createdon']) <= strtotime($thedate) && $totalamountreceivable != 0 && $transfer['status'] == '5')
            {
                    if ($totalamountreceivable == $transfer['donation_ph'] && $transfer['leftover_id'] == 0 && $transfer['status'] == '5')
                    {
                        //matched the participants immediately with its donation ph
                        //matched the particiapants to its donations
                        $mycon->beginTransaction();
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['donation_ph'],$row['accountdetail_id'],$expirydate);
                        if (!$matching_id)
                        {
                            $mycon->rollBack();
                            echo "Error 1";
                        }

                         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                        $receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                         
                        $transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                        if (!$receiveupdatestatus || !$transferupdatestatus)
                        {
                            $mycon->rollBack();
                            echo "Error 2";
                        }

                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                         //remove from the fund receivable
                        $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$donationsreceivable['withdrawn'] - $transfer['donation_ph'],$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $transfer['donation_ph']));
                        if (!$updatewithdrawn)
                        {
                            $mycon->rollBack();
                            echo "Error 3";
                        }
                        $amount = $transfer['donation_ph'];
                        $mycon->commit();
                        echo "done!";
                        echo "Fund raiser 1";

                    }
                else if ($totalamountreceivable == $transfer['leftover'] && $transfer['leftover_id'] == 1 && $transfer['status'] == '5')
                {
                    //matched the particiapants to its donations
                    $mycon->beginTransaction();
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['leftover'],$row['accountdetail_id'],$expirydate);
                        if (!$matching_id)
                        {
                            $mycon->rollBack();
                            echo "Error 4";
                        }


                         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                        $receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                         
                        $transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                        if (!$receiveupdatestatus || !$transferupdatestatus)
                        {
                            $mycon->rollBack();
                            echo "Error 5";
                        }

                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                         //remove from the fund receivable
                        $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$donationsreceivable['withdrawn'] - $transfer['leftover'],$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $transfer['leftover']));
                        if (!$updatewithdrawn)
                        {
                            $mycon->rollBack();
                            echo "Error 6";
                        }
                        $amount = $totalamountreceivable;
                        $mycon->commit();
                        echo "done!";
                        echo "Fund raiser 2";

                        $amount = $transfer['leftover'];
                }
                elseif ($totalamountreceivable > $transfer['donation_ph'] && $transfer['leftover_id'] == 0 && $transfer['status'] == '5')
                {
                     //matched the particiapants to its donations
                       $mycon->beginTransaction();
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['donation_ph'],$row['accountdetail_id'],$expirydate);
                        if (!$matching_id)
                        {
                            $mycon->rollBack();
                            echo "Error 7";
                        }

                         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                        //$receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                         
                        $transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                        if (!$transferupdatestatus)
                        {
                            $mycon->rollBack();
                            echo "Error 8";
                        }

                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                         //remove from the fund receivable
                        $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$totalamountreceivable - $transfer['donation_ph'],$donationsreceivable['amount'] - ($totalamountreceivable - $transfer['donation_ph']));
                        if (!$updatewithdrawn)
                        {
                            $mycon->rollBack();
                            echo "Error 9";
                        }
                        $amount += $transfer['donation_ph'];
                        $totalamountreceivable -= $transfer['donation_ph'];
                        $mycon->commit();
                        echo "done!";
                        echo "Fund raiser 3";
                }
                elseif ($totalamountreceivable > $transfer['leftover'] && $transfer['leftover_id'] == 1 && $transfer['status'] == '5')
                {
                    //matched the particiapants to its donations
                    $mycon->beginTransaction();
                    $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['leftover'],$row['accountdetail_id'],$expirydate);
                    if (!$matching_id)
                    {
                        $mycon->rollBack();
                        echo "Error 10";
                    }


                     //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                    //$receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                     
                    $transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                    if (!$transferupdatestatus)
                    {
                        $mycon->rollBack();
                        echo "Error 11";
                    }

                    $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                     //remove from the fund receivable
                    $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$totalamountreceivable - $transfer['leftover'],$donationsreceivable['amount'] - ($totalamountreceivable - $transfer['leftover']));
                    if (!$updatewithdrawn)
                    {
                        $mycon->rollBack();
                        echo "Error 12";
                    }
                    $amount += $transfer['leftover'];
                    $totalamountreceivable -= $transfer['leftover'];
                    $mycon->commit();
                    echo "done!";
                    echo "Fund raiser 4";

                    $amount += $transfer['leftover'];
                }
                else if($totalamountreceivable < $transfer['donation_ph'] && $transfer['leftover_id'] == 0 && $transfer['status'] == '5')
                {
                    //matched the particiapants to its donations
                    $mycon->beginTransaction();
                    $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$totalamountreceivable,$row['accountdetail_id'],$expirydate);
                    if (!$matching_id)
                    {
                        $mycon->rollBack();
                        echo "Error 13";
                    }

                     //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                    $receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                     
                    //$transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                    if (!$receiveupdatestatus)
                    {
                        $mycon->rollBack();
                        echo "Error 14";
                    }

                    //update the leftover
                     $leftover = $transfer['donation_ph'] - $totalamountreceivable;
                     //update the leftover of the donation
                     $leftoverupdate = $dataWrite->leftoverupdate($mycon, $transfer['donation_id'], $leftover, '1');
                     var_dump($leftover);
                     if (!$leftover)
                     {
                        $mycon->rollBack();
                        echo "Error 15";
                     }
                    $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                     //remove from the fund receivable
                    $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$donationsreceivable['withdrawn'] - $totalamountreceivable,$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $totalamountreceivable));
                    if (!$updatewithdrawn)
                    {
                        $mycon->rollBack();
                        echo "Error 16";
                    }
                    $amount += $totalamountreceivable;
                    var_dump($amount);
                    $mycon->commit();
                    echo "done!";
                    echo "Fund raiser 5";
                }
                else if ($totalamountreceivable < $transfer['leftover'] && $transfer['leftover_id'] == 1 && $transfer['status'] == '5')
                {
                    //matched the particiapants to its donations
                    $mycon->beginTransaction();
                    $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$totalamountreceivable,$row['accountdetail_id'],$expirydate);
                    if (!$matching_id)
                    {
                        $mycon->rollBack();
                        echo "Error 17";
                    }


                     //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                    $receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                     
                    //$transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                    if (!$receiveupdatestatus)
                    {
                        $mycon->rollBack();
                        echo "Error 18";
                    }

                    //update the leftover
                     $leftover = $transfer['leftover'] - $totalamountreceivable;
                     var_dump($leftover);
                     //update the leftover of the donation
                     $leftoverupdate = $dataWrite->leftoverupdate($mycon, $transfer['donation_id'], $leftover, '1');
                     if (!$leftoverupdate)
                     {
                        $mycon->rollBack();
                        echo "Error 19";
                     }

                    $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                     //remove from the fund receivable
                    $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$donationsreceivable['withdrawn'] - $totalamountreceivable,$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $totalamountreceivable));
                    if (!$updatewithdrawn)
                    {
                        $mycon->rollBack();
                        echo "Error 20";
                    }
                    $amount += $totalamountreceivable;
                    $totalamountreceivable -= $totalamountreceivable;
                    $mycon->commit();
                    echo "done!";
                    echo "Fund raiser 6";
                }
                
                //$amount = $totalamountreceivable;
            }
        }
    }

    }


}


//create a function that will reverse incomplete PH requests


//Create a function that will be checking if $amount is equal to $receivableamount
function checkAmount($amount, $member_id)
{
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();
    $mycon = databaseConnect();
    $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $member_id);
}


//create a function to update the matching table
function matchingUpdate($transfer_id, $receive_id, $amount)
{
   
}

//block members that has not made any donations since the day they joined
function membersBlock()
{
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();
    $mycon = databaseConnect();

    //first get all member details
    $membersall = $dataRead->member_getbyall($mycon);
    //find -3 days ago
    $daysago = date("Y-m-d H:i:s", strtotime("-3 days"));
    foreach ($membersall as $row)
    {
        //checked whether they have made any donations since joined
        $donationscheck = $dataRead->donations_getbyidrecent($mycon,$row['member_id']);
        if (!$donationscheck && (strtotime($row['createdon']) < strtotime($daysago)) && $row['status'] != '0')
        {
            //block the member by updating its status to 0
            $updatememberstatus = $dataWrite->members_updatestatus($mycon, $row['member_id'], '0');
            //send message to use that account has been verified
            $sentmessage = "<div class='container'>
                                <p>Hello ".$row['username'].",</p>
                                <p>You recently registered on WTG - Wealth Fund Global three days ago. And since then you haven't participated mutually, because you did not make any transfer fund request
                                on the platform.</p>
                                <p> We are not happy that you were blocked, we still want you back so you can improve the community and get benefitted. Anytime you are ready
                                 to make transfer fund request, please write to us through our support email support@wealthfundglobal.com </p> 
                                <p><small><em>This message is auto-generated, please do not reply to this email</em>M/small></p>
                            </div>";
        if (sendEmail($row['email'], 'Account Blocked! - Wealth Fund Global', $sentmessage) && sendEmail('support@wealthfundglobal.com', 'One Account Blocked! - Wealth Fund Global', $sentmessage))
        {
            echo "sent";
        }
        }
    }

    echo $daysago;
}



//function to get all donations that has leftover and merged the left over with random selected members
function matchLeftover()
{
    $mycon = databaseConnect();
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();

    //get all leftovers
    $leftovers = $dataRead->leftover_getall($mycon);
    $thedate = date("Y-m-d H:i:s", strtotime("-6 days"));
    $mycon->beginTransaction();
    foreach ($leftovers as $row)
    {
        //get the amount in the receivable donations
        
        $memberdetails = $dataRead->member_getbyrandommatch($mycon);
    if ($row['status'] == '5')
    {
        if (date('D') == 'Fri' || date('D') == 'Sat')
        $expirydate = date("Y-m-d H:i:s", strtotime("+5 days"));
        else $expirydate = date("Y-m-d H:i:s", strtotime("+3 days"));
        //matched the particiapants to its donations
        //get member details at random
       

        
        $firsttime = 0;
        //check if its a first time donation
        $donation_firsttime = $dataRead->donation_getbyid($mycon, $memberdetails['member_id']);
        if ($donation_firsttime)
        {
            $firsttime = 1;
        }
        
        //calculate 3 days from now to transfer fund request again
        $readydonation_ph = date("Y-m-d H:i:s", strtotime("+3 days"));
        $readydonation_gh = date("Y-m-d H:i:s");

        //add to the donation table for the PH
        //calculate 4 days from for transfer funds and 15 days for receiving fund
        $readydonation_ph_admin = date("Y-m-d H:i:s", strtotime("-4 days"));
        $readydonation_gh_admin = date("Y-m-d H:i:s", strtotime("-12 days"));
        $createdon = date("Y-m-d H:i:s", strtotime("-11 days"));
        $donation_id = $dataWrite->donation_add_admin($mycon,$row['leftover'],$memberdetails['member_id'],$readydonation_ph_admin,$readydonation_gh_admin,$memberdetails['accountdetail_id'],$firsttime, '5', $createdon);
        //add to the donation table for the GH
        $donation_id = $dataWrite->donation_add_gh($mycon,$row['leftover'],$memberdetails['member_id'],$readydonation_ph,$readydonation_gh,$memberdetails['accountdetail_id'],$firsttime);
        if (!$donation_id)
        {
            $mycon->rollBack();
            echo "Error 1";
        }

        $matching_id = $dataWrite->matching_add($mycon,$memberdetails['member_id'],$row['member_id'],$donation_id,$row['donation_id'],$row['leftover'],$memberdetails['accountdetail_id'],$expirydate);
        if (!$matching_id)
        {
            $mycon->rollBack();
            echo "Error 2";
        }


        addFundBonus();

        addReceiveAmount();

        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $memberdetails['member_id']);
        $totalamountreceivable = $donationsreceivable['withdrawn'];
        var_dump($totalamountreceivable);

         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
        $receiveupdatestatus = $dataWrite->donationsupdatestatus($mycon, $donation_id, '3', '5');
         
        $transferupdatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
        if (!$receiveupdatestatus || !$transferupdatestatus)
        {
            $mycon->rollBack();
            echo "Error 3";
        }

        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $memberdetails['member_id']);

        
         //remove from the fund receivable
        $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$memberdetails['member_id'],$donationsreceivable['withdrawn'] - $row['leftover'],$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $row['leftover']));
        if (!$updatewithdrawn)
        {
            $mycon->rollBack();
            echo "Error 4";
        }
        //update the leftover
         //update the leftover of the donation
         $leftoverupdate = $dataWrite->leftoverupdate($mycon, $row['donation_id'], '0', '1');
         if (!$leftoverupdate)
         {
            $mycon->rollBack();
            echo "Error 5";
         }
        $amount = $totalamountreceivable;
        $mycon->commit();
        echo "done!";
        echo "Update merging";
    }
}

}

//send email to participants to inform them of their order
function sendEmailParticipants()
{
    $mycon = databaseConnect();
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();


    //get the details of all the members
    $memberdetails = $dataRead->member_getbyall($mycon);
    foreach($memberdetails as $row)
    {
        //get the matching details if available
        $matchingdetails = $dataRead->matching_transfer_getbyidmemeber($mycon, $row['status'], $row['member_id']);
        var_dump($memberdetails);
        foreach($memberdetails as $match)
        {
            if ($match['sendemail'] == 0)
            {
                 $transferdetails = $dataRead->member_getbyid($mycon, $match['transfer_id']);
            $receiverdetails = $dataRead->member_getbyid($mycon, $match['receive_id']);
            $transfermessage = "<div class='container'>
                                <p>Hello ".$transferdetails['username'].",</p>
                                <p>You have a new request update. You have been matched to transfer the sum of ".$match['amount']." to ".$receiverdetails['firstname']." ".$receiverdetails['lastname']."..
                                Quickly login to your dashboard to see more details.</p>
                                <p>Ensure you full this request on or before the expiry time ".formatDate($match['expirydate'], "yes").". </p>
                                <p> For any complains or infomation, send us an email to support@wealthfundglobal.com or us our livechat installed on our website.</p>
                                 <p>please <a href='https://www.wealthfundglobal.com'>login to your office</a> to check. </p>
                                 <p>Regards</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                           </div>";
            $receivemessage = "<div class='container'>
                                <p>Hello ".$receiverdetails['username'].",</p>
                                <p>You have a new request update. You have been matched to receive the sum of ".$match['amount']." from ".$transferdetails['firstname']." ".$transferdetails['lastname']."..
                                Quickly login to your dashboard to see more details.</p>
                                <p>Ensure you full this request on or before the expiry time ".formatDate($match['expirydate'], "yes").". </p>
                                <p> For any complains or infomation, send us an email to support@wealthfundglobal.com or us our livechat installed on our website.</p>
                                 <p>please <a href='https://www.wealthfundglobal.com'>login to your office</a> to check. </p>
                                 <p>Regards</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";
            if (sendEmail($transferdetails['email'], "Transfer Order Matched - Wealth Fund Global", $transfermessage) && sendEmail($receiverdetails['email'], "Receive Order Matched - Wealth Fund Global", $receivemessage))
            {
                //update the matching send email to 1
                $updateemail = $dataWrite->matching_updateemail($mycon, $match['matching_id'], '1');
                echo "Sent";
            }
            }
        }
    }
}


//block participants who failed to pay and make a remerge
function failedParticipants()
{
    $mycon = databaseConnect();
    $dataRead = New DataRead();
    $dataWrite = New DataWrite();

    //find all the matching details
    $todaydate = date("Y-m-d H:i:s");
    $matchingdetails = $dataRead->matching_getallactivestatus($mycon, '5');
    $mycon->beginTransaction();
    foreach ($matchingdetails as $row)
    {
       if (strtotime($row['expirydate']) < strtotime($todaydate))
       {
           //get the transfer details and block the participants
           $transferdetails = $dataRead->member_getbyid($mycon, $row['transfer_id']);
           //update the participants status to 0 to show blocked member
           $updatestatus = $dataWrite->members_updatestatus($mycon, $transferdetails['member_id'], '5');
           if (!$updatestatus)
           {
                $mycon->rollBack();
                echo "failed update 1";
           }

           //send email to participants to inform their present status
           $message = "<div class='container'>
                                <p>Hello ".$transferdetails['username'].",</p>
                                <p>We are sorry to inform you that due to failure to complete your transfer order details, hence the system has automatically disabled your account for the main time. </p>
                                <p>If you are ready to participate mutually and wants your accounts running again, please contact support at support@welathfundglobal.com or chat using our installed livechat.</p>
                                 <p>Regards.</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";
            if (sendEmail($transferdetails['email'], "Account Blocked - Wealth Fund Global", $message))
            {
                //update the
                //set the matching status to 4 which shows remerge
                $matchingupdate = $dataWrite->updateMatchingStatus($mycon, $row['matching_id'], '4');
                if (!$matchingupdate)
                {
                    $mycon->rollBack();
                    echo "failed matching update";
                }

                //get the donation details of the receiver
                $receiverdonationdetails = $dataRead->donations_getbyiddonation($mycon, $row['receivefund_id']);
                $difference = $receiverdonationdetails['donation_gh'] - $row['amount'];

                //update the former recieve request
                $receivefundupdate = $dataWrite->donation_update_gh($mycon, $difference, $row['receivefund_id']);
                if (!$receivefundupdate)
                {
                    $mycon->rollBack();
                    echo "failed receiving fund update";
                }

                //create a new receive fund request for the receiver
                //calculate 3 days from now to transfer fund request again
                $readydonation_ph = date("Y-m-d H:i:s", strtotime("+3 days"));
                $readydonation_gh = date("Y-m-d H:i:s");

                //add to the donation table
                $donation_id = $dataWrite->donation_add_gh($mycon,$row['amount'],$row['receive_id'],$readydonation_ph,$readydonation_gh,$row['accountdetail_id'],'1');
                if (!$donation_id)
                {
                    $mycon->rollBack();
                    echo "failed updating the donation";
                }
 
            }
       }

                $mycon->commit();
    }

}





?>