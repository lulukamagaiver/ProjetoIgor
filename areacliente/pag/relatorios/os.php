<?php
		$S->PrAcess(26); //Visualizar Relatorios de OS
		
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabequipamento.php');
		require_once('lib/tabs/tabmateriaischamado.php');
		require_once('lib/tabs/tabconfiguracoes.php');
		require_once('lib/search.php');
		require_once('lib/relatorios.php');
		
		if(!empty($_POST['FechaOS'])){
				if((!empty($_POST['OS'])) && (is_array($_POST['OS']))){
						foreach($_POST['OS'] as $key => $val){
								$Os = new tabChamado;
								$Os->ConfirmaOS($_POST['OS'][$key]);
						}
				}
		}
		
		if((empty($_POST['Mes'])) || (empty($_POST['Mes']))){
				$_POST['Mes'] = date('m');
				$_POST['Ano'] = date('Y');
		}
		$DFim = "";
		$DIni = "01/".$_POST['Mes']."/".$_POST['Ano'];
		$d->setData($DIni,'BR',1,2);
		$d->setData($d->data,'BR',(-1),1);
		$DFim = $d->data;
		//echo $DIni." |-| ".$DFim;
		
		$Cf = new tabConfiguracoes;
		
		$Cl = new tabClientes;
		$Cl->SqlWhere = $S->ClUsu2();
		$Cl->MontaSQL();
		$Cl->Load();
		
		$B = new Search;
		$B->Periodo('DataOS',$DIni,$DFim);
		$B->Igual('IdCl',((!empty($_POST['Cliente'])) ? $_POST['Cliente'] : ""));
		$B->Igual('StatusOS',((!empty($_POST['Status'])) ? $_POST['Status'] : ""));
		$B->Igual('Status','14');
?>

<h1>Relatório de O.S.:</h1>

<form method="post">
		<div class="inputs">
        		Cliente:<br />
        		<select name="Cliente" id="Cliente">
                		<?php
						for($a=0;$a<$Cl->NumRows;$a++){
								?>
                                <option value="<?php echo $Cl->ID;?>"><?php echo $Cl->Nome;?></option>
                                <?php
						$Cl->Next();
						}
						?>
                </select>
        </div>
        
        <div class="inputsMeio">
        		Mês:<br />
                <select name="Mes" id="Mes">
                		<option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
        		</select>
        </div>
                
        <div class="inputsMeio">
        		Ano:<br />
                <select name="Ano" id="Ano">
                		<option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
        		</select>
        </div>
        
		<div class="inputsMeio">
        		Status:<br />
        		<select name="Status" id="Status">
                		<option value="1">Aberta</option>
                        <option value="2">Fechada</option>
                </select>
        </div>
        
<input name="Envia" value="ok" type="image" style="width:30px; height:30px; float:left; margin-left:0px;" src="imgs/icones/search.png" />
<div class="sepCont" style="height:20px;"></div> 

<script>
		<?php if(!empty($_POST['Cliente'])) :?>$('#Cliente').val('<?php echo $_POST['Cliente'];?>');<?php endif;?>
		<?php if(!empty($_POST['Status'])) :?>$('#Status').val('<?php echo $_POST['Status'];?>');<?php endif;?>
		<?php if(!empty($_POST['Mes'])) :?>$('#Mes').val('<?php echo $_POST['Mes'];?>');<?php endif;?>
		<?php if(!empty($_POST['Ano'])) :?>$('#Ano').val('<?php echo $_POST['Ano'];?>');<?php endif;?>
</script>

<?php
		if((!empty($_POST['Envia'])) || (!empty($_POST['FechaOS']))|| (!empty($_POST['Envia_x']))){	

				$Os = new tabChamado;
				$Os->SqlWhere = $B->Where;
				$Os->MontaSQL();
				$Os->Load();
				$Os->TG['TOnline'] = 0;
				$Os->TG['THOnline'] = 0;
				$Os->TG['TOffline'] = 0;
				$Os->TG['THOffline'] = 0;
				$Os->TG['TOSValor'] = 0;
				$Os->TG['TValor'] = 0;
				$Os->TG['TMat'] = 0;
				$Os->TG['TValorMat'] = 0;
				
				
				
				$Cl2 = new tabClientes($Os->IdCl);
				
				$d->setData();
		
				$a = array();
				$a[0] = "width: 80px; text-align: center;";
				$a[1] = "width: 80px; text-align: center;";
				$a[2] = "width: 294px; text-align: left;";
				$a[6] = "width: 90px; text-align: center;";
				$a[7] = "width: 120px; text-align: center;";
				$a[3] = "width: 100px; text-align: center;";
				$a[4] = "width: 80px; text-align: center;";
				$a[5] = "width: 69px; text-align: center;";
				?>
				<div class="fundoTabela">
						<div class="topoTabela">
								<div style=" <?php echo $a[0];?>">COD</div>
								<div style=" <?php echo $a[1];?>">Data</div>
								<div style=" <?php echo $a[2];?>">Técnico</div>
                                <div style=" <?php echo $a[6];?>">Tipo</div>
                                <div style=" <?php echo $a[7];?>">Hrs/Vlr</div>
								<div style=" <?php echo $a[3];?>">Confirmada</div>
								<div style=" <?php echo $a[4];?>">Mat./Serv.</div>
								<div style=" <?php echo $a[5];?>">Confirm.</div>
						</div>                
						<?php if($Os->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
						<?php for($b=0;$b<$Os->NumRows;$b++){
								$Eq = new tabEquipamento($Os->IDEquipamento);
								$Tc = new tabAdmm($Os->IDTecnico);
								$Mt = new tabMateriaisChamado;
								$Mt->SqlWhere = "IDChamado = '".$Os->ID."'";
								$Mt->MontaSQL();
								$Mt->Load();
						?>
						<div class="linhasTabela">
								<div class="haha" style=" <?php echo $a[0];?>"><?php echo $Os->COD($Os->ID);?>
								<p class="balaodialogo">
								<strong>Equip./Prod.: </strong><?php echo $Eq->Equipamento; ?><br />
								<strong>Responsável: </strong><?php echo $Os->Contato1; ?><br />
								<strong>Telefones: </strong><?php echo $Cl2->Tel; ?><br />
								<strong>Descrição: </strong><?php echo $Os->Descricao; ?>
								</p>
								</div>
								<div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($Os->DataOS));?></div>
								<div style=" <?php echo $a[2];?>"><?php echo $Tc->Apelido;?></div>
                                <div style=" <?php echo $a[6];?><?php echo ($Os->TipoCob == 3) ? "color:#AAA;" : "";?>">
                                <?php
										if(($Os->TipoCob < 3) && ($Os->TipoOS == 1)){
												$Os->TG['TOnline']++;
												$Os->TG['THOnline'] = $Os->TG['THOnline'] + $URL->t2d($Os->TempoOS);
										}
										if(($Os->TipoCob < 3) && ($Os->TipoOS != 1)){
												$Os->TG['TOffline']++;
												$Os->TG['THOffline'] = $Os->TG['THOnline'] + $URL->t2d($Os->TempoOS);
										}
										if($Os->TipoCob == 3){
												$Os->TG['TOSValor']++;
												$Os->TG['TValor'] = $Os->TG['TValor'] + $Os->ValorCob;
										}
								?>
                                <input type="checkbox" disabled <?php echo (($Os->TipoCob != 3) && ($Os->TipoOS == 1)) ? "checked" : "";?> /> On-Line
                                
                                </div>
                                <!--VALOR OU TEMPO DA OS-->
                                <div style=" <?php echo $a[7];?>">
                                		<?php 
										if(($Os->TipoCob < 3) && ($Cl2->Contrato == 1)){
												if($Cl2->Contrato == 1) echo $Os->TempoOS;
										}else{
												if($Cl2->Contrato == 1) echo "R$ ".number_format($Os->ValorCob,1,',','');
												elseif($Os->TipoCob < 3){
													 echo "R$ ".number_format(($URL->t2d($Os->TempoOS,2)*$Cl2->VHora),2,',','')." (".$Os->TempoOS.")";
												}
												else echo "R$ ".number_format($Os->ValorCob,2,',','');
										}
										?>
                                </div>
								<div style=" <?php echo $a[3];?>"><?php echo ($Os->Confirmada == 1) ? "Sim" : "Não";?></div>
								<div style=" <?php echo $a[4];?>"><?php
								if($Mt->NumRows > 0){
										$Os->TG['TMat']++;
										$Os->TG['TValorMat'] = $Os->TG['TValorMat'] + $Mt->MAX($Os->ID); 
										echo "SIM";
								}else echo "NÃO";
								?></div>
								<div style=" <?php echo $a[5];?>">
                                <input type="checkbox" name="OS[]" class="chk" <?php echo ($Os->Confirmada == 1) ? "checked disabled" : "";?> value="<?php echo $Os->ID;?>" />
								</div>
						</div>
						<?php $Os->Next(); }?>
						
						<div class="topoTabela">
								<div style="width:100%; text-align:center;"></div>
						</div>
				</div>
                
                <input name="FechaOS" value="OK" type="submit" style="display:none;" />
                <div class="btnAct" onclick="return $('input[name=FechaOS]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/like.png" /> Confirmar Selecionadas</div>
                
</form>
                
                <div class="sepCont"></div>
                
                <p class="left">
                Cliente: <strong><?php echo $Cl2->Nome;?></strong><br />
                <?php if($Cl2->Contrato == 1) :?>
                Valor do Contrato: <strong>R$ <?php echo number_format($Cl2->VContrato,2,',','');?></strong><br />
                HorasContratadas: <strong><?php echo $Cl2->QNTHoras;?></strong><br />
                <?php endif;?>
                Valor Hora Excedente: <strong>R$ <?php echo number_format($Cl2->VHora,2,',','');?></strong><br />
                </p>
                
                <div class="sepCont"></div>
                
                
                
                <!-----------------------------------------------RELATORIO DETALHADO --------------------------------------------->
                
                <div class="sepCol3">
                		<strong>ON-LINE</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOnline'];?></strong><br />
                        Total de Horas: <strong><?php echo $URL->d2t($Os->TG['THOnline']);?></strong><br />
                        <?php 
						if((!empty($Cl2->Desconto)) && ($Cl2->Desconto != 0)){
								$THOnline = ((100 - $Cl2->Desconto) / 100) * $Os->TG['THOnline'];
								$Desc = $Cl2->Desconto;
						}else{
								$THOnline = ((100 - $Cf->OSOnLine) / 100) * $Os->TG['THOnline'];
								$Desc = $Cf->OSOnLine;
						}
						?>
                        Total de horas (<?php echo 100 - $Desc;?>%): <strong><?php echo $URL->d2t($THOnline)?></strong>
                </div>
                                
                <div class="sepCol3">
                		<strong>OFF-LINE</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOffline'];?></strong><br />
                        Total de Horas: <strong><?php echo $URL->d2t($Os->TG['THOffline']);?></strong><br />
                </div>
                                
                <div class="sepCol3">
                		<strong>GERAL</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOffline'] + $Os->TG['TOnline'];?></strong><br />
                        Total de Horas: <strong><?php echo $URL->d2t($Os->TG['THOffline'] + $THOnline);?></strong><br />
                        Horas Restantes: <strong>
						<?php 
						$TRes = (($URL->t2d($Cl2->QNTHoras)) - ($Os->TG['THOffline'] + $THOnline));
						echo ($TRes > 0) ? $URL->d2t($TRes) : "00:00:00";
						?>
                        </strong><br />
                        Horas Excedentes: <strong><?php if($TRes < 0) echo $URL->d2t($TRes * (-1)); else echo "00:00:00";?></strong><br />
                        Valor Excedente: <strong>R$ <?php
						if($TRes < 0) $VExc = (($TRes * $Cl2->VHora) * (-1));
						else $VExc = 0;
						if($TRes < 0) echo number_format($VExc,2,',',''); else echo "0,00";?></strong>

                </div>
                
                <div class="sepCont"></div>
                                
                <div class="sepCol3">
                		<strong>VALOR</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOSValor'];?></strong><br />
                        Valor: <strong>R$ <?php echo number_format($Os->TG['TValor'],2,',','');?></strong>
                </div>
                
                <?php if($Os->TG['TMat'] > 0) :?>             
                <div class="sepCol3">
                		<strong>MATERIAIS/SERVIÇOS</strong><br />
                        Valor Total: <strong><?php echo number_format($Os->TG['TValorMat'],2,',','');?></strong>
                </div>
                <?php endif;?>
                
                <div class="sepCont"></div>
                
                <div class="sepCol3">
                		<br /><br />
                		<strong>Valor Total: <font color="#FF0000"><?php echo number_format(($VExc + $Cl2->VContrato + $Os->TG['TValor'] + $Os->TG['TValorMat']),2,',','');?></font></strong>
                </div>
                
                
<?php
                }
?>