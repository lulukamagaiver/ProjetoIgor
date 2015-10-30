<?php
include_once(dirname(dirname(__FILE__)).'/lib/tabs/tabclientes.php');

if(!empty($_POST['busca'])){
	$Cl = new tabClientes;
	$Cl->SqlWhere = "Nome LIKE '%".$_POST['busca']."%' LIMIT 4";
	$Cl->MontaSQL();
	$Cl->Load();
	
	if($Cl->NumRows > 0){
			echo "<script>$('.auto').fadeIn();</script>";
			for($a=0; $a < $Cl->NumRows; $a++){
					if($a == 0){
						echo '<input type="hidden" id="FirstAutoNome" value="'.$Cl->Nome.'" />';
						echo '<input type="hidden" id="FirstAutoID" value="'.$Cl->ID.'" />';
					}
					echo '
					<div class="opt" rel="'.$Cl->ID.'" title="'.$Cl->Nome.'" onClick="SelectCliente(this);">'.$Cl->Nome.'</div>
					';
					$Cl->Next();
			}
	}else echo "<script>$('.auto').fadeOut();</script>";
}else echo "<script>$('.auto').fadeOut();</script>";
?>