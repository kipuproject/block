
	function assignStatusPayment(obj,booking,formSaraDataURL){
	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignStatusPayment",
				paymentstatus:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}

	function assignOnlineValue(obj,booking,formSaraDataURL){

	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignOnlineValue",
				onlinepayment:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}

	function assignDate(chekininput,chekoutinput,booking,formSaraDataURL){

	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignDate",
				chekininput:chekininput.val(),
				chekoutinput:chekoutinput.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
				location.reload();
			}
		});


	}

	function assignRoom(obj,booking,formSaraDataURL){
	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignRoom",
				room:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}

	function assignTypeRoom(obj,booking,formSaraDataURL){
	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignTypeRoom",
				typeroom:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}

	function updateResponsible(form,formSaraDataURL){
		$.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "updateResponsible",
				dni :  $(form+" #u-main-dni").val(),
				id :  $(form+" #u-value").val(),
				name: $(form+" #u-main-name").val(),
				country: $(form+" #u-main-country").val(),
				uemail: $(form+" #u-main-email").val(),
				phone: $(form+" #u-main-phone").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});

	}

	function assignPaymentValue(obj,booking,formSaraDataURL){

	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignPaymentValue",
				value:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}

	function assignObservation(obj,booking,formSaraDataURL){

	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignObservation",
				value:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}

	function assignValue(obj,booking,formSaraDataURL){

	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: {
				optionBooking : "assignValue",
				value:obj.val(),
				booking:booking,
				commerce:$("#booking-commerce").val()
				},
			success: function(respuesta) {
				alert(respuesta);
				$('#valueinput').prop('disabled',true);
				$('#valuenightinput').val(($('#valueinput').val())/($('#nights').html()));
			}
		});
	}
  
function assignStatus(obj,booking,formSaraDataURL){
   $.ajax({
    type: 'GET',
    url: formSaraDataURL,
    async: false,
    data: { 
      optionBooking : "assignStatus",
      status:obj.val(),
      booking:booking,
      commerce:$("#booking-commerce").val()
      },
    success: function(respuesta) {
      alert(respuesta);
    }
  });
}
  
function updateForm(formSaraData,form){
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

function newService(id){
	$new=$('.template-service'+id).clone();
	$newid='service-'+id+'-'+$('.list-services-'+id).children().size();
	$new.attr("id",$newid);
	$new.removeClass("template-service"+id);
	$new.find(".title-service").html($('#selector-service-'+id+' option:selected').text()+': ');
	$new.find(".is").val($('#selector-service-'+id).val());
	$('.list-services-'+id).append($new);
	$('.list-services-'+id+' #'+$newid).show();
}

function saveService(obj,formSaraData,id,opSave){
	is=obj.parent().children('.is').val();
	cs=obj.parent().children('.cs').val();
	vs=obj.parent().children('.vs').val();
	$.ajax({
		type: 'GET',
		url: formSaraData,
		data:{'is':is,'cs':cs,'vs':vs,'idbooking':id,'opSave':opSave},
		success: function(respuesta) {
			if(respuesta!="true"){
				alert(respuesta);
			}else{
				alert("Operación exitosa!");
				if(opSave=="add"){
					obj.parent().children('.save').hide();
					obj.parent().children('.update').show();
				}
				if(opSave=="delete"){
					obj.parent().remove();
				}
			}
		}
	});
}

function block(formSaraDataURL){
  var my_books = $('.activeBook');
  var array_id=[];
  my_books.each(function(){
     var $this = $(this);
     $this.css({"background":"#000000"});
     array_id.push($this.attr('id'));
  });
  $.ajax({
  type: 'GET',
  url: formSaraDataURL,
  async: false,
  data: {
    optionBooking : "blockBooking",
    bookings:array_id.toString(),
    commerce:$("#booking-commerce").val()
    },
  success: function(respuesta) {
    alert(respuesta);
  }
  });
}

function showDetail(formSaraDataURL){
   var my_books = $('.activeBook');
   var array_id=[];
   my_books.each(function(){
       var $this = $(this);
       array_id.push($this.attr('id'));
   });
   $.ajax({
    type: 'GET',
    url: formSaraDataURL,
    async: false,
    data: {
      optionBooking : "showDetails",
      bookings:array_id.toString(),
      commerce:$("#booking-commerce").val()
      },
    success: function(respuesta) {
      $("#booking-calendar").html(respuesta);
      $(".btn-calendar").hide();
      $(".return-btn").show();
    }
  });
}

function unselect(formSaraDataURL){
   var my_books = $('.activeBook');
   var array_id=[];
   my_books.each(function(){
       var $this = $(this);
       $this.removeClass("activeBook");
       $this.css({"border":"1px solid #FFFFFF"});

   });
}

function unblock(formSaraDataURL){
   var my_books = $('.activeBook');
   var array_id=[];
   my_books.each(function(){
       var $this = $(this);
       $this.css({"background":"#FFFFFF"});
       array_id.push($this.attr('id'));
   });
   $.ajax({
    type: 'GET',
    url: formSaraDataURL,
    async: false,
    data: {
      optionBooking : "unblockBooking",
      bookings:array_id.toString(),
      commerce:$("#booking-commerce").val()
      },
    success: function(respuesta) {
      alert(respuesta);
    }
  });
}

function getPayuData(formSaraDataURL,key,value){

   $.ajax({
    type: 'GET',
    url: formSaraDataURL,
    async: false,
    data: {
      api : "payu",
      method : "payu-data",
      value:value,
      key:key
      },
    success: function(response) {
      json = jQuery.parseJSON(response);
      if(json.status_code == 200){
        $('#dialog'+value).html(json.data.ANSWER);
      }else{
        $('#dialog'+value).html(json.status);
      }
      $('#dialog'+value).dialog();
    }
  });
}

function editDate(){
  checkin = $('#chekininput');
  checkout = $('#chekoutinput');
  editbutton = $('#editbutton');
  savebutton = $('#savebutton');
  editbutton.hide();
  savebutton.show();
  checkin.prop('disabled',false);
  checkout.prop('disabled',false);
}

function setDate(form){
  
  checkin = $('#chekininput');
  checkout = $('#chekoutinput');
  editbutton = $('#editbutton');
  savebutton = $('#savebutton');
  
  $.ajax({
    type: 'GET',
    url: form,
    async: false,
    data: { 
      optionBooking : "assignDate",
      chekininput:checkin.val(),
      chekoutinput:checkout.val(),
      commerce:$("#booking-commerce").val()
      },
    success: function(respuesta) {
      alert(respuesta);
      editbutton.show();
      savebutton.hide();
      checkin.prop('disabled',true);
      checkout.prop('disabled',true); 
    }
  });
}

