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
								
								echo "<script>document.location = '".$URL->siteURL."';</script>";
								exit;
								
						}else $W->AddAviso('Nenhum usuário encontrado com estas credenciais.','WE');
						
				}else $W->AddAviso('Preencha todos os campos.','WA');
		}
		
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8">
    <title><?php echo $URL->siteTitle;?></title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
	<script src="<?php echo $URL->siteURL;?>js/jquery.1.10.2.js"></script>
    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo $URL->siteURL;?>css/style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="<?php echo $URL->siteURL;?>css/style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="<?php echo $URL->siteURL;?>css/style.responsive.css" media="all">


    <script src="<?php echo $URL->siteURL;?>js/jquery.js"></script>
    <script src="<?php echo $URL->siteURL;?>js/script.js"></script>
    <script src="<?php echo $URL->siteURL;?>js/script.responsive.js"></script>


<style>.content .postcontent-0 .layout-item-0 { padding-right: 10px;padding-left: 10px;  }
.ie7 .post .layout-cell {border:none !important; padding:0 !important; }
.ie6 .post .layout-cell {border:none !important; padding:0 !important; }
#box2{display:none}
#box, #box2{
	width:300px;
	height:300px;
	position:absolute;
	left:50%;
	top:50%;
	margin-left:-160px;
	margin-top:-160px;
	background-color:#FFF;
	box-shadow:0px 0px 20px #000;
	-moz-box-shadow:0px 0px 20px #000;
	-webkit-box-shadow:0px 0px 20px #000;
	-o-box-shadow:0px 0px 20px #000;
	-ms-box-shadow:0px 0px 20px #000;
	padding:10px;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
}
#resultado{
	color:#F00;
	margin-left:35px;
	margin-top:-25px;
}
</style>
</head>
<body>

<div id="main">
    <div class="sheet clearfix">
            <div class="layout-wrapper">
                <div class="content-layout">
                    <div class="content-layout-row">
                        <div class="layout-cell content"><article class="post article">
                                
                                                
                <div class="postcontent postcontent-0 clearfix"><div class="content-layout">
    <div class="content-layout-row">
    <div class="layout-cell layout-item-0" style="width: 100%" >
        <p><br></p><p><br></p>
        <p style="text-align: center;">
         <img width="372" height="88" alt="" class="lightbox" src="<?php echo $URL->siteURL;?>imgs/icones/Logo_service7_Tela_Login.png" style="margin-left: 0px; "><br></p>
		 
		 <form name="form1" method="post" action="" style="margin-top:50px">
		 
         <span style="margin-left:80px">Login</span>
		 
        <input style="width:200px; margin-left:80px" type="text" name="Login" id="Login"><br>
		
         <span style="margin-left:80px">Senha</span>
		 
         <input style="width:200px; margin-left:80px" type="password" name="Senha" id="Senha">
		 <br>
		 <input type="submit" name="Envia" value="Entrar" style="display:none;" />
        <p style="text-align: center;">&nbsp;<input type="submit" name="Envia" value="Entrar" class="button" />&nbsp;<br>
        </p>

		<div class="btnAct" onclick="$('#box').fadeOut(); $('#box2').fadeIn()"> 
		<p style="text-align: center;">Recuperar Senha</p>
		</div>
			
		</form>
    </div>
    </div>
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
            <br /><br>
			
			<input type="submit" name="EnviaRec" value="Redefinir" onclick="return $('input[name=EnviaRec]').click();" class="button" />
			
            
			<input type="submit" value="Cancelar" onclick="$('#box2').fadeOut(); $('#box').fadeIn()" class="button" />
			
</form>
</div>

</div>


</article></div>
                    </div>
                </div>
            </div>
    </div>
<footer class="footer">
  <div class="footer-inner">
<div class="Port">Sistema desenvolvido por <a href="http://datanove.com.br">Data Nove Tecnologia</a> | &copy; 2014 - <?=date("Y");?> | V. 1.1.0</div>
  </div>
</footer>

</div>

<div id="Warnings">
		<div class="Faixa">
        		<div class="Cont">
                		<div class="FechaWarning" onClick="$('#Warnings').fadeOut()"></div>
                        <div class="ResultWarning"></div>
                </div>
        </div>
</div>
<?php $W->Show();?>
<a style="display:scroll;position:fixed;bottom:70px;right:5px;" target="_blank"
href="http://www.tecnofooddf.com.br" title=""><img src="<?php echo $URL->siteURL;?>imgs/icones/Logo_Tecnofood_Tela_Login.png"/></a>
</body>
</html>