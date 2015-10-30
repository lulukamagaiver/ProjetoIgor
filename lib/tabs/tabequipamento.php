<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela equipamento
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabEquipamento extends DBConex{
      public $Tabs = array('ID','Equipamento','IdCl','Descricao','Status');
      public $ID, $Equipamento, $IdCl, $Descricao, $Status;
      
      public $Table = "equipamento";
      
      public function tabEquipamento($ID = null){
            parent::DBConex();
						
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>