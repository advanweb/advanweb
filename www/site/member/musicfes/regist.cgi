#!/usr/bin/perl

#��������������������������������������������������������������������
#�� JOYFUL NOTE
#�� regist.cgi - 2006/10/08
#�� Copyright (c) KentWeb
#�� webmaster@kent-web.com
#��������������������������������������������������������������������

# �O���t�@�C����荞��
require './init.cgi';
require $jcode;
require $cgi_lib;
$cgi_lib'maxdata = $maxdata;

# ������`
&parse_form;
&axscheck;
if ($mode eq "regist") { &regist; }
elsif ($mode eq "user_dele") { &user_dele; }
elsif ($mode eq "user_edit") { &user_edit; }
elsif ($mode eq "admin") { &admin; }
&error("�s���ȏ����ł�");

#-------------------------------------------------
#  ���e�L����t
#-------------------------------------------------
sub regist {
	local($top,$ango,$f,$match,$tail,$W,$H,@lines,@new,@tmp);

	# �t�H�[�����̓`�F�b�N
	&form_check;

	# ���e�L�[�`�F�b�N
	if ($regist_key) {
		require $regkeypl;

		if ($in{'regikey'} !~ /^\d{4}$/) {
			&error("���e�L�[�����͕s���ł��B<p>���e�t�H�[���ɖ߂��čēǍ��݌�A�w��̐�������͂��Ă�������");
		}

		# ���e�L�[�`�F�b�N
		# -1 : �L�[�s��v
		#  0 : �������ԃI�[�o�[
		#  1 : �L�[��v
		local($chk) = &registkey_chk($in{'regikey'}, $in{'str_crypt'});
		if ($chk == 0) {
			&error("���e�L�[���������Ԃ𒴉߂��܂����B<p>���e�t�H�[���ɖ߂��čēǍ��݌�A�w��̐������ē��͂��Ă�������");
		} elsif ($chk == -1) {
			&error("���e�L�[���s���ł��B<p>���e�t�H�[���ɖ߂��čēǍ��݌�A�w��̐�������͂��Ă�������");
		}
	}

	# �`�F�b�N
	if ($no_wd) { &no_wd; }
	if ($jp_wd) { &jp_wd; }
	if ($urlnum > 0) { &urlnum; }

	if ($in{'sub'} eq "") { $in{'sub'} = "����"; }

	# ���Ԃ��擾
	&get_time;

	# �N�b�L�[�𔭍s
	&set_cookie($in{'name'},$in{'email'},$in{'url'},$in{'pwd'},$in{'icon'},$in{'color'});

	# ���O���J��
	local($top,@data);
	open(DAT,"+< $logfile") || &error("Open Error: $logfile");
	eval "flock(DAT, 2);";
	$top = <DAT>;

	# �L��NO����
	local($no, $ip, $time2) = split(/<>/, $top);
	$no++;

	# �A�����e�`�F�b�N
	if ($addr eq $ip && $wait > $times - $time2) {
		close(DAT);
		&error("�A�����e�͂������΂炭���Ԃ������ĉ�����");
	}

	# �폜�L�[���Í���
	if ($in{'pwd'} ne "") { $ango = &encrypt($in{'pwd'}); }

	# �A�b�v���[�h
	local($ext,$w,$h);
	unless ($resmd && !$res_clip) {
		if ($in{'upfile'}) { ($ext,$w,$h) = &upload($no); }
	}

	# �e�L���̏ꍇ
	if ($in{'reno'} eq "") {
		local($i,$stop);
		while (<DAT>) {
			local($no2,$reno2,$dat,$nam,$eml,$sub,$com,$url,$hos,$pw,$col,$ex2,$w2,$h2,$chk) = split(/<>/);
			$i++;
			if ($i > $max-1 && $reno2 eq "") { $stop = 1; }
			if (!$stop) {
				push(@data,$_);
			} else {
				# �ߋ����O
				if ($pastkey) { push(@past,$_); }

				# �Y�t�t�@�C���͍폜
				if ($ex2) { unlink("$imgdir/$no2$ex2"); }
			}
		}
		unshift(@data,"$no<><>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
		unshift(@data,"$no<>$addr<>$times<>\n");

		# �ߋ����O�X�V
		if (@past > 0) { &past_make(@past); }

	# ���X�L���F�g�b�v�\�[�g����
	} elsif ($in{'reno'} && $topsort) {

		local($flg,$match,@tmp);
		while (<DAT>) {
			local($no2,$reno2,$dat,$nam,$eml,$sub,$com,$url,$hos,$pw,$col,$ex2,$w2,$h2,$chk) = split(/<>/);

			# �e�L������
			if ($in{'reno'} == $no2) {
				if ($reno2) { $flg = 1; last; }
				$match = 1;
				push(@data,$_);

			# ���X�L������
			} elsif ($in{'reno'} == $reno2) {
				push(@data,$_);

			# �e�L���̒����ɒu��
			} elsif ($match == 1 && $in{'reno'} != $reno2) {
				$match = 2;
				push(@data,"$no<>$in{'reno'}<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
				push(@tmp,$_);

			} else {
				push(@tmp,$_);
			}
		}
		if ($flg || !$match) {
			close(DAT);
			&error("�s���ȕԐM�v���ł�");
		}

		# �ŏ��̃��X�L���̃P�[�X
		if ($match == 1) {
			push(@data,"$no<>$in{'reno'}<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
		}
		# ���X�L���P�����g�b�v��
		push(@data,@tmp);
		unshift(@data,"$no<>$addr<>$times<>\n");

	# ���X�L���F�g�b�v�\�[�g�Ȃ�
	} else {

		local($flg,$match);
		while (<DAT>) {
			local($no2,$reno2,$dat,$nam,$eml,$sub,$com,$url,$hos,$pw,$col,$ex2,$w2,$h2,$chk) = split(/<>/);

			if ($match == 0 && $in{'reno'} == $no2) {
				if ($reno2) { $flg = 1; last; }
				$match = 1;

			} elsif ($match == 1 && $in{'reno'} != $reno2) {
				$match = 2;
				push(@data,"$no<>$in{'reno'}<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
			}
			push(@data,$_);
		}
		if ($flg || !$match) {
			close(DAT);
			&error("�s���ȕԐM�v���ł�");
		}

		if ($match == 1) {
			push(@data,"$no<>$in{'reno'}<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
		}
		unshift(@data,"$no<>$addr<>$times<>\n");
	}

	# �X�V
	seek(DAT, 0, 0);
	print DAT @data;
	truncate(DAT, tell(DAT));
	close(DAT);

	# ���[������
	if (($mailing == 1 && $in{'email'} ne $mailto) || ($mailing == 2)) { &mail_to; }

	# �����[�h
	if ($location) {
		if ($ENV{'PERLXS'} eq "PerlIS") {
			print "HTTP/1.0 302 Temporary Redirection\r\n";
			print "Content-type: text/html\n";
		}
		print "Location: $location?\n\n";
		exit;

	} else {
		&message("���e�͐���ɏ�������܂���");
	}
}

#-------------------------------------------------
#  ���[�U�L���폜
#-------------------------------------------------
sub user_dele {
	if ($in{'no'} eq '' || $in{'pwd'} eq '') {
		&error("�L��No�܂��͍폜�L�[�����̓����ł�");
	}

	local($top,$flg,$oya_flg,@data);
	open(DAT,"+< $logfile") || &error("Open Error : $logfile");
	eval "flock(DAT, 2);";
	$top = <DAT>;
	while (<DAT>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		# �Y���L��
		if ($in{'no'} == $no) {
			$oya_flg = 1;
			$flg = 1;
			if ($pw eq '') {
				$flg = 2;
				last;
			}
			# �폜�L�[���ƍ�
			if ( &decrypt($in{'pwd'},$pw) != 1 ) {
				$flg = 3;
				last;
			}
			# �Y�t�t�@�C���폜
			if ($ext) { unlink("$imgdir/$no$ext"); }
			next;

		# �e�L�����폜�����ꍇ�̓��X�L�����폜
		} elsif ($oya_flg && $in{'no'} == $reno) {

			# �Y�t�t�@�C���폜
			if ($ext) { unlink("$imgdir/$no$ext"); }
			next;
		}
		push(@data,$_);
	}
	if (!$flg) {
		close(DAT);
		&error("�Y���L������������܂���");
	} elsif ($flg == 2) {
		close(DAT);
		&error("�Y���L���ɂ͍폜�L�[���ݒ肳��Ă��܂���");
	} elsif ($flg == 3) {
		close(DAT);
		&error("�폜�L�[���Ⴂ�܂�");
	}

	# �X�V
	seek(DAT, 0, 0);
	print DAT $top;
	print DAT @data;
	truncate(DAT, tell(DAT));
	close(DAT);

	# ����
	&message("�L�����폜���܂���");
}

#-------------------------------------------------
#  �L���C������
#-------------------------------------------------
sub user_edit {
	if ($in{'no'} eq '' || $in{'pwd'} eq '') {
		&error("�L��No�܂��͈Ï؃L�[�����̓����ł�");
	}

	# ���s
	if ($in{'job'} eq "edit") {

		# �t�H�[�����̓`�F�b�N
		&form_check;

		# �`�F�b�N
		if ($no_wd) { &no_wd; }
		if ($jp_wd) { &jp_wd; }
		if ($urlnum > 0) { &urlnum; }

		if ($in{'sub'} eq "") { $in{'sub'} = "����"; }

		local($top,$ext2,$w2,$h2,@data);
		local($flg) = 0;
		open(DAT,"+< $logfile") || &error("Open Error: $logfile");
		eval "flock(DAT, 2);";
		$top = <DAT>;
		while (<DAT>) {
			local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

			if ($in{'no'} == $no) {
				$flg = 1;
				if ($pw eq '') {
					$flg = -1;
					last;
				}
				# �폜�L�[���ƍ�
				if ( &decrypt($in{'pwd'},$pw) != 1 ) {
					$flg = -2;
					last;
				}

				# �A�b�v���[�h
				unless ($resmd && !$res_clip) {
					if ($in{'upfile'}) {
						($ext2,$w2,$h2) = &upload($in{'no'});
					}
				}

				# �摜�폜
				if ($in{'imgdel'}) {
					unlink("$imgdir/$in{'no'}$ext");
					$ext = $w = $h = '';
				}

				# �Y�t�A�b�v���[�h�̏ꍇ
				if ($ext2) {
					# �g���q�ύX�̏ꍇ�A���t�@�C���͍폜
					if ($ext && $ext2 ne $ext) {
						unlink("$imgdir/$in{'no'}$ext");
					}
					# �V�Y�t�t�@�C�����
					($ext,$w,$h) = ($ext2,$w2,$h2);
				}
				$_ = "$no<>$reno<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$pw<>$in{'color'}<>$ext<>$w<>$h<>0<>\n";
			}
			push(@data,$_);
		}

		# �X�V
		seek(DAT, 0, 0);
		print DAT $top;
		print DAT @data;
		truncate(DAT, tell(DAT));
		close(DAT);

		if ($flg < 1) { &error("�s���ȏ����ł�"); }

		# �������b�Z�[�W
		&message("�C�����������܂���");
	}

	local($flg,$top,$resmd,$no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk);
	open(IN,"$logfile") || &error("Open Error: $logfile");
	$top = <IN>;
	while (<IN>) {
		($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		if ($in{'no'} == $no) {

			if ($reno) { $resmd = 1; }

			$flg = 1;
			if ($pw eq '') {
				$flg = -1;
			}
			# �폜�L�[���ƍ�
			if ( &decrypt($in{'pwd'},$pw) != 1 ) {
				$flg = -2;
			}
			last;
		}
	}
	close(IN);

	# ����
	if (!$flg) {
		&error("�Y���L������������܂���");
	} elsif ($flg == -1) {
		&error("�Y���L���ɂ͍폜�L�[���ݒ肳��Ă��܂���");
	} elsif ($flg == -2) {
		&error("�폜�L�[���Ⴂ�܂�");
	}

	# ���s����
	$com =~ s/<br>/\n/g;

	# �C���t�H�[��
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="hidden" name="page" value="$page">
<input type="submit" value="&lt; �߂�">
</form>
<p>
���ύX���镔���̂ݏC�����đ��M�{�^���������ĉ������B<br>
EOM

	&bbs_form("edit", $resmd);

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  �Ǘ��ҕҏW
#-------------------------------------------------
sub admin {
	if ($in{'pass'} ne $pass) { &error("�p�X���[�h���Ⴂ�܂�"); }

	if ($in{'url'} eq "http://") { $in{'url'} = ""; }

	# �C��
	local($top,@data);
	open(DAT,"+< $logfile") || &error("Open Error: $logfile");
	eval "flock(DAT, 2);";
	$top = <DAT>;
	while (<DAT>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		if ($in{'no'} == $no) {

			# �摜�폜
			if ($in{'imgdel'}) {
				unlink("$imgdir/$in{'no'}$ext");
				$ext = $w = $h = '';
			}

			# �A�b�v���[�h
			local($ext2,$w2,$h2);
			if ($in{'upfile'}) { ($ext2,$w2,$h2) = &upload($in{'no'}); }

			# �Y�t�A�b�v���[�h�̏ꍇ
			if ($ext2) {
				# �g���q�ύX�̏ꍇ�A���t�@�C���͍폜
				if ($ext && $ext2 ne $ext) {
					unlink("$imgdir/$in{'no'}$ext");
				}
				# �V�Y�t�t�@�C�����
				($ext,$w,$h) = ($ext2,$w2,$h2);
			}
			$_ = "$no<>$reno<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$pw<>$in{'color'}<>$ext<>$w<>$h<>$chk<>\n";
		}
		push(@data,$_);
	}

	# �X�V
	unshift(@data,$top);
	seek(DAT, 0, 0);
	print DAT @data;
	truncate(DAT, tell(DAT));
	close(DAT);

	# ����
	&header;
	print <<EOM;
<div align="center">
�L���̏C�����������܂����B<br>
<form action="$admincgi" method="post">
<input type="hidden" name="pass" value="$in{'pass'}">
<input type="submit" value="�Ǘ���ʂɖ߂�">
</form>
</div>
EOM
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  �ߋ����O����
#-------------------------------------------------
sub past_make {
	local(@past) = @_;

	# �ߋ����O�t�@�C�������`
	local($count);
	open(NO,"+< $nofile") || &error("Open Error: $nofile");
	eval "flock(NO, 2);";
	$count = <NO>;

	# �ߋ����O�t�@�C����
	local($pastfile) = sprintf("%s/%04d.cgi", $pastdir,$count);

	# �ߋ����O���J��
	local($i,$flg,@data);
	open(IN,"$pastfile") || &error("Open Error: $pastfile");
	while (<IN>) {
		$i++;
		push(@data,$_);

		# �ő匏���𒴂���ƒ��f
		if ($i >= $pastmax) { $flg++; last; }
	}
	close(IN);

	# �ő匏�����I�[�o�[����Ǝ��t�@�C������������
	if ($flg) {
		# �J�E���g�t�@�C���X�V
		seek(NO, 0, 0);
		print NO ++$count;
		truncate(NO, tell(NO));

		# �V�ߋ����O�t�@�C������
		$pastfile = sprintf("%s/%04d.cgi", $pastdir,$count);
		open(LOG,"> $pastfile");
		close(LOG);
		chmod(0666, $pastfile);

		@data = @past;
	} else {
		unshift(@data,@past);
	}

	close(NO);

	# �ߋ����O���X�V
	open(LOG,"+< $pastfile") || &error("Open Error: $pastfile");
	eval "flock(LOG, 2);";
	seek(LOG, 0, 0);
	print LOG @data;
	truncate(LOG, tell(LOG));
	close(LOG);
}

#-------------------------------------------------
#  �t�H�[�����̓`�F�b�N
#-------------------------------------------------
sub form_check {
	# ���T�C�g����̃A�N�Z�X��r��
	if ($mode eq "regist" && $base_url) {
		$baseUrl =~ s/(\W)/\\$1/g;

		$ref = $ENV{'HTTP_REFERER'};
		$ref =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($ref && $ref !~ /$base_url/i) { &error("�s���ȃA�N�Z�X�ł�"); }
	}

	# method�v���p�e�B��POST����
	if ($ENV{'REQUEST_METHOD'} ne 'POST') { &error("�s���ȓ��e�ł�"); }

	# ���͍��ڂ̃`�F�b�N
	if ($in{'name'} eq "") { &error("���O�����͂���Ă��܂���"); }
	if ($in{'comment'} eq "") { &error("�R�����g�����͂���Ă��܂���"); }
	if ($in_email) {
		if ($in{'email'} eq "") { &error("�d���[�������͂���Ă��܂���"); }
		elsif ($in{'email'} !~ /^[\w\.\-]+\@[\w\.\-]+\.[a-zA-Z]{2,6}$/) {
			&error("�d���[���̓��͓��e���s���ł�");
		}
	}
	if ($in{'url'} eq "http://") { $in{'url'} = ""; }
}

#-------------------------------------------------
#  �摜�A�b�v���[�h
#-------------------------------------------------
sub upload {
	local($no) = @_;
	local($macbin,$fname,$flg,$upfile,$imgfile,$tail,$W,$W2,$H,$H2);

	# �摜����
	foreach (@in) {
		if (/(.*)Content-type:(.*)/i) { $tail = $2; }
		if (/(.*)filename="([^"]*)"/i) { $fname = $2; }
		if (/application\/x-macbinary/i) { $macbin = 1; }
	}
	$tail =~ s/\r//g;
	$tail =~ s/\n//g;

	# �t�@�C���`����F��
	if ($tail =~ /image\/gif/i && $gif) { $tail = ".gif"; $flg = 1; }
	if ($tail =~ /image\/p?jpeg/i && $jpeg) { $tail = ".jpg"; $flg = 1; }
	if ($tail =~ /image\/x-png/i && $png) { $tail = ".png"; $flg = 1; }
	if ($tail =~ /text\/plain/i && $text) { $tail = ".txt"; $flg = 1; }
	if ($tail =~ /lha/i && $lha) { $tail = ".lzh"; $flg = 1; }
	if ($tail =~ /zip/i && $zip) { $tail = ".zip"; $flg = 1; }
	if ($tail =~ /pdf/i && $pdf) { $tail = ".pdf"; $flg = 1; }
	if ($tail =~ /audio\/.*mid/i && $midi) { $tail = ".mid"; $flg = 1; }
	if ($tail =~ /msword/i && $word) { $tail = ".doc"; $flg = 1; }
	if ($tail =~ /ms-excel/i && $excel) { $tail = ".xls"; $flg = 1; }
	if ($tail =~ /ms-powerpoint/i && $ppt) { $tail = ".ppt"; $flg = 1; }
	if ($tail =~ /audio\/.*realaudio/i && $ram) { $tail = ".ram"; $flg = 1; }
	if ($tail =~ /application\/.*realmedia/i && $rm) { $tail = ".rm"; $flg = 1; }
	if ($tail =~ /video\/.*mpeg/i && $mpeg) { $tail = ".mpg"; $flg = 1; }
	if ($tail =~ /audio\/.*mpeg/i && $mp3) { $tail = ".mp3"; $flg = 1; }

	if (!$flg) {
		if ($fname =~ /\.gif$/i && $gif) { $tail = ".gif"; $flg = 1; }
		if ($fname =~ /\.jpe?g$/i && $jpeg) { $tail = ".jpg"; $flg = 1; }
		if ($fname =~ /\.png$/i && $png) { $tail = ".png"; $flg = 1; }
		if ($fname =~ /\.lzh$/i && $lha) { $tail = ".lzh"; $flg = 1; }
		if ($fname =~ /\.txt$/i && $text) { $tail = ".txt"; $flg = 1; }
		if ($fname =~ /\.zip$/i && $zip) { $tail = ".zip"; $flg = 1; }
		if ($fname =~ /\.pdf$/i && $pdf) { $tail = ".pdf"; $flg = 1; }
		if ($fname =~ /\.mid$/i && $midi) { $tail = ".mid"; $flg = 1; }
		if ($fname =~ /\.doc$/i && $word) { $tail = ".doc"; $flg = 1; }
		if ($fname =~ /\.xls$/i && $excel) { $tail = ".xls"; $flg = 1; }
		if ($fname =~ /\.ppt$/i && $ppt) { $tail = ".ppt"; $flg = 1; }
		if ($fname =~ /\.ram$/i && $ram) { $tail = ".ram"; $flg = 1; }
		if ($fname =~ /\.rm$/i && $rm) { $tail = ".rm"; $flg = 1; }
		if ($fname =~ /\.mpe?g$/i && $mpeg) { $tail = ".mpg"; $flg = 1; }
		if ($fname =~ /\.mp3$/i && $mp3) { $tail = ".mp3"; $flg = 1; }
	}

	# �A�b�v���[�h���s����
	if (!$flg || !$fname) {
		if (!$clip_err) { return; }
		else { &error("�A�b�v���[�h�ł��܂���"); }
	}

	$upfile = $in{'upfile'};

	# �}�b�N�o�C�i���΍�
	if ($macbin) {
		$length = substr($upfile,83,4);
		$length = unpack("%N",$length);
		$upfile = substr($upfile,128,$length);
	}

	# �Y�t�f�[�^����������
	$imgfile = "$imgdir/$no$tail";
	open(OUT,">$imgfile") || &error("�A�b�v���[�h���s");
	binmode(OUT);
	binmode(STDOUT);
	print OUT $upfile;
	close(OUT);

	chmod (0666, $imgfile);

	# �摜�T�C�Y�擾
	if ($tail eq ".jpg") { ($W, $H) = &JpegSize($imgfile); }
	elsif ($tail eq ".gif") { ($W, $H) = &GifSize($imgfile); }
	elsif ($tail eq ".png") { ($W, $H) = &PngSize($imgfile); }

	# �摜�\���k��
	if ($W > $MaxW || $H > $MaxH) {
		$W2 = $MaxW / $W;
		$H2 = $MaxH / $H;
		if ($W2 < $H2) { $key = $W2; }
		else { $key = $H2; }
		$W = int ($W * $key) || 1;
		$H = int ($H * $key) || 1;
	}

	return ($tail,$W,$H);
}

#-------------------------------------------------
#  JPEG�T�C�Y�F��
#-------------------------------------------------
sub JpegSize {
	local($jpeg) = @_;
	local($t, $m, $c, $l, $W, $H);

	open(JPEG,"$jpeg") || return (0,0);
	binmode JPEG;
	read(JPEG, $t, 2);
	while (1) {
		read(JPEG, $t, 4);
		($m, $c, $l) = unpack("a a n", $t);

		if ($m ne "\xFF") { $W = $H = 0; last; }
		elsif ((ord($c) >= 0xC0) && (ord($c) <= 0xC3)) {
			read(JPEG, $t, 5);
			($H, $W) = unpack("xnn", $t);
			last;
		}
		else {
			read(JPEG, $t, ($l - 2));
		}
	}
	close(JPEG);
	return ($W, $H);
}

#-------------------------------------------------
#  GIF�T�C�Y�F��
#-------------------------------------------------
sub GifSize {
	local($gif) = @_;
	local($data);

	open(GIF,"$gif") || return (0,0);
	binmode(GIF);
	sysread(GIF,$data,10);
	close(GIF);

	if ($data =~ /^GIF/) { $data = substr($data,-4); }

	$W = unpack("v",substr($data,0,2));
	$H = unpack("v",substr($data,2,2));
	return ($W, $H);
}

#-------------------------------------------------
#  PNG�T�C�Y�F��
#-------------------------------------------------
sub PngSize {
	local($png) = @_;
	local($data);

	open(PNG, "$png") || return (0,0);
	binmode(PNG);
	read(PNG, $data, 24);
	close(PNG);

	$W = unpack("N", substr($data, 16, 20));
	$H = unpack("N", substr($data, 20, 24));
	return ($W, $H);
}

#-------------------------------------------------
#  ���[�����M
#-------------------------------------------------
sub mail_to {
	local($mcom,$hp,$msub,$mbody);

	# ���[���^�C�g�����`
	$msub = &base64("[$title : $no] $in{'sub'}");

	# �L���𕜌�
	$mcom  = $in{'comment'};
	$mcom =~ s/<br>/\n/g;
	$mcom =~ s/&lt;/��/g;
	$mcom =~ s/&gt;/��/g;
	$mcom =~ s/&quot;/�h/g;
	$mcom =~ s/&amp;/��/g;

	# URL���
	if ($in{'url'}) { $hp = "http://$in{'url'}"; }
	else { $hp = ""; }

	# ���[���{�����`
	$mbody = <<EOM;
���e�����F$date
�z�X�g���F$host
�u���E�U�F$ENV{'HTTP_USER_AGENT'}

���e�Җ��F$in{'name'}
�d���[���F$in{'email'}
�t�q�k  �F$hp
�^�C�g���F$in{'sub'}

$mcom
EOM

	# ���[���A�h���X���Ȃ��ꍇ�͊Ǘ��҃��[���ɒu������
	if ($in{'email'} eq "") { $email = $mailto; }
	else { $email = $in{'email'}; }

	open(MAIL,"| $sendmail -t -i") || &error("���M���s");
	print MAIL "To: $mailto\n";
	print MAIL "From: $email\n";
	print MAIL "Subject: $msub\n";
	print MAIL "MIME-Version: 1.0\n";
	print MAIL "Content-type: text/plain; charset=ISO-2022-JP\n";
	print MAIL "Content-Transfer-Encoding: 7bit\n";
	print MAIL "X-Mailer: $ver\n\n";
	foreach ( split(/\n/, $mbody) ) {
		&jcode'convert(*_, 'jis', 'sjis');
		print MAIL $_, "\n";
	}
	close(MAIL);
}

#-------------------------------------------------
#  BASE64�ϊ�
#-------------------------------------------------
#	�Ƃقق�WWW����Ō��J����Ă��郋�[�`����
#	�Q�l�ɂ��܂����B( http://www.tohoho-web.com/ )
sub base64 {
	local($sub) = @_;
	&jcode'convert(*sub, 'jis', 'sjis');

	$sub =~ s/\x1b\x28\x42/\x1b\x28\x4a/g;
	$sub = "=?iso-2022-jp?B?" . &b64enc($sub) . "?=";
	$sub;
}
sub b64enc {
	local($ch)="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	local($x, $y, $z, $i);
	$x = unpack("B*", $_[0]);
	for ($i=0; $y=substr($x,$i,6); $i+=6) {
		$z .= substr($ch, ord(pack("B*", "00" . $y)), 1);
		if (length($y) == 2) {
			$z .= "==";
		} elsif (length($y) == 4) {
			$z .= "=";
		}
	}
	$z;
}

#-------------------------------------------------
#  ���Ԏ擾
#-------------------------------------------------
sub get_time {
	$ENV{'TZ'} = "JST-9";
	$times = time;
	($min,$hour,$mday,$mon,$year,$wday) = (localtime($times))[1..6];
	@week = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

	# �����̃t�H�[�}�b�g
	$date = sprintf("%04d/%02d/%02d(%s) %02d:%02d",
			$year+1900,$mon+1,$mday,$week[$wday],$hour,$min);
}

#-------------------------------------------------
#  �p�X���[�h�Í�
#-------------------------------------------------
sub encrypt {
	local($inp) = shift;
	local($salt, $crypt, @char);

	# ��╶������`
	@char = ('a'..'z', 'A'..'Z', '0'..'9', '.', '/');

	# �����Ŏ�𒊏o
	srand;
	$salt = $char[int(rand(@char))] . $char[int(rand(@char))];

	# �Í���
	$crypt = crypt($inp, $salt) || crypt ($inp, '$1$' . $salt);
	$crypt;
}

#-------------------------------------------------
#  �p�X���[�h�ƍ�
#-------------------------------------------------
sub decrypt {
	local($inp, $log) = @_;

	# �풊�o
	local($salt) = $log =~ /^\$1\$(.*)\$/ && $1 || substr($log, 0, 2);

	# �ƍ�
	if (crypt($inp, $salt) eq $log || crypt($inp, '$1$' . $salt) eq $log) {
		return (1);
	} else {
		return (0);
	}
}

#-------------------------------------------------
#  �������b�Z�[�W
#-------------------------------------------------
sub message {
	local($msg) = shift;

	&header;
	print <<EOM;
<div align="center">
<hr width="350">
<h3>$msg</h3>
<form action="$bbscgi">
<input type="submit" value="�f���֖߂�">
</form>
<hr width="350">
</div>
EOM
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  �֎~���[�h�`�F�b�N
#-------------------------------------------------
sub no_wd {
	local($flg);
	foreach ( split(/,/, $no_wd) ) {
		if (index("$in{'name'} $in{'sub'} $in{'comment'}",$_) >= 0) {
			$flg = 1; last;
		}
	}
	if ($flg) { &error("�֎~���[�h���܂܂�Ă��܂�"); }
}

#-------------------------------------------------
#  ���{��`�F�b�N
#-------------------------------------------------
sub jp_wd {
	local($sub, $com, $mat1, $mat2, $code1, $code2);
	$sub = $in{'sub'};
	$com = $in{'comment'};
	if ($sub) {
		($mat1, $code1) = &jcode'getcode(*sub);
	}
	($mat2, $code2) = &jcode'getcode(*com);
	if ($code1 ne 'sjis' && $code2 ne 'sjis') {
		&error("�薼���̓R�����g�ɓ��{�ꂪ�܂܂�Ă��܂���");
	}
}

#-------------------------------------------------
#  URL���`�F�b�N
#-------------------------------------------------
sub urlnum {
	local($com) = $in{'comment'};
	local($num) = ($com =~ s|(https?://)|$1|ig);
	if ($num > $urlnum) {
		&error("�R�����g����URL�A�h���X�͍ő�$urlnum�܂łł�");
	}
}

