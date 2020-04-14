<?php 

$password = 'heslo';
$hash = '$2y$10$gTbTUMgIupl4bQoiCmYUW.8scwHbsGWU9QeX3L1jsn7wFLbV7GFsO';

if(password_verify("heslo", $hash)){
	
	echo "OK";
	
} else {
	
	echo "ERR";
	
}
	
?>
