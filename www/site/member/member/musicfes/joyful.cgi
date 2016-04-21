#!/usr/bin/perl

#��������������������������������������������������������������������
#�� JOYFUL NOTE
#�� joyful.cgi - 2006/10/04
#�� Copyright (c) KentWeb
#�� webmaster@kent-web.com
#��������������������������������������������������������������������

# �O���t�@�C����荞��
require './init.cgi';
require $jcode;
require $cgi_lib;

# �������`
&parse_form;
&axscheck;
if ($mode eq "howto") { &howto; }
elsif ($mode eq "find") { &find; }
elsif ($mode eq "past" && $pastkey) { &past_log; }
elsif ($mode eq "check") { &check; }
&bbs_log;

#-------------------------------------------------
#  �L���\����
#-------------------------------------------------
sub bbs_log {
	# �y�[�W�J�z
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
	# �ԐM�t�H�[������
	if ($resfm) { &res_form; }

	# �w�b�_���o��
	&header;

	# �J�E���^����
	if ($counter) { &counter; }

	# ���e�L�[
	local($str_plain,$str_crypt);
	if ($regist_key) {
		require $regkeypl;

		($str_plain,$str_crypt) = &pcp_makekey;
	}

	# �^�C�g����
	print "<div align=\"center\">\n";
	if ($banner1 ne "<!-- �㕔 -->") { print "$banner1<p>\n"; }
	if ($t_img) {
		print "<img src=\"$t_img\" width=\"$t_w\" height=\"$t_h\" alt=\"$title\">\n";
	} else {
		print "<b style=\"font-size:$t_size;color:$t_color;\">$title</b>\n";
	}

	# ���j���[��
	print "<hr width=\"90%\">\n";
	print "[<a href=\"$homepage\" target=\"_top\">�g�b�v�ɖ߂�</a>]\n";
	print "[<a href=\"$bbscgi?mode=howto\">���ӎ���</a>]\n";
	print "[<a href=\"$bbscgi?mode=find\">���[�h����</a>]\n";
	print "[<a href=\"$bbscgi?mode=past\">�ߋ����O</a>]\n" if ($pastkey);
	print "[<a href=\"$admincgi\">�Ǘ��p</a>]\n";
	print "<hr width=\"90%\"></div>\n";

	# ���e�t�H�[��
	&bbs_form("normal");

	print <<EOM;
<div align="center">
<form action="$bbscgi">
<input type="hidden" name="page" value="$page">
EOM

	# �L���W�J
	local($i,$top,@view,%res,%nam,$eml,%sub,%dat,%com,%col,%url,%ext,%imw,%imh);
	open(IN,"$logfile") || &error("Open Error: $logfile");
	$top = <IN>;
	while (<IN>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		++$i if (!$reno);
		next if ($i < $page + 1);
		next if ($i > $page + $pglog);

		# �e�L��
		if (!$reno) {
			push(@view,$no);
		# ���X�L��
		} else {
			$res{$reno} .= "$no,";
		}

		# �薼�̒���
		if (length($sub) > $sub_len*2) {
			$sub = substr($sub,0,$sub_len*2) . "...";
		}
		# e-mail�����N
		if ($eml) { $name = "<a href=\"mailto:$eml\">$name</a>"; }
		# URL�����N
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

	# �\��
	foreach (@view) {
		# �e�L��
		print "<p><table width=\"90%\" cellpadding=\"5\" cellspacing=\"1\" border=\"1\">\n";
		print "<tr><td bgcolor=\"$tbl_color\">\n";
		print "<b style=\"color:$subcol\">$sub{$_}</b> ";
		print "���e�ҁF<b>$nam{$_}</b> ���e���F$dat{$_} ";
		print "<span style=\"color:$subcol\">No.$_</span> ";
		if ($url{$_}) {
			print "<a href=\"$url{$_}\" target=\"_blank\">$img_home</a> ";
		}
		print "&nbsp;&nbsp;<input type=\"submit\" name=\"res$_\" value=\"�ԐM\"><br>\n";
		print "<div style=\"margin-left:22px; margin-top:6px\">";

		# �摜
		if ($ext{$_} =~ /\.(jpg|gif|png)$/) {

			# �摜-��
			if ($imgpoint == 1) {
				print "<a href=\"$imgurl/$ext{$_}\" target=\"_blank\">";
				print "<img src=\"$imgurl/$ext{$_}\" width=\"$imw{$_}\" height=\"$imh{$_}\" align=\"left\" hspace=\"5\" alt=\"\" border=\"0\"></a>";
				print "<span style=\"color:$col{$_}\">$com{$_}</span><br clear=\"all\">\n";

			# �摜-��
			} elsif ($imgpoint == 2) {
				print "<span style=\"color:$col{$_}\">$com{$_}</span><br>";
				print "<a href=\"$imgurl/$ext{$_}\" target=\"_blank\">";
				print "<img src=\"$imgurl/$ext{$_}\" width=\"$imw{$_}\" height=\"$imh{$_}\" alt=\"\" border=\"0\"></a>\n";
			}

		# �摜�ȊO
		} elsif ($ext{$_}) {
			# �T�C�Y
			local($size) = -s "$imgdir/$ext{$_}";
			$size = int ( $size / 1024 + 0.5 ) . 'KB';

			print "<span style=\"color:$col{$_}\">$com{$_}</span><br><br>";
			print "�Y�t�F<a href=\"$imgurl/$ext{$_}\" target=\"_blank\">$ext{$_}</a>\n";
			print "($size)\n";

		# �Y�t�Ȃ�
		} else {
			print "<span style=\"color:$col{$_}\">$com{$_}</span>";
		}
		print "</div>\n";

		# ���X�L��
		if (defined($res{$_})) {
			print "<div style=\"margin-left:22px; margin-top:5px;\"><hr size=\"1\">\n";

			foreach $res ( split(/,/, $res{$_}) ) {

				print "<b style=\"color:$subcol\">$sub{$res}</b> - <b>$nam{$res}</b> ";
				print "$dat{$res} <span style=\"color:$subcol\">No.$res</span> ";
				if ($url{$res}) {
					print "<a href=\"$url{$res}\" target=\"_blank\">$img_home</a>";
				}
				print "<br>";

				# �摜
				if ($ext{$res} =~ /\.(jpg|gif|png)$/) {

					# �摜-��
					if ($imgpoint == 1) {
						print "<a href=\"$imgurl/$ext{$res}\" target=\"_blank\">";
						print "<img src=\"$imgurl/$ext{$res}\" width=\"$imw{$res}\" height=\"$imh{$res}\" align=\"left\" hspace=\"5\" alt=\"\" border=\"0\"></a>";
						print "<span style=\"color:$col{$res}\">$com{$res}</span><br clear=\"all\">\n";

					# �摜-��
					} elsif ($imgpoint == 2) {
						print "<span style=\"color:$col{$res}\">$com{$res}</span><br>";
						print "<a href=\"$imgurl/$ext{$res}\" target=\"_blank\">";
						print "<img src=\"$imgurl/$ext{$res}\" width=\"$imw{$res}\" height=\"$imh{$res}\" alt=\"\" border=\"0\"></a>\n";
					}

				# �摜�ȊO
				} elsif ($ext{$res}) {
					# �T�C�Y
					local($size) = -s "$imgdir/$ext{$res}";
					$size = int ( $size / 1024 + 0.5 ) . 'KB';

					print "<span style=\"color:$col{$res}\">$com{$res}</span><br><br>";
					print "�Y�t�F<a href=\"$imgurl/$ext{$res}\" target=\"_blank\">$ext{$res}</a>\n";
					print "($size)\n";

				# �Y�t�Ȃ�
				} else {
					print "<span style=\"color:$col{$res}\">$com{$res}</span>";
				}

				print "<br><br>";
			}
			print "</div>\n";
		}

		print "</td></tr></table></p>\n";
	}

	# �J�z�y�[�W
	local($next) = $page + $pglog;
	local($back) = $page - $pglog;

	# �J�z�{�^���\��
	local($pg_btn);
	if ($back >= 0) {
		$pg_btn .= "<input type=\"submit\" name=\"page$back\" value=\"�O��$pglog��\">\n";
	}
	if ($next < $i) {
		$pg_btn .= "<input type=\"submit\" name=\"page$next\" value=\"����$pglog��\">\n";
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
���� <select name="mode">
<option value="user_edit">�C��
<option value="user_dele">�폜
</select>
�L��No <input type="text" name="no" size="3" style="ime-mode:inactive">
�Ï؃L�[ <input type="password" name="pwd" size="4" maxlength="8">
<input type="submit" value="���M"></form>
<!-- ���쌠�\\�� �폜�s�� ($ver) -->
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
#  �ԐM�t�H�[��
#-------------------------------------------------
sub res_form {
	# ���O�W�J
	local($flg,$top,$resub,%res,%nam,$eml,%sub,%dat,%com,%col,%url);
	open(IN,"$logfile") || &error("Open Error: $logfile");
	$top = <IN>;
	while (<IN>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		if ($resfm == $no) {
			$flg = 1;

			# �^�C�g����
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

	if (!$flg) { &error("�s���ȕԐM�v���ł�"); }

	# ���e�L�[
	local($str_plain,$str_crypt);
	if ($regist_key) {
		require $regkeypl;

		($str_plain,$str_crypt) = &pcp_makekey;
	}

	# �w�b�_���o��
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="submit" name="page$in{'pg'}" value="&lt; �߂�">
</form>
��<a href="#RES">�ԐM�t�H�[��</a>
<div align="center">
EOM

	print "<p><table bgcolor=\"$log_borcol\" width=\"90%\" cellpadding=\"5\" cellspacing=\"1\">\n";
	print "<tr><td bgcolor=\"$tbl_color\">\n";
	print "<b style=\"color:$subcol\">$sub{$resfm}</b> ";
	print "���e�ҁF<b>$nam{$resfm}</b> ���e���F$dat{$resfm} ";
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
			print "<br><br>�Y�t�FComingSoon ($size)\n";
		} else {
			print "<br><br>�Y�t�F<a href=\"$imgurl/$resfm$ext{$resfm}\" target=\"_blank\">$resfm$ext{$resfm}</a> ($size)\n";
		}
	}
	print "</div>";

	# ���X�L��
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
#  ���ӎ���
#-------------------------------------------------
sub howto {
	if ($in_email) {
		$eml_msg = "�L���𓊍e�����ł̕K�{���͍��ڂ�<b>�u���Ȃ܂��v�u�d���[���v�u���b�Z�[�W�v</b>�ł��B�t�q�k�A�薼�A�Ï؃L�[�͔C�ӂł��B";
	} else {
		$eml_msg = "�L���𓊍e�����ł̕K�{���͍��ڂ�<b>�u���Ȃ܂��v</b>��<b>�u���b�Z�[�W�v</b>�ł��B�d���[���A�t�q�k�A�薼�A�Ï؃L�[�͔C�ӂł��B";
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
<h3>���p��̗��ӎ���</h3>
<table width="90%" border="1" cellpadding="10">
<tr><td bgcolor="$tbl_color">
<ol>
<li>���̌f����<b>�N�b�L�[�Ή�</b>�ł��B�P�x�L���𓊍e���������ƁA���Ȃ܂��A�d���[���A�t�q�k�A�Ï؃L�[�̏��͂Q��ڈȍ~�͎������͂���܂��B�i���������p�҂̃u���E�U���N�b�L�[�Ή��̏ꍇ�j
<li>�摜�Ȃǂ̃o�C�i���[�t�@�C�����A�b�v���[�h���邱�Ƃ��\\�ł��B
  <ul>
  <li>�Y�t�\\�t�@�C�� : $FILE
  <li>�ő哊�e�f�[�^�� : $maxkb
  <li>�摜�͉�$MaxW�s�N�Z���A�c$MaxH�s�N�Z���𒴂���Ək���\\������܂��B
  </ul>
<li>���e���e�ɂ́A<b>HTML�^�O�͈�؎g�p�ł��܂���B</b>
<li>$eml_msg
<li>�L���ɂ́A<b>���p�J�i�͈�؎g�p���Ȃ��ŉ������B</b>���������̌����ƂȂ�܂��B
<li>�L���̓��e����<b>�u�Ï؃L�[�v</b>�Ƀp�X���[�h�i�p������8�����ȓ��j�����Ă����ƁA���̋L���͎���<b>�Ï؃L�[</b>�ɂ���č폜���邱�Ƃ��ł��܂��B
<li>�L���̕ێ�������<b>�ő� $max��</b>�ł��B����𒴂���ƌÂ����Ɏ����폜����܂��B
<li>�����̋L����<b>�u�ԐM�v</b>�����邱�Ƃ��ł��܂��B�e�L���̏㕔�ɂ���<b>�u�ԐM�v</b>�{�^���������ƕԐM�p�t�H�[��������܂��B
<li>�ߋ��̓��e�L������<b>�u�L�[���[�h�v�ɂ���ĊȈՌ������ł��܂��B</b>�g�b�v���j���[��<a href="$bbscgi?mode=find">�u���[�h�����v</a>�̃����N���N���b�N����ƌ������[�h�ƂȂ�܂��B
<li>�Ǘ��҂��������s���v�Ɣ��f����L���⑼�l���排�������L���͗\\���Ȃ��폜���邱�Ƃ�����܂��B
</ol>
</td></tr></table>
<p>
<form>
<input type="button" value="�f���ɖ߂�" onclick="history.back()">
</form>
</div>
</body>
</html>
EOM
	exit;
}

#-------------------------------------------------
#  ���[�h��������
#-------------------------------------------------
sub find {
	# �y�[�W��
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
<input type="submit" value="�f���ɖ߂�">
</form>
<ul>
<li>����������<b>�L�[���[�h</b>����͂��A�u�����v�u�\\���v��I�����āu�����v�{�^���������ĉ������B
<li>�L�[���[�h�͔��p�X�y�[�X�ŋ�؂��ĕ����w�肷�邱�Ƃ��ł��܂��B
</ul>
<table>
<tr>
EOM

	&search($logfile);

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  ��������
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

	print "�L�[���[�h <input type=\"text\" name=\"word\" size=\"40\" value=\"$in{'word'}\"> ";
	print "���� <select name=\"cond\"> &nbsp; ";

	if ($in{'cond'} eq "") { $in{'cond'} = "AND"; }
	foreach ("AND", "OR") {
		if ($in{'cond'} eq $_) {
			print "<option value=\"$_\" selected>$_\n";
		} else {
			print "<option value=\"$_\">$_\n";
		}
	}
	print "</select> �\\�� <select name=\"view\">\n";
	if ($in{'view'} eq "") { $in{'view'} = 10; }
	foreach (10,15,20,25,30) {
		if ($in{'view'} == $_) {
			print "<option value=\"$_\" selected>$_��\n";
		} else {
			print "<option value=\"$_\">$_��\n";
		}
	}
	print "</select> <input type=\"submit\" value=\" ���� \">";
	print "</td></form></tr></table>\n";

	# ���[�h�����̎��s�ƌ��ʕ\��
	if ($in{'word'} ne "") {

		# ���͓��e�𐮗�
		$in{'word'} =~ s/�@/ /g;
		local(@wd) = split(/\s+/, $in{'word'});

		# �t�@�C����ǂݍ���
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
				print "���e�ҁF<b>$nam</b> ���e���F$date<br><br>\n";
				print "<dd><div style=\"color:$col\">$com</div>\n";
				if ($ext) {
					local($size) = -s "$imgdir/$no$ext";
					$size = int ( $size / 1024 ) . 'KB';

					if ($ImageCheck && $chk eq '0') {
						print "<br><br><dd>�Y�t�FComingSoon ($size)\n";
					} else {
						print "<br><br><dd>�Y�t�F<a href=\"$imgurl/$no$ext\" target=\"_blank\">$no$ext</a> ($size)\n";
					}
				}
			}
		}
		close(IN);

		print "<dt><hr>�������ʁF<b>$i</b>��</dl>\n";

		local($next) = $page + $in{'view'};
		local($back) = $page - $in{'view'};
		local($enwd) = &url_enc($in{'word'});
		if ($back >= 0) {
			print "[<a href=\"$bbscgi?mode=$mode&page$back=v&word=$enwd&view=$in{'view'}&cond=$in{'cond'}$para\">�O��$in{'view'}��</a>]\n";
		}
		if ($next < $i) {
			print "[<a href=\"$bbscgi?mode=$mode&page$next=v&word=$enwd&view=$in{'view'}&cond=$in{'cond'}$para\">����$in{'view'}��</a>]\n";
		}
		print "</body></html>\n";
		exit;
	}
}

#-------------------------------------------------
#  �J�E���^����
#-------------------------------------------------
sub counter {
	local($count, $cntup, @count);

	# �{�����̂݃J�E���g�A�b�v
	if ($mode eq '') { $cntup = 1; } else { $cntup = 0; }

	# �J�E���g�t�@�C����ǂ݂���
	open(LOG,"+< $cntfile") || &error("Open Error: $cntfile");
	eval "flock(LOG, 2);";
	$count = <LOG>;

	# IP�`�F�b�N�ƃ��O�j���`�F�b�N
	local($cnt, $ip) = split(/:/, $count);
	if ($addr eq $ip || $cnt eq "") { $cntup = 0; }

	# �J�E���g�A�b�v
	if ($cntup) {
		$cnt++;
		seek(LOG, 0, 0);
		print LOG "$cnt:$addr";
		truncate(LOG, tell(LOG));
	}
	close(LOG);

	# ��������
	while(length($cnt) < $mini_fig) { $cnt = '0' . $cnt; }
	local(@cnts) = split(//, $cnt);

	# GIF�J�E���^�\��
	if ($counter == 2) {
		foreach (0 .. $#cnts) {
			print "<img src=\"$gif_path/$cnts[$_]\.gif\" alt=\"$cnts[$_]\" width=\"$mini_w\" height=\"$mini_h\">";
		}

	# �e�L�X�g�J�E���^�\��
	} else {
		print "<font color=\"$cnt_color\" face=\"verdana,Times New Roman,Arial\">$cnt</font><br>\n";
	}
}

#-------------------------------------------------
#  ����URL�����N
#-------------------------------------------------
sub auto_link {
	$_[0] =~ s/([^=^\"]|^)(http\:[\w\.\~\-\/\?\&\+\=\:\@\%\;\#\%]+)/$1<a href=\"$2\" target=\"_blank\">$2<\/a>/g;
}

#-------------------------------------------------
#  �ߋ����O
#-------------------------------------------------
sub past_log {
	# �y�[�W��
	local($page) = 0;
	foreach ( keys(%in) ) {
		if (/^page(\d+)$/) {
			$page = $1;
			last;
		}
	}

	# �ߋ����ONo
	open(IN,"$nofile") || &error("Open Error: $nofile");
	local($no) = <IN>;
	close(IN);

	$in{'pastlog'} =~ s/\D//g;
	if (!$in{'pastlog'}) { $in{'pastlog'} = $no; }

	&header;
	print <<"EOM";
<form action="$bbscgi" method="post">
<input type="submit" value="&lt; �߂�">
</form>
<form action="$bbscgi" method="post">
<input type="hidden" name="mode" value="past">
<table><tr><td><b>�ߋ����O�F</b> <select name="pastlog">
EOM

	# �ߋ����O�I��
	for ( $i = $no; $i > 0; --$i ) {
		$i = sprintf("%04d", $i);
		next unless (-e "$pastdir/$i.cgi");
		if ($in{'pastlog'} == $i) {
			print "<option value=\"$i\" selected>$i\n";
		} else {
			print "<option value=\"$i\">$i\n";
		}
	}
	print "</select> <input type=\"submit\" value=\"�ړ�\">";
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
		print "���e�ҁF<b>$nam</b> ���e���F$date &nbsp; $url <br><br>";
		print "<dd>$com<br><br>\n";

	}
	close(IN);

	print "<dt><hr></dl>\n";

	# �y�[�W�J�z
	local($next) = $page + $pglog;
	local($back) = $page - $pglog;

	if ($back >= 0 || $next < $i) {
		print "<form action=\"$bbscgi\" method=\"post\">\n";
		print "<input type=\"hidden\" name=\"mode\" value=\"past\">\n";
		print "<input type=\"hidden\" name=\"pastlog\" value=\"$in{'pastlog'}\">\n";

		if ($back >= 0) {
			print "<input type=\"submit\" name=\"page$back\" value=\"�O��$pglog��\">\n";
		}
		if ($next < $i) {
			print "<input type=\"submit\" name=\"page$next\" value=\"����$pglog��\">\n";
		}

		print "</form>\n";
	}
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  �`�F�b�N���[�h
#-------------------------------------------------
sub check {
	&header;
	print "<h2>Check Mode</h2>\n";
	print "<ul>\n";

	# ���O�p�X
	if (-e $logfile) {
		print "<li>���O�t�@�C���̃p�X�FOK\n";
		# �p�[�~�b�V����
		if (-r $logfile && -w $logfile) {
			print "<li>���O�t�@�C���̃p�[�~�b�V�����FOK\n";
		} else { print "<li>���O�t�@�C���̃p�[�~�b�V�����FNG\n"; }
	} else { print "<li>���O�t�@�C���̃p�X�FNG �� $logfile\n"; }

	# �J�E���^���O
	print "<li>�J�E���^�F";
	if ($counter) {
		print "�ݒ肠��\n";
		if (-e $cntfile) { print "<li>�J�E���^���O�t�@�C���̃p�X�FOK\n"; }
		else { print "<li>�J�E���^���O�t�@�C���̃p�X�FNG �� $cntfile\n"; }
	} else { print "�ݒ�Ȃ�\n"; }

	# �摜�f�B���N�g��
	print "<li>�摜�f�B���N�g���F$imgdir\n";
	if (-d $imgdir) {
		print "<li>�摜�f�B���N�g���̃p�X�FOK\n";
		if (-r $imgdir && -w $imgdir && -x $imgdir) {
			print "<li>�摜�f�B���N�g���̃p�[�~�b�V�����FOK\n";
		} else {
			print "<li>�摜�f�B���N�g���̃p�[�~�b�V�����FNG �� $imgdir\n";
		}
	} else { print "<li>�摜�f�B���N�g���FNG �� $imgdir\n"; }

	# �ߋ����O
	print "<li>�ߋ����O�F";
	if ($pastkey == 0) { print "�ݒ�Ȃ�\n"; }
	else {
		print "�ݒ肠��\n";

		# NO�t�@�C��
		if (-e $nofile) {
			print "<li>NO�t�@�C���p�X�FOK\n";
			if (-r $nofile && -w $nofile) {
				print "<li>NO�t�@�C���p�[�~�b�V�����FOK\n";
			} else { print "<li>NO�t�@�C���p�[�~�b�V�����FNG �� $nofile\n"; }
		} else { print "<li>NO�t�@�C���̃p�X�FNG �� $nofile\n"; }

		# �f�B���N�g��
		if (-d $pastdir) {
			print "<li>�ߋ����O�f�B���N�g���p�X�FOK\n";
			if (-r $pastdir && -w $pastdir && -x $pastdir) {
				print "<li>�ߋ����O�f�B���N�g���p�[�~�b�V�����FOK\n";
			} else {
				print "<li>�ߋ����O�f�B���N�g���p�[�~�b�V�����FNG �� $pastdir\n";
			}
		} else { print "<li>�ߋ����O�f�B���N�g���p�[�~�b�V�����FNG �� $pastdir\n"; }
	}
	print "</ul>\n</body></html>\n";
	exit;
}

#-------------------------------------------------
#  URL�G���R�[�h
#-------------------------------------------------
sub url_enc {
	local($_) = @_;

	s/(\W)/'%' . unpack('H2', $1)/eg;
	s/\s/+/g;
	$_;
}

