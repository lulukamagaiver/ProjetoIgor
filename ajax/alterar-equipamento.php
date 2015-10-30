<?php
		require_once('../lib/url.php');
		require_once('../lib/js.php');
		require_once('../lib/tabs/tabequipamento.php');
		
		$Eq = new tabEquipamento;
		$Eq->SqlWhere = "ID = '".$_GET['IDEquipamento']."'";
		$Eq->MontaSQL();
		$Eq->Load();
		
		$URL = new URL;
		$JS = new JS;
		
		if(!empty($_GET['IDEquipamento'])){
				?>
                <h4>Alterar Material/Serviço</h4>
                
                <form method="post" action="<?php echo $URL->siteURL;?>pag/equipamentos/edit.php" target="ajax">
                		<div class="sepCont" style="height:20px;"></div>
                        
                        <div class="inputs">
                        		Equipamento:<br />
                                <input type="text" name="Equipamento" id="Equipamento" maxlength="200" value="<?php echo $Eq->Equipamento;?>" />
                        </div>
                        
                        <div class="sepCont"></div>
                        
                        <div class="sepCol3" style="padding-left:0px;">
                        <div class="txtArea">
                                Descrição:<br />
                                <textarea name="Descricao" id="Descricao"><?php echo $Eq->Descricao;?></textarea>
                        </div>
                        </div>
                        
                        <div class="sepCont"></div>
                        <input name="Status" type="hidden" id="Status" value="<?php echo $Eq->Status;?>" />
                        <input name="IdCl" type="hidden" id="IdCl" value="<?php echo $Eq->IdCl;?>" />
                        <input name="ID" type="hidden" id="ID" value="<?php echo $Eq->ID;?>" />
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