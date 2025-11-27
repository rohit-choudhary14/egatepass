<?php
	include '../urlConfig.php';
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
	<meta name="description" content="A cluster of Princely States with an oasis known as Ajmer-Merwara, a British India Territory, was given geographical expression as Rajputana. These Twenty and odd Rajputana States before 20th Century AD were dynastic and the Rulers were the fountain head of all Executive, Legislative and Judicial Authority in the States. As soon as the country got freedom from British Imperialism, the process of integration of the princely States to form bigger units was initiated." />
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
	<div class="loading" id="loading" style="display:none;"><img src="../images/loader.svg"></div>
	<span id="errMsg"></span>
	<form class="form-horizontal" id="searchForm" name="searchForm" style="">
		<div class="form-group" style="margin-top:10px;">
			<div class="row"><h4>Date Wise Pass Generation Report</h4></div>
			<div class="row" style="margin-bottom:20px;">
				<div class="form-group">
					<div class="col-md-12 text-center">
						<label class="radio-inline">
							<input type="radio" name="searchtype" class="searchtype" value="1"> Pass Generation Date
						</label>
						<label class="radio-inline">
							<input type="radio" name="searchtype" class="searchtype" value="2"> Cause List Date (Date of Visit)
						</label>
					</div>
				</div>
			</div>
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
						style="margin-top:20px;" onclick="return searchreportcount();"><i class="fa fa-search"></i> &nbsp;Search</button>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<button title="Download Report" type="button" class="btn btn-danger" id="btnDownloadPDF" 
						style="margin-top:20px; display:none;" onclick="return downloadePDF();"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
					</center>
				</div>
			</div>
		</div>
	</form> 
	
	<div class="container" id="searchRegTable" style="padding:5px; display:none;">
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 text-center">
				<label class="control-label">
					Date Wise e-Pass Report for <?php echo $_SESSION['lawyer']['estt'] == 'P' ? 'Jodhpur':'Jaipur'; ?> as on <?php echo date('d/m/Y h:i A'); ?>
				</label>
			</div>
		</div>
		<div class="row">
			<div id="div_reg_pass_cnt">
				<table border="1" class="table table-striped table-bordered table-responsive" id="tbl_regcntlist" style="display:none; border-collapse:collapse; width:98%;">
					<thead>
						<tr>
							<th rowspan="2" style="vertical-align:middle; width:8%; text-align:center !important;">S.No.</th>
							<th rowspan="2" style="vertical-align:middle; text-align:center !important;">
								Date of Pass Generation
							</th>
							<th colspan="4" style="text-align:center !important;">
								Pass Issued
							</th>
							<th rowspan="2" style="vertical-align:middle; text-align:center !important;">
								Total Passess
							</th>
							<th colspan="3" style="text-align:center !important;">
								Registrations
							</th>
							<th rowspan="2" style="vertical-align:middle; text-align:center !important;">
								Total Registrations
							</th>
						</tr>
						<tr>
							<th style="text-align:center !important;">
								Sr. Advocate
							</th>
							<th style="text-align:center !important;">
								Advocate
							</th>
							<th style="text-align:center !important;">
								Litigant
							</th>
							<th style="text-align:center !important;">
								Party in Person
							</th>
							<th style="text-align:center !important;">
								Sr. Advocate
							</th>
							<th style="text-align:center !important;">
								Advocate
							</th>
							<th style="text-align:center !important;">
								Party in Person
							</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div id="div_pass_cnt">
				<table border="1" class="table table-striped table-bordered table-responsive" id="tbl_passcntlist" style="display:none; border-collapse:collapse; width:98%;">
					<thead>
						<tr>
							<th rowspan="2" style="vertical-align:middle; width:8%; text-align:center !important;">S.No.</th>
							<th rowspan="2" style="vertical-align:middle; text-align:center !important;">
								Date of Visit
							</th>
							<th colspan="5" style="text-align:center !important;">
								Pass Issued for Case Hearing
							</th>
							<th colspan="4" style="text-align:center !important;">
								Pass Issued for Section Visit
							</th>
							<th rowspan="2" style="vertical-align:middle; text-align:center!important;">
								Total Pass Issued
							</th>
						</tr>
						<tr>
							<th style="text-align:center !important;">
								Sr. Advocate
							</th>
							<th style="text-align:center !important;">
								Advocate
							</th>
							<th style="text-align:center !important;">
								Litigant
							</th>
							<th style="text-align:center !important;">
								Party in Person
							</th>
							<th style="text-align:center !important;">
								Total
							</th>
							<th style="text-align:center !important;">
								Sr. Advocate
							</th>
							<th style="text-align:center !important;">
								Advocate
							</th>
							<th style="text-align:center !important;">
								Party in Person
							</th>
							<th style="text-align:center !important;">
								Total
							</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<a href="" download class="downloadFile" id="downloadFile" tabindex="-1" target="_blank"></a>

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
<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>

<script type="text/javascript">
	$(document).ready(function(){
		var today  = "<?php echo date('d/m/Y', strtotime(date('Y-m-d').' + 30 days')); ?>";
		$(".datepickercalender").datepicker({
			format: 'dd/mm/yyyy',
			startDate: '26/06/2020',
			autoclose: true
		});
	});
	
	function isPastDate(startDate, endDate){
		// date is dd/mm/yyyy
		var fromDate = startDate.split("/");
		var toDate = endDate.split("/");
		fromDate = new Date(fromDate[2], fromDate[1] - 1, fromDate[0], 0, 0, 0, 0);
		toDate = new Date(toDate[2], toDate[1] - 1, toDate[0], 0, 0, 0, 0);
		return fromDate >= toDate;
	}
	
	$('.searchtype, .datepickercalender').on('change', function(){
		$('#tbl_regcntlist tbody').html('');
		$('#tbl_passcntlist tbody').html('');
		$('#searchRegTable').hide();
		$('#btnDownloadPDF').hide();
	});
	
	function searchreportcount(){
		$('#tbl_regcntlist').hide();
		$('#tbl_passcntlist').hide();
		$('#searchRegTable').hide();
		$('#btnDownloadPDF').hide();
		
		var fromdt = $.trim($('#from_dt').val());
		var todt   = $.trim($('#to_dt').val());
		var srchby = $('.searchtype:checked').val();
		var csrf   = $.trim($('#csrftoken').val());
		
		if(fromdt == '' || todt == '' || $('.searchtype').is(':checked') == false || !isPastDate(todt, fromdt)){
			$('#modelText').html("Please fill all mandatory information.");
			$('#blank_field_modal').modal('show');
		}
		else{
			$('#loading').show();
			$.ajax({
				type:"POST",
				cache:false,
				url:"../ajax-responce.php",
				data:'fromdt='+btoa(fromdt)+'&todt='+btoa(todt)+'&srchby='+btoa(srchby)+'&csrftoken='+csrf+'&QueryType=srchRegisterUser',
				dataType:"JSON",
				success: function (data) {
					$('#csrftoken').val(data[0]['csrftoken']);
					
					if(data[0]['status'] == "NO"){
						$('#modelText').html("No Record Found");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "INV"){
						$('#modelText').html("Invalid Input Field Value");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "CSRF"){
						$('#modelText').html("Authentication Failed.");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "INDEX"){
						window.location.href = 'my-logout.php';
					}
					else if(data.length == 1){
						$('#modelText').html("No record found");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == 'OK' && data.length > 1){
						var trcnthtml = ''; var totalsradvps = 0; var totaladvps = 0; var totallitps = 0; var totalpipps = 0;
						var totalsradvreg = 0; var totaladvreg = 0; var totallitreg = 0; var totalpipreg = 0;
						var totalsradvsectionpass = 0; var totaladvsectionpass = 0; var totalpipsectionpass = 0;
						var esttVal = "<?php echo $_SESSION['lawyer']['estt']; ?>";
						if(srchby == '99' && esttVal == 'B'){
							for(var i=1; i<data.length; i++){
								trcnthtml += '<tr><td style="text-align:center !important;">'+i+'</td><td style="text-align:center !important;">'+data[i]['regdate']+'</td><td style="text-align:center !important;">'+data[i]['sradvpass']+'</td><td style="text-align:center !important;">'+data[i]['advpass']+'</td><td style="text-align:center !important;">'+data[i]['litpass']+'</td><td style="text-align:center !important;">'+data[i]['pippass']+'</td><th style="text-align:center !important;">'+parseInt(parseInt(data[i]['sradvpass'])+parseInt(data[i]['advpass'])+parseInt(data[i]['litpass'])+parseInt(data[i]['pippass']))+'</th><td style="text-align:center !important;">'+data[i]['sradvreg']+'</td><td style="text-align:center !important;">'+data[i]['advreg']+'</td><td style="text-align:center !important;">'+data[i]['pipreg']+'</td><th style="text-align:center !important;">'+parseInt(parseInt(data[i]['sradvreg'])+parseInt(data[i]['advreg'])+parseInt(data[i]['pipreg']))+'</th></tr>';
								
								totalsradvps = parseInt(parseInt(totalsradvps)+parseInt(data[i]['sradvpass']));
								totaladvps	 = parseInt(parseInt(totaladvps)+parseInt(data[i]['advpass']));
								totallitps   = parseInt(parseInt(totallitps)+parseInt(data[i]['litpass']));
								totalpipps   = parseInt(parseInt(totalpipps)+parseInt(data[i]['pippass']));
								totalsradvreg= parseInt(parseInt(totalsradvreg)+parseInt(data[i]['sradvreg']));
								totaladvreg  = parseInt(parseInt(totaladvreg)+parseInt(data[i]['advreg']));
								totalpipreg  = parseInt(parseInt(totalpipreg)+parseInt(data[i]['pipreg']));
							}
							
							trcnthtml += '<tr><th colspan="2" style="text-align:center !important;">TOTAL</th><th style="text-align:center !important;">'+totalsradvps+'</th><th style="text-align:center !important;">'+totaladvps+'</th><th style="text-align:center !important;">'+totallitps+'</th><th style="text-align:center !important;">'+totalpipps+'</th><th style="text-align:center !important;">'+parseInt(totalsradvps+totaladvps+totallitps+totalpipps)+'</th><th style="text-align:center !important;">'+totalsradvreg+'</th><th style="text-align:center !important;">'+totaladvreg+'</th><th style="text-align:center !important;">'+totalpipreg+'</th><th style="text-align:center !important;">'+parseInt(totalsradvreg+totaladvreg+totalpipreg)+'</th></tr>';
							
							$('#tbl_regcntlist tbody').html(trcnthtml);
							$('#tbl_regcntlist').show();
						}
						else if(srchby == '2' || srchby == '1'){
							for(var i=1; i<data.length; i++){
								trcnthtml += '<tr><td style="text-align:center !important;">'+i+'</td><td style="text-align:center !important;">'+data[i]['regdate']+'</td><td style="text-align:center !important;">'+data[i]['sradvpass']+'</td><td style="text-align:center !important;">'+data[i]['advpass']+'</td><td style="text-align:center !important;">'+data[i]['litpass']+'</td><td style="text-align:center !important;">'+data[i]['pippass']+'</td><th style="text-align:center !important;">'+parseInt(parseInt(data[i]['sradvpass'])+parseInt(data[i]['advpass'])+parseInt(data[i]['litpass'])+parseInt(data[i]['pippass']))+'</th><td style="text-align:center !important;">'+data[i]['sradvsectionpass']+'</td><td style="text-align:center !important;">'+data[i]['advsectionpass']+'</td><td style="text-align:center !important;">'+data[i]['pipsectionpass']+'</td><th style="text-align:center !important;">'+parseInt(parseInt(data[i]['sradvsectionpass'])+parseInt(data[i]['advsectionpass'])+parseInt(data[i]['pipsectionpass']))+'</th><th style="text-align:center !important;">'+parseInt(parseInt(data[i]['sradvpass'])+parseInt(data[i]['advpass'])+parseInt(data[i]['litpass'])+parseInt(data[i]['pippass'])+parseInt(data[i]['sradvsectionpass'])+parseInt(data[i]['advsectionpass'])+parseInt(data[i]['pipsectionpass']))+'</th></tr>';
								
								totalsradvps = parseInt(parseInt(totalsradvps)+parseInt(data[i]['sradvpass']));
								totaladvps	 = parseInt(parseInt(totaladvps)+parseInt(data[i]['advpass']));
								totallitps   = parseInt(parseInt(totallitps)+parseInt(data[i]['litpass']));
								totalpipps   = parseInt(parseInt(totalpipps)+parseInt(data[i]['pippass']));
								
								totalsradvsectionpass = parseInt(parseInt(totalsradvsectionpass)+parseInt(data[i]['sradvsectionpass']));
								totaladvsectionpass	= parseInt(parseInt(totaladvsectionpass)+parseInt(data[i]['advsectionpass']));
								totalpipsectionpass = parseInt(parseInt(totalpipsectionpass)+parseInt(data[i]['pipsectionpass']));
							}
							
							trcnthtml += '<tr><th colspan="2" style="text-align:center !important;">TOTAL</th><th style="text-align:center !important;">'+totalsradvps+'</th><th style="text-align:center !important;">'+totaladvps+'</th><th style="text-align:center !important;">'+totallitps+'</th><th style="text-align:center !important;">'+totalpipps+'</th><th style="text-align:center !important;">'+parseInt(parseInt(totalsradvps)+parseInt(totaladvps)+parseInt(totallitps)+parseInt(totalpipps))+'</th><th style="text-align:center !important;">'+totalsradvsectionpass+'</th><th style="text-align:center !important;">'+totaladvsectionpass+'</th><th style="text-align:center !important;">'+totalpipsectionpass+'</th><th style="text-align:center !important;">'+parseInt(parseInt(totalsradvsectionpass)+parseInt(totaladvsectionpass)+parseInt(totalpipsectionpass))+'</th><th style="text-align:center !important;">'+parseInt(parseInt(totalsradvps)+parseInt(totaladvps)+parseInt(totallitps)+parseInt(totalpipps)+parseInt(totalsradvsectionpass)+parseInt(totaladvsectionpass)+parseInt(totalpipsectionpass))+'</th></tr>';
							
							$('#tbl_passcntlist tbody').html(trcnthtml);
							$('#tbl_passcntlist').show();
						}
						$('#btnDownloadPDF').show();
						$('#searchRegTable').show();
					}
					else{
						$('#modelText').html("Technical issues are occured. Please try after some time.");
						$('#blank_field_modal').modal('show');
					}
					$('#loading').hide();
				}
			});
		}
	}
	
	function downloadePDF(){
		var fromdt = $.trim($('#from_dt').val());
		var todt   = $.trim($('#to_dt').val());
		var srchby = $('.searchtype:checked').val();
		var csrf   = $.trim($('#csrftoken').val());
		//alert(srchby);
		if((fromdt != '' || todt != '') && isPastDate(todt, fromdt) && $('.searchtype').is(':checked') == true){
			$('#loading').show();
			ajaxRequest = $.ajax ({
				type: 'post',
				evalScripts: true,
				url:"../date-wise-report-pdf.php",
				data:"srchby="+btoa(srchby)+"&fromdt="+btoa(fromdt)+"&todt="+btoa(todt)+"&csrftoken="+csrf+"&QueryType=getePassPdf",
				success:function(data){
					var dataArr = data.split('##');
					$('#csrftoken').val(dataArr[1]);
					
					if(dataArr[0] == 'OK'){
						$('#downloadFile').attr('href', dataArr[2]);
						var element = document.getElementById('downloadFile');
						var eventObj = document.createEvent('MouseEvents');
						eventObj.initEvent('click',true,true);
						element.dispatchEvent(eventObj);
					}
					else if(dataArr[0] == 'CSRF'){
						$('#modelText').text('Authentication Failed !!.');
						$('#blank_field_modal').modal('show');
					}
					else if(dataArr[0] == 'NAN'){
						$('#modelText').text('Unauthorized access !!.');
						$('#blank_field_modal').modal('show');
					}
					else{
						$('#modelText').text('Somtheing went wrong !!.');
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
			$('#modelText').text('Please fill manadatory fields.');
			$('#blank_field_modal').modal('show');
			return false;
		}
	}
</script>
<?php include 'footer.php';?>
