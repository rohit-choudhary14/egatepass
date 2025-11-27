<?php 
	include "urlConfig.php";
	header( 'Content-Type: text/html; charset=utf-8' );
	date_default_timezone_set("Asia/kolkata");
	class spoperation
	{
		var $dbHost, $dbUser, $dbPass, $dbName, $db_conn, $MyQuery;
		public $bindParamArray = array();
		
		function CreateConnection()
		{
			global $dbHost;
			global $dbUser;
			global $dbPass;
			global $dbName;
		    //$dbHost = "localhost";
			$dbUser = 'postgres';
			$dbPass = '1';
			
			if(isset($_SESSION['lawyer']['connection']) && $_SESSION['lawyer']['connection'] == 'B'){
				$dbHost = "10.130.8.95";
				$dbName = 'jaipur_new';
			}
			else if(isset($_SESSION['lawyer']['connection']) && $_SESSION['lawyer']['connection'] == 'P'){
				$dbHost = "10.130.8.95";
				$dbName = 'jaipur_new';
			}
			else{
				$dbHost = "10.130.8.95";
				$dbName = 'jaipur_new';
			}
			
			try{	
				$conn = new PDO("pgsql:host=$dbHost; dbname=$dbName", $dbUser, $dbPass);
				return $conn;
			}
			catch(PDOException $e){  
				echo "* Error: Pgsql connection impossible !!!\n";
				$msg=$e->getMessage(); exit();
			}
		}
		
		function CreateMainConnection()
		{
			global $dbHost;
			global $dbUser;
			global $dbPass;
			global $dbName;
		    //$dbHost = "localhost";
			$dbUser = 'postgres';
			$dbPass = '1';
			$dbHost = "10.130.8.95";
			$dbName = 'jaipur_new';
			
			try{	
				$conn = new PDO("pgsql:host=$dbHost; dbname=$dbName", $dbUser, $dbPass);
				return $conn;
			}
			catch(PDOException $e){  
				echo "* Error: Pgsql connection impossible !!!\n";
				$msg=$e->getMessage(); exit();
			}
		}
		
		function CreateJDPConnection()
		{
			global $dbHost;
			global $dbUser;
			global $dbPass;
			global $dbName;
		    //$dbHost = "localhost";
			$dbUser = 'postgres';
			$dbPass = '1';
			$dbHost = "10.130.8.95";
			$dbName = 'jaipur_new';
			
			try{	
				$conn = new PDO("pgsql:host=$dbHost; dbname=$dbName", $dbUser, $dbPass);
				return $conn;
			}
			catch(PDOException $e){  
				echo "* Error: Pgsql connection impossible !!!\n";
				$msg=$e->getMessage(); exit();
			}
		}
		
		function countQuery($query,$bind_param_arr){			
			if($query!='' && is_array($bind_param_arr)){
				$conn = $this->CreateConnection();
				
				$sqlchk=$conn->prepare($query);		 
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$sqlchk->execute($bind_param_arr);
					$rowchk=$sqlchk->fetch();
					$count1=$rowchk[0];
					return array('errorFlag'=>'0','count1'=>$count1);
				}
				catch (PDOException $e){
					echo $e->getMessage( );
				}
			}	
		}

		function Query($query, $bind_insert){
			if($query!='' && is_array($bind_insert)){
				$conn = $this->CreateConnection();
				
				$sql=$conn->prepare($query);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
				
				try{
					$sql->execute($bind_insert);
					$iteminfo = array('count1' => 0);           
					return $iteminfo;
				}
				catch (PDOException $e){
					echo  $e->getMessage( )."..$query**********\n";
				}
			}
		}

		function Query_inMainDB($query, $bind_insert){
			if($query!='' && is_array($bind_insert)){
				$conn = $this->CreateConnection();
				
				$sql=$conn->prepare($query);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
				
				try{
					$sql->execute($bind_insert);
					$iteminfo = array('count1' => 0);           
					return $iteminfo;
				}
				catch (PDOException $e){
					echo  $e->getMessage( )."..$query**********\n";
				}
			}
		}

		function fetchQuerySingle($query,$bind_param){
			if($query!='' && is_array($bind_param)){
				$conn = $this->CreateConnection();
				
				$sqlchk=$conn->prepare($query);         
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$sqlchk->execute($bind_param);
					$rowchk=$sqlchk->fetch();
					$columnname_arr=array();
					foreach(range(0, $sqlchk->columnCount() - 1) as $column_index){
						$meta[] = $sqlchk->getColumnMeta($column_index);
						foreach($meta as $columnname){
							if(strpos($columnname['native_type'],'int')!==false)
								$columnname_arr[$columnname['name']]=0;
							else
								$columnname_arr[$columnname['name']]='';
						}
					}
				   
					if(count($rowchk)>1){
						$rowchk['errorFlag']='0';
						$rowchk['numrows']=count($rowchk);
						return $rowchk;
					}
					else{
						$columnname_arr['errorFlag']='0';
						$columnname_arr['numrows']=1;
						return $columnname_arr;
					}
				}
				catch (PDOException $e){
					echo  $e->getMessage( );
				}
			}
		}

		function fetchQuery($query, $bind_param){
			if($query!='' && is_array($bind_param)){
				$conn = $this->CreateConnection();
				
				$sqlchk=$conn->prepare($query);		 
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$sqlchk->execute($bind_param);	
					$rowchk=$sqlchk->fetchAll(PDO::FETCH_ASSOC);	
					return $rowchk;
				}
				catch (PDOException $e){
					echo  $e->getMessage( );
				}
			}
		}

		function fetchQuery_inMainDB($query, $bind_param){
			if($query!='' && is_array($bind_param)){
				$conn = $this->CreateMainConnection();
				
				$sqlchk=$conn->prepare($query);		 
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$sqlchk->execute($bind_param);	
					$rowchk=$sqlchk->fetchAll(PDO::FETCH_ASSOC);	
					return $rowchk;
				}
				catch (PDOException $e){
					echo  $e->getMessage( );
				}
			}
		}
		
		function fetchQuery_inJDPDB($query, $bind_param){
			if($query!='' && is_array($bind_param)){
				$conn = $this->CreateJDPConnection();
				
				$sqlchk=$conn->prepare($query);		 
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				try{
					$sqlchk->execute($bind_param);	
					$rowchk=$sqlchk->fetchAll(PDO::FETCH_ASSOC);	
					return $rowchk;
				}
				catch (PDOException $e){
					echo  $e->getMessage( );
				}
			}
		}

		function insertQuery($query, $bind_insert){
			if($query!='' && is_array($bind_insert)){
				$conn = $this->CreateConnection();
				
				$sql=$conn->prepare($query);
				$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
				
				try{
					$sql->execute($bind_insert);
					$rowchk=$sql->fetchAll();	
					return $rowchk;
				}
				catch (PDOException $e){
					echo  $e->getMessage( )."..$query**********\n";
				}
			}
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
		
		function SP_GET_ENROLLNO_NAME_CODE($EnrollNo, $passtype)
		{
			if($passtype == 1){
				$MyQuery="SELECT adv_name, adv_code, adv_mobile, email FROM advocate_t AS A 
						  WHERE adv_reg ilike '$EnrollNo%Sr%' AND display = 'Y' AND
						  NOT EXISTS (SELECT 1 FROM gatepass_users AS B WHERE enroll_num ilike '$EnrollNo%Sr%')";
			}
			else{
				$MyQuery="SELECT adv_name, adv_code, adv_mobile, email FROM advocate_t AS A 
						  WHERE lower(adv_reg)=lower('$EnrollNo') AND display = 'Y' AND
						  NOT EXISTS (SELECT 1 FROM gatepass_users AS B WHERE lower(A.adv_reg)=lower(B.enroll_num))";
			}
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function SP_GET_JR_ADV_ENROLLNO_NAME($EnrollNo)
		{
			$MyQuery="SELECT adv_name, adv_mobile FROM advocate_t AS A 
					  WHERE lower(adv_reg)=lower('$EnrollNo') AND display='Y'";
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function SP_CHECK_USER_ENROLLNO_EXISTS_OR_NOT($EnrollNo)
		{
			$MyQuery="SELECT name, contact_num, email, dob FROM gatepass_users WHERE lower(enroll_num)=lower('$EnrollNo')";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function SP_CHECK_USER_EMAILID_EXISTS_OR_NOT($Email)
		{
			$MyQuery="SELECT username, name FROM gatepass_users WHERE (status IS NOT NULL AND status <> '2') AND email='$Email'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_CHECK_USER_MOBILE_EXISTS_OR_NOT($MobileNo)
		{
			$MyQuery="SELECT username, name FROM gatepass_users WHERE (status IS NOT NULL AND status <> '2') AND contact_num='$MobileNo'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_CHECK_USER_MOBILENO_EXISTS_OR_NOT_FOR_DOB($mobileNo, $dob){
			$MyQuery="SELECT id FROM gatepass_users WHERE (status IS NOT NULL AND status <> '2') AND contact_num='$mobileNo' AND dob='$dob'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_RESET_USER_PASSWORD_BY_ID($userId, $NewPwd)
		{
			$MyQuery="UPDATE gatepass_users SET password = '$NewPwd', loginattempt = 0, block = 'N' WHERE id='$userId'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_CHECK_USER_SESSION($user_id, $session_id)
		{
			$MyQuery="SELECT * FROM gatepass_user_session WHERE userid='$user_id' AND session_id='$session_id'";
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_INSERT_USER_SESSION($user_id, $userip, $session_id)
		{
			$MyQuery="INSERT INTO gatepass_user_session (userid, userip, session_id) 
					  VALUES('$user_id', '$userip', '$session_id')";
			
			return $this->Query_inMainDB($MyQuery, $this->bindParamArray);
		}

		function SP_DELETE_USER_SESSION($user_id, $session_id)
		{
			$MyQuery="DELETE FROM gatepass_user_session WHERE userid='$user_id' AND session_id='$session_id'";
			return $this->Query_inMainDB($MyQuery, $this->bindParamArray);
		}

		function SP_UPDATE_USER_LOGIN_ATTEMPT($username, $attempt)
		{
			$MyQuery="UPDATE gatepass_users SET loginattempt=$attempt, block=(CASE WHEN $attempt>=3 THEN 'Y' ELSE 'N' END) WHERE (status IS NOT NULL AND status <> '2') AND lower(username)=lower('$username')";
			
			return $this->Query($MyQuery, $this->bindParamArray);
		}
		
		function UPDATE_ADV_NAME_INSIDE_CASE($type, $no, $year, $cltype, $cldt, $advname)
		{
			if($cltype == 'S'){
				$cltypecon = "B.causelisttype NOT IN ('D', 'W', 'L')";
			}
			else{
				$cltypecon = "B.causelisttype = '$cltype'";
			}
			
			$MyQuery = "SELECT A.cino
						FROM civil_t AS A INNER JOIN causelistsrno AS B ON ((A.case_no=B.case_no AND B.con_case_no IS NULL) OR (A.case_no=B.con_case_no AND B.con_case_no IS NOT NULL))
						WHERE A.regcase_type='$type' AND A.reg_no='$no' AND A.reg_year='$year' AND $cltypecon AND B.causelistdate='$cldt' AND B.isfinalized='Y'";
			
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			
			if(!empty($data)){
				$cino  	 = $data[0]['cino'];
				$userid  = $_SESSION['lawyer']['user_id'];
				$usrname = strtoupper(trim($_SESSION['lawyer']['user_name']));
				
				$advchksql = "SELECT cino, '1' AS tablenm, (CASE WHEN lower(pet_adv)='$advname' THEN 1 WHEN lower(res_adv)='$advname' THEN 2 ELSE 0 END) AS type
								FROM civil_t WHERE cino='$cino' AND (lower(pet_adv)='$advname' OR lower(res_adv)='$advname')
								UNION 
								SELECT cino, '2' AS tablenm, type FROM extra_adv_t WHERE cino='$cino' AND lower(adv_name)='$advname' 
								UNION 
								SELECT cino, '3' AS tablenm, type FROM civ_address_t WHERE display='Y' AND cino='$cino' AND lower(adv_name)='$advname'";

				$chkadv = $this->fetchQuery($advchksql, $this->bindParamArray);
				if(!empty($chkadv)){
					$table = $chkadv[0]['tablenm'];
					$type  = $chkadv[0]['type'];
					
					$advcd 	= '';
					$enroll = strtolower($_SESSION['lawyer']['enroll_no']);
					
					$chkadvsql 	= "SELECT adv_code FROM advocate_t WHERE display='Y' AND lower(adv_reg)='$enroll'";
					$advres 	= $this->fetchQuery($chkadvsql, $this->bindParamArray);
					if(!empty($advres)){
						$advcd = $advres[0]['adv_code'];
					}
					else{
						return 'NA'; exit();
					}
					
					if($table == '1' && $type == '1'){
						$tablename = 'civil_t';
						//$MyQuery="UPDATE civil_t SET pet_adv='$usrname', pet_adv_cd='$advcd' WHERE cino='$cino' AND lower(pet_adv)='$advname'";
					}
					else if($table == '1' && $type == '2'){
						$tablename = 'civil_t';
						//$MyQuery="UPDATE civil_t SET res_adv='$usrname', res_adv_cd='$advcd' WHERE cino='$cino' AND lower(res_adv)='$advname'";
					}
					else if($table == '2'){
						$tablename = 'extra_adv_t';
						//$MyQuery="UPDATE extra_adv_t SET adv_name='$usrname', adv_code='$advcd' WHERE cino='$cino' AND type='$type' AND lower(adv_name)='$advname'";
					}
					else if($table == '3'){
						$tablename = 'civ_address_t';
						//$MyQuery="UPDATE civ_address_t SET adv_name='$usrname', adv_cd='$advcd' WHERE display='Y' AND cino='$cino' AND type='$type' AND lower(adv_name)='$advname'";
					}
					else{
						return 'ERROR'; exit();
					}
					
					//$res = $this->Query($MyQuery, $this->bindParamArray);
					$res = 1;
					
					if($res){
						
						/************** INSERT LOG ***************/
						$updArr['userid'] 	 = $userid;
						$updArr['oldname'] 	 = strtoupper($advname);
						$updArr['newname'] 	 = $usrname;
						$updArr['adv_code']	 = $advcd;
						$updArr['enroll_no'] = strtoupper($enroll);
						$updArr['cino'] 	 = $cino;
						$updArr['tablename'] = $tablename;
						$updArr['adv_type']  = $type;
						$postvalues = json_encode($updArr);
						$this->SP_ADD_USER_LOG($userid, $_SERVER['REMOTE_ADDR'], 'Advocate Name Updated successfully', $postvalues);
						/************** INSERT LOG ***************/
						
						return 'OK'; exit();
					}
					else{
						return 'NU'; exit();
					}
				}
				else{
					return 'GNANE'; exit();
				}
			}
			else{
				return 'CNE'; exit();
			}
		}
		
		function SP_INSERT_USER_DETAILS($username, $name, $email, $pass, $enrollno, $gender, $mobile, $status, $ip, $role, $dob, $address, $state, $district, $pincode, $random, $adv_code, $passtype, $id_type, $id_num, $estt)
		{
			if($passtype == 3){
				$MyQuery="INSERT INTO gatepass_users (username, name, email, password, gender, contact_num, status, ip, role_id, created, dob, address, state, district, pincode, ver_code, adv_code, passtype, id_type, id_num, estt)
				VALUES ('$username', '$name', '$email', '$pass', '$gender', '$mobile', $status, '$ip', $role, NOW(), '$dob', '$address', $state, $district, $pincode, $random, 0, $passtype, '$id_type', '$id_num', '$estt') returning id";
			}
			else{
				$MyQuery="INSERT INTO gatepass_users (username, name, email, password, enroll_num, gender, contact_num, status, ip, role_id, created, dob, address, state, district, pincode, ver_code, adv_code, passtype)
				VALUES ('$username', '$name', '$email', '$pass', '$enrollno', '$gender', '$mobile', $status, '$ip', $role, NOW(), '$dob', '$address', $state, $district, $pincode, $random, $adv_code, $passtype) returning id";
			}
			
			return $this->insertQuery($MyQuery, $this->bindParamArray);
		}
		
		function SP_CHECK_USER_LOGIN($userid)
		{
			$MyQuery = "SELECT id, role_id, name, status, password, enroll_num, adv_code, contact_num, passtype, username, loginattempt, block, oldestpwd, oldpwd, estt FROM gatepass_users WHERE (status IS NOT NULL AND status <> '2') AND lower(username)=lower('$userid')";
			
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
	
		function SP_GET_CASE_TYPE_LIST()
		{
			$MyQuery = "SELECT case_type, type_name FROM case_type_t ORDER BY type_name";
			
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function SP_GET_PURPOSE_OF_VISIST()
		{
			$MyQuery = "SELECT * FROM gatepass_purpose_visit ORDER BY purpose";
			
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_CASE_DETAILS($type, $no, $year, $cltype, $cldt, $cl_dt, $passfor, $party, $advname)
		{
			
			$advcd  = $_SESSION['lawyer']['adv_code'];
			$enroll = $_SESSION['lawyer']['enroll_no'];
			$cltypecon = '';
			$passtype  = $_SESSION['lawyer']['passtype'];
			if($cltype == 'S'){
				$cltypecon = "B.causelisttype NOT IN ('D', 'W', 'L')";
			}
			else{
				$cltypecon = "B.causelisttype = '$cltype'";
			}
			
			$MyQuery = "SELECT A.cino, B.sno, B.croom
						FROM civil_t AS A INNER JOIN causelistsrno AS B ON ((A.case_no=B.case_no AND B.con_case_no IS NULL) OR (A.case_no=B.con_case_no AND B.con_case_no IS NOT NULL))
						WHERE A.regcase_type='$type' AND A.reg_no='$no' AND A.reg_year='$year' AND $cltypecon AND B.causelistdate='$cldt' AND B.isfinalized='Y'";
			//echo $MyQuery; die;
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			$res  = array();
			
			if(!empty($data)){
				$cino  	 = $data[0]['cino'];
				$advcd 	 = $_SESSION['lawyer']['adv_code'];
				$enroll	 = strtolower(trim($_SESSION['lawyer']['enroll_no']));
				$userid  = $_SESSION['lawyer']['user_id'];
				$usrname = strtolower(trim($_SESSION['lawyer']['user_name']));
				
				if(trim($advname) != ''){
					$usrname = strtolower($advname);
				}
				
				/// CHECK PASS GENERATE OR NOT FOR LITIGANTS BY ADVOCATE
				if($passfor == 'L' && $passtype == '2'){
					if($party == '1'){
						$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND passfor='L' AND party_type='1'";
					}
					else{
						$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND adv_code='$advcd' AND passfor='L' AND party_type='2'";
					}
					$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
					
					if(!empty($passchk)){
						$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
						$res[0]['status'] 	  = 'PRTPASSGEN';
						return $res; exit();
					}
				}
				/// CHECK PASS GENERATE OR NOT FOR LITIGANTS BY ADVOCATE
				
				// CHECK PASS GENERATE OR NOT FOR SR. ADV/ ADVOCATE FOR THIS CASE
				if($passfor != 'L' && ($passtype == '1' || $passtype == '2')){
					$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND adv_code='$advcd' AND passfor='S' AND passtype=$passtype";
					$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
					
					if(!empty($passchk)){
						$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
						$res[0]['status'] 	  = 'PASSEXISTS';
						return $res; exit();
					}
				}
				// CHECK PASS GENERATE OR NOT FOR SR. ADV/ ADVOCATE FOR THIS CASE
				
				// CHECK PASS GENERATE OR NOT FOR PARTY IN PERSON FOR THIS CASE
				if($passtype == '3'){
					$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND passfor='S' AND passtype=$passtype AND user_id='$userid'";
					$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
					
					if(!empty($passchk)){
						$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
						$res[0]['status'] 	  = 'PASSEXISTS';
						return $res; exit();
					}
				}
				// CHECK PASS GENERATE OR NOT FOR PARTY IN PERSON FOR THIS CASE

				//////// IF SR. ADVOCATE/ PARTY IN PERSON THEN GO BACK ////////
				if($_SESSION['lawyer']['passtype'] == '1' || $_SESSION['lawyer']['passtype'] == '3'){
					$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
					$res[0]['status'] 	 = 'OK';
					
					$res[1]['cino']  = $data[0]['cino'];
					$res[1]['sno'] 	 = $data[0]['sno'];
					$res[1]['croom'] = $data[0]['croom'];
					$res[1]['type']  = '0';
					
					return $res; exit();
				}
				//////// IF SR. ADVOCATE/ PARTY IN PERSON THEN GO BACK ////////
				
				if($_SESSION['lawyer']['passtype'] == '2'){
					/*********** CHECK ADVOCATE NAME **************/
					$advchksql = "SELECT cino, (CASE WHEN lower(pet_adv)='$usrname' THEN 1 WHEN lower(res_adv)='$usrname' THEN 2 ELSE 0 END) AS type
								FROM civil_t WHERE cino='$cino' AND (lower(pet_adv)='$usrname' OR lower(res_adv)='$usrname')
								UNION 
								SELECT cino, type FROM extra_adv_t WHERE cino='$cino' AND lower(adv_name)='$usrname' 
								UNION 
								SELECT cino, type FROM civ_address_t WHERE display='Y' AND cino='$cino' AND lower(adv_name)='$usrname'";

					$chkadv = $this->fetchQuery($advchksql, $this->bindParamArray);
					/*********** CHECK ADVOCATE NAME **************/
					if(empty($chkadv))
					{
						/*********** CHECK ADVOCATE ENROLLEMENT NO. **************/
						$advcdchksql = "SELECT A.cino, 1 AS type FROM civil_t AS A
									INNER JOIN advocate_t AS B ON A.pet_adv_cd=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll'
									UNION
									SELECT A.cino, 2 AS type FROM civil_t AS A
									INNER JOIN advocate_t AS B ON A.res_adv_cd=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll'
									UNION 
									SELECT A.cino, A.type FROM extra_adv_t AS A
									INNER JOIN advocate_t AS B ON A.adv_code=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll'
									UNION 
									SELECT A.cino, A.type FROM civ_address_t AS A
									INNER JOIN advocate_t AS B ON A.adv_cd=B.adv_code AND B.display='Y'
									WHERE A.display='Y' AND A.cino='$cino' AND lower(B.adv_reg)='$enroll'";

						$chkadvcd = $this->fetchQuery($advcdchksql, $this->bindParamArray);
						/*********** CHECK ADVOCATE ENROLLEMENT NO. **************/
						
						if(empty($chkadvcd)){
							$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
							$res[0]['status'] 	  = 'ADVNA';
							return $res; exit();
						}
						else{
							$chkadv[0]['type'] = $chkadvcd[0]['type'];
						}
					}
					
					$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
					$res[0]['status'] 	 = 'OK';
					
					if(trim($passfor) == 'L'){
						if($party == '1'){
							$prtychksql = "SELECT 0 AS party_no, pet_name AS party_nm
								FROM civil_t WHERE cino='$cino' AND lower(pet_adv)='$usrname'
								UNION
								SELECT party_no, name AS party_nm FROM civ_address_t
								WHERE display='Y' AND cino='$cino' AND type='$party' AND lower(adv_name)='$usrname'
								UNION
								SELECT party_no, pet_res AS party_nm
								FROM extra_adv_t
								WHERE cino='$cino' AND type='$party' AND lower(adv_name)='$usrname'";
						}
						else if($party == '2'){
							$prtychksql = "SELECT 0 AS party_no, res_name AS party_nm
								FROM civil_t WHERE cino='$cino' AND lower(res_adv)='$usrname'
								UNION
								SELECT party_no, name AS party_nm FROM civ_address_t
								WHERE display='Y' AND cino='$cino' AND type='$party' AND lower(adv_name)='$usrname'
								UNION
								SELECT party_no, pet_res AS party_nm
								FROM extra_adv_t
								WHERE cino='$cino' AND type='$party' AND lower(adv_name)='$usrname'";
						}
						$partyres = $this->fetchQuery($prtychksql, $this->bindParamArray);
						
						if(!empty($partyres)){
							$res[1]['party_no'] = '';
							$res[1]['party_nm'] = '';
							$i=1;
							foreach($partyres as $row){
								$res[$i]['party_no'] = $row['party_no'];
								$res[$i]['party_nm'] = $row['party_nm'];
								$i++;
							}
						}
						else{
							if($party == '1'){
								$prtychksql = "SELECT 0 AS party_no, pet_name AS party_nm
									FROM civil_t AS A
									INNER JOIN advocate_t AS B ON A.pet_adv_cd=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll'
									UNION
									SELECT party_no, name AS party_nm FROM civ_address_t AS A
									INNER JOIN advocate_t AS B ON A.adv_cd=B.adv_code AND B.display='Y'
									WHERE A.display='Y' AND A.cino='$cino' AND lower(B.adv_reg)='$enroll' AND A.type='$party'
									UNION
									SELECT party_no, pet_res AS party_nm
									FROM extra_adv_t AS A
									INNER JOIN advocate_t AS B ON A.adv_code=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll' AND A.type='$party'";
							}
							else if($party == '2'){
								$prtychksql = "SELECT 0 AS party_no, res_name AS party_nm
									FROM civil_t AS A
									INNER JOIN advocate_t AS B ON A.res_adv_cd=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll'
									UNION
									SELECT party_no, name AS party_nm FROM civ_address_t AS A
									INNER JOIN advocate_t AS B ON A.adv_cd=B.adv_code AND B.display='Y'
									WHERE A.display='Y' AND A.cino='$cino' AND lower(B.adv_reg)='$enroll' AND A.type='$party'
									UNION
									SELECT party_no, pet_res AS party_nm
									FROM extra_adv_t AS A
									INNER JOIN advocate_t AS B ON A.adv_code=B.adv_code AND B.display='Y'
									WHERE A.cino='$cino' AND lower(B.adv_reg)='$enroll' AND A.type='$party'";
							}
							$partyres = $this->fetchQuery($prtychksql, $this->bindParamArray);
							
							if(!empty($partyres)){
								$res[1]['party_no'] = '';
								$res[1]['party_nm'] = '';
								$i=1;
								foreach($partyres as $row){
									$res[$i]['party_no'] = $row['party_no'];
									$res[$i]['party_nm'] = $row['party_nm'];
									$i++;
								}
							}
							else{
								$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
								$res[0]['status'] 	  = 'PNE';
								return $res; exit();
							}
						}
					}
					
					$res[1]['cino']  = $data[0]['cino'];
					$res[1]['sno'] 	 = $data[0]['sno'];
					$res[1]['croom'] = $data[0]['croom'];						
					$res[1]['type']  = $chkadv[0]['type'];
				}
			}
			else{
				$res[0]['csrftoken'] = $_SESSION['lawyer']['CSRF_Token'];
				$res[0]['status'] 	  = 'CASENA';
				return $res; exit();
			}
			return $res;
		}
		
		function SP_GENERATE_ADV_PASS($cino, $adv_type, $cldt, $cltype, $courtno, $itemno, $paddress, $party, $passfor, $partyno, $partynm, $partymob)
		{
			$passNo = $cltype.str_replace('/', '', $cldt).$courtno.$itemno.date('His');
			$advcd  = $_SESSION['lawyer']['adv_code'];
			$enroll = $_SESSION['lawyer']['enroll_no'];
			$userid = $_SESSION['lawyer']['user_id'];
			$userip = $_SERVER['REMOTE_ADDR'];
			$cl_dt  = implode('-', array_reverse(explode('/', trim($cldt))));
			$passtype = $_SESSION['lawyer']['passtype'];
			
			// CHECK PASS GENERATE OR NOT FOR ADVOCATE
			/* $sqlchk = "SELECT pass_no FROM gatepass_details WHERE causelist_dt='$cl_dt' AND adv_code='$advcd'";
			$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
			
			if(!empty($passchk)){
				return 'PASSGENDT'; die;
			} */
			// CHECK PASS GENERATE OR NOT FOR ADVOCATE
			
			/// CHECK PASS GENERATE OR NOT FOR LITIGANTS BY ADVOCATE
			if($passfor == 'L' && $passtype == '2'){
				if($party == '1'){
					$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND passfor='L' AND party_type='1' AND passtype=$passtype";
				}
				else{
					$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND adv_code='$advcd' AND passfor='L' AND party_type='2' AND passtype=$passtype";
				}
				
				$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
				
				if(!empty($passchk)){
					return "PRTPASSGEN##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
				
				$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND party_no='$partyno' AND passfor='L' AND party_type='2' AND passtype=$passtype";
				$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
				
				if(!empty($passchk)){
					return "PPASSEXISTS##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
			}
			/// CHECK PASS GENERATE OR NOT FOR LITIGANTS BY ADVOCATE
			
			// CHECK PASS GENERATE OR NOT FOR SR. ADV/ ADVOCATE FOR THIS CASE
			if($passfor != 'L' && ($passtype == '1' || $passtype == '2')){
				$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND adv_code='$advcd' AND passfor='S' AND passtype=$passtype";
				$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
				
				if(!empty($passchk)){
					return "PASSEXISTS##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
			}
			// CHECK PASS GENERATE OR NOT FOR SR. ADV/ ADVOCATE FOR THIS CASE
			
			// CHECK PASS GENERATE OR NOT FOR PARTY IN PERSON FOR THIS CASE
			if($passtype == '3'){
				$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND passfor='S' AND passtype=$passtype AND user_id='$userid'";
				$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
				
				if(!empty($passchk)){
					return "PASSEXISTS##".$_SESSION['lawyer']['CSRF_Token']; exit();
				}
			}
			// CHECK PASS GENERATE OR NOT FOR PARTY IN PERSON FOR THIS CASE
				
			// CHECK PASS MAX PET ADV LIMIT
			if($adv_type == '1' && $passfor != 'L'){
				$sqlchk = "SELECT pass_no FROM gatepass_details WHERE cino='$cino' AND causelist_dt='$cl_dt' AND causelist_type='$cltype' AND adv_type='$adv_type' AND passfor='S' AND passtype=$passtype";
				$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
				
				if(!empty($passchk)){
					if(count($passchk) >= 2){
						return "PET2PASS##".$_SESSION['lawyer']['CSRF_Token']; exit();
					}
				}
			}
			// CHECK PASS MAX PET ADV LIMIT
			
			if($passfor == 'L' && $passtype == '2'){
				$dbmobile = $this->getEncryptValue($partymob);
				
				$MyQuery="INSERT INTO gatepass_details(cino, causelist_dt, causelist_type, court_no, item_no, pass_no, adv_enroll, user_id, user_ip, entry_dt, adv_code, paddress, adv_type, party_no, party_mob_no, party_type, passfor, party_name, passtype) VALUES('$cino', '$cl_dt', '$cltype', '$courtno', '$itemno', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$advcd', '$paddress', '$adv_type', $partyno, '$dbmobile', $party, '$passfor', '$partynm', $passtype) returning id";
			}
			else if($passtype == '1' || ($passfor != 'L' && $passtype == '2')){
				$MyQuery="INSERT INTO gatepass_details(cino, causelist_dt, causelist_type, court_no, item_no, pass_no, adv_enroll, user_id, user_ip, entry_dt, adv_code, paddress, adv_type, passfor, passtype) VALUES('$cino', '$cl_dt', '$cltype', '$courtno', '$itemno', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$advcd', '$paddress', '$adv_type', 'S', $passtype) returning id";
			}
			else if($passtype == '3'){
				$partynm = trim($_SESSION['lawyer']['user_name']);
				$MyQuery="INSERT INTO gatepass_details(cino, causelist_dt, causelist_type, court_no, item_no, pass_no, user_id, user_ip, entry_dt, paddress, passfor, party_name, passtype) VALUES('$cino', '$cl_dt', '$cltype', '$courtno', '$itemno', '$passNo', '$userid', '$userip', NOW(), '$paddress', 'S', '$partynm', $passtype) returning id";
			}
			else{
				return "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			
			$data = $this->insertQuery($MyQuery, $this->bindParamArray);
			
			if($passfor == 'L'){
				$name = $partynm;
				$adv = $_SESSION['lawyer']['user_name'];
				$mobile = $partymob;
			}
			else{
				$name = $_SESSION['lawyer']['user_name'];
				$mobile = $_SESSION['lawyer']['mobile'];
			}
				
			if($data){
				$estt = $_SESSION['lawyer']['connection'] == 'P' ? 'RHC Jodhpur' : 'RHCB Jaipur';
				
				// SEND PASS DETAIL TO ADVOCATE
				if($passfor == 'L' && $passtype == '2'){
					$dlt_template_id = '1107160033871933476';
					$message = "Entry pass issued for $name recommended by $adv, Advocate is valid for case hearing on $cldt only in Court No. $courtno Item No. $itemno at $estt.";
				}
				else if($passtype == '1'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Sr. Advocate is valid for case hearing on $cldt only in $estt.";
				}
				else if($passtype == '2'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Advocate is valid for case hearing on $cldt only in $estt.";
				}
				else if($passtype == '3'){
					$idres = $this->GET_PIP_ID_DETAILS($_SESSION['lawyer']['user_id']);
					if(!empty($idres)){
						$idno = $this->getDecryptValue($idres[0]['id_num']);
					}
					else{
						$idno = '';
					}
					$dlt_template_id = '1107160033876072976';
					$message = "Entry pass issued for $name ($idno) is valid for case hearing on $cldt only in Court No. $courtno Item No. $itemno at $estt.";
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

				$dbmobile = $this->getEncryptValue($mobile);
				$MyQuery="INSERT INTO gatepass_sms_details(cino, causelist_dt, causelist_type, pass_no, adv_enroll, user_id, user_ip, entry_dt, mobile) VALUES('$cino', '$cl_dt', '$cltype', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$dbmobile')";
				$res = $this->Query($MyQuery, $this->bindParamArray);
				
				return "OK##".$_SESSION['lawyer']['CSRF_Token'].'##'.$data[0]['id']; exit();
			}
			else{
				return "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		
		function SEND_PASS_DETAILS_ADV($passid, $passval)
		{
			$advcd  = $_SESSION['lawyer']['adv_code'];
			$enroll = $_SESSION['lawyer']['enroll_no'];
			$userid = $_SESSION['lawyer']['user_id'];			
			$userip = $_SERVER['REMOTE_ADDR'];
			$mobile = $_SESSION['lawyer']['mobile'];
			$name   = $_SESSION['lawyer']['user_name'];
			
			$estt   = $_SESSION['lawyer']['connection'] == 'P' ? 'RHC Jodhpur' : 'RHCB Jaipur';
			
			// CHECK PASS GENERATE OR NOT FOR ADVOCATE
			if($passval == 'C'){
				$sqlchk = "SELECT pass_no, cino, causelist_dt, causelist_type, passfor, passtype, party_mob_no, party_name, court_no, item_no FROM gatepass_details WHERE id='$passid'";
			}
			else if($passval == 'S'){
				$sqlchk = "SELECT pass_no, pass_dt, passtype FROM gatepass_details_section WHERE id='$passid'";
			}
			
			$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
			
			if(empty($passchk)){
				return "NEXISTS##".$_SESSION['lawyer']['CSRF_Token'];
			}
			// CHECK PASS GENERATE OR NOT FOR ADVOCATE
			if($passval == 'C'){
				$cino 	= $passchk[0]['cino'];
				$cl_dt 	= $passchk[0]['causelist_dt'];
				$cltype = $passchk[0]['causelist_type'];
				$passNo = $passchk[0]['pass_no'];
				$cldt	= implode('/', array_reverse(explode('-', trim($cl_dt))));
				$courtno = $passchk[0]['court_no'];
				$itemno	 = $passchk[0]['item_no'];
				$passfor = $passchk[0]['passfor'];
				$passtype = $passchk[0]['passtype'];
	
				if($passfor == 'L' && $passtype == '2'){
					$mobile = $this->getDecryptValue($passchk[0]['party_mob_no']);
					$name = $passchk[0]['party_name'];
					$adv = $_SESSION['lawyer']['user_name'];	 
				}
				
				// SEND PASS DETAIL TO ADVOCATE
				if($passfor == 'L' && $passtype == '2'){
					$dlt_template_id = '1107160033871933476';
					$message = "Entry pass issued for $name recommended by $adv, Advocate is valid for case hearing on $cldt only in Court No. $courtno Item No. $itemno at $estt.";
				}
				else if($passtype == '1'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Sr. Advocate is valid for case hearing on $cldt only in $estt.";
				}
				else if($passtype == '2'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Advocate is valid for case hearing on $cldt only in $estt.";
				}
				else if($passtype == '3'){
					$idres = $this->GET_PIP_ID_DETAILS($_SESSION['lawyer']['user_id']);
					if(!empty($idres)){
						$idno = $this->getDecryptValue($idres[0]['id_num']);
					}
					else{
						$idno = '';
					}
					$dlt_template_id = '1107160033876072976';
					$message = "Entry pass issued for $name ($idno) is valid for case hearing on $cldt only in Court No. $courtno Item No. $itemno at $estt.";
				}
			}
			else if($passval == 'S'){
				$cino 	= '-';
				$cl_dt 	= $passchk[0]['pass_dt'];
				$cltype = '-';
				$passNo = $passchk[0]['pass_no'];
				$cldt	= implode('/', array_reverse(explode('-', trim($cl_dt))));
				$passtype = $passchk[0]['passtype'];
				
				if($passtype == '1'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Sr. Advocate is valid for Ancillary Purposes other than court hearing on $cldt only in $estt.";
				}
				else if($passtype == '2'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Advocate is valid for Ancillary Purposes other than court hearing on $cldt only in $estt.";
				}
				else if($passtype == '3'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Party-in-Person is valid for Ancillary Purposes other than court hearing on $cldt only in $estt.";
				}
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

			$dbmobile = $this->getEncryptValue($mobile);
			$MyQuery="INSERT INTO gatepass_sms_details(cino, causelist_dt, causelist_type, pass_no, adv_enroll, user_id, user_ip, entry_dt, mobile) VALUES('$cino', '$cl_dt', '$cltype', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$dbmobile')";
			$data = $this->Query($MyQuery, $this->bindParamArray);

			return "OK##".$_SESSION['lawyer']['CSRF_Token'];
		}
		
		function GET_PASS_DETAILS_FOR_PDF($passid)
		{
			$MyQuery="SELECT A.pass_no, to_char(A.causelist_dt, 'DD/MM/YYYY') AS cl_dt, A.passfor, A.court_no,
					to_char(A.entry_dt, 'DD/MM/YYYY') AS gen_dt, B.pet_name, B.res_name, A.paddress, item_no,
					B.reg_no, B.reg_year, C.type_name, B.pet_adv, B.res_adv, A.passfor, A.party_name
					FROM gatepass_details AS A INNER JOIN civil_t AS B ON A.cino=B.cino
					INNER JOIN case_type_t AS C ON B.regcase_type=C.case_type
					WHERE A.id='$passid'";
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_PIP_PASS_DETAILS_FOR_PDF($passid)
		{
			$MyQuery="SELECT A.pass_no, to_char(A.causelist_dt, 'DD/MM/YYYY') AS cl_dt, A.passfor, A.court_no,
					to_char(A.entry_dt, 'DD/MM/YYYY') AS gen_dt, B.pet_name, B.res_name, A.paddress, item_no,
					B.reg_no, B.reg_year, C.type_name, B.pet_adv, B.res_adv, A.passfor, A.party_name
					FROM gatepass_details AS A INNER JOIN civil_t AS B ON A.cino=B.cino
					INNER JOIN case_type_t AS C ON B.regcase_type=C.case_type
					WHERE A.id='$passid'";
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_PIP_ID_DETAILS($userid)
		{
			$MyQuery="SELECT A.id_num, B.type FROM gatepass_users AS A INNER JOIN gatepass_id_mst AS B ON A.id_type=B.id WHERE A.id='$userid'";
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function GET_GENERATED_PASS_BY_ADV($fromdt, $todt, $passval)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			$usrid = $_SESSION['lawyer']['user_id'];

			if($passval == 'C'){
				$MyQuery="SELECT A.pass_no, to_char(A.causelist_dt, 'DD/MM/YYYY') AS cl_dt, (CASE WHEN A.causelist_type='D' THEN 'Daily' WHEN A.causelist_type='W' THEN 'Weekly' WHEN A.causelist_type='L' THEN 'Regular' ELSE 'Supplementary' END) AS cl_type, to_char(A.entry_dt::date, 'DD/MM/YYYY') AS entry_dt, B.pet_name, B.res_name, A.id, B.reg_no, B.reg_year, C.type_name, A.passfor, A.party_name, A.party_mob_no, A.passfor
					FROM gatepass_details AS A INNER JOIN civil_t AS B ON A.cino=B.cino
					INNER JOIN case_type_t AS C ON C.case_type=B.regcase_type
					WHERE A.entry_dt::date>='$fromdt' AND A.entry_dt::date<='$todt' AND A.user_id='$usrid'
					ORDER BY A.causelist_dt DESC, B.reg_no, B.reg_year, C.type_name";
			}
			else if($passval == 'S'){
				$MyQuery="SELECT A.pass_no, to_char(A.pass_dt, 'DD/MM/YYYY') AS pass_dt, to_char(A.entry_dt::date, 'DD/MM/YYYY') AS entry_dt, A.id, A.purposermks
					FROM gatepass_details_section AS A
					WHERE A.entry_dt::date>='$fromdt' AND A.entry_dt::date<='$todt' AND A.userid='$usrid'
					ORDER BY A.pass_dt DESC";
			}
			
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SEARCH_PARTY_SIGN_REQUEST($fromdt, $todt)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			if($_SESSION['lawyer']['estt'] == 'B'){
				$MyQuery="SELECT B.state_name, C.district_name, A.name, A.email, A.contact_num, A.address, A.pincode, to_char(A.dob, 'dd/mm/yyyy') AS dob_str, A.id, D.type AS idtype, A.id_num, A.ver_code
					FROM gatepass_users AS A
					INNER JOIN states_mst AS B ON A.state=B.id
					INNER JOIN districts_mst AS C ON A.district=C.id
					LEFT JOIN gatepass_id_mst AS D ON A.id_type=D.id
					WHERE A.created::date>='$fromdt' AND A.created::date<='$todt' AND A.status='0' AND A.passtype='3' AND A.estt='B'
					ORDER BY A.created";
			}
			else if($_SESSION['lawyer']['estt'] == 'P'){
				$MyQuery="SELECT B.state_name, C.district_name, A.name, A.email, A.contact_num, A.address, A.pincode, to_char(A.dob, 'dd/mm/yyyy') AS dob_str, A.id, D.type AS idtype, A.id_num, A.ver_code
					FROM gatepass_users AS A
					INNER JOIN states_mst AS B ON A.state=B.id
					INNER JOIN districts_mst AS C ON A.district=C.id
					LEFT JOIN gatepass_id_mst AS D ON A.id_type=D.id
					WHERE A.created::date>='$fromdt' AND A.created::date<='$todt' AND A.status='0' AND A.passtype='3' AND A.estt='P'
					ORDER BY A.created";
			}
			else{
				header('Location:my-logout.php');
			}
			
			//echo $MyQuery; die;
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SEARCH_PARTY_SIGN_REQUEST_AR($fromdt, $todt)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			if($_SESSION['lawyer']['estt'] == 'B'){
				$MyQuery="SELECT B.state_name, C.district_name, A.name, A.email, A.contact_num, A.address, A.pincode, to_char(A.dob, 'dd/mm/yyyy') AS dob_str, A.id, D.type AS idtype, (CASE WHEN A.status = '1' THEN 'Approved' WHEN A.status = '2' THEN 'Rejected' ELSE '' END) AS pstatus, A.id_num, A.ver_code, A.remark
					FROM gatepass_users AS A
					INNER JOIN states_mst AS B ON A.state=B.id
					INNER JOIN districts_mst AS C ON A.district=C.id
					LEFT JOIN gatepass_id_mst AS D ON A.id_type=D.id
					WHERE A.created::date>='$fromdt' AND A.created::date<='$todt' AND (A.status IS NOT NULL AND A.status <> '0') AND A.passtype='3' AND A.estt='B'
					ORDER BY A.created";
			}
			else if($_SESSION['lawyer']['estt'] == 'P'){
				$MyQuery="SELECT B.state_name, C.district_name, A.name, A.email, A.contact_num, A.address, A.pincode, to_char(A.dob, 'dd/mm/yyyy') AS dob_str, A.id, D.type AS idtype, (CASE WHEN A.status = '1' THEN 'Approved' WHEN A.status = '2' THEN 'Rejected' ELSE '' END) AS pstatus, A.id_num, A.ver_code, A.remark
					FROM gatepass_users AS A
					INNER JOIN states_mst AS B ON A.state=B.id
					INNER JOIN districts_mst AS C ON A.district=C.id
					LEFT JOIN gatepass_id_mst AS D ON A.id_type=D.id
					WHERE A.created::date>='$fromdt' AND A.created::date<='$todt' AND (A.status IS NOT NULL AND A.status <> '0') AND A.passtype='3' AND A.estt='P'
					ORDER BY A.created";
			}
			else{
				header('Location:my-logout.php');
			}
			
			//echo $MyQuery; die;
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_REGISTER_USERS_COUNT($fromdt, $todt, $srchby)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			if($srchby == '1'){
				// passes and registration count
				$MyQuery="SELECT * FROM (
							SELECT created::date AS regdate, passtype, 'S' AS passfor, 1 AS report, count(*) AS count
							FROM gatepass_users AS A
							WHERE created::date>='$fromdt' AND created::date<='$todt' AND passtype IN (1, 2, 3)
							GROUP BY created::date, passtype, passfor
							UNION
							SELECT entry_dt::date AS regdate, passtype, passfor, 2 AS report, count(*) AS count
							FROM gatepass_details AS A
							WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
							GROUP BY entry_dt::date, passtype, passfor
							
							UNION
							
							SELECT entry_dt::date AS regdate, passtype, 'S' as passfor, 3 AS report, count(*) AS count
							FROM gatepass_details_section AS A
							WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
							GROUP BY entry_dt::date, passtype, passfor
						) AS A
						ORDER BY regdate, passtype, report";
			}
			else if($srchby == '2'){
				// passes only
				$MyQuery="SELECT * FROM (
							SELECT causelist_dt AS regdate, passtype, passfor, 2 AS report, count(*) AS count
							FROM gatepass_details AS A
							WHERE causelist_dt>='$fromdt' AND causelist_dt<='$todt' AND passtype IN (1, 2, 3)
							GROUP BY causelist_dt, passtype, passfor
							
							UNION
							
							SELECT pass_dt AS regdate, passtype, 'S' as passfor, 3 AS report, count(*) AS count
							FROM gatepass_details_section AS A
							WHERE pass_dt>='$fromdt' AND pass_dt<='$todt' AND passtype IN (1, 2, 3)
							GROUP BY pass_dt, passtype, passfor
						) AS A
						ORDER BY regdate, passtype, report";
			}
			
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_REGISTER_USERS_COUNT_JDP($fromdt, $todt, $srchby)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}
			
			if($srchby == '1'){
				// passes and registration count
				$MyQuery="SELECT * FROM (
								SELECT entry_dt::date AS regdate, passtype, passfor, 2 AS report, count(*) AS count
								FROM gatepass_details AS A
								WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
								GROUP BY entry_dt::date, passtype, passfor
								
								UNION
								
								SELECT entry_dt::date AS regdate, passtype, 'S' as passfor, 3 AS report, count(*) AS count
								FROM gatepass_details_section AS A
								WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
								GROUP BY entry_dt::date, passtype, passfor
							) AS A
							ORDER BY regdate, passtype, report";
			}
			else if($srchby == '2'){
				// passes count only
				$MyQuery="SELECT * FROM (
								SELECT causelist_dt AS regdate, passtype, passfor, 2 AS report, count(*) AS count
								FROM gatepass_details AS A
								WHERE causelist_dt>='$fromdt' AND causelist_dt<='$todt' AND passtype IN (1, 2, 3)
								GROUP BY causelist_dt, passtype, passfor
								
								UNION
								
								SELECT pass_dt AS regdate, passtype, 'S' as passfor, 3 AS report, count(*) AS count
								FROM gatepass_details_section AS A
								WHERE pass_dt>='$fromdt' AND pass_dt<='$todt' AND passtype IN (1, 2, 3)
								GROUP BY pass_dt, passtype, passfor
							) AS A
							ORDER BY regdate, passtype, report";
			}
			
			$data = $this->fetchQuery_inJDPDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_REGISTER_PASSESS_COUNT($fromdt, $todt, $searchby)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			if($searchby == 1)
				$MyQuery="SELECT * FROM (SELECT count(*) AS count, 0 as passtype, 'S' as passfor, 'total' as remark, 0 AS report 
						FROM gatepass_users
						WHERE created::date>='$fromdt' AND created::date<='$todt' AND passtype IN (1, 2, 3)
						UNION
						SELECT count(*) AS count, passtype, 'S' as passfor, 'type' as remark, 0 AS report FROM gatepass_users
						WHERE created::date>='$fromdt' AND created::date<='$todt' AND passtype IN (1, 2, 3)
						GROUP BY passtype
						UNION 
						SELECT count(*) AS count, 0 as passtype, 'S' as passfor, 'total' as remark, 1 AS report FROM gatepass_details
						WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
						UNION
						SELECT count(*) AS count, passtype, passfor, 'type' as remark, 1 AS report FROM gatepass_details
						WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
						GROUP BY passtype, passfor) AS A
						ORDER BY report, passtype";
			else if($searchby == 2)
				$MyQuery="SELECT * FROM (SELECT count(*) AS count, 0 as passtype, 'S' as passfor, 'total' as remark, 0 AS report 
						FROM gatepass_users
						WHERE created::date>='$fromdt' AND created::date<='$todt' AND passtype IN (1, 2, 3)
						UNION
						SELECT count(*) AS count, passtype, 'S' as passfor, 'type' as remark, 0 AS report FROM gatepass_users
						WHERE created::date>='$fromdt' AND created::date<='$todt' AND passtype IN (1, 2, 3)
						GROUP BY passtype
						UNION 
						SELECT count(*) AS count, 0 as passtype, 'S' as passfor, 'total' as remark, 1 AS report FROM gatepass_details
						WHERE causelist_dt::date>='$fromdt' AND causelist_dt::date<='$todt' AND passtype IN (1, 2, 3)
						UNION
						SELECT count(*) AS count, passtype, passfor, 'type' as remark, 1 AS report FROM gatepass_details
						WHERE causelist_dt::date>='$fromdt' AND causelist_dt::date<='$todt' AND passtype IN (1, 2, 3)
						GROUP BY passtype, passfor) AS A
						ORDER BY report, passtype";
			//echo $MyQuery; die;
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_REGISTER_PASSESS_COUNT_JDP($fromdt, $todt, $searchby)
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			if($searchby == 1)
				$MyQuery="SELECT * FROM (
						SELECT count(*) AS count, 0 as passtype, 'S' as passfor, 'total' as remark, 1 AS report FROM gatepass_details
						WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
						UNION
						SELECT count(*) AS count, passtype, passfor, 'type' as remark, 1 AS report FROM gatepass_details
						WHERE entry_dt::date>='$fromdt' AND entry_dt::date<='$todt' AND passtype IN (1, 2, 3)
						GROUP BY passtype, passfor) AS A
						ORDER BY report, passtype";
			else if($searchby == 2)
				$MyQuery="SELECT * FROM (
						SELECT count(*) AS count, 0 as passtype, 'S' as passfor, 'total' as remark, 1 AS report FROM gatepass_details
						WHERE causelist_dt::date>='$fromdt' AND causelist_dt::date<='$todt' AND passtype IN (1, 2, 3)
						UNION
						SELECT count(*) AS count, passtype, passfor, 'type' as remark, 1 AS report FROM gatepass_details
						WHERE causelist_dt::date>='$fromdt' AND causelist_dt::date<='$todt' AND passtype IN (1, 2, 3)
						GROUP BY passtype, passfor) AS A
						ORDER BY report, passtype";
			
			$data = $this->fetchQuery_inJDPDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function SEARCH_BLOCKED_USER_ACCOUNT()
		{
			if(!isset($_SESSION['lawyer']['user_id']) || $_SESSION['lawyer']['user_id'] == ''){
				return 'INDEX'; exit();
			}

			if($_SESSION['lawyer']['estt'] == 'B'){
				$MyQuery="SELECT B.state_name, C.district_name, A.name, A.email, A.contact_num, A.address, A.pincode, to_char(A.dob, 'dd/mm/yyyy') AS dob_str, A.id
					FROM gatepass_users AS A
					INNER JOIN states_mst AS B ON A.state=B.id
					INNER JOIN districts_mst AS C ON A.district=C.id
					WHERE A.status IS NOT NULL AND A.status = '1' AND loginattempt >=3 AND block='Y' AND A.estt='B'
					ORDER BY A.name";
			}
			else if($_SESSION['lawyer']['estt'] == 'P'){
				$MyQuery="SELECT B.state_name, C.district_name, A.name, A.email, A.contact_num, A.address, A.pincode, to_char(A.dob, 'dd/mm/yyyy') AS dob_str, A.id
					FROM gatepass_users AS A
					INNER JOIN states_mst AS B ON A.state=B.id
					INNER JOIN districts_mst AS C ON A.district=C.id
					WHERE A.status IS NOT NULL AND A.status = '1' AND loginattempt >=3 AND block='Y' AND A.estt='P'
					ORDER BY A.name";
			}
			else{
				header('Location:my-logout.php');
			}
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function UNBLOCK_USER_ACCOUNT($dataid)
		{
			$MyQuery="UPDATE gatepass_users SET status='1', loginattempt='0', block='N' WHERE id='$dataid'";
			return $this->Query_inMainDB($MyQuery, $this->bindParamArray);
		}

		function APPROVE_REJECT_PARTY_REQUEST($dataid, $action, $remark)
		{
			$MyQuery="UPDATE gatepass_users SET status='$action', remark='$remark' WHERE id='$dataid'";
			return $this->Query_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function SP_GET_USER_PASSWORD_BY_USER_ID($UserId)
		{
			$MyQuery="SELECT password, oldpwd, oldestpwd FROM gatepass_users WHERE id='$UserId'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function SP_ADD_USER_LOG($userid, $userip, $action, $postvalues)
		{
			$MyQuery="INSERT INTO gatepass_audit_trail(userid, userip, action, postvalues, timestamp) VALUES('$userid', '$userip', '$action', '$postvalues', NOW())";
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_GET_STATE_LIST()
		{
			$MyQuery="SELECT id, state_name FROM states_mst ORDER BY state_name";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}		

		function SP_GET_DISTRICT_LIST($stateval)
		{
			$MyQuery="SELECT id, district_name FROM districts_mst WHERE states_id=$stateval ORDER BY district_name";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_UPDATE_USER_PASSWORD_WITH_OLD_PWD($UserId, $NewPwd)
		{
			$MyQuery="UPDATE gatepass_users SET password='$NewPwd', oldpwd=password, oldestpwd=oldpwd, loginattempt = 0, block = 'N' WHERE id='$UserId'";
			return $this->Query_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function GENERATE_ADV_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks)
		{
			$passNo = str_replace('/', '', $pass_dt).date('His');
			$advcd  = $_SESSION['lawyer']['adv_code'];
			$enroll = strtoupper($_SESSION['lawyer']['enroll_no']);
			$userid = $_SESSION['lawyer']['user_id'];
			$userip = $_SERVER['REMOTE_ADDR'];
			$passtype = $_SESSION['lawyer']['passtype'];
			
			// CHECK PASS GENERATE OR NOT FOR SR. ADV/ ADVOCATE FOR THIS CASE
			$sqlchk = "SELECT pass_no FROM gatepass_details_section WHERE pass_dt='$passdt' AND adv_cd='$advcd' AND passtype=$passtype";
			$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
			
			if(!empty($passchk)){
				return "PASSEXISTS##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			// CHECK PASS GENERATE OR NOT FOR SR. ADV/ ADVOCATE FOR THIS CASE
			
			$MyQuery="INSERT INTO gatepass_details_section(pass_dt, userid, userip, adv_cd, entry_dt, purpose_of_visit, passtype, pass_no, enroll_no, purposermks) VALUES('$passdt', '$userid', '$userip', '$advcd', NOW(), '$vist_purpose', $passtype, '$passNo', '$enroll', '$purposermks') returning id";
			
			$data = $this->insertQuery($MyQuery, $this->bindParamArray);
			
			$name	= $_SESSION['lawyer']['user_name'];
			$mobile = $_SESSION['lawyer']['mobile'];
				
			if($data){
				$estt = $_SESSION['lawyer']['connection'] == 'P' ? 'RHC Jodhpur' : 'RHCB Jaipur';
				
				// SEND PASS DETAIL TO ADVOCATE
				if($passtype == '1'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Sr. Advocate is valid for Ancillary Purposes other than court hearing on $pass_dt only in $estt.";
				}
				else if($passtype == '2'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Advocate is valid for Ancillary Purposes other than court hearing on $pass_dt only in $estt.";
				}
				else if($passtype == '3'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Party-in-Person is valid for Ancillary Purposes other than court hearing on $pass_dt only in $estt.";
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

				$dbmobile = $this->getEncryptValue($mobile);
				$MyQuery="INSERT INTO gatepass_sms_details(cino, causelist_dt, causelist_type, pass_no, adv_enroll, user_id, user_ip, entry_dt, mobile) VALUES('$cino', '$passdt', '-', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$dbmobile')";
				$res = $this->Query($MyQuery, $this->bindParamArray);
				
				return 'OK##'.$_SESSION['lawyer']['CSRF_Token'].'##'.$data[0]['id']; exit();
			}
			else{
				return "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		
		function GENERATE_PIP_SECTION_PASS($passfor, $passdt, $vist_purpose, $pass_dt, $purposermks)
		{
			$passNo = str_replace('/', '', $pass_dt).date('His');
			$name	= $_SESSION['lawyer']['user_name'];
			$mobile = $_SESSION['lawyer']['mobile'];
			$userid = $_SESSION['lawyer']['user_id'];
			$userip = $_SERVER['REMOTE_ADDR'];
			$passtype = $_SESSION['lawyer']['passtype'];
			
			// CHECK PASS GENERATE OR NOT FOR PIP
			$sqlchk = "SELECT pass_no FROM gatepass_details_section WHERE pass_dt='$passdt' AND userid=$userid AND passtype=$passtype";
			$passchk = $this->fetchQuery($sqlchk, $this->bindParamArray);
			
			if(!empty($passchk)){
				return "PASSEXISTS##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
			// CHECK PASS GENERATE OR NOT FOR PIP
			
			$MyQuery="INSERT INTO gatepass_details_section(pass_dt, userid, userip, adv_cd, entry_dt, purpose_of_visit, passtype, pass_no, enroll_no, purposermks) VALUES('$passdt', '$userid', '$userip', '0', NOW(), '$vist_purpose', $passtype, '$passNo', '$mobile', '$purposermks') returning id";
			
			$data = $this->insertQuery($MyQuery, $this->bindParamArray);
				
			if($data){
				$estt = $_SESSION['lawyer']['connection'] == 'P' ? 'RHC Jodhpur' : 'RHCB Jaipur';
				
				// SEND PASS DETAIL TO ADVOCATE
				if($passtype == '1'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Sr. Advocate is valid for Ancillary Purposes other than court hearing on $pass_dt only in $estt.";
				}
				else if($passtype == '2'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Advocate is valid for Ancillary Purposes other than court hearing on $pass_dt only in $estt.";
				}
				else if($passtype == '3'){
					$dlt_template_id = '1107160033864143735';
					$message = "Entry pass issued for $name, Party-in-Person is valid for Ancillary Purposes other than court hearing on $pass_dt only in $estt.";
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

				$dbmobile = $this->getEncryptValue($mobile);
				$MyQuery="INSERT INTO gatepass_sms_details(cino, causelist_dt, causelist_type, pass_no, adv_enroll, user_id, user_ip, entry_dt, mobile) VALUES('$cino', '$passdt', '-', '$passNo', '$enroll', '$userid', '$userip', NOW(), '$dbmobile')";
				$res = $this->Query($MyQuery, $this->bindParamArray);
				
				return 'OK##'.$_SESSION['lawyer']['CSRF_Token'].'##'.$data[0]['id']; exit();
			}
			else{
				return "NA##".$_SESSION['lawyer']['CSRF_Token']; exit();
			}
		}
		
		function CHECK_CASE_EXISTS_OR_NOT($type, $no, $year, $ctype)
		{
			if($ctype == 'F'){
				$MyQuery="SELECT cino FROM civil_t WHERE filcase_type='$type' AND fil_no='$no' AND fil_year='$year'";
			}
			else{
				$MyQuery="SELECT cino FROM civil_t WHERE regcase_type='$type' AND reg_no='$no' AND reg_year='$year'";
			}
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			return $data;
		}
		
		function GET_SECTION_PASS_DETAILS_FOR_PDF($passid)
		{
			/*$MyQuery="SELECT A.pass_no, to_char(A.pass_dt, 'DD/MM/YYYY') AS cl_dt, 
					to_char(A.entry_dt, 'DD/MM/YYYY') AS gen_dt, (SELECT string_agg(purpose, '<br/>') AS purpose FROM gatepass_purpose_visit WHERE id::TEXT = ANY (CONCAT('{', A.purpose_of_visit, '}')::TEXT[])) AS purposeofvisit
					FROM gatepass_details_section AS A
					WHERE A.id='$passid'";*/
			$MyQuery="SELECT A.pass_no, to_char(A.pass_dt, 'DD/MM/YYYY') AS cl_dt, A.purposermks,
			to_char(A.entry_dt, 'DD/MM/YYYY') AS gen_dt
			FROM gatepass_details_section AS A
			WHERE A.id='$passid'";
			$data = $this->fetchQuery($MyQuery, $this->bindParamArray);
			return $data;
		}

		function SP_INSERT_COVID_VACCINATION_STATUS_USERS($userid, $firstdose, $seconddose, $certrefid, $seconddosedate, $certfilepath, $userip, $estt)
		{
			$MyQuery = "INSERT INTO gatepass_covid_status_users (user_id, firstdose, seconddose, cert_ref_id, second_dose_date, cert_file_path, user_ip, estt) VALUES ('$userid', '$firstdose', '$seconddose', '$certrefid', '$seconddosedate', '$certfilepath', '$userip', '$estt') returning id";
			
			return $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function SP_INSERT_COVID_VACCINATION_STATUS_OTHERS($userid, $firstdose, $seconddose, $certrefid, $seconddosedate, $certfilepath, $userip, $regno, $name, $mobile, $estt)
		{
			$MyQuery = "INSERT INTO gatepass_covid_status_others (user_id, firstdose, seconddose, cert_ref_id, second_dose_date, cert_file_path, user_ip, reg_no, name, mobile, estt) VALUES ('$userid', '$firstdose', '$seconddose', '$certrefid', '$seconddosedate', '$certfilepath', '$userip', '$regno', '$name', '$mobile', '$estt') returning id";
			
			return $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function SP_UPDATE_COVID_VACCINATION_STATUS_USERS($dataid, $userid, $firstdose, $seconddose, $certrefid, $seconddosedate, $certfilepath, $userip, $estt)
		{
			$MyQuery = "UPDATE gatepass_covid_status_users SET seconddose='$seconddose', second_dose_date='$seconddosedate', cert_file_path='$certfilepath', user_ip='$userip', estt='$estt', entry_date=now(), status='P' WHERE id='$dataid' AND user_id='$userid'";
			
			return $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function SP_UPDATE_COVID_VACCINATION_STATUS_OTHERS($dataid, $userid, $firstdose, $seconddose, $certrefid, $seconddosedate, $certfilepath, $userip, $regno, $name, $mobile, $estt)
		{
			$MyQuery = "UPDATE gatepass_covid_status_others SET seconddose='$seconddose', second_dose_date='$seconddosedate', cert_file_path='$certfilepath', user_ip='$userip', estt='$estt', entry_date=now(), status='P' WHERE id='$dataid' AND user_id='$userid'";
			
			return $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function SP_RESET_COVID_VACCINATION_STATUS($userid, $dataid, $uploadfor)
		{
			$resetTable = '';
			$baseTable = '';
			if($uploadfor == 'S') {
				$resetTable = 'gatepass_covid_status_users_reset';
				$baseTable = 'gatepass_covid_status_users';
			}
			elseif($uploadfor == 'C') {
				$resetTable = 'gatepass_covid_status_others_reset';
				$baseTable = 'gatepass_covid_status_others';
			}
			
			$MyQuery = "INSERT INTO $resetTable SELECT * FROM $baseTable WHERE id = '$dataid' AND user_id = '$userid' RETURNING id";
			$result = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			if($result) {
				$MyQuery = "DELETE FROM $baseTable WHERE id = '$dataid' AND user_id = '$userid'";
				$result = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			}
			
			return $result;
		}
		
		function SP_GET_COVID_VACCINATION_STATUS_USERS($userid)
		{
			$MyQuery = "SELECT * FROM gatepass_covid_status_users WHERE user_id='$userid'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			return $data;
		}
		
		function SP_GET_COVID_VACCINATION_STATUS_OTHERS($userid)
		{
			$MyQuery = "SELECT * FROM gatepass_covid_status_others WHERE user_id='$userid'";
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			return $data;
		}
		
		function SP_GET_COVID_VACCINATION_DETAILS_FOR_PDF($dataid, $uploadfor)
		{
			if($uploadfor == 'S') {
				$MyQuery = "SELECT A.firstdose, A.seconddose, A.cert_ref_id, A.second_dose_date, A.cert_file_path, A.entry_date, B.enroll_num AS reg_no, B.name, B.contact_num AS mobile, A.action_date
						FROM gatepass_covid_status_users A
						INNER JOIN gatepass_users AS B ON A.user_id = B.id
						WHERE A.id = '$dataid' AND A.status = 'A'";
			}
			else if($uploadfor == 'C') {
				$MyQuery = "SELECT A.firstdose, A.seconddose, A.cert_ref_id, A.second_dose_date, A.cert_file_path, A.entry_date, A.reg_no, A.name, A.mobile, A.action_date
						FROM gatepass_covid_status_others A
						WHERE A.id = '$dataid' AND A.status = 'A'";
			}
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			return $data;
		}
		
		function SP_GET_COVID_VACCINATION_STATUS($fromdt, $todt, $estt, $status)
		{
			$onHoldCondition = '';
			/*$maxDate = date('Y-m-d', strtotime('-14 days'));
			if($status == 'P') {
				$onHoldCondition = " AND A.second_dose_date <= '$maxDate'";
			}
			
			if($status == 'H') {
				$onHoldCondition = " AND A.second_dose_date > '$maxDate'";
				$status = 'P';
			}*/
			
			$MyQuery="SELECT * FROM (
						SELECT A.id, A.firstdose, A.seconddose, A.cert_ref_id, A.second_dose_date, A.cert_file_path, A.status, A.remark, A.entry_date, B.enroll_num AS reg_no, B.name, B.contact_num AS mobile, 'S' AS uploadfor
						FROM gatepass_covid_status_users A
						INNER JOIN gatepass_users AS B ON A.user_id = B.id
						WHERE A.entry_date::date >= '$fromdt' AND A.entry_date::date <= '$todt' AND A.estt = '$estt' AND A.status = '$status' $onHoldCondition
						UNION
						SELECT A.id, A.firstdose, A.seconddose, A.cert_ref_id, A.second_dose_date, A.cert_file_path, A.status, A.remark, A.entry_date, A.reg_no, A.name, A.mobile, 'C' AS uploadfor
						FROM gatepass_covid_status_others A
						WHERE A.entry_date::date >= '$fromdt' AND A.entry_date::date <= '$todt' AND A.estt = '$estt' AND A.status = '$status' $onHoldCondition
					) AS C
					ORDER BY C.entry_date";
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			return $data;
		}
		
		function SP_APPROVE_REJECT_CERTIFICATE_UPLOAD($dataid, $action, $remark, $uploadfor, $user_id, $user_ip)
		{
			if($uploadfor == 'S') {
				$table = 'gatepass_covid_status_users';
			}
			else if($uploadfor == 'C') {
				$table = 'gatepass_covid_status_others';
			}
			
			$MyQuery = "UPDATE $table SET status = '$action', remark = '$remark', action_by = '$user_id', action_ip = '$user_ip', action_date = now() WHERE id = '$dataid' AND status = 'P'";
			
			return $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
		}
		
		function SP_GET_COVID_VACCINATION_REPORT()
		{
			/*$maxDate = date('Y-m-d', strtotime('-14 days'));
			$MyQuery = "SELECT 
							SUM(CASE WHEN estt = 'P' AND status = 'P' AND second_dose_date <= '$maxDate' THEN 1 ELSE 0 END) AS jdp_pending,
							SUM(CASE WHEN estt = 'P' AND status = 'P' AND second_dose_date > '$maxDate' THEN 1 ELSE 0 END) AS jdp_onhold,
							SUM(CASE WHEN estt = 'P' AND status = 'A' THEN 1 ELSE 0 END) AS jdp_approved,
							SUM(CASE WHEN estt = 'P' AND status = 'R' THEN 1 ELSE 0 END) AS jdp_rejected,
							SUM(CASE WHEN estt = 'P' THEN 1 ELSE 0 END) AS jdp_total,
							SUM(CASE WHEN estt = 'B' AND status = 'P' AND second_dose_date <= '$maxDate' THEN 1 ELSE 0 END) AS jp_pending,
							SUM(CASE WHEN estt = 'B' AND status = 'P' AND second_dose_date > '$maxDate' THEN 1 ELSE 0 END) AS jp_onhold,
							SUM(CASE WHEN estt = 'B' AND status = 'A' THEN 1 ELSE 0 END) AS jp_approved,
							SUM(CASE WHEN estt = 'B' AND status = 'R' THEN 1 ELSE 0 END) AS jp_rejected,
							SUM(CASE WHEN estt = 'B' THEN 1 ELSE 0 END) AS jp_total
						FROM (
							SELECT A.id, A.second_dose_date, A.status, A.estt
							FROM gatepass_covid_status_users A
							UNION
							SELECT A.id, A.second_dose_date, A.status, A.estt
							FROM gatepass_covid_status_others A
						) AS C";*/
						
			$MyQuery = "SELECT 
							SUM(CASE WHEN estt = 'P' AND status = 'P' THEN 1 ELSE 0 END) AS jdp_pending,
							SUM(CASE WHEN estt = 'P' AND status = 'A' THEN 1 ELSE 0 END) AS jdp_approved,
							SUM(CASE WHEN estt = 'P' AND status = 'R' THEN 1 ELSE 0 END) AS jdp_rejected,
							SUM(CASE WHEN estt = 'P' THEN 1 ELSE 0 END) AS jdp_total,
							SUM(CASE WHEN estt = 'B' AND status = 'P' THEN 1 ELSE 0 END) AS jp_pending,
							SUM(CASE WHEN estt = 'B' AND status = 'A' THEN 1 ELSE 0 END) AS jp_approved,
							SUM(CASE WHEN estt = 'B' AND status = 'R' THEN 1 ELSE 0 END) AS jp_rejected,
							SUM(CASE WHEN estt = 'B' THEN 1 ELSE 0 END) AS jp_total
						FROM (
							SELECT A.id, A.second_dose_date, A.status, A.estt
							FROM gatepass_covid_status_users A
							UNION
							SELECT A.id, A.second_dose_date, A.status, A.estt
							FROM gatepass_covid_status_others A
						) AS C";
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			return $data;
		}
		
		function SP_GET_COVID_VACCINATION_DETAILED_REPORT($fromdt, $todt, $estt, $status)
		{
			$MyQuery="SELECT * FROM (
						SELECT A.id, A.firstdose, A.seconddose, A.cert_ref_id, A.second_dose_date, A.cert_file_path, A.status, A.remark, A.entry_date, B.enroll_num AS reg_no, B.name, B.contact_num AS mobile, 'S' AS uploadfor
						FROM gatepass_covid_status_users A
						INNER JOIN gatepass_users AS B ON A.user_id = B.id
						WHERE A.entry_date::date >= '$fromdt' AND A.entry_date::date <= '$todt' AND A.estt = '$estt' AND A.status = '$status'
						UNION
						SELECT A.id, A.firstdose, A.seconddose, A.cert_ref_id, A.second_dose_date, A.cert_file_path, A.status, A.remark, A.entry_date, A.reg_no, A.name, A.mobile, 'C' AS uploadfor
						FROM gatepass_covid_status_others A
						WHERE A.entry_date::date >= '$fromdt' AND A.entry_date::date <= '$todt' AND A.estt = '$estt' AND A.status = '$status'
					) AS C
					ORDER BY C.name, C.reg_no";
			
			$data = $this->fetchQuery_inMainDB($MyQuery, $this->bindParamArray);
			
			return $data;
		}

		function SaveUploadedFile($HTML_Source_Object, $checkPdf = false, $minSizeB = 20480, $maxSizeB = 102400) {
			if(isset($_FILES[$HTML_Source_Object]) && $_FILES[$HTML_Source_Object]['name'] != '' && $_FILES[$HTML_Source_Object]['tmp_name'] != '') {
				$filecontent = ''; $file_extArr[] = '';
				$file_ext  = ''; $file_type = '';
				
				$filecontent = file_get_contents($_FILES[$HTML_Source_Object]['tmp_name']);
				$file_extArr = explode('.', $_FILES[$HTML_Source_Object]['name']);
				$file_ext  = strtolower(pathinfo($_FILES[$HTML_Source_Object]['name'], PATHINFO_EXTENSION));
				$file_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES[$HTML_Source_Object]['tmp_name']);
	 
				if($_FILES[$HTML_Source_Object]["error"] > 0) {
					return 'NVIMG';
				}
				
				/*if( (($file_ext == "jpeg" || $file_ext == "jpg") && ($file_type == 'image/jpeg')) ){
					return 'NVIMG';
				}*/
				//$_FILES[$HTML_Source_Object]["type"] == "image/jpeg" || $_FILES[$HTML_Source_Object]["type"] == "image/jpg" || $_FILES[$HTML_Source_Object]["type"] == "image/pjpeg"
				
				if($checkPdf && (!in_array($file_ext, ['jpeg', 'jpg', 'pdf']) || !in_array($file_type, ['image/jpeg', 'image/jpg', 'image/pjpeg', 'image/pjpg', 'application/pdf']))) {
					return 'NVIMG';
				}
				
				if(!$checkPdf && (!in_array($file_ext, ['jpeg', 'jpg']) || !in_array($file_type, ['image/jpeg', 'image/jpg', 'image/pjpeg', 'image/pjpg']))) {
					return 'NVIMG';
				}
				
				if($_FILES[$HTML_Source_Object]["size"] > $maxSizeB || $_FILES[$HTML_Source_Object]["size"] < $minSizeB) {
					return 'IMGSIZE';
				}
				
				if(strpos($filecontent, 'truncate') == true || strpos($filecontent, 'drop') == true || strpos($filecontent, '<script>') == true || strpos($filecontent, 'database') == true || strpos($filecontent, 'sql') == true || strpos($filecontent, 'php') == true || strpos($filecontent, 'document') || strpos($filecontent, 'ready') == true || strpos($filecontent, 'javascript') == true || strpos($filecontent, 'table') == true){
					return 'NVIMG';
				}
				
				return 'OK';
			}
			else {
				return 'NVIMG';
			}
		}
	}
?>