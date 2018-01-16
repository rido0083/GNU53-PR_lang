<?php
$sub_menu = "150000";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '번역관리 추가';
include_once('../admin.head.php');
?>

<style>
    .frm_input {
        height:50px;
    }
    .btn_submit {
        padding: 10px;
    }
</style>

<?php if ($is_admin == 'super') { ?>
    <div class="btn_add01 btn_add sort_with">
        <a href="./config_lang.php" id="bo_gr_add">목록보기</a>
    </div>
<?php } ?>

<form name="fboardgroup" id="fboardgroup" action="./add_lang_update.php" onsubmit="return fboardgroup_check(this);" method="post" autocomplete="off">
<div class="tbl_head02 tbl_wrap">
    <table id="add_langTable">
        <thead>
        <tr>
            <th>타입</th>
            <th>한국어</th>
        <?php
        foreach ($iu_lnagType as $val) {
            ?>
            <th><?php echo $val?></th>
            <?php
        }  // endforeach
        ?>
        </tr>
        </thead>
        <tbody id="add_langTr">
        <?php for ($i=0 ; $i < 20 ; $i++) { ?>
            <tr>
                <td>
                    <input type="text" name="include[]" class="frm_input" />
                </td>
                <td>
                    <textarea name="tokey[]" class="frm_input"></textarea>
                </td>
                <?php
                foreach ($iu_lnagType as $val) {
                    ?>
                    <td>
                        <textarea name="getval[<?php echo $val?>][]" class="frm_input"></textarea>
                    </td>
                    <?php
                }  // endforeach
                ?>
            </tr>
        <?php } // end for ?>
        </tbody>
    </table>
</div>

<div class="btn_add01 btn_add sort_with">
    <a onclick="add_tr();">+ 20 목록추가</a>
</div>

<?php if ($is_admin == 'super') { ?>
    <div class="btn_add01 btn_add sort_with">
        <a href="./config_lang.php" id="bo_gr_add">목록보기</a>
        <input type="submit" class="btn_submit" accesskey="s" value="저장하기">
    </div>
<?php } ?>
</form>

<script>
    function add_tr() {
        var add_lnag_tr = $("#add_langTr").html();
        $("#add_langTable").append(add_lnag_tr);
    }

    function fboardgroup_check(f)
    {
        f.action = './add_lang_update.php';
        return true;
    }
</script>


<?php
include_once('../admin.tail.php');
?>



