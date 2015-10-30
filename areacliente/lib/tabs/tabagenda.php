<?php

include('./db-conex.php');

/*
*Classe responsavel por manipular tabela Agenda
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabAgenda extends DBConex{
      public $Tabs = array('ID','Nome','Nascimento','Descricao');
      public $ID, $Nome, $Nascimento, $Descricao;
      
      public $Table = "Agenda";
      
      public function tabAgenda(){
            parent::DBConex();
      }
}
?>