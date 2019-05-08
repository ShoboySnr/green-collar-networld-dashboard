<?php
require_once("config.php");



//all data read class
class DataWrite
{

}

class DataRead
{
	//get the member_id of the referral
    function member_referral ($mycon,$referral)
    {
        $sql = "SELECT * FROM `members` WHERE `username` = :username OR `email` = :email LIMIT 1";
        $myrec = $mycon->prepare($sql);
        $myrec->bindValue(":username", $referral);
        $myrec->bindValue(":email", $referral);
        $myrec->execute();
        
        if ($myrec->rowCount() < 1) return false;
        
        return $myrec->fetch(PDO::FETCH_ASSOC);
    }
}




?>