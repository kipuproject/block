<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#c2_<?=$time?>">
					NUEVO COMERCIO TIPO <?=$typeCommerce?>
				</a>
			</div>
			<div id="c2_<?=$time?>" class="accordion-body collapse">
				<div class="accordion-inner">
					<div class="box-content nopadding">
						<ul class="tabs tabs-inline tabs-top">
							<li class='active'>
								<a href="#first11" data-toggle='tab'><i class="icon-inbox"></i> Datos Basicos del Comercio</a>
							</li>
							
						</ul>
						<div class="tab-content padding tab-content-inline tab-content-bottom">
							<div class="tab-pane active" id="first11">
								<form id="commerceDataBasic_<?=$time?>" action="index.php" method="POST" class='form-horizontal form-bordered'>
								
								
								<input type="hidden" name="commercetype" value="<?=$typeCommerce?>" />
								
								<div class="control-group">
									<label for="textfield" class="control-label">Tipo de Plan</label>
									<div class="controls">
										<div class="input-prepend">
											<select name="plan"  id="plan" >
											<?PHP	
													$categoryListPlan=array(array('IDPLAN'=>'1','NAMEPLAN'=>'Gratuito'),array('IDPLAN'=>'2','NAMEPLAN'=>'Standard'),array('IDPLAN'=>'3','NAMEPLAN'=>'Intermedio'),array('IDPLAN'=>'4','NAMEPLAN'=>'Premium'));
													foreach($categoryListPlan as $valueListPlan){
														$selected=($commerce[$i]['PLAN']==$valueListPlan['IDPLAN'])?"selected":"";
														echo '<option value="'.$valueListPlan['IDPLAN'].'" type="text" '.$selected.' >'.$valueListPlan['NAMEPLAN']."</option>";
													}
											?>
											</select>
										</div>
										<!--span class="helprocessEditprocessEditp-block">
											-
										</span-->
									</div>
								</div>
								<div class="control-group">
									<label for="textfield" class="control-label">Nombre</label>
									<div class="controls">
										<div class="input-prepend">
											<input name="nameCommerce" value="" type="text" placeholder="">
										</div>
										<!--span class="helprocessEditprocessEditp-block">
											-
										</span-->
									</div>
								</div>
								<div class="control-group">
									<label for="textfield" class="control-label">Descripcion</label>
									<div class="controls">
										<div class="input-prepend">
											<input name="description"  value=""  type="text" placeholder="">
										</div>
										<!--span class="help-block">
											-
										</span-->
									</div>
								</div>

								
								
								<div class="control-group">
									<label for="textfield" class="control-label">Ruta Principal Archivos</label>
									<div class="controls">
										
									</div>
								</div>
								
									<div class="form-actions">
										<a onclick="updateForm('<?=$formSaraData?>','#commerceDataBasic_<?=$time?>','<?=$reload?>'); " class="btn btn-primary">Guardar</a>
									</div>
								</form>	
							</div>

							
									
						</div>
					</div>
				</div>
			</div>
		</div>