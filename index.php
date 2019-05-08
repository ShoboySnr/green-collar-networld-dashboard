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

	<title>Welcome To Our Global Community - <?php echo pageUserTitle() ?></title>
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
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1430479256582072",
    enable_page_level_ads: true
  });
</script>
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

	<!-- REVOLUTION SLIDER
	============================================= -->
	<div class="fullwidthbanner-container top-shadow">
		<div class="fullwidthbanner">
			<ul>

				<li data-masterspeed="150" data-slotamount="4" data-transition="fade" >
					<img alt="" src="img/background-home/wealthfundglobal.jpg">
					<div style='background-color: rgba(0,0,0,0.5);'>
						<div class="tp-caption m-3-2em m-text-black m-semibold sft" data-easing="easeOutExpo" data-x="40" data-y="130">
							<br><span style="color: #FFFFFF; background-color: rgba(21,153,3,0.3);">Why Spend It When You Can Make It Grow.</span>
						</div>
						<div class="tp-caption m-1-8em m-text-black sfr" data-easing="easeOutExpo" data-x="40" data-y="185">
							<br><span style="color: #FFFFFF; background-color: rgba(21,153,3,0.3);">A mutual community where you participate with your spare cash and earn up to 50% in every 15 days!</span>
						</div>
					</div>
				<div class="revolution-padding">
				<div class="tp-caption sfb text-center" data-easing="easeInOutExpo"data-x="40" data-y="280">
					<a class="btn" href="mod.wealthfundglobal.com">Login</a>
				</div>
				<div class="tp-caption sfb" data-easing="easeInOutExpo" data-x="165" data-y="280">
					<a class="btn colored" href="mod.wealthfundglobal.com/register.php">Create your account</a>
				</div>
			</div>
				<!-- End Captions -->
				</li>
				<li data-masterspeed="150" data-slotamount="4" data-transition="fade">
					<img alt="" src="img/background-home/wealthfundglobal2.jpg">
				<div class='pull-right'>
				<div class="tp-caption pull-right m-3-2em m-text-black m-semibold sft" data-easing="easeOutExpo" data-x="40" data-y="130">
					<span  class='callout-text' style="color: #FFFFFF; background-color: rgba(21,153,3,0.3);">50% On Every Funds. 10% On Every Referrals. A Stable System!</span>
				</div>
				<div class="tp-caption m-1-8em m-text-black sfr revolution-padding" data-easing="easeOutExpo" data-x="40" data-y="230">
					<span class='callout-text' style="color: #FFFFFF; background-color: rgba(21,153,3,0.3);">Only a stable system of ours will give 50% on every funds and 10% on every referrals. Seriously!</span>
				</div>
				<div class="revolution-padding" style='padding-top: 30px'>
				<div class="tp-caption sfb text-center" data-easing="easeInOutExpo" data-x="40" data-y="300">
					<a class="btn" href="about.php">Read More</a>
				</div>
				<div class="tp-caption sfb" data-easing="easeInOutExpo" data-x="165" data-y="300">
					<a class="btn colored" href="#">Testimonies</a>
				</div>
			</div>
			</div>
				<!-- End Captions -->
			</li>
				<!-- Slide 1 -->
				<<!--li data-masterspeed="150" data-slotamount="2" data-transition="fade">
					<img alt="" src="img/background-home/want-healthy.jpeg">
				<div class="tp-caption m-3-2em m-text-black m-semibold sft" data-easing="easeOutExpo" data-speed="700" data-start="1400" data-x="40" data-y="130">
					<span class='callout-text' style="color: #FFFFFF; font-family: 'Poppins', sans-serif;">Want a Healthy System. Here it is!</span>
				</div>
				<div class="tp-caption m-1-8em m-text-black sfr revolution-padding " data-easing="easeOutExpo" data-speed="700" data-start="1600" data-x="40" data-y="185">
					<span class='callout-text' style="color: #FFFFFF; font-family: 'Poppins', sans-serif;">Our system has stand the test of time and has proven to be stable for a very long time. Seriously!</span>
				</div>
				<div class="tp-caption sfb" data-easing="easeInOutExpo" data-speed="700" data-start="1700" data-x="40" data-y="233">
					<a class="btn" href="mod/login.php">Login</a>
				</div>
				<div class="tp-caption sfb" data-easing="easeInOutExpo" data-speed="700" data-start="1800" data-x="165" data-y="233">
					<a class="btn colored" href="mod/register.php">Get Started</a>
				</div>
				<!-- End Captions -->
				<!--</li> -->
				<!-- End Slide 1 -->
				<!-- Slide 2 -->
			</ul>
		</div>
	</div>
	<!-- END REVOLUTION SLIDER
	============================================= -->

	<!-- FEATURED CONTENT
	============================================= -->
	<!--<div class="content content-featured">
		<div class="layout">
			<p>
				Wealth Fund Global is a global community of people adding  <a href="#">More<i class="icon-chevron-sign-right" style="margin: 0 0 0 7px;"></i></a>
			</p>
		</div>
	</div> -->
	<!-- END FEATURED CONTENT
	============================================= -->

	<!-- CONTENT 
	============================================= -->
	<div class="content shortcodes gray-content" style="padding-bottom: 10px;">
		<div class="layout" style="padding-bottom: 1px;">
			<div class="row">
				<div class="row-item col-1_3">
					<!-- Icon Box -->
					<div class="icon-box medium" style="margin-bottom: 25px;">
						<i class="fa fa-line-chart"></i>
						<h4><a href="#" class="dark-link">50% Fund Returns</a></h4>
						<p>
							 You receive 50% returns on every funds you transfer to other participants like you.
						</p>
						<p><a href="mod/register.php" class="btn colored" style="margin-bottom: 0;">Create an account</a></p>
						<p><a href="mod/login.php" class="btn colored" style="margin-bottom: 0;">Login</a>
						</p>
					</div>
					<!-- End Icon Box -->
				</div>
				<div class="row-item col-1_3">
					<!-- Icon Box -->
					<div class="icon-box medium" style="margin-bottom: 25px;">
						<i class="fa fa-users"></i>
						<h4><a href="#" class="dark-link">10% Referral Bonus</a></h4>
						<p>
							 You receive 10% instant referral bonus for every fund your downlines transfers to another participants
						</p>
						<p><a href="#" class="btn colored" style="margin-bottom: 0;">Read more</a></p>
					</div>
					<!-- End Icon Box -->
				</div>
				<div class="row-item col-1_3">
					<!-- Icon Box -->
					<div class="icon-box medium" style="margin-bottom: 25px;">
						<i class="fa fa-globe"></i>
						<h4><a href="#" class="dark-link">How It Works</a></h4>
						<p>
							 This our system has survive the test of time from working offline and building a larger community online.
						</p>
						<p><a href="#" class="btn colored" style="margin-bottom: 0;">How It Works</a></p>
					</div>
					<!-- End Icon Box -->
				</div>
			</div>
		</div>
	</div>
	
	<!-- END CONTENT 
	============================================= -->

	<?php include_once('inc_footer.php'); ?>
	
</div>
<!-- END MAIN 
============================================= -->


</body>
</html>