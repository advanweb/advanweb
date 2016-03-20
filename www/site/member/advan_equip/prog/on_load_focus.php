<?php
/*	****************************************************************
		body.onLoadでフォーカスする
		
		$onLoadFocus = フォーカスするターゲット
	****************************************************************/


	if ($onLoadFocus == "") {
		$onLoadFocus = "";
	}
	else {
		$onLoadFocus = " onLoad=\"".p($onLoadFocus).".focus()\"";
	}

?>