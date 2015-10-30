<?php

include_once('date.php');
/*
*Classe responsavel por manipular MySql
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class Search{
		public $Where = null;
		public $DataIni = null;
		public $DataFim = null;
		
		public function Search(){
				$d = new getDate;
		}
		
		public function Like($cmp = null, $input = null){
				$array = strpos($cmp,',');
				
				if($array === false){
						if((!empty($cmp)) && (!empty($input))){
								if(empty($this->Where)) return $this->Where = $cmp." LIKE '%".$input."%' ";
								else return $this->Where .= " AND ".$cmp." LIKE '%".$input."%' ";
						}
				}else{
						$arr = explode(',',$cmp);
						$ExitLike = null;
						foreach($arr as $key => $val){
								if($key == 0) $ExitLike .= $val." LIKE '%".$input."%'";
								else $ExitLike .= " OR ".$val." LIKE '%".$input."%'";
						}


						if(empty($this->Where)) return $this->Where = "(".$ExitLike.")";
						else return $this->Where .= " AND (".$ExitLike.")";
				}
		}
		
		public function Igual($cmp = null, $input = null){
				$array = strpos($cmp,',');
				
				if($array === false){
						if((!empty($cmp)) && (!empty($input))){
								if(empty($this->Where)) return $this->Where = $cmp." = '".$input."' ";
								else return $this->Where .= " AND ".$cmp." = '".$input."' ";
						}
				}else{
						$arr = explode(',',$cmp);
						$ExitIgual = null;
						foreach($arr as $key => $val){
								if($key == 0) $ExitIgual .= $val." = '".$input."'";
								else $ExitIgual .= " OR ".$val." = '".$input."'";
						}


						if(empty($this->Where)) return $this->Where = "(".$ExitIgual.")";
						else return $this->Where .= " AND (".$ExitIgual.")";
				}
		}
		
		public function Diferente($cmp = null, $input = null){
				if((!empty($cmp)) && (!empty($input))){
						if(empty($this->Where)) return $this->Where = $cmp." != '".$input."' ";
						else return $this->Where .= " AND ".$cmp." != '".$input."' ";
				}
		}
				
		public function Menor($cmp = null, $input = null){
				if((!empty($cmp)) && (!empty($input))){
						if(empty($this->Where)) return $this->Where = $cmp." < '".$input."' ";
						else return $this->Where .= " AND ".$cmp." < '".$input."' ";
				}
		}
				
		public function Maior($cmp = null, $input = null){
				if((!empty($cmp)) && (!empty($input))){
						if(empty($this->Where)) return $this->Where = $cmp." > '".$input."' ";
						else return $this->Where .= " AND ".$cmp." > '".$input."' ";
				}
		}
				
		public function Periodo($cmp = null, $dIni = null, $dFim = null){
				if(!empty($dIni)){
						$d = new getDate;
						$d->setData($dIni,'BD');
						$dIni = $d->data;
						$d->dataBR();
						$this->DataIni = $d->data;
				}else {
						$d = new getDate;
						$d->setData();
						$d->setData($d->data,'BD');
						$dIni = $d->ano.'-'.$d->mes.'-01';
						$d->dataBR();
						$this->DataIni = '01/'.$d->mes.'/'.$d->ano;
				}
				
				if(!empty($dFim)){
						$d = new getDate;
						$d->setData($dFim,'BD');
						$dFim = $d->data;
						$d->dataBR();
						$this->DataFim = $d->data;
				}else {
						$d = new getDate;
						$f = new getDate;
						$d->setData();
						$nData = "01/".$d->mes."/".$d->ano;
						$d->setData($nData,'BD',1,2);
						$d->setData($d->dataBR(),'BD',-1,1);
						$dFim = $d->data;
						$d->dataBR();
						$this->DataFim = $d->data;
				}
				
				if(empty($this->Where)) return $this->Where = " (".$cmp." BETWEEN '".$dIni."' AND '".$dFim."') ";
				else return $this->Where .= " AND (".$cmp." BETWEEN '".$dIni."' AND '".$dFim."') ";
		}
}
?>