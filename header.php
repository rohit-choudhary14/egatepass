<?php
if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != ''){
	error_reporting(0);
	include_once "spoperation.php";
	$call = new spoperation();
	$res = $call->SP_CHECK_USER_SESSION($_SESSION['lawyer']['user_id'], session_id());
	if(empty($res[0])){
		header("Location:".$base_url.'my-logout.php');
	}
}
	header('X-Frame-Options: DENY');
?>
<link rel="stylesheet" href="includes/css/stylesheet1.css">	
<style>
.contrastTheme{
	width:20px;
	height:20px;
	background:#000 !important;
	border:1px solid #fff;
	border-radius:50% !important;
	color:#fff;
	text-align:center;
	line-height:20px;
	}

.defaultTheme{
	width:20px;
	height:20px;
	background:#fff !important;
	border:1px solid #000;
	border-radius:60% !important;
	color:#000;
	text-align:center;
	line-height:20px;
	}
#Highcontrast, #Defaultcontrast{
background:#fff !important;
}
</style>
	
<div  style="float: right; background:transparent;">
	<button id="btndecfont" style="background:#fff;color:#000;">A-</button>
	<button style="padding-left: 10px;padding-right: 10px; background:#fff; color:#000;" id="btnresetfont">A</button>
	<button id="btnincfont" style="background:#fff; color:#000;">A+</button>
	<button class="whitelink" id="Defaultcontrast" title="Default contrast" ><div class="defaultTheme">A</div></button>
	<button class="blacklink1" id="Highcontrast" title="High contrast" ><div class="contrastTheme">A</div></button>
										
</div>	
	<div class="jumbotron">
		<div class="container text-center">
			<div class="col-md-1"></div>
			<div class="col-md-2 col-xs-2"><img src="images/Emblem_of_India.svg" class="emblem" alt="National Emblem"></div>
			<div class="col-md-6 col-xs-8"><h2 id="heading" class="headingText">Rajasthan High Court</h2></div>
			<div class="col-md-2 col-xs-2"><img src="images/Emblem_of_India.svg" class="emblem" alt="National Emblem"></div>
		</div>
	</div>
	<nav class="navbar navbar-inverse" style="height:45px">
		<div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" aria-label="Navigation Menu">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			</div>
			<div class="collapse navbar-collapse topnav" id="myNavbar">
				<ul class="nav navbar-nav " id="titleList">
					<!--<li style="z-index:1;" class="list" style="z-index:1;"><a href="https://localhost/hcraj/Allfiles/E-Pass_User_Guide.pdf" target="_blank">Help</a></li>-->
					<li style="z-index:1;">
						<a id="drop2" style="cursor:pointer;" role="button" class="dropdown-toggle" data-toggle="dropdown">Help <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
							<li style="z-index:1;"><a style="cursor:pointer;" href="https://localhost/hcraj/Allfiles/E-Pass_User_Guide.pdf" target="_blank">e-Pass</a></li>
							<!-- <li style="z-index:1;"><a style="cursor:pointer;" href="https://localhost/hcraj/Allfiles/User_Manual_Vaccination_Certificate_Upload.pdf" target="_blank">Upload Vaccination Certificate</a></li> -->
						</ul>
					</li>
					<?php if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != '') { ?>
					<li style="z-index:1;" class="list" style="z-index:1;"><a href="generate-pass.php">Generate New Pass</a></li>
					<li style="z-index:1;">
						<a id="drop2" style="cursor:pointer;" role="button" class="dropdown-toggle" data-toggle="dropdown">Previously Generated Pass <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
							<li style="z-index:1;"><a style="cursor:pointer;" href="search-generated-pass.php">Pass for Case Hearing</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="search-generated-pass-section.php">Pass for Section Visit</a></li>
						</ul>
					</li>
					
					<?php if(isset($_SESSION['lawyer']['passtype']) && ($_SESSION['lawyer']['passtype'] == '1' || $_SESSION['lawyer']['passtype'] == '2')) { ?>
					<!-- <li style="z-index:1;">
						<a id="drop2" style="cursor:pointer;" role="button" class="dropdown-toggle" data-toggle="dropdown">Upload Vaccination Certificate <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
							<li style="z-index:1;"><a style="cursor:pointer;" href="vaccination-status-user.php">For Self</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="vaccination-status-advocate-clerk.php">For Advocate Clerk</a></li>
						</ul>
					</li> -->
					<?php } 
					else { ?>
					<!-- <li style="z-index:1;"><a href="vaccination-status-user.php">Upload Vaccination Certificate</a></li> -->
					<?php } ?>
					
					<li style="z-index:1;"><a onclick="changeEstablishment();">Change Establishment</a></li>
					<?php } ?>
				</ul>
				<?php if(isset($_SESSION['lawyer']['user_id'])) { ?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown" style="z-index:1;">
						<a id="drop1" style="cursor:pointer;"  role="button" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $_SESSION['lawyer']['user_name'];?><span id="lblestt"> <?php if(isset($_SESSION['lawyer']['connection']) && $_SESSION['lawyer']['connection'] == 'P') { echo ' (Jodhpur)'; } else  if(isset($_SESSION['lawyer']['connection']) && $_SESSION['lawyer']['connection'] == 'B') { echo ' (Jaipur)'; } ?></span> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
							<li style="z-index:1;"><a style="cursor:pointer;" href="change-password.php"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="my-logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
						</ul>
					</li>	
				</ul>
				<?php } else{ ?>
				<ul class="nav navbar-nav navbar-right">
					<?php if(basename($_SERVER['PHP_SELF']) != 'signup.php') { ?>
						<!--<li style="z-index:1;"><a style="cursor:pointer;" href="signup.php"><span class="fa fa-sign-in"></span> Register</a></li>-->
					<?php } else{ ?>
						<li style="z-index:1;"><a style="cursor:pointer;" href="<?php echo $base_url;?>"><span class="fa fa-arrow-left"></span> Back</a></li>
					<?php } ?>
				</ul>
				<?php }?>
			</div>
		</div>
	</nav>
<script>
$('li').on('click',function(){
	$('li').removeClass('active');
	$(this).addClass('active');
});
</script>


 