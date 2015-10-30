<?php

/*
*Classe responsavel por manipular Javascript nas paginas
*Desenvolvidq por Robert Willian
*robertwillian@wmstudios.net
*/

class JS{
	
	public $ResultJS = null;
	
	//funcoes gerais
	public function JS(){
			echo "<script>";
			?>
            //POPUP
                    function PopUp(w,h,urlAjax){
                    		$('.PopUp').fadeIn();
                            $('.InnerPopUp').css('width',w+'px');
                            $('.InnerPopUp').css('height',h+'px');
                            $('.InnerPopUp').css('margin-left',-((w / 2)+10)+'px');
                            $('.InnerPopUp').css('margin-top',-((h / 2)+10)+'px');
                            $('.InnerPopUp').html('<img src="imgs/icones/img-loader.gif" width="50" height="50" class="load" /><p class="cancel" onClick="$(\'.PopUp\').fadeOut();">Cancelar</p>');
                            
                            $.ajax({
                            		url: urlAjax,
                                    success: function(data){
                            			$('.InnerPopUp').html(data);
                                    }
                            });
                    }
                    
                    //Fecha PopUp
                    $(document).ready(function(){
                            $('p.cancel').click(function(){
                                    $(this).fadeOut();
                            });
                    });
                    
            		//WARNINGS JS
            		function AddAviso(msg,Tp){
							$('.Faixa').attr('class','Faixa '+Tp);
							$('.ResultWarning').html(msg);
							$('#Warnings').fadeIn();
                    }
                    
                    //Acesso Negado
                    function AcNegado(){
                    		AddAviso('Você não possui permissão para esta ação.','WE');
                    }
            <?php
			echo "</script>";
	}
	
	//Define campos com datas
	public function DatePicker($cmps){
			foreach($cmps as $key => $val){
					?>
                    $(function() {
                        $( "<?php echo $val;?>" ).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "dd/mm/yy"
                        });
                    });
                    <?php	
			}
	}
	
	//Define Campos de moeda
	public function Money($cmps){
			foreach($cmps as $key => $val){
					?>
                    $('<?php echo $val;?>').priceFormat({
                        prefix: '',
                        centsSeparator: ',',
                        thousandsSeparator: ''
                    });
                    <?php	
			}
	}
	
	//Define Campos de Telefone
	public function Tel($cmps){
			foreach($cmps as $key => $val){
					?>
                    
                    $("<?php echo $val;?>").focusout(function(){
                        var phone, element;
                        element = $(this);
                        element.unmask();
                        phone = element.val().replace(/\D/g, '');
                        if(phone.length > 10) {
                            element.mask("(99) 99999-999?9");
                        } else {
                            element.mask("(99) 9999-9999?9");
                        }
                    }).trigger('focusout');
                    $("<?php echo $val;?>").css('font-size','11px');
                    <?php	
			}
	}
}