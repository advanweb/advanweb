<?php
/*	****************************************************************
		変更完了
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>削除完了 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_POST["id1"];
	$regist1 = $_POST["regist1"];

	if (is_string($regist1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "削除完了";
	$pageClass = "equip delete";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("../prog/root_dir.php");
	
	// html header
	
	// 各ページ共通のプログラム
	require_once($rootDir."prog/common.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	


	// act1
	if ($act1 != 1) {
		$showFlag1 = false;
	}
	
	// 入力値の判定
	if ($id1 == "") {
		$_SESSION["ae_editFlag1"] = false;
	}
	if ($showFlag1 != true) {
		$_SESSION["ae_editFlag1"] = false;
	}

	// editFlag1がtrueのときのみ登録
	if ($_SESSION["ae_editFlag1"] == true) {
		// editFlag1をoff
		$_SESSION["ae_editFlag1"] = false;

		// 削除
		$query3 = "DELETE FROM `ae_equip` WHERE `id` = ".$id1." LIMIT 1";
		// 実行して結果を入れる
		mysql_query($query3);
		if (mysql_errno() != 0) {
			echo mysql_error();
			echo "
<p class=\"error\">[エラー] 削除できませんでした。</p>
<p>[機材詳細へ戻る] を押すと機材詳細に戻ります。</p>";
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
		}
		else {

			// 結果の表示
			echo "
<h2>".$pageTitle."</h2>
<p>機材を完全削除しました。 [トップページへ戻る] を押すとトップページに戻ります。</p>";
			$message = "トップページへ戻る";
			$href = "../";
			include($rootDir."visual/nav_back.php");
		}
	}
		
	// エラーのとき
	else {
		echo "<br>
<p class=\"error\">[エラー] 連続登録を防止する機能が働いたため、登録できませんでした。</p>
<p>[機材詳細へ戻る] を押すと機材詳細に戻ります。</p>";
		$message = "機材詳細へ戻る";
		$href = "detail.php?id=".$id1;
		include($rootDir."visual/nav_back.php");
	}


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
	$dev["editFlag1"] = $_SESSION["ae_editFlag1"];
	$dev["query1"] = $query1;
	$dev["query2"] = $query2;
	$dev["class1"] = $class1;
	$dev["category1"] = $category1;
	$dev["rec1[name]"] = $rec1["name"];
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>