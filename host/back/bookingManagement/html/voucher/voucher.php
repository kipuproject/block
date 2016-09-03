<?php
require('fpdf.php');

setlocale(LC_ALL,"es_ES");
class PDF extends FPDF
{

var $B;
var $I;
var $U;
var $HREF;
var $nombrehotel;
var $reference;

	
function PDF($orientation='P', $unit='mm', $size='A4')
{

	// Llama al constructor de la clase padre
	$this->FPDF($orientation,$unit,$size);
	// Iniciación de variables
	$this->B = 0;
	$this->I = 0;
	$this->U = 0;
	$this->HREF = '';
	

}

function WriteHTML($html)
{
	// Intérprete de HTML
	$html = str_replace("\n",' ',$html);
	$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			// Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			// Etiqueta
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extraer atributos
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])] = $a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}


function SetStyle($tag, $enable)
{
	// Modificar estilo y escoger la fuente correspondiente
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

// Cabecera de página
function Header()
{
	// Logo y fondo
	
	$this->Image($this->logo,25,15,0,0,'',''); 
	$this->Image($this->rutaURL.'/html/voucher/imagenes/voucher.png',4,1,290,0,'','');
	$this->Cell(10);
	$this->Ln(0);
}

function certificado()
{
	$nombrehotel=$this->nombrehotel; 
	$reference=$this->reference;
	
	$this->SetFont('Arial','',16);
	$this->SetDrawColor(0,80,180);
	$this->SetFillColor(0,230,0);
	$this->SetTextColor(104,102,102);
	$this->SetX(-100);
	$this->SetY(70);
	$this->Cell(250,-80,$nombrehotel,10,0,'C');
	$this->Cell(-85,-80,$reference,0,0,'C');

	}
	function certificado2()
{
	
	$this->SetFont('Arial','',16);
	$this->SetDrawColor(0,80,180);
	$this->SetX(0);
	
	}

}
//Variables:


?>
