<?php
require_once("admin/inc_dbfunctions.php");
require_once("admin/config.php");


Fundgrowth();

NewReceiver();

addFundBonus();

matching();

membersBlock();

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
                if (!$growthupdate)
                {
                	echo false;
                }
                else echo true;
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
        $zerobalance = $dataWrite->donationsreceivable_update($mycon, $row['member_id'], '0', '0');  
    }
    
    
    foreach($membersall as $row)
    {
        //get each donation requests
        $donationrequests = $dataRead->donations_getidmember($mycon,$row['member_id']);

        foreach($donationrequests as $donation)
        {
            if ($donationrequests != null &&  $donation['status'] == '0')
            {
               //find the donations receivable
                $membercheck = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                //update the fund in wallet
                if ($membercheck['amount'] >= 0)
                {
                    $balance = ($donation['donation_ph'] * 0.5) + $donation['donation_ph'] + $membercheck['amount'] - $membercheck['withdrawn'];
                    $updatefund = $dataWrite->donationsreceivable_update($mycon, $membercheck['member_id'], $donation['donation_ph'] + $membercheck['amount'] + ($donation['donation_ph']*0.5), $balance);


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
                        $membercheck = $dataRead->donationsreceivable_getbyidreferral($mycon, $row['member_id']);
                        
                        //update the fund in wallet
                        if ($membercheck['amount'] >= 0)
                        {
                            $referralbalance =  $membercheck['amount'] * 0.1 - $donation['withdrawn'] + $donation['donation_ph'];
                            var_dump($referralbalance);
                            $updatefund = $dataWrite->donationsreceivable_update($mycon, $membercheck['referral_id'], $membercheck['amount'] + ($donation['donation_ph']*0.1), $referralbalance);

                        }
                        

                    }    
                }
                
            }
}

//function matching()
/**{
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
        //get the amount in the receivable donations
        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
        
        if ($donationsreceivable['withdrawn'] == $row['donation_gh'])
        {
            $totalamountreceivable = $donationsreceivable['withdrawn'];
        }

        //get the list of all the  active donations that are at least 3 days and matched status of 0, status of 5 and memberstatus of 0
        $thedate = date("Y-m-d H:i:s", strtotime("-3 days"));
        $activetransferdonations = $dataRead->activetransferdonations($mycon, '5', '0', '0', $row['member_id'], $row['country']);
        while ($amount < $totalamountreceivable)
        {

        //update the matching table
        //check if the matching falls on  weekend
        if (date('D') == 'Fri' || date('D') == 'Sat')
        $expirydate = date("Y-m-d H:i:s", strtotime("+5 days"));
        else $expirydate = date("Y-m-d H:i:s", strtotime("+3 days"));
        //$mycon->beginTransaction();
        foreach ($activetransferdonations as $transfer)
        {
            if (strtotime($transfer['createdon']) <= strtotime($thedate) && $row['withdrawn'] != 0)
                {
                    var_dump($totalamountreceivable);
                    if ($totalamountreceivable == $transfer['donation_ph'] && $transfer['leftover_id'] == 0)
                    {
                        //matched the participants immediately with its donation ph
                        //matched the particiapants to its donations
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$totalamountreceivable,$row['accountdetail_id'],$expirydate);

                         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                         
                        
                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                         //remove from the fund receivable
                         $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$donationsreceivable['withdrawn'] - $transfer['donation_ph'],$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $transfer['donation_ph']));

                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                         $amount = $totalamountreceivable;
                         echo "done!";
                        echo "Fund raiser 1";

                    }
                    else if ($totalamountreceivable == $transfer['leftover'] && $transfer['leftover_id'] != 0)
                    {
                        //matched the particiapants to its leftover
                        //matched the particiapants to its donations
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['leftover'],$row['accountdetail_id'],$expirydate);
                        if (!$matching_id)
                         
                        //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                        $updatestatus1 = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                        $updatestatus2 = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                        
                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                        $leftover = $totalamountreceivable - $transfer['leftover'];
                        //update the leftover of the donation
                        $leftoverupdate = $dataWrite->leftoverupdate($mycon, $transfer['donation_id'], $leftover, $totalamountreceivable - $transfer['leftover'], $totalamountreceivable - $transfer['leftover']);

                        //remove from the fund receivable
                        $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'], $donationsreceivable['withdrawn'] - $transfer['leftover'],$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $transfer['leftover']));
                        $amount = $totalamountreceivable;
                        $totalamountreceivable = 0;
                         echo "done!";
                        echo "Fund raiser 2";
                    }
                    else if ($totalamountreceivable > $transfer['donation_ph'] && $transfer['leftover_id'] == 0)
                    {
                        //matched the particiapants to its donations
                         $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['donation_ph'],$row['accountdetail_id'],$expirydate);
                         
                         //change the status of the transfer particiapants to status of 3 and matched status to 5
                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                         
                         //remove from the fund receivable
                         $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'], $transfer['donation_ph'], $totalamountreceivable - $transfer['donation_ph']);
                         $amount += $transfer['donation_ph'];
                         //get the amount in the receivable donations
                            $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
                            
                            $totalamountreceivable = $donationsreceivable['balance'];
                            
                         echo "done!";
                        echo "Fund raiser 3";

                       
                    }
                    else if ($totalamountreceivable > $transfer['leftover'] && $transfer['leftover'] != 0)
                    {
                        //matched the particiapants to its leftover
                        //matched the particiapants to its donations
                         $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$transfer['leftover'],$row['accountdetail_id'],$expirydate);
                         
                         //change the status of the transfer particiapants to status of 3 and matched status to 5
                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                         //get the amount in the receivable donations
                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);
                         
                         //remove from the fund receivable
                         $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'], $donationsreceivable['withdrawn'] - $transfer['leftover'], $donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $transfer['leftover']));
                         $amount += $transfer['leftover'];
                         
                         $totalamountreceivable = $donationsreceivable['withdrawn'] - $transfer['leftover'];
                            
                         echo "done!";
                        echo "Fund raiser 4";
                    }
                    else if ($totalamountreceivable < $transfer['donation_ph'] && $transfer['leftover_id'] == 0)
                    {
                        //matched the particiapants to its leftover
                        //matched the particiapants to its donations
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$totalamountreceivable,$row['accountdetail_id'],$expirydate);
                         if (!$matching_id)
                         
                         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                         
                         $leftover = $transfer['donation_ph'] - $totalamountreceivable;
                         //update the leftover of the donation
                         $leftoverupdate = $dataWrite->leftoverupdate($mycon, $transfer['donation_id'], $leftover, '1');
                         //remove from the fund receivable
                         $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],'0','0');
                         $amount = $totalamountreceivable;
                         echo "done!";
                        echo "Fund raiser 5";
                    }
                    else if ($totalamountreceivable < $transfer['leftover'] && $transfer['leftover'] != 0)
                    {
                        //matched the particiapants to its leftover
                        echo "Fund raiser 5";
                    }
                }
                
   
        }
    }
        

    }

} **/

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
        
        if ($donationsreceivable['withdrawn'] == $row['donation_gh'])
        {
            $totalamountreceivable = $donationsreceivable['withdrawn'];
        }


        //get the list of all the  active donations that are at least 3 days and matched status of 0, status of 5 and memberstatus of 0
        $thedate = date("Y-m-d H:i:s", strtotime("-3 days"));
        $activetransferdonations = $dataRead->activetransferdonations($mycon, '5', '0', '0', $row['member_id'], $row['country']);

        foreach ($activetransferdonations as $transfer)
        {
            if (strtotime($transfer['createdon']) <= strtotime($thedate) && $row['withdrawn'] != 0)
                {
                    var_dump($totalamountreceivable);
                    if ($totalamountreceivable == $transfer['donation_ph'] && $transfer['leftover_id'] == 0)
                    {
                        //matched the participants immediately with its donation ph
                        //matched the particiapants to its donations
                        $matching_id = $dataWrite->matching_add($mycon,$row['member_id'],$transfer['member_id'],$row['donation_id'],$transfer['donation_id'],$totalamountreceivable,$row['accountdetail_id'],$expirydate);

                         //change the status of the transfer particiapants to status of 3 and matched status to 5 and leftover id to 1
                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $row['donation_id'], '3', '5');
                         
                        
                        $donationsreceivable = $dataRead->donationsreceivable_getbyidmember($mycon, $row['member_id']);

                         //remove from the fund receivable
                         $updatewithdrawn = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$row['member_id'],$donationsreceivable['withdrawn'] - $transfer['donation_ph'],$donationsreceivable['amount'] - ($donationsreceivable['withdrawn'] - $transfer['donation_ph']));

                         $updatestatus = $dataWrite->donationsupdatestatus($mycon, $transfer['donation_id'], '3', '5');
                         $amount = $totalamountreceivable;
                         echo "done!";
                        echo "Fund raiser 1";

                    }
                }

            }
        }
    }


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


?>