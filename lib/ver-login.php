<?php
		require_once('sessao.php');
		require_once('url.php');
		require_once('warnings.php');
		$segundos = 0;
		
		$URL = new URL;
		$W = new Warnings;
		$S = new Sessao;
		if(empty($S->ID)){
			echo "<script>document.location = '".$URL->siteURL."login/';</script>";
			exit;
		}
		
		if(!empty($_SESSION['registro']))$registro = $_SESSION['registro'];
		else $registro = "";
		$limite = $URL->LimiteSessao;
		if((!empty($registro)))// verifica se a session  registro esta ativa
		{
				$segundos = time()- $registro;
				
				if($segundos>$limite)
				{
						$S->Logout();
						$W->AddAviso('Sua sessão expirou.','WA');

						echo "<script>document.location = '".$URL->siteURL."login/';</script>";
						exit;
						
				}
				else{
				 $_SESSION['registro'] = time();
				}
		}
		else{
		 $_SESSION['registro'] = time();
		}


?>