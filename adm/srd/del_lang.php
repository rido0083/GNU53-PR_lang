<?php
include_once('./_common.php');

$tokey = urldecode($_GET['ori']);
$sql = " delete from {$srd['srd_lang']}  where tokey='{$tokey}'";
sql_query($sql);
//echo $sql;

goto_url('./config_lang.php');
?>




