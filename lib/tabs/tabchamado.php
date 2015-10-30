<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');
include_once(dirname(dirname(__FILE__)).'/date.php');

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
	  
	  //Pega Total OS
	  public function TotalOS($Mes = null, $Ano = null, $Status = null, $Ctr = null, $Tec = null){
		  	if(empty($Mes)) $Mes = date('m');
			if(empty($Ano)) $Ano = date('Y');
			if($Mes < 10) $Mes = "0".($Mes * 1);
			
			$d = new getDate();
			$d->setData();
			
			$DIni = $Ano."-".$Mes."-01";
			$nDIni = "01/".$Mes."/".$Ano;
			$d->setData($nDIni,'BD',1,2);
			$d->setData($d->dataBR(),'BD',-1,1);
			$DFim = $d->data;
			
			parent::DBConex();
			$this->Tabs = array('Total');
			$this->Query = "SELECT COUNT(c.ID) AS Total FROM chamado AS c INNER JOIN clientes AS cl ON c.IdCl = cl.ID WHERE (c.DataOS BETWEEN '".$DIni."' AND '".$DFim."')".(($Ctr != '') ? (($Ctr == '0') ? "AND (cl.Contrato = '".$Ctr."' OR cl.Contrato = '')" : "AND cl.Contrato = '".$Ctr."'") : "").((!empty($Status)) ? "AND c.StatusOS = '".$Status."'" : "").(($Tec != '') ? "AND c.IDTecnico = '".$Tec."'" : "");
			$this->MontaSQLRelat();
			$this->Load();
			
			
			return $this->Total;
	  }
	  
	  //Pega Total Chamados
	  public function TotalCh($Mes = null, $Ano = null, $Status = null, $Ctr = null, $Tec = null){
		  	if(empty($Mes)) $Mes = date('m');
			if(empty($Ano)) $Ano = date('Y');
			if($Mes < 10) $Mes = "0".($Mes * 1);
			
			$d = new getDate();
			$d->setData();
			
			$DIni = $Ano."-".$Mes."-01";
			$nDIni = "01/".$Mes."/".$Ano;
			$d->setData($nDIni,'BD',1,2);
			$d->setData($d->dataBR(),'BD',-1,1);
			$DFim = $d->data;
			
			parent::DBConex();
			$this->Tabs = array('Total');
			$this->Query = "SELECT COUNT(c.ID) AS Total FROM chamado AS c INNER JOIN clientes AS cl ON c.IdCl = cl.ID WHERE (c.Data BETWEEN '".$DIni."' AND '".$DFim."')".(($Ctr != '') ? (($Ctr == '0') ? "AND (cl.Contrato = '".$Ctr."' OR cl.Contrato = '')" : "AND cl.Contrato = '".$Ctr."'") : "").((!empty($Status)) ? "AND c.Status = '".$Status."'" : "").(($Tec != '') ? "AND c.IDTecnico = '".$Tec."'" : "");
			$this->MontaSQLRelat();
			$this->Load();
			
			
			return $this->Total;
	  }
}
?>