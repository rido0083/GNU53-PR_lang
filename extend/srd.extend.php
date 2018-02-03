<?php
/*
	프로그램 : srd_project
	그누보드5의 Rido군의 이것저것 -_-;;
	ver . beta 0.3
	개발자 : rido0083@gmail.com
	그누보드 : rido
	개발일 : 2018-01-18
	- 번역 플러그인과 알림 서비스를 지원함
	- 소스 수정 / 사용은 알아서들 하시고 재배포 및 소스포함시 저작권만 유지해주세요
	- 수정시 수정사항을 메일로 피드백 해주시면 감사하겠습니다.
*/

/*
 * 공통함수 (srd project의 공통사용 함수)
 * */

//해당 플러그인에 필요한 디비가 있는지를 체크후 없다면 디비생성
function srd_exist_table($table_name) {
    $result = @sql_query("SHOW TABLES LIKE '{$table_name}'");
    if ($result->num_rows != 0) {
        return true;
    } else {
        return false;
    }
}

//환경설정을 위한 디비를 생성함
$srd['srd_config'] = G5_TABLE_PREFIX.'srd_config';
$is_config_db = srd_exist_table ($srd['srd_config']);

if ($is_config_db == false) {
    //디비를 생성함
    //기본 언어셋 관리를 위한 DB
    $is_add_config = "
      CREATE TABLE `{$srd['srd_config']}` (
      `id` int(16) NOT NULL NOT NULL AUTO_INCREMENT ,
      `c_name` varchar(255) NOT NULL,
      `c_config` text NOT NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;		
	";
    @sql_query($is_add_config);
    $config_sql = " 
      INSERT INTO `{$srd['srd_config']}` (`c_name`, `c_config`) VALUES ('srd_lang' , 
     ";
    //@sql_query($config_sql);
}

//환경변수 설정

/*
 * 번역플러그인 0.1
 * 아주 단순한 번역 function기능만을 제공
 * */

// 이하 번역플러그인
//변수명 $g5를 쓰던것을 $srd로 변경 (해피정님 의견)
$srd['srd_lang'] = G5_TABLE_PREFIX.'srd_lang';
$is_lang_db = srd_exist_table ($srd['srd_lang']);

if ($is_lang_db == false) {
    //디비를 생성함
    //기본 언어셋 관리를 위한 DB
    $is_add_lang = "
      CREATE TABLE `{$srd['srd_lang']}` (
      `id` int(16) NOT NULL NOT NULL AUTO_INCREMENT ,
      `include` varchar(255) NOT NULL,
      `lang` char(10) NOT NULL,
      `tokey` text NOT NULL,
      `getval` text NOT NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;		
	";
    @sql_query($is_add_lang);
    $input_sql = "
INSERT INTO `{$srd['srd_lang']}` (`id`, `include`, `lang`, `tokey`, `getval`) VALUES
(1, 'tail', 'ja', '개인정보처리방침', '個人情報の処理方針'),
(2, 'head33', 'en', '새글', 'New article'),
(3, 'head33', 'ja', '새글', '新着'),
(4, 'head3', 'en', '정보수정', 'Information modification'),
(5, 'head3', 'ja', '정보수정', '登録情報の修正'),
(6, 'head', 'en', '로그아웃', 'Log Out'),
(7, 'head', 'ja', '로그아웃', 'ログアウト'),
(8, 'head', 'en', '관리자', 'Administrator'),
(9, 'head', 'ja', '관리자', '管理者'),
(10, 'head', 'en', '회원가입', 'Sign Up'),
(11, 'head', 'ja', '회원가입', '会員登録'),
(12, 'head', 'en', '로그인', 'Log In'),
(13, 'head', 'ja', '로그인', 'ログイン'),
(14, 'head2', 'en', '쇼핑몰', 'Shopping mall'),
(15, 'head2', 'ja', '쇼핑몰', 'ECサイト'),
(16, 'head', 'en', '커뮤니티', 'Community'),
(17, 'head', 'ja', '커뮤니티', 'コミュニティー'),
(18, 'head', 'en', '검색어 필수', 'Search Word Required'),
(19, 'head', 'ja', '검색어 필수', '検索必須'),
(20, 'head', 'en', '검색어를 입력해주세요', 'Please enter your search word'),
(21, 'head', 'ja', '검색어를 입력해주세요', '検索kキーワードを入力してください。'),
(22, 'head', 'en', '검색', 'Search'),
(23, 'head', 'ja', '검색', '検索'),
(24, 'head', 'en', '검색어는 두글자 이상 입력하십시오.', 'Please enter at least two characters for the search word.'),
(25, 'head', 'ja', '검색어는 두글자 이상 입력하십시오.', '全角2文字以上で検索してください。'),
(26, 'head', 'en', '빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', 'You can enter only one space in the search term for quick search.'),
(27, 'head', 'ja', '빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', '検索表示速度改善のため空白は一つのみ入力できます。'),
(28, 'head', 'en', '메인메뉴', 'Main Menu'),
(29, 'head', 'ja', '메인메뉴', 'メインメニュー'),
(30, 'head', 'en', '하위분류', 'Sub category'),
(31, 'head', 'ja', '하위분류', 'サブカテゴリ'),
(34, 'head', 'en', '에서 설정하실 수 있습니다.', 'Can be set in.'),
(35, 'head', 'ja', '에서 설정하실 수 있습니다.', 'から設定できます。'),
(36, 'head', 'en', '전체메뉴', 'All Menu'),
(37, 'head', 'ja', '전체메뉴', '全てのメニュー'),
(38, 'head', 'en', '메뉴 준비 중입니다.', 'Preparing menu.'),
(39, 'head', 'ja', '메뉴 준비 중입니다.', '準備中'),
(40, 'head', 'en', '사이트 내 전체검색', 'Full search within the site'),
(41, 'head', 'ja', '사이트 내 전체검색', 'サイト内検索'),
(42, 'head', 'en', '1:1문의', '1: 1 Contact'),
(43, 'head', 'ja', '1:1문의', '1:1お問い合わせ'),
(44, 'head', 'en', '접속자', 'Connector'),
(45, 'head', 'ja', '접속자', '接続している人'),
(46, 'head', 'en', '한국어', 'Korean'),
(47, 'head', 'ja', '한국어', '韓国語'),
(48, 'head', 'en', '영어', 'English'),
(49, 'head', 'ja', '영어', '英語'),
(50, 'head', 'en', '일본어', 'Japanese'),
(51, 'head', 'ja', '일본어', '日本語'),
(52, 'head', 'en', '언어', 'language'),
(53, 'head', 'ja', '언어', '言語'),
(54, 'tail', 'en', '개인정보처리방침', 'Privacy policy'),
(55, 'tail', 'en', '회사소개', 'About Us'),
(56, 'tail', 'ja', '회사소개', '会社紹介'),
(57, 'tail', 'en', '서비스이용약관', 'Terms of Service'),
(58, 'tail', 'ja', '서비스이용약관', 'サービス利用規約'),
(59, 'tail', 'en', '모바일버전', 'Mobile version'),
(60, 'tail', 'ja', '모바일버전', 'スマホ版'),
(61, 'head', 'zh_CN', '관리자모드 > 환경설정 > 메뉴설정', '后台 &gt; 环境设置 &gt; 菜单设置'),
(62, 'head', 'zh_CN', '관리자모드 > 환경설정 > 메뉴설정', '后台 > 环境设置 > 菜单设置'),
(63, 'head', 'zh_CN', '1:1문의', '1:1交谈'),
(64, 'head', 'zh_CN', '개인정보처리방침', '隐私权保护声明'),
(65, 'head', 'zh_CN', '검색', '搜索'),
(66, 'head', 'zh_CN', '검색어 필수', '必填关键词'),
(67, 'head', 'zh_CN', '검색어는 두글자 이상 입력하십시오.', '关键词不能少于两个字'),
(68, 'head', 'zh_CN', '검색어를 입력해주세요', '请输入关键词'),
(69, 'head', 'zh_CN', '관리자', '管理员'),
(70, 'head', 'zh_CN', '로그아웃', '退出登陆'),
(71, 'head', 'zh_CN', '로그인', '登陆'),
(72, 'head', 'zh_CN', '메뉴 준비 중입니다.', '菜单正在准备中'),
(73, 'head', 'zh_CN', '메인메뉴', '主菜单'),
(74, 'head', 'zh_CN', '모바일버전', '手机版'),
(75, 'head', 'zh_CN', '빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', '为了确保快速搜索，只能输入一个空白'),
(76, 'head', 'zh_CN', '사이트 내 전체검색', '站内搜索'),
(77, 'head', 'zh_CN', '서비스이용약관', '最新'),
(78, 'head', 'zh_CN', '새글', '最新'),
(79, 'head', 'zh_CN', '서비스이용약관', '使用条款'),
(80, 'head', 'zh_CN', '쇼핑몰', '商城'),
(81, 'head', 'zh_CN', '언어', '语言'),
(82, 'head', 'zh_CN', '에서 설정하실 수 있습니다.', '上可以设置'),
(83, 'head', 'zh_CN', '영어', '英文'),
(84, 'head', 'zh_CN', '일본어', '日文'),
(85, 'head', 'zh_CN', '전체메뉴', '全部菜单'),
(86, 'head', 'zh_CN', '접속자', '在线'),
(87, 'head', 'zh_CN', '정보수정', '修改资料'),
(88, 'head', 'zh_CN', '커뮤니티', '社区'),
(89, 'head', 'zh_CN', '하위분류', '附菜单'),
(90, 'head', 'zh_CN', '한국어', '韩文'),
(91, 'head', 'zh_CN', '회사소개', '公司简介'),
(92, 'head', 'zh_CN', '회원가입', '注册'),
(93, 'head', 'en', '중국어', 'Chinese'),
(94, 'head', 'ja', '중국어', '中国語'),
(95, 'head', 'zh_CN', '중국어', '中文'),
(96, 'head', 'en', '관리자모드 &gt; 환경설정 &gt; 메뉴설정', 'Admin mode > Preferences > Menu settings'),
(97, 'head', 'ja', '관리자모드 &gt; 환경설정 &gt; 메뉴설정', '管理画面 > 環境設定 > メニュー設置'),
(98, 'head', 'zh_CN', '관리자모드 &gt; 환경설정 &gt; 메뉴설정', '后台 > 环境设置 > 菜单设置');
    
    ";
    @sql_query($input_sql);
}


// 언어 설정
$locale = "ko_KR";
if (isset($_GET["locale"]))
    $locale = $_GET["locale"];
else if (isset($_SESSION["locale"]))
    $locale = $_SESSION["locale"];
set_session('locale', $locale);
putenv("LANG={$locale}");
setlocale(LC_ALL, "$locale.UTF-8");

$domain = "gnuboard5";
bindtextdomain($domain, G5_PATH.'/locale');
textdomain($domain);

//언어셋을 선택한다.
/*
function lang_ch ($l) {
    session_start($l);
    $_SESSION['lang'] = $l;
    $locale = $l;
    $_SESSION["locale"] = $l;
    goto_url($_SERVER["PHP_SELF"]);
}
*/
//기본언어를 한국어로 선택
if (!$_SESSION['lang']) {
    $_SESSION['lang'] = 'ko_KR';
    $_SESSION['locale'] = 'ko_KR';
}

$srd_lang = $_SESSION['lang'];
//echo $srd_lang;
//언어분류 (기본 언어는 추가해서 사용가능) 한국어는 기본언어라 생략 아래는 언어셋 이름 예제
/*
    ko
    en_US
    ja_JP
    zh_CN
 */
//사용할 언어셋을 선택 배열로 추가가능 (기본은 한국어 / 영어 / 일본어)
$iu_lnagType = array(
    'en_US','ja_JP','zh_CN'
);
//메뉴 구성을 위한 배열 (기본은 한국어 / 영어 / 일본어)
$iu_lnagMenu = array(
    'ko_KR' => '한국어' ,
    'en_US' => '영어' ,
    'ja_JP' => '일본어' ,
    'zh_CN' => '중국어' ,
);

//언어별 배열을 만든다.
$srd_rlang = array();
$sql = "select * from {$srd['srd_lang']} where lang = '{$srd_lang}'";
$result = sql_query($sql);

for ($i=0 ; $row = sql_fetch_array($result) ; $i++) {
    $srd_rlang[$row['tokey']] = $row['getval'];
}

function _lang ($str) {
    global $srd_rlang;
    global $srd_lang;
    if ($srd_rlang[$str]) {
        return $srd_rlang[$str];
    } else {
        return $str;
    }
}
//echo _lang('테스트 입니다 번역이죠');

/*
 * 이하부분은 그누보드 원본의 function을 주석처리 후 사용하세요 *
 * */
?>
