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
	$_SESSION["ae_pass2"] = $_POST["pass2"];
	$submit1 = $_POST["submit1"];

	if (is_string($submit1) == true) {
		$act1 = 1;
	}
	
	// ɽ�����Ƥߤ�ƥ���
	if ($_SESSION["ae_devFlag1"] == true) {
		showTest($_SESSION["ae_name1"], "name1");
		showTest($_SESSION["ae_nendo1"], "nendo1");
		showTest($_SESSION["ae_pass1"], "pass1");
		showTest($_SESSION["ae_pass2"], "pass2");
		showTest($submit1, "submit1");
		showTest($act1, "act1");
	}
	
	// �ǥե����
	$showFlag1 = true;

	 
	// �쥤�������ѥƥ�ץ졼�Ȥ���إå�����ɽ��
	echo $layout["only_main"].$layout["body"];
?>

<!-- ������������ʸ�� -->


<?php
	
	// act1��1�ΤȤ��Τ�
	if ($act1 == 1) {
		
		// �����ͤ�Ƚ��
		$showFlag1 = checkInputText3($_SESSION["ae_name1"], "�桼����̾", 50, $showFlag1);
		$showFlag1 = checkInputText3($_SESSION["ae_nendo1"], "ǯ��", 2, $showFlag1);
		$showFlag1 = checkInputText3($_SESSION["ae_pass1"], "�ѥ����", 50, $showFlag1);
		
		if ($_SESSION["ae_pass1"] != $_SESSION["ae_pass2"]) {
			echo "<div class=\"err1\">[���顼] �ѥ���ɤ���äƤ��ޤ���</div>";
			$showFlag1 = false;
		}
		
		
		// showFlag1��true�ΤȤ�ɽ��
		if ($showFlag1 == true) {
			// Ʊ��̾�����ʤ��������å�
			// ������
			$query1 = "SELECT * FROM `ae_user` WHERE `name` = '".$_SESSION["ae_name1"]."'";
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
			
			
			// HTMLɽ���Ѥ��Ѵ�
			$name2 = p($_SESSION["ae_name1"]);
			$nendo2 = p($_SESSION["ae_nendo1"]);
		}
		
		// showFlag1��true�ΤȤ�ɽ��
		if ($showFlag1 == true) {
			echo "<div class=\"h1\">���Ͼ����ǧ</div>
			<div>�ʲ������Ƥǿ����桼������Ͽ���ޤ����������� [��Ͽ] �򲡤��Ƥ���������<br>
			���Ƥ���������ˤ� [���] �򲡤��Ƥ���������</div>
			<div class=\"p1\" style=\"width:400px; text-align:center;\">
				<table class=\"t1\" style=\"margin-top:20px;\">
					<tbody>
						<tr><th>����</th><th>������</th></tr>
						<tr><td>�桼����̾ :��</td><td>".$name2."</td></tr>
						<tr><td>ǯ�� :��</td><td>".$nendo2."</td></tr>
						<tr><td>�ѥ���� :��</td><td>(�ѥ���ɤ�ɽ������ޤ���)</td></tr>
					</tbody>
				</table>
				<div class=\"submit2\">
					<hr>
					<table>
						<tbody>
							<tr>
								<td>
									<form name=\"form1\" action=\"new_result_01.php\" method=\"post\">
										<input type=\"hidden\" name=\"name1\" value=\"".$_SESSION["ae_name1"]."\">
										<input type=\"hidden\" name=\"nendo1\" value=\"".$_SESSION["ae_nendo1"]."\">
										<input type=\"hidden\" name=\"pass1\" value=\"".$_SESSION["ae_pass1"]."\">
										<input type=\"submit\" name=\"regist1\" value=\"��Ͽ\" class=\"btn4\">��
									</form>
								</td>
								<td>
									<form name=\"form2\" action=\"new_entry_01.php\" method=\"post\">
										<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>";
		}
		
		// ���顼�ΤȤ�
		else {
			echo "<br>
			<div class=\"p1\" style=\"width:400px; text-align:center;\">
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
					<form name=\"form2\" action=\"new_entry_01.php\" method=\"post\">
						<input type=\"submit\" name=\"return1\" value=\"���\" class=\"btn1\">
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
			<form name=\"form2\" action=\"new_entry_01.php\" method=\"post\">
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