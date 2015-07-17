<?php
foreach($menuList as $key=>$submenu):
?>
	<ul  class="menu">
		<?php
			foreach($submenu as $namesubmenu=>$value):
		?>
				<li>
					<?php
					if($value['ICONO']<>""):
					?>
						<img style="float:left;" src="<?=$value['ICONO']?>">
					<?php
					endif;
					?>
					<a style="float:right; cursor:pointer"  href="<?=$this->makeURL($value['PARAMETRO'],$value['PAGINA'])?>"><?=$value['NOMBRE']?></a>

				</li>

		<?php
			endforeach;
		?>
	</ul>

	<select class="menuselect" ONCHANGE="location = this.options[this.selectedIndex].value;">
		<?php
			foreach($submenu as $namesubmenu=>$value):
		?>

  <option value="<?=$this->makeURL($value['PARAMETRO'],$value['PAGINA'])?>">
		<?php echo $value['NOMBRE']; ?>

  </option>

		<?php
			endforeach;
		?>
 </select>



<?php
endforeach;
?>


