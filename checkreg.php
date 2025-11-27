<?php
	include 'urlConfig.php';
	include 'spoperation.php';
	//9413960295
	
	function getEncryptValue($input){
		$password = 'Hcraj@123';
		$method = 'AES-256-CBC';
		$password = substr(hash('SHA256', $password, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		return base64_encode(openssl_encrypt($input, $method, $password, OPENSSL_RAW_DATA, $iv));
	}
	
	function getDecryptValue($input){
		$password = 'Hcraj@123';
		$method = 'AES-256-CBC';
		$password = substr(hash('SHA256', $password, true), 0, 32);
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		return openssl_decrypt(base64_decode($input), $method, $password, OPENSSL_RAW_DATA, $iv);
	}
	
	$msg = '';
	if($_POST)
	{
		$enrlno = trim($_POST['enrlno']);
		$mobile = trim($_POST['mobileno']);
		$email = trim($_POST['emailid']);
		
		if($enrlno != '')
		{
			$call = new spoperation();	 
			$data = $call->SP_CHECK_USER_ENROLLNO_EXISTS_OR_NOT($enrlno);
			if(!empty($data)){
				$msg .= "Advocate with enrollment no. $enrlno is already registered using following details: <br />" . getDecryptValue($data[0]['contact_num']) . ", " . getDecryptValue($data[0]['email']) . ", " . $data[0]['dob'];
			}
			else{
				$msg .= "Advocate with enrollment no. $enrlno is not yet registered.";
			}
		}
		
		if($mobile != '')
		{
			$call = new spoperation();	 
			$dbmobile = getEncryptValue($mobile);
			$data = $call->SP_CHECK_USER_MOBILE_EXISTS_OR_NOT($dbmobile);
			if(!empty($data)){
				$msg .= "Mobile no. $mobile is used by " . $data[0]['name'] . " (" . $data[0]['username'] . ")<br /><br />";
			}
			else{
				$msg .= "Mobile no. $mobile is not yet used.";
			}
		}
		
		if($email != '')
		{
			$call = new spoperation();	 
			$dbemail = getEncryptValue($email);
			$data = $call->SP_CHECK_USER_EMAILID_EXISTS_OR_NOT($dbemail);
			if(!empty($data)){
				$msg .= "Email address $email is used by " . $data[0]['name'] . " (" . $data[0]['username'] . ")";
			}
			else{
				$msg .= "Email address $email is not yet used.";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<title>RHCB</title>		 	
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
	<form class="form-horizontal" method="post" action="">
		<h3><u id="fmHeading">Check Registration Details</u></h3><br />
		<div class="alert alert-danger form_blank_error_message_for_change col-md-6 col-md-offset-3" style="display:none">
			<strong>Error!</strong> All Fields are mandatory.
		</div>
		<div class="form-group">
			<label class="control-label col-sm-5" for="enrlno">Enrollment Number</label>
			<div class="col-sm-3">
				<input type="text" autocomplete="off" class="form-control input-sm" id="enrlno" name="enrlno" placeholder="Enter Enrollment No." maxlength="15" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-5" for="mobileno">Mobile Number</label>
			<div class="col-sm-3">
				<input type="text" autocomplete="off" class="form-control input-sm" id="mobileno" name="mobileno" placeholder="Enter Mobile" maxlength="10" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-5" for="emailid">Email Address</label>
			<div class="col-sm-3">
				<input type="text" autocomplete="off" class="form-control input-sm" id="emailid" name="emailid" placeholder="Enter Email" maxlength="100" />
			</div>
		</div>
		<div class="form-group"> 
			<div class="col-sm-12 centered">
				<button title="Check" type="submit" class="btn btn-primary" id="check" name="check" onClick="return checkDetails();"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Check Details</button>
			</div>
		</div>
		<br />
		<div class="form-group"> 
			<div class="col-sm-12 centered">
				<b><?php echo $msg; ?></b>
			</div>
		</div>
	</form>
</div>


<script type="text/javascript">
function checkDetails() {
	var enrlno = $.trim($('#enrlno').val());
	var mobile = $.trim($('#mobileno').val());
	var email = $.trim($('#emailid').val());
	
	if(enrlno == '' && mobile == '' && email == '') {
		alert('Please enter atleast one field.');
		return false;
	}
	else {
		return true;
	}
}
</script>

<?php include 'footer.php'?>
