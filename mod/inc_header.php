<?php
$dataRead = New DataRead();
$dataWrite = New DataWrite();
$mycon = databaseConnect();
 //get the details of the member
$currentuserid = getCookie("userid");

$memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);

if (!$memberdetails)
{
    openPage("login.php?logout=yes");
}

if ($memberdetails['memberstatus'] == '5')
{
    showAlert("Your accounts has been blocked, please contact support team!");
    openPage("login.php?logout=yes");
}
?>
 <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="../index.php" class="logo"><div class='mycustomlogo'><i class="fa fa-globe icon-c-logo"></i></div><span><img src="img/logo/logo.png" height="72" width="100%"/></span></a>
                        
                        <!-- Image Logo here -->
                    </div>
                </div>



                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left waves-effect waves-light">
                                    <i class="md md-menu"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                           


                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="hidden-xs">
                                    <a href="locked.php" class="waves-effect waves-light"><i class="ti-lock m-r-10"></i> Lock Screen</a>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                                </li>
                                <li class="dropdown top-menu-item-xs">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="member_image/<?php if ($memberdetails['picturestatus'] == '0') echo 'avatar.png'; else echo $memberdetails['username'].'.jpg'; ?>" alt="<?php echo $memberdetails['username'] ?>_photo" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="profile.php"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
                                        <li><a href="profile-account.php"><i class="ti-settings m-r-10 text-custom"></i> Bank Account</a></li>
                                        <li><a href="locked.php"><i class="ti-lock m-r-10 text-custom"></i> Lock screen</a></li>
                                        <li class="divider"></li>
                                        <li><a href="login.php?logout=yes"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                        	<li class="text-muted menu-title">Menu Navigation</li>

                            <li class="">
                                <a href="dashboard.php" class="waves-effect"><i class="ti-dashboard"></i> <span> Dashboard </span> </a>
                            </li>
                            <li class="">
                                <a href="wallet.php" class="waves-effect"><i class="md md-favorite"></i> <span> Fund Wallet </span> </a>
                            </li>
                             <li class="">
                                <a href="referrals.php" class="waves-effect"><i class="fa fa-users"></i> <span> Referrals </span></a>
                            </li>
                             <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ion-android-lightbulb"></i> <span> Testimonies </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="your-testimony.php"><i class="md md-folder"></i>Manage your testimonies</a></li>
                                    <li><a href="all-testimony.php"><i class="md md-folder-shared"></i> All testimonies</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user"></i> <span> Account Section </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="profile.php"><i class="md md-perm-identity"></i>Manage Personal Account</a></li>
                                    <li><a href="profile-account.php"><i class="md md-credit-card"></i> Manage Bank Accounts</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="support.php" class="waves-effect"><i class="ti-home"></i> <span> Support </span> </a>
                            </li>
                            <li class="">
                                <a href="system-rules.php" class="waves-effect"><i class="md md-devices"></i> <span> System Rules </span> </a>
                            </li>
                           
                            <?php 
                            if ($memberdetails['role'] == '1')
                            {

                            ?>
                             <hr>
                            <li class="text-muted menu-title">Admin Panel</li>
                             <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-exchange-vertical"></i> <span> Funds Requests </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="transfer-new.php"><i class="md md-file-upload"></i>New Transfer Fund Requests</a></li>
                                    <!-- <li><a href="receive-new.php"><i class="md md-file-download"></i> New Receive Funds Requests</a></li> -->
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="md md-people-outline"></i> <span> Matching Management</span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="matching-list.php"><i class="md md-format-line-spacing"></i>Matching Lists</a></li>
                                    <!-- <li><a href="receive-new.php"><i class="md md-file-download"></i> New Receive Funds Requests</a></li> -->
                                </ul>
                            </li>
                             <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="md md-apps"></i> <span>Member Management</span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="members-lists.php"><i class="ion-ios7-people"></i>All Members</a></li>
                                    <li><a href="register.php"><i class="ion-android-add-contact"></i> Add New Member</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="news.php" class="waves-effect"><i class="ion-social-rss"></i> <span>News From Admin</span> </a>
                            </li>
                            <?php
                            }

                            ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->
            <iframe name="actionframe" id="actionframe" width="2px" height="2px" frameborder="0"></iframe> 
           </aside>

<script type="text/javascript">
    window.setTimeout(function(){
        document.location.href="login.php?logout=yes";
    },900000);
</script>