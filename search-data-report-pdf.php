<?php
//error_reporting(0);
include "spoperation.php";

if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ""){
	header("Location:".$base_url.'my-logout.php');
}

/***************** CHECK SESSION *****************/
if($_SESSION['lawyer']['sessionid'] != session_id()){
	header("Location:".$base_url.'my-logout.php');
}
/***************** CHECK SESSION *****************/

date_default_timezone_set('Asia/Kolkata');
ini_set('date.timezone', 'Asia/Kolkata');

$files = glob('storefiles/*') ; // get all file names
foreach($files as $file){ // iterate files
	if(is_file($file))
	{
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		if(($ext == 'pdf' || $ext == 'PDF' || $ext == 'txt') && (time() - filectime($file) > 100))
		{
			unlink($file); // delete file
		}
	}
}

require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');

if($_POST['QueryType'] == 'getePassPdf')
{
	$fromdt 	= htmlentities(trim(base64_decode($_POST['fromdt'])));
	$todt 		= htmlentities(trim(base64_decode($_POST['todt'])));
	$searchby 	= htmlentities(trim(base64_decode($_POST['searchby'])));
	$postedcsrf = htmlentities(trim($_POST['csrftoken']));
	
	$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
	$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
	
	if($postedcsrf != $csrftoken){
		//echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
	}
		
	$fromdts	= implode('-', array_reverse(explode('/', $fromdt)));
	$todts	= implode('-', array_reverse(explode('/', $todt)));
	
	$call = new spoperation();
	$registerjp  = $call->GET_REGISTER_PASSESS_COUNT($fromdts, $todts, $searchby);
	$registerjdp = $call->GET_REGISTER_PASSESS_COUNT_JDP($fromdts, $todts, $searchby);
	//echo $fromdt.' -- '.$todt.' -- '.$searchby;
	//print_r($registerjp); die;
	
	$dataArrJP = array();
	$dataArrJDP = array();
	
	foreach($registerjp AS $row){
		$dataArrJP[] = $row;
	}
	
	foreach($registerjdp AS $row){
		$dataArrJDP[] = $row;
	}
	
	class MYPDF extends TCPDF 
	{
		public $fromdt;
		public $todt;
		public $searchby;
		public function setData($fromdt, $todt, $searchby)
		{
			$this->fromdt 	= $fromdt;
			$this->todt 	= $todt;
			$this->searchby = $searchby;
		}
		//Page header
		public function Header() 
		{
			$fitbox=false;
			$this->Rect(6, 5, 200, 277, 'DF', '', array(255, 255, 255));
			
			//$this->SetLineWidth(0.2);
			$this->Line(6, 28, 206, 28, '');
			//$this->Line(170, 3, 170, 25, $style);
			$this->Line(35, 5, 35, 28, '');
			$this->SetFont('times', 'B', 22);
			$this->Text(65, 8, 'RAJASTHAN HIGH COURT');
			$this->SetFont('times', 'B', 14);
			$this->Text(72, 18, 'Pass Generation & Registration Report');
			$this->SetFont('times', 'B', 12,'C');
			$this->Cell(180, 0, '', 0, 1);
			
			$this->Cell(180, 0, '', 0, 1);
			//$this->write1DBarcode(2010192, 'I25', 170, 9, 35, 16, 0.4, $style1, 'N');
			$this->Image('images/Emblem_of_India.png', 11, 8, 18, 18, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
			$this->Text(20, 25, '');
		}
	}		
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(210, 297), true, 'UTF-8', false);
	//echo $dataArr[0]['cl_dt']; die;
	$pdf->setData($fromdt, $todt, $searchby);
	
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Rajasthan High Court');
	$pdf->SetTitle('ePass Details');
	$pdf->SetSubject('ePass Details');
	$pdf->SetKeywords('ePass Details');

	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	// remove default header/footer
	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);	
	$pdf->SetHeaderMargin(15);
	$pdf->SetFooterMargin(15);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
		require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
	
	$sradvjp=0; $sradvjdp=0; $advjp=0; $advjdp=0; $pipjp=0; $pipjdp=0; $litjp=0; $litjdp =0; $totalsradvpass =0; $totalsradvreg =0;
	$totaladvpass =0; $totaladvreg =0; $totalpippass =0; $totalpipreg =0; $totallitpass =0; $totallitreg =0; $totaljppass =0;
	$totaljdppass =0; $totalpass = 0; $totalreg = 0;
	
	if(!empty($dataArrJP)){
		foreach($dataArrJP as $row){
			if(trim($row['remark']) == 'total' && trim($row['report']) == '0' && trim($row['passtype']) == '0'){
				$totalreg = $row['count'];
			}
			else if(trim($row['remark']) == 'total' && trim($row['report']) == '1' && trim($row['passtype']) == '0'){
				$totaljppass = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '0' && $row['passtype'] == '1'){
				$totalsradvreg = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '0' && $row['passtype'] == '2' && $row['passfor'] == 'S'){
				$totaladvreg = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '0' && $row['passtype'] == '3'){
				$totalpipreg = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '1'){
				$sradvjp = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '2' && $row['passfor'] == 'S'){
				$advjp = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '2' && $row['passfor'] == 'L'){
				$litjp = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '3'){
				$pipjp = $row['count'];
			}
		}
	}
	
	if(!empty($dataArrJDP)){
		foreach($dataArrJDP as $row){
			if(trim($row['remark']) == 'total' && trim($row['report']) == '1' && trim($row['passtype']) == '0'){
				$totaljdppass = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '1'){
				$sradvjdp = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '2' && $row['passfor'] == 'S'){
				$advjdp = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '2' && $row['passfor'] == 'L'){
				$litjdp = $row['count'];
			}
			else if(trim($row['remark']) == 'type' && trim($row['report']) == '1' && $row['passtype'] == '3'){
				$pipjdp = $row['count'];
			}
		}
	}
	$totalpass 		= $totaljppass + $totaljdppass;
	$totalsradvpass = $sradvjp + $sradvjdp;
	$totaladvpass 	= $advjp + $advjdp;
	$totalpippass 	= $pipjp + $pipjdp;
	$totallitpass 	= $litjp + $litjdp;

	// set font
	$pdf->SetFont('times', '', 11);

	// add a page
	$pdf->SetMargins(9,33,9);
	$pdf->AddPage();
	
	$thhead = '';
	$tdtext1 = '';
	$tdtext2 = '';
	$tdtext3 = '';
	$tdtext4 = '';
	$tdtext5 = '';
	
	if($searchby == '1'){
		$title = 'Pass Generation Date: '.$fromdt.' to '.$todt;
		$thhead = '<th rowspan="2" style="text-align:center; font-weight:bold;">Total Registrations</th>';
		$tdtext1 = '<td style="text-align:center;">'.$totalsradvreg.'</td>';
		$tdtext2 = '<td style="text-align:center;">'.$totaladvreg.'</td>';
		$tdtext3 = '<td style="text-align:center;">'.$totalpipreg.'</td>';
		$tdtext4 = '<td style="text-align:center;">'.$totallitreg.'</td>';
		$tdtext5 = '<td style="text-align:center;">'.$totalreg.'</td>';
	}
	else if($searchby == '2'){
		$title = 'Cause List Date (Pass Generated For): '.$fromdt.' to '.$todt;
	}
	else{
		$title = 'Report';
	}
	$pdf->SetFont('times', 'B', 12,'C');
	
	$html ='<html>
			<h4 style="text-align:center;">'.$title.'</h4>
			<table align="left" border="1" cellpadding="3" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th rowspan="2" style="text-align:center;">-</th>
						<th colspan="3" style="text-align:center; font-weight:bold;">Passes Issued</th>
						'.$thhead.'
					</tr>
					<tr>
						<th style="text-align:center; font-weight:bold;">Jaipur</th>
						<th style="text-align:center; font-weight:bold;">Jodhpur</th>
						<th style="text-align:center; font-weight:bold;">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th style="text-align:left; font-weight:bold;">Sr. Advocate</th>
						<td style="text-align:center;">'.$sradvjp.'</td>
						<td style="text-align:center;">'.$sradvjdp.'</td>
						<td style="text-align:center;">'.$totalsradvpass.'</td>
						'.$tdtext1.'
					</tr>
					<tr>
						<th style="text-align:left; font-weight:bold;">Advocate</th>
						<td style="text-align:center;">'.$advjp.'</td>
						<td style="text-align:center;">'.$advjdp.'</td>
						<td style="text-align:center;">'.$totaladvpass.'</td>
						'.$tdtext2.'
					</tr>
					<tr>
						<th style="text-align:left; font-weight:bold;">Party in Person</th>
						<td style="text-align:center;">'.$pipjp.'</td>
						<td style="text-align:center;">'.$pipjdp.'</td>
						<td style="text-align:center;">'.$totalpippass.'</td>
						'.$tdtext3.'
					</tr>
					<tr>
						<th style="text-align:left; font-weight:bold;">Litigant</th>
						<td style="text-align:center;">'.$litjp.'</td>
						<td style="text-align:center;">'.$litjdp.'</td>
						<td style="text-align:center;">'.$totallitpass.'</td>
						'.$tdtext4.'
					</tr>
					<tr>
						<th style="text-align:left; font-weight:bold;">Total</th>
						<td style="text-align:center;">'.$totaljppass.'</td>
						<td style="text-align:center;">'.$totaljdppass.'</td>
						<td style="text-align:center;">'.$totalpass.'</td>
						'.$tdtext5.'
					</tr>
				</tbody></table>';
	
	$html .="</html>";
	//echo $html; die();

	$pdf->writeHTML($html, true, false, true, false, '');
	$filename = 'Report_Details_'.rand(100001, 999999).'.pdf';
	$output = $pdf->Output(__DIR__ . '/storefiles/'.$filename, 'F');
	if(file_exists(__DIR__ . '/storefiles/'.$filename))
	{
		$filepath = '../storefiles/'.$filename;
		echo "OK##".$_SESSION['lawyer']['CSRF_Token']."##".$filepath; exit();
	}
	else
	{
		echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
	}
}
else
{
	echo "NAN##".$_SESSION['lawyer']['CSRF_Token']; exit();
}
?>