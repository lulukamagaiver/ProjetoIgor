<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela mateiral
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabMaterial extends DBConex{
      public $Tabs = array('ID','Material','Valor','Status');
      public $ID, $Material, $Valor, $Status;
      
      public $Table = "material";
      
      public function tabMaterial(){
            parent::DBConex();
      }
}
?>