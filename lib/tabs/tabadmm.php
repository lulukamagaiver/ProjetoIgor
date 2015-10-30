<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Menus
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabAdmm extends DBConex{
      public $Tabs = array('ID','Nome','Status','Login','Senha','Email','Apelido','Permissoes','Clientes');
      public $ID, $Nome, $Status, $Login, $Senha, $Email, $Apelido, $Permissoes, $Clientes;
      
      public $Table = "admm";
      
      public function tabAdmm($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
	  
	  public function Clientes($Cp = 'ID'){
			$Cl = explode(',',$this->Clientes);
			$W = "";
			if(count($Cl) > 0){
					$W = "(";
					foreach($Cl as $key => $val){
							if($key == 0) $W .= $Cp." = '".$val."'";
							else $W .= " OR ".$Cp." = '".$val."'";
					}
					$W .= ")";
			}
			
			
			return $W;
	  }
}
?>