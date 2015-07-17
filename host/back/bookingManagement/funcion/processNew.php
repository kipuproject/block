<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	if(!empty($_POST))
	{
		
		$errors = array();
		$email = trim($_POST["email"]);
		$this->data['nombre']=$nombre = trim($_POST["nombre"]);
		$this->data['apellido']=$apellido = trim($_POST["apellido"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
		//$birthday= trim($_POST["birthday"]);
		$birthday="";
		
	
		if (!$this->miInspectorHTML->isValidEmail($email))
		{
			$this->mensaje['error'][] = "- Por favor ingresa un email valido";
		}else{
			
			$cadena_sql=$this->sql->cadena_sql("searchEmail",$email);
			$registro=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
			
			if(is_array($registro)){
				$this->mensaje['error'][] = "- Ya tenemos un registro con este correo.";
			}

		}	
		if($this->miInspectorHTML->minMaxRange(5,25,$password))
		{
			$this->mensaje['error'][] = "- Tu clave debe tener entre 5 y 25 caracteres";
		}

		if($password != $confirm_pass)
		{
			$this->mensaje['error'][] = "- La confirmacion de la clave no coincide";
		}

		//End data validation

		if(count($this->mensaje['error']) == 0)
		{	

			$cadena_sql=$this->sql->cadena_sql("insertUser",array("nombre"=>$nombre,"apellido"=>$apellido,"password"=>$password,"email"=>$email,"birthday"=>$birthday));
			$status=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");

			$id=$this->miRecursoDB->ultimo_insertado();


			if(is_array($_POST["role"])){
				foreach($_POST["role"] as $name=>$value){
					$cadena_sql=$this->sql->cadena_sql("insertarSubsistema",array("id"=>$id,"subsistema"=>$value));
					$registro=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
				}
			}

			if(is_array($_POST["companies"])){
				foreach($_POST["role"] as $name=>$value){
					$cadena_sql=$this->sql->cadena_sql("insertarEstablecimiento",array("id"=>$id,"company"=>$value));
					$registro=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
				}
			}


			if(!$status)
			{
				$this->mensaje['error'][] = "Error!";
				return $this->status=FALSE;
			}
			else
			{
				//enviar email
				//mensae
				$this->mensaje['exito'][] = "Registro fue exitoso";
				return $this->status=TRUE;
			}
		}else{

			return $this->status=FALSE;
		}
	}else{
	
		return $this->status=FALSE;

	}
	
	return $this->status=TRUE;


}
?>
