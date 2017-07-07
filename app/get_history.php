<?php 
    session_start();
    include("en/connect.php");
    include("require_login.php");
    $personID = $_SESSION['personID'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ดูประวัติการจอง : Reserve system OF monk's house</title>
</head>
<body>
	<h4>ดูประวัติการจอง</h4>
	<table border="1" style="text-align : center;">
		<tr>
			<td>หมายเลขการจอง</td>
			<td>ผู้จอง</td>
			<td>วันที่จอง</td>
			<td>กุฏิที่จอง</td>
			<td>วันที่เข้าพัก</td>
			<td>ช่วงเวลาที่เข้าพัก</td>
			<td>วันที่ยกเลิกการพัก</td>
			<td>การดำเนินการ</td>
		</tr>
	<?php
		$sql = "SELECT * FROM Reserve WHERE personID = '$personID'";
		$result = mysql_query($sql) or die(mysql_error());
		while($dbarr = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td>".$dbarr[1]."</td>";
					echo "<td>".$dbarr[0]."</td>";
					echo "<td>".$dbarr[3]."</td>";
					echo "<td>".$dbarr[2]."</td>";
					echo "<td>".$dbarr[4]."</td>";
					if($dbarr[6] == 0)
						echo "<td>เช้า</td>";
					else if($dbarr[6] == 1)
						echo "<td>บ่าย</td>";
					echo "<td>".$dbarr[5]."</td>";
					echo "<td>";
						echo "<form name=\"oparation\" action=\"en/_do_history.php\" method=\"POST\">";
							echo "<input type=\"hidden\" name=\"r_id\" value=\"$dbarr[1]\">";
							echo "<input type=\"hidden\" name=\"r_name\" value=\"$dbarr[0]\">";
							echo "<input type=\"hidden\" name=\"r_date\" value=\"$dbarr[3]\">";
							echo "<input type=\"hidden\" name=\"r_house\" value=\"$dbarr[2]\">";
							echo "<input type=\"hidden\" name=\"r_cin\" value=\"$dbarr[4]\">";
							echo "<input type=\"hidden\" name=\"r_time\" value=\"$dbarr[6]\">";
							echo "<input type=\"hidden\" name=\"r_cout\" value=\"$dbarr[5]\">";


							echo "<input type=\"submit\" name=\"delete\" value=\"ลบ\">";
							echo "<input type=\"submit\" name=\"update\" value=\"แก้ไข\">";
						echo "</form>";
					echo "</td>";
				echo "</tr>";
		}


	?>
	</table>


</body>
</html>