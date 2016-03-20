#!/usr/bin/perl

#┌─────────────────────────────────
#│ JOYFUL NOTE
#│ regist.cgi - 2006/10/08
#│ Copyright (c) KentWeb
#│ webmaster@kent-web.com
#└─────────────────────────────────

# 外部ファイル取り込み
require './init.cgi';
require $jcode;
require $cgi_lib;
$cgi_lib'maxdata = $maxdata;

# 処理定義
&parse_form;
&axscheck;
if ($mode eq "regist") { &regist; }
elsif ($mode eq "user_dele") { &user_dele; }
elsif ($mode eq "user_edit") { &user_edit; }
elsif ($mode eq "admin") { &admin; }
&error("不明な処理です");

#-------------------------------------------------
#  投稿記事受付
#-------------------------------------------------
sub regist {
	local($top,$ango,$f,$match,$tail,$W,$H,@lines,@new,@tmp);

	# フォーム入力チェック
	&form_check;

	# 投稿キーチェック
	if ($regist_key) {
		require $regkeypl;

		if ($in{'regikey'} !~ /^\d{4}$/) {
			&error("投稿キーが入力不備です。<p>投稿フォームに戻って再読込み後、指定の数字を入力してください");
		}

		# 投稿キーチェック
		# -1 : キー不一致
		#  0 : 制限時間オーバー
		#  1 : キー一致
		local($chk) = &registkey_chk($in{'regikey'}, $in{'str_crypt'});
		if ($chk == 0) {
			&error("投稿キーが制限時間を超過しました。<p>投稿フォームに戻って再読込み後、指定の数字を再入力してください");
		} elsif ($chk == -1) {
			&error("投稿キーが不正です。<p>投稿フォームに戻って再読込み後、指定の数字を入力してください");
		}
	}

	# チェック
	if ($no_wd) { &no_wd; }
	if ($jp_wd) { &jp_wd; }
	if ($urlnum > 0) { &urlnum; }

	if ($in{'sub'} eq "") { $in{'sub'} = "無題"; }

	# 時間を取得
	&get_time;

	# クッキーを発行
	&set_cookie($in{'name'},$in{'email'},$in{'url'},$in{'pwd'},$in{'icon'},$in{'color'});

	# ログを開く
	local($top,@data);
	open(DAT,"+< $logfile") || &error("Open Error: $logfile");
	eval "flock(DAT, 2);";
	$top = <DAT>;

	# 記事NO処理
	local($no, $ip, $time2) = split(/<>/, $top);
	$no++;

	# 連続投稿チェック
	if ($addr eq $ip && $wait > $times - $time2) {
		close(DAT);
		&error("連続投稿はもうしばらく時間をおいて下さい");
	}

	# 削除キーを暗号化
	if ($in{'pwd'} ne "") { $ango = &encrypt($in{'pwd'}); }

	# アップロード
	local($ext,$w,$h);
	unless ($resmd && !$res_clip) {
		if ($in{'upfile'}) { ($ext,$w,$h) = &upload($no); }
	}

	# 親記事の場合
	if ($in{'reno'} eq "") {
		local($i,$stop);
		while (<DAT>) {
			local($no2,$reno2,$dat,$nam,$eml,$sub,$com,$url,$hos,$pw,$col,$ex2,$w2,$h2,$chk) = split(/<>/);
			$i++;
			if ($i > $max-1 && $reno2 eq "") { $stop = 1; }
			if (!$stop) {
				push(@data,$_);
			} else {
				# 過去ログ
				if ($pastkey) { push(@past,$_); }

				# 添付ファイルは削除
				if ($ex2) { unlink("$imgdir/$no2$ex2"); }
			}
		}
		unshift(@data,"$no<><>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
		unshift(@data,"$no<>$addr<>$times<>\n");

		# 過去ログ更新
		if (@past > 0) { &past_make(@past); }

	# レス記事：トップソートあり
	} elsif ($in{'reno'} && $topsort) {

		local($flg,$match,@tmp);
		while (<DAT>) {
			local($no2,$reno2,$dat,$nam,$eml,$sub,$com,$url,$hos,$pw,$col,$ex2,$w2,$h2,$chk) = split(/<>/);

			# 親記事あり
			if ($in{'reno'} == $no2) {
				if ($reno2) { $flg = 1; last; }
				$match = 1;
				push(@data,$_);

			# レス記事あり
			} elsif ($in{'reno'} == $reno2) {
				push(@data,$_);

			# 親記事の直下に置く
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
			&error("不正な返信要求です");
		}

		# 最初のレス記事のケース
		if ($match == 1) {
			push(@data,"$no<>$in{'reno'}<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
		}
		# レス記事１式をトップへ
		push(@data,@tmp);
		unshift(@data,"$no<>$addr<>$times<>\n");

	# レス記事：トップソートなし
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
			&error("不正な返信要求です");
		}

		if ($match == 1) {
			push(@data,"$no<>$in{'reno'}<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$ango<>$in{'color'}<>$ext<>$w<>$h<>0<>\n");
		}
		unshift(@data,"$no<>$addr<>$times<>\n");
	}

	# 更新
	seek(DAT, 0, 0);
	print DAT @data;
	truncate(DAT, tell(DAT));
	close(DAT);

	# メール処理
	if (($mailing == 1 && $in{'email'} ne $mailto) || ($mailing == 2)) { &mail_to; }

	# リロード
	if ($location) {
		if ($ENV{'PERLXS'} eq "PerlIS") {
			print "HTTP/1.0 302 Temporary Redirection\r\n";
			print "Content-type: text/html\n";
		}
		print "Location: $location?\n\n";
		exit;

	} else {
		&message("投稿は正常に処理されました");
	}
}

#-------------------------------------------------
#  ユーザ記事削除
#-------------------------------------------------
sub user_dele {
	if ($in{'no'} eq '' || $in{'pwd'} eq '') {
		&error("記事Noまたは削除キーが入力モレです");
	}

	local($top,$flg,$oya_flg,@data);
	open(DAT,"+< $logfile") || &error("Open Error : $logfile");
	eval "flock(DAT, 2);";
	$top = <DAT>;
	while (<DAT>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		# 該当記事
		if ($in{'no'} == $no) {
			$oya_flg = 1;
			$flg = 1;
			if ($pw eq '') {
				$flg = 2;
				last;
			}
			# 削除キーを照合
			if ( &decrypt($in{'pwd'},$pw) != 1 ) {
				$flg = 3;
				last;
			}
			# 添付ファイル削除
			if ($ext) { unlink("$imgdir/$no$ext"); }
			next;

		# 親記事を削除した場合はレス記事も削除
		} elsif ($oya_flg && $in{'no'} == $reno) {

			# 添付ファイル削除
			if ($ext) { unlink("$imgdir/$no$ext"); }
			next;
		}
		push(@data,$_);
	}
	if (!$flg) {
		close(DAT);
		&error("該当記事が見当たりません");
	} elsif ($flg == 2) {
		close(DAT);
		&error("該当記事には削除キーが設定されていません");
	} elsif ($flg == 3) {
		close(DAT);
		&error("削除キーが違います");
	}

	# 更新
	seek(DAT, 0, 0);
	print DAT $top;
	print DAT @data;
	truncate(DAT, tell(DAT));
	close(DAT);

	# 完了
	&message("記事を削除しました");
}

#-------------------------------------------------
#  記事修正処理
#-------------------------------------------------
sub user_edit {
	if ($in{'no'} eq '' || $in{'pwd'} eq '') {
		&error("記事Noまたは暗証キーが入力モレです");
	}

	# 実行
	if ($in{'job'} eq "edit") {

		# フォーム入力チェック
		&form_check;

		# チェック
		if ($no_wd) { &no_wd; }
		if ($jp_wd) { &jp_wd; }
		if ($urlnum > 0) { &urlnum; }

		if ($in{'sub'} eq "") { $in{'sub'} = "無題"; }

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
				# 削除キーを照合
				if ( &decrypt($in{'pwd'},$pw) != 1 ) {
					$flg = -2;
					last;
				}

				# アップロード
				unless ($resmd && !$res_clip) {
					if ($in{'upfile'}) {
						($ext2,$w2,$h2) = &upload($in{'no'});
					}
				}

				# 画像削除
				if ($in{'imgdel'}) {
					unlink("$imgdir/$in{'no'}$ext");
					$ext = $w = $h = '';
				}

				# 添付アップロードの場合
				if ($ext2) {
					# 拡張子変更の場合、旧ファイルは削除
					if ($ext && $ext2 ne $ext) {
						unlink("$imgdir/$in{'no'}$ext");
					}
					# 新添付ファイル情報
					($ext,$w,$h) = ($ext2,$w2,$h2);
				}
				$_ = "$no<>$reno<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$pw<>$in{'color'}<>$ext<>$w<>$h<>0<>\n";
			}
			push(@data,$_);
		}

		# 更新
		seek(DAT, 0, 0);
		print DAT $top;
		print DAT @data;
		truncate(DAT, tell(DAT));
		close(DAT);

		if ($flg < 1) { &error("不正な処理です"); }

		# 完了メッセージ
		&message("修正が完了しました");
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
			# 削除キーを照合
			if ( &decrypt($in{'pwd'},$pw) != 1 ) {
				$flg = -2;
			}
			last;
		}
	}
	close(IN);

	# 判定
	if (!$flg) {
		&error("該当記事が見当たりません");
	} elsif ($flg == -1) {
		&error("該当記事には削除キーが設定されていません");
	} elsif ($flg == -2) {
		&error("削除キーが違います");
	}

	# 改行復元
	$com =~ s/<br>/\n/g;

	# 修正フォーム
	&header;
	print <<EOM;
<form action="$bbscgi">
<input type="hidden" name="page" value="$page">
<input type="submit" value="&lt; 戻る">
</form>
<p>
▼変更する部分のみ修正して送信ボタンを押して下さい。<br>
EOM

	&bbs_form("edit", $resmd);

	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  管理者編集
#-------------------------------------------------
sub admin {
	if ($in{'pass'} ne $pass) { &error("パスワードが違います"); }

	if ($in{'url'} eq "http://") { $in{'url'} = ""; }

	# 修正
	local($top,@data);
	open(DAT,"+< $logfile") || &error("Open Error: $logfile");
	eval "flock(DAT, 2);";
	$top = <DAT>;
	while (<DAT>) {
		local($no,$reno,$date,$name,$eml,$sub,$com,$url,$host,$pw,$col,$ext,$w,$h,$chk) = split(/<>/);

		if ($in{'no'} == $no) {

			# 画像削除
			if ($in{'imgdel'}) {
				unlink("$imgdir/$in{'no'}$ext");
				$ext = $w = $h = '';
			}

			# アップロード
			local($ext2,$w2,$h2);
			if ($in{'upfile'}) { ($ext2,$w2,$h2) = &upload($in{'no'}); }

			# 添付アップロードの場合
			if ($ext2) {
				# 拡張子変更の場合、旧ファイルは削除
				if ($ext && $ext2 ne $ext) {
					unlink("$imgdir/$in{'no'}$ext");
				}
				# 新添付ファイル情報
				($ext,$w,$h) = ($ext2,$w2,$h2);
			}
			$_ = "$no<>$reno<>$date<>$in{'name'}<>$in{'email'}<>$in{'sub'}<>$in{'comment'}<>$in{'url'}<>$host<>$pw<>$in{'color'}<>$ext<>$w<>$h<>$chk<>\n";
		}
		push(@data,$_);
	}

	# 更新
	unshift(@data,$top);
	seek(DAT, 0, 0);
	print DAT @data;
	truncate(DAT, tell(DAT));
	close(DAT);

	# 完了
	&header;
	print <<EOM;
<div align="center">
記事の修正を完了しました。<br>
<form action="$admincgi" method="post">
<input type="hidden" name="pass" value="$in{'pass'}">
<input type="submit" value="管理画面に戻る">
</form>
</div>
EOM
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  過去ログ生成
#-------------------------------------------------
sub past_make {
	local(@past) = @_;

	# 過去ログファイル名を定義
	local($count);
	open(NO,"+< $nofile") || &error("Open Error: $nofile");
	eval "flock(NO, 2);";
	$count = <NO>;

	# 過去ログファイル名
	local($pastfile) = sprintf("%s/%04d.cgi", $pastdir,$count);

	# 過去ログを開く
	local($i,$flg,@data);
	open(IN,"$pastfile") || &error("Open Error: $pastfile");
	while (<IN>) {
		$i++;
		push(@data,$_);

		# 最大件数を超えると中断
		if ($i >= $pastmax) { $flg++; last; }
	}
	close(IN);

	# 最大件数をオーバーすると次ファイルを自動生成
	if ($flg) {
		# カウントファイル更新
		seek(NO, 0, 0);
		print NO ++$count;
		truncate(NO, tell(NO));

		# 新過去ログファイル生成
		$pastfile = sprintf("%s/%04d.cgi", $pastdir,$count);
		open(LOG,"> $pastfile");
		close(LOG);
		chmod(0666, $pastfile);

		@data = @past;
	} else {
		unshift(@data,@past);
	}

	close(NO);

	# 過去ログを更新
	open(LOG,"+< $pastfile") || &error("Open Error: $pastfile");
	eval "flock(LOG, 2);";
	seek(LOG, 0, 0);
	print LOG @data;
	truncate(LOG, tell(LOG));
	close(LOG);
}

#-------------------------------------------------
#  フォーム入力チェック
#-------------------------------------------------
sub form_check {
	# 他サイトからのアクセスを排除
	if ($mode eq "regist" && $base_url) {
		$baseUrl =~ s/(\W)/\\$1/g;

		$ref = $ENV{'HTTP_REFERER'};
		$ref =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($ref && $ref !~ /$base_url/i) { &error("不正なアクセスです"); }
	}

	# methodプロパティはPOST限定
	if ($ENV{'REQUEST_METHOD'} ne 'POST') { &error("不正な投稿です"); }

	# 入力項目のチェック
	if ($in{'name'} eq "") { &error("名前が入力されていません"); }
	if ($in{'comment'} eq "") { &error("コメントが入力されていません"); }
	if ($in_email) {
		if ($in{'email'} eq "") { &error("Ｅメールが入力されていません"); }
		elsif ($in{'email'} !~ /^[\w\.\-]+\@[\w\.\-]+\.[a-zA-Z]{2,6}$/) {
			&error("Ｅメールの入力内容が不正です");
		}
	}
	if ($in{'url'} eq "http://") { $in{'url'} = ""; }
}

#-------------------------------------------------
#  画像アップロード
#-------------------------------------------------
sub upload {
	local($no) = @_;
	local($macbin,$fname,$flg,$upfile,$imgfile,$tail,$W,$W2,$H,$H2);

	# 画像処理
	foreach (@in) {
		if (/(.*)Content-type:(.*)/i) { $tail = $2; }
		if (/(.*)filename="([^"]*)"/i) { $fname = $2; }
		if (/application\/x-macbinary/i) { $macbin = 1; }
	}
	$tail =~ s/\r//g;
	$tail =~ s/\n//g;

	# ファイル形式を認識
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

	# アップロード失敗処理
	if (!$flg || !$fname) {
		if (!$clip_err) { return; }
		else { &error("アップロードできません"); }
	}

	$upfile = $in{'upfile'};

	# マックバイナリ対策
	if ($macbin) {
		$length = substr($upfile,83,4);
		$length = unpack("%N",$length);
		$upfile = substr($upfile,128,$length);
	}

	# 添付データを書き込み
	$imgfile = "$imgdir/$no$tail";
	open(OUT,">$imgfile") || &error("アップロード失敗");
	binmode(OUT);
	binmode(STDOUT);
	print OUT $upfile;
	close(OUT);

	chmod (0666, $imgfile);

	# 画像サイズ取得
	if ($tail eq ".jpg") { ($W, $H) = &JpegSize($imgfile); }
	elsif ($tail eq ".gif") { ($W, $H) = &GifSize($imgfile); }
	elsif ($tail eq ".png") { ($W, $H) = &PngSize($imgfile); }

	# 画像表示縮小
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
#  JPEGサイズ認識
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
#  GIFサイズ認識
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
#  PNGサイズ認識
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
#  メール送信
#-------------------------------------------------
sub mail_to {
	local($mcom,$hp,$msub,$mbody);

	# メールタイトルを定義
	$msub = &base64("[$title : $no] $in{'sub'}");

	# 記事を復元
	$mcom  = $in{'comment'};
	$mcom =~ s/<br>/\n/g;
	$mcom =~ s/&lt;/＜/g;
	$mcom =~ s/&gt;/＞/g;
	$mcom =~ s/&quot;/”/g;
	$mcom =~ s/&amp;/＆/g;

	# URL情報
	if ($in{'url'}) { $hp = "http://$in{'url'}"; }
	else { $hp = ""; }

	# メール本文を定義
	$mbody = <<EOM;
投稿日時：$date
ホスト名：$host
ブラウザ：$ENV{'HTTP_USER_AGENT'}

投稿者名：$in{'name'}
Ｅメール：$in{'email'}
ＵＲＬ  ：$hp
タイトル：$in{'sub'}

$mcom
EOM

	# メールアドレスがない場合は管理者メールに置き換え
	if ($in{'email'} eq "") { $email = $mailto; }
	else { $email = $in{'email'}; }

	open(MAIL,"| $sendmail -t -i") || &error("送信失敗");
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
#  BASE64変換
#-------------------------------------------------
#	とほほのWWW入門で公開されているルーチンを
#	参考にしました。( http://www.tohoho-web.com/ )
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
#  時間取得
#-------------------------------------------------
sub get_time {
	$ENV{'TZ'} = "JST-9";
	$times = time;
	($min,$hour,$mday,$mon,$year,$wday) = (localtime($times))[1..6];
	@week = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

	# 日時のフォーマット
	$date = sprintf("%04d/%02d/%02d(%s) %02d:%02d",
			$year+1900,$mon+1,$mday,$week[$wday],$hour,$min);
}

#-------------------------------------------------
#  パスワード暗号
#-------------------------------------------------
sub encrypt {
	local($inp) = shift;
	local($salt, $crypt, @char);

	# 候補文字列を定義
	@char = ('a'..'z', 'A'..'Z', '0'..'9', '.', '/');

	# 乱数で種を抽出
	srand;
	$salt = $char[int(rand(@char))] . $char[int(rand(@char))];

	# 暗号化
	$crypt = crypt($inp, $salt) || crypt ($inp, '$1$' . $salt);
	$crypt;
}

#-------------------------------------------------
#  パスワード照合
#-------------------------------------------------
sub decrypt {
	local($inp, $log) = @_;

	# 種抽出
	local($salt) = $log =~ /^\$1\$(.*)\$/ && $1 || substr($log, 0, 2);

	# 照合
	if (crypt($inp, $salt) eq $log || crypt($inp, '$1$' . $salt) eq $log) {
		return (1);
	} else {
		return (0);
	}
}

#-------------------------------------------------
#  完了メッセージ
#-------------------------------------------------
sub message {
	local($msg) = shift;

	&header;
	print <<EOM;
<div align="center">
<hr width="350">
<h3>$msg</h3>
<form action="$bbscgi">
<input type="submit" value="掲示板へ戻る">
</form>
<hr width="350">
</div>
EOM
	print &HtmlBot;
	exit;
}

#-------------------------------------------------
#  禁止ワードチェック
#-------------------------------------------------
sub no_wd {
	local($flg);
	foreach ( split(/,/, $no_wd) ) {
		if (index("$in{'name'} $in{'sub'} $in{'comment'}",$_) >= 0) {
			$flg = 1; last;
		}
	}
	if ($flg) { &error("禁止ワードが含まれています"); }
}

#-------------------------------------------------
#  日本語チェック
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
		&error("題名又はコメントに日本語が含まれていません");
	}
}

#-------------------------------------------------
#  URL個数チェック
#-------------------------------------------------
sub urlnum {
	local($com) = $in{'comment'};
	local($num) = ($com =~ s|(https?://)|$1|ig);
	if ($num > $urlnum) {
		&error("コメント中のURLアドレスは最大$urlnum個までです");
	}
}

