$(document).ready(function() {
	"use strict";
	var data = Object.create(null);	
	data.services = "services";
	// GET the services.
	$.ajax({		
		type: "GET",
		url: "api.php",
		datatype: 'json',
		data: data,
		success: function(json) {
        $.each(json, function(ignore,value) {
          $('#services').append($('<option>').text(value.service).attr('value', value.service));
					$('#services_new').append($('<option>').text(value.service).attr('value', value.service));
        });
    }
	});
	// GET the providers.
	$.ajax({
		type: "GET",
		url: "api.php",
		datatype: 'json',
		success: function(json) {
        $.each(json, function(ignore, value) {								
          $('#providers').append($('<option>').text(value.name).attr('value', value.id));
        });
    }
	});	
});
// Hide divs if necessary.
function hideDivs(show,hide1,hide2) {
	"use strict";
	$(show).toggle();
	$(hide1).hide();
	$(hide2).hide();
	$("#confirmsave").hide();
	$("#confirmnew").hide();
	$('#newform')[0].reset();	
}	
// GET the data for a specific provider for editing.
function getData() {
	"use strict";	
	$("#services option:selected").removeAttr("selected");
	var id = $("#providers").val();
	var data = Object.create(null);	
	data.id = id;
	$.ajax({
		type: "GET",
		url: "api.php",
		datatype: 'json',
		data: data,
		success: function(json) {
			$.each(json,function(ignore,value) {
				$('#name').val(function() {
					return value.name;
				});
				$('#location').val(function() {
					return value.location;
				});
				$('#phone').val(function() {
					return value.phone;
				});				
				$.each(value.provides,function(ignore,value) {
					$("#services option[value='" + value + "']").prop("selected", true);
				});
			});
		}		
	});
}
// Save the data for a provider that's been edited.
function saveData() {
	"use strict";
	var id = $("#providers").val();
	var this_name = $('#name').val();
	var this_phone = $('#phone').val();
	var this_location = $('#location').val();
	var this_provides = $('#services').val();
	if (!this_name) {
		alert("You must enter a name");
	}
	if (!this_location) {
		alert("You must enter a location");
	}
	var data = Object.create(null);
	data.id = id;
	data.name = this_name;
	data.phone = this_phone;
	data.location = this_location;
	data.provides = this_provides;
	$.ajax({
		type: "PUT",
		url: "api.php",
		datatype: 'json',		
		data: data,
		success: function() {
			$("#providers option:selected" ).text(this_name);
			$("#edit").hide();
			$("#confirmsave").show();
		},
		failure: function() {
			$("#failure").show();
		}
	});	
}
// Delete a provider.
function deleteData() {
	"use strict";
	var id = $("#providers").val();	
	var data = Object.create(null);
	data.id = id;
	$.ajax({
		type: "DELETE",
		url: "api.php",
		datatype: 'json',		
		data: data,
		success: function() {
			$("#delete").show();
			$("#edit").hide();
			$("#add").hide();
			$("#confirmsave").hide();
			$("#confirmnew").hide();
			$('#newform')[0].reset();
		}
	});
	$("#providers option:selected").remove();
}
// Save the data for a new provider.
function saveNew() {
	"use strict";
	var this_name = $('#name_new').val();
	var this_phone = $('#phone_new').val();
	var this_location = $('#location_new').val();
	var this_provides = $('#services_new').val();
	if (!this_name) {
		alert("You must enter a name");
	}
	if (!this_location) {
		alert("You must enter a location");
	}	
	var data = Object.create(null);
	data.name = this_name;
	data.phone = this_phone;
	data.location = this_location;
	data.provides = this_provides;
	$.ajax({
		type: "POST",
		url: "api.php",
		datatype: 'json',		
		data: data,
		success: function(json) {
			$.each(json, function(ignore, value) {		
				 $('#providers').append($('<option>').text(value.name).attr('value', value.id));
				 $("#providers option[value='" + value.id + "']").prop("selected", true);
			 });
			 $("#add").hide();
			 $("#confirmnew").show();
			 $('#newform')[0].reset();			 
		}
	});	
}
