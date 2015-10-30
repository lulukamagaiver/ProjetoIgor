<?php
		require_once('../lib/url.php');
		require_once('../lib/js.php');
		require_once('../lib/date.php');
		require_once('../lib/tabs/tablogincliente.php');
		require_once('../lib/tabs/tabadmm.php');

		$Cl = new tabLoginCliente;
		$Cl->MontaSQL();
		$Cl->Load();
		
		$Us = new tabAdmm;
		$Us->MontaSQL();
		$Us->Load();
		
		$JS = new JS;
		
		$d = new getDate;
		$d->SelectMes(date('n'),date('Y'));
				
		$URL = new URL;
?>
<h4>Selecionar Usuario</h4>
<div class="sepCont"></div>
<form method="post" action="<?php echo $URL->siteURL;?>relatorios/acessos/">
		<div class="inputsMeio">
				Tipo: <br />
				<select name="TipoUser" id="TipoUser" onchange="TrocaTipoUser();">
						<option value="1">Técnico</option>
                        <option value="2">Cliente</option>
				</select>
		</div>
		
		<div class="inputs" id="DivClientes" style="display:none;">
				Cliente: <br />
				<select name="IDClientes" id="IDClientes">
                		<option value="">Todos</option>
						<?php for($a=0;$a<$Cl->NumRows;$a++):?>
						<option value="<?php echo $Cl->ID;?>"><?php echo $Cl->Nome;?></option>
						<?php $Cl->Next(); endfor;?>
				</select>
		</div>
		
		<div class="inputs" id="DivTecnicos">
				Técnico: <br />
				<select name="IDTecnicos" id="IDTecnicos">
						<option value="">Todos</option>
						<?php for($a=0;$a<$Us->NumRows;$a++):?>
						<option value="<?php echo $Us->ID;?>"><?php echo $Us->Apelido;?></option>
						<?php $Us->Next(); endfor;?>
				</select>
		</div>
        
        <div class="inputsMeio">
        		Data Inicial: <br />
                <input type="text" name="DataIniAcss" id="DataIniAcss" value="<?php echo date('d/m/Y');?>" />
        </div>
                
        <div class="inputsMeio">
        		Data Final: <br />
                <input type="text" name="DataFimAcss" id="DataFimAcss" value="<?php echo date('d/m/Y');?>" />
        </div>
        
        <div class="sepCont"></div>
		
		<input type="hidden" id="OpcSelecionado" value="" />
		<input type="submit" name="Envia" value"ok" style="display:none" />
		<div style="margin-top:10px;" onClick="return $('input[name=Envia]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/chart.png" /> Gerar</div>
		<div style="margin-top:10px;" onClick="$('.PopUp').fadeOut();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" /> Cancelar</div>
</form>

<script>
function TrocaTipoUser(){
		if($('#TipoUser').val() == 1){
				$('#DivTecnicos').show();
				$('#DivClientes').hide();
		}else{
				$('#DivTecnicos').hide();
				$('#DivClientes').show();
		}
}

<?php echo $JS->DatePicker(array('#DataIniAcss','#DataFimAcss'));?>
</script>