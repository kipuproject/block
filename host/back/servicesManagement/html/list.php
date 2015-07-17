<div class="titulob">
<div class="tituloimg">
<h1>SERVICIOS ADICIONALES</h1>
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
								<a href="<?=$formSaraDataNew?>"><span>NUEVO SERVICIO</span></a>
							</li>
						</ul>	
					</h3>
				</div>
				<div class="box-content nopadding">
					
					
							<?php 
							$i=0;
							while(isset($serviceList[$i][0])){

							?>
							<br/>
							<div class="habitaciones2">
							<div class="cuatrocol20">
							Nombre
							</div>
							<div class="cuatrocol20">
							Descripción
							</div>
							<div class="cuatrocol30">
							
							</div>
							<div class="cuatrocol30" style="text-align: right;">
							
							<? if($serviceList[$i]['DYNAMIC']=='1'){ ?>
							<a class="btn" style="cursor:pointer" onclick="if(confirm('Estas seguro de eliminar este tipo de Habitacion? La operacion no se puede deshacer')){ deleteService('<?=$formSaraDataDelete?>&idservice=<?=$serviceList[$i]['IDSERVICE']?>') }"  class="btn" rel="tooltip" title="Borrar"><i class="icon-remove"></i></a>
							<? }else{ ?>
								Este tipo de servicio no se puede eliminar
							<? } ?>
							</div>
							
							<div class="clear"></div>
								</div>
							
							<div class="habitaciones">
										<form id="form-room" >
										
											<div class="cuatrocol_20">
												<div class="dat_1">(<?=$serviceList[$i]['IDSERVICE']?>) Nombre</div>  
												<br/><input name="name"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))" value="<?=$serviceList[$i]['NAME']?>"  type="text" placeholder=""><br/>
												
												<br/><input name="onepayment"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))"  type="radio" value="1" <?=($serviceList[$i]['ONPAYMENT']=="1")?"checked":""?> > Pago Unico
												<br/><input name="onepayment"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))"   type="radio" value="0" <?=($serviceList[$i]['ONPAYMENT']=="0")?"checked":""?>  > Pago x Cada dia de Reserva
												
											</div>
											 
											<div class="cuatrocol_20">
												<div class="dat_1">Descripcion</div>  
												<textarea style="width: 95%; height: 175px;"onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))" name="description"><?=trim($serviceList[$i]['DESCRIPTION'])?></textarea>
											</div>
											
											
																				
											<div class="cuatrocol_30">
												
												<table>
													<tr> 
														<th style="background: rgb(164, 169, 173);">Valor<br/>Temporada Baja</th>
														<th style="background:rgb(45, 179, 3);">Valor<br/>Temporada Alta</th>
														
													</tr>
													
													
													
													<tr>
														<td><input style="width:90px" name="currency-COP-1-<?=$g?>"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$serviceList[$i]['IDSERVICE']]['1']['COP']?>"  type="text" placeholder=""></td>
														
														<td><input style="width:90px" name="currency-COP-2-<?=$g?>"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$serviceList[$i]['IDSERVICE']]['2']['COP']?>"  type="text" placeholder=""></td>
														
													</tr>
													
													
												
												</table>
												
											</div>									
										
											
											
											<div class="cuatrocol_30">
												
												<table>
													<tr>
													<th style="background: rgb(204, 164, 5);">Valor<br/>Promocional 1</th>
														<th style="background:rgb(25, 179, 185);">Valor<br/>Promocional 2</th>
														
													</tr>
													
																											
													
													<tr>
														<td><input style="width:90px" name="currency-COP-3-<?=$g?>"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$serviceList[$i]['IDSERVICE']]['3']['COP']?>"  type="text" placeholder=""></td>
														
														<td><input style="width:90px" name="currency-COP-4-<?=$g?>"  onchange="updateService('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="<?=$priceList[$serviceList[$i]['IDSERVICE']]['4']['COP']?>"  type="text" placeholder=""></td>
													
												</tr>
													
													
												</table>
												
											</div>
											

											<input name="idservice"  value="<?=$serviceList[$i]['IDSERVICE']?>"  type="hidden" placeholder="">
										</form>
								</div>		
							<?php
							$i++;
							}
							?>

						
				</div>
			</div>
		</div>
	</div>
</div>

