<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->

<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>

<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="url" value="<?php echo $urlencode ?>">
<input type="hidden" name="agree" value="<?php echo $agree ?>">
<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
<input type="hidden" name="cert_no" value="">
<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
<?php }  ?>
 <div id="register_form"  class="form_01">   
    <div>
        <h2><?php echo _lang('사이트 이용정보 입력')?></h2>
        <ul>
            <li>
                <label for="reg_mb_id" class="sound_only"><?php echo _lang('아이디')?><strong><?php echo _lang('필수')?></strong></label>
                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input half_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="<?php echo _lang('아이디')?>">
                <span id="msg_mb_id"></span>
                <span class="frm_info"><?php echo _lang('영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.')?></span>
            </li>
            <li>
                <label for="reg_mb_password" class="sound_only"><?php echo _lang('비밀번호')?><strong class="sound_only"><?php echo _lang('필수')?></strong></label>
                <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input half_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="<?php echo _lang('비밀번호')?>">

                <label for="reg_mb_password_re" class="sound_only"><?php echo _lang('비밀번호 확인')?><strong><?php echo _lang('필수')?></strong></label>
                <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input half_input right_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="<?php echo _lang('비밀번호 확인')?>">
            </li>
        </ul>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <h2><?php echo _lang('개인정보 입력')?></h2>

        <ul>
            <li>
                <label for="reg_mb_name" class="sound_only"><?php echo _lang('이름')?><strong><?php echo _lang('필수')?></strong></label>
                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input half_input <?php echo $required ?> <?php echo $readonly ?>" size="10" placeholder="<?php echo _lang('이름')?>">
                <?php
                if($config['cf_cert_use']) {
                    if($config['cf_cert_ipin'])
                        echo '<button type="button" id="win_ipin_cert" class="btn_frmline">'._lang('아이핀 본인확인').'/button>'.PHP_EOL;
                    if($config['cf_cert_hp'])
                        echo '<button type="button" id="win_hp_cert" class="btn_frmline">'_lang('휴대폰 본인확인')'</button>'.PHP_EOL;

                    echo '<noscript>'._lang('본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.').'</noscript>'.PHP_EOL;
                }
                ?>
                <?php
                if ($config['cf_cert_use'] && $member['mb_certify']) {
                    if($member['mb_certify'] == 'ipin')
                        $mb_cert = '아이핀';
                    else
                        $mb_cert = '휴대폰';
                ?>
  
                <div id="msg_certify">
                    <strong><?php echo $mb_cert; ?> <?php echo _lang('본인확인')?></strong><?php if ($member['mb_adult']) { ?> <?php echo _lang('건')?>및 <strong><?php echo _lang('성인인증')?></strong><?php } ?> <?php echo _lang('완료')?>
                </div>
                <?php } ?>
                <?php if ($config['cf_cert_use']) { ?>
                <span class="frm_info"><?php echo _lang('아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.')?></span>
                <?php } ?>

                
            </li>
            <?php if ($req_nick) {  ?>
            <li>
                <label for="reg_mb_nick" class="sound_only"><?php echo _lang('닉네임')?><strong><?php echo _lang('필수')?></strong></label>
                
                    <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                    <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input required nospace  half_input" size="10" maxlength="20" placeholder="<?php echo _lang('닉네임')?>">
                    <span id="msg_mb_nick"></span>
                    <span class="frm_info">
                        <?php echo _lang('공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)')?><br>
                        <?php echo _lang('닉네임을 바꾸시면 앞으로')?> <?php echo (int)$config['cf_nick_modify'] ?>
                        <?php echo _lang('일 이내에는 변경 할 수 없습니다.')?>
                    </span>
                
            </li>
            <?php }  ?>

            <li>
                <label for="reg_mb_email" class="sound_only">E-mail<strong><?php echo _lang('필수')?></strong></label>
                
                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo _lang('E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.'); }  ?>
                    <?php if ($w=='u') { echo _lang('E-mail 주소를 변경하시면 다시 인증하셔야 합니다.'); }  ?>
                </span>
                <?php }  ?>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email full_input required" size="70" maxlength="100" placeholder="E-mail">
            
            </li>

            <?php if ($config['cf_use_homepage']) {  ?>
            <li>
                <label for="reg_mb_homepage" class="sound_only"><?php echo _lang('홈페이지')?><?php if ($config['cf_req_homepage']){ ?><strong><?php echo _lang('필수')?></strong><?php } ?></label>
                <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255" placeholder="<?php echo _lang('홈페이지')?>">
            </li>
            <?php }  ?>

            <li>
            <?php if ($config['cf_use_tel']) {  ?>
            
                <label for="reg_mb_tel" class="sound_only"><?php echo _lang('전화번호')?><?php if ($config['cf_req_tel']) { ?><strong><?php echo _lang('필수')?></strong><?php } ?></label>
                <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input half_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="<?php echo _lang('전화번호')?>">
            <?php }  ?>

            <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
                <label for="reg_mb_hp" class="sound_only"><?php echo _lang('휴대폰번호')?><?php if ($config['cf_req_hp']) { ?><strong><?php echo _lang('필수')?></strong><?php } ?></label>
                
                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input right_input half_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="<?php echo _lang('휴대폰번호')?>">
                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                <?php } ?>
            <?php }  ?>
            </li>


            <?php if ($config['cf_use_addr']) { ?>
            <li>
                <?php if ($config['cf_req_addr']) { ?><strong class="sound_only"><?php echo _lang('필수')?></strong><?php }  ?>
                <label for="reg_mb_zip" class="sound_only"><?php echo _lang('우편번호')?><?php echo $config['cf_req_addr']?'<strong class="sound_only"> '._lang('필수').'</strong>':''; ?></label>
                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="<?php echo _lang('우편번호')?>">
                <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');"><?php echo _lang('주소 검색')?></button><br>
                <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="<?php echo _lang('기본주소')?>">
                <label for="reg_mb_addr1" class="sound_only"><?php echo _lang('기본주소')?><?php echo $config['cf_req_addr']?'<strong> '._lang('필수').'</strong>':''; ?></label><br>
                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input" size="50"  placeholder="<?php echo _lang('상세주소')?>">
                <label for="reg_mb_addr2" class="sound_only"><?php echo _lang('상세주소')?></label>
                <br>
                <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly"  placeholder="<?php echo _lang('참고항목')?>">
                <label for="reg_mb_addr3" class="sound_only"><?php echo _lang('참고항목')?></label>
                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
                
            </li>
            <?php }  ?>
        </ul>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <h2><?php echo _lang('기타 개인설정')?></h2>
        <ul>
            <?php if ($config['cf_use_signature']) {  ?>
            <li>
                <label for="reg_mb_signature" class="sound_only"><?php echo _lang('서명')?><?php if ($config['cf_req_signature']){ ?><strong><?php echo _lang('필수')?></strong><?php } ?></label>
                <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"   placeholder="<?php echo _lang('서명')?>"><?php echo $member['mb_signature'] ?></textarea>
            </li>
            <?php }  ?>

            <?php if ($config['cf_use_profile']) {  ?>
            <li>
                <label for="reg_mb_profile" class="sound_only"><?php echo _lang('자기소개')?></label>
                <textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?>" placeholder="<?php echo _lang('자기소개')?>"><?php echo $member['mb_profile'] ?></textarea>
            </li>
            <?php }  ?>

            <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
            <li>
                <label for="reg_mb_icon" class="frm_label"><?php echo _lang('회원아이콘')?></label>
                <input type="file" name="mb_icon" id="reg_mb_icon" >
                                
                <span class="frm_info">
                    <?php echo _lang('이미지 크기는 가로')?> <?php echo $config['cf_member_icon_width'] ?>
                    <?php echo _lang('픽셀, 세로')?> <?php echo $config['cf_member_icon_height'] ?>
                    <?php echo _lang('픽셀 이하로 해주세요.')?><br>
                    <?php echo _lang('gif만 가능하며 용량')?> <?php echo number_format($config['cf_member_icon_size']) ?>
                    <?php echo _lang('바이트 이하만 등록됩니다.')?>
                </span>

                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
                <img src="<?php echo $mb_icon_url ?>" alt="<?php echo _lang('회원아이콘')?>">
                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
                <label for="del_mb_icon"><?php echo _lang('삭제')?></label>
                <?php }  ?>
            
            </li>
            <?php }  ?>

            <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
            <li>
                <label for="reg_mb_img" class="frm_label"><?php echo _lang('회원이미지')?></label>
                <input type="file" name="mb_img" id="reg_mb_img" >
                                
                <span class="frm_info">
                    <?php echo _lang('이미지 크기는 가로')?> <?php echo $config['cf_member_img_width'] ?>
                    <?php echo _lang('픽셀, 세로')?> <?php echo $config['cf_member_img_height'] ?>
                    <?php echo _lang('픽셀 이하로 해주세요.')?><br>
                    <?php echo _lang('gif 또는 jpg만 가능하며 용량')?> <?php echo number_format($config['cf_member_img_size']) ?>
                    <?php echo _lang('바이트 이하만 등록됩니다.')?>
                </span>

                <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
                <img src="<?php echo $mb_img_url ?>" alt="<?php echo _lang('회원아이콘')?>">
                <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
                <label for="del_mb_img"><?php echo _lang('삭제')?></label>
                <?php }  ?>
            
            </li>
            <?php } ?>

            <li>
                <label for="reg_mb_mailling" class="frm_label"><?php echo _lang('메일링서비스')?></label>
                <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>>
                <?php echo _lang('정보 메일을 받겠습니다.')?>
                
            </li>

            <?php if ($config['cf_use_hp']) {  ?>
            <li>
                <label for="reg_mb_sms" class="frm_label"><?php echo _lang('SMS 수신여부')?></label>
                
                    <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?>>
                <?php echo _lang('휴대폰 문자메세지를 받겠습니다.')?>
                
            </li>
            <?php }  ?>

            <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능  ?>
            <li>
                <label for="reg_mb_open" class="frm_label"><?php echo _lang('정보공개')?></label>
                <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
                <input type="checkbox" name="mb_open" value="1" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> id="reg_mb_open">
                <?php echo _lang('다른분들이 나의 정보를 볼 수 있도록 합니다.')?>
                <span class="frm_info">
                    <?php echo _lang('정보공개를 바꾸시면 앞으로')?> <?php echo (int)$config['cf_open_modify'] ?>
                    <?php echo _lang('일 이내에는 변경이 안됩니다.')?>
                </span>                
            </li>
            <?php } else {  ?>
            <li>
                <?php echo _lang('정보공개')?>
                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
                <span class="frm_info">
                    <?php echo _lang('정보공개는 수정후')?> <?php echo (int)$config['cf_open_modify'] ?>
                    <?php echo _lang('일 이내,')?> <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?>
                    <?php echo _lang('까지는 변경이 안됩니다.')?><br>
                    <?php echo _lang('이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.')?>
                </span>
                
            </li>
            <?php }  ?>

            <?php
            //회원정보 수정인 경우 소셜 계정 출력
            if( $w == 'u' && function_exists('social_member_provider_manage') ){
                social_member_provider_manage();
            }
            ?>

            <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
            <li>
                <label for="reg_mb_recommend" class="sound_only"><?php echo _lang('추천인아이디')?></label>
                <input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input" placeholder="<?php echo _lang('추천인아이디')?>">
            </li>
            <?php }  ?>

            <li class="is_captcha_use">
                <?php echo _lang('자동등록방지')?>
                <?php echo captcha_html(); ?>
            </li>
        </ul>
    </div>
    
</div>
<div class="btn_confirm">
    <a href="<?php echo G5_URL ?>" class="btn_cancel"><?php echo _lang('건')?>취소</a>
    <input type="submit" value="<?php echo $w==''? _lang('회원가입'): _lang('정보수정'); ?>" id="btn_submit" class="btn_submit" accesskey="s">
</div>
</form>

    <script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert('._lang("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오").');';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>
    });

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert(_lang("비밀번호를 3글자 이상 입력하십시오."));
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert(_lang("비밀번호가 같지 않습니다."));
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert(_lang("비밀번호를 3글자 이상 입력하십시오."));
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=="") {
            if (f.mb_name.value.length < 1) {
                alert(_lang("이름을 입력하십시오."));
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert(_lang("회원가입을 위해서는 본인확인을 해주셔야 합니다."));
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
                    alert(_lang("회원아이콘이 gif 파일이 아닙니다."));
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert(_lang("본인을 추천할 수 없습니다."));
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

<!-- } 회원정보 입력/수정 끝 -->