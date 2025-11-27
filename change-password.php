<?php
	include 'urlConfig.php';
	if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ""){
		header("Location:".$base_url.'my-logout.php');
	}
	
	/***************** CHECK SESSION *****************/
	if($_SESSION['lawyer']['sessionid'] != session_id()){
		header("Location:".$base_url.'my-logout.php');
	}
	/***************** CHECK SESSION *****************/
	
	$csrftoken= md5(uniqid());
	$_SESSION['lawyer']['CSRF_Token'] = $csrftoken;
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<title>RHCB Lawyer Change Password | Jaipur</title>		 	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow">      
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
	<base href="" />		
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
	
	<script type="text/javascript" src="includes/js/SHA256.js"></script>
	<script type="text/javascript" src="includes/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="includes/js/moment.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/transition.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/collapse.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="includes/js/validation_file.js?random=<?php echo rand(0001, 9999);?>"></script>

	<style>
		th, td {
			padding: 3px;
			text-align: center;
		}
		
		.table-hover tbody tr:hover td {
			background: #4dffff;
		}
		
		#partyDetailsTab {
			
		}
		.modal 
		{
			top:20% !important;
		}
		.alert 
		{
			text-align:center !important;
		}
	</style>
</head>

<body onunload="" oncontextmenu="return false" ondragstart="return false" onkeypress="return disableCtrlKeyCombination(event);" onkeydown="return disableCtrlKeyCombination(event);">
<?php include 'header.php';?>

<div class="container text-center" id="main_div_min_height" style="min-height:430px;">	
	<form class="form-horizontal" method="post" id="pwdForm">
		<h3><u id="fmHeading">Change Password</u></h3><br />
		<div class="alert alert-danger form_blank_error_message_for_change col-md-6 col-md-offset-3" style="display:none">
			<strong>Error!</strong> All Fields are mandatory.
		</div>
		<div class="form-group">
			<label class="control-label col-sm-5" for="user"><abbr class="req">*</abbr> Old Password:</label>
			<div class="col-sm-3">
				<input type="password" autocomplete="off" class="form-control input-sm  regExpForPassField name_validation required_validation_fro_change_pass" id="old_password" name="old_password" placeholder="Enter your old password" maxlength="100" required>
				<span class="old_password_error" style="color:red;font-weight:bold;"></span>
			</div>
		</div>
		<div class="loading" id="loading" style="display:none;"><img src="images/loader.svg"></div>
		<div class="form-group">
			<label class="control-label col-sm-5 col-xs-12" for="pass"><abbr class="req" >*</abbr> New Password:</label>
			<div class="col-sm-5 col-md-5 col-xs-12"> 
				<div class="col-sm-7 col-md-7 col-xs-12" style="margin:0px;padding:0px;">
					<input type="password" autocomplete="off" class="form-control input-sm name_validation regExpForPassField required_validation_fro_change_pass" onblur="checkPwd();checkpassword();" id="new_password" name="new_password" placeholder="Enter new password" maxlength="100" required>
					<span class="password_check_error_msg" style="color:red;font-weight:bold;display:none;"></span>
				</div>
				<div class="col-sm-5 col-md-5 col-xs-12" style="float:right;">
					<a class="Password_Policy" style="cursor:pointer;">Password Policy</a>
				</div>
			</div>
		</div>
			<div class="form-group">
			<label class="control-label col-sm-5" for="pass"><abbr class="req" >*</abbr> Confirm Password:</label>
			<div class="col-sm-3"> 
				<input type="password" autocomplete="off" onblur="checkpassword();" class="form-control regExpForPassField input-sm name_validation required_validation_fro_change_pass" id="conf_password" name="conf_password" placeholder="Confirm password" maxlength="100" required>
				<span class="password_match_error_msg_for" style="color:red;font-weight:bold;display:none;"></span>
			</div>
		</div>
		<div class="form-group"> 
			<div class="col-sm-12 centered">
				<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>
				<button title="Change Password" type="button" class="btn btn-primary change_password_btn" id="change_password" name="change_password"><i class="fa fa-key" aria-hidden="true"></i>&nbsp;Change Password</button>
			</div>
		</div>
	</form>
</div>
<br /><br />

<div id="password_success_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a href="my-logout.php" class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12 advocate_user"></label>
					<div class="alert alert-success">
						 Password Change Successfully
					</div>
					<div class="form-group">
						<div class="col-sm-12 col-md-12 col-xs-12">
							<a href="my-logout.php" class="btn btn-primary" style="cursor:pointer;float:right;">Continue</a>
						</div>
					</div>	
				</div>
			</form>
        </div>	
    </div>
</div>

<div id="Password_Policy_Model" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-12" style="top:20%;">
			<form class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title req text-center">Password Policy</h4>
				</div>
				<div class="modal-body">
					<br />
					<ul style="list-style-type:none">
						<li style="padding:5px;"><i class="glyphicon glyphicon-hand-right"></i> &nbsp; &nbsp; Password Length must be greater than equal to 8  and less than 16.</li>
						<li style="padding:5px;"><i class="glyphicon glyphicon-hand-right"></i> &nbsp; &nbsp; Password must use a combination of Atleast 1 Lower case letters (a – z).</li>
						<li style="padding:5px;"><i class="glyphicon glyphicon-hand-right"></i> &nbsp; &nbsp; Password must use a combination of Atleast 1 upper case letters (A – Z).</li>
						<li style="padding:5px;"><i class="glyphicon glyphicon-hand-right"></i> &nbsp; &nbsp; Password must use a combination of Atleast 1 number (0 – 9).</li>
						<li style="padding:5px;"><i class="glyphicon glyphicon-hand-right"></i> &nbsp; &nbsp; Must use a combination of At least one Special Characters: like (# $ % & ( ) * +  , - . / : ; < = > ? @ [ \ ]).</li>
						<li style="padding:5px;"><i class="glyphicon glyphicon-hand-right"></i> &nbsp; &nbsp; <strong>Please note down your password to login in future.</strong> </li>
					</ul>
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

<div id="password_error_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a  href="change-password.php" class="close" data-dismiss="modal">&times;</a>
				</div>				
				<div class="modal-body">
					<label class="col-md-12 advocate_user"></label>					 
					<div class="alert alert-danger change_text"></div>
					<div class="form-group"></div>	
				</div>
			</form>
        </div>	
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
      
    $(".email_validation").blur(function () {
        if (!ValidateEmail($(this).val())) {
			$(this).val("");
        }
        else {
            return  true;
        }
    });
    
   
    $(document).on('keydown', '.name_validation', function(e) {
		if (e.which === 32 &&  e.target.selectionStart === 0) {return false;}  
	});
	
	$(".number_validation").keydown(function (e) {
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
			(e.keyCode >= 35 && e.keyCode <= 40)) {
				 return;
		}
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});
 
	checkPwd = function () {
		var str = document.getElementById('new_password').value;
		var regularExpression  = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
		$('.password_check_error_msg').show();
		if(str!="" && str!=null){
			if (str.length < 8) {		
				$('.password_check_error_msg').text("Password length should be atleast 8 characters");
				return ("too_short");
			} 
			else if (str.length > 16) {
				$('.password_check_error_msg').text("Password length should be less than or equal to 16 characters");
				return ("too_long");
			}
			else if(!regularExpression.test(str)) {
				$('.password_check_error_msg').text("password should contain atleast one Upper Case Letter, one Lower Case Letter, one Number and one Special character");
				return ("bad_char");
			}
		}
		$('.password_check_error_msg').text("");
		return ("ok");
	}
});
</script>

<script type="text/javascript">
function checkpassword(){
	if($('#conf_password').val()!=""){
		if ($('#conf_password').val() == $('#new_password').val()){
		   $('.password_match_error_msg_for').text('');
		} 
		else{
			$('.password_match_error_msg_for').text('Password Mismatched');
			$('.password_match_error_msg_for').show();
		}
	}
}
</script>

<script type="text/javascript">
$(document).ready(function(e){
	var rep_image_val='';
	$(document).on('click', '.change_password_btn', function(e){
		var check_required_field='';
		checkpassword();
		checkPwd();
		$(".required_validation_fro_change_pass").each(function(){
			var val22 = $(this).val();
			if (!val22){
				check_required_field ='form-error';
				$(this).css("border-color","#ccc");
				$(this).css("border-color","red");
				$('.form_blank_error_message_for_change').show();
			}
			
			$(this).on('keypress change',function(){
				$(this).css("border-color","#ccc");
			});
		});
 
		if(check_required_field){ 
			return false;
		}  
		else{
			var Salt = '<?php echo $_SESSION['lawyer']['Salt_PHP']; ?>';
			var password_error_msg=$('.password_match_error_msg_for').text(); 
			var password_check_message=$('.password_check_error_msg').text();
			var old_pass_error=$('.old_password_error').text();
			
			if(password_error_msg=='Password Mismatched'){
				e.preventDefault();
				return false;
			}
			else if(password_check_message){
				e.preventDefault();
				return false;
			}
			else if(old_pass_error){
				e.preventDefault();
				return false;
			}
			else{
				$("#old_password").val(SHA_256(SHA_256($("#old_password").val())+Salt));
				$("#new_password").val(SHA_256($("#new_password").val()));
				$("#conf_password").val(SHA_256($("#conf_password").val()));
				
				var old_pass = $('#old_password').val();
				var new_pass = $('#new_password').val();
				var user_id  = '<?php echo $_SESSION['lawyer']['user_id']?>';
				
				if(old_pass){
					$('#loading').show();
					var data = 'new_pass='+btoa(new_pass)+'&csrftoken='+$('#csrftoken').val()+'&old_pass='+btoa(old_pass)+'&user_id='+btoa(user_id)+'&QueryType=ChangePassword';
					$.ajax({
						type:"POST",
						cache:false,
						url:"ajax-responce.php",
						data:data,   
						success: function (resp) {
							var dataArr = $.trim(resp).split('##');
							$('#csrftoken').val(dataArr[1]);
							$('#pwdForm').trigger('reset');
							
							if(dataArr[0] == "OK"){
								$('#password_success_modal').modal('show');
							}
							else if(dataArr[0]=="CSRF"){
								$('.change_text').text("Authentication Failed. Please try again.");
								$('#password_error_modal').modal('show');
							}
							else if(dataArr[0]=="OLD"){
								$('.change_text').text("New password must be different from last three password.");
								$('#password_error_modal').modal('show');
							}
							else if(dataArr[0]=="OPWNM"){
								$('.change_text').text("Old password not match. Please enter correct old password.");
								$('#password_error_modal').modal('show');
							}
							else if(dataArr[0]=="IVI"){
								$('.change_text').text("Inlaid input values.");
								$('#password_error_modal').modal('show');
							}
							else{
								$('.change_text').text("Incorrect Old Passsword.");
								$('#password_error_modal').modal('show');
							}
							$('#loading').hide();
						}
					});
				}
			}
		}
	});
});
</script>
<script>
$(document).ready(function(){
	$(document).on('click', '.Password_Policy', function(){
		$('#Password_Policy_Model').modal('show');
	})
});
</script>
<script>
$('#password_success_modal').on('hidden.bs.modal', function (e) {
	window.location.href="my-logout.php";
});

$('#password_error_modal').on('hidden.bs.modal', function (e) {
	location.reload();
});
</script>  
<?php include 'footer.php'?>
