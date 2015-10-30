<?php



include_once('mysql.php');



/*

*Classe responsavel por conectar com BD

*Desenvolvidq por Robert Willian

*robertwillian@wmstudios.net

*/



class DBConex extends MySql{

      

      public function DBConex(){

            parent::MySql('localhost','data_data','@dmin2014','data_data');
      }

}

?>