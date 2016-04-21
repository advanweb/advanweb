<?php
	// セッション開始
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>ユーザー情報の変更 - Advanced Creators 機材管理サイト</title>
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
		showTest($_SESSION["ae_editFlag1"], "editFlag1");
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
	}
	$showFlag1 = checkInputText3($name1, "ユーザー名", 50, $showFlag1);
	$showFlag1 = checkInputText3($nendo1, "年度", 2, $showFlag1);
	$showFlag1 = checkInputText3($pass1, "パスワード", 50, $showFlag1);
	
	if ($showFlag1 != true) {
		$_SESSION["ae_editFlag1"] = true;
	}

	// editFlag1がtrueじゃないときのみ登録
	if ($_SESSION["ae_editFlag1"] != true) {
		// クエリ
		$query1 = "UPDATE `ae_user` SET `name` = '".$name1."', `pass` = '".$pass1."', `year` = '".$nendo1."' WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
		// 実行して結果を入れる
		mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			echo "<br>
			<div class=\"err1\">[エラー] 登録できませんでした。</div>
			<br>
			<div class=\"align-c\">[戻る] を押して前のページに戻り、入力をやり直してください。<br><br>
			<form name=\"form1\" action=\"user_update_01.php\" method=\"post\">
				<input type=\"submit\" name=\"update1\" value=\"戻る\" class=\"btn1\">
			</form>";
		}
		else {
			// editFlag1をon
			$_SESSION["ae_editFlag1"] = true;

			// 変更した情報を取得
			// クエリ
			$query2 = "SELECT * FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
			// 実行して結果を入れる
			$result2 = mysql_query($query2);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			// 配列に結果を取得
			$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
			// ユーザー名を取得
			$_SESSION["ae_name1"] = $rec2["name"];
			// 年度を取得
			$_SESSION["ae_nendo1"] = $rec2["year"];
			// パスワードを取得
			$_SESSION["ae_pass1"] = $rec2["pass"];

			// 結果の表示
			echo "<div class=\"p1\">ユーザー情報を変更しました。 [戻る] を押してください。
				<div class=\"submit2\">
					<hr>
					<form name=\"submit1\" action=\"user_info_01.php\" method=\"post\">
						<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
					</form>
				</div>
			</div>";
		}
	}
		
	// エラーのとき
	else {
		echo "<br>
		<div class=\"err1\">[エラー] 連続登録を防止する機能が働いたため、登録できませんでした。</div>
		<br>
		<div class=\"align-c\">[戻る] を押すとユーザー情報に戻ります。<br><br>
		<form name=\"submit1\" action=\"user_info_01.php\" method=\"post\">
			<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
		</form>";
	}
	

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
		showTest($editFlag1, "editFlag1");
		showTest($query1, "query1");
		showTest($query2, "query2");
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