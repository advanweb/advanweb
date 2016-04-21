<?php
/*	****************************************************************
		タイトル画像の表示
	****************************************************************/


	// 画像の総数
	$titleImgNum = 15;
	
	// ae_titleImgIdが存在するときは次の画像
	if (isset($_SESSION["ae_titleImgId"]) == true) {
		$_SESSION["ae_titleImgId"]++;
		if ($_SESSION["ae_titleImgId"] > $titleImgNum) {
			$_SESSION["ae_titleImgId"] = 1;
		}
	}
	// 存在しないときはランダムで初期値を生成
	else {
		$_SESSION["ae_titleImgId"] = mt_rand(1, $titleImgNum);
	}
	
	// 10未満の時は0を付ける
	$titleImgId = $_SESSION["ae_titleImgId"];
	if ($titleImgId < 10) {
		$titleImgId = "0".$titleImgId;
	}
	// ルートからタイトル画像までのパス
	echo "<img src=\"".$rootDir."img/title_".p($titleImgId).".png\" alt=\"Advanced Creators 機材管理サイト\" width=\"750\" height=\"100\" />";

?>