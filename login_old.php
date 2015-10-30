<?php
		session_start();
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tablogincliente.php');
		require_once('lib/warnings.php');
		require_once('lib/url.php');
		require_once('lib/sessao.php');
		
		$URL = new URL;
		
		$W = new Warnings;
		
		
		if(!empty($_POST['Envia'])){
				unset($_POST['Envia']);	
				
				if((!empty($_POST['Login'])) && (!empty($_POST['Senha']))){
						$Log = new tabAdmm;
						$Log->SqlWhere = "Login = '".$_POST['Login']."' AND Senha = '".md5($_POST['Senha'])."'";
						$Log->MontaSQL();
						$Log->Load();
						
						$Log2 = new tabLoginCliente;
						$Log2->SqlWhere = "Login = '".$_POST['Login']."' AND Senha = '".$_POST['Senha']."'";
						$Log2->MontaSQL();
						$Log2->Load();
						
						if($Log->NumRows > 0){
								$S = new Sessao;
								$S->SetSessao('Nome',$Log->Nome);
								$S->SetSessao('Apelido',$Log->Apelido);
								$S->SetSessao('Status',$Log->Status);
								$S->SetSessao('ID',$Log->ID);
								$S->SetSessao('Email',$Log->Email);
								$S->SetSessao('P',explode('|-|',$Log->Permissoes));
								
								echo "<script>document.location = '".$URL->siteURL."';</script>";
								exit;
								
						}elseif($Log2->NumRows > 0){
								$S = new Sessao;
								$S->SetSessao('Nome',$Log2->Nome);
								$S->SetSessao('Apelido',$Log2->Nome);
								$S->SetSessao('Status','2');
								$S->SetSessao('ID',$Log2->ID);
								$S->SetSessao('Email',$Log2->Email);
								$S->SetSessao('Cl',$Log2->Clientes);
								$per = "11|-|22|-|26";
								$S->SetSessao('P',explode('|-|',$per));
								
								echo "<script>document.location = '".$URL->siteURL."areacliente/';</script>";
								exit;
								
						}else $W->AddAviso('Nenhum usuário encontrado com estas credenciais.','WE');
						
				}else $W->AddAviso('Preencha todos os campos.','WA');
		}
		
		if(!empty($_POST['EnviaRec'])){
				if((!empty($_POST['Login2'])) && (!empty($_POST['Email']))){
						$Us = new tabAdmm;
						$Us->SqlWhere = "Login = '".$_POST['Login2']."' AND Email = '".$_POST['Email']."'";
						$Us->MontaSQL();
						$Us->Load();
						$Chave = md5(uniqid(rand(), true));
						$msg = '
						<p>Para concluir a redefinição de sua senha, acesse o link abaixo:<br />
						'.$URL->siteURL.'redefinirsenha/</p>
						<p>E utilize este código para alterarmos sua senha:<br />
						<strong style="color:#F00">{senha}</strong>
						<br /><br /><br />
						</p>
						';
						if($Us->NumRows > 0){
								$Us->Senha = $Chave;
								$Us->Update($Us->ID);
								if($Us->Result){
										$W->AddAviso('Recebemos seu pedido. Verifique seu e-mail para mais instruções.');
										$URL->Emails($_POST['Email'],str_replace('{senha}',$Chave,$msg),'Redefinição de Senha');
								}else $W->AddAviso('Houve um erro ao atender seu pedido. Tente novamente.','WE');
						}else{
								$UsC = new tabLoginCliente;
								$UsC->SqlWhere = "Login = '".$_POST['Login2']."' AND Email = '".$_POST['Email']."'";
								$UsC->MontaSQL();
								$UsC->Load();
								
								if($UsC->NumRows > 0){
										$UsC->Senha = $Chave;
										$UsC->Update($UsC->ID);
										if($UsC->Result){
												$W->AddAviso('Recebemos seu pedido. Verifique seu e-mail para mais instruções.');
												$URL->Emails($_POST['Email'],str_replace('{senha}',$Chave,$msg),'Redefinição de Senha');
										}else $W->AddAviso('Houve um erro ao atender seu pedido. Tente novamente.','WE');
								}else $W->AddAviso('Não foi encontrado nenhum usuário com estes dados.','WE');
						}
				}else $W->AddAviso('Preencha todos os campos para redefinir sua senha.','WA');
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $URL->siteURL;?>css/login.css"/>
        <script src="<?php echo $URL->siteURL;?>js/jquery.1.10.2.js"></script>
        <title><?php echo $URL->siteTitle;?></title>
</head>

<body>
		
        
<div id="box">
<img src="<?php echo $URL->siteURL;?>imgs/icones/logo-login.png" width="180" style="margin-left:50px" />
  <form name="form1" method="post" action="" style="margin-top:50px">
            Login:<br />
            <label for="login"></label>
            <input type="text" name="Login" id="Login">
            <br />
            Senha:<br />
            <label for="senha"></label> 
            <input type="password" name="Senha" id="Senha">
            <br />
			<input type="submit" name="Envia" value="Entrar" style="display:none;" />
            <div style="margin:12px 0 0 20px;" class="btnAct" onclick="return $('input[name=Envia]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/locked.png" /> Entrar</div>
            <div style="margin:12px 0 0 20px;" class="btnAct" onclick="$('#box').fadeOut(); $('#box2').fadeIn()"><img src="<?php echo $URL->siteURL;?>imgs/icones/security.png" /> Esqueci a senha?</div>
</form>
</div>

<div id="box2">
<img src="<?php echo $URL->siteURL;?>imgs/icones/logo-login.png" width="180" style="margin-left:50px" />
  <form name="form1" method="post" action="" style="margin-top:50px">
            Nos informe seu login e endereço de e-mail, para que possamos restaurar sua senha.<br />
					 Login:<br />
            <label for="senha"></label>
            <input type="text" name="Login2" id="Login2">
            <br />
            Email:<br />
            <label for="senha"></label>
            <input type="text" name="Email" id="Email">
            <br />
			<input type="submit" name="EnviaRec" value="Entrar" style="display:none;" />
            <div class="btnAct" onclick="return $('input[name=EnviaRec]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/right_arrow.png" /> Redefinir</div>
            <div class="btnAct" onclick="$('#box2').fadeOut(); $('#box').fadeIn()"><img src="<?php echo $URL->siteURL;?>imgs/icones/block.png" /> Cancelar</div>
</form>
</div>
      
<div class="Port">Sistema desenvolvido por <a href="http://wmstudios.net">WM Studio's</a> | &copy; 2014 | V. 1.1.0</div>
        
<div id="Warnings">
		<div class="Faixa">
        		<div class="Cont">
                		<div class="FechaWarning" onClick="$('#Warnings').fadeOut()"></div>
                        <div class="ResultWarning"></div>
                </div>
        </div>
</div>
<?php $W->Show();?>
</body>
</html>