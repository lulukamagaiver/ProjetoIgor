<?php
		require('lib/tabs/tabcat-trans.php');
		require('lib/relatorios.php');

		
		if(!empty($_POST['tipo'])){
				switch($_POST['tipo']){
						case 'CatTrans':
						
								if(!empty($_POST['Categoria'])){
										if(empty($_POST['EditCatTrans'])){
												$CadCatTrans = new tabCatTrans;
												$CadCatTrans->Categoria = $_POST['Categoria'];
												$CadCatTrans->Status = "1";
												$CadCatTrans->Insert();
												if($CadCatTrans->InsertID > 0) $W->AddAviso('Categoria cadastrada.','WS');
												else  $W->AddAviso('Problemas ao cadastrar categoria.','WE');
										}elseif($_POST['EditCatTrans'] > 0){
												$CadCatTrans = new tabCatTrans;
												$CadCatTrans->ID = $_POST['EditCatTrans'];
												$CadCatTrans->Categoria = $_POST['Categoria'];
												$CadCatTrans->Status = "1";
												$CadCatTrans->Update($_POST['EditCatTrans']);
												if($CadCatTrans->Result) $W->AddAviso('Categoria alterara.','WS');
												else  $W->AddAviso('Problemas ao alterar categoria','WE');
										}
								}else  $W->AddAviso("Preencha o campo \'Categoria\'.",'WA');
						break;
				}
		}else  $W->AddAviso('Nenhuma ação definida.','WE');
		
		//Funcoes GET
		if(!empty($URL->GET)){
				$url = explode("/",$URL->GET);
				
				switch($url[0]){
						case "delete":
								if(!empty($url[1])){
										switch($url[1]){
												case "cattrans":
														$Del = new tabCatTrans;
														$Del->Delete($url[2]);
														if($Del->Result)  $W->AddAviso('Categoria deletada.','WS');
														else  $W->AddAviso('Problemas ao deletar categoria.','WE');
												break;	
										}
								}
						break;
				}
		}
		
		$CatTrans = new tabCatTrans;
		$CatTrans->MontaSQL();
		$CatTrans->Load();
?>


<h1>Opções do Sistema</h1>

<div class="sepCont"></div>
<h4>Categorias de Movimentações</h4>
<div class="sepCont"></div>


<div class="ColEsq">
<form id="CatSistemas" action="" method="post">
		<div class="inputs">
        		Categoria:<br />
                <input type="text" name="Categoria" id="Categoria" maxlength="" />
        </div>
        <br />
        <input type="hidden" name="tipo" id="tipo" value="CatTrans" />
        <input type="hidden" name="EditCatTrans" id="EditCatTrans" value="" />
        <input type="submit" id="btnSubmitCatTrans" value="Adicionar" />
</form>
</div>
<div class="ColDir">
        <?php
		for($a = 0; $a < $CatTrans->NumRows; $a++){
		?>
        
        <div class="Opc">
        <img src="<?php echo $URL->siteURL?>imgs/icones/edit.png" width="20" height="20" title="Editar" onclick="EditCatTrans('<?php echo $CatTrans->ID;?>','<?php echo $CatTrans->Categoria;?>');" />
        <a onclick="return confirm('Você tem certeza?');" href="<?php echo $URL->siteURL;?>configuracoes/opcoessistema/delete/cattrans/<?php echo $CatTrans->ID;?>"><img src="<?php echo $URL->siteURL?>imgs/icones/delete.png" class="sec" width="20" height="20" title="Excluir" /></a>
        <?php echo $CatTrans->Categoria;?>
        </div>
        <?php
			$CatTrans->Next();
		}
		?>
</div>


<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||  -->
<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||  -->
<!-- |||||||||||||||||||||SCRIPTS||||||||||||||||||||||||  -->
<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||  -->
<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||  -->
<script type="text/javascript">
		//Funcoes para Categorias de movimentacao
		function EditCatTrans(id, cat){ //Editar uma categoria
				$('#btnSubmitCatTrans').val('Alterar');
				$('#Categoria').val(cat);
				$('#EditCatTrans').val(id);
		}
</script>
