<?php
		$S->PrAcess(72);
		require_once('lib/tabs/tabconfiguracoes.php');
		
		
		$Cf = new tabConfiguracoes('1');
		
		if(!empty($_POST['Envia'])){
				
				$_POST['Checks'] = implode(',',$_POST['Checks']);
				
				$Cf->GetValPost();
				$Cf->Update('1');
				if($Cf->Result){
						$W->AddAviso('Configurações Alteradas.','WS');
				}else $W->AddAvsiso('Problemas ao alterar as configurações.','WA');
		}
?>
<h1>Configurações</h1>
<form method="post">
		
        <div class="inputsLarge">
        		Nome Fantasia:<br />
                <input type="text" name="NomeFantasia" id="NomeFantasia" maxlength="100" value="<?php echo (!empty($_POST['NomeFantasia'])) ? $_POST['NomeFantasia'] : $Cf->NomeFantasia;?>" />
        </div>
        
        <div class="sepCont"></div>
        		
        <div class="inputsLarge">
        		Endereço:<br />
                <input type="text" name="End" id="End" maxlength="200" value="<?php echo (!empty($_POST['End'])) ? $_POST['End'] : $Cf->End;?>" />
        </div>
                
        <div class="sepCont"></div>
        		
        <div class="inputsLarge">
        		E-mail:<br />
                <input type="text" name="Email" id="Email" maxlength="60" value="<?php echo (!empty($_POST['Email'])) ? $_POST['Email'] : $Cf->Email;?>" />
        </div>
        
        <div class="sepCont"></div>
        		
        <div class="inputs">
        		Telefone:<br />
                <input type="text" name="Tel1" id="Tel1" maxlength="100" value="<?php echo (!empty($_POST['Tel1'])) ? $_POST['Tel1'] : $Cf->Tel1;?>" />
        </div>
                
        <div class="sepCont"></div>
        		
        <div class="inputs">
        		Telefone:<br />
                <input type="text" name="Tel2" id="Tel2" maxlength="100" value="<?php echo (!empty($_POST['Tel2'])) ? $_POST['Tel2'] : $Cf->Tel2;?>" />
        </div>
        
        
        <div class="sepCont"></div>
        <div class="sepCol2">
        <div class="txtArea">
        		Mensagem no Painel de Controle do cliente:<br />
        		<textarea name="MSGPainel" id="MSGPainel"><?php echo (!empty($_POST['MSGPainel'])) ? $_POST['MSGPainel'] : $Cf->MSGPainel;?></textarea>
        </div>
        </div>
                
        <div class="sepCont"></div>        
        
        <div class="inputsMeio" style="width:300px;">
                On-Line:<br />
                <input type="text" name="OSOnLine" id="OSOnLine" maxlength="100" value="<?php echo (!empty($_POST['OSOnLine'])) ? $_POST['OSOnLine'] : $Cf->OSOnLine;?>" /> % de desconto no tempo
        </div>
                
        <div class="sepCont"></div>
        <div class="sepCol2">
        <div class="txtArea">
        		Observações em O.S.:<br />
        		<textarea name="ObsOS" id="ObsOS"><?php echo (!empty($_POST['ObsOS'])) ? $_POST['ObsOS'] : $Cf->ObsOS;?></textarea>
        </div>
        </div>
        <!--
        <div class="sepCont"></div>
        
        <p class="left" style="margin-left:15px;">Tempo Mínimo de O.S.:</p>
        
        <div class="sepCont"></div>        
        
        <div class="inputsMeio">
                On-Line:<br />
                <input type="text" name="TempoMinOnLine" id="TempoMinOnLine" maxlength="100" value="<?php echo (!empty($_POST['TempoMinOnLine'])) ? $_POST['TempoMinOnLine'] : $Cf->TempoMinOnLine;?>" />
        </div>
        
        <div class="inputsMeio">
                Off-Line:<br />
                <input type="text" name="TempoMinOffLine" id="TempoMinOffLine" maxlength="100" value="<?php echo (!empty($_POST['TempoMinOffLine'])) ? $_POST['TempoMinOffLine'] : $Cf->TempoMinOffLine;?>" />
        </div>
        -->
        <div class="sepCont"></div>
        <h6>Opções de envio de E-mail</h6>
        <div class="sepCont"></div>
        
        <div class="sepCol2 chk" style="width:970px">
        		<?php 
						//$Checks = array(); 
						if(!empty($_POST['Checks'])){
								$Checks = explode(',',$_POST['Checks']);
						}elseif(!empty($Cf->Checks)){
								$Checks = explode(',',$Cf->Checks);
						}
				?>
                <br />
                <input type="checkbox" name="Checks[]" value="1" <?php echo ((!empty($Checks)) && (in_array('1',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre O.S. que precisam ser confirmadas<br />
                <input type="checkbox" name="Checks[]" value="10" <?php echo ((!empty($Checks)) && (in_array('10',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre O.S. com status "Aguardando Cliente" para clientes e usuários de clientes<br />
                <input type="checkbox" name="Checks[]" value="11" <?php echo ((!empty($Checks)) && (in_array('11',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre comentários para clientes e usuários clientes<br />
                <input type="checkbox" name="Checks[]" value="12" <?php echo ((!empty($Checks)) && (in_array('12',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre abertura de chamados para clientes e usuários clientes<br />
                <input type="checkbox" name="Checks[]" value="13" <?php echo ((!empty($Checks)) && (in_array('13',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre abertura de chamados para técnicos<br />
                <input type="checkbox" name="Checks[]" value="14" <?php echo ((!empty($Checks)) && (in_array('14',$Checks))) ? "checked" : "";?>  /> Enviar e-mail para técnicos sobre comentários de clientes<br />
                <input type="checkbox" name="Checks[]" value="15" <?php echo ((!empty($Checks)) && (in_array('15',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre comentários para clientes e usuários clientes com status "Aguardando Cliente"<br />
                <input type="checkbox" name="Checks[]" value="16" <?php echo ((!empty($Checks)) && (in_array('16',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre O.S. gerada para clientes e usuários clientes<br />
                <input type="checkbox" name="Checks[]" value="17" <?php echo ((!empty($Checks)) && (in_array('17',$Checks))) ? "checked" : "";?>  /> Enviar e-mail sobre O.S. confirmada para técnicos<br />
                <input type="checkbox" name="Checks[]" value="18" <?php echo ((!empty($Checks)) && (in_array('18',$Checks))) ? "checked" : "";?>  /> Enviar cópia dos e-mails para endereço cadastrado nas configurações do sistema<br />
                
                <input type="checkbox" name="Checks[]" value="20" <?php echo ((!empty($Checks)) && (in_array('20',$Checks))) ? "checked" : "";?>  /> Não enviar emails<br />
        </div>
        
        <div class="sepCont"></div>
        <h6>Outras Opções</h6>
        <div class="sepCont"></div>
        
        <div class="sepCol2 chk" style="width:970px">
                <input type="checkbox" name="Checks[]" id="Checks7" value="7" <?php echo ((!empty($Checks)) && (in_array('7',$Checks))) ? "checked" : "";?>  /> Ativar Avaliação de O.S.<br />
                <input type="checkbox" name="Checks[]" id="Checks9" value="9" <?php echo ((!empty($Checks)) && (in_array('9',$Checks))) ? "checked" : "";?>  /> Permitir ao cliente visualizar status de atraso dos chamados<br />
				<input type="checkbox" name="Checks[]" id="Checks9" value="100" <?php echo ((!empty($Checks)) && (in_array('100',$Checks))) ? "checked" : "";?>  /> Permitir que clientes cadastrem equipamentos ao selecionar outros na abertura de chamado<br />
        </div>
        
		<input type="submit" name="Envia" value="ok" style="display:none;" />
        <div onClick="return $('input[name=Envia]').click();" class="btnAct"><img src="<?php echo $URL->siteURL;?>imgs/icones/save.png" /> Salvar</div>
</form>

<script>
		<?php echo $JS->Tel(array('#Tel1','#Tel2'));?>
		$('.sepCol2').css('padding-left','0px');
		$('.chk').css('padding-left','15px');
</script>