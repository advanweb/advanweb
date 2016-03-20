<?php
/*	****************************************************************
		入力エラーチェック関数
		
		$input = 入力値
		
		P : Positive =	0以上
		L : Limit =		文字数制限あり
		S : Space & Special Chars =	スペース、記号不可
		N : Null =		空白可
	****************************************************************/

	
	/*
	 *	入力チェック
	 *	整数が入力されているか
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputInt($input, $name, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません。</p>";
			$showFlag = false;
		}
		if (is_numeric($input) == false || $input-(int)($input) != 0) {
			echo "<p class=\"error\">[エラー] ".$name."には整数を入力してください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	0以上の整数が入力されているか (桁数制限あり・空白可)
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputIntPLN($input, $name, $limit, $showFlag)
	{
		if ($input != "") {
			if (is_numeric($input) == false || $input < 0 || $input-(int)($input) != 0) {
				echo "<p class=\"error\">[エラー] ".$name."には0以上の整数を入力をしてください。</p>";
				$showFlag = false;
			}
			
			if (strlen($input) > $limit) {
				echo "<p class=\"error\">[エラー] ".$name."は".$limit."桁以下にしてください。</p>";
				$showFlag = false;
			}
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	0以上の整数が入力されているか (桁数制限あり)
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputIntPL($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません。</p>";
			$showFlag = false;
		}
		if (is_numeric($input) == false || $input < 0 || $input-(int)($input) != 0) {
			echo "<p class=\"error\">[エラー] ".$name."には0以上の整数を入力してください。</p>";
			$showFlag = false;
		}
		
		if (strlen($input) > $limit) {
			echo "<p class=\"error\">[エラー] ".$name."は".$limit."桁以下にしてください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	実数が入力されているか
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputDouble($input, $name, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません。</p>";
			$showFlag = false;
		}
		if (is_Numeric($input) == false) {
			echo "<p class=\"error\">[エラー] ".$name."には実数を入力してください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	0以上の実数が入力されているか (桁数制限あり・空白可)
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputDoublePLN($input, $name, $limit, $showFlag)
	{
		if ($input != "") {
			if (is_numeric($input) == false || $input < 0) {
				echo "<p class=\"error\">[エラー] ".$name."には0以上の実数を入力してください。</p>";
				$showFlag = false;
			}
			
			if (strlen($input) > $limit) {
				echo "<p class=\"error\">[エラー] ".$name."は".$limit."桁以下にしてください。</p>";
				$showFlag = false;
			}
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	0以上の実数が入力されているか (桁数制限あり)
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputDoublePL($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません。</p>";
			$showFlag = false;
		}
		if (is_numeric($input) == false || $input < 0) {
			echo "<p class=\"error\">[エラー] ".$name."は0以上の実数を入力してください。</p>";
			$showFlag = false;
		}
		
		if (strlen($input) > $limit) {
			echo "<p class=\"error\">[エラー] ".$name."は".$limit."桁以下にしてください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	テキストが入力されているか
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputString($input, $name, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません。</p>";
			$showFlag = false;
		}
		if (is_string($input) == false) {
			echo "<p class=\"error\">[エラー] ".$name."にはテキストを入力してください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	テキストが入力されているか (文字数制限あり)
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$limit : 文字数制限
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputStringL($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません</p>";
			$showFlag = false;
		}
		if (is_string($input) == false) {
			echo "<p class=\"error\">[エラー] ".$name."にはテキストを入力してください。</p>";
			$showFlag = false;
		}
		
		if (strlen($input) > $limit) {
			echo "<p class=\"error\">[エラー] ".$name."は".$limit."文字以下にしてください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	テキストが入力されているか (スペース不可・記号不可・文字数制限あり)
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$limit : 文字数制限
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputStingSL($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<p class=\"error\">[エラー] ".$name."が入力されていません</p>";
			$showFlag = false;
		}
		if (is_string($input) == false) {
			echo "<p class=\"error\">[エラー] ".$name."にはテキストを入力してください。</p>";
			$showFlag = false;
		}
		if (strpos($input, " ") !== false) {
			echo "<p class=\"error\">[エラー] ".$name."にはスペースを入れないでください。</p>";
			$showFlag = false;
		}
		if (strpos($input, "　") !== false) {
			echo "<p class=\"error\">[エラー] ".$name."にはスペースを入れないでください。</p>";
			$showFlag = false;
		}
		// $fbdn.array("!", "\"", "#", "$", "%", "&", "'", "(", ")", "^", "\\", "=", "~", "|", "@", "[", "]", ";", ":", "`", "{", "}", "+", "*", ",", ".", "/", "<", ">", "?");
		$fbdn[1] = "!";
		$fbdn[2] = "\"";
		$fbdn[3] = "#";
		$fbdn[4] = "$";
		$fbdn[5] = "%";
		$fbdn[6] = "&";
		$fbdn[7] = "'";
		$fbdn[8] = "(";
		$fbdn[9] = ")";
		$fbdn[10] = "^";
		$fbdn[11] = "=";
		$fbdn[12] = "~";
		$fbdn[13] = "|";
		$fbdn[14] = "@";
		$fbdn[15] = "[";
		$fbdn[16] = "]";
		$fbdn[17] = ";";
		$fbdn[18] = ":";
		$fbdn[19] = "`";
		$fbdn[20] = "{";
		$fbdn[21] = "}";
		$fbdn[22] = "+";
		$fbdn[23] = "*";
		$fbdn[24] = ",";
		$fbdn[25] = ".";
		$fbdn[26] = "/";
		$fbdn[27] = "\\";
		$fbdn[28] = "<";
		$fbdn[29] = ">";
		$fbdn[30] = "?";
		foreach ($fbdn as $num => $char) {
			if (strpos($input, $char) !== false) {
				echo "<p class=\"error\">[エラー] ".$name."には記号を入れないください。</p>";
				$showFlag = false;
			}
		}
		
		if (strlen($input) > $limit) {
			echo "<p class=\"error\">[エラー] ".$name."は".$limit."文字以下にしてください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	入力チェック
	 *	テキスト文字数制限のみ
	 *	
	 *	$input : 入力値
	 *	$name : フィールド名
	 *	$limit : 文字数制限
	 *	$showFlag : 結果表示フラッグ
	 */
	
	function checkInputStringLN($input, $name, $limit, $showFlag)
	{
		if (strlen($input) > $limit) {
			echo "<p class=\"error\">[エラー] ".$name."は".$limit."文字以下にしたください。</p>";
			$showFlag = false;
		}
		
		return $showFlag;
	}
	
?>