<?php
		require_once('url.php');
		require_once('util.php');
		require_once('warnings.php');
/*
*Classe responsavel por exibir relatorios
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class Sessao{
		public $Nome = null;
		public $Status = null;
		public $Apelido = null;
		public $Email = null;
		public $ID = null;
		public $P = null;
		public $prefix = "admm_tecnofood_";
		
		public function Sessao(){
				if(!empty($_SESSION[$this->prefix.'Nome'])){
					$this->Nome = $_SESSION[$this->prefix.'Nome'];
					$this->ID = $_SESSION[$this->prefix.'ID'];
					$this->Apelido = $_SESSION[$this->prefix.'Apelido'];
					$this->Email = $_SESSION[$this->prefix.'Email'];
					$this->Status = $_SESSION[$this->prefix.'Status'];
					$this->P = $_SESSION[$this->prefix.'P'];
				}
		}
		
		public function SetSessao($Ss,$VSs){
				$_SESSION[$this->prefix.$Ss] = $VSs;
		}
		
		public function Logout(){
				unset($_SESSION[$this->prefix.'Nome']);
				unset($_SESSION[$this->prefix.'ID']);
				unset($_SESSION[$this->prefix.'Apelido']);
				unset($_SESSION[$this->prefix.'Email']);
				unset($_SESSION[$this->prefix.'Status']);
				unset($_SESSION[$this->prefix.'P']);
				unset($_SESSION['registro']);
		}
		
		//Permissoes
		public function Pr($Pr){
				if((in_array($Pr,$this->P)) && ($this->Status == '1')) return true;
				else return false;
		}
		
		//Permissao de pagina
		public function PrAcess($Pr){
				if(!empty($Pr)){
						if((!in_array($Pr,$this->P)) || ($this->Status != '1')){
								$URL = new URL;
								$W = new Warnings;
								
								$W->AddAviso('Você não possui permissão para esta ação.','WE');
								if($this->Status == '1') echo "<script>document.location = '".$URL->siteURL."';</script>";
								if($this->Status == '2') echo "<script>document.location = '".$URL->siteURL."areacliente/';</script>";
								exit;
						}
				}else{
						if($this->Status != '1'){
								$URL = new URL;
								$W = new Warnings;
								
								$W->AddAviso('Você não possui permissão para esta ação.','WE');
								if($this->Status == '2') echo "<script>document.location = '".$URL->siteURL."areacliente/';</script>";
								exit;
						}
				}
		}
}
?>