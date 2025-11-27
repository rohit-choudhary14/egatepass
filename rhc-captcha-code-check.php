<?php 
include 'urlConfig.php';	
if(isset($_POST['validateCaptch']))
{
	if (!empty($_POST['validateCaptch']))
	{
		if(!empty($_SESSION['lawyer']['captcha']))
		{
			if (trim($_POST['validateCaptch']) != trim($_SESSION['lawyer']['captcha']))
			{
				echo "false";
				exit();
			} 
			else
			{   
				echo "true";
				exit();
			}
		}
		else
		{
			echo "false";
			exit();
		}
	}
}
?>