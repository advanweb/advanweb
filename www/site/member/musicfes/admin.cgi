#!/usr/bin/perl

#��������������������������������������������������������������������
#�� JOYFUL NOTE
#�� admin.cgi - 2006/09/24
#�� Copyright (c) KentWeb
#�� webmaster@kent-web.com
#��������������������������������������������������������������������

# �O���t�@�C����荞��
require './init.cgi';
require $jcode;
require $cgi_lib;

# �������`
&parse_form;
&pwd_check;
&admin;

#-------------------------------------------------
#  �Ǘ����[�h
#-------------------------------------------------
sub admin {
	# �y�[�W�J�z
	local($page) = 0;
	foreach ( keys(%in) ) {
		if (/^page(\d+)$/) {
			$page = $1;
		}
	}

	# �C���t�H�[��
	if ($in{'job'} eq "edit" && $in{'no'}) {

		if ($in{'no'} =~ /\0/) { &error("�C����1�L���݂̂ł�"); }

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

		if (!$flg) { &error("�Y���L���͑��݂��܂���"); }

		# �C���t�H�[��
		&edit_form();

	# �폜����
	} elsif ($in{'job'} eq "dele" && $in{'no'}) {

		# �폜���
		local(@del) = split(/\0/, $in{'no'});

		# �폜�����}�b�`���O���X�V
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

		# �X�V
		unshift(@data,$top);
		seek(DAT, 0, 0);
		print DAT @data;
		truncate(DAT, tell(DAT));
		close(DAT);

	# �摜����
	} elsif ($in{'job'} eq "perm" && $in{'no'}) {

		# �����
		local(@perm) = split(/\0/, $in{'no'});

		# �������}�b�`���O���X�V
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

		# �X�V
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

		# �e�L��
		if (!$reno) {
			push(@view,$no);
		# ���X�L��
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

	# �Ǘ���\��
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="submit" value="&lt; �f����">
</form>
<form action="$admincgi" method="post">
<input type="hidden" name="pass" value="$in{'pass'}">
�����F
<select name="job">
<option value="edit">�ҏW
<option value="dele">�폜
EOM

	if ($ImageCheck) {
		print "<option value=\"perm\">����\n";
	}

	print <<EOM;
</select>
<input type="submit" value="���M����">
<p>
<dl>
EOM

	foreach (@view) {
		# �`�F�b�N�{�b�N�X
		print "<dt><hr><input type=\"checkbox\" name=\"no\" value=\"$_\"><b style=\"color:$subcol\">$sub{$_}</b> - ";
		print "<b>$nam{$_}</b> $dat{$_} <font color=\"$subcol\">No.$_</font> ($hos{$_})\n";

		if ($ext{$_}) {
			print "&lt;<a href=\"$imgurl/$_$ext{$_}\" target=\"_blank\">�Y�t</a>";
			if ($ImageCheck && $chk{$_} eq '0') { print ":������"; }
			print "&gt;";
		}

		# ���X�L��
		foreach $res ( split(/,/, $res{$_}) ) {
			print "<dd><input type=\"checkbox\" name=\"no\" value=\"$res\"><b style=\"color:$subcol\">$sub{$res}</b> - ";
			print "<b>$nam{$res}</b> $dat{$res} <font color=\"$subcol\">No.$res</font> ($hos{$res})\n";

			if ($ext{$res}) {
				print "&lt;<a href=\"$imgurl/$res$ext{$res}\" target=\"_blank\">�Y�t</a>&gt;";
			}
		}
	}

	print "<dt><hr></dl>\n";

	# �J�z�y�[�W
	local($next) = $page + $pglog;
	local($back) = $page - $pglog;

	# �J�z�{�^���\��
	if ($back >= 0) {
		print "<input type=\"submit\" name=\"page$back\" value=\"�O��$pglog��\">\n";
	}
	if ($next < $i) {
		print "<input type=\"submit\" name=\"page$next\" value=\"����$pglog��\">\n";
	}

	print "</form>\n";
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  �C���t�H�[��
#-------------------------------------------------
sub edit_form {
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="hidden" name="page" value="$page">
<input type="submit" value="&lt; �߂�">
</form>
<p>
���ύX���镔���̂ݏC�����đ��M�{�^���������ĉ������B<br>
EOM

	$com =~ s/<br>/\n/g;
	&bbs_form("admin", $resmd);

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  �p�X���[�h�`�F�b�N
#-------------------------------------------------
sub pwd_check {
	if ($in{'pass'} eq "") {
		&header;
		print <<EOM;
<div align="center">
<table width="360">
<tr><td align="center">
<fieldset>
<legend><b>�Ǘ��p�X���[�h����</b></legend>
<form action="$admincgi" method="post">
<input type="hidden" name="mode" value="admin">
<input type="password" name="pass" size="12">
<input type="submit" value=" �F�� ">
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
		&error("�p�X���[�h���Ⴂ�܂�");
	}
}

