<?php
		if(!isset($_SESSION)) session_start();
/*
*Classe responsavel por manipular Utilidades
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class Util{
	
		public $TG = array(); //Variavel para totais

		//Retorna codigo 6 digitos
		public function COD($num){
				return str_pad($num, 6, "0", STR_PAD_LEFT);
		}
		
		//Retorna H:m:s
		public function Horas($seg){
				$h = floor($seg / 3600);
				$seg -= $h * 3600;
				$m = floor($seg / 60);
				$seg -= $m * 60;
				
				if($h < 10) $h = "0".$h;
				if($m < 10) $m = "0".$m;
				if($seg < 10) $seg = "0".$seg;
				
				return $h.":".$m.":".$seg;
		}
		
		//Transforma Horas em decimal para calculos
		function t2d($time = 0){ 
		if($time != 0){
			$separar=explode(':',$time);
			floatval($min = 100 / 60);
			$decimal = $separar[0].".".($min*$separar[1]);
			return($decimal);	
		}
		}
		
		//Transforma Horas em decimal para calculos
		function d2t($dec = 0){ 
			$dec = str_replace(',','.',$dec);
			
			$time = 0;
			$timeDec = 0;
			
			$time = floor($dec);
			$h = $time;
			$m = floor(($dec - $time)*60);
			$s = str_pad((((($dec - $time)*60)-(floor(($dec - $time)*60))) * 60), 2, "0", STR_PAD_LEFT);
			
			if($s == 60){
					$m++;
					$s = "00";
			}
			if($m == 60){
					$h++;
					$m = "00";
			}
			$timeDec = str_pad(round($h), 2, "0", STR_PAD_LEFT).":".str_pad(round($m), 2, "0", STR_PAD_LEFT).":".str_pad(round($s), 2, "0", STR_PAD_LEFT); 
			return($timeDec);	
		}

}
?>