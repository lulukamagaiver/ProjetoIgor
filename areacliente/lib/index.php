<?php
      include('tabs/tabmenus.php');
      
      $tt = new tabMenus();
      $tt->MontaSQL();
      $tt->Load();
      
      for($a = 0; $a < $tt->NumRows; $a++){
            echo $tt->ID." - ".$tt->Menu."<br />";
            $tt->Next();
      }
	  
	  echo $tt->Result;
      
?>

<hr />

<hr />

<form method="post">
      Nome:<br />
      <input type="text" name="Nome" id="Nome" /><br />
      
      Descrição:<br />
      <input type="text" name="Descricao" id="Descricao" />
      
      <input type="submit" value="Enviar" />
</form>