<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Menus
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabMenus extends DBConex{
      public $Tabs = array('ID','Categoria','Menu','URL','Status','Ordem');
      public $ID, $Categoria, $Menu, $URL, $Status, $Ordem;
      
      public $Table = "menus";
      
      public function tabMenus(){
            parent::DBConex();
      }
}
?>