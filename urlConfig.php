<?php
ob_start();
ini_set('session.cookie_httponly', 1);
date_default_timezone_set('Asia/Kolkata');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('X-Frame-Options: DENY');
header("X-XSS-Protection: 1; mode=block");

$url = $_SERVER['REQUEST_URI'];
$query_str = parse_url($url, PHP_URL_QUERY);
parse_str($query_str, $query_params);

$folderName =basename(dirname(__FILE__));

$base_url="http://localhost:".$_SERVER['SERVER_PORT']."/".$folderName."/";

if(!empty($query_params))
{
	header("Location:".$base_url."error.php");die;
}

?>