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
	$passid 	= htmlentities(trim(base64_decode($_POST['passid'])));
	$download 	= htmlentities(trim(base64_decode($_POST['download'])));
	$postedcsrf = htmlentities(trim($_POST['csrftoken']));
	
	$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
	$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
	
	if($postedcsrf != $csrftoken){
		echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
	}
	
	$idnum=''; $idtype = '';
	
	$call = new spoperation();
	if(($_SESSION['lawyer']['passtype'] == '1' || $_SESSION['lawyer']['passtype'] == '2') && $download == 'C'){
		$getPassData = $call->GET_PASS_DETAILS_FOR_PDF($passid);
	}
	else if(($_SESSION['lawyer']['passtype'] == '1' || $_SESSION['lawyer']['passtype'] == '2') && $download == 'S'){
		$getPassData = $call->GET_SECTION_PASS_DETAILS_FOR_PDF($passid);
	}
	else if($_SESSION['lawyer']['passtype'] == '3' && $download == 'C'){
		$getPassData = $call->GET_PIP_PASS_DETAILS_FOR_PDF($passid);
		
		$getIDRes = $call->GET_PIP_ID_DETAILS($_SESSION['lawyer']['user_id']);
		
		$idnum	= $call->getDecryptValue($getIDRes[0]['id_num']);
		$idtype = $getIDRes[0]['type'];
	}
	else if($_SESSION['lawyer']['passtype'] == '3' && $download == 'S'){
		$getPassData = $call->GET_SECTION_PASS_DETAILS_FOR_PDF($passid);
		
		$getIDRes = $call->GET_PIP_ID_DETAILS($_SESSION['lawyer']['user_id']);
		
		$idnum	= $call->getDecryptValue($getIDRes[0]['id_num']);
		$idtype = $getIDRes[0]['type'];
	}
	
	$dataArr = array();
	//print_r($getPassData); die;
	foreach($getPassData AS $row)
	{
		$dataArr[] = $row;
	}
	
	class MYPDF extends TCPDF 
	{
		public $cldt;
		public function setData($cldt)
		{
			$this->cldt = $cldt;
		}
		//Page header
		public function Header() 
		{
			$fitbox=false;
			$this->Rect(6, 5, 200, 277, 'DF', '', array(255, 255, 255));  //x,y,w,h
			
			//$this->SetLineWidth(0.2);
			$this->Line(6, 30, 206, 30, '');  //horizontal line after logo   x1,y1,x2,y2
			//$this->Line(170, 3, 170, 25, $style);
			$this->Line(35, 5, 35, 30, '');   //vertical line after logo
			$this->Line(175, 5, 175, 30, '');   //vertical line after logo
			$this->SetFont('times', 'B', 14);
			if($_SESSION['lawyer']['connection'] == 'B'){
				$this->Text(68, 8, 'RAJASTHAN HIGH COURT BENCH JAIPUR');
			}
			else if($_SESSION['lawyer']['connection'] == 'P'){
				$this->Text(68, 8, 'RAJASTHAN HIGH COURT JODHPUR');
			}
			$this->SetFont('times', 'B', 12);
			$this->Text(100, 15, 'ePass Details');
			$this->SetFont('times', 'B', 12,'C');
			$this->Cell(180, 0, '', 0, 1); 
			$this->Text(85, 21, '(Pass vaild for: '.$this->cldt.' only)');
			$this->SetFont('times', 'B', 12,'C');
			$this->Cell(180, 0, '', 0, 1);
			//$this->write1DBarcode(2010192, 'I25', 170, 9, 35, 16, 0.4, $style1, 'N');
			$this->Image('images/Emblem_of_India.png', 11, 8, 18, 18, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
			$this->Text(20, 25, '');
		}
	}		
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(210, 297), true, 'UTF-8', false);
	//echo $dataArr[0]['cl_dt']; die;
	$pdf->setData($dataArr[0]['cl_dt']);
	
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

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('times', '', 11);

	// add a page
	$pdf->SetMargins(9,33,9);
	$pdf->AddPage();
	
	$html ='<html><table align="left" border="1" cellpadding="3" cellspacing="0" width="100%">';

	if($download == 'C'){
		if($dataArr[0]['passfor'] == 'L' && $_SESSION['lawyer']['passtype'] == '2'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Litigant</b></td></tr>';
		}
		else if($dataArr[0]['passfor'] == 'J' && $_SESSION['lawyer']['passtype'] == '2'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Jr. Advocate</b></td></tr>';
		}
		else if($_SESSION['lawyer']['passtype'] == '2'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Advocate</b></td></tr>';
		}
		else if($_SESSION['lawyer']['passtype'] == '1'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Sr. Advocate</b></td></tr>';
		}
		else if($_SESSION['lawyer']['passtype'] == '3'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Party in Person</b></td></tr>';
		}
	
	$html .='<tr>
				<td style="text-align:left; width:15%;"><b>Case Details</b></td>
				<td style="text-align: left; width:35%;">'.$dataArr[0]['type_name'].' / '.$dataArr[0]['reg_no'].' / '.$dataArr[0]['reg_year'].'</td>
				<td style="text-align:left; width:15%;"><b>Pass Number</b></td>
				<td style="text-align:left; width:35%;">'.$dataArr[0]['pass_no'].'</td>
			</tr>';
			
		$html .='<tr>
				<td style="text-align: left;"><b>Petitioner</b></td>
				<td style="text-align: left;">
					'.$dataArr[0]['pet_name'].'
				</td>
				<td style="text-align: left;"><b>Respondent</b></td>
				<td style="text-align: left;">
					'.$dataArr[0]['res_name'].'
				</td>
			</tr>';
		if($dataArr[0]['passfor'] == 'L'){
    $warningText = 'Litigant must carry a valid Photo ID with this ePass.';
} else {
    $warningText = '';
}
	if($dataArr[0]['passfor'] == 'L'){
			// $html .='<tr>
			// 	<td colspan="2" style="text-align: left;"><b>Present residential address</b></td>
			// 	<td colspan="2" style="text-align: left;">
			// 		'.$dataArr[0]['paddress'].'
			// 	</td>
			// </tr>';
												 
			$html .='<tr>
				<td colspan="2" style="text-align: left;"><b>Pass recommended by</b></td>
				<td colspan="2" style="text-align: left;">
					'.$_SESSION['lawyer']['user_name'].', Advocate
				</td>
			</tr>';

			$validfor = 'This entry pass is issued for <b>'.$dataArr[0]['party_name'].'</b> &nbsp;R/O of <b>'.$dataArr[0]['paddress'].'</b>  and valid for item no. <b>'.$dataArr[0]['item_no'].'</b> in court no. <b>'.$dataArr[0]['court_no'].'</b>.This pass is valid for case hearing on <b>'.$dataArr[0]['cl_dt'].'</b> only.'.$warningText.'';
		}
		else if($_SESSION['lawyer']['passtype'] == '1'){
			$validfor = 'This entry pass is issued for <span style="font-size: 12pt;"><b>'.$_SESSION['lawyer']['user_name'].'</b></span> and valid for case hearing on <b>'.$dataArr[0]['cl_dt'].'</b> only.';
		}
		else if($_SESSION['lawyer']['passtype'] == '2'){
			$validfor = 'This entry pass is issued for <span style="font-size: 12pt;"><b>'.$_SESSION['lawyer']['user_name'].'</b></span> and valid for case hearing on <b>'.$dataArr[0]['cl_dt'].'</b> only.';
		}
		else if($_SESSION['lawyer']['passtype'] == '3'){
			$html .='<tr>
					<td colspan="2" style="text-align: left;"><b>ID Details</b></td>
					<td colspan="2" style="text-align: left;">
						Photo ID Type: '.$idtype.', ID Number: '.$idnum.'
					</td>
				</tr>';
			$validfor = 'This entry pass is issued for <span style="font-size: 12pt;"><b>'.trim($_SESSION['lawyer']['user_name']).'</b></span> and valid for item no. <b>'.$dataArr[0]['item_no'].'</b> in court no. <b>'.$dataArr[0]['court_no'].'</b>.<br/><br/>This pass is valid for case hearing on <b>'.$dataArr[0]['cl_dt'].'</b> only.';
		}


	

	
	$html .= '</table>
		<table align="left" border="1" cellpadding="3" cellspacing="0" width="100%">
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
        '.$warningText.'<br/><br/>
        '.$validfor.'
    </td>
    <td style="text-align:center; width:20%;">
        '.$dataArr[0]['gen_dt'].'
    </td>
</tr></table>';
	}
	else if($download == 'S'){
		if($_SESSION['lawyer']['passtype'] == '2'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Advocate</b></td></tr>';
		}
		else if($_SESSION['lawyer']['passtype'] == '1'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Sr. Advocate</b></td></tr>';
		}
		else if($_SESSION['lawyer']['passtype'] == '3'){
			$html .='<tr><td colspan="4" style="text-align:center;"><b>Pass for Party in Person</b></td></tr>';
		}
		
		$html .='<tr>
					<td style="text-align:left; width:15%;"><b>Date of Visit</b></td>
					<td style="text-align: left; width:35%;">'.$dataArr[0]['cl_dt'].'</td>
					<td style="text-align:left; width:15%;"><b>Pass Number</b></td>
					<td style="text-align:left; width:35%;">'.$dataArr[0]['pass_no'].'</td>
				</tr>';
		
		$purposermks = json_decode($dataArr[0]['purposermks'], true);
		$remarks = '';
		$purposeVisit = '';
		foreach($purposermks as $pur){
			if($purposeVisit == '')
				$purposeVisit = $pur['purpose'];
			else
				$purposeVisit .= "<br />".$pur['purpose'];
			if($remarks == '')
				$remarks = $pur['remark'];
			else
				$remarks .= "<br />".$pur['remark'];
		}
		$html .='<tr>
					<td colspan="2" style="text-align:left;"><b>Purpose of Visit</b></td>
					<td colspan="2" style="text-align:left;"><b>'.$purposeVisit.'</b></td>
				</tr>';
		$html .='<tr>
					<td colspan="2" style="text-align:left;"><b>Remarks</b></td>
					<td colspan="2" style="text-align:left;">'.$remarks.'</td>
				</tr>';
		
		if($_SESSION['lawyer']['passtype'] == '2'){
			$validfor = 'This entry pass is issued for <span style="font-size: 12pt;"><b>'.$_SESSION['lawyer']['user_name'].'</b></span>, Advocate and valid for Ancillary Purposes other than court hearing on <span style="font-size: 12pt;"><b>'.$dataArr[0]['cl_dt'].'</b></span> only.';
		}
		else if($_SESSION['lawyer']['passtype'] == '1'){
			$validfor = 'This entry pass is issued for <span style="font-size: 12pt;"><b>'.$_SESSION['lawyer']['user_name'].'</b></span>, Sr. Advocate and valid for Ancillary Purposes other than court hearing on <span style="font-size: 12pt;"><b>'.$dataArr[0]['cl_dt'].'</b></span> only.';
		}
		else if($_SESSION['lawyer']['passtype'] == '3'){
			$validfor = 'This entry pass is issued for <span style="font-size: 12pt;"><b>'.$_SESSION['lawyer']['user_name'].'</b></span>, Party in Person and valid for Ancillary Purposes other than court hearing on <span style="font-size: 12pt;"><b>'.$dataArr[0]['cl_dt'].'</b></span> only.';
		}
		
		$html .= '</table>
			<table align="left" border="1" cellpadding="3" cellspacing="0" width="100%">
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
        '.$warningText.'<br/><br/>
        '.$validfor.'
    </td>
					<td style="text-align:center; width:20%;">
						'.$dataArr[0]['gen_dt'].'
					</td>
				</tr></table>';
	}
	
	$html .="</html>";
	//echo $html; die();

	$pdf->writeHTML($html, true, false, true, false, '');
	//QR Code generate start
	$case_type = $dataArr[0]['type_name'];
	$case_no = $dataArr[0]['reg_no'];
	$case_year = $dataArr[0]['reg_year'];
	$causelist_date = $dataArr[0]['cl_dt'];
    $advocate_name = $_SESSION['lawyer']['user_name'];

	
	if($download == 'C'){
		$qrcode = 'Case Details: '.$case_type.'/'.$case_no.'/'.$case_year."\n".'Causelist Date: '.$causelist_date."\n".'Advocate Name: '.$advocate_name;
	}
	if($download == 'S'){
		$purposermks = json_decode($dataArr[0]['purposermks'], true);
		$section = '';
		foreach($purposermks as $pur){
			$section .= $pur['purpose'] . "\n";
		}
		//echo $section; die;
		$qrcode = 'Section Details: '.$section.'Causelist Date: '.$causelist_date."\n".'Advocate Name: '.$advocate_name;
	}
	
	//$pdf->write2DBarcode($qrcode, 'QRCODE, Q', 80, 100, 35, 35, '', 'N'); //below side
	$pdf->write2DBarcode($qrcode, 'QRCODE, Q', 180, 9, 15.5, 15.5, '', 'N'); //below side
				

   // echo $qrcode; die;
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