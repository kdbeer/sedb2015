<?php 
    session_start();
    include("en/connect.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>จัดการประเภทกุฏิ : Reserve system of Monk's house</title>
	<?php
      if(($_SESSION["personID"] == "" or $_SESSION["personID"] == "unknow" ) AND$_SESSION["group"] == "admin")  {
           echo "<script>alert(\"กรุณาเข้าสู่ระบบก่อน\")</script>";
           echo "redirecting";
           echo "<script>window.location = 'app/login.php'</script>";
       }
   	?>
   	<script src="js/jquery-2.1.4.min.js"></script>
   	<script>
		function header_page(str) {
			var con = confirm("ต้องการจะลบรายการนี้ ใช่ หรือ ไม่");
			if(con) {
				var url = "en/_del_house.php?"+"r_id="+str;
				window.location = url;
			}
		}
   	</script>
</head>
<body>
   <h4>จัดการผู้ใช้</45>
   <form method="POST" action="en/_edit_reserve">
      <br />ค้าหา : <input type="text" name="search" placeholder="กรอกชื่อ">
      <input type="button" name="submit_del" value="ค้นหา" onclick="header_page();">
   </form>

   <br />
   <hr>
   		<h3>เพิ่มกุฏิ</h3>
	   <form action="manage_house.php" method="POST">
	      <table>
	         <tr>
	            <td>หมายเลขกุฏิ</td>
	            <?php
	            	$query = "SELECT * FROM house ORDER BY house_Id DESC";
			   		$_get_id = mysql_query($query) or die(mysql_error());
			   		$h_id = mysql_fetch_array($_get_id);
			   		$h_id = $h_id[0] + 1;
	            ?>
	            <td><?php echo "<input type=\"text\" name=\"house_Id\" value=\"$h_id\" size=\"3\">"; ?></td>
	         </tr>
	         <tr>
	            <td>สถานะ</td>
	            <td><select name="status">
	            	<option value="valid">valid</option>
	            	<option value="invalid">invalid</option>
	            </select>
	            </td>
	         </tr>
	         <tr>
	            <td>ประเภท</td>
	            <td><select name="type">
	            	<option value="ชาย">ชาย</option>
	            	<option value="หญิง">หญิง</option>
	            </select>
	            </td>
	         </tr>
	         
	        
	         <tr>
	            <td><input type="submit" name="submit" value="เพิ่มกุฏินี้"></td>
	         </tr>
	      </table>
	   </form>
   <hr>
   <table border="1">
      <?php
         $search = $_POST['search'];
         if(isset($search) && $search != "")
            $sql = "SELECT * FROM guest WHERE name = '$search' ORDER BY nation_ID limit 0, 30  ";
         else
            $sql = "SELECT H.house_Id, H.status, H.type FROM house AS H";

         $result = mysql_query($sql) or die(mysql_error());
         echo "<tr>";
            echo "<td>หมายเลขกุฏิ</td>";
            echo "<td>สถานะ</td>";
            echo "<td>ประเภท</td>";
            echo "<td>การจองทั้งหมด</td>";
            echo "<td>การดำเนินการ</td>";
         echo "</tr>";
         while($dbarr = mysql_fetch_array($result)) {
            echo "<form action=\"en/_del_house.php\" method=\"POST\">";
               echo "<tr>";
                  echo "<td><input type=\"text\" name=\"r_id\" value=\"$dbarr[0]\" size=\"16\"></td>";
                  echo "<td><input type=\"text\" name=\"p_name\" value=\"$dbarr[1]\" ></td>";
                  echo "<td><input type=\"text\" name=\"r_date\" value=\"$dbarr[2]\" size=\"11\"></td>";

                  $sql3 = "SELECT COUNT(r_id) FROM reserve WHERE house_Id = $dbarr[0]";
                  $_get_count = mysql_query($sql3) or die(mysql_error());
                  $countDB = mysql_fetch_array($_get_count);
                  echo "<td>".$countDB[0]."</td>";
                  echo "<input type=\"hidden\" name=\"_count\" value=\"$countDB[0]\">";

                  $sql2 = "SELECT * FROM reserve WHERE r_id='$dbarr[0]'";
                  $result2 = mysql_query($sql2) or die(mysql_error());
                  $dbarr2 = mysql_fetch_array($result2);
                  echo "<td><input type=\"submit\" name=\"submit\" value=\"ดูรายการนี้\" ><input type=\"button\" value=\"ยกเลิกการจอง\" onclick=\"header_page($dbarr[0]);\"></td>";
               echo "</tr>";
            echo "</form>";
         }
      ?>
   </table>



   <?php
   		$submit = $_POST['submit'];
   		$_house_Id = $_POST['house_Id'];
   		$status = $_POST['status'];
   		$type = $_POST['type'];

   		if($submit == "เพิ่มกุฏินี้") {
	   		$query = "INSERT INTO house VALUES('$_house_Id', '$status', '$type', '1')";
	   		if(mysql_query($query)) {
	   			echo "<script>alert(\"บันทึกข้อมูลเรียบร้อยเรียบร้อย\")</script>";
	   			echo "<script>window.location = 'manage_house.php'</script>";
	   		}
   		} else if ($submit == "ดูรายการนี้") {
   			$_count = $_POST['_count'];
   			if($_count == 0) {
   				echo "<script>alert(\"ขออภัย!! รายการนี้ไม่มีการจอง\")</script>";
	   			echo "<script>window.location = 'manage_house.php'</script>";
   			} else {
   				echo "<script>window.location = 'manage_house.php?r_id=$_house_Id'</script>";
   			}

   		} else if($_GET['submit'] == "ยกเลิกการจอง") {
   			$query_delete = "DELETE FROM house WHERE house_Id = '$_house_Id'";
   			if(mysql_query($query_delete)) {
   				echo "<script>alert(\"ลบข้อข้อมูลของกุฏิหมายเลข $_house_Id สำเร็จ\")</script>";
	   			echo "<script>window.location = 'manage_house.php'</script>";
   			}
   		}
   ?>

</body>
</html>