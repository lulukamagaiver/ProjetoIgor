<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela chamado
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabChamado extends DBConex{
      public $Tabs = array('ID','IdCl','IDEquipamento','Contato1','Contato2','Descricao','Data','Status','Categoria','IDTecnico','DescricaoOS','TipoCob','TempoOS','ValorCob','TipoOS','StatusOS','Confirmada','TempoEspera','TempoAtendimento','DataOS','DataFechamentoOS');
      public $ID, $idCl, $IDEquipamento, $Contato1, $Contato2, $Descricao, $Data, $Status, $Categoria, $IDTecnico, $DescricaoOS, $TipoCob, $TempoOS, $ValorCob, $TipoOS, $StatusOS, $Confirmada, $TempoEspera, $TempoAtendimento, $DataOS, $DataFechamentoOS;
      
      public $Table = "chamado";
      
      public function tabChamado($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
	  
	  //Fecha OS
	  public function FechaOS($ID = null){
		 	if(!empty ($ID)){
					$Os = new self($ID);
					$Os->Confirmada = 1;
					$Os->StatusOS = 2;
					$Os->Update($ID);
			}
	  }
	  
	  //Fecha OS
	  public function ConfirmaOS($ID = null){
		 	if(!empty ($ID)){
					$Os = new self($ID);
					$Os->Confirmada = 1;
					$Os->Update($ID);
			}
	  }
	  
	  //Deleta chamado
	  public function DeletaChamado($ID = null){
		 	if(!empty($ID)){
					$Ch = new self;
					$Ch->Delete($ID);
					$D = new DBConex;
					$D->Query = "DELETE FROM comentariochamado WHERE IdCh = '".$ID."'";
					$D->ExecSQL($D->Query);
					$D->Query = "DELETE FROM materiaischamados WHERE IDChamado = '".$ID."'";
					$D->ExecSQL($D->Query);

					return $Ch->Result;
			}
	  }
	  
	  //Deleta OS
	  public function DeletaOS($ID = null){
		 	if(!empty($ID)){
					$Os = new self($ID);
					$Os->Confirmada = '';
					$Os->DataOS = '';
					$Os->DescricaoOS = '';
					$Os->StatusOS = '';
					$Os->TipoCob = '';
					$Os->TipoOS = '';
					$Os->TempoOS = '';
					$Os->ValorCob = '';
					$Os->TempoAtendimento = '';
					$Os->TempoEspera = '';
					$Os->Status = '1';
					$Os->Update($ID);
					
					return $Os->Result;
			}
	  }
}
?>