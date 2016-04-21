#!/usr/bin/perl

#┌─────────────────────────────────
#│ JOYFUL NOTE
#│ admin.cgi - 2006/09/24
#│ Copyright (c) KentWeb
#│ webmaster@kent-web.com
#└─────────────────────────────────

# 外部ファイル取り込み
require './init.cgi';
require $jcode;
require $cgi_lib;

# 処理を定義
&parse_form;
&pwd_check;
&admin;

#-------------------------------------------------
#  管理モード
#-------------------------------------------------
sub admin {
	# ページ繰越
	local($page) = 0;
	foreach ( keys(%in) ) {
		if (/^page(\d+)$/) {
			$page = $1;
		}
	}

	# 修正フォーム
	if ($in{'job'} eq "edit" && $in{'no'}) {

		if ($in{'no'} =~ /\0/) { &error("修正は1記事のみです"); }

		local($flg,$top,$resmd,$no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk);
		open(DAT,"+< $logfile") || &error("Open Error: $logfile");
		$top = <DAT>;
		while (<DAT>) {
			($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

			if ($in{'no'} == $no) {
				if ($reno) { $resmd = 1; }
				$flg = 1;
				last;
			}
		}
		close(DAT);

		if (!$flg) { &error("該当記事は存在しません"); }

		# 修正フォーム
		&edit_form();

	# 削除処理
	} elsif ($in{'job'} eq "dele" && $in{'no'}) {

		# 削除情報
		local(@del) = split(/\0/, $in{'no'});

		# 削除情報をマッチングし更新
		local($top,@data);
		open(DAT,"+< $logfile") || &error("Open Error: $logfile");
		eval "flock(DAT, 2);";
		$top = <DAT>;
		while (<DAT>) {
			local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ex,$w,$h,$chk) = split(/<>/);
			local($flg);
			foreach $del (@del) {
				if ($no == $del || $reno == $del) {
					if ($ex) {
						unlink("$imgdir/$no$ex");
					}
					$flg = 1;
					last;
				}
			}
			if (!$flg) { push(@data,$_); }
		}

		# 更新
		unshift(@data,$top);
		seek(DAT, 0, 0);
		print DAT @data;
		truncate(DAT, tell(DAT));
		close(DAT);

	# 画像許可
	} elsif ($in{'job'} eq "perm" && $in{'no'}) {

		# 許可情報
		local(@perm) = split(/\0/, $in{'no'});

		# 許可情報をマッチングし更新
		local($top,@data);
		open(DAT,"+< $logfile") || &error("Open Error : $logfile");
		eval "flock(DAT, 2);";
		$top = <DAT>;
		while (<DAT>) {
			local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ex,$w,$h,$chk) = split(/<>/);
			foreach $perm (@perm) {
				if ($no == $perm) {
					if ($chk == 1) { $chk = 0; } else { $chk = 1; }
					$_ = "$no<>$reno<>$date<>$name<>$eml<>$sub<>$com<>$url<>$host<>$pw<>$col<>$ex<>$w<>$h<>$chk<>\n";
					last;
				}
			}
			push(@data,$_);
		}

		# 更新
		unshift(@data,$top);
		seek(DAT, 0, 0);
		print DAT @data;
		truncate(DAT, tell(DAT));
		close(DAT);

	}

	local($top,%nam,%eml,%sub,%dat,%com,%col,%url,%ext,%imw,%imh,%chk,%hos);
	$pglog *= 2;
	open(IN,"$logfile") || &error("Open Error: $logfile");
	$top = <IN>;
	while (<IN>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ex,$w,$h,$chk) = split(/<>/);

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

		$nam{$no} = $name;
		$eml{$no} = $eml;
		$sub{$no} = $sub;
		$dat{$no} = $date;
		$com{$no} = $com;
		$col{$no} = $col;
		$url{$no} = $url;
		$ext{$no} = $ex;
		$imw{$no} = $w;
		$imh{$no} = $h;
		$chk{$no} = $chk;
		$hos{$no} = $host;
	}
	close(IN);

	# 管理を表示
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="submit" value="&lt; 掲示板へ">
</form>
<form action="$admincgi" method="post">
<input type="hidden" name="pass" value="$in{'pass'}">
処理：
<select name="job">
<option value="edit">編集
<option value="dele">削除
EOM

	if ($ImageCheck) {
		print "<option value=\"perm\">許可\n";
	}

	print <<EOM;
</select>
<input type="submit" value="送信する">
<p>
<dl>
EOM

	foreach (@view) {
		# チェックボックス
		print "<dt><hr><input type=\"checkbox\" name=\"no\" value=\"$_\"><b style=\"color:$subcol\">$sub{$_}</b> - ";
		print "<b>$nam{$_}</b> $dat{$_} <font color=\"$subcol\">No.$_</font> ($hos{$_})\n";

		if ($ext{$_}) {
			print "&lt;<a href=\"$imgurl/$_$ext{$_}\" target=\"_blank\">添付</a>";
			if ($ImageCheck && $chk{$_} eq '0') { print ":未許可"; }
			print "&gt;";
		}

		# レス記事
		foreach $res ( split(/,/, $res{$_}) ) {
			print "<dd><input type=\"checkbox\" name=\"no\" value=\"$res\"><b style=\"color:$subcol\">$sub{$res}</b> - ";
			print "<b>$nam{$res}</b> $dat{$res} <font color=\"$subcol\">No.$res</font> ($hos{$res})\n";

			if ($ext{$res}) {
				print "&lt;<a href=\"$imgurl/$res$ext{$res}\" target=\"_blank\">添付</a>&gt;";
			}
		}
	}

	print "<dt><hr></dl>\n";

	# 繰越ページ
	local($next) = $page + $pglog;
	local($back) = $page - $pglog;

	# 繰越ボタン表示
	if ($back >= 0) {
		print "<input type=\"submit\" name=\"page$back\" value=\"前の$pglog件\">\n";
	}
	if ($next < $i) {
		print "<input type=\"submit\" name=\"page$next\" value=\"次の$pglog件\">\n";
	}

	print "</form>\n";
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  修正フォーム
#-------------------------------------------------
sub edit_form {
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="hidden" name="page" value="$page">
<input type="submit" value="&lt; 戻る">
</form>
<p>
▼変更する部分のみ修正して送信ボタンを押して下さい。<br>
EOM

	$com =~ s/<br>/\n/g;
	&bbs_form("admin", $resmd);

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  パスワードチェック
#-------------------------------------------------
sub pwd_check {
	if ($in{'pass'} eq "") {
		&header;
		print <<EOM;
<div align="center">
<table width="360">
<tr><td align="center">
<fieldset>
<legend><b>管理パスワード入力</b></legend>
<form action="$admincgi" method="post">
<input type="hidden" name="mode" value="admin">
<input type="password" name="pass" size="12">
<input type="submit" value=" 認証 ">
</form>
</fieldset>
</td></tr>
</table>
<script language="javascript">
<!--
self.document.forms[0].pass.focus();
//-->
</script>
</div>
EOM
		print &HtmlBot;
		exit;

	} elsif ($in{'pass'} ne $pass) {
		&error("パスワードが違います");
	}
}

