	function assignSeason(season,color,formSaraDataURL){
	   var my_books = $('.activeDay');
	   var array_id=[];
	   my_books.each(function(){
			   var $this = $(this); 
			   $this.css({"background":color});
			   array_id.push($this.attr('id'));
			   $this.removeClass("activeDay");
			   $this.css({"outline":"none"});
				
	   }); 
	   
	   $.ajax({
			type: 'GET',
			url: formSaraDataURL,
			async: false,
			data: { 
				days:array_id.toString(),
				season:season
			},
			success: function(respuesta) {
				alert(respuesta);
			}
		});
	}
	
	$(document).ready(function(){

		  var isDown = false;   // Tracks status of mouse button

		  $(document).mousedown(function() {
			isDown = true;      // When mouse goes down, set isDown to true
		  })
		  .mouseup(function() {
			isDown = false;    // When mouse goes up, set isDown to false
		  });

		  $(".clickableElement").live('mouseover', function() {
			if(isDown) {        // Only change css if mouse is down
			  selection($(this));
			}
		  });
		  
		  
		  $(".clickableElement").live('mousedown', function() {
			   selection($(this));
		  });
		  
		function selection(obj){
			if(obj.hasClass("activeDay")){
				obj.css({"outline":"none"});
				obj.removeClass("activeDay");
			}else{
				obj.css({"outline":"1px solid #0000FF"});
				obj.addClass("activeDay"); 
			}   
		}
	});	
	
	
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

