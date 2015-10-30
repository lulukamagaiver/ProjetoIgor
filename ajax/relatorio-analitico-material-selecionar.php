<?php
		require_once('../lib/url.php');
		require_once('../lib/tabs/tabclientes.php');

		$Cl = new tabClientes;
		$Cl->MontaSQL();
		$Cl->Load();
		
				
		$URL = new URL;
?>
<h4>Selecionar Meses e Cliente</h4>
<div class="sepCont"></div>
<form method="post" action="<?php echo $URL->siteURL;?>relatorios/analiticomaterial/">
		<div class="inputsMeio">
				Mês: <br />
				<select name="Mes" id="Mes">
						<option value="1" class="Janeiro">Janeiro</option>
                        <option value="2" class="Fevereiro">Fevereiro</option>
                        <option value="3" class="Março">Março</option>
                        <option value="4" class="Abril">Abril</option>
                        <option value="5" class="Maio">Maio</option>
                        <option value="6" class="Junho">Junho</option>
                        <option value="7" class="Julho">Julho</option>
                        <option value="8" class="Agosto">Agosto</option>
                        <option value="9" class="Setembro">Setembro</option>
                        <option value="10" class="Outubro">Outubro</option>
                        <option value="11" class="Novembro">Novembro</option>
                        <option value="12" class="Dezembro">Dezembro</option>
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
		
		<div class="btnAct" style="margin-top:10px;" onClick="AddMes();"><img src="<?php echo $URL->siteURL;?>imgs/icones/plus.png" /> Adicionar</div>
		
		<div id="ListaID" style="width:658px; padding-left:10px; height:178px; float:left; margin:10px auto;"></div>
		
		<input type="hidden" id="OpcSelecionado" value="" />
		<input type="submit" name="Envia" value"ok" style="display:none" />
		<div style="margin-top:10px;" onClick="return $('input[name=Envia]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/chart.png" /> Gerar</div>
		<div style="margin-top:10px;" onClick="$('.PopUp').fadeOut();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" /> Cancelar</div>
</form>

<div id="BaseOpc" style="display:none;">
<div class="OpcoesSistema" rel="{MESANO}">
<input type="hidden" name="Meses[]" value="{MESANO}" />
<img src="<?php echo $URL->siteURL;?>imgs/icones/delete.png" width="20" height="20" onClick="RemoverOpc('{MESANO}')" />
{Nome}
</div>
</div>
<script>
var ItensAnalitico = 0;
function AddMes(){
	if(ItensAnalitico < 12){
			var MESANO = $('#Mes').val() + '-' + $('#Ano').val();
			if(!$('input[value='+MESANO+']').val()){
			var MES = $('#Mes').val();
			var ANO = parseInt($('#Ano').val());

						var Base = $('#BaseOpc').html();
						
						ItensAnalitico++;
						
						Base = Base.replace('{MESANO}',MESANO);
						Base = Base.replace('{MESANO}',MESANO);
						Base = Base.replace('{MESANO}',MESANO);
						Base = Base.replace('{Nome}',$('#Mes option:selected').attr('class') + ' - ' + $('#Ano').val());
						
						$('#ListaID').append(Base);
						
						$('#Mes').find('option').each(function(){
						   $valor = this.value; //valor do option atual
							 //comparar com o valor do banco
							 if($valor == MES){
								 $index = this.index; //quero a posição index do option de valor 05
								 $('#Mes option:selected').removeAttr('selected'); // removendo o outro option selecionado
							//seleciona o option que eu achei.
								 $('#Mes option').eq($index+1).attr('selected', 'selected');
								 if(MES == 12){
									 console.log(ANO + 1);
									 	$('#Ano').val(ANO + 1);
								 }
								 
							 }
						});

			}else AddAviso('Mês já selecionado.','WA');
	}else AddAviso('Você atingiu o limite de meses por relatório.','WA');
}

function RemoverOpc(ID){
		$('div[rel='+ID+']').remove();
		ItensAnalitico--;
}
</script>