<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela configuracoes
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabConfiguracoes extends DBConex{
      public $Tabs = array('ID','NomeFantasia','End','Tel1','Tel2','Email','MSGPainel','OSOnLine','ObsOS','TempoMinOnLine','TempoMinOffLine','Checks', 'LNC');
      public $ID, $NomeFantasia, $End, $Tel1, $Tel2, $Email, $MSGPainel, $OSOnLine, $ObsOS, $TempoMinOnLine, $TempoMinOffLine, $Checks, $LNC;
      
      public $Table = "configuracoes";
      
      public function tabConfiguracoes($ID = '1'){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>