<?php 
    session_start();
    include("en/connect.php");
    include("require_login.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ตารางการจอง : Reserve system OF monk's house</title>
</head>
<body>
	<div class = "wrapper">
    	<div class="header">

        </div>
        <div class="content">
            <div class="select">
            	<input type="button" name="previous" value="ก่อนหน้า">
                ธันวาคม 2015
                <input type="button" name="next" value="ถัดไป">
                <br /><hr><br />
            </div>
            <div class="calender">
                <form name="getCal" action="reserve_view.php" method="POST">
                    กรุณาเลือกวันที่ : <input type="date" name="day">
                    <br />
                    <input type="submit" name="submit" value="ตกลง">
                </form>
                <br /><hr><br />
            </div>
            <div class="reserve">
                <?php
                    $c_in_date = $_POST['day'];
                    $sql = "SELECT * FROM reserve WHERE c_in_date = '$c_in_date'";
                    $result = mysql_query($sql) or die(mysql_error());
                    $row = mysql_num_rows($result);
                    echo $c_in_date."<br />";
                    if($row == 0 || !isset($c_in_date)) {
                        echo "กรุราเลือกวันที่ค่ะ";
                    } else if($row) {
                        echo "วันนี้มีการจองทั้งหมด : ".$row." รายการ";
                    }
                    $_check_reserve = "SELECT * FROM system WHERE job_date = '$c_in_date'";
                    $_reserve = mysql_query($_check_reserve) or die(mysql_error());
                    if(mysql_num_rows($_reserve) == 0)
                        echo "<br><a href=\"_regis_house.php?_date=$c_in_date\">ฉันต้องการจองกุฏิ ณ วันที่นี้</a>";
                    else
                        echo "<h5 style=\"color:red;\">ขอโทษค่ะ วันที่ : <b>$c_in_date</b> ไม่อนุญาติให้จองค่ะ</h5>";
                    echo "<br /><hr><br />";
                    echo "รายการจองวันที่ : ".$c_in_date." <br />";
                ?>
                <table border="1">
                    <tr>
                        <td>หมายเลขกุฏิ</td>
                        <td>วันที่จอง</td>
                        <td>วันที่เข้าพัก</td>
                        <td>ชื่อผู้จอง</td>
                        <td>ประเภทกุฏิ</td>
                    </tr>
                <?php
                    $sql = "SELECT R.house_id, R.r_date, R.c_in_date, G.name, H.type FROM reserve AS R, house AS H, person AS P, guest AS G WHERE R.personID = P.nation_id AND R.house_id = H.house_Id AND P.nation_id = G.nation_id AND R.c_in_date = '$c_in_date'";
                    $result = mysql_query($sql) or die(mysql_error());
                    while($db = mysql_fetch_array($result)) {
                        echo "<tr>";
                            echo "<td>".$db[0]."</td>";
                            echo "<td>".$db[1]."</td>";
                            echo "<td>".$db[2]."</td>";
                            echo "<td>".$db[3]."</td>";
                            echo "<td>".$db[4]."</td>";
                        echo "<tr />";
                    }
                 ?>
                 </table>
            </div>
        </div>
    </div>
</body>
</html>