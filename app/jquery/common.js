var date_now = new Date();
var month = date_now.getMonth();
var year = date_now.getFullYear();
var day = date_now.getDate();

function _get_reserve() {
	$.ajax({
		    type: 'POST',
		    url: 'app/reserve_view.php',
		    data: { 
		        'r_date': "_date"
			},
		success: function(data) {
	        $('#show_content_id').html(data);
	    }
	});
}

function _get_view() {
	$.ajax({
		    type: 'POST',
		    url: 'app/get_history.php',
		    data: { 
		        'r_date': "_date"
			},
		success: function(data) {
	        $('#show_content_id').html(data);
	    }
	});
}

function print_form_regis() {
	document.getElementById("show_menu_id").style.marginLeft  == "-370px";
	$('#header').css("backgroundColor","#f7ca18");
	$.ajax({
	    type: 'POST',
	    url: 'register.php',
	    data: { 
	        'r_date': "_date"
		},
		success: function(data) {
	        $('#show_content_id').html(data);
	    }
	});
}

function send_regis() {

	var uploadOK = 1;
	var regis_username = document.getElementById("regis_username").value;
	if(regis_username == "")
		uploadOK = 0;
	var regis_password = document.getElementById("regis_password").value;
	if(regis_password == "")
		uploadOK = 0;
	var regis_repassword = document.getElementById("regis_repassword").value;
	if(regis_repassword == "" )
		uploadOK = 0;
	if(regis_repassword != regis_repassword)
		uploadOK = 0;
	
	var regis_sname = document.getElementById("regis_sname").value;
	if(regis_sname == "")
		uploadOK = 0;
	var regis_surname = document.getElementById("regis_surname").value;
	if(regis_surname == "")
		uploadOK = 0;
	var regis_gender = document.getElementById("regis_gender").value;
	if(regis_gender == "")
		uploadOK = 0;
	var regis_nation_id = document.getElementById("regis_nation_id").value;
	if(regis_nation_id == "")
		uploadOK = 0;

	var regis_Dob = document.getElementById("regis_Dob").value;
	if(regis_Dob == "")
		uploadOK = 0;

	var regis_telno = document.getElementById("regis_telno").value;
	if(regis_telno == "")
		uploadOK = 0;

	var regis_email = document.getElementById("regis_email").value;
	if(regis_email == "")
		uploadOK = 0;

	 $.ajax({
	    type: 'POST',
	    url: 'register.php',
	    data: { 
	        'Register': "regis",
	        'username': regis_username,
	        'password': regis_password,
	        'r_password' : regis_repassword,
	        'name': regis_sname,	
	        'surname': regis_surname,
	        'Gender':regis_gender,
	        'nation_ID':regis_nation_id,
	        'Dob':regis_Dob,
	        'TelNo':regis_telno,
	        'email':regis_email
		},
		success: function(data) {
	        $('#show_content_id').html(data);
	    }
	});
}

function check_input_pass() {
	var regis_password = document.getElementById("regis_password").value;
	var regis_repassword = document.getElementById("regis_repassword").value;
	if(regis_password != regis_repassword)
		alert("Password not match!!!");
}

function get_sign_in() {
	$.ajax({
	    type: 'POST',
	    url: 'app/login.php',
	    data: { 
	        'r_date': "_date"
		},
		success: function(data) {
	        $('#show_content_id').html(data);
	    }
	});
}
function print_form_view() {
		$.ajax({
		    type: 'POST',
		    url: 'app/show_calendar.php',
		    data: { 
	        'r_date': "_date"
		},
		success: function(data) {
	       $('#show_content_id').html(data);
	    }
	});
}

function init_date() {
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
	get_data(day);
}

function get_data(data) {
	$('#rightContainer').html("<img src='style/loading.gif' width='25px' height='25px' style='margin:40px'>");		
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