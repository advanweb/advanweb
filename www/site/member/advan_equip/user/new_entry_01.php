<?php
	// ���å���󳫻�
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>�����桼������Ͽ - Advanced Creators �������������</title>
<link rel="stylesheet" href="../css/main_1.css" type="text/css">
<style type="text/css">
<!--


-->
</style>
</head>
<body onLoad="document.form1.name1.focus()">


<?php
	// ����php�ե�������ɤ߹���
	// �쥤�������ѥƥ�ץ졼��
	require ("../layout/layout_temp_02.php");
	
	// �ؿ��ƥ�ץ졼��
	require ("../prog/func_temp_01.php");


	// ����������å�
	checkLogin(false);
	
	
	// newFlag1�Υǥե��������
	$_SESSION["ae_newFlag1"] = false;
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_newFlag1"], "newFlag1");
	}
	
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�����ɽ��
	echo $layout["only_main"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<div class="h1">�����桼������Ͽ</div>
<div>
	�桼������Ͽ�򤷤ޤ���Ǥ�դΥ桼����̾�ȥѥ���ɤ����Ϥ��ơ� [��Ͽ] �򲡤��Ƥ���������
</div>
<br>

<div class="p1" style="width:400px;">
	<div class="h2" style="color:#33aacc;">�桼������������</div>
	<form name="form1" action="new_conf_01.php" method="post">
		<table class="form1">
			<tbody>
				<tr>
					<td>��˾�Υ桼����̾ :��</td><td><input type="text" name="name1" size="30" value="<?php echo $_SESSION["ae_name1"];?>" class="tbox1"></td>
				</tr>
				<tr>
					<td>ǯ�� (05��06�ʤ�) :��</td><td><input type="text" name="nendo1" size="4" value="<?php echo $_SESSION["ae_nendo1"];?>" class="tbox1"></td>
				</tr>
				<tr>
					<td>��˾�Υѥ���� :��</td><td><input type="password" name="pass1" size="30" class="tbox1"></td>
				</tr>
				<tr>
					<td>��˾�Υѥ����<br>(��ǧ�Τ���⤦1��) :��</td><td><br><input type="password" name="pass2" size="30" class="tbox1"></td>
				</tr>
			</tbody>
		</table>
		<div class="submit1">
			<hr>
			<input type="submit" name="submit1" value="��Ͽ" class="btn2">��<input type="reset" name="reset1" value="�ꥻ�å�" class="btn1">
		</div>
	</form>
</div>

<?php
	// �ʥӥ��������ɽ��
	echo showNavi("index.php");
?>


<!-- �������ޤ���ʸ�� -->

<?php
	// �쥤�������ѥƥ�ץ졼�Ȥ�����ʸ��λ�����說��λ��ɽ��
	echo $layout["footer"];
?>


</body>
</html>