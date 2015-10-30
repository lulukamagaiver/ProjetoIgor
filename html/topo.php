        <div class="topo">
        	<div class="content">
        		<div class="linha1">
                		<div class="logo"><img src="<?php echo $URL->siteURL;?>imgs/icones/logo_sistema.png" width="305" /></div>
                        <div class="Admm">
						<div>
							<ul>
							<li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
			  </ul>
						</div>	
						
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
                        <a href="<?php echo $URL->siteURL;?>"><li style="width: 61px;">Início</li></a>					
						
                        <li>
                        Consultar
                        		<ul>
                                		<a href="<?php echo $URL->siteURL;?>chamados/"><li class="first">Chamados</li></a>
                                        <a href="<?php echo $URL->siteURL;?>chamados/"><li>Chamados - Geral</li></a>
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
                                        <?php if($S->Pr(26)){?><a href="<?php echo $URL->siteURL;?>relatorios/ostecnico/"><li>O.S. por Técnico</li></a><?php }?>
                                        <?php if($S->Pr(73)){?><a href="<?php echo $URL->siteURL;?>relatorios/estatisticas/"><li>Estatísticas</li></a><?php }?>
                                        <?php if($S->Pr(73)){?><a href=""onClick="event.preventDefault(); PopUp(670,330,'<?php echo $URL->siteURL;?>ajax/relatorio-analitico-selecionar.php')"><li>Analítico/Manutenção</li></a><?php }?>
                                        <?php if($S->Pr(73)){?><a href=""onClick="event.preventDefault(); PopUp(670,330,'<?php echo $URL->siteURL;?>ajax/relatorio-analitico2-selecionar.php')"><li>Analítico/Categorias</li></a><?php }?>
                                        <?php if($S->Pr(71)){?><a href=""onClick="event.preventDefault(); PopUp(670,330,'<?php echo $URL->siteURL;?>ajax/relatorio-analitico-material-selecionar.php')"><li>Analítico/Material</li></a><?php }?>
                                         <?php if($S->Pr(71)){?><a href=""onClick="event.preventDefault(); PopUp(670,330,'<?php echo $URL->siteURL;?>ajax/relatorio-analitico-material2-selecionar.php')"><li>Analítico/Material Cli.</li></a><?php }?>
                                        <?php if($S->Pr(74)){?><a href=""onClick="event.preventDefault(); PopUp(670,150,'<?php echo $URL->siteURL;?>ajax/relatorio-acessos.php')"><li>Acessos</li></a><?php }?>
                                </ul>
                        </li>
                        <li>
                        Configurações
                        		<ul>
                        								<?php if($S->Pr(72)){?><a href="<?php echo $URL->siteURL;?>configuracoes/"><li>Configurações Gerais</li></a><?php }?>
                        								<a href="<?php echo $URL->siteURL;?>configuracoes/senha/"><li>Alterar Senha</li></a>
                        		</ul>
                        </li>
                        <a href="<?php echo $URL->siteURL;?>logout/"><li style="width: 61px;">Sair</li></a> 
                        </ul>
                </div>
        	</div>
        </div>