<?php
	// セッション開始
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>ユーザー情報 - Advanced Creators 機材管理サイト</title>
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
	$submit1 = $_POST["submit1"];

	if (is_string($login1) == true) {
		$act1 = 1;
	}
	
	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_loginFlag1"], "loginFlag1");
		showTest($submit1, "submit1");
		showTest($act1, "act1");
	}

	// デフォルト
	$showFlag1 = true;

	
	// レイアウト用テンプレートからヘッダー〜本文開始を表示
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ↓ここから本文↓ -->


<div class="h1">ユーザー情報</div>
<div>
	現在ログインしているユーザーのユーザー名と年度を表示します。<br>
	これらの情報やパスワードの変更をするには [ユーザー情報の変更] を、このユーザーを削除するには [ユーザーの削除] を押してください。
</div>


<?php
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
		echo "<div>
			<table class=\"t1\" style=\"margin:20px;\">
				<tbody>
					<tr><th>項目</th><th>入力値</th></tr>
					<tr><td>ユーザー名 :　</td><td>".$rec1["name"]."</td></tr>
					<tr><td>年度 :　</td><td>".$rec1["year"]."</td></tr>
					<tr><td>パスワード :　</td><td>(パスワードは表示されません)</td></tr>
				</tbody>
			</table>
			<div class=\"submit2\">
				<hr>
				<table>
					<tbody>
						<tr>
							<td>
								<form name=\"form1\" action=\"user_update_01.php\" method=\"post\">
									<input type=\"hidden\" name=\"name1\" value=\"".$rec1["name"]."\">
									<input type=\"hidden\" name=\"nendo1\" value=\"".$rec1["year"]."\">
									<input type=\"hidden\" name=\"pass1\" value=\"".$rec1["pass"]."\">
									<input type=\"submit\" name=\"update1\" value=\"変更\" class=\"btn2\">　
								</form>
							</td>
							<td>
								<form name=\"form2\" action=\"user_delete_01.php\" method=\"post\">
									<input type=\"hidden\" name=\"name1\" value=\"".$rec1["name"]."\">
									<input type=\"submit\" name=\"delete1\" value=\"削除\" class=\"btn4\">
								</form>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>";
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
	echo showNavi("top_01.php");
	
	// 管理者ページ
	if ($_SESSION["ae_adminFlag1"] == true) {
		echo "<br>
		<div class=\"navi1\"><a href=\"admin_01.php\"><img src=\"img/btn_right_01.gif\" width=\"11\" height=\"11\">管理者ページ</a></div>";
	}

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($query1, "query1");
		showTest($rec1["name"], "name");
		showTest($rec1["year"], "year");
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