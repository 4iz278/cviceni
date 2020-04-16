# 11. JSON, XML

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry:

## AJAX aplikace
* *Asynchronous JavaScript and XML*
* přístup k tvorbě interaktivních aplikací, v rámci kterých je využíváno skriptování na straně klienta (v JavaScriptu) i na straně serveru
* pro přenos dat se používá XML, JSON nebo plaintext
* pokud chcete s daty jednoduše pracovat v javascriptu, je výhodné posílat JSON
* velmi často se AJAXová komunikace skládá z aktivních skriptů jak na straně serveru (např. PHP), tak na straně klienta (javascript)
* **ukážeme si práci s požadavky prostřednictvím jQuery**
* je nutné pamatovat na 2 základní omezení:
    * **pokud to na serveru extra nepovolíme, nejde načítat obsah z cizích domén!**
    * **pokud máme načtenou stránku přes HTTPS, je nutné i AJAXové požadavky volat přes HTTPS** (jinak je prohlížeč zablokuje)
* pokud nemáte zkušenosti s javascriptem, mrkněte se na tyto podklady:
    * [podklady k práci s jQuery (z kurzu 4iz268)](https://github.com/4iz268/cviceni/tree/master/09-dom-jquery)
    * [jQuery AJAX intro (w3schools.com)](http://www.w3schools.com/jquery/jquery_ajax_intro.asp)
    * [podklady k AJAXu (z kurzu 4iz268)](https://github.com/4iz268/cviceni/tree/master/11-ajax)

```javascript
$('#updatovatelnyObsah').load('http://eso.vse.cz/....'); //nejjednodušší možný AJAXový požadavek, načte obsah ze serveru a vloží o do vybraného HTML elementu

$.getJSON('URL', function(data){
    //v proměnné data máme k dispozici
    console.log(data);
});
```

* [příklad AJAX - jednoduchý](./11-ajax-simple)
* [příklad AJAX - složitější](./11-ajax-complex)

## Domácí úkol
> **Připravte aplikaci umožňující nechat si zasílat novinky na e-mail.**
> Konkrétně připravte skript, který bude mít na svém začátku definované konstanty pro URL RSS kanálu a e-mailovou adresu.
>
> Skript stáhne informace z RSS zdroje a připraví informační e-mail v HTML, který následně odešle. V e-mailu by měly být nejen názvy, ale také úryvky článků a samozřejmě odkazy na původní zdroj článku pro jejich zobrazení.
>
> Doporučuji využít [RSS čtečku z dnešního cvičení](./rss-reader.php) a [posílání e-mailů z minulého cvičení](../10-mvc)