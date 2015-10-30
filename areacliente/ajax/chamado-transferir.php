<?php
		require_once('../lib/sessao.php');
		require_once('../lib/tabs/tabchamado.php');
		require_once('../lib/tabs/tabadmm.php');
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

						$Us = new tabAdmm;
						$Us->SqlWhere = "ID = '".$Cm->IDTecnico."'";
						$Us->MontaSQL();
						$Us->Load();
						$UsAnt = ($Cm->IDTecnico != 0) ? $Us->Apelido : "Todos";

				if(!empty($_POST['Transferir'])){						

						if($_POST['NTecnico'] != 0){
							$Us->SqlWhere = "ID = '".$_POST['NTecnico']."'";
							$Us->MontaSQL();
							$Us->Load();
							$NTec = $Us->Apelido;
						}else $NTec = "Todos";
												
								$Cm->IDTecnico = $_POST['NTecnico'];
								$Cm->Update($_GET['id']);
								
								if($Cm->Result){
										$C = new tabComentarioChamado;
										$C->AddComentario($S->Apelido.' alterou o Técnico deste chamado:<br />De: '.$UsAnt.'<br /> Para: '.$NTec,$_GET['id']);
										echo "<script>parent.document.location.reload();</script>";
								}else echo "<script>parent.AddAviso('Problemas ao tentar alterar técnico.','WA');</script>";
				}else{?>
                
                		<h4>Trasferir Chamado</h4>
                        
                        <form method="post" action="<?php echo $URL->siteURL;?>ajax/chamado-transferir.php?id=<?php echo $_GET['id'];?>" target="ajax">
                        		<div class="inputs">
                                		Transferir de:<br />
                                        <strong><?php echo $UsAnt;?></strong>
                                </div>
                                
                                <div class="sepCont"></div>
                                
                                <div class="inputs">
                                		Para:<br />
                                        <select name="NTecnico" id="NTecnico">
                                        		<option value="0">Todos</option>
                                                <?php
														$Tecs = new tabAdmm;
														$Tecs->MontaSQL();
														$Tecs->Load();
												
														for($a=0;$a<$Tecs->NumRows;$a++){
															?><option value="<?php echo $Tecs->ID;?>"><?php echo $Tecs->Apelido;?></option><?php
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
                		
                <?php
				}
		}else echo "<script>parent.AddAviso('Nenhum chamado definido para ser atendido.','WA');</script>";
