<?php
	// ���å���󳫻�
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>�桼����������ѹ� - Advanced Creators �������������</title>
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
	$name1 = $_POST["name1"];
	$nendo1 = $_POST["nendo1"];
	$pass1 = $_POST["pass1"];
	$regist1 = $_POST["regist1"];

	if (is_string($regist1) == true) {
		$act1 = 1;
	}
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_editFlag1"], "editFlag1");
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest(name1, "name1");
		showTest(nendo1, "nendo1");
		showTest(pass1, "pass1");
		showTest($regist1, "regist1");
		showTest($act1, "act1");
	}
	
	// �ǥե����
	$showFlag1 = true;

	 
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�����ɽ��
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<?php
	
	// act1
	if ($act1 != 1) {
		$showFlag1 = false;
	}
	
	// �����ͤ�Ƚ��
	if ($_SESSION["ae_userID1"] == "") {
		$showFlag1 = false;
	}
	$showFlag1 = checkInputText3($name1, "�桼����̾", 50, $showFlag1);
	$showFlag1 = checkInputText3($nendo1, "ǯ��", 2, $showFlag1);
	$showFlag1 = checkInputText3($pass1, "�ѥ����", 50, $showFlag1);
	
	if ($showFlag1 != true) {
		$_SESSION["ae_editFlag1"] = true;
	}

	// editFlag1��true����ʤ��Ȥ��Τ���Ͽ
	if ($_SESSION["ae_editFlag1"] != true) {
		// ������
		$query1 = "UPDATE `ae_user` SET `name` = '".$name1."', `pass` = '".$pass1."', `year` = '".$nendo1."' WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
		// �¹Ԥ��Ʒ�̤������
		mysql_query($query1);
		if (mysql_errno() != 0) {
			echo mysql_error();
			echo "<br>
			<div class=\"err1\">[���顼] ��Ͽ�Ǥ��ޤ���Ǥ�����</div>
			<br>
			<div class=\"align-c\">[���] �򲡤������Υڡ�������ꡢ���Ϥ���ľ���Ƥ���������<br><br>
			<form name=\"form1\" action=\"user_update_01.php\" method=\"post\">
				<input type=\"submit\" name=\"update1\" value=\"���\" class=\"btn1\">
			</form>";
		}
		else {
			// editFlag1��on
			$_SESSION["ae_editFlag1"] = true;

			// �ѹ�������������
			// ������
			$query2 = "SELECT * FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
			// �¹Ԥ��Ʒ�̤������
			$result2 = mysql_query($query2);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
			// ����˷�̤����
			$rec2 = mysql_fetch_array($result2,MYSQL_ASSOC);
			// �桼����̾�����
			$_SESSION["ae_name1"] = $rec2["name"];
			// ǯ�٤����
			$_SESSION["ae_nendo1"] = $rec2["year"];
			// �ѥ���ɤ����
			$_SESSION["ae_pass1"] = $rec2["pass"];

			// ��̤�ɽ��
			echo "<div class=\"p1\">�桼����������ѹ����ޤ����� [���] �򲡤��Ƥ���������
				<div class=\"submit2\">
					<hr>
					<form name=\"submit1\" action=\"user_info_01.php\" method=\"post\">
						<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
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
		<div class=\"align-c\">[���] �򲡤��ȥ桼������������ޤ���<br><br>
		<form name=\"submit1\" action=\"user_info_01.php\" method=\"post\">
			<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
		</form>";
	}
	

	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
		showTest($editFlag1, "editFlag1");
		showTest($query1, "query1");
		showTest($query2, "query2");
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