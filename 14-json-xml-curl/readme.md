# 14. JSON, XML a práce s externími daty

Moderní webové aplikace dnes velmi často nepracují jen s vlastní databází, ale také s daty z externích zdrojů. Typicky načítáme informace z různých API (např. počasí, kurzy měn, data z jiných systémů) nebo naopak data exportujeme do dalších aplikací. Je tedy nutné umět pracovat se strukturovanými daty a také je načítat z externích zdrojů.


## Strukturovaná data
:point_right:
- Pokud je to možné, pak pro výměnu dat mezi aplikacemi preferujeme strukturované datové formáty
  - strukturovaná data mají jasně definovanou podobu, díky které je lze snadno zpracovat v různých programovacích jazycích
  - např. chceme exportovat seznam objednávek, stáhnout fakturu, naimportovat kontakty, stáhnout data z API cizí aplikace atp.
- Nejčastěji tím myslíme [XML](#xml) a [JSON](#json) 
  - kromě toho ale existují i další formáty - např. CSV, které známe již z [předchozích podkladů](../03-soubory/)

### JSON
:point_right:
- = jednoduchý formát odvozený od zápisu objektů v jazyce JavaScript (*JavaScript Object Notation*)
- často se používá pro komunikaci mezi frontendem a backendem u interaktivních (javascriptových) aplikací
- data jsou ukládána v jednoduché objektové podobě, hodnoty mohou být řetězce, čísla, pole, objekty, true/false nebo null
- výhody:
    - podporují ho v podstatě všechny moderní jazyky
    - jde o datově úsporný formát
    - jednoduchý i při ručním vytváření
- nevýhody:
    - není standardní mechanismus kontroly dat - je nutné kontrolovat v rámci zpracovávající aplikace
    - existuje [json schema](http://json-schema.org), ale použití je jen volitelné (a v praxi méně časté než u XML schémat)
    - nepodporuje jmenné prostory
    - neumožňuje mít více hodnot pod stejným klíčem (klíče musí být unikátní)

:point_right:
**Příklad JSONu:**    
```json
{
    "10":{
        "jmeno":"Josef",
        "prijmeni":"Novák",
        "rok-narozeni": 1980,
        "email":["josef.novak@nekde.cz","josef.novak@nikde.com"]
    },
    "12":{
        "jmeno":"Eva",
        "prijmeni":"Adamová"
    }
}
```

:point_right:

#### Práce s JSONem z PHP
- **json_encode($data, $options)**
    - funkce pro zakódování pole, objektu atd.
    - pomocí ```$options``` jdou ovlivnit vlastnosti konverze - viz [json_encode v PHP manuálu](http://php.net/manual/en/function.json-encode.php)
- **json_decode($json, $assoc=false)**
    - funkce pro dekódování JSONu
    - vrací asociační pole nebo objekt (dle nastavení 2. parametru)
- Interface **JsonSerializable**
    - pro převod objektů do JSONu jsou ve výchozím stavu serializovány všechny public properties
    - serializaci je možné ovlivnit implementováním rozhraní JsonSerializable (funkce **jsonSerialize()**)

```php
$data = ['jmeno'=>'Josef','prijmeni'=>'Novák'];
$json = json_encode($data); //funkce pro vytvoření JSONu z pole

$data2=json_decode($json, true); //funkce pro dekódování JSONu (vrací asociační pole); když se to nepovede, vrací false
```

:blue_book:
- [příklad json_encode(), json_decode()](./14-json/json_encode_decode.php)
- [příklad JsonSerializable](./14-json/jsonserializable.php)

### XML
:point_right:

- značkovací jazyk využívaný pro záznam dokumentů o volitelné struktuře
- jde o obecný jazyk, z něhož jsou odvozeny konkrétní formáty používané pro konkrétní účely
    - kromě API a webové komunikace do něj ukládají i např. MS Office atp.
    - SVG, docx, xlsx, isdoc, RSS...
- obvykle bývá definováno pomocí schématu
    - schéma = popis, jaké značky mohou být v dokumentu použity a jaké jsou jejich hodnoty
    - tvůrce formátu jednou definuje, jaké značky a v jaké struktuře v XML budou, následně se tyto značky jednotně používají
- výhody:
    - jasně definovaná struktura, snadno kontrolovatelná standardními mechanismy (dle schématu)
    - podpora ve všech rozumných programovacích jazycích (ale ne vždy je to zcela jednoduché)
    - možnost XSL transformací
    - možnost kombinovat větší množství jmenných prostorů
- nevýhody:
    - pro jednoduchou výměnu dat je XML zbytečně "ukecané" - i v následujícím příkladu značky zabírají větší množství znaků, než samotný obsah
    - v případě velkých dokumentů náročné na paměť (DOM parser načítá celý dokument do paměti)

:point_right:
**Příklad XML:** 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<osoby>
    <osoba id="10">
        <jmeno>Josef</jmeno>
        <prijmeni>Novák</prijmeni>
        <email>josef.novak@nekde.cz</email>
        <email>josef.novak@nikde.com</email>
    </osoba>
    <osoba id="12">
        <jmeno>Eva</jmeno>
        <prijmeni>Adamová</prijmeni>
    </osoba>
</osoby>
```

:point_right:

#### Práce s XML z PHP
- v PHP máme k dispozici několik parserů, které umí pracovat s XML dokumenty
    - DOM přístup (procházení dat v podobě stromu)
        - [SimpleXML](https://php.net/manual/en/book.simplexml.php)
        - [DOMDocument](https://php.net/manual/en/class.domdocument.php)
    - SAX přístup ("proudové" zpracování - vhodné pro hodně velké dokumenty)
        - [XMLReader](https://php.net/manual/en/xmlreader.open.php)
- **pro většinu případů je vhodné použít SimpleXML**
    - jednoduchý objektový přístup ke XML dokumentu
        - co vnořená značka, to vnořený objekt
        - k atributům přistupujeme jako k prvkům pole
    - lze jej využít pro čtení i zápis XML dokumentu 
      - zápis je však z hlediska možností umístění elementů limitovaný
    - lze kombinovat s DOMDocument (např. pro složitější úpravy dokumentu)
        - toto využijeme pro složitější manipulace např. s pořadím elementů, které SimpleXML neumí
    - pozor, SimpleXML tak trochu ignoruje jmenné prostory (což nám pro většinu běžné práce nevadí, ale existují i dokumenty, ve kterých jsou elementy z více jmenných prostorů)

```php
$xml = simplexml_load_string($data);
if (isset($xml->osoba)){
  foreach($xml->osoba as $osoba){
    echo (string)$osoba['id'];
    echo ': ';
    echo (string)$osoba->jmeno;
    echo ' ';
    echo (string)$osoba->prijmeni;    
  }
}
```

:blue_book:
- [příklad SimpleXML](./14-xml/simplexml.php)
- [příklad DOMDocument](./14-xml/domdocument.php)
- [příklad validace](./14-xml/validace.php)
- [příklad XSL transformace](./14-xml/transformace.php)
- [příklad RSS čtečka](./14-xml/rss-reader.php)
