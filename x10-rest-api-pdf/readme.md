# 10. REST API, PDF

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
