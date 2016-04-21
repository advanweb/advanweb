<?php
	// セッション開始
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>カテゴリーの変更 - Advanced Creators 機材管理サイト</title>
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
	$id1 = $_POST["id1"];
	$class1 = $_POST["class1"];
	$category0 = $_POST["category0"];
	$category1 = $_POST["category1"];
	$category2 = $_POST["category2"];
	$category3 = $_POST["category3"];
	$category4 = $_POST["category4"];
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
		showTest($id1, "id1");
		showTest($class1, "class1");
		showTest($category0, "category0");
		showTest($category1, "category1");
		showTest($category2, "category2");
		showTest($category3, "category3");
		showTest($category4, "category4");
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
	
	// editFlag1がtrueじゃないときのみ登録
	if ($_SESSION["ae_editFlag1"] != true) {
		
		// カテゴリーの選択
		switch ($class1) {
			case "音響":
				$ncategory1 = $category0;
				break;
			case "照明":
				$ncategory1 = $category1;
				break;
			case "ケーブル":
				$ncategory1 = $category2;
				break;
			case "スタンド":
				$ncategory1 = $category3;
				break;
			case "アクセサリー":
				$ncategory1 = $category4;
				break;
			default:
				echo "<div class=\"err1\">[エラー] 項目が選択されていません！</div>";
				$showFlag1 = false;
		}
		
		// showFlag1がtrueのとき
		if ($showFlag1 == true) {
			// 結果の表示
			echo "<div class=\"p1\">カテゴリーによって機材データの項目は異なります。<br>
				[機材データの変更] を押して、機材データの変更ページに進んでください。<br>
				機材データの変更を行うまで、カテゴリーの変更は有効になりません。
				<div class=\"submit2\">
					<hr>
					<form name=\"submit1\" action=\"eqp_update_01.php\" method=\"post\">
						<input type=\"hidden\" name=\"id1\" value=\"".$id1."\">
						<input type=\"hidden\" name=\"nclass1\" value=\"".$class1."\">
						<input type=\"hidden\" name=\"ncategory1\" value=\"".$ncategory1."\">
						<input type=\"submit\" name=\"update1\" value=\"機材データの変更\" class=\"btn2\">
					</form>
				</div>
			</div>";
		}
		
		// エラーの時
		else {
			echo "<br>
			<div class=\"p1\">
				<div class=\"submit2\">
					<div>[戻る] を押して前のページに戻り、入力をやり直してください。</div>
					<div class=\"submit2\">
					<hr>
					<form name=\"submit1\" action=\"eqp_cate_01.php\" method=\"post\">
						<input type=\"hidden\" name=\"id1\" value=\"".$id1."\">
						<input type=\"submit\" name=\"cate1\" value=\"戻る\" class=\"btn1\">
					</form>
				</div>
			</div>
			<br>
			<div class=\"align-c\">
			</div>";
		}
	}
		
	// エラーのとき
	else {
		echo "<br>
		<div class=\"err1\">[エラー] 連続登録を防止する機能が働いたため、登録できませんでした。</div>
		<br>
		<div class=\"align-c\">[戻る] を押すと機材詳細に戻ります。<br><br>
		<form name=\"submit1\" action=\"eqp_detail_01.php\" method=\"post\">
			<input type=\"hidden\" name=\"id\" value=\"".$id1."\">
			<input type=\"submit\" name=\"return1\" value=\"戻る\" class=\"btn1\">
		</form>";
	}
	

	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
		showTest($editFlag1, "editFlag1");
		showTest($ncategory1, "ncategory1");
	}
	
?>


<!-- ↑ここまで本文↑ -->

<?php
	// レイアウト用テンプレートから本文終了～全ワク終了を表示
	echo $layout["footer"];

	// MySQLサーバを閉じる
	require ("../prog/db_close.php");
?>


</body>
</html> 