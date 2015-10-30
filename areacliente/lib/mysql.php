<?php
		include_once('util.php');

/*
*Classe responsavel por manipular MySql
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class MySql extends Util{
     
     //dados conexao banco de dados
     private $DBhost = null;
     private $DBuser = null;
     private $DBpass = null;
     private $DBname = null;
     
     //objetos mysql
     public $Conex = null;
     public $Query = null;
     public $InsertID = null;
     public $Linha = null;
     public $NumRows = null; 
	 public $Result = null;
     
     //objetos sql
     public $SqlSelect = null;
     public $SqlWhere = null;
     public $SqlOrder = null;
	 public $SqlGroup = null;
     public $SqlLimit = null;
     public $SqlTotal = null;
	 public $Tabs = null;
	 
	 //Objetos Controle
	 protected $VerAcao = null;
     
     //Construtor
     public function MySql($host, $user, $pass, $db){
           $this->DBhost = $host;
           $this->DBuser = $user;
           $this->DBpass = $pass;
           $this->DBname = $db;
     }
     
     //Abre conexao
     public function Conecta(){
           $this->Conex = mysqli_connect($this->DBhost, $this->DBuser, $this->DBpass);
           mysqli_select_db($this->Conex, $this->DBname);
     }
     
     //Fecha conexao
     public function FConecta(){
           mysqli_close($this->Conex);
     }
     
     //Executa SQL
     public function ExecSQL($sql){
           $this->Conecta();
           $this->Query = $sql;
           $this->Result = mysqli_query($this->Conex, $this->Query) or die (mysqli_error($this->Conex)." - ".$this->Query);
           $this->InsertID = mysqli_insert_id($this->Conex);
           $this->FConecta();
           $this->Linha = 0;
		   
		   $this->VerAcao = explode(" ",$this->Query);
           if($this->VerAcao[0] == "SELECT") $this->NumRows = mysqli_num_rows($this->Result);
		   $this->VerAcao = null;
		   
		   
           return $this->Result;
     }
     
     //Pega valores das variaveis
     public function GetVal(){
           $val = array();
           foreach($this->Tabs as $vals){
                 $val[$vals] = "'".$this->$vals."'";
           }
           return $val;
     }
     
     //Atribui valores de acordo com chave POST
     public function GetValPost(){
           foreach($_POST as $key => $v){
                 $this->$key = $v;
           }
     }
     
     //Insere dados no BD
     public function Insert(){
           unset($this->Tabs[0]);
           $values = $this->GetVal();
           $this->Query = "INSERT INTO ".$this->Table." (".implode(',',$this->Tabs).") VALUES (".implode(',', $values).");";
           $this->ExecSQL($this->Query);
     }
     
     //Altera dados do BD
     public function Update($id = null){
           if(!empty($id)){
                 unset($this->Tabs[0]);
                 $set = '';
                 foreach($this->GetVal() as $tab => $val){
                       $set .= " ".$tab." = ". $val.",";
                 }
           
                 $this->Query = "UPDATE ".$this->Table." SET ".substr($set,0,-1)." WHERE ID = '$id'";
                 $this->ExecSQL($this->Query);
           }else{
                 echo "Defina um registro para alterar";
           }
     }
     
     //Deleta registro do BD
     public function Delete($id = null){
           if(!empty($id)){
                 $this->Query = "DELETE FROM ".$this->Table." WHERE ID = '". $id."'";
                 $this->ExecSQL($this->Query);
           }else{
                 echo "Defina um registro para deletar";
           }
     }
     
			//Monta SQL
			public function MontaSQL(){
					$this->SqlSelect = (!empty($this->SqlSelect)) ? $this->SqlSelect : "*";
					$this->SqlWhere = (!empty($this->SqlWhere)) ? " WHERE ".$this->SqlWhere : "";
					$this->SqlOrder = (!empty($this->SqlOrder)) ? " ORDER BY ".$this->SqlOrder : '';
					$this->SqlGroup = (!empty($this->SqlGrpoup)) ? " GROUP BY ".$this->SqlGroup : '';
					
					$this->Query = "SELECT ".$this->SqlSelect." FROM ".$this->Table.$this->SqlWhere.$this->SqlGroup.$this->SqlOrder;
					
					$this->ExecSQL($this->Query);
			}
	 
     //Monta SQL nos Relatorios
     public function MontaSQLRelat(){
		 if(empty($this->Query)){
           $this->SqlSelect = (!empty($this->SqlSelect)) ? $this->SqlSelect : "*";
           $this->SqlWhere = (!empty($this->SqlWhere)) ? $this->SqlWhere : "";
           $this->SQLOrder = (!empty($this->SQLOrder)) ? $this->SQLOrder : '';
		   $this->SqlGroup = (!empty($this->SqlGrpoup)) ? " GROUP BY ".$this->SqlGroup : '';
           
           $this->Query = "SELECT ".$this->SqlSelect." FROM ".$this->Table."";
		 } 
           
           $this->ExecSQL($this->Query);
     }
	      
     //Associa resultados
     public function Load(){
           $d = mysqli_fetch_array($this->Result);
           foreach($this->Tabs as $c){
                 if(($c != 'action') && ($c != 'item')) $this->{$c} = $d[$c];
           }
     }
     
     //Próximo resultado
     public function Next(){
           $this->Linha++; 
           
           if($this->Linha < $this->NumRows){
                 $this->Load();
           }
     }
	 
	 //Primeiro resultado
	 public function Ini(){
			$this->Linha = 0;
			mysqli_data_seek(0);
			$this->Load(); 
	 }
}

?>