<?php
/*	****************************************************************
		新規機材登録
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>新規機材登録 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$maker1 = $_POST["maker1"];
	$name1 = $_POST["name1"];
	$class1 = $_POST["class1"];
	$category1 = $_POST["category1"];
	$status1[1] = $_POST["status1"];
	$status1[2] = $_POST["status2"];
	$status1[3] = $_POST["status3"];
	$status1[4] = $_POST["status4"];
	$status_title1[1] = $_POST["status_title1"];
	$status_title1[2] = $_POST["status_title2"];
	$status_title1[3] = $_POST["status_title3"];
	$status_title1[4] = $_POST["status_title4"];
	$power1 = $_POST["power1"];
	$weight1 = $_POST["weight1"];
	$comment1 = $_POST["comment1"];
	$site1 = $_POST["site1"];
	$manu_site1 = $_POST["manu_site1"];
	$stock1 = $_POST["stock1"];
	$condition1[1] = $_POST["condition1"];
	$condition1[2] = $_POST["condition2"];
	$condition1[3] = $_POST["condition3"];
	$condition1[4] = $_POST["condition4"];
	$condition1[5] = $_POST["condition5"];
	$condition1[6] = $_POST["condition6"];
	$cond_comm1 = $_POST["cond_comm1"];
	$add1 = $_POST["add1"];

	if (is_string($add1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "新規機材追加";
	$pageClass = "equip add";
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
	
		// 入力値の判定
		$showFlag1 = checkInputStringLN($maker1, "メーカー", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($name1, "機材名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[1], $status_title1[1], 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[2], $status_title1[2], 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[3], $status_title1[3], 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[4], $status_title1[4], 50, $showFlag1);
		$showFlag1 = checkInputDoublePLN($power1, "電力", 10, $showFlag1);
		$showFlag1 = checkInputDoublePLN($weight1, "重量", 10, $showFlag1);
		$showFlag1 = checkInputStringLN($comment1, "備考", 2048, $showFlag1);
		$showFlag1 = checkInputStringLN($site1, "メーカーサイト", 500, $showFlag1);
		$showFlag1 = checkInputStringLN($manu_site1, "取説サイト", 500, $showFlag1);
		$showFlag1 = checkInputIntPLN($stock1, "総数", 10, $showFlag1);
		$showFlag1 = checkInputIntPLN($condition1[1], "良好", 10, $showFlag1);
		$showFlag1 = checkInputIntPLN($condition1[2], "微妙", 10, $showFlag1);
		$showFlag1 = checkInputIntPLN($condition1[3], "不調", 10, $showFlag1);
		$showFlag1 = checkInputIntPLN($condition1[4], "故障", 10, $showFlag1);
		$showFlag1 = checkInputIntPLN($condition1[5], "修理", 10, $showFlag1);
		$showFlag1 = checkInputIntPLN($condition1[6], "不明", 10, $showFlag1);
		$showFlag1 = checkInputStringLN($cond_comm1, "コメントの備考", 2048, $showFlag1);


		if ($category1 == "") {
			$showFlag1 = false;
		}
		else {
			// ステータス１～４の列名を取得
			$query2 = "SELECT * FROM `ae_equip_title` WHERE `category` = '".$category1."' LIMIT 1";
			$result2 = mysql_query($query2);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
		}
		
		
		// showFlag1がtrueのときのみ
		if ($showFlag1 == true) {
		
			// 戻るナビゲーション
			$message = "機材リストへ戻る";
			$href = "./?category=".$rec2["id"];
			include($rootDir."visual/nav_back.php");

			// テキスト
			echo "
<p>機材データベースに新しい機種を追加します。</p>
<p>以下の項目に機材のデータを入力してください。<br />
機材について説明を書くには、 [補足] 欄にテキストを入力してください。</p>
<p><em>既に機材データベースに登録されている機種を買い足したときは、このページで追加するのではなく、</em><strong>機材詳細ページの [コンディションの変更] から [総数] を変更</strong><em>してください。</em></p>";

			// 機材データの表示
			echo "
<form action=\"add_conf.php\" method=\"post\">
	<h3>概要</h3>
	<dl>
		<dt>メーカー</dt>
		<dd><input type=\"text\" name=\"maker1\" size=\"25\" value=\"".p($maker1)."\" /></dd>
		<dt>機材名</dt>
		<dd><input type=\"text\" name=\"name1\" size=\"25\" value=\"".p($name1)."\" /></dd>
		<dt>カテゴリー</dt>
		<dd>";
		
		include ($rootDir."visual/equip_topic_path.php");	// パンくずリスト
			
			echo "
			<input type=\"hidden\" name=\"class1\" value=\"".p($class1)."\" />
			<input type=\"hidden\" name=\"category1\" value=\"".p($category1)."\" />
		</dd>
	</dl>
	<h3>機材データ</h3>
	<p class=\"aux\">
		<a href=\"".$rootDir."help/appendix.php?mode=2\" target=\"window\" title=\"別ウィンドウでコネクター記号の凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=2')\">コネクターの凡例</a>&nbsp;
		<a href=\"".$rootDir."help/appendix.php?mode=3\" target=\"window\" title=\"別ウィンドウで色記号の凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=3')\">色の凡例</a>
	</p>
	<dl>
	";
						
				for ($i = 1; $i <= 4; $i++) {
					if (strlen($rec2["status".$i]) > 1) {
						echo "
		<dt>".$rec2["status".$i]."</dt>
		<dd><input type=\"text\" name=\"status".$i."\" size=\"25\" value=\"".p($status1[$i])."\" /></dd>";
					}
				}
				echo "
		<dt>消費電力 (W)</dt>
		<dd><input type=\"text\" name=\"power1\" size=\"25\" value=\"".p($power1)."\" /></dd>
		<dt>重量 (kg)</dt>
		<dd><input type=\"text\" name=\"weight1\" size=\"25\" value=\"".p($weight1)."\" /></dd>
		<dt>備考</dt>
		<dd><textarea name=\"comment1\" cols=\"40\" rows=\"10\">".p($comment1)."</textarea></dd>
		<dt>メーカーサイト</dt>
		<dd><input type=\"text\" name=\"site1\" size=\"40\" value=\"".p($site1)."\" /></dd>
		<dt>取説サイト</dt>
		<dd><input type=\"text\" name=\"manu_site1\" size=\"40\" value=\"".p($manu_site1)."\" /></dd>
	</dl>
	<h3>コンディション</h3>
	<p class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=1\" target=\"window\" title=\"別ウィンドウでコンディションの凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=1')\">コンディションの凡例</a></p>
	<dl class=\"condition\">
		<dt class=\"cond1\">良好</dt>
		<dd class=\"cond1\"><input type=\"text\" name=\"condition1\" id=\"condition1\" size=\"3\" value=\"".p($condition1[1])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond2\">微妙</dt>
		<dd class=\"cond2\"><input type=\"text\" name=\"condition2\" id=\"condition2\" size=\"3\" value=\"".p($condition1[2])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond3\">不調</dt>
		<dd class=\"cond3\"><input type=\"text\" name=\"condition3\" id=\"condition3\" size=\"3\" value=\"".p($condition1[3])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond4\">故障</dt>
		<dd class=\"cond4\"><input type=\"text\" name=\"condition4\" id=\"condition4\" size=\"3\" value=\"".p($condition1[4])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond5\">修理</dt>
		<dd class=\"cond5\"><input type=\"text\" name=\"condition5\" id=\"condition5\" size=\"3\" value=\"".p($condition1[5])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond6\">不明</dt>
		<dd class=\"cond6\"><input type=\"text\" name=\"condition6\" id=\"condition6\" size=\"3\" value=\"".p($condition1[6])."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"cond0\">総数</dt>
		<dd class=\"cond0\"><input type=\"text\" name=\"stock1\" id=\"stock1\" size=\"3\" value=\"".p($stock1)."\" onfocus=\"this.select();\" /></dd>
		<dt class=\"condComm\">備考</dt>
		<dd class=\"condComm\"><textarea name=\"cond_comm1\" id=\"cond_comm\" cols=\"50\" rows=\"10\">".p($cond_comm1)."</textarea></dd>
	</dl>
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"hidden\" name=\"status_title1\" value=\"".p($rec2["status1"])."\" />
		<input type=\"hidden\" name=\"status_title2\" value=\"".p($rec2["status2"])."\" />
		<input type=\"hidden\" name=\"status_title3\" value=\"".p($rec2["status3"])."\" />
		<input type=\"hidden\" name=\"status_title4\" value=\"".p($rec2["status4"])."\" />
		<input type=\"submit\" name=\"submit1\" value=\"確認画面へ\" class=\"submit\" />　
	</p>
</form>";
			
			
			// 戻るナビゲーション
			$message = "機材リストへ戻る";
			$href = "./?category=".$rec2["id"];
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
	$dev["class1"] = $class1;
	$dev["category1"] = $category1;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>