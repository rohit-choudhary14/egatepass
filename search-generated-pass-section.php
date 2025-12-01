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

	$mobile = $_SESSION['lawyer']['mobile'];
	$csrftoken= md5(uniqid());
	$_SESSION['lawyer']['CSRF_Token'] = $csrftoken;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Previouly Generated Section Pass | RHC</title>		 	
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

<body onunload="" oncontextmenu="return false" ondragstart="return false" onkeypress="return disableCtrlKeyCombination(event);" onkeydown="return disableCtrlKeyCombination(event);">
<?php include 'header.php'; ?>

<div class="container text-center" id="main_div_min_height" style="min-height:430px;">
	<noscript>
		<h4 style="color: red;">Please enable JavaScript in your browser to use this application.</h4>
	</noscript>
	<span id="errMsg"></span>
	<form class="form-horizontal" id="searchForm" name="searchForm" style="">
		<div class="form-group" style="margin-top:20px;">
			<div class="row" style="margin-bottom:15px; font-size:17px; color:#372451;">
				<label class="col-sm-12 text-center">Previously Generated Pass for Section Visit</label>
			</div>
			<div class="row">
				<label class="control-label col-sm-2">Pass Generation From:</label>
				<div class="col-sm-4">
					<input type="text" autocomplete="off" class="form-control datepickercalender" id="from_dt" placeholder="dd/mm/yyyy" maxlength="10" value="<?php echo '01'.date('/m/Y'); ?>" onkeypress="return checkdatecharacter(event);" readonly />
				</div>
				<label class="control-label col-sm-2">Pass Generation To:</label>
				<div class="col-sm-4">
					<input type="text" autocomplete="off" class="form-control datepickercalender" id="to_dt" placeholder="dd/mm/yyyy" maxlength="10" value="<?php echo date('d/m/Y'); ?>" onkeypress="return checkdatecharacter(event);" readonly />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<center>
						<input type="hidden" id="csrftoken" name="csrftoken" value="<?php echo $_SESSION['lawyer']['CSRF_Token'];?>"/>
						<button title="Search Details" type="button" class="btn btn-primary" id="searchBtn" 
						style="margin-top:20px;" onclick="return searchsectionpass();"><i class="fa fa-search"></i> &nbsp;Search</button>
					</center>
				</div>
			</div>
		</div>
		<div class="loading" id="loading" style="display:none;"><img src="images/loader.svg"></div>
	</form> 

	<div class="container" id="searchEntriesTable" style="padding:5px; display:none;">
		<div class="clearfix"></div>
		<div class="row">
			<p class="showNumberOfRecords" style="text-align:center;display:none;">
			</p>
			  <table class="table table-striped table-bordered table-responsive" id="tbl_caselist">
				<thead>
					<tr>
						<th style="width:5%; text-align:center !important;">S.No.</th>
						<th style="width:10%; text-align:center !important;">
							Pass Number
							<input type='text' placeholder='Search' autocomplete="false" data-column='3' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Date of Visit
							<input type='text' placeholder='Search' autocomplete="false" data-column='5' class='form-control'/>
						</th>
						<th style="width:25%; text-align:center !important;">
							Purpose of Visit
							<input type='text' placeholder='Search' autocomplete="false" data-column='6' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Date of Pass Generation
							<input type='text' placeholder='Search' autocomplete="false" data-column='7' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Pass for
							<input type='text' placeholder='Search' autocomplete="false" data-column='8' class='form-control'/>
						</th>
						<th style="width:10%; text-align:center !important;">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<a href="" download class="downloadFile" id="downloadFile" tabindex="-1" target="_blank"></a>

<div id="no_record_found_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">		
		<div class="modal-content modal-content col-md-6 col-md-offset-3">
			<form class="form-horizontal">
				<div class="modal-header">
					<a href="search-generated-pass-section.php" class="close" data-dismiss="modal">&times;</a>
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
					<a href="search-generated-pass-section.php" class="close" data-dismiss="modal">&times;</a>
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
					<a href="search-generated-pass-section.php" class="close" data-dismiss="modal">&times;</a>
				</div>
				<div class="modal-body">
					<label class="col-md-12"></label>					 
					<div class="alert alert-success" id='successModelText'></div>	
					<div class="form-group">
						<div class="col-sm-12 col-md-12 col-xs-12">
							<button type="button" class="btn btn-success btnDownloadePass" style="float:left" onclick="downloadePass(this.id)">Download Pass</button>
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

<script type="text/javascript">
	function printDiv(){
	  var divToPrint=document.getElementById('showModelText');
	  var newWin=window.open('','Print-Window');
	  newWin.document.open();
	  newWin.document.write('<html><body onload="window.print()" style="text-align:center;">'+divToPrint.innerHTML+'</body></html>');
	  newWin.document.close();
	  setTimeout(function(){newWin.close();},10);
	}
	
	function showPassDetails(id){
		var cldt = $('#'+id).attr('data-dt');
		var name = $('#'+id).attr('data-name');
		var dataid = $('#'+id).attr('data-id');
		$('.btnDownloadePass').attr('id', dataid);
		
		$('#showModelText').html("<b>Rajasthan High Court</b><br/><br/><p style='text-align:justify !important;'></p><br/> <p style='text-align:justify !important;'>This entry Pass Issued for <b>"+name+"</b> and valid for <b>"+cldt+"</b> only.</p>");
		$('#showPassDetails').modal('show');
	}

	$(document).ready(function(){
		$(".datepickercalender").datepicker({
			format: 'dd/mm/yyyy',
			startDate: '01/01/2019',
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

	function searchsectionpass(){

		$("#searchEntriesTable").hide();
		var csrf 	= $.trim($('#csrftoken').val());
		var fromdt 	= $.trim($('#from_dt').val());
		var todt 	= $.trim($('#to_dt').val());
		//var passval = $.trim($('#passval').val());
		if((fromdt != '' || todt != '') && isPastDate(todt, fromdt)){
			$('#loading').show();
			$.ajax({
				type:"POST",
				cache:false,
				url:"ajax-responce.php",
				data:'fromdt='+btoa(fromdt)+'&todt='+btoa(todt)+'&passval='+btoa('S')+'&csrftoken='+csrf+'&QueryType=srchGeneratedPass',
				dataType:"JSON",
				success: function (data) {
					$('#csrftoken').val(data[0]['csrftoken']);
					
					if(data[0]['status'] == "NO"){
						$('#modelText').html("No Record Found");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "IVI"){
						$('#modelText').html("Invalid Input Field Value");
						$('#blank_field_modal').modal('show');
					}
					else if(data[0]['status'] == "INDEX"){
						window.location.href = 'my-logout.php';
					}
					else if(data.length == 1){
						$('#no_record_found_modal').modal('show');
					}
					else if(data[0]['status'] == 'OK' && data.length > 1){
						var trhtml = ''; var total=0; var btnShow=''; var passname=''; var mobile=''; var passfor='';
						var today = "<?php echo date('d/m/Y'); ?>";
						for(var i=1; i<data.length; i++){
							total++;
							if(isPastDate(data[i]['pass_dt'], today)){
								btnShow='';
							}
							else{
								//btnShow='display:none"';
							}
							
							if($.trim(data[i]['passfor']) == 'LS'){
								passname = $.trim(data[i]['litigantname']);
								mobile	 = $.trim(data[i]['party_mob_no']);
								passfor  = 'Litigant';
								console.log(data)
							}
							else{
								passname = "<?php echo $_SESSION['lawyer']['user_name']; ?>";
								mobile   = "<?php echo $mobile; ?>";
								passfor  = 'Self';
							}
							// passname = "<?php echo $_SESSION['lawyer']['user_name']; ?>";
							// mobile   = "<?php echo $mobile; ?>";
							// passfor  = 'Self';
							
							trhtml += '<tr><td style="width:5%; text-align:center !important;">'+total+'</td><td style="width:10%;">'+data[i]['pass_no']+'</td><td style="width:10%;">'+data[i]['pass_dt']+'</td><td style="width:25%;">'+data[i]['purposermks']+'</td><td style="width:10%;">'+data[i]['entry_dt']+'</td><td style="width:10%;">'+passfor+'</td><td style="width:10%;"><button type="button" onclick="sendPassAgain(this.id)" data-mob="'+mobile+'" data-id="'+data[i]['id']+'" id="btnSend_'+data[i]['id']+'" style="padding:6px 10px !important; '+btnShow+'" class="btn btn-info" data-toggle="tooltip" data-original-title="Resend ePass details"><i class="fa fa-send"></i></button><button type="button" class="btn btn-primary" onclick="showPassDetails(this.id)" data-id="'+data[i]['id']+'" data-dt="'+data[i]['pass_dt']+'" data-name="'+passname+'" id="showbtn_'+data[i]['id']+'" style="padding:6px 10px !important; margin-left:5px;" data-toggle="tooltip" data-original-title="View ePass details"><i class="fa fa-eye"></i></button></td></tr>';
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
						//$('.dataTables_filter').html('<button class="btn btn-danger" style="float:right; margin-top:-7px;" onclick="getPdfReport()"><i class="fa fa-file-pdf-o"></i> Mapped Case in PDF </button>');
						$('.showNumberOfRecords').text("Total Number Of Records : "+total).css({'font-weight':'bold'}).show();
						$("#searchEntriesTable").show();

						$('[data-toggle="tooltip"]').tooltip();
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
			$('#modelText').text('Please check from date should by less than to date.');
			$('#blank_field_modal').modal('show');
			return false;
		}
		else if($.trim($('#adv_enroll').val()).length < 6){
			$('#modelText').text('Please enter minimum 6 character in Enrollment Number.');
			$('#blank_field_modal').modal('show');
			return false;			
		}
		else{
			$('#modelText').text('Please fill manadatory');
			$('#blank_field_modal').modal('show');
			return false;
		}
	}

	function sendPassAgain(btnid){
		var passid = $('#'+btnid).attr('data-id');
		var mobile = $('#'+btnid).attr('data-mob');
		$('.btnDownloadePass').attr('id', passid);
		
		var mobf = mobile.substring(0, 2);
		var mobl = mobile.substring(8);
		mobile = mobf+'******'+mobl;
		
		if(passid != '' && passid != '0'){
			swal({
				title: "Are you sure?",
				text: "Do you want to resend pass details.",
				showCancelButton: true,
				cancelButtonColor: '#39b78e',
				confirmButtonColor: '#ff000c',
				confirmButtonText: 'Yes, Send',
				closeOnConfirm: true
			},
			function(){
				$('#loading').show();
				$.ajax({
					type:"POST",
					cache:false,
					url:"ajax-responce.php",
					data:'passid='+btoa(passid)+'&passval='+btoa('S')+'&csrftoken='+$('#csrftoken').val()+'&QueryType=sendPass',
					dataType:"JSON",
					success: function (data) {
						var dataArr = data.split('##');
						$('#csrftoken').val(dataArr[1]);
						
						if(dataArr[0] == "OK"){
							$('#successModelText').html("Pass resend on your mobile number "+mobile+".");
							$('#success_field_modal').modal('show');
						}
						else if(dataArr[0] == "IVI"){
							$('#modelText').html("Invalid Pass Id.");
							$('#blank_field_modal').modal('show');
						}
						else if(dataArr[0] == "NEXISTS"){
							$('#modelText').html("Pass details not exists.");
							$('#blank_field_modal').modal('show');
						}
						else if(dataArr[0] == "CSRF"){
							$('#modelText').html("Authentication Failed.");
							$('#blank_field_modal').modal('show');
						}
						else{
							$('#modelText').html("Technical issues are occured. Please try after some time.");
							$('#blank_field_modal').modal('show');
						}
						$('#loading').hide();
					}
				});
			});
		}
		else{
			$('#modelText').html("Something went wrong !!.");
			$('#blank_field_modal').modal('show');
		}
	}

	function downloadePass(passid){
		if(passid != '' && passid != null){
			$('#loading').show();
			ajaxRequest = $.ajax ({
				type: 'post',
				evalScripts: true,
				url:"get-ePass-in-pdf.php",
				data:"passid="+btoa(passid)+'&download='+btoa('S')+"&csrftoken="+$('#csrftoken').val()+"&QueryType=getePassPdf",
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
	}
</script>
<?php include 'footer.php';?>
