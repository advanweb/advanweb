<?php
	// ���å���󳫻�
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>�桼�������� - Advanced Creators �������������</title>
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


<div class="h1">�桼��������</div>
<div>
	���ߥ����󤷤Ƥ���桼�����Υ桼����̾��ǯ�٤�ɽ�����ޤ���<br>
	�����ξ����ѥ���ɤ��ѹ��򤹤�ˤ� [�桼����������ѹ�] �򡢤��Υ桼������������ˤ� [�桼�����κ��] �򲡤��Ƥ���������
</div>


<?php
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
		echo "<div>
			<table class=\"t1\" style=\"margin:20px;\">
				<tbody>
					<tr><th>����</th><th>������</th></tr>
					<tr><td>�桼����̾ :��</td><td>".$rec1["name"]."</td></tr>
					<tr><td>ǯ�� :��</td><td>".$rec1["year"]."</td></tr>
					<tr><td>�ѥ���� :��</td><td>(�ѥ���ɤ�ɽ������ޤ���)</td></tr>
				</tbody>
			</table>
			<div class=\"submit2\">
				<hr>
				<table>
					<tbody>
						<tr>
							<td>
								<form name=\"form1\" action=\"user_update_01.php\" method=\"post\">
									<input type=\"hidden\" name=\"name1\" value=\"".$rec1["name"]."\">
									<input type=\"hidden\" name=\"nendo1\" value=\"".$rec1["year"]."\">
									<input type=\"hidden\" name=\"pass1\" value=\"".$rec1["pass"]."\">
									<input type=\"submit\" name=\"update1\" value=\"�ѹ�\" class=\"btn2\">��
								</form>
							</td>
							<td>
								<form name=\"form2\" action=\"user_delete_01.php\" method=\"post\">
									<input type=\"hidden\" name=\"name1\" value=\"".$rec1["name"]."\">
									<input type=\"submit\" name=\"delete1\" value=\"���\" class=\"btn4\">
								</form>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>";
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
	echo showNavi("top_01.php");
	
	// �����ԥڡ���
	if ($_SESSION["ae_adminFlag1"] == true) {
		echo "<br>
		<div class=\"navi1\"><a href=\"admin_01.php\"><img src=\"img/btn_right_01.gif\" width=\"11\" height=\"11\">�����ԥڡ���</a></div>";
	}

	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($query1, "query1");
		showTest($rec1["name"], "name");
		showTest($rec1["year"], "year");
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