<?php

# mime types: http://en.wikipedia.org/wiki/Internet_media_type
# http headers: http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
# http://www.ietf.org/rfc/rfc2616.txt

$file = 'mustang.jpg';

if (file_exists($file)) {
	header('Content-Description: File Transfer');
	header('Content-Type: image/jpeg');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Expires: 0');
	
	/*
	Cache-Control:
	
	The following Cache-Control response directives
	allow an origin server to override the default cacheability of a
	response:

	public
	Indicates that the response MAY be cached by any cache, even if it
	would normally be non-cacheable or cacheable only within a non-
	shared cache. (See also Authorization, section 14.8, for
	additional details.)

	private
	Indicates that all or part of the response message is intended for
	a single user and MUST NOT be cached by a shared cache. This
	allows an origin server to state that the specified parts of the
	response are intended for only one user and are not a valid
	response for requests by other users. A private (non-shared) cache
	MAY cache the response.

	Note: This usage of the word private only controls where the
	response may be cached, and cannot ensure the privacy of the
	message content.

	no-cache
	If the no-cache directive does not specify a field-name, then a
	cache MUST NOT use the response to satisfy a subsequent request
	without successful revalidation with the origin server. This
	allows an origin server to prevent caching even by caches that
	have been configured to return stale responses to client requests.

	If the no-cache directive does specify one or more field-names,
	then a cache MAY use the response to satisfy a subsequent request,
	subject to any other restrictions on caching. However, the
	specified field-name(s) MUST NOT be sent in the response to a
	subsequent request without successful revalidation with the origin
	server. This allows an origin server to prevent the re-use of
	certain header fields in a response, while still allowing caching
	of the rest of the response.

	Note: Most HTTP/1.0 caches will not recognize or obey this
	directive.
	*/

	header('Cache-Control: no-cache');

	/* Pragma:
	
	The Pragma general-header field is used to include implementation-
	specific directives that might apply to any recipient along the
	request/response chain. All pragma directives specify optional
	behavior from the viewpoint of the protocol; however, some systems
	MAY require that behavior be consistent with the directives.
	HTTP/1.1 caches SHOULD treat "Pragma: no-cache" as if the client had sent "Cache-Control: no-cache". No new Pragma directives will be defined in HTTP.
	# Pragma: no-cache - to force any intermediate caches to obtain a new copy from the origin server.	
	*/	

	#header('Pragma: no-cache');

	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit;
}
?>