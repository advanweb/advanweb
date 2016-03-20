<?php
/*	****************************************************************
		ログイン
	****************************************************************/


	// 変数の取得
	$_SESSION["ae_name1"] = $_POST["name1"];
	$_SESSION["ae_pass1"] = $_POST["pass1"];
	// 入力値と登録情報を照合
	// クエリ
	$query1 = "SELECT * FROM `ae_user` WHERE `name` = '".$_SESSION["ae_name1"]."'";
	// 実行して結果を入れる
	$result1 = mysql_query($query1);
	if (mysql_errno() != 0) {
		echo mysql_error();
	}
	// 結果の個数
	$num1 = mysql_num_rows($result1);
	
	// 個数が1のときのみ
	if ($num1 == 1) {
		// 配列に結果を取得
		$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
		// パスワードを照合
		if ($_SESSION["ae_pass1"] == $rec1["pass"]) {	
			// login1をon
			$_SESSION["ae_loginFlag1"] = true;
			// 年度を取得
			$_SESSION["ae_nendo1"] = $rec1["year"];
			// idを取得
			$_SESSION["ae_userID1"] = $rec1["id"];
		}
		// パスワードエラー
		else {
			echo "
				<p class=\"error\">パスワードが違っています！</p>
				<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
				<form name=\"form2\" action=\"index.php\" method=\"post\">
					<p><input type=\"submit\" name=\"return1\" id=\"return1-id\" value=\"戻る\"></p>
				</form>";
			$showFlag1 = false;
		}
	}
	
	// 個数が1ではないとき
	else {
		echo "
			<p class=\"error\">ユーザー名が違っています！</p>
			<p>[戻る] を押して前のページに戻り、入力をやり直してください。</p>
			<form name=\"form2\" action=\"index.php\" method=\"post\">
				<p><input type=\"submit\" name=\"return1\" id=\"return1-id\" value=\"戻る\"></p>
			</form>";
		$showFlag1 = false;
	}
	
	// ユーザー名がdeveloperのときdevFlagをtrue
	if ($_SESSION["ae_name1"] == "developer") {
		$_SESSION["ae_devFlag1"] = true;
	}
	// ユーザー名がadminのときadminFlagをtrue
	if ($_SESSION["ae_name1"] == "admin") {
		$_SESSION["ae_adminFlag1"] = true;
	}

	// 表示してみるテスト
	$dev["userID1"] = $_SESSION["ae_userID1"];
	$dev["name1"] = $_SESSION["ae_name1"];
	$dev["nendo1"] = $_SESSION["ae_nendo1"];
	$dev["pass1"] = $_SESSION["ae_pass1"];
	$dev["loginFlag1"] = $_SESSION["ae_loginFlag1"];
	$dev["devFlag1"] = $_SESSION["ae_devFlag1"];
	$dev["adminFlag1"] = $_SESSION["ae_adminFlag1"];
	$dev["showFlag1"] = $showflag1;
	$dev["query1"] = $query1;
	$dev["num1"] = $num1;
	$dev["rec1[pass]"] = $rec1["pass"];
	include($rootDir."prog/dev.php");
	
	// エラー時はここでプログラム終了
	if ($showFlag1 == false) {
		die("");
	}

?>