<?php

require_once("inc_dbfunctions.php");
require_once("config.php");

$actionmanager = New ActionManager();

if(isset($_POST['command']) && $_POST['command'] == 'members_add')
{
    $actionmanager->members_add();
}
else if(isset($_POST['command']) && $_POST['command'] == 'token_add')
{
    $actionmanager->members_token_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "memberlogin")
{
    $actionmanager->member_login();
}
elseif(isset($_POST['command']) && $_POST['command'] == "bankaccountdetails_add")
{
    $actionmanager->bankaccountdetails_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "bankaccountdetails_update")
{
    $actionmanager->bankaccountdetails_update();
}
elseif(isset($_POST['command']) && $_POST['command'] == "members_update")
{
    $actionmanager->members_update();
}
elseif(isset($_POST['command']) && $_POST['command'] == "transfers_add")
{
    $actionmanager->transfers_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "receives_add")
{
    $actionmanager->receives_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "transfer_delete")
{
    $actionmanager->transfer_delete();
}
elseif(isset($_POST['command']) && $_POST['command'] == "transfer_refresh")
{
    $actionmanager->transfer_refresh();
}
elseif(isset($_POST['command']) && $_POST['command'] == "transfer_sort")
{
    $actionmanager->transfer_sort();
}
elseif(isset($_POST['command']) && $_POST['command'] == "available_balance")
{
    $actionmanager->available_balance();
}
elseif(isset($_POST['command']) && $_POST['command'] == "extendmatching")
{
    $actionmanager->extendmatching();
}
elseif(isset($_POST['command']) && $_POST['command'] == "evidence_add")
{
    $actionmanager->evidence_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "payment_confirm")
{
    $actionmanager->payment_confirm();
}
elseif(isset($_POST['command']) && $_POST['command'] == "matching_sort")
{
    $actionmanager->matching_sort();
}
elseif(isset($_POST['command']) && $_POST['command'] == "accountdetails_update")
{
    $actionmanager->accountdetails_update();
}
elseif(isset($_POST['command']) && $_POST['command'] == "memberrestore")
{
    $actionmanager->memberrestore();
}
elseif(isset($_POST['command']) && $_POST['command'] == "recovertoken_add")
{
    $actionmanager->recovertoken_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "password_update")
{
    $actionmanager->password_update();
}
elseif(isset($_POST['command']) && $_POST['command'] == "uploadfile")
{
    $actionmanager->uploadfile();
}
elseif(isset($_POST['command']) && $_POST['command'] == "unlock_account")
{
    $actionmanager->unlock_account();
}
elseif(isset($_POST['command']) && $_POST['command'] == "falsepayment")
{
    $actionmanager->falsepayment();
}
elseif(isset($_POST['command']) && $_POST['command'] == "testimony_add")
{
    $actionmanager->testimony_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "news_add")
{
    $actionmanager->news_add();
}
elseif(isset($_POST['command']) && $_POST['command'] == "news_edit")
{
    $actionmanager->news_edit();
}


class ActionManager
{

    function members_add()
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $phonenumber = $_POST['phonenumber'];
        $email = $_POST['email'];
        $gender = $_POST['sex'];
        $country = $_POST['country'];
        $referral = $_POST['referral'];
        $address = $_POST['address'];
        $captcha = $_POST['captcha'];
        
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        $count = 0;
        $captchaerror = '';
        $usernameerror = '';
        $emailerror = '';
        $phonenumbererror = '';
        $referralerror = '';
        $referralfinderror = '';
        
         //check if the captcha is eqaual to the session captcha
        if ($captcha != $_SESSION['captcha'])
        {
            $captchaerror = "Incorrect Captcha.";
            echo "<script type='text/javascript'>
                    $('#captchadiv').addClass('has-error');
                    </script>";
             $count = $count + 1;
        }
        //check if username exists
        $username_check = $dataRead->member_getbyusername($mycon, $username);
        if ($username_check != false)
        {
            $usernameerror = "<br>Username already exists.";
            echo "<script type='text/javascript'>
                    $('#usernamediv').addClass('has-error');
                    </script>";
             $count = $count + 1;
        }

        //check if email exists
        $email_check = $dataRead->member_getbyemail($mycon,$email);
        if ($email_check != false)
        {
            $emailerror = "<br> Email already exists.";
            echo "<script type='text/javascript'>
                    $('#emaildiv').addClass('has-error');
                    </script>";           
             $count = $count + 1;
        }

        //check if phonenumber exists
        $phonenumber_check = $dataRead->member_getbyphonenumber($mycon,$phonenumber);
        if ($phonenumber_check != false)
        {
            $phonenumbererror = "<br> Phonenumber already exists.";
            echo "<script type='text/javascript'>
                    $('#phonenumberdiv').addClass('has-error');
                    </script>";           
             $count = $count + 1;
        }
        
        
        if ($referral == $username || $referral == $email)
        {
            $referralerror = "<br> You cannot make yourself a referral.";
            echo "<script type='text/javascript'>
                    $('#referraldiv').addClass('has-error');
                    </script>"; 
             $count = $count + 1;
        }
        //get the member_id of the referral
        if ($referral != null)
        {
          $referral_id = $dataRead->member_referral($mycon, $referral);
            if (!$referral_id)
            {
                $referralfinderror = "Referral could not be found.";
                echo "<script type='text/javascript'>
                    $('#referraldiv').addClass('has-error');
                    </script>"; 
                 $count = $count + 1;
            }  
        }

         if ($count != 0)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **".$count." error was found.<br>".$captchaerror." ".$usernameerror." ".$emailerror." ".$phonenumbererror
                    ." ".$referralerror." ".$referralfinderror.
                "</div>";
            return;
        }
        
        //if all was successful, send a message to the email of the person so as to continue its registrations
        $token = substr(str_shuffle(time()),0,8);
        createCookie("logintoken", $token);
         $sentmessage = "<div class='container'>
                                <p>Hello ".$username.",</p>
                                <p>Enter this token to continue your registration at World Fund Global (WFG): ". $token."  </p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";

            $sentmessage = wordwrap($sentmessage,70);
            /**createCookie("email", $email);
            createCookie("username", $username);
            createCookie("firstname", $firstname);
            createCookie("lastname", $lastname);
            createCookie("phonenumber", $phonenumber);
            createCookie("password", $password);
            createCookie("gender", $gender);
            createCookie("country", $country);
            createCookie("referral", $referral);
            createCookie("captcha", $captcha);
            createCookie("address", $address);

            $message = "A code has been sent to your email ".$email.". Please check to verify your account set up.".$token. ".";
            echo "<div id='successalert'>
                    <div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Almost done!</strong> ".$message."
                    </div>
                    </div>
                    <script type='text/javascript'>
                    $('#registerform').hide(500);
                    </script>
                    <form class='form-horizontal m-t-20' action='admin/actionmanager.php' id='emailverifyform'>
                            <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='tokendiv'>
                                    <input class='form-control' name='token' type='text' id='token' placeholder='Input token*''>
                                </div>
                            </div>
                            <div class='form-group text-center m-t-40'>
                            <div class='col-xs-12'>
                                <div class='col-md-8 col-xs-8'>
                                    <button class='btn btn-success btn-block text-uppercase waves-effect waves-light'  id='emailverifybutton' type='button' onclick='submitVerifyForm(this);'>
                                    Verify Account
                                    </button>
                                </div>
                                <div class='col-md-4 col-xs-4'>
                                    <button class='btn btn-danger btn-block text-uppercase waves-effect waves-light' id='emailclearbutton' onclick='resetToken();' type='button'>
                                    Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='form-group text-center m-t-40'>
                        <div class='col-xs-12'>
                                <div class='col-md-12 col-xs-12'>
                                    <button class='btn btn-primary btn-block text-uppercase waves-effect waves-light' type='button'  id='backtoregisterbutton' onclick='backtoRegistration();'>
                                    << Back to register form
                                    </button>
                                </div>
                            </div>
                            </div>
                        </form>;
                    </script>";
            return;
            **/

           if (sendEmail($email,"Registration Token - Wealth Fund Global", $sentmessage))
           {
                createCookie("email", $email);
                createCookie("username", $username);
                createCookie("firstname", $firstname);
                createCookie("lastname", $lastname);
                createCookie("password", $password);
                createCookie("gender", $gender);
                createCookie("country", $country);
                createCookie("referral", $referral);
                createCookie("phonenumber", $phonenumber);
                createCookie("captcha", $captcha);
                createCookie("address", $address);

                $message = "A code has been sent to your email ".$email.". Please check to activate your account.";
           
                echo "<div id='successalert'>
                    <div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Almost done!</strong> ".$message."
                    </div>
                    </div>
                    <script type='text/javascript'>
                    $('#registerform').hide(500);
                    </script>
                    <form class='form-horizontal m-t-20' action='admin/actionmanager.php' id='emailverifyform'>
                            <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='emailverifydiv'>
                                    <input class='form-control' name='emailverify' type='text' id='emailverify' value='".getCookie("email")."' disabled>
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='tokendiv'>
                                    <input class='form-control' name='token' type='text' id='token' placeholder='Input token*''>
                                </div>
                            </div>
                            <div class='form-group text-center m-t-40'>
                            <div class='col-xs-12'>
                                <div class='col-md-8 col-xs-8'>
                                    <button class='btn btn-success btn-block text-uppercase waves-effect waves-light'  id='emailverifybutton' type='button' onclick='submitVerifyForm(this);'>
                                    Verify Account
                                    </button>
                                </div>
                                <div class='col-md-4 col-xs-4'>
                                    <button class='btn btn-danger btn-block text-uppercase waves-effect waves-light' id='emailclearbutton' onclick='resetToken();' type='button'>
                                    Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='form-group text-center m-t-40'>
                        <div class='col-xs-12'>
                                <div class='col-md-12 col-xs-12'>
                                    <button class='btn btn-primary btn-block text-uppercase waves-effect waves-light' type='button'  id='backtoregisterbutton' onclick='backtoRegistration();'>
                                    << Back to register form
                                    </button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </script>";
                    return;
                }
            else
            {
                echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i> ** There was an error sending mail to your email, please check your network properly.
                        </div>";
                return;
            }
    
            
                      
    }

    function members_token_add()
    {
        $email = $_POST['email'];
        $token = $_POST['token'];

        //check if the token is correct
        if ($token != getCookie('logintoken'))
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> ** Invalid token.
                </div>";
            return;
        }

        //get all the cookies saved
        $firstname = getCookie("firstname");
        $lastname = getCookie("lastname");
        $email = getCookie("email");
        $username = getCookie("username");
        $password = getCookie("password");
        $phonenumber = getCookie("phonenumber");
        $gender = getCookie("gender");
        $country = getCookie("country");
        $referral = getCookie("referral");
        $address = getCookie("address");
        $captcha = getCookie("captcha");

        $expiry = date("Y-m-d H:i:s", strtotime("+ 3 days"));

        $password = generatePassword($password);
        
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();
        $count = 0;
        $captchaerror = '';
        $usernameerror = '';
        $phonenumbererror = '';
        $emailerror = '';
        $referralerror = '';
        $referralfinderror = '';
         //check if the captcha is eqaual to the session captcha
        if ($captcha != $_SESSION['captcha'])
        {
            $captchaerror = "Incorrect Captcha.";
            echo "<script type='text/javascript'>
                    $('#captchadiv').addClass('has-error');
                    </script>";
             $count = $count + 1;
        }
        //check if username exists
        $username_check = $dataRead->member_getbyusername($mycon, $username);
        if ($username_check != false)
        {
            $usernameerror = "<br>Username already exists.";
            echo "<script type='text/javascript'>
                    $('#usernamediv').addClass('has-error');
                    </script>";
             $count = $count + 1;
        }

        //check if email exists
        $email_check = $dataRead->member_getbyemail($mycon,$email);
        if ($email_check != false)
        {
            $emailerror = "<br> Email already exists.";
            echo "<script type='text/javascript'>
                    $('#emaildiv').addClass('has-error');
                    </script>";           
             $count = $count + 1;
        }

        //check if phonenumber exists
        $phonenumber_check = $dataRead->member_getbyphonenumber($mycon,$phonenumber);
        if ($phonenumber_check != false)
        {
            $phonenumbererror = "<br> Phonenumber already exists.";
            echo "<script type='text/javascript'>
                    $('#phonenumberdiv').addClass('has-error');
                    </script>";           
             $count = $count + 1;
        }
        
        if ($referral == $username || $referral == $email)
        {
            $referralerror = "<br> You cannot make yourself a referral.";
            echo "<script type='text/javascript'>
                    $('#referraldiv').addClass('has-error');
                    </script>"; 
             $count = $count + 1;
        }
        //get the member_id of the referral
        if ($referral != null)
        {
          $referral_id = $dataRead->member_referral($mycon, $referral);
            if (!$referral_id)
            {
                $referralfinderror = "Referral could not be found.";
                echo "<script type='text/javascript'>
                    $('#referraldiv').addClass('has-error');
                    </script>"; 
                 $count = $count + 1;
            }  
        }

         if ($count != 0)
        {
            echo "<script type='text/javascript'>
                    $('#emailverifyform').hide();
                    $('#registerform').show(500);
                    </script>
            <div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **".$count." error was found.<br>".$captchaerror." ".$usernameerror." ".$emailerror." ".$phonenumbererror." ".$referralerror." ".$referralfinderror.
                "</div>";
            return;
        }


        //start creating the user accounts
        //create the useracccount
        $member_id = '';
        if ($referral == null)
        {
            $member_id = $dataWrite->members_add($mycon,$username,$firstname,$lastname,$password,$email,$phonenumber, $gender,'1',$country,$expiry,$address, $captcha);
        }
        else $member_id = $dataWrite->members_add($mycon,$username,$firstname,$lastname,$password,$email,$phonenumber, $gender,$referral_id['member_id'],$country,$expiry,$address, $captcha);

        if (!$member_id)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Due to security reasons, an error was suspected when saving your information, you will be redirected to the register page to start again.
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='register.php';
            },2000);
                </script>";
            return;
        }

        //first clear off all the cookies before
        setcookie(str_rot13("firstname"),"",time()-3600);
        setcookie(str_rot13("lastname"),"",time()-3600);
        setcookie(str_rot13("email"),"",time()-3600);
        setcookie(str_rot13("username"),"",time()-3600);
        setcookie(str_rot13("password"),"",time()-3600);
        setcookie(str_rot13("gender"),"",time()-3600);
        setcookie(str_rot13("referral"),"",time()-3600);
        setcookie(str_rot13("country"),"",time()-3600);
        setcookie(str_rot13("address"),"",time()-3600);
        setcookie(str_rot13("captcha"),"",time()-3600);

        //generate my sessions cookies
        createCookie("userid",$member_id);
        createCookie("userlogin","YES");
        createCookie("adminlogin", "NO");
        createCookie("username",$username);
        createCookie("email", $email);
        createCookie("fullname",$lastname." ".$firstname);

        //send message to use that account has been verified
          $sentmessage = "<div class='container'>
                                <p>Hello ".$username.",</p>
                                <p>Account verification completed. Ensure you add your bank account details after you are redirected to your 
                                personalized dashboard. Bank account details can be found in the 'Account Section' of the menu items. 
                                Thank you! </p>
                                <p><small><em>This message is auto-generated, please do not reply via your email</em>M/small></p>
                            </div>";
        $sentmessage = wordwrap($sentmessage,70);
        if (sendEmail($email, 'Account verified - Wealth Fund Global', $sentmessage))
        {
             echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Success!</strong> We are preparing your dashboard, please wait...
                    </div>
                    <script type-'text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
            },2000);
                </script>";
        }
        else {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **An error occurred while sending message, please check your internet connection properly
                </div>";
        }
        
        
        /**echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Success!</strong> We are preparing your dashboard, please wait...
                    </div>
                    <script type-'text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
            },2000);
                </script>";
        **/
        return;
        
    }

    function member_login()
    {
        $mycon = databaseConnect();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        $thedate = date("Y-m-d H:i:s");
        
        $dataread = New DataRead();
        $dataWrite = New DataWrite();
        
        //generate the encoded password
        $password = generatePassword($password);


        $count = 0;
        //check if the captcha is equal to session capcha
        if ($captcha != $_SESSION['captcha'])
        {
            $captchaerror = "Incorrect Captcha.";
            echo "<script type='text/javascript'>
                    $('#captchadiv').addClass('has-error');
                    </script>";
             $count = $count + 1;
        }

         if ($count != 0)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **".$count." error was found.<br>".$captchaerror.
                "</div>";
            return;
        }
        
        //find the member details through th 
        //check whether the email and password exists
        $member_get = $dataread->member_getbyusernamepassword($mycon, $username, $password);
        

        if(!$member_get)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Username or password combination is wrong!
                </div>";
            return;
        }
        if (!$member_get['status'] == '0')
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Your account is blocked, please contact support!
                </div>";
            return;
        }
        
        
        
        createCookie("userid",$member_get['member_id']);
        createCookie("userlogin","YES");
        createCookie("adminlogin", "NO");
        createCookie("username",$member_get['username']);
        createCookie("email", $member_get['email']);
        createCookie("fullname",$member_get['firstname']." ".$member_get['lastname']);
        
         echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Success!</strong> We are preparing your dashboard, please wait...
                    </div>
                    <script type-'text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
            },2000);
                </script>";
        return;
        
    }

    function bankaccountdetails_add()
    {
        $currentuserid = getCookie("userid");
        $name = $_POST['name']." ".$_POST['surname'];
        $bankname = $_POST['bankname'];
        $bankaccountnumber = $_POST['bankaccountnumber'];
        $password = $_POST['password'];

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }

        //check if the password supplied is correct
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Wrong password!
                </div>";
            return;
        }


        //check if bankname, bankaccount number and name is already available
        $uniqueness_check = $dataRead->member_bankuniqueness($mycon, $bankaccountnumber);
        if ($uniqueness_check != false)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Sorry, these bank details already exists!
                </div>";
            return;
        }

        //update the account datails
        $member_update = $dataWrite->accountdetails_add($mycon, $currentuserid, $name, $bankaccountnumber, $bankname);
        if (!$member_update)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to perform this operation, please try again!
                </div>";
            return;
        }

        echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Success!</strong> Your bank account details has been added. Thanks.
                    </div>
                    <script type='text/javascript'>
                        $('#accountdetails_new').hide(500);
                        $('#name').val('');
                        $('#surname').val('');
                        $('#bankname').val('');
                        $('#bankaccountnumber').val('');
                        $('#password').val('');
                        $('.error').removeClass('has-error');
                        window.setTimeout(function(){
                            document.location.href='profile-account.php';
                        },3000);
                    </script>";
        return;

        
    }


 function bankaccountdetails_update()
    {
        $currentuserid = getCookie("userid");
        $name = $_POST['name'];
        $bankname = $_POST['bankname'];
        $bankaccountnumber = $_POST['bankaccountnumber'];
        $accountdetail_id = $_POST['accountdetail_id'];
        $password = $_POST['password'];

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }

        //check if the password supplied is correct
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Wrong password!
                </div>
                <script type='text/javascript'>
                    $('#passworddiv').addClass('has-error');
                    </script>";
            return;
        }


        //check if bankname, bankaccount number and name is already available
        $uniqueness_check = $dataRead->member_bankuniqueness($mycon, $bankaccountnumber);
        if ($uniqueness_check != false)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Sorry, these bank details already exists!
                </div>";
            return;
        }

        //update the account datails
        $member_update = $dataWrite->accountdetails_update($mycon, $name, $bankaccountnumber, $bankname, $accountdetail_id);
        if (!$member_update)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to perform this operation, please try again!
                </div>";
            return;
        }

        echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Success!</strong> Your bank account details has been updated. Thanks.
                    </div>
                    <script type='text/javascript'>
                        $('#accountdetails_new').hide(500);
                        $('#updatename').val('');
                        $('#updatesurname').val('');
                        $('#updatebankname').val('');
                        $('#updatebankaccountnumber').val('');
                        $('#updatepassword').val('');
                        $('.update').removeClass('has-error');
                        window.setTimeout(function(){
                            document.location.href='profile-account.php';
                        },3000);
                    </script>";
        return;

        
    }

    function members_update()
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password_old = $_POST['password'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $gender = $_POST['sex'];
        $country = $_POST['country'];
        $address = $_POST['address'];
        
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();
        $currentuserid = getCookie("userid");

        $count = 0;
        $phonenumbererror = '';
        
        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }
        
        //check if phonenumber exists
        $phonenumber_check = $dataRead->member_getbyphonenumberupdate($mycon, $currentuserid,$phonenumber);
        if ($phonenumber_check != false)
        {
            $phonenumbererror = "<br> Phonenumber already exists.";
            echo "<script type='text/javascript'>
                    $('#phonenumberdiv').addClass('has-error');
                    </script>"; 
            $count = $count + 1;
        }
        
        
         if ($count != 0)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **".$count." error was found.<br>".$phonenumbererror.
                "</div>";
            return;
        }

        //if password is null
        if ($password_old == '')
        {
            $password = $memberdetails['password'];
        }
        else $password = generatePassword($password_old);

        
        //if all was successful, send a message to the email of the person so as to continue its registrations
        $member_update = $dataWrite->members_update($mycon, $firstname, $lastname, $phonenumber, $gender, $country, $password, $address, $currentuserid);
        if (!$member_update)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to perform this operation, please try again!
                </div>";
            return;
        }
             echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Profile updated successful! refreshing..
                </div>";
        if ($password_old != '' && (generatePassword($password_old) != $memberdetails['password']))
        {
            echo "<script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },2000);
                </script>";
            }
            else {
                echo "<script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='profile.php';
            },2000);
                </script>";
            }
            return;
    }

    //add to the donation table
    function transfers_add()
    {
        $amount = $_POST['amount'];
        $bankaccounts = $_POST['bankaccounts'];
        $amountcustom = $_POST['amountcustom'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        $currentuserid = getCookie("userid");
        
        $dataRead =  New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }
        $count = 0;
        $captchaerror = '';
        $passworderror = '';
        $amountcustomerror = '';
        $amountcustomexceederror = '';
        $lasttransferrerror = '';

        if ($captcha != $_SESSION['captcha'])
        {
             $captchaerror = "Incorrect captcha code.
                            <script type='text/javascript'>
                            $('#captchadiv').addClass('has-error');
                            </script>";
            ++$count;
        }

        //check if the password supplied is correct
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             $passworderror = "<br>**Wrong password.
                <script type='text/javascript'>
                    $('#passworddiv').addClass('has-error');
                    </script>";
            ++$count;
        }
        

        if ($amount == 'notfound' && ($amountcustom > 1000000  || $amountcustom < 5000))
        {
             $amountcustomexceederror = "<br>**Amounts to transfer is out of range
                <script type='text/javascript'>
                    $('#amountcustomdiv').addClass('has-error');
                    </script>";
            ++$count;
        }
        
        if ($amount == 'notfound' &&  $amountcustom%1000 != 0)
        {
            $amountcustomerror = "<br>**Amounts to transfer must be in multiples of 1000
                <script type='text/javascript'>
                    $('#amountcustomdiv').addClass('has-error');
                    </script>";
            ++$count;
        }

        if ($amount == 'notfound')
        {
            $amount = $amountcustom;
        }

        //check the last order
        $lasttransferorder = $dataRead->donations_getbyidrecent($mycon,$currentuserid);
        if ($lasttransferorder != '' && $amount < $lasttransferorder['donation_ph'] )
        {
            $lasttransferrerror = "<br>**Sorry, you can not make a lesser transfer funds than previous ones.";
            ++$count;
        }

        if ($count != 0)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**".$count." error was found.<br>".$captchaerror." ".$passworderror." ".$amountcustomexceederror." ".$amountcustomerror."
                     ".$lasttransferrerror."
                </div>";
                return;
        }

        $firsttime = 0;
        //check if its a first time donation
        /**$donation_firsttime = $dataRead->donations_getlastdonation($mycon, $currentuserid);
        if ($donation_firsttime)
        {
            $firsttime = 1;
            if ($donation_firsttime['status'] != 0)
            {
                echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <i class='fa fa-warning'></i>**You have an existing fund on transfer. Please complete the transfer before adding a new one.
                    </div>";
                return;  
            }
        }**/

        //calculate 4 days from for transfer funds and 15 days for receiving fund
        $readydonation_ph = date("Y-m-d H:i:s", strtotime("+4 days"));
        $readydonation_gh = date("Y-m-d H:i:s", strtotime("+15 days"));
        
        //check if there's no donation_gh
        $checkdonation_gh = $dataRead->donations_gh_getall($mycon);
        $firststatus = '';
        if ($checkdonation_gh == null)
        {
            $firststatus = 5;
        }

        //add to the donation table
        if ($memberdetails['role'] == '1')
        {
            //calculate 4 days from for transfer funds and 15 days for receiving fund
            $readydonation_ph_admin = date("Y-m-d H:i:s", strtotime("-4 days"));
            $readydonation_gh_admin = date("Y-m-d H:i:s", strtotime("-12 days"));
            $createdon = date("Y-m-d H:i:s", strtotime("-11 days"));
            $donation_id = $dataWrite->donation_add_admin($mycon,$amount,$currentuserid,$readydonation_ph_admin,$readydonation_gh_admin,$bankaccounts,$firsttime, $firststatus, $createdon);
        }
        else
        {
            $donation_id = $dataWrite->donation_add($mycon,$amount,$currentuserid,$readydonation_ph,$readydonation_gh,$bankaccounts,$firsttime, $firststatus);
        }
        if (!$donation_id)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**There was an error processing your request, please try again later.
                </div>";
                return;
        }

         $sentmessage = "<div class='container'>
                                <p>Hello ".$memberdetails['username'].",</p>
                                <p>You have successfully placed a new order on Wealth Fund Global Network. Amount placed is ".$amount." </p>
                                <p> Please ensure you continue checking your page to see if you have been matched. Matching takes place between 5 - 7 days after.</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";
        if (sendEmail($memberdetails['email'],"New Order - Wealth Fund Global", $sentmessage) && sendEmail('flexydoe001@gmail.com',"New Order Created- Wealth Fund Global", $sentmessage) && sendEmail('godwinshobowale@gmail.com',"New Order Created- Wealth Fund Global", $sentmessage))
        {
            echo $donation_id;
            return;
        }

        /**echo $donation_id;
        return; **/
        

        
    }

    //delete a transfer fund request
    function transfer_delete()
    {
        $donation_id = $_POST['removefund'];
        $currentuserid = getCookie("userid");
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if the donation request exist
        $donationrequest_exist = $dataRead->donationrequest_getbyid($mycon, $donation_id);
        
            if (!$donationrequest_exist)
            {
                 echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>**Sorry, this fund no longer exists, please try again.
                        </div>";
                return;
            }
            //delete the transfer funds request
            $donationrequest_delete = $dataWrite->donationrequest_delete($mycon, $donation_id);
            if (!$donationrequest_delete)
            {
                echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>**An error occurred while deleting your donation, please try again!
                        </div>";
                return;
            }

            if ($donationrequest_exist['donation_gh'] != '')
            {
                $donationdetailsmember = $dataRead->donationsreceivable_getbyidmember($mycon, $currentuserid);

                //remove from the donations receivable table
                $updateamount = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$currentuserid, $donationdetailsmember['withdrawn'] - $donationrequest_exist['donation_gh'] ,$donationdetailsmember['balance'] + $donationrequest_exist['donation_gh']); 
            }
            

             echo "<div class='alert alert-success alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                                <strong><i class='fa fa-smile-o'></i> Success!</strong>funds request successfully deleted! refreshing
                            </div>";
                return;

    }
         

    function transfer_refresh()
    {
        $donation_id = $_POST['refreshfund'];
        $currentuserid = getCookie("userid");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if the donations still exists with status of 5
        $donationrequest_exist = $dataRead->donationrequest_getbyidstatus($mycon, $donation_id, '5');
        if ($donationrequest_exist != '')
        {
             echo "<div class='portlet'>
                                    <div class='portlet-heading bg-primary'>
                                        <h3 class='portlet-title'>
                                           New Requests
                                        </h3>
                                        <div class='portlet-widgets'>
                                            <a href='javascript:void(0);' onclick='refreshTransferFund(".$donation_id.");' data-toggle='reload'><i class='ion-refresh'></i></a>
                                            <span class='divider'></span>
                                            <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$donation_id."'><i class='ion-minus-round'></i></a>
                                            <span class='divider'></span>
                                            <a href='javascript:void(0);' onclick='deleteTransferFund(".$donation_id.");' data-toggle='remove'><i class='ion-close-round'></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>";
            if ($donationrequest_exist['donation_ph'] != '')
            {
                echo "<div id='bg-primary".$donation_id."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> You created a new transfer fund request order.</p>
                                            <p> Amount: ".$donationrequest_exist['donation_ph'] ."</p>
                                            <hr>
                                            <p> Status: Pending</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$donation_id."'>Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade ".$donation_id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>You have created a new transfer fund request order</p>
                                                  <p>Amount to transfer: ".$donationrequest_exist['donation_ph']. "</p>
                                                  <p>Please wait patiently as we find another participants for you. Thanks</p>
                                                  <p>Status: Pending</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
            }
            else 
            {
                echo "<div id='bg-primary".$donation_id."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> You created a new receive fund request order.</p>
                                            <p> Amount: ".$donationrequest_exist['donation_gh'] ."</p>
                                            <hr>
                                            <p> Status: Pending</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$donation_id."'>Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade ".$donation_id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>You have created a new receive fund request order</p>
                                                  <p>Amount to receive: ".$donationrequest_exist['donation_gh']. "</p>
                                                  <p>Please wait patiently as we find another participants for you. Thanks</p>
                                                  <p>Status: Pending</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
            }
                                    
            return;
        }

        //check if the donations still exists with status of 3
        $donationrequest_exist = $dataRead->donationrequest_getbyidstatus($mycon, $donation_id, '3');
        if ($donationrequest_exist != '')
        {
            echo "<div class='portlet'>
                                    <div class='portlet-heading bg-danger'>
                                        <h3 class='portlet-title'>
                                           Matched Request
                                        </h3>
                                        <div class='portlet-widgets'>
                                            <a href='javascript:void(0);' onclick='refreshTransferFund(".$donation_id.");' data-toggle='reload'><i class='ion-refresh'></i></a>
                                            <span class='divider'></span>
                                            <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$donation_id."'><i class='ion-minus-round'></i></a>
                                            <span class='divider'></span>
                                            <a href='javascript:void(0);' onclick='deleteTransferFund(".$donation_id.");' data-toggle='remove'><i class='ion-close-round'></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>";
            if ($donationrequest_exist['donation_ph'] != '')
            {
                echo "<div id='bg-primary".$donation_id."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been matched.</p>
                                            <p> Amount: ".$donationrequest_exist['donation_ph'] ."</p>
                                            <hr>
                                            <p> Status: Matched</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$donation_id."'>Details</button>
                                            </div>
                                        <div class='modal fade ".$donation_id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Matched request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>Your transfer order has been processed. You have been matched to pay.</p>
                                                  <p>Amount to transfer: ".$donationrequest_exist['donation_ph']. "</p>
                                                  <p>You have been matched with another participants. Please attend to your transfer order request.</p>
                                                  <p>Status: Matched</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
            } 
            else 
            {
                echo "<div id='bg-primary".$donation_id."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been matched.</p>
                                            <p> Amount: ".$donationrequest_exist['donation_gh'] ."</p>
                                            <hr>
                                            <p> Status: Matched</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$donation_id."'>Details</button>
                                            </div>
                                        <div class='modal fade ".$donation_id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Matched request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>Your receive order has been processed. You have been matched to receive.</p>
                                                  <p>Amount to receive: ".$donationrequest_exist['donation_gh']. "</p>
                                                  <p>You have been matched with another participants. Please attend to your receive order request.</p>
                                                  <p>Status: Matched</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
            }                                   
                                    
            return;
        }        
         //check if the donations still exists with status of 0 shows confirmed order
        $donationrequest_exist = $dataRead->donationrequest_getbyidstatus($mycon, $donation_id, '0');
        if ($donationrequest_exist != '')
        {
             echo "<div class='portlet'>
                                    <div class='portlet-heading bg-success'>
                                        <h3 class='portlet-title'>
                                           Confirm Request
                                        </h3>
                                        <div class='portlet-widgets'>
                                            <a href='javascript:void(0);' onclick='refreshTransferFund(".$donation_id.");' data-toggle='reload'><i class='ion-refresh'></i></a>
                                            <span class='divider'></span>
                                            <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$donation_id."'><i class='ion-minus-round'></i></a>
                                            <span class='divider'></span>
                                            <a href='javascript:void(0);' onclick='deleteTransferFund(".$donation_id.");' data-toggle='remove'><i class='ion-close-round'></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>";
                if ($donationrequest_exist['donation_ph'] != '')
                {
                    echo "<div id='bg-primary".$donation_id."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been confirmed.</p>
                                            <p> Amount: ".$donationrequest_exist['donation_ph'] ."</p>
                                            <hr>
                                            <p> Status: Confirmed</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$donation_id."'>Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade ".$donation_id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Confirmed request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>Your transfer order has been confirmed.</p>
                                                  <p>Amount to transfer: ".$donationrequest_exist['donation_ph']. "</p>
                                                  <p>Your order has been sucessfully confirmed by the matched participants. Thank you!</p>
                                                  <p>Status: Confirmed</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
                }

                else
                {
                    echo "<div id='bg-primary".$donation_id."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been confirmed.</p>
                                            <p> Amount: ".$donationrequest_exist['donation_gh'] ."</p>
                                            <hr>
                                            <p> Status: Confirmed</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$donation_id."'>Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade ".$donation_id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Confirmed request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>Your receive order has been confirmed.</p>
                                                  <p>Amount to receive: ".$donationrequest_exist['donation_gh']. "</p>
                                                  <p>Your order has been sucessfully confirmed by the matched participants. Thank you!</p>
                                                  <p>Status: Confirmed</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
                }
                                    
            return;
        }        

    }   

    function transfer_sort()
    {
        $value = $_POST['value'];
        $currentuserid = getCookie("userid");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if the donations still exists with status of 5
           
        if ($value == '5')
        {
        $donationrequest_exist = $dataRead->donations_getbyidstatus($mycon, $currentuserid, $value);
        if ($donationrequest_exist )
        {
            foreach($donationrequest_exist as $row)
            {
             echo "<div class='portlet'>
                                    <div class='portlet-heading bg-primary'>
                                        <h3 class='portlet-title'>
                                           New Requests
                                        </h3>
                                        <div class='portlet-widgets'>
                                            <a href='javascript:void(0);' onclick='refreshTransferFund(".$row['donation_id'].");' data-toggle='reload'><i class='ion-refresh'></i></a>
                                            <span class='divider'></span>
                                            <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$row['donation_id']."'><i class='ion-minus-round'></i></a>
                                            <span class='divider'></span>
                                            <a href='javascript:void(0);' onclick='deleteTransferFund(".$row['donation_id'].");' data-toggle='remove'><i class='ion-close-round'></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>";
                if ($row['donation_ph'] != '')
                {
                    echo "<div id='bg-primary".$row['donation_id']."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> You created a new transfer fund request order.</p>
                                            <p> Amount: ".$row['donation_ph']."</p>
                                            <hr>
                                            <p> Status: Pending</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$row['donation_id']."'>Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade ".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>You have created a new transfer fund request order</p>
                                                  <p>Amount to transfer: ".$row['donation_ph']. "</p>
                                                  <p>Please wait patiently as we find another participants for you. Thanks</p>
                                                  <p>Status: Pending</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
                }
                else {
                    echo "<div id='bg-primary".$row['donation_id']."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> You created a new receive fund request order.</p>
                                            <p> Amount: ".$row['donation_gh']."</p>
                                            <hr>
                                            <p> Status: Pending</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$row['donation_id']."'>Details</button>
                                            </div>
                                        </div>
                                        <div class='modal fade ".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>You have created a new receive fund request order</p>
                                                  <p>Amount to receive: ".$row['donation_gh']. "</p>
                                                  <p>Please wait patiently as we find another participants for you. Thanks</p>
                                                  <p>Status: Pending</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
                }
                                    
                        }
            return;
        }
    }

    else if ($value == '3')
    {
        //check if the donations still exists with status of 3
        $donationrequest_exist = $dataRead->donations_getbyidstatus($mycon, $currentuserid, $value);
        if ($donationrequest_exist)
        {
            foreach($donationrequest_exist as $row)
            {
                echo "<div class='portlet'>
                                    <div class='portlet-heading bg-danger'>
                                        <h3 class='portlet-title'>
                                           Matched Request
                                        </h3>
                                        <div class='portlet-widgets'>
                                            <a href='javascript:void(0);' onclick='refreshTransferFund(".$row['donation_id'].");' data-toggle='reload'><i class='ion-refresh'></i></a>
                                            <span class='divider'></span>
                                            <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$row['donation_id']."'><i class='ion-minus-round'></i></a>
                                            <span class='divider'></span>
                                            <a href='javascript:void(0);' onclick='deleteTransferFund(".$row['donation_id'].");' data-toggle='remove'><i class='ion-close-round'></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>";
                if ($row['donation_ph'] != '')
                {
                    echo "<div id='bg-primary".$row['donation_id']."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been matched.</p>
                                            <p> Amount: ".$row['donation_ph'] ."</p>
                                            <hr>
                                            <p> Status: Matched</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$row['donation_id']."'>Details</button>
                                            </div>
                                        <div class='modal fade ".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Matched request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>Your transfer order has been processed. You have been matched to pay.</p>
                                                  <p>Amount to transfer: ".$row['donation_ph']. "</p>
                                                  <p>You have been matched with another participants. Please attend to your transfer order request.</p>
                                                  <p>Status: Matched</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
                }
                else
                {
                    echo "<div id='bg-primary".$row['donation_id']."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>
                                            <p> Your order has been matched.</p>
                                            <p> Amount: ".$row['donation_gh'] ."</p>
                                            <hr>
                                            <p> Status: Matched</p>
                                            <p class='text-right'>
                                               <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$row['donation_id']."'>Details</button>
                                            </div>
                                        <div class='modal fade ".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-sm'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Matched request details</h4>
                                                </div>
                                                <div class='modal-body'>
                                                  <p>Your receive order has been processed. You have been matched to receive.</p>
                                                  <p>Amount to receive: ".$row['donation_ph']. "</p>
                                                  <p>You have been matched with another participants. Please attend to your receive order request.</p>
                                                  <p>Status: Matched</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>";
                }
                                    
                }
            return;
        }
        }

        else if ($value == '0')
        {    
             //check if the donations still exists with status of 0 shows confirmed order
            $donationrequest_exist = $dataRead->donations_getbyidstatus($mycon, $currentuserid, $value);
            if ($donationrequest_exist)
            {
                foreach ($donationrequest_exist as $row)
                {        
                 echo "<div class='portlet'>
                                        <div class='portlet-heading bg-success'>
                                            <h3 class='portlet-title'>
                                               Confirm Request
                                            </h3>
                                            <div class='portlet-widgets'>
                                                <a href='javascript:void(0);' onclick='refreshTransferFund(".$row['donation_id'].");' data-toggle='reload'><i class='ion-refresh'></i></a>
                                                <span class='divider'></span>
                                                <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$row['donation_id']."'><i class='ion-minus-round'></i></a>
                                                <span class='divider'></span>
                                                <a href='javascript:void(0);' onclick='deleteTransferFund(".$row['donation_id'].");' data-toggle='remove'><i class='ion-close-round'></i></a>
                                            </div>
                                            <div class='clearfix'></div>
                                        </div>";
                    if ($row['donation_ph'] != '')
                    {
                        echo "<div id='bg-primary".$row['donation_id']."' class='panel-collapse collapse in'>
                                            <div class='portlet-body'>
                                                <p> Your order has been confirmed.</p>
                                                <p> Amount: ".$row['donation_ph'] ."</p>
                                                <hr>
                                                <p> Status: Confirmed</p>
                                                <p class='text-right'>
                                                   <button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$row['donation_id']."'>Details</button>
                                                </div>
                                            </div>
                                            <div class='modal fade ".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                            <div class='modal-dialog modal-sm'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                        <h4 class='modal-title' id='mySmallModalLabel'>Confirmed request details</h4>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <p>Your transfer order has been confirmed.</p>
                                                      <p>Amount to transfer: ".$row['donation_ph']. "</p>
                                                      <p>Your order has been sucessfully confirmed by the matched participants. Thank you!</p>
                                                      <p>Status: Confirmed</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>";
                    }
                    else
                    {
                        echo "<div id='bg-primary".$row['donation_id']."' class='panel-collapse collapse in'>
                                            <div class='portlet-body'>
                                                <p> Your order has been confirmed.</p>
                                                <p> Amount: ".$row['donation_gh'] ."</p>
                                                <hr>
                                                <p> Status: Confirmed</p>
                                                <div class='text-right'>";
                        if ($row['testimonialstatus'] == '1' && $row['donation_gh'] != '') 
                        {
                            echo "<button class='btn btn-success btn-xs waves-effect waves-light' data-toggle='modal' data-target='.t".$row['donation_id']."'><i class='fa fa-warning'></i> Upload testimony</button>";
                        }
                        elseif ($row['testimonialstatus'] == '5' && $row['donation_gh'] != '')
                        {
                        echo "<button class='btn btn-success btn-xs waves-effect waves-light'><i class='fa fa-check'></i> Testimony saved</button>";
                        }
                        echo "<button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='.".$row['donation_id']."'>Details</button>
                                                </div>
                                            </div>
                                            <div class='modal fade ".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                            <div class='modal-dialog modal-sm'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                        <h4 class='modal-title' id='mySmallModalLabel'>Confirmed request details</h4>
                                                    </div>
                                                    <div class='modal-body'>
                                                      <p>Your receive order has been confirmed.</p>
                                                      <p>Amount to receive: ".$row['donation_gh']. "</p>
                                                      <p>Your order has been sucessfully confirmed by the matched participants. Thank you!</p>
                                                      <p>Status: Confirmed</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class='modal fade t".$row['donation_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                                        <div class='modal-dialog modal-lg'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                                    <h4 class='modal-title' id='mySmallModalLabel'>Upload Testimony</h4>
                                            </div>
                                                <div class='modal-body'>
                                                  <h3> You received a sum of ".$row['donation_gh']." in your last receive request order. Please write a testimony letter to help us grow this community.
                                                    A testimony letter should contain the following: </h3>
                                                    <p><ol>
                                                            <li>Your Name e.g Linda Flemmings</li>
                                                            <li>Your location e.g Texas, United States</li>
                                                            <li>The last date you made a transfer request order and the amount </li>
                                                            <li>The date you received payment. </li>
                                                            <li>And the amount received. </li>
                                                        </ol></p>
                                                    <p> For example, <br>
                                                        <span style='color: #FF0000; font-weight: bold'>My Name is Linda Flemmings and i live in Texas, United State. I made a transfer request order on the 20th April, 2016 with the sum of 5000 and I received
                                                        the sum of 8000 on the 5th of May, 2016. Thanks to Wealth Fund Global! </span></p>
                                                        <div id='testimonyresult".$row['donation_id']."'></div>
                                                        <div class='row'> 
                                                        <div class='col-md-12'> 
                                                            <div class='form-group testimony error' id='testimonydiv".$row['donation_id']."'> 
                                                                <label for='testimony' class='control-label'>Testimony letter</label> 
                                                                <textarea class='form-control' name='testimnony' id='testimony".$row['donation_id']."' rows='5' placeholder='Write testimony letter here...''></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class='text-center'>
                                                        <div class='button-list'>
                                                            <button type='button' class='btn btn-success btn-custom waves-effect waves-light' id='testimonybutton".$row['donation_id']."' onclick='testimony(".$row['donation_id'].");'><i class='fa fa-check'></i> Save</button> 
                                                            <button type='button' class='btn btn-info btn-custom waves-effect waves-light' data-dismiss='modal'>Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                    }
                                        
                    }
                return;
            }        
        }

    }


    function receives_add()
    {
        $amount = $_POST['amount'];
        $bankaccounts = $_POST['bankaccounts'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];
        $currentuserid = getCookie("userid");
        
        $dataRead =  New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }
        $count = 0;
        $captchaerror = '';
        $passworderror = '';
        $amountcustomexceederror = '';
        $lasttransferrerror = '';
        $amountcustomerror = '';
        $lastdonationerror = '';

        if ($captcha != $_SESSION['captcha'])
        {
             $captchaerror = "Incorrect captcha code.
                            <script type='text/javascript'>
                            $('#captchareceivediv').addClass('has-error');
                            </script>";
            ++$count;
        }

        //check if the password supplied is correct
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             $passworderror = "<br>**Wrong password.
                <script type='text/javascript'>
                    $('#passwordreceivediv').addClass('has-error');
                    </script>";
            ++$count;
        }
        

        if ($amount > 1500000 && $amount < 5000)
        {
             $amountcustomexceederror = "<br>**Amounts to receive is out of range
                <script type='text/javascript'>
                    $('#amountreceivediv').addClass('has-error');
                    </script>";
            ++$count;
        }
        
        if ($amount%1000 != 0)
        {
            $amountcustomerror = "<br>**Amounts to receive must be in multiples of 1000
                <script type='text/javascript'>
                    $('#amountreceivediv').addClass('has-error');
                    </script>";
            ++$count;
        }

        //check if any of its PH exists that is greater than 15 days
        $exists = strtotime("-30 days");
        //get all donations ph made by the member
        $donationsgetall = $dataRead->donations_getidmember_limit($mycon, $currentuserid);
        //var_dump($donationsgetall);
        if ($exists > strtotime($donationsgetall['createdon']))
        {
            $lastdonationerror = "<br>**Sorry, You need to transfer fund again before you can receive any funds.
                <script type='text/javascript'>
                    $('#amountreceivediv').addClass('has-error');
                    </script>";
            ++$count;
        }

        if ($count != 0)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**".$count." error was found.<br>".$captchaerror." ".$passworderror." ".$amountcustomexceederror." ".$amountcustomerror." "
                    .$lasttransferrerror." ".$lastdonationerror."
                </div>";
                return;
        }

        //get the available balance for the member
        $availablebalance = $dataRead->donationsreceivable_getbyidmember($mycon, $currentuserid);
        if (($availablebalance['balance'] < 1000 || $availablebalance['amount'] < $amount))
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>** Invalid fund request
                </div>
                <script type='text/javascript'>
                    $('#amountreceivediv').addClass('has-error');
                    </script>";
            return;
        }

        $firsttime = 0;
        //check if its a first time donation
        $donation_firsttime = $dataRead->donation_getbyid($mycon, $currentuserid);
        if ($donation_firsttime)
        {
            $firsttime = 1;
        }
        
        //calculate 3 days from now to transfer fund request again
        $readydonation_ph = date("Y-m-d H:i:s", strtotime("+3 days"));
        $readydonation_gh = date("Y-m-d H:i:s");

        //add to the donation table
        $donation_id = $dataWrite->donation_add_gh($mycon,$amount,$currentuserid,$readydonation_ph,$readydonation_gh,$bankaccounts,$firsttime);
        if (!$donation_id)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**Unable to save your request, please try again later.
                </div>";
            return;
        }
        //update to the donation receive request fund
        $updatefundrequest = $dataWrite->donationsreceivable_updatewithdrawn($mycon,$currentuserid, $amount, $availablebalance['amount'] - $amount);    
        if (!$updatefundrequest)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**Unable to save your request, please try again later.
                </div>";
            return;
        }


         $sentmessage = "<div class='container'>
                                <p>Hello ".$memberdetails['username'].",</p>
                                <p>You have successfully placed a new receive order on Wealth Fund Global Network. Amount placed is ".$amount." </p>
                                <p> Ensure you continue to check your dashboard.</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";
        if (sendEmail($memberdetails['email'],"New Order - Wealth Fund Global", $sentmessage) && sendEmail('flexydoe001@gmail.com',"New Order Created- Wealth Fund Global", $sentmessage) && sendEmail('support@wealthfundglobal.com',"New Order Created- Wealth Fund Global", $sentmessage))
        {
            echo $donation_id;
            return;
        }
        
        /**echo $donation_id;
        return;**/
    } 



    //get the available balance
    function available_balance()
    {
        $currentuserid = getCookie("userid");
        $dataRead = New DataRead();
        $mycon = databaseConnect();
        $availabletowithdrawn = $dataRead->donationsreceivable_getbyidmember($mycon, $currentuserid);

        echo $availabletowithdrawn['balance'];
    }  


    function extendmatching()
    {
        $matching_id = $_POST['matching_id'];
        $password = $_POST['password'];
        $currentuserid = getCookie("userid");
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        $count = 0;
        $passworderror = '';
        $matchingfinderror = '';
        $updatematchingerror = '';

        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }

         //check if the password supplied is correct
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             $passworderror = "<br>**Wrong password.
                <script type='text/javascript'>
                    $('#extendpassworddiv'".$matching_id.").addClass('has-error');
                    </script>";
            ++$count;
        }

        //find the donation matching
        $donationmatchingfind = $dataRead->matching_getbyid($mycon, $matching_id);
        if (!$donationmatchingfind)
        {
            $matchingfinderror =  "<br>**Transfer match could not be found.";
            ++$count;
        }

        if ($count != 0)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**".$count." error was found.".$passworderror." ".$matchingfinderror."
                </div>";
                return;
        }

        //update the expiry date of the donation matching by 24 hours
        $extendtime = date("Y-m-d H:i:s", strtotime("+1 day", strtotime($donationmatchingfind['expirydate'])));
        $updatematchingexpirydate = $dataWrite->updateMatchingExpiryDate($mycon, $matching_id, $extendtime);

        if (!$updatematchingexpirydate)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>** Error performing operation
                </div>";
                return;
        }

        echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-smile-o'></i>****Expiry date successfully extended. Refreshing... 
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
            },3000);
                </script>";
    }




    //add evidence
    function evidence_add()
    {
        $evidence = $_FILES['uploadevidence'];
        $matching_id = $_POST['matching_id'];
        $amountpaid = $_POST['amountpaid'];
        $currentuserid = getCookie("userid");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        if ($amountpaid == '' || $evidence['size'] <= 0)
        {
            showAlert("Please fill the required information before sending.");
            return;
        }

        //get the amount paid compared to the donation in the matching
        $getmatching = $dataRead->matching_getbyid($mycon, $matching_id);
        if ($amountpaid != $getmatching['amount'])
        {
            showAlert("Please specify the real amount paid.");
            return;
        }

        $mycon->beginTransaction();
        if(strpos(strtoupper($evidence['type']),"IMAGE") > -1) 
            {
                //set the matching status to 3 after uploading evidence
                 $updatematchingstatus = $dataWrite->updateMatchingStatus($mycon, $matching_id, '3');
                 
                 if(!$updatematchingstatus)
                 {
                    $mycon->rollBack();
                    showAlert("Unable to perform operation.");
                    return;
                 }

        move_uploaded_file($evidence['tmp_name'],"../evidence/".$matching_id.".jpg");
            }
            else {
                showAlert("Only Image Evidence is allowed.");
                return;
            }

        
        $mycon->commit();
        showAlert("Evidence successfully uploaded.");
        openPage("../dashboard.php");

    }


    //confirm payment
    function payment_confirm()
    {
        $password = $_POST['password'];
        $matching_id = $_POST['matching_id'];
        $currentuserid = getCookie("userid");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();
        $count = 0;

        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }

         //check if the password supplied is correct
        $count = 0;
        $passworderror = '';
        $matchingfinderror = '';
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             $passworderror = "<br>**Wrong password.
                <script type='text/javascript'>
                    $('#extendpassworddiv'".$matching_id.").addClass('has-error');
                    </script>";
            ++$count;
        }

        //find the donation matching
        $donationmatchingfind = $dataRead->matching_getbyid($mycon, $matching_id);
        if (!$donationmatchingfind)
        {
            $matchingfinderror =  "<br>**Transfer match could not be found.";
            ++$count;
        }

        if ($count != 0)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**".$count." error was found.".$passworderror." ".$matchingfinderror."
                </div>";
            return;
        }

        //get the detials of the matching
        $getmatching = $dataRead->matching_getbyid($mycon, $matching_id);

        $mycon->beginTransaction();

        //get the donation details of the transfer with status of equal to 3 as merged
        $donationtransfer = $dataRead->donationrequest_getbyidstatus($mycon, $getmatching['transferfund_id'], '3');
        //update this transfer to equal to status of 0
        $updateTransfer = $dataWrite->donationsupdatestatus($mycon, $getmatching['transferfund_id'], '0', '5');
        if(!$updateTransfer)
        {
            $mycon->rollBack();
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**an error occured updating the this donor, please try again later.
                </div>";
            return;

        }

        //update the receive to equal to status of 0
        $updateMatching = $dataWrite->updateMatchingStatus($mycon, $getmatching['matching_id'], '0'); 
        if(!$updateMatching)
        {
                $mycon->rollBack();
                echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <i class='fa fa-warning'></i>**an error occured during confirmation, please try again later.
                    </div>";
                return;

            }
        //get the donations of the receiver in the donation table
        $donationreceiver = $dataRead->donationrequest_getbyidstatus($mycon, $getmatching['receivefund_id'], '3');

        //get all the matched of the receiver using his transferfund_id and member_id
        $totalamount = 0;
        $getReceiverMatching = $dataRead->matching_getbyidmemberandreceiver($mycon, $getmatching['receive_id'], $getmatching['receivefund_id']);
        foreach($getReceiverMatching as $row)
        {
            $totalamount += $row['amount'];
        }

        if ($totalamount == $donationreceiver['donation_gh'])
        {
            //update the receive to equal to status of 0
            $updateReceiver = $dataWrite->donationsupdatestatus_withtestimony($mycon, $getmatching['receivefund_id'], '0', '5', '1'); 
            if(!$updateTransfer)
            {
                $mycon->rollBack();
                echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <i class='fa fa-warning'></i>**an error occured during confirmation, please try again later.
                    </div>";
                return;

            } 
            
        }

        $mycon->commit();
        echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-smile-o'></i>****The sender is now confirmed successfully. Refreshing... 
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
            },3000);
                </script>";
        return;
    }

    /** function matching_sort()
    {
        $value = $_POST['value'];
        $currentuserid = getCookie("userid");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //check if the donations still exists with status of 5
           
        if ($value == '')
        {
        $matchingrequest_exist = $dataRead->matching_getbyidstatus($mycon, $currentuserid);
        if ($matchingrequest_exist )
        {
            foreach($matchingrequest_exist as $row)
            {
                $transferdetails = $dataRead->member_getbyid($mycon, $row['transfer_id']);
                $receiverdetails = $dataRead->member_getbyid($mycon, $row['receive_id']);
                $receiverbankaccoutdetails = $dataRead->bankaccountdetails_getbyid($mycon,$row['accountdetail_id']);
             echo "<div class='portlet' id='matchingfund'>
                                    <div class='portlet-heading bg-primary'>
                                        <h3 class='portlet-title'>
                                           New Match
                                        </h3>
                                        <div class='portlet-widgets'>
                                            <a href='javascript:void(0);' onclick='refreshMatchingFund(".$row['matching_id'] .")' data-toggle='reload'><i class='ion-refresh'></i></a>
                                            <span class='divider'></span>
                                            <a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary".$row['matching_id']."'><i class='ion-minus-round'></i></a>
                                        </div>
                                        <div class='clearfix'></div>
                                    </div>
                                    <div id='bg-primary".$row['matching_id']."' class='panel-collapse collapse in'>
                                        <div class='portlet-body'>";
            if ($row['matchingstatus'] == '5') 
                {
                 echo "<p>Status: No Evidence Uploaded</p>
                            <div class='text-center'>
                                 <div class='progress'>
                                <div class='progress-bar progress-bar-danger progress-bar-striped' role='progressbar' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100' style='width: 25%;'>
                                    <span class='sr-only'>25% Complete</span>
                                </div>
                            </div>
                            </div>";
                }
                else if ($row['matchingstatus'] == '3') 
                    {
                    echo "<p>Status: <a href='evidence/".$row['matching_id']."jpg' target='_blank' style='color: #FF0000; text-decoration: underline'> view evidence </a> </p>
                            <div class='text-center'>
                                <div class='progress'>
                                    <div class='progress-bar progress-bar-info progress-bar-striped' role='progressbar' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100' style='width: 50%;'>
                                        <span class='sr-only'>50% Complete</span>
                                    </div>
                                </div>
                            </div>";
                    }
                    else if ($row['matchingstatus'] == '0') 
                    {
                    echo "<p>Status: Confirmed</p>
                        <div class='text-center'>
                             <div class='progress'>
                            <div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%;'>
                                <span class='sr-only'>100% Complete</span>
                            </div>
                        </div>
                        </div>";
                    }
                echo "<div class='chat-conversation' style='height: 300px'>
                        <ul class='conversation-list nicescroll'>
                            <li class='clearfix'>
                             <div class='chat-avatar'>
                                <img src='assets/images/avatar-1.jpg' alt='male'>
                                    <i>".formatDate($row['thedate'])."</i>
                            </div>
                            <div class='conversation-text'>
                                <div class='ctext-wrap'>
                                    <i>".$transferdetails['lastname']." ".$transferdetails['firstname']."</i>
                                    <p>
                                        You are to receive ".$row['amount']." fund from me.
                                    </p>
                                    <p> 
                                        Phone number: ".$transferdetails['phonenumber']."
                                    </p>
                                </div>
                            </div>
                            </li>
                            <li class='clearfix odd'>
                                <div class='chat-avatar'>
                                    <img src='assets/images/avatar-1.jpg' alt='male'>
                                    <i>".formatDate($row['thedate']) ."</i>
                                </div>
                                <div class='conversation-text'>
                                <div class='ctext-wrap'>
                                    <i>".$receiverdetails['lastname']." ".$receiverdetails['firstname']."</i>
                                <p>
                                    Here are my account details<br>
                                    Account Name: ".$receiverbankaccoutdetails['bankaccountname'] ."<br>
                                    Bank Name: ".$receiverbankaccoutdetails['bankname'] ."<br>
                                    Bank Account Number: ".$receiverbankaccoutdetails['bankaccountnumber'] ."
                                </p>
                                    <p> Phonenumber: ".$receiverdetails['phonenumber'] ."</p>
                                    </div>
                                </div>
                               </li>
                            </ul>
                            <div class='text-center pull-left'>
                                <h3>Expiry: ".$expirydate = formatDate(date("Y-m-d H:i:s", strtotime($row['expirydate']) - strtotime("Y-m-d H:i:s")), "yes") ."</h3>
                            </div>
                            </div>
                            <hr>
                            <p class='text-right pull-right'>
                                <button class='btn btn-danger btn-md waves-effect waves-light' data-toggle='modal' data-target='.".$row['matching_id'] ."'>Details</button>
                            </div>
                            </div>
                            <div class='modal fade ".$row['matching_id']."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>
                        <div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                                    <h4 class='modal-title' id='mySmallModalLabel'>New matched details</h4>
                            </div>
                                <div class='modal-body'>
                                    <p>You have been martched! ".$transferdetails['lastname']." ".$transferdetails['firstname']." is to transfer the sum total of 
                                        ".$row['amount']." to ".$receiverdetails['lastname']." ".$receiverdetails['firstname'].". </p>
                                    <p><span style='color: #FF0000; font-weight: bold'><i class='md md-file-upload'></i> ".$transferdetails['lastname']." ".$transferdetails['firstname'] ."'s details:</span> <br />
                                        Fullname: ".$transferdetails['lastname']." ".$transferdetails['firstname'] ."<br />
                                        Phonenumber: ".$transferdetails['phonenumber']."<br />
                                        Email: ".$transferdetails['email']."<br />
                                        Gender: ".$transferdetails['gender']."<br />
                                        Country: ".$transferdetails['country']."
                                    </p>
                                    <p><span style='color: #FF0000; font-weight: bold'><i class='md md-file-download'></i> ".$receiverdetails['lastname']." ".$receiverdetails['firstname']."'s details:</span> <br />
                                        Fullname: ".$receiverdetails['lastname']." ".$receiverdetails['firstname'] ."<br />
                                        Account Name: ".$receiverbankaccoutdetails['bankaccountname']."<br/>
                                        Bank Name: ".$receiverbankaccoutdetails['bankname'] ."<br />
                                        Bank Account Number: ".$receiverbankaccoutdetails['bankaccountnumber'] ."<br />
                                        Phonenumber: ".$receiverdetails['phonenumber'] ."<br />
                                        Gender: ".$receiverdetails['gender']."<br />
                                        Country: ".$receiverdetails['country'] ."<br />
                                    </p>
                                    </p>
                                    <p>It can happen that either of the two party can forget that they have been matched. So ".$transferdetails['lastname']." ".$transferdetails['firstname']."can 
                                        call ".$receiverdetails['lastname']." ".$receiverdetails['firstname']."through ";
                    if ($receiverdetails['gender'] == 'Male') echo "his"; else echo "her";
                    echo " contact number ".$receiverdetails['phonenumber'].", also ".$receiverdetails['lastname']." ".$receiverdetails['firstname']." can call
                            ".$transferdetails['lastname']." ".$transferdetails['firstname']." through ";
                    if ($receiverdetails['gender'] == 'Male') echo "his"; else echo "her";
                    echo " contact number ". $transferdetails['phonenumber']."</p>
                        <P><strong>Pleae Note: These calls is not to force your matched participants but only to remind them of their request order. Hence do not disturb them with your calls. Any participants
                                        that fails to responds to their order before the expiry date and time will be blocked automatically. Therefore, if you are to matched to transfer, please do so as quick as possible. If you are to
                                        receive funds, as soon as the funds gets into your bank accounts confirm the sender. There's no need to delay anyone. </strong></p>
                                    <p style='color: #FF0000'>Expiry: ".$expirydate ."</p>
                                  <p>Status: ";
                    if ($row['matchingstatus'] == '5') echo "No Evidence Uploaded"; else if ($row['matchingstatus'] == '3') echo "<a href='evidence/".$row['matching_id'].".jpg' target='_blank' style='color: #FF0000; font-decoration: underline'> view Evidence </a>";
                    else if ($row['matchingstatus'] =='0') echo 'Confirmed';
                    echo "</p><br><br>";
                    if ($row['transfer_id'] == $currentuserid && $row['matchingstatus'] == '5')
                    {
                        echo "<iframe name='actionframe' id='actionframe' width='1px' height='1px' frameborder='0'></iframe> 
                                <form action='admin/actionmanager.php' method='post' id='evidenceform' target='actionframe' enctype='multipart/form-data'>
                                    <div class='matchingpaid' id='".$row['matching_id']."'></div>
                                        <div class='row'> 
                                        <div class='col-md-12'> 
                                            <div class='form-group paid error' id='amountpaiddiv'> 
                                                <label for='amountpaid' class='control-label'>Amount Paid*</label> 
                                                <input type='text' class='form-control' name='amountpaid' id='amountpaid' placeholder='Enter amount you paid'>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class='row'> 
                                        <div class='col-md-12'> 
                                            <div class='form-group paid error' id='uploadevidencediv'> 
                                                <label for='uploadevidence' class='control-label'>Upload Evidence*</label> 
                                                <input type='file' class='form-control' name='uploadevidence' id='uploadevidence'>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class='modal-footer'> 
                                        <button type='submit' class='btn btn-success waves-effect waves-light'>Save</button>
                                        <input type='hidden' name='command' id='command' value='evidence_add'>
                                        <input type='hidden' name='matching_id' id='matching_id' value='".$row['matching_id']."'>
                                        <button type='button' class='btn btn-danger waves-effect' id='paidresetbutton'>Reset</button> 
                                        <button type='button' class='btn btn-primary waves-effect' data-dismiss='modal'>Close</button>
                                    </div> 
                                    </form>";
                        }
                        else if ($row['receive_id'] == $currentuserid && $row['matchingstatus'] != '0')
                        {
                            echo "<p>Are you sure you want to perform operation on  <span class='extendmatching' id='".$row['matching_id']."'>".$transferdetails['lastname']." ".$transferdetails['firstname']."? </span></p>
                                    <div id='matchingextend'></div>
                                    <div class='row'> 
                                        <div class='col-md-12'> 
                                            <div class='form-group extend error' id='extendpassworddiv'> 
                                                <label for='extendpassword' class='control-label'>Enter your password*</label> 
                                                <input type='password' class='form-control' name='extendpassword' id='extendpassword' placeholder='Enter password to save changes'>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class='text-center'>
                                        <div class='button-list'>
                                            <button type='button' class='btn btn-success btn-custom btn-rounded waves-effect waves-light' id='confirmbutton'><i class='fa fa-check'></i> Confirm Payment</button>    
                                            <button type='button' class='btn btn-primary btn-custom btn-rounded waves-effect' id='extendbutton'><i class='fa fa-sign-out'></i> Extend by 24 hours</button>
                                            <button type='button' class='btn btn-danger btn-custom btn-rounded waves-effect waves-light' data-toggle='modal' data-target='.flag'>
                                                <i class='fa fa-times'></i> False Payment</button>
                                            <button type='button' class='btn btn-info btn-custom btn-rounded waves-effect waves-light' data-dismiss='modal'>Dismiss</button>
                                        </div>
                                    </div>";
                                }
                            else
                            {
                            echo "<button type='button' class='btn btn-info btn-custom btn-rounded waves-effect waves-light' data-dismiss='modal'>Dismiss</button>";
                            }
                            echo "</div>
                                </div>
                        </div>
                    </div>
                </div>";
                }
            }
        }
    }
    **/

    //restore your account details
    function memberrestore()
    {
        $email = $_POST['email'];
        $captcha = $_POST['captcha'];

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        $count = 0;
        $captchaerror = '';
        $membererror = '';
        //check if the captcha entered is equal to the captcha saved in the database
        if ($captcha != $_SESSION['captcha'])
        {
            $captchaerror = "<br>Incorrect Captcha.";
            echo "<script type='text/javascript'>
                    $('#captchadiv').addClass('has-error');
                    </script>";
             $count = $count + 1;
        }

        //find members by the email first
        $memberdetails = $dataRead->member_getbyemail($mycon , $email);
        if (!$memberdetails)
        {
            //get the members by the username
            $memberdetails = $dataRead->member_getbyusername($mycon, $email);
            if (!$memberdetails)
            {
                $membererror = "<br>Email or username do not exists";
                echo "<script type='text/javascript'>
                    $('#emaildiv').addClass('has-error');
                    </script>";
                $count = $count + 1;
            }
        }

        if ($count != 0)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **".$count." error was found.<br>".$captchaerror." ".$membererror.
                "</div>";
            return;
        }

        //if the member details is found
        $token = substr(str_shuffle(time()),0,6);
        createCookie("recovertoken", $token);
        $sentmessage = "<div class='container'>
                                <p>Hello ".$memberdetails['username'].",</p>
                                <p>Enter this token to restore your account at World Fund Global (WFG): ". $token."  </p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";

        $sentmessage = wordwrap($sentmessage,70);
        createCookie("email", $memberdetails['email']);

        /**$message = "A code has been sent to your email ".$email.". Please check to restore your account.".$token. ".";
        echo "<div id='successalert'>
                    <div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Almost done!</strong> ".$message."
                    </div>
                    </div>
                    <script type='text/javascript'>
                    $('#recoverform').hide(500);
                    </script>
                    <form class='form-horizontal m-t-20' action='admin/actionmanager.php' id='recoververifyform'>
                    <p>Enter token!</p>
                            <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='tokendiv'>
                                    <input class='form-control' name='token' type='text' id='token' placeholder='Input token*''>
                                </div>
                            </div>
                            <div class='form-group text-center m-t-40'>
                            <div class='col-xs-12'>
                                <div class='col-md-8 col-xs-8'>
                                    <button class='btn btn-success btn-block text-uppercase waves-effect waves-light'  id='recoververifybutton' type='button' onclick='submitrecoverVerifyForm(this);'>
                                    Recover Account
                                    </button>
                                </div>
                                <div class='col-md-4 col-xs-4'>
                                    <button class='btn btn-danger btn-block text-uppercase waves-effect waves-light' id='emailclearbutton' onclick='resetToken();' type='button'>
                                    Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='form-group text-center m-t-40'>
                        <div class='col-xs-12'>
                                <div class='col-md-12 col-xs-12'>
                                    <button class='btn btn-primary btn-block text-uppercase waves-effect waves-light' type='button'  id='backtorecoverbutton' onclick='backtoRecover();'>
                                    << Back to restore form
                                    </button>
                                </div>
                            </div>
                            </div>
                        </form>;
                    </script>";
            return; **/
           

           if (sendEmail($email,"Restore Token - Wealth Fund Global", $sentmessage))
           {
                $message = "A code has been sent to your email ".$email.". Please check to restore your account.";
                echo "<div id='successalert'>
                    <div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Almost done!</strong> ".$message."
                    </div>
                    </div>
                    <script type='text/javascript'>
                    $('#recoverform').hide(500);
                    </script>
                    <form class='form-horizontal m-t-20' action='admin/actionmanager.php' id='recoververifyform'>
                    <p>Enter token!</p>
                            <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='tokendiv'>
                                    <input class='form-control' name='token' type='text' id='token' placeholder='Input token*''>
                                </div>
                            </div>
                            <div class='form-group text-center m-t-40'>
                            <div class='col-xs-12'>
                                <div class='col-md-8 col-xs-8'>
                                    <button class='btn btn-success btn-block text-uppercase waves-effect waves-light'  id='recoververifybutton' type='button' onclick='submitrecoverVerifyForm(this);'>
                                    Recover Account
                                    </button>
                                </div>
                                <div class='col-md-4 col-xs-4'>
                                    <button class='btn btn-danger btn-block text-uppercase waves-effect waves-light' id='emailclearbutton' onclick='resetToken();' type='button'>
                                    Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='form-group text-center m-t-40'>
                        <div class='col-xs-12'>
                                <div class='col-md-12 col-xs-12'>
                                    <button class='btn btn-primary btn-block text-uppercase waves-effect waves-light' type='button'  id='backtorecoverbutton' onclick='backtoRecover();'>
                                    << Back to restore form
                                    </button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </script>";
            return;
           }
           else
            {
                echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i> ** There was an error sending mail to your email, please check your network properly.
                        </div>";
                return;
            }
            
            
    }

    function recovertoken_add()
    {
        $token = $_POST['token'];
        $email = getCookie("email");
        
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //validate token first
        if ($token != getCookie("recovertoken"))
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Invalid token!
                </div>
                <script type='text/javascript'>
                    $('#tokendiv').addClass('has-error');
                    </script>";
            return;
        }


        //get the details of the member by email
        $memberdetails = $dataRead->member_getbyemail($mycon, $email);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to validate your account, please start restore process again!
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='recover.php';
                },3000);
                    </script>";
            return;
        }

        $message = "Restore account successful, please create a new password.";
        echo "<div id='successalert'>
                    <div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <strong><i class='fa fa-smile-o'></i> Almost done!</strong> ".$message."
                    </div>
                    </div>
                    <script type='text/javascript'>
                    $('#recoververifyform').hide(500);
                    $('#recoverform').hide(500);
                    </script>
                    <form class='form-horizontal m-t-20' action='admin/actionmanager.php' id='newpasswordform'>
                    <div id='createpassword'></div>
                    <p>Create a new password</p>
                            <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='passworddiv'>
                                    <input class='form-control' name='password' type='password' id='password' placeholder='New Password*'>
                                </div>
                            </div>
                             <div class='form-group'>
                                <div class='col-xs-12 col-md-12 error' id='confirmpassworddiv'>
                                    <input class='form-control' name='confirmpassword' type='password' id='confirmpassword' placeholder='Confrim password*'>
                                </div>
                            </div>
                            <div class='form-group text-center m-t-40'>
                            <div class='col-xs-12'>
                                <div class='col-md-8 col-xs-8'>
                                    <button class='btn btn-success btn-block text-uppercase waves-effect waves-light'  id='passwordbutton' type='button' onclick='submitpasswordForm(this);'>
                                    Submit
                                    </button>
                                </div>
                                <div class='col-md-4 col-xs-4'>
                                    <button class='btn btn-danger btn-block text-uppercase waves-effect waves-light' id='passwordclearbutton' onclick='passwordReset(this)' type='button'>
                                    Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='form-group text-center m-t-40'>
                        <div class='col-xs-12'>
                                <div class='col-md-12 col-xs-12'>
                                    <button class='btn btn-primary btn-block text-uppercase waves-effect waves-light' type='button'  id='backtorecoverbutton' onclick='backtoRecover();'>
                                    << Back to restore form
                                    </button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </script>";
            return;
        
    }


    //update the change password of the user
    function password_update()
    {
        $password = $_POST['password'];
        $email = getCookie("email");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        //get the details of the member
        $memberdetails = $dataRead->member_getbyemail($mycon, $email);
        if (!$memberdetails)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to validate your account, please start restore process again!
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='recover.php';
                },3000);
                    </script>";
            return;
        }

        $password = generatePassword($password);
        //update the account user password
        $updatepassword = $dataWrite->members_updatepassword($mycon, $memberdetails['member_id'], $password);
        if (!$updatepassword)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to validate your account, please start restore process again!
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='recover.php';
                },3000);
                    </script>";
            return;
        }

         echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-smile-o'></i> **Password update successful, please login! redirecting...
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php';
                },3000);
                    </script>";
            return;
    }


    //upload image
    function uploadfile()
    {
        $photo = $_FILES['imageupload'];
        $currentuserid = getCookie("userid");

        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        if ($photo['size'] <= 0)
        {
            showAlert("No image file was choosen.");
            return;
        }

        //get the details of the member
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            showAlert("Unable to find your details, please sign in again.");
            openPage("../login.php?logout=yes");
        }

        $mycon->beginTransaction();
        if(strpos(strtoupper($photo['type']),"IMAGE") > -1) 
            {
                //set the picture status to 1 of the memnber
                 $updatepicturestatus = $dataWrite->updatePictureStatus($mycon, $memberdetails['member_id'], '1');
                 
                 if(!$updatepicturestatus)
                 {
                    $mycon->rollBack();
                    showAlert("Unable to perform operation.");
                    openPage("../profile.php");
                 }
            move_uploaded_file($photo['tmp_name'],"../member_image/".$memberdetails['username'].".jpg");
            }
            else {
                showAlert("Only Image File is allowed.");
                return;
            }

        
        
        $mycon->commit();
        showAlert("Your picture successfully uploaded.");
        openPage("../profile.php");
    }


    function unlock_account()
    {
        $password = $_POST['password'];
        $currentuserid = getCookie("userid");

        $mycon = databaseConnect();
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();

        //get member details
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Unable to validate your account
                </div>";
            return;
        }
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Wrong password!
                </div>";
            return;
        }

         echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-smile-o'></i> **Account unlocked! redirecting...
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
                },3000);
                    </script>";
        return;


    }

    //flag false payment
    function falsepayment()
    {
         $matching_id = $_POST['matching_id'];
        $password = $_POST['password'];
        $currentuserid = getCookie("userid");
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();
        $mycon = databaseConnect();

        $count = 0;
        $passworderror = '';
        $matchingfinderror = '';
        $updatematchingerror = '';

        //check if user is signed in by getting the user by member id
        $memberdetails = $dataRead->member_getbyid($mycon, $currentuserid);
        if (!$memberdetails)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i> **Token expired, please login again!
                </div>
                 <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='login.php?logout=yes';
            },1000);
                </script>";
            return;
        }

         //check if the password supplied is correct
        $password = generatePassword($password);
        if ($password != $memberdetails['password'])
        {
             $passworderror = "<br>**Wrong password.
                <script type='text/javascript'>
                    $('#extendpassworddiv'".$matching_id.").addClass('has-error');
                    </script>";
            ++$count;
        }

        //find the donation matching
        $donationmatchingfind = $dataRead->matching_getbyid($mycon, $matching_id);
        if (!$donationmatchingfind)
        {
            $matchingfinderror =  "<br>**Transfer match could not be found.";
            ++$count;
        }

        if ($count != 0)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**".$count." error was found.".$passworderror." ".$matchingfinderror."
                </div>";
                return;
        }


        $mycon->beginTransaction();
        $count = 0;
        
        //set the member status to five which shows blocked user
        $memberupdate = $dataWrite->members_updatestatus($mycon, $donationmatchingfind['transfer_id'], '5');
        if (!$memberupdate)
        {
            $mycon->rollBack();
            ++$count;
        }

        //set the matching status to 4 which shows remerge
        $matchingupdate = $dataWrite->updateMatchingStatus($mycon, $matching_id, '4');
        if (!$matchingupdate)
        {
            $mycon->rollBack();
            ++$count;
        }

        //get the donation delatails of the receiver
        $receiverdonationdetails = $dataRead->donations_getbyiddonation($mycon, $donationmatchingfind['receivefund_id']);
        $difference = $receiverdonationdetails['donation_gh'] - $donationmatchingfind['amount'];

        //update the former recieve request
        $receivefundupdate = $dataWrite->donation_update_gh($mycon, $difference, $donationmatchingfind['receivefund_id']);
        if (!$receivefundupdate)
        {
            $mycon->rollBack();
            ++$count;
        }

        //create a new receive fund request for the receiver
        //calculate 3 days from now to transfer fund request again
        $readydonation_ph = date("Y-m-d H:i:s", strtotime("+3 days"));
        $readydonation_gh = date("Y-m-d H:i:s");

        //add to the donation table
        $donation_id = $dataWrite->donation_add_gh($mycon,$donationmatchingfind['amount'],$donationmatchingfind['receive_id'],$readydonation_ph,$readydonation_gh,$donationmatchingfind['accountdetail_id'],'1');
        if (!$donation_id)
        {
            $mycon->rollBack();
            ++$count;
        }

        if ($count > 0)
        {
             echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**An error occured while processing your requests, please try again later.
                </div>";
                return;
        }

        $mycon->commit();
        echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**Payment successfully flagged!
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
                },3000);
                    </script>";
        return;

    }



    //upload testimony
    function testimony_add()
    {
        $testimony = $_POST['testimony'];
        $donation_id = $_POST['donation_id'];
        $currentuserid = getCookie("userid");
        $mycon = databaseConnect();
        $dataRead = New DataRead();
        $dataWrite = New DataWrite();

        //find the details of the donation
        $donationdetail = $dataRead->donations_getbyiddonation($mycon, $donation_id);
        if (!$donationdetail)
        {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**This donation no longer exists!
                </div>";
            return;
        }


        $mycon->beginTransaction();
        //upload the testimony
        $testimonyadd = $dataWrite->testimony_add($mycon, $testimony, $donation_id, $currentuserid);
        if (!$testimonyadd)
        {
            $mycon->rollBack();
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**Error uploading testimony!
                </div>";
            return;   
        } 

        //update the testimonial status of the donation
        $testimonialupdatedonation = $dataWrite->donationupdate_testimony($mycon, '5', $testimonyadd, $donation_id);
        if (!$testimonialupdatedonation)
        {
            $mycon->rollBack();
            echo "<div class='alert alert-danger alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**Error uploading testimony!
                </div>";
            return;
        }

        $mycon->commit();
        echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**Testimony uploaded successfully! Refreshing...
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='dashboard.php';
                },3000);
                    </script>";
            return;
        }


        //add news
        function news_add()
        {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $currentuserid = getCookie("userid");

            $dataRead = New DataRead();
            $dataWrite = New DataWrite();
            $mycon = databaseConnect();

            //check if the title and content is not empty
            $msg = '';
            $count = 0;
            $titleerror = '';
            $contenterror = '';
            echo "<link href='../assets/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
                    <script src='../assets/js/jquery.min.js'></script>
                    <script src='../assets/js/jquery.core.js'></script>
                    <script src='../assets/js/jquery.app.js'></script>
                    <script src='../assets/js/bootstrap.min.js'></script>
                    <script src='../assets/js/detect.js'></script>
                    <script src='../assets/js/fastclick.js'></script>
                    <script src=../assets/js/jquery.slimscroll.js'></script>
                    <script src=../assets/js/jquery.blockUI.js'></script>
                    <script src='../assets/js/waves.js'></script>
                    <script src='../assets/js/wow.min.js'></script>
                    <script src='../assets/js/jquery.nicescroll.js'></script>
                    <script src='../assets/js/jquery.scrollTo.min.js'></script>";
            if ($title == '')
            {
                $titleerror = "<br>** News Title is required
                        <script type='text/javascript'>
                        $('#titlediv').addClass('has-error');
                        </script>";
                ++$count;
            }
            if ($content == '')
            {
                $contenterror = "<br>** News Content is required
                        <script type='text/javascript'>
                        $('#contentdiv').addClass('has-error');
                        </script>";
                ++$count;
            }
            if ($count != 0)
            {
                if ($count == '1')
                {
                    echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** 1 error was found, please correct it.".$titleerror." ".$contenterror."
                        </div>";
                }
                else
                {
                     echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** ".$count." errors were found, please correct it.".$titleerror." ".$contenterror."
                        </div>";
                }

                return;

            }

            //add the news
            $news_id = $dataWrite->news_add($mycon, $title, $content, $currentuserid);
            if (!$news_id)
            {
                 echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** Error adding news, please try again...
                        </div>";
            }

            //send email to the participants
            $memberdetails = $dataRead->member_getbyall($mycon);
            foreach($memberdetails as $row)
            {

                $message = "<div class='container'>
                                <p>Hello ".$row['username'].",</p>
                                <p>How's your day going? There is a new message waiting for you in your dashboard from Wealth Fund Global Admin,
                                 please <a href='https://www.wealthfundglobal.com'>login to your office</a> to check. </p>
                                 <p>Regards</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";
                sendEmail($row['email'], "New Message From Admin - Wealth Fund Global", $message);
            }
             echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**New successfully added! Refreshing...
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='../news.php';
                },3000);
                    </script>";
            return;

        }

        function news_edit()
        {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $news_id = $_POST['new_id'];
            $currentuserid = getCookie("userid");

            $dataRead = New DataRead();
            $dataWrite = New DataWrite();
            $mycon = databaseConnect();

            //check if the title and content is not empty
            $msg = '';
            $count = 0;
            $titleerror = '';
            $contenterror = '';
            echo "<link href='../assets/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
                    <script src='../assets/js/jquery.min.js'></script>
                    <script src='../assets/js/jquery.core.js'></script>
                    <script src='../assets/js/jquery.app.js'></script>
                    <script src='../assets/js/bootstrap.min.js'></script>
                    <script src='../assets/js/detect.js'></script>
                    <script src='../assets/js/fastclick.js'></script>
                    <script src=../assets/js/jquery.slimscroll.js'></script>
                    <script src=../assets/js/jquery.blockUI.js'></script>
                    <script src='../assets/js/waves.js'></script>
                    <script src='../assets/js/wow.min.js'></script>
                    <script src='../assets/js/jquery.nicescroll.js'></script>
                    <script src='../assets/js/jquery.scrollTo.min.js'></script>";
            if ($title == '')
            {
                $titleerror = "<br>** News Title is required
                        <script type='text/javascript'>
                        $('#titlediv').addClass('has-error');
                        </script>";
                ++$count;
            }
            if ($content == '')
            {
                $contenterror = "<br>** News Content is required
                        <script type='text/javascript'>
                        $('#contentdiv').addClass('has-error');
                        </script>";
                ++$count;
            }


            if ($count != 0)
            {
                if ($count == '1')
                {
                    echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** 1 error was found, please correct it.".$titleerror." ".$contenterror."
                        </div>";
                }
                else
                {
                     echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** ".$count." errors were found, please correct it.".$titleerror." ".$contenterror."
                        </div>";
                }

                return;

            }

             //check if the news still exists
            $newscheck = $dataRead->news_getbyid($mycon, $news_id);
            if (!$newscheck)
            {
               echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** There was an error updating the news, please try again
                        </div>"; 
                return;
            }

            //add the news
            $news_id = $dataWrite->news_update($mycon, $title, $content, $currentuserid, $news_id);
            if (!$news_id)
            {
                 echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            <i class='fa fa-warning'></i>** Error adding news, please try again...
                        </div>";
            }

            //send email to the participants
            $memberdetails = $dataRead->member_getbyall($mycon);
            foreach($memberdetails as $row)
            {

                $message = "<div class='container'>
                                <p>Hello ".$row['username'].",</p>
                                <p>How's your day going? There is a new message waiting for you in your dashboard from Wealth Fund Global Admin,
                                 please <a href='https://www.wealthfundglobal.com'>login to your office</a> to check. </p>
                                 <p>Regards</p>
                                <p><small><em>This message is auto-generated, please do not reply via your email.</em></small></p>
                            </div>";
                if (sendEmail($row['email'], "New Message From Admin - Wealth Fund Global", $message))
                {
                    echo "Hello";
                }
            }
             echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                    <i class='fa fa-warning'></i>**New successfully added! Refreshing...
                </div>
                <script type='text/javascript'>
                    window.setTimeout(function(){
                document.location.href='../news.php';
                },3000);
                    </script>";
            return;

        }



}

?>