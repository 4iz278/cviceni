# 4. Objekty v PHP II., validace formulářů


## Magické metody objektů
TODO

* http://php.net/manual/en/language.oop5.magic.php
* http://php.net/manual/en/language.oop5.overloading.php

## Automatické načítání tříd
### Class loader
* rozčleňování kódu do většího množství souborů (obvykle v podstatě každá třída zvlášť) přispívá k jednodušší orientaci ve zdrojácích
* pro vykonání kódu potřebujeme ale všechen kód "na jednom místě"
* načítání souborů pomocí *require_once* je pruda :/ (a vede k chybám v případě, že na něco zapomeneme)

```php
spl_autoload_register(function($name){
  //vyřešení jména souboru a jeho require
});
```
* autoload funkcí je možné zaregistrovat i větší množství, volají se postupně, jak byly zaregistrovány do fronty (dokud některá z nich nevrátí true)
  * pole zaregistrovaných funkcí je možné získat pomocí *spl_autoload_functions()*, zvolenou funkci je možné odstranit pomocí *spl_autoload_unregister()*

* [příklad autoload](./04-autoload)
* [příklad autoload funkce pracující se jmennými prostory](./04-autoload-namespaces.php)

### Načítání tříd při použítí frameworku
* v podstatě všechny PHP frameworky zahrnuje nějakou vlastní podobu autoloadu => **při použití frameworku neimplementujeme vlastní autoload**
* často je očekáváno rozdělení souborů do pevně daných adresářů (*controllers*, *model* atp.), nebo načítání podle jmenných prostorů
* zajímavou metodu implementuje např. Nette - naindexuje všechny třídy v zadaném adresáři (bez ohledu na jejich umístění v podadresářích)

### Composer
* pokud chceme pracovat s externími "knihovnami" (balíčky tříd), je v PHP obvyklé neskládat dané kódy ručně, ale spracovat závislosti projektu pomocí composeru
TODO

## Validace formulářů
TODO

## Praktická aplikace
TODO
