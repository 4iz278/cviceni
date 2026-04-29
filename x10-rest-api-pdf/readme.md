# 10. REST API, PDF


:point_right:

**Na tomto cvičení nás čeká:**
- [tvorba REST API](#tvorba-rest-api)
- [AJAXová aplikace v PHP](#ajaxov%C3%A1-aplikace-v-php)

---

## Tvorba REST API
:point_right:

V řadě případů narážíme na požadavky, aby naše webová aplikace negenerovala výstup přímo v podobě HTML stránky, ale aby bylo možné s ní komunikovat také z jiných aplikací. Ať již jde o opravdu externí aplikace, nebo jen o zpřístupnění dat pro AJAXové požadavky z prohlížeče.

Pokud jde o poskytnutí dat naší aplikace aplikacím externím, je obvyklé implementovat dokumentované **API**.

### Možné formy API
:point_right:

API je možné realizovat v poměrně rozličné škále variant. Z často používaných lze jmenovat:
- **REST API** - o tom se budeme bavit na dnešním cvičení 
- **Web Services (SOAP)**
    - vzdálené volání funkcí přes web, velmi jednoduše použitelné např. z .NETu
    - dokumentace dostupných metod i předávaných objektů pomocí WSDL, možnosti autentizace, šifrování atp.
- **XML-RPC**
    - jedna ze starších forem API, ve které jsou volány vzdálené funkce (procedury) např. přes HTTP protokol - čímž se vlastně podobá REST API, ale nepracuje se zdroji, ale s funkcemi
- **GraphQL**
    - moderní API, umožňující definovat v rámci požadavků také požadovanou strukturu a rozsah dat získaných v odpovědi
    - často se používá např. ve spojení s Reactem

### REST API
:point_right:
- **REST je vlastně architektonickým vzorem pro tvorbu klient-server aplikací**, který velmi často používáme pro tvorbu API
    - stranou "server" je vždy ten, kdo poskytuje data (tj. pokud tvoříme vlastní API, bude to naše aplikace; pokud ale používáme cizí API, je naše aplikace v roli klienta)
- REST API je bezstavové (tj. není závislé na předchozích požadavcích) 
- obvykle jej používáme prostřednictvím protokolu HTTP
- REST API není závislé na žádném konkrétním programovacím jazyce (tj. můžeme jej využívat z PHP, Javy, Pythonu, JavaScriptu, C#, ...)
- **API musí být dokumentované!**
    - existuje celá řada nástrojů, doporučit mohu např. [Swagger](https://swagger.io/), pro který lze najít i nástroje pro zápis dokumentace API přímo do dokumentačních komentářů v PHP

:point_right:

**Základní myšlenkou REST API je zpřístupnění dat v podobě zdrojů.**
- s každým zdrojem můžeme provádět základní operace pro čtení, zápis, aktualizaci a mazání
- tomu obvykle odpovídá také struktura používaných URL adres (např. ```/api/item/1``` pro zdroj *item* s ID *1*)  

:point_right:

Pro rozlišení typu požadované operace využíváme různé typy HTTP metod:
- **GET** = požadavek pro načtení konkrétního záznamu či seznamu záznamů
- **POST** = požadavek na vytvoření a uložení nového záznamu
- **PUT** = požadavek na úpravu již existujícího záznamu
- **DELETE** = požadavek na smazání konkrétního záznamu  

:blue_book:

Další zdroje informací:
- [REST API na zdrojak.cz](https://www.zdrojak.cz/clanky/rest-architektura-pro-webove-api/)
- [REST API Tutorial](https://restfulapi.net/)

:point_right:

#### Datové formáty pro komunikaci

- pro komunikaci jsou data nejčastěji zasílána ve formátech JSON či XML
    - a to jak z hlediska odesílání dat ze serveru, tak také pro obdržení vstupů (tj. data posílaná na server nejsou obvykle kódována jako formuláře z prohlížeče)
- chytřejší REST API umí komunikovat i ve větším množství formátů, přičemž vhodný formát se vybere podle HTTP hlavičky ```Accept```
- při zasílání odpovědi je nezbytné odeslat ze serveru odpovídající HTTP hlavičku:
    ```php
    header("Content-Type: application/json;charset=utf-8"); //budeme odesílat data jako JSON; obdobně by vypadala hlavička pro XML  
    ```      

:point_right:
- pokud chceme, aby API bylo možné používat také z JavaScriptu ze stránek na jiných doménách, je potřeba ze serveru posílat hlavičku:
    ```
    Access-Control-Allow-Origin: *
    ```

:point_right:

#### Autentifikace uživatele API

- **REST API je bezstavové**
    - nemůžeme tedy používat běžné přihlášení uživatele s tím, že si informaci o přihlášení uložíme do session
- pro identifikaci uživatelů se nejčastěji používají API klíče (dle dokumentace daného API)
    - klíč předáváme na server obvykle v proměnné předané metodou GET (např. ```apiKey=xxx```),
    - nebo jej předáváme v HTTP hlavičce (např. hlavičky ```X-API-Key```, nebo ```Authorization```. 
- alternativně můžeme využívat také např. HTTP autentifikaci

### Ukázka implementace jednoduchého REST API
:point_right:

V rámci ukázkového příkladu si vytvoříme velmi jednoduchý adresář, který bude dostupný prostřednictvím RESTful API, které bude data poskytovat i přijímat ve formátu JSON.
- o osobách budeme ukládat vždy jen jejich jméno, e-mail a telefon; data jsou ukládána do 1 tabulky v databázi
- v aplikaci jsou ukázány všechny základní HTTP metody (tj. GET, POST, PUT i DELETE)

:orange_book:
- [prezentace s komentovaným postupem tvorby API](./10-api-persons/prezentace-postup-vyvoje-rest-api.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./10-api-persons)

:point_right:

*K zamyšlení: Zvládli byste do příkladu s API doplnit ověření uživatele pomocí API klíče?* 

## AJAXová aplikace v PHP
:point_right:

- *AJAX* je metodou komunikace mezi prohlížečem a serverem bez toho, aby byla v prohlížeči vždy přenačtena celá stránk
- tento přístup je využíván k tvorbě interaktivních aplikací, v rámci kterých je využíváno skriptování na straně klienta (v JavaScriptu) i na straně serveru
- pro přenos dat se obvykle používá JSON, XML či případně HTML
- pokud chcete s daty jednoduše pracovat v javascriptu, je nejvýhodnější posílat JSON (ale i XML je zpracovatelné v pohodě)
- POZOR: je nutné pamatovat na 2 základní omezení komunikace:
    - pokud to na serveru extra nepovolíme, nejde načítat obsah z cizích domén!
    - pokud máme načtenou stránku přes HTTPS, je nutné i AJAXové požadavky volat přes HTTPS (jinak je prohlížeč zablokuje) 

:point_right:

**Z pohledu PHP části implementace** jde vlastně o volání API (o jehož tvorbě jsme se bavili před chvílí), nebo má PHP skript vracet kousek HTML (ne celou stránku, ale např. jen obsah jednoho odstavce).  

### AJAX za využití jQuery
:point_right:

Jednou z nejjednodušších variant, jak využívat AJAX na straně prohlížeče, je javascriptová knihovna jQuery. Tu využijeme také v pár následujících ilustračních příkladech.  

```javascript
$('#updatovatelnyObsah').load('http://eso.vse.cz/....'); //nejjednodušší možný AJAXový požadavek, načte obsah ze serveru a vloží o do vybraného HTML elementu

$.getJSON('http://eso.vse.cz/....', function(data){//načtení dat AJAXem s předpokladem dat ve formátu JSON    
    console.log(data);//v proměnné data máme k dispozici již rozkódovaná JSON data, která jsme získali ze serveru
});
```

:blue_book:

Pokud nemáte zkušenosti s javascriptem, mrkněte se na tyto podklady:
- [podklady k práci s jQuery (z kurzu 4iz268)](https://github.com/4iz268/cviceni/tree/master/09-dom-jquery)
- [podklady k AJAXu (z kurzu 4iz268)](https://github.com/4iz268/cviceni/tree/master/11-ajax)
- [jQuery AJAX intro (w3schools.com)](http://www.w3schools.com/jquery/jquery_ajax_intro.asp)

### Ukázkové AJAXové aplikace
:blue_book:
- [jednoduchý příklad načítání PHP i statických data AJAXem](./10-ajax-simple)
- [složitější příklad s AJAXem](./10-ajax-complex)
    - v tomto případě PHP skripty načítají data z XML a odesílají z nich vybrané údaje ve formátu JSON
    - součástí je i prezentační [HTML stránka](./10-ajax-complex/index.html)
