$(document).ready(function () {
	// handles light click events
	$( ".light" ).click(function () {
		var id_string = $(this).attr("id");
		var id_array = id_string.split("-");
		var id = id_array[1];
				
		SetOutletState(id);
	});
});

function SetOutletState(id, state) {
	// invert the current state
	var current_state = $( "#state-" + id).val();
	var desired_state = (current_state == 'on') ? 'off' : 'on';
	
	$.ajax({
		url: 'ajax.php',
		data: { outlet: id, action: desired_state },
		error: function() {
			alert("ajax error ocurred");
		},
		success: function(data) {
			if (data.status == 'OK') {
				// set the value of the button
				$( '#outlet-' + id ).val(data.message);
				$( '#state-' + id).val(desired_state);			
			}
			else {
				alert(data.message);
			}
		}
	});
}