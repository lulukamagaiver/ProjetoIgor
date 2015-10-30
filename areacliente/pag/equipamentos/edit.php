<?php
		require_once('../../lib/ver-login.php');
		require_once('../../lib/tabs/tabequipamento.php');
		require_once('../../lib/warnings.php');
		$W = new Warnings;
		
		if((!empty($_POST['ID'])) && (!empty($_POST['Status'])) && (!empty($_POST['Equipamento'])) && (!empty($_POST['IdCl'])) && (!empty($_POST['Descricao']))){
				$Eq = new tabEquipamento;
				$Eq->GetValPost();
				$Eq->Update($_POST['ID']);
				
				if($Eq->Result){
					$W->AddAviso('Equipamento/Produto alterado.','WS');
					echo "<script>parent.document.location.reload();</script>";
				}else echo "<script>parent.AddAviso('Problemas ao alterar Equipamento/Produto.','WE');</script>";
		}else echo "<script>parent.AddAviso('Preencha todos os campos.','WA');</script>";
?>