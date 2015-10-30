<?php
		session_start();
		require_once('../lib/tabs/tabcomentariochamado.php');
		require_once('../lib/url.php');
		require_once('../lib/warnings.php');
		
		$W = new Warnings;
		
		$URL = new URL;
		
		if(!empty($_GET['id'])){
						
		$Cm = new tabComentarioChamado;
		$Cm->SqlWhere = "ID = '".$_GET['id']."'";
		$Cm->MontaSQL();
		$Cm->Load();
								
		if(!empty($_POST['EnviaComentario'])){
				if(!empty($_POST['Comentario2'])){
						$Cm->Comentario = $_POST['Comentario2'];
						$Cm->Update($_GET['id']);
						
						if($Cm->Result){
								$W->AddAviso('Comentário alterado.','WS');
								echo "<script>parent.document.location.reload();</script>";
						}else echo "<script>parent.AddAviso('Problemas ao alterar comentário.','WA');</script>";
				}else echo "<script>parent.AddAviso('Insira um comentário.','WA');</script>";

		}else{?>

<h4>Alterar Comentário</h4>
<form method="post" target="ajax" action="<?php echo $URL->siteURL;?>ajax/chamado-alterar-comentario.php?id=<?php echo $_GET['id'];?>">
		<textarea name="Comentario2" id="Comentario2" style="width:500px; height:200px;"><?php echo $Cm->Comentario?></textarea>
        <input type="hidden" name="ID" id="ID" value="" />
        <input name="EnviaComentario" type="submit" value="ok" style="display:none;">
        <div class="btnAct" onClick="return $('input[name=EnviaComentario]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/refresh.png" />Alterar</div>
        <div class="btnAct" onClick="$('.PopUp').fadeOut();"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" />Cancelar</div>
</form>

<?php }
}else echo "<script>parent.parent.AddAviso('Nenhum comentário defino para ser alterado..','WA'); parent.$('.PopUp')fadeOut();</script>";?>