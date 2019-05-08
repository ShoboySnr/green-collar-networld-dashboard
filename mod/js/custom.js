//if reset button is clicked
$('#resetbutton').on("click", function(event){
	$('#resetbutton').html("Reseting..");
	event.preventDefault();

	$('#firstname').val("");
	$('#lastname').val("");
	$('#username').val("");
    $('#email').val("");
	$('#password').val("");
    $('#phonenumber').val("");
    $('#confirmpassword').val("");
    $('#sex').val("");
    $('#referral').val("");
    $('#country').val("");
    $('#captcha').val("");
    $('#address').val("");
	$('#result').html("");
    $('.error').removeClass('has-error');

	$('#resetbutton').html("Reset");

});


//SUBMIT THE REGISTERATION FORM
$('#registerform').on("submit", function(event){
	$('#createaccountbutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Submiting...");
	$('.error').removeClass("has-error");


	event.preventDefault();

	 /* get some values from elements on the page: */
         var $form = $(this),
         	referral = $form.find('input[name="referral"]').val(),
         	firstname = $form.find('input[name="firstname"]').val(),
            lastname = $form.find('input[name="lastname"]').val(),
            username = $form.find('input[name="username"]').val(),
            email = $form.find('input[name="email"]').val(),
            phonenumber = $form.find('input[name="phonenumber"]').val(),
            password = $form.find('input[name="password"]').val(),
            confirmpassword = $form.find('input[name="confirmpassword"]').val(),
            sex = $form.find('select[name="sex"]').val(),
            country = $form.find('select[name="country"]').val(),
            address = $form.find('textarea[name="address"]').val(),
            captcha = $form.find('input[name="captcha"]').val(),
            url = $form.attr('action');

     //handle validations
     msg = '';
     var count = 0;
     if (firstname == '')
     {
     	$('#firstnamediv').addClass("has-error")
     	msg += 'First name is required';
     	count += 1;
     }
     if (lastname == '')
     {
     	$('#lastnamediv').addClass("has-error")
     	msg += 'Last name is required';
     	count += 1;
     }
     if (username == '')
     {
     	$('#usernamediv').addClass("has-error")
     	msg += 'Username is required';
     	count += 1;
     }
     if (email == '')
     {
     	$('#emaildiv').addClass("has-error")
     	msg += 'Email is required';
     	count += 1;
     }
     if (phonenumber == '')
     {
        $('#phonenumberdiv').addClass("has-error")
        msg += 'Phonenumber is required';
        count += 1;
     }
     if (password == '')
     {
     	$('#passworddiv').addClass("has-error");
     	msg += 'Password is required';
     	count += 1;
     }
     if (confirmpassword == '')
     {
     	$('#confirmpassworddiv').addClass("has-error");
     	msg += 'Confirm Password is required';
     	count += 1;
     }
     if (password != confirmpassword )
     {
     	$('#passworddiv').addClass("has-error");
     	$('#confirmpassworddiv').addClass("has-error");
     	msg += 'Password Mismatch';
     	count += 1;
     }
     if (country == '')
     {
     	$('#countrydiv').addClass("has-error");
     	msg += 'Name is required';
     	count += 1;
     }
      if (sex == '')
     {
     	$('#sexdiv').addClass("has-error");
     	msg += 'Sex is required';
     	count += 1;
     }
      if (captcha == '')
     {
     	$('#captchadiv').addClass("has-error");
     	msg += 'Capcha code is required';
     	count += 1;
     }

     if (msg != '')
     {
     	if (count == 1)
     	{
     		$('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
	                                            "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
	                                            "<i class='fa fa-warning'></i> ** "+count+" error was found, please correct" +
	                                        "</div>");
     	}
     	else {
     		$('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
	                                            "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
	                                            "<i class='fa fa-warning'></i> ** "+count+" errors were found, the highlighted items are required." +
	                                        "</div>");
     	}
     	$('#createaccountbutton').html("Set up my account!");
     	return;
     }

     //check if password length is greater than 6
     if (password.length < 6)
     {
        $('#passworddiv').addClass("has-error");
        $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** Password length must be greater than 6 " +
                                            "</div>");
        $('#createaccountbutton').html("Set up my account!");
        return;  
     }

     if (country !== 'Nigeria')
    {
        $('#countrydiv').addClass("has-error");
         $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** Sorry, our global network is not yet available in "+country+", please send us a message at support@wealthfundglobal.com if you want us to have it set up in "+country +
                                            "</div>");
        $('#createaccountbutton').html("Set up my account!");
        return;  
    }


     /* Send the data using post */
    var posting = $.post(url, {
        referral: referral,
        firstname: firstname,
        lastname: lastname,
        username: username,
        email: email,
        phonenumber: phonenumber,
        password: password,
        sex: sex,
        country: country,
        address: address,
        captcha: captcha,
        command: "members_add" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#result").html(data);
        $('#createaccountbutton').html("Set up my account!");


                    
    });
       
       return;                 

});


//SUBMIT THE BANK ACCOUNT DETAILS FORM
$('#bankaccountsave').on("click", function(event){
    $('#bankaccountsave').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Saving...");
    $('.error').removeClass("has-error");

    event.preventDefault();
     /* get some values from elements on the page: */
         var name = $('#name').val(),
            surname = $('#surname').val(),
            bankname = $('#bankname').val(),
            bankaccountnumber = $('#bankaccountnumber').val(),
            password = $('#password').val(),
            url = "admin/actionmanager.php";

     //handle validations
     msg = '';
     var count = 0;
     if (name == '')
     {
        $('#namediv').addClass("has-error")
        msg += 'name is required';
        count += 1;
     }
     if (surname == '')
     {
        $('#surnamediv').addClass("has-error")
        msg += 'Surname is required';
        count += 1;
     }
     if (bankname == '')
     {
        $('#banknamediv').addClass("has-error")
        msg += 'Bank name is required';
        count += 1;
     }
     if (bankaccountnumber == '')
     {
        $('#bankaccountnumberdiv').addClass("has-error")
        msg += 'Bank account number is required';
        count += 1;
     }
     if (password == '')
     {
        $('#passworddiv').addClass("has-error")
        msg += 'Password is required';
        count += 1;
     }
     if (msg != '')
     {
        if (count == 1)
        {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, please double check your information." +
                                            "</div>");
        }
        else {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, please double check your information." +
                                            "</div>");
        }
        $('#bankaccountsave').html("Save changes");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        name: name,
        surname: surname,
        bankname: bankname,
        bankaccountnumber: bankaccountnumber,
        password: password,
        command: "bankaccountdetails_add" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#result").html(data);
        $('#bankaccountsave').html("Save changes");


                    
    });
       
       return;                 

});


//SUBMIT THE BANK ACCOUNT DETAILS FORM
$('#bankaccountupdate').on("click", function(event){
    $('#bankaccountupdate').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Updating...");
    $('.update').removeClass("has-error");

    event.preventDefault();
     /* get some values from elements on the page: */
         var name = $('#updatename').val(),
            bankname = $('#updatebankname').val(),
            bankaccountnumber = $('#updatebankaccountnumber').val(),
            password = $('#updatepassword').val(),
            accountdetail_id = $('#updateaccountdetail_id').val(),
            url = "admin/actionmanager.php";

     //handle validations
     msg = '';
     var count = 0;
     if (name == '')
     {
        $('#updatenamediv').addClass("has-error")
        msg += 'name is required';
        count += 1;
     }
     if (bankname == '')
     {
        $('#updatebanknamediv').addClass("has-error")
        msg += 'Bank name is required';
        count += 1;
     }
     if (bankaccountnumber == '')
     {
        $('#updatebankaccountnumberdiv').addClass("has-error")
        msg += 'Bank account number is required';
        count += 1;
     }
     if (password == '')
     {
        $('#updatepassworddiv').addClass("has-error")
        msg += 'Password is required';
        count += 1;
     }
     if (msg != '')
     {
        if (count == 1)
        {
            $('#updateresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, please double check your information." +
                                            "</div>");
        }
        else {
            $('#updateresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, please double check your information." +
                                            "</div>");
        }
        $('#bankaccountupdate').html("Update changes");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        name: name,
        bankname: bankname,
        bankaccountnumber: bankaccountnumber,
        password: password,
        accountdetail_id: accountdetail_id,
        command: "bankaccountdetails_update" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#updateresult").html(data);
        $('#bankaccountupdate').html("Update changes");


                    
    });
       
       return;                 

});


//if reset button is clicked for bank account details
$('#bankaccountreset').on("click", function(event){
    $('#bankaccountreset').html("Reseting..");
    event.preventDefault();

    $('#name').val("");
    $('#surname').val("");
    $('#bankname').val("");
    $('#bankaccountnumber').val("");
    $('#password').val("");
    $('#result').html("");
    $('.error').removeClass('has-error');

    $('#bankaccountreset').html("Reset");

});

//if reset button is clicked for transfer fund request
$('#transfersavereset').on("click", function(event){
    $('#transfersavereset').html("Reseting..");
    event.preventDefault();

    $('#amount').val("");
    $('#amountcustom').val("");
    $('#bankaccounts').val("");
    $('#password').val("");
    $('#captcha').val("");
    $('#transferresult').html("");
    $('.transfer').removeClass('has-error');

    $('#transfersavereset').html("Reset");

});

//if reset button is clicked for transfer fund request
$('#receivesavereset').on("click", function(event){
    $('#receivesavereset').html("Reseting..");
    event.preventDefault();

    $('#amountreceive').val("");
    $('#bankaccountsreceive').val("");
    $('#passwordreceive').val("");
    $('#captchareceive').val("");
    $('#receiveresult').html("");
    $('.receive').removeClass('has-error');

    $('#receivesavereset').html("Reset");

});


//SUBMIT THE REGISTERATION FORM
$('#loginform').on("submit", function(event){
    $('#loginbutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Submiting...");
    $('.error').removeClass("has-error");


    event.preventDefault();

     /* get some values from elements on the page: */
         var $form = $(this),
            username = $form.find('input[name="username"]').val(),
            password = $form.find('input[name="password"]').val(),
            captcha = $form.find('input[name="captcha"]').val(),
            url = $form.attr('action');

     //handle validations
     msg = '';
     var count = 0;
     if (username == '')
     {
        $('#usernamediv').addClass("has-error")
        msg += 'Username is required';
        count += 1;
     }
     if (password == '')
     {
        $('#passworddiv').addClass("has-error")
        msg += 'Password is required';
        count += 1;
     }
     if (captcha == '')
     {
        $('#captchadiv').addClass("has-error")
        msg += 'Captcha is required';
        count += 1;
     }
    
     if (msg != '')
     {
        if (count == 1)
        {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, please double check your information." +
                                            "</div>");
        }
        else {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, please double check your information." +
                                            "</div>");
        }
        $('#loginbutton').html("Login");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        username: username,
        password: password,
        captcha: captcha,
        command: "memberlogin" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#result").html(data);
        $('#loginbutton').html("Login!");


                    
    });
       
       return;                 

});

//SUBMIT THE VERIFY ACCOUNT FORM
function submitVerifyForm(x)
{
    $('#emailverifybutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Verifying...");
    $('.error').removeClass("has-error");


    event.preventDefault();

     /* get some values from elements on the page: */
         var email = $('#emailverify').val(),
            token = $('#token').val(),
            url = 'admin/actionmanager.php';

     //handle validations
     msg = '';
     var count = 0;
     if (token == '')
     {
        $('#tokendiv').addClass("has-error")
        msg += 'Token is required';
        count += 1;
     }
     

     if (msg != '')
     {
        $('#successalert').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** Please input token!" +
                                            "</div>");
       
        $('#emailverifybutton').html("Verify Account!");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        email: email,
        token: token,
        command: "token_add" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#successalert").html(data);
        $('#emailverifybutton').html("Verify Account!");


                    
    });
       
       return;
}

//back to registeration button
function backtoRegistration()
{
    $('#emailverifyform').show(500);
    $('#registerform').show(500);


    $('#firstname').val("");
    $('#lastname').val("");
    $('#username').val("");
    $('#phonenumber').val("");
    $('#email').val("");
    $('#password').val("");
    $('#confirmpassword').val("");
    $('#sex').val("");
    $('#referral').val("");
    $('#country').val("");
    $('#captcha').val("");
    $('#address').val("");
    $('#result').html("");
    $('.error').removeClass('has-error');
}

//reset the inout of the verify account page
function resetToken()
{
    $('#emailclearbutton').html("Reseting..");

    $('#token').val("");
    $('.error').removeClass('has-error');

    $('#emailclearbutton').html("Reset");
}

//show the custom amount box
function customAmount(x)
{
    value = x.value;
    if (value == 'notfound')
    {
        $('#custom_amount').show(500);
    }
    else
    {
        $('#custom_amount').hide(500);
    }
}

//if reset button is clicked
$('#loginresetbutton').on("click", function(event){
    $('#loginresetbutton').html("Reseting..");
    event.preventDefault();

    $('#username').val("");
    $('#password').val("");
    $('#result').html("");
    $('.error').removeClass('has-error');

    $('#loginresetbutton').html("Reset");

});


//if reset button is clicked for bank account details
$('#profilereset').on("click", function(event){
    $('#profilereset').html("Reseting..");
    event.preventDefault();

    $('#firstname').val("");
    $('#lastname').val("");
    $('#phonenumber').val("");
    $('#sex').val("");
    $('#country').val("");
    $('#address').val("");
    $('#result').html("");
    $('.error').removeClass('has-error');

    $('#profilereset').html("Reset");

});



//PROFILE UPDATES
$('#profileform').on("submit", function(event){
    $('#profilesavebutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Saving...");
    $('.error').removeClass("has-error");

    event.preventDefault();

     /* get some values from elements on the page: */
         var $form = $(this),
            firstname = $form.find('input[name="firstname"]').val(),
            lastname = $form.find('input[name="lastname"]').val(),
            username = $form.find('input[name="username"]').val(),
            phonenumber = $form.find('input[name="phonenumber"]').val(),
            email = $form.find('input[name="email"]').val(),
            password = $form.find('input[name="password"]').val(),
            confirmpassword = $form.find('input[name="confirmpassword"]').val(),
            sex = $form.find('select[name="sex"]').val(),
            country = $form.find('select[name="country"]').val(),
            address = $form.find('textarea[name="address"]').val(),
            url = $form.attr('action');

     //handle validations
     msg = '';
     var count = 0;
     if (firstname == '')
     {
        $('#firstnamediv').addClass("has-error")
        msg += 'First name is required';
        count += 1;
     }
     if (lastname == '')
     {
        $('#lastnamediv').addClass("has-error")
        msg += 'Last name is required';
        count += 1;
     }
     if (username == '')
     {
        $('#usernamediv').addClass("has-error")
        msg += 'Username is required';
        count += 1;
     }
     if (phonenumber == '')
     {
        $('#phonenumberdiv').addClass("has-error")
        msg += 'Phone number is required';
        count += 1;
     }
     if (email == '')
     {
        $('#emaildiv').addClass("has-error")
        msg += 'Email is required';
        count += 1;
     }
     if (password != confirmpassword && password != '')
     {
        $('#passworddiv').addClass("has-error");
        $('#confirmpassworddiv').addClass("has-error")
        msg += 'Password Mismatch';
        count += 1;
     }
     if (country == '')
     {
        $('#countrydiv').addClass("has-error");
        msg += 'Name is required';
        count += 1;
     }
      if (sex == '')
     {
        $('#sexdiv').addClass("has-error");
        msg += 'Sex is required';
        count += 1;
     }

     if (msg != '')
     {
        if (count == 1)
        {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, please double check your information." +
                                            "</div>");
        }
        else {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, please double check your information." +
                                            "</div>");
        }
        $('#profilesavebutton').html("Set up my account!");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        firstname: firstname,
        lastname: lastname,
        username: username,
        phonenumber: phonenumber,
        email: email,
        password: password,
        sex: sex,
        country: country,
        address: address,
        command: "members_update" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#result").html(data);
        $('#profilesavebutton').html("Save changes");


                    
    });
       
       return;                 

});



//ADD NEW TRANSFER ORDER
$('#transfersave').on("click", function(event){
    $('#transfersave').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Saving...");
    $('.transfer').removeClass("has-error");

    event.preventDefault();
     /* get some values from elements on the page: */
         var amount = $('#amount').val(),
            bankaccounts = $('#bankaccounts').val(),
            amountcustom = $('#amountcustom').val(),
            password = $('#password').val(),
            captcha = $('#captcha').val(),
            url = "admin/actionmanager.php";

     //handle validations
     msg = '';
     var count = 0;
     if (amount == '')
     {
        $('#amountdiv').addClass("has-error")
        msg += 'Amount is required';
        count += 1;
     }
     if (amount == 'notfound' && amountcustom == '')
     {
        $('#amountcustomdiv').addClass("has-error")
        msg += 'Custom Amount is required';
        count += 1;
     }
     if (bankaccounts == '')
     {
        $('#bankaccountsdiv').addClass("has-error")
        msg += 'Bank Accounts is required';
        count += 1;
     }
     if (password == '')
     {
        $('#passworddiv').addClass("has-error")
        msg += 'Password is required';
        count += 1;
     }
     if (captcha == '')
     {
        $('#captchadiv').addClass("has-error")
        msg += 'Captcha is required';
        count += 1;
     }
     if (msg != '')
     {
        if (count == 1)
        {
            $('#transferresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, some field with * are required." +
                                            "</div>");
        }
        else {
            $('#transferresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, some field with * are required." +
                                            "</div>");
        }
        $('#transfersave').html("Save");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        amount: amount,
        bankaccounts: bankaccounts,
        amountcustom: amountcustom,
        password: password,
        captcha: captcha,
        command: "transfers_add" 
    });
    


    if (amount == 'notfound')
    {
        amount = amountcustom;
    }

    /* Put the results in a div */
    posting.done(function(data) {
        
        if (data > 0)
        {
        $("#transferresult").html("<div class='alert alert-success alert-dismissable'>"+
                        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                        "<strong><i class='fa fa-smile-o'></i> Success!</strong> You have placed a new transfer order requests"+
                    "</div>"+
                    "<script type='text/javascript'>"+
                    "$('#amount').val('');"+
                    "$('#password').val('');"+
                    "$('#bankaccounts').val('');"+
                    "$('#amountcustom').val('');"+
                    "$('#captcha').val('');"+
                    "</script>");
        $('#order_id').append("<div class='portlet'>"+
                                    "<div class='portlet-heading bg-primary'>"+
                                        "<h3 class='portlet-title'>"+
                                           "New Requests"+
                                        "</h3>"+
                                        "<div class='portlet-widgets'>"+
                                            "<a href='javascript:void(0);' onclick='refreshTransferFund("+data+");' data-toggle='reload'><i class='ion-refresh'></i></a>"+
                                            "<span class='divider'></span>"+
                                            "<a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary"+data+"'><i class='ion-minus-round'></i></a>"+
                                            "<span class='divider'></span>"+
                                            "<a href='javascript:void(0);' onclick='deleteTransferFund("+data+");' data-toggle='remove'><i class='ion-close-round'></i></a>"+
                                        "</div>"+
                                        "<div class='clearfix'></div>"+
                                    "</div>"+
                                    "<div id='bg-primary"+data+"' class='panel-collapse collapse in'>"+
                                        "<div class='portlet-body'>"+
                                            "<p> You created a new transfer fund request order.</p>"+
                                            "<p> Amount: "+ amount + "</p>"+
                                            "<hr>"+
                                            "<p> Status: Pending</p>"+
                                            "<p class='text-right'>"+
                                               "<button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='."+ captcha +"'>Details</button>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='modal fade "+captcha+"' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>"+
                                        "<div class='modal-dialog modal-sm'>"+
                                            "<div class='modal-content'>"+
                                                "<div class='modal-header'>"+
                                                    "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"+
                                                    "<h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>"+
                                                "</div>"+
                                                "<div class='modal-body'>"+
                                                  "<p>You have created a new transfer fund request order</p>"+
                                                  "<p>Amount to transfer: "+ amount + "</p>"+
                                                  "<p>Please wait patiently as we find another participants for you. Thanks</p>"+
                                                  "<p>Status: Pending</p>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "</div>");
        }
        else {
            $("#transferresult").html(data);
        }
        $('#transfersave').html("Save");
                    
    });
       
       return;                 

});


//ADD NEW TRANSFER ORDER
$('#receivesave').on("click", function(event){
    $('#receivesave').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Saving...");
    $('.receive').removeClass("has-error");

    event.preventDefault();
     /* get some values from elements on the page: */
         var amount = $('#amountreceive').val(),
            bankaccounts = $('#bankaccountsreceive').val(),
            password = $('#passwordreceive').val(),
            captcha = $('#captchareceive').val(),
            url = "admin/actionmanager.php";

     //handle validations
     msg = '';
     var count = 0;
     if (amount == '')
     {
        $('#amountreceivediv').addClass("has-error")
        msg += 'Amount is required';
        count += 1;
     }
     if (bankaccounts == '')
     {
        $('#bankaccountsreceivediv').addClass("has-error")
        msg += 'Bank Accounts is required';
        count += 1;
     }
     if (password == '')
     {
        $('#passwordreceivediv').addClass("has-error")
        msg += 'Password is required';
        count += 1;
     }
     if (captcha == '')
     {
        $('#captchareceivediv').addClass("has-error")
        msg += 'Captcha is required';
        count += 1;
     }
     if (msg != '')
     {
        if (count == 1)
        {
            $('#receiveresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, some field with * are required." +
                                            "</div>");
        }
        else {
            $('#receiveresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, some field with * are required." +
                                            "</div>");
        }
        $('#receivesave').html("Save");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        amount: amount,
        bankaccounts: bankaccounts,
        password: password,
        captcha: captcha,
        command: "receives_add" 
    });
    

    /* Put the results in a div */
    posting.done(function(data) {
        
        if (data > 0)
        {
        $("#receiveresult").html("<div class='alert alert-success alert-dismissable'>"+
                        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                        "<strong><i class='fa fa-smile-o'></i> Success!</strong> You have placed a new receive order requests"+
                    "</div>"+
                    "<script type='text/javascript'>"+
                    "$('#amountreceive').val('');"+
                    "$('#passwordreceive').val('');"+
                    "$('#bankaccountsreceive').val('');"+
                    "$('#captchareceive').val('');"+
                    "</script>");
        $('#order_id').append("<div class='portlet'>"+
                                    "<div class='portlet-heading bg-primary'>"+
                                        "<h3 class='portlet-title'>"+
                                           "New Requests"+
                                        "</h3>"+
                                        "<div class='portlet-widgets'>"+
                                            "<a href='javascript:void(0);' onclick='refreshTransferFund("+data+");' data-toggle='reload'><i class='ion-refresh'></i></a>"+
                                            "<span class='divider'></span>"+
                                            "<a data-toggle='collapse' data-parent='#accordion1' href='#bg-primary"+data+"'><i class='ion-minus-round'></i></a>"+
                                            "<span class='divider'></span>"+
                                            "<a href='javascript:void(0);' onclick='deleteTransferFund("+data+");' data-toggle='remove'><i class='ion-close-round'></i></a>"+
                                        "</div>"+
                                        "<div class='clearfix'></div>"+
                                    "</div>"+
                                    "<div id='bg-primary"+data+"' class='panel-collapse collapse in'>"+
                                        "<div class='portlet-body'>"+
                                            "<p> You created a new recieve fund request order.</p>"+
                                            "<p> Amount: "+ amount + "</p>"+
                                            "<hr>"+
                                            "<p> Status: Pending</p>"+
                                            "<p class='text-right'>"+
                                               "<button class='btn btn-danger btn-xs waves-effect waves-light' data-toggle='modal' data-target='."+ data +"'>Details</button>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='modal fade "+data+"' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true' style='display: none;'>"+
                                        "<div class='modal-dialog modal-sm'>"+
                                            "<div class='modal-content'>"+
                                                "<div class='modal-header'>"+
                                                    "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"+
                                                    "<h4 class='modal-title' id='mySmallModalLabel'>New request details</h4>"+
                                                "</div>"+
                                                "<div class='modal-body'>"+
                                                  "<p>You have created a new receive fund request order</p>"+
                                                  "<p>Amount to receive: "+ amount + "</p>"+
                                                  "<p>Please wait patiently as we find another participants for you. Thanks</p>"+
                                                  "<p>Status: Pending</p>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "</div>");
        }
        else {
            $("#receiveresult").html(data);
        }
        $('#receivesave').html("Save");
                    
    });
       
       return;                 

});


//refresh transfer fund
function refreshTransferFund(x)
{
    event.preventDefault();

    var refreshfund = x,
        url = 'admin/actionmanager.php';

    /* Send the data using post */
    var posting = $.post(url, {
        refreshfund: refreshfund,
        command: "transfer_refresh" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#transferfund"+refreshfund).html(data);
       
                    
    });
     return; 



}

//refresh transfer 
function deleteTransferFund(x)
{
    event.preventDefault();

    var removefund = x,
        url = 'admin/actionmanager.php';

     /* Send the data using post */
    var posting = $.post(url, {
        removefund: removefund,
        command: "transfer_delete" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#fundresult").html(data);
        $("#fundresult").append("<script type='text/javascript'>"+
                    "window.setTimeout(function(){"+
                "document.location.href='dashboard.php';"+
            "},2000);"+
                "</script>");
                    
    });
     return;
}

//SORT FUND REQUEST
$('#sortfundbutton').on("click", function(event){
    $('#sortfundbutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Sorting...");
    $('.sort').removeClass("has-error");

    event.preventDefault();
     /* get some values from elements on the page: */
         var value = $('#sortfund').val(),        
            url = "admin/actionmanager.php";



    /* Send the data using post */
    var posting = $.post(url, {
        value: value,
        command: "transfer_sort" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#order_id").html(data);
        $('#sortfundbutton').html("Sort!");
       
                    
    });
     return; 
});



//onload pages
$(document).ready(function(){

    $('#availablebalancebutton').on("click", function(event)
    {
        var posting = $.post('admin/actionmanager.php', {
        command: "available_balance" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#availablebalance").html(data);
       
                    
    });   
    });

    $('#withdrawall').on("click", function(event)
    {
        var posting = $.post('admin/actionmanager.php', {
        command: "available_balance" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#amountreceive").val(data);
       
                    
    });   
    });


});


//RESET UPLOAD EVIDENCE OF PAYMENT
$('#paidresetbutton').on("click", function(event){
    $('#paidresetbutton').html("Reseting..");
    event.preventDefault();
    $('#amountpaid').val("");
    $('#uploadevidence').val("");
    $('#matchingpaid').html("");
    $('.paid').removeClass('has-error');

    $('#paidresetbutton').html("Reset");


});

function extend(matching_id) {
    $('#extendbutton'+matching_id).html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Extending...");
    $('#extend').removeClass('has-error');
    var matching_id = matching_id,
        password = $('#extendpassword'+matching_id).val();
        url = 'admin/actionmanager.php';

    //check if password is supplied
    if (password == '')
    {
        $('#extendpassworddiv'+matching_id).addClass('has-error');
        $('#matchingextend'+matching_id).html("<div class='alert alert-danger alert-dismissable'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "<i class='fa fa-warning'></i>**password is empty"+
                "</div>");
        $('#extendbutton'+matching_id).html("<i class='fa fa-sign-out'></i> Extend by 24 hours");
        return;
    }

     /* Send the data using post */
    var posting = $.post(url, {
        matching_id: matching_id,
        password: password,
        command: "extendmatching" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#matchingextend"+matching_id).html(data);
        $('#extendbutton'+matching_id).html("<i class='fa fa-sign-out'></i> Extend by 24 hours");
       
                    
    });
     return; 
}

//false payment
function falsePayment(matching_id) {
    $('#falsepaymentbutton'+matching_id).html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Flaging...");
    $('#extend').removeClass('has-error');
    var matching_id = matching_id,
        password = $('#extendpassword'+matching_id).val();
        url = 'admin/actionmanager.php';

    //check if password is supplied
    if (password == '')
    {
        $('#extendpassworddiv'+matching_id).addClass('has-error');
        $('#matchingextend'+matching_id).html("<div class='alert alert-danger alert-dismissable'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "<i class='fa fa-warning'></i>**password is empty"+
                "</div>");
        $('#falsepaymentbutton'+matching_id).html("<i class='fa fa-times'></i> False Payment");
        return;
    }

     /* Send the data using post */
    var posting = $.post(url, {
        matching_id: matching_id,
        password: password,
        command: "falsepayment" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#matchingextend"+matching_id).html(data);
        $('#falsepaymentbutton'+matching_id).html("<i class='fa fa-times'></i> False Payment");
       
                    
    });
     return; 
}


//UPLOAD PROF OF PAYMENT
$('#paidsave').on("click", function(event){
    $('#paidsave').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Saving...");

    $('.paid').removeClass('has-error');
    var amountpaid = $('#amountpaid').val(),
        matching_id = $('.matchingpaid').attr('id');
        evidence = $('#uploadevidence').prop("files")[0];
        url = 'admin/actionmanager.php';


    //check if password is supplied
    if (amountpaid == '')
    {
        $('#amountpaiddiv').addClass('has-error');
        $('#evidenceresult').html("<div class='alert alert-danger alert-dismissable'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "<i class='fa fa-warning'></i>**Amount paid is empty, please input the total amount paid"+
                "</div>");
        $('#paidsave').html("Save");
        return;
    }

     /* Send the data using post */
    var posting = $.post(url, {
        amountpaid: amountpaid,
        matching_id: matching_id,
        evidence: evidence,
        command: "evidence_add" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#evidenceresult").html(data);
        $('#paidsave').html("Save");
       
                    
    });
     return; 
});


//CONFIRM PAYMENT
function confirm(matching_id) {
    $('#confirmbutton'+matching_id).html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Confirming...");
    $('#extend').removeClass('has-error');
    var matching_id = matching_id,
        password = $('#extendpassword'+matching_id).val();
        url = 'admin/actionmanager.php';
   
    //check if password is supplied
    if (password == '')
    {
        $('#extendpassworddiv'+matching_id).addClass('has-error');
        $('#matchingextend'+matching_id).html("<div class='alert alert-danger alert-dismissable'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "<i class='fa fa-warning'></i>**password is empty"+
                "</div>");
        $('#confirmbutton'+matching_id).html("<i class='fa fa-check'></i> Confirm Payment");
        return;
    }

     /* Send the data using post */
    var posting = $.post(url, {
        matching_id: matching_id,
        password: password,
        command: "payment_confirm" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#matchingextend"+matching_id).html(data);
        $('#confirmbutton'+matching_id).html("<i class='fa fa-check'></i> Confirm Payment");
       
                    
    });
     return; 
};


function refreshMatchingFund(x)
{
    var matching_id = x,
        url = 'load.php';

     /* Send the data using post */
    var posting = $.post(url, {
        matching_id: matching_id
    });

    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#matching_id").load(url);
                     
    });
}

$('#sortmatchingbutton').on("click", function(event){
    $('#sortmatchingbutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Sorting...");
    event.preventDefault();

    var value = $('#sortmatching').val();

    url = '';
    if (value == 'All')
    {
        url = 'loadall.php';
    }
    else if (value == '5')
    {
        url = 'load5.php';
    }
    else if (value == '3')
    {
        url = 'load3.php';
    }
    else if (value == '0')
    {
        url = 'load0.php';
    }

     /* Send the data using post */
    var posting = $.post(url, {
        value: value
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#matching_id").load(url);
        $('#sortmatchingbutton').html("Sort!");
       
                    
    });
     return; 

});

//refresh wallet
function walletRefresh(x)
{
    $('#wallet_refresh').load("walletdetails.php");
   
}


//UPDATE THE BANK ACCOUNT BANKS DETAILS OF THE MEMBER
$('#updateBankAccounts').on("submit", function(event){
    $('#bankaccountupdatebutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Updating...");
    event.preventDefault();

    var $form = $(this),
        name = $('#updatename').val(),
        bankname = $('#updatebankname').val(),
        bankaccountnumber = $('#updatebankaccountnumber').val(),
        password = $('#updatepassword').val(),
        accountdetail_id = $('#account_id').attr('class');
        url = $form.attr('action');

     //handle validations
     msg = '';
     var count = 0;
     if (name == '')
     {
        $('#updatenamediv').addClass("has-error")
        msg += 'Name is required';
        count += 1;
     }
     if (bankaccountnumber == '')
     {
        $('#updatebankaccountnumberdiv').addClass("has-error")
        msg += 'Bank Accounts Number is required';
        count += 1;
     }
     if (bankname == '')
     {
        $('#updatebanknamediv').addClass("has-error")
        msg += 'Bank Name is required';
        count += 1;
     }
     if (password == '')
     {
        $('#updatepassworddiv').addClass("has-error")
        msg += 'Passsword is required';
        count += 1;
     }
     if (msg != '')
     {
        if (count == 1)
        {
            $('#updatebankresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, some field with * are required." +
                                            "</div>");
        }
        else {
            $('#updatebankresult').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, some field with * are required." +
                                            "</div>");
        }
        $('#bankaccountupdatebutton').html("Update changes");
        return;
     }

     /* Send the data using post */
    var posting = $.post(url, {
        name: name,
        bankname: bankname,
        accountdetail_id: accountdetail_id,
        bankaccountnumber: bankaccountnumber,
        password: password,
        command: "bankaccountdetails_update"
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#updatebankresult").html(data);
        $('#bankaccountupdatebutton').html("Update changes");
       
                    
    });
     return; 


});


//RESTORE YOUR ACCOUNT FORM
$('#recoverform').on("submit", function(event){
    $('#recoverbutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Restoring...");
    $('.error').removeClass("has-error");


    event.preventDefault();

     /* get some values from elements on the page: */
         var $form = $(this),
            email = $form.find('input[name="email"]').val(),
            captcha = $form.find('input[name="captcha"]').val(),
            url = $form.attr('action');

     //handle validations
     msg = '';
     var count = 0;
     if (email == '')
     {
        $('#emaildiv').addClass("has-error")
        msg += 'Username is required';
        count += 1;
     }
     if (captcha == '')
     {
        $('#captchadiv').addClass("has-error")
        msg += 'Captcha is required';
        count += 1;
     }
    
     if (msg != '')
     {
        if (count == 1)
        {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, please double check your information." +
                                            "</div>");
        }
        else {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, please double check your information." +
                                            "</div>");
        }
        $('#recoverbutton').html("Restore");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        email: email,
        captcha: captcha,
        command: "memberrestore" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#result").html(data);
        $('#recoverbutton').html("Restore");


                    
    });
       
       return;                 

});


//back to recover form
function backtoRecover()
{
    $('#recoververifyform').hide();
    $('#recoverform').show(500);


    $('#email').val("");
    $('#captcha').val("");
    $('#address').val("");
    $('#result').html("");
    $('.error').removeClass('has-error');
}

//function to submit recovering form
function submitrecoverVerifyForm()
{
    $('#recoververifybutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Verifying...");
    $('.error').removeClass("has-error");


    event.preventDefault();

     /* get some values from elements on the page: */
         var token = $('#token').val(),
            url = 'admin/actionmanager.php';

     //handle validations
     msg = '';
     var count = 0;
     if (token == '')
     {
        $('#tokendiv').addClass("has-error")
        msg += 'Token is required';
        count += 1;
     }
     

     if (msg != '')
     {
        $('#successalert').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** Please input token!" +
                                            "</div>");
       
        $('#recoververifybutton').html("Recover Account");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        token: token,
        command: "recovertoken_add" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#successalert").html(data);
        $('#recoververifybutton').html("Recover Account!");


                    
    });
       
       return;
}

//reset the password field in the recover form
function passwordReset(x)
{
    $('#password').val("");
    $('#confirmpassword').val("");
    $('#createpassword').html("");
    $('.error').removeClass('has-error');

    return;
}

//create a new password 
function submitpasswordForm(x)
{
    $('#passwordbutton').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Submiting...");
    $('.error').removeClass("has-error");


    event.preventDefault();

     /* get some values from elements on the page: */
         var password = $('#password').val(),
            confirmpassword = $('#confirmpassword').val(),
            url = 'admin/actionmanager.php';

     //handle validations
     msg = '';
     var count = 0;
     if (password == '')
     {
        $('#passworddiv').addClass("has-error");
        msg += 'Password is required';
        count += 1;
     }
     
     if (confirmpassword == '')
     {
        $('#confirmpassworddiv').addClass("has-error");
        msg += 'Password is required';
        count += 1;
     }

     if (confirmpassword != password)
     {
        $('#cpassworddiv').addClass("has-error");
        $('#confirmpassworddiv').addClass("has-error");
        msg += 'Password is required';
        count += 1;
     }

     if (msg != '')
     {
        if (count == 1)
        {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" error was found, please correct the following." +
                                            "</div>");
        }
        else {
            $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** "+count+" errors were found, please correct the following." +
                                            "</div>");
        }
        $('#passwordbutton').html("Recover Account");
        return;
     }


     /* Send the data using post */
    var posting = $.post(url, {
        password: password,
        command: "password_update" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#createpassword").html(data);
        $('#passwordbutton').html("Recover Account!");


                    
    });
       
       return;
}


$('#unlockaccountform').on("submit", function(event){
    $('#unlockpassword').html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Submiting...");
    event.preventDefault();
    var password = $('#password').val(),
        url = 'admin/actionmanager.php';

    if (password == '')
    {
        $('#result').html("<div class='alert alert-danger alert-dismissable'>" + 
                                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                                "<i class='fa fa-warning'></i> ** Password is empty" +
                                            "</div>");
        $('#unlockpassword').html("Log In");
        return;
    }


     /* Send the data using post */
    var posting = $.post(url, {
        password: password,
        command: "unlock_account"
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#result").html(data);
        $('#unlockpassword').html("Log In");


                    
    });
       
       return;
});


//function to handle testimony upload for members_update//CONFIRM PAYMENT
function testimony(donation_id) {
    $('#testimonybutton'+donation_id).html("<img src='img/icons/loading.gif' height='20px' width='20px' alt='' /> Saving...");
    $('#testimonyresult'+donation_id).html("");
    $('.testimony').removeClass('has-error');
    var donation_id = donation_id,
        testimony = $('#testimony'+donation_id).val();
        url = 'admin/actionmanager.php';
    //check if password is supplied
    if (testimony == '')
    {
        $('#testimonydiv'+donation_id).addClass('has-error');
        $('#testimonyresult'+donation_id).html("<div class='alert alert-danger alert-dismissable'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+
                    "<i class='fa fa-warning'></i>**Testimony letter is empty"+
                "</div>");
        $('#testimonybutton'+donation_id).html("<i class='fa fa-check'></i> Save");
        return;
    }

     /* Send the data using post */
    var posting = $.post(url, {
        donation_id: donation_id,
        testimony: testimony,
        command: "testimony_add" 
    });
    
    /* Put the results in a div */
    posting.done(function(data) {
        $("#testimonyresult"+donation_id).html(data);
        $('#testimonybutton'+donation_id).html("<i class='fa fa-check'></i> Save");
       
                    
    });
     return; 
};


//for adding news 
$('.newsreset').on("click", function(event)
{
    $('.error').removeClass('has-error');
    $('#result').html("");
    $('input').val("");
    $('textarea').val("");

});