<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela clientes
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabClientes extends DBConex{
      public $Tabs = array('ID','Nome','Endereco','Bairro','Cidade','CEP','UF','Tel','Cel','Email','EnviaEmail','Tipo','Razao','CNPJ','IE','Login','Senha','Contrato','VContrato','QNTHoras','VHora','Desconto','Obs','Situacao','Assinatura');
      public $ID, $Nome, $Endereco, $Bairro, $Cidade, $CEP, $UF, $Tel, $Cel, $Email, $EnviaEmail, $Tipo, $Razao, $CNPJ, $IE, $Login, $Senha, $Contrato, $VContrato, $QNTHoras, $VHora, $Desconto, $Obs, $Situacao, $Assinatura;
      
      public $Table = "clientes";
      
      public function tabClientes($ID = null){
            parent::DBConex();
			
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
}
?>