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
        <title><?php echo $URL->siteTitle;?></title>
</head>

<body>
		
        
<div id="box">
<img src="<?php echo $URL->siteURL;?>imgs/icones/logo-login.png" width="300" height="120" />
  <form name="form1" method="post" action="">
            Login:<br />
            <label for="login"></label>
            <input type="text" name="Login" id="Login">
            <br />
            Senha:<br />
            <label for="senha"></label>
            <input type="password" name="Senha" id="Senha">
            <br />
			<input type="submit" name="Envia" value="Entrar" />
</form>
</div>
      
<div class="Port">Sistema desenvolvido por <a href="http://wmstudios.net">WM Studio's</a> | &copy; 2014 | V. 1.0.0</div>
        
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