<?php
		$S->PrAcess(73); //Visualizar Relatorios de OS
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabadmm.php');
		
		$Os = new tabChamado;
		
		$Us = new tabAdmm;
		$Us->MontaSQL();
		$Us->Load();
		
		$d->setData();
		
		$e = new getDate();
		$e->setData();
?>
<script>
$(function() {
		var d1 = [[<?php echo (!empty($_POST['Mes'])) ? $_POST['Mes'] : date('n');?>, <?php echo $Os->TotalOS((!empty($_POST['Mes'])) ? $_POST['Mes'] : date('n'),((!empty($_POST['Ano'])) ? $_POST['Ano'] : date('Y')));?>]]
		var dOS = [
					<?php for($a = 12; $a >= 0; $a--){
					$d->setData($e->data,'BR',-(12-$a),2);?>
					[<?php echo $a;?>, <?php echo $Os->TotalOS($d->mes,$d->ano);?>]<?php echo ($a != 0) ? ',' : '';?><?php }?>
					];
		var dCh = [
					<?php for($a = 12; $a >= 0; $a--){
					$d->setData($e->data,'BR',-(12-$a),2);?>
					[<?php echo $a;?>, <?php echo $Os->TotalCh($d->mes,$d->ano);?>]<?php echo ($a != 0) ? ',' : '';?><?php }?>
					];
		$.plot("#GraficoOS", [{
			data: dOS,
			color: '#000',
			points: {show:true},
			lines: {show: true}
		}],
		{
		xaxis: {
			ticks: [
					<?php
					$mes = "";
					for($a = 12; $a >= 0; $a--){
					$d->setData('01/'.$e->mes.'/'.$e->ano,'BR',-(12-$a),2);
					if($d->mes == 01) $mes = 'Jan';
					elseif($d->mes == 02) $mes = 'Fev';
					elseif($d->mes == 03) $mes = 'Mar';
					elseif($d->mes == 04) $mes = 'Abr';
					elseif($d->mes == 05) $mes = 'Mai';
					elseif($d->mes == 06) $mes = 'Jun';
					elseif($d->mes == 07) $mes = 'Jul';
					elseif($d->mes == 08) $mes = 'Ago';
					elseif($d->mes == 09) $mes = 'Set';
					elseif($d->mes == 10) $mes = 'Out';
					elseif($d->mes == 11) $mes = 'Nov';
					elseif($d->mes == 12) $mes = 'Dez';
					?>
					[<?php echo $a;?>, ['<?php echo substr($e->MesExtenso($d->mes),0,3);?>']]<?php echo ($a != 0) ? ',' : '';?><?php }?>]
		}
		});
		
		
		$.plot("#GraficoCh", [{
			data: dCh,
			color: '#000',
			points: {show:true},
			lines: {show: true}
		}],
		{
		xaxis: {
			ticks: [
					<?php
					$mes = "";
					for($a = 12; $a >= 0; $a--){
					$d->setData('01/'.$e->mes.'/'.$e->ano,'BR',-(12-$a),2);
					if($d->mes == 01) $mes = 'Jan';
					elseif($d->mes == 02) $mes = 'Fev';
					elseif($d->mes == 03) $mes = 'Mar';
					elseif($d->mes == 04) $mes = 'Abr';
					elseif($d->mes == 05) $mes = 'Mai';
					elseif($d->mes == 06) $mes = 'Jun';
					elseif($d->mes == 07) $mes = 'Jul';
					elseif($d->mes == 08) $mes = 'Ago';
					elseif($d->mes == 09) $mes = 'Set';
					elseif($d->mes == 10) $mes = 'Out';
					elseif($d->mes == 11) $mes = 'Nov';
					elseif($d->mes == 12) $mes = 'Dez';
					?>
					[<?php echo $a;?>, ['<?php echo substr($e->MesExtenso($d->mes),0,3);?>']]<?php echo ($a != 0) ? ',' : '';?><?php }?>]
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
	//Grafico Chamados
	var canvas1  = $('#GraficoCh canvas');
	var img1 = $('#ImgGraficoCh');
	img1.attr('src',canvas1[0].toDataURL("image/png"));
	canvas1.hide();
	img1.show();
	
	//Grafico OS
	var canvas2  = $('#GraficoOS canvas');
	var img2 = $('#ImgGraficoOS');
	img2.attr('src',canvas2[0].toDataURL("image/png"));
	canvas2.hide();
	img2.show();
	
	//Grafico OS Clientes
	var canvas3  = $('#GraficoOSCl canvas');
	var img3 = $('#ImgGraficoOSCl');
	img3.attr('src',canvas3[0].toDataURL("image/png"));
	canvas3.parent().hide();
	img3.show();
	
	//Grafico OS Clientes
	var canvas4  = $('#GraficoOSTec canvas');
	var img4 = $('#ImgGraficoOSTec');
	img4.attr('src',canvas4[0].toDataURL("image/png"));
	canvas4.parent().hide();
	img4.show();
	
	
	$('#Imprimir').print();
	return false;	
}
</script>
<div id="Imprimir">

<!--<img class="prints" src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" width="180" height="60" />-->
<div class="sepCont"></div>
<h1>Estatísticas</h1>
<div class="sepCont"></div>

		
<div class="sepCont" style="margin-top:20px;"></div>
<h4>Chamados</h4>
<div id="GraficoCh" style="float:left; width:100%; height:200px;"></div>
<img src="" width="100%" height="200" style="float:left;margin-top:-200px; display:none;" id="ImgGraficoCh" />

<div class="sepCont" style="margin-top:20px;"></div>
<h4>Ordens de Serviço</h4>
<div id="GraficoOS" style="float:left; width:100%; height:200px;"></div>
<img src="" width="100%" height="200" style="float:left;margin-top:-200px; display:none;" id="ImgGraficoOS" />

<div class="sepCont"></div>
		<div class="fundoTabela">
        		<div class="topoTabela">
                		<div style="width:200px;">Mês</div>
                        <div style="width:173px;">Chamados</div>
                        <div style="width:200px;">Último Chamado</div>
                        <div style="width:173px;">O. Serviço</div>
                        <div style="width:200px;">Última O. Serviço</div>
                </div>
                <?php 
					$Os->TG['Ch'] = 0;
					$Os->TG['OS'] = 0;
					for($a = 12; $a > 0; $a--){
					$d->setData('01/'.$e->mes.'/'.$e->ano,'BR',-(12-$a),2);
					if(($Os->TotalCh($d->mes,$d->ano)) || ($Os->TotalOS($d->mes,$d->ano))){
						$Os->TG['Ch'] = $Os->TG['Ch'] + $Os->TotalCh($d->mes,$d->ano);
						$Os->TG['OS'] = $Os->TG['OS'] + $Os->TotalOS($d->mes,$d->ano);
						
							$d->SelectMes($d->mes,$d->ano);
							
							$UltCh = new tabChamado;
							$UltCh->SqlWhere = "Data BETWEEN '".$d->DIni."' AND '".$d->DFim."'";
							$UltCh->Limit = '1';
							$UltCh->SqlOrder = 'Data DESC';
							$UltCh->MontaSQL();
							$UltCh->Load();
							
							$UltOS = new tabChamado;
							$UltOS->SqlWhere = "DataOS BETWEEN '".$d->DIni."' AND '".$d->DFim."'";
							$UltOS->Limit = '1';
							$UltOS->SqlOrder = 'DataOS DESC';
							$UltOS->MontaSQL();
							$UltOS->Load();
							
					?>
                        <div class="linhasTabela">
                                <div style="width:200px;"><?php echo $e->MesExtenso($d->mes).'/'.$d->ano;?></div>
                                <div style="width:173px;"><?php echo $Os->TotalCh($d->mes,$d->ano);?></div>
                                <div style="width:200px;"><?php echo ($UltCh->Data != '') ? date('d/m/Y H:i:s',strtotime($UltCh->Data)) : '-';?></div>
                                <div style="width:173px;"><?php echo $Os->TotalOS($d->mes,$d->ano);?></div>
                                <div style="width:200px;"><?php echo ($UltOS->DataOS != '') ? date('d/m/Y H:i:s',strtotime($UltOS->DataOS)) : '-';?></div>
                        </div>
                <?php }}?>
                
        		<div class="topoTabela">
                		<div style="width:200px;">Totais</div>
                        <div style="width:173px;"><?php echo $Os->TG['Ch'];?></div>
                        <div style="width:200px;"></div>
                        <div style="width:173px;"><?php echo $Os->TG['OS'];?></div>
                        <div style="width:200px;"></div>
                </div>
        </div>

<?php
		$Cor = array();
		$Cor[0] = "#0098D4";
		$Cor[1] = "#03A697";
		$Cor[2] = "#D97501";
		$Cor[3] = "#EC0397";
		$Cor[4] = "#FFFC00";
		$Cor[5] = "#FF0000";
		$Cor[6] = "#1102D9";
		$Cor[7] = "#26FF0C";
		$Cor[8] = "#0CD9ED";
		$Cor[9] = "#7C0091";
		$Cor[10] = "#738566";

		$DataOSCl = '';

		$Us = new tabClientes;
		$Us->Query = "SELECT cl.*, (SELECT COUNT(*) FROM chamado WHERE IdCl = cl.ID AND DataOS != '0000-00-00') AS Total FROM clientes As cl WHERE (SELECT COUNT(*) FROM chamado WHERE IdCl = cl.ID AND DataOS != '0000-00-00') > 0 ORDER BY Total DESC";
		array_push($Us->Tabs,'Total');
		$Us->MontaSQLRelat();
		$Us->Load();
		$Us->TG['OS'] = 0;
		$Us->TG['Outros'] = 0;
		
		//echo '<p>'.$Us->Query.'</P>';
		
		$TotalOS = new tabChamado;
		$TotalOS->SqlWhere = "DataOS != '0000-00-00 00:00:00'";
		$TotalOS->MontaSQL();
		$TotalOS->Load();
		
		$FatorOS = 100 / $TotalOS->NumRows;
?>
<hr />
<div class="sepCont" style="margin-top:20px;"></div>
<h4>O. Serviço por Cliente</h4>
<div class="sepCont"></div>
		<div class="fundoTabela" style=" page-break-after:always;">
        		<div class="topoTabela">
                		<div style="width:50px;">#</div>
                        <div style="width:330px;">Cliente</div>
                        <div style="width:81px;">O.S.</div>
                        <div style="width:60px;">%</div>
                        <div style="width:50px;"></div>
           </div>
				  <img src="" width="375" height="330" style="float:right; display:none;" id="ImgGraficoOSCl" />
        		<div id="GraficoOSCl" style="width:375px; height:330px; float:right;"></div>
           
           <?php for($a=0;$a<$Us->NumRows;$a++):
           $DataOSCl = ($a < 10) ? ($DataOSCl.'{data:'.$Us->Total.',color:\''.$Cor[$a].'\'}'.(($a == ($Us->NumRows - 1)) ? "" : ",")) : $DataOSCl;
           if($a < 10) $Us->TG['OS'] = $Us->TG['OS'] + $Us->Total;
           else $Us->TG['Outros'] += $Us->Total;
		   
		   		$DataOSCl = (($a >= 10) && ($a == ($Us->NumRows -1)) && ($Us->TG['Outros'] > 0)) ? ($DataOSCl.'{data:'.$Us->TG['Outros'].',color:\''.$Cor[10].'\'}') : $DataOSCl;
           
           ?>     
           <div class="linhasTabela <?php echo ($Us->TG['Outros'] > 0) ? 'Ocultos' : ''?>" style="width:625px; <?php echo ($Us->TG['Outros'] > 0) ? 'display:none;' : ''?>">
                		<div style="width:50px;"><?php echo $a+1;?></div>
                        <div style="width:330px; text-align:left;"><?php echo $Us->Nome;?></div>
                        <div style="width:81px;"><?php echo $Us->Total;?></div>
                        <div style="width:60px;"><?php echo number_format(($Us->Total * $FatorOS),3,',','');?>%</div>
                        <div style="width:50px;"><div style="width:10px; height:20px;margin:5px 15px; background-color:<?php echo ($a < 11) ? $Cor[$a] : $Cor[10];?> "></div></div>
           </div>
           <?php $Us->Next(); endfor;;?>
           <?php if($Us->TG['Outros'] > 0):?>
           <div class="linhasTabela Outros" style="width:625px;">
                		<div style="width:50px;"></div>
                        <div style="width:330px; text-align:left;">Outros</div>
                        <div style="width:81px;"><?php echo $Us->TG['Outros'];?></div>
                        <div style="width:60px;"><?php echo number_format(($Us->TG['Outros'] * $FatorOS),3,',','');?>%</div>
                        <div style="width:50px;"><div style="width:10px; height:20px;margin:5px 15px; background-color:<?php echo $Cor[10];?>"></div></div>
           </div>
           <?php endif;?>
        		<div class="topoTabela">
                		<div style="width:50px;"></div>
                        <div style="width:330px;"></div>
                        <div style="width:81px;"></div>
                        <div style="width:60px;"></div>
                        <?php if($Us->TG['Outros'] > 0):?><div style="width:425px; cursor:pointer" class="TxtOSCl" onclick="MostraOSCl();">Mostrar lista completa</div><?php endif;?>
                </div>
        </div>
<input type="hidden" id="OSCl" value="1" />
<script>
		$(function(){
				$.plot("#GraficoOSCl",[<?php echo $DataOSCl;?>],{
					series:{
						pie: {
								show:true,
								radius: 3.7/4,
								startAngle:2
							}
					}
				});
		});
</script>


<?php

		$DataOSTec = '';

		$Tec = new tabAdmm;
		$Tec->Query = "SELECT adm.*, (SELECT COUNT(*) FROM chamado WHERE IDTecnico = adm.ID AND DataOS != '0000-00-00') AS Total FROM admm As adm WHERE (SELECT COUNT(*) FROM chamado WHERE IDTecnico = adm.ID AND DataOS != '0000-00-00') > 0 ORDER BY Total DESC";
		array_push($Tec->Tabs,'Total');
		$Tec->MontaSQLRelat();
		$Tec->Load();
		$Tec->TG['OS'] = 0;
		$Tec->TG['Outros'] = 0;
		
		//echo '<p class="left">'.$Us->Query.'</P>';
?>

<div class="sepCont" style="margin-top:20px;"></div>
<h4>O. Serviço por Técnico</h4>
<div class="sepCont"></div>

		<div class="fundoTabela">
        		<div class="topoTabela">
                		<div style="width:50px;">#</div>
                        <div style="width:330px;">Cliente</div>
                        <div style="width:81px;">O.S.</div>
                        <div style="width:60px;">%</div>
                        <div style="width:50px;"></div>
                </div>
					<img src="" width="375" height="330" style="float:right; display:none;" id="ImgGraficoOSTec" />
        		<div id="GraficoOSTec" style="width:375px; height:330px; float:right;"></div>
        		
        		<?php for($a=0;$a<$Tec->NumRows;$a++):
           $DataOSTec = ($a < 10) ? ($DataOSTec.'{data:'.$Tec->Total.',color:\''.$Cor[$a].'\'}'.(($a == ($Tec->NumRows - 1)) ? "" : ",")) : $DataOSTec;
           if($a < 10) $Tec->TG['OS'] = $Tec->TG['OS'] + $Tec->Total;
           else $Tec->TG['Outros'] += $Tec->Total;
		   
		   		$DataOSTec = (($a >= 10) && ($a == ($Tec->NumRows -1)) && ($Tec->TG['Outros'] > 0)) ? ($DataOSTec.'{data:'.$Tec->TG['Outros'].',color:\''.$Cor[10].'\'}') : $DataOSTec;
           
           ?>   
           <div class="linhasTabela <?php echo ($Tec->TG['Outros'] > 0) ? 'OcultosTec' : ''?>" style="width:625px; <?php echo ($Tec->TG['Outros'] > 0) ? 'display:none;' : ''?>">
                		<div style="width:50px;"><?php echo $a+1;?></div>
                        <div style="width:330px; text-align:left;"><?php echo $Tec->Nome;?></div>
                        <div style="width:81px;"><?php echo $Tec->Total;?></div>
                        <div style="width:60px;"><?php echo number_format(($Tec->Total * $FatorOS),3,',','');?>%</div>
                        <div style="width:50px;"><div style="width:10px; height:20px;margin:5px 15px; background-color:<?php echo ($a < 11) ? $Cor[$a] : $Cor[10];?> "></div></div>
           </div>
           <?php $Tec->Next(); endfor;;?>
           <?php if($Tec->TG['Outros'] > 0):?>
           <div class="linhasTabela OutrosTec" style="width:625px;">
                		<div style="width:50px;"></div>
                        <div style="width:330px; text-align:left;">Outros</div>
                        <div style="width:81px;"><?php echo $Tec->TG['Outros'];?></div>
                        <div style="width:60px;"><?php echo number_format(($Tec->TG['Outros'] * $FatorOS),3,',','');?>%</div>
                        <div style="width:50px;"><div style="width:10px; height:20px;margin:5px 15px; background-color:<?php echo $Cor[10];?>"></div></div>
           </div>
           <?php endif;?>
        		<div class="topoTabela">
 	     				<div style="width:50px;"></div>
                        <div style="width:330px;"></div>
                        <div style="width:81px;"></div>
                        <div style="width:60px;"></div>
                        <?php if($Tec->TG['Outros'] > 0):?><div style="width:425px; cursor:pointer" class="TxtOSTec" onclick="MostraOSTec();">Mostrar lista completa</div><?php endif;?>
                </div>
</div>
</div>
<input type="hidden" id="OSTec" value="1" />
<script>
		$(function(){
				$.plot("#GraficoOSTec",[<?php echo $DataOSTec;?>],{
					series:{
						pie: {
								show:true,
								radius: 3.7/4,
								startAngle:2
							}
					}
				});
		});
</script>

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
.prints{ display:none;}
h4{
	border: none;
}
td{
	border-bottom:1px solid #000;
}
</style>

<script>
function MostraOSCl(){
		if($('#OSCl').val() == 1){
				$('#OSCl').val('0');
				$('.Outros').hide();
				$('.Ocultos').show();
				$('.TxtOSCl').html('Mostrar lista resumida');
		}else{
				$('#OSCl').val('1');
				$('.Outros').show();
				$('.Ocultos').hide();
				$('.TxtOSCl').html('Mostrar lista completa');
		}
}

function MostraOSTec(){
		if($('#OSTec').val() == 1){
				$('#OSTec').val('0');
				$('.OutrosTec').hide();
				$('.OcultosTec').show();
				$('.TxtOSTec').html('Mostrar lista resumida');
		}else{
				$('#OSTec').val('1');
				$('.OutrosTec').show();
				$('.OcultosTec').hide();
				$('.TxtOSTec').html('Mostrar lista completa');
		}
}
</script>