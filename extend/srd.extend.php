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
//해당 플러그인에 필요한 디비가 있는지를 체크후 없다면 디비생성 (디비 생성 없이 어떻게 해보려고 했는데 힘들듯)
function exist_table($table_name) {
    $result = sql_query("SHOW TABLES LIKE '{$table_name}'");
    //$row = sql_fetch_array($result, MYSQL_NUM);
    //return ($row === false)? false : true;
    return ($row === true)? true : false;
}

/*
 * 번역플러그인 0.1
 * 아주 단순한 번역 function기능만을 제공
 * */

// 이하 번역플러그인
$g5['g5_srd_lang'] = G5_TABLE_PREFIX.'srd_lang';
$is_lang_db = exist_table ($g5['g5_srd_lang']);

if ($is_lang_db == false) {
    //디비를 생성함
    $is_add_lang = "
      CREATE TABLE `{$g5['g5_srd_lang']}` (
      `id` int(16) NOT NULL,
      `include` varchar(255) NOT NULL,
      `lang` char(10) NOT NULL,
      `tokey` text NOT NULL,
      `getval` text NOT NULL
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;		
	";
    @sql_query($is_add_lang);
    $input_sql = "
INSERT INTO `{$g5['g5_srd_lang']}` (`include`, `lang`, `tokey`, `getval`) VALUES
( 'tail', 'ja_JP', '개인정보처리방침', '個人情報の処理方針'),
( 'head33', 'en_US', '새글', 'New'),
( 'head33', 'ja_JP', '새글', '新しく記事'),
( 'head3', 'en_US', '정보수정', 'Changing information'),
( 'head3', 'ja_JP', '정보수정', '情報の修正'),
('head', 'en_US', '로그아웃', 'Log out'),
('head', 'ja_JP', '로그아웃', 'ログアウト'),
('head', 'en_US', '관리자', 'manager'),
( 'head', 'ja_JP', '관리자', '管理者'),
( 'head', 'en_US', '회원가입', 'Sign Up'),
( 'head', 'ja_JP', '회원가입', '会員登録'),
( 'head', 'en_US', '로그인', 'login'),
( 'head', 'ja_JP', '로그인', 'ログイン'),
( 'head2', 'en_US', '쇼핑몰', 'shopping mall'),
( 'head2', 'ja_JP', '쇼핑몰', 'ショッピングモール'),
( 'head', 'en_US', '커뮤니티', 'community'),
( 'head', 'ja_JP', '커뮤니티', 'コミュニティ'),
( 'head', 'en_US', '검색어 필수', 'Search term required'),
( 'head', 'ja_JP', '검색어 필수', '検索必須'),
( 'head', 'en_US', '검색어를 입력해주세요', 'Please enter your search term'),
( 'head', 'ja_JP', '검색어를 입력해주세요', '検索用語を入力してください'),
( 'head', 'en_US', '검색', 'Search'),
( 'head', 'ja_JP', '검색', '検索'),
( 'head', 'en_US', '검색어는 두글자 이상 입력하십시오.', 'Please enter at least two characters.'),
( 'head', 'ja_JP', '검색어는 두글자 이상 입력하십시오.', '検索キーワードは2文字入力してください。'),
( 'head', 'en_US', '빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', 'You can enter only one space in the search term for quick search.'),
( 'head', 'ja_JP', '빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.', 'クイック検索のためのクエリに空白は一つだけ入力することができます。'),
( 'head', 'en_US', '메인메뉴', 'Main Menu'),
( 'head', 'ja_JP', '메인메뉴', 'メインメニュー'),
( 'head', 'en_US', '하위분류', 'Sub category'),
( 'head', 'ja_JP', '하위분류', 'サブカテゴリ'),
( 'head', 'en_US', '관리자모드 &gt; 환경설정 &gt; 메뉴설정', 'Administrator Mode> Preferences> Menu Settings'),
( 'head', 'ja_JP', '관리자모드 &gt; 환경설정 &gt; 메뉴설정', '管理者モード>環境設定>メニュー設定'),
( 'head', 'en_US', '에서 설정하실 수 있습니다.', 'Can be set in.'),
( 'head', 'ja_JP', '에서 설정하실 수 있습니다.', 'で設定することができます。'),
( 'head', 'en_US', '전체메뉴', 'All menus'),
( 'head', 'ja_JP', '전체메뉴', '全メニュー'),
( 'head', 'en_US', '메뉴 준비 중입니다.', 'The menu is being prepared.'),
( 'head', 'ja_JP', '메뉴 준비 중입니다.', 'メニュー準備中です'),
( 'head', 'en_US', '사이트 내 전체검색', 'Full search within the site'),
( 'head', 'ja_JP', '사이트 내 전체검색', 'サイト内検索'),
( 'head', 'en_US', '1:1문의', '1:1 contact'),
( 'head', 'ja_JP', '1:1문의', '1：1お問い合わせ'),
( 'head', 'en_US', '접속자', 'User'),
( 'head', 'ja_JP', '접속자', '接続者'),
( 'head', 'en_US', '한국어', 'korea'),
( 'head', 'ja_JP', '한국어', 'korea'),
( 'head', 'en_US', '영어', 'english'),
( 'head', 'ja_JP', '영어', 'english'),
( 'head', 'en_US', '일본어', 'japan'),
( 'head', 'ja_JP', '일본어', 'japan'),
( 'head', 'en_US', '언어', 'language'),
( 'head', 'ja_JP', '언어', '言語'),
( 'tail', 'en_US', '개인정보처리방침', 'Privacy policy'),
( 'tail', 'en_US', '회사소개', 'About Us'),
( 'tail', 'ja_JP', '회사소개', '会社紹介'),
( 'tail', 'en_US', '서비스이용약관', 'Terms of Service'),
( 'tail', 'ja_JP', '서비스이용약관', 'サービス利用規約'),
( 'tail', 'en_US', '모바일버전', 'Mobile version'),
( 'tail', 'ja_JP', '모바일버전', 'モバイル版');
    
    ";
    @sql_query($input_sql);
}

//언어셋을 선택한다.
function lang_ch ($l) {
    session_start($l);
    $_SESSION['lang'] = $l;
    goto_url($_SERVER["PHP_SELF"]);
}

//기본언어를 한국어로 선택
if (!$_SESSION['lang']) {
    $_SESSION['lang'] = 'ko';
}

$srd_lang = $_SESSION['lang'];
//echo $srd_lang;
//언어분류 (기본 언어는 추가해서 사용가능) 한국어는 기본언어라 생략 아래는 언어셋 이름 예제
/*
    ko_KR
    en_US
    ja_JP
    zh_CN
 */
//사용할 언어셋을 선택 배열로 추가가능 (기본은 한국어 / 영어 / 일본어)
$iu_lnagType = array(
    'en_US','ja_JP'
);
//메뉴 구성을 위한 배열 (기본은 한국어 / 영어 / 일본어)
$iu_lnagMenu = array(
    'ko_KR' => '한국어' ,
    'en_US' => '영어' ,
    'ja_JP' => '일본어' ,
);

//언어별 배열을 만든다.
$srd_rlang = array();
$sql = "select * from {$g5['g5_srd_lang']} where lang = '{$srd_lang}'";
$result = sql_query($sql);

for ($i=0 ; $row = sql_fetch_array($result) ; $i++) {
    $srd_rlang[$row['tokey']] = $row['getval'];
}
function _lang ($str) {
    global $srd_rlang;
    if ($srd_rlang[$str]) {
        return $srd_rlang[$str];
    } else {
        return $str;
    }
}
//echo _lang('테스트');


/*
 * 이하부분은 그누보드 원본의 function을 주석처리 후 사용하세요 *
 * */
?>