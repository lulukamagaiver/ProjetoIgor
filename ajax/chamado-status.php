<?php
		require_once('../lib/sessao.php');
		require_once('../lib/tabs/tabchamado.php');
		require_once('../lib/tabs/tabconfiguracoes.php');
		require_once('../lib/tabs/tabclientes.php');
		require_once('../lib/tabs/tablogincliente.php');
		require_once('../lib/tabs/tabstatuschamados.php');
		require_once('../lib/tabs/tabcomentariochamado.php');
		require_once('../lib/url.php');
		require_once('../lib/warnings.php');
		
		$S = new Sessao;
		
		$W = new Warnings;
		
		$URL = new URL;
		
		if(!empty($_GET['id'])){
						$Cm = new tabChamado;
						$Cm->SqlWhere = "ID = '".$_GET['id']."'";
						$Cm->MontaSQL();
						$Cm->Load();

						$Us = new tabStatusChamados;
						$Us->SqlWhere = "ID = '".$Cm->Status."'";
						$Us->MontaSQL();
						$Us->Load();
						$UsAnt = $Us->Descricao;

				if(!empty($_POST['Transferir'])){						

							$Us->SqlWhere = "ID = '".$_POST['NStatus']."'";
							$Us->MontaSQL();
							$Us->Load();
							$NTec = $Us->Descricao;
												
								$Cm->Status = $_POST['NStatus'];
								if(((empty($Cm->TempoEspera)) || ($Cm->TempoEspera == '0000-00-00 00:00:00')) && (($Cm->Status == 2) || ($Cm->Status == 3))) $Cm->TempoEspera = date('Y-m-d H:i:s');
								$Cm->Update($_GET['id']);
								
								if($Cm->Result){
										if($Cm->Status == 8){
												$Cf = new tabConfiguracoes('1');
												$Checks = explode(',',$Cf->Checks);
												if(in_array('10',$Checks)){
														$ClE = new tabClientes($Cm->IdCl);
														//$URL->Emails($ClE->Email,$MSGEmail,'O.S. #'.$URL->COD($url[0]).' '.(($Alt) ? "Alterada." : "Cadastrada."));
														$URL->EmailChamado($ClE->Email,$mensagem,"Mudança de Status do chamado #".$URL->COD($Cm->ID),$Cm->ID);
														//Busca Usuarios clientes
														$LC = new tabLoginCliente;
														$LC->SqlWhere = "Clientes LIKE '%,".$ClE->ID."%'";
														$LC->MontaSQL();
														$LC->Load();
														
														for($a=0;$a<$LC->NumRows;$a++){
																if($LC->RecEmail == 1){
																		$LCEmail = explode(';',$LC->Email);
																		foreach($LCEmail as $key => $val){
																				//Envia pra usuarios CLientes
																				if(!empty($val)) $URL->EmailChamado($val,$mensagem,"Mudança de Status do chamado #".$URL->COD($Cm->ID),$Cm->ID);
																		}
																}
														$LC->Next();
														}		
												}
										}
										
										$C = new tabComentarioChamado;
										$C->AddComentario($S->Apelido.' alterou o Status deste chamado:<br />De: '.$UsAnt.'<br /> Para: '.$NTec,$_GET['id'],false);
										echo "<script>parent.document.location.reload();</script>";
								}else echo "<script>parent.AddAviso('Problemas ao tentar alterar status.','WA');</script>";
				}else{?>
                		<html>
                        <head>
                        		<meta charset="utf-8">
                        </head>
                        <body>
                		<h4>Alterar Status</h4>
                        
                        <form method="post" action="<?php echo $URL->siteURL;?>ajax/chamado-status.php?id=<?php echo $_GET['id'];?>" target="ajax">
                        		<div class="inputs">
                                		Transferir de:<br />
                                        <strong><?php echo $UsAnt;?></strong>
                                </div>
                                
                                <div class="sepCont"></div>
                                
                                <div class="inputs">
                                		Para:<br />
                                        <select name="NStatus" id="NStatus">
                                                <?php
														$Tecs = new tabStatusChamados;
														$Tecs->MontaSQL();
														$Tecs->Load();
												
														for($a=0;$a<$Tecs->NumRows;$a++){
															?><option value="<?php echo $Tecs->ID;?>"><?php echo $Tecs->Descricao;?></option><?php
															$Tecs->Next();
														}
												?>
                                        </select>
                                </div>
                                <div class="sepCont"></div>
                                <input name="Transferir" type="submit" value="ok" style="display:none;">
                                <div class="btnAct" onClick="return $('input[name=Transferir]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" />Alterar</div>
                                <div class="btnAct" onClick="$('.PopUp').fadeOut();"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" />Cancelar</div>

                        </form>
                		</body>
                        </html>
                <?php
				}
		}else echo "<script>parent.AddAviso('Nenhum chamado definido para ser atendido.','WA');</script>";
