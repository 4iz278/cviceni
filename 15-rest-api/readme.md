# 15. REST API

V řadě případů narážíme na požadavky, aby naše webová aplikace negenerovala výstup přímo v podobě HTML stránky, ale aby bylo možné s ní komunikovat také z jiných aplikací. Ať již jde o opravdu externí aplikace, nebo jen o zpřístupnění dat pro AJAXové požadavky z prohlížeče.
Již umíme pracovat se strukturovanými daty, takže si nyní můžeme ukázat, jak využívat API cizích aplikací i jak vytvořit API vlastní.

## Možné formy API
:point_right:

API je možné realizovat v poměrně rozličné škále variant, přičemž základní rozdíl je ve způsobu přístupu:
- práce se zdroji - **REST API**
  - jednoduchá (a nejčastěji užívaná) forma API úzce propojená s protokolem HTTP, podrobněji viz dále
  - lze jej jednoduše využívat jak z libovolného programovacího jazyka, tak v případě některých požadavků také přímo z prohlížeče
- grafová data, flexibilní dotazování na konkrétní data - **GraphQL**
  - moderní API umožňující klientovi definovat, jaká konkrétní dat chce získat (čímž minimalizuje množství přenášených dat)
  - vhodné pro zpřístupnění grafových dat, ale používá jej např. také GitHub
  - často se používá např. ve spojení s Reactem
- vzdálené volání funkcí
  - **Web Services (SOAP)**
    - starší, ale robustní způsob komunikace založený na XML
    - nabízí standardizovanou dokumentaci (WSDL), podporu autentizace, šifrování atp.
    - velmi jednoduše použitelné např. z .NETu
  - **XML-RPC**
    - starší forma API založená na volání vzdálených funkcí (procedur)
    - využívá XML pro přenos dat přes HTTP, existuje ale také JSON-RPC
    - jednodušší než SOAP, ale dnes se používá spíše výjimečně
  - **gRPC**
    - moderní API využívající binární protokol (Protocol Buffers) místo textových formátů jako JSON nebo XML
    - velmi rychlé a efektivní, vhodné pro komunikaci mezi službami (microservices)

## REST API
:point_right:
- **REST je vlastně architektonickým vzorem pro tvorbu klient-server aplikací**, který velmi často používáme pro tvorbu API
    - stranou "server" je vždy ten, kdo poskytuje data (tj. pokud tvoříme vlastní API, bude to naše aplikace; pokud ale používáme cizí API, je naše aplikace v roli klienta)
- REST API je bezstavové (tj. každý požadavek obsahuje všechny potřebné informace a server si neuchovává stav mezi požadavky)
- REST API není závislé na žádném konkrétním programovacím jazyce (tj. můžeme jej využívat z PHP, Javy, Pythonu, JavaScriptu, C#, ...)
- **API musí být dokumentované!**
    - existuje celá řada nástrojů, doporučit mohu např. [OpenAPI (Swagger)](https://www.openapis.org/), pro který lze najít i nástroje pro zápis dokumentace API přímo do dokumentačních komentářů v PHP

:point_right:

**Základní myšlenkou REST API je zpřístupnění dat v podobě zdrojů.**
- s každým zdrojem můžeme provádět základní operace pro čtení, zápis, aktualizaci a mazání
- tomu obvykle odpovídá také struktura používaných URL adres (např. ```/api/item/1``` pro zdroj *item* s ID *1*)  

:point_right:

Pro rozlišení typu požadované operace využíváme různé typy HTTP metod:
- **GET** = požadavek pro načtení konkrétního záznamu či seznamu záznamů
- **POST** = požadavek na vytvoření a uložení nového záznamu
- **PUT** = požadavek na úpravu (nahrazení) již existujícího záznamu
- **DELETE** = požadavek na smazání konkrétního záznamu   
- **PATCH** = částečná úprava existujícího záznamu (méně časté než PUT, ale pokud jej API poskytuje, tak často vhodné)

Drobnost k metodě DELETE:
- pokud je tato HTTP metoda na serveru zakázána, obvykle se to obchází hlavičkou ```X-HTTP-Method-Override```, nebo proměnnou poslanou v GET

:blue_book:

Další zdroje informací:
- [REST API na zdrojak.cz](https://www.zdrojak.cz/clanky/rest-architektura-pro-webove-api/)
- [REST API Tutorial](https://restfulapi.net/)

:point_right:

### Datové formáty pro komunikaci

- pro komunikaci jsou data nejčastěji zasílána ve formátech JSON či XML
  - obvykle tedy nejde o data formuláře a nenajdeme je v PHP v proměnných ```$_POST``` či ```$_GET```, ale např. ve vstupním streamu ```php://input```
- při zasílání odpovědi je nezbytné odeslat ze serveru odpovídající HTTP hlavičku:
    ```php
    header("Content-Type: application/json;charset=utf-8"); //budeme odesílat data jako JSON; obdobně by vypadala hlavička pro XML  
    ```
- obdobně při požadavku na data můžeme pomocí hlavičky ```Accept``` určit, v jakém formátu chceme odpověď (pokud dané API umožňuje výběr např. mezi JSON a XML)

:point_right:
- pokud chceme, aby API bylo možné používat také z JavaScriptu ze stránek na jiných doménách, je potřeba ze serveru posílat hlavičku:
    ```
    Access-Control-Allow-Origin: *
    ```

### Autentifikace uživatele API
:point_right:
- **REST API je bezstavové**
    - nemůžeme spoléhat na běžné přihlášení uživatele uložené v ```$_SESSION```
    - každý požadavek musí obsahovat informaci o identitě uživatele
- pro identifikaci uživatelů se nejčastěji používají **API klíče** (dle dokumentace daného API)
    - klíč předáváme v HTTP hlavičce (např. hlavičky ```X-API-Key```, nebo ```Authorization```).
    - alternativně lze klíč předávat v proměnné zaslané metodou GET (např. ```apiKey=xxx```)
      - pozor na to, že pak bude klíč uložen v logu atp.
- často se používají také tzv. **tokeny**, např. ve formátu **JWT (JSON Web Token)**
  - server po přihlášení uživatele vydá token, který klient posílá v každém dalším požadavku
  - token obsahuje zakódované informace o uživateli (např. ID, role) a je podepsaný, aby jej nebylo možné změnit
  - posílá se typicky v hlavičce:
    ```
    Authorization: Bearer <token>
    ```
- případně můžeme využívat také např. HTTP autentifikaci

### Ukázka implementace jednoduchého REST API
:point_right:

V rámci ukázkového příkladu si vytvoříme velmi jednoduchý adresář, který bude dostupný prostřednictvím REST API:
- data budou předávána ve formátu JSON
- o osobách budeme ukládat vždy jen jejich jméno, e-mail a telefon; data jsou ukládána do 1 tabulky v databázi
- v aplikaci jsou ukázány všechny základní HTTP metody (tj. GET, POST, PUT i DELETE)

:orange_book:
- [prezentace s komentovaným postupem tvorby API](./15-api-persons/prezentace-postup-vyvoje-rest-api.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./15-api-persons)

:point_right:

*K zamyšlení: Zvládli byste do příkladu s API doplnit ověření uživatele pomocí API klíče?* 

## Využití existujícího GraphQL API
:point_right:

- Na rozdíl od REST API, kde máme pro různé operace různé URL a HTTP metody, používá GraphQL obvykle **jedno endpoint URL** (např. ```/graphql```) a požadavek definujeme pomocí dotazu (query).
- V porovnání s REST API je implementace na straně serveru náročnější - API musí skládat data dle požadavků klienta.
  - Ukážeme si volání existujícího API vystaveného cizí aplikací.
  - Pro implementace GraphQL API ve vlastní aplikaci lze využít řadu existujících knihoven. 
- GraphQL dotaz zapisujeme ve speciálním jazyce, ve kterém si určujeme, jaká data chceme získat.
  - klient si v GraphQL sám určuje strukturu odpovědi (na rozdíl od REST API)
  - dotaz obvykle posíláme metodou POST
- ukázkový dotaz vybírající data z API "countries" - vrací seznam zemí, pro každou z nich načítá kód a název
  ```graphql
    {
      countries {
        code
        name
      }
    }
  ```
- ukázkový dotaz - výběr detailů konkrétní země:
  ```graphql
  {
    country(code: "CZ") {
      name
      native
      capital
      currency
      emoji
    }
  }  
  ```

:blue_book:
- [GraphQL - dokumentace](https://graphql.org/)
- [Ukázkové API - countries](https://github.com/trevorblades/countries)
- [Příklad volání GraphQL API countries](./15-graphql-countries.php)

## Interaktivní (AJAXová) javascriptová aplikace s backendem v PHP
:point_right:

- *AJAX* je způsob komunikace mezi prohlížečem a serverem bez toho, aby byla v prohlížeči vždy přenačtena celá stránk
- tento přístup je využíván k tvorbě interaktivních aplikací, v rámci kterých je využíváno skriptování na straně klienta (v JavaScriptu) i na straně serveru
- pro přenos dat se obvykle používá JSON, XML či případně HTML
- pokud chcete s daty jednoduše pracovat v javascriptu, je nejvýhodnější posílat JSON (ale i XML je zpracovatelné v pohodě)
- POZOR: je nutné pamatovat na 2 základní omezení komunikace:
  - pokud to na serveru extra nepovolíme, nejde načítat obsah z cizích domén! (CORS policy)
  - pokud máme načtenou stránku přes HTTPS, musí být i AJAX požadavky přes HTTPS (jinak je prohlížeč zablokuje – tzv. mixed content)

:point_right:

**Z pohledu PHP části implementace**
- jde o zpracování požadavků na API.jde vlastně o volání API (o jehož tvorbě jsme se bavili před chvílí)
- PHP skript typicky vrací data (např. JSON), případně jen část HTML (např. obsah jednoho prvku)

### AJAX za využití Fetch API
:point_right:

Moderní JavaScript nabízí vestavěnou funkci ```fetch```, která umožňuje jednoduše volat API bez nutnosti použití externích knihoven.

```javascript
// jednoduché načtení dat (GET požadavek)
fetch('http://eso.vse.cz/...')
  .then(response => response.json()) // převod odpovědi na JSON
  .then(data => {
    console.log(data); // práce s daty
  })
  .catch(error => {
    console.error('Chyba při načítání:', error);
  });

// odeslání dat na server (POST požadavek)
fetch('http://eso.vse.cz/...', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    name: 'Eva Adamová',
    email: 'eva.adamova@domena.tld'
  })
})
  .then(response => response.json())
  .then(data => {
    console.log(data);
  })
  .catch(error => {
    console.error('Chyba:', error);
  });
```

### AJAX za využití jQuery
:point_right:

- pokud jste se (např. v kurzu [4iz278](https://4iz278.github.io)) setkali s jQuery, můžete jej použít i pro volání vlastního PHP API

```javascript
$('#updatovatelnyObsah').load('http://eso.vse.cz/...'); // načte obsah ze serveru a vloží ho do vybraného HTML elementu

$.getJSON('http://eso.vse.cz/...', function(data) { // načtení dat ve formátu JSON
  console.log(data); // data jsou již převedena na JavaScriptový objekt
});
```

:blue_book:
- [JavaScript fetch API (w3schools.com)](https://www.w3schools.com/js/js_async_fetch.asp)
- [jQuery AJAX intro (w3schools.com)](http://www.w3schools.com/jquery/jquery_ajax_intro.asp)
