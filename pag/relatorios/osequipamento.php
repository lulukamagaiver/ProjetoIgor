<?php
		$S->PrAcess(26); //Visualizar Relatorios de OS
		
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabequipamento.php');
		require_once('lib/tabs/tabmateriaischamado.php');
		require_once('lib/tabs/tabconfiguracoes.php');
		include_once('lib/tabs/tabcomentariochamado.php');
		require_once('lib/search.php');
		require_once('lib/relatorios.php');
		
		if(!empty($_POST['FechaOS'])){
				if((!empty($_POST['OS'])) && (is_array($_POST['OS']))){
						foreach($_POST['OS'] as $key => $val){
								$Os = new tabChamado;
								$Os->FechaOS($_POST['OS'][$key]);
								$CmC = new tabComentarioChamado;
								$CmC->AddComentario('O.S. #'.$URL->COD($url[1]).' foi fechada por: '.$S->Apelido,$_POST['OS'][$key],0);
						}
				}
		}
		
		if((empty($_POST['Mes'])) || (empty($_POST['Mes']))){
				$_POST['Mes'] = date('m');
				$_POST['Ano'] = date('Y');
		}
		$DFim = "";
		$DIni = "01/".$_POST['Mes']."/".$_POST['Ano'];
		$d->setData($DIni,'BR',1,2);
		$d->setData($d->data,'BR',(-1),1);
		$DFim = $d->data;
		//echo $DIni." |-| ".$DFim;
		
		$Cf = new tabConfiguracoes;
		
		$UsT = new tabAdmm($S->ID);
		
		$Cl = new tabClientes;
		$Cl->SqlWhere = $UsT->Clientes();
		$Cl->MontaSQL();
		$Cl->Load();
		
		$B = new Search;
		$B->Periodo('DataOS',$DIni,$DFim);
		$B->Igual('IdCl',((!empty($_POST['Cliente'])) ? $_POST['Cliente'] : ""));
		$B->Igual('StatusOS',((!empty($_POST['Status'])) ? $_POST['Status'] : ""));
		$B->Igual('Status','14');
		
		$C = new Search;
		$C->Igual('IdCl',((!empty($_POST['Cliente'])) ? $_POST['Cliente'] : ""));
		
?>

<h1>Relatório de O.S. por Equipamento/Produto:</h1>

<form method="post">
		<div class="inputs">
        		Cliente:<br />
        		<select name="Cliente" id="Cliente">
                		<?php
						for($a=0;$a<$Cl->NumRows;$a++){
								?>
                                <option value="<?php echo $Cl->ID;?>"><?php echo $Cl->Nome;?></option>
                                <?php
						$Cl->Next();
						}
						?>
                </select>
        </div>
        
        <div class="inputsMeio">
        		Mês:<br />
                <select name="Mes" id="Mes">
                		<option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
        		</select>
        </div>
                
        <div class="inputsMeio">
        		Ano:<br />
                <select name="Ano" id="Ano">
                		<option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
        		</select>
        </div>
        
		<div class="inputsMeio">
        		Status:<br />
        		<select name="Status" id="Status">
                		<option value="1">Aberta</option>
                        <option value="2">Fechada</option>
                </select>
        </div>
        
<input name="Envia" value="ok" type="image" style="width:30px; height:30px; float:left; margin-left:0px;" src="imgs/icones/search.png" />
<div class="sepCont" style="height:20px;"></div> 

<div id="Imprimir">
<script>
		<?php if(!empty($_POST['Cliente'])) :?>$('#Cliente').val('<?php echo $_POST['Cliente'];?>');<?php endif;?>
		<?php if(!empty($_POST['Status'])) :?>$('#Status').val('<?php echo $_POST['Status'];?>');<?php endif;?>
		<?php if(!empty($_POST['Mes'])) :?>$('#Mes').val('<?php echo $_POST['Mes'];?>');<?php endif;?>
		<?php if(!empty($_POST['Ano'])) :?>$('#Ano').val('<?php echo $_POST['Ano'];?>');<?php endif;?>
</script>

<?php
		if((!empty($_POST['Envia'])) || (!empty($_POST['FechaOS']))|| (!empty($_POST['Envia_x']))){	

				$Os = new tabChamado;
				$Os->SqlWhere = $B->Where;
				$Os->MontaSQL();
				$Os->Load();
				$Os->TG['TOnline'] = 0;
				$Os->TG['THOnline'] = 0;
				$Os->TG['TOffline'] = 0;
				$Os->TG['THOffline'] = 0;
				$Os->TG['TOSValor'] = 0;
				$Os->TG['TValor'] = 0;
				$Os->TG['TMat'] = 0;
				$Os->TG['TValorMat'] = 0;
				
				
				$Tc = new tabAdmm($Os->IDTecnico);
				$Cl2 = new tabClientes($Os->IdCl);
				
				$Eq = new tabEquipamento;
				$Eq->Tabs = array('Equipamento','QNT','ID');
				$Eq->Query = "SELECT eq.*, (SELECT COUNT(*) FROM chamado AS os WHERE os.IDEquipamento = eq.ID AND ".$B->Where.") AS QNT 
				FROM equipamento AS eq 
				WHERE ".$C->Where." AND (SELECT COUNT(*) FROM chamado AS os WHERE os.IDEquipamento = eq.ID AND ".$B->Where.") > 0 ORDER BY QNT DESC;";
				$Eq->MontaSQLRelat();
				$Eq->Load();
				$Eq->TG['Tempo'] = 0;
				$Eq->TG['Valor'] = 0;
				$Eq->TG['Mat'] = 0;
				
				$d->setData();
		
				$a = array();
				$a[0] = "width: 100px; text-align: center;";
				$a[1] = "width: 204px; text-align: left;";
				$a[2] = "width: 80px; text-align: center;";
				$a[6] = "width: 80px; text-align: center;";
				$a[7] = "width: 80px; text-align: center;";
				$a[3] = "width: 80px; text-align: center;";
				$a[4] = "width: 300px; text-align: left;";
				$a[5] = "width: 69px; text-align: center;";
				?>
				<div class="fundoTabela">
						<div class="topoTabela">
								<div style=" <?php echo $a[0];?>">% (QNT)</div>
								<div style=" <?php echo $a[1];?>">Equipamento/Produto</div>
								<div style=" <?php echo $a[2];?>">Tempo</div>
                                <div style=" <?php echo $a[6];?>">Valor</div>
                                <div style=" <?php echo $a[7];?>">Mat./Serv.</div>
								<div style=" <?php echo $a[3];?>">Total</div>
								<div style=" <?php echo $a[4];?>">O.S.</div>
						</div>                
						<?php if($Os->NumRows == 0){?><div class="linhasTabela"><div style="width:100%; text-align:center;">Nenhum resultado encontrado.</div></div><?php }?>
						
						
                        <?php for($c=0;$c<$Eq->NumRows;$c++) :
								
								//Gera os totais de tempo, valor
								$EqT = new DBConex;
								$EqT->Query = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( TempoOS ) ) ) AS Tempo, SUM(ValorCob) AS Valor FROM chamado WHERE IDEquipamento = '".$Eq->ID."' AND ".$B->Where."";
								$EqT->Tabs = array('Tempo','Valor');
								$EqT->MontaSQLRelat();
								$EqT->Load();
								
								//Define o total de materiais para determinado Equipamento
								$OsEq = new tabChamado;
								$OsEq->SqlWhere = "IDEquipamento = '".$Eq->ID."' AND ".$B->Where;
								$OsEq->MontaSQL();
								$OsEq->Load();
								$OsEq->TG['Mat'] = 0;
								$OsEq->TG['Os'] = "";
								
								for($aa=0;$aa<$OsEq->NumRows;$aa++){
										$TMatEq = new tabMateriaisChamado;
										$OsEq->TG['Mat'] = $OsEq->TG['Mat'] + $TMatEq->MAX($OsEq->ID);
										$OsEq->TG['Os'] = $OsEq->TG['Os'].",".$OsEq->ID;
								$OsEq->Next();
								}
						
						?>        
						<div class="linhasTabela">
								<div style=" <?php echo $a[0];?>">
										<?php $TOs = (100 / $Os->NumRows) * $Eq->QNT;?>
                                        <p class="porcentoEq" style="width:<?php echo floor($TOs);?>px;"></p>
                                        <?php echo number_format($TOs,2,',','');?>% (<?php echo $Eq->QNT;?>)
                                </div>
								<div style=" <?php echo $a[1];?>"><?php echo $Eq->Equipamento;?></div>
								<div style=" <?php echo $a[2];?>"><?php echo ((!empty($EqT->Tempo)) && ($EqT->Tempo != '00:00:00')) ? $EqT->Tempo : "-";?></div>
                                <div style=" <?php echo $a[6];?>"><?php echo ((!empty($EqT->Valor)) && ($EqT->Valor > 0)) ? "R$ ".number_format($EqT->Valor,2,',','') : "-";?></div>
                                <div style=" <?php echo $a[7];?>"><?php echo (!empty($OsEq->TG['Mat'])) ? "R$ ".number_format($OsEq->TG['Mat'],2,',','') : "-";?></div>
								<div style=" <?php echo $a[3];?>"><?php echo "R$ ".number_format(($OsEq->TG['Mat'] + $EqT->Valor),2,',','');?></div>
								<div style=" <?php echo $a[4];?>">
								<?php 
								$exp = explode(",",$OsEq->TG['Os']);
								unset($exp[0]);
								foreach($exp as $key => $val){
										echo '<a href="'.$URL->siteURL.'os/visualizar/'.$val.'/" target="_blank">'.$URL->COD($val)."</a> ";
								}
								?>
                                </div>
						</div>                
                        <?php $Eq->Next(); endfor;?>
<!--                                <?php for($b=0;$b<$Os->NumRows;$b++){
                                        $Mt = new tabMateriaisChamado;
                                        $Mt->SqlWhere = "IDChamado = '".$Os->ID."'";
                                        $Mt->MontaSQL();
                                        $Mt->Load();
                                ?>
                                <div class="linhasTabela">
                                        <div class="haha" style=" <?php echo $a[0];?>">
                                        <p class="porcentoEq" style="width:60px;"></p>60% (2)
                                        </div>
                                        <div style=" <?php echo $a[1];?>"><?php echo date("d/m/Y",strtotime($Os->DataOS));?></div>
                                        <div style=" <?php echo $a[2];?>"><?php echo $Tc->Apelido;?></div>
                                        <div style=" <?php echo $a[6];?><?php echo ($Os->TipoCob == 3) ? "color:#AAA;" : "";?>">
                                        <?php
                                                if(($Os->TipoCob < 3) && ($Os->TipoOS == 1)){
                                                        $Os->TG['TOnline']++;
                                                        $Os->TG['THOnline'] = $Os->TG['THOnline'] + $URL->t2d($Os->TempoOS);
                                                }
                                                if(($Os->TipoCob < 3) && ($Os->TipoOS != 1)){
                                                        $Os->TG['TOffline']++;
                                                        $Os->TG['THOffline'] = $Os->TG['THOnline'] + $URL->t2d($Os->TempoOS);
                                                }
                                                if($Os->TipoCob == 3){
                                                        $Os->TG['TOSValor']++;
                                                        $Os->TG['TValor'] = $Os->TG['TValor'] + $Os->ValorCob;
                                                }
                                        ?>
                                        <input type="checkbox" disabled <?php echo (($Os->TipoCob != 3) && ($Os->TipoOS == 1)) ? "checked" : "";?> /> On-Line
                                        
                                        </div>
                                        <!--VALOR OU TEMPO DA OS
                                        <div style=" <?php echo $a[7];?>">
                                                <?php 
                                                if(($Os->TipoCob < 3) && ($Cl2->Contrato == 1)){
                                                        if($Cl2->Contrato == 1) echo $Os->TempoOS;
                                                }else{
                                                        if($Cl2->Contrato == 1) echo "R$ ".number_format($Os->ValorCob,1,',','');
                                                        elseif($Os->TipoCob < 3){
                                                             echo "R$ ".number_format(($URL->t2d($Os->TempoOS,2)*$Cl2->VHora),2,',','')." (".$Os->TempoOS.")";
                                                        }
                                                        else echo "R$ ".number_format($Os->ValorCob,2,',','');
                                                }
                                                ?>
                                        </div>
                                        <div style=" <?php echo $a[3];?>"><?php echo ($Os->Confirmada == 1) ? "Sim" : "Não";?></div>
                                        <div style=" <?php echo $a[4];?>"><?php
                                        if($Mt->NumRows > 0){
                                                $Os->TG['TMat']++;
                                                $Os->TG['TValorMat'] = $Os->TG['TValorMat'] + $Mt->MAX($Os->ID); 
                                                echo "SIM";
                                        }else echo "NÃO";
                                        ?></div>
                                </div>
                                <?php $Os->Next(); }?>-->
                        
                        
						
						<div class="topoTabela">
								<div style="width:100%; text-align:center;"></div>
						</div>
				</div>
                
</form>
                
                <div class="sepCont"></div>
                
                <p class="left">
                Cliente: <strong><?php echo $Cl2->Nome;?></strong><br /><br />
                <?php if($Cl2->Contrato == 1) :?>
                Valor do Contrato: <strong>R$ <?php echo number_format($Cl2->VContrato,2,',','');?></strong><br />
                HorasContratadas: <strong><?php echo $Cl2->QNTHoras;?></strong><br />
                <?php endif;?>
                Valor Hora Excedente: <strong>R$ <?php echo number_format($Cl2->VHora,2,',','');?></strong><br />
                </p>
                
                <div class="sepCont"></div>
                
                
                
                <!-----------------------------------------------RELATORIO DETALHADO --------------------------------------------->
                
                <div class="sepCol3">
                		<strong>ON-LINE</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOnline'];?></strong><br />
                        Total de Horas: <strong><?php echo $URL->d2t($Os->TG['THOnline']);?></strong><br />
                        <?php 
						if((!empty($Cl2->Desconto)) && ($Cl2->Desconto != 0)){
								$THOnline = ((100 - $Cl2->Desconto) / 100) * $Os->TG['THOnline'];
								$Desc = $Cl2->Desconto;
						}else{
								$THOnline = ((100 - $Cf->OSOnLine) / 100) * $Os->TG['THOnline'];
								$Desc = $Cf->OSOnLine;
						}
						?>
                        Total de horas (<?php echo 100 - $Desc;?>%): <strong><?php echo $URL->d2t($THOnline)?></strong>
                </div>
                                
                <div class="sepCol3">
                		<strong>OFF-LINE</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOffline'];?></strong><br />
                        Total de Horas: <strong><?php echo $URL->d2t($Os->TG['THOffline']);?></strong><br />
                </div>
                                
                <div class="sepCol3">
                		<strong>GERAL</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOffline'] + $Os->TG['TOnline'];?></strong><br />
                        Total de Horas: <strong><?php echo $URL->d2t($Os->TG['THOffline'] + $THOnline);?></strong><br />
                        Horas Restantes: <strong>
						<?php 
						$TRes = (($URL->t2d($Cl2->QNTHoras)) - ($Os->TG['THOffline'] + $THOnline));
						echo ($TRes > 0) ? $URL->d2t($TRes) : "00:00:00";
						?>
                        </strong><br />
                        Horas Excedentes: <strong><?php if($TRes < 0) echo $URL->d2t($TRes * (-1)); else echo "00:00:00";?></strong><br />
                        Valor Excedente: <strong>R$ <?php
						if($TRes < 0) $VExc = (($TRes * $Cl2->VHora) * (-1));
						else $VExc = 0;
						if($TRes < 0) echo number_format($VExc,2,',',''); else echo "0,00";?></strong>

                </div>
                
                <div class="sepCont"></div>
                                
                <div class="sepCol3">
                		<strong>VALOR</strong><br />
                        Quantidade: <strong><?php echo $Os->TG['TOSValor'];?></strong><br />
                        Valor: <strong>R$ <?php echo number_format($Os->TG['TValor'],2,',','');?></strong>
                </div>
                
                <?php if($Os->TG['TMat'] > 0) :?>             
                <div class="sepCol3">
                		<strong>MATERIAIS/SERVIÇOS</strong><br />
                        Valor Total: <strong><?php echo number_format($Os->TG['TValorMat'],2,',','');?></strong>
                </div>
                <?php endif;?>
                
                <div class="sepCont"></div>
                
                <div class="sepCol3">
                		<br /><br />
                		<strong>Valor Total: <font color="#FF0000"><?php echo number_format(($VExc + $Cl2->VContrato + $Os->TG['TValor'] + $Os->TG['TValorMat']),2,',','');?></font></strong>
                </div>
<style>
.porcentoEq{
	height:20px;
	background-color:rgba(255,0,0,.4);
	position:absolute;
	margin-top:5px;
}
</style>
                
<?php
                }
?>
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

<?php //include_once($URL->siteURL."css/estilo.css");?>

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