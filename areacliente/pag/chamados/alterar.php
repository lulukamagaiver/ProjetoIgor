<?php
		$S->PrAcess(12); //Alterar Chamados
		
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabstatuschamados.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabcomentariochamado.php');
		require_once('lib/tabs/tabequipamento.php');
		
		if(!empty($_POST['Envia'])){
				if((!empty($_POST['IdCh'])) && ($_POST['IdCh'] != 0)){
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
							$IdCh = $_POST['IdCh'];
								$_POST['Data'] = date('Y-m-d H:m:i');
								$_POST['IDTecnico'] = 0;
								$_POST['Status'] = 1;
								
								$Ch = new tabChamado($_POST['IdCh']);
								
								$Ch->IDEquipamento = $_POST['IDEquipamento'];
								$Ch->Contato1 = $_POST['Contato1'];
								$Ch->Contato2 = $_POST['Contato2'];
								$Ch->Descricao = $_POST['Descricao'];
								$Ch->Update($_POST['IdCh']);
								
								if($Ch->Result){
										$W->AddAviso('Chamado alterado.','WS');
										$_POST = '';
										$Com = new tabComentarioChamado;
										$Com->AddComentario($S->Apelido.' alterou detalhes deste chamado.',$IdCh);
										
										echo "<script>document.location = '".$URL->siteURL."chamados/visualizar/".$IdCh."/'</script>";
										exit;
								}else $W->AddAviso('Problemas ao cadastrar chamado.','WE');
						} else $W->AddAviso('Selecione um cliente.','WA');
				}else $W->AddAviso('Houve algum problema ao verificar o Equipamento/Produto. Tente novamente.','WA');
		}
		
		$Cl = new tabClientes;
		$Cl->SqlOrder = 'Nome ASC';
		$Cl->MontaSQL();
		$Cl->Load();

		
		//
		if(!empty($URL->GET)){
				$url = explode('/',$URL->GET);
		}

		
		if((!empty($url[0])) && (is_numeric($url[0]))){ 
					$Ch = new tabChamado($url[0]);
		
					$Cl = new tabClientes($Ch->IdCl);
					
					$Us = new tabAdmm($Ch->IDTecnico);
					
					$St = new tabStatusChamados($Ch->Status);
					
					$Eq = new tabEquipamento;
					$Eq->SqlWhere = "IdCl = '".$Cl->ID."'";
					$Eq->MontaSQL();
					$Eq->Load();
					
					$Eq2 = new tabEquipamento;
					$Eq2->SqlWhere = "IdCl = '".$Cl->ID."'";
					$Eq2->MontaSQL();
					$Eq2->Load();
		}
?>

<h1>Alterar Chamado</h1>
<form method="post">
		<div class="inputs">
        		Cliente: *<br />
                <?php if(!empty($Cl->ID)){ ?>
                <input name="IdCl" type="hidden" id="IdCl" value="<?php echo $Cl->ID;?>" />
                <input name="IdCh" type="hidden" id="IdCh" value="<?php echo $Ch->ID;?>" />
                <select name="IdCl2" id="IdCl2" style="background-color:#DEDEDE;" disabled="disabled">
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
                <?php if((!empty($Cl->ID)) && (is_numeric($Cl->ID))){ 
						if($Cl->Contrato == 1) echo "(COM CONTRATO)";
				}?>
        </div>
                
        
        <div class="inputs">
        		Data:<br />
                <input type="text" disabled="disabled" value="<?php echo (!empty($_POST['Contato1'])) ? $_POST['Contato1'] : date("d/m/Y H:i:s",strtotime($Ch->Data)) ; ?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputs" id="ResultSelect">
                Equipamento:<br />
                <select name="IDEquipamento" id="IDEquipamento" onchange="TrocaEquip();">
                        <option value="0">Outro</option>
						<?php
                        for($a=0;$a<$Eq->NumRows;$a++){
                                echo '<option value="'.$Eq->ID.'">'.$Eq->Equipamento.'</option>';
                                $Eq->Next();
                        }
                        ?>
                </select>
        </div>

        <div class="inputs NEq">
        		Novo Equipamento: *<br />
                <input type="text" name="Equipamento" id="Equipamento" maxlength="200" <?php echo (!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "";?> />
        </div>
        
        <div class="inputsLarge NEq">
        		Descrição Novo Equipamento: *<br />
                <input type="text" name="DescEquipamento" id="DescEquipamento" maxlength="200" <?php echo (!empty($_POST['DescEquipamento'])) ? $_POST['DescEquipamento'] : "";?> />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputsLarge" style="height:auto; padding:10px;" id="ResultDescEquip">
        
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputs">
        		Responsável:<br />
                <input name="Contato1" type="text" id="Contato1" value="<?php echo (!empty($_POST['Contato1'])) ? $_POST['Contato1'] : $Ch->Contato1 ; ?>" />
        </div>
        
        <div class="inputs">
        		Outro Contato:<br />
                <input name="Contato2" type="text" id="Contato2" value="<?php echo (!empty($_POST['Contato2'])) ? $_POST['Contato2'] : $Ch->Contato2 ; ?>" />
        </div>
                        
        <div class="sepCont"></div>
        
        <div class="inputs">
        		Técnico:<br />
                <input type="text" style="color:#F00;" disabled="disabled" value="<?php echo ($Ch->IDTecnico != 0) ? $Us->Apelido : "Todos"; ?>" />
        </div>
        
        <div class="inputs">
        		Status:<br />
                <input type="text" style="color:#F00;" disabled="disabled" value="<?php echo $St->Descricao; ?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="sepCol2">
        		<div class="txtArea">
                		Descrição:<br />
                        <textarea name="Descricao" cols="" rows="" id="Descricao"><?php echo (!empty($_POST['Descricao'])) ? $_POST['Descricao'] : $Ch->Descricao ; ?></textarea>
                </div>
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Envia" value="Salvar" style="display:none;" />
        <div class="btnAct" onclick="return $('input[name=Envia]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" /> Salvar</div>
        
        
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
        <?php if(((empty($_POST['IDEquipamento'])) || ($_POST['IDEquipamento'] == 0)) && ($Ch->IDEquipamento != '')) :?>
		<script>$('.NEq').hide();</script>
        <?php endif;?>
<script>
		<?php if((!empty($Cl->ID)) && (is_numeric($Cl->ID))){ ?>
		$('#IdCl2').val('<?php echo $Cl->ID;?>');
		$('#IDEquipamento').val('<?php echo $Ch->IDEquipamento;?>');
		$('#ResultDescEquip').html($('#DescEquip'+$('#IDEquipamento').val()).val());
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
				});
				
            	$('#IDEquipamento').change(function(){
						if($('#DescEquip'+$('#IDEquipamento').val()).length > 0){
								$('#ResultDescEquip').html($('#DescEquip'+$('#IDEquipamento').val()).val());
						}else $('#ResultDescEquip').html('');
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