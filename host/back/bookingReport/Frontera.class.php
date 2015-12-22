<?
include_once("core/manager/Configurador.class.php");
include_once("core/auth/Sesion.class.php");

class FronterabookingReport{

	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $formulario;
	var $enlace;
	var $miConfigurador;
	
	function __construct()
	{
		$this->miSesion=Sesion::singleton();
		$this->miConfigurador=Configurador::singleton();
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB("master");
		$this->enlace=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."?".$this->miConfigurador->getVariableConfiguracion("enlace");
		$this->id_usuario=$this->miSesion->getValorSesion('idUsuario');
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

	function setSql($a)
	{
		$this->sql=$a;

	}

	function setFuncion($funcion){
		$this->funcion=$funcion;

	}

	
	function html(){
		
		include_once("core/builder/FormularioHtml.class.php");
		
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

		$this->miFormulario=new formularioHtml();

		$this->showHTML($_REQUEST);
		
	}
	
	
	function showReport($report){
	
		
		include_once($this->ruta."/html/{$report}/query.php");
		include_once($this->ruta."/html/{$report}/view.php");
		
	}

	public function orderArrayKeyBy($array,$key){
		$newArray=array();
		foreach($array as $name=>$value){
			$newArray[$value[$key]]=$array[$name];
		}
		return $newArray;
	}
	
	public function orderArrayMultiKeyBy($array,$key,$key2){
		$newArray=array();
		foreach($array as $name=>$value){
			$newArray[$value[$key]][$value[$key2]]=$array[$name];
		}
		return $newArray;
	}

	
	function showHTML($variable){
	
			
		$this->showMENU($report);
		$report=isset($variable['report'])?$variable['report']:"bookingHotel";
		
		if($report=="globalStats"){
			
			include_once("blocks/core/globalStats/Frontera.class.php");
			$visits=new FronteraglobalStats();
			$visits->token=$_REQUEST['piwiktoken'];
			$visits->site=$_REQUEST['piwiksite'];
			$visits->ruta="blocks/core/globalStats";
			$visits->showHTML();
			
		}else{
			$this->showReport($report);
		}
	
	
	}
	
	
	function showMENU(){
	
		$urlsummary="pagina=bookingReport";
		$urlsummary.="&report=bookingHotel";
		$urlsummary.="&piwiktoken=".$_REQUEST['piwiktoken'];
		$urlsummary.="&piwiksite=".$_REQUEST['piwiksite']; 
		$urlsummary=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($urlsummary,$this->enlace);

		$urlvisits="pagina=bookingReport";
		$urlvisits.="&report=globalStats";
		$urlvisits.="&piwiktoken=".$_REQUEST['piwiktoken'];
		$urlvisits.="&piwiksite=".$_REQUEST['piwiksite'];
		$urlvisits=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($urlvisits,$this->enlace);

		
		$urlrooms="pagina=bookingReport"; 
		$urlrooms.="&report=rooms";
		$urlrooms.="&piwiktoken=".$_REQUEST['piwiktoken'];
		$urlrooms.="&piwiksite=".$_REQUEST['piwiksite']; 
		$urlrooms=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($urlrooms,$this->enlace);

		
		include_once($this->ruta."/html/submenu.php");
	}
	
	
	

	function makeURL($param,$page){

		$formSaraData="pagina=".$page;
		$formSaraData.="&";
		$formSaraData.=$param;
		$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraData,$this->enlace);

		return $formSaraData;

	}


	function orderArrayByMonth($array){ 
		$newArray=array();
		foreach($array as $name=>$value){ 
			$newArray[$value['YEAR']][$value['MONTH']][]=$value['IDBOOKING'];
		}
		/*echo "<pre>";
			var_dump($newArray);
		echo "</pre>";*/
		return $newArray;
	}
	
	function bookingsByMonth($array){ 
		$result=array();
		$newArray=array();
		foreach($array as $name=>$value){ 
			$newArray[$value['YEAR']][$value['MONTH']][]=$value['TOTAL_MONEY'];
		}
		
		foreach($newArray as $year=>$month){
			foreach($month as $name=>$day){
				$period=$year.'-'.$name;
				$total=count($newArray[$year][$name]);
				$result[]=array("periodo"=>$period,"total"=>$total);
			}
		}
		
			
		/*echo "<pre>";
			var_dump(json_encode($result));
		echo "</pre>";*/
		return json_encode($result);
	}
	
	function moneyByMonth($array,$format){

		$result=array();

		foreach($array as $key=>$value){
			
			if($value['YEAR']<>"" && $value['MONTH']<>""){
				$period=$value['YEAR']."-".$value['MONTH'];
				if(!isset($money[$period])){
					$money[$period]=$value['MONEY_LOCAL']*1+$value['MONEY_ONLINE']*1;
				}else{
					$money[$period]=($money[$period]*1)+($value['MONEY_LOCAL']*1+$value['MONEY_ONLINE']*1);
				}
			}
		}
		
		 
		if($format===TRUE){
			foreach($money as $period=>$total){
				$result[]=array("periodo"=>$period,"total"=>number_format($total));
			}
		}else{
			foreach($money as $period=>$total){
				$result[]=array("periodo"=>$period,"total"=>$total);
			}
		}
		
		return json_encode($result);

	}
	
}
?>
