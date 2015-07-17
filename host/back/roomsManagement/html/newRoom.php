<tr>
	<form id="form-room">
		<td><input name="name"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" value=""  type="text" placeholder=""></td>
		<td>
			<select onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="typeroom"  id="plan" >
					<?PHP	
						echo "<option value='' type='text' >[selecciona]</option>";
						foreach($typeListRoom as $valueList){
							echo '<option value="'.$valueList['IDTYPEROOM'].'" type="text" >'.$valueList['NAME']."</option>";
						}
					?>
			</select>
		</td>
		<td><input name="currency-COP-1"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="0"  type="text" placeholder=""></td>																			
		<td><input name="currency-COP-2"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="0"  type="text" placeholder=""></td>
		<td><input name="currency-COP-3"  onchange="updateRoom('<?=$formSaraDataEdit?>',$(this.form))" name="name"  value="0"  type="text" placeholder=""></td>								
		<td><a style="cursor:pointer" onclick="if (confirm('Esta seguro de eliminar este establecimiento? Esta operacion no se puede deshacer')){ deleteRoom('<?=$formSaraDataDelete?>') }"  class="btn" rel="tooltip" title="Delete"><i class="icon-remove"></i></a></td>								
		<input name="idroom"  value="<?=$idNewRoom?>"  type="hidden" placeholder="">
	</form>	
</tr>
	