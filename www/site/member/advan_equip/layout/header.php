<?php
/*	****************************************************************
		ヘッダー表示用
		<body>出現後、内容記述前に挿入
		
		$pageClass = bodyのクラス名
		$pageHeader = <header></header>に特記する内容
	****************************************************************/


// onLoadFocusを読み込み
require($rootDir."prog/on_load_focus.php");

// headの読み込み
require_once($rootDir."layout/html_header.php");

// body以下の表示
echo "
<body class=\"".$pageClass."\"".$onLoadFocus.">

<div id=\"container\"><!-- 全体 -->

	<div id=\"header\"><!-- ヘッダー -->
		<h1><!-- サイトタイトル --><a href=\"".$rootDir."\">";
		
		// タイトル画像を表示
		include ($rootDir."visual/title_img.php");
		
		echo "</a></h1>
		<ul id=\"gNav\"><!-- グローバルナビゲーション -->
			<li><a href=\"".$rootDir."\" title=\"トップページに戻る\" accesskey=\"1\">トップ</a></li>
			<li><a href=\"".$rootDir."equip/\" title=\"機材データベースを見る\" accesskey=\"2\">機材リスト</a></li>
			<li><a href=\"".$rootDir."help/\" title=\"このサイトの使い方\" accesskey=\"3\">使い方</a></li>
			<li><a href=\"".$rootDir."about/\" title=\"このサイトについての説明\" accesskey=\"4\">このサイトについて</a></li>
			<li><a href=\"http://advancedcreators.undo.jp/site/member/\" title=\"Advanced Creators Members Siteに戻る\" accesskey=\"5\">Members Site</a></li>
		</ul>
		
		<hr class=\"hidden\" />
	<!-- header end --></div>
	
	
	<div id=\"mainCol\"><!-- メインの表示列 -->
		
		<div id=\"content\"><!-- content 内容 -->

";

?>