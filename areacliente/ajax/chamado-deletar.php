<?php
		require_once('../lib/tabs/tabchamado.php');
		require_once('../lib/url.php');
		
		$URL = new URL;
		
		if(!empty($_GET['ID'])){
				
				$Ch = new tabChamado($_GET['ID']);
?>
		<h4>Deletar Chamado:</h4>
        
        <p class="left">Se você realmente excluir este chamado, estára excluindo automaticamente qualquer dado vinculado a este (O.S, Materiais/Serviços, Comentários e Relatórios). Deseja realmente excluir?</p>        
        <div class="sepCont"></div>
        <a href="<?php echo $URL->siteURL;?>chamados/visualizar/deletar/<?php echo $_GET['ID'];?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" /> Deletar Tudo</div></a>
        <div class="btnAct" onClick="$('.PopUp').fadeOut();"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" /> Cancelar</div>
<?php
		}
?>