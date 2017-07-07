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
	//$("#show_content_id").css("color", "red");
}