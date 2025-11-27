<?php
include 'urlConfig.php';
include "spoperation.php";

$call = new spoperation();
$call->SP_DELETE_USER_SESSION($_SESSION['lawyer']['user_id'], session_id());

session_destroy();
header("Location:".$base_url);
?>