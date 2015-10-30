<?php
		$S->PrAcess('');
		
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
	<?php include($URL->siteURL.'css/refin.css');?>
  </style>
<script type="text/javascript">
$(document).ready(function() {
$(".trcomentarios").hide();
		$("#DefAjustes").change(function() {
				if($(this).val() == 1) {
				$(".trcomentarios").show();
				} else {
				$(".trcomentarios").hide();
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
                        CHAMADO #<?php echo $URL->COD($Os->ID);?>
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
        		        <th colspan="2" class="esqtam"><span class="strong">DATA: </span><?php echo date('d/m/Y',strtotime($Os->Data));?></th>
                </tr>

                <tr>
                        <th colspan="2" class="esq"><span class="strong">TÉCNICO: </span><?php echo ($Os->IDTecnico != 0) ? $Us->Apelido : "Todos"; ?></th>
                </tr>
                
                <tr>
                <th colspan="4"><hr></th>
                </tr>

                <tr>
		                <th colspan="4" class="desc" style="text-align: center;"><span class="strong">DESCRIÇÃO DO CHAMADO</span></th>
                </tr>

                <tr>
		                <th colspan="4" class="esq" style="text-align: justify;"><?php echo $Os->Descricao;?><br /><br /><br /><br /><br /><br /><br /></th>
                </tr>

                <tr style="text-align:center;">
		                <td class="assinatura">__________________________________<br /><?php echo $S->Nome;?></td>
                        <td></td>
                        <td colspan="2" class="assinatura">__________________________________<br /><?php echo $Cl->Nome;?></td>
                </tr>	

                <tr class="trcomentarios" style="display: table-row;">
                		<th colspan="3"><hr></th>
                </tr>
                
                <tr class="trcomentarios" style="display: table-row;">
                		<th colspan="3" class="desc" style="text-align:center;"><span class="strong">INTERAÇÕES</span></th>
                </tr>

		<?php
                $Cm = new DBConex;
                $Cm->Tabs = array('ID','Autor','Data','Comentario');
                $Cm->Query = "SELECT * FROM comentariochamado WHERE IdCh = '".$Os->ID."'";
                $Cm->MontaSQLRelat();
                $Cm->Load();
        
                for($b=0;$b<$Cm->NumRows;$b++){
						$Us2 = new tabAdmm($Cm->Autor);
        ?>

                <tr height="2" class="trcomentarios" style="display: table-row;">
                <td colspan="4" style="background:url(<?php echo $URL->siteURL;?>imgs/icones/bg_linha_td.gif) repeat-x;"></td>
                </tr>
                
                <tr class="trcomentarios" style="display: table-row;">
                <th style="color: #969696; text-align:center;"><?php echo ($Cm->Autor != 0) ? $Us2->Apelido : "SISTEMA";?><br /><?php echo date('d/m/Y às H:i:s',strtotime($Cm->Data));?></th>
                <th style="color: #969696" colspan="2" class="esq">
                <?php echo nl2br($Cm->Comentario);?>
                </th>
		<?php
				$Cm->Next();
				}
		?>
	  </tbody>
</table>
</div>
<div class="inputsMeio" style="margin-top:10px;">
	Interações:<br />
	<select id="DefAjustes">
    		<option value="2">Não</option>
            <option value="1">Sim</option>
    </select>
</div>
<div class="btnAct" onClick="get64($('#Logo')); $('#Imprimir').print(); return false;"><img src="<?php echo $URL->siteURL;?>imgs/icones/print.png" /> Imprimir</div>
<?php
		}else echo "<h1>Nenhuma O.S. Selecionada para ser impressa.</h1>";
?>