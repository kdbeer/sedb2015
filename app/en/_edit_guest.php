<?php
	session_start();
	include("connect.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>_edit_guest : Reserve system of Monk's house</title>
</head>
<body>

<?php
    if(($_SESSION["personID"] == "" or $_SESSION["personID"] == "unknow" ) AND$_SESSION["group"] == "admin")  {
            echo "<script>alert(\"กรุณาเข้าสู่ระบบก่อน\")</script>";
            echo "redirecting";
            echo "<script>window.location = '../../app/login.php'</script>";
   	}

   	$admin = $_SESSION['personID'];
   	$$c_date = DATE("Y-m-d");

   	$submit = $_POST['submit'];
   	$nation_ID = $_POST['nation_ID'];
   	if($submit == "ลบ") {
   		$sql = "DELETE FROM guest WHERE nation_ID = '$nation_ID'";
   		$sql2 = "DELETE FROM person WHERE nation_id = '$nation_ID'";
   	} else {
   		$name = $_POST['name'];
   		$surname = $_POST['surname'];
   		$dob = $_POST['dob'];
   		$telno = $_POST['telno'];
   		$email = $_POST['email'];
   		$Gender = $_POST['Gender'];
   		$username = $_POST['username'];
   		$password = $_POST['password'];
   		$Group = $_POST['Group'];

   		if($submit == "เปลี่ยนแปลง") {
   			$sql = "UPDATE guest SET name = '$name', surname = '$surname', dob='$dob', telno='$telno' WHERE nation_ID='$nation_ID' ";
   			$sql2 = "UPDATE person SET  email='$email', Gender='$Gender' , priv='$Group' WHERE nation_id = '$nation_ID'";

   			$update_massage = "INSERT INTO massage VALUES('' ,'4', '0', '$nation_ID', '$admin', '$c_date')";
            mysql_query($update_massage) or die(mysql_error());
   		} else if ($submit == "เพิ่มผู้จอง") {
   			$sql = "INSERT INTO guest VALUES('$nation_ID', '$name', '$surname', '$dob', '$telno')";
   			$sql2 = "INSERT INTO person VALUES('$nation_ID', '$username', '$password', '$email', '$Gender', '$Group')";

   			$update_massage = "INSERT INTO massage VALUES('' ,'5', '0', '$nation_ID', '$admin', '$c_date')";
            mysql_query($update_massage) or die(mysql_error());
   		}
   	}

   	if($result = mysql_query($sql) && $result2 = mysql_query($sql2)) {
   			echo "<script>alert(\"กำเนินการเสร็จแล้ว\")</script>";
            echo "redirecting";
            echo "<script>window.location = '../../app/manage_guest.php'</script>";
   	} else {
   			echo "<script>alert(\"การจัดการข้อมูลล้มเหลว กรุณาลองใหม่อีกครั้งค่ะ\")</script>";
            echo "redirecting";
            echo "<script>window.location = '../../app/manage_guest.php'</script>";
   	}

?>
</body>
</html>