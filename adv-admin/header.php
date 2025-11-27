<?php
$user_role_id = '';
if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != ''){
	
	//error_reporting(0);
	include "../spoperation.php";
	$call = new spoperation();
	$res = $call->SP_CHECK_USER_SESSION($_SESSION['lawyer']['user_id'], session_id());
	if(empty($res[0])){
		header("Location:".$base_url.'my-logout.php');
	}
}
?>
	<div class="jumbotron">
		<div class="container text-center">
			<div class="col-md-1"></div>
			<div class="col-md-2 col-xs-2"><img src="../images/Emblem_of_India.svg" class="emblem" alt="National Emblem"></div>
			<div class="col-md-6 col-xs-8"><h2 id="heading" class="headingText">Rajasthan High Court</h2></div>
			<div class="col-md-2 col-xs-2"><img src="../images/Emblem_of_India.svg" class="emblem" alt="National Emblem"></div>
		</div>
	</div>
	<nav class="navbar navbar-inverse" style="height:45px">
		<div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			</div>
			<div class="collapse navbar-collapse topnav" id="myNavbar">
				<ul class="nav navbar-nav " id="titleList">
					<?php if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != '' && $_SESSION['lawyer']['role_id'] == '1') { ?>
					
					<!--<li style="z-index:1;" class="list <?php //if(basename($_SERVER['PHP_SELF']) == 'resquest-signin.php') echo "active"; ?>" style="z-index:1;">
						<a href="resquest-signin.php">New Registrations</a>
					</li>
					<li style="z-index:1;" class="list <?php //if(basename($_SERVER['PHP_SELF']) == 'search-req-pass.php') echo "active"; ?>"><a href="search-req-pass.php">Approved/Rejected Registrations</a></li>-->
					
					<li style="z-index:1;">
						<a id="drop2" style="cursor:pointer;" role="button" class="dropdown-toggle" data-toggle="dropdown">Registrations <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
							<li style="z-index:1;"><a style="cursor:pointer;" href="resquest-signin.php">New Registrations</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="search-req-pass.php">Approved/Rejected Registrations</a></li>
						</ul>
					</li>
					
					<!--<li style="z-index:1;" class="list <?php //if(basename($_SERVER['PHP_SELF']) == 'usr-report.php') echo "active"; ?>"><a href="usr-report.php">Pass and Registration Report</a></li>
					<li style="z-index:1;" class="list <?php //if(basename($_SERVER['PHP_SELF']) == 'datewise-count.php') echo "active"; ?>"><a href="datewise-count.php">Date Wise Report</a></li>-->
					
					<li style="z-index:1;">
						<a id="drop2" style="cursor:pointer;" role="button" class="dropdown-toggle" data-toggle="dropdown">Reports <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
							<li style="z-index:1;"><a style="cursor:pointer;" href="usr-report.php">Pass and Registration Report</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="datewise-count.php">Date Wise Report</a></li>
						</ul>
					</li>
					
					<?php } else if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != '' && $_SESSION['lawyer']['role_id'] == '3') { ?>
					
					<li style="z-index:1;" class="list <?php if(basename($_SERVER['PHP_SELF']) == 'usr-report.php') echo "active"; ?>"><a href="usr-report.php">Pass and Registration Report</a></li>
					<li style="z-index:1;" class="list <?php if(basename($_SERVER['PHP_SELF']) == 'datewise-count.php') echo "active"; ?>"><a href="datewise-count.php">Date Wise Report</a></li>
					
					<?php } else if(isset($_SESSION['lawyer']['user_id']) && $_SESSION['lawyer']['user_id'] != '' && $_SESSION['lawyer']['role_id'] == '4') { ?>
					
					<li style="z-index:1;">
						<a id="drop2" style="cursor:pointer;" role="button" class="dropdown-toggle" data-toggle="dropdown">Vaccination Certificate Uploads <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
							<li style="z-index:1;"><a style="cursor:pointer;" href="covid-vaccination-pending.php">Pending</a></li>
							<!--<li style="z-index:1;"><a style="cursor:pointer;" href="covid-vaccination-on-hold.php">On Hold</a></li>-->
							<li style="z-index:1;"><a style="cursor:pointer;" href="covid-vaccination-approved.php">Approved</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="covid-vaccination-rejected.php">Rejected</a></li>
						</ul>
					</li>
					
					<?php } ?>
				</ul>
				<?php if(isset($_SESSION['lawyer']['user_id'])) { ?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown" style="z-index:1;">
						<a id="drop1" style="cursor:pointer;"  role="button" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $_SESSION['lawyer']['user_name'];?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
							<li style="z-index:1;"><a style="cursor:pointer;" href="change-password.php"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
							<li style="z-index:1;"><a style="cursor:pointer;" href="my-logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
						</ul>
					</li>	
				</ul>
				<?php } else{ ?>
				<!--<ul class="nav navbar-nav navbar-right">
					<li style="z-index:1;"><a style="cursor:pointer;" href="<?php echo $base_url."adv-admin/";?>"><span class="fa fa-sign-in"></span> Sign In</a></li>
				</ul>-->
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