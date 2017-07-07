<?php 
    session_start();
    include("en/connect.php");
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>จัดการการจอง : Reserve system of Monk's house</title>
   <?php
      $reserveable = "yes";
      if(($_SESSION["personID"] == "" or $_SESSION["personID"] == "unknow" ) AND$_SESSION["group"] == "admin")  {
           echo "<script>alert(\"กรุณาเข้าสู่ระบบก่อน\")</script>";
           echo "redirecting";
           echo "<script>window.location = 'app/login.php'</script>";
       }
   ?>
</head>
<body>
   <h4>จัดการผู้ใช้</45>
   <form method="POST" action="manage_reserve.php">
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
            $sql = "SELECT R.r_id, R.personID, R.r_date, R.house_id, R.c_in_date, R.c_out_date, R.c_in_time FROM reserve AS R, person AS P WHERE personID = nation_ID";

         $result = mysql_query($sql) or die(mysql_error());
         echo "<tr>";
            echo "<td>หมายเลขการจอง</td>";
            echo "<td>ผู้จอง</td>";
            echo "<td>วันที่จอง</td>";
            echo "<td>หมายเลขห้อง</td>";
            echo "<td>วันที่เข้าพัก</td>";
            echo "<td>วันที่ยกเลิกการพัก</td>";
            echo "<td>เวลาที่เข้าพัก</td>";
            echo "<td>เลือกการกระทำ</td>";
         echo "</tr>";
         while($dbarr = mysql_fetch_array($result)) {
            echo "<form action=\"en/_edit_reserve.php\" method=\"POST\">";
               echo "<tr>";
                  echo "<td><input type=\"text\" name=\"r_id\" value=\"$dbarr[0]\" size=\"16\"></td>";
                  echo "<td><input type=\"text\" name=\"p_name\" value=\"$dbarr[1]\" ></td>";
                  echo "<td><input type=\"text\" name=\"r_date\" value=\"$dbarr[2]\" size=\"11\"></td>";

                  $sql3 = "SELECT house_Id FROM house WHERE house_id NOT IN(SELECT house_id FROM reserve WHERE c_in_date = '$dbarr[4]')";
                  $_get_house = mysql_query($sql3) or die(mysql_error());
                  echo "<td><select name=\"house_id\">";
                     echo "<option value=\"$dbarr[3]\">".$dbarr[3]."</option>";
                     while ($houseDB = mysql_fetch_array($_get_house) ) {
                        echo "<option value=\"$houseDB[0]\">".$houseDB[0]."</option>";
                     }
                  echo "</select></td>";

                  echo "<td><input type=\"date\" name=\"c_in_date\" value=\"$dbarr[4]\" size=\"11\"></td>";
                  echo "<td><input type=\"date\" name=\"c_out_date\" value=\"$dbarr[5]\" size=\"11\"></td>";
                  echo "<input type=\"hidden\" name=\"p_ID\" value=\"$dbarr[7]\">";

                  $sql2 = "SELECT * FROM reserve WHERE r_id='$dbarr[0]'";
                  $result2 = mysql_query($sql2) or die(mysql_error());
                  $dbarr2 = mysql_fetch_array($result2);
                  echo "<td>";
                     echo "<select name=\"c_in_time\">";
                        if ($dbarr2[6] == 0)
                           echo "<option value=\"0\">เช้า</option>";
                        else
                           echo "<option value=\"1\">บ่าย</option>";
                        
                        if($dbarr2[6] == 0)
                           echo "<option value=\"1\">บ่าย</option>";
                        else
                           echo "<option value=\"0\">เช้า</option>";

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
   <form action="en/_edit_reserve.php" method="POST">
      <table>
         <tr>
            <td>ชื่อผู้จอง</td>
            <td><input type="text" name="name" ></td>
         </tr>
         <tr>
            <td>นามสกุล</td>
            <td><input type="text" name="surname" ></td>
         </tr>
         <tr>
            <td>วันที่จอง</td>
            <?php 
               $r_date = date("Y-m-d");   
               echo "<input type=\"hidden\" name=\"r_date\" value=\"$r_date\">";
            ?>
            <td><?php echo $r_date;  ?></td>
         </tr>
         <tr>
            <td>วันที่เข้าพัก</td>
            <td><input type="date" name="c_in_date" ></td>
         </tr>
         <tr>
            <td>หมายเลขห้อง</td>
            <?php
               $sql3 = "SELECT house_Id FROM house WHERE house_id NOT IN(SELECT house_id FROM reserve WHERE c_in_date = '$dbarr[4]')";
               $_get_house = mysql_query($sql3) or die(mysql_error());
               echo "<td><select name=\"house_id\">";
                  while ($houseDB = mysql_fetch_array($_get_house) ) {
                     echo "<option value=\"$houseDB[0]\">".$houseDB[0]."</option>";
                  }
               echo "</select></td>";
            ?>
         </tr>
         <tr>
            <td>วันที่ยกเลิกการพัก</td>
            <td><input type="date" name="c_out_date" ></td>
         </tr>
         <tr>
            <td>เวลาที่เข้าพัก</td>
            <?php
                  $sql2 = "SELECT * FROM reserve WHERE r_id='$dbarr[0]'";
                  $result2 = mysql_query($sql2) or die(mysql_error());
                  $dbarr2 = mysql_fetch_array($result2);
                  echo "<td>";
                     echo "<select name=\"c_in_time\">";
                        if ($dbarr2[6] == 0)
                           echo "<option value=\"0\">เช้า</option>";
                        else
                           echo "<option value=\"1\">บ่าย</option>";
                        
                        if($dbarr2[5] == 0)
                           echo "<option value=\"1\">บ่าย</option>";
                        else
                           echo "<option value=\"0\">เช้า</option>";
                     echo "</select>";
                  echo "</td>";
            ?>
         </tr>
         <tr>
            <td><input type="submit" name="submit" value="เพิ่มผู้จอง"></td>
         </tr>
      </table>
   </form>

</body>
</html>