<?php
		$S->PrAcess(37); //Cadastrar Equipamento
		
		require_once('lib/tabs/tabequipamento.php');
		require_once('lib/tabs/tabclientes.php');
		
		$Cl = new tabClientes;
		$Cl->SqlOrder = 'Nome ASC';
		$Cl->MontaSQL();
		$Cl->Load();
		
		if((!empty($_POST['Envia'])) || (!empty($_POST['EnviaNovo']))){
				
				$Refrash = (!empty($_POST['Envia'])) ? "a" : "b";
				
				unset($_POST['Envia']);	
				$_POST['Status'] = 1;
				
				if((!empty($_POST['Equipamento'])) && (!empty($_POST['IdCl'])) && ($_POST['IdCl'] > 0)){
						$Eq = new tabEquipamento;
						$Eq->GetValPost();
						$Eq->Insert();
						if($Eq->InsertID > 0){
								$W->AddAviso('Equipamento adcionado.','WS');
								if($Refrash == "a"){
									echo "<script>document.location='".$URL->siteURL."equipamentos/';</script>";
									exit;
								}
								$_POST = '';
						}else $W->AddAviso('Problemas ao adicionar equipamento.','WE');
				}else $W->AddAviso('Preencha os campos com *.','WA');
		}
		
		
		//
		if(!empty($URL->GET)){
				$url = explode('/',$URL->GET);
		}
?>

<h1>Cadastar Equipamento</h1>

<form method="post">
		<div class="inputs">
        		Cliente: *<br />
                <?php if((!empty($url[0])) && (is_numeric($url[0]))){ ?>
                <input name="IdCl" type="hidden" id="IdCl" value="<?php echo $url[0];?>" />
                <select name="IdCl2" id="IdCl2" disabled="disabled">
                <?php } else{?>
                <select name="IdCl" id="IdCl">
                <?php }?>
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
        
        <div class="sepCont"></div>

		<div class="inputs">
        		Equipamento: *<br />
                <input name="Equipamento" type="text" id="Equipamento" maxlength="200" value="<?php echo (!empty($_POST['Equipamento'])) ? $_POST['Equipamento'] : "";?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="sepCol3" style="padding-left:0px;">
				<div class="txtArea">
                Descrição:<br />
                <textarea name="Descricao" cols="" rows="" id="Descricao"><?php echo (!empty($_POST['Descricao'])) ? $_POST['Descricao'] : "";?></textarea>
                </div>
        </div>
        
        <div class="sepCont"></div>
        
        <input name="Envia" type="submit" value="Salvar" />
        <input type="submit" name="EnviaNovo" value="Salvar e Cadastrar Novo" />
</form>

<script>
		<?php echo $JS->Money(array('#Valor'));?>
		<?php if((!empty($url[0])) && (is_numeric($url[0]))){ ?>
		$('#IdCl2').val('<?php echo $url[0];?>');
		<?php }?>
</script>