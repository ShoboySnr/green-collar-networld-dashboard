<?php
if(isset($_GET['image']) && $_GET['image'] != "")
{
	$imagesource =  $_GET['image'];
	
	include('imagecropper.php');
	$image = new SimpleImage();
	$image->load($imagesource);

	if(isset($_GET['h']) && $_GET['h'] != "" && isset($_GET['w']) && $_GET['w'] != "")
	{
		$h = $_GET['h'];
		$w = $_GET['w'];
		$image->resize($w,$h);
	}
	else //both height and width not specified
	{
		if(isset($_GET['h']) && $_GET['h'] != "")
		{
			$h = $_GET['h'];
			$image->resizeToHeight($h);
		}
		elseif(isset($_GET['w']) && $_GET['w'] != "")
		{
			$w = $_GET['w'];
			$image->resizeToWidth($w);
			
		}
		elseif(isset($_GET['s']) && $_GET['s'] != "")
		{
			$s = $_GET['s'];
			$s = intval($s);
			if($image->getWidth() > $image->getHeight() && $image->getWidth() > $s)
			{
				$image->resizeToWidth($s);
			}
			elseif($image->getHeight() > $s)
			{
				$image->resizeToHeight($s);
			}
			
		}
		
	}
//	
//	$filetype = substr($imagesource,strlen($imagesource)-4,4); 
//	$filetype = strtolower($filetype); 
//	if($filetype == ".gif")  $image = @imagecreatefromgif($imagesource);  
//	if($filetype == ".jpg")  $image = @imagecreatefromjpeg($imagesource);  
//	if($filetype == ".png")  $image = @imagecreatefrompng($imagesource);  
//	if (!$image) die(); 
	$image->output();
	//imagejpeg($image); 
	//imagedestroy($image); 

}

?>