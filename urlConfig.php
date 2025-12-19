<?php
session_start();
ob_start();

date_default_timezone_set('Asia/Kolkata');
ini_set('date.timezone', 'Asia/Kolkata');

//error_reporting(0);
header('X-Frame-Options: DENY');
header("X-XSS-Protection: 1; mode=block");

ini_set( 'session.cookie_httponly', 1 );

$url = $_SERVER['REQUEST_URI'];
$query_str = parse_url($url, PHP_URL_QUERY);
parse_str($query_str, $query_params);

$folderName =basename(dirname(__FILE__));

$base_url="https://hcraj.nic.in:".$_SERVER['SERVER_PORT']."/".$folderName."/";

if(!empty($query_params))
{
	header("Location:".$base_url."error.php");die;
}

?>