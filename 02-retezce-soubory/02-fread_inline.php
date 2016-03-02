<?php

# mime types: http://en.wikipedia.org/wiki/Internet_media_type
# http headers: http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html

$file = 'mustang.jpg';

if (file_exists($file)) {
	header('Content-Description: File Transfer');
	header('Content-Type: image/jpeg');
	header('Content-Disposition: inline; filename='.basename($file));
	header('Expires: 0');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
}
?>