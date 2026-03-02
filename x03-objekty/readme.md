# 6. Chyby a výjimky
* **chyba != výjimka**

### Chyby a jejich odchytávání
* některé typy chyb již známe - např. se nepovede otevřít zvolený soubor, vypisujeme neexistující proměnnou atp.
* PHP obsahuje definici řady konstant určujících úroveň generování chyb (např. *E_NOTICE*, *E_WARNING*, ... *E_ALL*), v souvislosti s přechody mezi různými verzi PHP je důležitá také chyba *E_DEPRECATED*
* vyhazování chyb do výstupu závisí na nastavení PHP
* **chyby neslouží k řízení průběhu programu!**
* nejsou odchytitelné klasickými konstrukcemi známými např. z Javy, ale můžeme je ošetřit vlastní funkcí, nebo je skrýt

* [příklad error - zavináč](./03-error-zavinac.php)
* [příklad error handler](./03-error-handler.php)
* [příklad error_reporting](./03-error-reporting.php)
* [příklad error_reporting](./03-error-htaccess.txt)

### Exceptions
* výjimka (Exception) = instance třídy vygenerovaná v případě odchycení nestandartního stavu aplikace
  * lze definovat vlastní odvozené třídy
* lze je využít k řízení kódu programu, lze je odchytit pomocí try-catch bloku
* většina výchozích PHP funkcí výjimky nepoužívá

```php
try{
  //kód, u kterého je možný výskyt výjimky
}catch(\Exception $e){
  //kód obsahující ošetření výjimky
}finally{
  //kód provedený po try bloku a případném provedení kódu pro ošetření výjimky
  //podpora v PHP 5.5+
}
```

* [příklad exceptions](./03-exceptions.php)
* [PHP manuál - vlastní výjimky](http://php.net/manual/en/language.exceptions.extending.php)

## Příklad na procvičení
> Navrhněte základní strukturu objektů pro zachycení cvičení na VŠ
>  * cvičení absolvuje větší množství studentů
>  * cvičení má učitele
>  * cvičení má vztah k nějaké učebně
>  * pro definici tříd Student a Ucitel využijte společnou rodičovskou třídu
>  * zkuste vytvořit instance daných tříd...