<?php
		$S->PrAcess(32);// Consultar Cliente
		
		include_once('lib/relatorios.php');
		include_once('lib/search.php');
		include_once('lib/tabs/tabclientes.php');
		include_once('lib/tabs/tabequipamento.php');
		
		//BUSCA
		$B = new Search;
		$B->Like('ID,Nome,CNPJ,Email',(!empty($_POST['Busca'])) ? $_POST['Busca'] : "");

		$VerMais = 0;
		
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				//DELETAR
				if(((!empty($url[1])) && ($url[1] == 'deletar')) && (is_numeric($url[2]))){
					if($S->Pr(34)){
						$Del = new tabClientes;
						$Del->Delete($url[2]);
						if($Del->Result) $W->AddAviso('Cliente removido.','WS');
						else $W->AddAviso('Problemas ao deletar cliente','WE');
					}else $W->AddAviso('Você não possui permissão para esta ação.','WE');
				}
				
				//DELETAR EQUIPAMENTO
				if(((!empty($url[1])) && ($url[1] == 'deletarequipamento')) && (is_numeric($url[2]))){
					if($S->Pr(39)){
						$Del = new tabEquipamento;
						$Del->SqlWhere = "ID = '".$url[2]."'";
						$Del->MontaSQL();
						$Del->Load();
						
						$IdCl = $Del->IdCl;
						
						$Del->Delete($url[2]);
						if($Del->Result){
								$W->AddAviso('Equipamento/Produto removido.','WS');
								echo "<script>document.location = '".$URL->siteURL."clientes/visualizar/".$IdCl."/'</script>";
								exit;
						}
						else{
								$W->AddAviso('Problemas ao deletar Equipamento/Produto','WE');
								echo "<script>document.location = '".$URL->siteURL."clientes/visualizar/".$IdCl."/'</script>";
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
		$tt = new tabClientes;
		$tt->SqlWhere = $B->Where;
		$tt->SqlOrder = "Nome ASC";
		$tt->MontaSQL();
		$tt->Load();
?>

<h1>Consultar Clientes</h1>
		
		<form method="post" style="float:left; width:100%;">		
        <div class="sepCont"></div>
                		<div class="inputsLarge">
                        		Busca por Código, Nome, CPF, CNPJ ou E-mail: <br />
                                <input type="text" name="Busca" id="Busca" value="<?php echo (!empty($_POST['Busca'])) ? $_POST['Busca'] : "";?>" />
                        </div>
		
        <input name="" type="image" style="width:30px; height:30px; float:left; margin-left:0px;" src="imgs/icones/search.png" />
        <div class="sepCont" style="height:20px;"></div>        
        </form>        
        
        <!--<a href="<?php echo $URL->NURL;?>clientes/cadastrar/">
        <input name="" type="button" value="Novo" class="btnAZ" style="float:right; margin-bottom:20px; background-color:#09C;" />
        </a>-->
<?php
		$t = new Relat('',true);
		$t->WidthCols = array('60','325','120','100','260','70');
		$t->Cols = array('ID','Nome','CNPJ','Tel','Email','action');
		$t->Totais = array(0,0,0,0,0,0);
		$t->Formato = array('cod','','','','','');
		$t->Actions = '
		'.(($S->Pr(32)) ? '<a href="'.$URL->siteURL.'clientes/visualizar/{id}/"><img class="action" src="imgs/icones/edit.png" width="26" height="26" /></a>' : '<img onclick="AcNegado();" class="action" src="imgs/icones/edit.png" width="26" height="26" /></a>').'
		'.(($S->Pr(34)) ? '<a onclick="return confirm(\'Tem certeza que deseja excluir?\');" href="'.$URL->siteURL.'clientes/visualizar/deletar/{id}/"><img class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>' : '<img onclick="AcNegado();" class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>').'
		';
		$t->Query = $tt->Query;
		$t->setTitulos(array('COD:center','Nome:left','CPF/CNPJ:center','Telefone:Center','E-mail:left','Ações:center'));
		echo "<p class=\"left\">Número de registros encontrados: <strong>".$tt->NumRows."</strong></p>";
		$t->showTab(); 

elseif($VerMais == 1) :?>

<?php
		//Executa açoes submit
		if(!empty($_POST['Sub'])){
				if($S->Pr(33)){ //Alterar Cliente
					unset($_POST['Sub']);
					//$_POST = str_replace("'","\'",$_POST);
					
							if(($_POST['Nome'] != '')){
									$_POST['Contrato'] = (!empty($_POST['Contrato'])) ? "1" : "0";
									$_POST['Assinatura'] = (!empty($_POST['Assinatura'])) ? "1" : "0";
									$_POST['EnviaEmail'] = (!empty($_POST['EnviaEmail'])) ? "1" : "0";
		
									if(empty($_POST['Contrato'])){
											$_POST['VContrato'] = "";
											$_POST['QNTHoras'] = "";
									}
											$cl = new tabClientes;
											$_POST['VHora'] = str_replace(',','.',$_POST['VHora']);
											$_POST['VContrato'] = str_replace(',','.',$_POST['VContrato']);
											$cl->GetValPost();
											$cl->Update($url[1]);
											if($cl->Result) $W->AddAviso('Cliente alterado','WS');
											else{
												$W->AddAviso('Problemas ao alterar cliente.','WE');
												$_POST['VHora'] = str_replace('.',',',$_POST['VHora']);
												$_POST['VContrato'] = str_replace('.',',',$_POST['VContrato']);	
											}
							}
							else $W->AddAviso('Preencha os campos com *.','WA');
				}else $W->AddAviso('Você não possui pemissão para esta ação.','WE');
		}
		//Fim acoes submit
?>
		
<h1>Consultar Cliente #<?php echo $URL->COD($url[1]);?></h1>
        
		<?php
		
		$Cl = new tabClientes;
		$Cl->SqlWhere = "ID = '".$url[1]."'";
		$Cl->MontaSQL();
		$Cl->Load();
		?>

<form method="post" action="">

		<div class="inputsLarge">
        		Nome: *<br />
                <input type="text" name="Nome" id="Nome" maxlength="60" value="<?php echo (!empty($_POST['Nome'])) ? $_POST['Nome'] : (!empty($Cl->Nome)) ? $Cl->Nome : "";;?>" />
        </div>
 
		<div class="inputsLarge">
        		Endereço:<br />
                <input type="text" name="Endereco" id="Endereco" maxlength="100" value="<?php echo (!empty($_POST['Endereco'])) ? $_POST['Endereco'] : (!empty($Cl->Endereco)) ? $Cl->Endereco : "";?>" />
        </div>
                
		<div class="inputs">
        		Bairro:<br />
                <input type="text" name="Bairro" id="Bairro" maxlength="50" value="<?php echo (!empty($_POST['Bairro'])) ? $_POST['Bairro'] : (!empty($Cl->Bairro)) ? $Cl->Bairro : "";?>" />
        </div>
                
		<div class="inputs">
        		Cidade:<br />
                <input type="text" name="Cidade" id="Cidade" maxlength="50" value="<?php echo (!empty($_POST['Cidade'])) ? $_POST['Cidade'] : (!empty($Cl->Cidade)) ? $Cl->Cidade : "";?>" />
        </div>
                
		<div class="inputsMeio">
        		CEP:<br />
                <input type="text" name="CEP" id="CEP" maxlength="9" value="<?php echo (!empty($_POST['CEP'])) ? $_POST['CEP'] : (!empty($Cl->CEP)) ? $Cl->CEP : "";?>" />
        </div>
                
		<div class="inputsMeio">
        		UF:<br />
                <select name="UF" id="UF">
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AM">AM</option>
                        <option value="AP">AP</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF" selected="selected">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MG">MG</option>
                        <option value="MS">MS</option>
                        <option value="MT">MT</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="PR">PR</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="RS">RS</option>
                        <option value="SC">SC</option>
                        <option value="SE">SE</option>
                        <option value="SP">SP</option>
                        <option value="TO">TO</option>
                </select>
        </div>
                
		<div class="inputsMeio">
        		Telefone:<br />
                <input type="text" name="Tel" id="Tel" maxlength="15" value="<?php echo (!empty($_POST['Tel'])) ? $_POST['Tel'] : (!empty($Cl->Tel)) ? $Cl->Tel : "";?>" />
        </div>
                
		<div class="inputsMeio">
        		Telefone:<br />
                <input type="text" name="Cel" id="Cel" maxlength="15" value="<?php echo (!empty($_POST['Cel'])) ? $_POST['Cel'] : (!empty($Cl->Cel)) ? $Cl->Cel : "";?>" />
        </div>
                
		<div class="inputs">
        		E-mail:<br />
                <input type="text" name="Email" id="Email" maxlength="80" value="<?php echo (!empty($_POST['Email'])) ? $_POST['Email'] : (!empty($Cl->Email)) ? $Cl->Email : "";?>" />
        </div>
        
        <div class="inputs">
				Situação:<br />
                <select name="Situacao" id="Situacao">
                		<option value="1">Ativo</option>
                        <option value="2">Bloquado</option>
                        <option value="3">Em Débito</option>
                </select>
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputsLarge">
                <input type="checkbox" name="EnviaEmail" id="EnviaEmail" <?php echo (!empty($_POST['EnviaEmail'])) ? "checked" : ($Cl->EnviaEmail == 1) ? "checked" : "";?> value="1" /> Enviar E-mails (Chamados, Comentários, OS)<br />
                <input type="checkbox" name="Assinatura" id="Assinatura" <?php echo (!empty($_POST['Assinatura'])) ? "checked" : ($Cl->Assinatura == 1) ? "checked" : "";?> value="1" /> OSs devem ser assinadas (LEMBRETE)
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputsMeio">
        		Tipo: <br />
                <select name="Tipo" id="Tipo">
                		<option value="I">Selecionar</option>
                        <option value="J">Juríca</option>
                        <option value="F">Fisica</option>
                </select>
        </div>
        
        <div class="sepCol2" id="TipoCl" style="width:870px; padding:0; margin:0;">
        		
        </div>
        
        <div class="sepCont" style="height:20px;"></div>
                                
		<div class="inputs">
        		<br />
                <input type="checkbox" name="Contrato" id="Contrato" <?php echo (!empty($_POST['Contrato'])) ? "checked" : ($Cl->Contrato == 1) ? "checked" : "";?> value="1" /> Cliente Com Contrato
        </div>
        
        <div class="sepCont"></div>
                                
		<div class="inputsMeio">
        		Valor Contrato:<br />
                <input type="text" name="VContrato" id="VContrato" maxlength="50" value="<?php echo (!empty($_POST['VContrato'])) ? $_POST['VContrato'] : (!empty($Cl->VContrato)) ? $Cl->VContrato : "";?>" />
        </div>
                                
		<div class="inputsMeio">
        		QNT. Horas:<br />
                <input type="text" name="QNTHoras" id="QNTHoras" maxlength="50" value="<?php echo (!empty($_POST['QNTHoras'])) ? $_POST['QNTHoras'] : (!empty($Cl->QNTHoras)) ? $Cl->QNTHoras : "";?>" />
        </div>
                                
		<div class="inputsMeio">
        		Valor Hora:<br />
                <input type="text" name="VHora" id="VHora" maxlength="50" value="<?php echo (!empty($_POST['VHora'])) ? $_POST['VHora'] : (!empty($Cl->VHora)) ? $Cl->VHora : "";?>" />
        </div>
                                
		<div class="inputsLarge" style="width:600px;">
        		OS On-line:<br />
                <input style="width:84px;" type="text" name="Desconto" id="Desconto" maxlength="50" value="<?php echo (!empty($_POST['Desconto'])) ? $_POST['Desconto'] : (!empty($Cl->Desconto)) ? $Cl->Desconto : "";?>" />% DE DESCONTO (deixe em branco para valor padrão)
        </div>
        
        <div class="sepCont"></div>
        
        
        
        <div class="sepCont"></div>
        <div class="sepCol2">
        <div class="txtArea">
        		Observações:<br />
        		<textarea name="Obs" id="Obs"><?php echo (!empty($_POST['Obs'])) ? $_POST['Obs'] : (!empty($Cl->Obs)) ? $Cl->Obs : "";?></textarea>
        </div>
        </div>
        <div class="sepCont"></div>
        
        <input type="submit" name="Sub" value="Salvar" style="display:none;" />
        <div class="btnAct" onclick="return $('input[name=Sub]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" />Salvar</div>
        <?php if($S->Pr(34)){?><a onclick="return confirm('Tem certeza que deseja excluir?');" href="<?php echo $URL->siteURL;?>clientes/visualizar/deletar/<?php echo (!empty($Cl->ID)) ? $Cl->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" />Excluir</div></a><?php }?>
        <div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" />Imp. Equip./Prod.</div>
        <?php if($S->Pr(37)){?><a href="<?php echo $URL->siteURL;?>equipamentos/cadastrar/<?php echo (!empty($Cl->ID)) ? $Cl->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/plus.png" />Cad. Equip./Prod.</div></a><?php }?>
        <?php if($S->Pr(11)){?><a href="<?php echo $URL->siteURL;?>chamados/cadastrar/<?php echo (!empty($Cl->ID)) ? $Cl->ID : "";?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/blank_page.png" />Cad. Chamado</div></a><?php }?>

</form>

<script>
		<?php if((!empty($_POST['Tipo'])) || (!empty($Cl->Tipo))) :?>
		$('#Tipo').val('<?php echo (!empty($_POST['Tipo'])) ? $_POST['Tipo'] : (!empty($Cl->Tipo)) ? $Cl->Tipo : "";?>');
				<?php if(((!empty($_POST['Tipo'])) && ($_POST['Tipo'] == 'J')) || ($Cl->Tipo == 'J')) :?>$('#TipoCl').html('<div class="inputsLarge">Razão Social:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php echo (!empty($_POST['Razao'])) ? $_POST['Razao'] : (!empty($Cl->Razao)) ? $Cl->Razao : "";?>" /></div><div class="inputs">CNPJ:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php echo (!empty($_POST['CNPJ'])) ? $_POST['CNPJ'] : (!empty($Cl->CNPJ)) ? $Cl->CNPJ : "";?>" /></div><div class="inputs" style="width:230px;">I. E.:<br /><input type="text" name="IE" id="IE" maxlength="30" value="<?php echo (!empty($_POST['IE'])) ? $_POST['IE'] : (!empty($Cl->IE)) ? $Cl->IE : "";?>" /></div>');<?php endif;?>
				<?php if(((!empty($_POST['Tipo'])) && ($_POST['Tipo'] == 'F')) || ($Cl->Tipo == 'F')) :?>$('#TipoCl').html('<div class="inputsLarge">Nome Completo:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php echo (!empty($_POST['Razao'])) ? $_POST['Razao'] : (!empty($Cl->Razao)) ? $Cl->Razao : "";?>" /></div><div class="inputs">CPF:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php echo(!empty($_POST['CNPJ'])) ? $_POST['CNPJ'] : (!empty($Cl->CNPJ)) ? $Cl->CNPJ : "";?>" /></div>');<?php endif;?>
		<?php endif;?>
		
		<?php if((!empty($_POST['UF'])) || (!empty($Cl->UF))) :?>
		$('#UF').val('<?php echo (!empty($_POST['UF'])) ? $_POST['UF'] : (!empty($Cl->UF)) ? $Cl->UF : "";?>');
		<?php endif;?>
		
		<?php if((!empty($_POST['Situacao'])) || (!empty($Cl->Situacao))) :?>
		$('#Situacao').val('<?php echo (!empty($_POST['Situacao'])) ? $_POST['Situacao'] : (!empty($Cl->Situacao)) ? $Cl->Situacao : "";?>');
		<?php endif;?>
		
		$(document).ready(function(e) {
				$('#Tipo').change(function(){
						if($('#Tipo').val() == 'J') $('#TipoCl').html('<div class="inputsLarge">Razão Social:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php if(!empty($_POST['Razao'])) echo $_POST['Razao'];?>" /></div><div class="inputs">CNPJ:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php if(!empty($_POST['CNPJ'])) echo $_POST['CNPJ'];?>" /></div><div class="inputs" style="width:230px;">I. E.:<br /><input type="text" name="IE" id="IE" maxlength="30" value="<?php if(!empty($_POST['IE'])) echo $_POST['IE'];?>" /></div>');
						else if($('#Tipo').val() == 'F') $('#TipoCl').html('<div class="inputsLarge">Nome Completo:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php if(!empty($_POST['Razao'])) echo $_POST['Razao'];?>" /></div><div class="inputs">CPF:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php if(!empty($_POST['CNPJ'])) echo $_POST['CNPJ'];?>" /></div>');
						else $('#TipoCl').html('');
				});
				
				if($('#Contrato').is(':checked')){
						$('#VContrato').attr('disabled',false);
						$('#QNTHoras').attr('disabled',false);
				}else if($('#Contrato').not(':checked')){
						$('#VContrato').attr('disabled',true);
						$('#QNTHoras').attr('disabled',true);
				}
				
				$('#Contrato').click(function(){
						if($(this).is(':checked')){
								$('#VContrato').attr('disabled',false);
								$('#QNTHoras').attr('disabled',false);
						}else if($(this).not(':checked')){
								$('#VContrato').attr('disabled',true);
								$('#QNTHoras').attr('disabled',true);
						}
				});
				
				$('#Save').click(function(e){
						$('').click();
						return false;
				});
        });
		
		$('.sepCol2').css('padding-left','0px');
		
		<?php echo $JS->Money(array('#VContrato','#VHora'));?>
		<?php echo $JS->Tel(array('#Tel','#Cel'));?>
</script>

<div class="sepCont" style="height:50px;"></div>
<?php
		include_once('lib/tabs/tabequipamento.php');
		$tt = new tabEquipamento;
		$tt->SqlWhere = "Status = '1' AND IdCl = '".$Cl->ID."'";
		$tt->SqlOrder = "Equipamento ASC";
		$tt->MontaSQL();
		$tt->Load();
		
		
		
		$t = new Relat();
		$t->WidthCols = array('90','297','500','70');
		$t->Cols = array('ID','Equipamento','Descricao','action');
		$t->Totais = array(0,0,0,0);
		$t->Formato = array('cod','','','');
		$t->Actions = '
		'.(($S->Pr(38)) ? '<img class="action" src="imgs/icones/edit.png" width="26" height="26" onclick="PopUp(400,300,\''.$URL->siteURL.'ajax/alterar-equipamento.php?IDEquipamento={id}\');" />' : '<img class="action" src="imgs/icones/edit.png" width="26" height="26" onclick="AcNegado();" />').'
		'.(($S->Pr(39)) ? '<a href="'.$URL->siteURL.'clientes/visualizar/deletarequipamento/{id}/"><img class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>' : '<img class="action" src="imgs/icones/delete.png" width="26" height="26" onclick="AcNegado();" />').'
		';
		$t->Query = $tt->Query;
		$t->setTitulos(array('COD:center','Equipamento/Produto:left','Descrição:left','Açoes:Center'));
		$t->showTab();
?>

<?php endif;?>