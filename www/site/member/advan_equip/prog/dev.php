<?php
/*	****************************************************************
		変数を表示してみるテスト
		
		$showTest[変数名] = 変数
	****************************************************************/


	// $_SESSION["ae_devFlag1"] = true;
	
	if ($_SESSION["ae_devFlag1"] == true) {
		echo "
		<p class=\"dev\">";
		foreach ($dev as $sub => $val){
			echo "
			".$sub." = ".p($val)."<br />";
		}
		echo "
		</p>";
	}


/* [呼び出し方法]
	
	$dev["変数名"] = $変数;
	include($rootDir."prog/dev.php");
*/

?>
