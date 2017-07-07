<?php 
    session_start();
    include("en/connect.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Manage user : Reserve system of Monk's house</title>
	<?php
		if(($_SESSION["personID"] == "" or $_SESSION["personID"] == "unknow" ) AND $_SESSION["group"] == "admin")  {
	        echo "<script>alert(\"กรุณาเข้าสู่ระบบก่อน\")</script>";
	        echo "redirecting";
	        echo "<script>window.location = 'app/login.php'</script>";
	    }
	?>
	<h4>จัดการผู้ใช้</45>
	<form method="POST" action="manage_guest.php">
		<br />ค้าหา : <input type="text" name="search" placeholder="กรอกชื่อ">
		<input type="submit" value="ค้นหา">
	</form>
	<br /><hr>
	<table border="1">
		<?php
			$search = $_POST['search'];
			if(isset($search) && $search != "")
				$sql = "SELECT * FROM guest WHERE name = '$search' ORDER BY nation_ID limit 0, 30  ";
			else
				$sql = "SELECT * FROM guest ORDER BY nation_ID limit 0, 30  ";

			$result = mysql_query($sql) or die(mysql_error());
			echo "<tr>";
				echo "<td>เลขบัตรประจำตัวประชาชน</td>";
				echo "<td>ชื่อ</td>";
				echo "<td>สกุล</td>";
				echo "<td>วันเกิด</td>";
				echo "<td>เบอร์โทรศัพท์</td>";
				echo "<td>E-mail</td>";
				echo "<td>เพศ</td>";
				echo "<td>ระดับผู้ใช้</td>";
				echo "<td>การดำเนินการ</td>";
			echo "</tr>";
			while($dbarr = mysql_fetch_array($result)) {
				echo "<form action=\"en/_edit_guest.php\" method=\"POST\">";
					echo "<tr>";
						echo "<td><input type=\"text\" name=\"nation_ID\" value=\"$dbarr[0]\" ></td>";
						echo "<td><input type=\"text\" name=\"name\" value=\"$dbarr[1]\" size=\"12\"></td>";
						echo "<td><input type=\"text\" name=\"surname\" value=\"$dbarr[2]\" size=\"16\"></td>";
						echo "<td><input type=\"date\" name=\"dob\" value=\"$dbarr[3]\" ></td>";
						echo "<td><input type=\"text\" name=\"telno\" value=\"$dbarr[4]\" size=\"11\"></td>";

						$sql2 = "SELECT * FROM person WHERE nation_ID='$dbarr[0]'";
						$result2 = mysql_query($sql2) or die(mysql_error());
						$dbarr2 = mysql_fetch_array($result2);
						echo "<td><input type=\"email\" name=\"email\" value=\"".$dbarr2[3]."\" ></td>";
						echo "<td>";
							echo "<select name=\"Gender\" >";
								echo "<option value=\"$dbarr2[4]\">".$dbarr2[4]."</option>";
								if($dbarr2[4] == "ชาย")
									echo "<option value=\"หญิง\">หญิง</option>";
								else
									echo "<option value=\"ชาย\">ชาย</option>";
							echo "</select>";
						echo "</td>";
						echo "<td>";
							echo "<select name=\"Group\">";
								echo "<option value=\"$dbarr2[5]\">".$dbarr2[5]."</option>";
								if($dbarr2[5] == "user")
									echo "<option value=\"admin\">"."admin"."</option>";
								else
									echo "<option value=\"user\">"."user"."</option>";

							echo "</select>";
						echo "</td>";
						echo "<td><input type=\"submit\" name=\"submit\" value=\"ลบ\" ><input type=\"submit\" name=\"submit\" value=\"เปลี่ยนแปลง\" ></td>";
					echo "</tr>";
				echo "</form>";

			}
		?>
	</table>
	<br />
	<h4>เพิ่มผู้จอง</h4>
	<form action="en/_edit_guest.php" method="POST">
		<table>
			<tr>
				<td>เลขบัตรประจำตัวประชาชน</td>
				<td><input type="text" name="nation_ID" ></td>
			</tr>
			<tr>
				<td>ชื่อ</td>
				<td><input type="text" name="name" ></td>
			</tr>
			<tr>
				<td>สกุล</td>
				<td><input type="text" name="surname" ></td>
			</tr>
			<tr>
				<td>วันเกิด</td>
				<td><input type="date" name="dob" ></td>
			</tr>
			<tr>
				<td>เบอร์โทรศัพท์</td>
				<td><input type="text" name="telno" ></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="email" name="email" ></td>
			</tr>
			<tr>
				<td>เพศ</td>
				<td>
					<select name="Gender">
						<option value="ชาย">ชาย</option>
						<option value="หญิง">หญิง</option>
					</select>
				</td>
			</tr>
			<tr><td><hr></td></tr>
				<tr>
					<td>Username</td>
					<td><input type="text" name="username" ></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="text" name="password" ></td>
				<tr>
					<td>กลุ่มผู้ใช้</td>
					<td>
						<SELECT name="Group">
							<option value="user">ผู้จอง</option>
							<option value="admin">ผู้ดูแลระบบ</option>
						</SELECT>
					</td>
				</tr>
			<tr><td><hr></td></tr>

			<tr>
				<td><input type="submit" name="submit" value="เพิ่มผู้จอง"></td>
			</tr>
		</table>
	</form>
</head>
<body>

</body>
</html>