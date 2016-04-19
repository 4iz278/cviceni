<?php
	
# ukazka funkci pro praci s datem/casem

# http://dev.mysql.com/doc/refman/5.5/en/timestamp-initialization.html - v�choz� inicializace datov�ho typu timestamp v MySQL.
# http://php.net/manual/en/intro.datetime.php - �vod do pr�ce s datem/�asem v PHP.
# http://php.net/manual/en/function.date-default-timezone-set.php - nastaven� default �asov� z�ny
# http://php.net/manual/en/ref.datetime.php - funkce pro pr�ci s datem/�asem v PHP.
# http://php.net/manual/en/class.dateinterval.php - pr�ce s intervaly data/�asu v PHP.
# http://php.net/manual/en/timezones.php - podporovan� �asov� z�ny v PHP (na�e je Europe/Prague).


# casovou zonu jsme uz nastavili v souboru .htaccess (na Europe/Prague), takhle ji muzeme zmenit treba na UTC

date_default_timezone_set('UTC');

# http://php.net/manual/en/function.date.php - funkce date

# vytiskne aktualni den v tydnu
echo date("l");

echo "<br>";

# vytiskne dnesni datum a cas ve formatu W3C
echo date(DATE_W3C);

# dalsi formaty:

# DATE_ATOM - Atom (example: 2005-08-15T15:52:01+00:00)
# DATE_COOKIE - HTTP Cookies (example: Monday, 15-Aug-2005 15:52:01 UTC)
# DATE_ISO8601 - ISO-8601 (example: 2005-08-15T15:52:01+0000)
# DATE_RFC822 - RFC 822 (example: Mon, 15 Aug 05 15:52:01 +0000)
# DATE_RFC850 - RFC 850 (example: Monday, 15-Aug-05 15:52:01 UTC)
# DATE_RFC1036 - RFC 1036 (example: Mon, 15 Aug 05 15:52:01 +0000)
# DATE_RFC1123 - RFC 1123 (example: Mon, 15 Aug 2005 15:52:01 +0000)
# DATE_RFC2822 - RFC 2822 (example: Mon, 15 Aug 2005 15:52:01 +0000)
# DATE_RFC3339 - RFC 3339 (example: 2005-08-15T15:52:01+00:00) - stejn� form�t jako ATOM
# DATE_RSS - RSS (example: Mon, 15 Aug 2005 15:52:01 +0000)
# DATE_W3C - World Wide Web Consortium (example: 2005-08-15T15:52:01+00:00)

echo "<br>";

echo date(DATE_W3C);

?>