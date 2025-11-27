<?php
	include_once '../urlConfig.php';
	if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ""){
		header("Location:".$base_url.'my-logout.php');
	}
	
	/***************** CHECK SESSION *****************/
	if($_SESSION['lawyer']['sessionid'] != session_id()){
		header("Location:".$base_url.'my-logout.php');
	}
	/***************** CHECK SESSION *****************/
	
	if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != "" && in_array($_SESSION['lawyer']['role_id'], ['2', '3'])) 
	{
		header("Location:".$base_url.'my-logout.php');
	}
	
	$csrftoken= md5(uniqid());
	$_SESSION['lawyer']['CSRF_Token'] = $csrftoken;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin | Rajasthan High Court</title>
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
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="RHC, RHCB, Lawyer, Cause list, index, home page, login page, Rajasthan High Court, RHCB Website, Rajsthan Govt" />
	<meta name="description" content="Rajasthan High Court" />
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
	
	<link rel="shortcut icon" href="../images/national-emblem-india.PNG">	
	<link rel="stylesheet" href="../includes/libs/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../includes/libs/bootstrap/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="../includes/css/style.css">
	<link rel="stylesheet" href="../includes/css/stylesheet1.css">
	<link rel="stylesheet" type="text/css" href="../includes/css/datepicker3.css"/>
	<link rel="stylesheet" type="text/css" href="../includes/css/bootstrap-timepicker.min.css"/>
	<link rel="stylesheet" type="text/css" href="../includes/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="../includes/css/loader.css"/>
	<link rel="stylesheet" href="../datatables/plugins/bootstrap/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../datatables/plugins/bootstrap/dataTables.bootstrap.css">
	<link href="../includes/css/sweetalert.css" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript" src="../includes/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../includes/js/moment.js"></script>
	<script type="text/javascript" src="../includes/libs/bootstrap/js/transition.js"></script>
	<script type="text/javascript" src="../includes/libs/bootstrap/js/collapse.js"></script>
	<script type="text/javascript" src="../includes/libs/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../includes/libs/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="../includes/js/validation_file.js?random=<?php echo rand(0001, 9999);?>"></script>
	<script src="../datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="../includes/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../includes/js/sweetalert.min.js"></script>	
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
		.modal{
			top:20% !important;
		}
		.alert{
			text-align:center !important;
		}
	</style>
</head>

<body>
<?php include 'header.php'; ?>

<div class="container text-center" id="main_div_min_height" style="min-height:430px;">
	<noscript>
		<h4 style="color: red;">Please enable JavaScript in your browser to use this application.</h4>
	</noscript>
	<span id="errMsg"></span>
	<form class="form-horizontal" id="searchForm" name="searchForm" style="">
		<div class="form-group" style="margin-top:10px;">
			<div class="row" style="margin-bottom:15px;"><h4>Vaccination Certificate Uploads Pending for Approval</h4></div>
			<div class="row">
				<label class="control-label col-sm-2">From Date:</label>
				<div class="col-sm-4">
					<input type="text" autocomplete="off" class="form-control datepickercalender" id="from_dt" placeholder="dd/mm/yyyy" maxlength="10" value="<?php echo '01'.date('/m/Y'); ?>" onkeypress="return checkdatecharacter(event);" readonly />
				</div>
				<label class="control-label col-sm-2">To Date:</label>
				<div class="col-sm-4">
					<input type="text" autocomplete="off" class="form-control datepickercalender" id="to_dt" placeholder="dd/mm/yyyy" maxlength="10" value="<?php echo date('d/m/Y'); ?>" onkeypress="return checkdatecharacter(event);" readonly />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<center>
						<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>
						<button title="Search Details" type="button" class="btn btn-primary" id="searchBtn" 
						style="margin-top:20px;" onclick="return searchVaccinationStatus();"><i class="fa fa-search"></i> &nbsp;Search</button>
					</center>
				</div>
			</div>
		</div>
		<div class="loading" id="loading" style="display:none;"><img src="../images/loader.svg"></div>
	</form> 

	<div class="container" id="searchEntriesTable" style="padding:5px; display:none;">
		<div class="clearfix"></div>
		<div class="row">
			<p class="showNumberOfRecords" style="text-align:center;display:none;">
			</p>
			  <table class="table table-striped table-bordered table-responsive" id="tbl_caselist">
				<thead>
					<tr>
						<th style="width:6%; text-align:center !important;">S.No.</th>
						<th style="width:10%; text-align:center !important;">
							Name
							<input type='text' placeholder='Search' autocomplete="false" data-column='2' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Enrolment / Registration No.
							<input type='text' placeholder='Search' autocomplete="false" data-column='3' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Mobile No.
							<input type='text' placeholder='Search' autocomplete="false" data-column='4' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Reference Id
							<input type='text' placeholder='Search' autocomplete="false" data-column='5' class='form-control'/>
						</th>
						<th style="width:7%; text-align:center !important;">
							First Dose
							<input type='text' placeholder='Search' autocomplete="false" data-column='6' class='form-control'/>
						</th>
						<th style="width:7%; text-align:center !important;">
							Second Dose
							<input type='text' placeholder='Search' autocomplete="false" data-column='7' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Date of taking dose
							<input type='text' placeholder='Search' autocomplete="false" data-column='8' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Type of User
							<input type='text' placeholder='Search' autocomplete="false" data-column='9' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Upload Date
							<input type='text' placeholder='Search' autocomplete="false" data-column='10' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Action
						</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
<a href="" download class="downloadFile" id="downloadFile" tabindex="-1" target="_blank"></a>

<div id="no_record_found_modal" class="modal fade" role="dialog" style="z-index:99995">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>					 
					<div class="alert alert-danger">
						<b class="error">No Record Found for select details</b>.
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
 
<div id="blank_field_modal" class="modal fade" role="dialog" style="z-index:99996">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
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
 
<div id="success_field_modal" class="modal fade" role="dialog" style="z-index:99997">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>					 
					<div class="alert alert-success" id='successModelText'></div>	
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
 
<div id="viewPartyIDinLarageMode" class="modal fade" role="dialog" style="z-index:99998; margin-top:-130px !important;">
	<div class="modal-dialog modal-lg">		
		<div class="modal-dialog modal-md">		
			<div class="modal-content modal-content">
				<form class="form-horizontal">
					<div class="modal-header">
						<span class="caption" style="font-size:15px; font-weight:bold; color:#373cd8;">Party Photo</span>
						<a class="close" data-dismiss="modal">&times;</a>
					</div>
					<div class="modal-body text-justify">
						<div class="form-group">
							<div class="col-sm-12 col-md-12 col-xs-12 text-center">
								<img src="" id="imgPartyPhotoLarge" style="height:450px; width:400px;">
							</div>
						</div>
					</div>
					<div class="modal-footer text-justify">
						<div class="form-group">
							<div class="col-sm-12 col-md-12 col-xs-12">
								<button type="button" class="btn btn-primary" style="float:right" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>	
		</div>	
	</div>
</div>

<div id="showCertificateDetails" class="modal fade" role="dialog" style="z-index:99990; margin-top:-130px !important;">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content">
			<div class="modal-header">
				<span class="caption" style="font-size:15px; font-weight:bold; color:#373cd8;">Approve/Reject Certificate Upload</span>
				<a class="close" data-dismiss="modal">&times;</a>
			</div>
			<div class="modal-body text-justify">
				<form class="form-horizontal" style="display: inline-block;">
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="form-group">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Name: <span class="lblName" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Enrolment / Registration Number: <span class="lblRegno" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Mobile Number: <span class="lblMobile" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Reference Id: <span class="lblRefid" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									First Dose: <span class="lblFirstdose" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Second Dose: <span class="lblSeconddose" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Date of taking dose: <span class="lblSeconddosedate" style="font-weight: normal;"></span>
								</label>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2">
									Type of User: <span class="lblUsertype" style="font-weight: normal;"></span>
								</label>
								<span class="lblUploadfor" style="font-weight: normal; display: none;"></span>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<label class="control-label col-md-offset-2" style="margin-bottom: 14px;">
									Upload Date: <span class="lblEntrydate" style="font-weight: normal;"></span>
								</label>
							</div>
							
							<div class="col-md-offset-3">
								<!--<button type="button" class="btn btn-primary" data-src="" id="btnViewCertificate" onclick="ViewPhotoinLarge(this.id)"> View Vaccination Certificate</button>-->
								<a href="" class="btn btn-primary" id="btnViewCertificate" target="_blank">View Vaccination Certificate</a>
							</div>
							
							<div class="col-sm-12 col-md-12 col-xs-12" style="margin-top:15px; margin-bottom:15px; z-index: 99;">
								<!--<label class="col-md-4"></label>-->
								<label class="control-label col-md-offset-2" for="uploadactionA">
									<input type="radio" id="uploadactionA" name="uploadaction" class="form-control uploadaction" value="A" onclick="toggleRemarkField();"> Approve
								</label>&nbsp;&nbsp;
								<label class="control-label col-md-offset-2" for="uploadactionR">
									<input type="radio" id="uploadactionR" name="uploadaction" class="form-control uploadaction" value="R" onclick="toggleRemarkField();"> Reject
								</label>
							</div>
							
							<div class="col-md-offset-2 DIV_REMARK" style="display:none; margin-top:10px;">
								<textarea class="form-control" id="remark" maxlength="250" rows="2" placeholder="Enter reason for rejection">
								</textarea>
							</div>
							
							<div class="col-sm-12 col-md-offset-3" style="margin-top:20px;">
								<button type="button" class="btn btn-success btnUploadAction" id="btnUploadAction" onclick="approveRejectUpload(this.id)">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="col-sm-12 col-md-12 col-xs-12">
							<label style="margin-top:6px !important;">
								<img src="" id="imgFilepath" style="max-height: 50%;" />
							</label>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".datepickercalender").datepicker({
			format: 'dd/mm/yyyy',
			startDate: '01/01/1900',
			autoclose: true
		});
		
		$('#showCertificateDetails').on('hide.bs.modal', function() {
			$('.lblName').text('');
			$('.lblRegno').text('');
			$('.lblMobile').text('');
			$('.lblRefid').text('');
			$('.lblSeconddosedate').text('');
			$('.lblUsertype').text('');
			$('.lblUploadfor').text('');
			$('.lblEntrydate').text('');
			$('.lblFirstdose').text('');
			$('.lblSeconddose').text('');
			$('#btnViewCertificate').attr('href', '');
			$('#imgFilepath').attr('src', '');
			$('#remark').val('');
			$('.DIV_REMARK').hide();
			$('.uploadaction').attr("checked", false);
		});
	});
	
	function showCertificateDetails(id) {
		var dataid = $('#'+id).attr('data-id');
		var pdata = $.trim($('#'+id).attr('data-pdata'));
		var dataArr = pdata.split('@@');
		
		$('.btnUploadAction').attr('data-id', dataid);
		
		$('#showCertificateDetails').modal({
			backdrop:'static',
			keyboard:false
		});
		
		$('.lblName').text(dataArr[0]);
		$('.lblRegno').text(dataArr[1]);
		$('.lblMobile').text(dataArr[2]);
		$('.lblRefid').text(dataArr[3]);
		$('.lblSeconddosedate').text(dataArr[4]);
		$('.lblUsertype').text(dataArr[5]);
		$('.lblUploadfor').text(dataArr[6]);
		$('.lblEntrydate').text(dataArr[8]);
		$('.lblFirstdose').text(dataArr[9]);
		$('.lblSeconddose').text(dataArr[10]);
		$('#btnViewCertificate').attr('href', '../'+dataArr[7]);
		//$('#imgFilepath').attr('src', '../'+dataArr[7]);
		
		$('#showCertificateDetails').modal('show');
		
		//$('#imgPartyPhoto').attr('src', '../StoreCandPhoto/'+dataid+'_'+$.trim(dataArr[6])+'.JPG?ab=<?php echo rand(1001, 9999); ?>');
		//$('#imgPartyID').attr('src', '../StoreCandIds/'+dataid+'_'+$.trim(dataArr[6])+'.JPG?ab=<?php echo rand(1001, 9999); ?>');
		//$('#btnViewPhotoLarge').attr('data-src', '../StoreCandPhoto/'+dataid+'_'+$.trim(dataArr[6])+'.JPG?ab=<?php echo rand(1001, 9999); ?>');
	}
	
	function ViewPhotoinLarge(btnid) {
		var src = $('#'+btnid).attr('data-src');
		$('#imgPartyPhotoLarge').attr('src', src);
		$('#viewPartyIDinLarageMode').modal({
			backdrop:'static',
			kayboard:false
		});
		$('#viewPartyIDinLarageMode').modal('show');
	}
	
	function isPastDate(startDate, endDate) {
		// date is dd/mm/yyyy
		var fromDate = startDate.split("/");
		var toDate = endDate.split("/");
		fromDate = new Date(fromDate[2], fromDate[1] - 1, fromDate[0], 0, 0, 0, 0);
		toDate = new Date(toDate[2], toDate[1] - 1, toDate[0], 0, 0, 0, 0);
		return fromDate >= toDate;
	}
	
	function toggleRemarkField() {
		var chkVal = $('.uploadaction:checked').val();
		$('#remark').val('');
		
		if(chkVal == 'A') {
			$('.DIV_REMARK').hide();
		}
		else {
			$('.DIV_REMARK').show();
		}
	}
	
	function searchVaccinationStatus() {
		$("#searchEntriesTable").hide();
		var csrf 	= $.trim($('#csrftoken').val());
		var fromdt 	= $.trim($('#from_dt').val());
		var todt 	= $.trim($('#to_dt').val());
		if((fromdt != '' || todt != '') && isPastDate(todt, fromdt)) {
			$('#loading').show();
			$.ajax({
				type:"POST",
				cache:false,
				url:"../ajax-responce.php",
				data:'fromdt='+btoa(fromdt)+'&todt='+btoa(todt)+'&status='+btoa('P')+'&csrftoken='+csrf+'&QueryType=getVaccinationStatus',
				dataType:"JSON",
				success: function (data) {
					$('#csrftoken').val(data[0]['csrftoken']);
					
					if(data[0]['status'] == "NO"){
						$('#modelText').html("No Record Found.");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "INV"){
						$('#modelText').html("Invalid Input Field Value.");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "CSRF"){
						$('#modelText').html("Authentication Failed.");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "INDEX"){
						window.location.href = '../my-logout.php';
					}
					else if(data.length == 1){
						$('#no_record_found_modal').modal('show');
					}
					else if(data[0]['status'] == 'OK' && data.length > 1) {
						var trhtml = '';
						var total=0;
						
						for(var i=1; i<data.length; i++){
							total++;
							
							trhtml += '<tr><td style="width:6%; text-align:center !important;">'+total+'</td><td style="width:10%;">'+data[i]['name']+'</td><td style="width:10%;">'+data[i]['regno']+'</td><td style="width:10%;">'+data[i]['mobile']+'</td><td style="width:10%; text-align:center !important;">'+data[i]['refid']+'</td><td style="width:7%;">'+data[i]['firstdose']+'</td><td style="width:7%;">'+data[i]['seconddose']+'</td><td style="width:10%;">'+data[i]['seconddosedate']+'</td><td style="width:10%;">'+data[i]['usertype']+'</td><td style="width:10%;">'+data[i]['entrydate']+'</td><td style="width:10%;"><button type="button" class="btn btn-primary" onclick="showCertificateDetails(this.id)" data-id="'+data[i]['id']+'" data-pdata="'+data[i]['name']+'@@'+data[i]['regno']+'@@'+data[i]['mobile']+'@@'+data[i]['refid']+'@@'+data[i]['seconddosedate']+'@@'+data[i]['usertype']+'@@'+data[i]['uploadfor']+'@@'+data[i]['filepath']+'@@'+data[i]['entrydate']+'@@'+data[i]['firstdose']+'@@'+data[i]['seconddose']+'" id="showbtn_'+data[i]['id']+'" style="padding:6px 10px !important; margin-left:5px;" data-toggle="tooltip" data-original-title="View Details to Approve/Reject"><i class="fa fa-eye"></i></button></td></tr>';
						}

						$("#tbl_caselist").dataTable().fnDestroy();
						$('#tbl_caselist tbody').html(trhtml);
						$('#tbl_caselist').DataTable({
							"ordering": false,
							"filter": false,
							"searching":true,
							"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
						});
						var table = $('#tbl_caselist').DataTable();
						// Apply the search
						table.columns().eq(0).each(function(colIdx){
							$("input[type='text']", table.column(colIdx).header()).on( 'keyup change', function (){
								table.column(colIdx).search(this.value).draw();
							});
						});
						$('.dataTables_filter').hide();
						$('.showNumberOfRecords').text("Total Number Of Records : "+total).css({'font-weight':'bold'}).show();
						$("#searchEntriesTable").show();

						$('[data-toggle="tooltip"]').tooltip();
					}
					else{
						$('#modelText').html("Server error. Please try after some time.");
						$('#blank_field_modal').modal('show');
					}
					$('#loading').hide();
				}
			});
		}
		else if(!isPastDate(todt, fromdt)){
			$('#modelText').text('Please check From Date should be less than or equal to To Date.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		else{
			$('#modelText').text('Please fill mandatory fields.');
			$('#blank_field_modal').modal('show');
			return false;
		}
	}

	function approveRejectUpload(btnid) {
		var dataid = $('#btnUploadAction').attr('data-id');
		var chkVal = $('.uploadaction:checked').val();
		var remark = $.trim($('#remark').val());
		var mobile = $('.lblMobile').text();
		var name = $('.lblName').text();
		var uploadfor = $('.lblUploadfor').text();
		var dose = $('.lblSeconddose').text() == 'Yes' ? 'second' : 'first';
		
		if(dataid != '' && dataid != '0' && (chkVal == 'A' || (chkVal == 'R' && remark != '')) && $('.uploadaction').is(':checked') == true)
		{
			var txtmsg = '';
			if (chkVal == 'A') {
				txtmsg = "Do you want to approve this certificate upload.";
			}
			else{
				txtmsg = "Do you want to reject this certificate upload.";
			}
			
			swal({
				title: "Are you sure?",
				text: txtmsg,
				showCancelButton: true,
				cancelButtonColor: '#39b78e',
				confirmButtonColor: '#ff000c',
				confirmButtonText: 'Yes',
				closeOnConfirm: true
			},
			function(){
				$('#loading').show();
				$.ajax({
					type:"POST",
					cache:false,
					url:"../ajax-responce.php",
					data:'dataid='+btoa(dataid)+'&remark='+btoa(remark)+'&chkval='+btoa(chkVal)+'&mobile='+btoa(mobile)+'&name='+btoa(name)+'&uploadfor='+btoa(uploadfor)+'&dose='+btoa(dose)+'&csrftoken='+$('#csrftoken').val()+'&QueryType=approveRejectCertificateUpload',
					dataType:"JSON",
					success: function (data) {
						var dataArr = data.split('##');						
						$('#csrftoken').val(dataArr[1]);
						
						if(dataArr[0] == "OK"){
							if (chkVal == 'A'){
								$('#successModelText').html("Verification successful.");
							}
							else{
								$('#successModelText').html("Rejection successful.");
							}
							$('#searchBtn').trigger('click');
							$('#remark').val('');
							$('#showCertificateDetails').modal('hide');
							$('#success_field_modal').modal('show');
						}
						else if(dataArr[0] == "IVI") {
							$('#modelText').html("Invalid input values.");
							$('#blank_field_modal').modal('show');
						}
						else if(dataArr[0] == "CSRF") {
							$('#modelText').html("Authentication failed.");
							$('#blank_field_modal').modal('show');
						}
						else {
							$('#modelText').html("Server error. Please try after some time.");
							$('#blank_field_modal').modal('show');
						}
						$('#loading').hide();
					}
				});
			});
		}
		else if($('.uploadaction').is(':checked') == false) {
			$('#modelText').html("Please select Approve or Reject option.");
			$('#blank_field_modal').modal('show');
		}
		else if(chkVal == 'R' && remark == '') {
			$('#modelText').html("Please enter reason for rejection in Remark field.");
			$('#blank_field_modal').modal('show');
		}
		else {
			$('#modelText').html("Something went wrong. Please try after some time.");
			$('#blank_field_modal').modal('show');
		}
	}
</script>
<?php include 'footer.php';?>
