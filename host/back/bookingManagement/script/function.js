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

