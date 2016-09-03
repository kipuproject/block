
function updateRoom(formSaraData,form){

	$.ajax({
		type: 'GET',
		url: formSaraData,
		data: $(form).serialize(),
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			alert(respuesta);

		}
	});
}

function updateTypeRoom(formSaraData,form){

	$.ajax({
		type: 'GET',
		url: formSaraData,
		data: $(form).serialize(),
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			alert(respuesta);

		}
	});
}

function updateCapacity(formSaraData,form){

	$.ajax({
		type: 'GET',
		url: formSaraData,
		data: $(form).serialize(),
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			alert(respuesta);
			location.reload();

		}
	});
}

function updateMinimun(formSaraData,form,season){

	data_form = $(form).serialize();
	$.ajax({
		type: 'GET',
		url: formSaraData,
		data: data_form+"&season="+season,
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			alert(respuesta);
			location.reload();
		}
	});
}

function addRoom(formSaraData){

	$.ajax({
		type: 'GET',
		url: formSaraData,
		success: function(respuesta) {
			$("#table-rooms").append(respuesta);
		}
	});
}



function deleteRoom(formSaraData){
	location.replace(formSaraData);
}



