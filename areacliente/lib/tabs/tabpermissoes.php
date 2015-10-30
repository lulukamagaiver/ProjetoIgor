<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela permissoes
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabPermissoes extends DBConex{
      public $Tabs = array('ID','IDUsuario','IDPermissao');
      public $ID, $IDUsuario, $IDPermissao;
      
      public $Table = "permissoes";
      
      public function tabPermissoes(){
            parent::DBConex();
      }
}
?>