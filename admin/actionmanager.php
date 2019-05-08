<?php
require_once("config.php");
require_once("inc_dbfunctions.php");

$actionmanager = New ActionManager();
showAlert("hello!");
if(isset($_POST['command']) && $_POST['command'] == "contact_us")
{
	$actionmanager->contact_us();
}


class ActionManager
{


//send contact us message
function contact_us()
{
	showAlert("Hello");
	return;
}

}



?>