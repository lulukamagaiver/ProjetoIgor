<?php
		require_once('../lib/tabs/tabclientes.php');
		require_once('../lib/tabs/tabequipamento.php');
		
		
		if(!empty($_GET['IdCl'])){
			$IdCl = $_GET['IdCl'];
				$Cl = new tabClientes;
				$Cl->SqlWhere = "ID = '".$IdCl."'";
				$Cl->MontaSQL();
				$Cl->Load();
				
				if($Cl->NumRows >0){
					$Eq = new tabEquipamento;
					$Eq->SqlWhere = "IdCl = '".$IdCl."'";
					$Eq->MontaSQL();
					$Eq->Load();
					
					$Eq2 = new tabEquipamento;
					$Eq2->SqlWhere = "IdCl = '".$IdCl."'";
					$Eq2->MontaSQL();
					$Eq2->Load();
						?>
                        <div id="SelectEquip">
                        		Equipamento: *<br />
                                <select name="IDEquipamento" id="IDEquipamento" onChange="TrocaEquip();">
                                		<option value="">Outro</option>
                                        <?php
										for($a=0;$a<$Eq->NumRows;$a++){
												echo '<option value="'.$Eq->ID.'">'.$Eq->Equipamento.'</option>';
												$Eq->Next();
										}
										?>
                                </select>
                        </div>
						<?php
						
						echo '<input type="hidden" id="ContratoCliente" value="'.(($Cl->Contrato == 1) ? "1" : "0").'" />';
						
                        for($a=0;$a<$Eq2->NumRows;$a++){
                                if($a == 0) echo '<input type="hidden" id="DescEquip0" value="" />';
								echo '<input type="hidden" id="DescEquip'.$Eq2->ID.'" value="'.$Eq2->Descricao.'" />';
								$Eq2->Next();
                        }
				}
		}
?>