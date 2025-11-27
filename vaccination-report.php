<?php
	include_once('spoperation.php');
	
	$call = new spoperation();
	$result = $call->SP_GET_COVID_VACCINATION_REPORT();
	
	if(empty($result)) {
		echo 'No record found'; die;
	}
	
	$data = $result[0];
	
	echo '<b>Vaccination certificate upload status for Jodhpur:</b><br />';
	echo 'Pending - ' . $data['jdp_pending'] . '<br />';
	//echo 'On Hold - ' . $data['jdp_onhold'] . '<br />';
	echo 'Approved - ' . $data['jdp_approved'] . '<br />';
	echo 'Rejected - ' . $data['jdp_rejected'] . '<br />';
	echo 'Total - ' . $data['jdp_total'] . '<br />';
	
	echo '<br /><b>Vaccination certificate upload status for Jaipur:</b><br />';
	echo 'Pending - ' . $data['jp_pending'] . '<br />';
	//echo 'On Hold - ' . $data['jp_onhold'] . '<br />';
	echo 'Approved - ' . $data['jp_approved'] . '<br />';
	echo 'Rejected - ' . $data['jp_rejected'] . '<br />';
	echo 'Total - ' . $data['jp_total'] . '<br />';
?>