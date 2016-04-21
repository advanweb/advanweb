<?php
	mb_http_input("UTF-8");
	mb_http_output('UTF-8');
	mb_internal_encoding('UTF-8');


	/*
	 *	ɽƤߤƥ
	 *	
	 *	$input: ɽѿ
	 *	$name: ɽѿ̾
	 */
	
	function showTest($input, $name)
	{
		echo "<div class=\"dev1\">".$name." = ".(nl2br(strip_tags(htmlspecialchars($input))))."</div>";
	}



	/*
	 *	���å
	 *	
	 *	
	 *	$islogin: true (in): ���Υڡ, false (out): ���Υڡ
	 */
	
	function checkLogin($islogin)
	{
		if ($islogin == "true") {
			if ($_SESSION["ae_loginFlag1"] != true) {
				die("<div class=\"err2\">
					<div class=\"err1\">[顼] ���󤷤Ƥ</div>
					<ul>
						<li><a href=\"/advan_equip/default.php\">���ڡ</a>
					</ul>
					<p>loginFlag1 = ".$_SESSION["ae_loginFlag1"]."</p>
				</div>");
			}
		}
		
		else {
			if ($_SESSION["ae_loginFlag1"] == true) {
				unset ($_SESSION["ae_loginFlag1"]);
			}		
		}
		return $_SESSION["ae_loginFlag1"];
	}



	/*
	 *	ơɽ
	 *	
	 *	
	 *	
	 */
	
	function showStatus()
	{
		$status = "<table>
			<tbody>
				<tr><td>��� :</td><td>".$_SESSION["ae_name1"]."</td></tr>
			</tbody>
		</table>";
		return $status;
	}



	/*
	 *	ʥӥɽ ()
	 *	
	 *	
	 *	
	 */
	
	function showNavi($link)
	{
		if ($link == "") {
			$navi = "<div class=\"navi1\"><img src=\"img/btn_left_not_01.gif\" width=\"11\" height=\"11\"></div>";
		}
		else {
			$navi = "<div class=\"navi1\"><a href=\"".$link."\"><img src=\"img/btn_left_01.gif\" width=\"11\" height=\"11\"></a></div>";
		}
		return $navi;
	}


	
	/*
	 *	ϥå
	 *	ϤƤ뤫
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputInt($input, $name, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_numeric($input) == false || $input-(int)($input) != 0) {
			echo "<div class=\"err1\">[顼] ".$name." ˤϤƤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	0ʾϤƤ뤫 (¤ꡦ)
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputInt2($input, $name, $limit, $showFlag)
	{
		if ($input != "") {
			if (is_numeric($input) == false || $input < 0 || $input-(int)($input) != 0) {
				echo "<div class=\"err1\">[顼] ".$name." ˤ 0 ʾϤƤ</div>";
				$showFlag = false;
			}
			
			if (strlen($input) > $limit) {
				echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ޤǤϤǤޤ</div>";
				$showFlag = false;
			}
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	0ʾϤƤ뤫 (¤)
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputInt3($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_numeric($input) == false || $input < 0 || $input-(int)($input) != 0) {
			echo "<div class=\"err1\">[顼] ".$name." ˤ 0 ʾϤƤ</div>";
			$showFlag = false;
		}
		
		if (strlen($input) > $limit) {
			echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ޤǤϤǤޤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	¿ϤƤ뤫
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputDouble($input, $name, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_Numeric($input) == false) {
			echo "<div class=\"err1\">[顼] ".$name." ˤϼ¿ϤƤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	0ʾμ¿ϤƤ뤫 (¤ꡦ)
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputDouble2($input, $name, $limit, $showFlag)
	{
		if ($input != "") {
			if (is_numeric($input) == false || $input < 0) {
				echo "<div class=\"err1\">[顼] ".$name." ˤ 0 ʾμ¿ϤƤ</div>";
				$showFlag = false;
			}
			
			if (strlen($input) > $limit) {
				echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ޤǤϤǤޤ</div>";
				$showFlag = false;
			}
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	0ʾμ¿ϤƤ뤫 (¤)
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputDouble3($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_numeric($input) == false || $input < 0) {
			echo "<div class=\"err1\">[顼] ".$name." ˤ 0 ʾμ¿ϤƤ</div>";
			$showFlag = false;
		}
		
		if (strlen($input) > $limit) {
			echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ޤǤϤǤޤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	ƥȤϤƤ뤫
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$showFlag : ɽեå
	 */
	
	function checkInputText($input, $name, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_string($input) == false) {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	ƥȤϤƤ뤫 (ʸ¤)
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$limit : ʸ
	 *	$showFlag : ɽեå
	 */
	
	function checkInputText2($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_string($input) == false) {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		
		if (strlen($input) > $limit) {
			echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ʸޤǤϤǤޤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	ƥȤϤƤ뤫 (ڡԲġԲġʸ¤)
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$limit : ʸ
	 *	$showFlag : ɽեå
	 */
	
	function checkInputText3($input, $name, $limit, $showFlag)
	{
		if ($input == "") {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (is_string($input) == false) {
			echo "<div class=\"err1\">[顼] ".$name." ϤƤޤ</div>";
			$showFlag = false;
		}
		if (strpos($input, " ") !== false) {
			echo "<div class=\"err1\">[顼] ".$name." ˤϥڡȤޤ</div>";
			$showFlag = false;
		}
		if (strpos($input, "") !== false) {
			echo "<div class=\"err1\">[顼] ".$name." ˤϥڡȤޤ</div>";
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
				echo "<div class=\"err1\">[顼] ".$name." ˤϵ椬Ȥޤ</div>";
				$showFlag = false;
			}
		}
		
		if (strlen($input) > $limit) {
			echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ʸޤǤϤǤޤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϥå
	 *	ƥʸ¤Τ
	 *	
	 *	$input : 
	 *	$name : ե̾
	 *	$limit : ʸ
	 *	$showFlag : ɽեå
	 */
	
	function checkInputText4($input, $name, $limit, $showFlag)
	{
		if (strlen($input) > $limit) {
			echo "<div class=\"err1\">[顼] ".$name."  ".$limit." ʸޤǤϤǤޤ</div>";
			$showFlag = false;
		}
		
		return $showFlag;
	}


	
	/*
	 *	ϤHTMLѤѴ
	 *	
	 *	$input : 
	 */
	
	function p($input)
	{
		$output = $input;
		$output = htmlspecialchars($output);
		$output = strip_tags($output);
		$output = trim($output);
		$output = nl2br($output);
		
		return $output;
	}


	
	/*
	 *	000Ѵ
	 *	
	 *	$input : 
	 */
	
	function trans0to00($input)
	{
		if (strlen($input) <= 1) {
			$output = "0".$input;
		}
		else {
			$output = $input;
		}
		
		return $output;
	}


	
	/*
	 *	μ
	 *	
	 *	$input : ̾
	 */
	
	function getClassImg($input)
	{
		switch ($input) {
			case "音響":
				$output = "ico_pa_01.png";
				break;
			case "照明":
				$output = "ico_lighting_01.png";
				break;
			case "ケーブル":
				$output = "ico_cable_01.png";
				break;
			case "スタンド":
				$output = "ico_stand_01.png";
				break;
			case "その他":
				$output = "ico_accessory_01.png";
				break;
			default:
				$output = "";
		}
		
		return $output;
	}


	
	/*
	 *	ǥμ
	 *	
	 *	$input : ǥ̾
	 */
	
	function getCondImg($input)
	{
		switch ($input) {
			case "ɹ":
				$output = "ico_circ_01.gif";
				break;
			case "":
				$output = "ico_circ_02.gif";
				break;
			case "̯":
				$output = "ico_sqr_01.gif";
				break;
			case "":
				$output = "ico_tri_01.gif";
				break;
			case "ξ":
				$output = "ico_cros_01.gif";
				break;
			case "":
				$output = "ico_cros_02.gif";
				break;
			default:
				$output = "";
		}
		
		return $output;
	}
	
?>