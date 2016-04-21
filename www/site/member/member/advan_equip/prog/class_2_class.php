<?php
/*	****************************************************************
		部署のクラス名を取得
		
		$rec2["class"] = 部署名
	****************************************************************/


	switch ($rec2["class"]) {
		case "音響":
			$classClass = "pa";
			break;
		case "照明":
			$classClass = "lighting";
			break;
		case "ケーブル":
			$classClass = "cable";
			break;
		case "スタンド":
			$classClass = "stand";
			break;
		case "その他":
			$classClass = "accessory";
			break;
		default:
			$classClass = "";
	}
?>
