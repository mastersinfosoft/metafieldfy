<?php
$responce = '';
foreach ($_REQUEST as $key => $value) {
	$responce .= " $key => $value \n";
}
error_log("hello, this is a test!"); 
echo $responce;
$handle = fopen("unstalllog.txt", "w");
fwrite($handle, $responce);
fclose($handle);


?>