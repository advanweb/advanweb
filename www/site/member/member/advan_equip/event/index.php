<?php
/*	****************************************************************
		イベントリスト
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>イベントリスト | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$category1 = $_GET["category"];
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
	
	
	// イベントリストの検索
	// クエリ
	$query1 = "SELECT * FROM `ae_event`";// ORDER BY `sy` ASC , `sm` ASC , `sd` ASC , `sh` ASC , `sn` ASC";
	$result1 = mysql_query($query1);
	if (mysql_errno() != 0) {
		echo mysql_error();
		$showFlag1 = false;
	}
	
	// 個数の取得
	$num1 = mysql_num_rows($result1);

			
	// showFlag1がtrueのときのみ
	if ($showFlag1 == true) {
					
		// カテゴリー名の表示
		echo "<h2>イベントリスト</h2>";

		// 検索結果が０のとき
		if ($num1 == 0) {
			echo "<p>登録されているイベントはありません。</p>";
		}

		// １以上のとき
		else {
					
			echo "<p>".$num1." 項目のイベントがあります。</p>";
			
			// テーブルの中身を順番に取り出して表示する
			echo "<table class=\"dbList\" summary=\"イベントの一覧を表示しています。\">
				<tr>
					<th>イベント名</th>
					<th>カテゴリー</th>
					<th>開始日</th>
					<th>終了日</th>
				</tr>";
			for ($i=0;$i<$num1;$i++) {
				$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
				// レコード表示
				echo "
				<tr>
					<td><a href=\"detail.php?id=".$rec1["id"]."\">".$rec1["name"]."</a></td>
					<td>".$rec1["category"]."</td>
					<td>".$rec1["sy"].".".$rec1["sm"].".".$rec1["sd"]." (".$rec1["sw"].")</td>
					<td>".$rec1["ey"].".".$rec1["em"].".".$rec1["ed"]." (".$rec1["ew"].")</td>
				</tr>";
			}
			echo "
			</table>
			<p>イベントの詳細を見たり、イベントのデータを変更したりするには、イベント名をクリックしてください。</p>";
		}
		
		
		// 新規機材追加
		echo "
		<p>イベントデータベースに登録されていないイベントを追加するには、 [新規イベント追加] を押してください。</p>
		<form action=\"eve_add_01.php\" method=\"post\">
			<p class=\"submit\"><input type=\"submit\" name=\"add1\" id=\"add1-id\" value=\"新規イベント追加\" /></p>
		</form>";
	}
	
	// 入力が不正の時のエラー表示
	else {
		echo "<p class=\"error\">[エラー] リストを表示できませんでした。</p>
			<p>[戻る] を押すとトップページに戻ります。</p>
			<form action=\"top_01.php\" method=\"post\">
				<p class=\"submit\"><input type=\"submit\" name=\"return1\" id=\"return1-id\" value=\"戻る\" /></p>
			</form>";
	}


	// 表示してみるテスト
	$dev["userID1"] = $_SESSION["ae_userID1"];
	$dev["name1"] = $_SESSION["ae_name1"];
	$dev["nendo1"] = $_SESSION["ae_nendo1"];
	$dev["pass1"] = $_SESSION["ae_pass1"];
	$dev["loginFlag1"] = $_SESSION["ae_loginFlag1"];
	$dev["category1"] = $category1;
	$dev["submit1"] = $submit1;
	$dev["act1"] = $act1;
	$dev["showFlag1"] = $showflag1;
	$dev["query1"] = $query1;
	$dev["rec1[category]"] = $rec1["category"];
	$dev["class2"] = $class2;
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