<?php
/*	****************************************************************
		サイド・フッター表示用（機材カテゴリーリスト）
		内容記述後に挿入
	****************************************************************/


// contentの終了の読み込み
require("content_end.php");

echo "
	
	
	<div id=\"subCol\"><!-- サイド表示列 -->
		
		<hr />
		
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
		</dl>
		
	<!-- subCol end --></div>";
	
// フッターの読み込み
require("footer.php");

?>