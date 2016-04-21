#!/usr/bin/perl

#┌─────────────────────────────────
#│ JOYFUL NOTE
#│ joyful.cgi - 2006/10/04
#│ Copyright (c) KentWeb
#│ webmaster@kent-web.com
#└─────────────────────────────────

# 外部ファイル取り込み
require './init.cgi';
require $jcode;
require $cgi_lib;

# 処理を定義
&parse_form;
&axscheck;
if ($mode eq "howto") { &howto; }
elsif ($mode eq "find") { &find; }
elsif ($mode eq "past" && $pastkey) { &past_log; }
elsif ($mode eq "check") { &check; }
&bbs_log;

#-------------------------------------------------
#  記事表示部
#-------------------------------------------------
sub bbs_log {
	# ページ繰越
	local($page) = 0;
	local($resfm);
	foreach ( keys(%in) ) {
		if (/^page(\d+)$/) {
			$page = $1;
		}
		if (/^res(\d+)$/) {
			$resfm = $1;
			last;
		}
	}
	# 返信フォーム押下
	if ($resfm) { &res_form; }

	# ヘッダを出力
	&header;

	# カウンタ処理
	if ($counter) { &counter; }

	# 投稿キー
	local($str_plain,$str_crypt);
	if ($regist_key) {
		require $regkeypl;

		($str_plain,$str_crypt) = &pcp_makekey;
	}

	# タイトル部
	print "<div align=\"center\">\n";
	if ($banner1 ne "<!-- 上部 -->") { print "$banner1<p>\n"; }
	if ($t_img) {
		print "<img src=\"$t_img\" width=\"$t_w\" height=\"$t_h\" alt=\"$title\">\n";
	} else {
		print "<b style=\"font-size:$t_size;color:$t_color;\">$title</b>\n";
	}

	# メニュー部
	print "<hr width=\"90%\">\n";
	print "[<a href=\"$homepage\" target=\"_top\">トップに戻る</a>]\n";
	print "[<a href=\"$bbscgi?mode=howto\">留意事項</a>]\n";
	print "[<a href=\"$bbscgi?mode=find\">ワード検索</a>]\n";
	print "[<a href=\"$bbscgi?mode=past\">過去ログ</a>]\n" if ($pastkey);
	print "[<a href=\"$admincgi\">管理用</a>]\n";
	print "<hr width=\"90%\"></div>\n";

	# 投稿フォーム
	&bbs_form("normal");

	print <<EOM;
<div align="center">
<form action="$bbscgi">
<input type="hidden" name="page" value="$page">
EOM

	# 記事展開
	local($i,$top,@view,%res,%nam,$eml,%sub,%dat,%com,%col,%url,%ext,%imw,%imh);
	open(IN,"$logfile") || &error("Open Error: $logfile");
	$top = <IN>;
	while (<IN>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		++$i if (!$reno);
		next if ($i < $page + 1);
		next if ($i > $page + $pglog);

		# 親記事
		if (!$reno) {
			push(@view,$no);
		# レス記事
		} else {
			$res{$reno} .= "$no,";
		}

		# 題名の長さ
		if (length($sub) > $sub_len*2) {
			$sub = substr($sub,0,$sub_len*2) . "...";
		}
		# e-mailリンク
		if ($eml) { $name = "<a href=\"mailto:$eml\">$name</a>"; }
		# URLリンク
		if ($autolink) { &auto_link($com); }

		$nam{$no} = $name;
		$eml{$no} = $eml;
		$sub{$no} = $sub;
		$dat{$no} = $date;
		$com{$no} = $com;
		$col{$no} = $col;
		$url{$no} = $url;

		if ($ext) {
			if ($ImageCheck && $chk eq '0') {
				$ext{$no} = $IconSoon;
				$imw{$no} = $IconSoon_w;
				$imh{$no} = $IconSoon_h;
			} else {
				$ext{$no} = "$no$ext";
				$imw{$no} = $w;
				$imh{$no} = $h;
			}
		}
	}
	close(IN);

	# 表示
	foreach (@view) {
		# 親記事
		print "<p><table width=\"90%\" cellpadding=\"5\" cellspacing=\"1\" border=\"1\">\n";
		print "<tr><td bgcolor=\"$tbl_color\">\n";
		print "<b style=\"color:$subcol\">$sub{$_}</b> ";
		print "投稿者：<b>$nam{$_}</b> 投稿日：$dat{$_} ";
		print "<span style=\"color:$subcol\">No.$_</span> ";
		if ($url{$_}) {
			print "<a href=\"$url{$_}\" target=\"_blank\">$img_home</a> ";
		}
		print "&nbsp;&nbsp;<input type=\"submit\" name=\"res$_\" value=\"返信\"><br>\n";
		print "<div style=\"margin-left:22px; margin-top:6px\">";

		# 画像
		if ($ext{$_} =~ /\.(jpg|gif|png)$/) {

			# 画像-左
			if ($imgpoint == 1) {
				print "<a href=\"$imgurl/$ext{$_}\" target=\"_blank\">";
				print "<img src=\"$imgurl/$ext{$_}\" width=\"$imw{$_}\" height=\"$imh{$_}\" align=\"left\" hspace=\"5\" alt=\"\" border=\"0\"></a>";
				print "<span style=\"color:$col{$_}\">$com{$_}</span><br clear=\"all\">\n";

			# 画像-下
			} elsif ($imgpoint == 2) {
				print "<span style=\"color:$col{$_}\">$com{$_}</span><br>";
				print "<a href=\"$imgurl/$ext{$_}\" target=\"_blank\">";
				print "<img src=\"$imgurl/$ext{$_}\" width=\"$imw{$_}\" height=\"$imh{$_}\" alt=\"\" border=\"0\"></a>\n";
			}

		# 画像以外
		} elsif ($ext{$_}) {
			# サイズ
			local($size) = -s "$imgdir/$ext{$_}";
			$size = int ( $size / 1024 + 0.5 ) . 'KB';

			print "<span style=\"color:$col{$_}\">$com{$_}</span><br><br>";
			print "添付：<a href=\"$imgurl/$ext{$_}\" target=\"_blank\">$ext{$_}</a>\n";
			print "($size)\n";

		# 添付なし
		} else {
			print "<span style=\"color:$col{$_}\">$com{$_}</span>";
		}
		print "</div>\n";

		# レス記事
		if (defined($res{$_})) {
			print "<div style=\"margin-left:22px; margin-top:5px;\"><hr size=\"1\">\n";

			foreach $res ( split(/,/, $res{$_}) ) {

				print "<b style=\"color:$subcol\">$sub{$res}</b> - <b>$nam{$res}</b> ";
				print "$dat{$res} <span style=\"color:$subcol\">No.$res</span> ";
				if ($url{$res}) {
					print "<a href=\"$url{$res}\" target=\"_blank\">$img_home</a>";
				}
				print "<br>";

				# 画像
				if ($ext{$res} =~ /\.(jpg|gif|png)$/) {

					# 画像-左
					if ($imgpoint == 1) {
						print "<a href=\"$imgurl/$ext{$res}\" target=\"_blank\">";
						print "<img src=\"$imgurl/$ext{$res}\" width=\"$imw{$res}\" height=\"$imh{$res}\" align=\"left\" hspace=\"5\" alt=\"\" border=\"0\"></a>";
						print "<span style=\"color:$col{$res}\">$com{$res}</span><br clear=\"all\">\n";

					# 画像-下
					} elsif ($imgpoint == 2) {
						print "<span style=\"color:$col{$res}\">$com{$res}</span><br>";
						print "<a href=\"$imgurl/$ext{$res}\" target=\"_blank\">";
						print "<img src=\"$imgurl/$ext{$res}\" width=\"$imw{$res}\" height=\"$imh{$res}\" alt=\"\" border=\"0\"></a>\n";
					}

				# 画像以外
				} elsif ($ext{$res}) {
					# サイズ
					local($size) = -s "$imgdir/$ext{$res}";
					$size = int ( $size / 1024 + 0.5 ) . 'KB';

					print "<span style=\"color:$col{$res}\">$com{$res}</span><br><br>";
					print "添付：<a href=\"$imgurl/$ext{$res}\" target=\"_blank\">$ext{$res}</a>\n";
					print "($size)\n";

				# 添付なし
				} else {
					print "<span style=\"color:$col{$res}\">$com{$res}</span>";
				}

				print "<br><br>";
			}
			print "</div>\n";
		}

		print "</td></tr></table></p>\n";
	}

	# 繰越ページ
	local($next) = $page + $pglog;
	local($back) = $page - $pglog;

	# 繰越ボタン表示
	local($pg_btn);
	if ($back >= 0) {
		$pg_btn .= "<input type=\"submit\" name=\"page$back\" value=\"前の$pglog件\">\n";
	}
	if ($next < $i) {
		$pg_btn .= "<input type=\"submit\" name=\"page$next\" value=\"次の$pglog件\">\n";
	}
	if ($pg_btn) {
		print "<p><table width=\"90%\"><tr><td valign=\"top\">\n";
		print $pg_btn;

		local($x,$y) = (1,0);
		while ( $i > 0 ) {
			if ($page == $y) {
				print "<b>[$x]</b>\n";
			} else {
				print "[<a href=\"$bbscgi?page$y=v\">$x</a>]\n";
			}
			$x++;
			$y = $y + $pglog;
			$i = $i - $pglog;
		}

		print "</td></tr></table></p>\n";
	}

	print <<EOM;
</form>
<form action="$registcgi" method="post">
<input type="hidden" name="page" value="$page">
処理 <select name="mode">
<option value="user_edit">修正
<option value="user_dele">削除
</select>
記事No <input type="text" name="no" size="3" style="ime-mode:inactive">
暗証キー <input type="password" name="pwd" size="4" maxlength="8">
<input type="submit" value="送信"></form>
<!-- 著作権表\示 削除不可 ($ver) -->
$banner2
<p style="font-size:10px;font-family:Verdana,Helvetica,Arial">
- <a href="http://www.kent-web.com/" target="_top">Joyful Note</a> -
</p>
</div>
EOM
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  返信フォーム
#-------------------------------------------------
sub res_form {
	# ログ展開
	local($flg,$top,$resub,%res,%nam,$eml,%sub,%dat,%com,%col,%url);
	open(IN,"$logfile") || &error("Open Error: $logfile");
	$top = <IN>;
	while (<IN>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		if ($resfm == $no) {
			$flg = 1;

			# タイトル名
			if ($sub !~ /^Re\:/) { $resub = "Re: $sub"; }

		} elsif ($resfm == $reno) {
			$res{$reno} .= "$no,";
		} else {
			next;
		}

		$nam{$no} = $name;
		$eml{$no} = $eml;
		$sub{$no} = $sub;
		$dat{$no} = $date;
		$com{$no} = $com;
		$col{$no} = $col;
		$url{$no} = $url;
		$ext{$no} = $ext;
		$chk{$no} = $chk;
	}
	close(IN);

	if (!$flg) { &error("不正な返信要求です"); }

	# 投稿キー
	local($str_plain,$str_crypt);
	if ($regist_key) {
		require $regkeypl;

		($str_plain,$str_crypt) = &pcp_makekey;
	}

	# ヘッダを出力
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="submit" name="page$in{'pg'}" value="&lt; 戻る">
</form>
▼<a href="#RES">返信フォーム</a>
<div align="center">
EOM

	print "<p><table bgcolor=\"$log_borcol\" width=\"90%\" cellpadding=\"5\" cellspacing=\"1\">\n";
	print "<tr><td bgcolor=\"$tbl_color\">\n";
	print "<b style=\"color:$subcol\">$sub{$resfm}</b> ";
	print "投稿者：<b>$nam{$resfm}</b> 投稿日：$dat{$resfm} ";
	print "<span style=\"color:$subcol\">No.$resfm</span> ";
	if ($url{$resfm}) {
		print "<a href=\"$url{$resfm}\" target=\"_blank\">$img_home</a>";
	}
	print "<br>\n";
	print "<div style=\"color:$col{$resfm}; margin-left:22px; margin-top:6px\">";
	print "$com{$resfm}";
	if ($ext{$resfm}) {
		local($size) = -s "$imgdir/$resfm$ext{$resfm}";
		$size = int ( $size / 1024 ) . 'KB';

		if ($ImageCheck && $chk{$resfm} eq '0') {
			print "<br><br>添付：ComingSoon ($size)\n";
		} else {
			print "<br><br>添付：<a href=\"$imgurl/$resfm$ext{$resfm}\" target=\"_blank\">$resfm$ext{$resfm}</a> ($size)\n";
		}
	}
	print "</div>";

	# レス記事
	if (defined($res{$resfm})) {
		print "<div style=\"margin-left:22px; margin-top:5px;\">";
		foreach $res ( split(/,/, $res{$resfm}) ) {
			print "<b style=\"color:$subcol\">$sub{$res}</b> - <b>$nam{$res}</b> ";
			print "$dat{$res} <span style=\"color:$subcol\">No.$res</span> ";
			if ($url{$res}) {
				print "<a href=\"$url{$res}\" target=\"_blank\">$img_home</a>";
			}
			print "<br><span style=\"color:$col{$res}\">$com{$res}</span><br><br>";
		}
		print "</div>\n";
	}

	print "</td></tr></table></p></div>\n";
	print "<a name=\"RES\"></a>\n";

	$sub = $resub;
	&bbs_form("res", "res");

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  留意事項
#-------------------------------------------------
sub howto {
	if ($in_email) {
		$eml_msg = "記事を投稿する上での必須入力項目は<b>「おなまえ」「Ｅメール」「メッセージ」</b>です。ＵＲＬ、題名、暗証キーは任意です。";
	} else {
		$eml_msg = "記事を投稿する上での必須入力項目は<b>「おなまえ」</b>と<b>「メッセージ」</b>です。Ｅメール、ＵＲＬ、題名、暗証キーは任意です。";
	}

	local($maxkb) = int ($maxdata / 1024) . 'KB';
	if ($gif) { $FILE .= "GIF, "; }
	if ($jpeg) { $FILE .= "JPEG, "; }
	if ($png) { $FILE .= "PNG, "; }
	if ($text) { $FILE .= "TEXT, "; }
	if ($lha) { $FILE .= "LHA, "; }
	if ($zip) { $FILE .= "ZIP, "; }
	if ($pdf) { $FILE .= "PDF, "; }
	if ($midi) { $FILE .= "MIDI, "; }
	if ($word) { $FILE .= "WORD, "; }
	if ($excel) { $FILE .= "EXCEL, "; }
	if ($ppt) { $FILE .= "POWERPOINT, "; }
	if ($rm) { $FILE .= "RM, "; }
	if ($ram) { $FILE .= "RAM, "; }
	if ($mpeg) { $FILE .= "MPEG, "; }
	if ($mp3) { $FILE .= "MP3, "; }
	$FILE =~ s/\, $//;

	&header;
	print <<EOM;
<div align="center">
<h3>利用上の留意事項</h3>
<table width="90%" border="1" cellpadding="10">
<tr><td bgcolor="$tbl_color">
<ol>
<li>この掲示板は<b>クッキー対応</b>です。１度記事を投稿いただくと、おなまえ、Ｅメール、ＵＲＬ、暗証キーの情報は２回目以降は自動入力されます。（ただし利用者のブラウザがクッキー対応の場合）
<li>画像などのバイナリーファイルをアップロードすることが可能\です。
  <ul>
  <li>添付可能\ファイル : $FILE
  <li>最大投稿データ量 : $maxkb
  <li>画像は横$MaxWピクセル、縦$MaxHピクセルを超えると縮小表\示されます。
  </ul>
<li>投稿内容には、<b>HTMLタグは一切使用できません。</b>
<li>$eml_msg
<li>記事には、<b>半角カナは一切使用しないで下さい。</b>文字化けの原因となります。
<li>記事の投稿時に<b>「暗証キー」</b>にパスワード（英数字で8文字以内）を入れておくと、その記事は次回<b>暗証キー</b>によって削除することができます。
<li>記事の保持件数は<b>最大 $max件</b>です。それを超えると古い順に自動削除されます。
<li>既存の記事に<b>「返信」</b>をすることができます。各記事の上部にある<b>「返信」</b>ボタンを押すと返信用フォームが現れます。
<li>過去の投稿記事から<b>「キーワード」によって簡易検索ができます。</b>トップメニューの<a href="$bbscgi?mode=find">「ワード検索」</a>のリンクをクリックすると検索モードとなります。
<li>管理者が著しく不利益と判断する記事や他人を誹謗中傷する記事は予\告なく削除することがあります。
</ol>
</td></tr></table>
<p>
<form>
<input type="button" value="掲示板に戻る" onclick="history.back()">
</form>
</div>
</body>
</html>
EOM
	exit;
}

#-------------------------------------------------
#  ワード検索処理
#-------------------------------------------------
sub find {
	# ページ数
	local($page) = 0;
	foreach ( keys(%in) ) {
		if (/^page(\d+)$/) {
			$page = $1;
			last;
		}
	}

	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="submit" value="掲示板に戻る">
</form>
<ul>
<li>検索したい<b>キーワード</b>を入力し、「条件」「表\示」を選択して「検索」ボタンを押して下さい。
<li>キーワードは半角スペースで区切って複数指定することができます。
</ul>
<table>
<tr>
EOM

	&search($logfile);

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  検索処理
#-------------------------------------------------
sub search {
	local($target) = @_;
	local($i, $flag, $next, $back, $enwd, $wd, @wd);

	print "<td><form action=\"$bbscgi\" method=\"post\">\n";
	print "<input type=\"hidden\" name=\"mode\" value=\"$mode\">\n";

	local($para);
	if ($mode eq "past") {
		print "<input type=\"hidden\" name=\"pastlog\" value=\"$in{'pastlog'}\">\n";
		$para .= "&pastlog=$in{'pastlog'}";
	}

	print "キーワード <input type=\"text\" name=\"word\" size=\"40\" value=\"$in{'word'}\"> ";
	print "条件 <select name=\"cond\"> &nbsp; ";

	if ($in{'cond'} eq "") { $in{'cond'} = "AND"; }
	foreach ("AND", "OR") {
		if ($in{'cond'} eq $_) {
			print "<option value=\"$_\" selected>$_\n";
		} else {
			print "<option value=\"$_\">$_\n";
		}
	}
	print "</select> 表\示 <select name=\"view\">\n";
	if ($in{'view'} eq "") { $in{'view'} = 10; }
	foreach (10,15,20,25,30) {
		if ($in{'view'} == $_) {
			print "<option value=\"$_\" selected>$_件\n";
		} else {
			print "<option value=\"$_\">$_件\n";
		}
	}
	print "</select> <input type=\"submit\" value=\" 検索 \">";
	print "</td></form></tr></table>\n";

	# ワード検索の実行と結果表示
	if ($in{'word'} ne "") {

		# 入力内容を整理
		$in{'word'} =~ s/　/ /g;
		local(@wd) = split(/\s+/, $in{'word'});

		# ファイルを読み込み
		print "<dl>\n";
		local($i) = 0;
		open(IN,"$target") || &error("Open Error: $target");
		while (<IN>) {
			local($no,$reno,$date,$nam,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);
			local($flag);
			foreach $wd (@wd) {
				if (index("$nam $eml $sub $com $url",$wd) >= 0) {
					$flag = 1;
					if ($in{'cond'} eq 'OR') { last; }
				} else {
					if ($in{'cond'} eq 'AND') { $flag = 0; last; }
				}
			}
			if ($flag) {
				$i++;
				if ($i < $page + 1) { next; }
				if ($i > $page + $in{'view'}) { next; }

				if ($eml) { $nam = "<a href=\"mailto:$eml\">$nam</a>"; }
				if ($url) { $com .= "<p><a href=\"$url\" target=\"_blank\">$url</a>"; }

				print "<dt><hr>[<b>$no</b>] <b style=\"color:$subcol\">$sub</b> ";
				print "投稿者：<b>$nam</b> 投稿日：$date<br><br>\n";
				print "<dd><div style=\"color:$col\">$com</div>\n";
				if ($ext) {
					local($size) = -s "$imgdir/$no$ext";
					$size = int ( $size / 1024 ) . 'KB';

					if ($ImageCheck && $chk eq '0') {
						print "<br><br><dd>添付：ComingSoon ($size)\n";
					} else {
						print "<br><br><dd>添付：<a href=\"$imgurl/$no$ext\" target=\"_blank\">$no$ext</a> ($size)\n";
					}
				}
			}
		}
		close(IN);

		print "<dt><hr>検索結果：<b>$i</b>件</dl>\n";

		local($next) = $page + $in{'view'};
		local($back) = $page - $in{'view'};
		local($enwd) = &url_enc($in{'word'});
		if ($back >= 0) {
			print "[<a href=\"$bbscgi?mode=$mode&page$back=v&word=$enwd&view=$in{'view'}&cond=$in{'cond'}$para\">前の$in{'view'}件</a>]\n";
		}
		if ($next < $i) {
			print "[<a href=\"$bbscgi?mode=$mode&page$next=v&word=$enwd&view=$in{'view'}&cond=$in{'cond'}$para\">次の$in{'view'}件</a>]\n";
		}
		print "</body></html>\n";
		exit;
	}
}

#-------------------------------------------------
#  カウンタ処理
#-------------------------------------------------
sub counter {
	local($count, $cntup, @count);

	# 閲覧時のみカウントアップ
	if ($mode eq '') { $cntup = 1; } else { $cntup = 0; }

	# カウントファイルを読みこみ
	open(LOG,"+< $cntfile") || &error("Open Error: $cntfile");
	eval "flock(LOG, 2);";
	$count = <LOG>;

	# IPチェックとログ破損チェック
	local($cnt, $ip) = split(/:/, $count);
	if ($addr eq $ip || $cnt eq "") { $cntup = 0; }

	# カウントアップ
	if ($cntup) {
		$cnt++;
		seek(LOG, 0, 0);
		print LOG "$cnt:$addr";
		truncate(LOG, tell(LOG));
	}
	close(LOG);

	# 桁数調整
	while(length($cnt) < $mini_fig) { $cnt = '0' . $cnt; }
	local(@cnts) = split(//, $cnt);

	# GIFカウンタ表示
	if ($counter == 2) {
		foreach (0 .. $#cnts) {
			print "<img src=\"$gif_path/$cnts[$_]\.gif\" alt=\"$cnts[$_]\" width=\"$mini_w\" height=\"$mini_h\">";
		}

	# テキストカウンタ表示
	} else {
		print "<font color=\"$cnt_color\" face=\"verdana,Times New Roman,Arial\">$cnt</font><br>\n";
	}
}

#-------------------------------------------------
#  自動URLリンク
#-------------------------------------------------
sub auto_link {
	$_[0] =~ s/([^=^\"]|^)(http\:[\w\.\~\-\/\?\&\+\=\:\@\%\;\#\%]+)/$1<a href=\"$2\" target=\"_blank\">$2<\/a>/g;
}

#-------------------------------------------------
#  過去ログ
#-------------------------------------------------
sub past_log {
	# ページ数
	local($page) = 0;
	foreach ( keys(%in) ) {
		if (/^page(\d+)$/) {
			$page = $1;
			last;
		}
	}

	# 過去ログNo
	open(IN,"$nofile") || &error("Open Error: $nofile");
	local($no) = <IN>;
	close(IN);

	$in{'pastlog'} =~ s/\D//g;
	if (!$in{'pastlog'}) { $in{'pastlog'} = $no; }

	&header;
	print <<"EOM";
<form action="$bbscgi" method="post">
<input type="submit" value="&lt; 戻る">
</form>
<form action="$bbscgi" method="post">
<input type="hidden" name="mode" value="past">
<table><tr><td><b>過去ログ：</b> <select name="pastlog">
EOM

	# 過去ログ選択
	for ( $i = $no; $i > 0; --$i ) {
		$i = sprintf("%04d", $i);
		next unless (-e "$pastdir/$i.cgi");
		if ($in{'pastlog'} == $i) {
			print "<option value=\"$i\" selected>$i\n";
		} else {
			print "<option value=\"$i\">$i\n";
		}
	}
	print "</select> <input type=\"submit\" value=\"移動\">";
	print "</td></form><td width=\"20\"></td>\n";

	local($file) = sprintf("%s/%04d.cgi", $pastdir,$in{'pastlog'});
	&search($file);

	print "<dl>\n";
	local($i) = 0;
	open(IN,"$file") || &error("Open Error: $file");
	while (<IN>) {
		local($no,$reno,$date,$nam,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);
		if (!$reno) { $i++; }
		if ($i < $page + 1) { next; }
		if ($i > $page + $pglog) { last; }

		&auto_link($com) if ($link);

		if ($eml) { $nam = "<a href=\"mailto:$eml\">$nam</a>"; }
		if ($url) { $url = "&lt;<a href=\"$url\" target=\"_blank\">URL</a>&gt;"; }

		print "<dt><hr>[<b>$no</b>] <b style=\"color:$subcol\">$sub</b> ";
		print "投稿者：<b>$nam</b> 投稿日：$date &nbsp; $url <br><br>";
		print "<dd>$com<br><br>\n";

	}
	close(IN);

	print "<dt><hr></dl>\n";

	# ページ繰越
	local($next) = $page + $pglog;
	local($back) = $page - $pglog;

	if ($back >= 0 || $next < $i) {
		print "<form action=\"$bbscgi\" method=\"post\">\n";
		print "<input type=\"hidden\" name=\"mode\" value=\"past\">\n";
		print "<input type=\"hidden\" name=\"pastlog\" value=\"$in{'pastlog'}\">\n";

		if ($back >= 0) {
			print "<input type=\"submit\" name=\"page$back\" value=\"前の$pglog件\">\n";
		}
		if ($next < $i) {
			print "<input type=\"submit\" name=\"page$next\" value=\"次の$pglog件\">\n";
		}

		print "</form>\n";
	}
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  チェックモード
#-------------------------------------------------
sub check {
	&header;
	print "<h2>Check Mode</h2>\n";
	print "<ul>\n";

	# ログパス
	if (-e $logfile) {
		print "<li>ログファイルのパス：OK\n";
		# パーミッション
		if (-r $logfile && -w $logfile) {
			print "<li>ログファイルのパーミッション：OK\n";
		} else { print "<li>ログファイルのパーミッション：NG\n"; }
	} else { print "<li>ログファイルのパス：NG → $logfile\n"; }

	# カウンタログ
	print "<li>カウンタ：";
	if ($counter) {
		print "設定あり\n";
		if (-e $cntfile) { print "<li>カウンタログファイルのパス：OK\n"; }
		else { print "<li>カウンタログファイルのパス：NG → $cntfile\n"; }
	} else { print "設定なし\n"; }

	# 画像ディレクトリ
	print "<li>画像ディレクトリ：$imgdir\n";
	if (-d $imgdir) {
		print "<li>画像ディレクトリのパス：OK\n";
		if (-r $imgdir && -w $imgdir && -x $imgdir) {
			print "<li>画像ディレクトリのパーミッション：OK\n";
		} else {
			print "<li>画像ディレクトリのパーミッション：NG → $imgdir\n";
		}
	} else { print "<li>画像ディレクトリ：NG → $imgdir\n"; }

	# 過去ログ
	print "<li>過去ログ：";
	if ($pastkey == 0) { print "設定なし\n"; }
	else {
		print "設定あり\n";

		# NOファイル
		if (-e $nofile) {
			print "<li>NOファイルパス：OK\n";
			if (-r $nofile && -w $nofile) {
				print "<li>NOファイルパーミッション：OK\n";
			} else { print "<li>NOファイルパーミッション：NG → $nofile\n"; }
		} else { print "<li>NOファイルのパス：NG → $nofile\n"; }

		# ディレクトリ
		if (-d $pastdir) {
			print "<li>過去ログディレクトリパス：OK\n";
			if (-r $pastdir && -w $pastdir && -x $pastdir) {
				print "<li>過去ログディレクトリパーミッション：OK\n";
			} else {
				print "<li>過去ログディレクトリパーミッション：NG → $pastdir\n";
			}
		} else { print "<li>過去ログディレクトリパーミッション：NG → $pastdir\n"; }
	}
	print "</ul>\n</body></html>\n";
	exit;
}

#-------------------------------------------------
#  URLエンコード
#-------------------------------------------------
sub url_enc {
	local($_) = @_;

	s/(\W)/'%' . unpack('H2', $1)/eg;
	s/\s/+/g;
	$_;
}

