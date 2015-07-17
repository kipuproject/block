<div id="main_user">
		<div class="page-header">
					<div class="pull-left">
						<h1>CREAR ESTABLECIMIENTO</h1>
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
						<label for="textfield" class="control-label">Nombre Empresa</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="nameCompany" value="" class="required" type="text" placeholder="">
							</div>
							<span class="help-block">
								Corresponde al nombre de la empresa no necesariamente es el nombre del Comercio o establecimiento
							</span>
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
						<label for="textfield" class="control-label">Nombre Contacto</label>
						<div class="controls">
							<div class="input-prepend">
								<input name="manager"  value=""  type="text" placeholder="">
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
								<input name="email" value="" type="text" placeholder="">
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
								<input name="address"  value=""  type="text" placeholder="">
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
								<input name="phone"  value=""  type="text" placeholder="">
							</div>
							<!--span class="help-block">
								-
							</span-->
						</div>
					</div>

					<div class="form-actions">
						<a onclick="addCompany('<?=$formSaraDataCompany?>','#companyData')" class="btn btn-primary">Crear Empresa</a>
					</div>
					</form>	

					<form  id="commerceData"  action="index.php" method="POST" class='form-horizontal form-bordered'>
						<input type="hidden" value="" id="idCompany" name="idCompany"  />
						<div class="control-group">
							<label for="textfield" class="control-label">Asociar Comercio</label>
							<div class="controls">
								<div class="input-prepend">
									<select name="commercetype"  id="commercetype" >
									<?PHP	
											foreach($categoryListCommerce as $valueList){
												$selected=($commerce[$i]['IDTYPE']==$valueList['IDCATCOMMERCE'])?"selected":"";
												echo '<option value="'.$valueList['IDCATCOMMERCE'].'" type="text" '.$selected.' >'.$valueList['NAME']."</option>";
											}
									?>
									</select>
									<a onclick="addCommerce('<?=$formSaraDataAddCommerce?>','#commerceData')" class="btn btn-primary">CREAR</a>
								</div>
								<!--span class="helprocessEditprocessEditp-block">
									-
								</span-->
							</div>
						</div>
				
					</form>
					
				</div>
			</div>
		</div>
		
		<div id="allCommerce">
		</div>
	</div>				
</div>
