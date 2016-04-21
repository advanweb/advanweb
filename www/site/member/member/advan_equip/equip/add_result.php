<?php
/*	****************************************************************
		登録完了
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>登録完了 | Advanced Creators 機材管理サイト</title>
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
	$regist1 = $_POST["regist1"];

	if (is_string($regist1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "登録完了";
	$pageClass = "equip add";
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
	$showFlag1 = checkInputIntPL($stock1, "総数", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[1], "良好", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[2], "微妙", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[3], "不調", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[4], "故障", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[5], "修理", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[6], "不明", 10, $showFlag1);
	$showFlag1 = checkInputStringLN($cond_comm1, "コメントの備考", 2048, $showFlag1);

	// 同じ名前がないかチェック
	// クエリ
	$query4 = "SELECT * FROM `ae_equip` WHERE `name` = '".$name1."'";
	// 実行して結果を入れる
	$result4 = mysql_query($query4);
	if (mysql_errno() != 0) {
		echo mysql_error();
		$showFlag1 = false;
	}
	// 結果の個数
	$num4 = mysql_num_rows($result4);
	// 個数が0でないときエラー
	if ($num4 > 0) {
		$showFlag1 = false;
	}

	if ($showFlag1 != true) {
		$_SESSION["ae_editFlag1"] = false;
	}

	// editFlag1がtrueのときのみ登録
	if ($_SESSION["ae_editFlag1"] == true) {
		// editFlag1をoff
		$_SESSION["ae_editFlag1"] = false;

		// 現在のDTFを取得
		$dtf1 = getDtf();

		// クエリ
		$query1 = "INSERT INTO `ae_equip` ( `id` , `name` , `maker` , `class` , `category` , `stock` , `condition1` , `condition2` , `condition3` , `condition4` , `condition5` , `condition6` , `cond_comm` , `comment` , `power` , `weight` , `status1` , `status2` , `status3` , `status4` , `site` , `manu_site` , `date` ) 
			VALUES (
			NULL , '".$name1."', '".$maker1."', '".$class1."', '".$category1."', '".$stock1."', '".$condition1[1]."', '".$condition1[2]."', '".$condition1[3]."', '".$condition1[4]."', '".$condition1[5]."', '".$condition1[6]."', '".$cond_comm1."', '".$comment1."', '".$power1."', '".$weight1."', '".$status1[1]."', '".$status1[2]."', '".$status1[3]."', '".$status1[4]."', '".$site1."', '".$manu_site1."', '".$dtf1."')
			";
		// 実行して結果を入れる
		mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
			echo "
<p class=\"error\">[エラー] 登録できませんでした。</p>
<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
<form action=\"add.php\" method=\"post\">
	<p class=\"submit\">
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
			<input type=\"hidden\" name=\"stock1\" value=\"".p($stock1)."\" />
			<input type=\"hidden\" name=\"condition1\" value=\"".p($condition1[1])."\" />
			<input type=\"hidden\" name=\"condition2\" value=\"".p($condition1[2])."\" />
			<input type=\"hidden\" name=\"condition3\" value=\"".p($condition1[3])."\" />
			<input type=\"hidden\" name=\"condition4\" value=\"".p($condition1[4])."\" />
			<input type=\"hidden\" name=\"condition5\" value=\"".p($condition1[5])."\" />
			<input type=\"hidden\" name=\"condition6\" value=\"".p($condition1[6])."\" />
			<input type=\"hidden\" name=\"cond_comm1\" value=\"".$cond_comm1."\" />
		<input type=\"submit\" name=\"add1\" value=\"戻る\" />
	</p>
</form>";
		}
		else {
			// データを取得
			$query2 = "SELECT `id` FROM `ae_equip` WHERE `name` = '".$name1."' LIMIT 1";
			$result2 = mysql_query($query2);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
	
			// 結果の表示
			echo "
<h2>".$pageTitle."</h2>
<p>機材を登録しました。 [機材詳細へ] を押すと機材詳細に移動します。</p>";
			$message = "機材詳細へ";
			$href = "detail.php?id=".$rec2["id"];
			include($rootDir."visual/nav_back.php");
		}
	}
		
	// エラーのとき
	else {
		echo "
<p class=\"error\">[エラー] 連続登録を防止する機能が働いたため、登録できませんでした。</p>
<p>[機材詳細へ戻る] を押すと機材リストに戻ります。</p>";
		$message = "機材リストへ戻る";
		$href = "./";
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
	$dev["stock1"] = $stock1;
	$dev["condition1[1]"] = $condition1[1];
	$dev["condition1[2]"] = $condition1[2];
	$dev["condition1[3]"] = $condition1[3];
	$dev["condition1[4]"] = $condition1[4];
	$dev["condition1[5]"] = $condition1[5];
	$dev["condition1[6]"] = $condition1[6];
	$dev["cond_comm1"] = $cond_comm1;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require_once($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require_once($rootDir."prog/db_close.php");

?>