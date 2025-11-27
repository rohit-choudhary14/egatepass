<?php
//error_reporting(0);
include_once "spoperation.php";

if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == "") {
	header("Location:".$base_url.'my-logout.php');
}

/***************** CHECK SESSION *****************/
if($_SESSION['lawyer']['sessionid'] != session_id()) {
	header("Location:".$base_url.'my-logout.php');
}
/***************** CHECK SESSION *****************/

date_default_timezone_set('Asia/Kolkata');
ini_set('date.timezone', 'Asia/Kolkata');

$files = glob('storefiles/*.pdf') ; // get all file names
foreach($files as $file){ // iterate files
	if(is_file($file))
	{
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		//if(($ext == 'pdf' || $ext == 'PDF' || $ext == 'txt') && (time() - filectime($file) > 100))
		if($ext == 'pdf' && (time() - filectime($file) > 100))
		{
			unlink($file); // delete file
		}
	}
}

require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');

if($_POST['QueryType'] == 'getCovidPassPdf')
{
	$passid = htmlentities(trim(base64_decode($_POST['passid'])));
	$uploadfor = htmlentities(trim(base64_decode($_POST['uploadfor'])));
	$postedcsrf = htmlentities(trim($_POST['csrftoken']));
	
	$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
	$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
	
	if($postedcsrf != $csrftoken) {
		echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
	}
	
	$call = new spoperation();
	$getPassData = $call->SP_GET_COVID_VACCINATION_DETAILS_FOR_PDF($passid, $uploadfor);
	
	$dataArr = array();
	foreach($getPassData AS $row)
	{
		$dataArr = $row;
	}
	
	if(empty($dataArr)) {
		echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
	}
	
	class MYPDF extends TCPDF 
	{
		/*public $cldt;
		public function setData($cldt)
		{
			$this->cldt = $cldt;
		}*/
		
		//Page header
		public function Header() 
		{
			$fitbox=false;
			$this->Rect(6, 5, 200, 277, 'DF', '', array(255, 255, 255));  //x,y,w,h
			
			//$this->SetLineWidth(0.2);
			$this->Line(6, 30, 206, 30, '');  //horizontal line after logo   x1,y1,x2,y2
			//$this->Line(170, 3, 170, 25, $style);
			$this->Line(35, 5, 35, 30, '');   //vertical line after logo
			//$this->Line(175, 5, 175, 30, '');   //vertical line after logo
			$this->SetFont('times', 'B', 14);
			if($_SESSION['lawyer']['connection'] == 'B'){
				$this->Text(68, 8, 'RAJASTHAN HIGH COURT BENCH JAIPUR');
			}
			else if($_SESSION['lawyer']['connection'] == 'P'){
				$this->Text(68, 8, 'RAJASTHAN HIGH COURT JODHPUR');
			}
			$this->SetFont('times', 'B', 12);
			$this->Text(100, 15, 'Authorization Card');
			$this->SetFont('times', 'B', 12,'C');
			$this->Cell(180, 0, '', 0, 1); 
			//$this->Text(85, 21, '(Pass vaild for: '.$this->cldt.' only)');
			$this->SetFont('times', 'B', 12,'C');
			$this->Cell(180, 0, '', 0, 1);
			//$this->write1DBarcode(2010192, 'I25', 170, 9, 35, 16, 0.4, $style1, 'N');
			$this->Image('images/Emblem_of_India.png', 11, 8, 18, 18, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
			$this->Text(20, 25, '');
		}
	}		
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(210, 297), true, 'UTF-8', false);
	//echo $dataArr['cl_dt']; die;
	//$pdf->setData($dataArr['cl_dt']);
	
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Rajasthan High Court');
	//$pdf->SetTitle('ePass Details');
	//$pdf->SetSubject('ePass Details');
	//$pdf->SetKeywords('ePass Details');

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

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
		require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('times', '', 11);

	// add a page
	$pdf->SetMargins(9,33,9);
	$pdf->AddPage();
	
	$html = '<html><table align="left" border="1" cellpadding="6" cellspacing="0" width="100%">';
	
	if($uploadfor == 'S' && $dataArr['reg_no'] != '') {
		$html .= '<tr><td colspan="4" style="text-align:center;"><b>For Advocate</b></td></tr>';
		
		$labelForNumber = 'Advocate Enrolment Number';
		$number = $dataArr['reg_no'];
	}
	else if($uploadfor == 'S' && $dataArr['reg_no'] == '') {
		$html .= '<tr><td colspan="4" style="text-align:center;"><b>For Party-in-Person</b></td></tr>';
		
		$getIDRes = $call->GET_PIP_ID_DETAILS($_SESSION['lawyer']['user_id']);
		$idnum = $call->getDecryptValue($getIDRes[0]['id_num']);
		$idtype = $getIDRes[0]['type'];
		
		$labelForNumber = 'Identity Card Type / Number';
		$number = $idtype . ' / ' . $idnum;
	}
	else if($uploadfor == 'C') {
		$html .= '<tr><td colspan="4" style="text-align:center;"><b>For Advocate Clerk</b></td></tr>';
		
		$labelForNumber = 'Identity Card Number';
		$number = $dataArr['reg_no'];
	}
	
	if($dataArr['seconddose'] == 'Y') {
		$labelForVaccinationDate = 'Date of Second Vaccination';
	}
	else {
		$labelForVaccinationDate = 'Date of First Vaccination';
	}
	
	$html .= '<tr>
				<td style="text-align:left; width:40%;"><b> Name</b></td>
				<td style="text-align: left; width:60%;"> Mr./Ms. '.strtoupper($dataArr['name']).'</td>
			</tr>';
			
	$html .= '<tr>
				<td style="text-align:left; width:40%;"> <b>'.$labelForNumber.'</b></td>
				<td style="text-align: left; width:60%;"> '.strtoupper($number).'</td>
			</tr>';
			
	$html .= '<tr>
				<td style="text-align:left; width:40%;"> <b>'.$labelForVaccinationDate.'</b></td>
				<td style="text-align: left; width:60%;"> '.date('d-m-Y', strtotime($dataArr['second_dose_date'])).'</td>
			</tr>';
			
	$html .= '<tr>
				<td style="text-align:left; width:40%;"> <b>Vaccination Certificate Reference ID</b></td>
				<td style="text-align: left; width:60%;"> '.$dataArr['cert_ref_id'].'</td>
			</tr>';
			
	/*$html .= '<tr>
				<td style="text-align:left; width:40%;"> <b>Date of Issue</b></td>
				<td style="text-align: left; width:60%;"> '.date('d-m-Y h:i:s A', strtotime($dataArr['action_date'])).'</td>
			</tr>';*/
												 
	/*$html .= '<tr>
		<td colspan="2" style="text-align: left;"><b>Pass recommended by</b></td>
		<td colspan="2" style="text-align: left;">
			'.$_SESSION['lawyer']['user_name'].', Advocate
		</td>
	</tr>';*/
	
	$html .= '<tr>
				<td colspan="2" style="text-align:center; width:100%;"><b>Issued only for entry in premises of Rajasthan High Court</b></td>
			</tr>';

	$html .= '</table>';
	
	/*$validfor = 'Issued only for entry in premises of Rajasthan High Court';
	$html .= '<table align="left" border="1" cellpadding="3" cellspacing="0" width="100%">
			<tr style="background-color:#b0c4de;">
				<td colspan="2" style="text-align: center;"><b>ePass Details</b></td>
			</tr>
			<tr style="background-color:#ffeeee;">
				<td style="width:80%;">
					<center><b>ePass Details</b></center>
				</td>
				<td style="text-align:left; width:20%;">
					<center><b>Pass Generation Date</b></center>
				</td>
			</tr>
			<tr>
				<td style="text-align:justify; width:80%;">
					THIS ENTRY PASS IS NOT VALID FOR THE PERSONS UNDER QUARANTINE/ISOLATION.<br/><br/>
					'.$validfor.'
				</td>
					<td style="text-align:center; width:20%;">
						'.$dataArr['action_date'].'
					</td>
				</tr></table>';*/
	
	$html .= "</html>";
	
	//echo $html; die();

	$pdf->writeHTML($html, true, false, true, false, '');
	
	//QR Code generate start
	/*$case_type = $dataArr['type_name'];
	$case_no = $dataArr['reg_no'];
	$case_year = $dataArr['reg_year'];
	$causelist_date = $dataArr['cl_dt'];
    $advocate_name = $_SESSION['lawyer']['user_name'];
	$qrcode = 'Case Details: '.$case_type.'/'.$case_no.'/'.$case_year."\n".'Causelist Date: '.$causelist_date."\n".'Advocate Name: '.$advocate_name;
	$pdf->write2DBarcode($qrcode, 'QRCODE, Q', 180, 9, 15.5, 15.5, '', 'N');*/
	//QR Code end
	
	$filename = 'ePass_Details_'.rand(100001, 999999).'.pdf';
	$output = $pdf->Output(__DIR__ . '/storefiles/'.$filename, 'F');
	if(file_exists(__DIR__ . '/storefiles/'.$filename))
	{
		echo "OK##".$_SESSION['lawyer']['CSRF_Token']."##storefiles/".$filename; exit();
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