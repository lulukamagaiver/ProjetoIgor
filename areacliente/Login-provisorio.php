<?php
		session_start();
		require_once('lib/tabs/tabadmm.php');
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
						
						if($Log->NumRows > 0){
								$S = new Sessao;
								$S->SetSessao('Nome',$Log->Nome);
								$S->SetSessao('Apelido',$Log->Apelido);
								$S->SetSessao('Status',$Log->Status);
								$S->SetSessao('ID',$Log->ID);
								$S->SetSessao('Email',$Log->Email);
								$S->SetSessao('P',explode('|-|',$Log->Permissoes));
								
								echo "<script>document.location = '".$URL->siteURL."';</script>";
								
						}else $W->AddAviso('Nenhum usuário encontrado com estas credenciais.','WE');
						
				}else $W->AddAviso('Preencha todos os campos.','WA');
		}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $URL->siteURL;?>css/login.css"/>
        <script src="<?php echo $URL->siteURL;?>js/jquery.1.10.2.js"></script>
        <title>Service7 - HelpDesk - Tecnofood - Atendimento Técnico</title>
        
        <style>
		body{
			background-color:#DEDEDE;
			color:#5c5c5c;
			font-family:"Droid Serif",serif;
			font-size:15px;
			font-style:italic;
			background-image:url(<?php echo $URL->siteURL;?>imgs/icones/fundo-body.png);
			background-position:0 0;
			background-repeat:no-repeat;
		}
		
		.fundoLog{
			width:1000px;
			height:350px;
			position:absolute;
			bottom:0px;
			left:50%;
			margin-left:-500px;
			display:table;
		}
		
		.LogEsq, .LogDir{
			width:500px;
			float:left;
		}
		
		.LogDir{
			width:450px;
			margin-left:50px;
			font-family:Verdana, Geneva, sans-serif;
		}
		
		.LogDir p.strong{
			font-size:18px;
		}
		
		.rodapeLog{
			width:100%;
			height:50px;
			background-color:#1B3E68;
			position:absolute;
			top:100%;
			left:0px;
			display:table;
			text-align:center;
			line-height:50px;
			color:#FFF;
		}
		
		input[type=submit]{
			padding:2px;
			margin:5px 0px;
			background-color:#999;
			border:none;
			border-radius:0px;
			-webkit-border-radius:0px;
			height:20px;
			line-height:20px;
			font-weight:normal;
			line-height:1px;
			font-style:italic;
		}
		</style>
</head>

<body>
        <div class="fundoLog">
				<div class="LogEsq">
                <br /><br /><br /><br /><br />
                <img src="<?php echo $URL->siteURL;?>imgs/icones/logo.png" style="margin-left:160px;" width="180" />
                <br /><br /><br /><br />
                <p><strong>Prezado cliente,</strong></p><br />
                <p>Bem-vindo ao atendimento online TECNOFOOD ASSISTÊNCIA TÉCNICA. <br />Se você já é cliente cadastrado, digite seu  <strong>login</strong> e <strong>senha</strong> para  solicitar  ou  acompanhar  um chamado técnico.​</p>
                </div>
                <div class="LogDir">
                		<form method="post" action="http://www.sinterativo.com.br/funcoes/verifica_login.php"><br /><br /><br />
                		<p class="strong">Acesse sua conta</p><br /><br />
                        Login:<br />
                        <input name="usuario" type="text" id="usuario" size="30"  /><br /><br />
                        Senha:<br />
                        <input name="senha" type="password" id="senha" size="30" />
                        <br />
                        <input type="submit" value="Entrar" />
                        </form><br /><br /><br /><br />
                        <p>Dúvidas ligue: 61-3213 1523</p> 
                </div>
        </div>
        
        <div class="rodapeLog">
        <p>Tempo Bom Assistência Técnica LTDA - Service7 HelpDesk - Sinterativo sistemas web</p>
        </div>
</body>
</html>