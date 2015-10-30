<?php
include_once(dirname(dirname(__FILE__)).'/sessao.php');
include_once(dirname(dirname(__FILE__)).'/db-conex.php');
include_once(dirname(dirname(__FILE__)).'/warnings.php');
include_once(dirname(dirname(__FILE__)).'/conf.php');
include_once('tabconfiguracoes.php');
include_once('tablogincliente.php');
include_once('tabadmm.php');
/*
*Classe responsavel por manipular tabela clientes
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class tabComentarioChamado extends DBConex{
      public $Tabs = array('ID','Autor','Data','Comentario','IdCh');
      public $ID, $Autor, $Data, $Comentario, $IdCh;
      
      public $Table = "comentariochamado";
      
      public function tabComentarioChamado(){
            parent::DBConex();
      }
	  
	  //adicionar comentarios
	  public function AddComentario($msg = null, $IdCh= null, $IdAdmm = 0, $RecEmail = true){
		  	if(!empty($IdCh)){
			$Cm = new self;
			$Cm->Autor = $IdAdmm;
			$Cm->Comentario = $msg;
			$Cm->Data = date('Y-m-d H:i:s');
			$Cm->IdCh = $IdCh;
			$Cm->Insert();
			}
			
			if($Cm->InsertID > 0){
					$Cl = new DBConex;
					$Cl->Tabs = array('Email','Nome','EnviaEmail','ID','Status');
					$Cl->Query = "SELECT cl.Nome AS Nome, cl.ID AS ID, cl.Email AS Email, cl.EnviaEmail AS EnviaEmail, ch.Status FROM chamado AS ch INNER JOIN clientes AS cl ON cl.ID = ch.IdCl WHERE ch.ID = '".$IdCh."'"; 
					$Cl->MontaSQLRelat();
					$Cl->Load();
					
					$mensagem = $Cl->Nome.",<br /><br /><br />
					Um comentário foi adicionado ao chamado #".$this->COD($IdCh)." dia ".date('d/m/Y \a\s H:i:s',strtotime($Cm->Data)).":<br /><br />
					".$msg."
					
					";
					
					
					$Cf = new tabConfiguracoes('1');
					$Checks = explode(',',$Cf->Checks);
					
					$E = new Conf;
					if($RecEmail){
							//Verifica se Status "Aguardando CLiente" e se pode enviar caso positivo
							if(($Cl->Status != 8) || (($Cl->Status == 8) && (in_array('15',$Checks)))){ 
									//Envia Email para clientes e usuarios clientes
									if(in_array('11',$Checks)){
											$E->EmailChamado($Cl->Email,$mensagem,"Movimentação do chamado #".$E->COD($IdCh),$IdCh);
											
											//Busca Usuarios clientes
											$LC = new tabLoginCliente;
											$LC->SqlWhere = "Clientes LIKE '%,".$Cl->ID."%'";
											$LC->MontaSQL();
											$LC->Load();
											
											for($a=0;$a<$LC->NumRows;$a++){
													if($LC->RecEmail == 1){
															$LCEmail = explode(';',$LC->Email);
															foreach($LCEmail as $key => $val){
																	//Envia pra usuarios CLientes
																	if(!empty($val)) $E->EmailChamado($val,$mensagem,"Movimentação do chamado #".$E->COD($IdCh),$IdCh);
															}
													}
											$LC->Next();
											}
									}
							}
							
							if(in_array('14',$Checks)){
									$Tec = new tabAdmm;
									$Tec->SqlWhere = "Clientes LIKE '%,".str_pad($Cl->ID,11,0,STR_PAD_LEFT)."%'";
									$Tec->MontaSQL();
									$Tec->Load();
									//echo var_dump($Tec);
									for($a=0;$a<$Tec->NumRows;$a++){
											$TecEmail = explode(';',$Tec->Email);
											foreach($TecEmail as $key => $val){
													//Envia pra usuarios CLientes
													if(!empty($val)) $E->EmailChamado($val,$mensagem,"Abertura de Chamado #".$E->COD($Ch->InsertID));	
													//echo var_dump($val);
											}
									$Tec->Next();
									}
							}
							
					}
					
					//echo $mensagem;
					return $Cm->InsertID;
			}
	  }
}
?>