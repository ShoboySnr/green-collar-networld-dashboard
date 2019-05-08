<?php 
//This is code is used for generating a captcha image for forms to prevent robots from submiting a form

session_start(); 
$text = rand(10000,99999); 
$_SESSION["captcha"] = $text; 
$height = 25; 
$width = 65; 
 
$image_p = imagecreate($width, $height); 
$black = imagecolorallocate($image_p, 0, 0, 0); 
$white = imagecolorallocate($image_p, 255, 255, 255); 
$font_size = 14; 
 
imagestring($image_p, $font_size, 5, 5, $text, $white); 
imagejpeg($image_p, null, 80); 

//implementation
/*
<form action="submit.php" method="post"> 
Comment: <textarea name="coment"></textarea><br> 
Enter Code <img src="captcha.php"><input type="text" name="vercode" /><br> 
<input type="submit" name="Submit" value="Submit" /> 
</form>
*/

?>