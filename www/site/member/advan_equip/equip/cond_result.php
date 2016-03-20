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
<title>変更完了 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_POST["id1"];
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
	$pageTitle = "変更完了";
	$pageClass = "equip cond";
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
		$showFlag1 = false;
	}
	$showFlag1 = checkInputIntPL($stock1, "総数", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[1], "良好", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[2], "微妙", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[3], "不調", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[4], "故障", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[5], "修理", 10, $showFlag1);
	$showFlag1 = checkInputIntPL($condition1[6], "不明", 10, $showFlag1);
	$showFlag1 = checkInputStringLN($cond_comm1, "備考", 2048, $showFlag1);
	
	
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
		$query1 = "UPDATE `ae_equip` SET `stock` = '".$stock1."', `condition1` = '".$condition1[1]."',`condition2` = '".$condition1[2]."', `condition3` = '".$condition1[3]."', `condition4` = '".$condition1[4]."', `condition5` = '".$condition1[5]."', `condition6` = '".$condition1[6]."', `cond_comm` = '".$cond_comm1."', `date` = '".$dtf1."' WHERE `id` =".$id1." LIMIT 1 ;";
		// 実行して結果を入れる
		mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();	
			echo "
<p class=\"error\">[エラー] 変更できませんでした。</p>
<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
<form action=\"cond.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id\" value=\"".$id1."\" />
		<input type=\"submit\" name=\"cond1\" value=\"戻る\" />
	</p>
</form>";
		}
		else {
			// 結果の表示
			echo "
<h2>".$pageTitle."</h2>
<p>コンディションを変更しました。 [機材詳細へ戻る] を押すと機材詳細に戻ります。</p>";
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
		}
	}
		
	// エラーのとき
	else {
		echo "
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
	$dev["query3"] = $query3;
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