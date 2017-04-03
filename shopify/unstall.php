<?php
$responce = '';
foreach ($_REQUEST as $key => $value) {
	$responce .= " $key => $value \n";
}
echo $responce;
$handle = fopen("unstalllog.txt", "a");
fwrite($handle, $responce);
fclose($handle);


?>