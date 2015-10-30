<?php
		$S->PrAcess(31); // Cadasrtar Clientes
		
		include_once('lib/tabs/tabclientes.php');
		include_once('lib/tabs/tablogincliente.php');
		include_once('lib/tabs/tabadmm.php');
		
		$d->setData();
		
		//Executa açoes submit
		if(!empty($_POST['Sub'])){
			unset($_POST['Sub']);
			//$_POST = str_replace("'","\'",$_POST);
			
					if(($_POST['Nome'] != '') && ($_POST['Login'] != '') && ($_POST['Senha'] != '')){
							if(!empty($_POST['Clientes'])){
									$Sant = $_POST['Senha'];
									
									$_POST['Situacao'] = '1';
									$_POST['Assinatura'] = '0';
									
									$_POST['RecEmail'] = (!empty($_POST['RecEmail'])) ? 1 : 0;
									
									$VLogin = new DBConex;
									$VLogin->ExecSQL("SELECT Login FROM admm WHERE Login = '".$_POST['Login']."' UNION SELECT Login FROM logincliente WHERE Login = '".$_POST['Login']."'");
									
									if($VLogin->NumRows < 1){
											
											$cl = new tabLoginCliente;
											$cl->GetValPost();
											$cl->Insert();
											if($cl->InsertID > 0){
												$W->AddAviso('Usuário Cadastrado','WS');
												$_POST = "";
												$Sant = "";	
											}
											else $W->AddAviso('Problemas ao cadastrar usuário.','WE');
											
									}else $W->AddAviso('Este Login já está em uso.','WE');
									
									$_POST['Senha'] = $Sant;
							}else $W->AddAviso('Deve existir pelo menos um cliente associado ao usuário.','WA'); 
					}
					else $W->AddAviso('Preencha os campos com *.','WA');
			
		}
		//Fim acoes submit
?>

<h1>Usuários Cliente</h1>

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
        
        <div class="sepCont" style="height:20px;"></div>
                        
		<div class="inputs">
        		Login: *<br />
                <input type="text" name="Login" id="Login" maxlength="50" value="<?php if(!empty($_POST['Login'])) echo $_POST['Login'];?>" />
        </div>
                                
		<div class="inputs">
        		Senha: *<br />
                <input type="password" name="Senha" id="Senha" maxlength="50" value="<?php if(!empty($_POST['Senha'])) echo $_POST['Senha'];?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputs">
                <br />
                <input type="checkbox" name="RecEmail" id="RecEmail"  value="ok" <?php if(!empty($_POST['RecEmail'])) echo 'checked="checked"';?> /> Receber E-mails
        </div>
        
        <div class="sepCont"></div>
        <h4>Grupo de Clientes</h4>
        <div class="sepCont"></div>
        
        <div class="ColEsq">
                <div class="inputs">
                <?php
				$UsT = new tabAdmm($S->ID);
				$LCl = new tabClientes;
				$LCl->SqlWhere = $UsT->Clientes();
				$LCl->MontaSQL();
				$LCl->Load();
				?>
                        Categoria:<br />
                        <select name="IDCl" id="IDCl">
						<?php
								for($a=0;$a<$LCl->NumRows;$a++){
										?>
                                        <option value="<?php echo $LCl->ID;?>|-|<?php echo $LCl->Nome;?>"><?php echo $LCl->Nome;?></option>
                                        <?php
								$LCl->Next();
								}
						?>
                        </select>
                </div>
                <br />
                <input type="hidden" name="Clientes" id="Clientes" value="<?php echo (!empty($_POST['Clientes'])) ? $_POST['Clientes'] : "";?>" />
                <div onclick="AddCl();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/plus.png" />Adicionar</div>
                
        </div>
        <div class="ColDir" id="ListaDeClientes">
        		<?php
						if(!empty($_POST['Clientes'])){
						$Cls = (!empty($_POST['Clientes'])) ? $_POST['Clientes'] : "";
						$ClsExp = explode(",",$Cls);
						unset($ClsExp[0]);
						
						foreach($ClsExp as $key => $val){
								$Cl = new tabClientes($val);
								?>
                                        <div class="Opc" rel="Cl<?php echo $Cl->ID;?>">
                                        <img onclick="ExcCl('<?php echo $Cl->ID;?>');" src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="sec" width="20" height="20" title="Excluir" />
                                        <?php echo $Cl->Nome;?>
                                        </div>
                                <?php
						}
						}
				?>

        </div>


        <div class="sepCont"></div>
        
        <input type="submit" name="Sub" value="Salvar" style="display:none;" />
        
        <div onclick="return $('input[name=Sub]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" />Salvar</div>

</form>

<script>
		<?php if(!empty($_POST['UF'])) :?>
		$('#UF').val('<?php echo $_POST['UF'];?>');
		<?php endif;?>
		
		$('.sepCol2').css('padding-left','0px');
		
		<?php echo $JS->Tel(array('#Tel','#Cel'));?>
		
		function AddCl(){
				var Ant = $('#Clientes').val();
				var VIdCl = $('#IDCl').val();
				var DCl = VIdCl.split('|-|');
				
				if(Ant.indexOf(','+DCl[0]) < 0){//Verificacao se ja existe na lista
						$('#Clientes').val(Ant+','+DCl[0]);
						var msg = '<div class="Opc" rel="Cl'+DCl[0]+'"><img onclick="ExcCl(\''+DCl[0]+'\');" src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="sec" width="20" height="20" title="Excluir" />'+DCl[1]+'</div>';
						$('#ListaDeClientes').append(msg);
				}else AddAviso('Este usuário já possui acesso a este cliente.','WA');
		}
		
		function ExcCl(ID){
				var Ant = $('#Clientes').val();
				if(confirm('Você tem certeza?')){
						$('#Clientes').val(Ant.replace(','+ID,''));
						$('div[rel=Cl'+ID+']').remove();
				}
		}
</script>