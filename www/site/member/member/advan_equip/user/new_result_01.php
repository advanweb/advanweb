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
	checkLogin(false);
		
		
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
	$_SESSION["ae_name1"] = $_POST["name1"];
	$_SESSION["ae_nendo1"] = $_POST["nendo1"];
	$_SESSION["ae_pass1"] = $_POST["pass1"];
	$regist1 = $_POST["regist1"];

	if (is_string($regist1) == true) {
		$act1 = 1;
	}
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_newFlag1"], "newFlag1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($regist1, "regist1");
		showTest($act1, "act1");
	}
	
	// �ǥե����
	$showFlag1 = true;

	 
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�����ɽ��
	echo $layout["only_main"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<?php
	
	// act1
	if ($act1 != 1) {
		$showFlag1 = false;
	}
	
	// �����ͤ�Ƚ��
	$showFlag1 = checkInputText3($_SESSION["ae_name1"], "�桼����̾", 50, $showFlag1);
	$showFlag1 = checkInputText3($_SESSION["ae_nendo1"], "ǯ��", 2, $showFlag1);
	$showFlag1 = checkInputText3($_SESSION["ae_pass1"], "�ѥ����", 50, $showFlag1);
	
	if ($showFlag1 != true) {
		$_SESSION["ae_newFlag1"] = true;
	}

	// newFlag1��true����ʤ��Ȥ��Τ���Ͽ
	if ($_SESSION["ae_newFlag1"] != true) {
		// ������
		$query1 = "INSERT INTO `ae_user` ( `id` , `name` , `pass` , `year` ) VALUES (NULL , '".$_SESSION["ae_name1"]."', '".$_SESSION["ae_pass1"]."', '".$_SESSION["ae_nendo1"]."')";
		// �¹Ԥ��Ʒ�̤������
		mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			echo "<br>
			<div class=\"err1\">[���顼] ��Ͽ�Ǥ��ޤ���Ǥ�����</div>
			<br>
			<div class=\"align-c\">[���] �򲡤������Υڡ�������ꡢ���Ϥ���ľ���Ƥ���������<br><br>
			<a href=\"new_entry_01.php\" class=\"btn5\">���</a></div>";
		}
		else {
			// newFlag1��on
			$_SESSION["ae_newFlag1"] = true;
			// ��̤�ɽ��
			echo "<div class=\"p1\">�����桼������Ͽ���ޤ����� [������] �򲡤��ƥ����󤷤Ƥ���������
				<div class=\"submit2\">
					<hr>
					<form name=\"submit1\" action=\"top_01.php\" method=\"post\">
						<input type=\"hidden\" name=\"name1\" value=\"".$_SESSION["ae_name1"]."\">
						<input type=\"hidden\" name=\"pass1\" value=\"".$_SESSION["ae_pass1"]."\">
						<input type=\"submit\" name=\"login1\" value=\"������\" class=\"btn1\">
					</form>
				</div>
			</div>";
		}
	}
		
	// ���顼�ΤȤ�
	else {
		echo "<br>
		<div class=\"err1\">[���顼] Ϣ³��Ͽ���ɻߤ��뵡ǽ��Ư�������ᡢ��Ͽ�Ǥ��ޤ���Ǥ�����</div>
		<br>
		<div class=\"align-c\">[���] �򲡤��ȥ�����ڡ��������ޤ���<br><br>
		<form name=\"submit1\" action=\"index.php\" method=\"post\">
			<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
		</form>";
	}
	

	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
	}
	
?>


<!-- �������ޤ���ʸ�� -->

<?php
	// �쥤�������ѥƥ�ץ졼�Ȥ�����ʸ��λ�����說��λ��ɽ��
	echo $layout["footer"];

	// MySQL�����Ф��Ĥ���
	require ("../prog/db_close.php");
?>


</body>
</html>