<?php
include_once(dirname(dirname(__FILE__)).'/lib/tabs/tabmaterial.php');

if(!empty($_POST['busca'])){
	$Cl = new tabMaterial;
	$Cl->SqlWhere = "Material LIKE '%".$_POST['busca']."%' LIMIT 4";
	$Cl->MontaSQL();
	$Cl->Load();
	
	if($Cl->NumRows > 0){
			echo "<script>$('.auto').fadeIn();</script>";
			for($a=0; $a < $Cl->NumRows; $a++){
					echo '
					<div class="opt" rel="'.$Cl->ID.'" title="'.$Cl->Material.'" onClick="SelectMaterial(this);">'.$Cl->Material.'</div>
					<input type="hidden" id="AddMat'.$Cl->ID.'" value="'.$Cl->Material.'" />
					<input type="hidden" id="AddMatID'.$Cl->ID.'" value="'.$Cl->ID.'" />
					<input type="hidden" id="AddMatVal'.$Cl->ID.'" value="'.number_format($Cl->Valor,2,',','').'" />
					';
					$Cl->Next();
			}
	}else echo "<script>$('.auto').fadeOut();</script>";
}else echo "<script>$('.auto').fadeOut();</script>";
?>