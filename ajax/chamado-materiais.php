<?php
		require_once('../lib/sessao.php');
		require_once('../lib/tabs/tabmaterial.php');
		require_once('../lib/tabs/tabmateriaischamado.php');
		require_once('../lib/tabs/tabcomentariochamado.php');
		require_once('../lib/url.php');
		require_once('../lib/warnings.php');
		
		$W = new Warnings;
		
		$S = new Sessao;
		
		$URL = new URL;
		
		if((!empty($_GET['id'])) || (!empty($_GET['id_mat']))){
			
			
			if(!empty($_POST['EnviaMaterial'])){
				if(!empty($_POST['IDMat'])){
					$AdMat = new tabMateriaisChamado;
					$AdMat->Descricao = $_POST['Material'];
					$AdMat->QNT = $_POST['QNT'];
					$AdMat->Valor = str_replace(",",".",str_replace(".","",$_POST['Valor']));
					$AdMat->VTotal = str_replace(",",".",str_replace(".","",$_POST['VTotal']));
				
					if(!empty($_GET['id_mat'])){
							$AdMat->ID = $_GET['id_mat'];
							$AdMat->IDChamado = $_POST['IDMat'];
							$AdMat->Update($_GET['id_mat']);
							if($AdMat->Result){
									$C = new tabComentarioChamado;
									$C->AddComentario($S->Apelido.' alterou o Material/Serviço: #'.$URL->COD($_GET['id_mat']).'<br />Descrição: '.$AdMat->Descricao.'<br />Valor: R$'.number_format($AdMat->Valor,2,',','').'<br />QNT: '.$AdMat->QNT.'<br />Total: '.number_format($AdMat->VTotal,2,',','').'',$AdMat->IDChamado);
									$W->AddAviso('Materal/Serviço alterado.','WS');
									echo "<script>parent.document.location.reload();</script>";
									exit;
							}else echo "<script>parent.AddAviso('Problemas ao alterar Material/Serviço.','WE');</script>";
					}else{
							$AdMat->IDChamado = $_GET['id'];
							$AdMat->Insert();
							if($AdMat->InsertID > 0){
									$C = new tabComentarioChamado;
									$C->AddComentario($S->Apelido.' inseriu o Material/Serviço: #'.$URL->COD($AdMat->InsertID).'<br />Descrição: '.$AdMat->Descricao.'<br />Valor: R$'.number_format($AdMat->Valor,2,',','').'<br />QNT: '.$AdMat->QNT.'<br />Total: '.number_format($AdMat->VTotal,2,',','').'',$AdMat->IDChamado);
									$W->AddAviso('Materal/Serviço inserido.','WS');
									echo "<script>parent.document.location.reload();</script>";
									exit;
							}else echo "<script>parent.AddAviso('Problemas ao alterar Material/Serviço.','WE');</script>";
					}
				} else echo "<script>parent.AddAviso('Material/Servio não cadastrado.','WA');</script>";
			}
			
			
			if(!empty($_GET['id_mat'])){
					$MatCh = new tabMateriaisChamado;
					$MatCh->SqlWhere = "ID = '".$_GET['id_mat']."'";
					$MatCh->MontaSQL();
					$MatCh->Load();
			}
?>
<h4><?php echo (empty($_GET['id_mat'])) ? "Adicionar" : "Alterar";?> Material/Serviço</h4>
<div id="TelaMat1">
		<form method="post" target="ajax" action="<?php echo $URL->siteURL;?>ajax/chamado-materiais.php?id=<?php echo (!empty($_GET['id'])) ? $_GET['id'] : "";?>&&id_mat=<?php echo (!empty($_GET['id_mat'])) ? $_GET['id_mat'] : "";?>">
        		<div class="inputsLarge">
                		Material:<br />
                        <input type="text" autocomplete="off" name="Material" id="Material" maxlength="" value="<?php echo (!empty($_POST['Material'])) ? $_POST['Material'] : ((!empty($MatCh->Descricao)) ? $MatCh->Descricao : "");?>" />
                        <input type="hidden" name="IDCh" id="IDCh" value="<?php echo (!empty($_POST['IDCh'])) ? $_POST['IDCh'] : ((!empty($_GET['id'])) ? $_GET['id'] : ((!empty($MatCh->IDChamado)) ? $MatCh->IDChamado : ""));?>" />
                        <input type="hidden" name="IDMat" id="IDMat" value="<?php echo (!empty($_GET['id'])) ? $_GET['id'] : "";?>" />
                        <input type="hidden" name="IDMatCh" id="IDMatCh" value="<?php echo (!empty($_POST['IDMatCh'])) ? $_POST['IDMatCh'] : ((!empty($_GET['id_mat'])) ? $_GET['id_mat'] : "");?>" />
                        
                        <div class="auto">
                        
                        </div>
                </div>
                
                <div class="sepCont"></div>
                
                <div class="inputsMeio" onKeyUp="AtualizaValor();">
                		Valor:<br />
                        <input type="text" name="Valor" id="Valor" maxlength="" value="<?php echo (!empty($_POST['Valor'])) ? $_POST['Valor'] : ((!empty($MatCh->Valor)) ? number_format($MatCh->Valor,2,',','') : "");?>" />
                </div>
                
                <div class="inputsMeio" onKeyUp="AtualizaValor();">
                		Quantidade:<br />
                        <input type="text" name="QNT" id="QNT" maxlength="" value="<?php echo (!empty($_POST['QNT'])) ? $_POST['QNT'] : ((!empty($MatCh->QNT)) ? $MatCh->QNT : "");?>" />
                </div>
                                
                <div class="inputsMeio">
                		Total:<br />
                        <input type="text" name="" id="Total" disabled maxlength="" value="<?php echo (!empty($_POST['VTotal'])) ? $_POST['VTotal'] :  ((!empty($MatCh->VTotal)) ? number_format($MatCh->VTotal,2,',','') : "");?>" />
                        <input type="hidden" name="VTotal" id="VTotal" maxlength="" value="<?php echo (!empty($_POST['VTotal'])) ? $_POST['VTotal'] : ((!empty($MatCh->VTotal)) ? number_format($MatCh->VTotal,2,',','') : "");?>" />
                </div>
                
                <div class="sepCont"></div>
                
                <input name="EnviaMaterial" type="submit" value="ok" style="display:none;">
                <div class="btnAct" onClick="return $('input[name=EnviaMaterial]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/tools.png" /><?php echo (empty($_GET['id_mat'])) ? "Adicionar" : "Alterar";?></div>
                <div class="btnAct" onClick="$('.PopUp').fadeOut();"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" />Cancelar</div>
        
        </form>		
</div>

<div id="TelaMat1">

</div>

<script>
$(document).ready(function() {
	$( "#Material" ).keyup(function() {
			$('#Valor').val('');
			$('#IDMat').val('');
			$('#VTotal').val('');
			$('#Total').val('');
			$('#QNT').val('');
			var serch = $('#Material').val();
				$.post( "<?php echo $URL->siteURL;?>ajax/auto-complete-material.php", { busca: serch })
				.done(function( data ) {
				$('.auto').html(data);
				});
	});
	$( "#Material" ).blur(function() {
			$('.auto').fadeOut();
	});
});

function AtualizaValor(){
		var Valor = parseFloat(($('#Valor').val().replace('.','')).replace(',','.'));
		var Total = parseFloat($('#QNT').val() * Valor);
		
		$('#VTotal').val(numberFormat(Total.toFixed(2)));
		$('#Total').val(numberFormat(Total.toFixed(2)));
}

function numberFormat(n) {
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, "") + (parts[1] ? "," + parts[1] : "");
}

function SelectMaterial(div){
	var Base = $(div).attr('rel');
			$('#Material').val($('#AddMat'+Base).val());
			$('#IDMat').val($('#AddMatID'+Base).val());
			$('#Valor').val($('#AddMatVal'+Base).val());
			$('#VTotal').val($('#AddMatVal'+Base).val());
			$('#Total').val($('#AddMatVal'+Base).val());
			$('#QNT').val('1');
}
</script>

<?php }?>