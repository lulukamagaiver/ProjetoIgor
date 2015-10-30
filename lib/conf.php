<?php
		include_once('util.php');
		include_once('mailer/PHPMailerAutoload.php');
		include_once('sessao.php');
		include_once('tabs/tabconfiguracoes.php');
		include_once('tabs/tablogincliente.php');
		include_once('tabs/tabclientes.php');
		include_once('tabs/tabadmm.php');
		include_once('tabs/tabchamado.php');
		include_once('tabs/tabequipamento.php');
		include_once('tabs/tabmateriaischamado.php');
/*
*Classe responsavel por manipular MySql
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/


class Conf extends Util{
//		public $siteURL = "http://localhost:8080/Chamados3/";
		public $siteURL = "http://datahelp.ml/";
		public $siteTitle = "Service7 - HelpDesk - Tecnofood - Atendimento Tecnico";
		//public $EmailHost = "smtp.gmail.com";
		public $EmailHost = "127.0.0.1";
		public $EmailAut = "no@datahelp.ml";
		//public $EmailAut = "no-reply@servicesete.com.br";
		public $EmailPass = "@dmin2014";
		public $EmailPorta = 587;
		//public $SecurySmtp = "tls";
		public $LimiteSessao  = 3600; //segundos
		
//		public $siteURLDir = "/Chamados3/";
		public $siteURLDir = "/";
		
		
		//construtor
		public function Conf(){
				
		}
		
		
		//Emails do sistema
		public function Emails($email = null, $msg = null, $ass = 'Email Automático'){
						$Cf = new tabConfiguracoes;
						$Checks = explode(',',$Cf->Checks);
						
						//echo var_dump('--->'.$email); 
						
						$mensagem = '
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Service7</title>
						<style type="text/css">
						body,td,th {
							color: #000;
						}
						body {
							background-color: #FFF;
							margin-left: 0px;
							margin-right: 0px;
						}
						</style>
						</head>
						<body topmargin="0" marginheight="0">
						<table width="700" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td height="200"><img src="'.$this->siteURL.'imgs/icones/logo.png" width="300" /></td>
						  </tr>
						  <tr>
							<td><p>'.$msg.'</p></td>
						  </tr>
						  <tr>
							<td height="80" style="color:#F00;">Este é um e-mail automático. Por favor não responda.</td>
						  </tr>
						</table>
						</body>
						</html>
						';
						$mail             = new PHPMailer();
						$mail->CharSet 	  = 'UTF-8';
						$mail->IsSMTP(); // telling the class to use SMTP
						$mail->Host       = $this->EmailHost; // SMTP server
						$mail->SMTPAuth   = true;                  // enable SMTP authentication
						$mail->Host       = $this->EmailHost; 			// sets the SMTP server
						$mail->Port       = $this->EmailPorta;                    // set the SMTP port for the GMAIL server
						$mail->SMTPSecure = $this->SecurySmtp;
						$mail->Username   = $this->EmailAut; 			// SMTP account username
						$mail->Password   = $this->EmailPass;        // SMTP account password
						$mail->SetFrom($this->EmailAut, $this->siteTitle);
						//$mail->AddReplyTo($this->EmailAut, $this->siteTitle);
						$mail->Subject    = $ass;
						$mail->AltBody    = ""; // optional, comment out and test
						$mail->MsgHTML($mensagem);
						
						$mail->AddAddress($email, "");
						//$mail->SMTPDebug  = 1;
						if(in_array('18',$Checks)) $mail->AddAddress($Cf->Email, "");
						if(!in_array('20',$Checks)) $mail->Send();
		}
		
		
		//Envia email ao add comentario
		public function EmailChamado($email = null, $msg = null, $ass = 'Email Automático', $IDCH = null){
				$Cf = new tabConfiguracoes;
				$Checks = explode(',',$Cf->Checks);
				$S = new Sessao;
				
				$Cf = new tabConfiguracoes;
				$Os = new tabChamado($IDCH);
				$Cl = new tabClientes($Os->IdCl);
				$Eq = new tabEquipamento($Os->IDEquipamento);
				$Us = new tabAdmm($Os->IDTecnico);
				$TMat = new tabMateriaisChamado;
				$TMat->SqlWhere = "IDChamado = '".$Os->ID."'";
				$TMat->MontaSQL();
				$TMat->Load();
				
						$mensagem = '
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Service7</title>
						<style type="text/css">
						body,td,th {
							color: #000;
						}
						body {
							background-color: #FFF;
							margin-left: 0px;
							margin-right: 0px;
						}
						table {
							border-spacing:1px;
							font-family:Verdana, Arial, Helvetica, sans-serif;
							font-size:11px;
							width:657px;
							padding:10px;
						}
						td, th {
							padding: 4px;
						}
						thead th, tbody th {
							padding-top: 5px;
						}
						thead th {
							text-align: center;
							font-weight: normal;
						}
						thead th.topo {
							font-size:12px;
						}
						tbody th {
							font-weight: normal;
							text-align: right;
						}
						tbody th.nomecli {
							text-align: left;
						}
						.strong, .strong2 {
							font-weight: bold;
						}
						.strong2 {
							padding-left: 62px;
						}
						.valortotal {
							color:#FF0000;
						}
						.tit_cliente {
							text-align: left;
							font-weight:bold;
						}
						.tit_demais {
							text-align: right;
							font-weight:bold;
						}
						/*************************/
						.equi_tit {
							text-align: center;
							font-weight: bold;
						}
						.equi_dados {
							text-align: center; }
						.equi_total {
							font-weight: bold;
							text-align: center;
						}
						/*************************/
						.titos {
							font-weight:bold;
							font-size:12px;
						}
						.espos {
							margin-right:270px;
						}
						.esq {
							text-align: left;
						}
						.esqtam {
							text-align: left;
							width: 30%;
						}
						.topoos {
							font-size:12px;
							width: 60%;
						}
						.obs {
							font-size:10px;
							font-weight:bold;
						}
						.assinatura {
							text-align: center;
						}
						</style>
						<link rel="stylesheet" type="text/css" href="'.$this->siteURL.'css/refin.css">
						</head>
						<body topmargin="0" marginheight="0">
						<table>
								<thead>
										<tr>
												<th><img src="'.$this->siteURL.'imgs/icones/logo.png" height="60"></th>
						
												<th colspan="3" class="topoos">
												<span class="strong">'.$Cf->NomeFantasia.'</span><br />
												<br />
												'.$Cf->End.'<br />
												TEL: '.$Cf->Tel1.((!empty($Cf->Tel2)) ? " | ".$Cf->Tel2 : "").'
												</th>
										</tr>
										
										<tr>
												<th colspan="4"><hr></th>
										</tr>
										
										<tr>
												<th colspan="4" class="titos">
												CHAMADO #'.$this->COD($Os->ID).'
												</th>
										</tr>
										
										<tr>
												<th colspan="4"><hr></th>
										</tr>
								</thead>
						
								<tbody>
										<tr>
												<th colspan="4" class="esq">
												<span class="strong">CLIENTE:</span> '.$Cl->Nome.'<br />
												<span class="strong2">'.(($Cl->Contrato == 1) ? "(COM CONTRATO)" : "").'</span>
												</th>
										</tr>
								
										<tr>
												<th colspan="4" class="esq">
												<span class="strong">ENDEREÇO:</span> '.$Cl->Endereco.'	  </th>
										</tr>
						
										<tr>
												<th colspan="4" class="esq">
												<span class="strong">TELEFONE:</span> '.$Cl->Tel.'	  </th>
										</tr>
						
										<tr>
												<th colspan="4" class="esq">
												<span class="strong">RESPONSÁVEL:</span> '.$Os->Contato1.'
												</th>
										</tr>
						
										<tr>
												<th colspan="4"><hr></th>
										</tr>
						
										<tr>
												<th colspan="2" class="esq"><span class="strong">EQUIP. / PRODUTO: </span>'.$Eq->Equipamento.'</th>
												<th colspan="2" class="esqtam"><span class="strong">DATA: </span>'.date('d/m/Y',strtotime($Os->Data)).'</th>
										</tr>
						
										<tr>
												<th colspan="2" class="esq"><span class="strong">TÉCNICO: </span>'.(($Os->IDTecnico != 0) ? $Us->Apelido : "Todos").'</th>
										</tr>
										
										<tr>
										<th colspan="4"><hr></th>
										</tr>
						
										<tr>
												<th colspan="4" class="desc" style="text-align: center;"><span class="strong">DESCRIÇÃO DO CHAMADO</span></th>
										</tr>
						
										<tr>
												<th colspan="4" class="esq" style="text-align: justify;">'.$Os->Descricao.'<br /><br /><br /><br /><br /><br /><br /></th>
										</tr>
						
										<tr style="text-align:center;">
												<td class="assinatura">__________________________________<br />'.$S->Nome.'</td>
												<td></td>
												<td colspan="2" class="assinatura">__________________________________<br />'.$Cl->Nome.'</td>
										</tr>	
						
										<tr class="trcomentarios" style="display: table-row;">
												<th colspan="3"><hr></th>
										</tr>
										
										<tr class="trcomentarios" style="display: table-row;">
												<th colspan="3" class="desc" style="text-align:center;"><span class="strong">INTERAÇÕES</span></th>
										</tr>
						';
						
						$Cm = new DBConex;
						$Cm->Tabs = array('ID','Autor','Data','Comentario');
						$Cm->Query = "SELECT * FROM comentariochamado WHERE IdCh = '".$Os->ID."'";
						$Cm->MontaSQLRelat();
						$Cm->Load();
				
						for($b=0;$b<$Cm->NumRows;$b++){
								$Us2 = new tabAdmm($Cm->Autor);
								$mensagem .= '
								<tr height="2" class="trcomentarios" style="display: table-row;">
								<td colspan="4" style="background:url('.$this->siteURL.'imgs/icones/bg_linha_td.gif) repeat-x;"></td>
								</tr>
								<tr class="trcomentarios" style="display: table-row;">
								<th style="color: #969696; text-align:center;">'.(($Cm->Autor != 0) ? $Us2->Apelido : "SISTEMA").'<br />'.date('d/m/Y às H:i:s',strtotime($Cm->Data)).'</th>
								<th style="color: #969696" colspan="2" class="esq">
								'.nl2br($Cm->Comentario).' 
								</th>'; 
						$Cm->Next();
						}
						$mensagem .= '
							  </tbody>
						</table>
						</body>
						</html>
						';
						$mail             = new PHPMailer();
						$mail->CharSet 	  = 'UTF-8';
						$mail->IsSMTP(); // telling the class to use SMTP
						$mail->Host       = $this->EmailHost; // SMTP server
						$mail->SMTPAuth   = true;                  // enable SMTP authentication
						$mail->Host       = $this->EmailHost; 			// sets the SMTP server
						$mail->Port       = $this->EmailPorta;                    // set the SMTP port for the GMAIL server
						$mail->SMTPSecure = $this->SecurySmtp;
						$mail->Username   = $this->EmailAut; 			// SMTP account username
						$mail->Password   = $this->EmailPass;        // SMTP account password
						$mail->SetFrom($this->EmailAut, $this->siteTitle);
						//$mail->AddReplyTo($this->EmailAut, $this->siteTitle);
						$mail->Subject    = $ass;
						$mail->AltBody    = ""; // optional, comment out and test
						$mail->MsgHTML($mensagem);
						$mail->AddAddress($email, "");
						
						if(in_array('18',$Checks)) $mail->AddAddress($Cf->Email, "");
						if(!in_array('20',$Checks)) $mail->Send();
		}

}
?>