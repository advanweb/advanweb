<?php
/*	****************************************************************
		コンディション変更
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>カテゴリー変更 | Advanced Creators 機材管理サイト</title>
<?php
	
	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	$id1 = $_POST["id1"];
	$cate1 = $_POST["cate1"];

	if (is_string($cate1) == true) {
		$act1 = 1;
	}
	
	// ページのタイトル
	$pageTitle = "カテゴリー変更";
	$pageClass = "equip cate";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("../prog/root_dir.php");
	
	// html header
	
	// 各ページ共通のプログラム
	require_once($rootDir."prog/common.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	


echo "
<h2>".$pageTitle."</h2>";


	// act1 
	if ($act1 == 1) {
	
		if ($id1 == "") {
			$showFlag1 = false;
		}
		else {
			// 機材データを取得
			$query1 = "SELECT * FROM `ae_equip` WHERE `id` = ".$id1." LIMIT 1";
			$result1 = mysql_query($query1);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
			
			// nameの存在しないレコード指定したときは表示しない
			if ($rec1["name"] == "") {
				$showFlag1 = false;
			}
			
			// ステータス１～４の列名を取得
			$query2 = "SELECT * FROM `ae_equip_title` WHERE `category` = '".$rec1["category"]."' LIMIT 1";
			$result2 = mysql_query($query2);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
			
			// コメントをHTMLに変換
			$comment1 = p($rec1["comment"]);
			$cond_comm1 = p($rec1["cond_comm"]);
		}
		
		
		// showFlag1がtrueのときのみ
		if ($showFlag1 == true) {
		
			// 機材データの表示
			echo "
<h3>".$rec1["maker"]."　".$rec1["name"]."</h3>";
			
			include ($rootDir."visual/equip_topic_path.php");	// パンくずリスト
	
			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
			
			// テキスト
			echo "
<p>機材のカテゴリーを変更します。</p>
<p>ラジオボタンで部署を選択し、プルダウンメニューからカテゴリーを選択しください。</p>";

			// カテゴリー
			echo "
<form action=\"update.php\" method=\"post\">
	<table>
		<tr>
			<th>部署</th>
			<th>カテゴリー</th>
		</tr>
		<tr>
			<td>
				<label><input type=\"radio\" name=\"class1\" value=\"音響\"";
				if ($rec1["class"] == "音響") {
					echo " checked=\"checked\"";
				}
				echo " /><img src=\"".$rootDir."img/ico_pa_01.png\" alt=\"\" width=\"11\" height=\"11\" />音響</label>
			</td>
			<td>
				<select name=\"category0\" size=\"1\">
					<option value=\"コンソール\"";
					if ($rec1["category"] == "コンソール") {
						echo " selected=\"selected\"";
					}
					echo ">コンソール</option>
					<option value=\"エフェクター\"";
					if ($rec1["category"] == "エフェクター") {
						echo " selected=\"selected\"";
					}
					echo ">エフェクター</option>
					<option value=\"プレーヤー\"";
					if ($rec1["category"] == "プレーヤー") {
						echo " selected=\"selected\"";
					}
					echo ">プレーヤー</option>
					<option value=\"スピーカー\"";
					if ($rec1["category"] == "スピーカー") {
						echo " selected=\"selected\"";
					}
					echo ">スピーカー</option>
					<option value=\"パワーアンプ\"";
					if ($rec1["category"] == "パワーアンプ") {
						echo " selected=\"selected\"";
					}
					echo ">パワーアンプ</option>
					<option value=\"マイク\"";
					if ($rec1["category"] == "マイク") {
						echo " selected=\"selected\"";
					}
					echo ">マイク</option>
					<option value=\"DI\"";
					if ($rec1["category"] == "DI") {
						echo " selected=\"selected\"";
					}
					echo ">DI</option>
					<option value=\"PD\"";
					if ($rec1["category"] == "PD") {
						echo " selected=\"selected\"";
					}
					echo ">PD</option>
					<option value=\"ヘッドフォン\"";
					if ($rec1["category"] == "ヘッドフォン") {
						echo " selected=\"selected\"";
					}
					echo ">ヘッドフォン</option>
					<option value=\"その他音響\"";
					if ($rec1["category"] == "その他音響") {
						echo " selected=\"selected\"";
					}
					echo ">その他音響</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label><input type=\"radio\" name=\"class1\" value=\"照明\"";
				if ($rec1["class"] == "照明") {
					echo " checked=\"checked\"";
				}
				echo " /><img src=\"".$rootDir."img/ico_lighting_01.png\" alt=\"\" width=\"11\" height=\"11\" />照明</label>
			</td>
			<td>
				<select name=\"category1\" size=\"1\">
					<option value=\"調光卓\"";
					if ($rec1["category"] == "調光卓") {
						echo " selected=\"selected\"";
					}
					echo ">調光卓</option>
					<option value=\"ディマー\"";
					if ($rec1["category"] == "ディマー") {
						echo " selected=\"selected\"";
					}
					echo ">ディマー</option>
					<option value=\"灯体\"";
					if ($rec1["category"] == "灯体") {
						echo " selected=\"selected\"";
					}
					echo ">灯体</option>
					<option value=\"レンズ・電球\"";
					if ($rec1["category"] == "レンズ・電球") {
						echo " selected=\"selected\"";
					}
					echo ">レンズ・電球</option>
					<option value=\"ハンガー・クランプ\"";
					if ($rec1["category"] == "ハンガー・クランプ") {
						echo " selected=\"selected\"";
					}
					echo ">ハンガー・クランプ</option>
					<option value=\"バンドア\"";
					if ($rec1["category"] == "バンドア") {
						echo " selected=\"selected\"";
					}
					echo ">バンドア</option>
					<option value=\"エフェクト\"";
					if ($rec1["category"] == "エフェクト") {
						echo " selected=\"selected\"";
					}
					echo ">エフェクト</option>
					<option value=\"ゼラ枠\"";
					if ($rec1["category"] == "ゼラ枠") {
						echo " selected=\"selected\"";
					}
					echo ">ゼラ枠</option>
					<option value=\"ゼラ\"";
					if ($rec1["category"] == "ゼラ") {
						echo " selected=\"selected\"";
					}
					echo ">ゼラ</option>
					<option value=\"その他照明\"";
					if ($rec1["category"] == "その他照明") {
						echo " selected=\"selected\"";
					}
					echo ">その他照明</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label><input type=\"radio\" name=\"class1\" value=\"ケーブル\"";
				if ($rec1["class"] == "ケーブル") {
					echo " checked=\"checked\"";
				}
				echo " /><img src=\"".$rootDir."img/ico_cable_01.png\" alt=\"\" width=\"11\" height=\"11\" />ケーブル</label>
			</td>
			<td>
				<select name=\"category2\" size=\"1\">
					<option value=\"マイクケーブル\"";
					if ($rec1["category"] == "マイクケーブル") {
						echo " selected=\"selected\"";
					}
					echo ">マイクケーブル</option>
					<option value=\"スピーカーケーブル\"";
					if ($rec1["category"] == "スピーカーケーブル") {
						echo " selected=\"selected\"";
					}
					echo ">スピーカーケーブル</option>
					<option value=\"立ち上げ\"";
					if ($rec1["category"] == "立ち上げ") {
						echo " selected=\"selected\"";
					}
					echo ">立ち上げ</option>
					<option value=\"マルチ\"";
					if ($rec1["category"] == "マルチ") {
						echo " selected=\"selected\"";
					}
					echo ">マルチ</option>
					<option value=\"楽器用ケーブル\"";
					if ($rec1["category"] == "楽器用ケーブル") {
						echo " selected=\"selected\"";
					}
					echo ">楽器用ケーブル</option>
					<option value=\"電源\"";
					if ($rec1["category"] == "電源") {
						echo " selected=\"selected\"";
					}
					echo ">電源</option>
					<option value=\"アース\"";
					if ($rec1["category"] == "アース") {
						echo " selected=\"selected\"";
					}
					echo ">アース</option>
					<option value=\"コネクター\"";
					if ($rec1["category"] == "コネクター") {
						echo " selected=\"selected\"";
					}
					echo ">コネクター</option>
					<option value=\"その他ケーブル\"";
					if ($rec1["category"] == "その他ケーブル") {
						echo " selected=\"selected\"";
					}
					echo ">その他ケーブル</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label><input type=\"radio\" name=\"class1\" value=\"スタンド\"";
				if ($rec1["class"] == "スタンド") {
					echo " checked=\"checked\"";
				}
				echo " /><img src=\"".$rootDir."img/ico_stand_01.png\" alt=\"\" width=\"11\" height=\"11\" />スタンド</label>
			</td>
			<td>
				<select name=\"category3\" size=\"1\">
					<option value=\"マイクスタンド\"";
					if ($rec1["category"] == "マイクスタンド") {
						echo " selected=\"selected\"";
					}
					echo ">マイクスタンド</option>
					<option value=\"マイクホルダー\"";
					if ($rec1["category"] == "マイクホルダー") {
						echo " selected=\"selected\"";
					}
					echo ">マイクホルダー</option>
					<option value=\"スピーカースタンド\"";
					if ($rec1["category"] == "スピーカースタンド") {
						echo " selected=\"selected\"";
					}
					echo ">スピーカースタンド</option>
					<option value=\"照明スタンド\"";
					if ($rec1["category"] == "照明スタンド") {
						echo " selected=\"selected\"";
					}
					echo ">照明スタンド</option>
					<option value=\"楽器用スタンド\"";
					if ($rec1["category"] == "楽器用スタンド") {
						echo " selected=\"selected\"";
					}
					echo ">楽器用スタンド</option>
					<option value=\"その他スタンド\"";
					if ($rec1["category"] == "その他スタンド") {
						echo " selected=\"selected\"";
					}
					echo ">その他スタンド</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label><input type=\"radio\" name=\"class1\" value=\"アクセサリー\"";
				if ($rec1["class"] == "アクセサリー") {
					echo " checked=\"checked\"";
				}
				echo " /><img src=\"".$rootDir."img/ico_accessory_01.png\" alt=\"\" width=\"11\" height=\"11\" />アクセサリー</label>
			</td>
			<td>
				<select name=\"category4\" size=\"1\">
					<option value=\"音響アクセサリー\"";
					if ($rec1["category"] == "音響アクセサリー") {
						echo " selected=\"selected\"";
					}
					echo ">音響アクセサリー</option>
					<option value=\"照明アクセサリー\"";
					if ($rec1["category"] == "照明アクセサリー") {
						echo " selected=\"selected\"";
					}
					echo ">照明アクセサリー</option>
					<option value=\"ラック\"";
					if ($rec1["category"] == "ラック") {
						echo " selected=\"selected\"";
					}
					echo ">ラック</option>
					<option value=\"ケース\"";
					if ($rec1["category"] == "ケース") {
						echo " selected=\"selected\"";
					}
					echo ">ケース</option>
					<option value=\"工具\"";
					if ($rec1["category"] == "工具") {
						echo " selected=\"selected\"";
					}
					echo ">工具</option>
					<option value=\"文具\"";
					if ($rec1["category"] == "文具") {
						echo " selected=\"selected\"";
					}
					echo ">文具</option>
					<option value=\"楽器\"";
					if ($rec1["category"] == "楽器") {
						echo " selected=\"selected\"";
					}
					echo ">楽器</option>
					<option value=\"その他\"";
					if ($rec1["category"] == "その他") {
						echo " selected=\"selected\"";
					}
					echo ">その他</option>
				</select>
			</td>
		</tr>
	</table>
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".$id1."\" />
		<input type=\"reset\" name=\"reset1\" value=\"表示をリセット\" />
		<input type=\"submit\" name=\"regist1\" value=\"変更\" class=\"submit\" />　
	</p>
</form>
<form action=\"update.php\" method=\"post\">
	<p class=\"submit\">
		<input type=\"hidden\" name=\"id1\" value=\"".$id1."\" />
		<input type=\"submit\" name=\"update1\" value=\"キャンセル\" />　
	</p>
</form>";


			// 戻るナビゲーション
			$message = "機材詳細へ戻る";
			$href = "detail.php?id=".$id1;
			include($rootDir."visual/nav_back.php");
		}
	}
	
	else {
		$showFlag1 = false;
	}
	
	// showFlag1エラーの時
	if ($showFlag1 != true) {		
		echo "
<p class=\"error\">[エラー] リストを表示できませんでした。</p>
<p>[戻る] を押すとトップページに戻ります。</p>
<form action=\"".$rootDir."\" method=\"post\" />
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
	$dev["editFlag1"] = $_SESSION["ae_editFlag1"];
	$dev["query1"] = $query1;
	$dev["query2"] = $query2;
	$dev["rec1[class]"] = $rec1["class"];
	$dev["rec1[category]"] = $rec1["category"];
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>