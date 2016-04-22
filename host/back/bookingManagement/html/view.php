<script>

	$(document).ready(function(){
		  var isDown = false;   // Tracks status of mouse button
			$(function() {
				$( document ).tooltip();
			});
 		  $(document).mousedown(function() {
        isDown = true;      // When mouse goes down, set isDown to true
		  })
		  .mouseup(function() {
        isDown = false;    // When mouse goes up, set isDown to false
		  });

		  $(".clickableElement").live('mouseover', function() {

		  	row = $(this).attr("row");
				col = $(this).attr("col");

		  	if(isDown) {        // Only change css if mouse is down
				  selection($(this));
				}else{

					$("."+row).css({"background":"yellowgreen"});
					$("."+col).css({"background":"yellowgreen"});
				}
		  });

		  $(".clickableElement").live('mouseout', function() {

		  	row = $(this).attr("row");
				col = $(this).attr("col");

		  	$("."+row).css({"background":"#ECECEC"});
				$("."+col).css({"background":"#ECECEC"});

		  });

		  $(".clickableElement").live('mousedown', function() {
			   selection($(this));
		  });


		function selection(obj){

			if(obj.hasClass("activeBook")){
			   obj.css({"border":"1px solid #FFFFFF"});
			   obj.removeClass("activeBook");
			}else{
			   obj.css({"border":"1px solid #FF0000"});
			   obj.addClass("activeBook");
			}
		}
		$(function(){
		   var my_books = $('.activeBook');
		   $('#show_hide').click(function(){
			   my_books.each(function(){
				   var $this = $(this);
				   if( $this.is(':visible') )
					   $this.hide();
				   else
					   $this.show();
			   });
		   });
		});

		$('.booking-filter').on('change', function() {
			reloadCalendar();
		});

		$('.return-btn').on('click', function() {
			reloadCalendar();
		});

		function reloadCalendar(){
			$.ajax({
				type: 'GET',
				url: '<?=$formSaraDataURL?>',
				async: false,
				data: {
					optionBooking : "reloadForm",
					month:$("#booking-month").val(),
					year:$("#booking-year").val(),
					company:$("#booking-company").val(),
					commerce:$("#booking-commerce").val()
					},
				success: function(respuesta) {
					$("#booking-calendar").html(respuesta);
					$(".btn-calendar").show();
					$(".return-btn").hide();
				}
			});
		}

	});
</script>

<br/>
	<ul class="main-nav menu_calendar">
			<li class="btn-calendar">
				<a href="<?=$formSaraDataBookingList?>"><span>VER LISTADO</span></a>
			</li>
	</ul>
	<br/><br/><br/>

<div class="titulob">
	<div class="tituloimg">
		<h1>ADMINISTRAR DISPONIBILIDAD</h1>
	</div>
</div>

<div class="box box-color box-bordered no-seleccionable" >
	<div class="box-title">
		<h3>
			<select class="booking-filter" style="width:90px" id="booking-year">
        <?php for($i=2014;$i<=2020;$i++): ?>
				<option <?=($year==$i)?"selected":""?>  VALUE="<?=$i?>" ><?=$i?></option>
				<?php endfor; ?>
			</select>

			<select class="booking-filter" id="booking-month">
				<option <?=($month=="1")?"selected":""?>  VALUE="1" >ENERO</option>
				<option <?=($month=="2")?"selected":""?>  VALUE="2" >FEBRERO</option>
				<option <?=($month=="3")?"selected":""?>  VALUE="3" >MARZO</option>
				<option <?=($month=="4")?"selected":""?>  VALUE="4" >ABRIL</option>
				<option <?=($month=="5")?"selected":""?>  VALUE="5" >MAYO</option>
				<option <?=($month=="6")?"selected":""?>  VALUE="6" >JUNIO</option>
				<option <?=($month=="7")?"selected":""?>  VALUE="7" >JULIO</option>
				<option <?=($month=="8")?"selected":""?>  VALUE="8" >AGOSTO</option>
				<option <?=($month=="9")?"selected":""?>  VALUE="9" >SEPTIEMBRE</option>
				<option <?=($month=="10")?"selected":""?>  VALUE="10" >OCTUBRE</option>
				<option <?=($month=="11")?"selected":""?>  VALUE="11" >NOVIEMBRE</option>
				<option <?=($month=="12")?"selected":""?>  VALUE="12" >DICIEMBRE</option>
			</select>
		</h3>
		<input type="hidden" id="booking-commerce"  value="<?=$this->commerce?>"/>
		<ul class="main-nav menu_calendar">
			<li class="btn-calendar">
				<a onclick="showDetail('<?php echo $formSaraDataURL; ?>')"><span>VER</span></a>
			</li>
			<li  class="btn-calendar">
				<a  onclick="block('<?php echo $formSaraDataURL; ?>')" ><span>BLOQUEAR</span></a>
			</li>
			<li  class="btn-calendar">
				<a  onclick="unblock('<?php echo $formSaraDataURL; ?>')" ><span>DESBLOQUEAR</span></a>
			</li>
			<li class="btn-calendar">
				<a  onclick="unselect('<?php echo $formSaraDataURL; ?>')"><span>QUITAR SELECCION</span></a>
			</li>
			<li class="return-btn">
				<a  onclick="unselect('<?php echo $formSaraDataURL; ?>')"><span>REGRESAR</span></a>
			</li>
		</ul>
	</div>
	<div id="booking-calendar" class="box-content nopadding">
		<?=$this->paintBookingForm($month,$year,$this->commerce)?>
	</div>
</div>
