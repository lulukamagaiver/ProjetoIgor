        <div class="topo">
        	<div class="content">
        		<div class="linha1">
                		<div class="logo"><img src="<?php echo $URL->siteURL;?>imgs/icones/logo_sistema.png" width="305" /></div>
                        <div class="Admm">
                            <table>
                        	<tr><td><img src="<?php echo $URL->siteURL;?>imgs/icones/Icone_Usuario.png"> </td>
							<td style=" padding-left: 20px;">
							<p style="-webkit-margin-after: -0.5em;">Olá, <strong><?php echo $S->Nome;?></strong>! Seja Bem Vindo!</p>
                            <p>Registro de Acesso em <?php echo date('d/m/Y H:i');?></p></td></tr>
							</table>
                        </div>
                </div>
                <div class="linha2">
                        <ul>
                        <a href="<?php echo $URL->siteURL;?>" ><li style="width: 61px;">Início</li></a>
                        <li>
                        Consultar
                        		<ul>
                                		<a href="<?php echo $URL->siteURL;?>chamados/"><li class="first">Chamados</li></a>
                                        <a href="<?php echo $URL->siteURL;?>chamados/geral/"><li>Chamados - Geral</li></a>
                                        <?php if($S->Pr(22)){?><a href="<?php echo $URL->siteURL;?>os/"><li>Ordens de Serviço</li></a><?php }?>
										<?php if($S->Pr(32)){?><a href="<?php echo $URL->siteURL;?>clientes/"><li>Clientes</li></a><?php }?>
                                        <?php if($S->Pr(42)){?><a href="<?php echo $URL->siteURL;?>material/"><li>Material/Serviço</li></a><?php }?>
                                        <?php if($S->Pr(52)){?><a href="<?php echo $URL->siteURL;?>usuarios/"><li>Usuários</li></a><?php }?>
                                        <?php if($S->Pr(31)){?><a href="<?php echo $URL->siteURL;?>clientes/alterarusuarios/"><li class="first">Usuarios Clientes</li></a><?php }?>
                                        
                                </ul>
                        </li>
                        <li>
                        Cadastrar
                        		<ul>
                                        <?php if($S->Pr(11)){?><a href="<?php echo $URL->siteURL;?>chamados/cadastrar/"><li>Chamado</li></a><?php }?>
                                        <?php if($S->Pr(37)){?><a href="<?php echo $URL->siteURL;?>equipamentos/cadastrar/"><li>Equipamento / Produto</li></a><?php }?>
                                		<?php if($S->Pr(31)){?><a href="<?php echo $URL->siteURL;?>clientes/cadastrar/"><li class="first">Clientes</li></a><?php }?>
                                        <?php if($S->Pr(41)){?><a href="<?php echo $URL->siteURL;?>material/cadastrar/"><li>Material / Serviço</li></a><?php }?>
                                        <?php if($S->Pr(51)){?><a href="<?php echo $URL->siteURL;?>usuarios/cadastrar/"><li>Usuários</li></a><?php }?>
                                        <?php if($S->Pr(31)){?><a href="<?php echo $URL->siteURL;?>clientes/usuarios/"><li class="first">Usuario Clientes</li></a><?php }?>
                                </ul>
                        </li>
                        <li>
                        Relatórios
                        		<ul>
                                        <?php if($S->Pr(26)){?><a href="<?php echo $URL->siteURL;?>relatorios/os/"><li>Ordens de Serviço</li></a><?php }?>
                                        <?php if($S->Pr(26)){?><a href="<?php echo $URL->siteURL;?>relatorios/osequipamento/"><li>O.S. por Equip./Prod.</li></a><?php }?>
                                </ul>
                        </li>
                        <li>
                        Configurações
                        		<ul>
                        								<?php if($S->Pr(72)){?><a href="<?php echo $URL->siteURL;?>configuracoes/"><li>Configurações Gerais</li></a><?php }?>
                        								<a href="<?php echo $URL->siteURL;?>configuracoes/senha/"><li>Alterar Senha</li></a>
                        		</ul>
                        </li>
                        <a href="<?php echo $URL->siteURL;?>logout/">
                        <li style="width: 61px;">
                        Sair</li></a>
                        </ul>
                </div>
        	</div>
        </div>