<?php

include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela Banco
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabBanco extends DBConex{
		public $Tabs = array('ID','Data','Finalidade','Cliente','Categoria','Valor','Parcelas', 'IDParcela', 'VParcela', 'Entrada','Tipo','IdCl','Obs');
		public $ID, $Data, $Finalidade, $Cliente, $Categoria, $Valor, $Parcelas, $IDParcela, $VParcela, $Entrada, $Tipo, $IdCl, $Obs;
		
		public $Table = "banco";
		
		public function tabBanco(){
			parent::DBConex();
		}
		
		//funcao para apagar registro onde possua IDParcela igual
		public function DeleteIDParcela($id){
			$this->Query = "DELETE FROM ".$this->Table." WHERE IDParcela = '". $id."'";
			$this->ExecSQL($this->Query);
		}
}
?>