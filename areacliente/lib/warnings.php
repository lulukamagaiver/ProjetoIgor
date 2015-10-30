<?php
/*
*Classe responsavel por exibir alertas
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/


class Warnings{
		
		public $Texto = null;
		public $Tipo = "WS";
		
		private $Exibido = null;
		
		public function AddAviso($tx = null, $tt = "WS"){
				$this->Texto = $tx;
				$this->Tipo = $tt;
				
				$_SESSION['WTexto'] = $this->Texto;
				$_SESSION['WTipo'] = $this->Tipo;
		}
		
		public function Show(){
			
				if(!empty($_SESSION['WTexto'])) $this->AddAviso($_SESSION['WTexto'],$_SESSION['WTipo']);
				
				if(!empty($this->Texto)){
					?>
                    <script>
							$('.Faixa').attr('class','Faixa <?php echo $this->Tipo;?>');
							$('.ResultWarning').html('<?php echo $this->Texto;?>');
							$('#Warnings').fadeIn();
					</script>
                    <?php
					$_SESSION['WTexto'] = "";
					$_SESSION['WTipo'] = "";
				}
		}
}
?>