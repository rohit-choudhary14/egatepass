<?php
session_start();
ob_start();
error_reporting(0);
include 'urlConfig.php';
header('X-Frame-Options: DENY');
ini_set( 'session.cookie_httponly', 1 );
header("Set-Cookie: hidden=value; httpOnly");
?>
<!DOCTYPE html>
<html lang="en" >
	<head>
		<title>RHCB Filing Login | Jaipur</title>		 	
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
        <meta name="robots" content="DISALLOW">
        <meta name="revisit-after" content="1 day">
        <meta http-equiv="content-script-type" content="text/javascript">
        <meta http-equiv="content-language" content="en">
        <meta name="robots" content="DISALLOW">
        <meta name="revisit-after" content="1 day">
        <meta http-equiv="content-script-type" content="text/javascript">
        <base href="<?php echo $base_url; ?>"/>		
		<link rel="shortcut icon" href="images/national-emblem-india.PNG">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="RHC, RHCB, Filing, Cause list, index, home page, login page, Rajasthan High Court, RHCB Website, Rajsthan Govt" />
		<meta name="description" content="A cluster of Princely States with an oasis known as Ajmer-Merwara, a British India Territory, was given geographical expression as Rajputana. These Twenty and odd Rajputana States before 20th Century AD were dynastic and the Rulers were the fountain head of all Executive, Legislative and Judicial Authority in the States. As soon as the country got freedom from British Imperialism, the process of integration of the princely States to form bigger units was initiated." />
		<meta http-equiv="Content-Security-Policy">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8; X-Content-Type-Options=nosniff" />
		<script type="application/x-javascript"> 
			addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
			function hideURLbar(){ window.scrollTo(0,1); } 
		</script>
		<link rel="stylesheet" href="includes/libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="includes/css/style.css">
		<link rel="stylesheet" type="text/css" href="includes/css/font-awesome.min.css"/>
		<script type="text/javascript" src="includes/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="includes/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="includes/js/validation_file.js?random=<?php echo rand(0001, 9999);?>"></script>
		<style>
			.bck-img{
				background-image:url('images/back-img.jpg');
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				height: 100%;
			}
			.error-msg{
				background-color: #F8F8F8;
				text-align: center;
				border-radius: 5px;
				padding: 5px;
				opacity: 0.8;
				margin-top:10%;
				padding-bottom:5%;
				webkit-box-shadow: 0 1px 4px rgba(1, 0, 0, 0.5), 0 0 10px rgba(0, 0, 0, 0.1) inset;
				-moz-box-shadow: 0 1px 4px rgba(1, 0, 0, 0.5), 0 0 10px rgba(0, 0, 0, 0.1) inset;
				box-shadow: 0 1px 4px rgba(1, 0, 0, 0.5), 0 0 0px rgba(0, 0, 0, 0.1) inset;
			}
			.error-h1{
				color:red;
				font-size:140px;
			}
			.error-h2{
				color:red;
				font-size:25px;
			}
		</style>
	</head>
	<body style="margin:0px !important;">
		<div class="container-fluid bck-img" style="min-height:100vh; padding:0px !important; margin:0px !important;">
			<div class="row" style="margin:0px !important;">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="col-md-12 error-msg">
						<h1 class="error-h1">404</h1>
						<h2 class="error-h2">Sorry! The page you were looking for could not be found</h2><br/><br/><br/>
						<a href="http://hcraj.nic.in" class="btn btn-danger">Go Back Home Page</a>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>
	</body>
</html>
			

