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
	$srchby 	= htmlentities(trim(base64_decode($_POST['srchby'])));
	$postedcsrf = htmlentities(trim($_POST['csrftoken']));
	
	$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
	$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
	
	if($postedcsrf != $csrftoken){
		echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
	}
	
	$fromdts = implode('-', array_reverse(explode('/', $fromdt)));
	$todts	 = implode('-', array_reverse(explode('/', $todt)));
	
	$call = new spoperation();
	if($_SESSION['lawyer']['estt'] == 'P')
		$passdata = $call->GET_REGISTER_USERS_COUNT_JDP($fromdts, $todts, $srchby);
	else
		$passdata = $call->GET_REGISTER_USERS_COUNT($fromdts, $todts, $srchby);
	$dataArr  = array();
	
	if(!empty($passdata)){
		$i=0; $prvdt = '';
		foreach($passdata as $row){
			if($prvdt == '' || $prvdt == $row['regdate']){
				if($prvdt == ''){
					$dataArr[$i]['regdate']   = $row['regdate'];
					$dataArr[$i]['sradvpass'] = 0;
					$dataArr[$i]['advpass']   = 0;
					$dataArr[$i]['litpass']   = 0;
					$dataArr[$i]['pippass']   = 0;
					$dataArr[$i]['sradvreg']  = 0;
					$dataArr[$i]['advreg'] 	  = 0;
					$dataArr[$i]['pipreg'] 	  = 0;
					
					$dataArr[$i]['sradvsectionpass'] = 0;
					$dataArr[$i]['advsectionpass'] = 0;
					$dataArr[$i]['pipsectionpass'] = 0;
				}
				$prvdt = $row['regdate'];
				$dataArr[$i]['regdate']  = $row['regdate'];
				if($row['passtype'] == '1' && $row['report'] == '2' && $row['passfor'] == 'S'){
					$dataArr[$i]['sradvpass'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'S'){
					$dataArr[$i]['advpass'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'L'){
					$dataArr[$i]['litpass'] = $row['count'];
				}
				else if($row['passtype'] == '3' && $row['report'] == '2' && $row['passfor'] == 'S'){
					$dataArr[$i]['pippass'] = $row['count'];
				}
				else if($row['passtype'] == '1' && $row['report'] == '1'){
					$dataArr[$i]['sradvreg'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '1'){
					$dataArr[$i]['advreg'] = $row['count'];
				}
				else if($row['passtype'] == '3' && $row['report'] == '1'){
					$dataArr[$i]['pipreg'] = $row['count'];
				}
				
				else if($row['passtype'] == '1' && $row['report'] == '3' && $row['passfor'] == 'S'){
					$dataArr[$i]['sradvsectionpass'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '3' && $row['passfor'] == 'S'){
					$dataArr[$i]['advsectionpass'] = $row['count'];
				}
				else if($row['passtype'] == '3' && $row['report'] == '3' && $row['passfor'] == 'S'){
					$dataArr[$i]['pipsectionpass'] = $row['count'];
				}
			}
			else if($prvdt != $row['regdate']){
				$i++;
				$prvdt = $row['regdate'];
				$dataArr[$i]['regdate']   = $row['regdate'];
				$dataArr[$i]['sradvpass'] = 0;
				$dataArr[$i]['advpass']   = 0;
				$dataArr[$i]['litpass']   = 0;
				$dataArr[$i]['pippass']   = 0;
				$dataArr[$i]['sradvreg']  = 0;
				$dataArr[$i]['advreg'] 	  = 0;
				$dataArr[$i]['pipreg'] 	  = 0;
				
				$dataArr[$i]['sradvsectionpass'] = 0;
				$dataArr[$i]['advsectionpass'] = 0;
				$dataArr[$i]['pipsectionpass'] = 0;
				
				if($row['passtype'] == '1' && $row['report'] == '2' && $row['passfor'] == 'S'){
					$dataArr[$i]['sradvpass'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'S'){
					$dataArr[$i]['advpass'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'L'){
					$dataArr[$i]['litpass'] = $row['count'];
				}
				else if($row['passtype'] == '3' && $row['report'] == '2' && $row['passfor'] == 'S'){
					$dataArr[$i]['pippass'] = $row['count'];
				}
				else if($row['passtype'] == '1' && $row['report'] == '1'){
					$dataArr[$i]['sradvreg'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '1'){
					$dataArr[$i]['advreg'] = $row['count'];
				}
				else if($row['passtype'] == '3' && $row['report'] == '1'){
					$dataArr[$i]['pipreg'] = $row['count'];
				}
				
				else if($row['passtype'] == '1' && $row['report'] == '3' && $row['passfor'] == 'S'){
					$dataArr[$i]['sradvsectionpass'] = $row['count'];
				}
				else if($row['passtype'] == '2' && $row['report'] == '3' && $row['passfor'] == 'S'){
					$dataArr[$i]['advsectionpass'] = $row['count'];
				}
				else if($row['passtype'] == '3' && $row['report'] == '3' && $row['passfor'] == 'S'){
					$dataArr[$i]['pipsectionpass'] = $row['count'];
				}
			}
		}
	}
	
	class MYPDF extends TCPDF 
	{
		public $searchby;
		public function setData($searchby){
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
			$this->SetFont('times', 'B', 14);
			
			if($this->searchby == '99' && $_SESSION['lawyer']['estt'] == 'B'){
				$this->Text(65, 8, 'RAJASTHAN HIGH COURT BENCH JAIPUR');
				$this->SetFont('times', 'B', 12);
				$this->Text(72, 18, 'Date Wise Pass Generation & Registration Report');
			}
			else if(($this->searchby == '2' || $this->searchby == '1') && $_SESSION['lawyer']['estt'] == 'B'){
				$this->Text(65, 8, 'RAJASTHAN HIGH COURT BENCH JAIPUR');
				$this->SetFont('times', 'B', 12);
				$this->Text(85, 18, 'Date Wise Pass Generation Report');
			}
			else if($this->searchby == '99' && $_SESSION['lawyer']['estt'] == 'P'){
				$this->Text(68, 8, 'RAJASTHAN HIGH COURT JODHPUR');
				$this->SetFont('times', 'B', 12);
				$this->Text(65, 18, 'Date Wise Pass Generation & Registration Report');
			}
			else if(($this->searchby == '2' || $this->searchby == '1') && $_SESSION['lawyer']['estt'] == 'P'){
				$this->Text(68, 8, 'RAJASTHAN HIGH COURT JODHPUR');
				$this->SetFont('times', 'B', 12);
				$this->Text(82, 18, 'Date Wise Pass Generation Report');
			}
			
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
	$pdf->setData($srchby);
	
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
	// set font
	$pdf->SetFont('times', '', 11);

	// add a page
	$pdf->SetMargins(9,33,9);
	$pdf->AddPage();
	
	if($srchby == '1'){
		$title = 'Pass Generation Date : '.$fromdt.' to '.$todt;
	}
	else if($srchby == '2'){
		$title = 'Cause List Date (Date of Visit) : '.$fromdt.' to '.$todt;
	}
	else{
		$title = 'Report';
	}
	$pdf->SetFont('times', '', 9, 'C');
	
	$html ='<html><h4 style="text-align:center;">'.$title.'</h4>
			<table align="left" border="1" cellpadding="3" cellspacing="0" width="100%">';
	if(!empty($dataArr)){
		$i=1; $totalsradvps = 0; $totaladvps = 0; $totallitps = 0; $totalpipps = 0;
		$totalsradvreg = 0; $totaladvreg = 0; $totallitreg = 0; $totalpipreg = 0;
		$totalsradvsectionpass = 0; $totaladvsectionpass = 0; $totalpipsectionpass = 0;
		if($srchby == '99'){
			$html .='<thead>
					<tr>
						<th rowspan="2" style="vertical-align:middle; font-weight:bold; text-align:center;">S.No.</th>
						<th rowspan="2" style="vertical-align:middle; font-weight:bold; text-align:center;">
							Date
						</th>
						<th colspan="4" style="text-align:center; font-weight:bold;">
							Pass Issued
						</th>
						<th rowspan="2" style="vertical-align:middle; font-weight:bold; text-align:center;">
							Total Passess
						</th>
						<th colspan="3" style="text-align:center; font-weight:bold;">
							Registrations
						</th>
						<th rowspan="2" style="vertical-align:middle; font-weight:bold; text-align:center;">
							Total<br/>Registrations
						</th>
					</tr>
					<tr>
						<th style="text-align:center; font-weight:bold;">
							Sr. Advocate
						</th>
						<th style="text-align:center; font-weight:bold;">
							Advocate
						</th>
						<th style="text-align:center; font-weight:bold;">
							Litigant
						</th>
						<th style="text-align:center; font-weight:bold;">
							Party in Person
						</th>
						<th style="text-align:center; font-weight:bold;">
							Sr. Advocate
						</th>
						<th style="text-align:center; font-weight:bold;">
							Advocate
						</th>
						<th style="text-align:center; font-weight:bold;">
							Party in Person
						</th>
					</tr>
				</thead><tbody>';
			foreach($dataArr as $row){
				$html .='<tr>
							<td style="text-align:center;">'.$i.'</td>
							<td style="text-align:center;">'.implode('/', array_reverse(explode('-', $row['regdate']))).'</td>
							<td style="text-align:center;">'.$row['sradvpass'].'</td>
							<td style="text-align:center;">'.$row['advpass'].'</td>
							<td style="text-align:center;">'.$row['litpass'].'</td>
							<td style="text-align:center;">'.$row['pippass'].'</td>
							<td style="text-align:center; font-weight:bold;">'.($row['sradvpass']+$row['advpass']+$row['litpass']+$row['pippass']).'</td>
							<td style="text-align:center;">'.$row['sradvreg'].'</td>
							<td style="text-align:center;">'.$row['advreg'].'</td>
							<td style="text-align:center;">'.$row['pipreg'].'</td>
							<td style="text-align:center; font-weight:bold;">'.($row['sradvreg']+$row['advreg']+$row['pipreg']).'</td>
						</tr>';
				$totalsradvps = $totalsradvps+$row['sradvpass'];
				$totaladvps	  = $totaladvps+$row['advpass'];
				$totallitps   = $totallitps+$row['litpass'];
				$totalpipps   = $totalpipps+$row['pippass'];
				$totalsradvreg = $totalsradvreg+$row['sradvreg'];
				$totaladvreg  = $totaladvreg+$row['advreg'];
				$totalpipreg  = $totalpipreg+$row['pipreg'];
				$i++;
			}
			$html .='<tr>
						<td colspan="2" style="text-align:center; font-weight:bold;">TOTAL</td>
						<td style="text-align:center; font-weight:bold;">'.$totalsradvps.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totaladvps.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totallitps.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totalpipps.'</td>
						<td style="text-align:center; font-weight:bold;">'.($totalsradvps+$totaladvps+$totallitps+$totalpipps).'</td>
						<td style="text-align:center; font-weight:bold;">'.$totalsradvreg.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totaladvreg.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totalpipreg.'</td>
						<td style="text-align:center; font-weight:bold;">'.($totalsradvreg+$totaladvreg+$totalpipreg).'</td>
					</tr>';
		}
		else if($srchby == '2' || $srchby == '1'){
			$html .='<thead>
					<tr>
						<th rowspan="2" style="vertical-align:middle; text-align:center; font-weight: bold;">S.No.</th>
						<th rowspan="2" style="vertical-align:middle; text-align:center; font-weight: bold; width: 9%;">
							Date
						</th>
						<th colspan="5" style="text-align:center; font-weight: bold;">
							Pass Issued for Case Hearing
						</th>
						<th colspan="4" style="text-align:center; font-weight: bold;">
							Pass Issued for Section Visit
						</th>
						<th rowspan="2" style="vertical-align:middle; text-align:center; font-weight: bold;">
							Total Pass Issued
						</th>
					</tr>
					<tr>
						<th style="text-align:center; font-weight: bold;">
							Sr. Advocate
						</th>
						<th style="text-align:center; font-weight: bold;">
							Advocate
						</th>
						<th style="text-align:center; font-weight: bold;">
							Litigant
						</th>
						<th style="text-align:center; font-weight: bold;">
							Party in Person
						</th>
						<th style="text-align:center; font-weight: bold;">
							Total
						</th>
						<th style="text-align:center; font-weight: bold;">
							Sr. Advocate
						</th>
						<th style="text-align:center; font-weight: bold;">
							Advocate
						</th>
						<th style="text-align:center; font-weight: bold;">
							Party in Person
						</th>
						<th style="text-align:center; font-weight: bold;">
							Total
						</th>
					</tr>
				</thead><tbody>';
			foreach($dataArr as $row){
				$html .='<tr>
							<td style="text-align:center;">'.$i.'</td>
							<td style="text-align:center; width: 9%;">'.implode('/', array_reverse(explode('-', $row['regdate']))).'</td>
							<td style="text-align:center;">'.$row['sradvpass'].'</td>
							<td style="text-align:center;">'.$row['advpass'].'</td>
							<td style="text-align:center;">'.$row['litpass'].'</td>
							<td style="text-align:center;">'.$row['pippass'].'</td>
							<td style="text-align:center; font-weight:bold;">'.($row['sradvpass']+$row['advpass']+$row['litpass']+$row['pippass']).'</td>
							<td style="text-align:center;">'.$row['sradvsectionpass'].'</td>
							<td style="text-align:center;">'.$row['advsectionpass'].'</td>
							<td style="text-align:center;">'.$row['pipsectionpass'].'</td>
							<td style="text-align:center; font-weight:bold;">'.($row['sradvsectionpass']+$row['advsectionpass']+$row['pipsectionpass']).'</td>
							<td style="text-align:center; font-weight:bold;">'.($row['sradvpass']+$row['advpass']+$row['litpass']+$row['pippass']+$row['sradvsectionpass']+$row['advsectionpass']+$row['pipsectionpass']).'</td>
						</tr>';
				
				$totalsradvps = $totalsradvps+$row['sradvpass'];
				$totaladvps	  = $totaladvps+$row['advpass'];
				$totallitps   = $totallitps+$row['litpass'];
				$totalpipps   = $totalpipps+$row['pippass'];
				
				$totalsradvsectionpass = $totalsradvsectionpass+$row['sradvsectionpass'];
				$totaladvsectionpass = $totaladvsectionpass+$row['advsectionpass'];
				$totalpipsectionpass = $totalpipsectionpass+$row['pipsectionpass'];
				
				$i++;
			}
			$html .='<tr>
						<td colspan="2" style="text-align:center; font-weight:bold;">TOTAL</td>
						<td style="text-align:center; font-weight:bold;">'.$totalsradvps.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totaladvps.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totallitps.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totalpipps.'</td>
						<td style="text-align:center; font-weight:bold;">'.($totalsradvps+$totaladvps+$totallitps+$totalpipps).'</td>
						<td style="text-align:center; font-weight:bold;">'.$totalsradvsectionpass.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totaladvsectionpass.'</td>
						<td style="text-align:center; font-weight:bold;">'.$totalpipsectionpass.'</td>
						<td style="text-align:center; font-weight:bold;">'.($totalsradvsectionpass+$totaladvsectionpass+$totalpipsectionpass).'</td>
						<td style="text-align:center; font-weight:bold;">'.($totalsradvps+$totaladvps+$totallitps+$totalpipps+$totalsradvsectionpass+$totaladvsectionpass+$totalpipsectionpass).'</td>
					</tr>';
		}
	}
	
	$html .="</tbody></table></html>";
	
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