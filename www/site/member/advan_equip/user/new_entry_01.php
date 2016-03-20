<?php
	// セッション開始
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>新規ユーザー登録 - Advanced Creators 機材管理サイト</title>
<link rel="stylesheet" href="../css/main_1.css" type="text/css">
<style type="text/css">
<!--


-->
</style>
</head>
<body onLoad="document.form1.name1.focus()">


<?php
	// 外部phpファイルの読み込み
	// レイアウト用テンプレート
	require ("../layout/layout_temp_02.php");
	
	// 関数テンプレート
	require ("../prog/func_temp_01.php");


	// ログインチェック
	checkLogin(false);
	
	
	// newFlag1のデフォルト設定
	$_SESSION["ae_newFlag1"] = false;
	
	// 表示してみるテスト
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_newFlag1"], "newFlag1");
	}
	
	// レイアウト用テンプレートからヘッダーを表示
	echo $layout["only_main"].$layout["body"];
?>

<!-- ↓ここから本文↓ -->


<div class="h1">新規ユーザー登録</div>
<div>
	ユーザー登録をします。任意のユーザー名とパスワードを入力して、 [登録] を押してください。
</div>
<br>

<div class="p1" style="width:400px;">
	<div class="h2" style="color:#33aacc;">ユーザー情報入力</div>
	<form name="form1" action="new_conf_01.php" method="post">
		<table class="form1">
			<tbody>
				<tr>
					<td>希望のユーザー名 :　</td><td><input type="text" name="name1" size="30" value="<?php echo $_SESSION["ae_name1"];?>" class="tbox1"></td>
				</tr>
				<tr>
					<td>年度 (05、06など) :　</td><td><input type="text" name="nendo1" size="4" value="<?php echo $_SESSION["ae_nendo1"];?>" class="tbox1"></td>
				</tr>
				<tr>
					<td>希望のパスワード :　</td><td><input type="password" name="pass1" size="30" class="tbox1"></td>
				</tr>
				<tr>
					<td>希望のパスワード<br>(確認のためもう1度) :　</td><td><br><input type="password" name="pass2" size="30" class="tbox1"></td>
				</tr>
			</tbody>
		</table>
		<div class="submit1">
			<hr>
			<input type="submit" name="submit1" value="登録" class="btn2">　<input type="reset" name="reset1" value="リセット" class="btn1">
		</div>
	</form>
</div>

<?php
	// ナビゲーション表示
	echo showNavi("index.php");
?>


<!-- ↑ここまで本文↑ -->

<?php
	// レイアウト用テンプレートから本文終了〜全ワク終了を表示
	echo $layout["footer"];
?>


</body>
</html>