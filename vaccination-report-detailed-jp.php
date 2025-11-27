<?php
	include_once('spoperation.php');
	
	$estt = 'B';
	$status = 'A';
	
	if(empty($estt) || empty($status)) {
		echo 'No record found'; die;
	}
	
	$call = new spoperation();
	$result = $call->SP_GET_COVID_VACCINATION_DETAILED_REPORT('2021-06-01', date('Y-m-d'), $estt, $status);
	
	if(empty($result)) {
		echo 'No record found'; die;
	}
	
	$esttText = '';
	if($estt == 'B') {
		$esttText = 'Jaipur';
	}
	else if($estt == 'P') {
		$esttText = 'Jodhpur';
	}
	
	echo '<html>';
	
	echo "<b>Vaccination certificate upload report for $esttText.</b><br />";
	
	echo '<table border="1">
			<tr>
				<th>S.No.</th>
				<th>Name</th>
				<th>Enrolment No.</th>
				<th>Type of User</th>
			</tr>';
	
	$i = 0;
	foreach($result as $data) {
		echo '<tr>';
		echo '<td>'.++$i.'</td>';
		echo '<td>'.ucwords(strtolower($data['name'])).'</td>';
		echo '<td>'.strtoupper($data['reg_no']).'</td>';
		
		$userType = '';
		if($data['uploadfor'] == 'S' && $data['reg_no'] != '') {
			$userType = 'Advocate';
		}
		else if($data['uploadfor'] == 'S' && $data['reg_no'] == '') {
			$userType = 'Party-in-Person';
		}
		if($data['uploadfor'] == 'C') {
			$userType = 'A. Clerk';
		}
		
		echo '<td>'.$userType.'</td>';
		echo '</tr>';
	}
	
	echo '</table></html>';
?>