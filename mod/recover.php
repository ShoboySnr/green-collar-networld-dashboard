<?php

require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Earn Up to 50% on Every Fund Transfer You send to Other Participants. Wealth Fund Global">
		<meta name="author" content="Coderthemes">

		<link rel="shortcut icon" href="img/logo/logowfg.ico">

		<title>Recover - <?php echo pageUserTitle(); ?></title>

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

	</head>
	<body>

		<div class="account-pages login-register-background"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
					<div class="text-center">
					<a href="../index.php"><img src="img/logo/logowfg.png" alt="" width="70px" height="70px"></a>
				</div>
					<h3 class="text-center"><i class='md md-restore'></i> Restore your account </h3>
				</div>

				<div class="panel-body">
					<div id="result"></div>
					<form class="form-horizontal m-t-20" action="admin/actionmanager.php" id="recoverform">
						<p>Enter your registered email or username to restore your account</p>
						<div class="form-group">
							<div class="col-xs-12 error" id="emaildiv">
								<input class="form-control" type="text" id="email" name="email" placeholder="Username or email">
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12">
								<div class="col-md-4">
									<img src="captcha.php" height="35px" /><br>
								</div><span class="visible-xs"><br></span>
								<div class="col-md-8 col-xs-12 error" id="captchadiv">
									<input class="form-control" type="text" id="captcha" name="captcha" placeholder="Enter captcha here">
								</div>
							</div>
						</div>

						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<div class="col-md-8 col-xs-8">
								<button class="btn btn-primary btn-block text-uppercase waves-effect waves-light" type="submit" id="recoverbutton">
									Restore
								</button>
							</div>
							<div class="col-md-4 col-xs-4">
								<button class="btn btn-danger btn-block text-uppercase waves-effect waves-light" type="button" id="loginresetbutton">
									Reset
								</button>
							</div>
							</div>
						</div>
					</form>
					<div class="pull-right m-t-40">
						<button type="button" class="btn btn-primary btn-custom btn-rounded waves-effect waves-light" onclick="location.href='login.php'" ><i class='fa fa-sign-in'></i> Login</button>
					</div>

				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
					<p class="login-footer">
						New member and want to register? <a href="register.php" class="text-primary m-l-5"><b>Register here</b></a>
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
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>


        <script src="assets/js/jquery.core.js"></script>
        <script src="js/custom.js"></script>

	</body>
</html>