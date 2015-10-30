<?php
		$S->PrAcess(22);
		
		require_once('lib/tabs/tabconfiguracoes.php');
		require_once('lib/tabs/tabchamado.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/tabs/tabequipamento.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabmateriaischamado.php');
		
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				$Cf = new tabConfiguracoes;
				$Os = new tabChamado($url[0]);
				$Cl = new tabClientes($Os->IdCl);
				$Eq = new tabEquipamento($Os->IDEquipamento);
				$Us = new tabAdmm($Os->IDTecnico);
				$TMat = new tabMateriaisChamado;
				$TMat->SqlWhere = "IDChamado = '".$Os->ID."'";
				$TMat->MontaSQL();
				$TMat->Load();
				
?>

<link rel="stylesheet" type="text/css" href="<?php echo $URL->siteURL;?>css/refin.css">
  <style type="text/css" media="print">
  	.ajustes { display: none; }
  </style>
  <style type="text/css" media="all">
  	.trcomentarios { display: none; }
	<?php  include($URL->siteURL.'css/refin.css');?>
  </style>
<script type="text/javascript">
$(document).ready(function() {
		$("#DefAjustes").change(function() {
				if($(this).val() == 1) {
				$(".trTotal").show();
				} else {
				$(".trTotal").hide();
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
</script>
<div id="Imprimir" style="float:left;">
<table>
        <thead>
                <tr>
                		<th><img id="Logo" src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" height="60"></th>

                        <th colspan="3" class="topoos">
                        <span class="strong"><?php echo $Cf->NomeFantasia;?></span><br />
                        <br />
                        <?php echo $Cf->End;?><br />
                        TEL: <?php echo $Cf->Tel1;?><?php echo (!empty($Cf->Tel2)) ? " | ".$Cf->Tel2 : "";?>
                        </th>
                </tr>
                
                <tr>
                		<th colspan="4"><hr></th>
                </tr>
                
                <tr>
                        <th colspan="4" class="titos">
                        <span class="espos">ORDEM DE SERVIÇO #<?php echo $URL->COD($Os->ID);?></span><input type="checkbox" <?php echo (($Os->TipoOS == 1) && ($Cl->Contrato == 1)) ? "checked" : "";?> disabled> ON-LINE
                        </th>
                </tr>
                
                <tr>
                		<th colspan="4"><hr></th>
                </tr>
        </thead>

        <tbody>
                <tr>
                        <th colspan="4" class="esq">
                        <span class="strong">CLIENTE:</span> <?php echo $Cl->Nome;?><br />
                        <span class="strong2"><?php echo ($Cl->Contrato == 1) ? "(COM CONTRATO)" : ""; ?></span>
                        </th>
                </tr>
        
                <tr>
                        <th colspan="4" class="esq">
                        <span class="strong">ENDEREÇO:</span> <?php echo $Cl->Endereco;?>	  </th>
                </tr>

                <tr>
                        <th colspan="4" class="esq">
                        <span class="strong">TELEFONE:</span> <?php echo $Cl->Tel;?>	  </th>
                </tr>

                <tr>
                        <th colspan="4" class="esq">
                        <span class="strong">RESPONSÁVEL:</span> <?php echo $Os->Contato1;?>
                        </th>
                </tr>

                <tr>
                		<th colspan="4"><hr></th>
                </tr>

                <tr>
		                <th colspan="2" class="esq"><span class="strong">EQUIP. / PRODUTO: </span><?php echo $Eq->Equipamento;?></th>
        		        <th colspan="2" class="esqtam"><span class="strong">DATA: </span><?php echo date('d/m/Y',strtotime($Os->DataOS));?></th>
                </tr>

                <tr>
                        <th colspan="2" class="esq"><span class="strong">TÉCNICO: </span><?php echo ($Os->IDTecnico != 0) ? $Us->Apelido : "Todos"; ?></th>
                        <?php
								$V = 0;
						?>
                        <?php if(($Os->TipoCob < 3) && ($Cl->Contrato == 1) && ($Os->TipoOS == 1)) :?>
                        		<th colspan="2" class="esqtam"><span class="strong">DURAÇÃO: </span><?php echo (!empty($Os->TempoOS)) ? $Os->TempoOS : "00:00:00";?></th>
                        <?php else :
								if($Cl->Contrato == 1) {
										if($Os->TipoOS == 1){
										$V = $Os->ValorCob;?>
												<th colspan="2" class="esqtam trTotal"><span class="strong">MÃO-DE-OBRA: </span>R$ <?php echo (!empty($Os->ValorCob)) ? number_format($Os->ValorCob,2,',','') : "0,00";?></th>
                                        <?php }else{      
										$V = $URL->t2d($Os->TempoOS,2)*$Cl->VHora;?>
												<th colspan="2" class="esqtam trTotal"><span class="strong">MÃO-DE-OBRA: </span>R$ <?php echo  number_format($V,2,',','')." (".$Os->TempoOS.")";?></th>
                                        <?php }?>
                                <?php }elseif($Os->TipoCob < 3){
								$V = $URL->t2d($Os->TempoOS,2)*$Cl->VHora;	?>
                                		<th colspan="2" class="esqtam trTotal"><span class="strong">MÃO-DE-OBRA: </span>R$ <?php echo (!empty($V)) ? number_format($V,2,',','') : "0,00";?></th>
                                <?php }else{
								$V = $Os->ValorCob;?>
                                		<th colspan="2" class="esqtam trTotal"><span class="strong">MÃO-DE-OBRA: </span>R$ <?php echo (!empty($V)) ? number_format($V,2,',','') : "0,00";?></th>
                                <?php }?>
                        <?php endif;?>
                </tr>
                
                <?php if($TMat->MAX($Os->ID) > 0) :?>
                <tr>
                		<th colspan="2" class="esq"><span class="strong">MATERIAIS/SERVIÇOS: </span>R$ <?php echo number_format($TMat->MAX($Os->ID),2,',','.');?></th>
                        <th colspan="2" class="esqtam trTotal"><span class="strong">TOTAL: </span>R$ <?php echo number_format($TMat->MAX($Os->ID) + $V,2,',','.');?></th>
                </tr>

                <tr>
		                <th colspan="4"><hr></th>
                </tr>
                
                        <tr>
                        <th colspan="4" class="desc" style="text-align: center;"><span class="strong">MATERIAIS/SERVIÇOS</span></th>
                        </tr>
                        
                        <tr>
                        <th style="text-align: center;"><span class="strong">DESCRIÇÃO</span></th>
                        <th style="text-align: right;"><span class="strong">VALOR</span></th>
                        <th style="text-align: right;"><span class="strong">QTDE</span></th>
                        <th style="text-align: right; width: 134px;"><span class="strong">TOTAL</span></th>
                        </tr>
                        
                        <tr height="2">
                        <td colspan="4" style="background:url(<?php echo $URL->siteURL;?>imgs/icones/bg_linha_td.gif) repeat-x;"></td>
                        </tr>
                        <?php for($a=0;$a<$TMat->NumRows;$a++) :?>
                        <tr>
                        <td><?php echo $TMat->Descricao;?></td>
                        <td style="text-align: right;">R$ <?php echo number_format($TMat->Valor,2,',','.');?></td>
                        <td style="text-align: right;"><?php echo $TMat->QNT;?></td>
                        <td style="text-align: right;">R$ <?php echo $TMat->VTotal;?></td>
                        </tr>
                        
                        <tr height="2">
                        <td colspan="4" style="background:url(<?php echo $URL->siteURL;?>imgs/icones/bg_linha_td.gif) repeat-x;"></td>
                        </tr>
                        <?php $TMat->Next(); endfor;?>
                        
                        <tr>
                        <td colspan="3"><span class="strong">TOTAL:</span></td>
                        <td style="text-align: right;"><span class="strong">R$ <?php echo number_format($TMat->MAX($Os->ID),2,',','.');?></span></td>
                        </tr>
                <?php endif;?>
                
                <tr>
                <th colspan="4"><hr></th>
                </tr>

                <tr>
		                <th colspan="4" class="desc" style="text-align: center;"><span class="strong">DESCRIÇÃO DOS SERVIÇOS</span></th>
                </tr>

                <tr>
		                <th colspan="4" class="esq" style="text-align: justify;"><?php echo $Os->DescricaoOS;?><br /><br /><br /><br /><br /><br /><br /></th>
                </tr>

                <tr>
		                <td class="assinatura">__________________________________<br /><?php echo $S->Nome;?></td>
                        <td></td>
                        <td colspan="2" class="assinatura">__________________________________<br /><?php echo $Cl->Nome;?></td>
                </tr>	

                <tr>
		                <th colspan="4"><hr></th>
                </tr>

                <tr>
                        <th colspan="4" style="text-align: justify; font-size: 10px;">
                        <strong>Observações importantes:</strong>
                        <br /><br />
                        <?php echo $Cf->ObsOS;?>	
                        </th>
                </tr>

                <tr>
                        <th colspan="4" class="obs" style="text-align: center; font-size: 10px;">
                        <?php
						$Desc = (!empty($Cl->Desconto)) ? (100 - $Cl->Desconto) : (100 - $Cf->OSOnLine);
						?>
                        <?php if($Cl->Contrato == 1) :?>Em caso de O.S. do tipo ON-LINE, será cobrado <?php echo $Desc;?>% do tempo real utilizado.<?php endif;?>
                        </th>
				</tr>
	  </tbody>
</table>
</div>
<div class="inputsMeio" style="margin-top:10px;">
	Total O.S.:<br />
	<select id="DefAjustes">
            <option value="1">Sim</option>
    		<option value="2">Não</option>
    </select>
</div>
<div class="btnAct" onClick="get64($('#Logo')); $('#Imprimir').print(); return false;"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div>
<?php
		}else echo "<h1>Nenhuma O.S. Selecionada para ser impressa.</h1>";
?>