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
	$pass2 = $_POST["pass2"];
	$option1 = $_POST["option1"];
	$oldpass1 = $_POST["oldpass1"];
	$submit1 = $_POST["submit1"];

	if (is_string($submit1) == true) {
		$act1 = 1;
	}
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_userID1"], "userID1");
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_loginFlag1"], "loginFlag1");
		showTest($name1, "name1");
		showTest($nendo1, "nendo1");
		showTest($pass1, "pass1");
		showTest($pass2, "pass2");
		showTest($option1, "option1");
		showTest($submit1, "submit1");
		showTest($oldpass1, "oldpass1");
		showTest($act1, "act1");
	}
	
	// �ǥե����
	$showFlag1 = true;

	 
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�����ɽ��
	echo $layout["header"].$layout["status"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<?php
	
	// act1��1�ΤȤ��Τ�
	if ($act1 == 1) {
		
		if ($_SESSION["ae_userID1"] == "") {
			$showFlag1 = false;
		}
		else {
			// �ѥ����ǧ��
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
			
			// �ѥ���ɤ��㤦�Ȥ����顼
			if ($oldpass1 != $rec2["pass"]) {
				echo "<div class=\"err1\">[���顼] �ѥ���ɤ���äƤ��ޤ���</div>";
				$showFlag1 = false;			
			}
	
			
			// �桼����̾���ѹ�����Ȥ�
			if ($name1 != $_SESSION["ae_name1"]) {
	
				// �����ͤ�Ƚ��
				$showFlag1 = checkInputText3($name1, "�桼����̾", 50, $showFlag1);
			
				// Ʊ��̾�����ʤ��������å�
				// ������
				$query1 = "SELECT * FROM `ae_user` WHERE `name` = '".$name1."'";
				// �¹Ԥ��Ʒ�̤������
				$result1 = mysql_query($query1);
				if (mysql_errno() != 0) {
					echo mysql_error();
					$showFlag1 = false;
				}
				// ��̤θĿ�
				$num1 = mysql_num_rows($result1);
				// �Ŀ���0�Ǥʤ��Ȥ����顼
				if ($num1 > 0) {
					echo "<div class=\"err1\">[���顼] Ʊ���桼����̾��¸�ߤ���Τǡ����Υ桼����̾�Ǥ���Ͽ�Ǥ��ޤ���</div>";
					$showFlag1 = false;
				}
			}
			
			// ǯ�٤��ѹ�����Ȥ�
			if ($nendo1 != $_SESSION["ae_nendo1"]) {
				
				// �����ͤ�Ƚ��
				$showFlag1 = checkInputText3($nendo1, "ǯ��", 2, $showFlag1);
			}
			
			// �ѥ���ɤ��ѹ�����Ȥ�
			if ($option1 == true) {
			
				// �����ͤ�Ƚ��
				$showFlag1 = checkInputText3($pass1, "�ѥ����", 50, $showFlag1);
				if ($pass1 != $pass2) {
					echo "<div class=\"err1\">[���顼] �������ѥ���ɤ����פ��Ƥ��ޤ���</div>";
					$showFlag1 = false;
				}
			}
			// �ѥ���ɤ��ѹ����ʤ��Ȥ�
			else {
				$pass1 = $_SESSION["ae_pass1"];
			}
					
			// HTMLɽ���Ѥ��Ѵ�
			$name2 = p($name1);
			$nendo2 = p($nendo1);
		}

		
		// showFlag1��true�ΤȤ�ɽ��
		if ($showFlag1 == true) {
			echo "<div class=\"h1\">���Ͼ����ǧ</div>
			<div>�桼���������ʲ������Ƥ��ѹ����ޤ����������� [�ѹ�] �򲡤��Ƥ���������<br>
			���Ƥ���������ˤ� [���] �򲡤��Ƥ���������</div>
			<div class=\"p1\">
				<div class=\"submit2\">
					<table class=\"t1\">
						<tbody>
							<tr><th>����</th><th>������</th></tr>
							<tr><td>�桼����̾ :��</td><td>".$name2."</td></tr>
							<tr><td>ǯ�� :��</td><td>".$nendo2."</td></tr>
							<tr><td>�ѥ���� :��</td><td>(�ѥ���ɤ�ɽ������ޤ���)</td></tr>
						</tbody>
					</table>
					<hr>
					<table>
						<tbody>
							<tr>
								<td>
									<form name=\"form1\" action=\"user_update_result_01.php\" method=\"post\">
										<input type=\"hidden\" name=\"name1\" value=\"".$name1."\">
										<input type=\"hidden\" name=\"nendo1\" value=\"".$nendo1."\">
										<input type=\"hidden\" name=\"pass1\" value=\"".$pass1."\">
										<input type=\"submit\" name=\"regist1\" value=\"�ѹ�\" class=\"btn4\">��
									</form>
								</td>
								<td>
									<form name=\"form2\" action=\"user_update_01.php\" method=\"post\">
										<input type=\"submit\" name=\"update1\" value=\"���\" class=\"btn1\">
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			";
		}
		
		// ���顼�ΤȤ�
		else {
			echo "<br>
			<div class=\"p1\">
				<div class=\"submit2\">
					<table class=\"t1\" style=\"margin:20px;\">
						<tbody>
							<tr><th>����</th><th>������</th></tr>
							<tr><td>�桼����̾ :��</td><td>".$name2."</td></tr>
							<tr><td>ǯ�� :��</td><td>".$nendo2."</td></tr>
							<tr><td>�ѥ���� :��</td><td>(�ѥ���ɤ�ɽ������ޤ���)</td></tr>
						</tbody>
					</table>
					<div>[���] �򲡤������Υڡ�������ꡢ���Ϥ���ľ���Ƥ���������</div>
					<div class=\"submit2\">
					<hr>
					<form name=\"form2\" action=\"user_update_01.php\" method=\"post\">
						<input type=\"submit\" name=\"update1\" value=\"���\" class=\"btn1\">
					</form>
				</div>
			</div>
			<br>
			<div class=\"align-c\">
			</div>";
		}
	}
	
	
	else {
		echo "<div class=\"err1\">[���顼] ���Ͼ����ɽ���Ǥ��ޤ���Ǥ�����</div>
		<div>[���] �򲡤������Ϥ���ľ���Ƥ���������</div>
		<div class=\"submit2\">
			<hr>
			<form name=\"form2\" action=\"user_update_01.php\" method=\"post\">
				<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
			</form>
		</div>";
	}
	
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($name2, "name2");
		showTest($nendo2, "nendo2");
		showTest($showFlag1, "showFlag1");
		showTest($query1, "query1");
		showTest($num1, "num1");
		showTest($query2, "query2");
		showTest($num2, "num2");
		showTest($rec2["pass"], "rec2[pass]");
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