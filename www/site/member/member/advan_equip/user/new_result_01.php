<?php
	// セッション開始
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>新規ユーザー登録 - Advanced Creators 機材管理サイト</title>
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
	checkLogin(false);
		
		
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
	$_SESSION["ae_name1"] = $_POST["name1"];
	$_SESSION["ae_nendo1"] = $_POST["nendo1"];
	$_SESSION["ae_pass1"] = $_POST["pass1"];
	$regist1 = $_POST["regist1"];

	if (is_string($regist1) == true) {
		$act1 = 1;
	}
	
	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_newFlag1"], "newFlag1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($regist1, "regist1");
		showTest($act1, "act1");
	}
	
	// デフォルト
	$showFlag1 = true;

	 
	// レイアウト用テンプレートからヘッダーを表示
	echo $layout["only_main"].$layout["body"];
?>

<!-- ↓ここから本文↓ -->


<?php
	
	// act1
	if ($act1 != 1) {
		$showFlag1 = false;
	}
	
	// 入力値の判定
	$showFlag1 = checkInputText3($_SESSION["ae_name1"], "ユーザー名", 50, $showFlag1);
	$showFlag1 = checkInputText3($_SESSION["ae_nendo1"], "年度", 2, $showFlag1);
	$showFlag1 = checkInputText3($_SESSION["ae_pass1"], "パスワード", 50, $showFlag1);
	
	if ($showFlag1 != true) {
		$_SESSION["ae_newFlag1"] = true;
	}

	// newFlag1がtrueじゃないときのみ登録
	if ($_SESSION["ae_newFlag1"] != true) {
		// クエリ
		$query1 = "INSERT INTO `ae_user` ( `id` , `name` , `pass` , `year` ) VALUES (NULL , '".$_SESSION["ae_name1"]."', '".$_SESSION["ae_pass1"]."', '".$_SESSION["ae_nendo1"]."')";
		// 実行して結果を入れる
		mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			echo "<br>
			<div class=\"err1\">[エラー] 登録できませんでした。</div>
			<br>
			<div class=\"align-c\">[戻る] を押して前のページに戻り、入力をやり直してください。<br><br>
			<a href=\"new_entry_01.php\" class=\"btn5\">戻る</a></div>";
		}
		else {
			// newFlag1をon
			$_SESSION["ae_newFlag1"] = true;
			// 結果の表示
			echo "<div class=\"p1\">新規ユーザー登録しました。 [ログイン] を押してログインしてください。
				<div class=\"submit2\">
					<hr>
					<form name=\"submit1\" action=\"top_01.php\" method=\"post\">
						<input type=\"hidden\" name=\"name1\" value=\"".$_SESSION["ae_name1"]."\">
						<input type=\"hidden\" name=\"pass1\" value=\"".$_SESSION["ae_pass1"]."\">
						<input type=\"submit\" name=\"login1\" value=\"ログイン\" class=\"btn1\">
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
		<div class=\"align-c\">[戻る] を押すとログインページに戻ります。<br><br>
		<form name=\"submit1\" action=\"index.php\" method=\"post\">
			<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
		</form>";
	}
	

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
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