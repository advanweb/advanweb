#!/usr/bin/perl

###############################################
#   sche18.cgi
#      V2.0 (2004.9.22)
#                     Copyright(C) CGI-design
###############################################

$script = 'sche18.cgi';
$base = './schedata';				#データ格納ディレクトリ
$nofile = "$base/no.txt";			#記事番号
$opfile = "$base/option.txt";		#オプション

@week = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
@mdays = (31,28,31,30,31,30,31,31,30,31,30,31);
@month = ('January','February','March','April','May','June','July','August','September','October','November','December');

open (IN,"$opfile") || &error("OPEN ERROR");	$opdata = <IN>;		close IN;
if (!$opdata) {
	$pass = &crypt('cgi');
	chmod(0666,$opfile);	open (OUT,">$opfile") || &error("OPEN ERROR");
	print OUT "$pass<>Schedule<><><>#000000<>#FFFFFF<>#FFFFFF<>#aaaaaa<>#ffffff<>#eeeeee<>#c00000<>#4169e1<>#fef5da<>#ffd700";
	close OUT;
	chmod(0666,$nofile);
}

##### メイン処理 #####
if ($ENV{'REQUEST_METHOD'} eq "POST") {read(STDIN,$in,$ENV{'CONTENT_LENGTH'});} else {$in = $ENV{'QUERY_STRING'};}
foreach (split(/&/,$in)) {
	($n,$val) = split(/=/);
	$val =~ tr/+/ /;
	$val =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$in{$n} = $val;
}
$mode = $in{'mode'};

open (IN,"$opfile") || &error("OPEN ERROR");
($pass,$title,$home,$bg_img,$bg_color,$text_color,$title_color,$frame_color,$combg_color,$subbg_color,$holi_color,$sat_color,$sche_color,$today_color) = split(/<>/,<IN>);
close IN;
@wcolor = ($holi_color,$text_color,$text_color,$text_color,$text_color,$text_color,$sat_color);

($sec,$min,$hour,$nowday,$nowmon,$nowyear) = localtime;
$nowyear += 1900;
$nowmon++;

$logyear = $in{'year'};
$logmon = $in{'mon'};
if (!$logyear) {$logyear = $nowyear; $logmon = $nowmon;}
$logfile = "$base/$logyear$logmon.txt";

if ($mode eq 'admin') {&admin;} else {&main;}

print "</center></body></html>\n";
exit;

###
sub header {
	print "Content-type: text/html\n\n";
	print "<html><head><META HTTP-EQUIV=\"Content-type\" CONTENT=\"text/html; charset=Shift_JIS\">\n";
	print "<title>$title</title><link rel=\"stylesheet\" type=\"text/css\" href=\"$base/style.css\"></head>\n";
	$head = 1;
}

###
sub main {
	&header;
	print "<body background=\"$bg_img\" bgcolor=\"$bg_color\" text=\"$text_color\"><center>\n";
	print "<table width=98% cellpadding=0 cellspacing=0><tr>";
	if ($home) {print "<td><a href=\"$home\">HOME</a></td>";}
	print "<td align=right>| <a href=\"$script?mode=admin\">編集</a> |</td></tr></table>\n";
	&dsp;
	# 次の行は著作権表示ですので削除しないで下さい。#
	print "<a href=\"http://merlion.cool.ne.jp/cgi/\" target=\"_blank\">CGI-design</a>\n";
}

###
sub dsp {
	@data=@logno=();
	if (-e $logfile) {
		open (IN,"$logfile") || &error("OPEN ERROR");
		while (<IN>) {
			push (@data,$_);
			($no,$day) = split(/<>/);
			if (!$logno[$day]) {$logno[$day] = $no;}
		}
		close IN;
	}
	$mdays = $mdays[$logmon - 1];
	if ($logmon == 2 && $logyear % 4 == 0) {$mdays = 29;}

	print "<table cellspacing=0 cellpadding=0><tr valign=top>\n";
	print "<td><font size=\"+1\" color=\"#aaaaaa\"><b>$logyear</b></font>&nbsp;</font></td><td align=center>\n";
	$mon = $logmon - 1;
	if ($mon < 1) {$mon = 12; $year = $logyear - 1;} else {$year = $logyear;}
	if ($mode eq 'admin') {
		print "<table cellpadding=0><tr><td><form action=\"$script\" method=\"POST\">\n";
		print "<input type=hidden name=mode value=\"admin\">\n";
		print "<input type=hidden name=pass value=\"$inpass\">\n";
		print "<input type=hidden name=year value=\"$year\">\n";
		print "<input type=hidden name=mon value=\"$mon\">\n";
		print "<input type=submit value=\"LAST\"></td></form><td>\n";
	} else {
		print "<a href=\"$script?year=$year&mon=$mon\">&lt;&lt; LAST</a>";
	}
	print "　<font size=\"+2\" color=\"#aaaaaa\"><b>$logmon</b></font> <font color=\"#aaaaaa\">$month[$logmon - 1]</font>";
	$mon = $logmon + 1;
	if (12 < $mon) {$mon = 1; $year = $logyear + 1;} else {$year = $logyear;}
	if ($mode eq 'admin') {
		print "</td><td><form action=\"$script\" method=\"POST\">\n";
		print "<input type=hidden name=mode value=\"admin\">\n";
		print "<input type=hidden name=pass value=\"$inpass\">\n";
		print "<input type=hidden name=year value=\"$year\">\n";
		print "<input type=hidden name=mon value=\"$mon\">\n";
		print "　<input type=submit value=\"NEXT\"></td></form></tr></table>\n";
	} else {
		print "　<a href=\"$script?year=$year&mon=$mon\">NEXT &gt;&gt;</a>\n";
	}
	print "<table bgcolor=\"$combg_color\" bordercolor=\"$frame_color\" border=1 cellspacing=0 cellpadding=4 style=\"border-collapse: collapse\"><col span=7 align=center><tr bgcolor=\"$subbg_color\">\n";
	for (0 .. 6) {print "<td width=22><font color=\"$wcolor[$_]\">$week[$_]</font></td>\n";}
	print "</tr>\n";

	&holi_set;
	$wday = &get_date($logyear,$logmon,1);
	$w=$n=0;
	$k=1;
	for (0 .. 41) {
		if (!$w) {print "<tr>";}
		if ($wday <= $_ && $k <= $mdays) {
			if ($w == 1) {$n++;}
			$wcolor = $wcolor[$w];
			if (2002 < $logyear) {
				&get_holiday($logmon,$k,$w,$n);
				if ($holiday) {$wcolor = $holi_color;}
			}
			$dspday = "<font color=\"$wcolor\">$k</font>";
			if ($logno[$k]) {
				$bgcday = " bgcolor=\"$sche_color\"";
				$dspday = "<a href=\"\#$logno[$k]\"><b>$dspday</b></a>";
			} else {$bgcday = '';}
			if ($logyear == $nowyear && $logmon == $nowmon && $k == $nowday) {$bgcday = " bgcolor=\"$today_color\"";}
			print "<td$bgcday>$dspday</td>\n";
			$k++;
		} else {print "<td></td>\n";}
		$w++;
		if ($w == 7) {
			print "</tr>\n";
			if ($mdays < $k) {last;}
			$w = 0;
		}
	}
	print "</table></td><td width=10></td><td>\n";
	print "<table width=430 bgcolor=\"$combg_color\" bordercolor=\"$frame_color\" border=1 cellspacing=0 cellpadding=1 style=\"border-collapse: collapse\">\n";
	foreach (@data) {
		($no,$day,$wday,$sub) = split(/<>/);
		if ($logyear == $nowyear && $logmon == $nowmon && $day == $nowday) {print "<tr bgcolor=\"$today_color\">";} else {print "<tr>";}
		print "<td width=80>　 $logmon.$day <font color=\"$wcolor[$wday]\">$week[$wday]</font></td><td>　<a href=\"\#$no\">$sub</a></td></tr>\n";
	}
	print "</table></td></tr></table><br>\n";
	foreach (@data) {
		($no,$day,$wday,$sub,$com) = split(/<>/);
		&dsp_log;
	}
}

###
sub dsp_log {
	$com =~ s/([^=^\"]|^)(http\:[\w\.\~\-\/\?\&\+\=\:\@\%\;\#\%]+)/$1<a href=\"$2\" target=\"_blank\">$2<\/a>/g;
	print "<a name=\"$no\"></a><table width=620 bgcolor=\"$frame_color\" cellspacing=1 cellpadding=0>\n";
	print "<tr><td bgcolor=\"$combg_color\" align=center><table width=100% bgcolor=\"$subbg_color\"><tr><td>&nbsp;&nbsp;$logyear.$logmon.$day <font color=\"$wcolor[$wday]\">$week[$wday]</font> 　　<b>$sub</b></td>\n";
	if ($mode eq 'admin') {
		print "<td align=right><form action=\"$script\" method=\"POST\">\n";
		print "<input type=hidden name=mode value=\"admin\">\n";
		print "<input type=hidden name=pass value=\"$inpass\">\n";
		print "<input type=hidden name=act value=\"edt\">\n";
		print "<input type=hidden name=no value=\"$no\">\n";
		print "<input type=hidden name=year value=\"$logyear\">\n";
		print "<input type=hidden name=mon value=\"$logmon\">\n";
		print "<input type=submit value=\"修正\"></td></form>\n";
	}
	print "</tr></table><table width=97% cellspacing=8 cellpadding=0><tr><td>$com</td></tr></table></td></tr></table>\n";
	print "<table width=600 cellpadding=0><tr><td align=right><a href=\"\#top\">▲top</a></td></tr></table>\n";
}

###
sub get_date {
	my($y,$m,$d) = @_;
	if ($m < 3){$y--; $m+=12;}
	return ($y+int($y/4)-int($y/100)+int($y/400)+int((13*$m+8)/5)+$d)%7;
}

###
sub holi_set {
	$def = 0.242194*($logyear-1980)-int(($logyear-1980)/4);
	$spr = int(20.8431+$def);
	$aut = int(23.2488+$def);
	%holi_d = ('0101','元日','0211','建国記念の日',"03$spr",'春分の日','0429','みどりの日','0503','憲法記念日','0505','こどもの日',"09$aut",'秋分の日','1103','文化の日','1123','勤労感謝の日','1223','天皇誕生日');
	%holi_w = ('012','成人の日','073','海の日','093','敬老の日','102','体育の日');
}

###
sub get_holiday {
	$sm = sprintf("%02d%02d",$_[0],$_[1]);
	$holiday = $holi_d{$sm};
	if ($sm eq '0504' && 1 < $_[2]) {$holiday = '国民の休日';}
	if ($holiday && !$_[2]) {$hflag = 1;}
	if (!$holiday && $_[2] == 1) {
		$smw = sprintf("%02d$_[3]",$_[0]);
		$holiday = $holi_w{$smw};
		if ($hflag) {$holiday = '振替休日'; $hflag = 0;}
	}
}

###
sub admin {
	&header;
	print "<body><center>\n";
	$inpass = $in{'pass'};
	if ($inpass eq '') {
		print "<table width=97%><tr><td><a href=\"$script\">[Return]</a></td></tr></table>\n";
		print "<br><br><br><br><h4>パスワードを入力して下さい</h4>\n";
		print "<form action=\"$script\" method=POST>\n";
		print "<input type=hidden name=mode value=\"admin\">\n";
		print "<input type=password name=pass size=10 maxlength=8>\n";
		print "<input type=submit value=\"認証\"></form>\n";
		print "</center></body></html>\n";
		exit;
	}
	$mat = &decrypt($inpass,$pass);
	if (!$mat) {&error("パスワードが違います");}

	print "<table width=95% bgcolor=\"#8c4600\"><tr><td>　<a href=\"$script\"><font color=\"#ffffff\"><b>Return</b></font></a></td>\n";
	print "<td align=right><form action=\"$script\" method=POST>\n";
	print "<input type=hidden name=mode value=\"admin\">\n";
	print "<input type=hidden name=pass value=\"$inpass\">\n";
	print "<input type=submit value=\"　編集　\">\n";
	print "<input type=submit name=set value=\"　設定　\"></td></form><td width=10></td></tr></table><br>\n";

	$act = $in{'act'};
	if ($in{'set'}) {&setup;} else {&edt;}
}

###
sub edt {
	if ($in{'newwrt'}) {&newwrt;}
	elsif ($in{'edtwrt'}) {&edtwrt;}
	elsif ($in{'delwrt'}) {&delwrt;}

	&in_form;
	print "<a name=\"top\"></a><hr width=90%>記事を修正・削除する場合は[修正]をクリックして下さい。<br><br>\n";
	&dsp;
}

###
sub in_form {
	print "<table bgcolor=\"#edefde\" cellspacing=8><tr><td><table cellspacing=2 cellpadding=0>\n";
	print "<form action=\"$script\" method=POST>\n";
	print "<input type=hidden name=mode value=\"admin\">\n";
	print "<input type=hidden name=pass value=\"$inpass\">\n";
	if (!$act) {
		print "<tr><td>日付</td><td><select name=year>\n";
		for (2004 .. $nowyear+1) {
			if ($_ == $nowyear) {$sel = ' selected';} else {$sel = '';}
			print "<option value=\"$_\"$sel>$_</option>\n";
		}
		print "</select>年 <select name=mon>\n";
		for (1 .. 12) {
			if ($_ == $nowmon) {$sel = ' selected';} else {$sel = '';}
			print "<option value=\"$_\"$sel>$_</option>\n";
		}
		print "</select>月 <select name=day>\n";
		for (1 .. 31) {
			if ($_ == $nowday) {$sel = ' selected';} else {$sel = '';}
			print "<option value=\"$_\"$sel>$_</option>\n";
		}
		print "</select>日</td></tr>\n";
		$sub=$com='';
	} else {
		print "<input type=hidden name=year value=\"$logyear\">\n";
		print "<input type=hidden name=mon value=\"$logmon\">\n";
		print "<input type=hidden name=no value=\"$in{'no'}\">\n";
		open (IN,"$logfile") || &error("OPEN ERROR");
		while (<IN>) {
			($no,$day,$wday,$sub,$com) = split(/<>/);
			if ($no eq $in{'no'}) {last;}
		}
		close IN;
		$com =~ s/<br>/\r/g;
		print "<tr><td>日付</td><td>&nbsp;<b>$logyear年$logmon月$day日<font color=\"$wcolor[$wday]\">($week[$wday])</font></b></td></tr>\n";
	}
	print "<tr><td>題名</td><td><input type=text name=sub size=50 value=\"$sub\"></td></tr>\n";
	print "<tr><td valign=top><br>内容</td><td><textarea cols=80 rows=20 name=com wrap=\"soft\">$com</textarea></td></tr>\n";
	print "<tr><td></td><td>";
	if (!$act) {print "<input type=submit name=newwrt value=\"登録する\">";}
	else {
		print "<table width=100% cellspacing=0 cellpadding=2><tr><td><input type=submit name=edtwrt value=\"修正する\"></td>\n";
		print "<td width=40 bgcolor=red align=center><input type=submit name=delwrt value=\"削除\"></td></tr></table>\n";
	}
	print "</td></tr></table></td></tr></table></form>\n";
}

###
sub newwrt {
	$in{'com'} =~ s/\r\n|\r|\n/<br>/g;
	$wday = &get_date($logyear,$logmon,$in{'day'});

	open (IN,"$nofile") || &error("OPEN ERROR"); 		$no = <IN>; 		close IN;
	$no++;
	open (OUT,">$nofile") || &error("OPEN ERROR");		print OUT $no;		close OUT;
	$newdata = "$no<>$in{'day'}<>$wday<>$in{'sub'}<>$in{'com'}<>\n";

	if (-e $logfile) {
		@new = ();
		$flag = 0;
		open (IN,"$logfile") || &error("OPEN ERROR");
		while (<IN>) {
			($no,$day) = split(/<>/);
			if (!$flag && $in{'day'} < $day) {push(@new,$newdata); $flag = 1;}
			push(@new,$_);
		}
		close IN;
		if (!$flag) {push(@new,$newdata);}
		open (OUT,">$logfile") || &error("OPEN ERROR");		print OUT @new;			close OUT;
	} else {
		open (OUT,">$logfile") || &error("OPEN ERROR");		print OUT $newdata;		close OUT;		chmod(0666,$logfile);
	}
}

###
sub edtwrt {
	$in{'com'} =~ s/\r\n|\r|\n/<br>/g;
	@new = ();
	open (IN,"$logfile") || &error("OPEN ERROR");
	while (<IN>) {
		($no,$day,$wday) = split(/<>/);
		if ($no eq $in{'no'}) {push(@new,"$no<>$day<>$wday<>$in{'sub'}<>$in{'com'}<>\n");} else {push(@new,$_);}
	}
	close IN;
	open (OUT,">$logfile") || &error("OPEN ERROR");		print OUT @new;		close OUT;
}

###
sub delwrt {
	@new = ();
	open (IN,"$logfile") || &error("OPEN ERROR");
	while (<IN>) {
		($no) = split(/<>/);
		if ($no ne $in{'no'}) {push(@new,$_);}
	}
	close IN;
	open (OUT,">$logfile") || &error("OPEN ERROR");		print OUT @new;		close OUT;
}

###
sub setup {
	if ($in{'wrt'}) {
		if ($in{'newpass'} ne '') {$pass = &crypt($in{'newpass'});}
		$title = $in{'title'};
		$home = $in{'home'};
		$bg_img = $in{'bg_img'};

		$bg_color = $in{'color0'};
		$text_color = $in{'color1'};
		$title_color = $in{'color2'};
		$frame_color = $in{'color3'};
		$combg_color = $in{'color4'};
		$subbg_color = $in{'color5'};
		$holi_color = $in{'color6'};
		$sat_color = $in{'color7'};
		$sche_color = $in{'color8'};
		$today_color = $in{'color9'};

		open (OUT,">$opfile") || &error("OPEN ERROR");
		print OUT "$pass<>$title<>$home<>$bg_img<>$bg_color<>$text_color<>$title_color<>$frame_color<>$combg_color<>$subbg_color<>$holi_color<>$sat_color<>$sche_color<>$today_color";
		close OUT;
	}

	print "<form action=\"$script\" method=\"POST\">\n";
	print "<input type=hidden name=mode value=\"admin\">\n";
	print "<input type=hidden name=pass value=\"$inpass\">\n";
	print "<input type=hidden name=set value=\"1\">\n";
	print "<input type=submit name=wrt value=\"設定する\"><br><br>\n";

	print "<table bgcolor=\"#dddddd\" cellspacing=10><tr><td><table cellspacing=1 cellpadding=0>\n";
	print "<tr><td><b>タイトル</b></td><td><input type=text name=title size=40 value=\"$title\"></td></tr>\n";
	print "<tr><td><b>ホームURL</b></td><td><input type=text size=60 name=home value=\"$home\"></td></tr>\n";
	print "<tr><td><b>壁紙</b></td><td><input type=text size=60 name=bg_img value=\"$bg_img\"></td></tr>\n";

	print "<tr><td></td><td><a href=\"$base/color.htm\" target=\"_blank\">カラーコード</a></td></tr>\n";
	@name = ('基本背景色','基本文字色','タイトル色','枠色','記事背景色','項目背景色','休日','土曜日','スケジュール日','本日');
	@data = ($bg_color,$text_color,$title_color,$frame_color,$combg_color,$subbg_color,$holi_color,$sat_color,$sche_color,$today_color);
	for (0 .. $#name) {
		print "<tr><td><b>$name[$_]</b></td><td><table cellspacing=0 cellpadding=0><tr>\n";
		print "<td><input type=text name=color$_ size=10 value=\"$data[$_]\"></td>\n";
		print "<td width=5></td><td width=80 bgcolor=\"$data[$_]\"></td></tr></table></td></tr>\n";
	}
	print "<tr><td><b>パスワード変更</b></td><td><input type=password name=newpass size=10 maxlength=8> （英数8文字以内）</td></tr>\n";
	print "</table></td></tr></table></form>\n";
}

###
sub crypt {
	@salt = ('a' .. 'z','A' .. 'Z','0' .. '9');
	srand;
	$salt = "$salt[int(rand($#salt))]$salt[int(rand($#salt))]";
	return crypt($_[0],$salt);
}

###
sub decrypt {
	$salt = $_[1] =~ /^\$1\$(.*)\$/ && $1 || substr($_[1],0,2);
	if (crypt($_[0],$salt) eq $_[1] || crypt($_[0],'$1$' . $salt) eq $_[1]) {return 1;}
	return 0;
}

###
sub error {
	if (!$head) {&header; print "<body><center>\n";}
	print "<br><br><br><br><h3>ERROR !!</h3><font color=red><b>$_[0]</b></font>\n";
	print "</center></body></html>\n";
	exit;
}
