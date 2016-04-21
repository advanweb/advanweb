<?php
/*	****************************************************************
		データベース接続
	****************************************************************/


	// データベース設定 (ローカル用設定)
	/*
	$MySQL_host = "localhost";
	$MySQL_user = "customer";
	$MySQL_pass = "customer";
	$MySQL_database = "advan_equip";
	*/

	// データベース設定 (サーバー用設定)
	$MySQL_host = "mysql34.db.sakura.ne.jp";
	$MySQL_user = "advancedcreators";
	$MySQL_pass = "mg166fx";
	$MySQL_database = "advancedcreators";

	// MySQLサーバに接続する
	$conn = mysql_connect($MySQL_host, $MySQL_user, $MySQL_pass);
	if(mysql_errno() != 0) {
		die("MySQL接続に失敗しました。<br>");	// プログラムをすぐ終了させる
	}
	else {
		mysql_query("SET NAMES utf8");	// 文字コードにUTF-8を使う宣言
	}
			
	// 使うデータベースの選択
	mysql_select_db($MySQL_database);

?>