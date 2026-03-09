# 7. Chyby a výjimky
:point_right:
* **chyba != výjimka**
* Výjimky jsou součástí běžného návrhu aplikace, zatímco chyby signalizují problém v kódu nebo konfiguraci.

## Chyby a jejich odchytávání
:point_right:
* některé typy chyb již známe - např. se nepovede otevřít zvolený soubor, vypisujeme neexistující proměnnou atp.
* PHP obsahuje definici řady konstant určujících úroveň generování chyb (např. *E_NOTICE*, *E_WARNING*, ... *E_ALL*), v souvislosti s přechody mezi různými verzi PHP je důležitá také chyba *E_DEPRECATED*
* vyhazování chyb do výstupu závisí na nastavení PHP
* **chyby neslouží k řízení průběhu programu!**
* mezi chybami najdeme i varování na deprecated funkce atp.
* klasické chyby nelze zachytit pomocí try-catch
  * lze je ošetřit vlastní funkcí pomocí **set_error_handler()**
  * případně lze výpis chyby potlačit operátorem **@** (nedoporučuje se)

### Zapnutí/vypnutí výpisu chyb
:point_right:
* při vývoji obvykle chceme vidět vypsané všechny chyby, ale běžný uživatel by je v aplikaci ve výchozím stavu vidět nikdy neměl!
  * na produkci je běžně zapisujeme do logu
* samotný výpis chyb do výstupu řídí nastavení **display_errors**
* generování i vypisování chyb jde zapnout jak přímo v PHP, tak v konfiguraci serveru (např. v ```.htaccess```, nebo v ```php.ini``` či  ```.user.ini```)

```php
error_reporting(E_ALL - E_NOTICE); //výpis všech chyb vyjma úrovně notice
//alternativní zápis: error_reporting(E_ALL & ~E_NOTICE); //výpis všech chyb vyjma úrovně notice - bitová maska
//alternativa nastavení konfigugace: ini_set("error_reporting", E_ALL);

error_reporting(0); //vypnutí generování všech chyb

//konfigurace výpisu chyb
ini_set('display_errors', 1);  // zapnutí výpisu chyb
ini_set('display_errors', 0);  // vypnutí výpisu chyb
```

:blue_book:
* [příklad error - zavináč](07-error-zavinac.php)
* [příklad error handler](07-error-handler.php)
* [příklad error_reporting](07-error-reporting.php)
* [příklad error_reporting](07-error-htaccess.txt)

## Exceptions
:point_right:
* výjimka (Exception) = objekt reprezentující nestandardní stav aplikace
  * obvykle jde o instanci třídy ```\Exception``` nebo jejích potomků (můžeme si definovat vlastní)
* lze je využít k řízení průběhu programu, lze je odchytit pomocí **try-catch** bloku
* výjimku vyvoláme pomocí příkazu **throw**

```php
try{
  //kód, u kterého je možný výskyt výjimky
}catch(\Exception $e){
  //kód obsahující ošetření výjimky, pokud bychom s výjimkou nepotřebovali dále pracovat, lze proměnnou $e vynechat
}finally{
  // kód provedený po try bloku a případném catch,
  // i pokud by v try bloku byl return
}

//ukázka vyvolání výjimky
throw new LogicException('Moje chyba');
```

:blue_book:
* [příklad exceptions](07-exceptions.php)
* [PHP manuál - vlastní výjimky](http://php.net/manual/en/language.exceptions.extending.php)

### Rozhraní Throwable
:point_right:
* = společné rozhraní, které implementují jak výjimky (Exception), tak chyby (Error)
* umožňuje nám zachytit některé typy chyb pomocí try-catch bloku (např. TypeError, ParseError...)

```php
try{
  $x = 5 / 0; //vyvolá DivisionByZeroError
}catch(\Throwable $e){
  echo 'Došlo k chybě: '.$e->getMessage();
}
```