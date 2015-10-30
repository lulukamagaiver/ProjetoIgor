<?php
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tablogincliente.php');
		
		if(!empty($_POST['Envia'])){
				if((!empty($_POST['SenhaAnt'])) && (!empty($_POST['SenhaNova'])) && (!empty($_POST['ConfSenha']))){
						if($_POST['SenhaNova'] == $_POST['ConfSenha']){
								if($S->Status == 1){
										$Sen = new tabAdmm;
								}elseif($S->Status == 2){
										$Sen = new tabLoginCliente;
								}
								
								$Sen->SqlWhere = "ID = '".$S->ID."'";
								$Sen->MontaSQL();
								$Sen->Load();
								
								
								$SenhaAnt = ($S->Status == 1) ? md5($_POST['SenhaAnt']) : $_POST['SenhaAnt'];
								$SenhaNova = ($S->Status == 1) ? md5($_POST['SenhaNova']) : $_POST['SenhaNova'];
								
								if($SenhaAnt == $Sen->Senha){
										$Sen->Senha = $SenhaNova;
										
										$Sen->Update($S->ID);
										
										if($Sen->Result) $W->AddAviso('Você alterou sua senha com sucesso.');
										else $W->AddAviso('Houve algum problema ao alterar sua senha. Tente novamente.','WE');
								}else $W->AddAviso('Você inseriu uma senha incorreta. Tente novamente.','WA');
						}else $W->AddAviso('Você deve confirmar a senha.','WA');
				}else $W->AddAviso('Preencha todos os campos.','WA');
						
						
		}
		
?>

<h1>Alterar Senha</h1>

<form method="post">
		<div class="inputs">
				Senha Anterior: *<br />
				<input type="password" name="SenhaAnt" id="SenhaAnt" />
		</div>
		
		<div class="sepCont"></div>
		
		<div class="inputs">
				Senha Nova: *<br />
				<input type="password" name="SenhaNova" id="SenhaNova" />
		</div>
		
		<div class="sepCont"></div>
		
		<div class="inputs">
				Confirmar Senha: *<br />
				<input type="password" name="ConfSenha" id="ConfSenha" />
		</div>	
		
		<div class="sepCont"></div>
		
		<input style="display:none;" type="submit" name="Envia" value="ok" />
		<div class="btnAct" onClick="return $('input[name=Envia]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" /> Salvar</div>
</form>