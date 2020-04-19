# 10. REST API, PDF

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

TODO opakování

---

:point_right:

**Na tomto cvičení nás čeká:**
- ukázka tvorby API
- [AJAXová aplikace v PHP]()
- [generování PDF](#generov%C3%A1n%C3%AD-pdf)

---

TODO tvorba API

TODO AJAX


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

### Ukázka za využití jQuery
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
- TODO
- [web mPDF](http://mpdf.github.io/)
- [web TCPDF](http://www.tcpdf.org/) 