<?php
	// ���å���󳫻�
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>�桼�����κ�� - Advanced Creators �������������</title>
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
		showTest($_SESSION["ae_deleteFlag1"], "deleteFlag1");
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
		$_SESSION["ae_deleteFlag1"] = true;
	}

	if ($showFlag1 != true) {
		$_SESSION["ae_deleteFlag1"] = true;
	}

	// deleteFlag1��true����ʤ��Ȥ��Τߺ��
	if ($_SESSION["ae_deleteFlag1"] != true) {

		// �ѥ����ǧ��
		// ������
		$query3 = "SELECT * FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
		// �¹Ԥ��Ʒ�̤������
		$result3 = mysql_query($query3);
		if (mysql_errno() != 0) {
			echo mysql_error();
			$showFlag1 = false;
		}
		// ����˷�̤����
		$rec3 = mysql_fetch_array($result3,MYSQL_ASSOC);
		
		// �ѥ���ɤ��㤦�Ȥ����顼
		if ($pass1 != $rec3["pass"]) {
			echo "<div class=\"err1\">[���顼] �ѥ���ɤ���äƤ��ޤ���</div>
			<div>[���] �򲡤������Υڡ�������ꡢ���Ϥ���ľ���Ƥ���������</div>
			<div class=\"submit2\">
				<hr>
				<form name=\"form2\" action=\"user_delete_01.php\" method=\"post\">
					<input type=\"submit\" name=\"delete1\" value=\"���\" class=\"btn1\">
				</form>
			</div>";
			$showFlag1 = false;			
		}
		
		// showFlag1��true�ΤȤ��Τ������
		if ($showFlag1 == true) {

			// ������
			$query1 = "DELETE FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
			// �¹Ԥ��Ʒ�̤������
			mysql_query($query1);
			if (mysql_errno() != 0) {
				echo mysql_error();
				echo "<br>
				<div class=\"err1\">[���顼] ����Ǥ��ޤ���Ǥ�����</div>
				<br>
				<div class=\"align-c\">[���] �򲡤��ȥ桼������������ޤ���<br><br>
				<form name=\"form1\" action=\"user_info_01.php\" method=\"post\">
					<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
				</form>";
			}
			else {
				// deleteFlag1��on
				$_SESSION["ae_deleteFlag1"] = true;
	
				// ��̤�ɽ��
				echo "<div class=\"p1\">�桼�����������ޤ����� [���] �򲡤��Ƥ���������
					<div class=\"submit2\">
						<hr>
						<form name=\"submit1\" action=\"index.php\" method=\"post\">
							<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
						</form>
					</div>
				</div>";
			}
		}
		
	}
		
	// ���顼�ΤȤ�
	else {
		echo "<br>
		<div class=\"err1\">[���顼] Ϣ³������ɻߤ��뵡ǽ��Ư�������ᡢ����Ǥ��ޤ���Ǥ�����</div>
		<br>
		<div class=\"align-c\">[���] �򲡤��ȥ桼������������ޤ���<br><br>
			<form name=\"submit1\" action=\"user_info_01.php\" method=\"post\">
				<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
			</form>
		</div>";
	}
	

	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($showFlag1, "showFlag1");
		showTest($editFlag1, "editFlag1");
		showTest($query1, "query1");
		showTest($query2, "query2");
		showTest($query3, "query3");
		showTest($rec3["pass"], "rec3[pass]");
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