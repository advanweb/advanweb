<?php
/*	****************************************************************
		このサイトの使い方
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>このサイトの使い方 | Advanced Creators 機材管理サイト</title>
<?php

	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	

	// ページのタイトル
	$pageTitle = "このサイトの使い方";
	$pageClass = "help";
	$pageTree = 1;
	
	// ルートディレクトリまでのパスを読み込み
	require_once("../prog/root_dir.php");
	
	// html header
	
	// 各ページ共通のプログラム
	require_once($rootDir."prog/common.php");
	
	
/* ------------------------------------------------------------
	content
------------------------------------------------------------ */	


?>
<h2><?php echo "".p($pageTitle); ?></h2>
<p>超簡易取説を用意しました。<br />
ここに載ってないこと、これを見ても分からないことは制作者に直接問い合わせてください。</p>
<h3>1.機材データを見る</h3>
<p>機材のデータを見るには、左側のカテゴリー名を押してください。<br />
	そのカテゴリーに登録されている機材リストが表示されます。<br />
	その後、リストから見たい機材名をクリックすると、機材詳細ページが表示されます。</p>
<h4>コンディションについて</h4>
<p>使える状態の機材がいくつあり、不調だったり故障していたりする機材がいくつあるか&hellip;といった、機材の状態に関する情報を見ることができます。<br />
機材詳細ページの [コンディション] の欄に、状態別に個数が表示されます。</p>
<h3>2.コンディションを変更する</h3>
<p>コンディションの変更は、機材詳細ページから行えます。<br />
1.の方法で機材詳細を表示してから、コンディションの欄の右下にある [変更] を押してください。<br />
テキストボックスに変更する値を入力して、ボタンを押してください。</p>
<h3>3.機材データを変更する</h3>
<p>機材データの変更は、機材詳細ページから行えます。<br />
1.の方法で機材詳細を表示してから、機材データの欄の右下にある [変更] を押してください。<br />
テキストボックスに変更する値を入力して、ボタンを押してください。</p>
<h3>4.新しい機種を追加登録する</h3>
<p>機材データベースに登録されていない機種の新規追加は、機材リストページから行えます。<br />
	追加したいカテゴリーの機材リストを表示して、 [新規機材登録] を押してください。</p>
<p><em>*注: 既に機材データベースに登録されている機種を買い足したときは、2.の [コンディションの変更] から [総数] を変更するようにしてください。</em></p>
<h3>5.機材を完全に削除する</h3>
<p>機材の完全削除は、機材詳細ページから行えます。<br />
	1. の方法で機材詳細を表示してから、 [完全削除] を押してください。</p>
<p><em>*注: 廃棄処分などで機材を所有しなくなったときは、2.の [コンディションの変更] から [所持数] を変更するようにしてください。<br />
一度削除したデータは2度と復元することができません。</em></p>
<h3>付録</h3>
<h4>コンディションの凡例</h4>
<?php $helpAppendixMode1 = 1; include($rootDir."visual/help_appendix.php"); ?>
<h4>コネクター記号の凡例</h4>
<?php $helpAppendixMode1 = 2; include($rootDir."visual/help_appendix.php"); ?>
<h4>色記号の凡例</h4>
<?php $helpAppendixMode1 = 3; include($rootDir."visual/help_appendix.php"); ?>


<?php
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
	$dev["query2"] = $query2;
	include($rootDir."prog/dev.php");
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require($rootDir."prog/db_close.php");

?>