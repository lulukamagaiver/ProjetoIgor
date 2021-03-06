<?php
		include_once('lib/relatorios.php');
		include_once('lib/search.php');
		include_once('lib/tabs/tabequipamento.php');
		
		//BUSCA
		$B = new Search;
		$B->Like('ID,Equipamento',(!empty($_POST['Busca'])) ? $_POST['Busca'] : "");

		$VerMais = 0;
		
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				//DELETAR
				if(((!empty($url[1])) && ($url[1] == 'deletar')) && (is_numeric($url[2]))){
						$Del = new tabEquipamento;
						$Del->SqlWhere = "ID = '".$url[2]."'";
						$Del->MontaSQL();
						$Del->Load();
						$Del->Status = '0';
						$Del->Update($url[2]);
						if($Del->Result) $W->AddAviso('Equipamento removido.','WS');
						else $W->AddAviso('Problemas ao remover equipamento','WE');
				}
				
				//Definir qual cliente será exibido
				if(((!empty($url[0])) && ($url[0] == 'visualizar')) && (is_numeric($url[1]))){
						$VerMais = 1;
				}				
		}
		



if($VerMais == 0) :
		$tt = new tabEquipamento;
		$tt->SqlWhere = "Status = '1' AND ".$B->Where;
		$tt->SqlOrder = "Equipamento ASC";
		$tt->MontaSQL();
		$tt->Load();
?>

<h1>Consultar Equipamento/Produto</h1>
		
		<form method="post" style="float:left; width:100%;">		
        <div class="sepCont"></div>
                		<div class="inputsLarge">
                        		Busca por Código ou Equipamento: <br />
                                <input type="text" name="Busca" id="Busca" value="<?php echo (!empty($_POST['Busca'])) ? $_POST['Busca'] : "";?>" />
                        </div>
		
        <input name="" type="image" style="width:30px; height:30px; float:left; margin-left:0px;" src="imgs/icones/search.png" />
        <div class="sepCont" style="height:20px;"></div>        
        </form>        
        
        <!--<a href="<?php echo $URL->NURL;?>clientes/cadastrar/">
        <input name="" type="button" value="Novo" class="btnAZ" style="float:right; margin-bottom:20px; background-color:#09C;" />
        </a>-->
<?php
		$t = new Relat();
		$t->WidthCols = array('90','297','500','70');
		$t->Cols = array('ID','Equipamento','Descricao','action');
		$t->Totais = array(0,0,0,0);
		$t->Formato = array('cod','','','');
		$t->Actions = '
		<img class="action" src="imgs/icones/edit.png" width="26" height="26" onclick="PopUp(400,300,\''.$URL->siteURL.'ajax/alterar-equipamento.php?IDEquipamento={id}\');" />
		<a href="'.$URL->siteURL.'material/visualizar/deletar/{id}/"><img class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>
		';
		$t->Query = $tt->Query;
		$t->setTitulos(array('COD:center','Equipamento/Produto:left','Descrição:left','Açoes:Center'));
		echo "<p class=\"left\">Número de registros encontrados: <strong>".$tt->NumRows."</strong></p>";
		$t->showTab(); 


endif;?>