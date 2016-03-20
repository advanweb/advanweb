<?php
/*	****************************************************************
		このサイトの使い方
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>凡例 | Advanced Creators 機材管理サイト</title>
<?php

	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$helpAppendixMode1 = $_GET["mode"];

	// ページのタイトル
	$pageTitle = "凡例";
	$pageClass = "help popupWin";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("../prog/root_dir.php");
	
	// html header
	
	// 各ページ共通のプログラム
	require_once($rootDir."prog/common.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	
	
	if ($helpAppendixMode1 == 1) {
		echo "
<h4>コンディションの凡例</h4>";
		$helpAppendixMode1 = 1; include($rootDir."visual/help_appendix.php");
	}

	else if ($helpAppendixMode1 == 2) {
		echo "
<h4>コネクター記号の凡例</h4>";
		$helpAppendixMode1 = 2; include($rootDir."visual/help_appendix.php");
	}

	else if ($helpAppendixMode1 == 3) {
		echo "
<h4>色記号の凡例</h4>";
		$helpAppendixMode1 = 3; include($rootDir."visual/help_appendix.php");
	}


?>


<div class="submit"><p><input type="submit" name="close" value="閉じる" onclick="window.close();"></p></div>


<?php
	// 表示してみるテスト
	$dev["userID1"] = $_SESSION["ae_userID1"];
	$dev["name1"] = $_SESSION["ae_name1"];
	$dev["nendo1"] = $_SESSION["ae_nendo1"];
	$dev["pass1"] = $_SESSION["ae_pass1"];
	$dev["loginFlag1"] = $_SESSION["ae_loginFlag1"];
	$dev["id1"] = $id1;
	$dev["submit1"] = $submit1;
	$dev["act1"] = $act1;
	$dev["showFlag1"] = $showflag1;
	$dev["query1"] = $query1;
	$dev["query2"] = $query2;
	$dev["mode1"] = $helpAppendixMode1;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_nofooter.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>