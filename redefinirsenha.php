<?php
		session_start();
		require_once('lib/tabs/tabadmm.php');
		require_once('lib/tabs/tablogincliente.php');
		require_once('lib/warnings.php');
		require_once('lib/url.php');
		require_once('lib/sessao.php');
		
		$URL = new URL;
		
		$W = new Warnings;
		
		
		if(!empty($_POST['EnviaRec'])){
				if((!empty($_POST['codigo'])) && (!empty($_POST['novasenha'])) && (!empty($_POST['confirmarsenha']))){
						if($_POST['novasenha'] == $_POST['confirmarsenha']){
								$Us = new tabAdmm;
								$Us->SqlWhere = "Senha = '".$_POST['codigo']."'";
								$Us->MontaSQL();
								$Us->Load();
								$Chave = md5($_POST['novasenha']);
								$msg = '
								<p>Confirmação de redefinição de senha dia '.date('d/m/Y à\s H:i:s').'
								</p>
								';
								if($Us->NumRows > 0){
										$Us->Senha = $Chave;
										$Us->Update($Us->ID);
										if($Us->Result){
												$W->AddAviso('Você redefiniu sua senha.');
												$URL->Emails($_POST['Email'],str_replace('{senha}',$Chave,$msg),'Redefinição de Senha');
												echo "<script>document.location = '".$URL->siteURL."login/';</script>";
												exit;
										}$W->AddAviso('Houve um erro ao atender seu pedido. Tente novamente.','WE');
								}else{
										$UsC = new tabLoginCliente;
										$UsC->SqlWhere = "Senha = '".$_POST['codigo']."'";
										$UsC->MontaSQL();
										$UsC->Load();
										
										if($UsC->NumRows > 0){
												$UsC->Senha = $Chave;
												$UsC->Update($UsC->ID);
												if($UsC->Result){
														$W->AddAviso('Você redefiniu sua senha.');
														$URL->Emails($_POST['Email'],str_replace('{senha}',$Chave,$msg),'Redefinição de Senha');
														echo "<script>document.location = '".$URL->siteURL."login/';</script>";
														exit;
												}$W->AddAviso('Houve um erro ao atender seu pedido. Tente novamente.','WE');
										}else $W->AddAviso('Código Inválido.','WE');
								}
						}else $W->AddAviso('Você inseriu duas senhas diferentes.','WA');
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
  <form name="form1" method="post" action="" style="margin-top:20px">
            Código:<br />
            <label for="codigo"></label>
            <input type="text" name="codigo" id="codigo">
            <br /><br />
            Nova Senha:<br />
            <label for="novasenha"></label>
            <input type="password" name="novasenha" id="novasenha">
            <br />
			Confirmar Nova Senha:<br />
            <label for="confirmarsenha"></label>
            <input type="password" name="confirmarsenha" id="confirmarsenha">
            <br />
			<input type="submit" name="EnviaRec" value="Entrar" style="display:none;" />
            <div style="margin:12px 0 0 20px;" class="btnAct" onclick="return $('input[name=EnviaRec]').click();"><img src="<?php echo $URL->siteURL;?>imgs/icones/security.png" /> Redefinir</div>
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