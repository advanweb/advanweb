<?php


// ȥڤؤ
$title_img_num = 10;	// ڤؤθĿ

// $title_img_id = mt_rand(1, 10);
if (isset($_SESSION["ae_title_img_id"]) == true) {
	$_SESSION["ae_title_img_id"]++;
	if ($_SESSION["ae_title_img_id"] > $title_img_num) {
		$_SESSION["ae_title_img_id"] = 1;
	}
}
else {
	$_SESSION["ae_title_img_id"] = mt_rand(1, $title_img_num);
}

$title_img_id = $_SESSION["ae_title_img_id"];

if ($title_img_id < 10) {
	$title_img_id = "0".$title_img_id;
}
$title_img_src = "img/title_01_".$title_img_id.".jpg";	// 



/*
 *	$layout["header"] :		ɥΡᥤɽ
 *	$layout["only_main"] :	ȥåײȥᥤɽȥ쥤ѥơ֥Τ
 *	$layout["status"] :		ơɽ
 *	$layout["body"] :		ʸ
 *	$layout["footer"] :		ʸλ說λ
 *	
 *	
 *	<���>
 *	$layout["header"].$layout["only_main"].$layout["body"]
 *	ʸ
 *	$layout["footer"]
 *	
 *	
 *	<���>
 *	$layout["header"].$layout["menu"].$layout["status"].$layout["body"]
 *	ʸ
 *	$layout["footer"]
 *	
 */


$layout["header"] = "
<!-- window ɥ -->
<div id=\"window\">

	<!-- parent ʬ -->
	<div id=\"parent\">

		<!-- header إå -->
		<div id=\"header\">
			<!-- title_img ȥ -->
			<div id=\"title_img\">
				<a href=\"top_01.php\"><img src=\"".$title_img_src."\" width=\"750\" height=\"120\"></a>
			</div>
		</div>



		<!-- menu ˥塼 -->
		<div id=\"menu\">
			<span class=\"menu_btn\"><a href=\"top_01.php\">ȥå</a></span>
			<span class=\"menu_btn\"><a href=\"eve_list_01.php\">٥</a></span>
			<span class=\"menu_btn\"><a href=\"about_01.php\">ΥȤˤĤ</a></span>
			<span class=\"menu_btn\"><a href=\"user_info_01.php\">桼</a></span>
			<span class=\"menu_btn\"><a href=\"index.php\">���</a></span>
		</div>



		<!-- main-flame ƥɽȥᥤɽΥ쥤ѥơ֥ -->
		<table id=\"main-flame\">
			<tbody>
				<tr>
						<!-- left ƥɽ -->
					<td>
						<div id=\"left\">
							<div class=\"cate\" id=\"pa\">
								<table>
									<tbody>
										<tr>
											<th></th>
										</tr>
										<tr>
											<td>
												<ul>
													<li><a href=\"eqp_list_01.php?category=1\">󥽡</a>
													<li><a href=\"eqp_list_01.php?category=2\">ե</a>
													<li><a href=\"eqp_list_01.php?category=3\">ץ졼䡼</a>
													<li><a href=\"eqp_list_01.php?category=4\">ԡ</a>
													<li><a href=\"eqp_list_01.php?category=5\">ѥ</a>
													<li><a href=\"eqp_list_01.php?category=6\">ޥ</a>
													<li><a href=\"eqp_list_01.php?category=7\">DI</a>
													<li><a href=\"eqp_list_01.php?category=8\">PD</a>
													<li><a href=\"eqp_list_01.php?category=9\">إåɥե</a>
													<li><a href=\"eqp_list_01.php?category=10\">¾</a>
            									</ul>
											</td>

										</tr>
									</tbody>
								</table>
							</div>
							<div class=\"cate\" id=\"lighting\">
								<table>
									<tbody>
										<tr>
											<th></th>
										</tr>
										<tr>
											<td>
												<ul>
													<li><a href=\"eqp_list_01.php?category=11\">Ĵ</a>
													<li><a href=\"eqp_list_01.php?category=12\">ǥޡ</a>
													<li><a href=\"eqp_list_01.php?category=13\">PAR饤</a>
													<li><a href=\"eqp_list_01.php?category=14\">ơ饤</a>
													<li><a href=\"eqp_list_01.php?category=15\">եȥ饤</a>
													<li><a href=\"eqp_list_01.php?category=16\">ŵ</a>
													<li><a href=\"eqp_list_01.php?category=17\">Хɥ</a>
													<li><a href=\"eqp_list_01.php?category=18\">ϥ󥬡</a>
													<li><a href=\"eqp_list_01.php?category=19\"></a>
													<li><a href=\"eqp_list_01.php?category=20\">¾</a>
            									</ul>
											</td>

										</tr>
									</tbody>
								</table>
							</div>
							<div class=\"cate\" id=\"cable\">
								<table>
									<tbody>
										<tr>
											<th>֥</th>
										</tr>
										<tr>
											<td>
												<ul>
													<li><a href=\"eqp_list_01.php?category=21\">ޥ֥</a>
													<li><a href=\"eqp_list_01.php?category=22\">ԡ֥</a>
													<li><a href=\"eqp_list_01.php?category=23\">Ω夲</a>
													<li><a href=\"eqp_list_01.php?category=24\">ޥ֥</a>
													<li><a href=\"eqp_list_01.php?category=25\">ڴѥ֥</a>
													<li><a href=\"eqp_list_01.php?category=26\">Ÿ</a>
            									</ul>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class=\"cate\" id=\"stand\">
								<table>
									<tbody>
										<tr>
											<th></th>
										</tr>
										<tr>
											<td>
												<ul>
													<li><a href=\"eqp_list_01.php?category=31\">ޥ</a>
													<li><a href=\"eqp_list_01.php?category=32\">ԡ</a>
													<li><a href=\"eqp_list_01.php?category=33\"></a>
            									</ul>
											</td>

										</tr>
									</tbody>
								</table>
							</div>
							<div class=\"cate\" id=\"accessory\">
								<table>
									<tbody>
										<tr>
											<th>꡼</th>
										</tr>
										<tr>
											<td>
												<ul>
													<li><a href=\"eqp_list_01.php?category=41\">꡼</a>
													<li><a href=\"eqp_list_01.php?category=42\">꡼</a>
													<li><a href=\"eqp_list_01.php?category=43\"></a>
													<li><a href=\"eqp_list_01.php?category=44\">ʸ</a>
													<li><a href=\"eqp_list_01.php?category=45\">ڴ</a>
													<li><a href=\"eqp_list_01.php?category=46\">¾꡼</a>
            									</ul>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</td>


					<!-- main ᥤɽ -->
					<td>
						<div id=\"main\">
";



$layout["only_main"] = "
<!-- window ɥ -->
<div id=\"window\">

	<!-- parent ʬ -->
	<div id=\"parent\">

		<!-- header إå -->
		<div id=\"header\">
			<!-- title_img ȥ -->
			<div id=\"title_img\">
				<a href=\"index.php\"><img src=\"".$title_img_src."\" width=\"750\" height=\"120\"></a>
			</div>
		</div>



		<!-- main-flame ᥤɽΥ쥤ѥơ֥ -->
		<table id=\"main-flame\">
			<tbody>
				<tr>
					<!-- main ᥤɽ -->
					<td>
						<div id=\"main\">
";



$layout["status"] = "
							<!-- status ơɽ -->
							<div id=\"status\">
								<table>
									<tbody>
										<tr><td>���Υ桼 :&nbsp&nbsp</td><td>".$_SESSION["ae_name1"]."</td></tr>
									</tbody>
								</table>
							</div>
";



$layout["body"] = "
							<!-- body ʸ -->
							<div id=\"body\">
";



$layout["footer"] = "
							</div>

							<!-- footer եå -->
							<div id=\"footer\">
								<hr>
								Advanced Creators <br>
								Copyright &copy; 2006 <a href=\"http://sound.jp/advancedcreators/\" target=\"_blank\">Advanced Creators</a>, <a href=\"http://mkgweb.or.tv/\" target=\"_blank\">XIAORING</a> All rights reserved.
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
";



?>