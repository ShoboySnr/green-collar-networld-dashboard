<?php
require_once ('admin/config.php');

$mycon = databaseConnect();
$dataRead = New DataRead();

if (isset($_GET['ref']) && $_GET['ref'] != '')
{
    $referred = $dataRead->member_referral($mycon, $_GET['ref']);
    if (!$referred)
    {
        showAlert("referral was not found");
        openPage("mod/register.php");
    }
    else {
    createCookie("ref", $_GET['ref']);
    openPage("mod/register.php");
    }
}
?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<title>How It Works - <?php echo pageUserTitle() ?></title>
	<link rel="shortcut icon" href="img/logo/logowfg.ico">
	<!-- Styles -->
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/responsive.css">
	<link rel="stylesheet" href="css/prettyPhoto.css">
	<link rel="stylesheet" type="text/css" href="css/settings.css" media="screen"/>
	<link rel="stylesheet" href="css/color-scheme/blue.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- Base JS -->
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/stellar.js"></script>
	<script src="js/main.js"></script>
	
	<!-- Revolution Slider -->
	<script src="js/jquery.themepunch.plugins.min.js"></script>
	<script src="js/jquery.themepunch.revolution.min.js"></script>
	<script src="js/revolution-slider-options.js"></script>
	
	<!-- Prety photo -->
	<script src="js/jquery.prettyPhoto.js"></script>
	<script>
		$(document).ready(function(){
			$("a[rel^='prettyPhoto']").prettyPhoto();
		});
	</script>
</head>

<body>

<div class="main">

	
	<?php include_once('inc_header.php'); ?>

	<!-- TITLE BAR
	============================================= -->
	<div class="b-titlebar">
		<div class="layout">
			<!-- Bread Crumbs -->
			<ul class="crumbs">
				<li>You are here:</li>
				<li><a href="index.php">Home</a></li>
				<li><a href="#">About WFG</a></li>
			</ul>
			<!-- Title -->
			<h1>How Wealth Fund Global Operate</h1>
		</div>
	</div>
	<!-- END TITLE BAR
	============================================= -->

	<!-- CONTENT 
	============================================= -->
	<div class="content">
		<div class="layout">
			<div class="row">
				<div class="row-item col-1_2">
					<h3 class="lined margin-20">10 Easy Guidelines</h3>
					<img class="" src="img/others/WG02.png" alt="" width="100%" height="50%">
				</div>
				<div class="row-item col-1_2">	
					<p>Wealth Fund Global is a global community of people. We are located at Texas, United States, and we have global representatives in some countries. Our major aim is to alleviate and bridge the gap between the poor and the rich, and we do this by setting up this platform. Wealth should belong to everyone, every individuals should have access to this wealth but we have studied and seen over the years that certain individuals known as the government officials, bankers, money lenders have deprived the masses access to this wealth.</p>
					<p>And this is unfair and unjust to the human race. Hence, Wealth Fund Global is all about funding one another through one's kind heartedness and honesty. We ensure your money will grow over a period of 15 days and gives you 50% returns on every funding you completed. And for every person you refer through your email or username or referral link, you get 10%. </p>
				</div>
				<div class="row-item col-1_1">	
					<p>Our merging system is automatic and was developed by a group of programmers at Texas. Everything here is auto-process. We believe that this system will be stable over a long time because of the way it has been structured.</p>
					<p>Please note that, this system is not a quick making money platform. We are not making money here, we are simply helping each other through funds. Hence ensure you stay away from anything that might deprive the system growth. We are monitoring all accounts 24 hours every day. Any suspected individuals will be automatically blocked.</p>
					<p>All we require of you as participants is your honesty and support to grow this community. This will take us far and fast. If you have any complains, please use our live chats support integrated in the website or send us a mail via support@wealthfundglobal.com.</p>
					<p>Wealth Fund Global is here and will stay forever. Keep Funding, Keep Inviting and Keep Smiling. Grow your wealth!</p>
							
					<p></p>
					
					<div class="gap" style="height: 30px;">
					</div>
					
				</div>
			</div>
			
		</div>
	</div>
	
	
	<!-- END CONTENT 
	============================================= -->

	<?php include_once('inc_footer.php'); ?>
	============================================= -->
	
</div>
<!-- END MAIN 
============================================= -->


</body>
</html>