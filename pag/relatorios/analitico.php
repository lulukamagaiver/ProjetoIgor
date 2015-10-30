<?php
		$S->PrAcess(73); //Visualizar Relatorios de Estatisticas
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabmateriaischamado.php');
		
		$Where = "";
		
		if(!empty($_POST['IDs'])){
				$Mes = $_POST['Mes'];
				$Ano = $_POST['Ano'];
				
				$d->SelectMes($Mes,$Ano);
				
				foreach($_POST['IDs'] as $key => $val){
						if($key == 0) $Where .= "cl.ID = '".$val."'";
						else $Where .= " || cl.ID = '".$val."'";
				}
				
				$Cl = new tabCLientes;
				$Cl->Query = "SELECT cl.*, 
				(SELECT COUNT(*) FROM chamado WHERE IdCl = cl.ID AND Data BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') AS TChamados,
				(SELECT COUNT(*) FROM chamado WHERE IdCl = cl.ID AND StatusOS = '2' AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') AS TOS, 
				(SELECT COUNT(*) FROM chamado WHERE (Status != '1' AND Status != '14') AND IdCl = cl.ID AND Data BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') TChAtendimento,
				(SELECT SUM(VTotal) FROM materiaischamados AS m WHERE m.IDChamado IN (SELECT ID FROM chamado WHERE IdCl = cl.ID AND StatusOS = '2' AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') ) AS Materiais
				FROM clientes AS cl WHERE ".$Where." ORDER BY cl.Nome";
				array_push($Cl->Tabs,'TChamados','TOS','TChAtendimento','Materiais');
				$Cl->MontaSQLRelat();
				$Cl->Load();
				
				$Cl->TG['TChamados'] = 0;
				$Cl->TG['TChAtendimento'] = 0;
				$Cl->TG['TOS'] = 0;
				$Cl->TG['Materiais'] = 0;
				
				$DataGrafMaterial = "";
				$DataGrafChamados = "";
				
				
				$Mat = new tabMateriaisChamado;
				$DataEvolucao = "[[0,0]";
				for($a=1;$a<13;$a++){
						$d->SelectMes($a,$Ano);
						$Mat->Query = "SELECT SUM(m.VTotal) AS Total FROM materiaischamados AS m WHERE m.IDChamado IN (SELECT ID FROM chamado WHERE (".str_replace('cl.ID','IdCl',$Where).") AND StatusOS = '2' AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59')";
						$Mat->Tabs = array('Total');
						$Mat->MontaSQLRelat();
						$Mat->Load();
						
						$DataEvolucao .= ",[".$a.",".number_format($Mat->Total,0,'','')."]";
				}
				$DataEvolucao .= "]";
		}
		
		//echo $Cl->Query;
?>
<div id="Imprimir">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
        <td width="200" height="60" align="center" valign="bottom"><img src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" height="60" id="Logo" class="prints" /></td>
        <td height="60" align="center" valign="middle"><strong>RELATÓRIO ANALÍTICO DE MANUTENÇÃO</strong></td>
        <td style="font-style:italic" width="300" height="60" align="center" valign="bottom">Mês de Referência: <strong><?php echo $d->MesExtenso($Mes);?> de <?php echo $Ano;?></strong></td>
 		</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <thead>
                <tr>
                <th height="25" align="left" valign="middle" scope="col">CLIENTES</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">CHAMADOS</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">OS</th>
                <th width="120" height="25" align="center" valign="middle" scope="col">EM ATENDIMENTO</th>
                <th width="120" height="25" align="center" valign="middle" scope="col">MATERIAL</th>
          </tr>
        </thead>
        <tbody>
        <?php for($a=0;$a<$Cl->NumRows;$a++):?>
        <?php 
		
		$DataGrafMaterial = $DataGrafMaterial.'{label:\''.$Cl->Nome.'\', data:'.number_format($Cl->Materiais,0,'','').'}'.(($a == ($Cl->NumRows - 1)) ? "" : ",");
		$DataGrafChamados = $DataGrafChamados.'{label:\'\', data:'.$Cl->TChamados.'}'.(($a == ($Cl->NumRows - 1)) ? "" : ",");
		
		$Cl->TG['TChamados'] += $Cl->TChamados; 
		$Cl->TG['TChAtendimento'] += $Cl->TChAtendimento; 
		$Cl->TG['TOS'] += $Cl->TOS; 
		$Cl->TG['Materiais'] += $Cl->Materiais;
		?>
                <tr>
                <td height="25" align="left" valign="middle"><?php echo $Cl->Nome;?></td>
                <td width="80" height="25" align="center" valign="middle"><?php echo $Cl->TChamados;?></td>
                <td width="80" height="25" align="center" valign="middle" style="font-weight:bold"><?php echo $Cl->TOS;?></td>
                <td width="120" height="25" align="center" valign="middle"><?php echo $Cl->TChAtendimento;?></td>
                <td width="120" height="25" align="center" valign="middle">R$ <?php echo number_format($Cl->Materiais,2,',','.');?></td>
				</tr>
        <?php $Cl->Next(); endfor;?>
        </tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4" style="margin-top:20px;">
        <tr>
        <td height="25" align="right" valign="middle" style="font-weight:bold; font-style:italic;">TOTAL DE CHAMADOS / OS:</td>
        <td class="STotal" width="80" height="25" align="center" valign="middle"><?php echo $Cl->TG['TChamados'];?></td>
        <td class="STotal" width="80" height="25" align="center" valign="middle" style="font-weight:bold"><?php echo $Cl->TG['TOS']?></td>
        <td class="STotal" width="120" height="25" align="center" valign="middle"><?php echo $Cl->TG['TChAtendimento'];?></td>
        <td class="STotal" width="120" height="25" align="center" valign="middle"></td>
        </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4" style="font-style:italic; font-weight:bold;">
        <tr>
        <td width="80" height="25" align="center" valign="middle"></td>
        <td width="80" height="25" align="center" valign="middle"></td>
        <td width="120" height="25" align="center" valign="middle"></td>
        <td height="25" align="right" valign="middle">CUSTO TOTAL DE MATERIAL:</td>
        <td width="120" height="25" align="center" valign="middle">R$ <?php echo number_format($Cl->TG['Materiais'],2,',','.');?></td>
        </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <thead>
                <tr>
                <th height="25" align="left" valign="middle" scope="col">ANÁLISE GRÁFICA</th>
          		</tr>
        </thead>
        <tbody><tr><td></td></tr></tbody>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
        <th>
                <br /><strong>CUSTO INDIVIDUAL COM MATERIAL</strong><br />
                
                <div id="GrafMaterial" style="width:333px; height:333px; float:left;"></div>
                <img src="" width="333" height="333" id="ImgGrafMaterial" style="float:left; display:none; margin-top:-333px;" />
        </th>
        <th>
                <br /><strong>VOLUME INDIVIDUAL DE CHAMADOS</strong><br />
                
                <div id="GrafChamados" style="width:333px; height:333px; float:left;"></div>
                <img src="" width="333" height="333" id="ImgGrafChamados" style="float:left; display:none; margin-top:-333px;" />
        </th>
        <th align="right">
                <br /><strong>LEGENDA</strong><br />
                <div id="GrafLegendas" style="width:333px; height:333px; float:left;"></div>
                <img src="" width="333" height="333" id="ImgGrafLegendas" style="float:left; display:none; margin-top:-333px;" />
        </th>
        </tr>
</table>
<!--
<div class="sepCol3" style="text-align:center; font-style:italic; height:400px; width:333px;">
</div>

<div class="sepCol3" style="text-align:center; font-style:italic; height:400px; width:333px;">
</div>

<div class="sepCol3" style="text-align:right; font-style:italic; height:400px; width:333px;">
</div>
-->

<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <thead>
                <tr>
                <th height="25" align="left" valign="middle" scope="col">EVOLUÇÃO GERAL DE CUSTOS COM MATERIAL</th>
          		</tr>
        </thead>
        <tbody><tr><td></td></tr></tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
                <th>
                        <div id="EvolucaoGeral" style="float:left; width:100%; height:200px;"></div>
                        <img src="" width="100%" height="200" id="ImgGrafEvolucao" style="display:none; position:absolute; left:15px;" />
                </th>
        </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4">
                <tr>
                <th height="25" align="right" valign="middle" scope="col" style="font-style:italic; font-size:14px;">service7.com.br</th>
          		</tr>
</table>
</div>
<div class="sepCont"></div>
<div class="btnAct" onClick="Imprimir()"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div>

<style>
@media print{
.screen{ display:none;}	
.prints{ display:block;float:left;}	
body{
	margin:0;
	padding:0;
	font-size:12px;
	color:#000;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	background-position:center 143px;
	background-repeat:no-repeat;
}
}
<?php include_once($URL->siteURL."css/estilo.css");?>
<?php include_once($URL->siteURL."css/tabelas.css");?>
<?php include_once($URL->siteURL."css/conteudo.css");?>
<?php include_once($URL->siteURL."css/paginas.css");?>
<?php include_once($URL->siteURL."css/tabelas.css");?>
table{
	float:left;
	font-size:14px;
	color:#333;
}

thead tr{
	background-color:#666;
	color:#FFF;
	font-weight:bold;
	font-style:italic;
}

tbody tr{
	background-color:#DEDEDE;
}

.STotal{
	border-top:3px #000 solid;
}

tbody tr:nth-child(odd){
	background-color:transparent;
}

.pieLabel{
	color:#FFF;
}
</style>
<script>
		$(function(){
				$.plot("#GrafMaterial",[<?php echo $DataGrafMaterial;?>],{
					series:{
						pie: {
								show:true,
								radius: 3.6/4,
								startAngle:2,
								label: {
									show: true,
									radius: 1,
									background: { 
									opacity: 0.8,
									color: '#FFF'
									},
									formatter: function (label, series) {
										return '<strong style="color:#000;">' + Math.round(series.percent) + '%</strong>';
										//return console.log(series.data);
									},
									threshold: 0.01
								}
							}
					},
					legend: {
							show: false
					}
				});
				
				$.plot("#GrafChamados",[<?php echo $DataGrafChamados;?>],{
					series:{
						pie: {
								show:true,
								radius: 3.6/4,
								startAngle:2,
								label: {
									show: true,
									radius: 1,
									background: { 
									opacity: 0.8,
									color: '#FFF'
									},
									formatter: function (label, series) {
										return '<strong style="color:#000;">' + Math.round(series.percent) + '%</strong>';
										//return console.log(series.data);
									},
									threshold: 0.01
								}
							}
					},
					legend: {
							show: false
					}
				});
				
				$.plot("#GrafLegendas",[<?php echo $DataGrafMaterial;?>],{
					legend: {
							show: true
					},
					yaxis: {tickLength:0}, 
					xaxis: {tickLength:0},
					grid: {show: false}
				});
				
				
				$.plot("#EvolucaoGeral", [{
					data: <?php echo $DataEvolucao;?>,
					color: '#000',
					points: {show:true},
					lines: {show: true}
				},
				{
					data: [[<?php echo $Mes;?>,<?php echo $Cl->TG['Materiais'];?>]],
					bars: {show:true, lineWidth:1, barWidth:.5, align: 'center'},
					color: '#0C0'
				}],
				{
				xaxis: {
					ticks: [
							[0, ['']], [1, ['Jan/<?php echo $Ano;?>']],[2, ['Fev']],[3, ['Mar']],[4, ['Abr']],[5, ['Mai']],[6, ['Jun']],[7, ['Jul']],[8, ['Ago']],[9, ['Set']],[10, ['Out']],[11, ['Nov']],[12, ['Dez']]
					]
				},
				yaxis: {
					mode: "money",
					min: 0,
					tickDecimals: 2,
					tickFormatter: function (v, axis) { return "R$" + numberFormat(v.toFixed(axis.tickDecimals)) }
	
				}
				});

		});
		
		
function get64(Img){
	var p = Img.attr('src');
	img = new Image();
	img.setAttribute('src', p);
	var canvas = document.createElement("canvas");
	canvas.width = img.width;
	canvas.height = img.height;
	var ctx = canvas.getContext("2d");
	ctx.drawImage(img, 0, 0);
	var dataURL = canvas.toDataURL("image/png");
	var dataURL = canvas.toDataURL("image/png");
	var r=dataURL.replace('/^data:image/(png|jpg);base64,/', "");
	base64=r;
	Img.attr('src',base64);
}

function Imprimir(){
	//Grafico Chamados
	var canvas1  = $('#GrafChamados canvas');
	var img1 = $('#ImgGrafChamados');
	img1.attr('src',canvas1[0].toDataURL("image/png"));
	canvas1.hide();
	img1.show();
	
	//Grafico OS
	var canvas2  = $('#GrafMaterial canvas');
	var img2 = $('#ImgGrafMaterial');
	img2.attr('src',canvas2[0].toDataURL("image/png"));
	canvas2.hide();
	img2.show();
	
	//Grafico OS Clientes
	var canvas3  = $('#GrafLegendas canvas');
	var img3 = $('#ImgGrafLegendas');
	img3.attr('src',canvas3[0].toDataURL("image/png"));
	//canvas3.parent().hide();
	//img3.show();
	
	//Grafico OS Clientes
	var canvas4  = $('#EvolucaoGeral canvas');
	var img4 = $('#ImgGrafEvolucao');
	img4.attr('src',canvas4[0].toDataURL("image/png"));
	img4.show();
	
	get64($('#Logo'));
	$('#Imprimir').print();

	img4.hide();	
	return false;	

}
</script>