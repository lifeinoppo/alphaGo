<?php

 $filename = 'resonance786.zip';
 $zip = new ZipArchive; 
$res = $zip->open($filename); 
$zip->extractTo('test786'); 
 $zip->close(); 

?>




