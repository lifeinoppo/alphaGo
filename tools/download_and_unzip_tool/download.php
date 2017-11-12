<?php

$myfile = fopen("resonance786.zip", "w");
$content = file_get_contents("https://github.com/Akikonata/worldmeeting/archive/master.zip");
fwrite($myfile, $content);

?>



