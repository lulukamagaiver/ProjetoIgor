<?php
		$S->PrAcess(52); //Consultar usuario
		
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tabclientes.php');
		require_once('lib/relatorios.php');
		require_once('lib/search.php');
		
		$B = new Search;
		$B->Like('ID,Nome,Email',((!empty($_POST['Busca'])) ? $_POST['Busca'] : ""));
		
		$VerMais = 0;
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				
				if(((!empty($url[0])) && ($url[0] == 'visualizar')) && (is_numeric($url[1]))){
						$VerMais = 1;
				}	
				
				
				//DELETAR
				if(((!empty($url[1])) && ($url[1] == 'deletar')) && (is_numeric($url[2]))){
					if($S->Pr(54)){ //Deletar usuario
						$Del = new tabAdmm;
						$Del->Delete($url[2]);
						if($Del->Result) $W->AddAviso('Usuário removido.','WS');
						else $W->AddAviso('Problemas ao deletar usuário','WE');
					}else $W->AddAviso('Você não possui permissão para esta ação.','WE');
				}	
		}
		
		$Us = new tabAdmm;
		$Us->SqlWhere = $B->Where;
		$Us->MontaSQL();
		$Us->Load();
?>

<?php
if($VerMais == 0) :
		$tt = new tabAdmm;
		$tt->SqlWhere = $B->Where;
		$tt->SqlOrder = "Nome ASC";
		$tt->MontaSQL();
		$tt->Load();
?>

<h1>Consultar Usuários</h1>

		<form method="post" style="float:left; width:100%;">		
        <div class="sepCont"></div>
                		<div class="inputsLarge">
                        		Busca por Código, Nome ou E-mail: <br />
                                <input type="text" name="Busca" id="Busca" value="<?php echo (!empty($_POST['Busca'])) ? $_POST['Busca'] : "";?>" />
                        </div>
		
        <input name="" type="image" style="width:30px; height:30px; float:left; margin-left:0px;" src="imgs/icones/search.png" />
        <div class="sepCont" style="height:20px;"></div>        
        </form>  
<?php
		$t = new Relat();
		$t->WidthCols = array('90','500','297','70');
		$t->Cols = array('ID','Nome','Email','action');
		$t->Totais = array(0,0,0,0);
		$t->Formato = array('cod','','','');
		$t->Actions = '
		'.(($S->Pr(53)) ? '<a href="'.$URL->siteURL.'usuarios/visualizar/{id}/"><img class="action" src="imgs/icones/edit.png" width="26" height="26" /></a>' : '<img class="action" src="imgs/icones/edit.png" width="26" height="26" onclick="AcNegado();" />').'
		'.(($S->Pr(54)) ? '<a href="'.$URL->siteURL.'usuarios/visualizar/deletar/{id}/"><img class="action" src="imgs/icones/delete.png" width="26" height="26" /></a>' : '<img onclick="AcNegado();" class="action" src="imgs/icones/delete.png" width="26" height="26" />').'
		';
		$t->Query = $Us->Query;
		$t->setTitulos(array('COD:center','Nome:left','E-mail:left','Açoes:Center'));
		$t->showTab();
?>

<?php elseif($VerMais == 1) : ?>

<?php
		//Executa açoes submit
		if(!empty($_POST['Envia'])){
				if($S->Pr(53)){ //Alterar Usuario
					unset($_POST['Envia']);
					//$_POST = str_replace("'","\'",$_POST);
							if((!empty($_POST['Nome'])) && (!empty($_POST['Login']))){
									if(!empty($_POST['Permissoes'])){
											if(empty($_POST['Apelido'])) $_POST['Apelido'] = $_POST['Nome'];
											$PAnt = $_POST['Permissoes'];
											$SAnt = $_POST['Senha'];
												
											$_POST['Permissoes'] = implode("|-|",$_POST['Permissoes']);
											
													$Us = new tabAdmm($url[1]);
													$_POST['Senha'] = ($_POST['Senha']) ? md5($_POST['Senha']) : $Us->Senha;
													$Us->GetValPost();
													$Us->Status = 1;
													$Us->Update($url[1]);
													
													if($Us->Result){
														$W->AddAviso('Usuário alterado com sucesso.','WS');
														$_POST = "";
														$Us->Permissoes = "";
													}
													else{
														$W->AddAviso('Problemas ao alterar usuário, tente novamente.','WE');
														$_POST['Permissoes'] = $PAnt;
														$_POST['Senha'] = $SAnt;
													}
									}else $W->AddAviso('Defina pelo menos uma permissão ao usuário.','WA');
							}else $W->AddAviso('Preencha os campos com *.','WA');
				}else $W->AddAviso('Você não possui pemissão para esta ação.','WE');
		}
		//Fim acoes submit
?>

		<h1>Consultar Usuário #<?php echo $URL->COD($url[1]);?></h1>
        
		<?php
				$Us = new tabAdmm;
				$Us->SqlWhere = "ID = '".$url[1]."'";
				$Us->MontaSQL();
				$Us->Load();
				
				$Us->Permissoes = explode("|-|",$Us->Permissoes);
		?>
        

<form method="post">
		<div class="inputsLarge">
        		Nome: *<br />
                <input name="Nome" type="text" id="Nome" value="<?php echo (!empty($_POST['Nome'])) ? $_POST['Nome'] : ((!empty($Us->Nome)) ? $Us->Nome : ""); ?>"/>
        </div>
        
        <div class="sepCont"></div>
        
		<div class="inputsLarge">
        		E-mail:<br />
                <input name="Email" type="text" id="Email" value="<?php echo (!empty($_POST['Email'])) ? $_POST['Email'] : ((!empty($Us->Email)) ? $Us->Email : ""); ?>"/>
        </div>
        
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Exibição:<br />
                <input name="Apelido" type="text" id="Apelido" value="<?php echo (!empty($_POST['Apelido'])) ? $_POST['Apelido'] : ((!empty($Us->Apelido)) ? $Us->Apelido : ""); ?>"/>
        </div>
                
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Login: *<br />
                <input name="Login" readonly type="text" id="Login" value="<?php echo (!empty($_POST['Login'])) ? $_POST['Login'] : ((!empty($Us->Login)) ? $Us->Login : ""); ?>"/>
        </div>
                
        <div class="sepCont"></div>
        
		<div class="inputs">
        		Senha:<br />
                <input name="Senha" type="password" id="Senha" value="<?php echo (!empty($_POST['Senha'])) ? $_POST['Senha'] : ""; ?>" maxlength="14" />
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
        <h4>Permissões</h4>
        <div class="sepCont"></div>
        
        <div class="sepCol3">
        		<p><strong>Chamados:</strong></p>
                <input type="checkbox" name="Permissoes[]" id="Permissao11" class="Permissoes Chamados" <?php echo (empty($_POST['Permissoes'])) ? ((empty($Us->Permissoes)) ? "checked" : (in_array('11',$Us->Permissoes)) ? "checked" : "") : (in_array('11',$_POST['Permissoes'])) ? "checked" : "";?> value="11" /> Consultar<br />
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

<script>
		$('.sepCol2').css('padding-left','0px');
		
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
        
<?php endif;?>