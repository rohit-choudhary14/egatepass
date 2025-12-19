<?php
	if(date('Y-m-d H:i:s') > '2020-11-14 00:01:00' && date('Y-m-d H:i:s') < '2020-11-16 10:01:00') { 
		header("Location: https://hcraj.nic.in/hcraj/maintenance.php");
	}
	
	include 'urlConfig.php';
	error_reporting(0);
	$_SESSION['lawyer']['Salt_PHP'] = rand('10000', '99999').rand('10000', '99999'); 
	if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != "") 
	{
		header("Location:".$base_url."generate-pass.php");die;
	}

	$httpRefre = $_SERVER['HTTP_REFERER'];
	
	if($httpRefre){
		echo $_SESSION['lawyer']['unique'];
	}
	else{
		unset($_SESSION['lawyer']['unique']);
	}
	unset($_SESSION['lawyer']['enroll_num']);

	$csrftoken= md5(uniqid());
	$_SESSION['lawyer']['CSRF_Token']= $csrftoken;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RHC e-Pass | Login</title>		 	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
	    <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Mon, 01 Jan 1990 00:00:00 GMT">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="pragma" content="no-cache">        
        <meta http-equiv="cache-control" content="private" />
        <meta http-equiv="cache-control" content="pre-check=0" />
        <meta http-equiv="cache-control" content="post-check=0" />
        <meta http-equiv="cache-control" content="must-revalidate" />
        <meta http-equiv="content-language" content="en">
        <meta http-equiv="content-script-type" content="text/javascript">	
		<link rel="shortcut icon" href="images/national-emblem-india.PNG">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="RHC, RHCB, Lawyer, Cause list, index, home page, login page, Rajasthan High Court, RHCB Website, Rajsthan Govt" />
		<meta name="description" content="A cluster of Princely States with an oasis known as Ajmer-Merwara, a British India Territory, was given geographical expression as Rajputana. These Twenty and odd Rajputana States before 20th Century AD were dynastic and the Rulers were the fountain head of all Executive, Legislative and Judicial Authority in the States. As soon as the country got freedom from British Imperialism, the process of integration of the princely States to form bigger units was initiated." />
		<meta http-equiv="Content-Security-Policy">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8; X-Content-Type-Options=nosniff" />
		<script type="application/x-javascript"> 
			addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
			function hideURLbar(){ window.scrollTo(0,1); } 
		</script>

		<link rel="stylesheet" href="includes/libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="includes/libs/bootstrap/css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="includes/css/style.css">
		<link rel="stylesheet" href="includes/css/stylesheet1.css">
		<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css"/>
		<link rel="stylesheet" type="text/css" href="includes/css/loader.css"/>
		<link rel="stylesheet" type="text/css" href="includes/css/datepicker3.css"/>
		
		<script type="text/javascript" src="includes/js/SHA256.js"></script>
		<script type="text/javascript" src="includes/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="includes/js/moment.js"></script>
		<script type="text/javascript" src="includes/libs/bootstrap/js/transition.js"></script>
		<script type="text/javascript" src="includes/libs/bootstrap/js/collapse.js"></script>
		<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="includes/js/validation_file.js?random=<?php echo rand(0001, 9999);?>"></script>
		<script type="text/javascript" src="includes/js/bootstrap-datepicker.js"></script>
		<script>
			window.flag = [];
		</script>
		
		<style>
			.alert
			{
				text-align:center !important;
			}
			.ui-tooltip, .arrow:after {
				background: #fff;
				border: 1px solid #C90;
			}
			.ui-tooltip {
				padding: 10px 20px;
				color: #000;
				border-radius: 20px;
				font-size:12px;
			}
			.arrow {
				width: 70px;
				height: 30px;
				overflow: hidden;
				position: absolute;
				top: 40%;
				left: -69px;
			}
			.arrow.top {
				/*top: -16px;
				bottom: auto;*/
			}
			.arrow.left {
				/*left: 20%;*/
			}
			.arrow:after {
			content: "";
			position: absolute;
				/* left: 26px;*/
				right: -17px;
				width: 25px;
				height: 25px;
				box-shadow: 6px 5px 9px -9px black;
				-webkit-transform: rotate(45deg);
				-moz-transform: rotate(45deg);
				-ms-transform: rotate(45deg);
				-o-transform: rotate(45deg);
				tranform: rotate(45deg);
			}
			.arrow.top:after {
				bottom: -20px;
				top: auto;
			}
			.ui-tooltip-content {
				position: relative;
				padding: 1em;
			}
			.tooltip
			{
				left:170px !important;
				width:100% !mportant;
			}
			.contrastTheme{
			width:25px;
			height:25px;
			background:#000 !important;
			border:1px solid #fff;
			border-radius:50% !important;
			color:#fff;
			text-align:center;
			line-height:25px;
			}

		.defaultTheme{
			width:25px;
			height:25px;
			background:#fff !important;
			border:1px solid #000;
			border-radius:60% !important;
			color:#000;
			text-align:center;
			line-height:25px;
			}
		#Highcontrast, #Defaultcontrast{
		background:#fff !important;
		}
			
		</style>
	</head>
	<body >
		<?php include 'header.php'; ?>
		<?php
		if(isset($_SESSION['lawyer']['error']))
		{
			$error=$_SESSION['lawyer']['error'];
			unset($_SESSION['lawyer']['error']);
		?>
				<div class="alert alert-danger error_messages col-md-6 col-md-offset-3" style="margin-top:20px;">
					<strong>Error!</strong> <?php echo $error; ?>.
				</div>
		<?php }	?>

	<div class="alert alert-danger form_blank_error_message_for_letigents col-md-6 col-md-offset-3" style="display:none; margin-top:20px;">
	  <strong>Error!</strong> All Fields are mandatory.
	</div>

	<div class="alert alert-danger form_blank_error_message col-md-6 col-md-offset-3" style="display:none; margin-top:20px;">
	  <strong>Error!</strong> All Fields are mandatory.
	</div>

<div class="container text-center" style="min-height:420px;">
	<br /><br />
	<div class="loading" id="loading" style="display:none;"><img src="images/loader.svg" alt="Loading"></div>
	<form class="form-horizontal" method="post" id="lawyer_login_form">
		<div id="Advocate_login_form" >
			<div class="form-group">
				<label class="control-label col-sm-5" for="user"><span class="req" title="required">*</span>Login id:</label>
				<div class="col-sm-3">
					<input type="text" autocomplete="off" value="<?php if(isset($_POST['login_id'])){echo $_POST['login_id'];}?>" class="form-control regExpForEnrollnumberLogin input-sm required_validation_for_advocate_login name_validation" id="user" name="login_id" maxlength="50" placeholder="Login ID"  onkeypress="return isAlphaNumericCharater(event);" required aria-label="Login Id">
				</div>
			</div>
			<input type="hidden" name="user_type" class="user_type" />
			<div class="form-group">
				<label class="control-label col-sm-5" for="pass"><span class="req" title="required">*</span> Password:</label>
				<div class="col-sm-3"> 
					<input type="password" autocomplete="off" class="form-control input-sm name_validation regExpForPassField required_validation_for_advocate_login" id="pass" name="pass" placeholder="Password" maxlength="100" required aria-label="Password">
					<input type="hidden" value="1" name="loginBtn_advocate"/>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-1"></div>
				<div class="col-sm-11 centered">
					<input type="hidden" name="QueryType" value="loginBtn_advocate"/>
					<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>
					<button type="button" class="btn btn-primary login_btn_advocate" id="loginBtn" name="loginBtn_advocate"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Login</button>
					&nbsp;&nbsp;&nbsp;<a style="cursor:pointer; text-decoration:none" class="forget_password">Reset password</a>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-4"></div>
				<div class="col-sm-5 centered">
					<a href="signup.php" style="cursor:pointer; text-decoration:none;" class="btn btn-success"><b>New User Registration</b></a>
				</div>
				<div class="col-sm-3"></div>
			</div>
		</div>
	</form>
</div>

<div id="forget_password_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content modal-content col-md-8 col-md-offset-2" style="top:30%;">
			<form class="form-horizontal" method="post" id="ResetPasswordForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title req text-center">Forgot Password</h4>
				</div>
				<div class="alert alert-danger error_msg_reset_pwd col-md-12" style="display:none">
					<strong>Error!</strong> All fields are mandatory
				</div>
				<label class="col-sm-12 text-center" style="padding:15px;">Recovery Password will be sent to your registered mobile number</label>
				<br />
				<div class="modal-body row">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-sm-4" for="ad_mobile_no"><span class="req" title="required">*</span> Mobile No.:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm name_validation  req-Feild-reset-pwd regExpForTextField" id="ad_mobile_no" name="user_mobile_no" ng-model="user_mobile_no" placeholder="Enter mobile no. in 10 digits" pattern="[0-9]*" onblur="return mobileNumber('ad_mobile_no');" minlength="10" maxlength="10" required onkeypress="return onlyNumbers(event);" autocomplete="off"/>
									<span class="mobile_number_check_error_1 col-md-12" style="color:red;font-weight:bold;display:none;text-align:center;margin-top:1%;"></span>								
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-sm-4" for="ad_dob"><span class="req" title="required">*</span> DOB:</label>
								<div class="col-sm-8">
									<input type="text"  autocomplete="off"  class="form-control input-sm name_validation req-Feild-reset-pwd datepickercalender" id="dob" name="dob" placeholder="dd/mm/yyyy" maxlength="10" onkeypress="return checkdatecharacter(event);" onchange="calculateAge('dob');" onBlur="calculateAge('dob');"  required aria-label="Date of Birth">
									<span class="age_error_essage" style="color:red;font-weight:bold;display:none;font-size:12px;"></span>
								</div>
							</div>		
						</div>	
					</div>
					<div class="form-group">
						<div class="col-sm-12 col-md-12 col-xs-12 text-center">
							<button type="button" class="btn btn-primary send_verCode_btn" name="send_email"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
						</div>
					</div>	
				</div>
			</form>
		</div>	
	</div>
</div>

<div id="verification_code_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a href="<?php echo $base_url;?>" class="close" >&times;</a>
					<h4 class="modal-title req text-center">MOBILE NUMBER VERIFICATION</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger verification_code_error col-md-12" style="display:none">
						<strong>Error!</strong> Fields with * Sign are  mandatory.
					</div>
					<div class="alert alert-success col-md-12" id="messageForVericationCode" style="display:none;text-align:center;">
					</div>
					<div class="col-md-12 text-center">
						<div class="form-group">
							<div class="col-sm-6 col-md-offset-3">
								<input type="hidden" id='currentdatetime' class="regExpForTextField"/>
								<input type="hidden" id="hiddenUserId regExpForTextField" value="<?php echo $userHidden;?>"/>
								<input type="text" class="form-control input-sm name_validation required_validation_for_verification_code regExpForTextField" autocomplete="off"  id="verification_code" maxlength="8" placeholder="Enter Verification Code Here " required aria-label="Verification Code">
								<span class="verification_code_error_text" style="color:red;font-weight:bold;display:none;"></span>
								<span class="countdown" style="color:red;font-weight:bold;display:none;"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12 text-center">
						<div class="form-group">
							<div class="col-sm-12 col-md-12 col-xs-12">
								<button title="Submit Verification Code" type="button" id="submit_verification_code"  class="btn btn-primary" style="cursor:pointer;margin-left:2%;"><i class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></i>&nbsp;SUBMIT</button>
								<button title="Resend Verification Code" type="button" id="resend_verfication_code" class="btn btn-info" style="cursor:pointer;margin-left:2%;"><i class="fa fa fa-paper-plane" aria-hidden="true"></i>&nbsp;RESEND CODE</button>
								<a href="<?php echo $base_url;?>"  title="Cancle"  class="btn btn-danger"  style="cursor:pointer;margin-left:2%;"><i class="fa fa-times-circle-o" aria-hidden="true"></i>&nbsp;Close</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>
</div>
<div id="showModelForAllTypes" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content modal-content col-md-12" style="margin-top:15%;">
			<form class="form-horizontal">
				<div class="modal-header">
					<a  class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				</div>				
				<div class="modal-body">
					<span class="col-md-12 advocate_user"></span>
					<div class="alert alert-danger" style="text-align:center;">
						<span id="modelText"></span>
					</div>
						<div class="form-group">
						<div class="col-sm-12 col-md-12 col-xs-12">
							<button type="button" class="btn btn-primary" style="float:right" data-dismiss="modal">OK</button>
						</div>
					</div>	
				</div>
			</form>
		</div>	
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$(".datepickercalender").datepicker({
            format: 'dd/mm/yyyy',
			startDate: '01/01/1900',
            endDate: 'today',
			autoclose: true
        });
	});
	function calculateAge(id){
		var dob = $('#'+id).val();
		var splitDate = dob.split('/');
		dob = splitDate[1]+'/'+splitDate[0]+'/'+splitDate[2];
		if(dob){
			dob = new Date(dob);
			var today = new Date();
			var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
			var className = 'age_error_essage';
		
			if(age<18){
				$('.'+className).text('Age should be greater than or equal to 18').show();
			}
			else{
				$('.'+className).text('').hide();
			}
		}
	}

</script>

<script> 
$(document).ready(function(){
	$(document).on('click', '.forget_password', function(){
		$('.mobile_number_check_error_1').text('').hide();
		$('.email_id_check_error_1').text('').hide();
		$('.age_error_essage').text('').hide();
		$('.req-Feild-reset-pwd').css("border-color","#ccc");
		$('.error_msg_reset_pwd').html('').hide();
		$('#ResetPasswordForm').trigger('reset');
		$("#forget_password_modal").modal({
			backdrop: 'static',
			keyboard: false
		});
	});
	
	$(document).on('click', '.showVerifyBtn', function(){
		$('#messageForVericationCode').text("Verification code has been sent on your mobile number. Please enter the code below.").show();
		$("#verification_code_modal").modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#verification_code_modal').modal('show');
	});
	
	$(document).on('click','#submit_verification_code',function(e){
		var check_required_field='';
		var hiddenUserIdVal = $('#user_id').val();
		var vericationCode = $('#verification_code').val();
		$('.verification_code_error_text').text(" ").hide();
		var verCode =$('.required_validation_for_verification_code').val();
		
		$(".required_validation_for_verification_code").each(function(){
			var val22 = $(this).val();
			if (!val22){
				check_required_field ='form-error';
				$(this).css("border-color","#ccc");
				$(this).css("border-color","red");
				$('.verification_code_error').show();
			} 
			$(this).on('keypress change',function(){
				$(this).css("border-color","#ccc");
				$('.verification_code_error').hide();
			});
		});
		if(check_required_field){ 
			return false;
		}  
		else{
			var csrftoken = $('#csrftoken').val();
			e.preventDefault();
			var post_data = "mobile="+btoa($.trim($('#ad_mobile_no').val()))+"&vericationCode="+btoa(vericationCode)+"&csrftoken="+csrftoken+"&QueryType=checkVerificationCode";
			$.ajax({
				type:"POST",
				cache:false,
				url:"ajax-responce.php",
				data:post_data,
				success: function (html) {
					var dataArr = $.trim(html).split('##');
					$('#csrftoken').val(dataArr[1]);

					if(dataArr[0] == 'Yes'){
						$('.verification_code_error_text').text("Verified Successfully").css('color','green').show();
						setTimeout(function(){
							window.location.href="<?php echo $base_url.'resetpassword.php';?>";
						}, 300);
					}
					else if(dataArr[0] == 'CSRF'){
						$('#messageForVericationCode').text("Authentication failed. Please try again.").show();
					}
					else{
						$('.verification_code_error_text').text("Incorrect Verification Code").css('color','red').show();
					}
				}
			});
		}
	});

	$(document).on('click', '#resend_verfication_code', function(e){
		var check_required_field='';
		var hiddenUserIdVal = $('#hiddenUserId').val();
		var mobile = $('#ad_mobile_no').val();
		$('.verification_code_error_text').text(" ").hide();
		e.preventDefault();
		$('#messageForVericationCode').hide();
		var csrftoken = $('#csrftoken').val();
		
		var post_data = 'mobile='+btoa(mobile)+'&QueryType=resendVericationCode';						
		$.ajax({
			type:"POST",
			cache:false,
			url:"ajax-responce.php",
			data:post_data,   
			success: function (html) {
				var dataArr = $.trim(html).split('##');
				$('#csrftoken').val(dataArr[1]);
				
				if(dataArr[0] == 'Yes'){
					$('#messageForVericationCode').text("Verification code has been resent on your registered mobile number. Please enter the code below.").show();
				}
				else if(dataArr[0] == 'CSRF'){
					$('#messageForVericationCode').text("Authentication failed. Please try again.").show();
				}
				else{
					$('#messageForVericationCode').text(" ").hide();
				}
			}
		});
	});
});
</script> 

<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click', '.send_verCode_btn', function(e){
		var check_required_field='';
		$(".req-Feild-reset-pwd").each(function(){
			var val22 = $(this).val();
			if (!val22){
				check_required_field ='form-error';
				$(this).css("border-color","#ccc");
				$(this).css("border-color","red");
				$('.error_messages').hide();
				$('.error_msg_reset_pwd').html('<strong>'+'Error!'+'</strong> All fields are mandatory');
				$('.error_msg_reset_pwd').show();
			} 
			$(this).on('keypress change',function(){
				$(this).css("border-color","#ccc");
			});
		});
	 
		if(check_required_field){ 
			return false;
		}  
		else{
			var MobErr = $('.email_id_check_error_1').text();
			var ageErr = $('.age_error_essage').text();
			$('.error_msg_reset_pwd').html(' ').hide();
			if(MobErr){
				e.preventDefault();
				return false;
			}
			if(ageErr){
				e.preventDefault();
				return false;
			}
			else{
				$('.email_id_check_error_1').text('').hide();
				$('.age_error_essage').text('').hide();
				$('.error_msg_reset_pwd').html('').hide();
				
				var mobile 	= $('#ad_mobile_no').val();
				var dob 	= $('#dob').val();
				var csrftoken = $('#csrftoken').val();
				
				var post_data = "mobile="+btoa(mobile)+"&csrftoken="+csrftoken+"&QueryType=resetpasswordlink&dob="+btoa(dob);
				$.ajax({
					type:"POST",
					cache:false,
					url:"ajax-responce.php",
					data:post_data, 
					success: function (html) {
						var dataArr = $.trim(html).split('##');
						$('#csrftoken').val(dataArr[1]);
						
						if(dataArr[0] == "OK"){
							e.preventDefault();
							$('.error_msg_reset_pwd').hide();
							$('.error_msg_reset_pwd').html(' ').hide();
							$('.error_messages').hide();
							sendverificationCode(mobile, dob);
							return true;
						}
						else if(dataArr[0]=='DOB'){
							$('.error_msg_reset_pwd').html('<strong>'+'Error!'+'</strong> Invalid Date input please check.').show();
						}
						else if(dataArr[0] == 'CSRF'){
							$('.error_msg_reset_pwd').html('<strong>'+'Error!'+'</strong> Authentication failed please try again').show();
						}
						else if(dataArr[0]=='MNV'){
							$('.error_msg_reset_pwd').html('<strong>'+'Error!'+'</strong> Invalid mobile number').show();
						}
						else if(dataArr[0]=='NA'){
							$('.error_msg_reset_pwd').html('<strong>'+'Error!'+'</strong> No recod found with given details.').show();
						}
						else{
							$('.error_msg_reset_pwd').html('<strong>'+'Error!'+'</strong> No recod found with given details.').show();
							e.preventDefault();
							$('.error_messages').hide();
							return false;
						}
					}
				});
			}
		}
	});
});
</script>

<script> 
function sendverificationCode(mobile, dob){
	var csrftoken = $('#csrftoken').val();
	var post_data = "mobile="+btoa(mobile)+"&csrftoken="+csrftoken+"&QueryType=sendcodeforresetpass&dob="+btoa(dob);
	$.ajax({
		type:"POST",
		cache:false,
		url:"ajax-responce.php",
		data:post_data,  
		success: function (html) {
			var dataArr = $.trim(html).split('##');
			$('#csrftoken').val(dataArr[1]);
			
			if(dataArr[0] == 'DOB'){
				$('.form_blank_error_message_for_forget').html('<strong>'+'Error!'+'</strong> Invalid date format please check').show();
			}
			else if(dataArr[0]=='MNV'){
				$('.form_blank_error_message_for_forget').html('<strong>'+'Error!'+'</strong> Invalid Mobile Number').show();
			}
			else if(dataArr[0]=='CSRF'){
				$('.form_blank_error_message_for_forget').html('<strong>'+'Error!'+'</strong> Authentication failed please try again').show();
			}
			else if(dataArr[0] == 'OK'){
				$('#messageForVericationCode').text("Verification code has been sent on your Mobile Number. Please enter the code below.").show();
				$("#verification_code_modal").modal({
					backdrop: 'static',
					keyboard: false
				});
				$('#forget_password_modal').modal('hide');
			}
			else{
				$('.form_blank_error_message_for_forget').html('<strong>'+'Error!'+'</strong> No record found with given details.').show();
				$('.error_messages').hide();
				return false;
			}
		}
	});
}
</script> 

<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click','.login_btn_advocate',function(e){
		var check_required_field='';
		$('#loading').show();
		$(".required_validation_for_advocate_login").each(function(){
			var val22 = $(this).val();
			if (!val22){
				check_required_field ='form-error';
				$(this).css("border-color","#ccc");
				$(this).css("border-color","red");
				$('.form_blank_error_message_for_letigents').hide();
				$('.error_messages').hide();
				$('.form_blank_error_message').show();
			} 
			$(this).on('keypress change',function(){
				$(this).css("border-color","#ccc");
			});
		});
			
		var pwdregx  = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@_#$-&.*])[a-zA-Z0-9!@_#$-&.*]{6,16}$/;
		var loginIdregx  = /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9()]{5,30}$/;
		var myErrorstring ='';
		var upwd 	= $("#pass").val();
		var ulogid 	= $("#user").val();
		
		if(!pwdregx.test(upwd)){
			myErrorstring = "Please enter correct password. <br/>";
		}
		
		if(!loginIdregx.test(ulogid)){
			//myErrorstring = myErrorstring + "Please enter correct login Id. <br/>";
		}
		
		if(myErrorstring != ''){
			$("#showModelForAllTypes").modal({
				backdrop: 'static',
				keyboard: false
			});
			$('#modelText').html(myErrorstring);
			$('#showModelForAllTypes').modal('show');
			$('#loading').hide();
			return false;
		}
		
		if(check_required_field){ 
			$('.form_blank_error_message').show();
			$('.error_messages').hide();
			$('#loading').hide();
			return false;
		}  
		else{
			$('.form_blank_error_message').hide();
			$('.error_messages').hide();
			var Salt = '<?php echo $_SESSION['lawyer']['Salt_PHP']; ?>';
			$("#pass").val(SHA_256(SHA_256($("#pass").val())+Salt));
			$('#lawyer_login_form').attr('action', 'ajax-responce.php').submit();
		}
	});
});
</script>

<script>
$(document).bind("contextmenu",function(e) {
	e.preventDefault();
});	

$(document).keydown(function(e){
	if(e.which === 123){
	   return false;
	}
});
$("input[type='text']").tooltip({
	position: {
	my: "left center",
	at: "right center",
	using: function(position, feedback) {
			$(this).css(position);
			$( "<div>").addClass("arrow").addClass(feedback.vertical).addClass(feedback.horizontal).appendTo(this);
		}
	}
});
</script>


<?php include 'footer.php';?>