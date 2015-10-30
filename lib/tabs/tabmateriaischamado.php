<?php
include_once(dirname(dirname(__FILE__)).'/db-conex.php');

/*
*Classe responsavel por manipular tabela materiaischamado
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabMateriaisChamado extends DBConex{
      public $Tabs = array('ID','Descricao','QNT','Valor','VTotal','IDChamado');
      public $ID, $Descricao, $QNT, $Valor, $VTotal, $IDChamado;
      
      public $Table = "materiaischamados";
      
      public function tabMateriaisChamado($ID = null){
            parent::DBConex();
						
			if(!empty($ID)){
					$this->SqlWhere = "ID = '".$ID."'";
					$this->MontaSQL();
					return $this->Load();
			}
      }
	  
	  //retorna o valor total de materiais para um chamado
	  public function MAX($IdCh = null){
		 	 parent::DBConex();
			 
			 $Mat = new self;
			 $Mat->SqlWhere = "IDChamado = '".$IdCh."'";
			 $Mat->MontaSQL();
			 $Mat->Load();
			 
			 $V = 0;
			 for($a=0;$a<$Mat->NumRows;$a++){
					$V = $V + $Mat->VTotal;
					$Mat->Next(); 
			 }
			 
			 return $V;
	  }
}
?>