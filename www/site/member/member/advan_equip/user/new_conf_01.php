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
	$_SESSION["ae_pass2"] = $_POST["pass2"];
	$submit1 = $_POST["submit1"];

	if (is_string($submit1) == true) {
		$act1 = 1;
	}
	
	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_pass2"], "pass2");
		showTest($submit1, "submit1");
		showTest($act1, "act1");
	}
	
	// デフォルト
	$showFlag1 = true;

	 
	// レイアウト用テンプレートからヘッダーを表示
	echo $layout["only_main"].$layout["body"];
?>

<!-- ↓ここから本文↓ -->


<?php
	
	// act1が1のときのみ
	if ($act1 == 1) {
		
		// 入力値の判定
		$showFlag1 = checkInputText3($_SESSION["ae_name1"], "ユーザー名", 50, $showFlag1);
		$showFlag1 = checkInputText3($_SESSION["ae_nendo1"], "年度", 2, $showFlag1);
		$showFlag1 = checkInputText3($_SESSION["ae_pass1"], "パスワード", 50, $showFlag1);
		
		if ($_SESSION["ae_pass1"] != $_SESSION["ae_pass2"]) {
			echo "<div class=\"err1\">[エラー] パスワードが違っています！</div>";
			$showFlag1 = false;
		}
		
		
		// showFlag1がtrueのとき表示
		if ($showFlag1 == true) {
			// 同じ名前がないかチェック
			// クエリ
			$query1 = "SELECT * FROM `ae_user` WHERE `name` = '".$_SESSION["ae_name1"]."'";
			// 実行して結果を入れる
			$result1 = mysql_query($query1);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			// 結果の個数
			$num1 = mysql_num_rows($result1);
			// 個数が0でないときエラー
			if ($num1 > 0) {
				echo "<div class=\"err1\">[エラー] 同じユーザー名が存在するので、そのユーザー名では登録できません！</div>";
				$showFlag1 = false;
			}
			
			
			// HTML表示用に変換
			$name2 = p($_SESSION["ae_name1"]);
			$nendo2 = p($_SESSION["ae_nendo1"]);
		}
		
		// showFlag1がtrueのとき表示
		if ($showFlag1 == true) {
			echo "<div class=\"h1\">入力情報確認</div>
			<div>以下の内容で新規ユーザー登録します。よろしければ [登録] を押してください。<br>
			内容を訂正するには [戻る] を押してください。</div>
			<div class=\"p1\" style=\"width:400px; text-align:center;\">
				<table class=\"t1\" style=\"margin-top:20px;\">
					<tbody>
						<tr><th>項目</th><th>入力値</th></tr>
						<tr><td>ユーザー名 :　</td><td>".$name2."</td></tr>
						<tr><td>年度 :　</td><td>".$nendo2."</td></tr>
						<tr><td>パスワード :　</td><td>(パスワードは表示されません)</td></tr>
					</tbody>
				</table>
				<div class=\"submit2\">
					<hr>
					<table>
						<tbody>
							<tr>
								<td>
									<form name=\"form1\" action=\"new_result_01.php\" method=\"post\">
										<input type=\"hidden\" name=\"name1\" value=\"".$_SESSION["ae_name1"]."\">
										<input type=\"hidden\" name=\"nendo1\" value=\"".$_SESSION["ae_nendo1"]."\">
										<input type=\"hidden\" name=\"pass1\" value=\"".$_SESSION["ae_pass1"]."\">
										<input type=\"submit\" name=\"regist1\" value=\"登録\" class=\"btn4\">　
									</form>
								</td>
								<td>
									<form name=\"form2\" action=\"new_entry_01.php\" method=\"post\">
										<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>";
		}
		
		// エラーのとき
		else {
			echo "<br>
			<div class=\"p1\" style=\"width:400px; text-align:center;\">
				<table class=\"t1\" style=\"margin:20px;\">
					<tbody>
						<tr><th>項目</th><th>入力値</th></tr>
						<tr><td>ユーザー名 :　</td><td>".$name2."</td></tr>
						<tr><td>年度 :　</td><td>".$nendo2."</td></tr>
						<tr><td>パスワード :　</td><td>(パスワードは表示されません)</td></tr>
					</tbody>
				</table>
				<div>[戻る] を押して前のページに戻り、入力をやり直してください。</div>
				<div class=\"submit2\">
					<hr>
					<form name=\"form2\" action=\"new_entry_01.php\" method=\"post\">
						<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
					</form>
				</div>
			</div>
			<br>
			<div class=\"align-c\">
			</div>";
		}
	}
	
	
	else {
		echo "<div class=\"err1\">[エラー] 入力情報を表示できませんでした。</div>
		<div>[戻る] を押して入力をやり直してください。</div>
		<div class=\"submit2\">
			<hr>
			<form name=\"form2\" action=\"new_entry_01.php\" method=\"post\">
				<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
			</form>
		</div>";
	}	
	
	
	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($name2, "name2");
		showTest($nendo2, "nendo2");
		showTest($showFlag1, "showFlag1");
		showTest($query1, "query1");
		showTest($num1, "num1");
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