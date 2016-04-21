<?php
/*	****************************************************************
		イベント詳細
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>イベント詳細 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_GET["id"];
	$submit1 = $_POST["submit1"];

	if (is_string($login1) == true) {
		$act1 = 1;
	}
	
	
	// ページのタイトル
	$pageClass = "event";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require("../prog/root_dir.php");
	
	// ログインチェック
	require($rootDir."prog/check_login.php");
	
	// データベース接続
	require($rootDir."prog/db_conn.php");
	
	// 関数テンプレート
	require ($rootDir."prog/func_temp_01.php");
	
	// html header
	
	// ヘッダーの読み込み
	require($rootDir."layout/header.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	
	
	
	// 機材データを取得
	if ($id1 == "") {
		$showFlag1 = false;
	}
	else {
		$query1 = "SELECT * FROM `ae_event` WHERE `id` = ".$id1." LIMIT 1";
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
		
		// コメントをHTMLに変換
		$note1 = p($rec1["note"]);
		$equip1 = p($rec1["equip1"]);
		$equip2 = p($rec1["equip2"]);
		$equip3 = p($rec1["equip3"]);
		$equip4 = p($rec1["equip4"]);
		// 0を00に変換
		$sh1 = trans0to00($rec1["sh"]);
		$sn1 = trans0to00($rec1["sn"]);
		$eh1 = trans0to00($rec1["eh"]);
		$en1 = trans0to00($rec1["en"]);
		// 使用機材が空白の時の処理
		if ($equip1 == "") $equip1 = "&nbsp;";
		if ($equip2 == "") $equip2 = "&nbsp;";
		if ($equip3 == "") $equip3 = "&nbsp;";
		if ($equip4 == "") $equip4 = "&nbsp;";
	}
		
				
	// showFlag1がtrueのときのみ
	if ($showFlag1 == true) {
					
		// 機材データの表示
		echo "<h2>イベント詳細</h2>
		<h3>".$rec1["name"]."</h3>
		<p>カテゴリー :　".$rec1["category"]."</p>
		<table summary=\"イベントの詳細データを表示しています。\">
			<tr>
				<th scope=\"row\">開始日時</th>
				<td>".$rec1["sy"].".".$rec1["sm"].".".$rec1["sd"]." (".$rec1["sw"].")　".$sh1.":".$sn1."</td>
			</tr>
			<tr>
				<th scope=\"row\">終了日時</th>
				<td>".$rec1["ey"].".".$rec1["em"].".".$rec1["ed"]." (".$rec1["ew"].")　".$eh1.":".$en1."</td>
			</tr>
			<tr>
				<th scope=\"row\">会場</th>
				<td>".$rec1["place"]."</td>
			</tr>
			<tr>
				<th scope=\"row\">コメント</th>
				<td>".$note1."</td>
			</tr>
		</table>";
		
		// 使用機材
		echo "
		<h4>使用機材</h4>
		<dl>
			<dt class=\"pa\">卓</dt>
			<dd>".$equip1."</dd>
			<dt class=\"stage\">舞台</dt>
			<dd>".$equip2."</dd>
			<dt class=\"lighting\">照明</dt>
			<dd>".$equip3."</dd>
			<dt class=\"other\">その他</dt>
			<dd>".$equip4."</dd>
		</dl>";
		
		
		// 戻るナビゲーション
		$message = "機材リストへ戻る";
		$href = "./";
		include($rootDir."visual/nav_back.php");
		
		// 変更・削除
		echo "
		<p>イベントのデータを変更するには [イベントデータの変更] を、<br />
			使用機材を変更するには [使用機材の変更] を、<br />
			イベントを完全に削除するには [イベントの完全削除] をクリックしてください。</p>
		<div class=\"submit\">
			<form action=\"eve_update_01.php\" method=\"post\">
				<p><input type=\"hidden\" name=\"id1\" value=\"".$rec1["id"]."\" />
				<input type=\"submit\" name=\"update1\" id=\"update1-id\" value=\"イベントデータの変更\" /></p>
			</form>
			<form action=\"eqp_cond_01.php\" method=\"post\">
				<p><input type=\"hidden\" name=\"id1\" value=\"".$rec1["id"]."\" />
				<input type=\"submit\" name=\"cond1\" id=\"cond1-id\" value=\"使用機材の変更\" /></p>
			</form>
			<form action=\"eve_delete_01.php\" method=\"post\">
				<p><input type=\"hidden\" name=\"id1\" value=\"".$rec1["id"]."\" />
				<input type=\"submit\" name=\"delete1\" id=\"delete1-id\" value=\"イベントの完全削除\" /></p>
			</form>
		</div>";
		
	}
	
	// 入力が不正の時のエラー表示
	else {
		echo "<p class=\"error\">[エラー] リストを表示できませんでした。</p>
		<p>[戻る] を押すとトップページに戻ります。</p>
		<form action=\"".$rootDir."\" method=\"post\">
			<p class=\"submit\"><input type=\"submit\" name=\"return1\" id=\"return1-id\" value=\"戻る\" /></p>
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
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>