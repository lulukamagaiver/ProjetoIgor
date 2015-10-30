<?php
		require_once('../lib/sessao.php');
		require_once('../lib/tabs/tabchamado.php');
		require_once('../lib/tabs/tabadmm.php');
		require_once('../lib/tabs/tabcomentariochamado.php');
		require_once('../lib/tabs/tabstatuschamados.php');
		require_once('../lib/url.php');
		require_once('../lib/warnings.php');
		
		$S = new Sessao;
		
		$W = new Warnings;
		
		$URL = new URL;
		
		if(!empty($_GET['id'])){
						
		$Cm = new tabChamado;
		$Cm->SqlWhere = "ID = '".$_GET['id']."'";
		$Cm->MontaSQL();
		$Cm->Load();
		
		$St = new tabStatusChamados;
		$St->SqlWhere = "ID = '".$Cm->Status."'";
		$St->MontaSQL();
		$St->Load();
		$StaAnt = $St->Descricao;
		
		$Us = new tabAdmm;
		$Us->SqlWhere = "ID = '".$Cm->IDTecnico."'";
		$Us->MontaSQL();
		$Us->Load();
		$UsAnt = ($Cm->IDTecnico != 0) ? $Us->Apelido : "Todos";
								
				$Cm->IDTecnico = $S->ID;
				$Cm->Status = 2;
				if((empty($Cm->TempoEspera)) || ($Cm->TempoEspera == '0000-00-00 00:00:00')) $Cm->TempoEspera = date('Y-m-d H:i:s');
				$Cm->Update($_GET['id']);
				
				if($Cm->Result){
						$C = new tabComentarioChamado;
						$C->AddComentario($S->Apelido.' alterou o Status deste chamado:<br />De: '.$StaAnt.'<br /> Para: Em atendimento',$_GET['id']);
						$C->AddComentario($S->Apelido.' alterou o Técnico deste chamado:<br />De: '.$UsAnt.'<br /> Para: '.$S->Apelido,$_GET['id']);
						echo "<script>parent.document.location.reload();</script>";
				}else echo "<script>parent.AddAviso('Problemas ao tentar atender chamado.','WA');</script>";
		}else echo "<script>parent.AddAviso('Nenhum chamado definido para ser atendido.','WA');</script>";
