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
<body onLoad="document.form1.name1.focus()">


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
	$update1 = $_POST["update1"];

	if (is_string($update1) == true) {
		$act1 = 1;
	}
	
	// editFlag1�Υǥե��������
	$_SESSION["ae_editFlag1"] = false;

	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_loginFlag1"], "loginFlag1");
		showTest($update1, "update1");
		showTest($act1, "act1");
	}

	// �ǥե����
	$showFlag1 = true;

	
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�������ʸ���Ϥ�ɽ��
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<div class="h1">�桼����������ѹ�</div>
<div>
	�桼����������ѹ����ޤ���<br>
	�ѹ����������ܤ˿�������������Ϥ��Ƥ���������<br>
	�ѥ���ɤ��ѹ�����Ȥ��ϡ� [�ѥ���ɤ��ѹ�����] �˥����å�������ơ��������ѥ���ɤ����Ϥ��Ƥ���������
</div>


<?php
	// act1 �桼���������ѹ�
	if ($act1 == 1) {
	
		if ($_SESSION["ae_userID1"] == "") {
			$showFlag1 = false;
		}
		else {
			// ���ߤΥ桼�����Υ쥳���ɤ����
			// ������
			$query1 = "SELECT * FROM `ae_user` WHERE `id` = ".$_SESSION["ae_userID1"]." LIMIT 1";
			// �¹Ԥ��Ʒ�̤������
			$result1 = mysql_query($query1);
			if (mysql_errno() != 0) {
				echo mysql_error();
				$showFlag1 = false;
			}
		}
			
		// showFlag1��true�ΤȤ��Τ�
		if ($showFlag1 == true) {
			// ����˷�̤����
			$rec1 = mysql_fetch_array($result1,MYSQL_ASSOC);
			// �쥳���ɤ�ɽ��
			echo "<div class=\"p1\">
				<form name=\"form1\" action=\"user_update_conf_01.php\" method=\"post\">
					<table class=\"form1\">
						<tbody>
							<tr><td style=\"width:10%;\"></td><td>�桼����̾ :��</td><td><input type=\"text\" name=\"name1\" size=\"30\" value=\"".$rec1["name"]."\" class=\"tbox1\"></td></tr>
							<tr><td></td><td>ǯ�� :��</td><td><input type=\"text\" name=\"nendo1\" size=\"4\" value=\"".$rec1["year"]."\" class=\"tbox1\"></td></tr>
							<tr><td style=\"height:20px;\"></td><td></td><td></td></tr>
							<tr><td colspan=\"3\"><input type=\"checkbox\" name=\"option1\" value=\"true\">�ѥ���ɤ��ѹ�����</td></tr>
							<tr><td style=\"height:10px;\"></td><td></td><td></td></tr>
							<tr><td style=\"width:10%;\"></td><td>�������ѥ���� :��</td><td><input type=\"password\" name=\"pass1\" size=\"30\" class=\"tbox1\"></td></tr>
							<tr><td></td><td>�������ѥ����<br>(��ǧ�Τ���⤦1��) :��</td><td><br><input type=\"password\" name=\"pass2\" size=\"30\" class=\"tbox1\"></td></tr>
						</tbody>
					</table>
					<div class=\"submit1\">
						<hr>
						<div>�ѹ�����ˤϡ����Υѥ���ɤ����Ϥ��� [�ѹ�] �򲡤��Ƥ���������</div>
						<input type=\"password\" name=\"oldpass1\" size=\"30\" class=\"tbox1\">��<input type=\"submit\" name=\"submit1\" value=\"�ѹ�\" class=\"btn2\">��<input type=\"reset\" name=\"reset1\" value=\"�ꥻ�å�\" class=\"btn1\">
					</div>
				</form>
			</div>";
		}
		
	}
	
	else {
		$showFlag1 = false;
	}
	
	// showFlag1���顼�λ�
	if ($showFlag1 != true) {		
		echo "<div class=\"err2\">
			<div class=\"err1\">[���顼] �桼���������ɽ���Ǥ��ޤ���Ǥ�����</div>
			<div>[���] �򲡤��ȥȥåץڡ��������ޤ���</div>
			<div class=\"submit2\">
				<hr>
				<form name=\"form2\" action=\"top_01.php\" method=\"post\">
					<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
				</form>
			</div>
		</div>";
	}

	// �ʥӥ��������ɽ��
	echo showNavi("user_info_01.php");

	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($query1, "query1");
		showTest($rec1["name"], "name");
		showTest($rec1["year"], "nendo");
		showTest($rec1["pass"], "pass");
		showTest($num1, "num1");
		showTest($showFlag1, "showFlag1");
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