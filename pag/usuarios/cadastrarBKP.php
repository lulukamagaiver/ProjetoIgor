<?php
		if(empty($_POST['Permissoes'])) echo "vazio";
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
        <h4>Permissões</h4>
        <div class="sepCont"></div>
        
        <div class="sepCol3">
        		<p><strong>Chamados:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao11" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="11" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao12" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="12" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao13" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="13" /> Excluir<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao14" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="14" /> Alterar Comentários<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao15" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="15" /> Excluir Comentários<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao16" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="16" /> Incluir Material/Serviço<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao17" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="17" /> Alterar Material/Serviço<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao18" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="18" /> Excluir Material/Serviço<br />
        </div>
        
        <div class="sepCol3">
        		<p><strong>Ordens de Serviço:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao21" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="21" /> Gerar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao22" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="22" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao23" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="23" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao24" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="25" /> Excluir<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao25" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="25" /> Fechar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao26" class="Permissoes OS" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="26" /> Relatórios de OS/Relatórios de OS por Equip./Prod.<br />
        </div>
        
        <div class="sepCol3">
        		<p><strong>Clientes:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao31" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="31" /> Cadastrar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao32" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="32" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao33" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="33" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao34" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="34" /> Excluir<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao35" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="35" /> Visualizar dados Financeiros<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao36" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="36" /> Visualizar Senha<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao37" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="37" /> Cadastrar Equipamento/Produto<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao38" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="38" /> Alterar Equipamento/Produto<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao39" class="Permissoes Clientes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="39" /> Excluir Equipamento/Produto<br />
        </div>
        
        <div class="sepCont"></div>
                
        <div class="sepCol3">
        		<p><strong>Materiais/Serviços:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao41" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="41" /> Cadastrar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao42" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="42" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao43" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="43" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao44" class="Permissoes Materiais" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="44" /> Excluir<br />
        </div>
                        
        <div class="sepCol3">
        		<p><strong>Usuários:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao51" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="51" /> Cadastrar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao52" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="52" /> Consultar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao53" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="53" /> Alterar<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao54" class="Permissoes Usuarios" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="54" /> Excluir<br />
        </div>
                                
        <div class="sepCol3">
        		<p><strong>Avaliações:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao61" class="Permissoes Avaliacoes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="61" /> Consultar OS Avaliadas / Relatórios de Avaliações<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao62" class="Permissoes Avaliacoes" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="62" /> Cadastrar, Alterar e Excluir tópicos<br />
        </div>
        
        <div class="sepCont"></div>
                        
        <div class="sepCol3">
        		<p><strong>Outros:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao71" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="71" /> Relatório Financeiro<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao72" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="72" /> Configurações Gerais<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao73" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="73" /> Estatísticas<br />
                <input type="checkbox" name="Permissoes[]" id="Permissao74" class="Permissoes Outros" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11')) ? "checked" : "") : (in_array('11')) ? "checked" : "";?> value="74" /> Relatório de Acessos<br />
        </div>
        
        <div class="sepCont"></div>
        
        <input type="submit" name="Envia" value="Salvar" />
</form>