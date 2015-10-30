<?php
include_once('conf.php');
include_once('sessao.php');
include_once('tabs/tabconfiguracoes.php');
/*
*Classe responsavel por manipular URLs
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class URL extends Conf{
		
		public $siteCat = null;
		public $siteArq = null;
		public $siteVars = null;
		public $sitePag = null;
		public $DirPags = null;
		public $GET = null;
		public $NURL = null;
		public $BaseURL = null;
		
		//construtor
		public function URL(){
			$this->DirPags = 'pag/';
				if($this->siteURLDir != '/') $url = str_replace($this->siteURLDir,'',$_SERVER['REQUEST_URI']);
				else $url = substr($_SERVER['REQUEST_URI'],1);
				$this->BaseURL = $url;
				
				if($url != ''){
						$this->GET = $url;
						
						
						$DivideURL = explode('/',$url);
						$tags = count($DivideURL);
						if(substr($url, -1) == "/") $tags--;
						
						//Define o arquivo a sr aberto
						if($tags > 1){
								if($DivideURL[1] != "visualizar"){ 
										$this->siteArq = $DivideURL[1].".php";
										$this->GET = str_replace($DivideURL[1]."/","",$this->GET);
										$this->GET = str_replace($DivideURL[1],"",$this->GET);
								}
								else $this->siteArq = "index.php";
						}else{
								$this->siteArq = "index.php";	
						}
						
						//Define a Categoria
						$this->siteCat = $DivideURL[0]."/";
						$this->GET = str_replace($DivideURL[0]."/","",$this->GET);
						$this->GET = str_replace($DivideURL[0],"",$this->GET);			

						//Verifica se existe destino, se nao retorna 404
						if(!file_exists($this->DirPags.$this->siteCat.$this->siteArq)){
							$this->siteArq = "404.php";
							$this->siteCat = "home/";
						}
						
						$this->sitePag = $this->DirPags.$this->siteCat.$this->siteArq;
				
				}else{ 
						$this->sitePag = $this->DirPags."home/index.php";
				}
				
				$this->NURL = $this->siteURLDir;
				
				$Cf = new tabConfiguracoes;
				$S = new Sessao;
				if(base64_encode($_SERVER['HTTP_HOST']) != $Cf->LNC) $S->Logout();

				return $this->sitePag = $this->sitePag;
				
		}
		
		//Chama pagina
		public function Pag(){
			return $this->sitePag;
		}
}