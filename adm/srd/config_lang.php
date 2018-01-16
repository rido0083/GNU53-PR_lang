<?php
$sub_menu = "150000";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '번역관리설정';
include_once('../admin.head.php');
?>

<!--jquery table cdn-->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<style>
    .frm_input {
        height:50px;
    }
    .lang_del {
        padding:10px;
        border:1px solid #999;
        background-color: #ddd;
    }
</style>
<script>
    $(document).ready(function(){
        $('#langTable').DataTable();
    });
</script>

<div id="langDiv">
<table id="langTable">
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
        <th>삭제</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT COUNT(*), id, include, tokey FROM {$g5['g5_srd_lang']} GROUP BY tokey order by id asc";
    $result = sql_query($sql);
    for ($i=0 ; $row = sql_fetch_array($result) ; $i++) {
    ?>
        <tr>
            <td><span class="sound_only"><?php echo $row['include'] ?></span> <input type="text" name="type" value="<?php echo $row['include'] ?>"
                class="frm_input modi_lang"
                data-id="<?php echo $row['id']?>"
                data-ori="<?php echo $row['tokey']?>"
                data-type="type"
            >  </td>
            <td><textarea class="frm_input modi_lang"
            data-id="<?php echo $row['id']?>"
            data-lang="ko"
            data-ori="<?php echo $row['tokey']?>"
                ><?php echo $row['tokey']?></textarea></td>
    <?php
        //언어 기준별로 데이터를 반환한다.
        $sql2 = "select * from {$g5['g5_srd_lang']} where tokey = '{$row['tokey']}'";
        $result2 = sql_query($sql2);
        
        //변수초기화
        $row2 = '';
        $key='';
        $get_lang=array();
        $get_id=array();
        for ($j=0 ; $row2 = sql_fetch_array($result2) ; $j++) {
            $key = $row2['lang'];
            $get_lang[$key] = $row2['getval'];
            $get_id[$key] = $row2['id'];
        }  // end for
        foreach ($iu_lnagType as $val) {
        ?>
            <td><textarea class="frm_input modi_lang"
                data-id="<?php echo $get_id[$val]?>"
                data-lang="<?php echo $val?>"
                data-ori="<?php echo $row['tokey']?>"
                ><?php echo $get_lang[$val]?></textarea></td>
        <?php
        } // end foreach
        echo '<td><span data-ori="'.urlencode($row['tokey']).'" class="lang_del">삭제</span></td>';
        echo '</tr>';
    }  // end for
    ?>
    </tbody>
</table>
</div>

<?php if ($is_admin == 'super') { ?>
    <div class="btn_add01 btn_add sort_with">
        <a href="./add_lang.php" id="bo_gr_add">번역문구 추가</a>
    </div>
<?php } ?>

<script>
    $(".lang_del").click(function () {
        var ori = $(this).data('ori');
        var r = confirm("정말 삭제하시겠습니까?");
        if (r == true) {
            location.href='./del_lang.php?ori='+ori;
        }
    });

    $(".modi_lang").change(function () {
        var g_idx = $(this).data('id');
        var g_ori = $(this).data('ori');
        var g_lang = $(this).data('lang');
        var g_text = $(this).val();
        var g_type = $(this).data('type');
        $.post(
            './ajax/ajax_lang_modify.php',
            {
                'g_idx':g_idx,
                'g_ori':g_ori,
                'g_text':g_text,
                'g_type' : g_type ,
                'g_lang':g_lang
            },
            function(data) {
                console.log(data);
            }
        );
    });
</script>


<?php
include_once('../admin.tail.php');
?>



