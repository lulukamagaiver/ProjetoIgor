<?php
		$S->PrAcess('');
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabconfiguracoes.php');
		
		
		$Cf = new tabConfiguracoes;
		$arr = explode(',',$Cf->Checks);
		
		$RT = new getDate;
		$FatorGraf = 60 / 100;
?>

<h1>Notificações</h1>

<p class="left" style="text-align:center; width:100%;"><?php echo $Cf->MSGPainel;?></p>

<h4>Seus Chamados Abertos</h4>

		<?php
		$Us = new tabAdmm;
		$Us->SqlOrder = "FIELD(ID, ".$S->ID.") DESC, Nome ASC";
		$Us->MontaSQL();
		$Us->Load();
		$Us->TG['Chamados'] = 0;
		
		$tt2 = new DBConex;
		$tt2->Tabs = array('ID','Data','Status','Cliente','Equipamento','Responsavel','Telefone','Descricao');
		$tt2->Query = "SELECT ch.ID AS ID, ch.Data AS Data, st.Descricao AS Status, cl.Nome AS Cliente, eq.Equipamento AS Equipamento, cl.Tel AS Telefone, ch.Contato1 AS Responsavel, ch.Descricao AS Descricao FROM chamado AS ch INNER JOIN statuschamados AS st ON st.ID = ch.Status INNER JOIN clientes AS cl ON cl.ID = ch.IdCl INNER JOIN equipamento AS eq ON eq.ID = ch.IDEquipamento
		WHERE ".$S->ClUsu(true)." AND ch.Status != '14'";
		$tt2->MontaSQLRelat();
		$tt2->Load();
		$Us->TG['Chamados'] = $Us->TG['Chamados'] + $tt2->NumRows; 
		
		$d->setData();

		$a = array();
		$a[0] = "width: 110px; text-align: ".((in_array('9',$arr)) ? "left" : "center").";";
		$a[1] = "width: 80px; text-align: center;";
		$a[2] = "width: 520px; text-align: left;";
		$a[3] = "width: 167px; text-align: center;";
		$a[4] = "width: 69px; text-align: center;";
		?>
		<div class="fundoTabela">
        		<div class="topoTabela">
                		<div style=" <?php echo $a[0];?>">COD</div>
                        <div style=" <?php echo $a[1];?>">Data</div>
                        <div style=" <?php echo $a[2];?>">Cliente</div>
                        <div style=" <?php echo $a[3];?>">Status</div>
                        <div style=" <?php echo $a[4];?>">Ações</div>
                </div>

                <?php if($tt2->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
                <?php for($b=0;$b<$tt2->NumRows;$b++){
						
						$TDias = $RT->RetornaDias($tt2->Data);
						$TDiasIcon = 0;
						
						if($TDias < 2) $TDiasIcon = 1;
						if($TDias > 2) $TDiasIcon = 2;
						if($TDias > 5) $TDiasIcon = 3;
						if($TDias > 10) $TDiasIcon = 4;
						if($TDias > 15) $TDiasIcon = 5;
						
						$TDiasIcon = ($tt2->Status == 14) ? 0 : $TDiasIcon;	
							
						?>
        		<div class="linhasTabela">
                		<div class="haha" style=" <?php echo $a[0];?>"><?php echo $tt2->COD($tt2->ID);?> <?php if(in_array('9',$arr)) :?>
                        <!--<img src="<?php echo $URL->siteURL?>imgs/icones/status_ch_<?php echo $TDiasIcon;?>.gif" style="position:absolute; width:14px; height:14px; margin:8px 0px; left:0px; margin-left:80px;" class="action" />-->
                        <span class="GrafOS" style="width:<?php echo (($FatorGraf * $RT->RetornaHoras($tt2->Data)) > 60) ? '60' : ($FatorGraf * $RT->RetornaHoras($tt2->Data));?>px "></span><div class="TXTGrafOS"><?php echo number_format($RT->RetornaHoras($tt2->Data),0);?>%</div><?php endif;?>
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
                        </div>
                </div>
                <?php $tt2->Next(); }?>
                
        		<div class="topoTabela">
                		<div style="width:100%; text-align:center;">Total de chamados: <?=$Us->TG['Chamados']?></div>
                </div>
        </div>


<h4>O.S. Não Confirmadas e Abertas</h4>
<?php	
		$Us->TG['OSNaoConfAberta'] = 0;
		$Os2 = new DBConex;
		$Os2->Tabs = array('ID','Data','Status','Cliente','Equipamento','Responsavel','Telefone','Descricao','Confirmada','StatusOS');
		$Os2->Query = "SELECT ch.ID AS ID, ch.DataOS AS Data, ch.StatusOS AS StatusOS, ch.Confirmada AS Confirmada, st.Descricao AS Status, cl.Nome AS Cliente, eq.Equipamento AS Equipamento, cl.Tel AS Telefone, ch.Contato1 AS Responsavel, ch.Descricao AS Descricao FROM chamado AS ch INNER JOIN statuschamados AS st ON st.ID = ch.Status INNER JOIN clientes AS cl ON cl.ID = ch.IdCl INNER JOIN equipamento AS eq ON eq.ID = ch.IDEquipamento
		WHERE ".$S->ClUsu(true)." AND ch.Confirmada = '0' AND ch.StatusOS = '1'";
		$Os2->MontaSQLRelat();
		$Os2->Load();
		$Us->TG['OSNaoConfAberta'] = $Us->TG['OSNaoConfAberta'] + $Os2->NumRows; 
		
		$d->setData();

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
                <?php if($Os2->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
                <?php for($b=0;$b<$Os2->NumRows;$b++){?>
        		<div class="linhasTabela">
                		<div class="haha" style=" <?php echo $a[0];?>"><?php echo $Os2->COD($Os2->ID);?>
                        <p class="balaodialogo">
                        <strong>Equip./Prod.: </strong><?php echo $Os2->Equipamento; ?><br />
                        <strong>Responsável: </strong><?php echo $Os2->Responsavel; ?><br />
                        <strong>Telefones: </strong><?php echo $Os2->Telefone; ?><br />
                        <strong>Descrição: </strong><?php echo $Os2->Descricao; ?>
                        </p>
                        </div>
                        <div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($Os2->Data));?></div>
                        <div style=" <?php echo $a[2];?>"><?php echo $Os2->Cliente;?></div>
                        <div style=" <?php echo $a[3];?>"><?php echo ($Os2->Confirmada == 1) ? "Sim" : "Não";?></div>
                        <div style=" <?php echo $a[4];?>"><?php echo ($Os2->StatusOS == 1) ? "Aberta" : "Fechada";?></div>
                        <div style=" <?php echo $a[5];?>">
                        <?php if($S->Pr(22)) {?><a href="<?php echo $URL->siteURL?>os/visualizar/<?php echo $Os2->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /></a><?php } else{?><img onclick="AcNegado();" src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /><?php }?>
                        </div>
                </div>
                <?php $Os2->Next(); }?>
                
        		<div class="topoTabela">
                		<div style="width:100%; text-align:center;">Total de O.S.: <?=$Us->TG['OSNaoConfAberta']?></div>
                </div>
        </div>


<h4>O.S. Confirmadas em Aberto</h4>

<?php	
		$Us->TG['OSConfAberta'] = 0;
		$Os = new DBConex;
		$Os->Tabs = array('ID','Data','Status','Cliente','Equipamento','Responsavel','Telefone','Descricao','Confirmada','StatusOS');
		$Os->Query = "SELECT ch.ID AS ID, ch.DataOS AS Data, ch.StatusOS AS StatusOS, ch.Confirmada AS Confirmada, st.Descricao AS Status, cl.Nome AS Cliente, eq.Equipamento AS Equipamento, cl.Tel AS Telefone, ch.Contato1 AS Responsavel, ch.Descricao AS Descricao FROM chamado AS ch INNER JOIN statuschamados AS st ON st.ID = ch.Status INNER JOIN clientes AS cl ON cl.ID = ch.IdCl INNER JOIN equipamento AS eq ON eq.ID = ch.IDEquipamento
		WHERE ".$S->ClUsu(true)." AND ch.Confirmada = '1' AND ch.StatusOS = '1'";
		$Os->MontaSQLRelat();
		$Os->Load();
		$Us->TG['OSConfAberta'] = $Us->TG['OSConfAberta'] + $Os->NumRows; 
		
		$d->setData();

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
                <?php if($Os->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
                <?php for($b=0;$b<$Os->NumRows;$b++){?>
        		<div class="linhasTabela">
                		<div class="haha" style=" <?php echo $a[0];?>"><?php echo $Os->COD($Os->ID);?>
                        <p class="balaodialogo">
                        <strong>Equip./Prod.: </strong><?php echo $Os->Equipamento; ?><br />
                        <strong>Responsável: </strong><?php echo $Os->Responsavel; ?><br />
                        <strong>Telefones: </strong><?php echo $Os->Telefone; ?><br />
                        <strong>Descrição: </strong><?php echo $Os->Descricao; ?>
                        </p>
                        </div>
                        <div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($Os->Data));?></div>
                        <div style=" <?php echo $a[2];?>"><?php echo $Os->Cliente;?></div>
                        <div style=" <?php echo $a[3];?>"><?php echo ($Os->Confirmada == 1) ? "Sim" : "Não";?></div>
                        <div style=" <?php echo $a[4];?>"><?php echo ($Os->StatusOS == 1) ? "Aberta" : "Fechada";?></div>
                        <div style=" <?php echo $a[5];?>">
                        <?php if($S->Pr(22)) {?><a href="<?php echo $URL->siteURL?>os/visualizar/<?php echo $Os->ID;?>/"><img src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /></a><?php } else{?><img onclick="AcNegado();" src="<?php echo $URL->siteURL?>imgs/icones/zoom_in.png" class="action" /><?php }?>
                        </div>
                </div>
                <?php $Os->Next(); }?>
                
        		<div class="topoTabela">
                		<div style="width:100%; text-align:center;">Total de O.S.: <?=$Us->TG['OSConfAberta']?></div>
                </div>
        </div>