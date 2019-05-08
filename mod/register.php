<?php

require_once("admin/config.php");
require_once("admin/inc_dbfunctions.php");

$mycon = databaseConnect();
$dataRead = New DataRead();



//get the country lists
$countrydetails = $dataRead->country_getall($mycon);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Earn Up to 50% on Every Fund Transfer You send to Other Participants. Wealth Fund Global">
		<meta name="author" content="Coderthemes">

		<link rel="shortcut icon" href="img/logo/logowfg.ico">

		<title>Create an account - <?php echo pageUserTitle(); ?></title>

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
					<h3 class="text-center"><span class="waves-effect waves-light" style="color: darkgreen"> Create an acount  </span></h3>
				</div>

				<div class="panel-body" id="step1">
						<p class="text-left text-primary is-required" > * is required </p>
						<div id="result"></div>
					<form class="form-horizontal m-t-20" action="admin/actionmanager.php" id="registerform">
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="referraldiv">
								<input class="form-control" name="referral" type="text" id="referral" placeholder="Referral Username or email" value=<?php if (getCookie("ref") != null) echo getCookie("ref"); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="firstnamediv">
								<input class="form-control" name="firstname" type="text" id="firstname" placeholder="Firstname*">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="lastnamediv">
								<input class="form-control" type="text" name="lastname" id="lastname" placeholder="Lastname*">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="usernamediv">
								<input class="form-control" type="text" name="username" id="username" placeholder="Username*">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 col-xs-12 error" id="phonenumberdiv">
								<input class="form-control" type="text" name="phonenumber" id="phonenumber" placeholder="Phone number*">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="emaildiv">
								<input class="form-control" type="email" name="email" id="email" placeholder="Email*">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="passworddiv">
								<input class="form-control" type="password" name="password" id="password" placeholder="Password*">
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="confirmpassworddiv">
								<input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Repeat Password*">
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12 col-md-12 error" id="sexdiv">
								<select name="sex" id="sex" class="form-control">
									   <option value="">Choose gender*</option>
									   <option value="Female">Female</option>
									   <option value="Male">Male</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-md-12 error" id="countrydiv">
								<select name="country" id="country" class="form-control">
									<option value="">Choose country*</option>
									<?php
									foreach ($countrydetails as $row)
									{
									?>
									<option value="<?php echo $row['nicename'] ?>" <?php if ($row['nicename'] == 'Nigeria') echo "selected" ?> ><?php echo $row['nicename'] ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12" id="addressdiv">
								<textarea class="form-control" rows="5" name="address" id="address" placeholder="Address"></textarea>
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12">
								<div class="col-md-4">
									<img src="captcha.php" height="35px" /><br>
								</div><span class="visible-xs"><br></span>
								<div class="col-md-8 error" id="captchadiv">
									<input class="form-control" type="text"  name="captcha" id="captcha" placeholder="Enter captcha here">
								</div>
							</div> 
						</div>

						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<div class="col-md-8 col-xs-8">
									<button class="btn btn-primary btn-block text-uppercase waves-effect waves-light"  id="createaccountbutton" type="submit">
									Setup my account!
									</button>
								</div>
								<div class="col-md-4 col-xs-4">
									<button class="btn btn-danger btn-block text-uppercase waves-effect waves-light" id="resetbutton" type="button">
									Reset
									</button>
								</div>
							</div>
						</div>

					</form>

				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
					<p class="login-footer">
						Already a member?<a href="login.php" class="text-primary m-l-5"><b>Log In</b></a>
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