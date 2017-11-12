<?php

ignore_user_abort(true); 
set_time_limit(0); 

 $filename = 'resonance786.zip';
 $zip = new ZipArchive; 
$res = $zip->open($filename); 
$zip->extractTo('test786'); 
 $zip->close(); 

?>




