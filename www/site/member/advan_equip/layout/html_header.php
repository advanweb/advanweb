<?php
/*	****************************************************************
		<head>タグ内ヘッダー表示用
		<body>出現後、内容記述前に挿入
		
		$pageClass = bodyのクラス名
		$pageHeader = <header></header>に特記する内容
	****************************************************************/


// ヘッダーの表示
echo "<meta name=\"author\" content=\"XIAORING @ 2007 Advanced Creators Web Administrator &lt;http://mkgweb.undo.jp/&gt;\" />
<meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />
<meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\" />
<meta name=\"ROBOTS\" content=\"NOINDEX, NOFOLLOW\" />
<link rel=\"stylesheet\" href=\"".$rootDir."css/main_master.css\" type=\"text/css\" />
<link rel=\"shortcut icon\" href=\"".$rootDir."img/favicon.ico\" />
<link rev=\"made\" href=\"http://advancedcreators.undo.jp/\" />
<link rel=\"home\" href=\"".$rootDir."\" />
<link rel=\"contents\" href=\"./\" />
<link rel=\"author\" href=\"".$rootDir."about/\" />
<link rel=\"copyright\" href=\"".$rootDir."about/\" />
<link rel=\"help\" href=\"".$rootDir."help/\" />".$pageHeader."
</head>
";

?>