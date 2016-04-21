<?php
/*	****************************************************************
		各ページ共通のプログラム
	****************************************************************/


	// デフォルト
	$showFlag1 = true;
	
	// ログインチェック
	require_once($rootDir."prog/check_login.php");
	
	// データベース接続
	require_once($rootDir."prog/db_conn.php");

	// link要素 prev, next
	require_once($rootDir."prog/link_prevnext.php");

	// datetime変換関数
	require_once($rootDir."prog/trans_datetime.php");
	
	// HTML用変換関数
	require_once($rootDir."prog/trans_html.php");
	
	// DTF取得関数
	require_once($rootDir."prog/get_dtf.php");
	
	// 入力チェック関数
	require_once($rootDir."prog/check_input.php");
	
	// 関数テンプレート
	// require_once($rootDir."prog/func_temp_01.php");
	
	// ヘッダーの読み込み
	// Popup Window
	if ($pageClass == "help popupWin") {
		require_once($rootDir."layout/header_popupwin.php");
	}
	// 通常
	else {
		require_once($rootDir."layout/header.php");
	}
?>
