<?php

$avalaibleRooms=$this->getAvalaibleRooms($booking['ROOM'],strtotime($booking['FECHA_INICIO']),strtotime($booking['FECHA_FIN']),$booking['IDCOMMERCE'],$booking['ROOMTYPE']);
$payuPayment=$this->getPayuPayment($booking['IDBOOKING']);
$additionaldata=$this->getAdditionalData($booking['IDBOOKING']);

?>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<div id="dialog<?php echo $booking['IDBOOKING']; ?>" title="Informacion Pago" style="display:none">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>


<div class="detailBookingBox">
   <h1>C&Oacute;DIGO DE RESERVA: <?php echo $booking['IDBOOKING']; ?></h1>
	<ul class="tabs tabs-inline ">
		<li class="active" ><a href="#general<?=$booking['IDBOOKING']?>" data-toggle='tab'>INFORMACION GENERAL</a></li>
		<li><a href="#financiera<?=$booking['IDBOOKING']?>" data-toggle='tab'>INFORMACION FINANCIERA</a></li>
		<li><a href="#huespedes<?=$booking['IDBOOKING']?>" data-toggle='tab'>INFORMACION HUESPEDES</a></li>
		<!--li>
			<a href="<?=$booking['URLVOUCHER']?>" target="_blank">
				<img title="Imprimir Voucher" src="http://www.hoteles.kipu.co/blocks/host/back/bookingManagement/html/voucher/imagenes/pdf.png" >
			</a>
		</li-->
	</ul>

	<div class="tab-content padding tab-content-inline tab-content-bottom">

		<div class="tab-pane active" id="general<?=$booking['IDBOOKING']?>">

		<div class="box-content nopadding">
			<form id="form-15" class="form-horizontal form-column form-bordered" method="POST" action="#">
				<div class="span12">
					<div class="control-group" >
						<label class="control-label" for="textfield">FECHA:</label>
						<div class="controls">
              Check In :
							<div class="input-prepend">
								<input type="text" disabled="true"  id="chekininput" value="<?=date("d/m/Y",strtotime($booking['FECHA_INICIO']))?>" />
							</div>
              <div class="input-prepend"> Check Out:
									<input type="text" disabled="true"  id="chekoutinput" value="<?=date("d/m/Y",strtotime($booking['FECHA_FIN']))?>" />
							</div>
              
              <span class="add-on">
                <a id="editbutton" onclick="editDate()" >
                  Editar fechas
                </a>
                <a id="savebutton" style="display:none" onclick="setDate('<?php echo $formSaraDataURL; ?>')" >
                  Guardar cambios
                </a>
              </span>
						</div>
					</div>

				</div>
        <div class="span6">
          <div class="control-group">
						<label class="control-label" for="textfield">OBSERVACIONES:</label>
						<div class="controls">
							<div class="">
									HOTEL:
									<textarea onchange="assignObservation($(this),'<?=$booking['IDBOOKING']?>')" id="observationvalueinput"><?=$booking['OBSERVATION']?></textarea>
									<br/>
									CLIENTE: <?php echo $booking['OBSERVATION_CUSTOMER']; ?>
							</div>
							<span class="help-block">
									<?php
										if(is_array($additionaldata)):
											$ad=0;
											while(isset($additionaldata[$ad][0])):
												?>
													[ <?=$additionaldata[$ad]['NAMEFIELD']?>: <?=$additionaldata[$ad]['VALUE']?> ]
												<?php
												$ad++;
											endwhile;
										endif;
									?>
							</span>
						</div>
					</div>
        </div>
        <div class="span6">
        
					<div class="control-group"  >
						<label class="control-label" for="textfield">ESTADO RESERVA:</label>
						<div class="controls">
							<div class="input-prepend">
									<select name="assignStatusObj" id="assignStatusObj" onchange="assignStatus($(this),'<?=$booking['IDBOOKING']?>')" >
										<option <?=($booking['STATUS']=="6")?"selected":""?> value="6">PENDIENTE</option>
										<option <?=($booking['STATUS']=="2")?"selected":""?> value="2">CONFIRMADA</option>
										<option <?=($booking['STATUS']=="3")?"selected":""?> value="3">CANCELADA</option>
									</select>
							</div>
							<span class="help-block">
                Procedencia de la Reserva: <?php echo $booking['MEDIO']; ?>
              </span>
						</div>
					</div>        
        </div>
				<div class="span6">
					<div class="control-group">
						<label class="control-label" for="textfield">HABITACION:</label>
						<div class="controls">
							<div class="input-prepend">
								<select onchange="assignRoom($(this),'<?=$booking['IDBOOKING']?>')"  id="assignRoomObj" >
									<option <?=($booking['ROOM']=="0")?"selected":""?> value="0">SIN ASIGNAR</option>
									<?php
										foreach($avalaibleRooms as $key=>$value): ?>
											<option <?=($booking['ROOM']==$value[0]['IDROOM'])?"selected":""?>  value="<?=$value[0]['IDROOM']?>" ><?=$value[0]['NAME']?></option>
									<?php
										endforeach;
									?>
								</select>
							</div>
							<span class="help-block">
								TIPO DE HABITACION:
								<select  id="typeroominput" disabled="true"  onchange="assignTypeRoom($(this),'<?=$booking['IDBOOKING']?>')">
								<? foreach($typeRooms as $key=>$value): ?>
										<option <?=($booking['ROOMTYPE']==$value[0]['IDTYPEROOM'])?"selected":""?> value="<?=$value[0]['IDTYPEROOM']?>" ><?=$value[0]['NAME']?></OPTION>
								<? endforeach; ?>
								</select>
								<span class="add-on"><a onclick="$('#typeroominput').prop('disabled', false);" ><img src="http://www.assets.kipu.co/img/edit.png"></a></span>
							</span>
						</div>
					</div>
				</div>
			</form>
		</div>
		</div>
		<div class="tab-pane" id="financiera<?=$booking['IDBOOKING']?>">
      <div class="box-title" style="background: #fff !important; margin-top: 3px;">
        <h3>HOSPEDAJE</h3>
      </div>
			<div class="box-content nopadding">
				<form class="form-horizontal form-column form-bordered" method="POST" action="#">
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="textfield">VALOR RESERVA:</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on">$</span>
									<input type="text" style="width:70px"  onchange="assignValue($(this),'<?=$booking['IDBOOKING']?>')" disabled="true"  id="valueinput" value="<?=$booking['VALUEBOOKING']?>" />
									<span class="add-on"><a onclick="$('#valueinput').prop('disabled', false);" ><img src="http://www.assets.kipu.co/img/edit.png"></a></span>
								</div>
                <span class="help-block">
								VALOR POR NOCHE:  <?=round(($booking['VALUEBOOKING'])/(round((($booking['FECHA_FIN_UNIX'])*1-($booking['FECHA_INICIO_UNIX'])*1)/86400)))?>
 								# Noches: <span id="nights" ><?=round((($booking['FECHA_FIN_UNIX'])*1-($booking['FECHA_INICIO_UNIX'])*1)/86400)?></span>
                </span>

              </div>
						</div>
						<div class="control-group">
							<label class="control-label" for="textfield">SALDO PENDIENTE:</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on">$</span>
									<input class="input-small" style="width:70px" type="text"  disabled="true" id="valuenightinput" value="<?=($booking['VALUEBOOKING'])-($payuPayment['VALUE'])-($booking['VALUEPAYMENT'])?>" />
								</div>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="control-group">
							<label class="control-label" for="textfield">ESTADO PAGO:</label>
							<div class="controls">
								<div class="input-prepend">
										<select name="assignStatusPaymentObj" id="assignStatusPaymentObj" onchange="assignStatusPayment($(this),'<?=$booking['IDBOOKING']?>')" >
											<option <?=($booking['PAYMENT']=="1")?"selected":""?> value="1">PAGO REALIZADO</option>
											<option <?=($booking['PAYMENT']=="0")?"selected":""?> value="0">NO SE REPORTA PAGO</option>
											<option <?=($booking['PAYMENT']=="2")?"selected":""?> value="2">PAGO PARCIAL</option>
										</select>
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="textfield">TOTAL ABONADO:</label>
							<div class="controls">
								<div class="input-prepend">
									<span class="add-on">$</span>
									<input type="text" style="width:70px" onchange="assignOnlineValue($(this),'<?=$booking['IDBOOKING']?>')" disabled="true" id="payupaymentinput" value="<?=$payuPayment['VALUE']?>" />
									<span class="add-on">PAGO EN LINEA</span>
									<span class="add-on"><?=$payuPayment['VALUE']*100/$booking['VALUEBOOKING']?>%</span>
									<span class="add-on">
                    <a onclick="$('#payupaymentinput').prop('disabled', false);" >
                      <img src="http://www.assets.kipu.co/img/kate32.png">
                    </a>
                    <a onclick="getPayuData('<?php echo $booking['LINK']; ?>','<?php echo $booking['KEY']; ?>','<?php echo $booking['IDBOOKING']; ?>')" >
                      <img src="http://www.assets.kipu.co/img/info32.png">
                    </a>
                    <a onclick="" >
                      <img src="http://www.assets.kipu.co/img/refresh32.png">
                    </a>
                  </span>
									<br/>
									<span class="add-on">$</span>
									<input type="text" style="width:70px"  onchange="assignPaymentValue($(this),'<?=$booking['IDBOOKING']?>')" disabled="true"  id="paymentvalueinput" value="<?=$booking['VALUEPAYMENT']?>" />
									<span class="add-on">PAGO DIRECTO</span>
									<span class="add-on"><a onclick="$('#paymentvalueinput').prop('disabled', false);" ><img src="http://www.assets.kipu.co/img/edit.png"></a></span>
								</div>
							</div>
						</div>
					</div>
      </div>
      <div class="box-title" style="background: #fff !important; margin-top: 3px;">
        <h3>SERVICIOS ADICIONALES</h3>
      </div>
      <div class="box-content nopadding">
					<div  style="display:block" class="span12">
						<div class="control-group">
							<div class="additional-service">
                <select id="selector-service-<?=$booking['IDBOOKING']?>" name="service[]" onchange="" >
                  <?php foreach($serviceList as $key=>$value): ?>
                    <option value="<?=$value[0]['IDSERVICE']?>" ><?=$value[0]['NAME']?></option>
                  <?php endforeach; ?>
                </select>
                <a onclick="newService('<?=$booking['IDBOOKING']?>');" class="red-button">Agregar</a>
              </div>

							<div class="list-services-<?=$booking['IDBOOKING']?>">
								<?php
                $bs=0;
								while(isset($bookingServiceList[$bs]['ID'])):
								?>
									<div style="display:block" class="controls">
										<div class="" >
											<span class="title-service"><?=$serviceList[$bookingServiceList[$bs]['ID']][0]['NAME']?>: </span>
											Cantidad:
											<input style="width:50px" type="text" class="cs" id="textfield" value="<?=$bookingServiceList[$bs]['CANT']?>" class="spinner input-mini">
											Valor: <input type="text" class="vs" value="<?=$bookingServiceList[$bs]['VALUE']?>" >
											<input type='hidden' class='is' value="<?=$bookingServiceList[$bs]['ID']?>">
											<a onclick="saveService($(this),'<?=$formSaraDataService?>','<?=$booking['IDBOOKING']?>','update');" class="red-button update" >Actualizar</a>
											<a onclick="if (confirm('Estas seguro de eliminar este registro')){ saveService($(this),'<?=$formSaraDataService?>','<?=$booking['IDBOOKING']?>','delete'); }" class="red-button" >X</a>
										</div>
									</div>
								<?php
								$bs++;
								endwhile;
								?>

								<div  style="display:none" class="template-service<?=$booking['IDBOOKING']?> controls">
									<div class="">
										<span class="title-service"></span>
										Cantidad:
										<input style="width:50px" type="text" class="cs" id="textfield" value="1" class="spinner input-mini">
										Valor: <input type="text" class="vs">
										<input type='hidden' class='is'>
										<a onclick="saveService($(this),'<?=$formSaraDataService?>','<?=$booking['IDBOOKING']?>','add');" class="red-button save" >Guardar</a>
										<a style="display:none" onclick="saveService($(this),'<?=$formSaraDataService?>','<?=$booking['IDBOOKING']?>','update');" class="red-button update" >Actualizar</a>
										<a onclick="if (confirm('Estas seguro de eliminar este registro')){ saveService($(this),'<?=$formSaraDataService?>','<?=$booking['IDBOOKING']?>','delete'); }" class="red-button" >X</a>
									</div>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div>
			<div class="clear"></div>
		</div>
		<div class="tab-pane" id="huespedes<?=$booking['IDBOOKING']?>">
			<div class="box-title" style="background:#DDD !important; color:#000 !important; border:none !important; margin-top:5px;">
				<h3>INFORMACION HUESPEDES - ADULTOS: <?=$booking['NUMGUEST']?> NIÑOS: <?=$booking['NUMKIDS']?>
				</h3>
			</div>

			<?php $guestBooking=$this->getGuestBooking($booking['IDBOOKING'],$booking['IDCOMMERCE']); ?>

				<table class="table table-hover table-nomargin table-bordered " >
					<tr >
						<td style="font-weight:bold"><b>#</b></td>
						<td style="font-weight:bold"><b>IDENTIFICACION</b></td>
						<td style="font-weight:bold"><b>NOMBRE</b></td>
						<td style="font-weight:bold"><b>NACIONALIDAD</b></td>
						<td style="font-weight:bold"><b>EMAIL</b></td>
						<td style="font-weight:bold"><b>TELEFONO</b></td>
          </tr>

					<?php
						$mvu = "main-view".$booking['IDBOOKING'];
						$meu = "main-edit".$booking['IDBOOKING'];
					?>

          <!-- View -->
          <tr id="<?=$mvu?>" style="background:rgb(252, 252, 252);">
						<td>RESPONSABLE</td>
						<td><?=$booking['DNI']?></td>
						<td><?=$booking['NAMECLIENT']?></td>
						<td><?=$booking['COUNTRY']?></td>
						<td><?=$booking['EMAILCLIENT']?></td>
						<td><?=$booking['PHONECLIENT']?></td>
						<td><img onclick="$('#<?=$mvu?>').hide(); $('#<?=$meu?>').show();" src="http://www.assets.kipu.co/img/user.png"></td>
						<td><a href="">Enviar Encuesta</a></td>
					</tr>

          <!-- Edit -->

						<tr id="<?=$meu?>" class="user-edit" style="display:none; background:rgb(252, 252, 252);">
							<td>RESPONSABLE</td>
							<td><input id = "u-main-dni" value = "<?=$booking['DNI']?>" /></td>
							<td><input id = "u-main-name" value = "<?=$booking['NAMECLIENT']?>" /></td>
							<td><input id = "u-main-country" value = "<?=$booking['COUNTRY']?>" /></td>
							<td><input id = "u-main-email" value = "<?=$booking['EMAILCLIENT']?>" /></td>
							<td><input id = "u-main-phone" value = "<?=$booking['PHONECLIENT']?>" /></td>
	            <td colspan = "2" >
	            		<input id="u-value" type="hidden" value = "<?=$booking['ID']?>" />
	            		<img onclick="updateResponsible('#<?=$meu?>'); $('#uecancel').hide();" src="http://www.assets.kipu.co/img/check.png">
	            		<img id="uecancel" onclick="$('#<?=$mvu?>').show(); $('#<?=$meu?>').hide();" src="http://www.assets.kipu.co/img/uncheck.png">
	            </td>
						</tr>
			<?php
				$g=0;
				while(isset($guestBooking[$g][0])): ?>
					<tr>
						<td>INVITADO</td>
						<td><?=$guestBooking[$g]['DNI']?></td>
						<td><?=$guestBooking[$g]['NAMECLIENT']?></td>
						<td><?=$guestBooking[$g]['COUNTRY']?></td>
						<td><?=$guestBooking[$g]['EMAILCLIENT']?></td>
						<td><?=$guestBooking[$g]['PHONECLIENT']?></td>
					</tr>
			<?php
				$g++;
				endwhile;
			?>
				</table>
		</div>
	</div>
</div>
<br/><br/>
