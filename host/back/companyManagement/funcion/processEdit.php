<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	switch($option){
		case "processEditCompany":	
		
			$cadena_sql=$this->sql->cadena_sql("updateDataCompany",$_REQUEST);
			$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");
			$this->mensaje="Datos Actualizados Correctamente";
			return $this->status=FALSE;
			
		break;
		case "processEditCommerce":	
			$this->mensaje=$_REQUEST['optionTab'];
			switch($_REQUEST['optionTab']){
				case "basic":
					
					if(!isset($_REQUEST['jxajax'])){
						//var_dump($_FILES);
						$varprom='imgpromociones-'.$_REQUEST['optionValue'];
						$vargal='imggaleria-'.$_REQUEST['optionValue'];
						$varmenu='filemenu-'.$_REQUEST['optionValue'];
						$varlogo='fileImage-'.$_REQUEST['optionValue'];
						if(isset($_FILES[$varprom])){
							$imgs->actionUploadFile($_FILES[$varprom]['name'],$varprom,$_REQUEST["file_folder_".$varprom]);
						}
						if(is_array($_FILES[$vargal])){
							$imgs->actionUploadFile($_FILES[$vargal]['name'],$vargal,$_REQUEST["file_folder_".$vargal]);
						}
						if(is_array($_FILES[$varmenu])){
							$_REQUEST['menu']=$_FILES[$varmenu]['name'][0];
							
							if($_REQUEST['menu']<>""){
								$imgs->actionUploadFile($_FILES[$varmenu]['name'],$varmenu,$_REQUEST["file_folder_".$varmenu]);
								$cadena_sql=$this->sql->cadena_sql("updateDataCommerceMenu",$_REQUEST);
								$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");
							}
						}
						
						if(is_array($_FILES[$varlogo])){
							$_REQUEST['logo']=$_FILES[$varlogo]['name'][0];
							
							if($_REQUEST['logo']<>""){
								$imgs->actionUploadFile($_FILES[$varlogo]['name'],$varlogo,$_REQUEST["file_folder_".$varlogo]);
								$cadena_sql=$this->sql->cadena_sql("updateDataCommerceLogo",$_REQUEST);
								$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");
							}
							
						}
					 
						//echo var_dump($imgs->mensaje);
						$formSaraData="pagina=companyManagement";
						$formSaraData.="&saramodule=host"; 
						$formSaraData.="&optionValue=".$_REQUEST['optionValue'];
						$formSaraData.="&option=edit";
						$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraData,$this->enlace);
						
						echo "<script>location.replace('".$formSaraData."')</script>";
										  
					}else{
            
						$cadena_sql=$this->sql->cadena_sql("updateDataCommerceBasic",$_REQUEST);
						$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");
						$this->mensaje="Datos Basicos Actualizados Correctamente";
					
					}
						
					
				break;
				case "features":

					$cadena_sql=$this->sql->cadena_sql("deleteDataCommerceFeatures",$_REQUEST);
					$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");

					foreach($_REQUEST['optionFeature'] as $value){
						$_REQUEST['optionValFeature']=$value;
						$cadena_sql=$this->sql->cadena_sql("insertDataCommerceFeatures",$_REQUEST);
						$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");

					}

					$this->mensaje="Datos de descripcion Actualizados Correctamente";


				break;
				case "time":
					$cadena_sql=$this->sql->cadena_sql("updateDataCommerceTime",$_REQUEST);
					$result=$this->masterResource->ejecutarAcceso($cadena_sql,"");
					$this->mensaje="Datos de Actualizados Correctamente";
				break;
			}


			return $this->status=FALSE;
		break;
		default:
			$this->mensaje="Datos incorrectos";
			return $this->status=FALSE;
		break;
	}
	return $this->status=FALSE;


}
?>
