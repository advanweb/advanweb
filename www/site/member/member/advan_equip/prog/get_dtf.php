<?php
/*	****************************************************************
		現在日時のDTFを返す
		
		
	****************************************************************/

	
	function getDtf()
	{
		// 現在日時を取得
		$dtf1 = "".date("Y")."-".date("m")."-".date("d")."T".date("H").":".date("i").":".date("s")."+09:00";
		
		return $dtf1;
	}
	
?>