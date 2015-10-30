<?php
		require_once('../lib/url.php');
		require_once('../lib/js.php');
		require_once('../lib/tabs/tabmaterial.php');
		
		$Mat = new tabMaterial;
		$Mat->SqlWhere = "ID = '".$_GET['IDMaterial']."'";
		$Mat->MontaSQL();
		$Mat->Load();
		
		$URL = new URL;
		$JS = new JS;
		
		if(!empty($_GET['IDMaterial'])){
				?>
                <h4>Alterar Material/Serviço</h4>
                
                <form method="post" action="<?php echo $URL->siteURL;?>pag/material/edit.php" target="ajax">
                		<div class="sepCont" style="height:20px;"></div>
                        
                        <div class="inputs">
                        		Material/Serviço:<br />
                                <input type="text" name="Material" id="Material" maxlength="200" value="<?php echo $Mat->Material;?>" />
                        </div>
                        
                        <div class="sepCont"></div>
                        
                        <div class="inputsMeio">
                        		Valor:<br />
                                <input type="text" name="Valor" id="Valor" value="<?php echo number_format($Mat->Valor,2,',','.');?>" />
                        </div>
                        
                        <div class="sepCont"></div>
                        <input name="Status" type="hidden" id="Status" value="<?php echo $Mat->Status;?>" />
                        <input name="ID" type="hidden" id="ID" value="<?php echo $Mat->ID;?>" />
                        <input type="submit" name="Envia" value="Salvar" />
                        <input type="button" onClick="$('.PopUp').fadeOut();" class="cancel" value="Cancelar" />
                </form>
                <?php
		}else{
				echo "<script>parent.AddAviso('Nenhum item definido para ser alterado.','WA');</script>";
		}
?>
<script>
		<?php echo $JS->Money(array('#Valor'));?>
</script>