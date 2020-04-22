:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

## 1. Zdroje pro cvičení:

* http://php.net/manual/en/intro.datetime.php - úvod do práce s datem/časem v PHP.
* http://php.net/manual/en/function.date.php - funkce date.
* http://php.net/manual/en/function.date-default-timezone-set.php - nastavení default časové zóny
* http://php.net/manual/en/ref.datetime.php - funkce pro práci s datem/časem v PHP.
* http://php.net/manual/en/class.dateinterval.php - práce s intervaly data/času v PHP.
* http://php.net/manual/en/timezones.php - podporované časové zóny v PHP (naše je **Europe/Prague**)
* http://php.net/manual/en/datetime.add.php - sčítání data a času
* http://php.net/manual/en/function.date-create.php - vytvoření objektu data a času
* http://php.net/manual/en/function.date-interval-create-from-date-string.php - vytvoření intervalu (objekt pro sčítání k objektu data/času) z řetězce
* http://php.net/manual/en/function.time.php - aktuální čas
* Facebook PHP SDK: https://developers.facebook.com/docs/reference/php
* Facebook PHP SDK, přihlášení přes OAuth: https://developers.facebook.com/docs/php/howto/example_facebook_login

## 6. Práce s datem/časem v PHP
* Před voláním [PHP funkcí pro datum a čas](http://php.net/manual/en/ref.datetime.php) musíme nastavit časovou zónu, jinak PHP bude vyhazovat varování - buď funkcí [date_default_timezone_set](http://php.net/manual/en/function.date-default-timezone-set.php), nebo INI nastavením *date.timezone* (viz soubor [.htaccess](./.htaccess) a nastavení *php_value date.timezone 'Europe/Prague'*, případně globálně v souboru *php.ini*.
* Konstanty standardů a formátů pro datum a čas, viz http://php.net/manual/en/class.datetime.php, primární zdroje na standardy viz zdroje nahoře, popř. Google ;)
  * **DATE_ATOM** - Atom (example: 2005-08-15T15:52:01+00:00), formát **Y-m-d\TH:i:sP**
  * **DATE_COOKIE** - HTTP Cookies (example: Monday, 15-Aug-2005 15:52:01 UTC), formát **l, d-M-Y H:i:s T**
  * **DATE_ISO8601** - ISO-8601 (example: 2005-08-15T15:52:01+0000), formát **Y-m-d\TH:i:sO**
  * **DATE_RFC822** - RFC 822 (example: Mon, 15 Aug 05 15:52:01 +0000), formát **D, d M y H:i:s O**
  * **DATE_RFC850** - RFC 850 (example: Monday, 15-Aug-05 15:52:01 UTC), formát **l, d-M-y H:i:s T**
  * **DATE_RFC1036** - RFC 1036 (example: Mon, 15 Aug 05 15:52:01 +0000), formát **D, d M y H:i:s O**
  * **DATE_RFC1123** - RFC 1123 (example: Mon, 15 Aug 2005 15:52:01 +0000), formát **D, d M Y H:i:s O**
  * **DATE_RFC2822** - RFC 2822 (example: Mon, 15 Aug 2005 15:52:01 +0000), formát **D, d M Y H:i:s O**
  * **DATE_RFC3339** - RFC 3339 (example: 2005-08-15T15:52:01+00:00) - stejný formát jako ATOM
  * **DATE_RSS** - RSS (example: Mon, 15 Aug 2005 15:52:01 +0000), formát **D, d M Y H:i:s O**
  * **DATE_W3C** - World Wide Web Consortium (example: 2005-08-15T15:52:01+00:00), formát **Y-m-d\TH:i:sP**
* **[ukázky použití funkcí pro datum a čas](./09-datetime.php)**
* [class DateTime](http://php.net/manual/en/class.datetime.php)


## 7. OAuth - přihlášení pomocí Facebooku

* Registrujeme naši aplikaci u Facebooku: Facebook/v levé záložce Developer/Manage Apps/zelené tlačítko Add a New App/typ Website/napsat název aplikace a vyplnit kontaktní údaje, (není to testovací aplikace)/tlačítko Skip Quick Start a získat klíče:
  * **app-id (id naší aplikace)**
  * **app-secret (tajný klíč k naší aplikaci)**
  * Tyto klíče nastavíme v souborech [09-facebook/login.php](./09-facebook/login.php) a [09-facebook/fb-callback.php](./09-facebook/fb-callback.php).
* Stáhneme si Facebook PHP SDK z https://github.com/facebook/facebook-php-sdk-v4/archive/5.0.0.zip a rozbalíme do web rootu naší aplikace, ukázka viz [adresář 09-facebook](./09-facebook/).
* V našem scriptu si vyžádáme autoloader, který registruje potřebné soubory:
```php
require_once __DIR__ . './facebook-php-sdk-v4-5.0.0/src/Facebook/autoload.php';
```
* Pošleme uživatele na Facebook pro autentizační klíč (pokud uživatel není do Facebooku přihlášen, musí se nejdříve přihlásit).
* Facebook si vyžádá souhlas s autentizací uživatele.
* Pokud uživatel souhlasil, Facebook zavolá nazpět námi předanou URL (callback URL) společně s tokenem (řetězcem s omezenou platností), který lze použít pro další komunikaci s Facebookem (získání dat o uživateli, apod.).
* **Viz [Facebook login](./09-facebook/login.php) a [Facebook callback](./09-facebook/fb-callback.php)**.
* **Funkční ukázka k dispozici na http://eso.vse.cz/~xhraj18/09-facebook/login.php**
