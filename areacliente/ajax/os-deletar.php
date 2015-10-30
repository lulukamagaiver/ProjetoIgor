<?php
		require_once('../lib/tabs/tabchamado.php');
		require_once('../lib/url.php');
		
		$URL = new URL;
		
		if(!empty($_GET['ID'])){
				
				$Os = new tabChamado($_GET['ID']);
?>
		<h4>Deletar O.S.:</h4>
        
        <p class="left">Se você deseja excluir apenas a O.S., mas manter o chamado e alterar seu status para <strong>Aberto</strong>, clique no botão '<strong>Deletar O.S.</strong>' abaixo:</p>        
        <p class="left">Se você deseja excluir tudo (O.S., Chamado, Comentários, Materiais/Serviços), clique no botão '<strong>Deletar Tudo</strong>' abaixo:</p>
        <div class="sepCont"></div>
        <a href="<?php echo $URL->siteURL;?>os/visualizar/deletarordserv/<?php echo $_GET['ID'];?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" /> Deletar O.S.</div></a>
        <a href="<?php echo $URL->siteURL;?>os/visualizar/deletarchamado/<?php echo $_GET['ID'];?>/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" /> Deletar Tudo</div></a>
        <div class="btnAct" onClick="$('.PopUp').fadeOut();"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" /> Cancelar</div>
<?php
		}
?>