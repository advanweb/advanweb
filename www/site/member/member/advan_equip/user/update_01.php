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
<body onLoad="document.form1.name1.focus()">


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
	$update1 = $_POST["update1"];

	if (is_string($update1) == true) {
		$act1 = 1;
	}
	
	// editFlag1のデフォルト設定
	$_SESSION["ae_editFlag1"] = false;

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_loginFlag1"], "loginFlag1");
		showTest($update1, "update1");
		showTest($act1, "act1");
	}

	// デフォルト
	$showFlag1 = true;

	
	// レイアウト用テンプレートからヘッダー〜本文開始を表示
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ↓ここから本文↓ -->


<div class="h1">ユーザー情報の変更</div>
<div>
	ユーザー情報を変更します。<br>
	変更したい項目に新しい情報を入力してください。<br>
	パスワードを変更するときは、 [パスワードを変更する] にチェックを入れて、新しいパスワードを入力してください。
</div>


<?php
	// act1 ユーザー情報変更
	if ($act1 == 1) {
	
		if ($_SESSION["ae_userID1"] == "") {
			$showFlag1 = false;
		}
		else {
			// 現在のユーザーのレコードを抽出
			// クエリ
			$query1 = "SELECT * FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
			// 実行して結果を入れる
			$result1 = mysql_query($query1);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
		}
			
		// showFlag1がtrueのときのみ
		if ($showFlag1 == true) {
			// 配列に結果を取得
			$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
			// レコードを表示
			echo "<div class=\"p1\">
				<form name=\"form1\" action=\"user_update_conf_01.php\" method=\"post\">
					<table class=\"form1\">
						<tbody>
							<tr><td style=\"width:10%;\"></td><td>ユーザー名 :　</td><td><input type=\"text\" name=\"name1\" size=\"30\" value=\"".$rec1["name"]."\" class=\"tbox1\"></td></tr>
							<tr><td></td><td>年度 :　</td><td><input type=\"text\" name=\"nendo1\" size=\"4\" value=\"".$rec1["year"]."\" class=\"tbox1\"></td></tr>
							<tr><td style=\"height:20px;\"></td><td></td><td></td></tr>
							<tr><td colspan=\"3\"><input type=\"checkbox\" name=\"option1\" value=\"true\">パスワードを変更する</td></tr>
							<tr><td style=\"height:10px;\"></td><td></td><td></td></tr>
							<tr><td style=\"width:10%;\"></td><td>新しいパスワード :　</td><td><input type=\"password\" name=\"pass1\" size=\"30\" class=\"tbox1\"></td></tr>
							<tr><td></td><td>新しいパスワード<br>(確認のためもう1度) :　</td><td><br><input type=\"password\" name=\"pass2\" size=\"30\" class=\"tbox1\"></td></tr>
						</tbody>
					</table>
					<div class=\"submit1\">
						<hr>
						<div>変更するには、元のパスワードを入力して [変更] を押してください。</div>
						<input type=\"password\" name=\"oldpass1\" size=\"30\" class=\"tbox1\">　<input type=\"submit\" name=\"submit1\" value=\"変更\" class=\"btn2\">　<input type=\"reset\" name=\"reset1\" value=\"リセット\" class=\"btn1\">
					</div>
				</form>
			</div>";
		}
		
	}
	
	else {
		$showFlag1 = false;
	}
	
	// showFlag1エラーの時
	if ($showFlag1 != true) {		
		echo "<div class=\"err2\">
			<div class=\"err1\">[エラー] ユーザー情報を表示できませんでした。</div>
			<div>[戻る] を押すとトップページに戻ります。</div>
			<div class=\"submit2\">
				<hr>
				<form name=\"form2\" action=\"top_01.php\" method=\"post\">
					<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
				</form>
			</div>
		</div>";
	}

	// ナビゲーション表示
	echo showNavi("user_info_01.php");

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($query1, "query1");
		showTest($rec1["name"], "name");
		showTest($rec1["year"], "nendo");
		showTest($rec1["pass"], "pass");
		showTest($num1, "num1");
		showTest($showFlag1, "showFlag1");
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