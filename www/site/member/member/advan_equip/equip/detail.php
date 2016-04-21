<?php
/*	****************************************************************
		機材詳細
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>機材詳細 | Advanced Creators 機材管理サイト</title>
<?php
	
	// 変数の取得
	$id1 = $_GET["id"];
	$submit1 = $_POST["submit1"];

	if (is_string($login1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "機材詳細";
	$pageClass = "equip detail";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("../prog/root_dir.php");
	
	// html header
	$pageHeader .= "
<script type=\"text/javascript\" src=\"".$rootDir."js/popupwin_open.js\"></script>";
	
	// 各ページ共通のプログラム
	require_once($rootDir."prog/common.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	
	
	
	// 機材データを取得
	if ($id1 == "") {
		$showFlag1 = false;
	}
	else {
		$query1 = "SELECT * FROM `ae_equip` WHERE `id` = ".$id1." LIMIT 1";
		$result1 = mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}
		$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
		
		// nameの存在しないレコード指定したときは表示しない
		if ($rec1["name"] == "") {
			$showFlag1 = false;
		}
		
		// ステータス１～４の列名を取得
		$query2 = "SELECT * FROM `ae_equip_title` WHERE `category` = '".$rec1["category"]."' LIMIT 1";
		$result2 = mysql_query($query2);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}
		$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
	}
		
				
	// showFlag1がtrueのときのみ
	if ($showFlag1 == true) {
					
		// 機材データの表示
		echo "
<h2>".$pageTitle."</h2>
<h3>".p($rec1["maker"])."　".p($rec1["name"])."</h3>";
		
		include ($rootDir."visual/equip_topic_path.php");	// パンくずリスト
		
		// 戻るナビゲーション
		$message = "機材リストへ戻る";
		$href = "./?category=".$rec2["id"];
		include($rootDir."visual/nav_back.php");

		// 機材データ
		echo "
<h4>機材データ</h4>
<table summary=\"機材の詳細データ\">";
				
		for ($i = 1; $i <= 4; $i++) {
			if (strlen($rec2["status".$i]) > 1) {
				echo "
	<tr>
		<th scope=\"row\">".p($rec2["status".$i])."</th>
		<td>".p($rec1["status".$i])."</td>
	</tr>";
			}
		}
		echo "
	<tr>
		<th scope=\"row\">消費電力 (W)</th>
		<td>".p($rec1["power"])."</td>
	</tr>
	<tr>
		<th scope=\"row\">重量 (kg)</th>
		<td>".p($rec1["weight"])."</td>
	</tr>
	<tr>
		<th scope=\"row\">備考</th>
		<td>".p($rec1["comment"])."</td>
	</tr>
</table>";
		
		
		// メーカーサイト・取説サイト
		if ($rec1["site"] != "" || $rec1["manu_site"] != "") {
			echo "
<ul>";

			if ($rec1["site"] != "") {
				echo "
	<li><a href=\"".p($rec1["site"])."\" title=\"メーカーの製品情報サイトへ移動\">メーカーサイト</a></li>";
			}
			if ($rec1["manu_site"] != "") {
				echo "
	<li><a href=\"".p($rec1["manu_site"])."\" title=\"取扱説明書のサイトへ移動\">取説サイト</a></li>";
			}

			echo "
</ul>";
		}
		
		
		// 変更
		echo "
	<form action=\"update.php\" method=\"post\">
		<p class=\"submit\">
			<span class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=2\" target=\"window\" title=\"別ウィンドウでコネクター記号の凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=2')\">コネクターの凡例</a>&nbsp;</span>
			<span class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=3\" target=\"window\" title=\"別ウィンドウで色記号の凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=3')\">色の凡例</a></span>
			<input type=\"hidden\" name=\"id1\" value=\"".p($rec1["id"])."\" /><input type=\"submit\" name=\"update1\" value=\"変更\" title=\"機材データを変更する\" />
		</p>
	</form>";

		
		// コンディション
		echo "
<h4>コンディション</h4>
<dl class=\"condition\">
	<dt class=\"cond1\">良好</dt>
	<dd class=\"cond1\">".p($rec1["condition1"])."</dd>
	<dt class=\"cond2\">微妙</dt>
	<dd class=\"cond2\">".p($rec1["condition2"])."</dd>
	<dt class=\"cond3\">不調</dt>
	<dd class=\"cond3\">".p($rec1["condition3"])."</dd>
	<dt class=\"cond4\">故障</dt>
	<dd class=\"cond4\">".p($rec1["condition4"])."</dd>
	<dt class=\"cond5\">修理</dt>
	<dd class=\"cond5\">".p($rec1["condition5"])."</dd>
	<dt class=\"cond6\">不明</dt>
	<dd class=\"cond6\">".p($rec1["condition6"])."</dd>
	<dt class=\"cond0\">総数</dt>
	<dd class=\"cond0\">".p($rec1["stock"])."</dd>";
	
	if ($rec1[cond_comm] != "") echo "
	<dt class=\"condComm\">備考</dt>
	<dd class=\"condComm\">".p($rec1["cond_comm"])."</dd>";
	
	echo "
</dl>

<form action=\"cond.php\" method=\"post\">
	<p class=\"submit\"><input type=\"hidden\" name=\"id1\" value=\"".p($rec1["id"])."\" />
		<span class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=1\" target=\"window\" title=\"別ウィンドウでコンディションの凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=1')\">コンディションの凡例</a></span>
		<input type=\"submit\" name=\"cond1\" value=\"変更\" title=\"コンディションを変更する\" /></p>
</form>";
		
		
		// 戻るナビゲーション
		$message = "機材リストへ戻る";
		$href = "./?category=".p($rec2["id"]);
		include($rootDir."visual/nav_back.php");
		
		// 完全削除
		echo "
	<form action=\"delete.php\" method=\"post\">
		<p class=\"submit delete\"><input type=\"hidden\" name=\"id1\" value=\"".p($rec1["id"])."\" /><input type=\"submit\" name=\"delete1\" value=\"完全削除\" title=\"この機材をデータベースから完全に削除する\" /></p>
	</form>";
		
	}
	
	// 入力が不正の時のエラー表示
	else {
		echo "
<p class=\"error\">[エラー] リストを表示できませんでした。</p>
<p>[戻る] を押すとトップページに戻ります。</p>
<form action=\"".$rootDir."\" method=\"post\">
	<p class=\"submit\"><input type=\"submit\" name=\"return1\" value=\"戻る\" /></p>
</form>";
		$showFlag1 = false;
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
	$dev["query1"] = $query1;
	$dev["rec1[category]"] = $rec1["category"];
	$dev["category2"] = $category2;
	$dev["query2"] = $query2;
	$dev["num2"] = $num2;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require_once($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require_once($rootDir."prog/db_close.php");

?>