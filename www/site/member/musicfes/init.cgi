#��������������������������������������������������������������������
#��  JOYFUL NOTE v2.69 (2006/10/22)
#��  Copyright (c) KentWeb
#��  webmaster@kent-web.com
#��  http://www.kent-web.com/
#��������������������������������������������������������������������
$ver = 'JoyfulNote v2.69';
#��������������������������������������������������������������������
#�� [���ӎ���]
#�� 1. ���̃X�N���v�g�̓t���[�\�t�g�ł��B���̃X�N���v�g���g�p����
#��    �����Ȃ鑹�Q�ɑ΂��č�҂͈�؂̐ӔC�𕉂��܂���B
#�� 2. �ݒu�Ɋւ��鎿��̓T�|�[�g�f���ɂ��肢�������܂��B
#��    ���ڃ��[���ɂ�鎿��͈�؂��󂯂������Ă���܂���B
#�� 3. ���̃X�N���v�g�́Amethod=POST ��p�ł��B	
#�� 4. �����̃A�C�R���ŁA�ȉ��̃t�@�C���̒��쌠�҂͈ȉ��̂Ƃ���ł��B
#��    home.gif : mayuRin����
#��    clip.gif : �������ƃA�C�R���̕�������
#��������������������������������������������������������������������
#
# �y�t�@�C���\����z
#
#  public_html (�z�[���f�B���N�g��)
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
#  �ݒ荀��
#-------------------------------------------------

# ���C�u����
$jcode    = './lib/jcode.pl';
$cgi_lib  = './lib/cgi-lib.pl';
$regkeypl = './lib/registkey.pl';

# �^�C�g����
$title = "�G�k�f����";

# �^�C�g���̕����F
$t_color = "#ffffff";

# �^�C�g���̕����T�C�Y
$t_size = '26px';

# �{���̕����t�H���g
$face = '"MS UI Gothic", "�l�r �o�S�V�b�N", Osaka';

# �{���̕����T�C�Y
$b_size = '13px';

# �ǎ����w�肷��ꍇ�ihttp://����w��j
$bg = "";

# �w�i�F���w��
$bc = "#000000";

# �����F���w��
$tx = "#ffffff";

# �����N�F���w��
$lk = "#bbbbbb";	# ���K��
$vl = "#777777";	# �K���
$al = "#777777";	# �K�⒆

# �߂���URL (index.html�Ȃ�)�yURL�p�X�z
$homepage = "../";

# �ő�L���� (�e�L��+���X�L�����܂߂����j
$max = 100;

# �Ǘ��җp�}�X�^�p�X���[�h (�p�����łW�����ȓ�)
$pass = 'mg16/6fx';

# �ԐM�����Ɛe�L�����g�b�v�ֈړ� (0=no 1=yes)
$topsort = 0;

# �ԐM�ɂ��Y�t�@�\�������� (0=no 1=yes)
$res_clip = 1;

# �摜�ƋL���̈ʒu
#  1 : �摜�����B�L���͉E�����荞��
#  2 : �摜�����B�L���͉摜�̏�ɕ\���B
$imgpoint = 2;

# �^�C�g����GIF�摜���g�p���鎞 (http://����L�q)
$t_img = "";
$t_w = 180;	# GIF�摜�̕� (�s�N�Z��)
$t_h = 40;	#    �V    ���� (�s�N�Z��)

# �~�j�J�E���^�̐ݒu
# �� 0=no 1=�e�L�X�g 2=GIF�摜
$counter = 1;

# �~�j�J�E���^�̌���
$mini_fig = 6;

# �e�L�X�g�̂Ƃ��F�~�j�J�E���^�̐F
$cnt_color = "#ffffff";

# GIF�J�E���^�̂Ƃ��F�摜�܂ł̃f�B���N�g��
# �� �Ō�� / �ŕ��Ȃ�
$gif_path = "./img";
$mini_w = 8;		# �摜�̉��T�C�Y
$mini_h = 12;		# �摜�̏c�T�C�Y

# �J�E���^�t�@�C��
$cntfile = './data/count.dat';

# �{��CGI��URL�yURL�p�X�z
$bbscgi = './joyful.cgi';

# ����CGI��URL�yURL�p�X�z
$registcgi = './regist.cgi';

# �Ǘ�CGI��URL�yURL�p�X�z
$admincgi = './admin.cgi';

# ���O�t�@�C���y�T�[�o�p�X�z
$logfile = './data/joylog.cgi';

# �A�b�v���[�h�f�B���N�g���y�T�[�o�p�X�z
# �� �p�X�̍Ō�� / �����Ȃ�
$imgdir = './img';

# �A�b�v���[�h�f�B���N�g���yURL�p�X�z
# �� �p�X�̍Ō�� / �����Ȃ�
$imgurl = "./img";

# �Y�t�t�@�C���̃A�b�v���[�h�Ɏ��s�����Ƃ�
# 0 : �Y�t�t�@�C���͖������A�L���͎󗝂���
# 1 : �G���[�\�����ď����𒆒f����
$clip_err = 1;

# �L�� [�^�C�g��] ���̒��� (�S�p�������Z)
$sub_len = 15;

# ���[���A�h���X�̓��͕K�{ (0=no 1=yes)
$in_email = 0;

# �L���� [�^�C�g��] ���̐F
$subcol = "#ffffff";

# �L���\�����̉��n�̐F
$tbl_color = "#555555";

# ����IP�A�h���X����̘A�����e���ԁi�b���j
# �� �A�����e�Ȃǂ̍r�炵�΍�
# �� �l�� 0 �ɂ���Ƃ��̋@�\�͖����ɂȂ�܂�
$wait = 10;

# �P�y�[�W������̋L���\���� (�e�L��)
$pglog = 8;

# ���e������ƃ��[���ʒm���� (sendmail�K�{)
#  0 : �ʒm���Ȃ�
#  1 : �ʒm���邪�A�����̓��e�L���̓��[�����Ȃ��B
#  2 : �ʒm����B�����̓��e�L�����ʒm����B
$mailing = 0;

# ���[���A�h���X(���[���ʒm���鎞)
$mailto = 'xxx@xxx.xxx';

# sendmail�p�X�i���[���ʒm���鎞�j
$sendmail = '/usr/lib/sendmail';

# ���T�C�g���瓊�e�r�����Ɏw�� (http://���珑��)
$base_url = "";

# �����F�̐ݒ�i���p�X�y�[�X�ŋ�؂�j
$colors = '#FF66CC #99CCFF #99FFCC #FFFF99 #FF9966 #FFFFFF #CCCCFF #FF9999 #CCFF99';

# URL�̎��������N (0=no 1=yes)
$autolink = 1;

# �^�O�L���}���I�v�V����
# �� <!-- �㕔 --> <!-- ���� --> �̑���Ɂu�L���^�O�v��}������B
# �� �L���^�O�ȊO�ɁAMIDI�^�O �� LimeCounter���̃^�O�ɂ��g�p�\�ł��B
$banner1 = '<!-- �㕔 -->';	# �f���㕔�ɑ}��
$banner2 = '<!-- ���� -->';	# �f�������ɑ}��

# �z�X�g�擾���@
# 0 : gethostbyaddr�֐����g��Ȃ�
# 1 : gethostbyaddr�֐����g��
$gethostbyaddr = 0;

# �A�N�Z�X�����i���p�X�y�[�X�ŋ�؂�A�A�X�^���X�N�j
#  �� ���ۃz�X�g�����L�q�i�����v�j�y��z*.anonymizer.com
$deny_host = '';
#  �� ����IP�A�h���X���L�q�i�O����v�j�y��z210.12.345.*
$deny_addr = '';

# �֎~���[�h
# �� ���e���֎~���郏�[�h���R���}�ŋ�؂�
$no_wd = '';

# ���{��`�F�b�N�i���e�����{�ꂪ�܂܂�Ă��Ȃ���΋��ۂ���j
# 0=No  1=Yes
$jp_wd = 0;

# URL���`�F�b�N
# �� ���e�R�����g���Ɋ܂܂��URL���̍ő�l
$urlnum = 3;

# �A�b�v���[�h��������t�@�C���`��
#  0:no  1:yes
$gif   = 1;	# GIF�t�@�C��
$jpeg  = 1;	# JPEG�t�@�C��
$png   = 1;	# PNG�t�@�C��
$text  = 1;	# TEXT�t�@�C��
$lha   = 0;	# LHA�t�@�C��
$zip   = 1;	# ZIP�t�@�C��
$pdf   = 1;	# PDF�t�@�C��
$midi  = 1;	# MIDI�t�@�C��
$word  = 1;	# WORD�t�@�C��
$excel = 1;	# EXCEL�t�@�C��
$ppt   = 1;	# POWERPOINT�t�@�C��
$ram   = 0;	# RAM�t�@�C��
$rm    = 0;	# RM�t�@�C��
$mpeg  = 0;	# MPEG�t�@�C��
$mp3   = 0;	# MP3�t�@�C��

# ���e�󗝍ő�T�C�Y (bytes)
# �� �� : 102400 = 100KB
$maxdata = 2048000;

# �摜�t�@�C���̍ő�\���̑傫���i�P�ʁF�s�N�Z���j
# �� ����𒴂���摜�͏k���\�����܂�
$MaxW = 300;	# ����
$MaxH = 150;	# �c��

# �A�C�R���摜�t�@�C���� (�t�@�C�����̂�)
$IconClip = "clip.gif";  # �N���b�v
$IconSoon = "soon.gif";  # COMINIG SOON
$IconSoon_w = 88;
$IconSoon_h = 31;

# �ƃA�C�R���^�O
# �� �e�L�X�g�����ł���
$img_home = "<img src=\"$imgurl/home.gif\" border=\"0\" alt=\"�z�[���y�[�W\" align=\"top\">";

# �摜�Ǘ��҃`�F�b�N�@�\ (0=no 1=yes)
# �� �A�b�v���[�h�u�摜�v�͊Ǘ��҂��`�F�b�N���Ȃ��ƕ\������Ȃ��@�\�ł�
# �� �`�F�b�N�����܂Łu�摜�v�́uCOMING SOON�v�̃A�C�R�����\������܂�
$ImageCheck = 0;

# ���e��̏���
#  �� �f�����g��URL���L�q���Ă����ƁA���e�ナ���[�h���܂�
#  �� �u���E�U���ēǂݍ��݂��Ă���d���e����Ȃ��[�u�B
#  �� Location�w�b�_�̎g�p�\�ȃT�[�o�̂�
$location = '';

## --- <�ȉ��́u���e�L�[�v�@�\�i�X�p���΍�j���g�p����ꍇ�̐ݒ�ł�> --- ##
#
# ���e�L�[�̎g�p�i�X�p���΍�j
# �� 0=no 1=yes
$regist_key = 0;

# ���e�L�[�摜�����t�@�C���yURL�p�X�z
$registkeycgi = './registkey.cgi';

# ���e�L�[�Í��p�p�X���[�h�i�p�����łW�����j
$pcp_passwd = 'password';

# ���e�L�[���e���ԁi���P�ʁj
#   ���e�t�H�[����\�������Ă���A���ۂɑ��M�{�^�����������
#   �܂ł̉\���Ԃ𕪒P�ʂŎw��
$pcp_time = 30;

# ���e�L�[�摜�̑傫���i10�| or 12�|�j
# 10pt �� 10
# 12pt �� 12
$regkey_pt = 10;

# ���e�L�[�摜�̕����F
# �� $tx�ƍ��킹��ƈ�a�����Ȃ��B�ڗ�������ꍇ�� #dd0000 �ȂǁB
$moji_col = '#dd0000';

# ���e�L�[�摜�̔w�i�F
# �� $bc�ƍ��킹��ƈ�a�����Ȃ�
$back_col = '#FEF5DA';

## --- <�ȉ��́u�ߋ����O�v�@�\���g�p����ꍇ�̐ݒ�ł�> --- ##
#
# �ߋ����O����
# �� 0=no 1=yes
$pastkey = 0;

# �ߋ����O�pNO�t�@�C���y�T�[�o�p�X�z
$nofile  = './data/pastno.dat';

# �ߋ����O�̃f�B���N�g���y�T�[�o�p�X�z
# �� �p�X�̍Ō�� / �����Ȃ�
$pastdir = './past';

# �ߋ����O�P�t�@�C���̍s��
# �� ���̍s���𒴂���Ǝ��y�[�W�������������܂�
$pastmax = 600;

#-------------------------------------------------
#  �ݒ芮��
#-------------------------------------------------

#-------------------------------------------------
#  �A�N�Z�X����
#-------------------------------------------------
sub axscheck {
	# IP&�z�X�g�擾
	$host = $ENV{'REMOTE_HOST'};
	$addr = $ENV{'REMOTE_ADDR'};

	if ($gethostbyaddr && ($host eq "" || $host eq $addr)) {
		$host = gethostbyaddr(pack("C4", split(/\./, $addr)), 2);
	}

	# IP�`�F�b�N
	local($flg);
	foreach ( split(/\s+/, $deny_addr) ) {
		s/\./\\\./g;
		s/\*/\.\*/g;

		if ($addr =~ /^$_/i) { $flg = 1; last; }
	}
	if ($flg) {
		&error("�A�N�Z�X��������Ă��܂���");

	# �z�X�g�`�F�b�N
	} elsif ($host) {

		foreach ( split(/\s+/, $deny_host) ) {
			s/\./\\\./g;
			s/\*/\.\*/g;

			if ($host =~ /$_$/i) { $flg = 1; last; }
		}
		if ($flg) {
			&error("�A�N�Z�X��������Ă��܂���");
		}
	}
	if ($host eq "") { $host = $addr; }
}

#-------------------------------------------------
#  �t�H�[���f�R�[�h
#-------------------------------------------------
sub parse_form {
	undef(%in);
	&ReadParse;
	while ( local($key, $val) = each(%in) ) {

		next if ($key eq "upfile");

		# �V�t�gJIS�R�[�h�ϊ�
		&jcode'convert(*val, "sjis", "", "z");

		# �^�O����
		$val =~ s/&/&amp;/g;
		$val =~ s/"/&quot;/g;
		$val =~ s/</&lt;/g;
		$val =~ s/>/&gt;/g;

		# ���s����
		$val =~ s/\r\n/<br>/g;
		$val =~ s/\r/<br>/g;
		$val =~ s/\n/<br>/g;

		$in{$key} = $val;
	}
	$mode = $in{'mode'};
}

#-------------------------------------------------
#  �G���[����
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
#  HTML�w�b�_�[
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
#  �N�b�L�[���s
#-------------------------------------------------
sub set_cookie {
	local(@cook) = @_;
	local($gmt, $cook, @t, @m, @w);

	@t = gmtime(time + 60*24*60*60);
	@m = ('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	@w = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

	# ���ەW�������`
	$gmt = sprintf("%s, %02d-%s-%04d %02d:%02d:%02d GMT",
			$w[$t[6]], $t[3], $m[$t[4]], $t[5]+1900, $t[2], $t[1], $t[0]);

	# �ۑ��f�[�^��URL�G���R�[�h
	foreach (@cook) {
		s/(\W)/sprintf("%%%02X", unpack("C", $1))/eg;
		$cook .= "$_<>";
	}

	# �i�[
	print "Set-Cookie: JoyfulNote=$cook; expires=$gmt\n";
}

#-------------------------------------------------
#  �N�b�L�[�擾
#-------------------------------------------------
sub get_cookie {
	local($key, $val, *cook);

	# �N�b�L�[���擾
	$cook = $ENV{'HTTP_COOKIE'};

	# �Y��ID�����o��
	foreach ( split(/;/, $cook) ) {
		($key, $val) = split(/=/);
		$key =~ s/\s//g;
		$cook{$key} = $val;
	}

	# �f�[�^��URL�f�R�[�h���ĕ���
	foreach ( split(/<>/, $cook{'JoyfulNote'}) ) {
		s/%([0-9A-Fa-f][0-9A-Fa-f])/pack("C", hex($1))/eg;

		push(@cook,$_);
	}
	return @cook;
}

#-------------------------------------------------
#  ���e�t�H�[��
#-------------------------------------------------
sub bbs_form {
	local($type, $resmd) = @_;
	local($cnam,$ceml,$curl,$cpwd,$cico,$ccol);

	print <<EOM;
<blockquote>
<form action="$registcgi" method="post" enctype="multipart/form-data">
EOM

	## �t�H�[����ʂ𔻕�
	# �C��
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
	# �ԐM
	} elsif ($resmd) {
		print "<input type=\"hidden\" name=\"mode\" value=\"regist\">\n";
		print "<input type=\"hidden\" name=\"reno\" value=\"$resfm\">\n";

		($cnam,$ceml,$curl,$cpwd,$cico,$ccol) = &get_cookie;
	# �V�K
	} else {
		print "<input type=\"hidden\" name=\"mode\" value=\"regist\">\n";

		($cnam,$ceml,$curl,$cpwd,$cico,$ccol) = &get_cookie;
	}
	if (!$curl) { $curl = 'http://'; }

	print <<EOM;
<table border="0" cellspacing="0">
<tr>
  <td nowrap><b>���Ȃ܂�</b></td>
  <td><input type="text" name="name" size="28" value="$cnam"></td>
</tr>
<tr>
  <td nowrap><b>�d���[��</b></td>
  <td><input type="text" name="email" size="28" value="$ceml"></td>
</tr>
<tr>
  <td nowrap><b>�^�C�g��</b></td>
  <td nowrap>
    <input type="text" name="sub" size="36" value="$sub">
<input type="submit" value="���e����"><input type="reset" value="���Z�b�g">
  </td>
</tr>
<tr>
  <td colspan="2">
    <b>�R�����g</b><br>
    <textarea cols="56" rows="7" name="comment">$com</textarea>
  </td>
</tr>
<tr>
  <td nowrap><b>�Q��URL</b></td>
  <td><input type="text" size="50" name="url" value="$curl"></td>
</tr>
EOM

	# �Y�t�t�H�[��
	unless ($resmd && !$res_clip) {
		print "<tr><td><b>�Y�tFile</b></td>\n";
		print "<td><input type=\"file\" name=\"upfile\" size=\"40\">\n";

		# �Y�t
		if ($ext) {
			print "&nbsp;[<a href=\"$imgurl/$in{'no'}$ext\" target=\"_blank\">�Y�t</a>]\n";
			print "<input type=\"checkbox\" name=\"imgdel\" value=\"1\">�폜\n";
		}

		print "</td></tr>\n";
	}
	# �p�X���[�h��
	if ($type ne "edit" && $type ne "admin") {
		print "<tr><td nowrap><b>�Ï؃L�[</b></td>";
		print "<td><input type=\"password\" name=\"pwd\" size=\"8\" maxlength=\"8\" value=\"$cpwd\">\n";
		print "(�p������8�����ȓ�)</td></tr>\n";
	}
	# ���e�L�[
	if ($regist_key && ($type eq "normal" || $type eq "res")) {
		print "<tr><td nowrap><b>���e�L�[</b></td>";
		print "<td><input type=\"text\" name=\"regikey\" size=\"6\" style=\"ime-mode:inactive\" value=\"\">\n";
		print "�i���e�� <img src=\"$registkeycgi?$str_crypt\" align=\"absmiddle\" alt=\"���e�L�[\"> ����͂��Ă��������j</td></tr>\n";
		print "<input type=\"hidden\" name=\"str_crypt\" value=\"$str_crypt\">\n";
	}

	# �F�w��
	print "<tr><td nowrap><b>�����F</b></td><td>\n";
	@col = split(/\s+/, $colors);
	if ($ccol eq "") { $ccol = $col[0]; }
	foreach (@col) {
		if ($ccol eq $_) {
			print "<input type=\"radio\" name=\"color\" value=\"$_\" checked><font color=\"$_\">��</font>\n";
		} else {
			print "<input type=\"radio\" name=\"color\" value=\"$_\"><font color=\"$_\">��</font>\n";
		}
	}
	print "</td></tr></table></form>\n";
	if ($ImageCheck) {
		print "�E�摜�͊Ǘ��҂�������܂ŁuCOMING SOON�v�̃A�C�R�����\\������܂��B<br>\n";
	}
	print "</blockquote>\n";
}




1;

