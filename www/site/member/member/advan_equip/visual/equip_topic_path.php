<?php
/*	****************************************************************
		機材カテゴリーのパンくずリスト表示
		
		$rec1["class"] = 部署
		$rec1["category"] = カテゴリー
	****************************************************************/


	// 機材データ更新、新規機材追加のページでは、新しいカテゴリーで表示
	if ($pageClass == "equip update" || $pageClass == "equip add") {
		echo "
<ol class=\"topicPath\">
	<li class=\"";
			
		// 部署でリストのクラス名を書き換える
		switch ($class1) {
			case "音響":
				echo "pa";
				break;
			case "照明":
				echo "lighting";
				break;
			case "ケーブル":
				echo "cable";
				break;
			case "スタンド":
				echo "stand";
				break;
			case "その他":
				echo "accessory";
				break;
		}
				
		echo "\">".p($class1)."</li><li>".p($category1)."</li>
</ol>";
	}
	
	// 通常のページ
	else {
		echo "
<ol class=\"topicPath\">
	<li class=\"";
			
		// 部署でリストのクラス名を書き換える
		switch ($rec1["class"]) {
			case "音響":
				echo "pa";
				break;
			case "照明":
				echo "lighting";
				break;
			case "ケーブル":
				echo "cable";
				break;
			case "スタンド":
				echo "stand";
				break;
			case "その他":
				echo "accessory";
				break;
		}
				
		echo "\">".p($rec1["class"])."</li><li>".p($rec1["category"])."</li>
</ol>";
	}

?>
