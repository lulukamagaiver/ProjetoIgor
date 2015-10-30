<?php
		require_once('../lib/url.php');
		require_once('../lib/tabs/tabclientes.php');

		$Cl = new tabClientes;
		$Cl->MontaSQL();
		$Cl->Load();
		
				
		$URL = new URL;
?>
<h4>Selecionar Clientes</h4>
<div class="sepCont"></div>
<form method="post" action="<?php echo $URL->siteURL;?>relatorios/analiticocategorias/">
		<div class="inputsMeio">
				Mês: <br />
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
                <script>$('#Mes').val('<?php echo date('n');?>');</script>
		</div>
		
		<div class="inputsMeio">
				Ano: <br />
				<select name="Ano" id="Ano">
						<option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
				</select>
                <script>$('#Ano').val('<?php echo date('Y');?>');</script>
		</div>
		
		<div class="inputs">
				Cliente: <br />
				<select name="ClientesOpc" id="ClientesOpc">
						<?php for($a=0;$a<$Cl->NumRows;$a++):?>
						<option value="<?php echo $Cl->ID;?>"><?php echo $Cl->Nome;?></option>
						<?php $Cl->Next(); endfor;?>
				</select>
		</div>
		
		<div class="btnAct" style="margin-top:10px;" onClick="AddCl();"><img src="<?php echo $URL->siteURL;?>imgs/icones/plus.png" /> Adicionar</div>
		
		<div id="ListaID" style="width:658px; padding-left:10px; height:178px; float:left; margin:10px auto;"></div>
		
		<input type="hidden" id="OpcSelecionado" value="" />
		<input type="submit" name="Envia" value"ok" style="display:none" />
		<div style="margin-top:10px;" onClick="return $('input[name=Envia]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/chart.png" /> Gerar</div>
		<div style="margin-top:10px;" onClick="$('.PopUp').fadeOut();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" /> Cancelar</div>
</form>

<div id="BaseOpc" style="display:none;">
<div class="OpcoesSistema" rel="{ID}">
<input type="hidden" name="IDs[]" value="{ID}" />
<img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" width="20" height="20" onClick="RemoverOpc('{ID}')" />
{Nome}
</div>
</div>
<script>
var ItensAnalitico = 0;
function AddCl(){
	
	if(ItensAnalitico < 12){
			var ID = $('#ClientesOpc').val();
							
						
				if(ID != null){
						var Nome = $('#ClientesOpc option:selected').text();
						var Base = $('#BaseOpc').html();
						
						ItensAnalitico++;
						
						Base = Base.replace('{ID}',ID);
						Base = Base.replace('{ID}',ID);
						Base = Base.replace('{ID}',ID);
						Base = Base.replace('{Nome}',Nome);
						
						$('#ListaID').append(Base);
						
						$('#ClientesOpc option[value='+ID+']').prop('disabled', true);
						$('#OpcSelecionado').val($('#OpcSelecionado').val()+','+ID);
				}else AddAviso('Cliente já selecionado.','WA');
				
				$('#ClientesOpc').find('option').each(function(){
				   $valor = this.value; //valor do option atual
					 //comparar com o valor do banco
					 if($valor == ID){
						 $index = this.index; //quero a posição index do option de valor 05
						 $('#ClientesOpc option:selected').removeAttr('selected'); // removendo o outro option selecionado
					//seleciona o option que eu achei.
						 $('#ClientesOpc option').eq($index+1).attr('selected', 'selected'); 
						 
					 }
				   
				});
	}else AddAviso('Você atingiu o limite de clientes por relatório.','WA');
}

function RemoverOpc(ID){
		$('div[rel='+ID+']').remove();
		$('#ClientesOpc option[value='+ID+']').prop('disabled', false);
		$('#OpcSelecionado').val($('#OpcSelecionado').val().replace(','+ID,''));
		ItensAnalitico--;
}
</script>