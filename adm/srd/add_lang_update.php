<?php
include_once('./_common.php');

$tokey = $_POST['tokey'];

for ($i=0 ; $i < count($tokey) ; $i++) {
    if ($tokey[$i]) {

        //저장된 문구가 없다면 insert
        $sql = " select id from {$g5['g5_srd_lang']} where tokey = '{$tokey[$i]}' ";
        $get_tokey = sql_fetch($sql);

        if (!$get_tokey['id']) {
            foreach ($iu_lnagType as $val) {
                $sql = " insert into {$g5['g5_srd_lang']} set include = '{$_POST['include'][$i]}' , tokey='{$tokey[$i]}' , getval='{$_POST['getval'][$val][$i]}' , lang='{$val}' ";
                sql_query($sql);
            }  // endforeach
        } // end if if (!$get_tokey['id']) {
    } //end if if ($tokey[$i]) {
} // end for

goto_url('./config_lang.php');
?>




