<?php
		$S->PrAcess(51); // cadastrar usuario
		
		require_once('lib/tabs/tabadmm.php');
		
		
		if(!empty($_POST['Envia'])){
				if((!empty($_POST['Nome'])) && (!empty($_POST['Login'])) && (!empty($_POST['Senha']))){
						if(!empty($_POST['Permissoes'])){
								if(empty($_POST['Apelido'])) $_POST['Apelido'] = $_POST['Nome'];
								$PAnt = $_POST['Permissoes'];
								$SAnt = $_POST['Senha'];
									
								$VLogin = new DBConex;
								$VLogin->ExecSQL("SELECT Login FROM admm WHERE Login = '".$_POST['Login']."' UNION SELECT Login FROM clientes WHERE Login = '".$_POST['Login']."'");
								
								if($VLogin->NumRows < 1){
								$_POST['Permissoes'] = implode("|-|",$_POST['Permissoes']);
								$_POST['Senha'] = md5($_POST['Senha']);
								$_POST['Status'] = '1';
										$Us = new tabAdmm;
										$Us->GetValPost();
										$Us->Insert();
										
										if($Us->InsertID > 0){
											$W->AddAviso('Usuário cadastrado com sucesso.','WS');
											$_POST = "";
											$Us->Permissoes = "";
										}
										else{
											$W->AddAviso('Problemas ao cadastrar usuário, tente novamente.','WE');
											$_POST['Permissoes'] = $PAnt;
											$_POST['Senha'] = $SAnt;
										}
								}else $W->AddAviso('Este usuário já existe.','WA');
						}else $W->AddAviso('Defina pelo menos uma permissão ao usuário.','WA');
				}else $W->AddAviso('Preencha os campos com *.','WA');
		}
?>

<h1>Cadastrar Usuários</h1>

<form method="post">
		<div class="inputsLarge">
        		Nome: *<br />
                <input name="Nome" type="text" id="Nome" value="<?php echo (!empty($_POST['Nome'])) ? $_POST['Nome'] : ""; ?>"/>
        </div>
        
        <div class="sepCont"></div>
        
		<div class="inputsLarge">
        		E-mail:<br />
                <input name="Email" type="text" id="Email" value="<?php echo (!empty($_POST['Email'])) ? $_POST['Email'] : ""; ?>"/>
        </div>
        
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Exibição:<br />
                <input name="Apelido" type="text" id="Apelido" value="<?php echo (!empty($_POST['Apelido'])) ? $_POST['Apelido'] : ""; ?>"/>
        </div>
                
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Login: *<br />
                <input name="Login" type="text" id="Login" value="<?php echo (!empty($_POST['Login'])) ? $_POST['Login'] : ""; ?>"/>
        </div>
                
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Senha: *<br />
                <input name="Senha" type="password" id="Senha" value="<?php echo (!empty($_POST['Senha'])) ? $_POST['Senha'] : ""; ?>" maxlength="14" />
        </div>
        
        <div class="sepCont"></div>
        <h4>Permissões</h4>
        <div class="sepCont"></div>
        
        <div class="sepCol3">
        		<p><strong>Chamados:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao11" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11',$Us->Permissoes)) ? "checked" : "") : (in_array(11,$_POST['Permissoes'])) ? "checked" : "";?> value="11" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao12" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('12',$Us->Permissoes)) ? "checked" : "") : (in_array('12',$_POST['Permissoes'])) ? "checked" : "";?> value="12" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao13" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('13',$Us->Permissoes)) ? "checked" : "") : (in_array('13',$_POST['Permissoes'])) ? "checked" : "";?> value="13" /> Excluir<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao14" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('14',$Us->Permissoes)) ? "checked" : "") : (in_array('14',$_POST['Permissoes'])) ? "checked" : "";?> value="14" /> Alterar Comentários<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao15" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('15',$Us->Permissoes)) ? "checked" : "") : (in_array('15',$_POST['Permissoes'])) ? "checked" : "";?> value="15" /> Excluir Comentários<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao16" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('16',$Us->Permissoes)) ? "checked" : "") : (in_array('16',$_POST['Permissoes'])) ? "checked" : "";?> value="16" /> Incluir Material/Serviço<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao17" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('17',$Us->Permissoes)) ? "checked" : "") : (in_array('17',$_POST['Permissoes'])) ? "checked" : "";?> value="17" /> Alterar Material/Serviço<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao18" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('18',$Us->Permissoes)) ? "checked" : "") : (in_array('18',$_POST['Permissoes'])) ? "checked" : "";?> value="18" /> Excluir Material/Serviço<br />
        </div>
        
        <div class="sepCol3">
        		<p><strong>Ordens de Serviço:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao21" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('21',$Us->Permissoes)) ? "checked" : "") : (in_array('21',$_POST['Permissoes'])) ? "checked" : "";?> value="21" /> Gerar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao22" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('22',$Us->Permissoes)) ? "checked" : "") : (in_array('22',$_POST['Permissoes'])) ? "checked" : "";?> value="22" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao23" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('23',$Us->Permissoes)) ? "checked" : "") : (in_array('23',$_POST['Permissoes'])) ? "checked" : "";?> value="23" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao24" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('24',$Us->Permissoes)) ? "checked" : "") : (in_array('24',$_POST['Permissoes'])) ? "checked" : "";?> value="24" /> Excluir<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao25" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('25',$Us->Permissoes)) ? "checked" : "") : (in_array('25',$_POST['Permissoes'])) ? "checked" : "";?> value="25" /> Fechar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao26" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('26',$Us->Permissoes)) ? "checked" : "") : (in_array('26',$_POST['Permissoes'])) ? "checked" : "";?> value="26" /> Relatórios de OS/Relatórios de OS por Equip./Prod.<br />
        </div>
        
        <div class="sepCol3">
        		<p><strong>Clientes:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao31" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('31',$Us->Permissoes)) ? "checked" : "") : (in_array('31',$_POST['Permissoes'])) ? "checked" : "";?> value="31" /> Cadastrar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao32" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('32',$Us->Permissoes)) ? "checked" : "") : (in_array('32',$_POST['Permissoes'])) ? "checked" : "";?> value="32" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao33" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('33',$Us->Permissoes)) ? "checked" : "") : (in_array('33',$_POST['Permissoes'])) ? "checked" : "";?> value="33" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao34" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('34',$Us->Permissoes)) ? "checked" : "") : (in_array('34',$_POST['Permissoes'])) ? "checked" : "";?> value="34" /> Excluir<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao35" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('35',$Us->Permissoes)) ? "checked" : "") : (in_array('35',$_POST['Permissoes'])) ? "checked" : "";?> value="35" /> Visualizar dados Financeiros<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao36" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('36',$Us->Permissoes)) ? "checked" : "") : (in_array('36',$_POST['Permissoes'])) ? "checked" : "";?> value="36" /> Visualizar Senha<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao37" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('37',$Us->Permissoes)) ? "checked" : "") : (in_array('37',$_POST['Permissoes'])) ? "checked" : "";?> value="37" /> Cadastrar Equipamento/Produto<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao38" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('38',$Us->Permissoes)) ? "checked" : "") : (in_array('38',$_POST['Permissoes'])) ? "checked" : "";?> value="38" /> Alterar Equipamento/Produto<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao39" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('39',$Us->Permissoes)) ? "checked" : "") : (in_array('39',$_POST['Permissoes'])) ? "checked" : "";?> value="39" /> Excluir Equipamento/Produto<br />
        </div>
        
        <div class="sepCont"></div>
                
        <div class="sepCol3">
        		<p><strong>Materiais/Serviços:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao41" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('41',$Us->Permissoes)) ? "checked" : "") : (in_array('41',$_POST['Permissoes'])) ? "checked" : "";?> value="41" /> Cadastrar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao42" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('42',$Us->Permissoes)) ? "checked" : "") : (in_array('42',$_POST['Permissoes'])) ? "checked" : "";?> value="42" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao43" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('43',$Us->Permissoes)) ? "checked" : "") : (in_array('43',$_POST['Permissoes'])) ? "checked" : "";?> value="43" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao44" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('44',$Us->Permissoes)) ? "checked" : "") : (in_array('44',$_POST['Permissoes'])) ? "checked" : "";?> value="44" /> Excluir<br />
        </div>
                        
        <div class="sepCol3">
        		<p><strong>Usuários:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao51" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('51',$Us->Permissoes)) ? "checked" : "") : (in_array('51',$_POST['Permissoes'])) ? "checked" : "";?> value="51" /> Cadastrar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao52" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('52',$Us->Permissoes)) ? "checked" : "") : (in_array('52',$_POST['Permissoes'])) ? "checked" : "";?> value="52" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao53" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('53',$Us->Permissoes)) ? "checked" : "") : (in_array('53',$_POST['Permissoes'])) ? "checked" : "";?> value="53" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao54" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('54',$Us->Permissoes)) ? "checked" : "") : (in_array('54',$_POST['Permissoes'])) ? "checked" : "";?> value="54" /> Excluir<br />
        </div>
                                
        <div class="sepCol3">
        		<p><strong>Avaliações:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao61" class="Permissoes Avaliacoes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('61',$Us->Permissoes)) ? "checked" : "") : (in_array('61',$_POST['Permissoes'])) ? "checked" : "";?> value="61" /> Consultar OS Avaliadas / Relatórios de Avaliações<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao62" class="Permissoes Avaliacoes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('62',$Us->Permissoes)) ? "checked" : "") : (in_array('62',$_POST['Permissoes'])) ? "checked" : "";?> value="62" /> Cadastrar, Alterar e Excluir tópicos<br />
        </div>
        
        <div class="sepCont"></div>
                        
        <div class="sepCol3">
        		<p><strong>Outros:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao71" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('71',$Us->Permissoes)) ? "checked" : "") : (in_array('71',$_POST['Permissoes'])) ? "checked" : "";?> value="71" /> Relatório Financeiro<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao72" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('72',$Us->Permissoes)) ? "checked" : "") : (in_array('72',$_POST['Permissoes'])) ? "checked" : "";?> value="72" /> Configurações Gerais<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao73" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('73',$Us->Permissoes)) ? "checked" : "") : (in_array('73',$_POST['Permissoes'])) ? "checked" : "";?> value="73" /> Estatísticas<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao74" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('74',$Us->Permissoes)) ? "checked" : "") : (in_array('74',$_POST['Permissoes'])) ? "checked" : "";?> value="74" /> Relatório de Acessos<br />
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Envia" value="Salvar" />
</form>