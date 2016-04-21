#┌─────────────────────────────────
#│  JOYFUL NOTE v2.69 (2006/10/22)
#│  Copyright (c) KentWeb
#│  webmaster@kent-web.com
#│  http://www.kent-web.com/
#└─────────────────────────────────
$ver = 'JoyfulNote v2.69';
#┌─────────────────────────────────
#│ [注意事項]
#│ 1. このスクリプトはフリーソフトです。このスクリプトを使用した
#│    いかなる損害に対して作者は一切の責任を負いません。
#│ 2. 設置に関する質問はサポート掲示板にお願いいたします。
#│    直接メールによる質問は一切お受けいたしておりません。
#│ 3. このスクリプトは、method=POST 専用です。	
#│ 4. 同梱のアイコンで、以下のファイルの著作権者は以下のとおりです。
#│    home.gif : mayuRinさん
#│    clip.gif : 牛飼いとアイコンの部屋さん
#└─────────────────────────────────
#
# 【ファイル構成例】
#
#  public_html (ホームディレクトリ)
#      |
#      +-- joyful / joyful.cgi    [705]
#            |      admin.cgi     [705]
#            |      regist.cgi    [705]
#            |      registkey.cgi [705]
#            |      init.cgi      [705]
#            |
#            +-- lib / jcode.pl
#            |         cgi-lib.pl
#            |         registkey.pl
#            |
#            +-- data / joylog.cgi [606]
#            |          count.dat  [606]
#            |          pastno.dat [606]
#            |
#            +-- past [707] / 0001.cgi [606] ...
#            |
#            +-- img  [707] /

#-------------------------------------------------
#  設定項目
#-------------------------------------------------

# ライブラリ
$jcode    = './lib/jcode.pl';
$cgi_lib  = './lib/cgi-lib.pl';
$regkeypl = './lib/registkey.pl';

# タイトル名
$title = "雑談掲示板";

# タイトルの文字色
$t_color = "#ffffff";

# タイトルの文字サイズ
$t_size = '26px';

# 本文の文字フォント
$face = '"MS UI Gothic", "ＭＳ Ｐゴシック", Osaka';

# 本文の文字サイズ
$b_size = '13px';

# 壁紙を指定する場合（http://から指定）
$bg = "";

# 背景色を指定
$bc = "#000000";

# 文字色を指定
$tx = "#ffffff";

# リンク色を指定
$lk = "#bbbbbb";	# 未訪問
$vl = "#777777";	# 訪問済
$al = "#777777";	# 訪問中

# 戻り先のURL (index.htmlなど)【URLパス】
$homepage = "../";

# 最大記事数 (親記事+レス記事も含めた数）
$max = 100;

# 管理者用マスタパスワード (英数字で８文字以内)
$pass = 'mg16/6fx';

# 返信がつくと親記事をトップへ移動 (0=no 1=yes)
$topsort = 0;

# 返信にも添付機能を許可する (0=no 1=yes)
$res_clip = 1;

# 画像と記事の位置
#  1 : 画像が左。記事は右から回り込む
#  2 : 画像が下。記事は画像の上に表示。
$imgpoint = 2;

# タイトルにGIF画像を使用する時 (http://から記述)
$t_img = "";
$t_w = 180;	# GIF画像の幅 (ピクセル)
$t_h = 40;	#    〃    高さ (ピクセル)

# ミニカウンタの設置
# → 0=no 1=テキスト 2=GIF画像
$counter = 1;

# ミニカウンタの桁数
$mini_fig = 6;

# テキストのとき：ミニカウンタの色
$cnt_color = "#ffffff";

# GIFカウンタのとき：画像までのディレクトリ
# → 最後は / で閉じない
$gif_path = "./img";
$mini_w = 8;		# 画像の横サイズ
$mini_h = 12;		# 画像の縦サイズ

# カウンタファイル
$cntfile = './data/count.dat';

# 本体CGIのURL【URLパス】
$bbscgi = './joyful.cgi';

# 書込CGIのURL【URLパス】
$registcgi = './regist.cgi';

# 管理CGIのURL【URLパス】
$admincgi = './admin.cgi';

# ログファイル【サーバパス】
$logfile = './data/joylog.cgi';

# アップロードディレクトリ【サーバパス】
# → パスの最後に / をつけない
$imgdir = './img';

# アップロードディレクトリ【URLパス】
# → パスの最後に / をつけない
$imgurl = "./img";

# 添付ファイルのアップロードに失敗したとき
# 0 : 添付ファイルは無視し、記事は受理する
# 1 : エラー表示して処理を中断する
$clip_err = 1;

# 記事 [タイトル] 部の長さ (全角文字換算)
$sub_len = 15;

# メールアドレスの入力必須 (0=no 1=yes)
$in_email = 0;

# 記事の [タイトル] 部の色
$subcol = "#ffffff";

# 記事表示部の下地の色
$tbl_color = "#555555";

# 同一IPアドレスからの連続投稿時間（秒数）
# → 連続投稿などの荒らし対策
# → 値を 0 にするとこの機能は無効になります
$wait = 10;

# １ページ当たりの記事表示数 (親記事)
$pglog = 8;

# 投稿があるとメール通知する (sendmail必須)
#  0 : 通知しない
#  1 : 通知するが、自分の投稿記事はメールしない。
#  2 : 通知する。自分の投稿記事も通知する。
$mailing = 0;

# メールアドレス(メール通知する時)
$mailto = 'xxx@xxx.xxx';

# sendmailパス（メール通知する時）
$sendmail = '/usr/lib/sendmail';

# 他サイトから投稿排除時に指定 (http://から書く)
$base_url = "";

# 文字色の設定（半角スペースで区切る）
$colors = '#FF66CC #99CCFF #99FFCC #FFFF99 #FF9966 #FFFFFF #CCCCFF #FF9999 #CCFF99';

# URLの自動リンク (0=no 1=yes)
$autolink = 1;

# タグ広告挿入オプション
# → <!-- 上部 --> <!-- 下部 --> の代わりに「広告タグ」を挿入する。
# → 広告タグ以外に、MIDIタグ や LimeCounter等のタグにも使用可能です。
$banner1 = '<!-- 上部 -->';	# 掲示板上部に挿入
$banner2 = '<!-- 下部 -->';	# 掲示板下部に挿入

# ホスト取得方法
# 0 : gethostbyaddr関数を使わない
# 1 : gethostbyaddr関数を使う
$gethostbyaddr = 0;

# アクセス制限（半角スペースで区切る、アスタリスク可）
#  → 拒否ホスト名を記述（後方一致）【例】*.anonymizer.com
$deny_host = '';
#  → 拒否IPアドレスを記述（前方一致）【例】210.12.345.*
$deny_addr = '';

# 禁止ワード
# → 投稿時禁止するワードをコンマで区切る
$no_wd = '';

# 日本語チェック（投稿時日本語が含まれていなければ拒否する）
# 0=No  1=Yes
$jp_wd = 0;

# URL個数チェック
# → 投稿コメント中に含まれるURL個数の最大値
$urlnum = 3;

# アップロードを許可するファイル形式
#  0:no  1:yes
$gif   = 1;	# GIFファイル
$jpeg  = 1;	# JPEGファイル
$png   = 1;	# PNGファイル
$text  = 1;	# TEXTファイル
$lha   = 0;	# LHAファイル
$zip   = 1;	# ZIPファイル
$pdf   = 1;	# PDFファイル
$midi  = 1;	# MIDIファイル
$word  = 1;	# WORDファイル
$excel = 1;	# EXCELファイル
$ppt   = 1;	# POWERPOINTファイル
$ram   = 0;	# RAMファイル
$rm    = 0;	# RMファイル
$mpeg  = 0;	# MPEGファイル
$mp3   = 0;	# MP3ファイル

# 投稿受理最大サイズ (bytes)
# → 例 : 102400 = 100KB
$maxdata = 2048000;

# 画像ファイルの最大表示の大きさ（単位：ピクセル）
# → これを超える画像は縮小表示します
$MaxW = 300;	# 横幅
$MaxH = 150;	# 縦幅

# アイコン画像ファイル名 (ファイル名のみ)
$IconClip = "clip.gif";  # クリップ
$IconSoon = "soon.gif";  # COMINIG SOON
$IconSoon_w = 88;
$IconSoon_h = 31;

# 家アイコンタグ
# → テキスト文字でも可
$img_home = "<img src=\"$imgurl/home.gif\" border=\"0\" alt=\"ホームページ\" align=\"top\">";

# 画像管理者チェック機能 (0=no 1=yes)
# → アップロード「画像」は管理者がチェックしないと表示されない機能です
# → チェックされるまで「画像」は「COMING SOON」のアイコンが表示されます
$ImageCheck = 0;

# 投稿後の処理
#  → 掲示板自身のURLを記述しておくと、投稿後リロードします
#  → ブラウザを再読み込みしても二重投稿されない措置。
#  → Locationヘッダの使用可能なサーバのみ
$location = '';

## --- <以下は「投稿キー」機能（スパム対策）を使用する場合の設定です> --- ##
#
# 投稿キーの使用（スパム対策）
# → 0=no 1=yes
$regist_key = 0;

# 投稿キー画像生成ファイル【URLパス】
$registkeycgi = './registkey.cgi';

# 投稿キー暗号用パスワード（英数字で８文字）
$pcp_passwd = 'password';

# 投稿キー許容時間（分単位）
#   投稿フォームを表示させてから、実際に送信ボタンが押される
#   までの可能時間を分単位で指定
$pcp_time = 30;

# 投稿キー画像の大きさ（10ポ or 12ポ）
# 10pt → 10
# 12pt → 12
$regkey_pt = 10;

# 投稿キー画像の文字色
# → $txと合わせると違和感がない。目立たせる場合は #dd0000 など。
$moji_col = '#dd0000';

# 投稿キー画像の背景色
# → $bcと合わせると違和感がない
$back_col = '#FEF5DA';

## --- <以下は「過去ログ」機能を使用する場合の設定です> --- ##
#
# 過去ログ生成
# → 0=no 1=yes
$pastkey = 0;

# 過去ログ用NOファイル【サーバパス】
$nofile  = './data/pastno.dat';

# 過去ログのディレクトリ【サーバパス】
# → パスの最後に / をつけない
$pastdir = './past';

# 過去ログ１ファイルの行数
# → この行数を超えると次ページを自動生成します
$pastmax = 600;

#-------------------------------------------------
#  設定完了
#-------------------------------------------------

#-------------------------------------------------
#  アクセス制限
#-------------------------------------------------
sub axscheck {
	# IP&ホスト取得
	$host = $ENV{'REMOTE_HOST'};
	$addr = $ENV{'REMOTE_ADDR'};

	if ($gethostbyaddr && ($host eq "" || $host eq $addr)) {
		$host = gethostbyaddr(pack("C4", split(/\./, $addr)), 2);
	}

	# IPチェック
	local($flg);
	foreach ( split(/\s+/, $deny_addr) ) {
		s/\./\\\./g;
		s/\*/\.\*/g;

		if ($addr =~ /^$_/i) { $flg = 1; last; }
	}
	if ($flg) {
		&error("アクセスを許可されていません");

	# ホストチェック
	} elsif ($host) {

		foreach ( split(/\s+/, $deny_host) ) {
			s/\./\\\./g;
			s/\*/\.\*/g;

			if ($host =~ /$_$/i) { $flg = 1; last; }
		}
		if ($flg) {
			&error("アクセスを許可されていません");
		}
	}
	if ($host eq "") { $host = $addr; }
}

#-------------------------------------------------
#  フォームデコード
#-------------------------------------------------
sub parse_form {
	undef(%in);
	&ReadParse;
	while ( local($key, $val) = each(%in) ) {

		next if ($key eq "upfile");

		# シフトJISコード変換
		&jcode'convert(*val, "sjis", "", "z");

		# タグ処理
		$val =~ s/&/&amp;/g;
		$val =~ s/"/&quot;/g;
		$val =~ s/</&lt;/g;
		$val =~ s/>/&gt;/g;

		# 改行処理
		$val =~ s/\r\n/<br>/g;
		$val =~ s/\r/<br>/g;
		$val =~ s/\n/<br>/g;

		$in{$key} = $val;
	}
	$mode = $in{'mode'};
}

#-------------------------------------------------
#  エラー処理
#-------------------------------------------------
sub error {
	&header if (!$headflag);
	print <<EOM;
<div align="center">
<hr width="400">
<h3>ERROR !</h3>
<font color="red">$_[0]</font>
<p>
<hr width="400">
</div>
EOM
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  HTMLヘッダー
#-------------------------------------------------
sub header {
	$headflag=1;
	print "Content-type: text/html\n\n";
	print <<"EOM";
<html>
<head>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=Shift_JIS">
<style type="text/css">
<!--
body,td,th { font-size:$b_size; font-family:$face }
a:hover { color: $al }
-->
</style>
<title>$title</title>
</head>
EOM

	if ($bg) {
		print "<body background=\"$bg\" bgcolor=\"$bc\" text=\"$tx\" link=\"$lk\" vlink=\"$vl\" alink=\"$al\">\n";
	} else {
		print "<body bgcolor=\"$bc\" text=\"$tx\" link=\"$lk\" vlink=\"$vl\" alink=\"$al\">\n";
	}
}

#-------------------------------------------------
#  クッキー発行
#-------------------------------------------------
sub set_cookie {
	local(@cook) = @_;
	local($gmt, $cook, @t, @m, @w);

	@t = gmtime(time + 60*24*60*60);
	@m = ('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	@w = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

	# 国際標準時を定義
	$gmt = sprintf("%s, %02d-%s-%04d %02d:%02d:%02d GMT",
			$w[$t[6]], $t[3], $m[$t[4]], $t[5]+1900, $t[2], $t[1], $t[0]);

	# 保存データをURLエンコード
	foreach (@cook) {
		s/(\W)/sprintf("%%%02X", unpack("C", $1))/eg;
		$cook .= "$_<>";
	}

	# 格納
	print "Set-Cookie: JoyfulNote=$cook; expires=$gmt\n";
}

#-------------------------------------------------
#  クッキー取得
#-------------------------------------------------
sub get_cookie {
	local($key, $val, *cook);

	# クッキーを取得
	$cook = $ENV{'HTTP_COOKIE'};

	# 該当IDを取り出す
	foreach ( split(/;/, $cook) ) {
		($key, $val) = split(/=/);
		$key =~ s/\s//g;
		$cook{$key} = $val;
	}

	# データをURLデコードして復元
	foreach ( split(/<>/, $cook{'JoyfulNote'}) ) {
		s/%([0-9A-Fa-f][0-9A-Fa-f])/pack("C", hex($1))/eg;

		push(@cook,$_);
	}
	return @cook;
}

#-------------------------------------------------
#  投稿フォーム
#-------------------------------------------------
sub bbs_form {
	local($type, $resmd) = @_;
	local($cnam,$ceml,$curl,$cpwd,$cico,$ccol);

	print <<EOM;
<blockquote>
<form action="$registcgi" method="post" enctype="multipart/form-data">
EOM

	## フォーム種別を判別
	# 修正
	if ($type eq "edit" || $type eq "admin") {

		if ($type eq "edit") {
			print "<input type=\"hidden\" name=\"pwd\" value=\"$in{'pwd'}\">\n";
			print "<input type=\"hidden\" name=\"mode\" value=\"user_edit\">\n";
			print "<input type=\"hidden\" name=\"job\" value=\"edit\">\n";
		} else {
			print "<input type=\"hidden\" name=\"mode\" value=\"admin\">\n";
			print "<input type=\"hidden\" name=\"pass\" value=\"$in{'pass'}\">\n";
			print "<input type=\"hidden\" name=\"job\" value=\"edit2\">\n";
		}

		print "<input type=\"hidden\" name=\"no\" value=\"$in{'no'}\">\n";

		$cnam = $name;
		$ceml = $eml;
		$curl = $url;
		$ccol = $col;
	# 返信
	} elsif ($resmd) {
		print "<input type=\"hidden\" name=\"mode\" value=\"regist\">\n";
		print "<input type=\"hidden\" name=\"reno\" value=\"$resfm\">\n";

		($cnam,$ceml,$curl,$cpwd,$cico,$ccol) = &get_cookie;
	# 新規
	} else {
		print "<input type=\"hidden\" name=\"mode\" value=\"regist\">\n";

		($cnam,$ceml,$curl,$cpwd,$cico,$ccol) = &get_cookie;
	}
	if (!$curl) { $curl = 'http://'; }

	print <<EOM;
<table border="0" cellspacing="0">
<tr>
  <td nowrap><b>おなまえ</b></td>
  <td><input type="text" name="name" size="28" value="$cnam"></td>
</tr>
<tr>
  <td nowrap><b>Ｅメール</b></td>
  <td><input type="text" name="email" size="28" value="$ceml"></td>
</tr>
<tr>
  <td nowrap><b>タイトル</b></td>
  <td nowrap>
    <input type="text" name="sub" size="36" value="$sub">
<input type="submit" value="投稿する"><input type="reset" value="リセット">
  </td>
</tr>
<tr>
  <td colspan="2">
    <b>コメント</b><br>
    <textarea cols="56" rows="7" name="comment">$com</textarea>
  </td>
</tr>
<tr>
  <td nowrap><b>参照URL</b></td>
  <td><input type="text" size="50" name="url" value="$curl"></td>
</tr>
EOM

	# 添付フォーム
	unless ($resmd && !$res_clip) {
		print "<tr><td><b>添付File</b></td>\n";
		print "<td><input type=\"file\" name=\"upfile\" size=\"40\">\n";

		# 添付
		if ($ext) {
			print "&nbsp;[<a href=\"$imgurl/$in{'no'}$ext\" target=\"_blank\">添付</a>]\n";
			print "<input type=\"checkbox\" name=\"imgdel\" value=\"1\">削除\n";
		}

		print "</td></tr>\n";
	}
	# パスワード欄
	if ($type ne "edit" && $type ne "admin") {
		print "<tr><td nowrap><b>暗証キー</b></td>";
		print "<td><input type=\"password\" name=\"pwd\" size=\"8\" maxlength=\"8\" value=\"$cpwd\">\n";
		print "(英数字で8文字以内)</td></tr>\n";
	}
	# 投稿キー
	if ($regist_key && ($type eq "normal" || $type eq "res")) {
		print "<tr><td nowrap><b>投稿キー</b></td>";
		print "<td><input type=\"text\" name=\"regikey\" size=\"6\" style=\"ime-mode:inactive\" value=\"\">\n";
		print "（投稿時 <img src=\"$registkeycgi?$str_crypt\" align=\"absmiddle\" alt=\"投稿キー\"> を入力してください）</td></tr>\n";
		print "<input type=\"hidden\" name=\"str_crypt\" value=\"$str_crypt\">\n";
	}

	# 色指定
	print "<tr><td nowrap><b>文字色</b></td><td>\n";
	@col = split(/\s+/, $colors);
	if ($ccol eq "") { $ccol = $col[0]; }
	foreach (@col) {
		if ($ccol eq $_) {
			print "<input type=\"radio\" name=\"color\" value=\"$_\" checked><font color=\"$_\">■</font>\n";
		} else {
			print "<input type=\"radio\" name=\"color\" value=\"$_\"><font color=\"$_\">■</font>\n";
		}
	}
	print "</td></tr></table></form>\n";
	if ($ImageCheck) {
		print "・画像は管理者が許可するまで「COMING SOON」のアイコンが表\示されます。<br>\n";
	}
	print "</blockquote>\n";
}




1;

