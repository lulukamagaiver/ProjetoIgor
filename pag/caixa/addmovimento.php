<?php
		require('lib/tabs/tabcat-trans.php');
		require('lib/tabs/tabbanco.php');
		require('lib/tabs/tabcaixa.php');
		
	
		//Efetua Cadastro
		if((!empty($_POST['Envia'])) || (!empty($_POST['EnviaNovo']))){
				
				$Refrash = (!empty($_POST['Envia'])) ? "a" : "b";
				
				unset($_POST['Envia']);
				unset($_POST['EnviaNovo']);
				
				//Verifica Obrigatórios
				if((!empty($_POST['Data'])) && (!empty($_POST['Tipo'])) && ($_POST['Tipo'] > 0) && (!empty($_POST['Finalidade']) && (!empty($_POST['Valor']))) && ($_POST['Valor'] != '')){
							
						//Configura Vlores
						$_POST['Valor'] = str_replace(",",".",$_POST['Valor']);
						$_POST['Entrada'] = str_replace(",",".",$_POST['Entrada']);
						$_POST['Data'] = implode("-",array_reverse(explode("/",$_POST['Data'])));
						
						if($_POST['Destino'] == "Caixa") $Destino = new tabCaixa;
						elseif($_POST['Destino'] == "Banco") $Destino = new tabBanco;
						
						//Define valores em caso de parcela
						if((!empty($_POST['Parcelas'])) && (is_numeric($_POST['Parcelas']))){
								if((!empty($_POST['Entrada'])) && (($_POST['Valor'] - $_POST['Entrada']) >0)){
										$TRestante = $_POST['Valor'] - $_POST['Entrada'];
								}else{
									$TRestante = $_POST['Valor'];
									$_POST['Entrada'] = 0;
								}
								
								$_POST['IDParcela'] = md5(uniqid(rand(), true));
								
								
								$_POST['VParcela'] = $TRestante / $_POST['Parcelas'];
								
								$BaseFin = $_POST['Finalidade'];
								$BaseData = implode("/",array_reverse(explode("-",$_POST['Data'])));
								
								for($a=0;$a < $_POST['Parcelas'];$a++){
										$d->setData($BaseData,"BD",$a,2); 
										$_POST['Data'] = $d->data;
										
										$_POST['Finalidade'] = $BaseFin." (".($a+1)."/".$_POST['Parcelas'].")";
										
										$Destino->GetValPost();
										$Destino->Insert();
										
										$_POST['Entrada'] = "";
								}
								
								
								
								
						}else{
								//Verifica exixstencia de Entrada, se nao grava no bd
								if((!empty($_POST['Entrada'])) && (($_POST['Valor'] - $_POST['Entrada']) >0)){
										$TRestante = $_POST['Valor'] - $_POST['Entrada'];
										
										//Gera ID Parcela
										$_POST['IDParcela'] = md5(uniqid(rand(), true));
										
										//Define a existencia de 2 parcelas
										$_POST['Parcelas'] = 2;
										
										$_POST['VParcela'] = $TRestante / ($_POST['Parcelas'] - 1);
										
										$BaseFin = $_POST['Finalidade'];
										$BaseData = implode("/",array_reverse(explode("-",$_POST['Data'])));
										
										for($a=0;$a < $_POST['Parcelas'];$a++){
												$d->setData($BaseData,"BD",$a,2); 
												$_POST['Data'] = $d->data;
												
												$_POST['Finalidade'] = $BaseFin." (".($a+1)."/".$_POST['Parcelas'].")";
												
												$Destino->GetValPost();
												$Destino->Insert();
												
												$_POST['Entrada'] = "";
										}
								}else{
										$Destino->GetValPost();
										$Destino->Insert();
								}
						}
						
						if(($Destino->InsertID) && ($Destino->InsertID > 0)){
								$W->AddAviso('Registro adicionado com sucesso.','WS');
								if($Refrash == "a"){
									echo "<script>document.location='".$URL->siteURL."caixa/';</script>";
									exit;
								}
								
								//Limpa POST
								$_POST = "";
						}
						else $W->AddAviso('Problemas ao adicionar registro.','WE');
						
				}else{
						$W->AddAviso('Preencha todos os campos com *.','WA');
						$_POST['Valor'] = str_replace(".",",",$_POST['Valor']);
						$_POST['Entrada'] = str_replace(".",",",$_POST['Entrada']);
				}
		}
		
		//Categorias Movimentos
		$CatMov = new tabCatTrans;
		$CatMov->SqlWhere = "Status = 1";
		$CatMov->MontaSQL();
		$CatMov->Load();
?>


<h1>Adicionar Movimento</h1>


<div class="sepCol2">

<h4>Novo Registro</h4>
<div class="sepCont"></div>

<form method="post">
        <div class="inputsMeio">
                Destino:<br />
                <select name="Destino" id="Destino">
                        <option value="Caixa" <?php echo ((!empty($_POST['Destino'])) && ($_POST['Destino'] == "Caixa")) ? 'selected="selected"' : ''; ?>>Caixa</option>
                        <option value="Banco" <?php echo ((!empty($_POST['Destino'])) && ($_POST['Destino'] == "Banco")) ? 'selected="selected"' : ''; ?>>Banco</option>
                </select>
        </div>
        
        <div class="inputsMeio">
        		Tipo: *<br />
                <select name="Tipo" id="Tipo">
                        <option value="0">Selecionar</option>
                        <option value="1" <?php echo ((!empty($_POST['Tipo'])) && ($_POST['Tipo'] == "1")) ? 'selected="selected"' : ''; ?>>Crédito</option>
                        <option value="2" <?php echo ((!empty($_POST['Tipo'])) && ($_POST['Tipo'] == "2")) ? 'selected="selected"' : ''; ?>>Débito</option>
                </select>
        </div>
                        
        <div class="inputsMeio">
                Categoria:<br />
                <select name="Categoria" id="Categoria">
                        <option value="0">Outros</option>
                        <?php 
                        for($a=0; $a<$CatMov->NumRows; $a++){
                                ?>
                                <option value="<?php echo $CatMov->ID;?>" <?php echo ((!empty($_POST['Categoria'])) && ($_POST['Categoria'] == $CatMov->ID)) ? 'selected="selected"' : ''; ?>><?php echo $CatMov->Categoria;?></option>
                                <?php
                                $CatMov->Next();
                        }
                        ?>
                </select>
        </div>
        
        <div class="sepCont"></div>
                                
        <div class="inputsLarge" id="teste">
                Cliente:<br />
                <input type="text" name="Cliente" id="Cliente" maxlength="" value="<?php echo (!empty($_POST['Cliente'])) ? $_POST['Cliente'] : "";?>" />
                <input type="hidden" name="IdCl" id="IdCl" value="<?php echo (!empty($_POST['IdCl'])) ? $_POST['IdCl'] : "";?>" />
                <div class="auto">
                
                </div>
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputsMeio">
                Data: *<br />
                <?php $d->setData();?>
                <input type="text" name="Data" id="Data" maxlength="" value="<?php echo (!empty($_POST['Data'])) ? implode("/",array_reverse(explode("-",$_POST['Data']))) : $d->data;?>" />
        </div>
                
        <div class="inputs">
                Finalidade: *<br />
                <input type="text" name="Finalidade" id="Finalidade" maxlength="100" value="<?php echo (!empty($_POST['Finalidade'])) ? $_POST['Finalidade'] : "";?>" />
        </div>
        
        <div class="sepCont"></div>
                
        <div class="inputsMeio">
                Valor: *<br />
                <input type="text" name="Valor" id="Valor" maxlength="" value="<?php echo (!empty($_POST['Valor'])) ? $_POST['Valor'] : "";?>" />
        </div>
                
        <div class="inputsMeio">
                Parcelas:<br />
                <input type="text" name="Parcelas" id="Parcelas" maxlength="" value="<?php echo (!empty($_POST['Parcelas'])) ? $_POST['Parcelas'] : "";?>" />
        </div>
                
        <div class="inputsMeio">
                Entrada:<br />
                <input type="text" name="Entrada" id="Entrada" maxlength="" value="<?php echo (!empty($_POST['Entrada'])) ? $_POST['Entrada'] : "";?>" />
        </div>
       
       	<div class="sepCont"></div>
                        
        <div class="inputsLarge">
                Observações:<br />
                <input type="text" name="Obs" id="Obs" maxlength="" value="<?php echo (!empty($_POST['Obs'])) ? $_POST['Obs'] : "";?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Envia" value="Salvar" />
        <input type="submit" name="EnviaNovo" value="Salvar e Cadastrar Novo" />
        
</form>

</div>

<div class="sepCol2">
<h4>Registros para Data</h4>
<div class="sepCont"></div>

</div>

<div class="sepCont"></div>

<div class="sepCol2"></div>

<script>
		<?php 
		$JS->DatePicker(array('#Data'));
		$JS->Money(array('#Valor','#Entrada'));
		?>
		
		
$(document).ready(function() {
	
	$( "#Cliente" ).keyup(function() {
			$('#IdCl').val('');
			var serch = $('#Cliente').val();
				$.post( "<?php echo $URL->siteURL;?>ajax/auto-complete-cliente-addmovimento.php", { busca: serch })
				.done(function( data ) {
				$('.auto').html(data);
			});
	});
	$( "#Cliente" ).blur(function() {
			$('.auto').fadeOut();
	});
	
    jQuery('body').on('keydown', 'input, select, textarea', function(e) {
        var self = $(this)
                , form = self.parents('form:eq(0)')
                , focusable
                , next
				, at
                ;
        if (e.keyCode == 13) {
            focusable = form.find('input,a,select,button,textarea').filter(':visible');
			at = focusable.eq(focusable.index(this));
			next = focusable.eq(focusable.index(this) + 1);
			if(($(at).attr('name'))!= 'Cliente'){
            if (next.length) {
                next.focus();
            } else {
                form.submit();
            }
			}
			else{
						if($('#FirstAutoNome').val()){
								$('#Cliente').val($('#FirstAutoNome').val());
								$('#IdCl').val($('#FirstAutoID').val());
								
						}
						$('.auto').fadeOut()
						if (next.length) {
							next.focus();
						} else {
							form.submit();
						}
			}
            return false;
        }
    });
});

function SelectCliente(div){
			$('#Cliente').val($(div).attr('title'));
			$('#IdCl').val($(div).attr('rel'));
}
</script>