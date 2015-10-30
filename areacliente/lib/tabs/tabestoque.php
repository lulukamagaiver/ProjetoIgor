<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Estoque
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabEstoque extends DBConex{
      public $Tabs = array('ID','Produto','Quantidade','Limite','Status','Categoria','Tipo','Ordem');
      public $ID, $Produto, $Quantidade, $Limite, $Status, $Categoria, $Tipo, $Ordem;
      
      public $Table = "estoque";
      
      public function tabEstoque(){
            parent::DBConex();
      }
}
?>