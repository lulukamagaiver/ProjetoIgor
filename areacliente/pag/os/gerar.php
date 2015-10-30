<?php
		$S->PrAcess(21); // Gerar OS
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabequipamento.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/relatorios.php');
		
		$Verifica = false;
		
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				$Ch = new tabChamado($url[0]); //Pega detalhes do chamado
				$Cl = new tabClientes($Ch->IdCl); // Pega detalhes do cliente
				$Eq = new tabEquipamento($Ch->IDEquipamento); //Pega detalhes do equipamento

		
		if(!empty($_POST['Salvar'])){
			$Alt = ((!empty($Ch->DataOS)) && ($Ch->DataOS != '0000-00-00')) ? true : false;
				if(empty($_POST['TipoOS'])) $_POST['TipoOS'] = 0;
				if((!empty($_POST['DescricaoOS']))){
						if(!empty($_POST['Cobranca'])){
								switch($_POST['Cobranca']){
										case "1" :
												if(((!empty($_POST['HIni'])) && (!empty($_POST['HFim']))) || (!empty($_POST['HTotal']))){
														if(empty($_POST['HTotal'])){
																$HIni = strtotime($_POST['HIni']);
																$HFim = strtotime($_POST['HFim']);
																$_POST['TempoOS'] = $URL->Horas($HFim - $HIni);
																$Verifica = true;
														}else{
																$_POST['TempoOS'] = $_POST['HTotal'].":00";
																$Verifica = true;															
														}
												}else $Verifica == false;
										break;
										case "2" :
												if((!empty($_POST['HTotal']))){
														$_POST['TempoOS'] = $_POST['HTotal'].":00";
														$Verifica = true;
												}else $Verifica == false;
										break;
										case "3" :
												if((!empty($_POST['ValorCob']))){
														$_POST['ValorCob'] = str_replace(',','.',$_POST['ValorCob']);
														$Verifica = true;
												}else $Verifica == false;
										break;
										default : $verifica = false;
								}
								if($Verifica == true){
										$_POST['TipoCob'] = $_POST['Cobranca'];
										if(empty($_POST['TipoOS'])) $_POST['TipoOS'] = 0; 
										$_POST['StatusOS'] = 1;
										$_POST['Confirmada'] = 0;
										$_POST['TempoAtendimento'] = date('Y-m-d H:i:s');
										if($Ch->DataOS == '0000-00-00 00:00:00')$Ch->DataOS = date('Y-m-d H:i:s');
										$Ch->GetValPost();
										$Ch->Status = 14;
										
										
										$Ch->Update($url[0]);
										if($Ch->Result){										
												$msgExtra = "";
												if($Cl->Assinatura == 1) $msgExtra = "OS deste cliente devem ser assinadas.";
												$W->AddAviso('OS '.(($Alt) ? "Alterada" : "Cadastrada").'. '.$msgExtra,'WS');
										}else $W->AddAviso('Problemas ao gerar OS.','WE');
										
								}else $W->AddAviso('Preencha todos os campos necessárioss.','WA');
						}else $W->AddAviso('Defina uma forma de cobrança','WA');
				}else $W->AddAviso('Preencha todos os campos necessários.','WA');
		}
		
?>

<h1><?php echo ((!empty($Ch->DataOS)) && ($Ch->DataOS != '0000-00-00 00:00:00')) ? "Alterar" : "Gerar";?> Ordem de Serviço #<?php echo $Ch->COD($Ch->ID);?></h1>

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
        		Cobrança:<br />
                <select name="Cobranca" id="Cobranca">
                		<option value="">Selecione</option>
                        <option value="1">Tempo Calculado</option>
                        <option value="2">Tempo Total</option>
                        <option value="3">Valor</option>
                </select>
        </div>
        
        <div class="sepCol2" id="TipoCob" style="width:870px; padding:0; margin:0;">

        </div>
        
        <div class="sepCont"></div>
        <div class="sepCol2">
        <div class="txtArea">
        		Descrição:<br />
        		<textarea name="DescricaoOS" id="DescricaoOS"><?php echo (!empty($_POST['DescricaoOS'])) ? $_POST['DescricaoOS'] : $Ch->DescricaoOS;?></textarea>
        </div>
        </div>
        <div class="sepCont"></div>
        
        <input type="submit" name="Salvar" style="display:none;" value="Salvar" />
        <div onclick="$('input[name=Salvar]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" /> Salvar</div>
        
        <div class="sepCont"></div>
        
        
        <div class="fundoTabela" style="margin-top:40px;">
        		<div class="topoTabela">
                		<div style="width:990px;">Descrição Chamado</div>
                </div>
        		<div class="linhasTabela" style="height:auto">
                		<div style="width:990px; height:auto; min-height:30px; text-align:left;">Descrição Chamado<br />ashbhbcsjhs</div>
                </div>
        </div>
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

		
		$RMat = new Relat('',true);
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
                        <div style=" <?php echo $a[3];?>">Comentário</div>
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
                                        <td width="" height="30" align="left" valign="middle"style=""><?php echo nl2br($Cm->Comentario);?></td>
                                </tr>
                        </table>
                        <?php $Cm->Next(); }?>

                
        		<div class="topoTabela">
                		<div style="width:100%; text-align:center;"></div>
          </div>
        </div>
<?php }?>
        
</form>
<script>
		<?php if((!empty($_POST['Cobranca'])) || (!empty($Ch->TipoCob))) :?>
		$('#Cobranca').val('<?php echo (!empty($_POST['Cobranca'])) ? $_POST['Cobranca'] : $Ch->TipoCob;?>');
				<?php if(((!empty($_POST['Cobranca'])) && ($_POST['Cobranca'] == '1'))) :?>$('#TipoCob').html('<div class="inputsMeio">Hora Inicial:<br /><input type="text" id="HIni" name="HIni" value="<?php echo (!empty($_POST['HIni'])) ? $_POST['HIni'] : "";?>" /></div><div class="inputsMeio">Hora Final:<br /><input type="text" id="HFim" name="HFim" value="<?php echo (!empty($_POST['HFim'])) ? $_POST['HFim'] : "";?>" /></div><div class="sepCont"></div><div class="inputsMeio"><br /><input type="checkbox" name="TipoOS" id="TipoOS" <?php echo ((!empty($_POST['TipoOS'])) && ($_POST['TipoOS'] == 1)) ? "Checked" : (((!empty($Ch->TipoOS)) && ($Ch->TipoOS != 0)) ? "checked" : "");?> value="1" /> On-line</div>');<?php endif;?>
				<?php if(((!empty($_POST['Cobranca'])) && ($_POST['Cobranca'] == '2') && ($_POST['Cobranca'] != '1')) || (($Ch->TipoCob == 2) || ($Ch->TipoCob == 1))) :?>$('#TipoCob').html('<div class="inputsMeio">Tempo Total:<br /><input type="text" id="HTotal" name="HTotal" value="<?php echo (!empty($_POST['HTotal'])) ? $_POST['HTotal'] : $Ch->TempoOS;?>" /></div><div class="sepCont"></div><div class="inputsMeio"><br /><input type="checkbox" name="TipoOS" id="TipoOS" <?php echo ((!empty($_POST['TipoOS'])) && ($_POST['TipoOS'] == 1)) ? "Checked" : (((!empty($Ch->TipoOS)) && ($Ch->TipoOS != 0)) ? "checked" : "");?> value="1" /> On-line</div>');<?php endif;?>
				<?php if(((!empty($_POST['Cobranca'])) && ($_POST['Cobranca'] == '3')) || ($Ch->TipoCob == 3)) :?>$('#TipoCob').html('<div class="inputsMeio" style="width:300px;">Valor:<br /><input type="text" id="ValorCob" name="ValorCob" value="<?php echo (!empty($_POST['ValorCob'])) ? number_format($_POST['ValorCob'],2,',','') : number_format($Ch->ValorCob,2,',','');?>" /><?php if($Mat->NumRows > 0) echo " + R$ ".number_format(($RMat->Soma[4] - 1),2,',','')." (Materiais/Serviços)";?></div>');<?php endif;?>
		<?php endif;?>
		
		
		$(document).ready(function(e) {
				$('#Cobranca').change(function(){
						if($('#Cobranca').val() == '1'){
								$('#TipoCob').html('<div class="inputsMeio">Hora Inicial:<br /><input type="text" id="HIni" name="HIni" value="<?php echo (!empty($_POST['HIni'])) ? $_POST['HIni'] : "";?>" /></div><div class="inputsMeio">Hora Final:<br /><input type="text" id="HFim" name="HFim" value="<?php echo (!empty($_POST['HFim'])) ? $_POST['HFim'] : "";?>" /></div><div class="sepCont"></div><div class="inputsMeio"><br /><input type="checkbox" name="TipoOS" id="TipoOS" <?php echo ((!empty($_POST['TipoOS'])) && ($_POST['TipoOS'] == 1)) ? "Checked" : (((!empty($Ch->TipoOS)) && ($Ch->TipoOS != 0)) ? "checked" : "");?> value="1" /> On-line</div>');
								$('#HIni').mask('99:99');
								$('#HFim').mask('99:99');
						}
						else if($('#Cobranca').val() == '2'){
								$('#TipoCob').html('<div class="inputsMeio">Tempo Total:<br /><input type="text" id="HTotal" name="HTotal" value="<?php echo (!empty($_POST['HTotal'])) ? $_POST['HTotal'] : $Ch->TempoOS;?>" /></div><div class="sepCont"></div><div class="inputsMeio"><br /><input type="checkbox" name="TipoOS" id="TipoOS" <?php echo ((!empty($_POST['TipoOS'])) && ($_POST['TipoOS'] == 1)) ? "Checked" : (((!empty($Ch->TipoOS)) && ($Ch->TipoOS != 0)) ? "checked" : "");?> value="1" /> On-line</div>');
								$('#HTotal').mask('99:99');
						}
						else if($('#Cobranca').val() == '3'){
								$('#TipoCob').html('<div class="inputsMeio" style="width:300px;">Valor:<br /><input type="text" id="ValorCob" name="ValorCob" value="<?php echo (!empty($_POST['ValorCob'])) ? number_format($_POST['ValorCob'],2,',','') : number_format($Ch->ValorCob,2,',','');?>" /><?php if($Mat->NumRows > 0) echo " + R$ ".number_format(($RMat->Soma[4] - 1),2,',','')." (Materiais/Serviços)";?></div>');
								$('#ValorCob').priceFormat({
									prefix: '',
									centsSeparator: ',',
									thousandsSeparator: ''
								});
						}
						else $('#TipoCob').html('');
				});
        });
		
		$('td').css('padding','0px 10px');
		$('td').css('border-right','1px dotted #000');
		$('.sepCol2').css('padding-left','0px');
</script>

<style>
	.action2{
			float:left;
			margin-top:0px;
			margin-left:2px;
	}
</style>

<?php		
		}	
?>