<?php
		$S->PrAcess(31); // Cadasrtar Clientes
		
		include_once('lib/tabs/tabclientes.php');
		include_once('lib/tabs/tablogincliente.php');
		include_once('lib/relatorios.php');
		include_once('lib/search.php');


if(!empty($URL->GET)){
$url = explode("/",$URL->GET);

}


if((!empty($url[0])) && ($url[0] != 'deletar')){
$url = explode("/",$URL->GET);
				
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

											
											$cl = new tabLoginCliente;
											$cl->GetValPost();
											$cl->Update($url[0]);
											if($cl->Result){
												$W->AddAviso('Usuário alterado','WS');
												echo "<script>document.location = '".$URL->siteURL."clientes/alterarusuarios/'</script>";
												exit;
											}
											else $W->AddAviso('Problemas ao alterar usuário.','WE');
									
									$_POST['Senha'] = $Sant;
							}else $W->AddAviso('Deve existir pelo menos um cliente associado ao usuário.','WA'); 
					}
					else $W->AddAviso('Preencha os campos com *.','WA');
			
		}
		//Fim acoes submit
		
		$Us = new tabLoginCliente($url[0]);
?>

<h1>Alterar Usuário Cliente</h1>

<form method="post" action="">

		<div class="inputsLarge">
        		Nome: *<br />
                <input type="text" name="Nome" id="Nome" maxlength="60" value="<?php echo (!empty($_POST['Nome'])) ? $_POST['Nome'] : $Us->Nome;?>" />
        </div>
 
		<div class="inputsLarge">
        		Endereço:<br />
                <input type="text" name="Endereco" id="Endereco" maxlength="100" value="<?php echo (!empty($_POST['Endereco'])) ? $_POST['Endereco'] : $Us->Endereco;?>" />
        </div>
                
		<div class="inputs">
        		Bairro:<br />
                <input type="text" name="Bairro" id="Bairro" maxlength="50" value="<?php echo (!empty($_POST['Bairro'])) ? $_POST['Bairro'] : $Us->Bairro;?>" />
        </div>
                
		<div class="inputs">
        		Cidade:<br />
                <input type="text" name="Cidade" id="Cidade" maxlength="50" value="<?php echo (!empty($_POST['Cidade'])) ? $_POST['Cidade'] : $Us->Cidade;?>" />
        </div>
                
		<div class="inputsMeio">
        		CEP:<br />
                <input type="text" name="CEP" id="CEP" maxlength="9" value="<?php echo (!empty($_POST['CEP'])) ? $_POST['CEP'] : $Us->CEP;?>" />
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
                <input type="text" name="Tel" id="Tel" maxlength="15" value="<?php echo (!empty($_POST['Tel'])) ? $_POST['Tel'] : $Us->Tel;?>" />
        </div>
                
		<div class="inputsMeio">
        		Telefone:<br />
                <input type="text" name="Cel" id="Cel" maxlength="15" value="<?php echo (!empty($_POST['Cel'])) ? $_POST['Cel'] : $Us->Cel;?>" />
        </div>
                
		<div class="inputs">
        		E-mail:<br />
                <input type="text" name="Email" id="Email" maxlength="80" value="<?php echo (!empty($_POST['Email'])) ? $_POST['Email'] : $Us->Email;?>" />
        </div>
        
        <div class="sepCont" style="height:20px;"></div>
                        
		<div class="inputs">
        		Login: *<br />
                <input type="text" readonly name="Login" id="Login" maxlength="50" value="<?php echo (!empty($_POST['Login'])) ? $_POST['Login'] : $Us->Login;?>" />
        </div>
                                
		<div class="inputs">
        		Senha: *<br />
                <input type="<?php echo ($S->Pr(36)) ? "text" : "password";?>" name="Senha" id="Senha" maxlength="50" value="<?php echo (!empty($_POST['Senha'])) ? $_POST['Senha'] : $Us->Senha;?>" />
        </div>
        
        <div class="sepCont"></div>
        
        <div class="inputs">
                <br />
                <input type="checkbox" name="RecEmail" id="RecEmail"  value="ok" <?php echo (!empty($_POST['RecEmail'])) ? 'checked="checked"' : ((!empty($Us->RecEmail)) ? 'checked="checked"' : '');?> /> Receber E-mails
        </div>
        
        <div class="sepCont"></div>
        <h4>Grupo de Clientes</h4>
        <div class="sepCont"></div>
        
        <div class="ColEsq">
                <div class="inputs">
                <?php
				$LCl = new tabClientes;
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
                <input type="hidden" name="Clientes" id="Clientes" value="<?php echo (!empty($_POST['Clientes'])) ? $_POST['Clientes'] : $Us->Clientes;?>" />
                <div onclick="AddCl();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/plus.png" />Adicionar</div>
                
        </div>
        <div class="ColDir" id="ListaDeClientes">
        
        		<?php
						$Cls = (!empty($_POST['Clientes'])) ? $_POST['Clientes'] : $Us->Clientes;
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
				?>
               

        
        </div>


        <div class="sepCont"></div>
        
        <input type="submit" name="Sub" value="Salvar" style="display:none;" />
        
        <div onclick="return $('input[name=Sub]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" />Salvar</div>

</form>

<script>
		<?php if(!empty($_POST['UF'])) :?>
		$('#UF').val('<?php echo (!empty($_POST['UF'])) ? $_POST['UF'] : $Us->UF;?>');
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

<?php } else{//Fim area se houver id do usuario?>
		
        <h1>Usuários de Clientes</h1>
		
		
		<form method="post" style="float:left; width:100%;">		
        <div class="sepCont"></div>
                		<div class="inputsLarge">
                        		Busca por Código, Nome, Login ou E-mail: <br />
                                <input type="text" name="Busca" id="Busca" value="<?php echo (!empty($_POST['Busca'])) ? $_POST['Busca'] : "";?>" />
                        </div>
		
        <input name="" type="image" style="width:30px; height:30px; float:left; margin-left:0px;" src="imgs/icones/search.png" />
        <div class="sepCont" style="height:20px;"></div>        
        </form> 
        <?php

				if((!empty($url[0])) && ($url[0] == 'deletar') && (!empty($url[1]))){
						$Del = new tabLoginCliente;
						$Del->Delete($url[1]);
						if($Del->Result) $W->AddAviso('Usuario removido.','WS');
						else $W->AddAviso('Problemas ao remover usuario.','WE');
				}

				$B = new Search;
				$B->Like('ID,Nome,Login,Email',(!empty($_POST['Busca'])) ? $_POST['Busca'] : "");

				
				$Us = new tabLoginCliente;
				$Us->SqlWhere = $B->Where;
				$Us->MontaSQL();
				$Us->Load();
				
				$R = new Relat();
				$R->WidthCols = array('60','325','120','100','260','70');
				$R->Cols = array('ID','Nome','Login','Tel','Email','action');
				$R->Totais = array(0,0,0,0,0,0);
				$R->Formato = array('cod','','','','','');
				$R->Actions = '
				<a href="'.$URL->siteURL.'clientes/alterarusuarios/{id}/"><img class="action" src="imgs/icones/edit.png" width="26" height="26" /></a>
				<a onclick="return confirm(\'Tem certeza que deseja excluir?\');" href="'.$URL->siteURL.'clientes/alterarusuarios/deletar/{id}/"><img class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>
				';
				$R->Query = $Us->Query;
				$R->setTitulos(array('COD:center','Nome:left','Login:left','Telefone:Center','E-mail:left','Ações:center'));
				echo "<p class=\"left\">Número de registros encontrados: <strong>".$Us->NumRows."</strong></p>";
				$R->showTab(); 
		?>
        <a href="<?php echo $URL->siteURL;?>clientes/usuarios/"><div class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/plus.png" />Adicionar</div></a>
<?php }?>