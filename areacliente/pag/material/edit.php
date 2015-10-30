<?php
		require_once('../../lib/ver-login.php');
		require_once('../../lib/tabs/tabmaterial.php');
		require_once('../../lib/warnings.php');
		$W = new Warnings;
		
		if((!empty($_POST['ID'])) && (!empty($_POST['Status'])) && (!empty($_POST['Material'])) && (!empty($_POST['Valor']))){
				$Mat = new tabMaterial;
				$Mat->GetValPost();
				$Mat->Update($_POST['ID']);
				
				if($Mat->Result){
					$W->AddAviso('Material/Serviço alterado.','WS');
					echo "<script>parent.document.location.reload();</script>";
				}else echo "<script>parent.AddAviso('Problemas ao alterar Material/Serviço.','WE');</script>";
		}else echo "<script>parent.AddAviso('Preencha todos os campos.','WA');</script>";
?>