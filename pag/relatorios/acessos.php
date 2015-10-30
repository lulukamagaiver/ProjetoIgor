<?php
		$S->PrAcess(74); //Visualizar Relatorios de Acessos
        require_once('lib/tabs/tablogincliente.php');
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabacessos.php');
		require_once('lib/search.php');
		
		if($_POST['TipoUser'] == 1){
			$IDUser = $_POST['IDTecnicos'];
			$Us = new tabAdmm($IDUser);
		}elseif($_POST['TipoUser'] == 2){
			$IDUser = $_POST['IDClientes'];
			$Us = new tabAdmm($IDUser);
		}
		
		$B = new Search;
		$B->Igual('IDUser',$IDUser);
		$B->Igual('StatusUser',$_POST['TipoUser']);
		$B->Periodo('Data',$_POST['DataIniAcss'],$_POST['DataFimAcss']);
		
		$Ac = new tabAcessos;
		$Ac->SqlWhere = $B->Where;
		$Ac->SqlOrder = "Data DESC";
		$Ac->MontaSQL();
		$Ac->Load();
?>

<div id="Imprimir">
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
        <td width="200" height="60" align="center" valign="bottom"><img src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" height="60" id="Logo" class="prints" /></td>
        <td height="60" align="center" valign="middle"><strong>RELATÓRIO DE ACESSOS</strong></td>
        <td style="font-style:italic" width="200" height="60" align="center" valign="bottom"></td>
 		</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
        <td style="font-style:italic" width="45%" height="" align="left" valign="bottom"><strong><?php echo ($_POST['TipoUser'] == 1) ? "Técnico" : "Cliente";?>: </strong><?php echo ($IDUser != "") ? $Us->Nome : "Todos";?></td>
        <td height="" align="center" valign="middle"></td>
        <td style="font-style:italic;" width="45%" height="" align="right" valign="bottom"><strong><?php echo $_POST['DataIniAcss']." - ".$_POST['DataFimAcss'];?></strong></td>
 		</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <thead>
                <tr>
                <th height="25" align="left" valign="middle" scope="col">Descricão</th>
                <th width="200" height="25" align="left" valign="middle" scope="col">Usuário</th>
                <th width="120" height="25" align="center" valign="middle" scope="col">IP</th>
                <th width="120" height="25" align="center" valign="middle" scope="col">Data</th>
          </tr>
        </thead>
        <tbody>
        <?php for($a=0;$a<$Ac->NumRows;$a++):?>
        <?php
		if($_POST['TipoUser'] == 1){
			$Us2 = new tabAdmm($Ac->IDUser);
		}elseif($_POST['TipoUser'] == 2){
			$Us2 = new tabAdmm($Ac->IDUser);
		}
		
		$Link = '<a href="'.$URL->siteURL.$Ac->URL.'" target="_blank">'.(($Ac->URL != '') ? $Ac->URL : "Início").'</a>';
		?>

                <tr>
                <td height="25" align="left" valign="middle"><?php echo $Link;?></td>
                <td width="200" height="25" align="left" valign="middle"><?php echo $Us2->Nome;?></td>
                <td width="120" height="25" align="center" valign="middle"><?php echo $Ac->IP;?></td>
                <td width="120" height="25" align="center" valign="middle"><?php echo date('d/m/Y H:i:s',strtotime($Ac->Data));?></td>
				</tr>
        <?php $Ac->Next(); endfor;?>
        </tbody>
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