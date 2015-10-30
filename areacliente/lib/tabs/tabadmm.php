<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Menus
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabAdmm extends DBConex{
      public $Tabs = array('ID','Nome','Status','Login','Senha','Email','Apelido','Permissoes','Clientes');
      public $ID, $Nome, $Status, $Login, $Senha, $Email, $Apelido, $Permissoes,$Clientes;
      
      public $Table = "admm";
      
      public function tabAdmm($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>