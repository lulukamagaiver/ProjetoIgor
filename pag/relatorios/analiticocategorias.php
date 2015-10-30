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
				(SELECT COUNT(*) FROM chamado WHERE StatusOS = '2' AND Categoria = '1' AND IdCl = cl.ID AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') TGarantia,
				(SELECT COUNT(*) FROM chamado WHERE StatusOS = '2' AND Categoria = '2' AND IdCl = cl.ID AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') TCrr,
				(SELECT COUNT(*) FROM chamado WHERE StatusOS = '2' AND Categoria = '3' AND IdCl = cl.ID AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') TPrev,
				(SELECT COUNT(*) FROM chamado WHERE StatusOS = '2' AND Categoria = '4' AND IdCl = cl.ID AND DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59') TUso
				FROM clientes AS cl WHERE ".$Where." ORDER BY cl.Nome";
				array_push($Cl->Tabs,'TChamados','TOS','TChAtendimento','TGarantia','TCrr','TPrev','TUso');
				$Cl->MontaSQLRelat();
				$Cl->Load();
				
				$Cl->TG['TChamados'] = 0;
				$Cl->TG['TChAtendimento'] = 0;
				$Cl->TG['TOS'] = 0;
				$Cl->TG['Garantia'] = 0;
				$Cl->TG['Corr'] = 0;
				$Cl->TG['Prev'] = 0;
				$Cl->TG['Uso'] = 0;
				
				$DataGrafMaterial = "";
				$DataGrafChamados = "";
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
                <th width="98" height="25" align="center" valign="middle" scope="col">EM ATENDIMENTO</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">GARANTIA</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">M-CORR</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">M-PREV</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">MAL USO</th>
          </tr>
        </thead>
        <tbody>
        <?php for($a=0;$a<$Cl->NumRows;$a++):?>
        <?php 

		$Cl->TG['TChamados'] += $Cl->TChamados; 
		$Cl->TG['TChAtendimento'] += $Cl->TChAtendimento; 
		$Cl->TG['TOS'] += $Cl->TOS; 
		$Cl->TG['Garantia'] += $Cl->TGarantia;
		$Cl->TG['Corr'] += $Cl->TCrr;
		$Cl->TG['Prev'] += $Cl->TPrev;
		$Cl->TG['Uso'] += $Cl->TUso;
		?>
                <tr>
                <td height="25" align="left" valign="middle"><?php echo $Cl->Nome;?></td>
                <td width="80" height="25" align="center" valign="middle"><?php echo $Cl->TChamados;?></td>
                <td width="80" height="25" align="center" valign="middle" style="font-weight:bold"><?php echo $Cl->TOS;?></td>
                <td width="98" height="25" align="center" valign="middle"><?php echo $Cl->TChAtendimento;?></td>
                <td width="80" height="25" align="center" valign="middle"><?php echo $Cl->TGarantia;?></td>
                <td width="80" height="25" align="center" valign="middle"><?php echo $Cl->TCrr;?></td>
                <td width="80" height="25" align="center" valign="middle"><?php echo $Cl->TPrev;?></td>
                <td width="80" height="25" align="center" valign="middle"><?php echo $Cl->TUso;?></td>
				</tr>
        <?php $Cl->Next(); endfor;?>
        </tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4" style="margin-top:20px;">
        <tr>
        <td height="25" align="right" valign="middle" style="font-weight:bold; font-style:italic;">TOTAL DE CHAMADOS / OS:</td>
        <td class="STotal" width="80" height="25" align="center" valign="middle"><?php echo $Cl->TG['TChamados'];?></td>
        <td class="STotal" width="80" height="25" align="center" valign="middle" style="font-weight:bold"><?php echo $Cl->TG['TOS']?></td>
        <td class="STotal" width="98" height="25" align="center" valign="middle"><?php echo $Cl->TG['TChAtendimento'];?></td>
        <td class="STotal" width="80" height="25" align="center" valign="middle"><?php echo $Cl->TG['Garantia'];?></td>
        <td class="STotal" width="80" height="25" align="center" valign="middle"><?php echo $Cl->TG['Corr'];?></td>
        <td class="STotal" width="80" height="25" align="center" valign="middle"><?php echo $Cl->TG['Prev'];?></td>
        <td class="STotal" width="80" height="25" align="center" valign="middle"><?php echo $Cl->TG['Uso'];?></td>
        </tr>
</table>
<div class="sepCont"  style="page-break-after:always;"></div>
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
        <th align="left" valign="middle">
                <strong style="font-size:14px"><em>
                <table width="250" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="25" align="left" valign="middle">Total de Chamados</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['TChamados'];?></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle">Total de O.S.</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['TOS']?></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle">O.S. Garantia</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['Garantia'];?></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle">O.S. Corretiva</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['Corr'];?></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle">O.S. Preventiva</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['Prev'];?></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle">O.S. Mal Uso</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['Uso'];?></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle">O.S. em Atendimento</td>
                    <td width="50" height="25" align="center" valign="middle"><?php echo $Cl->TG['TChAtendimento'];?></td>
                  </tr>
                </table>
                </em></strong>
        </th>

        <th width="450" align="center">
                <br /><strong><div style="width:10px; height:10px;background-color:#40699C; display:inline-block"></div> GARANTIA 
                <div style="width:10px; height:10px; background-color:#4F81BD; display:inline-block"></div> M-CORR 
                <div style="width:10px; height:10px;background-color:#AABAD7; display:inline-block"></div> M-PREV</strong>
                <div style="width:10px; height:10px;background-color:#999999; display:inline-block"></div> MAL USO</strong><br /><br />
                <div id="Graf" style="width:450px; height:450px; float:left;"></div>
                <img src="" width="450" height="450" id="ImgGraf" style="float:left; display:none; margin-top:-450px;" />
        </th>
        <th width="100">
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
				$.plot("#Graf",[{data:'<?php echo $Cl->TG['Garantia'];?>',color:'#40699C'},{data:'<?php echo $Cl->TG['Corr'];?>',color:'#4F81BD'},{data:'<?php echo $Cl->TG['Prev'];?>',color:'#AABAD7'},{data:'<?php echo $Cl->TG['Uso'];?>',color:'#999999'}],{
					series:{
						pie: {
								show:true,
								radius: 1,
								startAngle:2,
								label: {
									show: true,
									radius: 3.6/4,
									background: { 
									opacity: 0.0,
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
	var canvas1  = $('#Graf canvas');
	var img1 = $('#ImgGraf');
	img1.attr('src',canvas1[0].toDataURL("image/png"));
	canvas1.hide();
	img1.show();
		
	get64($('#Logo'));
	$('#Imprimir').print();

	img1.hide();
	img1.show();	
	return false;	

}
</script>