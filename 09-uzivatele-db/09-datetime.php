<?php
	
# ukazka funkci pro praci s datem/casem

# http://php.net/manual/en/intro.datetime.php - �vod do pr�ce s datem/�asem v PHP.
# http://php.net/manual/en/function.date.php - funkce date.
# http://php.net/manual/en/function.date-default-timezone-set.php - nastaven� default �asov� z�ny
# http://php.net/manual/en/ref.datetime.php - funkce pro pr�ci s datem/�asem v PHP.
# http://php.net/manual/en/class.dateinterval.php - pr�ce s intervaly data/�asu v PHP.
# http://php.net/manual/en/timezones.php - podporovan� �asov� z�ny v PHP (na�e je **Europe/Prague**)
# http://php.net/manual/en/datetime.add.php - s��t�n� data a �asu
# http://php.net/manual/en/function.date-create.php - vytvo�en� objektu data a �asu
# http://php.net/manual/en/function.date-interval-create-from-date-string.php - vytvo�en� intervalu (objekt pro s��t�n� k objektu data/�asu) z �et�zce
# http://php.net/manual/en/function.time.php - aktu�ln� �as

# casovou zonu jsme uz nastavili v souboru .htaccess (na Europe/Prague), takhle ji muzeme zmenit treba na UTC
date_default_timezone_set('UTC');

# vytiskne aktualni den v tydnu
# http://php.net/manual/en/function.date.php - funkce date
echo date("l");

echo "<br>";

# vytiskne dnesni datum a cas ve formatu W3C
echo date(DATE_W3C);

# dalsi formaty:

# DATE_ATOM - Atom (example: 2005-08-15T15:52:01+00:00), form�t Y-m-d\TH:i:sP
# DATE_COOKIE - HTTP Cookies (example: Monday, 15-Aug-2005 15:52:01 UTC), form�t l, d-M-Y H:i:s T
# DATE_ISO8601 - ISO-8601 (example: 2005-08-15T15:52:01+0000), form�t Y-m-d\TH:i:sO
# DATE_RFC822 - RFC 822 (example: Mon, 15 Aug 05 15:52:01 +0000), form�t D, d M y H:i:s O
# DATE_RFC850 - RFC 850 (example: Monday, 15-Aug-05 15:52:01 UTC), form�t l, d-M-y H:i:s T
# DATE_RFC1036 - RFC 1036 (example: Mon, 15 Aug 05 15:52:01 +0000), form�t D, d M y H:i:s O
# DATE_RFC1123 - RFC 1123 (example: Mon, 15 Aug 2005 15:52:01 +0000), form�t D, d M Y H:i:s O
# DATE_RFC2822 - RFC 2822 (example: Mon, 15 Aug 2005 15:52:01 +0000), form�t D, d M Y H:i:s O
# DATE_RFC3339 - RFC 3339 (example: 2005-08-15T15:52:01+00:00) - stejn� form�t jako ATOM
# DATE_RSS - RSS (example: Mon, 15 Aug 2005 15:52:01 +0000), form�t D, d M Y H:i:s O
# DATE_W3C - World Wide Web Consortium (example: 2005-08-15T15:52:01+00:00), form�t Y-m-d\TH:i:sP

echo "<br>";

# pouziti vlastniho formatu
# format viz funkce date http://php.net/manual/en/function.date.php, nebo priklady dle standardu
# format jako 19.4.2016 21:34
echo date("d.m.Y H:i");

# TODO zmente casovou zonu zpatky na Europe/Prague a podivejte se, co to udela s datem/casem tohoto scriptu

#######################
# SCITANI DATA A CASU #
#######################

# http://php.net/manual/en/datetime.add.php
# http://php.net/manual/en/function.date-create.php

# tady pouzivame proceduralni styl, lze pouzit i objektovy

# vytvorime si vlastni datum a cas
# vraci objekt
$datetime = date_create('2016-04-19 07:00:23');

# pridame 6 hodin
# POZOR: meni primo predany objekt
# priklady viz http://php.net/manual/en/dateinterval.createfromdatestring.php
date_add($datetime, date_interval_create_from_date_string('6 hours'));

# vytiskneme vysledek ve W3C formatu
echo "<br>";
echo date_format($datetime, DATE_W3C);

######################
# ROZDIL MEZI 2 DATY #
######################

# http://php.net/manual/en/function.date-diff.php
# http://php.net/manual/en/dateinterval.format.php
$a = date_create('2016-04-19');
$b = date_create('2016-05-06');
$interval =  date_diff($b, $a);

echo "<br>";
echo date_interval_format($interval, "%a days");

?>