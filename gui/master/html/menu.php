
<div class="container-fluid">
	<div class='main-navx'>

			<div class="menu_master">
				<a>
					<form id="ftypecommerce">
						<span>Tipo de Comercio</span>
						<select name="typecommerce"  onchange="$('#ftypecommerce').submit()" >
							<?php foreach($typesList as $key=>$value): ?>

								<option <?=($currentType<>"" && $currentType==$commerceTypes[$value]['IDTYPE'])?"selected":""?> value="<?=$commerceTypes[$value]['IDTYPE']?>"><?=$commerceTypes[$value]['NAME']?> </option>

							<?php endforeach; ?>
						</select>

						<input type="hidden" name="formSaraData" value="<?php echo $formSaraDataCommerce; ?>" />
						<input type="hidden" name="option" value="updateType" />
						<input type="hidden" name="currentType" value="<?php echo $commerceList[0]['TYPECOMMERCE']; ?>" />

					</form>
				</a>
			</div>


			<div class="menu_master">
				<a>
					<form id="fcommerce">

						<span>Comercio</span>

						<select name="commerce" onchange="$('#fcommerce').submit()">
							<?php foreach($commerceList as $key=>$value): ?>

								<option <?=($commerce<>"" &&  $commerce==$value['IDCOMMERCE'])?"selected":""?>  value="<?=$value['IDCOMMERCE']?>" ><?=$value['NAME']?> </option>

							<?php endforeach; ?>

						</select>

						<input type="hidden" name="formSaraData" value="<?=$formSaraDataCommerce?>" />
						<input type="hidden" name="option" value="updatecommerce" />
						<input type="hidden" name="currentType" value="<?=$commerceList[0]['TYPECOMMERCE']?>" />

					</form>
				</a>
			</div>

	</div>

</div>
