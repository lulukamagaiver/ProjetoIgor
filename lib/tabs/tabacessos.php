<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela acessos
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabAcessos extends DBConex{
      public $Tabs = array('ID','IP','URL','IDUser','StatusUser','Data');
      public $ID, $IP, $URL, $Data, $IDUser, $StatusUser;
      
      public $Table = "acessos";
      
      public function tabAcessos($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>