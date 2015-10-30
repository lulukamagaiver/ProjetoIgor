<?php
		$S->PrAcess(73); //Visualizar Relatorios de Estatisticas
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabmateriaischamado.php');
		
		$Where = "";
		$MesRef = "";
		$TMeses = 0;
		
		if(!empty($_POST['Meses'])){				
				foreach($_POST['Meses'] as $key => $val){
						$Data = explode('-',$val);
						
						$TMeses++;
						
						
						$d->SelectMes($Data[0],$Data[1]);
						if($key == 0){
								$Where .= "o.DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59'";
								$MesRef .= $d->MesExtenso($Data[0])."/".$Data[1];
						}
						else {
								$Where .= " || o.DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim." 23:59:59'";
								$MesRef .= ", ".$d->MesExtenso($Data[0])."/".$Data[1];
						}
				}
				
				$Mat = new tabMateriaisChamado;
				$Mat->Query = "SELECT m.*, cl.VContrato, cl.Nome, SUM(m.VTotal) AS VTotal, m.Valor, SUM(m.QNT) AS QNT, GROUP_CONCAT(o.ID SEPARATOR '-') AS NumOS, COUNT(o.ID) AS TOS
				FROM materiaischamados AS m INNER JOIN chamado AS o ON o.ID = m.IDChamado INNER JOIN clientes AS cl ON cl.ID = o.IdCl
				WHERE (".$Where.") AND cl.ID = '".$_POST['ClientesOpc']."' GROUP BY m.Descricao ORDER BY m.Descricao";
				array_push($Mat->Tabs,'NumOS','TOS','VContrato','Nome');
				$Mat->MontaSQLRelat();
				$Mat->Load();
				
				$Mat->TG['VTotal'] = 0;
				$Mat->TG['TOS'] = 0;
				
				//echo $Mat->Query;

		}
		
		//echo print_r($_POST);
?>
<div id="Imprimir">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
        <td width="200" height="60" align="center" valign="bottom"><img src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" height="60" id="Logo" class="prints" /></td>
        <td height="60" align="center" valign="middle"><strong>RELATÓRIO ANALÍTICO DE MATERIAL</strong></td>
        <td style="font-style:italic" width="200" height="60" align="center" valign="bottom"></td>
 		</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
        <td style="font-style:italic" width="45%" height="" align="left" valign="bottom"><strong>Cliente: </strong><?php echo $Mat->Nome;?></td>
        <td height="" align="center" valign="middle"></td>
        <td style="font-style:italic; direction:rtl" width="45%" height="" align="right" valign="bottom">Mês(es) de Referência: <strong><?php echo $MesRef;?></strong></td>
 		</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <thead>
                <tr>
                <th height="25" align="left" valign="middle" scope="col">Descricão</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">Valor Unit.</th>
                <th width="80" height="25" align="center" valign="middle" scope="col">Nº OS's</th>
                <th width="50" height="25" align="center" valign="middle" scope="col">QNT</th>
                <th width="120" height="25" align="center" valign="middle" scope="col">Valor Total</th>
          </tr>
        </thead>
        <tbody>
        <?php for($a=0;$a<$Mat->NumRows;$a++):?>
        <?php 
		$Mat->TG['VTotal'] += $Mat->VTotal; 
		$Mat->TG['TOS'] += $Mat->TOS;
		
		$LinkOS = "";
		foreach(explode('-',$Mat->NumOS) as $key => $val){
				if($key == 0) $LinkOS .= '<a href="'.$URL->siteURL.'os/visualizar/'.$val.'/" target="_blank">'.$val.'</a>';
				else $LinkOS .= ' - <a href="'.$URL->siteURL.'os/visualizar/'.$val.'/" target="_blank">'.$val.'</a>';
		}
		?>
                <tr>
                <td height="25" align="left" valign="middle"><?php echo $Mat->Descricao;?></td>
                <td width="80" height="25" align="center" valign="middle">R$ <?php echo $Mat->Valor;?></td>
                <td width="120" height="25" align="center" valign="middle" style="font-weight:bold"><?php echo $LinkOS;?></td>
                <td width="35" height="25" align="center" valign="middle"><?php echo $Mat->QNT;?></td>
                <td width="120" height="25" align="center" valign="middle">R$ <?php echo number_format($Mat->VTotal,2,',','.');?></td>
				</tr>
        <?php $Mat->Next(); endfor;?>
        </tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="4" style="margin-top:20px; font-style:italic;">
        <tr>
        <td height="" align="right" valign="middle" style="font-weight:bold; font-style:italic;">TOTAL DE OS's:</td>
        <td class="STotal" width="80" height="" align="center" valign="middle"><?php echo $Mat->TG['TOS'];?></td>
        <td class="STotal" width="155" height="" align="right" valign="middle" style="font-weight:bold">CUSTO TOTAL DE MATERIAL R$</td>
        <td class="STotal" width="120" height="" align="right" valign="middle"><?php echo number_format($Mat->TG['VTotal'],2,',','.');?></td>
        </tr>
        
        <tr style="background-color:transparent">
        <td height="" align="right" valign="middle" style="font-weight:bold; font-style:italic;"></td>
        <td class="" width="80" height="" align="center" valign="middle"></td>
        <td class="" width="320" height="" align="right" valign="middle" style="font-weight:bold">CONTRATO R$</td>
        <td class="" width="120" height="" align="right" valign="middle"><?php echo ($TMeses > 1) ? $TMeses."x ".number_format(($Mat->VContrato * $TMeses),2,',','.') : number_format($Mat->VContrato,2,',','.');?></td>
        </tr>
        
        <tr style="background-color:transparent; color:#F00;">
        <td height="" align="right" valign="middle" style="font-weight:bold; font-style:italic;"></td>
        <td class="" width="80" height="" align="center" valign="middle"></td>
        <td class="" width="320" height="" align="right" valign="middle" style="font-weight:bold">TOTAL GERAL R$</td>
        <td class="" width="120" height="" align="right" valign="middle"><?php echo number_format(($Mat->VContrato * $TMeses) + $Mat->TG['VTotal'],2,',','.');?></td>
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

a {
	color:#000;
	text-decoration:none;
}

a:hover{
	color:#000;
	text-decoration:underline;
}
</style>
<script>
		
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
	get64($('#Logo'));
	$('#Imprimir').print();
	return false;	
}
</script>