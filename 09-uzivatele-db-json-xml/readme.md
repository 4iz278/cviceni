# 9. Uživatelé a DB, JSON, XML

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry: 

## Opakování z předchozího cvičení
:point_right:

TODO

---

:point_right:

**Na tomto cvičení nás čeká:**
- práce s datem a časem
- víceuživatelský přístup k databázi
- strukturované datové formáty
    - [JSON](#json)
    - [XML](#xml)

---


## JSON a XML
:point_right:

- Většina byť jen trochu složitějších aplikací potřebuje pro svoji funkčnost komunikovat s dalšími aplikacemi, či například podporovat export dat.
    - chceme exportovat seznam objednávek, stáhnout fakturu, naimportovat kontakty, stáhnout data z cizí aplikace atp.
- Pro komunikaci se obvykle používají strukturované formáty.
    - nejčastěji tím myslíme [XML](#xml) a [JSON](#json) 
    - kromě toho ale existují i další formáty - např. CSV, které známe již ze [2. cvičení](../02-retezce-soubory)

### JSON
:point_right:
- = jednoduchý formát odvozený od zápisu objektů v jazyce JavaScript (*JavaScript Object Notation*)
- výhody:
    - podporují ho v podstatě všechny moderní jazyky
    - jde o datově úsporný formát
    - jednoduchý i při ručním vytváření
- nevýhody:
    - není standartní mechanismus kontroly dat - je nutné kontrolovat v rámci zpracovávající aplikace
    - existuje [json schema](http://json-schema.org), ale není moc podporované a využívané
    - nepodporuje jmenné prostory a vícenásobné definice prvků se stejným jménem

**Příklad JSONu:**    
```json
{
    "10":{
        "jmeno":"Josef",
        "prijmeni":"Novák",
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
    - pro převod objektů do JSONu jsou ve výchozím stavu serializovány všechny properties
    - serializaci je možné ovlivnit implementováním rozhraní JsonSerializable (funkce **jsonSerialize()**)

```php
$data = ['jmeno'=>'Josef','prijmeni'=>'Novák'];
$json = json_encode($data); //funkce pro vytvoření JSONu z pole

$data2=json_decode($json, true); //funkce pro dekódování JSONu (vrací asociační pole)
```

:blue_book:
- [příklad json_encode(), json_decode()](./09-json/json_encode_decode.php)
- [příklad JsonSerializable](./09-json/jsonserializable.php)

### XML
:point_right:

- značkovací jazyk využívaný pro záznam dokumentů o volitelné struktuře
- jde o obecný jazyk, z něhož jsou odvozeny konkrétní formáty používané pro konkrétní účely
    - dnes se s ním setkáme téměř všude
    - xHTML, docx, xlsx, isdoc, rss...
- každé XML by mělo být vytvářeno dle konkrétního schématu
    - schéma = popis, jaké značky mohou být v dokumentu použity a jaké jsou jejich hodnoty
- výhody:
    - jasně definovaná struktura, snadno kontrolovatelná standartními mechanismy (dle schématu)
    - podpora ve všech rozumných programovacích jazycích (ale ne vždy je to zcela jednoduché)
    - možnost XSL transformací
    - možnost kombinovat větší množství jmenných prostorů
- nevýhody:
    - pro jednoduchou výměnu dat je XML zbytečně "ukecané" - i v následujícím příkladu značky zabírají větší množství znaků, než samotný obsah
    - v případě velkých dokumentů náročné na paměť (při zpracování DOM parserem - tj. procházení v podobě stromu)

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
    - DOM přístup (procházení dle uzlů stromu)
        - [SimpleXML](http://php.net/manual/en/book.simplexml.php) (SimpleXMLElement)
        - [DOM Parser](http://php.net/manual/en/class.domdocument.php) (DOMDocument)
    - SAX přístup ("proudové" zpracování - vhodné pro hodně velké dokumenty)
        - [XMLReader](http://php.net/manual/en/xmlreader.open.php)
        - [Expat parser](http://www.w3schools.com/php/php_xml_parser_expat.asp)
- **pro většinu případů doporučuji použít SimpleXML**
    - jednoduchý objektový přístup ke XML dokumentu
        - co vnořená značka, to vnořený objekt
        - k atributům přistupujeme jako k prvkům pole
    - lze jej využít pro čtení i zápis XML dokumentu
    - objekty jsou vzájemně převoditelné s DOM Parserem
        - toto využijeme pro složitější manipulace např. s pořadím elementů, které SimpleXML neumí
    - pozor, SimpleXML tak trochu ignoruje jmenné prostory (což nám pro většinu běžné práce nevadí, ale existují i dokumenty, ve kterých jsou elementy z více jmenných prostorů)

```php
$xml = simplexml_load_string($data);
if (!empty($xml->osoba)){
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
- [příklad SimpleXML](./09-xml/simplexml.php)
- [příklad DOMDocument](./09-xml/domdocument.php)
- [příklad validace](./09-xml/validace.php)
- [příklad XSL transformace](./09-xml/transformace.php)
- [příklad RSS čtečka](./09-xml/rss-reader.php)