<?php
		require_once('lib/tabs/tabmaterial.php');
		
		if((!empty($_POST['Envia'])) || (!empty($_POST['EnviaNovo']))){
				
				$Refrash = (!empty($_POST['Envia'])) ? "a" : "b";
				
				unset($_POST['Envia']);	
				$_POST['Status'] = 1;
				
				if(!empty($_POST['Material'])){
						$Mat = new tabMaterial;
						$Mat->GetValPost();
						$Mat->Valor = str_replace(',','.',$_POST['Valor']);
						$Mat->Insert();
						
						
						if($Mat->InsertID > 0){
								$W->AddAviso('Material/Serviço adcionado.','WS');
								if($Refrash == "a"){
									echo "<script>document.location='".$URL->siteURL."material/';</script>";
									exit;
								}
								$_POST = '';
						}else $W->AddAviso('Problemas ao adicionar Material/Serviço.','WE');
				}else $W->AddAviso('Preencha os campos com *.','WA');
		}
?>

<h1>Cadastar Material/Serviço</h1>

<form method="post">
		<div class="inputsLarge">
        		Material/Serviço: *<br />
                <input name="Material" type="text" id="Material" maxlength="200" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputsMeio">
        		Valor: <br />
                <input name="Valor" type="text" id="Valor" />
        </div>
        
        <div class="sepCont"></div>
        
        <input name="Envia" type="submit" value="Salvar" />
        <input type="submit" name="EnviaNovo" value="Salvar e Cadastrar Novo" />
</form>

<script>
		<?php echo $JS->Money(array('#Valor'));?>
</script>