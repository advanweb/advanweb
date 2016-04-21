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
	$stock1 = $_POST["stock1"];
	$condition1[1] = $_POST["condition1"];
	$condition1[2] = $_POST["condition2"];
	$condition1[3] = $_POST["condition3"];
	$condition1[4] = $_POST["condition4"];
	$condition1[5] = $_POST["condition5"];
	$condition1[6] = $_POST["condition6"];
	$cond_comm1 = $_POST["cond_comm1"];
	$submit1 = $_POST["submit1"];

	if (is_string($submit1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageTitle = "変更の確認";
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


	// act1が1のときのみ
	if ($act1 == 1) {
		
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
			$query2 = "SELECT * FROM `ae_equip_title` WHERE `category` = '".$rec1["category"]."' LIMIT 1";
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
			// 機材データの表示
			echo "
<h3>".p($rec1["maker"])."　".p($rec1["name"])."</h3>";
			
			include($rootDir."visual/equip_topic_path.php");	// パンくずリスト
			
			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
			
			// テキスト
			echo "
<p>コンディションを以下の内容に変更します。</p>
<p>よろしければ [確定] を押してください。<br />
内容を訂正するには [戻る] を押してください。</p>";

			// コンディション
			echo "
<h4>コンディション</h4>
<dl class=\"condition\">
	<dt class=\"cond1\">良好</dt>
	<dd class=\"cond1\">".p($condition1[1])."</dd>
	<dt class=\"cond2\">微妙</dt>
	<dd class=\"cond2\">".p($condition1[2])."</dd>
	<dt class=\"cond3\">不調</dt>
	<dd class=\"cond3\">".p($condition1[3])."</dd>
	<dt class=\"cond4\">故障</dt>
	<dd class=\"cond4\">".p($condition1[4])."</dd>
	<dt class=\"cond5\">修理</dt>
	<dd class=\"cond5\">".p($condition1[5])."</dd>
	<dt class=\"cond6\">不明</dt>
	<dd class=\"cond6\">".p($condition1[6])."</dd>
	<dt class=\"cond0\">総数</dt>
	<dd class=\"cond0\">".p($stock1)."</dd>";
	
			if ($cond_comm1 != "") echo "
	<dt class=\"condComm\">備考</dt>
	<dd class=\"condComm\">".p($cond_comm1)."</dd>";
	
		echo "
</dl>";

			// submit button
			echo "
<div class=\"submit\">
	<form action=\"cond.php\" method=\"post\">
		<p>
			<span class=\"aux\"><a href=\"".$rootDir."help/appendix.php?mode=1\" target=\"window\" title=\"別ウィンドウでコンディションの凡例を表示する\" onclick=\"popupWinOpen('".$rootDir."help/appendix.php?mode=1')\">コンディションの凡例</a></span>
			<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
			<input type=\"submit\" name=\"cond1\" value=\"入力画面へ戻る\" />
		</p>
	</form>
	<form action=\"cond_result.php\" method=\"post\">
		<p>
			<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
			<input type=\"hidden\" name=\"stock1\" value=\"".p($stock1)."\" />
			<input type=\"hidden\" name=\"condition1\" value=\"".p($condition1[1])."\" />
			<input type=\"hidden\" name=\"condition2\" value=\"".p($condition1[2])."\" />
			<input type=\"hidden\" name=\"condition3\" value=\"".p($condition1[3])."\" />
			<input type=\"hidden\" name=\"condition4\" value=\"".p($condition1[4])."\" />
			<input type=\"hidden\" name=\"condition5\" value=\"".p($condition1[5])."\" />
			<input type=\"hidden\" name=\"condition6\" value=\"".p($condition1[6])."\" />
			<input type=\"hidden\" name=\"cond_comm1\" value=\"".$cond_comm1."\" />
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
<form action=\"cond.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"submit\" name=\"return1\" value=\"戻る\" />
	</p>
</form>";
		}
	}
	
	
	else {
		echo "
<p class=\"error\">[エラー] 入力情報を表示できませんでした。</p>
<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
<form action=\"cond.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".p($id1)."\" />
		<input type=\"submit\" name=\"return1\" value=\"戻る\" />
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