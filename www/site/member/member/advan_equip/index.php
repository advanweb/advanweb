<?php
/*	****************************************************************
		サイトトップ
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Advanced Creators 機材管理サイト</title>
<?php
	
	// 変数の取得
	$login1 = $_POST["login1"];
	
	if (is_string($login1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "トップページ";
	$pageClass = "home";
	$pageTree = 0;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("prog/root_dir.php");
	
	// データベース接続
	require_once($rootDir."prog/db_conn.php");
	
	// ログイン
	if ($act1 == 1) {
		require($rootDir."prog/login.php");
	}
	
	else {
		// 表示してみるテスト
		$dev["userID1"] = $_SESSION["ae_userID1"];
		$dev["name1"] = $_SESSION["ae_name1"];
		$dev["nendo1"] = $_SESSION["ae_nendo1"];
		$dev["pass1"] = $_SESSION["ae_pass1"];
		$dev["loginFlag1"] = $_SESSION["ae_loginFlag1"];
		$dev["login1"] = $login1;
		$dev["act1"] = $act1;
		require_once($rootDir."prog/trans_html.php");
		include($rootDir."prog/dev.php");
	}

	// ログインチェック
	require_once($rootDir."prog/check_login.php");
	
	// link要素 prev, next
	require_once($rootDir."prog/link_prevnext.php");
	
	// datetime変換関数の読み込み
	require_once($rootDir."prog/trans_datetime.php");
	
	// 関数テンプレート
	// require_once($rootDir."prog/func_temp_01.php");
	
	// html header
	
	// ヘッダーの読み込み
	require_once($rootDir."layout/header.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	
	
	
?>

<h2><?php echo "".$pageTitle; ?></h2>
<p>このサイトは、東京工科大学 Advanced Creatorsが所有する機材の情報を管理するサイトです。</p>
<p>機材リストを見るには、左のリストから機材のカテゴリー名を押してください。</p>
<p>このサイトの使い方を見るには、上のメニューから [<a href="help/">使い方</a>] を、このサイトの説明を見るには、上のメニューから [<a href="about/">このサイトについて</a>] を押してください。</p>
<ul class="navBack">
	<li><a href="http://advancedcreators.undo.jp/site/member/">Advanced Creators Members Siteに戻る。</a></li>
</ul>
<h3>更新情報</h3>
<dl class="list">
	<dt>2008.5.6</dt>
	<dd>新規機材登録のページで、新しい機材をデータベースに登録できないバグを修正しました。</dd>
	<dt>2007.12.28</dt>
	<dd><a href="<?php echo "".$rootDir."help/"; ?>">使い方</a> に凡例を追加しました。</dd>
	<dd>新しいカテゴリーを追加しました。</dd>
	<dt>2007.12.20</dt>
	<dd>サイトオープン。</dd>
</dl>
<?php
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require_once($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require_once($rootDir."prog/db_close.php");

?>