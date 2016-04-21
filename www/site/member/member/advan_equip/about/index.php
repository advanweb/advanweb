<?php
/*	****************************************************************
		このサイトについて
	****************************************************************/


	// セッション開始
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>このサイトについて | Advanced Creators 機材管理サイト</title>
<?php

	// デフォルト
	$showFlag1 = true;
	
	// 変数の取得
	

	// ページのタイトル
	$pageTitle = "このサイトについて";
	$pageClass = "about";
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
<p>このサイトは、東京工科大学 Advanced Creatorsが所有する機材の情報を管理するサイトです。</p>
<p>サーバサイド・スクリプト言語としてPHP、リレーショナルデータベースとしてMySQLを使用して開発されており、ユーザーはブラウザからの簡単な作業で機材リストの閲覧や更新ができます。</p>
<p>このサイトを利用することにより、<span class="aux">(インターネットに接続できる環境なら)</span> どこでもアドバンの機材の状況が分かります。</p>
<h3>推奨環境</h3>
<p>このサイトは以下の環境を主なターゲットに開発されました。</p>
<table summary="このサイトを閲覧するにあたって最適な環境を提案しています。">
	<tr>
		<th scope="row">ブラウザ</th>
		<td>Windows版 Firefox 2.0 以上<br />
			または Windows版 Opera 9.0 以上<br />
			または Windows版 Internet Explorer 7.0 以上</td>
	</tr>
	<tr>
		<th scope="row">画面解像度</th>
		<td>1024px * 768px 以上</td>
	</tr>
	<tr>
		<th scope="row">フォント</th>
		<td>メイリオ<br />
			または ＭＳ Ｐゴシック </td>
	</tr>
	<tr>
		<th scope="row">文字サイズ</th>
		<td>16 (Firefox, Operaの場合)<br />
			または 中 (Internet Explorerの場合) </td>
	</tr>
	<tr>
		<th scope="row">文字コード</th>
		<td>UTF-8</td>
	</tr>
	<tr>
		<th scope="row">言語</th>
		<td>日本語 (ja-jp) </td>
	</tr>
</table>
<p>この情報は、ブラウザ、その他ユーザーエージェントの動作や閲覧状況を保証するものではありません。</p>
<h3>制作者と著作権</h3>
<p>このサイトは、2007年度Advaneced Creators Web担当の05小林 <span class="aux">(XIAORING)</span> によって制作されました。</p>
<p>2006年度メディア2年後期「メディア基礎演習・Webサーバの基礎」で制作した課題をベースに作られ、2007年12月20日にリリースされました。</p>
<p>著作権者は、Advanced CreatorsとXIAORING <span class="aux">(制作者: 05小林)</span> の共著となっています。</p>
<p>なお、データベースに格納されている各機材のデータについては著作権保護の対象外です。</p>
<h3>サポート</h3>
<p>手作り感たっぷりなサイトであるが故に、さまざまなバグやトラブルが発生すると思われます。</p>
<p>このサイトのサポートに関しては、制作者の在学中に限り、制作者が受け持ちます。</p>
<p>直接話す、メールする、メッセで話しかける、<a href="http://advancedcreators.undo.jp/site/member/musicfes/joyful.cgi">雑談BBS</a>に書き込む&hellip;&hellip;といった方法でコンタクトを取ってください。</p>
<h3 id="disclaimer">免責事項</h3>
<p><em>当サイトの利用によって生じたいかなる不利益に対しても、当サイトおよび管理人は一切の責任を負うことはできません。</em></p>
<p>当サイト上の掲載内容については、管理人の能力の範囲でできるだけ正確・適切であるように努力していますが、その内容について完全に正確性・正当性・信頼性を保障することはできません。<br />
	内容に不備があった場合でも、それに起因するいかなる不利益に対しても、当サイトおよび管理人は一切の責任を負うことはできません。</p>
<p>Webサイトの性質上、掲載内容は予告無く変更したり削除したりすることがあります。<br />
	また過去のコンテンツには、現在では正しくない情報が含まれていたり、制作当時と現在では作者の意思や状況が変化していることがあります。</p>
<p>当サイトから外部サイトへのリンクが貼られている箇所がありますが、リンク先の内容については一切保障することはできません。<br />
	リンク先の内容が正確性・正当性・信頼性に欠けるものであったり、そもそもリンクが切れていたりする可能性があります。</p>
<h3>リンク</h3>
<ul>
	<li><a href="http://advancedcreators.undo.jp/">Advanced Creators 公式サイト</a></li>
	<li><a href="http://advancedcreators.undo.jp/site/member/">Advanced Creators Members Site</a></li>
	<li><a href="http://mkgweb.undo.jp/">制作者の個人サイト</a></li>
</ul>


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