<div class="titulob">
<div class="tituloimg">
<h1>CREAR CLIENTE</h1>
</div>

</div>

<div id="main_user">
		
		<div class="row-fluid">
						<div class="span12">
							<div class="box box-bordered">
								
								<div class="box-content nopadding">
									
									<form action="index.php" method="POST" class='form-horizontal form-bordered'>

										<div class="control-group">
											<label for="textfield" class="control-label">Nombre</label>
											<div class="controls">
												<div class="input-prepend">
													<input name="name" type="text" value="" placeholder="">
												</div>
												<span class="help-block">
													
												</span>
											</div>
										</div>
										<div class="control-group">
											<label for="textfield" class="control-label">Apellido</label>
											<div class="controls">
												<div class="input-prepend">
													<input name="lastname" type="text" value="" placeholder="">
												</div>
												<span class="help-block">
													
												</span>
											</div>
										</div>
										<div class="control-group">
											<label for="textfield" class="control-label">Identificacion</label>
											<div class="controls">
												<div class="input-prepend">
													<input name="dni" type="text" value="" placeholder="">
												</div>
												<span class="help-block">
													
												</span>
											</div>
										</div>
										<div class="control-group">
											<label for="textfield" class="control-label">Nacionalidad</label>
											<div class="controls">
												<div class="input-prepend">
													<input name="country" type="text" value="" placeholder="">
												</div>
												<span class="help-block">
													
												</span>
											</div>
										</div>
										<div class="control-group">
											<label for="textfield" class="control-label">Correo</label>
											<div class="controls">
												<div class="input-prepend">
													<input name="email" type="text" value="" placeholder="">
												</div>
												<span class="help-block">
													
												</span>
											</div>
										</div>
										<div class="control-group">
											<label for="textfield" class="control-label">Tel&eacute;fono</label>
											<div class="controls">
												<div class="input-prepend">
													<input name="phone" type="text" value="" placeholder="">
												</div>
												<span class="help-block">
													
												</span>
											</div>
										</div>
										
										
										<!--div class="control-group">
											<label for="textfield" class="control-label">Servicio</label>
											<div class="controls">
												<select  id="my-select" name="service">
													<?php
													foreach($serviceList as $name=>$value){
																																								?>
														<option value="<?=$value['IDSERVICE']?>"  ><?=$value['TITLE']?></option>
													<?php
													}
													?>
												</select>
												<span class="help-block">
												</span>
											</div>
											
										</div-->
										
										
										
										
										<div class="form-actions">
											<button type="submit" class="btn btn-primary">Crear</button>
											<button type="button" class="btn">Cancel</button>
										</div>

									<input type='hidden' name='formSaraData' value="<?=$formSaraData?>">

									</form>
								</div>
							</div>
						</div>
					</div>
					
</div>
