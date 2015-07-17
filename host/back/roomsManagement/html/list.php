
<div id="main_user">
		
	<div class="row-fluid">
		<div class="span12">
			<div class="box box-color box-bordered">
				<div class="box-title">
					<h3>
						<i class="icon-table"></i>
						HABITACIONES
						<br/><br/>
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
								<th>Valor<br/>Temporada Baja</th>
								<th>Valor<br/>Temporada Alta</th>
								<th>Valor<br/>Promocional</th>
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
															foreach($typeListRoom as $valueList){
																$selected=($roomList[$i]['TYPEROOM']==$valueList['IDTYPEROOM'])?"selected":"";
																echo '<option value="'.$valueList['IDTYPEROOM'].'" type="text" '.$selected.' >'.$valueList['NAME']."</option>";
															}
														?>
												</select>
											</td>
											<td><input name="currency-COP-1"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$roomList[$i]['IDRESERVABLE']]['1']['COP']?>"  type="text" placeholder=""></td>																			
											<td><input name="currency-COP-2"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$roomList[$i]['IDRESERVABLE']]['2']['COP']?>"  type="text" placeholder=""></td>
											<td><input name="currency-COP-3"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$roomList[$i]['IDRESERVABLE']]['3']['COP']?>"  type="text" placeholder=""></td>								
											<td><a style="cursor:pointer" onclick="if(confirm('Esta seguro de eliminar este establecimiento? Esta operacion no se puede deshacer')){ deleteRoom('<?=$formSaraDataDelete?>&idroom=<?=$roomList[$i]['IDRESERVABLE']?>') }"  class="btn" rel="tooltip" title="Borrar"><i class="icon-remove"></i></a></td>								
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

