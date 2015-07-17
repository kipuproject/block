function updateForm(formSaraData,form){

	$.ajax({
		type: 'GET',
		enctype: 'multipart/form-data',
		url: formSaraData,
		data: $(form).serialize(),
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			alert(respuesta);
			
			

		}
	});
}



function addCompany(formSaraData,form){

	$.ajax({
		type: 'GET',
		url: formSaraData,
		data: $(form).serialize(),
		success: function(respuesta) {

			myJson=$.parseJSON(respuesta);

			if(myJson.status=="TRUE"){
				$("#commerceData #idCompany").val(myJson.id);
				$("#commerceData").show();
			}else{
				if(myJson.mensaje!="" && myJson.mensaje.length>0){
					alert(myJson.mensaje);
				}
			}	

		}
	});
}

function addCommerce(formSaraData,form){

	$.ajax({
		type: 'GET',
		url: formSaraData,
		data: $(form).serialize(),
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			$("#allCommerce").append(respuesta);
			
		}
	});
}

function DeleteCompany(formSaraData,postDelete){
	
	$.ajax({
		type: 'GET',
		url: formSaraData,
		success: function(respuesta) {
			//$(form+" #status").html(respuesta);
			if(respuesta=="true"){
				/*$(this).parent('td').remove();*/
				location.replace(postDelete);
			}else{
				alert(respuesta);	
			}

		}
	});
}

