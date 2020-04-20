# 10. REST API, PDF

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičení 1. 5. 2020, doporučuji ji však ke studiu také studentům z pátečních cvičení.**

## Opakování z předchozího cvičení
:point_right:

Na minulém cvičení jsme se zabývali víceuživatelským přístupem k aplikaci a také strukturovanými datovými formáty. Co bychom si o tom určitě měli pamatovat?

:point_right:

**Ohledně víceuživatelského přístupu k aplikaci:**
- u aplikací bychom měli počítat s tím, že je bude využívat více uživatelů v ten samý čas a poku si mohou data přepisovat, měli bychom tento stav ošetřit
- pokud očekáváme, že si uživatelé budou data spíše prohlížeč, ale málokdy je upravovat, je vhodné použít **optimistické zamykání**
- pokud očekáváme, že většina uživatelů, kteří si zobrazí daný datový záznam k úpravě, jej nakonec také změní, je vhodné využít **pesimistické zamykání**
- je vhodné počítat také se situací, kdy uživatel úpravu korektně neukončí (např. prostě jen zavře prohlížeč) - zámek by měl tedy po určité době vypršet    

:point_right:

**Ohledně strukturovaných datových formátů** jsme se bavili o XML a JSONu.
- **XML**
    - datový formát, který se podobá HTML
    - je využíván pro ukládání a výměnu dat (a je z něj odvozena celá řada specifických formátů) 
    - je možné definovat vlastní elementy a jejich atributy
    - pro ruční zpracování je z PHP výhodné používat ```SimpleXML```
    - velmi snadno můžeme používat validaci podle XML schématu, transformaci pomocí XSLT atp.
- **JSON**
    - jednoduchý datový formát odvozený od objektové notace v javascriptu
    - oproti XML má tento formát méně možností, ale je výrazně méně "ukecaný"
    - z PHP používáme funkce ```json_encode()``` a ```json_decode()```, u objektů můžeme využít rozhraní ```JsonSerializable``` 

Na používání formátů JSON a XML navážeme právě na tomto cvičení, kdy je využijeme pro tvorbu API.

---

:point_right:

**Na tomto cvičení nás čeká:**
- [tvorba REST API](#tvorba-rest-api)
- [AJAXová aplikace v PHP](#ajaxov%C3%A1-aplikace-v-php)
- [generování PDF](#generov%C3%A1n%C3%AD-pdf)

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

## Generování PDF
:point_right:

**K čemu by mohlo být dobré generovat PDF z PHP?**
- generování faktur, dodávkových listů, objednávek atp.
- exporty dat pro archivaci (u PDF máte uživatel jistotu, že bude všude vypadat stejně)
    
:point_right:

PHP neumí PDF generovat samo o sobě, ale existuje celá řada knihoven a nástrojů, které nám s tím pomohou.
- Z nepřímého generování bychom mohli uvažovat např. o generování PDF z XML pomocí XSL transformace (viz např. XSL-FO v kurzu 4iz238).

Běžněji se ale využívají metody, jak generovat PDF přímo prostřednictvím PHP knihoven - pojďme si tedy představit nejznámnější z nich.
- [TCPDF](http://www.tcpdf.org/)
    - = asi nejkomplexnější knihovna pro generování PDF
    - zvládá i dokumenty podepsané certifikátem atp.
    - lze generovat části popsané pomocí HTML (ale s minimální podporou stylů) a části popsané pomocí speciálních konstrukcí
    - [ukázkové příklady na webu TCPDF](https://tcpdf.org/examples/)  
- [mPDF](http://mpdf.github.io/)
    - knihovna pro jednoduché generování PDF výstupu z HTML a zjednodušeného CSS
    - pro jednodušší dokumenty ji rozhodně doporučuji :)
    - [ukázkové příklady na githubu mPDF](https://github.com/mpdf/mpdf-examples/tree/master)
- [FPDF](http://www.fpdf.org/)
    - jedna ze základních free knihoven pro generování PDF (je na ní postavená třeba i zmíněná knihovna *mPDF*)     

Všechny uvedené knihovny jdou jednoduše instalovat pomocí composeru, nebo jdou do jednodušších aplikací také přímo stáhnout a načíst ručně.

:blue_book:
- [příklad mPDF - jednoduchý](./10-mpdf/basic-example.php)
- [příklad mPDF - vzorová faktura](./10-mpdf/example-invoice)
- [web mPDF](http://mpdf.github.io/)
- [web TCPDF](http://www.tcpdf.org/) 