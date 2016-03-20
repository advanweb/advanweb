<?php
	// セッション開始
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>ユーザーの削除 - Advanced Creators 機材管理サイト</title>
<link rel="stylesheet" href="../css/main_1.css" type="text/css">
<style type="text/css">
<!--


-->
</style>
</head>
<body>


<?php
	// 外部phpファイルの読み込み
	// レイアウト用テンプレート
	require ("../layout/layout_temp_02.php");
	
	// 関数テンプレート
	require ("../prog/func_temp_01.php");
	
	// データベース接続
	require ("../prog/db_conn.php");


	// ログインチェック
	checkLogin(true);
		
		
	// データベース接続
	
	// MySQLサーバに接続する
	$conn = mysql_connect($MySQL_host, $MySQL_user, $MySQL_pass);
	if (mysql_errno()!=0) {
		die("MySQL接続に失敗しました<br>");	// プログラムをすぐ終了させる
	}else{
		mysql_query("SET NAMES ujis");	// 文字コードにEUC-JPを使う宣言
	}
			
	// 扱うデータベースの選択
	mysql_select_db($MySQL_database);



	// 変数の取得
	$name1 = $_POST["name1"];
	$nendo1 = $_POST["nendo1"];
	$pass1 = $_POST["pass1"];
	$regist1 = $_POST["regist1"];

	if (is_string($regist1) == true) {
		$act1 = 1;
	}
	
	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_deleteFlag1"], "deleteFlag1");
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest(name1, "name1");
		showTest(nendo1, "nendo1");
		showTest(pass1, "pass1");
		showTest($regist1, "regist1");
		showTest($act1, "act1");
	}
	
	// デフォルト
	$showFlag1 = true;

	 
	// レイアウト用テンプレートからヘッダーを表示
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ↓ここから本文↓ -->


<?php
	
	// act1
	if ($act1 != 1) {
		$showFlag1 = false;
	}
	
	// 入力値の判定
	if ($_SESSION["ae_userID1"] == "") {
		$showFlag1 = false;
		$_SESSION["ae_deleteFlag1"] = true;
	}

	if ($showFlag1 != true) {
		$_SESSION["ae_deleteFlag1"] = true;
	}

	// deleteFlag1がtrueじゃないときのみ削除
	if ($_SESSION["ae_deleteFlag1"] != true) {

		// パスワード認証
		// クエリ
		$query3 = "SELECT * FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
		// 実行して結果を入れる
		$result3 = mysql_query($query3);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}
		// 配列に結果を取得
		$rec3 = mysql_fetch_array($result3,MYSQL_ASSOC);
		
		// パスワードが違うときエラー
		if ($pass1 != $rec3["pass"]) {
			echo "<div class=\"err1\">[エラー] パスワードが違っています！</div>
			<div>[戻る] を押して前のページに戻り、入力をやり直してください。</div>
			<div class=\"submit2\">
				<hr>
				<form name=\"form2\" action=\"user_delete_01.php\" method=\"post\">
					<input type=\"submit\" name=\"delete1\" value=\"戻る\" class=\"btn1\">
				</form>
			</div>";
			$showFlag1 = false;			
		}
		
		// showFlag1がtrueのときのだけ削除
		if ($showFlag1 == true) {

			// クエリ
			$query1 = "DELETE FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
			// 実行して結果を入れる
			mysql_query($query1);
			if (mysql_errno() != 0) {
				echo mysql_error();
				echo "<br>
				<div class=\"err1\">[エラー] 削除できませんでした。</div>
				<br>
				<div class=\"align-c\">[戻る] を押すとユーザー情報に戻ります。<br><br>
				<form name=\"form1\" action=\"user_info_01.php\" method=\"post\">
					<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
				</form>";
			}
			else {
				// deleteFlag1をon
				$_SESSION["ae_deleteFlag1"] = true;
	
				// 結果の表示
				echo "<div class=\"p1\">ユーザーを削除しました。 [戻る] を押してください。
					<div class=\"submit2\">
						<hr>
						<form name=\"submit1\" action=\"index.php\" method=\"post\">
							<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
						</form>
					</div>
				</div>";
			}
		}
		
	}
		
	// エラーのとき
	else {
		echo "<br>
		<div class=\"err1\">[エラー] 連続削除を防止する機能が働いたため、削除できませんでした。</div>
		<br>
		<div class=\"align-c\">[戻る] を押すとユーザー情報に戻ります。<br><br>
			<form name=\"submit1\" action=\"user_info_01.php\" method=\"post\">
				<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
			</form>
		</div>";
	}
	

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
		showTest($editFlag1, "editFlag1");
		showTest($query1, "query1");
		showTest($query2, "query2");
		showTest($query3, "query3");
		showTest($rec3["pass"], "rec3[pass]");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
	}
	
?>


<!-- ↑ここまで本文↑ -->

<?php
	// レイアウト用テンプレートから本文終了〜全ワク終了を表示
	echo $layout["footer"];

	// MySQLサーバを閉じる
	require ("../prog/db_close.php");
?>


</body>
</html>