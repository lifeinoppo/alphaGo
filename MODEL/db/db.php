<?php
/*
  function provider for Mysql here 
*/

 // do query operation 
  function 	query_db(){

  	$st = $db->query('SELECT xxx,yyy FROM xxx');
  	foreach($st->fetchAll() as $row ){
  		// get item result 
  		// $row['xxx']   and   $row['yyy']
  	}

  }





?>