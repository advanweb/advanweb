<?php
/*	****************************************************************
		機材データ変更
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>機材データ変更 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_POST["id1"];
	$update1 = $_POST["update1"];
	$nclass1 = $_POST["class1"];
	$ncategory0 = $_POST["category0"];
	$ncategory1 = $_POST["category1"];
	$ncategory2 = $_POST["category2"];
	$ncategory3 = $_POST["category3"];
	$ncategory4 = $_POST["category4"];
	$regist1 = $_POST["regist1"];

	if (is_string($update1) == true) {
		$act1 = 1;
	}
	else if (is_string($regist1) == true) {
		$act1 = 2;
	}

	// ページのタイトル
	$pageTitle = "機材データ変更";
	$pageClass = "equip update";
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


	// act1:機材データ変更 or 2:カテゴリー変更後の機材データ変更
	if ($act1 == 1 || $act1 == 2) {
	
		// 入力値の判定
		$showFlag1 = checkInputStringLN($nclass1, "新しい部署名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($ncategory0, "新しいカテゴリー名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($ncategory1, "新しいカテゴリー名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($ncategory2, "新しいカテゴリー名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($ncategory3, "新しいカテゴリー名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($ncategory4, "新しいカテゴリー名", 50, $showFlag1);
		

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
	
			// 部署の取得
			if ($nclass1 == "") {
				$class1 = $rec1["class"];
			}
			else {
				$class1 = $nclass1;
			}
	
			// カテゴリーの取得
			if ($ncategory1 == "") {
				$category1 = $rec1["category"];
			}
			else {
				// クラスからカテゴリーを選択
				switch ($class1) {
					case "音響":
						$category1 = $ncategory0;
						break;
					case "照明":
						$category1 = $ncategory1;
						break;
					case "ケーブル":
						$category1 = $ncategory2;
						break;
					case "スタンド":
						$category1 = $ncategory3;
						break;
					case "アクセサリー":
						$category1 = $ncategory4;
						break;
					default:
						echo "<p class=\"error\">[エラー] 項目が選択されていません。</p>";
						$showFlag1 = false;
				}
			}
			
			// 新しいカテゴリーでステータス１～４の列名を取得
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
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
			
			// テキスト
			echo "
<p>機材データを変更します。</p>
<p>変更する項目に新しいデータを入力してください。<br />
機材について説明を書くには、 [備考] 欄にテキストを入力してください。</p>";

			// 機材データの表示
			echo "
<form action=\"update_conf.php\" method=\"post\">
	<h3>概要</h3>
	<dl>
		<dt>メーカー</dt>
		<dd><input type=\"text\" name=\"maker1\" size=\"25\" value=\"".p($rec1["maker"])."\" /></dd>
		<dt>機材名</dt>
		<dd><input type=\"text\" name=\"name1\" size=\"25\" value=\"".p($rec1["name"])."\" /></dd>
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
		<dd><input type=\"text\" name=\"status".$i."\" size=\"25\" value=\"".p($rec1["status".$i])."\" /></dd>";
					}
				}
				echo "
		<dt>消費電力 (W)</dt>
		<dd><input type=\"text\" name=\"power1\" size=\"25\" value=\"".p($rec1["power"])."\" /></dd>
		<dt>重量 (kg)</dt>
		<dd><input type=\"text\" name=\"weight1\" size=\"25\" value=\"".p($rec1["weight"])."\" /></dd>
		<dt>備考</dt>
		<dd><textarea name=\"comment1\" cols=\"40\" rows=\"10\">".p($rec1["comment"])."</textarea></dd>
		<dt>メーカーサイト</dt>
		<dd><input type=\"text\" name=\"site1\" size=\"40\" value=\"".p($rec1["site"])."\" /></dd>
		<dt>取説サイト</dt>
		<dd><input type=\"text\" name=\"manu_site1\" size=\"40\" value=\"".p($rec1["manu_site"])."\" /></dd>
	</dl>
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".$id1."\" />
		<input type=\"hidden\" name=\"status_title1\" value=\"".p($rec2["status1"])."\" />
		<input type=\"hidden\" name=\"status_title2\" value=\"".p($rec2["status2"])."\" />
		<input type=\"hidden\" name=\"status_title3\" value=\"".p($rec2["status3"])."\" />
		<input type=\"hidden\" name=\"status_title4\" value=\"".p($rec2["status4"])."\" />
		<input type=\"reset\" name=\"reset1\" value=\"変更をリセット\" />
		<input type=\"submit\" name=\"submit1\" value=\"確認画面へ\" class=\"submit\" />　
	</p>
</form>";


			// カテゴリーの変更
			echo "
<p>機材の登録されているカテゴリーを変更するには、 [カテゴリーの変更] を押してください。</p>
<form action=\"cate.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"submit\" name=\"cate1\" value=\"カテゴリーの変更\" />
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
	$dev["class1"] = $class1;
	$dev["category1"] = $category1;
	$dev["nclass1"] = $nclass1;
	$dev["ncategory1"] = $ncategory1;
	$dev["rec2[status1]"] = $rec2["status1"];
	$dev["rec2[status2]"] = $rec2["status2"];
	$dev["rec2[status3]"] = $rec2["status3"];
	$dev["rec2[status4]"] = $rec2["status4"];
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>