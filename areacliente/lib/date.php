<?php
		//Classe que pega data/hora
		//Desenvolvida por Robert Willian
		//wmstudios.net
		//robertwillian@wmstudios.net
		class getDate{
			
			public $data;
			public $dia;
			public $mes;
			public $ano;
			
			public function setData($dIni = false, $saida = 'BR', $pVal = false, $pP = false){
							$this->pVal = $pVal;
							$this->pP = $pP;
							$this->saida = $saida;

					if(!$dIni){
							$d = getdate();
							$this->dia = $d['mday'];
							$this->mes = $d['mon'];
							$this->ano = $d['year'];
							
							if($this->dia < 10) $this->dia = "0".$this->dia;
							if($this->mes < 10) $this->mes = "0".$this->mes;
					}
					else{
							$d = explode("/",$dIni);
							$this->dia = $d[0];
							$this->mes = $d[1];
							$this->ano = $d[2];
					}
					
					if($this->pP == 1) $nD = date("Y-m-d",mktime(0,0,0,$this->mes,$this->dia+($this->pVal),$this->ano));	
					if($this->pP == 2) $nD = date("Y-m-d",mktime(0,0,0,$this->mes+($this->pVal),$this->dia,$this->ano));	
					if($this->pP == 3) $nD = date("Y-m-d",mktime(0,0,0,$this->mes,$this->dia,$this->ano+($this->pVal)));
					
					if($this->pP > 0){
							$dd = explode('-',$nD);
							$this->dia = $dd[2];
							$this->mes = $dd[1];
							$this->ano = $dd[0];
					}
					
					if(($this->saida == 'BR')) $this->dataBR();
					if($this->saida == 'BD') $this->dataBD();
			}
			
			function dataBR(){
					$this->data = $this->dia."/".$this->mes."/".$this->ano;
					return $this->data;
			}
			
			function dataBD(){
					$this->data = $this->ano."-".$this->mes."-".$this->dia;
					return $this->data;
			}
			
			function MesExtenso($M){
				switch($M){
					case '01' : return "JANEIRO";
					break;
					case '02' : return "FEVEREIRO";
					break;
					case '03' : return "MARÇO";
					break;
					case '04' : return "ABRIL";
					break;
					case '05' : return "MAIO";
					break;
					case '06' : return "JUNHO";
					break;
					case '07' : return "JULHO";
					break;
					case '08' : return "AGOSTO";
					break;
					case '09' : return "SETEMBRO";
					break;
					case '10' : return "OUTUBRO";
					break;
					case '11' : return "NOVEMBRO";
					break;
					case '12' : return "DEZEMBRO";
					break;					
					
				}
			}
			
			public function RetornaDias($Dt){
					$DIni = strtotime($Dt);
					$DAtu = strtotime(date('Y-m-d H:i:s'));
					
					$Res = $DAtu - $DIni;
					
					return (($Res / 3600) / 24);
			}
			
			public function RetornaHoras($Dt){
					$DIni = strtotime($Dt);
					$DAtu = strtotime(date('Y-m-d H:i:s'));
					
					$Res = $DAtu - $DIni;
					
					$Fator = 100/72;
					
					return ((($Res / 3600) * $Fator) >= 100) ? 100 : (($Res / 3600) * $Fator);
					//return $Fator;
			}
			
			public function DifHoras($SEG){
					$H = number_format(($SEG / 3600),0,'','');
					$M = number_format((($SEG % 3600) / 60),0,'','');
					
					$H = ($H < 10) ? "0".$H : $H;
					$M = ($M < 10) ? "0".$M : $M;
					
					return $H.":".$M;
			}

		}
?>