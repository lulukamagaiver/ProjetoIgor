<?php

		require_once('lib/ver-login.php');
		include_once('lib/warnings.php');
		include_once('lib/url.php');
		include_once('lib/js.php');
		include_once('lib/date.php');
		include_once('lib/sessao.php');
		include_once('lib/tabs/tabacessos.php');
		
		$URL = new URL;
		$W = new Warnings;
		$S = new Sessao;
		$d = new getDate;
		
$Salva = 1;
if(($S->ID != '')){
		$Acss = new tabAcessos;
		$Acss->SqlWhere = "IDUser = '".$S->ID."' AND StatusUser = '".$S->Status."'";
		$Acss->SqlOrder = "Data DESC LIMIT 1";
		$Acss->MontaSQL();
		$Acss->Load();
		
		if(($Acss->URL != substr($_SERVER['REQUEST_URI'],1)) || ($Acss->NumRows == 0)){
				$Acss->IP = getenv("REMOTE_ADDR");
				$Acss->IDUser = $S->ID;
				$Acss->StatusUser = $S->Status;
				$Acss->URL = substr($_SERVER['REQUEST_URI'],1);
				$Acss->Data = date('Y-m-d H:i:s');
				$Acss->Insert();
		}else{
				$Acss->Data = date('Y-m-d H:i:s');
				$Acss->Update($Acss->ID);
		}
}
?>
<!doctype html>
        <head>
        <meta charset="utf-8">
        <title><?php echo $URL->siteTitle;?></title>
        <?php require('html/header.php');?>
        <?php $JS = new JS();?>
		<meta name="google-site-verification" content="eScIeXdPfricYXboEUXpsZiH8wrGARRc0w6t4ssajf4" />
        </head>
<body>
		
		<?php require('html/topo.php');?>
		
        <div class="conteudo">
				<?php 
				include_once(dirname(__FILE__)."/".$URL->Pag());?>
        </div>
        
        <?php require('html/footer.php');?>
        
        <?php require('html/warnings.php');?>
        
        <?php require('html/popup.php');?>
        
<iframe src="" name="ajax" style="display:none;"></iframe>
<script>
$('input').attr('autocomplete','off');
</script>
</body>
</html>