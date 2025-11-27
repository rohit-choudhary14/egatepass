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
	<div class="loading" id="loading" style="display:none;"><img src="../images/loader.svg"></div>
	<span id="errMsg"></span>
	<form class="form-horizontal" id="searchForm" name="searchForm" style="">
		<div class="form-group" style="margin-top:10px;">
			<div class="row"><h4>Pass Generation & Registration Report</h4></div>
			<div class="row text-center" style="margin-bottom:20px;">
				<label class="radio-inline">
					<input type="radio" name="searchby" class="searchby" value="1"> Pass Generation Date
				</label>
				<label class="radio-inline">
					<input type="radio" name="searchby" class="searchby" value="2"> Cause List Date (Pass Generated For)
				</label>
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
						style="margin-top:20px;" onclick="return searchreportcount();"><i class="fa fa-search"></i> Search</button>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <button title="Download Report" type="button" class="btn btn-danger" id="btnDownloadPDF" 
						style="margin-top:20px; display:none;" onclick="return downloadePDF();"><i class="fa fa-file-pdf-o"></i> Download PDF</button>
					</center>
				</div>
			</div>
		</div>
	</form> 
	
	<div class="container" id="searchRegTable" style="padding:5px; display:none;">
		<div class="clearfix"></div>
		<div class="row">
			<table class="table table-striped table-bordered table-responsive" id="tbl_regcntlist">
				<thead>
					<tr>
						<th rowspan="2" class="text-center">-</th>
						<th colspan="3" class="text-center">Passes Issued</th>
						<th rowspan="2" class="text-center th_registration">Total Registrations</th>
					</tr>
					<tr>
						<th class="text-center">Jaipur</th>
						<th class="text-center">Jodhpur</th>
						<th class="text-center">Total</th>
					</tr>
				</thead>
				<tbody> </tbody>
			</table>
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
	
	$('.searchby, .datepickercalender').on('change', function () {
		$('#searchRegTable').hide();
		$('#btnDownloadPDF').hide();
	});
	
	function isPastDate(startDate, endDate){
		// date is dd/mm/yyyy
		var fromDate = startDate.split("/");
		var toDate = endDate.split("/");
		fromDate = new Date(fromDate[2], fromDate[1] - 1, fromDate[0], 0, 0, 0, 0);
		toDate = new Date(toDate[2], toDate[1] - 1, toDate[0], 0, 0, 0, 0);
		return fromDate >= toDate;
	}
	
	function searchreportcount(){
		var searchby = $('.searchby:checked').val();
		var fromdt = $.trim($('#from_dt').val());
		var todt   = $.trim($('#to_dt').val());
		var csrf   = $.trim($('#csrftoken').val());
		$('#searchRegTable').hide();
		$('#btnDownloadPDF').hide();
		
		if((fromdt != '' || todt != '') && isPastDate(todt, fromdt) && $('.searchby').is(':checked') == true){
			$('#loading').show();
			$.ajax({
				type:"POST",
				cache:false,
				url:"../ajax-responce.php",
				data:'fromdt='+btoa(fromdt)+'&todt='+btoa(todt)+'&searchby='+btoa(searchby)+'&csrftoken='+csrf+'&QueryType=srchRegPassCnt',
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
						window.location.href = '../my-logout.php';
					}
					else if(data.length == 1){
						$('#no_record_found_modal').modal('show');
					}
					else if(data[0]['status'] == 'OK' && data.length > 1){
						var trreghtml = '';
						var sradvjp=0; var sradvjdp=0; var advjp=0; var advjdp=0; var pipjp=0; var pipjdp=0;
						var litjp=0; var litjdp =0; var totalsradvpass =0; var totalsradvreg =0;
						var totaladvpass =0; var totaladvreg =0; var totalpippass =0; var totalpipreg =0;
						var totallitpass =0; var totallitreg =0; var totaljppass =0; var totaljdppass =0;
						var passtype = ''; var totalpass = 0; var totalreg = 0;
						
						for(var i=1; i<data.length; i++){
							if($.trim(data[i]['remark']) == 'total' && $.trim(data[i]['report']) == '0' && $.trim(data[i]['passtype']) == '0' && $.trim(data[i]['estt']) == 'B'){
								totalreg = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'total' && $.trim(data[i]['report']) == '1' && $.trim(data[i]['passtype']) == '0' && $.trim(data[i]['estt']) == 'B'){
								totaljppass = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'total' && $.trim(data[i]['report']) == '1' && $.trim(data[i]['passtype']) == '0' && $.trim(data[i]['estt']) == 'P'){
								totaljdppass = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '0' && data[i]['passtype'] == '1' && data[i]['estt'] == 'B'){
								totalsradvreg = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '0' && data[i]['passtype'] == '2' && data[i]['estt'] == 'B' && data[i]['passfor'] == 'S'){
								totaladvreg = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '0' && data[i]['passtype'] == '3' && data[i]['estt'] == 'B'){
								totalpipreg = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '1' && data[i]['estt'] == 'B'){
								sradvjp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '2' && data[i]['estt'] == 'B' && data[i]['passfor'] == 'S'){
								advjp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '2' && data[i]['estt'] == 'B' && data[i]['passfor'] == 'L'){
								litjp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '3' && data[i]['estt'] == 'B'){
								pipjp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '1' && data[i]['estt'] == 'P'){
								sradvjdp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '2' && data[i]['estt'] == 'P' && data[i]['passfor'] == 'S'){
								advjdp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '2' && data[i]['estt'] == 'P' && data[i]['passfor'] == 'L'){
								litjdp = data[i]['count'];
							}
							else if($.trim(data[i]['remark']) == 'type' && $.trim(data[i]['report']) == '1' && data[i]['passtype'] == '3' && data[i]['estt'] == 'P'){
								pipjdp = data[i]['count'];
							}
						}
						totalpass = parseInt(parseInt(totaljppass)+parseInt(totaljdppass));
						totalsradvpass = parseInt(parseInt(sradvjp)+parseInt(sradvjdp));
						totaladvpass = parseInt(parseInt(advjp)+parseInt(advjdp));
						totalpippass = parseInt(parseInt(pipjp)+parseInt(pipjdp));
						totallitpass = parseInt(parseInt(litjp)+parseInt(litjdp));
						
						$('.th_registration').show();
						var display = '';
						if(searchby == '2'){
							display = 'display:none;';
							$('.th_registration').hide();
						}
						
						trreghtml = '<tr><th class="text-left">Sr. Advocate</th><td class="text-center">'+sradvjp+'</td><td class="text-center">'+sradvjdp+'</td><td class="text-center">'+totalsradvpass+'</td><td style="'+display+'" class="text-center">'+totalsradvreg+'</td></tr><tr><th class="text-left">Advocate</th><td class="text-center">'+advjp+'</td><td class="text-center">'+advjdp+'</td><td class="text-center">'+totaladvpass+'</td><td style="'+display+'" class="text-center">'+totaladvreg+'</td></tr><tr><th class="text-left">Party in Person</th><td class="text-center">'+pipjp+'</td><td class="text-center">'+pipjdp+'</td><td class="text-center">'+totalpippass+'</td><td style="'+display+'" class="text-center">'+totalpipreg+'</td></tr><tr><th class="text-left">Litigant</th><td class="text-center">'+litjp+'</td><td class="text-center">'+litjdp+'</td><td class="text-center">'+totallitpass+'</td><td style="'+display+'" class="text-center">'+totallitreg+'</td></tr><tr><th class="text-left">Total</th><td class="text-center">'+totaljppass+'</td><td class="text-center">'+totaljdppass+'</td><td class="text-center">'+totalpass+'</td><td style="'+display+'" class="text-center">'+totalreg+'</td></tr>'
						$('.totalpass').html('Total Number of Pass Generated: '+totalpass);
						$('#tbl_regcntlist tbody').html(trreghtml);
						$('#searchRegTable').show();
						$('#btnDownloadPDF').show();
					}
					else{
						$('#modelText').html("Technical issues are occured. Please try after some time.");
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
	
	function downloadePDF(){
		var searchby = $('.searchby:checked').val();
		var fromdt = $.trim($('#from_dt').val());
		var todt   = $.trim($('#to_dt').val());
		var csrf   = $.trim($('#csrftoken').val());
		
		if((fromdt != '' || todt != '') && isPastDate(todt, fromdt) && $('.searchby').is(':checked') == true){
			$('#loading').show();
			ajaxRequest = $.ajax ({
				type: 'post',
				evalScripts: true,
				url:"../search-data-report-pdf.php",
				data:"searchby="+btoa(searchby)+"&fromdt="+btoa(fromdt)+"&todt="+btoa(todt)+"&csrftoken="+csrf+"&QueryType=getePassPdf",
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
