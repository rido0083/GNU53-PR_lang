<?php
include_once "./_common.php";

$l = $_GET['l'];
$u = $_GET['u'];

session_start();
$_SESSION['lang'] = $l;
$_SESSION['locale'] = $l;
goto_url($u);
?>
