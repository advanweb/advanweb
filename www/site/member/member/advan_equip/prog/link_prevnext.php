<?php
/*	****************************************************************
		データベース接続解除
	****************************************************************/


	// diaryのとき
	if($pageClass == "diary entry" || $pageClass == "diary monthly" || $pageClass == "diary yearly" || $pageClass == "diary index") {
		if($pageClass == "diary index") require_once($rootDir."prog/trans_datetime.php");
		include($rootDir."prog/diary/get_nextprev_url.php");
	}
	
	// prevPageUrl と nextPageUrlがあるときはlink要素を追加
	if($prevPageUrl != "") {
		$pageHeader .= "
<link rel=\"prev\" href=\"".p($prevPageUrl)."\" />";
	}

	if($nextPageUrl != "") {
		$pageHeader .= "
<link rel=\"next\" href=\"".p($nextPageUrl)."\" />";
	}
?>
