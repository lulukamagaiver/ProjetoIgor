<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Cat-Estoque
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabCatEstoque extends DBConex{
      public $Tabs = array('ID','Categoria','Status','Ordem');
      public $ID, $Categoria, $Status, $Ordem;
      
      public $Table = "cat_estoque";
      
      public function tabCatEstoque(){
            parent::DBConex();
      }
}
?>