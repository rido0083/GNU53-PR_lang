<?php
include_once "./_common.php";
$lang = $_GET['lang'];
$return_url = $_GET['return_url'];

session_start();
$_SESSION['lang'] = $lang;
goto_url($return_url);

?>