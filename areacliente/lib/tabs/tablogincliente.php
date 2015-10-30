<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela clientes
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabLoginCliente extends DBConex{
      public $Tabs = array('ID','Nome','Endereco','Bairro','Cidade','CEP','UF','Tel','Cel','Email','Login','Senha','Clientes','RecEmail');
      public $ID, $Nome, $Endereco, $Bairro, $Cidade, $CEP, $UF, $Tel, $Cel, $Email, $Login, $Senha, $Clientes, $RecEmail;
      
      public $Table = "logincliente";
      
      public function tabLoginCliente($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>