# 1. HTML, základy PHP syntaxe

* HTML - stručné opakování
* základy syntaxe
* nahrání stránek na výukový server

## PHP
* interpretovaný programovací jazyk spouštěný na straně serveru
* aktuálně obvykle využívána řada 5.x
  * od prosince 2015 je k dispozici také verze 7
  * jednotlivé verze se řeší ve funkcionalitě, některé zastaralé funkce jsou postupně odstraňovány
* PHP soubory mají obvykle příponu **.php**
* nejčastěji je PHP využíváno ke generování textových výstupů (HTML, XML, JSON, plain text atp.), ale je možné generovat také jakýkoliv jiný obsah (PDF, obrázky), či mít skript, který na výstup nevrací nic
* obvykle spouštěno přes webový server (typicky Apache)
  * vytvořený soubor nahrajeme na server a načteme přes prohlížeč
  * pro výuku budeme využívat server [eso.vse.cz](http://eso.vse.cz) - viz [info k přístupům](../00-zakladni-info/server-eso.md)
* v řadě syntaxe PHP podobná Javě
  * podobné
    * stejné zápisy komentářů
    * každý příkaz končí středníkem
    * podobné zápisy cyklů atp.
  * rozdílné
    * volitelné využívání objektů
    * netypovost proměnných
    * nemožnost vícenásobných definic stejných funkcí s různými atributy

### Vložení PHP do webových stránek
```php
<?php
  // vlastní kód
?>
```
* PHP bloků může být v kódu libovolné množství
  * všechny PHP bloky na sebe navazují
  * před odesláním obsahu jsou z kódu stránek všechny PHP bloky "odstraněny" (klient je nevidí)
* existují i zkrácené zápisy - pokud možno se jejich využívání vyhněte
* Ukázky:
  * [Hello world! - textový](./hello-text.php)
  * [Hello world! - HTML stránka](./hello-html.php)

### Základní syntaktické konstrukce
#### Komentáře
#### Proměnné
#### Textové řetězce
#### Operátory
#### Podmínky
#### Cykly

