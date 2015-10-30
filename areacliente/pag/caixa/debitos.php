<?php
		require_once('lib/db-conex.php');
		require('lib/relatorios.php');
		require_once('lib/tabs/tabcaixa.php');
		require_once('lib/tabs/tabbanco.php');
		//Deletar
		if(!empty($URL->GET)){
				$url = explode('/',$URL->GET);
				if((!empty($url[1])) && ($url[1] == 'deletar')){
						if($url[2] == 'caix') $Del = new tabCaixa;
						if($url[2] == 'banco') $Del = new tabBanco;
						
						$Del->SqlWhere = "ID = '".$url[3]."'";
						$Del->MontaSQL();
						$Del->Load();
						
						if($Del->NumRows >0){
								if(!empty($Del->IDParcela)) $Del->DeleteIDParcela($Del->IDParcela);
								else $Del->Delete($Del->ID);
								
								if($Del->Result) $W->AddAviso('Registro deletado.','WS');
								else $W->AddAviso('Problemas ao deletar registro.','WE');
						}else $W->AddAviso('Você provavelmente já deletou este registro.','WA');
				}else $W->AddAviso('Não foi definida uma ação.','WA');
		}

		
		$Bal = new DBConex;
		
		
		$Bal->Query = "SELECT *, 'Caixa' AS Status,
		CASE Tipo WHEN '2' THEN IF(Entrada != 0.00, Entrada, (IF(VParcela != 0, VParcela, Valor))) ELSE '0.00' END AS Saida FROM caixa WHERE Tipo = 2
		UNION
		SELECT *, 'Banco' AS Status, 
		CASE Tipo WHEN '2' THEN IF(Entrada != 0.00, Entrada, (IF(VParcela != 0, VParcela, Valor))) ELSE '0.00' END AS Saida FROM banco
		WHERE Tipo = 2 ORDER BY Data
		";
		
		
		$Bal->Tabs = array('ID','Status','Data','Finalidade','Categoria','Valor','Parcelas', 'IDParcela', 'VParcela', 'Entrada','Tipo','IdCl','Obs','Saida');
		$Bal->MontaSQLRelat();
		$Bal->Load();
		
		
		
?>

<h1>Relatório de Débitos</h1>

		<?php
		$t = new Relat('100%',true);
		$t->WidthCols = array('30','80','60','235','348','110','60','100');
		$t->Cols = array('item','Data','Status','Cliente','Finalidade','Saida','action','ID');
		$t->Totais = array(0,0,0,0,0,1,0,0);
		$t->Formato = array('','data','','','','moeda','','');
		$t->Actions = '
		<a href="'.$URL->siteURL.'caixa/alterar/{tipoBal}/{id}"><img class="action" src="imgs/icones/edit.png" width="26" height="26" /></a>
		<a href="'.$URL->siteURL.'caixa/visualizar/deletar/{tipoBal}/{id}"><img class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>
		';
		$t->Query = $Bal->Query;
		$t->setTitulos(array('#:center','Data:center','Origem:center','Cliente:left','Finalidade:left','Saída:ceter','Ações:center','ID:center'));
		$t->showTab();
 		?>