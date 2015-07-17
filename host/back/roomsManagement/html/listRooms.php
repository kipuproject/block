<div class="titulob">
<div class="tituloimg">
<h1>HABITACIONES</h1>
</div>

</div>

<div id="main_user">
		
	<div class="row-fluid">
		<div class="span12">
			<div class="box box-color box-bordered">
				<div class="box-title">
					<h3>
						<ul class="main-nav menu_calendar">
							<li class="btn-calendar">
								<a href="<?=$formSaraDataNew?>"><span>NUEVA</span></a>
							</li>
							<li class="btn-calendar">
								<a href="<?=$formSaraDataTypeRooms?>"><span>TIPOS DE HABITACION</span></a>
							</li>
						</ul>	
					</h3>
				</div>
				<div class="box-content nopadding">
					<table class="table table-hover table-nomargin table-bordered ">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Tipo</th>

								<th></th>
							</tr>
						</thead>
						<tbody id="table-rooms" >
					
							<?php
							$i=0;
							while(isset($roomList[$i][0])){

							?>
								
									<tr>
										<form id="form-room" >
											<td><input name="name"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" value="<?=$roomList[$i]['NAME']?>"  type="text" placeholder=""></td>
											<td>
												<select onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="typeroom"  id="plan" >
														<?PHP	
																echo '<option value="" > Sin Asignar </option>';
															foreach($typeListRoom as $valueList){
																$selected=($roomList[$i]['TYPEROOM']==$valueList['IDTYPEROOM'])?"selected":"";
																echo '<option value="'.$valueList['IDTYPEROOM'].'" type="text" '.$selected.' >'.$valueList['NAME']."</option>";
															}
														?>
												</select>
											</td>
							
											<td><a style="cursor:pointer" onclick="if(confirm('Estas seguro de eliminar esta habitacion? la operacion no se puede deshacer')){ deleteRoom('<?=$formSaraDataDelete?>&idroom=<?=$roomList[$i]['IDRESERVABLE']?>') }"  class="btn" rel="tooltip" title="Borrar"><i class="icon-remove"></i></a></td>								
											<input name="idroom"  value="<?=$roomList[$i]['IDRESERVABLE']?>"  type="hidden" placeholder="">
										</form>
									</tr>
									
							<?php
							$i++;
							}
							?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

