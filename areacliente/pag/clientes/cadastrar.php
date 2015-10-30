<?php
		$S->PrAcess(31); // Cadasrtar Clientes
		
		include_once('lib/tabs/tabclientes.php');
		
		$d->setData();
		
		//Executa açoes submit
		if(!empty($_POST['Sub'])){
			unset($_POST['Sub']);
			//$_POST = str_replace("'","\'",$_POST);
			
					if(($_POST['Nome'] != '')){
							$_POST['Situacao'] = '1';
							$_POST['Assinatura'] = '0';
							
							$VLogin = new DBConex;
							$VLogin->ExecSQL("SELECT Login FROM admm WHERE Login = '".$_POST['Login']."' UNION SELECT Login FROM logincliente WHERE Login = '".$_POST['Login']."'");

							if($VerLogin->NumRows < 1){
									$cl = new tabClientes;
									$_POST['VHora'] = str_replace(',','.',$_PSOT['VHora']);
									$_POST['VContrato'] = str_replace(',','.',$_PSOT['VContrato']);
									$cl->GetValPost();
									$cl->Insert();
									if($cl->InsertID > 0) $W->AddAviso('Cliente Cadastrado','WS');
									else{
										$W->AddAviso('Problemas ao cadastrar cliente.','WE');
										$_POST['VHora'] = str_replace('.',',',$_PSOT['VHora']);
										$_POST['VContrato'] = str_replace('.',',',$_PSOT['VContrato']);
									}
							}else $W->AddAviso('Este usuário já existe.','WE');
					}
					else $W->AddAviso('Preencha os campos com *.','WA');
			
		}
		//Fim acoes submit
?>

<h1>Cadastrar Clientes</h1>

<form method="post" action="">

		<div class="inputsLarge">
        		Nome: *<br />
                <input type="text" name="Nome" id="Nome" maxlength="60" value="<?php if(!empty($_POST['Nome'])) echo $_POST['Nome'];?>" />
        </div>
 
		<div class="inputsLarge">
        		Endereço:<br />
                <input type="text" name="Endereco" id="Endereco" maxlength="100" value="<?php if(!empty($_POST['Endereco'])) echo $_POST['Endereco'];?>" />
        </div>
                
		<div class="inputs">
        		Bairro:<br />
                <input type="text" name="Bairro" id="Bairro" maxlength="50" value="<?php if(!empty($_POST['Bairro'])) echo $_POST['Bairro'];?>" />
        </div>
                
		<div class="inputs">
        		Cidade:<br />
                <input type="text" name="Cidade" id="Cidade" maxlength="50" value="<?php if(!empty($_POST['Cidade'])) echo $_POST['Cidade'];?>" />
        </div>
                
		<div class="inputsMeio">
        		CEP:<br />
                <input type="text" name="CEP" id="CEP" maxlength="9" value="<?php if(!empty($_POST['CEP'])) echo $_POST['CEP'];?>" />
        </div>
                
		<div class="inputsMeio">
        		UF:<br />
                <select name="UF" id="UF">
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AM">AM</option>
                        <option value="AP">AP</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF" selected="selected">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MG">MG</option>
                        <option value="MS">MS</option>
                        <option value="MT">MT</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="PR">PR</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="RS">RS</option>
                        <option value="SC">SC</option>
                        <option value="SE">SE</option>
                        <option value="SP">SP</option>
                        <option value="TO">TO</option>
                </select>
        </div>
                
		<div class="inputsMeio">
        		Telefone:<br />
                <input type="text" name="Tel" id="Tel" maxlength="15" value="<?php if(!empty($_POST['Tel'])) echo $_POST['Tel'];?>" />
        </div>
                
		<div class="inputsMeio">
        		Telefone:<br />
                <input type="text" name="Cel" id="Cel" maxlength="15" value="<?php if(!empty($_POST['Cel'])) echo $_POST['Cel'];?>" />
        </div>
                
		<div class="inputs">
        		E-mail:<br />
                <input type="text" name="Email" id="Email" maxlength="80" value="<?php if(!empty($_POST['Email'])) echo $_POST['Email'];?>" />
        </div>
        
        <div class="inputsLarge">
                <input type="checkbox" name="EnviaEmail" id="EnviaEmail" checked value="1" /> Enviar E-mails (Chamados, Comentários, OS)
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputsMeio">
        		Tipo: <br />
                <select name="Tipo" id="Tipo">
                		<option value="I">Selecionar</option>
                        <option value="J">Juríca</option>
                        <option value="F">Fisica</option>
                </select>
        </div>
        
        <div class="sepCol2" id="TipoCl" style="width:870px; padding:0; margin:0;">
        		
        </div>
        
        <div class="sepCont" style="height:20px;"></div>

                                
		<div class="inputs">
        		<br />
                <input type="checkbox" name="Contrato" id="Contrato" <?php if(!empty($_POST['Contrato'])) echo "checked";?> value="1" /> Cliente Com Contrato
        </div>
        
        <div class="sepCont"></div>
                                
		<div class="inputsMeio">
        		Valor Contrato:<br />
                <input type="text" name="VContrato" id="VContrato" maxlength="50" value="<?php if(!empty($_POST['VContrato'])) echo $_POST['VContrato'];?>" />
        </div>
                                
		<div class="inputsMeio">
        		QNT. Horas:<br />
                <input type="text" name="QNTHoras" id="QNTHoras" maxlength="50" value="<?php if(!empty($_POST['QNTHoras'])) echo $_POST['QNTHoras'];?>" />
        </div>
                                
		<div class="inputsMeio">
        		Valor Hora:<br />
                <input type="text" name="VHora" id="VHora" maxlength="50" value="<?php if(!empty($_POST['VHora'])) echo $_POST['VHora'];?>" />
        </div>
                                
		<div class="inputsLarge" style="width:600px;">
        		OS On-line:<br />
                <input style="width:84px;" type="text" name="Desconto" id="Desconto" maxlength="50" value="<?php if(!empty($_POST['Desconto'])) echo $_POST['Desconto'];?>" />% DE DESCONTO (deixe em branco para valor padrão)
        </div>
        
        <div class="sepCont"></div>
        
        
        
        <div class="sepCont"></div>
        <div class="sepCol2">
        <div class="txtArea">
        		Observações:<br />
        		<textarea name="Obs" id="Obs"><?php if(!empty($_POST['Obs'])) echo $_POST['Obs'];?></textarea>
        </div>
        </div>
        <div class="sepCont"></div>
        
        <input type="submit" name="Sub" value="Salvar" />

</form>

<script>
		<?php if(!empty($_POST['Tipo'])) :?>
		$('#Tipo').val('<?php echo $_POST['Tipo'];?>');
				<?php if($_POST['Tipo'] == 'J') :?>$('#TipoCl').html('<div class="inputsLarge">Razão Social:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php if(!empty($_POST['Razao'])) echo $_POST['Razao'];?>" /></div><div class="inputs">CNPJ:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php if(!empty($_POST['CNPJ'])) echo $_POST['CNPJ'];?>" /></div><div class="inputs" style="width:230px;">I. E.:<br /><input type="text" name="IE" id="IE" maxlength="30" value="<?php if(!empty($_POST['IE'])) echo $_POST['IE'];?>" /></div>');<?php endif;?>
				<?php if($_POST['Tipo'] == 'F') :?>$('#TipoCl').html('<div class="inputsLarge">Nome Completo:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php if(!empty($_POST['Razao'])) echo $_POST['Razao'];?>" /></div><div class="inputs">CPF:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php if(!empty($_POST['CNPJ'])) echo $_POST['CNPJ'];?>" /></div>');<?php endif;?>
		<?php endif;?>
		
		<?php if(!empty($_POST['UF'])) :?>
		$('#UF').val('<?php echo $_POST['UF'];?>');
		<?php endif;?>
		
		$(document).ready(function(e) {
				$('#Tipo').change(function(){
						if($('#Tipo').val() == 'J') $('#TipoCl').html('<div class="inputsLarge">Razão Social:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php if(!empty($_POST['Razao'])) echo $_POST['Razao'];?>" /></div><div class="inputs">CNPJ:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php if(!empty($_POST['CNPJ'])) echo $_POST['CNPJ'];?>" /></div><div class="inputs" style="width:230px;">I. E.:<br /><input type="text" name="IE" id="IE" maxlength="30" value="<?php if(!empty($_POST['IE'])) echo $_POST['IE'];?>" /></div>');
						else if($('#Tipo').val() == 'F') $('#TipoCl').html('<div class="inputsLarge">Nome Completo:<br /><input type="text" name="Razao" id="Razao" maxlength="100" value="<?php if(!empty($_POST['Razao'])) echo $_POST['Razao'];?>" /></div><div class="inputs">CPF:<br /><input type="text" name="CNPJ" id="CNPJ" maxlength="30" value="<?php if(!empty($_POST['CNPJ'])) echo $_POST['CNPJ'];?>" /></div>');
						else $('#TipoCl').html('');
				});
				
				if($('#Contrato').is(':checked')){
						$('#VContrato').attr('disabled',false);
						$('#QNTHoras').attr('disabled',false);
				}else if($('#Contrato').not(':checked')){
						$('#VContrato').attr('disabled',true);
						$('#QNTHoras').attr('disabled',true);
				}
				
				$('#Contrato').click(function(){
						if($(this).is(':checked')){
								$('#VContrato').attr('disabled',false);
								$('#QNTHoras').attr('disabled',false);
						}else if($(this).not(':checked')){
								$('#VContrato').attr('disabled',true);
								$('#QNTHoras').attr('disabled',true);
						}
				});
        });
		
		$('.sepCol2').css('padding-left','0px');
		
		<?php echo $JS->Money(array('#VContrato','#VHora'));?>
		<?php echo $JS->Tel(array('#Tel','#Cel'));?>
</script>