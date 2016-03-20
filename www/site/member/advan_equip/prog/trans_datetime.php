<?php
/*	****************************************************************
		DTF - 配列相互変換関数
		
		$dtf = DTF YYYY-MM-DDThh:mm:ssTZD型
		$datetime[] = array("year", "month", "day", "hour", "minute", "second", "timezone")
	****************************************************************/

	
	function dtf2array($dtf)
	{
		$datetime["year"] = substr($dtf, 0, 4);
		$datetime["month"] = substr($dtf, 5, 2);
		$datetime["day"] = substr($dtf, 8, 2);
		$datetime["hour"] = substr($dtf, 11, 2);
		$datetime["minute"] = substr($dtf, 14, 2);
		$datetime["second"] = substr($dtf, 17, 2);
		$datetime["timezone"] = substr($dtf, 19);
		
		return $datetime;
	}
	

	function array2dtf($datetime)
	{
		$dtf = "".$datetime["year"]."-".$datetime["month"]."-".$datetime["day"]."T".$datetime["hour"].":".$datetime["minute"].":".$datetime["second"].$datetime["timezone"];
		
		return $dtf;
	}
	
?>