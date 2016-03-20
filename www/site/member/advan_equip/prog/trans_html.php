<?php
/*	****************************************************************
		入力からHTML用に変換する関数
		
		$input = 入力値
	****************************************************************/

	
	function p($input)
	{
		$output = $input;
		$output = htmlspecialchars($output);
		$output = strip_tags($output);
		$output = trim($output);
		$output = nl2br($output);
		
		return $output;
	}
	
?>