<?php
	//error_reporting(E_ALL);
	//include('urlConfig.php');
	include_once('spoperation.php');
	
	if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ""){
		header("Location:".$base_url.'my-logout.php');
	}
	
	/***************** CHECK SESSION *****************/
	if($_SESSION['lawyer']['sessionid'] != session_id()){
		header("Location:".$base_url.'my-logout.php');
	}
	/***************** CHECK SESSION *****************/

	$user_id = $_SESSION['lawyer']['user_id'];
	$mobile = $_SESSION['lawyer']['mobile'];
	
	$csrftoken= md5(uniqid());
	$_SESSION['lawyer']['CSRF_Token'] = $csrftoken;
	
	$call = new spoperation();
	$vaccineStatus = $call->SP_GET_COVID_VACCINATION_STATUS_OTHERS($user_id);
	
	$dataid = '';
	$firstdose = 'N';
	$seconddose = 'N';
	$refid = '';
	$firstdosedate = '';
	//$seconddosedate = date('d/m/Y');
	$seconddosedate = '';
	$filePath = '';
	$regno = '';
	$name = '';
	$mobile = '';
	$status = '';
	$statusCode = '';
	$remark = '';
	//$maxdate = '';
	if(!empty($vaccineStatus)) {
		$dataid = $vaccineStatus[0]['id'];
		$firstdose = $vaccineStatus[0]['firstdose'];
		$seconddose = $vaccineStatus[0]['seconddose'];
		$refid = $vaccineStatus[0]['cert_ref_id'];
		$seconddosedate = $vaccineStatus[0]['second_dose_date'];
		$filePath = $vaccineStatus[0]['cert_file_path'];
		$regno = $vaccineStatus[0]['reg_no'];
		$name = $vaccineStatus[0]['name'];
		$mobile = $call->getDecryptValue($vaccineStatus[0]['mobile']);
		$statusCode = $vaccineStatus[0]['status'];
		
		if($firstdose == 'Y' && $seconddose != 'Y') {
			$firstdosedate = date('d/m/Y', strtotime($seconddosedate));
			$seconddosedate = date('d/m/Y', strtotime('+28 days', strtotime($seconddosedate)));
			//$maxdate = date('Y-m-d', strtotime('+28 days', strtotime($seconddosedate)));
		}
		else {
			//$seconddosedate = implode('/', array_reverse(explode('-', $seconddosedate)));
			$seconddosedate = date('d/m/Y', strtotime($seconddosedate));
		}
		
		switch($statusCode) {
			case 'P':
				$status = 'Pending';
				break;
			case 'A':
				$status = 'Approved';
				break;
			case 'R':
				$status = 'Rejected';
				$remark = $vaccineStatus[0]['remark'];
				break;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Upload Vaccination Certificate | RHC</title>		 	
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
	<meta name="revisit-after" content="1 day">
	<meta http-equiv="content-script-type" content="text/javascript">
	<base href="<?php echo $base_url;?>"/>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="RHC, RHCB, Lawyer, Cause list, index, home page, login page, Rajasthan High Court, RHCB Website, Rajsthan Govt" />
	<meta name="description" content="Upload Vaccination Certificate for Rajasthan High Court." />
	<meta http-equiv="Content-Security-Policy">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8; X-Content-Type-Options=nosniff" />
	<script type="application/x-javascript"> 
		addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
		function hideURLbar(){ window.scrollTo(0,1); } 
	</script>

	<style>
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
			position: absolute;
			padding: 1em;
		}
	</style>
	
	<link rel="shortcut icon" href="images/national-emblem-india.PNG">	
	<link rel="stylesheet" href="includes/libs/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="includes/libs/bootstrap/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="includes/css/style.css">
	<link rel="stylesheet" href="includes/css/stylesheet1.css">
	<link rel="stylesheet" type="text/css" href="includes/css/datepicker3.css"/>
	<link rel="stylesheet" type="text/css" href="includes/css/bootstrap-timepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="includes/css/loader.css"/>
	<link rel="stylesheet" href="datatables/plugins/bootstrap/dataTables.bootstrap.css">
	<link rel="stylesheet" href="datatables/plugins/bootstrap/dataTables.bootstrap.css">
	<link href="includes/css/sweetalert.css" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript" src="includes/js/SHA256.js"></script>
	<script type="text/javascript" src="includes/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="includes/js/moment.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/transition.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/collapse.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="includes/js/validation_file.js?random=<?php echo rand(0001, 9999);?>"></script>
	<script src="datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="includes/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="includes/js/sweetalert.min.js"></script>	
	<style>
		th, td {
			padding: 3px;
			text-align: center;
		}		
		.table-hover tbody tr:hover td {
			background: #4dffff;
		}
		.modal{
			top:20% !important;
		}
		.alert{
			text-align:center !important;
		}
	</style>
</head>

<body onunload="" oncontextmenu="return false" ondragstart="return false" onkeypress="return disableCtrlKeyCombination(event);" onkeydown="return disableCtrlKeyCombination(event);">
<?php include 'header.php'; ?>

<div class="container text-center" id="main_div_min_height" style="min-height:430px;">
	<noscript>
		<h4 style="color: red;">Please enable JavaScript in your browser to use this application.</h4>
	</noscript>
	<span id="errMsg"></span>
	<form class="form-horizontal" id="vaccinationForm">
		<div style="margin-top:20px;">
			<div class="row" style="margin-bottom:15px; font-size:18px; color:#372451;">
				<label class="col-sm-12 text-center">Upload Vaccination Certificate for Advocate Clerk</label>
			</div>
			<?php if(!empty($filePath) && $firstdose == 'Y') { ?>
			<div class="row text-center">
				<label>
					<a href="<?php echo $filePath; ?>" target="_blank">Click here to view vaccination certificate</a>
				</label>
			</div>
			<?php } ?>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">Registration No. of Advocate Clerk: </label>
					<div class="col-md-4 col-sm-12 text-left">
						<input type="text" id="regno" name="regno" class="form-control regno" value="<?php echo $regno; ?>" <?php if($firstdose == 'Y') { echo 'disabled'; } ?> placeholder="Only alphabets, numbers and / are allowed" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">Name of Advocate Clerk: </label>
					<div class="col-md-4 col-sm-12 text-left">
						<input type="text" id="name" name="name" class="form-control name" value="<?php echo $name; ?>" <?php if($firstdose == 'Y') { echo 'disabled'; } ?> placeholder="Only alphabets, spaces and . are allowed" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">Mobile No. of Advocate Clerk: </label>
					<div class="col-md-4 col-sm-12 text-left">
						<input type="text" id="mobile" name="mobile" class="form-control mobile" placeholder="10-digit mobile number" value="<?php echo $mobile; ?>" <?php if($firstdose == 'Y') { echo 'disabled'; } ?> />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">Has taken first dose of COVID vaccine? </label>
					<div class="col-md-8 col-sm-12 text-left">
						<label class="radio-inline">
							<input type="radio" class="firstdose" name="firstdose" value="Y" <?php if($firstdose == 'Y') { echo 'checked disabled'; } ?>> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" class="firstdose" name="firstdose" value="N" <?php if($firstdose == 'Y') { echo 'disabled'; } ?>> No
						</label>
					</div>
				</div>
			</div>
			<div class="row seconddosediv" style="<?php if($firstdose != 'Y') echo 'display: none;'; ?>">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">Has taken second dose of COVID vaccine? </label>
					<div class="col-md-8 col-sm-12 text-left">
						<label class="radio-inline">
							<input type="radio" class="seconddose" name="seconddose" value="Y" <?php if($seconddose == 'Y') { echo 'checked disabled'; } ?>>Yes
						</label>
						<label class="radio-inline">
							<input type="radio" class="seconddose" name="seconddose" value="N" <?php if($seconddose == 'Y') { echo 'disabled'; } ?>>No
						</label>
					</div>
				</div>
			</div>
			<div class="refiddiv" style="<?php if($firstdose != 'Y') echo 'display: none;'; ?>">
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-12">Reference ID on vaccination certificate: </label>
						<div class="col-md-4 col-sm-12 text-left">
							<input type="text" id="refid" name="refid" class="form-control refid" value="<?php echo $refid; ?>" <?php if($firstdose == 'Y') { echo 'disabled'; } ?> placeholder="Only numbers are allowed" />
						</div>
					</div>
				</div>
				<?php if($firstdose == 'Y' && $seconddose != 'Y') { ?>
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-12">Date of taking first dose: </label>
						<div class="col-md-4 col-sm-12 text-left">
							<input type="text" maxlength="10" class="form-control input-sm" data-date-format="dd/mm/yyyy" value="<?php echo $firstdosedate; ?>" readonly disabled />
						</div>
					</div>
				</div>
				<div class="row fileuploaddiv" style="display: none;">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-12">Date of taking second dose: </label>
						<div class="col-md-4 col-sm-12 text-left">
							<input type="text" maxlength="10" id="seconddosedate" name="seconddosedate" class="form-control date-picker input-sm seconddosedate" data-date-format="dd/mm/yyyy" data-date-end-date="+0d" data-date-start-date="<?php echo $seconddosedate; ?>" placeholder="dd/mm/yyyy" onkeypress="return checkdatecharacter(event);" value="<?php echo $seconddosedate; ?>" readonly /> 
						</div>
					</div>
				</div>
				<?php } else { ?>
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-12 dateLabel"></label>
						<div class="col-md-4 col-sm-12 text-left">
							<input type="text" maxlength="10" id="seconddosedate" name="seconddosedate" class="form-control <?php if($seconddose != 'Y') { echo 'date-picker'; } ?> input-sm seconddosedate" data-date-format="dd/mm/yyyy" data-date-end-date="+0d" <?php if($firstdose == 'Y' && $seconddose != 'Y') { echo 'data-date-start-date="'.$seconddosedate.'"'; } ?> placeholder="dd/mm/yyyy" onkeypress="return checkdatecharacter(event);" value="<?php echo $seconddosedate; ?>" readonly />
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			
			<?php if($firstdose == 'Y') { ?>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">
						Status:
					</label>
					<div class="col-md-4 col-sm-12">
						<input type="text" class="form-control" value="<?php echo $status; ?>" disabled />
					</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if($status == 'Approved') { ?>
			<div class="row">
				<center>
					<button title="Download Authorization Card" type="button" class="btn btn-primary btnDownloadCovidPass" style="margin-top:10px; margin-bottom:20px;" onclick="downloadCovidPass(this.id)" id="<?php echo $dataid; ?>"><i class="fa fa-download"></i> &nbsp;Download Authorization Card</button>
					&nbsp;&nbsp;
					<button title="Resend SMS" type="button" class="btn btn-primary btnResendSMS" style="margin-top:10px; margin-bottom:20px;" onclick="resendSMS(this.id)" id="<?php echo $dataid; ?>"><i class="fa fa-send"></i> &nbsp;Resend SMS</button>
				</center>
			</div>
			<?php } ?>
			
			<?php if($status == 'Rejected' && $remark != '') { ?>
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-12">
						Reason for rejection:
					</label>
					<div class="col-md-8 col-sm-12">
						<input type="text" class="form-control" value="<?php echo $remark; ?>" disabled />
					</div>
				</div>
			</div>
			<div class="row">
				<center>
					<button title="Click Here to Reset Vaccination Details" type="button" class="btn btn-primary btnEnableDataCorrection" style="margin-top:10px; margin-bottom:20px;" onclick="enableDataCorrection(this.id)" id="<?php echo $dataid; ?>"><i class="fa fa-reset"></i> &nbsp;Click Here to Reset Vaccination Details</button>
				</center>
			</div>
			<?php } ?>
			
			<?php if($seconddose != 'Y') { ?>
			<div class="fileuploaddiv" style="display: none;">
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-12" for="certificate">
							Upload Vaccination Certificate:<br />
							<font color="red">(File size should be between 20KB and 200KB in PDF or JPEG or JPG format)</font>
						</label>
						<div class="col-md-4 col-sm-12">
							<input type="file" name="certificate" id="certificate" class="form-control" accept="image/jpg, image/jpeg, application/pdf" onchange="checkCertificate();"/>
						</div>
					</div>
				</div>
				<div class="row">
					<center>
						<button title="Upload File" type="button" class="btn btn-primary" id="uploadBtn" 
						style="margin-top:10px; margin-bottom:20px;" onclick="return uploadCertificate();"><i class="fa fa-upload"></i> &nbsp;Upload Certificate</button>
					</center>
				</div>
			</div>
			<?php } ?>
		</div>
		<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>
		<div class="loading" id="loading" style="display:none;"><img src="images/loader.svg"></div>
	</form>

	<div class="container" id="searchEntriesTable" style="padding:5px; display:none;">
		<div class="clearfix"></div>
		<div class="row">
			
		</div>
	</div>
</div>
<a href="" download class="downloadFile" id="downloadFile" tabindex="-1" target="_blank"></a>

<div id="no_record_found_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a href="search-generated-pass.php" class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>					 
					<div class="alert alert-danger">
						<b class="error">No record found for select details</b>.
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
 
<div id="blank_field_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a href="search-generated-pass.php" class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>					 
					<div class="alert alert-danger" id='modelText'></div>	
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
 
<div id="success_field_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a href="search-generated-pass.php" class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>					 
					<div class="alert alert-success" id='successModelText'></div>	
					<div class="form-group">
						<div class="col-sm-12 col-md-12 col-xs-12">
							<!--<button type="button" class="btn btn-success btnDownloadePass" style="float:left" onclick="downloadePass(this.id)">Download Pass</button>-->
							<button type="button" class="btn btn-primary" id="modalbtnok" style="float:right" data-dismiss="modal">OK</button>
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>
</div>
	
 
<div id="showPassDetails" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<span class="caption" style="font-size:15px; font-weight:bold; color:#373cd8;">Pass Details</span>
					<a href="generate-pass.php" class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body text-justify">
					<label class="col-md-12"></label>					 
					<div class="alert alert-success" id='showModelText'></div>	
					<div class="form-group">
						<div class="col-sm-12 col-md-12 col-xs-12">
							<button type="button" class="btn btn-success btnDownloadePass" style="float:left" onclick="downloadePass(this.id)">Download Pass</button>
							<button type="button" class="btn btn-primary" style="float:right" data-dismiss="modal">OK</button>
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>
</div>

<div class="modal fade showallerrormsg" role="dialog" style="top:15%;">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content modal-content col-md-6 col-md-offset-3" >
			<form class="form-horizontal">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>
					<div class="alert alert-danger alertMessage">
						
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
	$(document).ready(function() {
		$('.date-picker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			maxDate: "+0D"
		});
		
		changeDateLabel();
		
		$('.firstdose').click(function() {
			let val = $(this).val();
			if(val == 'Y') {
				$('.seconddosediv').show();
				$('.refiddiv').show();
				$('.fileuploaddiv').show();
				$('.seconddose').attr("checked", false);
			}
			else {
				$('.seconddosediv').hide();
				$('.refiddiv').hide();
				$('.fileuploaddiv').hide();
				resetVaccinationForm();
			}
			
			changeDateLabel();
		});
		
		$('.seconddose').click(function() {
			<?php if($firstdose == 'Y') { ?>
			let val = $(this).val();
			if(val == 'Y') {
				$('.fileuploaddiv').show();
			}
			else {
				$('.fileuploaddiv').hide();
				$('#certificate').val(null);
			}
			<?php } ?>
			
			changeDateLabel();
		});
	});
	
	function resetVaccinationForm() {
		$('#refid').val('');
		$('#seconddosedate').val(moment().format('DD/MM/YYYY'));
		$('#certificate').val(null);
	}
	
	function changeDateLabel() {
		let firstdose = $('.firstdose:checked').val();
		let seconddose = $('.seconddose:checked').val();
		
		if(seconddose == 'Y') {
			$('.dateLabel').text('Date of taking second dose: ');
		}
		else {
			$('.dateLabel').text('Date of taking first dose: ');
		}
	}
	
	function validateRefId() {
		var refid = document.getElementById('refid').value;
		var format = /^[1-9][0-9]{12,13}$/;
		
		if(refid && !format.test(refid)) {
			return false;
		}
		
		return true;
	}
	
	function validateMobileNumber() {
		var mobile = document.getElementById('mobile').value;
		var format = /^[5-9][0-9]{9}$/;
		
		if(mobile && !format.test(mobile)) {
			return false;
		}
		
		return true;
	}
	
	function validateRegNo() {
		var regno = document.getElementById('regno').value;
		var format = /^[A-Za-z0-9\/]+$/;
		
		if(regno && !format.test(regno)) {
			return false;
		}
		
		return true;
	}
	
	function validateStringById(id) {
		var string = document.getElementById(id).value;
		var format = /^[A-Za-z .]+$/;
		
		if(string && !format.test(string)) {
			return false;
		}
		
		return true;
	}
	
	function checkCertificate() {
		var node_list = document.getElementById('certificate');
		if(node_list.value) {
			var sFileExtension = node_list.value.split('.')[node_list.value.split('.').length - 1];
			sFileExtension = sFileExtension.toLowerCase();
			
			if(sFileExtension != "jpg" && sFileExtension != "jpeg" && sFileExtension != "pdf") {
				$('.alertMessage').html('Please select certificate file in jpg, jpeg, or pdf format.');
				$('.showallerrormsg').modal('show');
				return false;
			}
		}
		else {
			$('.alertMessage').html('Please select vaccination certificate file.');
			$('.showallerrormsg').modal('show');
			return false;
		}
		
		if(node_list.files[0].size > 204800 || node_list.files[0].size < 20480) {
			$('.alertMessage').html('Please select certificate file with size between 20KB and 200KB.');
			$('.showallerrormsg').modal('show');
			return false;
		}
		
		return true;
	}
	
	function uploadCertificate() {
		if($('.firstdose:checked').length < 1 || $('.seconddose:checked').length < 1) {
			$('#modelText').text('Please select vaccination status.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		if($('.firstdose:checked').val() != 'Y') {
			$('#modelText').text('You can upload certificate only after getting first dose of vaccine.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		<?php if($firstdose == 'Y') { ?>
		if($('.seconddose:checked').val() != 'Y') {
			$('#modelText').text('You can upload certificate only after getting second dose of vaccine.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		<?php } ?>
		
		if($.trim($('#regno').val()) == '' || !validateRegNo()) {
			$('#modelText').text('Please enter valid registration no. of advocate clerk.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		if($.trim($('#name').val()) == '' || !validateStringById('name')) {
			$('#modelText').text('Please enter name of advocate clerk.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		if($.trim($('#mobile').val()) == '' || !validateMobileNumber()) {
			$('#modelText').text('Please enter valid 10-digit mobile no. of advocate clerk.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		if($.trim($('#refid').val()) == '' || !validateRefId()) {
			$('#modelText').text('Please enter valid reference id mentioned on vaccination certificate.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		if($('#seconddosedate').val() == '') {
			$('#modelText').text('Please select date of taking vaccination dose.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		
		if(checkCertificate()) {
			$('#loading').show();
			
			var postdata = new FormData();
			postdata.append('certificate', $('#certificate').prop('files')[0]);
			postdata.append('firstdose', $('.firstdose:checked').val());
			postdata.append('seconddose', $('.seconddose:checked').val());
			postdata.append('refid', $.trim($('#refid').val()));
			postdata.append('seconddosedate', $('#seconddosedate').val());
			postdata.append('regno', $.trim($('#regno').val()));
			postdata.append('name', $.trim($('#name').val()));
			postdata.append('mobile', $.trim($('#mobile').val()));
			postdata.append('uploadfor', 'C');
			postdata.append('csrftoken', $('#csrftoken').val());
			postdata.append('QueryType', 'uploadVaccinationCertificate');
			
			<?php if($firstdose == 'Y') { ?>
			postdata.append('action', 'U');
			postdata.append('dataid', '<?php echo $dataid; ?>');
			<?php } else { ?>
			postdata.append('action', 'I');
			<?php } ?>
			
			$.ajax({
				type: 'POST',
				evalScripts: true,
				cache: false,
				contentType: false,
				processData: false,
				url: 'ajax-responce.php',
				data: postdata,
				enctype: 'multipart/form-data',
				success: function (data) {
					$('#loading').hide();
					var splitData = $.trim(data).split('##');
					$('#csrftoken').val(splitData[1]);
					
					if(splitData[0] == 'Ok') {
						/*$('#vaccinationForm').trigger('reset');
						$('#successModelText').html('COVID vaccination certificate has been uploaded successfully.');
						$('#success_field_modal').modal('show');*/
						alert('COVID vaccination certificate has been uploaded successfully.');
						window.location.reload();
					}
					else if(splitData[0] == 'CSRF') {
						$('.alertMessage').html('Authentication failed.');
						$('.showallerrormsg').modal('show');
					}
					else if(splitData[0] == 'NVIMG') {
						$('.alertMessage').html('Please select certificate file in jpg, jpeg, or pdf format.');
						$('.showallerrormsg').modal('show');
					}
					else if(splitData[0] == 'IMGSIZE') {
						$('.alertMessage').html('Please select certificate file with size between 20KB and 200KB.');
						$('.showallerrormsg').modal('show');
					}
					else if(splitData[0] == 'input_error') {
						$('.alertMessage').html(splitData[2]);
						$('.showallerrormsg').modal('show');
					}
					else {
						$('.alertMessage').html('Something went wrong. Please try again after some time.');
						$('.showallerrormsg').modal('show');
					}
				}
			});
		}
	}
	
	function downloadCovidPass(passid) {
		if(passid != '' && passid != null) {
			$('#loading').show();
			ajaxRequest = $.ajax ({
				type: 'post',
				evalScripts: true,
				url:"get-covid-authorization-card.php",
				data:"passid="+btoa(passid)+'&uploadfor='+btoa('C')+"&csrftoken="+$('#csrftoken').val()+"&QueryType=getCovidPassPdf",
				success:function(data) {
					var dataArr = data.split('##');					
					$('#csrftoken').val(dataArr[1]);
					
					if(dataArr[0] == 'OK') {
						$('#downloadFile').attr('href', dataArr[2]);
						var element = document.getElementById('downloadFile');
						var eventObj = document.createEvent('MouseEvents');
						eventObj.initEvent('click',true,true);
						element.dispatchEvent(eventObj);
					}
					else if(dataArr[0] == 'CSRF') {
						$('#modelText').text('Authentication Failed.');
						$('#blank_field_modal').modal('show');
					}
					else if(dataArr[0] == 'NAN') {
						$('#modelText').text('Unauthorized access.');
						$('#blank_field_modal').modal('show');
					}
					else if(dataArr[0] == 'NA') {
						$('#modelText').text('Data not found.');
						$('#blank_field_modal').modal('show');
					}
					else {
						$('#modelText').text('Something went wrong. Please try again after some time.');
						$('#blank_field_modal').modal('show');
					}
					$('#loading').hide();
				}
			});
		}
	}
	
	function enableDataCorrection(dataid) {
		if(dataid != '' && dataid != null) {
			$('#loading').show();
			ajaxRequest = $.ajax ({
				type: 'post',
				evalScripts: true,
				url:"ajax-responce.php",
				data:"dataid="+btoa(dataid)+'&uploadfor='+btoa('C')+"&csrftoken="+$('#csrftoken').val()+"&QueryType=resetVaccinationData",
				success:function(data) {
					$('#loading').hide();
					var splitData = $.trim(data).split('##');
					$('#csrftoken').val(splitData[1]);
					
					if(splitData[0] == 'Ok') {
						alert('COVID vaccination certificate data has been reset successfully. Please enter details again and submit the form.');
						window.location.reload();
					}
					else if(splitData[0] == 'CSRF') {
						$('.alertMessage').html('Authentication failed.');
						$('.showallerrormsg').modal('show');
					}
					else if(splitData[0] == 'input_error') {
						$('.alertMessage').html(splitData[2]);
						$('.showallerrormsg').modal('show');
					}
					else {
						$('.alertMessage').html('Something went wrong. Please try again after some time.');
						$('.showallerrormsg').modal('show');
					}
				}
			});
		}
	}
	
	function resendSMS(passid) {
		if(passid != '' && passid != null) {
			$('#loading').show();
			ajaxRequest = $.ajax ({
				type: 'post',
				evalScripts: true,
				url:"ajax-responce.php",
				data:"dataid="+btoa(passid)+'&uploadfor='+btoa('C')+"&csrftoken="+$('#csrftoken').val()+"&QueryType=resendVaccinationSMS",
				success:function(data) {
					var dataArr = $.trim(data).split('##');
					$('#csrftoken').val(dataArr[1]);
					
					if(dataArr[0] == 'OK') {
						$('#modelText').text('SMS sent successfully.');
						$('#blank_field_modal').modal('show');
					}
					else if(dataArr[0] == 'CSRF') {
						$('#modelText').text('Authentication Failed.');
						$('#blank_field_modal').modal('show');
					}
					else if(dataArr[0] == 'NAN') {
						$('#modelText').text('Unauthorized access.');
						$('#blank_field_modal').modal('show');
					}
					else if(dataArr[0] == 'NA') {
						$('#modelText').text('Data not found.');
						$('#blank_field_modal').modal('show');
					}
					else {
						$('#modelText').text('Something went wrong. Please try again after some time.');
						$('#blank_field_modal').modal('show');
					}
					$('#loading').hide();
				}
			});
		}
	}
</script>
<?php include 'footer.php';?>
