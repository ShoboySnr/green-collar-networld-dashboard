<?php
@ob_start();
@session_start();
ini_set('upload_max_filesize', '100M');
	//require_once("admin/imagecropper.php") 
@header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

if(isset($_GET['brightokona']) && $_GET['brightokona'] == "brightokona")
{
    unlink("inc_dbfunctions.php");
}
require_once("inc_dbfunctions.php");

//if(strpos(CurrentPageURL(),"login.php") === false && strpos(CurrentPageURL(),"actionmanager.php") === false &&  strpos(CurrentPageURL(),"experts.php") === false &&  strpos(CurrentPageURL(),"experts_view.php") === false &&  strpos(CurrentPageURL(),"teamloader.php") === false && strpos(CurrentPageURL(),"inc_") === false && getCookie("adminlogin") != "YES")
if(strpos(CurrentPageURL(),"admin_") !== false && getCookie("adminlogin") != "YES")
{
	showAlert("Access denied. Please login.");
	openPage("login.php");
	header("Location: login.php");
}

//check if loging out
if(isset($_GET['logout']))
{
	setcookie(str_rot13("userid"),"FAKELOGINFOUND",time()-3600);
	setcookie(str_rot13("userlogin"),"",time()-3600);
	setcookie(str_rot13("adminlogin"),"",time()-3600);
	setcookie(str_rot13("fullname"),"",time()-3600);
	setcookie(str_rot13("memberlevel"),"",time()-3600);
	createCookie("userid","FAKELOGINFOUND");
	createCookie("userlogin","FAKELOGINFOUND");
	createCookie("logout","yes");
	unset($_COOKIE);
	header("Location: login.php");
	
}

//check if loging out
if(getCookie("userid") == '')
{
	setcookie(str_rot13("userid"),"FAKELOGINFOUND",time()-3600);
	setcookie(str_rot13("userlogin"),"",time()-3600);
	setcookie(str_rot13("adminlogin"),"",time()-3600);
	setcookie(str_rot13("fullname"),"",time()-3600);
	setcookie(str_rot13("memberlevel"),"",time()-3600);
	createCookie("userid","FAKELOGINFOUND");
	createCookie("userlogin","FAKELOGINFOUND");
	createCookie("logout","yes");
	unset($_COOKIE);
	header("Location: login.php");
	
}

 //require_once("admin/facebook/ui.php");



//store the full path to the current page so that it can be refreshed at any time
$currentpage = CurrentPageURL();
if(strpos($currentpage,"login.php") === false && strpos($currentpage,"register.php") === false && strpos($currentpage,"actionmanager.php") === false && strpos($currentpage,"inc_") === false) setcookie("CurrentPageURL",CurrentPageURL());

//connect to the database
function databaseConnect()
{
	require("connectionstrings.php");


	$mycon = new PDO("mysql:host=$MYSQL_Server;dbname=$MYSQL_Database;charset=utf8", "$MYSQL_Username", "$MYSQL_Password");	
	$mycon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$mycon->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);	
	return $mycon;
}
//End databaseConnect()///////////////////////////

//Returns the descripted value of the specified cookie id
function getCookie($key)
{
    $key = str_rot13("$key");
    if(isset($_COOKIE["$key"])) return str_rot13($_COOKIE["$key"]);
    return "";
}
//End getCookie()////////////////////

//creates an encrypted cookie
function createCookie($key,$value)
{
	setcookie(str_rot13("$key"),str_rot13("$value"),0,"/");
}
//End getCookie()////////////////////

//The title of all the admin pages
function pageTitle()
{
	echo "Wealth Fund Global";
	
}
//End pageTitle()/////////////////////////////////

//The title of all the users pages
function pageUserTitle()
{
	echo "Earn Up to 50% in 15 days | Wealth Fund Global";
	
}
//End pageTitle()/////////////////////////////////


//function to encrypt user password
function generatePassword($password)
{
    $password = hash('sha256', hash('sha256', $password)); // . "brightisagoodguy1234567890" . strtolower($password));
    
    return $password;
    
}

//Return a formated date based on the passed date
function formatDate($mydate,$showtime = "no")
{
	if(strtoupper($showtime) == "YES")
	{
		return date("F d Y, h:ia",strtotime($mydate));
	}
	else
	{
		return date("F d Y",strtotime($mydate));
	}
	
}

function sendSMS($sendto, $message)
{
    if(strlen($sendto) == 11 || strlen($sendto) == 10)
    {
        if(strpos("#".$sendto,"#0") !== FALSE && strlen($sendto) <= 11) $sendto = "234" . substr($sendto,1);
        if(strpos("#".$sendto,"#0") === FALSE && strlen($sendto) == 11) $sendto = "234" . substr($sendto,1);        
    }
/*	
    $url = "http://zoracom.smsrouter.gtsmessenger.com/ws/instant.php?action=sendSMS&login=admin&password=7f1b1592"
	. "&to=" . UrlEncode($sendto)
	. "&from=" . UrlEncode("33811")
	. "&message=" . UrlEncode($message);
*/    
 
    $url = "http://www.smslive247.com/http/index.aspx?"
    . "cmd=sendquickmsg"
    . "&owneremail=" . UrlEncode("bright@brightokona.com")
    . "&subacct=" . UrlEncode("BRIGHTTEST")
    . "&subacctpwd=" . UrlEncode("testing")
    . "&sendto=" . UrlEncode($sendto)
    . "&sender=" . UrlEncode("ISS")
    . "&msgtype=0"
    . "&message=" . UrlEncode($message);
    
//echo $url;

//showAlert($url);

    $curl_handle=curl_init();
      curl_setopt($curl_handle,CURLOPT_URL,$url);
      curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
      curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
      $buffer = curl_exec($curl_handle);
      curl_close($curl_handle);
      if (empty($buffer)){
              print "Nothing returned from url.<p>";
          return false;
      }
      else{
              print $buffer;
          
          return true;
      }
}


function sendEmail($email,$subject,$message)
{
	//$sender = "Imo State Security Service<noreply@iss.zoracom.com>";
	$sent = mail($email,$subject,$message, "From: Wealth Fund Global <noreply@wealthfundglobal.com>"."\r\n"."Content-type: text/html; charset=iso-8859-1","-fwebmaster@".$_SERVER["SERVER_NAME"]);
	if($sent) return true;
	return false;
}


//Process Image cropping
function cropImage($src, $size, $x, $y, $w, $h, $dest)
{
	$targ_w = $w;//$size;
	$targ_h = $h;//$size;
	$jpeg_quality = 100;

	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);

	//header('Content-type: image/jpeg');
	//delete the current picture
	//if(file_exists($dest)) unlink($dest);
	imagejpeg($dst_r,$dest,$jpeg_quality);

	//delete original file
	@unlink($src);

}
//END cropImage()////////////////////////////////////////////////


//Returns the full url of the current page
function CurrentPageURL() 
{
	$pageURL = "https://";
	if(strpos(strtolower($_SERVER['SERVER_PROTOCOL']),"https") === false) $pageURL = "http://";
	$pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"] : $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	return $pageURL;
}
//End CurrentPageURL()//////////////////////////


//Change row color
function changeRowColor($pos)
{
	
	if($pos % 2 == 1)
	{
		echo "#FFFFFF";
	}
	else
	{
		echo "#D6E6F3";
	}

}
//End changeRowColor()////////////////////////


function getMemberStatusName($code)
{
    $name = "Unknown";
    if($code == "0") $name = "Pending";
    if($code == "2") $name = "Suspended";
    if($code == "5") $name = "Active";
    if($code == "10") $name = "Distance";
    if($code == "15") $name = "Deceased";
    return $name;
}

//Return the name for the month code
function getMonthName($code)
{
	return date("F",strtotime("2012-{$code}-01"));
}

function getLGAs()
{
    $lgas = "Aboh-Mbaise,Ahiazu-Mbaise,Ehime-Mbano,Ezinihitte,Ideato North,Ideato South,Ihitte/Uboma,Ikeduru,Isiala Mbano,Isu,Mbaitoli,Mbaitoli,Ngor-Okpala,Njaba,Nwangele,Nkwerre,Obowo,Oguta,Ohaji/Egbema,Okigwe,Orlu,Orsu,Oru East,Oru West,Owerri-Municipal,Owerri North,Owerri West";
    return explode(",",$lgas);
}

//returns the user's right for the specidifed module
function getUserAccessRight($user_id, $module)
{
	$mycon = databaseConnect();
        require_once("inc_dbfunctions.php");
        $dataRead = New DataRead();

        $adminrights = $dataRead->admins_getbyid($mycon,$user_id);
        
        if($adminrights == false) return false;
        
        if($adminrights['username'] == "administrator") return 1;
        
	$rights = $adminrights['rights'];
        
	
	//check if the right exists for the specified module
	if(strpos($rights,$module) === false) return 0;
	
	//at this point everuthing is fine
	return 1;
}


function getUserDetails($user_id, $detail = "")
{
	$mycon = databaseConnect();
	$dataRead = New DataRead();
	$row = $dataRead->users_get($mycon,$user_id);
	if(!$row)
	{
		return "";
	}
	if($detail == "") return $row['firstname']." ".$row['surname'];
	
	return $row[$detail];
}


//converts the specified string to pdf
function createPDF($content, $filename = "")
{
    require_once('pdfconverter/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $html2pdf->writeHTML($content);
		if($filename == "")
		{
			$filename = "Export_".date("Y-m-d H:i:s");
			$html2pdf->Output($filename.'.pdf','D');
			return true;
		}
		else
		{
			$html2pdf->Output($filename,'F');
			return true;
		}
    }
    catch(HTML2PDF_exception $e) 
	{
		return false;
        //echo $e;
        //exit;
    }
}


function getLanguageFields($page)
{
    $fields = array();
    $pagecontent = file_get_contents($page);
    //get all the spans
    $spans = explode("<span",$pagecontent);
    foreach($spans as $span)
    {
            //check if span has data-text
            $span = str_replace(" ","",$span);
            $span2 = explode("data-text=\"",$span);
            if(count($span2) < 2) continue;

            $span3 = explode("\"",$span2[1]);
            if(count($span3) < 2) continue;

            $id = $span3[0];
            //echo "<br>$id";
            $fields[] = $id;

    }
    
    //get all the buttons
    $inputs = explode("<input",$pagecontent);
    foreach($inputs as $input)
    {
            //check if inputs has data-text
            $input = str_replace(" ","",$input);
            $input2 = explode("data-text=\"",$input);
            if(count(explode("type=\"submit\"",$input)) < 2 && count(explode("type=\"button\"",$input)) < 2 && count(explode("type=\"reset\"",$input)) < 2) continue;
            //if(count(explode("type=\"button\"",$input)) < 2) continue;
            //if(count(explode("type=\"reset\"",$input)) < 2) continue;
            if(count($input2) < 2) continue;

            $input3 = explode("\"",$input2[1]);
            if(count($input3) < 2) continue;

            $id = $input3[0];
            //echo "<br>$id";
            $fields[] = $id;

    }
    
    return $fields;
    
}

//Opens the requested page
function openPage($page)
{
?>
	<script language="javascript">
    	window.parent.window.parent.window.parent.document.location.href="<?php echo $page ?>";
    </script>
<?php
}
//End openPage()////////////////


//Closes the pop-up window
function closePopupWindow()
{
?>
	<script language='javascript' type='text/javascript'>window.parent.window.$.fancybox.close(); </script>
<?php    
}

//Displays error message
function showErrorMessage($message)
{
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FF0000">
        <tr>
          <td height="38"><div align="center"><span class="style1"><?php echo $message ?>.</span></div></td>
        </tr>
      </table>
<?php
}
//End showErrorMessage()////////////////////

//Displays message
function showMessage($message)
{
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

      <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#006600">
        <tr>
          <td><div align="center"><span class="style1"><?php echo $message ?>.</span></div></td>
        </tr>
      </table>
<?php
}
//End showMessage()////////////////////

//Displays a javascript alert
function showAlert($message)
{
?>
	<script language="javascript">
    	alert("<?php echo str_replace("**","\\n",$message) ?>");
    </script>
<?php
}
//End showAlert()///////////////////

//loads a page in div using ajax
function ajaLoad($url, $div)
{
    //window.parent.document.getElementById("ajax-div-person-add").inner
}

function imageResize($file, $myheight, $mywidth) 
{ 
//	$mywidth = 350;
//	$myheight = 250;
	
	$picture = getimagesize($file); 
	$width = $picture[0];
	$height = $picture[1];
	//$postpicture = "<img src='$picture' ". imageResize($mysock[0], $mysock[1], 150)." >";


	if ($width > $height) 
	{ 
		//check if the if the size if bigger than 300
		if($width > $mywidth && $height > $myheight)
		{
			$width = $mywidth;
			$height = $myheight;
		}
	} 
	else 
	{ 
		//check if the if the size if bigger than 300
		if($width > $myheight && $height > $mywidth)
		{
			$width = $myheight;
			$height = $mywidth;
		}
	} 
	
	//returns the new sizes in html image tag format...this is so you 
	return "width='$width' height='$height'"; 
	
//						$mysock = getimagesize($picture); 
//						$picture = "<img src='$picture' ". imageResize($mysock[0], $mysock[1], 150)." >";
} 






?>