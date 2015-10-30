<?php
		$S->PrAcess(22);
		
		include_once('lib/relatorios.php');
		include_once('lib/search.php');
		include_once('lib/tabs/tabconfiguracoes.php');
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
		$B->Igual('ch.StatusOS',(!empty($_POST['Status'])) ? $_POST['Status'] : "");
		$B->Igual('ch.Status','14');
		$B->Igual('cl.ID',(!empty($_POST['Busca'])) ? $_POST['Busca'] : "");
		$B->Like('eq.Equipamento',(!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "");
		$B->Periodo('ch.Data',((!empty($_POST['DIni'])) ? $_POST['DIni'] : ""),((!empty($_POST['DFim'])) ? $_POST['DFim'] : ""));
		
		$C = new Search;
		$C->Igual('ID',(!empty($_POST['Tecnico'])) ? $_POST['Tecnico'] : "");

		$VerMais = 0;
		
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				//DELETAR
				if(((!empty($url[1])) && ($url[1] == 'deletarordserv')) && (is_numeric($url[2]))){
					if($S->Pr(24)){ //Deletar OS
						$Del = new tabChamado;
						if($Del->DeletaOS($url[2])) {
							$W->AddAviso('O.S. removida.','WS');
						}
						else $W->AddAviso('Problemas ao deletar O.S.','WE');
					}else $W->AddAviso('Você não possui permissão para esta ação.','WE');
				}
				
				//DELETAR Chamado
				
				
				if(((!empty($url[1])) && ($url[1] == 'deletarchamado')) && (is_numeric($url[2]))){
					if($S->Pr(13)){ //Deletar Chamado
						$Del = new tabChamado;
						if($Del->DeletaChamado($url[2])) {
							$W->AddAviso('O.S. removida.','WS');
						}
						else $W->AddAviso('Problemas ao deletar O.S.','WE');
					}else $W->AddAviso('Você não possui permissão para esta ação.','WE');
				}
				
				//Definir qual cliente será exibido
				if(((!empty($url[0])) && ($url[0] == 'visualizar')) && (is_numeric($url[1]))){
						$VerMais = 1;
				}				
		}
		
		$ClWhere = "";
		foreach(explode(',',$S->Cl) as $key => $val){
				if($key == 0) $ClWhere .= "ID = '".$val."'";
				else $ClWhere .= " || ID = '".$val."'";
		}
		
		$ClB = new tabClientes;
		$ClB->SqlWhere = $ClWhere;
		$ClB->MontaSQL();
		$ClB->Load();
		



if($VerMais == 0) :
		$Us = new tabAdmm;
		$Us->SqlWhere = $C->Where;
		$Us->SqlOrder = "FIELD(ID, ".$S->ID.") DESC, Nome ASC";
		$Us->MontaSQL();
		$Us->Load();
		$Us->TG['Chamados'] = 0;
		
	
		$tt2 = new DBConex;
		$tt2->Tabs = array('ID','Data','Status','Cliente','Equipamento','Responsavel','Telefone','Descricao','Confirmada','StatusOS');
		$tt2->Query = "SELECT ch.ID AS ID, ch.DataOS AS Data, ch.StatusOS AS StatusOS, ch.Confirmada AS Confirmada, st.Descricao AS Status, cl.Nome AS Cliente, eq.Equipamento AS Equipamento, cl.Tel AS Telefone, ch.Contato1 AS Responsavel, ch.Descricao AS Descricao FROM chamado AS ch INNER JOIN statuschamados AS st ON st.ID = ch.Status INNER JOIN clientes AS cl ON cl.ID = ch.IdCl INNER JOIN equipamento AS eq ON eq.ID = ch.IDEquipamento
		WHERE ".$S->ClUsu(true)."".((!empty($B->Where)) ? " AND ".$B->Where : ""). "ORDER BY ch.StatusOS";;
		$tt2->MontaSQLRelat();
		$tt2->Load();
		$Us->TG['Chamados'] = $Us->TG['Chamados'] + $tt2->NumRows; 
		
		$d->setData();
?>

<h1>Consultar Ordem de Serviço</h1>
		
		<form method="post" style="float:left; width:100%;">		
        <div class="sepCont"></div>
                		<div class="inputsMeio" style="margin-left:-6px;">
                        		COD: <br />
                                <input type="text" name="COD" id="COD" value="<?php echo (!empty($_POST['COD'])) ? $_POST['COD'] : "";?>" />
                        </div>
                        
                		<div class="inputs">
                        		Cliente: <br />
                                <select name="Busca" id="Busca" value="<?php echo (!empty($_POST['Busca'])) ? $_POST['Busca'] : "";?>">
                                <?php
								for($z=0;$z<$ClB->NumRows;$z++){
										?>
                                        <option value="<?php echo $ClB->ID;?>"><?php echo $ClB->Nome;?></option>
                                        <?php
								$ClB->Next();
								}
								?>
                                </select>
                                <?php if(!empty($_POST['Busca'])){?><script>$('#Busca').val('<?php echo $_POST['Busca'];?>');</script><?php }?>
                        </div>

                        <div class="inputsMeio">
                        		Status:<br />
                                <select name="Status" id="Status">
                                		<option value="">Todos</option>
                                        <option value="1">Aberta</option>
                                        <option value="2">Fechada</option>
                                </select>
                        </div>
                                                
                        <div class="inputsMeio">
                        		Equi./Prod.:<br />
                                <input type="text" name="Equipamento" id="Equipamento" value="<?php echo (!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "";?>" />
                        </div>
                                                                        
                        <div class="inputsMeio">
                        		Técnico:<br />
                                <select name="Tecnico" id="Tecnico">
                                		<option value="">Todos</option>
                                        <?php
												$Tec = new tabAdmm;
												$Tec->MontaSQL();
												$Tec->Load();
												for($a=0;$a<$Tec->NumRows;$a++){
														echo '<option value="'.$Tec->ID.'">'.$Tec->Apelido.'</option>';
												$Tec->Next();
												}
										?>
                                </select>
                        </div>
                        
                        <div class="inputsMeio">
                        		D. Inicial:<br />
                                <input type="text" name="DIni" id="DIni" value="<?php echo (!empty($_POST['DIni'])) ? $_POST['DIni'] : '01/'.$d->mes.'/'.$d->ano;?>" />
                        </div>
                        
                        <div class="inputsMeio">
                        		D. Final:<br />
                                <input type="text" name="DFim" id="DFim" value="<?php echo (!empty($B->DataFim)) ? $B->DataFim : ((!empty($_POST['DFim'])) ? $_POST['DFim'] : "");?>" />
                        </div>
		
        <input name="" type="image" style="width:30px; height:30px; float:left; margin-left:-23px; margin-top:17px; position:absolute;" src="imgs/icones/search.png" />
        <div class="sepCont" style="height:20px;"></div>        
        </form>        
        
        <!--<a href="<?php echo $URL->NURL;?>clientes/cadastrar/">
        <input name="" type="button" value="Novo" class="btnAZ" style="float:right; margin-bottom:20px; background-color:#09C;" />
        </a>-->
		<?php
		$a = array();
		$a[0] = "width: 80px; text-align: center;";
		$a[1] = "width: 80px; text-align: center;";
		$a[2] = "width: 526px; text-align: left;";
		$a[3] = "width: 100px; text-align: center;";
		$a[4] = "width: 80px; text-align: center;";
		$a[5] = "width: 69px; text-align: center;";
		?>
		<div class="fundoTabela">
        		<div class="topoTabela">
                		<div style=" <?php echo $a[0];?>">COD</div>
                        <div style=" <?php echo $a[1];?>">Data</div>
                        <div style=" <?php echo $a[2];?>">Cliente</div>
                        <div style=" <?php echo $a[3];?>">Confirmada</div>
                        <div style=" <?php echo $a[4];?>">Status</div>
                        <div style=" <?php echo $a[5];?>">Ações</div>
                </div>

                <?php if($tt2->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
                <?php for($b=0;$b<$tt2->NumRows;$b++){?>
        		<div class="linhasTabela">
                		<div class="haha" style=" <?php echo $a[0];?>"><?php echo $URL->COD($tt2->ID);?>
                        <p class="balaodialogo">
                        <strong>Equip./Prod.: </strong><?php echo $tt2->Equipamento; ?><br />
                        <strong>Responsável: </strong><?php echo $tt2->Responsavel; ?><br />
                        <strong>Telefones: </strong><?php echo $tt2->Telefone; ?><br />
                        <strong>Descrição: </strong><?php echo $tt2->Descricao; ?>
                        </p>
                        </div>
                        <div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($tt2->Data));?></div>
                        <div style=" <?php echo $a[2];?>"><?php echo $tt2->Cliente;?></div>
                        <div style=" <?php echo $a[3];?>"><?php echo ($tt2->Confirmada == 1) ? "Sim" : "Não";?></div>
                        <div style=" <?php echo $a[4];?>"><?php echo ($tt2->StatusOS == 1) ? "Aberta" : "Fechada";?></div>
                        <div style=" <?php echo $a[5];?>">
                        <?php if($S->Pr(22)) {?><a href="<?php echo $URL->siteURL?>os/visualizar/<?php echo $tt2->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /></a><?php } else{?><img onclick="AcNegado();" src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /><?php }?>
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
		if(!empty($_POST['Fechar'])){
				$Fc = new tabChamado;
				$Fc->SqlWhere = "ID = '".$url[1]."'";
				$Fc->MontaSQL();
				$Fc->Load();
				
				$Fc->Confirmada = 1;
				
				$Fc->Update($url[1]);
				if($Fc->Result){
						$Cf = new tabConfiguracoes('1');
						$Checks = explode(',',$Cf->Checks);
						
						if(in_array('17',$Checks)){
								$Tec = new tabAdmm;
								$Tec->SqlWhere = "ID = '".$Fc->IDTecnico."'";
								$Tec->MontaSQL();
								$Tec->Load();
								
								$MSG = $S->Apelido." confirmou a O.S. ".$URL->COD($Fc->ID);
								
								for($a=0;$a<$Tec->NumRows;$a++){
										$TecEmail = explode(';',$Tec->Email);
										foreach($TecEmail as $key => $val){
												//Envia pra usuarios CLientes
												$URL->Emails($val,$MSG,"Confirmação de O.S. #".$URL->COD($Fc->ID));	
										}
								}
						}
						$W->AddAviso('O.S. foi confirmada com sucesso!','WS');
				}else $W->AddAviso('Problemas ao confirmar O.S.','WA');
				
		}
?>
		
<h1>Consultar O.S. #<?php echo $URL->COD($url[1]);?></h1>
        
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
		
		$Ad = new tabAdmm;
		$Ad->SqlWhere = "ID = '".$Ch->IDTecnico."'";
		$Ad->MontaSQL();
		$Ad->Load();
		
		
		$MTotal = new DBConex;
		$MTotal->Tabs = array('Total');
		$MTotal->Query = "SELECT SUM(VTotal) AS Total FROM materiaischamados WHERE IDChamado = '".$url[1]."'";
		$MTotal->MontaSQLRelat();
		$MTotal->Load();
		?>

<form method="post" action="">

		<div class="inputsLarge">
        		Cliente:<br />
                <input type="text" readonly style="width:310px; color:#F00;" value="<?php echo (!empty($Cl->Nome)) ? $Cl->Nome : "";;?>" />
                <a href="<?php echo $URL->siteURL;?>clientes/visualizar/<?php echo $Cl->ID;?>/"><img src="<?php echo $URL->siteURL;?>imgs/icones/zoom_in.png" width="30" height="30" style="position:absolute; margin:-2px 0 0 5px;" /></a>
        </div>
        
        <div class="inputs">
        		<br />
                <?php echo ($Cl->Contrato == 1) ? "<strong>(COM CONTRATO)</strong>" : "";?>
        </div>
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Data:<br />
                <input type="text" readonly style="" value="<?php echo (!empty($Ch->DataOS)) ? date("d/m/Y H:i:s",strtotime($Ch->DataOS)) : "";?>" />
        </div>
        
		<div class="inputs">
        		Telefone:<br />
                <input type="text" readonly style="" value="<?php echo (!empty($Cl->Tel)) ? $Cl->Tel : "";?>" />
        </div>
                
		<div class="inputs">
        		Telefone:<br />
                <input type="text" readonly style="" value="<?php echo (!empty($Cl->Cel)) ? $Cl->Cel : "";?>" />
        </div>
                
		<div class="inputs">
        		Email:<br />
                <input type="text" readonly style="" value="<?php echo (!empty($Cl->Email)) ? $Cl->Email : "";?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="sepCol2" style="height:auto;">
                <div class="inputs">
                        Equipamento:<br />
                        <input type="text" readonly style="" value="<?php echo (!empty($Eq->Equipamento)) ? $Eq->Equipamento : "Outro";?>" />
                </div><br />
                <div class="sepCont"></div>
                <p style="margin-left:15px;"><?php echo (!empty($Eq->Descricao)) ? $Eq->Descricao : "";?></p>
        </div>
        
        <div class="sepCont"></div>
        
				<?php if(($Ch->TipoCob < 3) && ($Cl->Contrato == 1) && ($Ch->TipoOS == 1)) :?>
                <div class="inputs">
                        Duração:<br />
                        <input type="text" readonly value="<?php echo (!empty($Ch->TempoOS)) ? $Ch->TempoOS : "00:00:00";?>" />
                </div>
                        
                <div class="inputs">
                        <br />
                        <input type="checkbox" readonly <?php echo ($Ch->TipoOS == 1) ? "checked" : "";?> /> On-Line
                </div>
                <?php else :?>
                <div class="inputs">
                        Serviço:<br />
                        <?php if($Cl->Contrato == 1) {
								if($Ch->TipoOS == 1){?><input type="text" readonly value="R$ <?php echo (!empty($Ch->ValorCob)) ? number_format($Ch->ValorCob,2,',','') : "0,00";?>" />
                        <?php }else { $Valor = $URL->t2d($Ch->TempoOS,2)*$Cl->VHora;?>
                        		<input type="text" readonly value="R$ <?php echo (!empty($Valor)) ? number_format($Valor,2,',','')." (".$Ch->TempoOS.")" : "0,00";?>" />
                        <?php }?>
						<?php }elseif($Ch->TipoCob < 3) {
								$Valor = $URL->t2d($Ch->TempoOS,2)*$Cl->VHora;
								
								?><input type="text" readonly value="R$ <?php echo (!empty($Valor)) ? number_format($Valor,2,',','')." (".$Ch->TempoOS.")" : "0,00";?>" />
						<?php } else{
								$Valor = $Ch->ValorCob;
								?><input type="text" readonly value="R$ <?php echo (!empty($Valor)) ? number_format($Valor,2,',','') : "0,00";?>" /><?php }?>
                        
                </div>
                <?php endif;?>                
                <?php if($MTotal->Total > 0) :?>
                <div class="inputs">
                        Materiais/Serviços:<br />
                        <input type="text" readonly value="<?php echo "R$ ".number_format($MTotal->Total,2,',','');?>" />
                </div>
                <?php endif;?>
                
                <?php if($Cl->Contrato == 0) :?>
                <div class="inputs">
                        Total:<br />
                        <input type="text" readonly value="<?php echo "R$ ".number_format(($Valor + $MTotal->Total),2,',','');?>" />
                </div>
                <?php endif;?>
                
                
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Status:<br />
                <input type="text" readonly style="color:#F00;" value="<?php echo ($Ch->StatusOS == 1) ? "Aberta" : "Fechada";?>" />
        </div>
                
		<div class="inputs">
        		Confirmada:<br />
                <input type="text" readonly style="color:#F00;" value="<?php echo ($Ch->Confirmada == 1) ? "Sim" : "Não";?>" />
        </div>
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Técnico:<br />
                <input type="text" readonly style="color:#F00;" value="<?php echo ($Ch->IDTecnico != 0) ? ((!empty($Ad->Apelido)) ? $Ad->Apelido : "") : "Todos";?>" />
        </div>
        
        <div class="sepCont"></div>
               
        <div class="sepCol2" style="height:auto;">
				<div class="txtArea">
                Descrição:<br />
                <textarea style="width:300px;" readonly><?php echo (!empty($Ch->DescricaoOS)) ? $Ch->DescricaoOS : "";?></textarea>
                </div>
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Fechar" value="1" style="display:none;" />
        
</form>  
     	<?php if($Ch->StatusOS == 1) :?>
        <div class="btnAct" onclick="return $('input[name=Fechar]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/like.png" /> Confirmar</div>
        <?php endif;?>
        <?php if($S->Pr(22)){?><a href="<?php echo $URL->siteURL;?>os/imprimir/<?php echo (!empty($Ch->ID)) ? $Ch->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div></a><?php }else{?><div class="btnAct" onclick="AcNegado();"><img src="<?php echo $URL->siteURL;?>imgs/icones/tools.png" />Mat./Serv.</div><?php }?>

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
		$RMat->WidthCols = array('54','580','120','70','120','0');
		$RMat->Cols = array('ID','Descricao','Valor','QNT','VTotal','ID');
		$RMat->Totais = array(0,0,0,0,1,0);
		$RMat->Formato = array('cod','','moeda','','moeda','');
		$RMat->Actions = '';
		$RMat->Query = $Mat->Query;
		$RMat->setTitulos(array('#:center','Descrição:left','Valor:center','QNT:center','Total:center','ID:kkk'));
		$RMat->showTab();
		
		}
?>

<script>		
		$('.sepCol2').css('padding-left','0px');
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