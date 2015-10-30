<?php
		$S->PrAcess('');
		include_once('lib/relatorios.php');
		include_once('lib/search.php');
		include_once('lib/tabs/tabchamado.php');
		include_once('lib/tabs/tabclientes.php');
		include_once('lib/tabs/tabequipamento.php');
		include_once('lib/tabs/tabadmm.php');
		include_once('lib/tabs/tabstatuschamados.php');
		include_once('lib/tabs/tabcomentariochamado.php');
		include_once('lib/tabs/tabmateriaischamado.php');
		
		
		//BUSCA
		$B = new Search;
		$B->Igual('ch.ID',(!empty($_POST['COD'])) ? ($_POST['COD'] * 1) : "");
		$B->Igual('ch.Status',(!empty($_POST['Status'])) ? $_POST['Status'] : "");
		$B->Like('cl.Nome',(!empty($_POST['Busca'])) ? $_POST['Busca'] : "");
		$B->Like('eq.Equipamento',(!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "");
		$B->Periodo('ch.Data',((!empty($_POST['DIni'])) ? $_POST['DIni'] : ""),((!empty($_POST['DFim'])) ? $_POST['DFim'] : ""));
		
		$C = new Search;
		$C->Igual('ID',(!empty($_POST['Tecnico'])) ? $_POST['Tecnico'] : "");

		$VerMais = 0;
		
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				//DELETAR
				if(((!empty($url[1])) && ($url[1] == 'deletar')) && (is_numeric($url[2]))){
					if($S->Pr(13)){ //Deletar chamado
						$Del = new tabChamado;
						$Del->Delete($url[2]);
						if($Del->Result) {
							$W->AddAviso('Chamado removido.','WS');
							$D = new DBConex;
							$D->Query = "DELETE FROM comentariochamado WHERE IdCh = '".$url[2]."'";
							$D->ExecSQL($D->Query);
							$D->Query = "DELETE FROM materiaischamados WHERE IDChamado = '".$url[2]."'";
							$D->ExecSQL($D->Query);
							
						}
						else $W->AddAviso('Problemas ao deletar chamado','WE');
					}else $W->AddAviso('Você não possui permissão para esta ação.','WE');
				}
				
				//DELETAR Comentario
				if(((!empty($url[1])) && ($url[1] == 'deletarcomentario')) && (is_numeric($url[2]))){
					if($S->Pr(15)){ //Deletar comentario
						$Del = new tabComentarioChamado;
						$Del->SqlWhere = "ID = '".$url[2]."'";
						$Del->MontaSQL();
						$Del->Load();
						
						$IdCl = $Del->IdCh;
						
						$Del->Delete($url[2]);
						if($Del->Result){
								$W->AddAviso('Comentário removido.','WS');
								echo "<script>document.location = '".$URL->siteURL."chamados/visualizar/".$IdCl."/'</script>";
								exit;
						}
						else{
								$W->AddAviso('Problemas ao deletar Comentário.','WE');
								echo "<script>document.location = '".$URL->siteURL."chamados/visualizar/".$IdCl."/'</script>";
								exit;
						}
					}else $W->AddAviso('Você não possui permissão para esta ação.',''); 
				}
				
				//DELETAR MATERIAL
				if(((!empty($url[1])) && ($url[1] == 'deletarmaterial')) && (is_numeric($url[2]))){
					if($S->Pr(18)){ //Deletar material
						$Del = new tabMateriaisChamado;
						$Del->SqlWhere = "ID = '".$url[2]."'";
						$Del->MontaSQL();
						$Del->Load();
						
						$IdCl = $Del->IDChamado;
						
						$Del->Delete($url[2]);
						if($Del->Result){
								$W->AddAviso('Material/Serviço removido.','WS');
								echo "<script>document.location = '".$URL->siteURL."chamados/visualizar/".$IdCl."/'</script>";
								exit;
						}
						else{
								$W->AddAviso('Problemas ao deletar Material/Serviço.','WE');
								echo "<script>document.location = '".$URL->siteURL."chamados/visualizar/".$IdCl."/'</script>";
								exit;
						}
					}else $W->AddAviso('Você não possui permissão para esta ação.',''); 
				}
				
				//Definir qual cliente será exibido
				if(((!empty($url[0])) && ($url[0] == 'visualizar')) && (is_numeric($url[1]))){
						$VerMais = 1;
				}				
		}
		



if($VerMais == 0) :
		$Us = new tabAdmm;
		$Us->SqlWhere = $C->Where;
		$Us->SqlOrder = "FIELD(ID, ".$S->ID.") DESC, Nome ASC";
		$Us->MontaSQL();
		$Us->Load();
		$Us->TG['Chamados'] = 0;
		
	
		$tt2 = new DBConex;
		$tt2->Tabs = array('ID','Data','Status','Cliente','Equipamento','Responsavel','Telefone','Descricao');
		$tt2->Query = "SELECT ch.ID AS ID, ch.Data AS Data, st.Descricao AS Status, cl.Nome AS Cliente, eq.Equipamento AS Equipamento, cl.Tel AS Telefone, ch.Contato1 AS Responsavel, ch.Descricao AS Descricao FROM chamado AS ch INNER JOIN statuschamados AS st ON st.ID = ch.Status INNER JOIN clientes AS cl ON cl.ID = ch.IdCl INNER JOIN equipamento AS eq ON eq.ID = ch.IDEquipamento
		WHERE ".$S->ClUsu(true)." AND ch.Status > '3' AND ch.Status != '14'".((!empty($B->Where)) ? " AND ".$B->Where : "")." ORDER BY ch.Status DESC";
		$tt2->MontaSQLRelat();
		$tt2->Load();
		$Us->TG['Chamados'] = $Us->TG['Chamados'] + $tt2->NumRows; 
		
		$d->setData();
?>

<h1>Consultar Chamados</h1>
        <!--<a href="<?php echo $URL->NURL;?>clientes/cadastrar/">
        <input name="" type="button" value="Novo" class="btnAZ" style="float:right; margin-bottom:20px; background-color:#09C;" />
        </a>-->
		<?php
		$a = array();
		$a[0] = "width: 80px; text-align: center;";
		$a[1] = "width: 80px; text-align: center;";
		$a[2] = "width: 550px; text-align: left;";
		$a[3] = "width: 167px; text-align: center;";
		$a[4] = "width: 69px; text-align: center;";
		?>
        Período: <?php echo $B->DataIni." - ".$B->DataFim;?>
		<div class="fundoTabela">
        		<div class="topoTabela">
                		<div style=" <?php echo $a[0];?>">COD</div>
                        <div style=" <?php echo $a[1];?>">Data</div>
                        <div style=" <?php echo $a[2];?>">Cliente</div>
                        <div style=" <?php echo $a[3];?>">Status</div>
                        <div style=" <?php echo $a[4];?>">Ações</div>
                </div>
                
                <?php
						$tt = new DBConex;
						$tt->Tabs = array('ID','Data','Status','Cliente','Equipamento','Responsavel','Telefone','Descricao');
						$tt->Query = "SELECT ch.ID AS ID, ch.Data AS Data, st.Descricao AS Status, cl.Nome AS Cliente, eq.Equipamento AS Equipamento, cl.Tel AS Telefone, ch.Contato1 AS Responsavel, ch.Descricao AS Descricao
						FROM chamado AS ch INNER JOIN statuschamados AS st ON st.ID = ch.Status INNER JOIN clientes AS cl ON cl.ID = ch.IdCl INNER JOIN equipamento AS eq ON eq.ID = ch.IDEquipamento WHERE ".$S->ClUsu(true)." AND ch.Status > '0' AND ch.Status < '4' AND ch.Status != '14'".((!empty($B->Where)) ? " AND ".$B->Where : "")." ORDER BY ch.Status DESC";
						$tt->MontaSQLRelat();
						$tt->Load();
				?>
                        <div class="linhasTabela"><div style="width:100%; text-align:center; background-color:#999; font-weight:bold;">CHAMADOS ATIVOS: (<?php echo $tt->NumRows;?>)</div></div>
                        <?php if($tt->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
                        <?php for($b=0;$b<$tt->NumRows;$b++){?>
                        <div class="linhasTabela">
                                <div class="haha" style=" <?php echo $a[0];?>"><?php echo $tt->COD($tt->ID);?>
                                <p class="balaodialogo">
                                <strong>Equip./Prod.: </strong><?php echo $tt->Equipamento; ?><br />
                                <strong>Responsável: </strong><?php echo $tt->Responsavel; ?><br />
                                <strong>Telefones: </strong><?php echo $tt->Telefone; ?><br />
                                <strong>Descrição: </strong><?php echo $tt->Descricao; ?>
                                </p>
                                </div>
                                <div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($tt->Data));?></div>
                                <div style=" <?php echo $a[2];?>"><?php echo $tt->Cliente;?></div>
                                <div style=" <?php echo $a[3];?>"><?php echo $tt->Status;?></div>
                                <div style=" <?php echo $a[4];?>">
                                <a href="<?php echo $URL->siteURL?>chamados/visualizar/<?php echo $tt->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /></a>
                                <?php if($S->Pr(13)) {?><a href="<?php echo $URL->siteURL?>chamados/visualizar/deletar/<?php echo $tt->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="action" /></a><?php } else{?><img onclick="AcNegado();" src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="action" /><?php }?>
                                </div>
                        </div>
                        <?php $Us->TG['Chamados'] = $Us->TG['Chamados'] + $tt->NumRows; $tt->Next(); }?>
                
                <div class="linhasTabela"><div style="width:100%; text-align:center; background-color:#999; font-weight:bold;">CHAMADOS EM ESPERA: (<?php echo $tt2->NumRows;?>)</div></div>
                <?php if($tt2->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
                <?php for($b=0;$b<$tt2->NumRows;$b++){?>
        		<div class="linhasTabela">
                		<div class="haha" style=" <?php echo $a[0];?>"><?php echo $tt->COD($tt2->ID);?>
                        <p class="balaodialogo">
                        <strong>Equip./Prod.: </strong><?php echo $tt2->Equipamento; ?><br />
                        <strong>Responsável: </strong><?php echo $tt2->Responsavel; ?><br />
                        <strong>Telefones: </strong><?php echo $tt2->Telefone; ?><br />
                        <strong>Descrição: </strong><?php echo $tt2->Descricao; ?>
                        </p>
                        </div>
                        <div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($tt2->Data));?></div>
                        <div style=" <?php echo $a[2];?>"><?php echo $tt2->Cliente;?></div>
                        <div style=" <?php echo $a[3];?>"><?php echo $tt2->Status;?></div>
                        <div style=" <?php echo $a[4];?>">
                        <a href="<?php echo $URL->siteURL?>chamados/visualizar/<?php echo $tt2->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /></a>
                        <?php if($S->Pr(13)) {?><a href="<?php echo $URL->siteURL?>chamados/visualizar/deletar/<?php echo $tt2->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="action" /></a><?php } else{?><img onclick="AcNegado();" src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="action" /><?php }?>
                        </div>
                </div>
                <?php $tt2->Next(); }?>
                
        		<div class="topoTabela">
                		<div style="width:100%; text-align:center;">Total de chamados: <?=$Us->TG['Chamados']?></div>
                </div>
        </div>
        
<script>
		<?php echo $JS->DatePicker(array('#DIni','#DFim'));?>
</script>


<?php
elseif($VerMais == 1) :?>
<?php
		if(!empty($_POST['Envia'])){
			if(!empty($_POST['Comentario'])){
				$Cm = new tabComentarioChamado;
				$Cm->Data = date("Y-m-d H:i:s");
				$Cm->Autor = $S->ID;
				$Cm->Comentario = $_POST['Comentario'];
				$Cm->IdCh = $url[1];
				$Cm->Insert();
				if($Cm->InsertID > 0) {
						$W->AddAviso('Comentário adcionado.','WS');
						$_POST = "";
				}else $W->AddAviso('Problemas ao adicionar comentário.','WE');
			}else $W->AddAviso('Adicione um comentário.','WA');
		}
?>
		
<h1>Consultar Chamado #<?php echo $URL->COD($url[1]);?></h1>
        
		<?php
		
		$Ch = new tabChamado;
		$Ch->SqlWhere = "ID = '".$url[1]."'";
		$Ch->MontaSQL();
		$Ch->Load();
		
		$Cl = new tabClientes;
		$Cl->SqlWhere = "ID = '".$Ch->IdCl."'";
		$Cl->MontaSQL();
		$Cl->Load();
        
		$Eq = new tabEquipamento;
		$Eq->SqlWhere = "ID = '".$Ch->IDEquipamento."'";
		$Eq->MontaSQL();
		$Eq->Load();
		        
		$St = new tabStatusChamados;
		$St->SqlWhere = "ID = '".$Ch->Status."'";
		$St->MontaSQL();
		$St->Load();
		
		$Ad = new tabAdmm;
		$Ad->SqlWhere = "ID = '".$Ch->IDTecnico."'";
		$Ad->MontaSQL();
		$Ad->Load();
		?>

<form method="post" action="">

		<div class="inputsLarge">
        		Cliente:<br />
                <input type="text" readonly="readonly" style="width:310px; color:#F00;" value="<?php echo (!empty($Cl->Nome)) ? $Cl->Nome : "";;?>" />
                <a href="<?php echo $URL->siteURL;?>clientes/visualizar/<?php echo $Cl->ID;?>/"><img src="<?php echo $URL->siteURL;?>imgs/icones/zoom_in.png" width="30" height="30" style="position:absolute; margin:-2px 0 0 5px;" /></a>
        </div>
        
        <div class="inputs">
        		<br />
                <?php echo ($Cl->Contrato == 1) ? "<strong>(COM CONTRATO)</strong>" : "";?>
        </div>
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Data:<br />
                <input type="text" readonly="readonly" style="" value="<?php echo (!empty($Ch->Data)) ? date("d/m/Y H:i:s",strtotime($Ch->Data)) : "";?>" />
        </div>
        
		<div class="inputs">
        		Telefone:<br />
                <input type="text" readonly="readonly" style="" value="<?php echo (!empty($Cl->Tel)) ? $Cl->Tel : "";?>" />
        </div>
                
		<div class="inputs">
        		Telefone:<br />
                <input type="text" readonly="readonly" style="" value="<?php echo (!empty($Cl->Cel)) ? $Cl->Cel : "";?>" />
        </div>
                
		<div class="inputs">
        		Email:<br />
                <input type="text" readonly="readonly" style="" value="<?php echo (!empty($Cl->Email)) ? $Cl->Email : "";?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="sepCol2" style="height:auto;">
                <div class="inputs">
                        Equipamento:<br />
                        <input type="text" readonly="readonly" style="" value="<?php echo (!empty($Eq->Equipamento)) ? $Eq->Equipamento : "Outro";?>" />
                </div><br />
                <div class="sepCont"></div>
                <p style="margin-left:15px;"><?php echo (!empty($Eq->Descricao)) ? $Eq->Descricao : "";?></p>
        </div>
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Status:<br />
                <input type="text" readonly="readonly" style="color:#F00;" value="<?php echo (!empty($St->Descricao)) ? $St->Descricao : "";?>" />
        </div>
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Técnico:<br />
                <input type="text" readonly="readonly" style="color:#F00;" value="<?php echo ($Ch->IDTecnico != 0) ? ((!empty($Ad->Apelido)) ? $Ad->Apelido : "") : "Todos";?>" />
        </div>
        
        <div class="sepCont"></div>
               
        <div class="sepCol2" style="height:auto;">
				<div class="txtArea">
                Descrição:<br />
                <textarea style="width:300px;" readonly="readonly"><?php echo (!empty($Ch->Descricao)) ? $Ch->Descricao : "";?></textarea>
                </div>
        </div>
        
        <div class="sepCont"></div>
</form>  
<?php
		include_once('lib/tabs/tabmateriaischamado.php');
		$Mat = new tabMateriaisChamado;
		$Mat->SqlWhere = "IDChamado = '".$Ch->ID."'";
		$Mat->MontaSQL();
		$Mat->Load();
		
		if($Mat->NumRows > 0){
?>
        <div class="sepCont"></div>
        <h6>Materiais/Serviços</h6>
        <div class="sepCont"></div>
<?php

		
		$RMat = new Relat();
		$RMat->WidthCols = array('54','500','120','70','120','70','0');
		$RMat->Cols = array('ID','Descricao','Valor','QNT','VTotal','action','ID');
		$RMat->Totais = array(0,0,0,0,1,0,0);
		$RMat->Formato = array('cod','','moeda','','moeda','','');
		$RMat->Actions = '
		'.(($S->Pr(17)) ? '<img class="action" src="imgs/icones/edit.png" width="26" height="26" onclick="PopUp(400,200,\''.$URL->siteURL.'ajax/chamado-materiais.php?id='.$Ch->ID.'&&id_mat={id}\');" />' : '<img class="action" src="imgs/icones/edit.png" width="26" height="26" onclick="AcNegado();" />').'
		'.(($S->Pr(18)) ? '<a href="'.$URL->siteURL.'chamados/visualizar/deletarmaterial/{id}/"><img class="action" src="'.$URL->siteURL.'imgs/icones/delete.png" width="26" height="26" /></a>' : '<img class="action" src="imgs/icones/delete.png" width="26" height="26" onclick="AcNegado();" />').'
		';
		$RMat->Query = $Mat->Query;
		$RMat->setTitulos(array('#:center','Descrição:left','Valor:center','QNT:center','Total:center','Açoes:Center','ID:kkk'));
		$RMat->showTab();
		
		}
?>
        

<?php
		$Cm = new DBConex;
		$Cm->Tabs = array('ID','Autor','Data','Comentario');
		$Cm->Query = "SELECT * FROM comentariochamado WHERE IdCh = '".$Ch->ID."'";
		$Cm->MontaSQLRelat();
		$Cm->Load();
		
		if($Cm->NumRows > 0){
?>

        <div class="sepCont"></div>
        <h6>Interações</h6>
        <div class="sepCont"></div>
		<?php
		$a = array();
		$a[0] = "width: 54px; text-align: center;";
		$a[1] = "width: 187px; text-align: center;";
		$a[2] = "width: 130px; text-align: center;";
		$a[3] = "width: 506px; text-align: left;";
		$a[4] = "width: 69px; text-align: center;";
		?>
		<div class="fundoTabela">
   		  <div class="topoTabela">
                		<div style=" <?php echo $a[0];?>">#</div>
                        <div style=" <?php echo $a[1];?>">Autor</div>
                        <div style=" <?php echo $a[2];?>">Data e Hora</div>
                        <div style=" <?php echo $a[3];?>">Status</div>
                        <div style=" <?php echo $a[4];?>">Ações</div>
                </div>
<?php

?>                
                        <?php for($b=0;$b<$Cm->NumRows;$b++){?>
		
                        <?php
                        if($Cm->Autor != 0){
                                $Au = new tabAdmm;
                                $Au->SqlWhere = "ID = '".$Cm->Autor."'";
                                $Au->MontaSQL();
                                $Au->Load();
                                
                                $Autor = $Au->Apelido;
                        }else $Autor = "Sistema";
                        ?>
                        
          						<table style="color:#000; background-color:<?php echo (($b % 2) == 0) ? "" : "#DEDEDE;";?>" width="100%">
                        		<tr>
                                        <td width="42" height="30" align="center" valign="middle"><?php echo $b + 1;?></td>
                                        <td width="175" height="30" align="center" valign="middle" style=""><?php echo $Autor;?></td>
                                        <td width="118" height="30" align="center" valign="middle"style=""><?php echo date("d/m/Y H:i:s",strtotime($Cm->Data));?></td>
                                        <td width="494" height="30" align="left" valign="middle"style=""><?php echo nl2br($Cm->Comentario);?></td>
                                        <td height="30" align="center" valign="middle" style="border:none;">
                                        <?php if($Cm->Autor == 0){?>
										<img class="action2" style="margin:0;" src="<?php echo $URL->siteURL;?>imgs/icones/edit-block.png" width="26" height="26" onclick="AddAviso('Não é possível alterar interações feitas pelo SISTEMA.','WE');" />
                                        <img class="action2" src="<?php echo $URL->siteURL;?>imgs/icones/delete-block.png" width="26" height="26" onclick="AddAviso('Não é possível alterar interações feitas pelo SISTEMA.','WE');" />
										<?php }else {?>
                                        <?php if($S->Pr(14)){?><img class="action2" style="margin:0; cursor:pointer;" src="<?php echo $URL->siteURL;?>imgs/icones/edit.png" width="26" height="26" onclick="PopUp('500','300','<?php echo $URL->siteURL;?>ajax/chamado-alterar-comentario.php?id=<?php echo $Cm->ID;?>');" /><?php } else{?><?php }?>
                                        <?php if($S->Pr(15)){?><img class="action2" style="cursor:pointer;" src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" width="26" height="26" /><?php }?>
                                        <?php }?>
                                        </td>
                                </tr>
                        </table>
                        <?php $Cm->Next(); }?>

                
        		<div class="topoTabela">
                		<div style="width:100%; text-align:center;"></div>
          </div>
        </div>
<?php }?>
<h6>Inserir Comentário</h6>
<form method="post">
        <div class="txtArea" style="margin-left:0px;">
        		<textarea name="Comentario" id="Comentario" style="width:980px;"><?php echo (!empty($_POST['Comentario'])) ? $_POST['Comentario'] : "";?></textarea>
        </div>
            
        <div sepCont></div>
            
        <input name="Envia" type="submit" value="Adcionar Comentário" style="display:none;" />
        <div class="btnAct" style="margin-left:10px; margin-top:5px;" onclick="return $('input[name=Envia]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/comments.png" onclick="" />Adcionar Comentário</div>
        
        <div class="sepCont" style="height:30px;"></div>
</form>
<!---------------------BOTOES RODAPE ------------------------>
      
        <?php if($Ch->Status != 14) :?>
        <div class="btnAct" onclick="PopUp('100','100','<?php echo $URL->siteURL;?>ajax/chamado-atender.php?id=<?php echo $Ch->ID;?>');"><img src="<?php echo $URL->siteURL;?>imgs/icones/like.png" />Atender</div>
        <div class="btnAct" onclick="PopUp('400','200','<?php echo $URL->siteURL;?>ajax/chamado-transferir.php?id=<?php echo $Ch->ID;?>');"><img src="<?php echo $URL->siteURL;?>imgs/icones/users.png" />Transferir</div>
        <?php if($S->Pr(14)){?><div class="btnAct" onclick="PopUp('400','200','<?php echo $URL->siteURL;?>ajax/chamado-status.php?id=<?php echo $Ch->ID;?>');"><img src="<?php echo $URL->siteURL;?>imgs/icones/info.png" />Status</div><?php }else{?><div class="btnAct" onclick="AcNegado();"><img src="<?php echo $URL->siteURL;?>imgs/icones/info.png" />Status</div><?php }?>
        <?php if($S->Pr(16)){?><div class="btnAct" onclick="PopUp('400','200','<?php echo $URL->siteURL;?>ajax/chamado-materiais.php?id=<?php echo $Ch->ID;?>');"><img src="<?php echo $URL->siteURL;?>imgs/icones/tools.png" />Mat./Serv.</div><?php }else{?><div class="btnAct" onclick="AcNegado();"><img src="<?php echo $URL->siteURL;?>imgs/icones/tools.png" />Mat./Serv.</div><?php }?>
        <?php if($S->Pr(12)){?><a href="<?php echo $URL->siteURL;?>chamados/alterar/<?php echo (!empty($Ch->ID)) ? $Ch->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/edit.png" />Alterar</div></a><?php }else{?><div class="btnAct" onclick="AcNegado();"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" />Alterar</div><?php }?>
		<?php if($S->Pr(13)){?><a onclick="return confirm('Tem certeza que deseja excluir?');" href="<?php echo $URL->siteURL;?>chamados/visualizar/deletar/<?php echo (!empty($Ch->ID)) ? $Ch->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" />Excluir</div></a><?php }else{?><div class="btnAct" onclick="AcNegado();"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" />Excluir</div><?php }?>
        <a href="<?php echo $URL->siteURL;?>imprimir/chamado/<?php echo (!empty($Cl->ID)) ? $Cl->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div></a>
        <?php if($S->Pr(21)){?><a href="<?php echo $URL->siteURL;?>os/gerar/<?php echo (!empty($Ch->ID)) ? $Ch->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/blank_page.png" />Gerar O. S.</div></a><?php }?>
		<?php else :?>
        <a href="<?php echo $URL->siteURL;?>imprimir/chamado/<?php echo (!empty($Cl->ID)) ? $Cl->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div></a>
        <?php if($S->Pr(13)){?><a onclick="return confirm('Tem certeza que deseja excluir?');" href="<?php echo $URL->siteURL;?>chamados/visualizar/deletar/<?php echo (!empty($Ch->ID)) ? $Ch->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" />Excluir</div></a><?php }else{?><div class="btnAct" onclick="AcNegado();"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" />Excluir</div><?php }?>
        <?php endif;?>


<script>		
		$('.sepCol2').css('padding-left','0px');
		$('td').css('padding','0px 10px');
		$('td').css('border-right','1px dotted #000');
</script>

<style>
	.action2{
			float:left;
			margin-top:0px;
			margin-left:2px;
	}
	.btnAct{
		margin-left:33px;
		width:150px;
	}
</style>

<div class="sepCont" style="height:50px;"></div>


<?php endif;?>