<?php
require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");
$currentuserid = getCookie("userid");

$dataRead = New DataRead();
$mycon = databaseConnect();
$memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
if (!$memberdetails)
{
	openPage("login.php?logout=yes");
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">

		<link rel="shortcut icon" href="assets/images/favicon_1.ico">

		<title>Dashboard Locked - <?php echo pageTitle(); ?></title>

		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
        <script type='text/javascript'>
        	$(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });

        </script>

	</head>
	<body>

		<div class="account-pages login-register-background"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-body">
					<form method="post" action="admin/actionmanager.php" role="form" class="text-center" id="unlockaccountform">
						<div class="row">
						<div class="user-thumb pull-left">
							<img src="img/logo/logowfg.png" alt="" width="70px" height="70px">
						</div>
						<div class="user-thumb pull-right">
							<img src="member_image/<?php if ($memberdetails['picturestatus'] == '0') echo 'avatar.png'; else echo $memberdetails['username'].'.jpg'; ?>" class="img-responsive img-circle img-thumbnail" alt="<?php echo $memberdetails['username'] ?>_photo">
						</div>
					</div>
						<div class="form-group">
							<h3><?php echo $memberdetails['username'] ?></h3>
							<h4><?php echo $memberdetails['email'] ?></h4>
							<p class="text-muted">
								Enter your password to access the dashboard.
							</p>
							<div id="result"></div>
							<div class="input-group m-t-30" id="passworddiv">
								<input type="password" class="form-control" placeholder="Password" id="password">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-success w-sm waves-effect waves-light" id="unlockpassword">
										Log In
									</button> 
								</span>
							</div>
						</div>
						
					</form>
       

				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<p class="login-footer">
						Not <?php echo $memberdetails['username'] ?>?<a href="login.php?logout=yes" class="text-primary m-l-5"><b>Log In</b></a>
					</p>
				</div>
			</div>

		</div>

		<script>
			var resizefunc = [];
		</script>

		<!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>


        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/custom.js"></script>

	</body>
</html>