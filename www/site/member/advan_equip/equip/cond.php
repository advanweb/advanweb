<?php
/*	****************************************************************
		コンディション変更
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>コンディション変更 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_POST["id1"];
	$cond1 = $_POST["cond1"];

	if (is_string($cond1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "コンディション変更";
	$pageClass = "equip cond";
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


echo "
<h2>".$pageTitle."</h2>";


	// act1
	if ($act1 == 1) {
	
		if ($id1 == "") {
			$showFlag1 = false;
		}
		else {
			// 機材データを取得
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
<h3>".p($rec1["maker"])."　".p($rec1["name"])."</h3>";
			
			include ($rootDir."visual/equip_topic_path.php");	// パンくずリスト
			
			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
			
			// テキスト
			echo "
<p>機材のコンディションと所持数を変更します。</p>
<p>該当する項目に個数を入力してください。<br />
コンディションについて説明を書くには、 [備考] 欄にテキストを入力してください。</p>";
			
			// コンディション
			echo "
<h4>コンディション</h4>
<p class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=1\" target=\"window\" title=\"別ウィンドウでコンディションの凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=1')\">コンディションの凡例</a></p>
<form action=\"cond_conf.php\" method=\"post\">
	<dl class=\"condition\">
		<dt class=\"cond1\">良好</dt>
		<dd class=\"cond1\"><input type=\"text\" name=\"condition1\" id=\"condition1\" size=\"3\" value=\"".p($rec1["condition1"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond2\">微妙</dt>
		<dd class=\"cond2\"><input type=\"text\" name=\"condition2\" id=\"condition2\" size=\"3\" value=\"".p($rec1["condition2"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond3\">不調</dt>
		<dd class=\"cond3\"><input type=\"text\" name=\"condition3\" id=\"condition3\" size=\"3\" value=\"".p($rec1["condition3"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond4\">故障</dt>
		<dd class=\"cond4\"><input type=\"text\" name=\"condition4\" id=\"condition4\" size=\"3\" value=\"".p($rec1["condition4"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond5\">修理</dt>
		<dd class=\"cond5\"><input type=\"text\" name=\"condition5\" id=\"condition5\" size=\"3\" value=\"".p($rec1["condition5"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond6\">不明</dt>
		<dd class=\"cond6\"><input type=\"text\" name=\"condition6\" id=\"condition6\" size=\"3\" value=\"".p($rec1["condition6"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond0\">総数</dt>
		<dd class=\"cond0\"><input type=\"text\" name=\"stock1\" id=\"stock1\" size=\"3\" value=\"".p($rec1["stock"])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"condComm\">備考</dt>
		<dd class=\"condComm\"><textarea name=\"cond_comm1\" id=\"cond_comm\" cols=\"50\" rows=\"10\">".p($rec1["cond_comm"])."</textarea></dd>
	</dl>
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"reset\" name=\"reset1\" value=\"表示をリセット\" />
		<input type=\"submit\" name=\"submit1\" class=\"submit\" value=\"確認画面へ\" />
	</p>
</form>";


			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
		}
	}
	
	else {
		$showFlag1 = false;
	}
	
	// showFlag1エラーの時
	if ($showFlag1 != true) {		
		echo "
<p class=\"error\">[エラー] リストを表示できませんでした。</p>
<p>[戻る] を押すとトップページに戻ります。</p>
<form action=\"".$rootDir."\" method=\"post\" />
	<p class=\"submit\"><input type=\"submit\" name=\"return1\" value=\"戻る\" /></p>
</form>";
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
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>