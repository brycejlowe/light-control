var ajax_url = '/ajax.php';

$(document).ready(function () {
	$( ".outlet" ).change(function () {
		toggleSwitch($(this));
	});

	$( ".all-button" ).click(function () {
		bulkSwitch($(this));
	});
});

function toggleSwitch(element) {
	var outlet_id = element.attr("id").replace("outlet-", "");
	var state = element.val();

	changeState(outlet_id, state);
}

function bulkSwitch(element) {
	var outlet_id = 0;
	var state = element.attr("href").replace("#all-", "");

	changeState(outlet_id, state);
}

function changeState(outlet_id, state) {
        $.ajax({
                url: ajax_url,
                data: { outlet: outlet_id, state: state },
                dataType: 'json',
                method: 'GET',
		beforeSend: function () {
			$.mobile.loading( "show" );
		},
                success: function(data) {
			var reload = false;
			if (data.status != 'OK') {
				alert(data.message);
				reload = true;
			}	
			else if (outlet_id == 0) {
				reload = true;
			}                        

			if (reload) {
				location.reload();
                        }
                },
                error: function() {
                        alert("Unknown Error Occurred");
			location.reload();
                },
		complete: function () {
			$.mobile.loading( "hide" );
		}
        });
}
