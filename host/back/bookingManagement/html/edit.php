<div id="main_user">
	<div class="page-header">
		<div class="pull-left">
			<h1>ESTABLECIMIENTO/EMPRESA</h1>
		</div>
	</div>
	<div class="accordion accordion-widget" id="accordion3">
		<div class="accordion-group blue">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#c1">
					DATOS GENERALES DE LA EMPRESA
				</a>
			</div>
			<div id="c1" class="accordion-body collapse in">
				<div class="accordion-inner">
					
					<form  id="companyData"  action="index.php" method="POST" class='form-horizontal form-bordered'>
					<span id="status" ></span>
					<div class="control-group">
						<label for="textfield" class="control-label">Nombre</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="nombre" value="<?=$company['NOMBRE']?>" type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>
					<div class="control-group">
						<label for="textfield" class="control-label">Descripcion</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="descripcion"  value="<?=$company['DESCRIPCION']?>"  type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>
					<div class="control-group">
						<label for="textfield" class="control-label">Contacto</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="contacto"  value="<?=$company['CONTACTO']?>"  type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>
					<div class="control-group">
						<label for="textfield" class="control-label">URL</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="url"  value="<?=$company['URL']?>"  type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>
					<div class="control-group">
						<label for="textfield" class="control-label">Email</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="email" value="<?=$company['EMAIL']?>" type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>
					<div class="control-group">
						<label for="textfield" class="control-label">Direccion</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="direccion"  value="<?=$company['DIRECCION']?>"  type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>
					<div class="control-group">
						<label for="textfield" class="control-label">Telefono</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="telefono"  value="<?=$company['TELEFONOS']?>"  type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>

					<div class="form-actions">
						<a onclick="updateForm('<?=$formSaraDataCompany?>','#companyData')" class="btn btn-primary">Actualizar</a>
					</div>
					</form>				
				</div>
			</div>
		</div>

		<!--Inicio Comercio-->

		<?PHP
		$i=0;
		while(isset($commerce[$i]['IDCOMMERCE'])){
		?>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#c2">
					<?=$commerce[$i]['NAME']?> (<?=$commerce[$i]['NAMETYPE']?>)
				</a>
			</div>
			<div id="c2" class="accordion-body collapse">
				<div class="accordion-inner">
					<div class="box-content nopadding">
						<ul class="tabs tabs-inline tabs-top">
							<li class='active'>
								<a href="#first11" data-toggle='tab'><i class="icon-inbox"></i> Datos del Comer‭cio</a>
							</li>
							<li>
								<a href="#second22" data-toggle='tab'><i class="icon-share-alt"></i> Caracteriscas</a>
							</li>
							<li>
								<a href="#thirds3322" data-toggle='tab'><i class="icon-tag"></i> Configuracion del Calendario</a>
							</li>
						</ul>
						<div class="tab-content padding tab-content-inline tab-content-bottom">
							<div class="tab-pane active" id="first11">
								<form id="commerceDataBasic"action="index.php" method="POST" class='form-horizontal form-bordered'>

								<div class="control-group">
									<label for="textfield" class="control-label">Nombre</label>
									<div class="controls">
										<div class="input-prepend">
											<input name="nombre" value="<?=$commerce[$i]['NAME']?>" type="text" placeholder="">
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
											<input name="descripcion"  value="<?=$commerce[$i]['DESCRIPTION']?>"  type="text" placeholder="">
										</div>
										<!--span class="help-block">
											-
										</span-->
									</div>
								</div>
								<div class="control-group">
									<label for="textfield" class="control-label">Metodo de Reserva</label>
									<div class="controls">

										<label class="radio">
											 <input name="method" value="IR" type="radio" <?PHP echo $check=($commerce[$i]['METHOD']=="IR")?"checked":"" ?> > ITEM RESERVABLE 	
										</label>
										<label class="radio">
											 <input name="method" value="NP" type="radio" <?PHP echo $check=($commerce[$i]['METHOD']=="NP")?"checked":"" ?> > NUMERO DE PERSONAS 
										</label>
										<!--span class="help-block">
											-
										</span-->
									</div>
								</div>
								<div class="control-group">
									<label for="textfield" class="control-label">Direccion</label>
									<div class="controls">
										<div class="input-prepend">
											<input name="direccion"  value="<?=$commerce[$i]['ADDRESS']?>"  type="text" placeholder="">
										</div>
									</div>
								</div>
								<div class="control-group">
									<label for="textfield" class="control-label">Capacidad Maxima</label>
									<div class="controls">
										<div class="input-prepend">
											<input name="capacidad"  value="<?=$commerce[$i]['CAPACITY']?>"  type="text" placeholder="">
										</div>
										<span class="help-block">
											Numero maximo de personas
										</span>
									</div>
								</div>
									<input type='hidden' name='optionValue' value="<?=$commerce[$i]['IDCOMMERCE']?>">
									<input type='hidden' name='optionTab' value="basic">
									<div class="form-actions">
										<a onclick="updateForm('<?=$formSaraDataCommerce?>','#commerceDataBasic')" class="btn btn-primary">Actualizar</a>
									</div>
								</form>	
							</div>

							<!--TAB 2 -->

							<div class="tab-pane" id="second22">

								<form id="commerceDataFeatures" class="form-horizontal form-bordered" method="POST" action="index.php">

								<?PHP $component=$this->loadFiltersByCommerce($commerce[$i]['IDTYPE'],$commerce[$i]['IDCOMMERCE']);

									foreach($component as $keyComponent=>$option){

										echo "<div class='control-group'>";

										echo "	<label for='textfield' class='control-label'>{$keyComponent}</label>";

										echo "	<div class='controls'>";

										foreach($option as $keyOption=>$value){
	
											$checked=($value['CHECKED']=="true")?"checked":"";

											echo "	<label class='radio'>";
											echo "		 <input name='optionFeature[]'  value='".$value['ID_OPCION']."' type='checkbox' {$checked} > {$value['NOMBRE_OPCION']}";
											echo "	</label>";	
										}
										
										echo "	</div>";
										
										echo "</div>";
									}


								?>

									<input type='hidden' name='optionValue' value="<?=$commerce[$i]['IDCOMMERCE']?>">
									<input type='hidden' name='optionTab' value="features">
									<div class="form-actions">
										<a onclick="updateForm('<?=$formSaraDataCommerce?>','#commerceDataFeatures')" class="btn btn-primary">Actualizar</a>
									</div>
								</form>


							</div>
							<div class="tab-pane" id="thirds3322">
								<form id="commerceDataTime" class="form-horizontal form-bordered" method="POST" action="index.php">
									<div class="controls">
											<div class="input-prepend">
												<input name="intervalo"  id="intervalo"  value="<?=$commerce[$i]['INTERVALO']?>"  type="text" placeholder="">
											</div>
											<span class="help-block">
												Duracion de cada reserva en segundos (Ej 3600segs = 1hora)
											</span>
									</div>
									<input type='hidden' name='optionValue' value="<?=$commerce[$i]['IDCOMMERCE']?>">
									<input type='hidden' name='optionTab' value="time">
									<div class="form-actions">
										<a onclick="updateForm('<?=$formSaraDataCommerce?>','#commerceDataTime')" class="btn btn-primary">Actualizar</a>
									</div>
								</form>
							</div>
									
						</div>
					</div>
				</div>
			</div>
		</div>
		<?PHP
		$i++;
		}
		?>
		<!--Fin Comercio-->




	</div>
		
					
</div>
