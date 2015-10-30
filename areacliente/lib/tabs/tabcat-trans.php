<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Cat-transacoes
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabCatTrans extends DBConex{
      public $Tabs = array('ID','Categoria','Status','Ordem');
      public $ID, $Categoria, $Status, $Ordem;
      
      public $Table = "cat_transacoes";
      
      public function tabCatTrans(){
            parent::DBConex();
      }
}
?>