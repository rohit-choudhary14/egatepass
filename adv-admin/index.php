<?php
	include '../urlConfig.php';
	error_reporting(0);
	$_SESSION['lawyer']['Salt_PHP'] = rand('10000001', '99999999');
	
	if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != "") // && $_SESSION['lawyer']['role_id'] == '1')
	{
		header("Location:".$base_url."adv-admin/resquest-signin.php");die;
	}
	else if(isset($_SESSION['lawyer']['user_id']))
	{
		header("Location:".$base_url."my-logout.php");die;
	}

	$httpRefre = $_SERVER['HTTP_REFERER'];
	
	if($httpRefre){
		echo $_SESSION['lawyer']['unique'];
	}
	else{
		unset($_SESSION['lawyer']['unique']);
	}

	$csrftoken= md5(uniqid());
	$_SESSION['lawyer']['CSRF_Token'] = $csrftoken;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RHC e-Gate Pass Admin Login</title>		 	
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

		<link rel="stylesheet" href="../includes/libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../includes/libs/bootstrap/css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="../includes/css/style.css">
		<link rel="stylesheet" href="../includes/css/stylesheet1.css">
		<link rel="stylesheet" type="text/css" href="../includes/css/font-awesome.min.css"/>
		<link rel="stylesheet" type="text/css" href="../includes/css/loader.css"/>
		<link rel="stylesheet" type="text/css" href="../includes/css/datepicker3.css"/>
		
		<script type="text/javascript" src="../includes/js/SHA256.js"></script>
		<script type="text/javascript" src="../includes/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="../includes/js/moment.js"></script>
		<script type="text/javascript" src="../includes/libs/bootstrap/js/transition.js"></script>
		<script type="text/javascript" src="../includes/libs/bootstrap/js/collapse.js"></script>
		<script type="text/javascript" src="../includes/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../includes/libs/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="../includes/js/validation_file.js?random=<?php echo rand(0001, 9999);?>"></script>
		<script type="text/javascript" src="../includes/js/bootstrap-datepicker.js"></script>
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
		</style>
	</head>
	<body >
		<?php include 'header.php'; ?>
		<?php
		if(isset($_SESSION['lawyer']['error'])) {
			$error = $_SESSION['lawyer']['error'];
			unset($_SESSION['lawyer']['error']);
		?>
				<div class="alert alert-danger error_messages col-md-6 col-md-offset-3" style="margin-top:20px;">
					<strong>Error!</strong> <?php echo $error; ?>.
				</div>
		<?php } ?>

	<div class="alert alert-danger form_blank_error_message col-md-6 col-md-offset-3" style="display:none; margin-top:20px;">
	  <strong>Error!</strong> All Fields are mandatory.
	</div>

<div class="container text-center" style="min-height:420px;">
	<br /><br />
	<div class="loading" id="loading" style="display:none;"><img src="../images/loader.svg"></div>
	<form class="form-horizontal" method="post" id="admin-login-frm">
		<div id="Advocate_login_form" >
			<div class="form-group">
				<label class="control-label col-sm-5" for="user"><span class="req" title="required">*</span>Login id:</label>
				<div class="col-sm-3">
					<input type="text" autocomplete="off" class="form-control regExpForEnrollnumberLogin input-sm req-Feilds name_validation" id="user" name="login_id" maxlength="50" placeholder="Login Id"  onkeypress="return isAlphaNumericCharater(event);" required>
				</div>
			</div>
			<input type="hidden" name="user_type" class="user_type" />
			<div class="form-group">
				<label class="control-label col-sm-5" for="pass"><span class="req" title="required">*</span> Password:</label>
				<div class="col-sm-3"> 
					<input type="password" autocomplete="off" class="form-control input-sm name_validation regExpForPassField req-Feilds" id="pass" name="pass" placeholder="Password" maxlength="100" required>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-12 centered">
					<input type="hidden" name="QueryType" value="adminLogin"/>
					<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>
					<button type="button"  class="btn btn-primary login_btn_admin" id="loginBtn" name="adminLogin"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Login</button></a>
				</div>
			</div>
		</div>
	</form>
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
					<label class="col-md-12 advocate_user"></label>
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
$(document).ready(function(){
	$(document).on('click','.login_btn_admin',function(e){
		var check_required_field='';
		$('#loading').show();
		$(".req-Feilds").each(function(){
			var val22 = $(this).val();
			if (!val22){
				check_required_field ='form-error';
				$(this).css("border-color","#ccc");
				$(this).css("border-color","red");
				$('.error_messages').hide();
				$('.form_blank_error_message').show();
			} 
			$(this).on('keypress change',function(){
				$(this).css("border-color","#ccc");
			});
		});
			
		var pwdregx  = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@_#$-&.*])[a-zA-Z0-9!@_#$-&.*]{6,16}$/;
		var myErrorstring ='';
		var upwd 	= $("#pass").val();
		var ulogid 	= $("#user").val();
		
		if(!pwdregx.test(upwd)){
			myErrorstring = "Please enter correct password. <br/>";
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
			$('#admin-login-frm').attr('action', '../ajax-responce.php').submit();
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