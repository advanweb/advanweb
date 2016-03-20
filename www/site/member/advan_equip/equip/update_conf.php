<?php
/*	****************************************************************
		変更の確認
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>変更の確認 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_POST["id1"];
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
	$submit1 = $_POST["submit1"];

	if (is_string($submit1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "変更の確認";
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


	// act1が1のときのみ
	if ($act1 == 1) {
		
		// 入力値の判定
		if ($id1 == "") {
			$showFlag1 = false;
		}
		$showFlag1 = checkInputStringLN($maker1, "メーカー", 50, $showFlag1);
		$showFlag1 = checkInputStringL($name1, "機材名", 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[1], $status_title1[1], 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[2], $status_title1[2], 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[3], $status_title1[3], 50, $showFlag1);
		$showFlag1 = checkInputStringLN($status1[4], $status_title1[4], 50, $showFlag1);
		$showFlag1 = checkInputDoublePLN($power1, "電力", 10, $showFlag1);
		$showFlag1 = checkInputDoublePLN($weight1, "重量", 10, $showFlag1);
		$showFlag1 = checkInputStringLN($comment1, "備考", 2048, $showFlag1);
		$showFlag1 = checkInputStringLN($site1, "メーカーサイト", 500, $showFlag1);
		$showFlag1 = checkInputStringLN($manu_site1, "取説サイト", 500, $showFlag1);

		
		// showFlag1がtrueのとき表示
		if ($showFlag1 == true) {
			
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
			$query2 = "SELECT * FROM `ae_equip_title` WHERE `category` = '".$category1."' LIMIT 1";
			$result2 = mysql_query($query2);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);


			// editFlag1をon
			$_SESSION["ae_editFlag1"] = on;
			

			// 表示
			echo "
<h2>".$pageTitle."</h2>";
			
			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
			
			// テキスト
			echo "
<p>機材データを以下の内容に変更します。</p>
<p>よろしければ [確定] を押してください。<br />
内容を訂正するには [戻る] を押してください。</p>";
			
			// 機材データ
			echo "
<h3>".p($maker1)."　".p($name1)."</h3>";
			
			include ($rootDir."visual/equip_topic_path.php");	// パンくずリスト
			
			echo "
<table summary=\"機材の詳細データ\">";
				
			for ($i = 1; $i <= 4; $i++) {
				if (strlen($rec2["status".$i]) > 1) {
					echo "
	<tr>
		<th scope=\"row\">".p($status_title1[$i])."</th>
		<td>".p($status1[$i])."</td>
	</tr>";
				}
			}
			echo "
	<tr>
		<th scope=\"row\">消費電力 (W)</th>
		<td>".p($power1)."</td>
	</tr>
	<tr>
		<th scope=\"row\">重量 (kg)</th>
		<td>".p($weight1)."</td>
	</tr>
	<tr>
		<th scope=\"row\">備考</th>
		<td>".p($comment1)."</td>
	</tr>
</table>";
		
		
		// メーカーサイト・取説サイト
			if ($site1 != "" || $manu_site1 != "") {
				echo "
<dl>";

				if ($site1 != "") {
					echo "
	<dt><a href=\"".p($site1)."\">メーカーサイト</a></dt>
	<dd><input name=\"site1\" type=\"text\" value=\"".p($site1)."\" size=\"40\" readonly=\"readonly\" onfocus=\"this.select();\" /></dd>";
				}
				if ($manu_site1 != "") {
					echo "
	<dt><a href=\"".p($manu_site1)."\">取説サイト</a></dt>
	<dd><input name=\"manu_site1\" type=\"text\" value=\"".p($manu_site1)."\" size=\"40\" readonly=\"readonly\" onfocus=\"this.select();\" /></dd>";
				}

				echo "
</dl>";
			}

			// submit button
			echo "
<div class=\"submit\">
	<form action=\"update.php\" method=\"post\">
		<p>
			<span class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=2\" target=\"window\" title=\"別ウィンドウでコネクター記号の凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=2')\">コネクターの凡例</a>&nbsp;</span>
			<span class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=3\" target=\"window\" title=\"別ウィンドウで色記号の凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=3')\">色の凡例</a>&nbsp;</span>
			<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
			<input type=\"hidden\" name=\"class1\" value=\"".p($class1)."\" />
			<input type=\"hidden\" name=\"category1\" value=\"".p($category1)."\" />
			<input type=\"submit\" name=\"update1\" value=\"入力画面へ戻る\" />
		</p>
	</form>
	<form action=\"update_result.php\" method=\"post\">
		<p>
			<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
			<input type=\"hidden\" name=\"maker1\" value=\"".$maker1."\" />
			<input type=\"hidden\" name=\"name1\" value=\"".$name1."\" />
			<input type=\"hidden\" name=\"class1\" value=\"".p($class1)."\" />
			<input type=\"hidden\" name=\"category1\" value=\"".p($category1)."\" />
			<input type=\"hidden\" name=\"status1\" value=\"".$status1[1]."\" />
			<input type=\"hidden\" name=\"status2\" value=\"".$status1[2]."\" />
			<input type=\"hidden\" name=\"status3\" value=\"".$status1[3]."\" />
			<input type=\"hidden\" name=\"status4\" value=\"".$status1[4]."\" />
			<input type=\"hidden\" name=\"power1\" value=\"".p($power1)."\" />
			<input type=\"hidden\" name=\"weight1\" value=\"".p($weight1)."\" />
			<input type=\"hidden\" name=\"comment1\" value=\"".$comment1."\" />
			<input type=\"hidden\" name=\"site1\" value=\"".$site1."\" />
			<input type=\"hidden\" name=\"manu_site1\" value=\"".$manu_site1."\" />
			<input type=\"submit\" name=\"regist1\" value=\"確定\" class=\"submit\" />　
		</p>
	</form>
</div>";


			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
		}
		
		
		// エラーのとき
		else {
			echo "
<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
<form action=\"update.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"hidden\" name=\"class1\" value=\"".p($class1)."\" />
		<input type=\"hidden\" name=\"category1\" value=\"".p($category1)."\" />
		<input type=\"submit\" name=\"update1\" value=\"戻る\" />
	</p>
</form>";
		}
	}
	
	
	else {
		echo "
<p class=\"error\">[エラー] 入力情報を表示できませんでした。</p>
<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
<form action=\"update.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"hidden\" name=\"class1\" value=\"".p($class1)."\" />
		<input type=\"hidden\" name=\"category1\" value=\"".p($category1)."\" />
		<input type=\"submit\" name=\"update1\" value=\"戻る\" />
	</p>
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
	$dev["maker1"] = $maker1;
	$dev["name1"] = $name1;
	$dev["class1"] = $class1;
	$dev["category1"] = $category1;
	$dev["status1[1]"] = $status1[1];
	$dev["status1[2]"] = $status1[2];
	$dev["status1[3]"] = $status1[3];
	$dev["status1[4]"] = $status1[4];
	$dev["status_title1[1]"] = $status_title1[1];
	$dev["status_title1[2]"] = $status_title1[2];
	$dev["status_title1[3]"] = $status_title1[3];
	$dev["status_title1[4]"] = $status_title1[4];
	$dev["power1"] = $power1;
	$dev["weight1"] = $weight1;
	$dev["comment1"] = $comment1;
	$dev["site1"] = $site1;
	$dev["manu_site1"] = $manu_site1;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require_once($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require_once($rootDir."prog/db_close.php");

?>