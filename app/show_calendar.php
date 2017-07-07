<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="style/common.css">
	<link rel="stylesheet" type="text/css" href="style/Calendar.css">
	<link rel="stylesheet" type="text/css" href="style/show_calendar.css">
	<script src="jquery/jquery-2.1.4.min"></script>
	<script type="text/javascript">
		var date_now = new Date();
		var month = date_now.getMonth();
		var year = date_now.getFullYear();
		var day = date_now.getDate();
		function  alert_txt(str) {
			alert(str);
		}

		function get_date() {

		}

		function update_head() {
			var month_arr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			document.getElementById("show_date").innerHTML = month_arr[month]+" "+year;
		}

		function miner_month() {
			if(month == 0) {
				month = 11;
				year-=1;
			} else {
				month-=1
			}

			$.ajax({
				type: 'POST',
				url: 'app/en/_get_calendar.php',
				data: { 
					'year': year,
					'month' : month
				},
				success: function(data){
					update_head();
				    $('#calendar_body').html(data);
				}
			});
		}

		function plus_month() {
			if(month == 11) {
				month = 0;
				year+=1;
			} else {
				month+=1;
			}
			
			$.ajax({
				type: 'POST',
				url: 'app/en/_get_calendar.php',
				data: { 
					'year': year,
					'month' : month
				},
				success: function(data){
					update_head();
				    $('#calendar_body').html(data);
				}
			});
		}

		function get_data(data) {
			$('#rightContainer').html("<img src='app/style/loading.gif' width='25px' height='25px' style='margin:40px'>");		
			$.ajax({
				type: 'POST',
				url: 'app/en/_get_reserve_data.php',
				data: { 
					'year': year,
					'month':month,
					'day':data
				},
				success: function(data){
				    $('#rightContainer').html(data);
				}
			});
		} 
	</script>
</head>
<body onload="init_date()";>
	<div class="get_reservelist_wrapper">
		<div class="left_side">
			<div class="calendar">
				<div class="calendar_header">
					<div class="left_arrow" onclick="miner_month();"><img src="app/style/img/left_arrow.png" width="20px" height="auto"></div>
					<div class="show_date" id="show_date"></div>
					<div class="right_arrow" onclick="plus_month();"><img src="app/style/img/right_arrow.png" width="20px" height="auto"></div>
				</div>
				<div class="calendar_body" id="calendar_body">
				</div>
			</div>
			<div class="descript_txt"><i>หมายเหตุ</i> : <img src="app/style/img/flag.png">  หมายถึงวันที่มีการจอง <i>เลือกวันที่เพื่อดู</i></div>
		</div>
		<div class="right_side">
			<div id="rightContainer">
				
			</div>
		</div>
	</div>
</body>
</html>