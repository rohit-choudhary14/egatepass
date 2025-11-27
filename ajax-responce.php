<?php
include "spoperation.php";
header( 'Content-Type: text/html; charset=utf-8' );
//error_reporting(0);
class Insert_USER_Detail extends spoperation{
	
	function __Construct(){
		
	}

	function StringValidtion($inputStr)
	{
		return preg_match("/^[a-zA-Z. \s]+$/",$inputStr);
	}

	function PartyNameValidtion($inputStr)
	{
		//return preg_match("/^[a-zA-Z. \/ \s]+$/",$inputStr);
		return preg_match("/^[a-zA-Z0-9.@&-_)( \/ \s \d]+$/",$inputStr);
	}

	function DateValidtion($inputDt)
	{
		return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$inputDt);
	}

	function NumberValidtion($inputNo)
	{
		return is_numeric($inputNo);
	}	

	function validate_email($email)
	{
		return preg_match( "/^[_A-za-z0-9-]+(\.[_A-za-z0-9-]+)*@[A-za-z0-9-]+(\.[A-za-z0-9-]+)*(\.[A-za-z]{2,})$/", $email);
	}

	function validate_mobile($mobile)
	{
		return preg_match('/(5|6|7|8|9)\d{9}/', $mobile);
	}

	function validateAlphanumericString($alphanum)
	{
		return preg_match("/^[a-zA-Z.0-9]+$/", $alphanum);
	}

	function validatePasswordString($password)
	{
		return preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/", $password);
	}

	function validateAddressString($address)
	{
		return preg_match('/^[\/a-zA-Z0-9-,.() ]+$/', $address);
	}

	function validateEnrollmentNumber($alphanum)
	{
		return preg_match("/^[a-zA-Z0-9 ]+$/", $alphanum);
	}
	
	function validateClerkRegistrationNumber($alphanum)
	{
		return preg_match("/^[a-zA-Z0-9\/]+$/", $alphanum);
	}
	
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
	
	function Check_Duplicate_EmailId($EmailId){
		$call = new spoperation();
		$check_email_error	=	$this->validate_email($EmailId);
		if($check_email_error==1 && strlen($EmailId)<=100){
			$dbemail 	= $this->getEncryptValue($EmailId);
			$email_sql 	= $call->SP_CHECK_USER_EMAILID_EXISTS_OR_NOT($dbemail);
			if(!empty($email_sql)){
				echo "Yes##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			else{
				echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else{
			echo "IVI##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}

	function Check_Duplicate_MobileNo($MobileNo){			
		$call = new spoperation();	 
		$mobileNumCheck = $this->validate_mobile($MobileNo);
		if($mobileNumCheck == 1 && strlen($MobileNo) == 10){
			$dbmobile = $this->getEncryptValue($MobileNo);
			
			$mob_sql = $call->SP_CHECK_USER_MOBILE_EXISTS_OR_NOT($dbmobile);
			if(!empty($mob_sql)){
				echo "Yes##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			else{
				echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else{
			echo "IVI##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}

	function sendVerificationCodeForResetPassword($mobile, $dob)
	{
		$call 	= new spoperation();
		$chkmob	= $this->validate_mobile($mobile);
		$call 	= new spoperation();
		$dob	= implode('-', array_reverse(explode('/', ltrim($dob," "))));			
		$usrage = (date('Y') - date('Y',strtotime($dob)));
		$chkdt  = $this->DateValidtion($dob);
		
		if(!$chkdt || strlen($dob) != 10){
			echo "DOB##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if($chkmob == 1 && strlen($mobile) == 10 && strlen($dob) == 10)	
		{
			$dbmobile = $this->getEncryptValue($mobile);
			$dobMobileSql = $call->SP_CHECK_USER_MOBILENO_EXISTS_OR_NOT_FOR_DOB($dbmobile, $dob);
			if(!empty($dobMobileSql)){
				$varcode = rand(100001, 999999);
				
				//SEND OTP ON MOBLE NUMBER
				$dlt_template_id = '1107160033837759671';
				$message = "OTP for RHC GATE PASS is $varcode";
				$message = urlencode($message);
				
				// SMS CODE
				$url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=courts-raj.sms&pin=A%25%5Eb3%24*z7&message=$message&mnumber=$mobile&signature=RCOURT&dlt_entity_id=1101333050000031038&dlt_template_id=$dlt_template_id";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPHEADER, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //needed so that the $result=curl_exec() output is the file and isn't just true/false
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$result = curl_exec($ch);
				curl_close($ch);
				//SEND OTP ON MOBLE NUMBER

				$_SESSION['lawyer']["$mobile"]['timestamp'] = date('Y-m-d H:i:s');
				$_SESSION['lawyer']["$mobile"]['varcode'] = $varcode;
				
				echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			else{
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else{
			echo "MNV##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}

	function sendVerificationCodeMobile($mobile){
		$varcode = rand(100001, 999999);
		
		//SEND OTP ON MOBLE NUMBER
		$dlt_template_id = '1107160033837759671';
		$message = "OTP for RHC GATE PASS is $varcode";
		$message = urlencode($message);
		
		// SMS CODE
		$url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=courts-raj.sms&pin=A%25%5Eb3%24*z7&message=$message&mnumber=$mobile&signature=RCOURT&dlt_entity_id=1101333050000031038&dlt_template_id=$dlt_template_id";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //needed so that the $result=curl_exec() output is the file and isn't just true/false
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($ch);
		curl_close($ch);
		//SEND OTP ON MOBLE NUMBER
		
		$_SESSION['lawyer']["$mobile"]['varcode'] 	= $varcode;
		$_SESSION['lawyer']["$mobile"]['timestamp'] = date('Y-m-d H:i:s');
		
		echo "Yes##".$_SESSION['lawyer']['CSRF_Token'].'##'.date('Y-m-d H:i:s').'##'.$varcode; exit();
	}

	function CheckVerificationcodeOfUser($mobile, $varcode){
		$otptime  = new DateTime($_SESSION['lawyer']["$mobile"]['timestamp']);
		$crntime  = date('Y-m-d H:i:s');
		$timediff = $otptime->diff(new DateTime($crntime));
		
		if($timediff->i >= 3){
			echo "OTP##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if($varcode != '' && $varcode == $_SESSION['lawyer']["$mobile"]['varcode']){
			echo "Yes##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else{
			echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}

	function SP_GET_CASE_TYPE_LIST(){			
		$call = new spoperation();
		$result = $call->SP_GET_CASE_TYPE_LIST();
		
		$res[0]['status'] 	 = 'OK';
		$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
		
		if(!empty($result)){
			$i=1;
			foreach($result as $row){
				$res[$i]['case_type'] = $row['case_type'];
				$res[$i]['type_name'] = $row['type_name'];
				$i++;
			}
		}
		
		echo json_encode($res); exit();
	}
	
	function SP_GET_PURPOSE_OF_VISIST(){
		$call = new spoperation();
		$result = $call->SP_GET_PURPOSE_OF_VISIST();
		
		$res[0]['status'] 	 = 'OK';
		$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
		
		if(!empty($result)){
			$i=1;
			foreach($result as $row){
				$res[$i]['id'] 		= $row['id'];
				$res[$i]['purpose'] = $row['purpose'];
				$i++;
			}
		}
		
		echo json_encode($res); exit();
	}

	function Check_Duplicate_EnrollNo($EnrollNo, $passtype){
		$EnrollNumCheck = $this->validateEnrollmentNumber($EnrollNo);
		$chkpasstype  = ($passtype!='' && $passtype!=null)?is_numeric($passtype):1;

		if($EnrollNumCheck == 1 && strlen($EnrollNo) <= 16 && $chkpasstype == 1){
			$call = new spoperation();
			$EnrollNo = strtoupper($EnrollNo);
			$EnrollNo = rtrim($EnrollNo, 'SR');
			$EnrollNo = rtrim($EnrollNo, 'SR.');

			$EnrollNo = $call->SP_GET_ENROLLNO_NAME_CODE($EnrollNo, $passtype);
			if(!empty($EnrollNo) && count($EnrollNo) == 1){
				$email = ''; $mob ='';
				
				if(trim($EnrollNo[0]['adv_mobile']) != ''){
					$phone 	= trim($EnrollNo[0]['adv_mobile']);
					$mob 	= substr($phone, 0, 2);
					$mob   .= "******";
					$mob   .= substr($phone, 8, 2);
				}
				
				if(trim($EnrollNo[0]['email']) != ''){
					$emailid = trim($EnrollNo[0]['email']);
					$email   = substr($emailid, 0, 3);
					$email 	.= "*********";
					$email 	.= substr($emailid, strlen($emailid)-6, 6);
				}
					
				echo "Yes##".$_SESSION['lawyer']['CSRF_Token'].'##'.$EnrollNo[0]['adv_name'].'@@'.$EnrollNo[0]['adv_code'].'@@'.$EnrollNo[0]['adv_mobile'].'@@'.$EnrollNo[0]['email'].'@@'.$mob.'@@'.$email; exit();
			}
			else{
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}		
		}
		else{
			echo "IVI##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	
	function CHECK_JR_ADV_ENROLLNO($EnrollNo){
		$EnrollNumCheck = $this->validateEnrollmentNumber($EnrollNo);

		if($EnrollNumCheck == 1 && strlen($EnrollNo) <= 16){
			$call = new spoperation();
			$EnrollNo = strtolower($EnrollNo);

			$EnrollNo = $call->SP_GET_JR_ADV_ENROLLNO_NAME($EnrollNo, $passtype);
			if(!empty($EnrollNo) && count($EnrollNo) == 1){
				$phone 	= trim($EnrollNo[0]['adv_mobile']);
				if(trim($EnrollNo[0]['adv_mobile']) != ''){
					$phone 	= trim($EnrollNo[0]['adv_mobile']);
					$mob 	= substr($phone, 0, 2);
					$mob   .= "******";
					$mob   .= substr($phone, 8, 2);
				}
				
				echo "Yes##".$_SESSION['lawyer']['CSRF_Token'].'##'.$EnrollNo[0]['adv_name'].'@@'.$mob.'@@'.$EnrollNo[0]['adv_mobile']; exit();
			}
			else{
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}		
		}
		else{
			echo "IVI##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}

	function INSERT_Advocate_Detail(){
		$name		= htmlentities(trim($_POST['ad_name']));
		$partyname	= htmlentities(trim($_POST['party_name']));
		$idtype		= htmlentities(trim($_POST['id_type']));
		$adv_code	= htmlentities(trim($_POST['adv_code']));
		$enrollno	= htmlentities(trim($_POST['ad_enroll_no']));
		$gender		= htmlentities($_POST['ad_gender']);
		$mobile_no	= htmlentities(trim($_POST['hdn_mobile']));
		$email		= htmlentities(strtolower(trim($_POST['hdn_email'])));
		$pass		= htmlentities($_POST['ad_pass']);
		$dob		= implode('-', array_reverse(explode('/', htmlentities(trim($_POST['dob'])))));
		$calculate 	= (date('Y') - date('Y',strtotime($dob)));
		$address	= htmlentities(trim($_POST['address']));
		$passtype	= htmlentities(trim($_POST['hdn_passtype']));
		$id_type	= htmlentities(trim($_POST['id_type']));
		$id_num		= htmlentities(trim($_POST['id_num']));
		$state		= htmlentities(trim($_POST['adv_state']));
		$district	= htmlentities(trim($_POST['adv_district']));
		$pincode	= htmlentities(trim($_POST['adv_pincode']));	 
		$ip_address	= $_SERVER['REMOTE_ADDR'];
		$idtype		= $idtype != '' ? $idtype:0;
		
		$estt = '';
		if($passtype == 3){
			$estt = htmlentities(trim($_POST['estttype']));
		}

		$chkpasstype  = ($passtype!='' && $passtype!=null) ? is_numeric($passtype):1;
		$chkAdvCode   = ($adv_code!='' && $adv_code!=null) ? is_numeric($adv_code):1;
		$checkPincode = ($pincode!='' && $pincode!=null) ? is_numeric($pincode):1;
		$checkEmail   = ($email !='' && $email != null) ? $this->validate_email($email):1;
		$checkEnroll  = ($enrollno !='' && $enrollno != null) ? $this->validateEnrollmentNumber($enrollno):1;
		$checkidtype  = ($id_type!='' && $id_type!=null) ? is_numeric($id_type):1;
		$checkidnum   = ($id_num !='' && $id_num != null) ? $this->validateAlphanumericString($id_num):1;
		
		$checkName  = ($name !='' && $name != null)?$this->StringValidtion($name):1;
		$checkPName  = ($partyname !='' && $partyname != null)? $this->StringValidtion($partyname):1;
		
		if(strlen($name)>100|| strlen($partyname)>100 || strlen($pass)>100 || strlen($pincode)>6 || !is_numeric($idtype) || !is_numeric($state) || strlen($state)>2 || !is_numeric($district) || strlen($district)>3  || $this->StringValidtion($gender)==0 || strlen($gender)>1 || $this->DateValidtion($dob)==0 || strlen($dob) != 10 || $this->validateAddressString($address)==0 || strlen($address)>500 || $this->validate_mobile($mobile_no)==0 || strlen($mobile_no) != 10 || $checkPincode==0 || $checkEmail==0 ||  $chkpasstype==0 || strlen($email)>100 || $checkEnroll == 0 || $checkName == 0 || $checkPName == 0 || $chkAdvCode == 0 || $checkidtype == 0 || $checkidnum == 0){
			echo "input_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		
		$call = new spoperation();
		
		$dbmobile = $this->getEncryptValue($mobile_no);
		$dbemail  = $this->getEncryptValue($email);
		$dbidnum  = $this->getEncryptValue($id_num);
		
		$mobile_no_sql 	= $call->SP_CHECK_USER_MOBILE_EXISTS_OR_NOT($dbmobile);
		$email_sql 		= $call->SP_CHECK_USER_EMAILID_EXISTS_OR_NOT($dbemail);
		
		$enroll_num_sql = array();
		if($passtype == '1')
			$enroll_num_sql = $call->SP_CHECK_USER_ENROLLNO_EXISTS_OR_NOT($enrollno.'SR');
		else if($passtype == '2')
			$enroll_num_sql = $call->SP_CHECK_USER_ENROLLNO_EXISTS_OR_NOT($enrollno);
		
		$check_mobile_number = $this->validate_mobile($mobile_no);
		$check_email_error 	 = $this->validate_email($email);
		$EnrollNumCheck 	 = $this->validateEnrollmentNumber($enrollno);	
		
		if(!empty($email_sql)){
			echo "email_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if($email == '' || $email == null){
			echo "email_not_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}					   
		else if(!empty($mobile_no_sql)){
			echo "contact_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		/* else if($calculate<18){
			echo "age_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		} */
		else if(!empty($enroll_num_sql) && $passtype != '3'){
			echo "enroll_error##".$_SESSION['lawyer']['CSRF_Token'].'##'.$enroll_num_sql[0]['name'];
			exit();
		}
		else if($check_mobile_number==0 || strlen($mobile_no) != 10){
			echo "phone_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if(!is_numeric($mobile_no) || strlen($mobile_no)>10){
			echo "number_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if(!is_numeric($pincode) && $pincode != "" && strlen($pincode) != 6){
			echo "number_error_pincode##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if($check_email_error==0 || strlen($email)>100){
			echo "email_not_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if(($EnrollNumCheck==0 || strlen($enrollno)>16) && $passtype != '3'){
			echo "enroll_not_valid_error##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		/* else if($passtype == 3 && !empty($_FILES["id_upload"]) && $call->SaveUploadedFile('id_upload') != 'OK'){
			echo $call->SaveUploadedFile('id_upload')."##".$_SESSION['lawyer']['CSRF_Token'].'##ID'; exit();
		} */
		else if($passtype == 3 && !empty($_FILES["id_photo"]) && $call->SaveUploadedFile('id_photo') != 'OK'){
			echo $call->SaveUploadedFile('id_photo')."##".$_SESSION['lawyer']['CSRF_Token'].'##PHOTO'; exit();
		}
		else{
			$pincode = $pincode != '' ? $pincode:0;
			$status	= 1; $role_id = 2;
			$randomText = rand(100001, 999999);
			$enrollno = $passtype == 1?$enrollno.'SR':$enrollno;
			$username = $enrollno;
			
			if($passtype == 3){
				$name 	  = $partyname;
				$status	  = 0;
				$username = $mobile_no;
			}

			$result = $call->SP_INSERT_USER_DETAILS($username, $name, $dbemail, $pass, $enrollno, $gender, $dbmobile,$status, $ip_address, $role_id, $dob, $address, $state, $district, $pincode, $randomText, $adv_code, $passtype, $id_type, $dbidnum, $estt);
			if(!empty($result)){
				/* if(!empty($_FILES["id_upload"])){
					copy($_FILES["id_upload"]["tmp_name"], "StoreCandIds/".$result[0]['id']."_".$randomText.".JPG");
				} */
				unset($_POST["id_photo"]);
				
				/************** INSERT LOG ***************/
				$postvalues = json_encode($_POST);
				$call->SP_ADD_USER_LOG($result[0]['id'], $_SERVER['REMOTE_ADDR'], 'User created successfully', $postvalues);
				/************** INSERT LOG ***************/
				
				if(!empty($_FILES["id_photo"])){
					copy($_FILES["id_photo"]["tmp_name"], "StoreCandPhoto/".$result[0]['id']."_".$randomText.".JPG");
				}
				echo "Ok##".$_SESSION['lawyer']['CSRF_Token']."##".$result[0]['id']; exit();
			}
			else{
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
	}	

	function Change_User_Password_By_Old_Password(){
		$OldPwd = htmlentities(trim(base64_decode($_POST['old_pass'])));
		$NewPwd = htmlentities(trim(base64_decode($_POST['new_pass'])));
		$UserId = htmlentities(trim(base64_decode($_POST['user_id'])));
		
		$_POST['old_pass'] = $OldPwd;
		$_POST['new_pass'] = $NewPwd;
		$_POST['user_id']  = $UserId;
		
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(is_numeric($UserId)==1 && strlen($OldPwd)<100 && strlen($NewPwd)<100){
			$call = new spoperation();
			$DBOldPwd = $call->SP_GET_USER_PASSWORD_BY_USER_ID($UserId);
			if(!empty($DBOldPwd))
			{
				$oldestpwd 	 = $DBOldPwd[0]['oldestpwd'];
				$dboldpwd 	 = $DBOldPwd[0]['oldpwd'];
				$dbpwd 		 = $DBOldPwd[0]['password'];
				$dbpwdsalt	 = $dbpwd.$_SESSION['lawyer']['Salt_PHP'];	  
				$salteddbpwd = hash('sha256', $dbpwdsalt);
				
				if($oldestpwd == $NewPwd){
					echo "OLD##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else if($dboldpwd == $NewPwd){
					echo "OLD##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else if($dbpwd == $NewPwd){
					echo "OLD##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else if($salteddbpwd == $OldPwd){
					$UpdatePwd = $call->SP_UPDATE_USER_PASSWORD_WITH_OLD_PWD($UserId, $NewPwd);
				
					/************** INSERT LOG ***************/
					$postvalues = json_encode($_POST);
					$call->SP_ADD_USER_LOG($_SESSION['lawyer']['user_id'], $_SERVER['REMOTE_ADDR'], 'Reset Password using old password', $postvalues);
					/************** INSERT LOG ***************/
					
					echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else{
					echo "OPWNM##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
			}
			else{
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else{
			echo "IVI##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	
	function resetPassword(){
		$newpwd	 = htmlentities(trim(base64_decode($_POST['new_pass'])));
		$user_id = htmlentities(trim(base64_decode($_POST['user_id'])));
		$call 	 = new spoperation();
		
		$_POST['new_pass'] = $newpwd;
		$_POST['user_id']  = $user_id;
		
		$chkuserid	= $this->validateAlphanumericString($user_id);
		if($chkuserid == 1 && strlen($user_id) <= 20 && strlen($newpwd) <= 100){
			$usrres = $call->SP_GET_USER_PASSWORD_BY_USER_ID($user_id);
			
			if(!empty($usrres)){
				
				$oldestpwd 	 = $usrres[0]['oldestpwd'];
				$dboldpwd 	 = $usrres[0]['oldpwd'];
				$dbpwd 		 = $usrres[0]['password'];
				
				if($oldestpwd == $newpwd){
					echo "OLD##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else if($dboldpwd == $newpwd){
					echo "OLD##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else if($dbpwd == $newpwd){
					echo "OLD##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				else{
					$resetpass = $call->SP_RESET_USER_PASSWORD_BY_ID($user_id, $newpwd);
					if($resetpass){
						/************** INSERT LOG ***************/
						$postvalues = json_encode($_POST);
						$call->SP_ADD_USER_LOG($user_id, $_SERVER['REMOTE_ADDR'], 'Reset Password using reset option', $postvalues);
						/************** INSERT LOG ***************/
						
						echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
					}
					else{
						echo "NS##".$_SESSION['lawyer']['CSRF_Token']; exit();
					}
				}
			}
			else{
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else{
			echo "IVI##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}

	function checkMobileNumberAndDOB($mobileNo, $dob){
		$mobile = $this->validate_mobile($mobileNo);
		$dob	=  implode('-', array_reverse(explode('/', ltrim($dob," "))));			
		$age 	= (date('Y') - date('Y',strtotime($dob)));
		$checkDate = $this->DateValidtion($dob);
		
		if(!$checkDate || strlen($dob) != 10){
			echo "DOB##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else if($mobile==1 && strlen($dob)==10 && strlen($mobileNo)==10){
			$call = new spoperation();
			
			$dbmobile = $this->getEncryptValue($mobileNo);
			$dobMobile = $call->SP_CHECK_USER_MOBILENO_EXISTS_OR_NOT_FOR_DOB($dbmobile, $dob);
			
			if(!empty($dobMobile)){
				$_SESSION['lawyer']['user_id'] = $dobMobile[0]['id'];
				echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			else{
				unset($_SESSION['lawyer']['user_id']);
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else{
			echo "MNV##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	
	function Check_USER_login($login_id, $pass, $base_url)
	{
		$call = new spoperation();	 
		$conn = $call->CreateConnection();
		
		$checkLoginId = $this->validateAlphanumericString($login_id);
		
		if($checkLoginId==true && strlen($login_id) <= 20 && strlen($pass) <= 100){
			$EnrollNo = $call->SP_CHECK_USER_LOGIN($login_id);
			
			if(!empty($EnrollNo)){
				$role_id	= $EnrollNo[0]['role_id'];
				$adv_code	= $EnrollNo[0]['adv_code'];
				$user_id	= $EnrollNo[0]['id'];
				$user_name	= $EnrollNo[0]['name'];
				$loginattempt= $EnrollNo[0]['loginattempt'];
				$block		= $EnrollNo[0]['block'];
				$mobile		= $this->getDecryptValue($EnrollNo[0]['contact_num']);
				$passtype	= $EnrollNo[0]['passtype'];
				$userStatus	= $EnrollNo[0]['status'];
				$without_salt = $EnrollNo[0]['password'];
				$with_salted  = $without_salt.$_SESSION['lawyer']['Salt_PHP'];	  
				$salted_pwd   = hash('sha256', $with_salted);
				
				$loginattempt = $loginattempt == '' ? 0:$loginattempt;
				
				if($salted_pwd == $pass){
					if($userStatus == 1 && $loginattempt<3 && $block == 'N'){
						session_regenerate_id();
						$_SESSION['lawyer']['sessionid'] = session_id();
						$_SESSION['lawyer']['user_id']	 = $user_id;
						$_SESSION['lawyer']['enroll_no'] = $EnrollNo[0]['enroll_num'];
						$_SESSION['lawyer']['user_name'] = $user_name;
						$_SESSION['lawyer']['role_id']	 = $role_id;
						$_SESSION['lawyer']['adv_code']	 = $adv_code;
						$_SESSION['lawyer']['mobile']	 = $mobile;
						$_SESSION['lawyer']['passtype']	 = $passtype;
						
						$call->SP_UPDATE_USER_LOGIN_ATTEMPT($login_id, 0);
						$call->SP_INSERT_USER_SESSION($user_id, $_SERVER['REMOTE_ADDR'], session_id());
						
						/************** INSERT LOG ***************/
						$postvalues = json_encode($_POST);
						$call->SP_ADD_USER_LOG($user_id, $_SERVER['REMOTE_ADDR'], 'User login successfully', $postvalues);
						/************** INSERT LOG ***************/
						
						$error='';
						header("Location:".$base_url."generate-pass.php");
						
					}
					else if($loginattempt >= 3){
						$_SESSION['lawyer']['error'] = 'This account has been Locked. Please contact to Admin';
						header("Location:".$base_url); exit();
					}
					else if($block == 'Y'){
						$_SESSION['lawyer']['error'] = 'This account has been Locked. Please contact to Admin';
						header("Location:".$base_url); exit();
					}
					else if($userStatus==0){
						$_SESSION['lawyer']['error'] = 'You account is not verified by Rajasthan High Court Administration';
						header("Location:".$base_url); exit();
					}
					else{
						$_SESSION['lawyer']['error'] = 'Incorrect login id and password.';
						header("Location:".$base_url); exit();
					}
				}
				else{
					$loginattempt++;
					$call->SP_UPDATE_USER_LOGIN_ATTEMPT($login_id, $loginattempt);
					
					$_SESSION['lawyer']['error']= 'Login Id or password is incorrect';
					header("Location:".$base_url); exit();
				}
			}
			else{
				$_SESSION['lawyer']['error']= 'Login Id or Password is incorrect';
				header("Location:".$base_url); exit();
			}
		}
		else{
			$_SESSION['lawyer']['error']= 'Invalid Input fields';
			header("Location:".$base_url); exit();
		}
	}

	function Check_admin_login($login_id, $pass, $base_url)
	{
		$call = new spoperation();	 
		$conn = $call->CreateConnection();
		
		$chkLoginId = $this->StringValidtion($login_id);
		
		if($chkLoginId == true && strlen($login_id) <= 20 && strlen($pass) <= 100){
			$LoginRes = $call->SP_CHECK_USER_LOGIN($login_id);
			
			if(!empty($LoginRes)){
				$role_id	= $LoginRes[0]['role_id'];
				$user_id	= $LoginRes[0]['id'];
				$user_name	= $LoginRes[0]['name'];
				$userStatus	= $LoginRes[0]['status'];
				$username	= $LoginRes[0]['username'];
				$loginattempt= $LoginRes[0]['loginattempt'];
				$block		= $LoginRes[0]['block'];
				$estt		= $LoginRes[0]['estt'];
				
				$without_salt = $LoginRes[0]['password'];
				$with_salted  = $without_salt.$_SESSION['lawyer']['Salt_PHP'];	  
				$salted_pwd   = hash('sha256', $with_salted);
				
				$loginattempt = $loginattempt == '' ? 0:$loginattempt;
				
				if($salted_pwd == $pass){
					if($userStatus==1 && $loginattempt<3 && $block == 'N'){
						session_regenerate_id();
						$_SESSION['lawyer']['sessionid'] = session_id();
						$_SESSION['lawyer']['user_id']	 = $user_id;
						$_SESSION['lawyer']['user_name'] = $user_name;
						$_SESSION['lawyer']['username']  = $username;
						$_SESSION['lawyer']['role_id']	 = $role_id;
						$_SESSION['lawyer']['estt']	 = $estt;
						//$_SESSION['lawyer']['connection']	= $estt;
						
						$call->SP_UPDATE_USER_LOGIN_ATTEMPT($login_id, 0);
						$call->SP_INSERT_USER_SESSION($user_id, $_SERVER['REMOTE_ADDR'], session_id());
						
						/************** INSERT LOG ***************/
						$postvalues = json_encode($_POST);
						$call->SP_ADD_USER_LOG($user_id, $_SERVER['REMOTE_ADDR'], 'Admin login successfully', $postvalues);
						/************** INSERT LOG ***************/
						
						header("Location:".$base_url."adv-admin/resquest-signin.php");
					}
					else if($loginattempt >= 3){
						$_SESSION['lawyer']['error'] = 'This account has been Locked. Please contact to Admin';
						header("Location:".$base_url."adv-admin/"); exit();
					}
					else if($block == 'Y'){
						$_SESSION['lawyer']['error'] = 'This account has been Locked. Please contact to Admin';
						header("Location:".$base_url."adv-admin/"); exit();
					}
					else if($userStatus==0){
						$_SESSION['lawyer']['unique']= $user_id;
						$_SESSION['lawyer']['error'] = 'This account is blocked. Please contact to admin.';
						header("Location:".$base_url."adv-admin/"); exit();
					}
					else{
						$_SESSION['lawyer']['error'] = 'Incorrect login id and password.';
						header("Location:".$base_url."adv-admin/"); exit();
					}
				}
				else{
					$loginattempt++;
					$call->SP_UPDATE_USER_LOGIN_ATTEMPT($login_id, $loginattempt);
					$_SESSION['lawyer']['error'] = 'Incorrect login id and password.';
					header("Location:".$base_url."adv-admin/"); exit();
				}
			}
			else{
				$_SESSION['lawyer']['error'] = 'Incorrect login id and password.';
				header("Location:".$base_url."adv-admin/"); exit();
			}
		}
		else{
			$_SESSION['lawyer']['error'] = 'Invalid input value.';
			header("Location:".$base_url."adv-admin/"); exit();
		}
	}

	function SP_GET_STATE_LIST(){
		$call 	= new spoperation();
		$result = $call->SP_GET_STATE_LIST();
		
		if(!empty($result)){
			$results[0]['status'] = 'OK';
			$results[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
			$i=1;
			foreach($result as $row){
				$results[$i]['id'] 		   = $row['id'];
				$results[$i]['state_name'] = $row['state_name'];
				$i++;
			}
			echo json_encode($results); exit();
		}
		else{
			$result[0]['status'] = 'NA';
			$result[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($result); exit();
		}
	}

	function SP_GET_DISTRICT_LIST($stateval){
		$call = new spoperation();
		if(is_numeric($stateval)==1 && strlen($stateval)<=3){
			$result = $call->SP_GET_DISTRICT_LIST($stateval);
			if(!empty($result)){
				$results[0]['status'] = 'OK';
				$results[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
				$i=1;
				foreach($result as $row){
					$results[$i]['id'] 			= $row['id'];
					$results[$i]['district_name'] = $row['district_name'];
					$i++;
				}
				echo json_encode($results); exit();
			}
			else{
				$result[0]['status'] = 'NA';
				$result[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
				echo json_encode($result); exit();
			}
		}
		else{
			$result[0]['status'] = 'IVI';
			$result[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($result); exit();
		}
	}
	
	function get_case_details(){
		$type 	= htmlentities(trim(base64_decode($_POST['type'])));
		$no 	= htmlentities(trim(base64_decode($_POST['no'])));
		$year 	= htmlentities(trim(base64_decode($_POST['year'])));
		$cltype = htmlentities(trim(base64_decode($_POST['cltype'])));
		$passfor= htmlentities(trim(base64_decode($_POST['passfor'])));
		$party  = htmlentities(trim(base64_decode($_POST['party'])));
		$advname = htmlentities(trim(base64_decode($_POST['advname'])));
		
		$cl_dt 	= implode('-', array_reverse(explode('/', htmlentities(trim(base64_decode($_POST['cldt']))))));
		$cldt 	= str_replace('/', '', htmlentities(trim(base64_decode($_POST['cldt']))));
		
		if(($passfor != '' && $this->StringValidtion($passfor) == 0) || $this->NumberValidtion($party) == 0 || $this->StringValidtion($cltype) == 0 || $this->NumberValidtion($type) == 0 || $this->NumberValidtion($no) == 0 || $this->NumberValidtion($year) == 0 || $this->DateValidtion($cl_dt) == 0){
			$data[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			$data[0]['status'] 	  = 'IVI';
			echo json_encode($data); exit();
		}
		
		$call 	= new spoperation();
		$result = $call->GET_CASE_DETAILS($type, $no, $year, $cltype, $cldt, $cl_dt, $passfor, $party, $advname);
		echo json_encode($result); exit();
	}
	
	function generatePassforAdv($cino, $adv_type, $cldt, $cltype, $courtno, $itemno, $paddress, $party, $passfor, $partyno, $partynm, $partymob){
		$cl_dt = implode('-', array_reverse(explode('/', trim($cldt))));
	
		$passfor = ($_SESSION['lawyer']['passtype'] == '3' OR $_SESSION['lawyer']['passtype'] == '1') ? 'S':$passfor;
		$partyno = ($_SESSION['lawyer']['passtype'] == '3' OR $passfor == 'S') ? 0:$partyno;
		$chkmob  = ($_SESSION['lawyer']['passtype'] == '3' OR $passfor == 'S') ? 1:$this->validate_mobile($partymob);
		
		//echo $passfor.' - '.$this->validateAlphanumericString($cino).' -- '.$this->NumberValidtion($adv_type).' -- '.$this->DateValidtion($cl_dt).' -- '.$this->StringValidtion($cltype).' -- '.$this->NumberValidtion($courtno).' -- '.$this->NumberValidtion($itemno).' -- '.$this->validateAddressString($paddress).' -- '.$this->NumberValidtion($party).' -- '.$this->StringValidtion($passfor).' -- '.$this->NumberValidtion($partyno).' -- '.$this->PartyNameValidtion($partynm).' -- '.$chkmob;; die;
		if($this->validateAlphanumericString($cino) == 0 || $this->NumberValidtion($adv_type) == 0 || $this->DateValidtion($cl_dt) == 0 || $this->StringValidtion($cltype) == 0 || $this->NumberValidtion($courtno) == 0 || $this->NumberValidtion($itemno) == 0 || ($paddress != '' && $this->validateAddressString($paddress) == 0) || $this->NumberValidtion($party) == 0 || $this->StringValidtion($passfor) == 0 || $this->NumberValidtion($partyno) == 0 || $this->PartyNameValidtion($partynm) == 0 || $chkmob == 0){
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
		else {
			$call = new spoperation();
			$res  = $call->SP_GENERATE_ADV_PASS($cino, $adv_type, $cldt, $cltype, $courtno, $itemno, $paddress, $party, $passfor, $partyno, $partynm, $partymob);

			/************** INSERT LOG ***************/
			$_POST['cino']		= $cino;
			$_POST['adv_type']	= $adv_type;
			$_POST['cldt']		= $cldt;
			$_POST['cltype']	= $cltype;
			$_POST['courtno']	= $courtno;
			$_POST['itemno']	= $itemno;
			$_POST['paddress']	= $paddress;
			$_POST['party']		= $party;
			$_POST['passfor']	= $passfor;
			$_POST['partyno']	= $partyno;
			$_POST['partynm']	= $partynm;
			$_POST['partymob'] 	= $partymob;
			
			$postvalues = json_encode($_POST);
			$call->SP_ADD_USER_LOG($_SESSION['lawyer']['user_id'], $_SERVER['REMOTE_ADDR'], 'User pass details', $postvalues);
			/************** INSERT LOG ***************/
			
			echo json_encode($res); exit();
		}
	}
	
	function send_pass_details_adv($passid, $passval){
		if($this->NumberValidtion($passid) == 0 || $this->StringValidtion($passval) == 0){
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
		
		$call = new spoperation();
		$res = $call->SEND_PASS_DETAILS_ADV($passid, $passval);
		echo json_encode($res); exit();
	}
	
	function get_matching_enrollment_list(){
		$enroll = htmlentities(strtoupper(trim($_POST['enroll'])));
		if($this->validateEnrollmentNumber($enroll)){
			$call 	= new spoperation();
			$result = $call->GET_MATCHING_ENROLLMENT_LIST($enroll);
			echo json_encode($result); exit();
		}
		else{
			echo 'NO'; exit();
		}
	}
	
	function search_generated_pass(){
		$fromdt = htmlentities(trim(base64_decode($_POST['fromdt'])));
		$todt   = htmlentities(trim(base64_decode($_POST['todt'])));
		$passval = htmlentities(trim(base64_decode($_POST['passval'])));
		
		$fromdt	= implode('-', array_reverse(explode('/', $fromdt)));
		$todt	= implode('-', array_reverse(explode('/', $todt)));
		
		if($this->DateValidtion($fromdt) && $this->DateValidtion($todt)){
			$call 	= new spoperation();
			$result = $call->GET_GENERATED_PASS_BY_ADV($fromdt, $todt, $passval);
			
			$res[0]['status'] 	 = 'OK';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			if(!empty($result)){
				$i=1;
				if($passval == 'C'){
					foreach($result as $row){
						$res[$i]['id'] 			= $row['id'];
						$res[$i]['pass_no'] 	= $row['pass_no'];
						$res[$i]['cl_dt'] 		= $row['cl_dt'];
						$res[$i]['cl_type'] 	= $row['cl_type'];
						$res[$i]['entry_dt'] 	= $row['entry_dt'];
						$res[$i]['pet_name'] 	= $row['pet_name'];
						$res[$i]['res_name'] 	= $row['res_name'];
						$res[$i]['reg_no'] 		= $row['reg_no'];
						$res[$i]['reg_year'] 	= $row['reg_year'];
						$res[$i]['type_name'] 	= $row['type_name'];
						$res[$i]['passfor'] 	= $row['passfor'];
						$res[$i]['party_name'] 	= $row['party_name'];
						$res[$i]['party_mob_no']= $this->getDecryptValue($row['party_mob_no']);
						$res[$i]['jradvname'] 	= $row['jradvname'];
						$res[$i]['jradvmob'] 	= $this->getDecryptValue($row['jradvmob']);
						$i++;
					}
				}
				else if($passval == 'S'){
					foreach($result as $row){
						$res[$i]['id'] 			= $row['id'];
						$res[$i]['pass_no'] 	= $row['pass_no'];
						$res[$i]['pass_dt']		= $row['pass_dt'];
						$res[$i]['entry_dt'] 	= $row['entry_dt'];
						
						$purposermks = json_decode($row['purposermks'], true);
						$purposeRemarks = '';
						foreach($purposermks as $pur){
							if($purposeRemarks == '')
								$purposeRemarks = $pur['purpose'].' - '.$pur['remark'];
							else
								$purposeRemarks .= '<br />'.$pur['purpose'].' - '.$pur['remark'];
						}
						$res[$i]['purposermks'] = $purposeRemarks;
						
						$i++;
					}
				}
			}
			echo json_encode($res); exit();			
		}
		else{
			$res[0]['status'] 	 = 'IVI';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	
	function search_party_sign_request(){
		$fromdt	= htmlentities(trim(base64_decode($_POST['fromdt'])));
		$todt	= htmlentities(trim(base64_decode($_POST['todt'])));
		
		$fromdt	= implode('-', array_reverse(explode('/', $fromdt)));
		$todt	= implode('-', array_reverse(explode('/',$todt)));
		
		if($this->DateValidtion($fromdt) && $this->DateValidtion($todt)){
			$call 	= new spoperation();
			$result = $call->SEARCH_PARTY_SIGN_REQUEST($fromdt, $todt);
			
			$res[0]['status'] 	 = 'OK';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			if(!empty($result)){
				$i=1;
				foreach($result as $row){
					$res[$i]['id'] 			= $row['id'];
					$res[$i]['state_name'] 	= $row['state_name'];
					$res[$i]['district'] 	= $row['district_name'];
					$res[$i]['name'] 		= $row['name'];
					$res[$i]['email'] 		= $this->getDecryptValue($row['email']);
					$res[$i]['contact_num'] = $this->getDecryptValue($row['contact_num']);
					$res[$i]['address'] 	= $row['address'];
					$res[$i]['pincode'] 	= $row['pincode'];
					$res[$i]['dob_str'] 	= $row['dob_str'];
					$res[$i]['idtype'] 		= $row['idtype'];
					$res[$i]['id_num'] 		= $this->getDecryptValue($row['id_num']);
					$res[$i]['ver_code']	= $row['ver_code'];
					$i++;
				}
			}
			echo json_encode($res); exit();
		}
		else{
			$res[0]['status'] 	  = 'IVI';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	
	function search_party_sign_request_ar(){
		$fromdt	= htmlentities(trim(base64_decode($_POST['fromdt'])));
		$todt	= htmlentities(trim(base64_decode($_POST['todt'])));
		
		$fromdt	= implode('-', array_reverse(explode('/', $fromdt)));
		$todt	= implode('-', array_reverse(explode('/', $todt)));
		
		if($this->DateValidtion($fromdt) && $this->DateValidtion($todt)){
			$call 	= new spoperation();
			$result = $call->SEARCH_PARTY_SIGN_REQUEST_AR($fromdt, $todt);
			
			$res[0]['status'] 	 = 'OK';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			if(!empty($result)){
				$i=1;
				foreach($result as $row){
					$res[$i]['id'] 			= $row['id'];
					$res[$i]['state_name'] 	= $row['state_name'];
					$res[$i]['district'] 	= $row['district_name'];
					$res[$i]['name'] 		= $row['name'];
					$res[$i]['email'] 		= $this->getDecryptValue($row['email']);
					$res[$i]['contact_num'] = $this->getDecryptValue($row['contact_num']);
					$res[$i]['address'] 	= $row['address'];
					$res[$i]['pincode'] 	= $row['pincode'];
					$res[$i]['dob_str'] 	= $row['dob_str'];
					$res[$i]['idtype'] 		= $row['idtype'];
					$res[$i]['pstatus'] 	= $row['pstatus'];
					$res[$i]['id_num'] 		= $this->getDecryptValue($row['id_num']);
					$res[$i]['ver_code']	= $row['ver_code'];
					$res[$i]['remark']		= $row['remark'];
					$i++;
				}
			}
			echo json_encode($res); exit();
		}
		else{
			$res[0]['status'] 	 = 'IVI';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	
	function GET_REGISTER_USERS_COUNT(){
		$fromdt	= htmlentities(trim(base64_decode($_POST['fromdt'])));
		$todt	= htmlentities(trim(base64_decode($_POST['todt'])));
		$srchby	= htmlentities(trim(base64_decode($_POST['srchby'])));
		
		$fromdt	= implode('-', array_reverse(explode('/', $fromdt)));
		$todt	= implode('-', array_reverse(explode('/', $todt)));
		
		if($this->DateValidtion($fromdt) && $this->DateValidtion($todt) && $this->NumberValidtion($srchby)){
			$call 	= new spoperation();
			if($_SESSION['lawyer']['estt'] == 'P'){
				$result  = $call->GET_REGISTER_USERS_COUNT_JDP($fromdt, $todt, $srchby);
			}
			else{
				$result = $call->GET_REGISTER_USERS_COUNT($fromdt, $todt, $srchby);
			}
			
			$res[0]['status'] 	 = 'OK';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			if(!empty($result)){
				$i=1; $prvdt = '';
				foreach($result as $row){
					if($prvdt == '' || $prvdt == $row['regdate']){
						if($prvdt == ''){
							$res[$i]['regdate']   = $row['regdate'];
							$res[$i]['sradvpass'] = 0;
							$res[$i]['advpass']   = 0;
							$res[$i]['litpass']   = 0;
							$res[$i]['pippass']   = 0;
							$res[$i]['sradvreg']  = 0;
							$res[$i]['advreg'] 	  = 0;
							$res[$i]['pipreg'] 	  = 0;
							
							$res[$i]['sradvsectionpass']  = 0;
							$res[$i]['advsectionpass'] = 0;
							$res[$i]['pipsectionpass'] = 0;
						}
						$prvdt = $row['regdate'];
						$res[$i]['regdate']  = implode('/', array_reverse(explode('-', $row['regdate'])));
						if($row['passtype'] == '1' && $row['report'] == '2' && $row['passfor'] == 'S'){
							$res[$i]['sradvpass'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'S'){
							$res[$i]['advpass'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'L'){
							$res[$i]['litpass'] = $row['count'];
						}
						else if($row['passtype'] == '3' && $row['report'] == '2' && $row['passfor'] == 'S'){
							$res[$i]['pippass'] = $row['count'];
						}
						else if($row['passtype'] == '1' && $row['report'] == '1'){
							$res[$i]['sradvreg'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '1'){
							$res[$i]['advreg'] = $row['count'];
						}
						else if($row['passtype'] == '3' && $row['report'] == '1'){
							$res[$i]['pipreg'] = $row['count'];
						}
						
						else if($row['passtype'] == '1' && $row['report'] == '3' && $row['passfor'] == 'S'){
							$res[$i]['sradvsectionpass'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '3' && $row['passfor'] == 'S'){
							$res[$i]['advsectionpass'] = $row['count'];
						}
						else if($row['passtype'] == '3' && $row['report'] == '3' && $row['passfor'] == 'S'){
							$res[$i]['pipsectionpass'] = $row['count'];
						}
					}
					else if($prvdt != $row['regdate']){
						$i++;
						$prvdt = $row['regdate'];
						$res[$i]['regdate']  = implode('/', array_reverse(explode('-', $row['regdate'])));
						$res[$i]['sradvpass'] = 0;
						$res[$i]['advpass']   = 0;
						$res[$i]['litpass']   = 0;
						$res[$i]['pippass']   = 0;
						$res[$i]['sradvreg']  = 0;
						$res[$i]['advreg'] 	  = 0;
						$res[$i]['pipreg'] 	  = 0;
						
						$res[$i]['sradvsectionpass'] = 0;
						$res[$i]['advsectionpass'] 	 = 0;
						$res[$i]['pipsectionpass'] 	 = 0;
						
						if($row['passtype'] == '1' && $row['report'] == '2' && $row['passfor'] == 'S'){
							$res[$i]['sradvpass'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'S'){
							$res[$i]['advpass'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '2' && $row['passfor'] == 'L'){
							$res[$i]['litpass'] = $row['count'];
						}
						else if($row['passtype'] == '3' && $row['report'] == '2' && $row['passfor'] == 'S'){
							$res[$i]['pippass'] = $row['count'];
						}
						else if($row['passtype'] == '1' && $row['report'] == '1'){
							$res[$i]['sradvreg'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '1'){
							$res[$i]['advreg'] = $row['count'];
						}
						else if($row['passtype'] == '3' && $row['report'] == '1'){
							$res[$i]['pipreg'] = $row['count'];
						}
						
						else if($row['passtype'] == '1' && $row['report'] == '3' && $row['passfor'] == 'S'){
							$res[$i]['sradvsectionpass'] = $row['count'];
						}
						else if($row['passtype'] == '2' && $row['report'] == '3' && $row['passfor'] == 'S'){
							$res[$i]['advsectionpass'] = $row['count'];
						}
						else if($row['passtype'] == '3' && $row['report'] == '3' && $row['passfor'] == 'S'){
							$res[$i]['pipsectionpass'] = $row['count'];
						}
					}
				}
			}
			echo json_encode($res); exit();
		}
		else{
			$res[0]['status'] 	 = 'IVI';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	
	function GET_REGISTER_PASSESS_COUNT(){
		$searchby = htmlentities(trim(base64_decode($_POST['searchby'])));
		$fromdt	= htmlentities(trim(base64_decode($_POST['fromdt'])));
		$todt	= htmlentities(trim(base64_decode($_POST['todt'])));
		
		$fromdt	= implode('-', array_reverse(explode('/', $fromdt)));
		$todt	= implode('-', array_reverse(explode('/', $todt)));
		
		if($this->DateValidtion($fromdt) && $this->DateValidtion($todt) && $this->NumberValidtion($searchby)){
			$call 	= new spoperation();
			$registerjp  = $call->GET_REGISTER_PASSESS_COUNT($fromdt, $todt, $searchby);
			$registerjdp = $call->GET_REGISTER_PASSESS_COUNT_JDP($fromdt, $todt, $searchby);
			
			$res[0]['status'] 	 = 'OK';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			$i=1;
			if(!empty($registerjp)){
				foreach($registerjp as $row){
					$res[$i]['count'] 	 = $row['count'];
					$res[$i]['passtype'] = $row['passtype'];
					$res[$i]['remark'] 	 = $row['remark'];
					$res[$i]['passfor']  = $row['passfor'];
					$res[$i]['report'] 	 = $row['report'];
					$res[$i]['estt'] 	 = 'B';
					$i++;
				}
			}
			if(!empty($registerjdp)){
				foreach($registerjdp as $row){
					$res[$i]['count'] 	 = $row['count'];
					$res[$i]['passtype'] = $row['passtype'];
					$res[$i]['remark'] 	 = $row['remark'];
					$res[$i]['passfor']  = $row['passfor'];
					$res[$i]['report'] 	 = $row['report'];
					$res[$i]['estt'] 	 = 'P';
					$i++;
				}
			}
			echo json_encode($res); exit();
		}
		else{
			$res[0]['status'] 	 = 'IVI';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	
	function search_blocked_user_account(){
		$call 	= new spoperation();
		$result = $call->SEARCH_BLOCKED_USER_ACCOUNT();
		
		$res[0]['status'] 	 = 'OK';
		$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
		if(!empty($result)){
			$i=1;
			foreach($result as $row){
				if(!empty($row)){
					$res[$i]['id'] 			= $row['id'];
					$res[$i]['state_name'] 	= $row['state_name'];
					$res[$i]['district'] 	= $row['district_name'];
					$res[$i]['name'] 		= $row['name'];
					$res[$i]['email'] 		= $this->getDecryptValue($row['email']);
					$res[$i]['contact_num'] = $this->getDecryptValue($row['contact_num']);
					$res[$i]['address'] 	= $row['address'];
					$res[$i]['pincode'] 	= $row['pincode'];
					$res[$i]['dob_str'] 	= $row['dob_str'];
					$i++;
				}
			}
		}
		echo json_encode($res); exit();
	}
	
	function UNBLOCK_USER_ACCOUNT(){
		$dataid	= htmlentities(trim(base64_decode($_POST['dataid'])));
		
		if($this->NumberValidtion($dataid)){
			$call 	= new spoperation();
			$result = $call->UNBLOCK_USER_ACCOUNT($dataid);
			if($result){
				echo json_encode("OK##".$_SESSION['lawyer']['CSRF_Token'].'##'.$dataid); exit();
			}
			else{
				echo json_encode("NU##".$_SESSION['lawyer']['CSRF_Token']); exit();
			}
		}
		else{
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token'].'##'.$dataid); exit();
		}
	}
	
	function APPROVE_REJECT_PARTY_REQUEST(){
		$dataid	= htmlentities(trim(base64_decode($_POST['dataid'])));
		$action	= htmlentities(trim(base64_decode($_POST['chkval'])));
		$remark	= htmlentities(trim(base64_decode($_POST['remark'])));
		$mobile	= htmlentities(trim(base64_decode($_POST['mobile'])));
		
		if($this->NumberValidtion($dataid) && $this->NumberValidtion($action) && $this->NumberValidtion($mobile)){
			$call 	= new spoperation();
			$result = $call->APPROVE_REJECT_PARTY_REQUEST($dataid, $action, $remark);
			if($result){
				if($action == '1'){
					$dlt_template_id = '1107160033849832781';
					$message = "Registration for RHC e-Gate Pass approved. Kindly login to generate pass.";
				}
				else if($action == '2'){
					$dlt_template_id = '1107160033853492123';
					$message = "Registration for RHC e-Gate Pass rejected due to $remark";
				}
				$message = urlencode($message);
		
				// SMS CODE
				$url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=courts-raj.sms&pin=A%25%5Eb3%24*z7&message=$message&mnumber=$mobile&signature=RCOURT&dlt_entity_id=1101333050000031038&dlt_template_id=$dlt_template_id";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPHEADER, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //needed so that the $result=curl_exec() output is the file and isn't just true/false
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$result = curl_exec($ch);
				curl_close($ch);
				// SEND PASS DETAIL TO ADVOCATE

				/*$dbmobile = $this->getEncryptValue($mobile);
				$MyQuery="INSERT INTO gatepass_sms_details(cino, causelist_dt, causelist_type, pass_no, adv_enroll, user_id, user_ip, entry_dt, mobile) VALUES('$cino', '$cl_dt', '$cltype', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$dbmobile')";
				$data = $this->Query($MyQuery, $this->bindParamArray);*/
				echo json_encode("OK##".$_SESSION['lawyer']['CSRF_Token']); exit();
			}
			else{
				echo json_encode("NU##".$_SESSION['lawyer']['CSRF_Token']); exit();
			}
		}
		else{
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	
	function UPDATE_ADV_NAME_INSIDE_CASE(){			
		$type	 = htmlentities(trim(base64_decode($_POST['type'])));
		$no		 = htmlentities(trim(base64_decode($_POST['no'])));
		$year	 = htmlentities(trim(base64_decode($_POST['year'])));
		$cltype	 = htmlentities(trim(base64_decode($_POST['cltype'])));
		$cldt	 = htmlentities(trim(base64_decode($_POST['cldt'])));
		$advname = strtolower(htmlentities(trim(base64_decode($_POST['advname']))));
		$cldt 	 = str_replace('/', '', $cldt);
		
		if($this->NumberValidtion($type) && $this->NumberValidtion($no) && $this->NumberValidtion($year) && $this->NumberValidtion($cldt) && $this->StringValidtion($cltype) && $this->StringValidtion($advname)){
			$call = new spoperation();
			$res  = $call->UPDATE_ADV_NAME_INSIDE_CASE($type, $no, $year, $cltype, $cldt, $advname);
			
			echo json_encode($res."##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
		else{
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	
	function GENERATE_ADV_SECTION_PASS(){
		$passfor = htmlentities(trim(base64_decode($_POST['passfor'])));
		$pass_dt = htmlentities(trim(base64_decode($_POST['pass_dt'])));
		$vist_purpose = htmlentities(trim(base64_decode($_POST['vist_purpose'])));
		$purposermks  = stripslashes(base64_decode($_POST['purposermks']));
		$passtype = $_SESSION['lawyer']['passtype'];
		
		$passdt  = implode('-', array_reverse(explode('/', $pass_dt)));
																													  
		if($this->StringValidtion($passfor) && $this->DateValidtion($passdt) && $this->validateAddressString($vist_purpose)){
			$call = new spoperation();
			if($passtype == '1' || $passtype == '2')
				$res  = $call->GENERATE_ADV_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks);
			else if($passtype == '3')
				$res  = $call->GENERATE_PIP_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks);
			echo json_encode($res); exit();
		}
		else{
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}

	function GENERATE_ADV_SECTION_PASS_FOR_LITIGANTS(){
		$passfor = htmlentities(trim(base64_decode($_POST['passfor'])));
		$pass_dt = htmlentities(trim(base64_decode($_POST['pass_dt'])));
		$vist_purpose = htmlentities(trim(base64_decode($_POST['vist_purpose'])));
		$purposermks  = stripslashes(base64_decode($_POST['purposermks']));
		$litigant_mob = htmlentities(trim(base64_decode($_POST['litigant_mob'])));
		$litigant_name  = stripslashes(base64_decode($_POST['litigant_name']));
		$passtype = $_SESSION['lawyer']['passtype'];
		
		$passdt  = implode('-', array_reverse(explode('/', $pass_dt)));
			if($this->StringValidtion($passfor) && $this->DateValidtion($passdt) && $this->validateAddressString($vist_purpose)){
			$call = new spoperation();
			if($passtype == '1' || $passtype == '2')
				$res  = $call->GENERATE_ADV_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks);
			else if($passtype == '3')
				$res  = $call->GENERATE_PIP_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks);
			echo json_encode($res); exit();
		}
		else{
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}																										  
		// if($this->StringValidtion($passfor) && $this->DateValidtion($passdt) && $this->validateAddressString($vist_purpose)){
		// 	$call = new spoperation();
		// 	if($passtype == '1' || $passtype == '2')
		// 		$res  = $call->GENERATE_ADV_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks);
		// 	else if($passtype == '3')
		// 		$res  = $call->GENERATE_PIP_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks);
		// 	echo json_encode($res); exit();
		// }
		// else{
		// 	echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		// }
	}
	
	function CHECK_CASE_EXISTS_OR_NOT(){			
		$type  = htmlentities(trim(base64_decode($_POST['type'])));
		$no	   = htmlentities(trim(base64_decode($_POST['no'])));
		$year  = htmlentities(trim(base64_decode($_POST['year'])));
		$ctype = htmlentities(trim(base64_decode($_POST['casefilingtype'])));
		
		$chkctype = $type != '0' ? $this->NumberValidtion($type):1;
		$chkcno   = $type != '0' ? $this->NumberValidtion($no):1;
		$chkcyear = $type != '0' ? $this->NumberValidtion($year):1;
		$chkcfile = $ctype != '' ? $this->StringValidtion($ctype):1;
		
		if($chkctype == 1 && $chkcno == 1 && $chkcyear == 1 && $chkcfile == 1){
			$call = new spoperation();
			$res  = $call->CHECK_CASE_EXISTS_OR_NOT($type, $no, $year, $ctype);
			if(!empty($res)){
				echo json_encode('OK##'.$_SESSION['lawyer']['CSRF_Token'].'##'.$res[0]['cino']); exit();
			}
			else{
				echo json_encode("NE##".$_SESSION['lawyer']['CSRF_Token']); exit();
			}
		}
		else{
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	
	function uploadVaccinationCertificate()
	{
		$firstdose = htmlentities($_POST['firstdose']);
		$seconddose = htmlentities($_POST['seconddose']);
		$refid = htmlentities($_POST['refid']);
		$seconddosedate = htmlentities($_POST['seconddosedate']); // DD/MM/YYYY
		$uploadfor = htmlentities($_POST['uploadfor']);
		$action = htmlentities($_POST['action']);
		$dataid = htmlentities($_POST['dataid']);
		
		if($firstdose != 'Y') {
			echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."You can upload certificate only after getting first dose of vaccine."; exit();
		}
		
		if($action == 'U' && $seconddose != 'Y') {
			echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."You can upload certificate only after getting second dose of vaccine."; exit();
		}
		
		if(empty($refid)) {
			echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Please enter valid reference id mentioned on vaccination certificate."; exit();
		}
		
		if(empty($seconddosedate) || strlen($seconddosedate) != 10) {
			echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Please select date of taking vaccination dose."; exit();
		}
		else {
			$seconddosedate = implode('-', array_reverse(explode('/', $seconddosedate)));
			
			if(!$this->DateValidtion($seconddosedate)) {
				echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Please select date of taking vaccination dose."; exit();
			}
		}
		
		if($uploadfor == 'C') {
			$regno = htmlentities(trim($_POST['regno']));
			$name = htmlentities(trim($_POST['name']));
			$mobile = htmlentities(trim($_POST['mobile']));
			
			if(empty($regno) || strlen($regno) < 3 || !$this->validateClerkRegistrationNumber($regno)) {
				echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Please enter valid registration number of advocate clerk."; exit();
			}
			
			if(empty($name) || strlen($name) < 3 || !$this->StringValidtion($name)) {
				echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Please enter valid name of advocate clerk."; exit();
			}
			
			if(empty($mobile) || !$this->validate_mobile($mobile)) {
				echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Please enter valid 10-digit mobile number of advocate clerk."; exit();
			}
			
			$sms_name = $name;
			$sms_mobile = $this->getDecryptValue($mobile);
			
			$mobile = $this->getEncryptValue($mobile);
		}
		else {
			$sms_name = $_SESSION['lawyer']['user_name'];
			$sms_mobile = $_SESSION['lawyer']['mobile'];
		}
		
		if(empty($_FILES['certificate'])) {
			echo "NVIMG##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		
		$name_file = $_FILES['certificate']['name'];
		$ext_file = strtolower(substr($name_file, strrpos($name_file, '.') + 1));
		
		$call = new spoperation();
		$uploadStatus = $call->SaveUploadedFile('certificate', true, 20480, 204800);
		
		if($uploadStatus != 'OK') {
			echo $uploadStatus."##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else {
			$user_id = $_SESSION['lawyer']['user_id'];
			$user_ip = $_SERVER['REMOTE_ADDR'];
			$estt = $_SESSION['lawyer']['connection'];
			$filePath = "StoreVaccCert/".$user_id."_".$refid.".".$ext_file;
			
			if($uploadfor == 'S' && $action == 'I') {
				$result = $call->SP_INSERT_COVID_VACCINATION_STATUS_USERS($user_id, $firstdose, $seconddose, $refid, $seconddosedate, $filePath, $user_ip, $estt);
			}
			else if($uploadfor == 'C' && $action == 'I') {
				$result = $call->SP_INSERT_COVID_VACCINATION_STATUS_OTHERS($user_id, $firstdose, $seconddose, $refid, $seconddosedate, $filePath, $user_ip, $regno, $name, $mobile, $estt);
			}
			else if($uploadfor == 'S' && $action == 'U') {
				$result = $call->SP_UPDATE_COVID_VACCINATION_STATUS_USERS($dataid, $user_id, $firstdose, $seconddose, $refid, $seconddosedate, $filePath, $user_ip, $estt);
			}
			else if($uploadfor == 'C' && $action == 'U') {
				$result = $call->SP_UPDATE_COVID_VACCINATION_STATUS_OTHERS($dataid, $user_id, $firstdose, $seconddose, $refid, $seconddosedate, $filePath, $user_ip, $regno, $name, $mobile, $estt);
			}
			
			if($result) {
				// copy file to folder
				copy($_FILES["certificate"]["tmp_name"], $filePath);
				
				/************** INSERT LOG ***************/
				unset($_POST["certificate"]);
				$postvalues = json_encode($_POST);
				$call->SP_ADD_USER_LOG($user_id, $user_ip, 'COVID vaccination status updated successfully', $postvalues);
				/************** INSERT LOG ***************/
				
				// send SMS
				/*$maxDate = date('Y-m-d', strtotime('-14 days'));
				if($seconddosedate > $maxDate) {
					$dlt_template_id = '1107162451962489032';
					$message = "Dear Mr./Ms. $sms_name, Your request for vaccination certificate verification has been put on hold as you have not completed 14 days after the vaccination. Registrar (Administration), Rajasthan High Court.";
					$message = urlencode($message);
			
					// SMS CODE
					$url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=courts-raj.sms&pin=A%25%5Eb3%24*z7&message=$message&mnumber=$sms_mobile&signature=RCOURT&dlt_entity_id=1101333050000031038&dlt_template_id=$dlt_template_id";
					
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_HTTPHEADER, false);
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //needed so that the $result=curl_exec() output is the file and isn't just true/false
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					$result = curl_exec($ch);
					curl_close($ch);
				}*/
				
				echo "Ok##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			else {
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
	}
	
	function resetVaccinationData()
	{
		$uploadfor = htmlentities(base64_decode($_POST['uploadfor']));
		$dataid = htmlentities(base64_decode($_POST['dataid']));
		$user_id = $_SESSION['lawyer']['user_id'];
		$user_ip = $_SERVER['REMOTE_ADDR'];
		
		if(empty($dataid) || empty($uploadfor)) {
			echo "input_error##".$_SESSION['lawyer']['CSRF_Token']."##"."Invalid input data."; exit();
		}
		
		$call = new spoperation();
		$result = $call->SP_RESET_COVID_VACCINATION_STATUS($user_id, $dataid, $uploadfor);
		
		if($result) {
			/************** INSERT LOG ***************/
			$postvalues = json_encode($_POST);
			$call->SP_ADD_USER_LOG($user_id, $user_ip, 'COVID vaccination status reset successfully', $postvalues);
			/************** INSERT LOG ***************/
			
			echo "Ok##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
		else {
			echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	
	function getVaccinationStatus()
	{
		$fromdt	= htmlentities(trim(base64_decode($_POST['fromdt'])));
		$todt = htmlentities(trim(base64_decode($_POST['todt'])));
		$status	= htmlentities(trim(base64_decode($_POST['status'])));
		
		$fromdt	= implode('-', array_reverse(explode('/', $fromdt)));
		$todt = implode('-', array_reverse(explode('/',$todt)));
		
		if($this->DateValidtion($fromdt) && $this->DateValidtion($todt)) {
			$estt = $_SESSION['lawyer']['estt'];
			$call = new spoperation();
			$result = $call->SP_GET_COVID_VACCINATION_STATUS($fromdt, $todt, $estt, $status);
			
			$res[0]['status'] = 'OK';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			if(!empty($result)) {
				$i=1;
				foreach($result as $row){
					$res[$i]['id'] = $row['id'];
					$res[$i]['firstdose'] = $row['firstdose'] == 'Y' ? 'Yes' : 'No';
					$res[$i]['seconddose'] = $row['seconddose'] == 'Y' ? 'Yes' : 'No';
					$res[$i]['refid'] = $row['cert_ref_id'];
					$res[$i]['seconddosedate'] = date('d-m-Y', strtotime($row['second_dose_date']));
					$res[$i]['status'] = $row['status'];
					$res[$i]['remark'] = $row['remark'];
					$res[$i]['entrydate'] = date('d-m-Y h:i:s A', strtotime($row['entry_date']));
					$res[$i]['regno'] = $row['reg_no'] ? strtoupper($row['reg_no']) : 'NA';
					$res[$i]['name'] = ucwords(strtolower($row['name']));
					$res[$i]['mobile'] = $this->getDecryptValue($row['mobile']);
					$res[$i]['uploadfor'] = $row['uploadfor'];
					$res[$i]['filepath'] = $row['cert_file_path'];
					
					if($row['uploadfor'] == 'S' && $row['reg_no'] != '') {
						$res[$i]['usertype'] = 'Advocate';
					}
					else if($row['uploadfor'] == 'S' && $row['reg_no'] == '') {
						$res[$i]['usertype'] = 'Party-in-Person';
					}
					if($row['uploadfor'] == 'C') {
						$res[$i]['usertype'] = 'A. Clerk';
					}
					
					$i++;
				}
			}
			echo json_encode($res); exit();
		}
		else {
			$res[0]['status'] 	  = 'IVI';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	
	function approveRejectCertificateUpload()
	{
		$dataid	= htmlentities(trim(base64_decode($_POST['dataid'])));
		$action	= htmlentities(trim(base64_decode($_POST['chkval'])));
		$remark	= htmlentities(trim(base64_decode($_POST['remark'])));
		$mobile	= htmlentities(trim(base64_decode($_POST['mobile'])));
		$uploadfor = htmlentities(trim(base64_decode($_POST['uploadfor'])));
		$name = htmlentities(trim(base64_decode($_POST['name'])));
		$dose = htmlentities(trim(base64_decode($_POST['dose'])));
		
		$user_id = $_SESSION['lawyer']['user_id'];
		$user_ip = $_SERVER['REMOTE_ADDR'];
		
		if($this->NumberValidtion($dataid) && in_array($action, ['A', 'R']) && $this->validate_mobile($mobile))
		{
			$call = new spoperation();
			$result = $call->SP_APPROVE_REJECT_CERTIFICATE_UPLOAD($dataid, $action, $remark, $uploadfor, $user_id, $user_ip);
			if($result) {
				/************** INSERT LOG ***************/
				$postvalues = json_encode($_POST);
				$call->SP_ADD_USER_LOG($user_id, $user_ip, 'COVID vaccination status updated successfully', $postvalues);
				/************** INSERT LOG ***************/
				
				if($action == 'A') {
					/*$dlt_template_id = '1107162451884608488';
					$message = "Dear Mr./Ms. $name, on verification of your final vaccination certificate, you have been allowed entry in Rajasthan High Court premises. You may download the authorization card or show this message at entry gates. Registrar (Administration), Rajasthan High Court.";*/
					$dlt_template_id = '1107162513539179065';
					$message = "Dear Mr./Ms. $name, on verification of your $dose vaccination certificate, you have been allowed entry in Rajasthan High Court premises. You may download the authorization card or show this message at entry gates. Registrar (Administration), Rajasthan High Court.";
				}
				else if($action == 'R') {
					$dlt_template_id = '1107162451950634875';
					$message = "Dear Mr./Ms. $name, Your request for vaccination certificate verification has been rejected. Please visit the portal on Rajasthan High Court website for details. Registrar (Administration), Rajasthan High Court.";
				}
				
				$message = urlencode($message);
		
				// SMS CODE
				$url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=courts-raj.sms&pin=A%25%5Eb3%24*z7&message=$message&mnumber=$mobile&signature=RCOURT&dlt_entity_id=1101333050000031038&dlt_template_id=$dlt_template_id";
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPHEADER, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //needed so that the $result=curl_exec() output is the file and isn't just true/false
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$result = curl_exec($ch);
				curl_close($ch);

				echo json_encode("OK##".$_SESSION['lawyer']['CSRF_Token']); exit();
			}
			else {
				echo json_encode("NU##".$_SESSION['lawyer']['CSRF_Token']); exit();
			}
		}
		else {
			echo json_encode("IVI##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	
	function resendVaccinationCertificateSMS()
	{
		$dataid	= htmlentities(trim(base64_decode($_POST['dataid'])));
		$uploadfor = htmlentities(trim(base64_decode($_POST['uploadfor'])));
		
		$user_id = $_SESSION['lawyer']['user_id'];
		$user_ip = $_SERVER['REMOTE_ADDR'];
		
		if($this->NumberValidtion($dataid))
		{
			$call = new spoperation();
			$result = $call->SP_GET_COVID_VACCINATION_DETAILS_FOR_PDF($dataid, $uploadfor);
			if($result) {
				/************** INSERT LOG ***************/
				$postvalues = json_encode($_POST);
				$call->SP_ADD_USER_LOG($user_id, $user_ip, 'COVID vaccination status SMS resent successfully', $postvalues);
				/************** INSERT LOG ***************/
				
				$name = ucwords(strtolower($result[0]['name']));
				$mobile = $this->getDecryptValue($result[0]['mobile']);
				$dose = $result[0]['seconddose'] == 'Y' ? 'second' : 'first';
				
				$dlt_template_id = '1107162513539179065';
				$message = "Dear Mr./Ms. $name, on verification of your $dose vaccination certificate, you have been allowed entry in Rajasthan High Court premises. You may download the authorization card or show this message at entry gates. Registrar (Administration), Rajasthan High Court.";
				$message = urlencode($message);
				
				// SMS CODE
				$url = "https://smsgw.sms.gov.in/failsafe/HttpLink?username=courts-raj.sms&pin=A%25%5Eb3%24*z7&message=$message&mnumber=$mobile&signature=RCOURT&dlt_entity_id=1101333050000031038&dlt_template_id=$dlt_template_id";
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HTTPHEADER, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //needed so that the $result=curl_exec() output is the file and isn't just true/false
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$result = curl_exec($ch);
				curl_close($ch);

				echo "OK##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			else {
				echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		else {
			echo "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
}

if($_POST){
	$call = new Insert_USER_Detail();
	if($_POST['QueryType'] == 'check_enroll'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->Check_Duplicate_EnrollNo(htmlentities(trim(base64_decode($_POST['enroll']))), htmlentities(trim(base64_decode($_POST['passtype']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'check_mobileno'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->Check_Duplicate_MobileNo(htmlentities(trim(base64_decode($_POST['mobile']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'check_emailid'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->Check_Duplicate_EmailId(htmlentities(trim(base64_decode($_POST['email_val']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else  if($_POST['QueryType'] == 'insert_advocate_data'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->INSERT_Advocate_Detail();
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else  if($_POST['QueryType'] == 'ChangePassword'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->Change_User_Password_By_Old_Password(); 
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'loginBtn_advocate'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$login_id	= htmlentities(trim($_POST['login_id']));
			$pass		= htmlentities(trim($_POST['pass']));
			
			$call->Check_USER_login($login_id, $pass, $base_url);
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}		
	else if($_POST['QueryType'] == 'StateList'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->SP_GET_STATE_LIST();
		}
		else{
			$result[0]['status'] = 'CSRF';
			$result[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($result); exit();
		}
	}
	else  if($_POST['QueryType'] == 'DistrictList'){
		$stateval = htmlentities(trim(base64_decode($_POST['stateval'])));
		
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->SP_GET_DISTRICT_LIST($stateval);
		}
		else{
			$result[0]['status'] = 'CSRF';
			$result[0]['csrf']   = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($result); exit();
		}	
	}
	else if($_POST['QueryType'] == 'checkVerificationCode'){
		$mobile  = htmlentities(trim(base64_decode($_POST['mobile'])));
		$varcode = htmlentities(trim(base64_decode($_POST['vericationCode'])));
		
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];		
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->CheckVerificationcodeOfUser($mobile, $varcode);
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'resendVericationCode'){
		$mobile = htmlentities(trim(base64_decode($_POST['mobile'])));
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->sendVerificationCodeMobile($mobile);
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'sendcodeforresetpass'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->sendVerificationCodeForResetPassword(htmlentities(trim(base64_decode($_POST['mobile']))), htmlentities(trim(base64_decode($_POST['dob']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'resetpasswordlink'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->checkMobileNumberAndDOB(htmlentities(trim(base64_decode($_POST['mobile']))), htmlentities(trim(base64_decode($_POST['dob']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else  if($_POST['QueryType'] == 'resetPassword'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->resetPassword();
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'searchCases'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->get_case_details();
		}
		else{
			$data[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			$data[0]['status'] 	  = 'CSRF';
			echo json_encode($data); exit();
		}
	}
	else if($_POST['QueryType'] == 'setestt'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$_SESSION['lawyer']['connection'] = htmlentities(trim(base64_decode($_POST['estt'])));
			echo json_encode("OK##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'casetype'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->SP_GET_CASE_TYPE_LIST();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'getPurpose'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->SP_GET_PURPOSE_OF_VISIST();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'searchEnroll'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->get_matching_enrollment_list();
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'srchGeneratedPass'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->search_generated_pass();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'sendVarCode'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->sendVerificationCodeMobile(htmlentities(trim(base64_decode($_POST['mobile']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'genPass'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		//if (trim($_POST['csrftoken']) == $csrftoken){
			$call->generatePassforAdv(htmlentities(trim(base64_decode($_POST['cino']))), htmlentities(trim(base64_decode($_POST['adv_type']))), htmlentities(trim(base64_decode($_POST['cldt']))), htmlentities(trim(base64_decode($_POST['cltype']))), htmlentities(trim(base64_decode($_POST['courtno']))), htmlentities(trim(base64_decode($_POST['itemno']))), htmlentities(strtoupper(trim(base64_decode($_POST['paddress'])))), htmlentities(trim(base64_decode($_POST['party']))), htmlentities(trim(base64_decode($_POST['passfor']))), htmlentities(trim(base64_decode($_POST['partyno']))), trim(base64_decode($_POST['partynm'])), htmlentities(trim(base64_decode($_POST['partymob']))), htmlentities(trim(base64_decode($_POST['jradvmob']))), htmlentities(trim(base64_decode($_POST['jradvname']))), htmlentities(trim(base64_decode($_POST['jrenroll']))), htmlentities(trim(base64_decode($_POST['jradvprtyno']))));
		/* }
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		} */
	}
	else if($_POST['QueryType'] == 'sendPass'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->send_pass_details_adv(htmlentities(trim(base64_decode($_POST['passid']))), htmlentities(trim(base64_decode($_POST['passval']))));
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'adminLogin'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$login_id = htmlentities(trim($_POST['login_id']));
			$pass	  = htmlentities(trim($_POST['pass']));
			$call->Check_admin_login($login_id, $pass, $base_url);
		}
		else{
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}		
	}
	else if($_POST['QueryType'] == 'srchPartyinPerson'){		
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->search_party_sign_request();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'srchRegisterUser'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->GET_REGISTER_USERS_COUNT();
		}
		else{
			$res[0]['status'] 	 = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'srchRegPassCnt'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->GET_REGISTER_PASSESS_COUNT();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'srchPartyinPersonAR'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->search_party_sign_request_ar();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'actionPartyinPerson'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->APPROVE_REJECT_PARTY_REQUEST();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'srchBlockedUser'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->search_blocked_user_account();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'actionUnblockUsr'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->UNBLOCK_USER_ACCOUNT();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'updateAdvname'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->UPDATE_ADV_NAME_INSIDE_CASE();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'genSectionPass'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->GENERATE_ADV_SECTION_PASS();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'genSectionPassForLitigants'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->GENERATE_ADV_SECTION_PASS_FOR_LITIGANTS();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'chkCaseDetail'){
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		//if (trim($_POST['csrftoken']) == $csrftoken){
			$call->CHECK_CASE_EXISTS_OR_NOT();
		/* }
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		} */
	}
	else if($_POST['QueryType'] == 'uploadVaccinationCertificate') {
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken) {
			$call->uploadVaccinationCertificate();
		}
		else {
			echo "CSRF##".$_SESSION['lawyer']['CSRF_Token']; exit();
		}
	}
	else if($_POST['QueryType'] == 'getVaccinationStatus'){		
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if(trim($_POST['csrftoken']) == $csrftoken){
			$call->getVaccinationStatus();
		}
		else{
			$res[0]['status'] 	  = 'CSRF';
			$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
			echo json_encode($res); exit();
		}
	}
	else if($_POST['QueryType'] == 'approveRejectCertificateUpload') {
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->approveRejectCertificateUpload();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'resetVaccinationData') {
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->resetVaccinationData();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
	else if($_POST['QueryType'] == 'resendVaccinationSMS') {
		$csrftoken = $_SESSION['lawyer']['CSRF_Token'];
		$_SESSION['lawyer']['CSRF_Token'] = md5(uniqid());
		
		if (trim($_POST['csrftoken']) == $csrftoken){
			$call->resendVaccinationCertificateSMS();
		}
		else{
			echo json_encode("CSRF##".$_SESSION['lawyer']['CSRF_Token']); exit();
		}
	}
}
else{
	header("Location:".$base_url."error.php");exit();
}	
?>