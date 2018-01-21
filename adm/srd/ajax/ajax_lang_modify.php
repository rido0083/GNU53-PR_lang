<?php
include_once('./_common.php');

$id = $_POST['g_idx'];
$lang = $_POST['g_lang'];
$getval = $_POST['g_text'];
$ori = $_POST['g_ori'];
$type = $_POST['g_type'];

if ($type == 'type' ) {
    $sql = " update {$srd['srd_lang']} set include = '{$getval}' where tokey='{$ori}'";
}
else if ($lang == 'ko') {
    $sql = " update {$srd['srd_lang']} set tokey = '{$getval}' where tokey='{$ori}' ";
} else {
    $sql = "select id from {$srd['srd_lang']} where id={$id}";
    $get_id = sql_fetch($sql);
    if ($get_id['id']) {
        $sql = " update {$srd['srd_lang']} set getval = '{$getval}' where id={$id} ";
    } else {
        $sql = " insert into {$srd['srd_lang']} set tokey = '{$ori}' , getval = '{$getval}' , lang = '{$lang}' ";
    }
}

sql_query($sql);
echo $sql;
?>




