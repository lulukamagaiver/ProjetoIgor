<?php
include_once('db-conex.php');

/*
*Classe responsavel por exibir relatorios
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class Relat extends DBConex{
		public $Width = null; 
		public $Cols = null;
		public $Query = null; 
		public $Titulos = null; 
		public $Formato = null; 
		public $Totais = null;
		public $Debug = false;
		public $ResultTab = null;
		public $WidthCols = null;
		public $Actions = null;
		
		
		public $Soma = null;
		 
      
      
		//cconstrutor
		public function Relat($Largura = '100%', $TabDebug = false){
			$this->Width = $Largura;
			$this->Debug = $TabDebug;
			$this->Soma = $this->Totais;
			
			$this->setWidth();
			
			parent::DBConex();
		}
		
		//Deeina Tamanho em largura da Tabela
		//Default: 100%
		public function setWidth(){
			return $this->ResultTab = '<div class="fundoTabela" style="width:'.$this->Width.';">';
		}
		
		//Definine Tilulos, largura colunas, e alinhamento
		public function setTitulos($TabTitulos = null){
			$this->Titulos = $TabTitulos;
			
			$this->ResultTab .= '<div class="topoTabela">';
			
			if(is_array($this->Titulos)){
				$opcoes = null;
				$a =-1;
				
				foreach($this->Titulos as $key => $val){
					$back = null;
					$a++;
					$ultimo = array_keys($this->Titulos);
					if (($key == (end($ultimo))) && ($this->Debug)) $back = "background-color:#00C;";
					$opcoes = explode(':',$val);
					$this->ResultTab .= '<div style="width:'.$this->WidthCols[$a].'px; text-align:'.((!empty($opcoes[1])) ? $opcoes[1] : '').';'.$back.'">'.((!empty($opcoes[0])) ? $opcoes[0] : '').'</div>';
				}
			}
			
			
			return $this->ResultTab .= '</div>';
		}
		
		//Exibe Resultados
		public function showLinhas(){
			$this->Tabs = $this->Cols;
			$this->ExecSQL($this->Query);
			$this->Load();
			
			$align = null;
			$this->Soma = $this->Totais;

			if($this->NumRows > 0){
					for($a = 0; $a < $this->NumRows; $a++){
							$this->ResultTab .= '<div class="linhasTabela">';
								$b = 0;
								foreach($this->Tabs as $key => $val){
										if(($val == 'action') || ($val == 'item')){
												if($val == 'action') $this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px;">'.$this->DefACtion($this->Actions).'</div>';
												if($val == 'item') $this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px;">'.($a + 1).'</div>';
												//echo $this->DefACtion($this->Actions);
										}else{
										
										$align = explode(":",$this->Titulos[$b]);
										//echo "<pre>".print_r($this->Soma)."</pre><br />";
												
												//Calcula total coluna
												if(is_array($this->Totais)){
														if($this->Totais[$b] == 1){
																$this->Soma[$b] = ($this->Soma[$b] + $this->{$val});
														}
												}
												
												if(($this->Formato[$b] == "texto") || ($this->Formato[$b] == "")) $this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px; text-align:'.$align[1].';">'.$this->{$val}.'</div>';
												elseif($this->Formato[$b] == "moeda") {
													if($this->{$val} > 0) $this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px;">R$ '.number_format($this->{$val},2,',','.').'</div>';
													else$this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px;">-</div>';
												}
												elseif($this->Formato[$b] == "data") $this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px;">'.date("d/m/Y",strtotime($this->{$val})).'</div>';
												elseif($this->Formato[$b] == "cod") $this->ResultTab .= '<div style="width:'.$this->WidthCols[$b].'px;">'.$this->COD($this->{$val}).'</div>';
												
												
										}
										$b++;
								}
							$this->ResultTab .= '</div>';
							$this->Next();
					}
			}
		}
		
		//Gera soma final da tabela
		public function showTotal(){
				if(($this->Totais != 0) && (is_array($this->Totais))){
						$this->ResultTab .= '<div class="topoTabela">';
								
								foreach($this->Totais as $key => $val){
										if(($this->Totais[$key] == 1) && ($this->Cols != 'action')){
										$align = explode(":",$this->Titulos[$key]);

												if(($this->Formato[$key] == "texto") || ($this->Formato[$key] == "")) $this->ResultTab .= '<div style="width:'.$this->WidthCols[$key].'px; text-align:'.$align[1].';">'.($this->Soma[$key] - 1).'</div>';
												elseif($this->Formato[$key] == "moeda") $this->ResultTab .= '<div style="width:'.$this->WidthCols[$key].'px;">R$ '.number_format(($this->Soma[$key] - 1),2,',','.').'</div>';
												elseif($this->Formato[$key] == "data") $this->ResultTab .= '<div style="width:'.$this->WidthCols[$key].'px;">'.date("d/m/Y",strtotime($this->Soma[$key])).'</div>';

										}else{
											
												$this->ResultTab .= '<div style="width:'.$this->WidthCols[$key].'px;"></div>';
										}
								}
								
						$this->ResultTab .= '</div>';
				}
		}
		
		//Define Acoes
		public function DefACtion($action){
			if(strpos($action,'{id}')) $action =  str_replace('{id}',$this->ID,$action);
			if(strpos($action,'{tipoBal}')) $action =  str_replace('{tipoBal}',($this->Status == 'Caixa') ? "caix" : "banco",$action); //Define de qual tabela vem a informacao (caixa, banco)
			return $action;
		}
		
		//Imprime Tabela
		public function showTab(){
				$this->showLinhas();
				$this->showTotal();
				$this->ResultTab .= '</div>';
				
				if($this->NumRows > 0) echo $this->ResultTab;
				}
		
		
}

?>