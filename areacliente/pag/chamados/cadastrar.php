<?php
		$S->PrAcess(11); //Cadastrar Chamados
		
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tablogincliente.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabcomentariochamado.php');
		require_once('lib/tabs/tabequipamento.php');
		require_once('lib/tabs/tabconfiguracoes.php');
		
		$Cf = new tabConfiguracoes('1');
		$Checks = explode(',',$Cf->Checks);
		
		if(!empty($_POST['Envia'])){
				if((!empty($_POST['IdCl'])) && ($_POST['IdCl'] != 0) ){
				
				$verEquip = true;
				if(empty($_POST['IDEquipamento'])){
						if((!empty($_POST['Equipamento'])) && (!empty($_POST['DescEquipamento']))){
								$CadEq = new tabEquipamento;
								$CadEq->Equipamento = $_POST['Equipamento'];
								$CadEq->Descricao = $_POST['DescEquipamento'];
								$CadEq->IdCl = $_POST['IdCl'];
								$CadEq->Status = 1;
								$CadEq->Insert();
								
								if($CadEq->InsertID > 0){
										$verEquip = true;
										$_POST['IDEquipamento'] = $CadEq->InsertID;
								}else $verEquip = false;
						}else $verEquip = false;
				}
				
						if($verEquip){
								$_POST['Data'] = date('Y-m-d H:m:i');
								$_POST['IDTecnico'] = 0;
								$_POST['Status'] = 1;
								
								$Ch = new tabChamado;
								$Ch->GetValPost();
								$Ch->Insert();
								
								if($Ch->InsertID > 0){
										$W->AddAviso('Chamado cadastrado.','WS');
										$_POST = '';
										$Com = new tabComentarioChamado;
										$Com->AddComentario("Chamado aberto por ".$S->Apelido.".",$Ch->InsertID,0,false);
										
										$MSG = $S->Apelido." abriu o chamado #".$Ch->COD($Ch->InsertID);
										if(in_array('12',$Checks)){
												$ClE = new tabClientes($Ch->IdCl);
												$URL->EmailChamado($ClE->Email,$MSG,"Abertura de Chamado #".$URL->COD($Ch->InsertID),$Ch->InsertID);
												
												//Busca Usuarios clientes
												$LC = new tabLoginCliente;
												$LC->SqlWhere = "Clientes LIKE '%,".$Ch->IdCl."%'";
												$LC->MontaSQL();
												$LC->Load();
												
												for($a=0;$a<$LC->NumRows;$a++){
														if($LC->RecEmail == 1){
																$LCEmail = explode(';',$LC->Email);
																foreach($LCEmail as $key => $val){
																		//Envia pra usuarios CLientes
																		if(!empty($val)) $URL->EmailChamado($val,$MSG,"Abertura de Chamado #".$URL->COD($Ch->InsertID),$Ch->InsertID);
																}
														}
												$LC->Next();
												}		
										}
										
										if(in_array('13',$Checks)){
												$Tec = new tabAdmm;
												$Tec->SqlWhere = "Clientes LIKE '%,".$Ch->IdCl."%'";
												$Tec->MontaSQL();
												$Tec->Load();
												
												for($a=0;$a<$Tec->NumRows;$a++){
														$TecEmail = explode(';',$Tec->Email);
														foreach($TecEmail as $key => $val){
																//Envia pra usuarios CLientes
																if(!empty($val)) $URL->EmailChamado($val,$MSG,"Abertura de Chamado #".$URL->COD($Ch->InsertID),$Ch->InsertID);	
														}
												$Tec->Next();
												}
										}
										
										
										echo "<script>document.location = '".$URL->siteURL."';</script>";
										exit;
								}else $W->AddAviso('Problemas ao cadastrar chamado.','WE');
						}else $W->AddAviso('Houve algum problema ao verificar o Equipamento/Produto. Tente novamente.','WA');
				} else $W->AddAviso('Preencha todos os campos com *.','WA');
		}
		
		$Cl = new tabClientes;
		$Cl->SqlWhere = $S->ClUsu2();
		$Cl->SqlOrder = 'Nome ASC';
		$Cl->MontaSQL();
		$Cl->Load();

		
		//
		if(!empty($URL->GET)){
				$url = explode('/',$URL->GET);
		}

		
		if((!empty($url[0])) && (is_numeric($url[0]))){ 
					$Eq = new tabEquipamento;
					$Eq->SqlWhere = "IdCl = '".$url[0]."'";
					$Eq->MontaSQL();
					$Eq->Load();
					
					$Eq2 = new tabEquipamento;
					$Eq2->SqlWhere = "IdCl = '".$url[0]."'";
					$Eq2->MontaSQL();
					$Eq2->Load();
		}
		
		
?>

<h1>Cadastrar Chamado</h1>
<form method="post">
		<div class="inputs">
        		Cliente: *<br />
                <?php if((!empty($url[0])) && (is_numeric($url[0]))){ ?>
                <input name="IdCl" type="hidden" id="IdCl" value="<?php echo $url[0];?>" />
                <select name="IdCl2" id="IdCl2" disabled="disabled">
                <?php } else{?>
                <select name="IdCl" id="IdCl">
                <?php }?>
                        <option value="0">Selecionar</option>
						<?php
						for($a = 0; $a < $Cl->NumRows; $a++){
								?>
                                <option value="<?php echo $Cl->ID;?>" <?php echo ((!empty($_POST['IdCl'])) && ($_POST['IdCl'] == $Cl->ID)) ? 'selected="selected"' : ""?>><?php echo $Cl->Nome;?></option>
                                <?php
						$Cl->Next();
						}
						?>
                </select>
        </div>
        
        <div class="inputs" id="ResultContrato">
        		<br />
                <?php if((!empty($url[0])) && (is_numeric($url[0]))){ 
						if($Cl->Contrato == 1) echo "(COM CONTRATO)";
				}?>
        </div>
        
        <div class="sepCont"></div>
		<!---------------------------------------------------------->
		<!---------------------------------------------------------->
		<!-- Fim Permissão de cadastro de equipamento por cliente -->
		<!---------------------------------------------------------->
		<!---------------------------------------------------------->
		
        <?php if(in_array('100',$Checks)) { ?>
        <div class="inputs" id="ResultSelect">
                Equipamento: *<br />
                <select name="IDEquipamento" id="IDEquipamento" onchange="TrocaEquip();">
                        
						<?php
                        for($a=0;$a<$Eq->NumRows;$a++){
                                echo '<option value="'.$Eq->ID.'">'.$Eq->Equipamento.'</option>';
                                $Eq->Next();
                        }
                        ?>
						<option value="">Outro2</option>
                </select>
        </div>
        <?php if((empty($_POST['IDEquipamento'])) || ($_POST['IDEquipamento'] == 0)) { ?>
		<?php //if(($Eq->Equipamento) || ($Eq->Equipamento == 0)) {?>
        <div class="inputs NEq">
        		Novo Equipamento: *<br />
                <input type="text" name="Equipamento" id="Equipamento" maxlength="200" <?php echo (!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "";?> />
        </div>
        
        <div class="inputsLarge NEq">
        		Descrição Novo Equipamento: *<br />
                <input type="text" name="DescEquipamento" id="DescEquipamento" maxlength="200" <?php echo (!empty($_POST['DescEquipamento'])) ? $_POST['DescEquipamento'] : "";?> />
        </div>
		<!---------------------------------------------------------->
        <?php  } }else{ ?> 
		<!---------------------------------------------------------->
		        <div class="inputs" id="ResultSelect">
                Equipamento: *<br />
                <select name="IDEquipamento" id="IDEquipamento" onchange="TrocaEquip();">
                        
						<?php
                        for($a=0;$a<$Eq->NumRows;$a++){
                                echo '<option value="'.$Eq->ID.'">'.$Eq->Equipamento.'</option>';
                                $Eq->Next();
                        } ?>
						<option value="">Outro</option>
						
						
                </select>
        </div>
        <?php if((empty($_POST['IDEquipamento'])) || ($_POST['IDEquipamento'] == 0)) { ?>
		
		
        <div class="inputs NEq">
        		Informe no campo <b>DESCRIÇÃO</b> o <b>NOME e DESCRIÇÃO</b> do equipamento.<br />
                <input type="hidden" name="Equipamento" id="Equipamento" maxlength="200" value="Outro" <?php echo (!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "";?> />
        </div>
        
        <div class="inputsLarge NEq">
        		<br />
                <input type="hidden"  name="DescEquipamento" id="DescEquipamento" maxlength="200" value="Informe no campo <b>DESCRIÇÃO</b> o <b>NOME e DESCRIÇÃO</b> do equipamento" <?php echo (!empty($_POST['DescEquipamento'])) ? $_POST['DescEquipamento'] : "";?> />
        </div>
		
		<?php }else{ ?>
		<div class="inputs NEq">
        		Informe no campo <b>DESCRIÇÃO</b> o <b>NOME e DESCRIÇÃO</b> do equipamento.<?=$Eq->Equipamento ;?><br />
                <input type="hidden" name="Equipamento" id="Equipamento" maxlength="200" <?php echo (!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "";?> />
        </div>
        
        <div class="inputsLarge NEq">
        		<br />
                <input type="text"  name="DescEquipamento" id="DescEquipamento" maxlength="200" <?php echo (!empty($_POST['DescEquipamento'])) ? $_POST['DescEquipamento'] : "";?> />
        </div>
		
		<?php }  } ?>
        <!---------------------------------------------------------->
		<!---------------------------------------------------------->
		<!-- Fim Permissão de cadastro de equipamento por cliente -->
		<!---------------------------------------------------------->
		<!---------------------------------------------------------->
		
        <div class="sepCont"></div>
        
        <div class="inputsLarge" style="height:auto; padding:10px;" id="ResultDescEquip">
        
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputs">
        		Responsável:<?=$equipa ;?><br />
                <input name="Contato1" type="text" id="Contato1" value="<?php echo (!empty($_POST['Contato1'])) ? $_POST['Contato1'] : "" ; ?>" />
        </div>
                
        <div class="sepCont"></div>
        
        <div class="inputs">
        		Outro Contato:<br />
                <input name="Contato2" type="text" id="Contato2" value="<?php echo (!empty($_POST['Contato2'])) ? $_POST['Contato2'] : "" ; ?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="sepCol2">
        		<div class="txtArea">
                		Descrição:<br />
                        <textarea name="Descricao" cols="" rows="" id="Descricao"><?php for($a=0;$a<$Eq->NumRows;$a++){
			if($Eq->Equipamento == "Outro"){
			echo "Outro";
		} else { 
		echo "deu erro";
		}
		}?><?php echo (!empty($_POST['Descricao'])) ? $_POST['Descricao'] : "" ; ?></textarea>
                </div>
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Envia" value="Salvar" style="display:none;" />
        <div class="btnAct" onclick="return $('input[name=Envia]').click().remove();"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" /> Salvar</div>
        
        
</form>

<div id="ResultAjax" style="display:none;">
<?php					
					for($a=0;$a<$Eq2->NumRows;$a++){
							if($a == 0) echo '<input type="hidden" id="DescEquip0" value="" />';
							echo '<input type="hidden" id="DescEquip'.$Eq2->ID.'" value="'.$Eq2->Descricao.'" />';
							$Eq2->Next();
					}
?>
</div>

<script>
		<?php if((!empty($url[0])) && (is_numeric($url[0]))){ ?>
		$('#IdCl2').val('<?php echo $url[0];?>');
		<?php }?>
		
		$(document).ready(function(e) {
            	$('#IdCl').change(function(){
					$('#ResultDescEquip').html('');
					$('#IDEquipamento option:selected').text('Carregando...');
					$('#IDEquipamento').prop('disabled', 'disabled');
						$.ajax({
							url: '<?php echo $URL->siteURL; ?>ajax/chamado-def-cliente.php?IdCl='+$('#IdCl').val(),
							success: function(data){
									$('#ResultAjax').html(data);
									PosAjax();
							}
						});
						$('.NEq').show();
				});
				
            	$('#IDEquipamentossss').change(function(){
					alert($('#DescEquip5').val());
						if($('#DescEquip'+$('#IDEquipamento').val()).length > 0){
								$('#ResultDescEquip').html($('#DescEquip'+$('#IDEquipamento').val()).val());
						}else{
								$('#ResultDescEquip').html('');
						}
				});
        });
		
		function TrocaEquip(){
				if($('#DescEquip'+$('#IDEquipamento').val()).length > 0){
						$('#ResultDescEquip').html($('#DescEquip'+$('#IDEquipamento').val()).val());
				}else{
						$('#ResultDescEquip').html('');	
				}
				if($('#IDEquipamento').val() > 0) $('.NEq').hide();
				else $('.NEq').show();
		}
		
		function PosAjax(){
			if($('#ResultAjax').html() != ''){
					$('#ResultSelect').html($('#SelectEquip').html());
					if($('#ContratoCliente').val() == 1) $('#ResultContrato').html('<br />(COM CONTRATO)');
					else $('#ResultContrato').html('');
			}
		}
</script>