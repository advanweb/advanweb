<?php
	// ���å���󳫻�
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>�����ԥڡ��� - Advanced Creators �������������</title>
<link rel="stylesheet" href="../css/main_1.css" type="text/css">
<style type="text/css">
<!--


-->
</style>
</head>
<body>


<?php
	// ����php�ե�������ɤ߹���
	// �쥤�������ѥƥ�ץ졼��
	require ("../layout/layout_temp_02.php");
	
	// �ؿ��ƥ�ץ졼��
	require ("../prog/func_temp_01.php");
	
	// �ǡ����١�����³
	require ("../prog/db_conn.php");
	
	
	// ����������å�
	checkLogin(true);

	
	// �ǡ����١�����³
	
	// MySQL�����Ф���³����
	$conn = mysql_connect($MySQL_host, $MySQL_user, $MySQL_pass);
	if (mysql_errno()!=0) {
		die("MySQL��³�˼��Ԥ��ޤ���<br>");	// �ץ����򤹤���λ������
	}else{
		mysql_query("SET NAMES ujis");	// ʸ�������ɤ�EUC-JP��Ȥ����
	}
			
	// �����ǡ����١���������
	mysql_select_db($MySQL_database);


	// �ѿ��μ���
	$submit1 = $_POST["submit1"];

	if (is_string($login1) == true) {
		$act1 = 1;
	}
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_loginFlag1"], "loginFlag1");
		showTest($submit1, "submit1");
		showTest($act1, "act1");
	}

	// �ǥե����
	$showFlag1 = true;

	
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�������ʸ���Ϥ�ɽ��
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<div class="h1">�����ԥڡ���</div>
<div>
	�����Ը��¤ǡ����̥桼�������񤭹����������ѹ��������������ꤷ�ޤ���
</div>


<!-- �������ޤ���ʸ�� -->

<?php
	// �쥤�������ѥƥ�ץ졼�Ȥ�����ʸ��λ�����說��λ��ɽ��
	echo $layout["footer"];

	// MySQL�����Ф��Ĥ���
	require ("../prog/db_close.php");
?>


</body>
</html>