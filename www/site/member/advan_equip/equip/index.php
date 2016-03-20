<?php
/*	****************************************************************
		機材リスト
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>機材リスト | Advanced Creators 機材管理サイト</title>
<?php

	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$category1 = $_GET["category"];
	$submit1 = $_POST["submit1"];
	
	if (is_numeric($category1) == true) {
		$act1 = true;
	}
	else if ($category1 == "") {
		$act2 = true;
	}
	

	// ページのタイトル
	$pageTitle = "機材リスト";
	$pageClass = "equip";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("../prog/root_dir.php");
	
	// html header
	// link要素
	if ($category1 != "" && $category1 < "48") $pageHeader .= "
<link rel=\"next\" href=\"./?category=".($category1+1)."\" />";	// nextに1つ次のカテゴリー
	if ($category1 != "" && $category1 > "1") $pageHeader .= "
<link rel=\"prev\" href=\"./?category=".($category1-1)."\" />";	// prevに1つ前のカテゴリー
	if ($category1 != "") $pageHeader .= "
<link rel=\"first\" href=\"./?category=1\" />
<link rel=\"last\" href=\"./?category=48\" />";					// firstにコンソール、lastにその他
	
	// 各ページ共通のプログラム
	require_once($rootDir."prog/common.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	
	
	
	// カテゴリー名を取得
	if ($act1 == true) {
		$query1 = "SELECT * FROM `ae_equip_title` WHERE `id` = ".p($category1)." LIMIT 1";
		$result1 = mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}

		// 結果を取得
		$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
		$class2 = $rec1["class"];
		$category2 = $rec1["category"];
		$status1 = $rec1["status1"];
		
		// categoryの存在しないレコード指定したときは表示しない
		if ($category2 == "") {
			$showFlag1 = false;
		}
		
		
		// 機材リストの検索
		// クエリ
		$query2 = "SELECT * FROM `ae_equip` WHERE `category` = '".$category2."' AND `stock` > 0 ORDER BY `maker` ASC , `name` ASC";
		$result2 = mysql_query($query2);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}
		
		// 個数の取得
		$num2 = mysql_num_rows($result2);
		
		// 過去の機材リストの検索
		// クエリ
		$query3 = "SELECT * FROM `ae_equip` WHERE `category` = '".$category2."' AND `stock` = 0 ORDER BY `maker` ASC , `name` ASC";
		$result3 = mysql_query($query3);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}
		
		// 個数の取得
		$num3 = mysql_num_rows($result3);
	}
		
	// showFlag1がtrueのときのみ
	if ($showFlag1 == true) {
	
		// リスト表示
		if ($act1 == true) {
						
			// カテゴリー名の表示
			echo "
<h2>".$pageTitle."</h2>
<h3>".p($class2)." &gt; ".p($category2)."</h3>";
	
			// 戻るナビゲーション
			$message = "機材カテゴリー一覧へ戻る";
			$href = "./";
			include($rootDir."visual/nav_back.php");

			// 検索結果が０のとき
			if ($num2 == 0) {
				echo "
<p>このカテゴリーの機材はありません。</p>";
			}
	
			// １以上のとき
			else {
						
				echo "
<p>このカテゴリーには ".p($num2)." 機種の機材があります。</p>";
				
				// テーブルの中身を順番に取り出して表示する
				echo "
<table class=\"dbList\" summary=\"このカテゴリーにある機材の一覧\">
	<tr>
		<th>メーカー</th>
		<th>機材名</th>
		<th>カテゴリー</th>
		<th>良好 / 総数</th>
		<th>".p($rec1["status1"])."</th>
	</tr>";
				for ($i=0;$i<$num2;$i++) {
					$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
					// 部署のクラスを取得
					include($rootDir."prog/class_2_class.php");
					// レコード表示
					echo "
	<tr>
		<td>".p($rec2["maker"])."</td>
		<td><a href=\"detail.php?id=".p($rec2["id"])."\">".p($rec2["name"])."</a></td>
		<td class=\"".p($classClass)."\">".p($rec2["category"])."</td>
		<td>".p($rec2["condition1"])." / ".p($rec2["stock"])."</td>
		<td>".p($rec2["status1"])."</td>
	</tr>";
				}
				echo "
</table>
<p>機材の詳細を見たり、機材のデータを変更したりするには、機材名をクリックしてください。</p>";
			}
			
			
			// 過去の機材の表示
			if ($num3 > 0) {
						
				echo "
<h4>過去に所有していた機材</h4>
<p>".$num3." 機種の機材があります。</p>";
				
				// テーブルの中身を順番に取り出して表示する
				echo "
<table class=\"dbList\" summary=\"過去に所有していた機材の一覧\">
	<tr>
		<th>メーカー</th>
		<th>機材名</th>
		<th>カテゴリー</th>
		<th>所持数</th>
		<th>".p($rec1["status1"])."</th>
	</tr>";
				for ($i=0;$i<$num3;$i++) {
					$rec3 = mysql_fetch_array($result3,MYSQL_ASSOC);
					// レコード表示
					echo "
	<tr>
		<td>".p($rec3["maker"])."</td>
		<td><a href=\"detail.php?id=".p($rec3["id"])."\">".p($rec3["name"])."</a></td>
		<td class=\"".p($classClass)."\">".p($rec2["category"])."</td>
		<td>".p($rec3["stock"])."</td>
		<td>".p($rec3["status1"])."</td>
	</tr>";
				}
				echo "
</table>";
			}
			
			// 戻るナビゲーション
			$message = "機材カテゴリー一覧へ戻る";
			$href = "./";
			include($rootDir."visual/nav_back.php");

			
			// 新規機材追加
			echo "
<p>機材データベースに登録されていない機種を追加するには、 [新規機材登録] を押してください。</p>
<form action=\"add.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"class1\" value=\"".p($rec1["class"])."\" />
		<input type=\"hidden\" name=\"category1\" value=\"".p($rec1["category"])."\" />
		<input type=\"submit\" name=\"add1\" id=\"add1-id\" value=\"新規機材登録\" />
	</p>
</form>";
		}
		
		// カテゴリー指定なし
		else if ($act2 == true) {
			echo "
<h2>機材リスト</h2>
<h3>機材カテゴリー一覧</h3>";

			// 戻るナビゲーション
			$message = "トップページへ戻る";
			$href = $rootDir;
			include($rootDir."visual/nav_back.php");
			
			echo "
<p>データベースから機材のデータを表示します。<br />
以下のリストから表示する機材のカテゴリーを選択してください。</p>
<dl class=\"pa\">
	<dt>音響</dt>
	<dd>
		<ul>
			<li><a href=\"".$rootDir."equip/?category=1\">コンソール</a></li>
			<li><a href=\"".$rootDir."equip/?category=2\">エフェクター</a></li>
			<li><a href=\"".$rootDir."equip/?category=3\">プレーヤー</a></li>
			<li><a href=\"".$rootDir."equip/?category=4\">スピーカー</a></li>
			<li><a href=\"".$rootDir."equip/?category=5\">パワーアンプ</a></li>
			<li><a href=\"".$rootDir."equip/?category=6\">マイク</a></li>
			<li><a href=\"".$rootDir."equip/?category=7\">DI</a></li>
			<li><a href=\"".$rootDir."equip/?category=8\">PD</a></li>
			<li><a href=\"".$rootDir."equip/?category=9\">ヘッドフォン</a></li>
			<li><a href=\"".$rootDir."equip/?category=10\">その他音響</a></li>
		</ul>
	</dd>
</dl>
<dl class=\"lighting\">
	<dt>照明</dt>
	<dd>
		<ul>
			<li><a href=\"".$rootDir."equip/?category=11\">調光卓</a></li>
			<li><a href=\"".$rootDir."equip/?category=12\">ディマー</a></li>
			<li><a href=\"".$rootDir."equip/?category=13\">灯体</a></li>
			<li><a href=\"".$rootDir."equip/?category=14\">レンズ・電球</a></li>
			<li><a href=\"".$rootDir."equip/?category=15\">ハンガー・クランプ</a></li>
			<li><a href=\"".$rootDir."equip/?category=16\">バンドア</a></li>
			<li><a href=\"".$rootDir."equip/?category=17\">エフェクト</a></li>
			<li><a href=\"".$rootDir."equip/?category=18\">ゼラ枠</a></li>
			<li><a href=\"".$rootDir."equip/?category=19\">ゼラ</a></li>
			<li><a href=\"".$rootDir."equip/?category=20\">その他照明</a></li>
		</ul>
	</dd>
</dl>
<dl class=\"cable\">
	<dt>ケーブル</dt>
	<dd>
		<ul>
			<li><a href=\"".$rootDir."equip/?category=21\">マイクケーブル</a></li>
			<li><a href=\"".$rootDir."equip/?category=22\">スピーカーケーブル</a></li>
			<li><a href=\"".$rootDir."equip/?category=23\">立ち上げ</a></li>
			<li><a href=\"".$rootDir."equip/?category=24\">マルチ</a></li>
			<li><a href=\"".$rootDir."equip/?category=25\">楽器用ケーブル</a></li>
			<li><a href=\"".$rootDir."equip/?category=26\">電源</a></li>
			<li><a href=\"".$rootDir."equip/?category=27\">アース</a></li>
			<li><a href=\"".$rootDir."equip/?category=28\">コネクター</a></li>
			<li><a href=\"".$rootDir."equip/?category=30\">その他ケーブル</a></li>
		</ul>
	</dd>
</dl>
<dl class=\"stand\">
	<dt>スタンド</dt>
	<dd>
		<ul>
			<li><a href=\"".$rootDir."equip/?category=31\">マイクスタンド</a></li>
			<li><a href=\"".$rootDir."equip/?category=32\">マイクホルダー</a></li>
			<li><a href=\"".$rootDir."equip/?category=33\">スピーカースタンド</a></li>
			<li><a href=\"".$rootDir."equip/?category=34\">照明スタンド</a></li>
			<li><a href=\"".$rootDir."equip/?category=35\">楽器用スタンド</a></li>
			<li><a href=\"".$rootDir."equip/?category=40\">その他スタンド</a></li>
		</ul>
	</dd>
</dl>
<dl class=\"accessory\">
	<dt>その他</dt>
	<dd>
		<ul>
			<li><a href=\"".$rootDir."equip/?category=41\">音響アクセサリー</a></li>
			<li><a href=\"".$rootDir."equip/?category=42\">照明アクセサリー</a></li>
			<li><a href=\"".$rootDir."equip/?category=43\">ラック</a></li>
			<li><a href=\"".$rootDir."equip/?category=44\">ケース</a></li>
			<li><a href=\"".$rootDir."equip/?category=45\">工具</a></li>
			<li><a href=\"".$rootDir."equip/?category=46\">文具</a></li>
			<li><a href=\"".$rootDir."equip/?category=47\">楽器</a></li>
			<li><a href=\"".$rootDir."equip/?category=50\">その他</a></li>
		</ul>
	</dd>
</dl>";
			
			// 戻るナビゲーション
			$message = "トップページへ戻る";
			$href = $rootDir;
			include($rootDir."visual/nav_back.php");
		}
	}
	
	// 入力が不正の時のエラー表示
	else {
		echo "
<p class=\"error\">[エラー] リストを表示できませんでした。</p>
<p>[戻る] を押すとトップページに戻ります。</p>
<form action=\"".$rootDir."\" method=\"post\">
	<p class=\"submit\"><input type=\"submit\" name=\"return1\" value=\"戻る\" /></p>
</form>";
	}


	// 表示してみるテスト
	$dev["userID1"] = $_SESSION["ae_userID1"];
	$dev["name1"] = $_SESSION["ae_name1"];
	$dev["nendo1"] = $_SESSION["ae_nendo1"];
	$dev["pass1"] = $_SESSION["ae_pass1"];
	$dev["loginFlag1"] = $_SESSION["ae_loginFlag1"];
	$dev["id1"] = $id1;
	$dev["submit1"] = $submit1;
	$dev["act1"] = $act1;
	$dev["showFlag1"] = $showflag1;
	$dev["query1"] = $query1;
	$dev["rec1[category]"] = $rec1["category"];
	$dev["class2"] = $class2;
	$dev["category2"] = $category2;
	$dev["query2"] = $query2;
	$dev["num2"] = $num2;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require_once($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require_once($rootDir."prog/db_close.php");

?>