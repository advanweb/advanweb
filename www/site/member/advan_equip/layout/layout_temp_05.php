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
<title>Advanced Creators 機材管理サイト</title>
<?php
	
	// 変数の取得
	
	
	// ページのタイトル
	$pageTitle = "ページタイトル";
	$pageClass = "equip";
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
			<h2><?php echo "".$pageTitle; ?> <a href="#" title="リンクテスト">ページ</a>レイアウトテスト</h2>
			<h3>大見出し <a href="#" title="リンクテスト">Advanced Creators</a> 概要</h3>
			<p>段落 Advanced Creators は、学内学外を問わず、主に屋内・外のステージ等において音響・照明・イベント企画を行っている<a href="#" title="リンクテスト">東京工科大学</a>のサークルです。 主な活動内容は、学内では各音楽サークルのライブや演劇、東京工科大学大学祭でのステージ作成、学外では立川・八王子・武蔵村山近辺の野外イベント・ライブでの音響、舞台、照明のスタッフとしての活動等です。段落 Advanced Creators は、学内学外を問わず、主に屋内・外のステージ等において音響・照明・イベント企画を行っている<a href="#" title="リンクテスト">東京工科大学</a>のサークルです。 主な活動内容は、学内では各音楽サークルのライブや演劇、東京工科大学大学祭でのステージ作成、学外では立川・八王子・武蔵村山近辺の野外イベント・ライブでの音響、舞台、照明のスタッフとしての活動等です。段落 Advanced Creators は、学内学外を問わず、主に屋内・外のステージ等において音響・照明・イベント企画を行っている<a href="#" title="リンクテスト">東京工科大学</a>のサークルです。 主な活動内容は、学内では各音楽サークルのライブや演劇、東京工科大学大学祭でのステージ作成、学外では立川・八王子・武蔵村山近辺の野外イベント・ライブでの音響、舞台、照明のスタッフとしての活動等です。</p>
			<p>段落 Advanced Creators は、学内学外を問わず、主に屋内・外のステージ等において音響・照明・イベント企画を行っている<a href="#" title="リンクテスト">東京工科大学</a>のサークルです。 主な活動内容は、学内では各音楽サークルのライブや演劇、東京工科大学大学祭でのステージ作成、学外では立川・八王子・武蔵村山近辺の野外イベント・ライブでの音響、舞台、照明のスタッフとしての活動等です。</p>
			<h3>大見出し <a href="#" title="リンクテスト">イベント</a>の依頼をされる主催者様へ</h3>
			<p>段落 本サークルは、学外での活動に関して、あくまで「主催者様にサークル活動の場を提供して頂いている」というスタンスで活動しています。そのため、一般の  PA業者等の様にPA代金を頂くようなことはありません。ボランティアのようなものとして考えて頂ければ幸いです。但し、機材運搬費等、必要経費につきましてはご相談させて頂いております。</p>
			<h4>小見出し <a href="#" title="リンクテスト">イベント</a>の依頼をされる主催者様へ</h4>
			<p>段落 本サークルは、学外での活動に関して、あくまで<em>「主催者様に<a href="#" title="リンクテスト">サークル活動</a>の場を提供して頂いている」</em>というスタンスで活動しています。そのため、一般の  PA業者等の様にPA代金を頂くようなことはありません。ボランティアのようなものとして考えて頂ければ幸いです。<strong>但し、機材運搬費等、<a href="#" title="リンクテスト">必要経費</a>につきましてはご相談させて頂いております。</strong></p>
			<ul>
				<li>順不同リスト</li>
				<li>順不同リスト</li>
				<li>複数行の<br />
					順不同リスト</li>
				<li><a href="#" title="リンクテスト">順不同リスト</a>
					<ul>
						<li>順不同リスト</li>
						<li>順不同リスト</li>
						<li>順不同リスト
							<ul>
								<li>順不同リスト</li>
								<li>順不同リスト</li>
								<li>順不同リスト</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>順不同リスト</li>
			</ul>
			<p>段落 依頼がある方は、以下の方法でお寄せ下さい。</p>
			<dl>
				<dt>定義リスト</dt>
				<dd>内容</dd>
				<dt>定義リスト</dt>
				<dd>内容</dd>
				<dt>複数行の<br />
				定義リスト</dt>
				<dd>複数行の<br />
				内容</dd>
				<dt><a href="#" title="リンクテスト">定義リスト</a></dt>
				<dd><a href="#" title="リンクテスト">内容</a></dd>
				<dt>定義リスト</dt>
				<dd>内容</dd>
			</dl>
			<ol>
				<li>番号付きリスト</li>
				<li>番号付きリスト</li>
				<li>複数行の<br />
				番号付きリスト</li>
				<li><a href="#" title="リンクテスト">番号付きリスト</a>
					<ol>
						<li>番号付きリスト</li>
						<li>番号付きリスト</li>
						<li>番号付きリスト
							<ol>
								<li>番号付きリスト</li>
								<li>番号付きリスト</li>
								<li>番号付きリスト</li>
							</ol>
						</li>
					</ol>
				</li>
				<li>番号付きリスト</li>
				<li>番号付きリスト</li>
			</ol>
			<p>段落 ご依頼があった場合、お応えすることが可能かどうかについて主催者様との連絡及びサークル内での会議において検討いたします。お応えすることが可能である場合、主催者様と詳細を検討していく形になります。</p>
			<table summary="テーブルの要約">
				<tr>
					<th>ヘ</th>
					<th>ヘッダー</th>
					<th><a href="#" title="リンクテスト">ヘッダー</a></th>
				</tr>
				<tr>
					<td>名称</td>
					<td><a href="#" title="リンクテスト">Advanced Creators</a></td>
					<td>アドバンスト・クリエイターズ</td>
				</tr>
				<tr>
					<td>設立</td>
					<td>1987年</td>
					<td>昭和62年</td>
				</tr>
				<tr>
					<td>所在地</td>
					<td>&#x3012;192-0982<br />
					東京都八王子市片倉町1404-1</td>
					<td>東京工科大学<br />
					サ-316</td>
				</tr>
				<tr>
					<td>部室</td>
					<td>サークル棟 3F サ-316 </td>
					<td>サークル棟の階段を下りて真っ直ぐ奥から2番目</td>
				</tr>
				<tr>
					<td>顧問</td>
					<td>バイオニクス学部講師</td>
					<td>三田 俊裕</td>
				</tr>
				<tr>
					<td>連絡先</td>
					<td>E-Mail</td>
					<td>advancedcreators@hotmail.com</td>
				</tr>
			</table>
			<table summary="テーブルの要約">
				<tr>
					<th scope="row">名称</th>
					<td>Advanced Creators </td>
					<td>アドバンスト・クリエイターズ</td>
				</tr>
				<tr>
					<th scope="row">設立</th>
					<td>1987年</td>
					<td>昭和62年</td>
				</tr>
				<tr>
					<th scope="row">所在地</th>
					<td>&#x3012;192-0982<br />
					東京都八王子市片倉町1404-1</td>
					<td>東京工科大学<br />
					サ-316</td>
				</tr>
				<tr>
					<th scope="row">部室</th>
					<td>サークル棟 3F サ-316 </td>
					<td>サークル棟の階段を下りて真っ直ぐ奥から2番目</td>
				</tr>
				<tr>
					<th scope="row">顧問</th>
					<td>バイオニクス学部講師</td>
					<td>三田 俊裕</td>
				</tr>
				<tr>
					<th scope="row">連絡先</th>
					<td>E-Mail</td>
					<td>advancedcreators@hotmail.com</td>
				</tr>
			</table>
			<p>段落 大学のサークルという性格上、活動日程や時間等、制約がありますことをご了承ください。</p>
			<blockquote title="引用のtitle" cite="引用元">
				<p>引用 BBSは<a href="#" title="リンクテスト">ネチケット</a>を守って書き込んでください。書き込む際に個人情報などを載せないようご注意ください。誹謗・中傷など、悪意のある・不快になる書き込みや管理者が不適切だと判断したものは予告なく削除します。</p>
			</blockquote>
			<p><cite>引用元</cite></p>
			<p>活動していく上で、一般の<abbr title="Public Address">PA</abbr>業者等と比べ至らぬところも有るかと存じますが、もしお任せ頂ければ<kbd>Enter</kbd>精一杯頑張りますので<q>どうぞ宜しくお願いいたします</q>。</p>
			<pre title="整形済テキストのtitle">&lt;p&gt;段落 本サークルは、学外での活動に関して、あくまで&lt;em&gt;「主催者様に&lt;a href=&quot;#&quot; title=&quot;リンクテスト&quot;&gt;サークル活動&lt;/a&gt;の場を提供して頂いている」&lt;/em&gt;というスタンスで活動しています。そのため、一般の  PA業者等の様にPA代金を頂くようなことはありません。ボランティアのようなものとして考えて頂ければ幸いです。&lt;strong&gt;但し、機材運搬費等、&lt;a href=&quot;#&quot; title=&quot;リンクテスト&quot;&gt;必要経費&lt;/a&gt;につきましてはご相談させて頂いております。&lt;/strong&gt;&lt;/p&gt;
&lt;ul&gt; 
	&lt;li&gt;順不同リスト&lt;/li&gt;
	&lt;li&gt;順不同リスト&lt;/li&gt;
	&lt;li&gt;順不同リスト&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot; title=&quot;リンクテスト&quot;&gt;順不同リスト4&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;順不同リスト5&lt;/li&gt;
&lt;/ul&gt;
&lt;p&gt;段落 ご依頼があった場合、お応えすることが可能かどうかについて主催者様との連絡及びサークル内での会議において検討いたします。お応えすることが可能である場合、主催者様と詳細を検討していく形になります。&lt;/p&gt;</pre>
			<p>段落 機材に関しましては、<del datetime="2007.4.17 (Tue) 2:22:48">音響機材及び照明機材は当方が所有していますが、</del>ステージの規模や、<ins datetime="2007.4.17 (Tue) 2:22:48">出演者の編成、</ins>常設機材の有無等を考慮し、プランをご相談させていただきます。</p>
			<ins datetime="2007.4.17 (Tue) 2:22:48">
			<p>各楽器のアンプ、ドラムセット、キーボードスタンド等に関しましては、当方では用意しかねる為、<a href="#" title="リンクテスト">主催者</a>様側で用意していただく形になります。</p>
			</ins>
			<p>以下のフォームに記入してください。</p>
			<form action="#" method="post">
				<fieldset>
					<legend>ユーザー情報</legend>
					<dl>
						<dt>ユーザー名</dt>
						<dd><input type="text" id="username-id" name="username" size="20" /></dd>
						<dt>パスワード</dt>
						<dd><input type="password" id="password-id" name="password" size="20" /></dd>
					</dl>
				</fieldset>
				<h3>アドバンでの所属</h3>
				<dl>
					<dt>年度</dt>
					<dd><label for="year04-id"><input type="radio" id="year04-id" name="year" value="04" />04</label><label for="year05-id"><input type="radio" id="year05-id" name="year" value="05" checked="checked" />05</label><label for="year06-id"><input type="radio" id="year06-id" name="year" value="06" />06</label><label for="year07-id"><input type="radio" id="year07-id" name="year" value="07" />07</label></dd>
					<dt>部署</dt>
					<dd><label for="depart-mixer-id"><input type="checkbox" id="depart-mixer-id" name="department" value="mixer" checked="checked" />卓</label><label for="depart-stage-id"><input type="checkbox" id="depart-stage-id" name="department" value="stage" checked="checked" />舞台</label><label for="depart-lighting-id"><input type="checkbox" id="depart-lighting-id" name="department" value="lighting" />照明</label><label for="depart-planning-id"><input type="checkbox" id="depart-planning-id" name="department" value="planning" />企画</label></dd>
				</dl>
				<h4>出身と住所</h4>
				<dl>
					<dt>出身</dt>
					<dd>
						<select id="hometown-id" name="hometown" size="1">
							<optgroup label="東日本">
								<option value="北海道">北海道</option>
								<option value="東北">東北</option>
								<option value="関東" selected="selected">関東</option>
								<option value="中部">中部</option>
								<option value="東海">東海</option>
								<option value="北陸">北陸</option>
							</optgroup>
							<optgroup label="西日本">
								<option value="近畿">近畿</option>
								<option value="中国">中国</option>
								<option value="四国">四国</option>
								<option value="九州">九州</option>
								<option value="沖縄">沖縄</option>
							</optgroup>
						</select>
					</dd>
					<dt>住所</dt>
					<dd>
						<select id="address-id" name="address" size="8" multiple="multiple">
							<optgroup label="東京">
								<option value="八王子" selected="selected">八王子</option>
								<option value="立川">立川</option>
								<option value="国分寺">国分寺</option>
								<option value="吉祥寺">吉祥寺</option>
								<option value="荻窪">荻窪</option>
								<option value="町田">町田</option>
								<option value="23区">23区</option>
							</optgroup>
							<optgroup label="神奈川">
								<option value="橋本">橋本</option>
								<option value="相模原">相模原</option>
								<option value="横浜">横浜</option>
								<option value="川崎">川崎</option>
								<option value="厚木">厚木</option>
							</optgroup>
						</select>
					</dd>
				</dl>
				<dl>
					<dt>ファイル</dt>
					<dd><input type="file" id="file-id" name="file" size="20" /></dd>
					<dt>コメント</dt>
					<dd><textarea id="comment-id" name="comment" cols="40" rows="10"></textarea></dd>
				</dl>
				<dl class="submit">
					<dt>&nbsp;</dt>
					<dd><input type="hidden" id="hidden-id" name="hidden" value="hidden" />
						<input type="submit" id="submit-id" name="submit" value="送信" />
					</dd>
				</dl>
			</form>

			<!-- ここからcommon.css記述項目 -->			
			<p>依頼頂く場合はイベントの規模やスタッフの仕事内容<span class="aux">（例：音響のみ、など）</span>、大体で良いので出来る限り内容をご記入くださるようお願い致します。</p>
			<ul class="navBack">
				<li><a href="#" title="リンクテスト">戻る</a></li>
			</ul>
			<ul class="navAux">
				<li><a href="#" title="リンクテスト">補足ナビゲーション</a></li>
			</ul>
			<p>段落 大学の講義や、他のイベント等と日時が重複してしまう場合、機材や人員の関係でお応えできない場合があります。</p>
			<div class="photo">
				<img src="../img/title_02.png" alt="image" width="750" height="100" /></div>
			<div class="photo">
				<img src="../img/rss_01.png" alt="image" width="47" height="15" /></div>
			<dl class="list">
				<dt>定義語</dt>
				<dd>dlの横並びリストスタイル</dd>
				<dt>定義語</dt>
				<dd>dlの横並びリストスタイル</dd>
				<dt>dt</dt>
				<dd>ddが複数行のテスト<br />
				ddが複数行のテスト</dd>
				<dt>定義語が複数行のテスト</dt>
				<dd>dd</dd>
				<dt>定義語</dt>
				<dd>dlの横並びリストスタイル</dd>
			</dl>
			<dl class="listLong">
				<dt>定義語</dt>
				<dd>dlの横並びリストスタイル</dd>
				<dt>定義語</dt>
				<dd>dlの横並びリストスタイル</dd>
				<dt>dt</dt>
				<dd>ddが複数行のテスト<br />
				ddが複数行のテスト</dd>
				<dt>定義語が複数行のテスト定義語が複数行のテスト</dt>
				<dd>dd</dd>
				<dt>定義語</dt>
				<dd>dlの横並びリストスタイル</dd>
			</dl>
			
			<!-- ここからtheme.css記述項目 -->
			<div class="entry"> 
				<h3>部室への訪問</h3>
				<h4>投稿者名</h4>
				<p>部室(<a href="#" title="リンクテスト">東京工科大学</a> サークル棟サ-0316)に直接来てのご相談の場合、その場にいる部員が対応いたします。そのため十分な対応が出来ない場合もあります。細かい打ち合わせなどを部室で行いたい場合は、メールであらかじめ日時などを決めた上で訪問されることをお勧めします。 </p>
				<p>もしお越しになられたときに誰もいない場合は、連絡先を明記した手紙を置いていってくださっても結構です。</p>
				<div class="res">
					<p>部室(<a href="#" title="リンクテスト">東京工科大学</a> サークル棟サ-0316)に直接来てのご相談の場合、その場にいる部員が対応いたします。そのため十分な対応が出来ない場合もあります。細かい打ち合わせなどを部室で行いたい場合は、メールであらかじめ日時などを決めた上で訪問されることをお勧めします。 </p>
					<p>もしお越しになられたときに誰もいない場合は、連絡先を明記した手紙を置いていってくださっても結構です。</p>
				</div>
				<p class="date">2007.3.2 (Fri) 23:59 </p>
			</div>
			<p>段落 八王子クリエイトホールにて、劇団こねこめにすたんさんの音響、照明のオペを行います。</p>
			<div class="entry equip">
				<h3>機材カテゴリー</h3>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
			</div>
			<div class="entry event">
				<h3>イベントカテゴリー</h3>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
			</div>
			<div class="entry log">
				<h3>ログカテゴリー</h3>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
			</div>
			<div class="entry note">
				<h3>ノートカテゴリー</h3>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
			</div>
			<div class="entry web">
				<h3>サイトカテゴリー</h3>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
			</div>
			<div class="entry important">
				<h3>重要カテゴリー</h3>
				<div class="res">
					<h4>投稿者</h4>
					<p>内容</p>
					<p class="date">2007.3.2 (Fri) 23:59</p>
				</div>
			</div>
			<h2>機材リスト</h2>
			<ol class="topicPath">
				<li class="pa">音響</li><li>コンソール</li>
			</ol>
			<ol class="topicPath">
				<li class="lighting">照明</li><li>調光卓</li>
			</ol>
			<ol class="topicPath">
				<li class="cable">ケーブル</li><li>マイクケーブル</li>
			</ol>
			<ol class="topicPath">
				<li class="stand">スタンド</li><li>マイクスタンド</li>
			</ol>
			<ol class="topicPath">
				<li class="accessory">その他</li><li>音響その他</li>
			</ol>
			<ol class="topicPath">
				<li><a href="#">トップ</a></li><li><a href="#">ユーザー管理</a></li><li>ユーザー情報の変更</li>
			</ol>
			<table class="dbList">
				<tr>
					<th>メーカー</th>
					<th>機材名</th>
					<th>カテゴリー</th>
					<th>良好/総数</th>
					<th>Input (ch)</th>
				</tr>
				<tr>
					<td>BEHRINGER</td>
					<td><a href="#">UB1622FX-PRO</a></td>
					<td>コンソール</td>
					<td>1 / 1</td>
					<td>12</td>
				</tr>
				<tr>
					<td>MACKIE.</td>
					<td><a href="#">1642-VLZ PRO</a></td>
					<td>コンソール</td>
					<td>1 / 1 </td>
					<td>16</td>
				</tr>
				<tr>
					<td>YAMAHA</td>
					<td><a href="#">GA32/12</a></td>
					<td>コンソール</td>
					<td>1 / 1 </td>
					<td>32</td>
				</tr>
				<tr>
					<td>YAMAHA</td>
					<td><a href="#">MC1604II</a></td>
					<td>コンソール</td>
					<td>1 / 1 </td>
					<td>16</td>
				</tr>
				<tr>
					<td>YAMAHA</td>
					<td><a href="#">MG16/6FX</a></td>
					<td>コンソール</td>
					<td>1 / 1 </td>
					<td>16</td>
				</tr>
			</table>
			<h2>YAMAHA GA32/12</h2>
			<h3>機材詳細</h3>
			<ol class="topicPath">
				<li class="pa">音響</li>
				<li>コンソール</li>
			</ol>
			<dl class="list">
				<dt>Input (ch)</dt>
				<dd>32</dd>
				<dt>Bus (ch)</dt>
				<dd>0 ~ 4</dd>
				<dt>Aux (ch)</dt>
				<dd>6 ~ 10</dd>
				<dt>Effect</dt>
				<dd>-</dd>
				<dt>消費電力 (W)</dt>
				<dd>110.00</dd>
				<dt>重量 (kg)</dt>
				<dd>42.0</dd>
				<dt>備考</dt>
				<dd>GAダイバシティー搭載</dd>
			</dl>
			<h3>コンディション</h3>
			<dl class="condition">
				<dt class="cond1">良好</dt>
				<dd class="cond1">6</dd>
				<dt class="cond2">微妙</dt>
				<dd class="cond2">5</dd>
				<dt class="cond3">不調</dt>
				<dd class="cond3">4</dd>
				<dt class="cond4">故障</dt>
				<dd class="cond4">3</dd>
				<dt class="cond5">修理</dt>
				<dd class="cond5">2</dd>
				<dt class="cond6">不明</dt>
				<dd class="cond6">1</dd>
				<dt class="cond0">総数</dt>
				<dd class="cond0">21</dd>
				<dt class="condNote">備考</dt>
				<dd class="condNote">1つInput端子にガリあり。</dd>
			</dl>
			<p class="error">[エラー] パスワードが違います!</p>
			<p>[戻る]をクリックして、パスワードを再入力してください。</p>
			<form action="#" method="post">
				<div class="submit">
					<input type="hidden" id="hidden2-id" name="hidden2" value="hidden2" />
					<input type="submit" id="return-id" name="return" value="戻る" />
				</div>
			</form>
<?php
	
	
/* ------------------------------------------------------------
	content end
------------------------------------------------------------ */	


	// サイド・フッターの読み込み
	require_once($rootDir."layout/footer_equip.php");
	
	// データベース接続解除
	require_once($rootDir."prog/db_close.php");

?>