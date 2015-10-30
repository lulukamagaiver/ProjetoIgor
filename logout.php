<?php
		session_start();
		require_once('lib/url.php');
		require_once('lib/sessao.php');
		require_once('lib/warnings.php');
		
		$URL = new URL;
		
		$S = new Sessao;
		
		$S->Logout();
		
		$W = new Warnings;
		
		$W->AddAviso('Você se desconectou do seu sistema.','WS');
?>
<script>document.location = '<?php echo $URL->siteURL;?>';</script>