<?php
		$S->PrAcess(26); //Visualizar Relatorios de OS
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabadmm.php');
		
		$Os = new tabChamado;
		
		$Us = new tabAdmm;
		$Us->MontaSQL();
		$Us->Load();
?>
<script>
$(function() {
		var d1 = [[<?php echo (!empty($_POST['Mes'])) ? $_POST['Mes'] : date('n');?>, <?php echo $Os->TotalOS((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('n'),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>]]
		var d2 = [
				[0, <?php echo $Os->TotalOS(12,((!empty($_POST['Ano'])) ? ($_POST['Ano'] - 1) : (date('Y') - 1)));?>], 
				[1, <?php echo $Os->TotalOS(1,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[2, <?php echo $Os->TotalOS(2,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[3, <?php echo $Os->TotalOS(3,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[4, <?php echo $Os->TotalOS(4,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[5, <?php echo $Os->TotalOS(5,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[6, <?php echo $Os->TotalOS(6,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[7, <?php echo $Os->TotalOS(7,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[8, <?php echo $Os->TotalOS(8,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[9, <?php echo $Os->TotalOS(9,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[10, <?php echo $Os->TotalOS(10,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[11, <?php echo $Os->TotalOS(11,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>], 
				[12, <?php echo $Os->TotalOS(12,((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>]
				];
		$.plot("#Teste", [{
			data: d2,
			color: '#000',
			points: {show:true},
			lines: {show: true}
		},
		{
			data: d1,
			bars: {show:true, lineWidth:1, barWidth:.5, align: 'center'},
			color: '#0C0'
		}],
		{
		xaxis: {
			ticks: [
					[0, ['Dez/<?php echo ((!empty($_POST['Ano'])) ? ($_POST['Ano'] - 1) : (date('Y') - 1));?>']], [1, ['Jan/<?php echo ((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y'));?>']],[2, ['Fev']],[3, ['Mar']],[4, ['Abr']],[5, ['Mai']],[6, ['Jun']],[7, ['Jul']],[8, ['Ago']],[9, ['Set']],[10, ['Out']],[11, ['Nov']],[12, ['Dez']]
			]
		}
		});
});

$(document).ready(function() {
	oTable = $('#table').dataTable({
		"bPaginate": false,
		"bJQueryUI": false,
		"paging": false,
		"bFilter": false,
		"sDom": '<"top">rt<"bottom"flp><"clear">',
		"aaSorting": [[ 1, "desc" ]]
	});
});

function Imprimir(){
	$('.prints').show();
	var canvas  = $('canvas');
	var img = $('#ImgTeste');
	img.attr('src',canvas[0].toDataURL("image/png"));
	canvas.hide();
	img.show();
	get64($('#Logo'));
	$('#Imprimir').print();
	$('.prints').hide();
	return false;	
}

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
</script>
<div id="Imprimir">

<img src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" height="60" id="Logo" class="prints" />
<div class="sepCont"></div>
<h1>Ordens de Serviço por Técnico | <?php echo (!empty($_POST['Mes'])) ? (($_POST['Mes'] < 10) ? "0".$_POST['Mes'] : $_POST['Mes']) : date('m');?>/<?php echo (!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y');?> | <?php echo (empty($_POST['Status'])) ? "Todas" : (($_POST['Status'] == 1) ? "Abertas" : "Fechadas");?></h1>

        <form method="post" style="float:left; width:100%;" class="screen">		
        <div class="sepCont"></div>

                        <div class="inputsMeio">
                        		Mês:<br />
                          <select name="Mes" id="Mes">
                                        <option value="1">Janeiro</option>
                                		<option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                </select>
                          <script>$('#Mes').val('<?php echo (!empty($_POST['Mes'])) ? $_POST['Mes'] : date('n');?>');</script>
                        </div>
                                                                        
                        <div class="inputsMeio">
                        		Ano:<br />
                          <select name="Ano" id="Ano">
                                		<option value="2013">2013</option>
                            <option value="2014">2014</option>
                                        <option value="2015">2015</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                </select>
                          <script>$('#Ano').val('<?php echo (!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y');?>');</script>
                        </div>
                        
                        <div class="inputsMeio">
                        		Status:<br />
                        		<select name="Status" id="Status">
                                		<option value="">Todas</option>
                                        <option value="1">Abertas</option>
                                        <option value="2">Fechadas</option>
                                </select>
                          <script>$('#Status').val('<?php echo (!empty($_POST['Status'])) ? $_POST['Status'] : "";?>');</script>
                        </div>
		
        <input name="" type="image" style="width:30px; height:30px; float:left;" src="<?php echo $URL->siteURL;?>imgs/icones/search.png" />
        <div class="sepCont" style="height:20px;"></div>        
</form>


		
<table id="table" width="100%" border="0" cellspacing="0" cellpadding="4">
<thead style="display:none;">
  <tr>
    <th height="20" align="left" valign="middle" scope="col">Técnico</th>
    <th width="20" height="20" align="center" valign="middle" scope="col">T</th>
    <th width="20" height="20" align="center" valign="middle" scope="col" style="color:#0C0;">C</th>
    <th width="20" height="20" align="center" valign="middle" scope="col" style="color:#F00;">S</th>
    <th width="600" height="20" align="left" valign="middle" scope="col">Gráfico</th>
  </tr>
</thead>
<tbody>
<?php for($a=0;$a<$Us->NumRows;$a++) :
$Total = $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""));
if($Total > 0) $Fator = 100 / $Total;
else $Fator = 0;
$Real = $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"",$Us->ID);
?>
  <tr rel="<?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"",$Us->ID);?>">
    <td height="20" align="left" valign="middle"><?php echo $Us->Nome;?></td>
    <td width="20" height="20" align="center" valign="middle"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"",$Us->ID);?></td>
    <td width="20" height="20" align="center" valign="middle" style="color:#0C0;"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"1",$Us->ID);?></td>
    <td width="20" height="20" align="center" valign="middle" style="color:#F00;"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"0",$Us->ID);?></td>
    <td width="600" height="20" align="left" valign="middle"><div style="width:<?php echo $Real * $Fator;?>%; background-color:#03F; height:15px;"></div></td>
  </tr>
<?php $Us->Next(); endfor;
$Real = $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"",'0');
?>
  <tr rel="<?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"","0");?>">
    <td height="20" align="left" valign="middle">Sem técnico definido</td>
    <td width="20" height="20" align="center" valign="middle"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"","0");?></td>
    <td width="20" height="20" align="center" valign="middle" style="color:#0C0;"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"1","0");?></td>
    <td width="20" height="20" align="center" valign="middle" style="color:#F00;"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),"0","0");?></td>
    <td width="600" height="20" align="left" valign="middle"><div style="width:<?php echo $Real * $Fator;?>%; background-color:#03F; height:15px;"></div></td>
  </tr>
</tbody>
<tfoot>
  <tr>
    <th height="20" align="center" valign="middle" scope="col">Total</th>
    <th width="20" height="20" align="center" valign="middle" scope="col"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""));?></th>
    <th width="20" height="20" align="center" valign="middle" scope="col" style="color:#0C0;"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),'1');?></th>
    <th width="20" height="20" align="center" valign="middle" scope="col" style="color:#F00;"><?php echo $Os->TotalOS(((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('m')),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')),((!empty($_POST['Status'])) ? $_POST['Status'] : ""),'0');?></th>
    <th width="600" height="20" align="center" valign="middle" scope="col">
    <div style="width:50px; height:15px; float:left;"></div>
    <div style="width:15px; background-color:#000; height:15px; float:left; margin-right:5px;"></div><div style="width:150px; height:15px; text-align:left; float:left;">Total</div>
    <div style="width:15px; background-color:#0C0; height:15px; float:left; margin-right:5px;"></div><div style="width:150px; height:15px; text-align:left; float:left;">Com Contrato</div>
    <div style="width:15px; background-color:#F00; height:15px; float:left; margin-right:5px;"></div><div style="width:150px; height:15px; text-align:left; float:left;">Sem Contrato</div>
    
    </th>
  </tr>
</tfoot>
</table>

<div id="Teste" style="float:left; width:100%; height:200px; margin-top:50px;">

</div>
<img src="" width="100%" height="200" style="float:left;margin-top:-200px; display:none;" id="ImgTeste" />
</div>

<div class="sepCont"></div>
<div class="btnAct" onClick="Imprimir()"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div>

<style>
@media print{
.screen{ display:none;}	
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
/*@import url("<?php echo $URL->siteURL;?>css/formularios.css");*/
.prints{ display:none;}	
td{
	border-bottom:1px solid #000;
}
</style>