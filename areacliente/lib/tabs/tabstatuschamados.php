<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela statuschamados
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabStatusChamados extends DBConex{
      public $Tabs = array('ID','Descricao','Status');
      public $ID, $Descricao, $Status;
      
      public $Table = "statuschamados";
      
      public function tabStatusChamados($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>