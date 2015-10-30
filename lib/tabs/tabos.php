<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela os
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabOS extends DBConex{
      public $Tabs = array('ID','IDChamado','VServico','VMaterial','Total','Horas','Tipo','Status','Confirmada','Descricao');
      public $ID, $IDChamado, $VServico, $VMaterial, $Total, $Horas, $Tipo, $Status, $Confirmada, $Descricao;
      
      public $Table = "os";
      
      public function tabOS(){
            parent::DBConex();
      }
}
?>