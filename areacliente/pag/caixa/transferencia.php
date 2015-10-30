<?php
		require_once('lib/tabs/tabcaixa.php');
        require_once('lib/tabs/tabbanco.php');
		
		if(!empty($_POST['Envia'])){
				if((!empty($_POST['Valor'])) && ($_POST['Valor'] > 0) && ($_POST['Valor'] != '0,00') && (!empty($_POST['Data']))){
						if($_POST['Origem'] != ($_POST['Destino'])){
								$Tbs = new tabCaixa;
								$Tfs = new DBConex;
								$Tfs->Tabs = $Tbs->Tabs;
								
								if($_POST['Origem'] == 'caixa'){
									
									$Tfs->Query = "INSERT INTO banco (Cliente, Valor, Data, Finalidade, Tipo) VALUES ('Usuário: ".$S->Nome."', '".$_POST['Valor']."','".implode("-",array_reverse(explode("/",$_POST['Data'])))."','Transferência do Caixa -> Banco','1')";
									$Tfs->MontaSQLRelat();
									$Tfs->Query = "INSERT INTO caixa (Cliente, Valor, Data, Finalidade, Tipo) VALUES ('Usuário: ".$S->Nome."', '".$_POST['Valor']."','".implode("-",array_reverse(explode("/",$_POST['Data'])))."','Transferência do Caixa -> Banco','2');";
									$Tfs->MontaSQLRelat();
								}
								
								if($_POST['Origem'] == 'banco'){
									
									$Tfs->Query = "INSERT INTO caixa (Cliente, Valor, Data, Finalidade, Tipo) VALUES ('Usuário: ".$S->Nome."', '".$_POST['Valor']."','".implode("-",array_reverse(explode("/",$_POST['Data'])))."','Transferência do Banco -> Caixa','1')";
									$Tfs->MontaSQLRelat();
									$Tfs->Query = "INSERT INTO banco (Cliente, Valor, Data, Finalidade, Tipo) VALUES ('Usuário: ".$S->Nome."', '".$_POST['Valor']."','".implode("-",array_reverse(explode("/",$_POST['Data'])))."','Transferência do Banco -> Caixa','2');";
									$Tfs->MontaSQLRelat();
								}
								
								if(!empty($Tfs->InsertID)) {
									$W->AddAviso('Transferência concluída.','WS');
									$_POST = "";
								}
						}else $W->AddAviso('O destino não pode ser o mesmo que a origem.','WA');
				}else $W->AddAviso('Preencha todos os campos com *.','WA');
		}
?>

<h1>Transferência Automática</h1>

<form method="post">
		<div class="inputs">
        		Origem:<br />
                <select name="Origem" id="Origem">
                		<option value="caixa" <?php echo ((!empty($_POST['Origem'])) && ($_POST['Origem'] == 'caixa')) ? 'selected="selected"' : ''; ?>>Caixa</option>
                        <option value="banco" <?php echo ((!empty($_POST['Origem'])) && ($_POST['Origem'] == 'banco')) ? 'selected="selected"' : ''; ?>>Banco</option>
                </select>
        </div>
        
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Destino:<br />
                <select name="Destino" id="Destino">
                		<option value="banco" <?php echo ((!empty($_POST['Destino'])) && ($_POST['Destino'] == 'banco')) ? 'selected="selected"' : ''; ?>>Banco</option>
                        <option value="caixa" <?php echo ((!empty($_POST['Destino'])) && ($_POST['Destino'] == 'caixa')) ? 'selected="selected"' : ''; ?>>Caixa</option>
                </select>
        </div>
        
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Data: *<br />
                <?php
						$d->setData();
				?>
                <input type="text" name="Data" id="Data" value="<?php echo (!empty($_POST['Data'])) ? $_POST['Data'] : $d->data; ?>" />
        </div>
        
        <div class="sepCont"></div>
                
		<div class="inputs">
        		Valor: *<br />
                <input type="text" name="Valor" id="Valor" value="<?php echo (!empty($_POST['Valor'])) ? $_POST['Valor'] : ''; ?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Envia" value="Transferir" />
        
</form>

<script>
		<?php
		$JS->Money(array('#Valor'));
		$JS->DatePicker(array('#Data'));
		?>
</script>